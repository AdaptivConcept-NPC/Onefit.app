<?php
session_start();
require("../../../config.php");
require_once("../../../functions.php");

// check to see if username passed get
if (!isset($_GET['usnm'])) die("Fatal Error");
// if ($_GET['usnm'] !== $_SESSION['currentUserUsername']) die("invalid_session");
//header("Location: ../scripts/php/destroy_session.php?return=invalid_session");

// declare variables
$user_loggedin_username =
    $final_output =
    $output_user_account_profile_img =
    $verif_icon = null;

$user_friend_count =
    $user_workout_achievements_count =
    $user_challenge_cmplt_count =
    $user_current_fp_xp =
    $goal_fp_xp = 0;

$usrdetails_userid =
    $usrdetails_username =
    $usrdetails_name =
    $usrdetails_surname =
    $usrdetails_idnumber =
    $usrdetails_email =
    $usrdetails_contact =
    $usrdetails_dob =
    $usrdetails_gender =
    $usrdetails_race =
    $usrdetails_nationality =
    $usrdetails_acc_active =
    $usrdetails_profileid =
    $usrdetails_about =
    $usrdetails_profiletype =
    $usrdetails_profile_url =
    $usrdetails_profile_img_url =
    $usrdetails_profile_banner_url = null;

// assign get param values
$user_loggedin_username = sanitizeMySQL($dbconn, $_GET['usnm']);

function get_thousands_xp($num, $factor)
{
    return ceil($num / $factor) * $factor; // - 1
}

