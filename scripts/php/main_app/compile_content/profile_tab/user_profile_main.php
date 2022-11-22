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
        $usrdetails_profile_img_url = "../../../../../media/profiles/0_default/default_profile_pic.png";
    }

    // assign profile image htm;
    $output_user_account_profile_img = '<div class="display-profile-img-container shadow" style=""></div>';

    // assign default profile banner if unavailable
    if ($usrdetails_profile_banner_url == "default" || $usrdetails_profile_banner_url == null || $usrdetails_profile_banner_url == "") {
        $usrdetails_profile_banner_url = "../../../../../media/profiles/0_default/default_profile_banner.jpg";
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

    $query = "SELECT `challenget_log_id`, `workout_challenges_workout_challenge_id` FROM `user_challenge_cmplt_log` WHERE `users_username` = '$user_loggedin_username'";

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

    // if user_current_fp_xp is  null / blank / 0, set 0 as value to avoid DIV/0 error, else calculate the fp xp progression rate
    if (is_null($user_current_fp_xp) || !isset($user_current_fp_xp) || $user_current_fp_xp == 0) $fp_xp_progression_rate = 1;
    else $fp_xp_progression_rate = ($user_current_fp_xp / $goal_fp_xp) * 100; // get the progression rate (%) of the current fp xp to the goal fp xp (progress bar)

    // if user_current_fp_xp is null / blank / 0, set it to 1 so that we can get the nearest goal_fp_xp
    if (is_null($user_current_fp_xp) || !isset($user_current_fp_xp) || $user_current_fp_xp == 0) $goal_fp_xp = get_thousands_xp(1, 1000); // pass xp value of 1 to get the thousannd tier
    else $goal_fp_xp = get_thousands_xp($user_current_fp_xp, 1000); // xp is tiered/leveled at a factor of 1000 per level


    // assign user details to the user pro
    $final_output = <<<_END
    <div class='col-lg p-4' style="max-height: 100vh; overflow-y: auto;">
        <!-- Share an Update section -->
        <h5 class='fs-1'>Share an Update </h5>
        <div class="container shadow mb-4" style="border-radius: 25px;" id="profile-social-post-update-container">
            <div class="row align-items-center collapsez" id="tab-nav-social-quickpostz">
                <div class="col-sm d-grid gap-2 py-4 px-0">
                    <!-- Quick Post to Social -->
                    <div class="social-quick-post d-grid">
                        <textarea name="" class="w-100 quick-post-input" id="" cols="30" rows="10" placeholder="Share an update with the Community.">Share an update with the Community.</textarea>
                    </div>
                    <!-- ./ Quick Post to Social -->
                </div>
                <div class="col-md-4 d-grid gap-2">
                    <div class="row text-center">
                        <div class="col-sm px-0">
                            <div class="d-grid">
                                <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                    <span class="material-icons material-icons-round" style="font-size: 18px !important">
                                        attach_file </span>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm px-0">
                            <div class="d-grid">
                                <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                    <span class="material-icons material-icons-round" style="font-size: 18px !important">
                                        perm_media </span>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm px-0">
                            <div class="d-grid">
                                <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                    <span class="material-icons material-icons-round" style="font-size: 18px !important"> link
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="onefit-buttons-style-light p-4">
                        <i class="fas fa-paper-plane" style="font-size: 38px !important"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- ./ Share an Update -->

        <h5 class='fs-1'>My Updates </h5>
        <div id='profileUsersPostsList' style='max-height: 100vh, overflow-y: auto;'>
            $outputProfileUsersPostsList
        </div>
    </div>
    <div class='col-lg-4 p-4z sticky-top shadow no-scroller' style="max-height: 100vh; overflow-y: auto; z-index: 900!important; border-radius: 25px;">
        <h5 class='fs-1'>My Media</h5>
        <div id='profileUserMediaList' class="grid-container"> <?php echo $outputProfileUserMediaList; ?> </div>
        <hr class='text-white' style='height: 5px;'>
        <h5 class='fs-1'>My Resources</h5>
        <div id='profileUsersResourcesList'> <?php echo $outputProfileUsersResourcesList; ?> </div>
        <hr class='text-white' style='height: 5px;'>
        <h5 class='fs-1'>My Friends</h5>
        <div id='profileUserFriendsList'> <?php echo $outputProfileUserFriendsList; ?> </div>
        <hr class='text-white' style='height: 5px;'>
        <h5 class='fs-1'>My Programs</h5>
        <div id='profileUsersProgramsList'> <?php echo $outputProfileUsersProgramsList; ?> </div>
        <hr class='text-white' style='height: 5px;'>
        <h5 class='fs-1'>My Saves</h5>
        <div id='profileUsersFavesList'> <?php echo $outputProfileUsersFavesList; ?> </div>
        <hr class='text-white' style='height: 5px;'>
        <h5 class='fs-1'>My Groups</h5>
        <div id='profileUserSubsGroupsList'> <?php echo $profileUserSubsGroupsList; ?> </div>
    </div>
    _END;

    // echo $final_output;
} catch (\Throwable $th) {
    throw $th;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <title>Onefit.app&trade; | Onefit.Net&reg; &copy; <?php echo date('Y'); ?></title>

    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

    <!-- Google Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- Plyr.io Media Player -->
    <link rel="stylesheet" href="https://cdn.plyr.io/1.8.2/plyr.css">

    <!-- Plry.io JS CDN -->
    <script src="https://cdn.plyr.io/1.8.2/plyr.js"></script>
    <script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- W3 CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />

    <!-- My CSS styles -->
    <link rel="stylesheet" href="../../../../../css/styles.css" />
    <link rel="stylesheet" href="../../../../../css/digital-clock.css" />
    <link rel="stylesheet" href="../../../../../css/timeline-styles.css" />

    <!-- Site Scripts -->
    <!-- <script src="../scripts/js/script.js"></script>
    <script src="../scripts/js/api_requests.js"></script> -->

    <!-- ./ Site Scripts -->

    <!-- JQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <?php echo $final_output; ?>
    </div>
</body>

</html>