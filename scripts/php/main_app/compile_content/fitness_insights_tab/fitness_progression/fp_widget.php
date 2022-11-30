<?php
session_start();
require("../../../../config.php");
require_once("../../../../functions.php");

// check to see if username passed get
if (!isset($_GET['usnm'])) die("Fatal Error");
// if ($_GET['usnm'] !== $_SESSION['currentUserUsername']) die("invalid_session");
//header("Location: ../scripts/php/destroy_session.php?return=invalid_session");

// declare variables
$user_loggedin_username =
    $final_output = null;

$user_current_fp_xp =
    $goal_fp_xp = 0;

// assign get param values
$user_loggedin_username = sanitizeMySQL($dbconn, $_GET['usnm']);

function get_thousands_xp($num, $factor)
{
    return ceil($num / $factor) * $factor; // - 1
}

try {
    // get users fitness progression xp

    $query = "SELECT SUM(`total_xp`) AS total_xp FROM `user_profile_xp` uxp
    WHERE `general_user_profiles_user_profile_id` =  $usrdetails_profileid";

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error: - " . $dbconn->error . "]");

    $row = $result->num_rows;

    if ($row > 0) {
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


    // assign user details to the user pro
    $final_output = <<<_END
    <!-- $usrdetails_name's fitness progression progress bar -->
    <div class="p-4 my-0 d-grid align-items-center" id="user-fp-xp-bar" style="background-color: rgb(255 165 0 / 80%);border-radius:25px 25px 0 0;">
        <!-- rgba(52, 52, 52, 0.8) -->
        <!-- $usrdetails_name's fitness progression progress bar -->
        <div id="fitness-progression-progress-bar">
            <h5 class="mt-4"><span class="material-icons material-icons-outlined align-middle" style="color: #fff;">data_exploration</span> <span class="align-middle">Fitness Progression</span></h5>
            <div class="progress mt-4 bg-white" style="height: 20px;">
                <div class="progress-bar" role="progressbar" aria-label="Example 1px high" style="width: $fp_xp_progression_rate%; background-color: #343434 !important; border-right: #ffa500 10px solid;" aria-valuenow="$fp_xp_progression_rate" aria-valuemin="$user_current_fp_xp" aria-valuemax="$goal_fp_xp"></div>
            </div>
            <div class="row mt-2" style="margin-bottom: 60px;">
                <div class="col text-start comfortaa-font" style="font-size: 12px;">
                    Current XP <strong>($user_current_fp_xp)</strong>
                </div>
                <div class="col text-end comfortaa-font" style="font-size: 12px;">
                    Target XP <strong>($goal_fp_xp)</strong>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ $usrdetails_name's fitness progression progress bar -->
    _END;

    echo $final_output;
} catch (\Throwable $th) {
    throw $th;
}