try {
    $query = "SELECT * FROM users u INNER JOIN general_user_profiles gup ON u.username = gup.users_username WHERE u.username = '$user_loggedin_username';";
    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error: - " . $dbconn->error . "]");

    $rows = $result->num_rows;

    if ($rows > 0) {
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $usrdetails_userid = $row["user_id"];
            $usrdetails_username = $row["username"];
            $usrdetails_name = $row["user_name"];
            $usrdetails_surname = $row["user_surname"];
            $usrdetails_idnumber = $row["id_number"];
            $usrdetails_email = $row["user_email"];
            $usrdetails_contact = $row["contact_number"];
            $usrdetails_dob = $row["date_of_birth"];
            $usrdetails_gender = $row["user_gender"];
            $usrdetails_race = $row["user_race"];
            $usrdetails_nationality = $row["user_nationality"];
            $usrdetails_acc_active = $row["account_active"];

            $usrdetails_profileid = $row["user_profile_id"];
            $usrdetails_about = $row["about"];
            $usrdetails_profiletype = $row["profile_type"];
            $usrdetails_profile_url = $row["profile_url"];
            $usrdetails_profile_img_url = $row["profile_image_url"];
            $usrdetails_profile_banner_url = $row["profile_banner_url"];
            $usrdetails_verification = $row["verification"];
        }
    }

    // assign default profile picture if unavailable
    if ($usrdetails_profile_img_url == "default" || $usrdetails_profile_img_url == null || $usrdetails_profile_img_url == "") {
        $usrdetails_profile_img_url = "../media/profiles/0_default/default_profile_pic.svg";
        // ../../../../
    }

    // assign profile image htm;
    $output_user_account_profile_img = '<div class="display-profile-img-container shadow" style=""></div>';

    // assign default profile banner if unavailable
    if ($usrdetails_profile_banner_url == "default" || $usrdetails_profile_banner_url == null || $usrdetails_profile_banner_url == "") {
        $usrdetails_profile_banner_url = "../media/profiles/0_default/default_profile_banner.jpg";
        // ../../../../
    }

    // verification icon
    if ($usrdetails_verification == true) {
        $verif_icon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
    } else {
        $verif_icon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> groups </span>';
    }

    // get count of users friends
    $result = null;

    $query = "SELECT user_friend_username FROM friends
    WHERE users_username = '$user_loggedin_username' AND friendship_status = 1";

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error: - " . $dbconn->error . "]");

    $row = $result->num_rows;

    $user_friend_count = $row;

    // get count of users workout achievements
    $result = null;

    $query = "SELECT `workouts_workout_id`, `exercises_exercise_id` FROM `user_workout_achievements` 
    WHERE `users_username` = '$user_loggedin_username'";

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error: - " . $dbconn->error . "]");

    $row = $result->num_rows;

    $user_workout_achievementscount = $row;

    // get count of users workout achievements
    $result = null;

    $query = "SELECT `workouts_workout_id`, `exercises_exercise_id` FROM `user_workout_achievements` 
    WHERE `users_username` = '$user_loggedin_username'";

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error: - " . $dbconn->error . "]");

    $row = $result->num_rows;

    $user_workout_achievements_count = $row;

    // get count of users challenges completed
    $result = null;

    $query = "SELECT `challenge_log_id`, `workout_challenges_workout_challenge_id` FROM `user_challenge_cmplt_log` WHERE `users_username` = '$user_loggedin_username'";

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error: - " . $dbconn->error . "]");

    $row = $result->num_rows;

    $user_challenge_cmplt_count = $row;

    // get users fitness progression xp
    $result = null;

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
    <style>
        .display-profile-img-container {
            background: url('../media/profiles/$usrdetails_profile_img_url');
            background-repeat: no-repeat;
            background-position: center; 
            background-attachment: local; 
            background-clip: content-box; 
            background-size: contain;
            border-radius: 25px;
            height: 150px;
            width: 150px;
            overflow: hidden; 
        }
        .display-profile-banner-container {
            background-image: url('../media/profiles/$usrdetails_profile_banner_url');
        }
    </style>
    <div style="background-color: rgba(52, 52, 52, 0.8);">
        <div class='text-center'>
            <!-- Users Profile Banner -->
            <div class="shadow-lg display-profile-banner-container">
                <div class="h-100 down-top-grad-dark"><!-- gradient overlay --></div>
            </div>
            <!-- ./ Users Profile Banner -->
            <!-- Profile Picture -->
            <div class="d-grid justify-content-center down-top-grad-dark" style="margin-top: -200px !important">
                $output_user_account_profile_img
            </div>
            <!-- ./ Profile Picture -->
            <p class='poppins-font mt-2 username-tag' hidden>@$user_loggedin_username</p>
        </div>
        <!--<hr class='text-white' />-->
        <!-- main buttons for interacting with user profile -->
        <div class="d-flex justify-content-around align-items-center p-4" style="background-color: #343434;border-radius:0 0 25px 25px;">
            <!--  -->
            <button type="button"
                class="onefit-buttons-style-dark p-4 m-1 border-1 bg-transparent d-grid">
                <span
                    class="material-icons material-icons-round align-middle"
                    style="font-size: 20px !important">follow_the_signs</span>
                <span class="align-middle d-none d-lg-block"
                    style="font-size: 10px;">
                    <!-- <span style="color: #ffa500 !important;">+</span> -->
                    Follow Me
                </span>
            </button>
            <!-- visual divide -->
            <div>
                <span
                    class="material-icons material-icons-round align-middle"
                    style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                    horizontal_rule
                </span>
            </div>
            <!-- ./ visual divide -->
            <!--  -->
            <button type="button"
                class="onefit-buttons-style-dark p-4 m-1 border-1 bg-transparent d-grid">
                <span
                    class="material-icons material-icons-round align-middle"
                    style="font-size: 20px !important"> handshake
                </span>
                <span class="align-middle d-none d-lg-block"
                    style="font-size: 10px;">
                    <!-- <span style="color: #ffa500 !important;">+</span> -->
                    Help
                </span>
            </button>
            <!-- visual divide -->
            <div>
                <span
                    class="material-icons material-icons-round align-middle"
                    style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                    horizontal_rule
                </span>
            </div>
            <!-- ./ visual divide -->
            <!--  -->
            <button type="button"
                class="onefit-buttons-style-dark p-4 m-1 border-1 bg-transparent d-grid">
                <span
                    class="material-icons material-icons-round align-middle"
                    style="font-size: 20px !important"> 3p </span>
                <span class="align-middle d-none d-lg-block"
                    style="font-size: 10px;">
                    <!-- <span style="color: #ffa500 !important;">+</span> -->
                    Message
                </span>
            </button>
        </div>
        <!-- ./ main buttons for interacting with user post -->
        <hr class="text-white"/>
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
        <!-- user detailed progression list - user info -->
        <ol class='list-group list-group-numberedz list-group-flush p-4' style="background-color: rgba(52, 52, 52, 0.8);border-radius:25px;">
            <li class='list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-white'>
                <div class='ms-2 me-auto'>
                    <div class='fw-bold users-name-tag fs-5 mb-2' style='color: #ffa500'>
                        $usrdetails_name $usrdetails_surname
                    </div>
                    <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500; font-size: 20px !important;">alternate_email</span>
                    <span class='username-tag mb-4 barcode-fontz'>$user_loggedin_username</span><br />
                    <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500; font-size: 20px !important;">data_exploration</span> 
                    <span class="align-middle">Level 1 [$user_current_fp_xp xp]</span>
                </div>
                <span class='badge bg-primary p-4' style='background-color: #ffa500 !important; color: #333 !important; border-radius: 25px'>
                    $verif_icon
                </span>
            </li>
            <!-- Friends section -->
            <li class='list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-white'>
                <div class='ms-2 me-auto'>
                    <div class='fw-bold mb-2' style='color: #ffa500'>Followers</div>
                    <span>$user_friend_count Friends</span><br />
                    <span>0 Followers</span><br />
                    <span>0 Following</span>
                </div>
                <span class="badge bg-primary p-4 d-grid align-items-center fs-5" style="background-color: #ffa500 !important; color: #333 !important; border-radius: 25px">
                    <span class='material-icons material-icons-round' style='font-size: 40px !important'> people_alt </span>
                    <span>$user_friend_count</span>
                <span>
            </li>
            <!-- Achievements section -->
            <li class='list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-white'>
                <div class='ms-2 me-auto'>
                    <div class='fw-bold mb-2' style='color: #ffa500'>Achievements</div>
                    <span>$user_workout_achievements_count Achievements</span><br />
                    <span>0 Awards</span><br />
                </div>
                <span class="badge bg-primary p-4 d-grid align-items-center fs-5" style="background-color: #ffa500 !important; color: #333 !important; border-radius: 25px">
                    <span class='material-icons material-icons-round' style='font-size: 40px !important'> emoji_events </span>
                    <span>$user_workout_achievements_count</span>
                </span>
            </li>
            <!-- Challengess section -->
            <li class='list-group-item d-flex justify-content-between align-items-center bg-transparent text-white border-white'>
                <div class='ms-2 me-auto'>
                    <div class='fw-bold mb-2' style='color: #ffa500'>Challenges</div>
                    <span>$user_challenge_cmplt_count Challenges Completed</span>
                </div>
                <span class="badge bg-primary p-4 d-grid align-items-center fs-5" style="background-color: #ffa500 !important; color: #333 !important; border-radius: 25px">
                    <span class='material-icons material-icons-round' style='font-size: 40px !important'> stars </span>
                    <span>$user_challenge_cmplt_count</span>
                </span>
            </li>
        </ol>
        <hr class="text-white"/>
        <div class="text-center p-4" style="background-color: rgba(52, 52, 52, 0.8);" hidden aria-hidden="true">
            <img src="../media/assets/One-Symbol-Logo-Orange.svg" class="img-fluid" style="height: 50px;"/>
        </div>
    </div>
    _END;

    echo $final_output;
} catch (\Throwable $th) {
    throw $th;
}
