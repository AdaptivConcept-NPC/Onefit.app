<?php
session_start();
require("../../../../config.php");
require_once("../../../../functions.php");


// check to see if username and widget type has been passed via GET, if any is missing then fatal error (type: bar / mini)
if (!isset($_GET['usnm']) || !isset($_GET['wtype'])) die("Fatal Error");
// if ($_GET['usnm'] !== $_SESSION['currentUserUsername']) die("invalid_session");
//header("Location: ../scripts/php/destroy_session.php?return=invalid_session");

// declare variables
$user_loggedin_username =
    $usrdetails_profileid =
    $final_output =
    $widget_type = null;

$user_current_fp_xp =
    $goal_fp_xp = 0;

// assign get param values
$user_loggedin_username = sanitizeMySQL($dbconn, $_GET['usnm']);
$widget_type = sanitizeMySQL($dbconn, $_GET['wtype']);

function get_thousands_xp($num, $factor)
{
    return ceil($num / $factor) * $factor; // - 1
}

try {
    // get users fitness progression xp

    $query = "SELECT `user_profile_id` FROM `general_user_profiles` WHERE `users_username` = '$user_loggedin_username'";
    $result = $dbconn->query($query);

    if (!$result) die("User identity cannot be found");

    $rows = $result->num_rows;

    if ($rows > 0) {
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $usrdetails_profileid = $row["user_profile_id"];
        }
    }

    $result = null;

    $query = "SELECT SUM(`total_xp`) AS total_xp FROM `user_profile_xp` uxp
    WHERE `general_user_profiles_user_profile_id` =  $usrdetails_profileid";

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error: - " . $dbconn->error . "]");

    $rows = $result->num_rows;

    if ($rows > 0) {
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $user_current_fp_xp = $row["total_xp"];
        }
    }

    // if user_current_fp_xp is null / blank / 0, set it to 1 so that we can get the nearest goal_fp_xp
    if (is_null($user_current_fp_xp) || !isset($user_current_fp_xp) || $user_current_fp_xp === 0) $goal_fp_xp = get_thousands_xp(1, 1000); // pass xp value of 1 to get the thousannd tier
    else $goal_fp_xp = get_thousands_xp($user_current_fp_xp, 1000); // xp is tiered/leveled at a factor of 1000 per level

    // if user_current_fp_xp is  null / blank / 0, set 0 as value to avoid DIV/0 error, else calculate the fp xp progression rate
    if (is_null($user_current_fp_xp) || !isset($user_current_fp_xp) || $user_current_fp_xp === 0) $fp_xp_progression_rate = 1;
    else $fp_xp_progression_rate = ($user_current_fp_xp / $goal_fp_xp) * 100; // get the progression rate (%) of the current fp xp to the goal fp xp (progress bar)

    switch ($widget_type) {
        case 'bar':
            # for bar type fp progress bar
            $final_output = <<<_END
            <!-- $user_loggedin_username - fitness progression progress bar -->
            <h5 class="mt-4"><span class="material-icons material-icons-outlined align-middle" style="color: #fff;">data_exploration</span> <span class="align-middle">Fitness Progression</span></h5>
            <div class="progress mt-4 bg-white" style="height:20px;border:1px solid white !important;">
                <div class="progress-bar" role="progressbar" aria-label="Example 1px high" style="width: $fp_xp_progression_rate%; background-color: var(--secondary-color) !important; border-right: var(--primary-color) 10px solid;" aria-valuenow="$fp_xp_progression_rate" aria-valuemin="$user_current_fp_xp" aria-valuemax="$goal_fp_xp"></div>
            </div>
            <div class="mt-2 w-100 d-flex justify-content-between" style="margin-bottom: 60px;">
                <p class="text-start m-0 poppins-font" style="font-size: 12px;">
                    Current XP <strong>($user_current_fp_xp)</strong>
                </p>
                <p class="text-end m-0 poppins-font" style="font-size: 12px;">
                    Target XP <strong>($goal_fp_xp)</strong>
                </p>
            </div>
            <!-- ./ $user_loggedin_username - fitness progression progress bar -->
            _END;
            break;

        case 'mini':
            # for mini fp progress stat
            $final_output = <<<_END
                <p class="text-center m-0"><span class="material-icons material-icons-outlined align-middle" style="color: var(--primary-color);">horizontal_rule</span></p>
                <!-- $user_loggedin_username - display User XP -->
                <div class="d-grid justify-content-center">
                    <p class="comfortaa-font mb-0 text-center" style="font-size: 10px;">Fitness Progression</p>
                    <div class="text-center px-4 py-0 d-inline comfortaa-font" id="userXPDisplay">
                        <span class="material-icons material-icons-outlined align-middle" style="color: var(--primary-color);">data_exploration</span>
                        <span class="align-middle fs-2"> $user_current_fp_xp </span><sup class="align-bottom" style="color: var(--primary-color);">xp</sup>
                    </div>
                </div>
                <!-- ./ $user_loggedin_username - display User XP -->
                <p class="text-center m-0"><span class="material-icons material-icons-outlined align-middle" style="color: var(--primary-color);">horizontal_rule</span></p>
                _END;
            break;

        default:
            # generic message
            $final_output = <<<_END
            <div class="text-center">
                <h5>Fitness progression could not be loaded. Please refresh the page.</h5>
            </div>
            _END;
            break;
    }

    echo $final_output;
} catch (\Throwable $th) {
    throw $th;
}