<?php
session_start();
require("../../../config.php");
require_once("../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// check to see if username passed get
if (!isset($_GET['usnm'])) die("Fatal Error");
// if ($_GET['usnm'] !== $_SESSION['currentUserUsername']) die("invalid_session");
//header("Location: ../scripts/php/destroy_session.php?return=invalid_session");

// declare variables
$user_loggedin_username =
    $final_output =
    $output_user_account_profile_img =
    $verif_icon =
    $verif_icon_tahiti =
    $verif_icon_dark =
    $verif_icon_white =
    $verif_icon_nocolor = null;

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
    $usrdetails_profile_banner_url =
    $usrdetails_verification = null;

// assign get param values
$user_loggedin_username = sanitizeMySQL($dbconn, $_GET['usnm']);

function get_thousands_xp($num, $factor)
{
    return ceil($num / $factor) * $factor; // - 1
}

try {
    $query = "SELECT * FROM users u INNER JOIN general_user_profiles gup ON u.username = gup.users_username WHERE u.username = '$user_loggedin_username';";
    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error (1): - " . $dbconn->error . "]");

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
    if ($usrdetails_verification == "verified") {
        $verif_icon_tahiti = '<span class="material-icons material-icons-round align-middle" style="font-size: 80px !important;color: var(--primary-color);"> verified_user </span>';
        $verif_icon_dark = '<span class="material-icons material-icons-round align-middle" style="font-size: 80px !important;color: var(--secondary-color);"> verified_user </span>';
        $verif_icon_white = '<span class="material-icons material-icons-round align-middle" style="font-size: 80px !important;color:var(--white);"> verified_user </span>';
        $verif_icon_nocolor = '<span class="material-icons material-icons-round align-middle" style="font-size: 80px !important;"> verified_user </span>';
        $verif_label = "Pro";
    } else {
        $verif_icon_tahiti = '<span class="material-icons material-icons-round align-middle" style="font-size: 80px !important;color: var(--primary-color);"> groups_3 </span>';
        $verif_icon_dark = '<span class="material-icons material-icons-round align-middle" style="font-size: 80px !important;color:var(--dark);"> groups_3 </span>';
        $verif_icon_white = '<span class="material-icons material-icons-round align-middle" style="font-size: 80px !important;color:var(--white);"> groups_3 </span>';
        $verif_icon_nocolor = '<span class="material-icons material-icons-round align-middle" style="font-size: 80px !important;"> groups_3 </span>';
        $verif_label = "Community";
    }

    // switch $usrdetails_profiletype
    switch ($usrdetails_profiletype) {
        case "private":
            $usrdetails_profiletype = "Premiere";
            break;
        case "trainer":
            $usrdetails_profiletype = "Trainer";
            break;
        case "community_trainer":
            $usrdetails_profiletype = "CommTrainer";
            break;
        case "trainee":
            $usrdetails_profiletype = "Pro";
            break;
        case "admin":
            $usrdetails_profiletype = "Administrator";
            break;
        case "community":
            $usrdetails_profiletype = "CommTrainee";
            break;
        case "community_trainee":
            $usrdetails_profiletype = "CommTrainee";
            break;
        default:
            // public: community members
            $usrdetails_profiletype = "Guest";
            break;
    }

    // get count of users friends
    $result = null;

    $query = "SELECT user_friend_username FROM friends
    WHERE users_username = '$user_loggedin_username' AND friendship_status = 1";

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error (2): - " . $dbconn->error . "]");

    $row = $result->num_rows;

    $user_friend_count = $row;

    // get count of users workout achievements
    $result = null;

    $query = "SELECT `workouts_workout_id`, `exercises_exercise_id` FROM `user_workout_achievements` 
    WHERE `users_username` = '$user_loggedin_username'";

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error (3): - " . $dbconn->error . "]");

    $row = $result->num_rows;

    $user_workout_achievementscount = $row;

    // get count of users workout achievements
    $result = null;

    $query = "SELECT `workouts_workout_id`, `exercises_exercise_id` FROM `user_workout_achievements` 
    WHERE `users_username` = '$user_loggedin_username'";

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error (4): - " . $dbconn->error . "]");

    $row = $result->num_rows;

    $user_workout_achievements_count = $row;

    // get count of users challenges completed
    $result = null;

    $query = "SELECT `challenge_log_id`, `workout_challenges_workout_challenge_id` FROM `user_challenge_cmplt_log` WHERE `users_username` = '$user_loggedin_username'";

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error (5): - " . $dbconn->error . "]");

    $row = $result->num_rows;

    $user_challenge_cmplt_count = $row;

    $result = null;

    $query = "SELECT `user_profile_id` FROM `general_user_profiles` WHERE `users_username` = '$user_loggedin_username'";
    $result = $dbconn->query($query);

    if (!$result) die("User profile ID cannot be found");

    if ($row > 0) {
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $usrdetails_profileid = $row["user_profile_id"];
        }
    }

    // die("$ usrdetails_profileid: " . $usrdetails_profileid . " \n query: " . $query);

    // get users fitness progression xp
    $result = null;

    $query = "SELECT SUM(`total_xp`) AS total_xp FROM `user_profile_xp`
    WHERE `general_user_profiles_user_profile_id` = $usrdetails_profileid";

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to process this request. [user profile header error (6): - " . $dbconn->error . " \nsql query: \n" . $query . "]");

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
        <div class="text-center">
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
            <div id="profile-verification-strip" class="p-4 pb-0 d-grid gap-4" style="background:var(--secondary-color);">
                <p class="poppins-font p-4 pb-0 m-0 fs-1">$usrdetails_name $usrdetails_surname</p>
                <div class="d-grid gap-2 mb-4">
                    <div class="text-center mb-3 d-none">
                        <span class="barcode-font" style="font-size:16px;color:var(--white);">
                            <span style="color: var(--primary-color);">
                                @$user_loggedin_username
                            </span>
                        </span>
                    </div>
                    <div class="d-flex gap-4 align-items-center justify-content-evenly">
                        <div class="col-sm-5 text-sm-end d-none d-md-block">
                            <span class="poppins-font" style="font-size:16px;color:var(--white);">
                                <span class="material-icons material-icons-round align-middle" style="font-size: 22px !important;color: var(--primary-color);">
                                    alternate_email
                                </span> $user_loggedin_username
                            </span>
                        </div>
                        <div class="col-sm d-grid justify-content-center">
                            <div class="border-start border-end border-light border-5 p-4 py-2" style="border-radius:15px;">
                                $verif_icon_tahiti
                                <span class="comfortaa-font mb-2 text-truncate" style="font-size:14px;color:var(--white);"> $verif_label </span>
                            </div>
                        </div>
                        <div class="col-sm-5 text-sm-start d-none d-md-block">
                            <span class="poppins-font mb-2" style="font-size:16px;color:var(--white);"> $usrdetails_profiletype </span>
                            <span class="material-icons material-icons-round align-middle" style="font-size: 22px !important;color: var(--primary-color);">
                                workspaces
                            </span>
                        </div>
                    </div>
                    <!--<div class="d-flex gap-4 justify-content-center align-items-end"></div>-->
                </div>
            </div>
        </div>
        <!--<hr class="text-white" />-->
        <!-- main buttons for interacting with user profile -->
        <div class="d-flex justify-content-evenly aroundz align-items-center p-4 pt-0 mx-2" style="background-color: var(--secondary-color);border-radius:0 0 25px 25px;">
            <!-- audience -->
            <button type="button" class="onefit-buttons-style-dark p-4 m-1 border-1 bg-transparent d-grid position-relative gap-4">
                <span class="material-icons material-icons-round align-middle" style="font-size: 40px !important">follow_the_signs</span>
                <span class="align-middle d-none d-lg-block" style="font-size: 12px;">
                    Audience
                </span>
                <span class="position-absolute top-100 start-50 translate-middle badge rounded-pill text-dark p-2 px-3 poppins-font fs-5z shadow" style="background-color: var(--primary-color)!important;">
                    99+ <span class="visually-hidden">followers</span>
                </span>
            </button>
            <!-- visual divide -->
            <div>
                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: var(--primary-color) !important; transform: rotate(90deg);">
                    horizontal_rule
                </span>
            </div>
            <!-- ./ visual divide -->
            <!-- support -->
            <button type="button" class="onefit-buttons-style-dark p-4 m-1 border-1 bg-transparent d-grid position-relative gap-4">
                <span class="material-icons material-icons-round align-middle" style="font-size: 40px !important"> handshake
                </span>
                <span class="align-middle d-none d-lg-block" style="font-size: 12px;">
                    Trainer Support
                </span>
                <span class="position-absolute top-100 start-50 translate-middle badge rounded-pill text-dark p-2 px-3 poppins-font fs-5z shadow" style="background-color: var(--primary-color)!important;">
                    12 interactions <span class="visually-hidden">Trainer Support</span>
                </span>
            </button>
            <!-- visual divide -->
            <div>
                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: var(--primary-color) !important; transform: rotate(90deg);">
                    horizontal_rule
                </span>
            </div>
            <!-- ./ visual divide -->
            <!-- messages -->
            <button type="button" class="onefit-buttons-style-dark p-4 m-1 border-1 bg-transparent d-grid position-relative gap-4" onclick="$('#app-msgs-btn').click()">
                <span class="material-icons material-icons-round align-middle" style="font-size: 40px !important"> 3p </span>
                <span class="align-middle d-none d-lg-block" style="font-size: 12px;">
                    Messages
                </span>
                <span class="position-absolute top-100 start-50 translate-middle badge rounded-pill text-dark p-2 px-3 poppins-font fs-5z shadow" style="background-color: var(--primary-color)!important;">
                    99+ <span class="visually-hidden">unread messages</span>
                </span>
            </button>
            <!-- visual divide -->
            <div>
                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: var(--primary-color) !important; transform: rotate(90deg);">
                    horizontal_rule
                </span>
            </div>
            <!-- ./ visual divide -->
            <!-- go live -->
            <button type="button" class="onefit-buttons-style-red p-4 m-1 border-1 bg-transparent d-grid gap-4 position-relative">
                <span class="material-icons material-icons-round align-middle" style="font-size: 40px !important"> live_tv </span>
                <span class="align-middle d-none d-lg-block" style="font-size: 12px;">
                    <!-- <span style="color: var(--primary-color) !important;">+</span> -->
                    <span class="material-icons material-icons-round align-middle" style="font-size: 12px !important; color: var(--red);"> radio_button_checked
                    </span> Go Live
                </span>
                <span class="position-absolute top-100 start-50 translate-middle badge rounded-pill text-white p-2 px-3 poppins-font fs-5 shadow" style="background-color:var(--red)!important;">
                    Live <span class="visually-hidden">live status</span>
                </span>
            </button>
        </div>
        <!-- ./ main buttons for interacting with user post -->
        <hr class="text-white"/>
        <!-- $usrdetails_name's fitness progression progress bar -->
        <div class="p-4 my-0 mx-2 d-grid align-items-center top-down-grad-dark" id="user-fp-xp-bar" style="background-color: rgb(255 165 0 / 80%);border-radius:25px 25px 0 0;padding-bottom:40px!important;">
            <!-- rgba(52, 52, 52, 0.8) -->
            <!-- $usrdetails_name's fitness progression progress bar -->
            <div id="fitness-progression-progress-bar" class="bar-fpwidget">
                <h5 class="mt-4 text-center fs-1"><span class="material-icons material-icons-outlined align-middle" style="color: #fff;">data_exploration</span> <span class="align-middle">Fitness Progression</span></h5>
                <div class="progress mt-4 bg-white" style="height:20px;border:1px solid white !important;">
                    <div class="progress-bar" role="progressbar" aria-label="Example 1px high" style="width: $fp_xp_progression_rate%; background-color: var(--secondary-color) !important; border-right: var(--tahitigold) 10px solid;" aria-valuenow="$fp_xp_progression_rate" aria-valuemin="$user_current_fp_xp" aria-valuemax="$goal_fp_xp"></div>
                </div>
                <div class="mt-2 w-100 d-flex justify-content-between" style="margin-bottom:20px!important;">
                    <p class="text-start m-0 poppins-font" style="font-size: 12px;">
                        Current XP <strong>($user_current_fp_xp)</strong>
                    </p>
                    <p class="text-end m-0 poppins-font" style="font-size: 12px;">
                        Target XP <strong>($goal_fp_xp)</strong>
                    </p>
                </div>
            </div>
            <!-- Insight Summary Chart placeholders -->
            <div class="row align-items-center">
                <h5 class="mt-4 text-center fs-1"><span class="material-icons material-icons-outlined align-middle" style="color: #fff;">insights</span> <span class="align-middle">Fitness Summary</span></h5>
                <div class="col-md-8 rounded" style="overflow: hidden">
                    <img src="../media/assets/chartjs_profletab_analytics chart_example_line.png" class="img-fluid" alt="chart placeholder - line chart" srcset="" style="border-radius: 25px !important">
                </div>
                <div class="col-md">
                    <img src="../media/assets/chartjs_profletab_analytics chart_example_polar_area.png" class="img-fluid" alt="chart placeholder - polar area chart" srcset="" style="border-radius: 25px !important">
                </div>
            </div>
            <!-- ./ Insight Summary Chart placeholders -->
            <!-- Trainer notes (open diary model and focus on trainer notes section) -->
            <div class="d-grid mb-4 mt-5">
                <button class="onefit-buttons-style-dark p-4"><span class="material-icons material-icons-outlined align-middle" style="color: #fff;">speaker_notes</span> Trainer Notes</button>
            </div>
            <!-- ./ Trainer notes (open diary model and focus on trainer notes section) -->
        </div>
        <!-- ./ $usrdetails_name's fitness progression progress bar -->
        <!-- user detailed progression list - user info -->
        <ol class="p-4 list-group list-group-numberedz list-group-flush p-4 mx-2 edge-line-tahiti-vertical-grad-slanted gap-4" style="background-color: rgba(52, 52, 52, 1);border-radius:25px;margin-top:-25px;">
            <li class="p-4 list-group-item d-flex justify-content-between align-items-center bg-transparent shadow text-white border-dark left-right-grad-mineshaft" style="border-radius:25px">
                <div class="d-flex gap-2 align-items-center">
                    <div class="text-center d-none d-lg-block">
                        <span class="material-icons material-icons-round d-none">
                            assignment_ind
                        </span>
                        $output_user_account_profile_img
                    </div>
                    <div class="ms-2 me-auto">
                        <div class="fw-bold users-name-tag fs-5 mb-2" style="color: var(--primary-color)">
                            $usrdetails_name $usrdetails_surname
                        </div>
                        <span class="material-icons material-icons-outlined align-middle" style="color: var(--primary-color); font-size: 20px !important;">alternate_email</span>
                        <span class="username-tag mb-4 barcode-fontz">$user_loggedin_username</span><br />
                        <span class="material-icons material-icons-outlined align-middle" style="color: var(--primary-color); font-size: 20px !important;">data_exploration</span> 
                        <span class="align-middle">Level 1 [$user_current_fp_xp xp]</span>
                    </div>
                </div>
                <span class="badge bg-primary p-4 d-grid" style="background-color: var(--primary-color) !important; color: var(--secondary-color) !important; border-radius: 25px">
                    $verif_icon_dark
                    <span>$verif_label Groups</span>
                </span>
            </li>
            <!-- Friends section -->
            <li class="p-4 list-group-item d-flex justify-content-between align-items-center bg-transparent shadow text-white border-dark left-right-grad-mineshaft" style="border-radius:25px">
                <div class="ms-2 me-auto">
                    <h5 class="fw-bold mb-2 fs-5" style="color: var(--primary-color)">Audience</h5>
                    <span>$user_friend_count Friends</span><br />
                    <span>0 Followers</span><br />
                    <span>0 Following</span>
                </div>
                <span class="badge bg-primary p-4 d-grid align-items-center fs-5" style="background-color: var(--primary-color) !important; color: var(--secondary-color) !important; border-radius: 25px">
                    <span class="material-icons material-icons-round" style="font-size: 80px !important"> people_alt </span>
                    <span>$user_friend_count</span>
                <span>
            </li>
            <!-- Achievements section -->
            <li class="p-4 list-group-item d-flex justify-content-between align-items-center bg-transparent shadow text-white border-dark left-right-grad-mineshaft" style="border-radius:25px">
                <div class="ms-2 me-auto">
                    <h5 class="fw-bold mb-2 fs-5" style="color: var(--primary-color)">Achievements</h5>
                    <span>$user_workout_achievements_count Awards</span><br />
                    <span>$user_workout_achievements_count Rewards</span><br />
                    <span>Total Achievements</span><br />
                </div>
                <span class="badge bg-primary p-4 d-grid align-items-center fs-5" style="background-color: var(--primary-color) !important; color: var(--secondary-color) !important; border-radius: 25px">
                    <span class="material-icons material-icons-round" style="font-size: 80px !important"> emoji_events </span>
                    <span>$user_workout_achievements_count</span>
                </span>
            </li>
            <!-- Challengess section -->
            <li class="p-4 list-group-item d-flex justify-content-between align-items-center bg-transparent shadow text-white border-dark left-right-grad-mineshaft" style="border-radius:25px">
                <div class="ms-2 me-auto">
                    <h5 class="fw-bold mb-2 fs-5" style="color: var(--primary-color)">Challenges</h5>
                    <span>$user_challenge_cmplt_count Challenges Completed</span><br/>
                    <span>$user_challenge_cmplt_count Total Challenges</span>
                </div>
                <span class="badge bg-primary p-4 d-grid align-items-center fs-5" style="background-color: var(--primary-color) !important; color: var(--secondary-color) !important; border-radius: 25px">
                    <span class="material-icons material-icons-round" style="font-size: 80px !important"> stars </span>
                    <span>$user_challenge_cmplt_count%</span>
                </span>
            </li>
        </ol>
        <hr class="text-white"/>
        <div class="text-center p-4 mx-2" style="background-color: rgba(52, 52, 52, 0.8);" hidden aria-hidden="true">
            <img src="../media/assets/One-Symbol-Logo-Orange.svg" class="img-fluid" style="height: 50px;"/>
        </div>
    </div>
    _END;

    echo $final_output;
} catch (\Throwable $th) {
    throw $th;
}