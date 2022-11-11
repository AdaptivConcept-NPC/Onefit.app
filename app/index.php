<?php
session_start();
require("../scripts/php/config.php");
require('../scripts/php/functions.php');

//Connection Test==============================================>
// Check connection
/*if ($dbconn->connect_error) {
      die("Connection failed: " . $dbconn->connect_error);
  }
  echo "Connected successfully";*/
if ($dbconn->connect_error) die("Fatal Error");
//end of Connection Test============================================>

// declaring variables
$userAuth = false;
$currentUser_Usrnm = "";

//output/display variables
$outputSocialItems = $outputProfileUserSubsGroupsList = $outputProfileUsersPostsList = $outputProfileUsersResourcesList = $outputProfileUsersProgramsList = $outputProfileUserFriendsList = $outputProfileUsersFavesList = $outputProfileUserMediaList = $outputProfileUserNotifications = $outputProfileUserChats = $outputProfileUserPref = $outputProfileUserChallenges = NULL;

// user profile demographic details
$usr_userid = $usrprof_username = $usrprof_name = $usrprof_surname = $usrprof_idnumber = $usrprof_email = $usrprof_contact = $usrprof_dob = $usrprof_gender = $usrprof_race = $usrprof_nationality = $usrprof_acc_active = $usr_profileid = $usr_about = $usr_profiletype = $usr_profilepicurl = $usr_verification = NULL;

// storing the other profile details
$socialItems = $profileUserSubsGroupsList = $profileUsersPostsList = $profileUsersResourcesList = $profileUsersProgramsList = $profileUserFriendsList = $profileUsersFavesList = $profileUserMediaList = $profileUserNotifications = $profileUserChats = $profileUserPref = $profileUserChallenges = $currentUserAccountProdImg = NULL;

// storing the community content
$outputCommunityGroups = $outputCommunityNews = $outputCommunityResources = $outputCommunityUpdates = NULL;

// storing the discovery content
$discoveryAllUsersList = $discoveryFitProgsIndi = $discoveryFitProgsTeams = $discoveryAllTrainees = $discoveryAllTrainers = $discoverygroups = NULL;

//getUserChats
$convo_conversationid = $convo_secondaryuser = $secondaryuser_name = $secondaryuser_surname = $communicationUserMessages = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserFriends
$friendid = $friendUsername = $friendName = $friendSurname = $profileUserFriendsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserGroups
$grps_groupid = $grps_refcode = $grps_name = $grps_description = $grps_category = $grps_privacy = $grps_createdby = $grps_createdate = $profileUserSubsGroupsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserMedia
$fileList = $profileUserMediaList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserNotifications
$notif_id = $notif_title = $notif_message = $notif_date = $communicationUserNotifications =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserPref

//getUserProgSubs
$programs_progid = $programs_refcode = $programs_title = $programs_description = $programs_duration = $programs_category = $programs_privacy = $programs_creator = $programs_active = $profileUsersProgramsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserResources
$usrresources_resourceid = $usrresources_title = $usrresources_description = $usrresources_type = $usrresources_link = $usrresources_sharedate = $usrresources_sharename = $usrresources_sharesurname = $profileUsersResourcesList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserSaves
$fave_id = $fave_ref = $fave_date = $post_id = $post_date = $post_msg = $mod_date = $poster_name = $poster_surname = $poster_username = $profileUsersFavesList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserSocials
$usr_socialnet = $usr_socialhandle = $usr_sociallink = $socialNetworkIcon = $socialItems = $userSocialItemsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserUpdates
$usrposts_postid = $usrposts_postdate = $usrposts_message = $usrposts_user = $usrposts_faveref  = $usrposts_name = $usrposts_surname = $profileUsersPostsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getCommunityGroups
$grps_groupid = $grps_refcode = $grps_name = $grps_description = $grps_category = $grps_privacy = $grps_createdby = $grps_createdate = $discoverGroupsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getCommunityNews
$news_id = $news_title = $news_content = $news_createdby = $news_date = $news_poster_name = $news_poster_surname = $communicationNews = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getCommunityResources
$resourceid = $resource_title = $resource_descr = $resource_type = $resource_link = $sharedbyUsername = $sharedate = $openlinkbtn = $outputCommunityResources = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

$commpost_postid = $commpost_postdate = $commpost_message = $commpost_user = $commpost_faveref = $commpost_usr_name = $commpost_usr_surname = $communityPosts = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getAllUsers
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $usrs_prof_acctype = $discoverPeopleList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getFitProgramsIndi
$indi_programs_progid = $indi_programs_refcode = $indi_programs_title = $indi_programs_description = $indi_programs_duration = $indi_programs_category = $indi_programs_privacy = $indi_programs_creator = $indi_programs_active = $discoverIndiProgramsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getFitProgramsTeams
$team_programs_progid = $team_programs_refcode = $team_programs_title = $team_programs_description = $team_programs_duration = $team_programs_category = $team_programs_privacy = $team_programs_creator = $team_programs_active = $discoverteamProgramsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getAllTrainees
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $activitiesTraineesList = $usrs_prof_acctype = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getAllTrainers
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $activitiesTrainersList = $usrs_prof_acctype = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

// exercise dropdown list
$workout_activities_list = $user_profile_id = $exercise_name = $xp_points = null;

// misc
$currentuser_img_url = $otheruser_img_url = $verifIcon = $otherUserverifIcon = $output_msg = $app_err_msg = $output = NULL;
$uctDateTime = new DateTime(date('Y-m-d H:i:s'));
$uctDateTime->setTimezone(new DateTimeZone("UTC"));


if (isset($_SESSION["currentUserAuth"])) {
    if ($_SESSION["currentUserAuth"] == true) {
        $userAuth = sanitizeString($_SESSION["currentUserAuth"]);
        $currentUser_Usrnm = sanitizeString($_SESSION["currentUserUsername"]);

        // echo <<<_END
        //     <div class="alert alert-danger p-3">userAuth: $userAuth | username: $currentUser_Usrnm</div>
        //     _END;

        // Load App Content
        // Load the user profile information
        $sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username WHERE u.username = '$currentUser_Usrnm';";

        if ($result = mysqli_query($dbconn, $sql)) {

            while ($row = mysqli_fetch_assoc($result)) {
                $usr_userid = $row["user_id"];

                $usrprof_username = $row["username"];
                $usrprof_name = $row["user_name"];
                $usrprof_surname = $row["user_surname"];
                $usrprof_idnumber = $row["id_number"];
                $usrprof_email = $row["user_email"];
                $usrprof_contact = $row["contact_number"];
                $usrprof_dob = $row["date_of_birth"];
                $usrprof_gender = $row["user_gender"];
                $usrprof_race = $row["user_race"];
                $usrprof_nationality = $row["user_nationality"];
                $usrprof_acc_active = $row["account_active"];

                $usr_profileid = $row["user_profile_id"];
                $usr_about = $row["about"];
                $usr_profiletype = $row["profile_type"];
                $usr_profilepicurl = $row["profile_url"];
                $usr_verification = $row["verification"];
            }

            // get the other profile details
            //$currentUserAccountProdImg = '<img src="../media/profiles/'.$usrprof_username.'/'.$usr_profilepicurl.'" alt="'.$usrprof_name.' '.$usrprof_surname.' - Profile Picture" class="img-fluid">';
            if ($usr_profilepicurl == "default" || $usr_profilepicurl == null || $usr_profilepicurl == "") {
                $currentuser_img_url = "../media/profiles/0_default/default_profile_pic.png";
            } else {
                $currentuser_img_url = "../media/profiles/$currentUser_Usrnm/$usr_profilepicurl";
            }

            $currentUserAccountProdImg = '<div class="social-update-profile-pic shadow" style="background-position: center !important; background-size: contain !important; background-repeat: no-repeat !important; background-attachment: local !important; height: 150px !important; width:  150px !important; background: url(' . "'$currentuser_img_url'" . ') !important"></div>';

            $outputSocialItems = getUserSocials();
            $outputProfileUserSubsGroupsList = getUserGroups();
            $outputProfileUsersPostsList = getUserUpdates();
            $outputProfileUsersResourcesList = getUserResources();
            $outputProfileUsersProgramsList = getUserProgSubs();
            $outputProfileUserFriendsList = getUserFriends();
            $outputProfileUsersFavesList = getUserSaves();
            $outputProfileUserMediaList = getUserMedia();
            $outputProfileUserNotifications = getUserNotifications();
            $outputProfileUserChats = getUserChatConversations();
            $outputProfileUserPref = getUserPref();
            $outputProfileUserChallenges = getUserChallenges();

            // get the community content
            $outputCommunityGroups = getCommunityGroups();
            $outputCommunityNews = getCommunityNews();
            $outputCommunityResources = getCommunityResources();
            $outputCommunityUpdates = getCommunityUpdates();

            // get the discovery content
            $discoveryAllUsersList = getAllUsers();
            $discoveryFitProgsIndi = getFitProgramsIndi();
            $discoveryFitProgsTeams = getFitProgramsTeams();
            $discoveryAllTrainees = getAllTrainees();
            $discoveryAllTrainers = getAllTrainers();

            // verification icon
            if ($usr_verification == true) {
                $verifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $verifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> groups </span>';
            }
        } else {
        }

        // call to compile exercise list
        $workout_activities_list = compileSelectInputExerciseList();
    } else {
        //destroy session,
        header("Location: ../scripts/php/destroy_session.php");
    }
} else {
    //destroy session,
    header("Location: ../scripts/php/destroy_session.php");
    //$currentUser_Usrnm = "Guest-" . generateRandomString(8) . "_"; // . $uctDateTime;
}

//Functions
function compileSelectInputExerciseList()
{
    global $dbconn;
    $exercise_id = $xp_points = 0;
    $exercise_name = $workout_name = "";
    $compile_workout_activities_list = "";

    // $sql = "SELECT ex.exercise_id, ex.exercise_name, ex.xp_points, wk.workout_name, wk.workout_category FROM exercises ex
    // INNER JOIN workout_training wt ON wt.exercises_exercise_id = ex.exercise_id
    // INNER JOIN workouts wk ON w.workout_id = wt.workouts_workout_id
    // ORDER BY ex.exercise_name ASC";

    $sql = "SELECT `exercise_id`, `exercise_name`, `xp_points` FROM `exercises` ORDER BY `exercise_name` ASC";

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $exercise_id = $row["exercise_id"];
            $exercise_name = $row["exercise_name"];
            $xp_points = $row["xp_points"];

            // echo <<<_END
            // <div class="alert alert-success p-3">upid: $exercise_id | exercise name: $exercise_name | xp: $xp_points</div>
            // _END;

            $compile_workout_activities_list .= <<<_END
            <option value="$exercise_id"> $exercise_name ($xp_points<sub style="color: #ffa500;">xp</sub>)</option>
            _END;
        }
    } else {
        // echo <<<_END
        //     <div class="alert alert-danger p-3">No exercise items found.</div>
        //     _END;
        $compile_workout_activities_list = '<option value="error">No exercise items found.</option>';
    }

    return $compile_workout_activities_list;
}

function dateDifference($start_date, $end_date)
{
    // calulating the difference in timestamps 
    $diff = strtotime($start_date) - strtotime($end_date);

    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds
    return ceil(abs($diff / 86400));
}

//Content Load Functions - User Profile
function getUserChallenges()
{
    $output = "Loading...";

    return $output;
}
function getUserChatConversations()
{
    global $convo_conversationid, $convo_secondaryuser, $secondaryuser_name, $secondaryuser_surname, $communicationUserMessages, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //messages
    //$sql = "SELECT * FROM messages msg INNER JOIN users u ON msg.receiver = u.username WHERE msg.sender = '$currentUser_Usrnm';";
    /*$sql = "SELECT * FROM ((user_conversations uc 
    INNER JOIN users u ON uc.secondary_user = u.username) 
    INNER JOIN user_conversation_messages ucm  ON ucm.conversation_id = uc.conversation_id) 
    WHERE uc.primary_user = '$currentUser_Usrnm' ORDER BY ucm.send_date DESC LIMIT 1;";*/
    $sql = "SELECT * FROM user_conversations uc 
    INNER JOIN users u ON uc.secondary_user = u.username
    WHERE uc.primary_user = '$currentUser_Usrnm' ORDER BY uc.conversation_id DESC;";

    //LEFT OUTER JOIN user_conversation_messages ucm  ON ucm.conversation_id = uc.conversation_id) 

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //ucm: `message_id`, `conversation_id`, `message`, `sender`, `receiver`, `send_date`, `message_read`
            //uc: `conversation_id`, `primary_user`, `secondary_user`, `conversation_start_date`
            //$msg_id = $row["message_id"];

            $convo_conversationid = $row["conversation_id"];
            //$convo_lastmsg = $row["message"];
            $convo_secondaryuser = $row["secondary_user"];
            //$convo_lastmsgdate = $row["send_date"];
            //$convo_msgread = $row["message_read"];

            $secondaryuser_name = $row["user_name"];
            $secondaryuser_surname = $row["user_surname"];

            $communicationUserMessages .= '
            <li class="list-group-item bg-transparent text-white" id="conversation-' . $convo_conversationid . '">
                <div class="row align-items-center" style="min-height: 100px;">
                    <div class="col-sm-3 text-center">
                        <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                    </div>
                    <div class="col-sm text-center">
                        <p class="fs-5 my-0 text-truncate">' . $secondaryuser_name . ' ' . $secondaryuser_surname . ' </p>
                    </div>
                    <div class="col-sm-3 text-center d-grid py-2">
                        <button type="button" class="onefit-buttons-style-dark p-4 position-relative" onclick="openMessenger(' . "'" . $convo_conversationid . "'" . ', ' . "'" . $currentUser_Usrnm . "'" . ', ' . "'" . $convo_secondaryuser . "'" . ')">
                            Open
                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-dangerz border border-light rounded-circle my-pulse-animation-tahiti" style="background-color: #ffa500 !important;">
                                <span class="visually-hidden">New Message</span>
                            </span>
                        </button>
                    </div>
                </div>
            </li>';

            $output = $communicationUserMessages;
        }
    } else {
        $output_msg = "|[System Error]|:. [Communications load (User conversations list) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2 d-block" id="application-error-msg"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserDetails($username)
{
    global $currentUser_Usrnm, $dbconn;

    $otherUserverifIcon = $usrdetails_userid = $usrdetails_username = $usrdetails_name = $usrdetails_surname = $usrdetails_idnumber = $usrdetails_email = $usrdetails_contact = $usrdetails_dob = $usrdetails_race = $usrdetails_nationality = $usrdetails_acc_active = $usrdetails_profileid = $usrdetails_about = $usrdetails_profiletype = $usrdetails_profilepicurl = $usrdetails_verification = $currentUserAccountProdImg = "";

    // Load the user profile information
    $sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username WHERE u.username = '$username';";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
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
            $usrdetails_profilepicurl = $row["profile_url"];
            $usrdetails_verification = $row["verification"];
        }

        // get the other profile details
        //$currentUserAccountProdImg = '<img src="../media/profiles/'.$usrprof_username.'/'.$usr_profilepicurl.'" alt="'.$usrprof_name.' '.$usrprof_surname.' - Profile Picture" class="img-fluid">';

        $otheruser_img_url = "'../media/profiles/$currentUser_Usrnm/$usrdetails_profilepicurl'";

        $otherUserAccountProdImg = '<div class="social-update-profile-pic shadow" style="height: 200px !important; width:  200px !important; background-color: url(' . $otheruser_img_url . ')"></div>';

        // verification icon
        if ($usrdetails_verification == true) {
            $otherUserverifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
        } else {
            $otherUserverifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> groups </span>';
        }

        return $result;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Account details - 2) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';

        $output = $app_err_msg;
    }

    return $output;
}
function getUserFriends()
{
    global $friendid, $friendUsername, $friendName, $friendSurname, $profileUserFriendsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;
    $frnd_profilepicurl = $currentUserAccountProdImg = $currentuser_img_url = $verifIcon = "";
    $usr_verification = false;

    //users friends list
    $sql = "SELECT f.friend_id, f.friend_username, u.user_name, u.user_surname, up.profile_url, up.verification FROM friends f 
    INNER JOIN users u ON f.friend_username = u.username 
    INNER JOIN user_profiles up ON f.friend_username = up.username
    WHERE f.username = '$currentUser_Usrnm' AND f.friendship_status = 1";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $friendid = $row["friend_id"];
            $friendUsername = $row["friend_username"];

            $friendName = $row["user_name"];
            $friendSurname = $row["user_surname"];

            $frnd_profilepicurl = $row["profile_url"];

            if ($frnd_profilepicurl == "default" || $frnd_profilepicurl == null || $frnd_profilepicurl == "") {
                $currentuser_img_url = "../media/profiles/0_default/default_profile_pic.png";
            } else {
                $currentuser_img_url = "../media/profiles/$friendUsername/$frnd_profilepicurl";
            }

            //$currentUserAccountProdImg = '<div class="social-update-profile-pic shadow" style="background-position: center !important; background-size: contain !important; background-repeat: no-repeat !important; background-attachment: local !important; height: 200px !important; width:  200px !important; background: url(' . $currentuser_img_url . ') !important"></div>';

            // verification icon
            if ($usr_verification == true) {
                $verifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $verifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            $profileUserFriendsList .= '
            <!-- User Friends - dark Grad -->
            <div class="grid-tile p-0">
                <div class="my-4 tunnel-bg-container" id="friend-' . $friendid . '-' . $friendUsername . '" style="border-radius: 25px;">
                    <div class="top-down-grad-light" style="border-radius: 25px;">
                        <div class="row align-items-center content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaftz left-right-grad-mineshaft">
                            <div class="col-xlg-2 text-center p-4">
                                <img src="' . $currentuser_img_url . '" class="img-fluid rounded-circle shadow" style="border-radius: 25px;" alt="prof thumbnail">
                            </div>
                            <div class="col-xlg-6 text-center p-4">
                                <h3 class="text-white">' . $friendName . ' ' . $friendSurname . '</h3>
                                <p style="font-size: 10px">@' . $friendUsername . '</p>
                                <p style="font-size: 10px">Level.: 1</p>
                                ' . $verifIcon . '
                            </div>
                            <div class="col-xlg-4 text-center p-4">
                                <button class="onefit-buttons-style-light p-4 my-4 shadow" onclick="openProfiler(' . "'" . $friendUsername . "'" . ')">
                                    View profile <i class=" fas fa-chevron-circle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./ User Friends - dark Grad -->';
        }

        $output = $profileUserFriendsList;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Users friends) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserGroups()
{
    global $grps_groupid, $grps_refcode, $grps_name, $grps_description, $grps_category, $grps_privacy, $grps_createdby, $grps_createdate, $profileUserSubsGroupsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //groups that the user is a member of
    $sql = "SELECT * FROM groups g INNER JOIN group_members gm ON  g.group_ref_code = gm.group_ref_code WHERE gm.username = '$currentUser_Usrnm';"; //

    $groupMemsArray = array();
    $foundGroup = false;

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $foundGroup = true;

            $grps_groupid = $row["group_id"];
            $grps_refcode = $row["group_ref_code"];

            $grps_name = $row["group_name"];
            $grps_description = $row["group_description"];
            $grps_category = $row["group_category"];
            $grps_privacy = $row["group_privacy"];
            $grps_createdby = $row["created_by"];
            $grps_createdate = $row["creation_date"];

            $profileUserSubsGroupsList .= '
            <!-- Group Card -->
            <div class="grid-tile">
                <div class="px-2 mx-0 content-panel-border-style my-4 tunnel-bg-container"
                style="overflow: hidden; border-radius: 25px;" id="group-' . $grps_groupid . '-' . $grps_refcode . '">
                    <div class="row align-items-center top-down-grad-dark">
                        <div class="col-lg-4 text-center p-4 w-100">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="img-fluid" style="border-radius: 25px;"
                            alt="preview palceholder - delete">
                        </div>
                        <div class="col-lg -8 p-4 left-right-grad-tahiti-mineshaft" style="border-radius: 25px; color: #343434;">
                            <div class="row">
                                <div class="col-md text-dark">
                                <h3>' . $grps_name . ' <span style="font-size: 10px; color: #fff;">' . $grps_privacy . '</span></h3>
                                <p>' . $grps_category . '</p>

                                </div>
                                <div class="col-md text-white">
                                <p class="text-dark">' . $grps_description . '</p>
                                <p class="text-right mt-4" style="font-size: 8px;">' . $grps_createdate . '</p>
                                </div>
                            </div>
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font shadow my-4"
                                onclick="openGroup(' . "'" . $grps_refcode . "'" . ')">
                                Open group <i class="fas fa-chevron-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./ Group Card -->';

            //$groupMemsArray = $row;
        }
        /*echo $discoverGroupsList;
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo json_encode($groupMemsArray);
    die();*/

        $output = $profileUserSubsGroupsList;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Users groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserMedia()
{
    global $fileList, $profileUserMediaList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //users media items
    //Get a list of file paths using the glob function.
    $fileList = glob("../media/profiles/$currentUser_Usrnm/*");

    //Loop through the array that glob returned.
    foreach ($fileList as $filename) {
        //Simply print them out onto the screen.
        //echo $filename, '<br>'; 
        $profileUserMediaList .= '
      <div class="grid-tile p-0 mx-0 content-panel-border-style my-4 center-container" style="overflow: hidden; max-height: 200px;">
      <img src="' . $filename . '" class="img-fluid" alt="media image">
      </div>';
    }

    $output = $profileUserMediaList;

    return $output;
}
function getUserNotifications()
{
    global $notif_id, $notif_title, $notif_message, $notif_date, $communicationUserNotifications, $grps_category, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //notifications
    $sql = "SELECT * FROM notifications WHERE notify_user = '$currentUser_Usrnm' ORDER BY created_by DESC";

    if ($result = mysqli_query($dbconn, $sql)) {
        $communicationUserNotifications = '<div class="my-4 text-dark tunnel-bg-container"
        style="border-radius: 25px;">';
        while ($row = mysqli_fetch_assoc($result)) {
            //`notification_id`, `notification_title`, `notification_message`, `notify_user`, `created_by`, `notification_date`, `notification_read`

            $notif_id = $row["notification_id"];
            $notif_title = $row["notification_title"];
            $notif_message = $row["notification_message"];
            $notif_date = $row["notification_date"];

            $communicationUserNotifications .= '
            <a href="#" class="list-group-item list-group-item-action text-dark" aria-current="true" id="notifcation-' . $notif_id . '" style="border-radius: 25px !important;">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 fw-bold text-truncate">' . $notif_title . '</h5>
                    <small class="text-end">' . $notif_date . ' (# days ago)</small>
                </div>
                <p class="mb-1" style="max-height: 100px;">' . $notif_message . '</p>
                <small>' . $grps_category . '</small>
            </a>';
        }
        $communicationUserNotifications .= '</div>';

        $output = $communicationUserNotifications;
    } else {
        $output_msg = "|[System Error]|:. [Communications load (User notifications) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2 d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserPref()
{
    global $output;
    $output = "Loading...";
    return $output;
}
function getUserProgSubs()
{
    global $programs_progid, $programs_refcode, $programs_title, $programs_description, $programs_duration, $programs_category, $programs_privacy, $programs_creator, $programs_active, $profileUsersProgramsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //subscriptions (programs)
    //$sql = "SELECT * FROM training_programs;";
    $sql = "SELECT ps.prog_subscriber_id, ps.username, ps.program_ref_code, ps.subscribe_date, tp.program_id, tp.program_title, tp.program_description, tp.program_duration, tp.program_category, tp.program_privacy, tp.created_by, tp.active 
  FROM program_subscribers ps 
  INNER JOIN training_programs tp ON ps.program_ref_code = tp.program_ref_code 
  WHERE username = '$currentUser_Usrnm'";

    //TP: `program_id`, `program_ref_code`, `program_title`, `program_description`, `program_duration`, `program_category`, `program_privacy`, `created_by`, `creation_date`, `active` 
    //PA: `prog_activity_id`, `activity_title`, `activity_description`, `activity_duration`, `activity_reps`, `activity_sets`, `achievement_id`, `program_ref_code`

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {

            $programs_progid = $row["program_id"];
            $programs_refcode = $row["program_ref_code"];
            $programs_title = $row["program_title"];
            $programs_description = $row["program_description"];
            $programs_duration = $row["program_duration"];
            $programs_category = $row["program_category"];
            $programs_privacy = $row["program_privacy"];
            $programs_creator = $row["created_by"];
            $programs_active = $row["active"];

            /*$programs_activityid = $row["prog_activity_id"];
            $programs_activitytitle = $row["activity_title"];
            $programs_activityduration = $row["activity_duration"];*/

            $profileUsersProgramsList .= '
            <div class="p-0 mx-0 my-4 tunnel-bg-container" style="border-radius: 25px;" id="discover_programs-' . $programs_progid . '-' . $programs_refcode . '">
                <div class="card content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaft"
                    style="border-right: 0 !important;">
                    <div class="card-body">
                        <img src="../media/profiles/system_tmp/photo-1517838277536-f5f99be501cd.jpg" alt="palceholder" class="img-fluid shadow d-none d-lg-block w-100" style="border-radius: 25px;">
                        <div class="row align-items-center">
                            <div class="col-md py-4">
                                <h3 class="card-title text-truncate">' . $programs_title . ' <span
                                    style="font-size: 10px">(' . $programs_privacy . ')</span>
                                </h3>
                                <p class="card-subtitle ">Head Trainer: @' . $programs_creator . '</p>
                                <p class="card-text">' . $programs_description . '</p>
                            </div>
                            <div class="col-md-8 text-center d-lg-none">
                                <img src="../media/profiles/system_tmp/photo-1517838277536-f5f99be501cd.jpg" alt="palceholder"
                                class="img-fluid shadow" style="border-radius: 25px; max-height: 30vh;">
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow"
                            onclick="openProgram(' . "'" . $programs_refcode . "'" . ')">
                            View Program <i class="fas fa-chevron-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>';
        }

        $output = $profileUsersProgramsList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserResources()
{
    global $usrresources_resourceid, $usrresources_title, $usrresources_description, $usrresources_type, $usrresources_link, $usrresources_sharedate, $usrresources_sharename, $usrresources_sharesurname, $profileUsersResourcesList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //community and resource shares (latest 50 posts each)
    $sql = "SELECT * FROM community_resources cr INNER JOIN users u ON cr.shared_by = u.username WHERE cr.shared_by = '$currentUser_Usrnm';";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //`comm_resource_id`, `resource_title`, `resource_description`, `resource_type`, `resource_link`, `shared_by`, `share_date`
            $usrresources_resourceid = $row["comm_resource_id"];
            $usrresources_title = $row["resource_title"];
            $usrresources_description = $row["resource_description"];
            $usrresources_type = $row["resource_type"];
            $usrresources_link = $row["resource_link"];
            $usrresources_sharedate = $row["share_date"];

            $usrresources_sharename = $row["user_name"];
            $usrresources_sharesurname = $row["user_surname"];

            if ($usrresources_type == "external link") {
                $openlinkbtn = '<button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button" onclick="openExtLink(' . "'" . $usrresources_link . "'" . ')"><i class="fas fa-link"></i> Follow link</button>';
            } else if ($usrresources_type == "profile link") {
                $openlinkbtn = '<button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'profile'" . ')"><i class="fas fa-id-badge"></i> View profile</button>';
            } else if ($usrresources_type == "post link") {
                $openlinkbtn = '<button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'post'" . ')"><i class="fas fa-sticky-note"></i> Open post</button>';
            } else if ($usrresources_type == "document link") {
                $openlinkbtn = '<button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'document'" . ')"><i class="fas fa-file-alt"></i> View document</button>';
            } else if ($usrresources_type == "media link") {
                $openlinkbtn = '<button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'media'" . ')"><i class="fas fa-photo-video"></i> View media</button>';
            }

            $profileUsersResourcesList .= '
            <!-- User Resources - Tile -->
            <div class="grid-tile">
                <div class="p-0 mx-0 my-4 tunnel-bg-container" style="border-radius: 25px;"
                id="resource-' . $usrresources_resourceid . '-' . $currentUser_Usrnm . '" style="max-width: 100%!important">
                <div class="content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaft p-4">
                    <h3 class=" text-truncate">' . $usrresources_title . ' <span
                        style="font-size: 10px">' . $usrresources_type . '</span></h3>
                    <p><span style="color: #ffa500">' . $usrresources_description . '</span></p>
                    <p><i class="fas fa-link"></i> | ' . $usrresources_link . '</p>
                    <p>Shared by: @' . $usrresources_type . '</p>

                    ' . $openlinkbtn . '
                    <button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button"
                    onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'media'" . ')">
                    View media <i class="fas fa-photo-video"></i>
                    </button>

                    <p class="text-right" style="font-size: 8px">' . $usrresources_sharedate . '</p>
                </div>
                </div>
            </div>
            <!-- User Resources - Tile -->';
        }

        $output = $profileUsersResourcesList;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Users posts) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserSaves()
{
    global $fave_id, $fave_ref, $fave_date, $post_id, $post_date, $post_msg, $mod_date, $poster_name, $poster_surname, $poster_username, $profileUsersFavesList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //Favourites
    $sql = "SELECT * FROM ((fave_saves fs
    INNER JOIN users u ON fs.username = u.username) 
    INNER JOIN community_posts cp ON fs.fave_ref = cp.favourite_ref)
    WHERE fs.username = '$currentUser_Usrnm';";

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $fave_id = $row['fave_id'];
            $fave_ref = $row['fave_ref'];
            $fave_date = $row['fave_date'];
            $post_id = $row['post_id'];
            $post_date = $row['post_date'];
            $post_msg = $row['post_message'];
            $mod_date = $row['modified_date'];

            $poster_name = $row['user_name'];
            $poster_surname = $row['user_surname'];
            $poster_username = $row['username'];

            $profileUsersFavesList .= '
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4 down-top-grad-tahiti" id="fave-' . $fave_id . '">
                <div class="row align-items-center p-2">
                    <div class="col-md-4 text-center">
                        <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
                    </div>
                    <div class="col-md-8">
                        <h3>' . $poster_name . ' ' . $poster_surname . ' <span style="font-size: 10px">@<span style="color: #ffa500">' . $poster_username . '</span></span></h3>
                    </div>
                </div>
                <div class="post-content">
                    <hr class="bg-white">

                    <p class="my-2">' . $post_msg . '</p>
                    <p class="text-right" style="font-size: 8px">' . $post_date . '</p>

                    <!--function buttons-->
                    <ul class="list-group list-group-horizontal my-4 no-scroller">
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $post_id . ', ' . "'$currentUser_Usrnm'" . ', ' . "'like'" . ', ' . "'user_faves'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    favorite
                                </span>
                                <span class="d-none d-lg-block">
                                    Like
                                </span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $post_id . ', ' . "'$currentUser_Usrnm'" . ', ' . "'comment'" . ', ' . "'user_faves'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    insert_comment
                                </span>
                                <span class="d-none d-lg-block">
                                    Comment
                                </span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $post_id . ', ' . "'$currentUser_Usrnm'" . ', ' . "'share'" . ', ' . "'user_faves'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    share
                                </span>
                                <span class="d-none d-lg-block">Share</span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $post_id . ', ' . "'$currentUser_Usrnm'" . ', ' . "'save'" . ', ' . "'user_faves'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    remove_circle_outline
                                </span>
                                <span class="d-none d-lg-block">Remove</span>
                            </button>
                        </li>
                    </ul>
                    <!-- ./ function buttons -->
                </div>
            </div>';
        }

        $output = $profileUsersFavesList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';

        $output = $app_err_msg;
    }

    return $output;
}
function getUserSocials()
{
    global $usr_socialnet, $usr_socialhandle, $usr_sociallink, $socialNetworkIcon, $socialItems, $userSocialItemsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //get the social details
    $sql = "SELECT social_network, handle, link FROM user_socials WHERE username = '$currentUser_Usrnm'";

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            //u.user_id, u.username, u.user_name, u.user_surname, u.id_number, u.user_email, u.contact_number, u.date_of_birth, u.user_gender, u.user_race, u.user_nationality, u.account_active
            $usr_socialnet = $row["social_network"];
            $usr_socialhandle = $row["handle"];
            $usr_sociallink = $row["link"];

            if ($usr_socialnet == "facebook") {
                $socialNetworkIcon = '<i class="fab fa-facebook"></i>';
            } else if ($usr_socialnet == "twitter") {
                $socialNetworkIcon = '<i class="fab fa-twitter"></i>';
            } else if ($usr_socialnet == "instagram") {
                $socialNetworkIcon = '<i class="fab fa-instagram"></i>';
            } else if ($usr_socialnet == "tumbler") {
                $socialNetworkIcon = '<i class="fab fa-tumblr"></i>';
            } else if ($usr_socialnet == "whatsapp") {
                $socialNetworkIcon = '<i class="fab fa-whatsapp"></i>';
            } else if ($usr_socialnet == "reddit") {
                $socialNetworkIcon = '<i class="fab fa-reddit"></i>';
            } else {
                $socialNetworkIcon = '<i class="fas fa-globe-africa"></i>';
            }

            $socialItems .= '<li class="list-group-item text-center text-dark bg-transparent rounded-pill shadow my-2 mx-1 p-4 social-link flex-fill user-social-strip"><span class="p-2 mr-2 bg-warningz" style="border-radius: 5px">' . $socialNetworkIcon . '</span> | <a href="' . $usr_sociallink . '">' . $usr_socialhandle . '</a></li>';

            $socialItems .= '';
        }
        //echo $discoverPeopleList;
        //die();

        $userSocialItemsList = <<<_END
    <ul class="list-group list-group-horizontal-md justify-content-center p-2 shadow" style="border-radius: 25px; background: #333">$socialItems</ul>
    _END;

        $output = $userSocialItemsList;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Social details) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        $output = $app_err_msg;
        //exit();
    }

    return $output;
}
function getUserUpdates()
{
    global $usrposts_postid, $usrposts_postdate, $usrposts_message, $usrposts_user, $usrposts_faveref, $currentUserAccountProdImg, $usrposts_name, $usrposts_surname, $profileUsersPostsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    $sql = "SELECT * FROM community_posts cp 
    INNER JOIN users u ON cp.username = u.username 
    INNER JOIN user_profiles up ON u.username = up.username
    WHERE cp.username = '$currentUser_Usrnm';";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //`post_id`, `post_date`, `post_message`, `username`, `modified_date`, `favourite_ref`FROM `community_posts` WHERE 
            $usrposts_postid = $row["post_id"];
            $usrposts_postdate = $row["post_date"];
            $usrposts_message = $row["post_message"];
            $usrposts_user = $row["username"];
            $usrposts_faveref = $row["favourite_ref"];

            $usrposts_name = $row["user_name"];
            $usrposts_surname = $row["user_surname"];

            $usrposts_profilepicurl = $row["profile_url"];
            $usrposts_verification = $row["verification"];

            //calc post date
            /* $date1 = $row["post_date"]; //date('Y-m-d', $usrposts_postdate); //date_create("2013-03-15");
            $date2 = date_create("2013-12-12");
            $diff = date_diff($date1, $date2);
            echo $diff->format("%a days"); */

            // verification icon
            if ($usrposts_verification == "verified") {
                $usrposts_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $usrposts_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            // start date 
            $start_date = $usrposts_postdate;

            // end date 
            $current_datetime = new DateTime(date('Y-m-d H:i:s'));
            $end_date = $current_datetime->format('Y-m-d H:i:s');

            // call dateDifference() function to find the number of days between two dates
            $dateDiff = dateDifference($start_date, $end_date);

            //echo "Difference between two dates: " . $dateDiff . " Days ";

            $profileUsersPostsList .= '
            <!-- Social Update Card -->
            <div class="my-4 p-0 social-update-card shadow-lg" style="border-bottom: #ffa500 solid 5px;"
            id="post-' . $usrposts_postid . '-' . $usrposts_user . '">
            <div class="row align-items-center px-4 py-4 m-0 down-top-grad-darkz" style="border-radius: 25px!important;">
                <div class="col-md-4  text-center">
                    ' . $currentUserAccountProdImg . '
                </div>
                <div class="col-md-8 text-end">
                    <div class="d-grid gap-4 p-2" style="border-radius: 15px!important; background-color: rgba(52, 52, 52, 0.8) !important;">
                        <h3 class="text-truncate">' . $usrposts_name . ' ' . $usrposts_surname . ' ' . $usrposts_verification_output . '</h3>
                        <span style="font-size: 10px">@<span style="color: #ffa500">' . $usrposts_user . '</span>
                    </div>
                </div>
            </div>
            <div class="post-content px-4 px-0 fs-4 text-break down-top-grad-dark" style="border-radius: 25px!important;">
                <hr class="bg-white">
                <div>
                    <p class="my-2 text-break">' . $usrposts_message . '</p>
                </div>
                <div class="row align-items-center">
                    <div class="col-md text-center">
                        <hr class="bg-white">
                    </div>
                    <div class="col-md-3 text-center">
                        <p class="text-right p-3 rounded-pill bg-white text-dark m-0" style="font-size: 10px">' . $dateDiff . ' days ago <!--(' . $usrposts_postdate . ')-->
                        </p>
                    </div>
                </div>

                <!--function buttons-->
                <ul class="list-group list-group-horizontal -sm my-4 no-scroller" style="overflow-x: auto;">
                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
                        onclick="socialFunctions(' . $usrposts_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'like'" . ', ' . "'user_profile'" . ')">
                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                favorite
                            </span>
                            <span class="d-none d-lg-block">Like</span>
                        </button>
                    </li>
                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
                        onclick="socialFunctions(' . $usrposts_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'comment'" . ', ' . "'user_profile'" . ')">
                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                insert_comment
                            </span>
                            <span class="d-none d-lg-block">
                                Comment
                            </span>
                        </button>
                    </li>
                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
                        onclick="socialFunctions(' . $usrposts_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'share'" . ', ' . "'user_profile'" . ')">
                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                share
                            </span>
                            <span class="d-none d-lg-block">Share</span>
                        </button>
                    </li>
                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
                        onclick="socialFunctions(' . $usrposts_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'save'" . ', ' . "'user_profile'" . ')">
                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                bookmarks
                            </span>
                            <span class="d-none d-lg-block">Save</span>
                        </button>
                    </li>
                </ul>
            </div>
            </div>
            <!-- ./ Social Update Card -->';
        }

        $output = $profileUsersPostsList;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Users posts) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}

//Content Load Functions - Community Content
function getCommunityGroups()
{
    global $dbconn, $grps_groupid, $grps_refcode, $grps_name, $grps_description, $grps_category, $grps_privacy, $grps_createdby, $grps_createdate, $discoverGroupsList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg, $usr_profilepicurl;

    //groups
    $sql = "SELECT * FROM groups";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //`group_id`, `group_ref_code`, `group_name`, `group_description`, `group_category`, `group_privacy`, `created_by`, `creation_date`

            $grps_groupid = $row["group_id"];
            $grps_refcode = $row["group_ref_code"];
            $grps_name = $row["group_name"];
            $grps_description = $row["group_description"];
            $grps_category = $row["group_category"];
            $grps_privacy = $row["group_privacy"];
            $grps_createdby = $row["created_by"];
            $grps_createdate = $row["creation_date"];

            $discoverGroupsList .= '
            <!-- Group Card -->
            <div class="grid-tile">
                <div class="px-2 mx-0 content-panel-border-style my-4 tunnel-bg-container"
                style="overflow: hidden; border-radius: 25px;" id="group-' . $grps_groupid . '-' . $grps_refcode . '">
                <div class="row align-items-center top-down-grad-dark">
                    <div class="col-lg-4 text-center p-4 w-100">
                    <img src="../media/profiles/' . $currentUser_Usrnm . '/' . $usr_profilepicurl . '" class="img-fluid"
                        style="border-radius: 25px;" alt="prof thumbnail">

                    <!--<img src="../media/assets/OnefitNet Profile Pic Redone.png" class="img-fluid" style="border-radius: 25px;"
                        alt="preview palceholder - delete">

                    <div class="group-card-profile-pic shadow" hidden>
                    </div>-->
                    </div>
                    <div class="col-lg -8 p-4 left-right-grad-tahiti-mineshaft" style="border-radius: 25px; color: #343434;">
                    <div class="row">
                        <div class="col-md text-dark">
                        <h3>' . $grps_name . ' <span style="font-size: 10px; color: #fff;">' . $grps_privacy . '</span></h3>
                        <p>' . $grps_category . '</p>

                        </div>
                        <div class="col-md text-white">
                        <p class="text-dark">' . $grps_description . '</p>
                        <p class="text-right mt-4" style="font-size: 8px;">' . $grps_createdate . '</p>
                        </div>
                    </div>
                    <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font shadow my-4"
                        onclick="openGroup(' . "'" . $grps_refcode . "'" . ')">
                        Open group <i class="fas fa-chevron-circle-right"></i>
                    </button>
                    </div>
                </div>
                </div>
            </div>
            <!-- ./ Group Card -->';
        }
        //echo $discoverPeopleList;
        //die();

        $output = $discoverGroupsList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getCommunityNews()
{
    global $dbconn, $news_id, $news_title, $news_content, $news_createdby, $news_date, $news_poster_name, $news_poster_surname, $communicationNews, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //news
    $sql = "SELECT * FROM news n INNER JOIN users u ON n.created_by = u.username ORDER BY n.creation_date DESC";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //`article_id`, `article_title`, `content`, `created_by`, `creation_date`

            $news_id = $row["article_id"];
            $news_title = $row["article_title"];
            $news_content = $row["content"];
            $news_createdby = $row["created_by"];
            $news_date = $row["creation_date"];

            $news_poster_name = $row["user_name"];
            $news_poster_surname = $row["user_surname"];

            $communicationNews .= '
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="news-' . $news_id . '">
                <h3>' . $news_title . ' <span style="font-size: 10px">By ' . $news_poster_name . ' ' . $news_poster_surname . ' (@' . $news_createdby . ')</span></h3>
                <p><span style="color: #ffa500">' . $news_content . '</span></p>
                <p class="text-right" style="font-size: 8px">' . $news_date . '</p>
            </div>
            ';
        }

        $output = $communicationNews;
    } else {
        $output_msg = "|[System Error]|:. [Communications load (User notifications) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2 d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getCommunityResources()
{
    global $dbconn, $resourceid, $resource_title, $resource_descr, $resource_type, $resource_link, $sharedbyUsername, $sharedate, $openlinkbtn, $outputCommunityResources, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //fitness resources (latest 50 resources)
    $sql = "SELECT * FROM community_resources";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //`resource_title`, `resource_description`, `resource_type`, `resource_link`, `shared_by`, `share_date`
            $resourceid = $row["comm_resource_id"];
            $resource_title = $row["resource_title"];
            $resource_descr = $row["resource_description"];
            $resource_type = $row["resource_type"];
            $resource_link = $row["resource_link"];
            $sharedbyUsername = $row["shared_by"];
            $sharedate = $row["share_date"];

            if ($resource_type == "external link") {
                $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openExtLink(' . "'" . $resource_link . "'" . ')"><i class="fas fa-link"></i> Follow link</button>';
            } else if ($resource_type == "profile link") {
                $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $resource_link . "'" . ', ' . "'profile'" . ')"><i class="fas fa-id-badge"></i> View profile</button>';
            } else if ($resource_type == "post link") {
                $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $resource_link . "'" . ', ' . "'post'" . ')"><i class="fas fa-sticky-note"></i> Open post</button>';
            } else if ($resource_type == "document link") {
                $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $resource_link . "'" . ', ' . "'document'" . ')"><i class="fas fa-file-alt"></i> View document</button>';
            } else if ($resource_type == "media link") {
                $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $resource_link . "'" . ', ' . "'media'" . ')"><i class="fas fa-photo-video"></i> View media</button>';
            }

            $outputCommunityResources .= '
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="resource-' . $resourceid . '-' . $sharedbyUsername . '">
                <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
                </div>
                <div class="col-md-8">
                    <h3>' . $resource_title . ' <span style="font-size: 10px">' . $resource_type . '</span></h3>
                    <p><span style="color: #ffa500">' . $resource_descr . '</span></p>
                    <p><i class="fas fa-link"></i> | ' . $resource_link . '</p>
                    <p>Shared by: @' . $sharedbyUsername . '</p>

                    ' . $openlinkbtn . '

                    <p class="text-right" style="font-size: 8px;">' . $sharedate . '</p>
                </div>
                </div>
            </div>';
        }
        //$discoverResourcesList = $homeCommunityResources;
        $output = $outputCommunityResources;
    } else {
        $output_msg = "|[System Error]|:. [Home load (Community resources) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getCommunityUpdates()
{
    global $dbconn, $commpost_postid, $commpost_postdate, $commpost_message, $commpost_user, $commpost_faveref, $commpost_usr_name, $commpost_usr_surname, $communityPosts, $currentUserAccountProdImg, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //local
    $commpost_img_url = "";
    $commpostUserAccountProdImg = "";
    $commpostusr_profilepicurl = "";
    $commpostusr_verification = "";

    //community posts (latest 50 posts)
    $sql = "SELECT * FROM community_posts cp 
    INNER JOIN users u ON cp.username = u.username
    INNER JOIN user_profiles up ON u.username = up.username;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //`post_id`, `post_date`, `post_message`, `username`, `modified_date`, `favourite_ref`FROM `community_posts` WHERE 
            $commpost_postid = $row["post_id"];
            $commpost_postdate = $row["post_date"];
            $commpost_message = $row["post_message"];
            $commpost_username = $row["username"];
            $commpost_faveref = $row["favourite_ref"];
            $commpost_usr_name = $row["user_name"];
            $commpost_usr_surname = $row["user_surname"];

            $commpostusr_profilepicurl = $row["profile_url"];
            $commpostusr_verification = $row["verification"];

            // start date 
            $start_date = $commpost_postdate;

            // end date 
            $current_datetime = new DateTime(date('Y-m-d H:i:s'));
            $end_date = $current_datetime->format('Y-m-d H:i:s');

            // call dateDifference() function to find the number of days between two dates
            $dateDiff = dateDifference($start_date, $end_date);

            //echo "Difference between two dates: " . $dateDiff . " Days ";

            // verification icon
            if ($commpostusr_verification == "verified") {
                $commpostusr_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $commpostusr_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            //profile picture
            if ($commpostusr_profilepicurl == "default" || $commpostusr_profilepicurl == null || $commpostusr_profilepicurl == "") {
                $commpost_img_url = "'../media/profiles/0_default/default_profile_pic.png'";
            } else {
                $commpost_img_url = "'../media/profiles/$commpost_username/$commpostusr_profilepicurl'";
            }

            $commpostUserAccountProdImg = '<div class="social-update-profile-pic shadow" style="background-position: center !important; background-size: cover !important; background-repeat: no-repeat !important; background-attachment: local !important; height: 150px !important; width:  150px !important; background: url(' . $commpost_img_url . ') !important;"></div>';


            $communityPosts .= '
            <!-- Community Update Card -->
            <div class="px-2 mx-0 my-4 social-update-card" style="border-bottom: #ffa500 solid 5px;" id="post-' . $commpost_postid . '-' . $commpost_username . '">
                <div class="row align-items-center px-4 py-4 m-0" style="border-radius: 25px!important;">
                    <div class="col-md-4 text-center">
                    ' . $commpostUserAccountProdImg . '
                    </div>
                    <div class="col-md-8 text-end">
                    <div class="d-grid gap-4 p-2" style="border-radius: 15px!important; background-color: rgba(52, 52, 52, 0.8) !important;">
                        <h3 class="text-truncate">' . $commpost_usr_name . ' ' . $commpost_usr_surname . ' ' . $commpostusr_verification_output . '</h3>
                        <span style="font-size: 10px">@<span style="color: #ffa500">' . $commpost_username . '</span></span>
                    </div>
                    </div>
                </div>
                <div class="post-content">
                    <hr class="bg-white">
                    <div>
                    <p class="m-4 text-break">' . $commpost_message . '</p>
                    </div>
                    <div class="row align-items-center">
                    <div class="col-md text-center">
                        <hr class="bg-white">
                    </div>
                    <div class="col-md-3 text-center">
                        <p class="text-right p-3 rounded-pill bg-white text-dark m-0" style="font-size: 10px">' . $dateDiff . ' days ago <!--(' . $commpost_postdate . ')-->
                        </p>
                    </div>
                    </div>

                    <!-- function buttons -->
                    <ul class="list-group list-group-horizontal my-4 no-scroller">
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $commpost_postid . ', ' . "'$commpost_username'" . ', ' . "'like'" . ', ' . "'community_posts'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    favorite
                                </span>
                                <span class="d-none d-lg-block">
                                    Like
                                </span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $commpost_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'comment'" . ', ' . "'community_posts'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    insert_comment
                                </span>
                                <span class="d-none d-lg-block">
                                    Comment
                                </span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $commpost_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'share'" . ', ' . "'community_posts'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    share
                                </span>
                                <span class="d-none d-lg-block">Share</span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $commpost_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'save'" . ', ' . "'community_posts'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    bookmarks
                                </span>
                                <span class="d-none d-lg-block">Save</span>
                            </button>
                        </li>
                    </ul>
                    <!-- ./ function buttons -->
                </div>
            </div>
            <!-- Community Update Card -->';
        }

        $output = $communityPosts;
    } else {
        $output_msg = "|[System Error]|:. [Home load (Community posts) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}

//Content Load Functions - Discovery Specific Content
function getAllUsers()
{
    global $dbconn, $usrs_userid, $usrs_username, $usrs_name, $usrs_surname, $usrs_idnumber, $usrs_email, $usrs_contact, $usrs_dob, $usrs_gender, $usrs_race, $usrs_nationality, $usrs_acc_active, $usrs_prof_acctype, $discoverPeopleList, $activitiesTraineesList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg, $usr_profileid, $usr_about, $usr_profiletype, $usr_profilepicurl, $usr_verification;

    $allusrs_userid = null;
    $allusrs_username = $allusrs_name = $allusrs_surname = $allusrs_idnumber = $allusrs_email = $allusrs_contact = $allusrs_dob = $allusrs_gender = $allusrs_race = $allusrs_nationality = "";
    $allusrs_acc_active = false;
    $allusrs_prof_acctype = "Community";
    $allusrs_profileid = null;
    $allusrs_about = $allusrs_profilepicurl =  $allusrs_verification =  $allusrs_verification_output = $allusers_account_prod_img = $allusers_img_url = "";

    $users_exist = false;

    //loading: Discover (load max of 50 records)
    //People
    $sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $users_exist = true;
            $allusrs_userid = $row["user_id"];
            $allusrs_username = $row["username"];
            $allusrs_name = $row["user_name"];
            $allusrs_surname = $row["user_surname"];
            $allusrs_idnumber = $row["id_number"];
            $allusrs_email = $row["user_email"];
            $allusrs_contact = $row["contact_number"];
            $allusrs_dob = $row["date_of_birth"];
            $allusrs_gender = $row["user_gender"];
            $allusrs_race = $row["user_race"];
            $allusrs_nationality = $row["user_nationality"];
            $allusrs_acc_active = $row["account_active"];

            $allusrs_profileid = $row["user_profile_id"];
            $allusrs_about = $row["about"];
            $allusrs_prof_acctype = $row["profile_type"];
            $allusrs_profilepicurl = $row["profile_url"];
            $allusrs_verification = $row["verification"];

            // verification icon
            if ($allusrs_verification == "verified") {
                $allusrs_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $allusrs_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            //profile picture
            if ($allusrs_profilepicurl == "default" || $allusrs_profilepicurl == null || $allusrs_profilepicurl == "") {
                $allusers_img_url = "../media/profiles/0_default/default_profile_pic.png";
            } else {
                $allusers_img_url = "../media/profiles/$allusrs_username/$allusrs_profilepicurl";
            }

            $allusers_account_prod_img = '<div class="social-update-profile-pic shadow" style="background-position: center !important; background-size: cover !important; background-repeat: no-repeat !important; background-attachment: local !important; height: 150px !important; width:  150px !important; background: url(' . $allusers_img_url . ') !important;"></div>';


            $discoverPeopleList .= '
            <!-- All Users Card - dark Grad -->
            <div class="grid-tile">
              <div class="my-4 container-fluid tunnel-bg-container" id="discover_trainee-' . $allusrs_userid . '-' . $allusrs_username . '"
                style="border-radius: 25px;">
                <div class="top-down-grad-light" style="border-radius: 25px;">
                  <div
                    class="row align-items-center content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaftz left-right-grad-mineshaft">
                    <div class="col-xlg-2 text-center p-4">
                      <img src="' . $allusers_img_url . '" class="img-fluid rounded-circle shadow" style="border-radius: 25px;" alt="prof thumbnail" hidden>
                      ' . $allusers_account_prod_img . '
                    </div>
                    <div class="col-xlg-6 text-center p-4">
                      <h3 class="text-white">' . $allusrs_name . ' ' . $allusrs_surname . '</h3>
                      <p style="font-size: 10px">@' . $allusrs_username . '</p>
                      <p style="font-size: 10px">Level.: 1</p>
                      ' . $allusrs_verification_output . '
                    </div>
                    <div class="col-xlg-4 text-center p-4">
                      <button class="onefit-buttons-style-light p-4 my-4 shadow" onclick="openProfiler(' . "'" . $allusrs_username . "'" . ')">
                            View profile <i class=" fas fa-chevron-circle-right"></i>
                      </button>
                    </div>
                  </div>
                </div>
          
              </div>
            </div>
            <!-- ./ All Users Card - dark Grad -->';
        }
        //echo $discoverPeopleList;
        //die();

        /* <div class="grid-tile px-2 mx-0 container content-panel-border-style my-4" id="discover_people-' . $allusrs_userid . '-' . $allusrs_username . '">
                <div class="card bg-transparent align-items-center">
                <div class="text-center">
                    <!--<img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">-->
                    ' . $allusers_account_prod_img . '
                </div>
                <div class="card-body">
                    <h3>' . $allusrs_name . ' ' . $allusrs_surname . '</h3>
                    <p>@<span style="color: #ffa500">' . $allusrs_username . '</span></p>
                    <div class="text-center">
                    <button class="null-btn m-4 shadow" onclick="openProfiler(' . "'" . $allusrs_username . "'" . ')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
                    </div>
                </div>
                </div>
            </div> */

        if ($users_exist == true) {
            $output = $discoverPeopleList;
        } else {
            $output = <<<_END
            <div class="text-center" style="padding: 100px 10px;">
                No users available
            </div>
            _END;
        }
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All People) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getFitProgramsIndi()
{
    global $dbconn, $indi_programs_progid, $indi_programs_refcode, $indi_programs_title, $indi_programs_description, $indi_programs_duration, $indi_programs_category, $indi_programs_privacy, $indi_programs_creator, $indi_programs_active, $discoverIndiProgramsList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //Programs
    //$sql = "SELECT * FROM training_programs tp INNER JOIN program_activities pa ON tp.program_ref_code = pa.program_ref_code;";
    $sql = "SELECT * FROM training_programs;";

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            //TP: `program_id`, `program_ref_code`, `program_title`, `program_description`, `program_duration`, `program_category`, `program_privacy`, `created_by`, `creation_date`, `active` 
            //PA: `prog_activity_id`, `activity_title`, `activity_description`, `activity_duration`, `activity_reps`, `activity_sets`, `achievement_id`, `program_ref_code`
            $indi_programs_progid = $row["program_id"];
            $indi_programs_refcode = $row["program_ref_code"];
            $indi_programs_title = $row["program_title"];
            $indi_programs_description = $row["program_description"];
            $indi_programs_duration = $row["program_duration"];
            $indi_programs_category = $row["program_category"];
            $indi_programs_privacy = $row["program_privacy"];
            $indi_programs_creator = $row["created_by"];
            $indi_programs_active = $row["active"];

            /*$programs_activityid = $row["prog_activity_id"];
            $programs_activitytitle = $row["activity_title"];
            $programs_activityduration = $row["activity_duration"];*/

            $discoverIndiProgramsList .= '
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="discover_programs-' . $indi_programs_progid . '-' . $indi_programs_refcode . '">
                <div class="card bg-transparent">
                    <div class="card-body">
                        <h3 class="card-title">' . $indi_programs_title . ' <span style="font-size: 10px">(' . $indi_programs_privacy . ')</span></h3>
                        <p class="card-subtitle ">Trainer: @' . $indi_programs_creator . '</p>
                        <p class="card-text">' . $indi_programs_description . '</p>
                        <div class="text-center">
                        <button class="null-btn m-4 shadow" onclick="openProgram(' . "'" . $indi_programs_refcode . "'" . ')"><i class="fas fa-chevron-circle-right"></i> View program</button>
                        </div>
                    </div>
                </div>
            </div>';
        }

        $output = $discoverIndiProgramsList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getFitProgramsTeams()
{
    global $dbconn, $team_programs_progid, $team_programs_refcode, $team_programs_title, $team_programs_description, $team_programs_duration, $team_programs_category, $team_programs_privacy, $team_programs_creator, $team_programs_active, $discoverTeamProgramsList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //Programs
    //$sql = "SELECT * FROM training_programs tp INNER JOIN program_activities pa ON tp.program_ref_code = pa.program_ref_code;";
    $sql = "SELECT * FROM training_programs;";

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            //TP: `program_id`, `program_ref_code`, `program_title`, `program_description`, `program_duration`, `program_category`, `program_privacy`, `created_by`, `creation_date`, `active` 
            //PA: `prog_activity_id`, `activity_title`, `activity_description`, `activity_duration`, `activity_reps`, `activity_sets`, `achievement_id`, `program_ref_code`
            $team_programs_progid = $row["program_id"];
            $team_programs_refcode = $row["program_ref_code"];
            $team_programs_title = $row["program_title"];
            $team_programs_description = $row["program_description"];
            $team_programs_duration = $row["program_duration"];
            $team_programs_category = $row["program_category"];
            $team_programs_privacy = $row["program_privacy"];
            $team_programs_creator = $row["created_by"];
            $team_programs_active = $row["active"];

            /*$programs_activityid = $row["prog_activity_id"];
            $programs_activitytitle = $row["activity_title"];
            $programs_activityduration = $row["activity_duration"];*/

            $discoverTeamProgramsList .= '
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="discover_programs-' . $team_programs_progid . '-' . $team_programs_refcode . '">
                <div class="card bg-transparent">
                <div class="card-body">
                    <h3 class="card-title">' . $team_programs_title . ' <span style="font-size: 10px">(' . $team_programs_privacy . ')</span></h3>
                    <p class="card-subtitle ">Trainer: @' . $team_programs_creator . '</p>
                    <p class="card-text">' . $team_programs_description . '</p>
                    <div class="text-center">
                    <button class="null-btn m-4 shadow" onclick="openProgram(' . "'" . $team_programs_refcode . "'" . ')"><i class="fas fa-chevron-circle-right"></i> View program</button>
                    </div>
                </div>
                </div>
            </div>';
        }

        $output = $discoverTeamProgramsList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getAllTrainees()
{
    global $dbconn, $usrs_userid, $usrs_username, $usrs_name, $usrs_surname, $usrs_idnumber, $usrs_email, $usrs_contact, $usrs_dob, $usrs_gender, $usrs_race, $usrs_nationality, $usrs_acc_active, $activitiesTraineesList, $usrs_prof_acctype, $currentUser_Usrnm, $output, $output_msg, $app_err_msg, $usr_profileid, $usr_about, $usr_profiletype, $usr_profilepicurl, $usr_verification;

    $trainee_userid = null;
    $trainee_username = $trainee_name = $trainee_surname = $trainee_idnumber = $trainee_email = $trainee_contact = $trainee_dob = $trainee_gender = $trainee_race = $trainee_nationality = $trainee_acc_active = $trainee_prof_acctype = "";

    $trainee_profileid = null;
    $trainee_about = $trainee_profiletype = $trainee_profilepicurl = $trainee_verification = $trainee_verification_output = $trainee_img_url = $trainee_account_prod_img = "";

    //loading: Discover (load max of 50 records)
    //People
    $sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $trainee_userid = $row["user_id"];
            $trainee_username = $row["username"];
            $trainee_name = $row["user_name"];
            $trainee_surname = $row["user_surname"];
            $trainee_idnumber = $row["id_number"];
            $trainee_email = $row["user_email"];
            $trainee_contact = $row["contact_number"];
            $trainee_dob = $row["date_of_birth"];
            $trainee_gender = $row["user_gender"];
            $trainee_race = $row["user_race"];
            $trainee_nationality = $row["user_nationality"];
            $trainee_acc_active = $row["account_active"];

            $trainee_profileid = $row["user_profile_id"];
            $trainee_about = $row["about"];
            $trainee_prof_acctype = $row["profile_type"];
            $trainee_profilepicurl = $row["profile_url"];
            $trainee_verification = $row["verification"];

            // verification icon
            if ($trainee_verification == "verified") {
                $trainee_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $trainee_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            //profile picture
            if ($trainee_profilepicurl == "default" || $trainee_profilepicurl == null || $trainee_profilepicurl == "") {
                $trainee_img_url = "../media/profiles/0_default/default_profile_pic.png";
            } else {
                $trainee_img_url = "../media/profiles/$trainee_username/$trainee_profilepicurl";
            }

            $trainee_account_prod_img = '<div class="social-update-profile-pic shadow" style="background-position: center !important; background-size: cover !important; background-repeat: no-repeat !important; background-attachment: local !important; height: 150px !important; width:  150px !important; background: url(' . $trainee_img_url . ') !important;"></div>';

            //compile list of trainers
            if ($trainee_prof_acctype == "trainee") {
                $activitiesTraineesList .= '
                <!-- Trainees Card - dark Grad -->
                <div class="grid-tile">
                    <div class="my-4 container-fluid tunnel-bg-container" id="discover_trainee-' . $trainee_userid . '-' . $trainee_username . '" style="border-radius: 25px;">
                        <div class="top-down-grad-light" style="border-radius: 25px;">
                            <div class="row align-items-center content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaftz left-right-grad-mineshaft">
                                <div class="col-xlg-2 text-center p-4">
                                    <img src="' . $trainee_img_url . '" class="img-fluid rounded-circle shadow" style="border-radius: 25px;" alt="prof thumbnail" hidden>
                                    ' . $trainee_account_prod_img . '
                                </div>
                                <div class="col-xlg-6 text-center p-4">
                                    <h3 class="text-white">' . $trainee_name . ' ' . $trainee_surname . '</h3>
                                    <p style="font-size: 10px">@' . $trainee_username . '</p>
                                    <p style="font-size: 10px">Level.: 1</p>
                                    ' . $trainee_verification_output . '
                                </div>
                                <div class="col-xlg-4 text-center p-4">
                                    <button class="onefit-buttons-style-light p-4 my-4 shadow" onclick="openProfiler(' . "'" . $usrs_username . "'" . ')">
                                        View profile <i class=" fas fa-chevron-circle-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./ Trainees Card - dark Grad -->';
            }
        }
        //echo $discoverPeopleList;
        //die();

        $output = $activitiesTraineesList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All People) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getAllTrainers()
{
    global $dbconn, $usrs_userid, $usrs_username, $usrs_name, $usrs_surname, $usrs_idnumber, $usrs_email, $usrs_contact, $usrs_dob, $usrs_gender, $usrs_race, $usrs_nationality, $usrs_acc_active, $activitiesTrainersList, $usrs_prof_acctype, $currentUser_Usrnm, $output, $output_msg, $app_err_msg, $usr_profileid, $usr_about, $usr_profiletype, $usr_profilepicurl, $usr_verification;

    $trainer_userid = null;
    $trainer_username = $trainer_name = $trainer_surname = $trainer_idnumber = $trainer_email = $trainer_contact = $trainer_dob = $trainer_gender = $trainer_race = $trainer_nationality = $trainer_acc_active = $trainer_prof_acctype = "";

    $trainer_profileid = null;
    $trainer_about = $trainer_profiletype = $trainer_profilepicurl = $trainer_verification = $trainer_img_url = $trainer_account_prod_img = "";

    //loading: Discover (load max of 50 records)
    //People
    $sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {

            $trainer_userid = $row["user_id"];
            $trainer_username = $row["username"];
            $trainer_name = $row["user_name"];
            $trainer_surname = $row["user_surname"];
            $trainer_idnumber = $row["id_number"];
            $trainer_email = $row["user_email"];
            $trainer_contact = $row["contact_number"];
            $trainer_dob = $row["date_of_birth"];
            $trainer_gender = $row["user_gender"];
            $trainer_race = $row["user_race"];
            $trainer_nationality = $row["user_nationality"];
            $trainer_acc_active = $row["account_active"];

            $trainer_profileid = $row["user_profile_id"];
            $trainer_about = $row["about"];
            $trainer_prof_acctype = $row["profile_type"];
            $trainer_profilepicurl = $row["profile_url"];
            $trainer_verification = $row["verification"];

            // verification icon
            if ($trainer_verification == "verified") {
                $trainer_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $trainer_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            //profile picture
            if ($trainer_profilepicurl == "default" || $trainer_profilepicurl == null || $trainer_profilepicurl == "") {
                $trainer_img_url = "../media/profiles/0_default/default_profile_pic.png";
            } else {
                $trainer_img_url = "../media/profiles/$trainer_username/$trainer_profilepicurl";
            }

            $trainer_account_prod_img = '<div class="social-update-profile-pic shadow" style="background-position: center !important; background-size: cover !important; background-repeat: no-repeat !important; background-attachment: local !important; height: 150px !important; width:  150px !important; background: url(' . $trainer_img_url . ') !important;"></div>';

            //compile list of trainers
            if ($trainer_prof_acctype == "trainer") {
                $activitiesTrainersList .= '
                <!-- All Trainers Card - dark Grad -->
                <div class="grid-tile">
                  <div class="my-4 container-fluid tunnel-bg-container" id="discover_trainer-' . $trainer_userid . '-' . $trainer_username . '"
                    style="border-radius: 25px;">
                    <div class="top-down-grad-light" style="border-radius: 25px;">
                      <div
                        class="row align-items-center content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaftz left-right-grad-mineshaft">
                        <div class="col-xlg-2 text-center p-4">
                          <img src="' . $trainer_img_url . '" class="img-fluid rounded-circle shadow" style="border-radius: 25px;" alt="prof thumbnail" hidden>
                          ' . $trainer_account_prod_img . '
                        </div>
                        <div class="col-xlg-6 text-center p-4">
                          <h3 class="text-white">' . $trainer_name . ' ' . $trainer_surname . '</h3>
                          <p style="font-size: 10px">@' . $trainer_username . '</p>
                          <p style="font-size: 10px">Level.: 1</p>
                          ' . $trainer_verification_output . '
                        </div>
                        <div class="col-xlg-4 text-center p-4">
                          <button class="onefit-buttons-style-light p-4 my-4 shadow" onclick="openProfiler(' . "'" . $trainer_username . "'" . ')">
                                View profile <i class=" fas fa-chevron-circle-right"></i>
                          </button>
                        </div>
                      </div>
                    </div>
              
                  </div>
                </div>
                <!-- ./ All Trainers Card - dark Grad -->';
            }
        }
        //echo $discoverPeopleList;
        //die();

        $output = $activitiesTrainersList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All People) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $usrprof_name . " " . $usrprof_surname; ?> - Onefit.app&trade; | Onefit.Net&reg; &copy; <?php echo date('Y'); ?></title>

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
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/digital-clock.css" />
    <link rel="stylesheet" href="../css/timeline-styles.css" />

    <!-- Site Scripts -->
    <script src="../scripts/js/script.js"></script>
    <script src="../scripts/js/api_requests.js"></script>

    <!-- ./ Site Scripts -->

    <!-- JQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- ./ JQuery CDN -->

    <!-- For Digital Clock Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script>
    <!-- ./ For Digital Clock Plugin -->

    <!-- Map Highlight -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/maphilight/1.4.0/jquery.maphilight.min.js"></script>
    <script src="../scripts/js/mapoid/mapoid.js"></script> -->
    <!-- ./ Map Highlight -->

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128&display=swap" rel="stylesheet">

    <!-- Soccer field -->
    <link rel="stylesheet" href="../scripts/js/soccer-field-players-positions/soccerfield.min.css" />
    <link rel="stylesheet" href="../scripts/js/soccer-field-players-positions/soccerfield.default.min.css" />
    <script src="../scripts/js/soccer-field-players-positions/jquery.soccerfield.min.js"></script>

    <!-- chartjs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <!-- JQuery Scripts -->
    <script>
        //jQuery Code Only
        //$.noConflict();
        $(document).ready(function() {
            // call the initializeContent function
            // $(window).on('load', function() {
            //     initializeContent('<?php echo $userAuth; ?>', '<?php echo $currentUser_Usrnm; ?>');
            // });

            var data = [{
                    name: 'KEYLOR NAVAS',
                    position: 'C_GK',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'MARCELO',
                    position: 'LC_B',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'SERGIO RAMOS',
                    position: 'C_B',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'CARVAJAL',
                    position: 'RC_B',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'CASEMIRO',
                    position: 'C_DM',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'KROOS',
                    position: 'L_M',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'ISCO',
                    position: 'LC_M',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'ASENSIO',
                    position: 'RC_M',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'MODRIC',
                    position: 'R_M',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'RONALDO',
                    position: 'LC_F',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'BENZEMA',
                    position: 'RC_F',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
            ];

            $("#soccerfield").soccerfield(data, {
                field: {
                    width: "960px",
                    height: "600px",
                    img: '../media/assets/field_diagrams/soccer-field-dimensions-1.jpg',
                    startHidden: false,
                    animate: false,
                    fadeTime: 1000,
                    autoReveal: false,
                    onReveal: function() {
                        // triggered on reveal
                    }
                },
                players: {
                    font_size: 16,
                    reveal: false,
                    sim: true, // reveal simultaneously
                    timeout: 1000,
                    fadeTime: 1000,
                    img: true,
                    onReveal: function() {
                        // triggered on reveal
                    }
                }
            });

            // ***** Locaion: Modal
            // ajax jquery - submit activity tracking data [Heart Rate]
            $("#modal-heartrate-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                var form_data = new FormData($('#modal-heartrate-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_heartrate.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Heart Rate]');
                        },
                        success: function(response) {
                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Heart Rate]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [Heart Rate]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Heart Rate]

            // ajax jquery - submit activity tracking data [Body Temp]
            $("#modal-bodytemp-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                var form_data = new FormData($('#modal-bodytemp-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bodytemp.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Body Temp]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Body Temp]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [Body Temp]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Body Temp]

            // ajax jquery - submit activity tracking data [Speed]
            $("#modal-speed-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                var form_data = new FormData($('#modal-speed-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_speed.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Speed]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Speed]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [Speed]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Speed]

            // ajax jquery - submit activity tracking data [BMI Weight]
            $("#modal-weight-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                var form_data = new FormData($('#modal-weight-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bmiweight.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [BMI Weight]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [BMI Weight]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [BMI Weight]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [BMI Weight]

            // ***** Locaion: Single
            // ajax jquery - submit activity tracking data [Heart Rate]
            $("#single-heartrate-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                var form_data = new FormData($('#single-heartrate-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_heartrate.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Heart Rate]');
                        },
                        success: function(response) {
                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Heart Rate]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [Heart Rate]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Heart Rate]

            // ajax jquery - submit activity tracking data [Body Temp]
            $("#single-bodytemp-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                var form_data = new FormData($('#single-bodytemp-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bodytemp.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Body Temp]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Body Temp]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [Body Temp]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Body Temp]

            // ajax jquery - submit activity tracking data [Speed]
            $("#single-speed-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                var form_data = new FormData($('#single-speed-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_speed.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Speed]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Speed]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [Speed]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Speed]

            // ajax jquery - submit activity tracking data [BMI Weight]
            $("#single-weight-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                var form_data = new FormData($('#single-weight-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bmiweight.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [BMI Weight]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [BMI Weight]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [BMI Weight]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [BMI Weight]

            // load Teams Activity Capturing Form
            $.loadTeamsActivityCaptureForm = function(day, grpRefcode) {
                // alert("../scripts/php/main_app/data_management/system_admin/team_athletics_data/compile_teams_add_new_activity_day_form.php?day=" + day + "&gref=" + grpRefcode);

                $.get("../scripts/php/main_app/data_management/system_admin/team_athletics_data/compile_teams_add_new_activity_day_form.php?day=" + day + "&gref=" + grpRefcode, function(data, status) {
                    console.log("loadTeamsActivityCaptureForm returned: \n[Status]: " + status + "\n[Data]: " + data);

                    if (status == "success") {
                        // populate the modal body
                        $('#tabEditWeeklyTeamsTrainingScheduleModal_body').html(data);
                    } else {
                        // provide an error message
                        console.log("Error loading edit add new form");
                    }
                });
            }

            $.populateWeeklyActivityBarChart = function() {
                // inner bar activity containers
                // $('#teams-weekly-activity-barchart-bar-day1').html(data);
                // $('#teams-weekly-activity-barchart-bar-day2').html(data);
                // $('#teams-weekly-activity-barchart-bar-day3').html(data);
                // $('#teams-weekly-activity-barchart-bar-day4').html(data);
                // $('#teams-weekly-activity-barchart-bar-day5').html(data);
                // $('#teams-weekly-activity-barchart-bar-day6').html(data);
                // $('#teams-weekly-activity-barchart-bar-day7').html(data);

                // bar cols
                // $('#day-1-col').html(data);
                // $('#day-2-col').html(data);
                // $('#day-3-col').html(data);
                // $('#day-4-col').html(data);
                // $('#day-5-col').html(data);
                // $('#day-6-col').html(data);
                // $('#day-7-col').html(data);

                var weekDaysArray = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

                // alert("JQuery AJAX populateWeeklyActivityBarChart");
                var $grpRefCode = "tst_grp_0001";

                weekDaysArray.forEach(day => {
                    $.get("../scripts/php/main_app/data_management/system_admin/team_athletics_data/compile_teams_daily_activities.php?day=" + day + "&gref=" + $grpRefCode, function(data, status) {
                        // console.log("compile_teams_daily_activities returned: \n[Status]: " + status + "\n[Data]: " + data);

                        switch (day) {
                            case "monday":
                                $('#day-1-col').html(data);
                                break;
                            case "tuesday":
                                $('#day-2-col').html(data);
                                break;
                            case "wednesday":
                                $('#day-3-col').html(data);
                                break;
                            case "thursday":
                                $('#day-4-col').html(data);
                                break;
                            case "friday":
                                $('#day-5-col').html(data);
                                break;
                            case "saturday":
                                $('#day-6-col').html(data);
                                break;
                            case "sunday":
                                $('#day-7-col').html(data);
                                break;

                            default:
                                console.log("Error [populateWeeklyActivityBarChart]: Day: " + day + " | grpRefCode" + $grpRefCode);
                                break;
                        }
                    });
                });

            }

            // ajax jquery - submit edited weekly teams activity data [Teams Submit Edited Activities Form]
            $("#teams-add-new-day-activity-data-form").submit(function(e) {
                e.preventDefault();

                var form_data = new FormData($('#teams-add-new-day-activity-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/system_admin/team_athletics_data/submit/teams_add_new_activity_day_form_submit.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submit edited weekly teams activity data [Teams Submit Edited Activities Form]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - submit edited weekly teams activity data [Teams Submit Edited Activities Form]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - submit edited weekly teams activity data [Teams Submit Edited Activities Form]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit edited weekly teams activity data [Teams Submit Edited Activities Form]

            // $("map[name=image-map-male-front]").mapoid({
            //     click: function(e) {
            //         /*// stroke color
            //         strokeColor: 'black',
            //         // stroke width
            //         strokeWidth: 1,
            //         // fill color
            //         fillColor: 'black',
            //         // 0-1
            //         fillOpacity: 0.5,
            //         // in milliseconds
            //         fadeTime: 500,
            //         // an array of selected areas
            //         selectedArea: false,
            //         // select on click
            //         selectOnClick: true*/

            //         //alert('click');
            //         e.preventDefault();
            //         var clickedArea = $(this); // remember clicked area
            //         // foreach area
            //         $("map[name=image-map-male-front]").each(function() {
            //             hData = $(this).data('maphilight') || {}; // get
            //             hData.alwaysOn = $(this).is(clickedArea); // modify
            //             $(this).data('maphilight', hData).trigger('alwaysOn.maphilight'); // set
            //         });
            //     }
            // });
            //JQuery Image Map Highlighting
            //$('.map').maphilight();

            //$('.map').maphilight();

            /*$('#musclepart').click(function(e) {
                e.preventDefault();
                var clickedArea = $(this); // remember clicked area
                // foreach area
                $('#musclepart').each(function() {
                    hData = $(this).data('maphilight') || {}; // get
                    hData.alwaysOn = $(this).is(clickedArea); // modify
                    $(this).data('maphilight', hData).trigger('alwaysOn.maphilight'); // set
                });
            });*/

            // ChartJs
            // const config = {
            //     type: 'line',
            //     data: data,
            // };
        });
    </script>
</head>

<body class="noselect" onload="initializeContent('<?php echo $userAuth; ?>','<?php echo $currentUser_Usrnm; ?>')">
    <!--  -->
    <!-- Load Curtain -->
    <div class="load-curtain" id="LoadCurtain" style="display: block;">
        <!-- twitter social panel -->
        <div class="load-curtain-social-btn-panel comfortaa-font d-grid gap-2 p-4">
            <!--  d-none d-lg-block p-4 -->
            <div class="d-flex gap-2 w-100">
                <button class="p-4 m-0 shadow onefit-buttons-style-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseloadCurtainTweetFeed" aria-expanded="false" aria-controls="collapseloadCurtainTweetFeed">
                    <div class="d-grid">
                        <span class="material-icons material-icons-round" style="font-size: 48px !important;">
                            <i class="fab fa-twitter" style="font-size: 40px; color: #fff !important;"></i>
                        </span>
                        <p class="comfortaa-font mt-1 mb-0" style="font-size: 10px;">@onefitnet</p>
                    </div>
                </button>
            </div>
            <div class="collapse no-scroller pb-4 w3-animate-bottom" id="collapseloadCurtainTweetFeed" style="overflow-y: auto;">
                <div class="pb-4 no-scroller" style="border-radius: 25px !important; overflow-y: auto; max-height: 90vh; min-width: 500px;">
                    <a class="twitter-timeline comfortaa-font" href="https://twitter.com/OnefitNet?ref_src=twsrc%5Etfw">Tweets by OnefitNet</a>
                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>
            </div>
        </div>
        <!-- ./ twitter social panel -->

        <div class="d-flex align-items-center top-down-grad-tahiti" style="width: 100%; height: 100%;">
            <div class="text-center w-100">
                <div class="ring d-flex align-items-center p-4 my-pulse-animation-light">
                    <!-- <span></span> -->
                    <div style="width: 100%;">
                        <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid p-4" style="max-height: 20vh;" alt="">
                    </div>
                </div>
            </div>
        </div>
        <nav class="text-center text-center p-4 fixed-bottom" alt="">
            <p class="navbar-brand fs-1 text-white comfortaa-font">One<span style="color: #ffa500">fit</span>.app<span style="font-size: 10px">&trade;</span></p>
            <p class="text-center comfortaa-font" styl="font-size: 10px !important;">Loading. Please wait.</p>
        </nav>
    </div>
    <!-- ./Load Curtain -->

    <!-- Facebook API -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v13.0" nonce="47FC3Uf9"></script>
    <!-- ./ Facebook API -->

    <!-- Navigation bar, Cart & Other functions -->
    <div class="container-lg -fluid text-center pt-4">
        <a class="navbar-brand my-4 p-4 fs-1 text-white comfortaa-font" href="#">
            One<span style="color: #ffa500">fit</span>.app<span style="font-size: 10px">&trade;</span>
        </a>

        <!-- Cart Container  -->
        <div class="container py-4">
            <div class="text-center">
                <button class="navbar-toggler shadowz onefit-buttons-style-dark p-2" type="button" data-bs-toggle="collapse" data-bs-target="#cart-panel" aria-controls="cart-panel">
                    <div class="row px-4 py-2 align-items-centerz">
                        <div class="col-sm border-start border-end border-light p-2">
                            <span class="material-icons material-icons-round align-middle" style="font-size: 50px !important;">
                                verified_user
                            </span>
                        </div>
                        <div class="col-sm border-start border-end border-light p-2">
                            <div class="d-grid gap-2">
                                <span class="material-icons material-icons-round" style="font-size: 20px !important"> shopping_bag </span>
                                <span class="d-nonez d-lg-blockz" id="" style="font-size: 10px;">Cart (<span class="fw-bold comfortaa-font" style="color: #ffa500;">4</span>)</span>
                            </div>
                        </div>
                        <div class="col-sm fw-bold comfortaa-font border-start border-end border-light p-2">
                            <span class="align-middle" style="font-size: 10px; color: #ffa500;">ZAR</span><br> 0.00
                        </div>
                    </div>
                </button>
            </div>

            <div class="collapse showz down-top-grad-dark w3-animate-top comfortaa-font text-white" style="border-radius: 25px; overflow: hidden;" id="cart-panel">
                <div class="p-4 shadow" id="">
                    <div class="text-center d-flex justify-content-between align-items-center">
                        <button class="navbar-toggler shadow onefit-buttons-style-dark p-4 mb-4 w3-animate-right d-grid gap-1" type="button" onclick="openLink(event, 'TabStore')">
                            <span class="material-icons material-icons-round align-middle">
                                storefront
                            </span>
                            <span class="align-middle"><span class="d-none d-lg-block">Visit the </span><span style="color: #ffa500 !important;">.Store</span></span>
                        </button>

                        <div class="w3-animate-top text-center">
                            <!-- <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="max-height: 50px;" alt="logo"> -->
                            <div class="d-grid text-center">
                                <p class="m-0 fs-5 comfortaa-font text-muted">Shopping</p>
                                <p class="m-0 fs-1 comfortaa-font text-muted">Cart.</p>
                            </div>

                        </div>

                        <button class="navbar-toggler shadow onefit-buttons-style-dark p-4 mb-4 w3-animate-left d-grid gap-1" type="button">
                            <span class="material-icons material-icons-round align-middle">
                                point_of_sale
                            </span>
                            <span class="align-middle">
                                <span class="d-none d-lg-block">Proceed to </span><span class="d-none d-lg-block" style="color: #ffa500 !important;">>Payment.</span>
                            </span><span class="d-lg-none" style="color: #ffa500 !important;">Pay.</span>
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-6 py-4">
                            <p class="text-start w3-animate-left comfortaa-font" style="min-height: 30px;">Invoice [ <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;">20220201-879ds6fsdf_id</span> ]</p>
                            <hr class="text-white">
                            <h1><span style="color: #ffa500;">Total:</span> R<span id="shop-cart-total-amt">0.00</span> <span class="align-top" style="font-size: 10px; color: #ffa500;">ZAR</span></h1>
                            <ul id="main-cart-items-list" class="list-group list-group-flush list-group-numbered shadow py-4 no-scroller px-4" style="background-color: #343434; overflow-y: auto; border-radius: 25px !important; max-height: 50vh !important;">
                                <li id="main-cart-items-list-item-idvalue" class="list-group-item border-light bg-transparent text-white fs-5 d-flex" style="border-radius: 10px;">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <div class="d-grid gap-2 text-start px-4 pb-2">
                                            <div class="comfortaa-font">
                                                <span id="main-cart-items-list-item-name" class="align-middle">Aiwa Smart Band ASB-40</span>
                                            </div>
                                            <div class="comfortaa-font">
                                                <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                                <span class="fs-5" id="main-cart-items-list-item-price" style="color: #ffa500;">R149.00</span>
                                            </div>
                                        </div>
                                        <div class="d-grid justify-content-end">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </li>
                                <li id="main-cart-items-list-item-idvalue" class="list-group-item border-light bg-transparent text-white fs-5 d-flex" style="border-radius: 10px;">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <div class="d-grid gap-2 text-start px-4 pb-2">
                                            <div class="comfortaa-font">
                                                <span id="main-cart-items-list-item-name" class="align-middle">Aiwa Smart Band ASB-40</span>
                                            </div>
                                            <div class="comfortaa-font">
                                                <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                                <span class="fs-5" id="main-cart-items-list-item-price" style="color: #ffa500;">R149.00</span>
                                            </div>
                                        </div>
                                        <div class="d-grid justify-content-end">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </li>
                                <li id="main-cart-items-list-item-idvalue" class="list-group-item border-light bg-transparent text-white fs-5 d-flex" style="border-radius: 10px;">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <div class="d-grid gap-2 text-start px-4 pb-2">
                                            <div class="comfortaa-font">
                                                <span id="main-cart-items-list-item-name" class="align-middle">Aiwa Smart Band ASB-40</span>
                                            </div>
                                            <div class="comfortaa-font">
                                                <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                                <span class="fs-5" id="main-cart-items-list-item-price" style="color: #ffa500;">R149.00</span>
                                            </div>
                                        </div>
                                        <div class="d-grid justify-content-end">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </li>
                                <li id="main-cart-items-list-item-idvalue" class="list-group-item border-light bg-transparent text-white fs-5 d-flex" style="border-radius: 10px;">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <div class="d-grid gap-2 text-start px-4 pb-2">
                                            <div class="comfortaa-font">
                                                <span id="main-cart-items-list-item-name" class="align-middle">Aiwa Smart Band ASB-40</span>
                                            </div>
                                            <div class="comfortaa-font">
                                                <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                                <span class="fs-5" id="main-cart-items-list-item-price" style="color: #ffa500;">R149.00</span>
                                            </div>
                                        </div>
                                        <div class="d-grid justify-content-end">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 py-4">
                            <p class="text-end w3-animate-right comfortaa-font" style="min-height: 30px;">Cart Items (<span id="mini-cart-item-count" style="color: #ffa500;">4</span>)</p>
                            <hr class="text-white">
                            <div class="horizontal-scroll p-5">
                                <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-end me-4 position-relative" style="border-color: #ffa500 !important;">
                                    <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                        1
                                    </div>
                                    <div class="d-grid gap-2 justify-content-center">
                                        <span class="material-icons material-icons-round text-muted" style="font-size: 8px !important;">shopping_basket</span>
                                        <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                        <div class="text-center">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh;" alt="placeholder">
                                        </div>

                                        <p class="fw-bold text-truncate text-center py-4 comfortaa-font">
                                            <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                            <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                        </p>
                                        <div class="d-grid">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-end me-4 position-relative" style="border-color: #ffa500 !important;">
                                    <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                        2
                                    </div>
                                    <div class="d-grid gap-2 justify-content-center">
                                        <span class="material-icons material-icons-round text-muted" style="font-size: 8px !important;">shopping_basket</span>
                                        <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                        <div class="text-center">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh;" alt="placeholder">
                                        </div>

                                        <p class="fw-bold text-truncate text-center py-4 comfortaa-font">
                                            <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                            <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                        </p>
                                        <div class="d-grid">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-end me-4 position-relative" style="border-color: #ffa500 !important;">
                                    <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                        3
                                    </div>
                                    <div class="d-grid gap-2 justify-content-center">
                                        <span class="material-icons material-icons-round text-muted" style="font-size: 8px !important;">shopping_basket</span>
                                        <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                        <div class="text-center">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh;" alt="placeholder">
                                        </div>

                                        <p class="fw-bold text-truncate text-center py-4 comfortaa-font">
                                            <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                            <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                        </p>
                                        <div class="d-grid">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-end me-4 position-relative" style="border-color: #ffa500 !important;">
                                    <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                        4
                                    </div>
                                    <div class="d-grid gap-2 justify-content-center">
                                        <span class="material-icons material-icons-round text-muted" style="font-size: 8px !important;">shopping_basket</span>
                                        <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                        <div class="text-center">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh;" alt="placeholder">
                                        </div>

                                        <p class="fw-bold text-truncate text-center py-4 comfortaa-font">
                                            <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                            <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                        </p>
                                        <div class="d-grid">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!--<div class="row align-items-start">
                <div class="col-md-9 text-white">
                    <p class="text-end" hidden>Your Cart (0 items)</p>
                    <div class="collapse showz down-top-grad-dark w3-animate-left comfortaa-font" style="border-radius: 25px; overflow: hidden;" id="cart-panel">
                        <div class="p-4 shadow" id="">
                            <div class="text-end">
                                <button class="navbar-toggler shadow onefit-buttons-style-light p-4 mb-4" type="button">
                                    <p>
                                        <span class="material-icons material-icons-round">
                                            storefront
                                        </span>
                                        <span class="align-middle"><span class="d-none d-lg-block">Visit the </span><span style="color: #ffa500 !important;">.Store</span></span>
                                    </p>
                                </button>
                                <button class="navbar-toggler shadow onefit-buttons-style-light p-4 mb-4" type="button">
                                    <p>
                                        <span class="material-icons material-icons-round">
                                            point_of_sale
                                        </span>
                                        <span class="align-middle"><span class="d-none d-lg-block">Proceed to </span>Checkout</span>
                                    </p>
                                </button>
                            </div>

                            <div class="row">
                                <div class="col-md-6 py-4">
                                    <p class="text-start">Invoice [ <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;">20220201-879ds6fsdf_id</span> ]</p>
                                    <hr class="text-white">
                                    <h1><span style="color: #ffa500;">Total:</span> R<span id="shop-cart-total-amt">0.00</span> <span class="align-top" style="font-size: 10px; color: #ffa500;">ZAR</span></h1>
                                    <ul class="list-group list-group-flush list-group-numbered shadow py-4 no-scroller" id="" style="background-color: #343434; overflow-y: auto; border-radius: 25px !important; max-height: 50vh !important;">
                                        <li class="list-group-item border-light bg-transparent text-white">R149.00 | Aiwa Smart Band ASB-40</li>
                                        <li class="list-group-item border-light bg-transparent text-white">R149.00 | Aiwa Smart Band ASB-40</li>
                                        <li class="list-group-item border-light bg-transparent text-white">R149.00 | Aiwa Smart Band ASB-40</li>
                                        <li class="list-group-item border-light bg-transparent text-white">R149.00 | Aiwa Smart Band ASB-40</li>
                                    </ul>
                                </div>
                                <div class="col-md-6 py-4">
                                    <p class="text-start">Cart Items (4)</p>
                                    <hr class="text-white">
                                    <div class="horizontal-scroll">
                                        <div class="horizontal-scroll-card p-4 shadow">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px;" alt="placeholder">
                                            <p class="fw-bold text-truncate text-center py-4">
                                                R149.00 | Aiwa Smart Band ASB-40
                                            </p>
                                        </div>
                                        <div class="horizontal-scroll-card p-4 shadow">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px;" alt="placeholder">
                                            <p class="fw-bold text-truncate text-center py-4">
                                                R149.00 | Aiwa Smart Band ASB-40
                                            </p>
                                        </div>
                                        <div class="horizontal-scroll-card p-4 shadow">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px;" alt="placeholder">
                                            <p class="fw-bold text-truncate text-center py-4">
                                                R149.00 | Aiwa Smart Band ASB-40
                                            </p>
                                        </div>
                                        <div class="horizontal-scroll-card p-4 shadow">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px;" alt="placeholder">
                                            <p class="fw-bold text-truncate text-center py-4">
                                                R149.00 | Aiwa Smart Band ASB-40
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-end d-grid gap-2 py-4">
                    <button class="navbar-toggler shadowz onefit-buttons-style-dark p-2" type="button" data-bs-toggle="collapse" data-bs-target="#cart-panel" aria-controls="cart-panel">
                        <div class="row px-4 py-2">
                            <div class="col-sm border-start border-end border-light p-2">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round" style="font-size: 40px !important"> shopping_bag </span>
                                    <span class="d-nonez d-lg-blockz" id="" style="font-size: 10px;">Cart (<span class="fw-bold comfortaa-font" style="color: #ffa500;">4</span>)</span>
                                </div>
                            </div>
                            <div class="col-sm fw-bold comfortaa-font border-start border-end border-light p-2">
                                <span class="align-middle" style="font-size: 10px; color: #ffa500;">ZAR</span><br> 0.00
                            </div>
                        </div>
                    </button>
                </div>
            </div>-->
        </div>
        <!-- ./ Cart Container  -->

        <!-- Create Button - hidden on screens smaller than lg -->
        <div class="create-btn-container my-pulse-animation-tahiti comfortaa-font d-grid gap-2 d-none d-lg-block">
            <div class="collapse p-4 w3-animate-bottom" id="collapseCreateCommandList">
                <ul class="list-groupz list-group-flush list-group border-0 text-white fw-bold text-center comfortaa-font" style="overflow: initial !important;">
                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Social Update</button></li>
                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Community Resource</button></li>
                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Share Media</button></li>
                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Chat Message</button></li>
                </ul>
            </div>
            <div class="d-grid gap-2 w-100">
                <button class="p-4 m-0 shadow onefit-buttons-style-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCreateCommandList" aria-expanded="false" aria-controls="collapseCreateCommandList">
                    <div class="d-grid">
                        <span class="material-icons material-icons-round" style="font-size: 48px !important;">
                            brush
                        </span>
                        <p class="comfortaa-font" style="font-size: 20px;">Create.</p>
                    </div>
                </button>
            </div>

        </div>
        <!-- ./ Create Button - hidden on screens smaller than lg -->
    </div>
    <!-- ./ Navigation bar, Cart & Other functions -->

    <!-- Main Content -->
    <div class="container-lg" style="padding-bottom: 50px">
        <!-- Main Navigation Bar -->
        <nav class="navbar navbar-light sticky-top navbar-style w-100 mb-4" style="border-radius: 25px; max-height: 100vh !important; border-bottom: #ffa500 solid 5px;">
            <!-- App Function Buttons -->
            <div class="container">
                <button class="onefit-buttons-style-dark p-2 shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotifications" aria-controls="offcanvasNotifications">
                    <div class="d-grid gap-2">
                        <span class="material-icons material-icons-round" style="font-size: 24px !important"> notifications </span>
                        <span class="d-none d-lg-block" style="font-size: 10px;">Notifications</span>
                    </div>
                </button>

                <button type="button" id="display-current-tab-button" class="onefit-buttons-style-dark p-2 my-4 shadow comfortaa-font" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#tabNavModal">
                    <div class="d-grid gap-2">
                        <span class="material-icons material-icons-round" style="font-size: 24px !important;" id="display-current-tab-button-icon">
                            dashboard </span>
                        <span class="d-none d-lg-block" id="display-current-tab-button-text" style="font-size: 10px;">Dashboard</span>
                    </div>
                </button>

                <!-- Main UPPL Toggle button -->
                <div class="d-inline gap-2">
                    <button class="onefit-buttons-style-dark p-2 shadow d-nonez d-lg-blockz" style="overflow: hidden; font-size: 10px;" type="button" data-bs-toggle="modal" data-bs-target="#tabLatestSocialModal">
                        <div class="d-grid gap-2 text-center">
                            <!-- Profile Picture -->
                            <img src="../media/assets/One-Symbol-Logo-White.png" alt="Onefit Logo" class="p-1 img-fluid my-pulse-animation-tahitiz" style="height: 50px; width: 50px; border-radius: 15px; border-color: #ffa500 !important" />
                            <!-- ./ Profile Picture -->
                            <span class="d-none d-lg-block">Latest</span>
                        </div>
                    </button>
                </div>
                <!-- ./ Main UPPL Toggle button -->

                <button type="button" class="onefit-buttons-style-dark p-2 my-4 shadow comfortaa-font" data-bs-toggle="collapse" data-bs-target="#widget-rows-container" aria-controls="widget-rows-container">
                    <div class="d-grid gap-2">
                        <span class="material-icons material-icons-round" style="font-size: 24px !important"> widgets </span>
                        <span class="d-none d-lg-block" style="font-size: 10px;">Widgets</span>
                    </div>
                    <!--<span class="material-icons material-icons-round" style="font-size: 24px !important"> linear_scale </span>-->
                </button>

                <button class="navbar-toggler shadow onefit-buttons-style-dark p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <div class="d-grid gap-2">
                        <span class="material-icons material-icons-round" style="font-size: 24px !important"> menu_open </span>
                        <span class="d-none d-lg-block" id="" style="font-size: 10px;">Navigation</span>
                    </div>
                </button>

                <!-- Navigation Menu Offcanvas -->
                <div class="offcanvas offcanvas-end offcanvas-menu-primary-style fitness-bg-containerz" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="h-100z" id="offcanvas-menu">
                        <div class="offcanvas-header shadow fs-1" style="background-color: #343434; color: #fff">
                            <img src="../media/assets/One-Symbol-Logo-White.png" alt="" class="img-fluid logo-size-2 pulse-animation" />

                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel" style="overflow-x: hidden;">
                                Navigation
                            </h5>
                            <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="offcanvas" aria-label="Close">
                                <span class="material-icons material-icons-round"> cancel </span>
                            </button>
                        </div>
                        <div class="offcanvas-body" style="padding-bottom: 40px; overflow-y: auto; overflow-x: hidden; max-height: 80vh;">
                            <ul class="navbar-nav justify-content-end flex-grow-1 py-3 comfortaa-font fs-3">
                                <li class="nav-item">
                                    <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">Contact</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active p-4" style="border-radius: 25px !important;" aria-current="page" href="#">Onefit.app&trade;</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">Onefit.Edu&trade; (Blog)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">Onefit.Shop&trade;</a>
                                </li>
                                <hr class="text-dark" style="height: 5px;" />
                                <li class="nav-item d-grid gap-2">
                                    <button class="onefit-buttons-style-danger p-4 text-center my-4" onclick="launchLink('../scripts/php/destroy_session.php')" style="border-radius: 25px !important;">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                <img src="<?php echo $currentuser_img_url; ?>" class="img-fluid rounded-circle" height="50" width="50" alt="user profile picture">
                                            </div>
                                            <div class="col-md-8">
                                                Sign Out
                                            </div>
                                        </div>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ./Navigation Menu Offcanvas -->

                <!-- Notifocation List Offcanvas -->
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotifications" aria-controls="offcanvasNotifications" hidden>
                    <span class="material-icons material-icons-round" style="font-size: 48px !important"> notifications </span>
                    Notifications
                </button>

                <div class="offcanvas offcanvas-start offcanvas-menu-primary-style fitness-bg-containerz" tabindex="-1" id="offcanvasNotifications" aria-labelledby="offcanvasNotificationsLabel">
                    <div class="offcanvas-header align-center shadow" style="background-color: #fff;">
                        <span class="material-icons material-icons-round" style="font-size: 48px !important"> notifications </span>

                        <h5 id="offcanvasTopLabel" style="overflow-x: hidden;">
                            Notifications</h5>

                        <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="offcanvas" aria-label="Close">
                            <span class="material-icons material-icons-round"> cancel </span>
                        </button>
                    </div>
                    <div class="offcanvas-body" style="background-color: rgba(255, 255, 255, 0.8);">
                        <ul class="list-group list-group-flush shadow p-4z" id="notif-list" style="border-radius: 25px; max-height: 60vh;" hidden>
                            <li class="list-group-item border-dark">An item</li>
                            <li class="list-group-item border-dark">A second item</li>
                            <li class="list-group-item border-dark">A third item</li>
                            <li class="list-group-item border-dark">A fourth item</li>
                            <li class="list-group-item border-dark">And a fifth one</li>
                        </ul>
                        <div id="communicationUserNotifications">
                            <?php echo $outputProfileUserNotifications; ?>
                        </div>
                        <?php echo $communicationUserNotifications; ?>
                    </div>
                </div>
                <!-- ./Notifocation List Offcanvas -->
            </div>
            <!-- ./ App Function Buttons -->
        </nav>
        <!-- ./ Main Navigation Bar -->

        <!-- Tab Content -->
        <div class="container-lg">
            <div class="tab-container" id="tab-container">
                <div id="TabHome" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: block">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">dashboard</span> Dashboard</h5>

                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <h5 class="text-center">Hi Thabang.</h5>
                    <p class="my-4 text-center comfortaa-fontr">Welcome to the Dashboard Page. Here, you can find various feeds from the activities we will be doing in the OnefitNet Community.</p>

                    <hr class="text-white">

                    <div class="variable-grid-container">
                        <div class="full-wide-grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">

                            <!-- fitness progression progress bar -->
                            <div id="fitness-progression-progress-bar">
                                <h5 class="mt-4"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">data_exploration</span> <span class="align-middle">Fitness Progression</span></h5>
                                <div class="progress mt-4" style="height: 4px;">
                                    <div class="progress-bar" role="progressbar" aria-label="Example 1px high" style="width: 25%; background-color: #ffa500 !important; border-right: #343434 10px solid;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="row mt-2" style="margin-bottom: 60px;">
                                    <div class="col text-start comfortaa-font" style="font-size: 12px;">
                                        Current XP <strong>(112)</strong>
                                    </div>
                                    <div class="col text-end comfortaa-font" style="font-size: 12px;">
                                        Target XP <strong>(150)</strong>
                                    </div>
                                </div>
                            </div>
                            <!-- ./ fitness progression progress bar -->

                            <hr class="text-white">

                            <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important; margin-bottom: 60px !important;">
                                <h4 class="d-grid gap-2 text-center">
                                    <span class="material-icons material-icons-round align-middle" style="color: #ffa500 !important">timeline</span>
                                    <span class="rounded-pill p-4 align-middle my-pulse-animation-tahiti" style="background-color: #343434; color: #fff; border-bottom: #ffa500 5px solid;">Activities lined up.</span>
                                </h4>
                            </div>

                            <h5 class="align-middle text-center"><span class="material-icons material-icons-outlined align-middle">today</span><br> <?php echo date("l"); ?><br> <span style="color: #ffa500;">[</span> <?php echo date("d/m/Y"); ?> <span style="color: #ffa500;">]</span></h5>
                            <!-- Digital Clock -->
                            <div id="clock" class="dark my-4 shadow">
                                <div class="display no-scroller">
                                    <div class="weekdays"></div>
                                    <div class="ampm"></div>
                                    <div class="alarm"></div>
                                    <div class="digits"></div>
                                </div>
                            </div>
                            <!-- ./. Digital Clock -->

                            <div id="dashboard-activity-lineup-container">
                                <div class="d-flex align-items-center text-center justify-content-center" id="no-activities-banner-container" style="min-height: 100px;">
                                    <p class="my-4 fs-5 fw-bold comfortaa-font" style="cursor: pointer;" onclick="openLink(event, 'TabStudio')">No activities lined up. Go to the <span style="color: #ffa500;">.Studio</span> to get active.</p>
                                </div>

                                <div class="row align-items-start text-white" id="training-schedule-chart-grid">
                                    <div class="col-md-8">
                                        <div class="horizontal-scroll-card w-100 p-4 shadow">
                                            <h5 class="text-center">Your Assessments for the day</h5>
                                            <hr class="text-white" style="height: 5px;">

                                            <ol class="list-group list-group-flush border-0 my-4">
                                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                                    </span>
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                                        Frequency: Daily<br />
                                                        Mendatory: Optional
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                                    </span>
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                                        Frequency: Daily<br />
                                                        Mendatory: Optional
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                                            pending_actions </span>
                                                    </span>
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                                        Frequency: Daily<br />
                                                        Mendatory: Yes
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                                            pending_actions </span>
                                                    </span>
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                                        Frequency: Daily<br />
                                                        Mendatory: Yes
                                                    </div>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>

                                    <div class="col-md-4 text-white text-center" id="home-day-1-col">

                                        <div class="chart-col-bar p-2 shadow comfortaa-font">
                                            <h5>Today's Workout Activities</h5>

                                            <hr class="text-white" style="height: 5px;">

                                            <div class="down-top-grad-tahiti py-4 mb-4" style="border-radius: 0 0 25px 25px;">
                                                <p class="fs-5 fw-bold">
                                                    Regeneration
                                                </p>
                                                <p style="color: #343434;">
                                                    RPE 1-3
                                                </p>
                                            </div>

                                            <hr class="text-white" style="height: 5px;" hidden>

                                            <div class="chart-col-bar-item text-center position-relative">
                                                <p>Cycling / Spinning</p>
                                                <img src="../media/assets/icons/cycling.png" alt="" class="img-fluid">
                                            </div>
                                            <hr class="text-white my-2 p-0" style="height: 5px;">

                                            <div class="chart-col-bar-item text-center">
                                                <p>Strength & Core</p>
                                                <img src="../media/assets/icons/bodybuilder.png" alt="" class="img-fluid">
                                            </div>
                                            <hr class="text-white my-2 p-0" style="height: 5px;">

                                            <p class="text-center fs-5 fw-bold">Day 1/-6 <br>(Sunday, dd/mm/yyyy)</p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Content Card - Dashboard -->
                        <div class="grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>News, Resources, Blog and Ads Feed</h4>
                            <small class="text-muted" id="">Content</small>
                            <p style="color: #ffa500;">Stay tuned for helpful resources, media content and the latest news in Sports, Health, Wellness, Lifestyle and Current Affairs News.</p>
                            <div class="text-center">
                                <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <!-- Content Card - Dashboard -->

                        <div class="full-tall-grid-tile wide-grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>Social Updates Feed</h4>
                            <p class="mb-4">Check out what the Community is up to. Feel free to post an Update about your fitness journey.</p>

                            <div class="no-scroller px-2" id="dashboard-Community-Posts" style="max-height: 50vh; overflow-y: auto; overflow-x: hidden; box-shadow: inset 0px 0px 40px 0px rgba(232, 138, 4, 1); border-radius: 25px">
                                <!--rgba(232, 138, 4, 1)-->
                                <?php echo $outputCommunityUpdates; ?>
                            </div>
                        </div>
                        <div class="tall-grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>News, Resources, Blog and Ads Feed</h4>
                            <small class="text-muted" id="">Content</small>
                            <p style="color: #ffa500;">Stay tuned for helpful resources, media content and the latest news in Sports, Health, Wellness, Lifestyle and Current Affairs News.</p>
                            <div class="text-center">
                                <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="tall-grid-tile full-wide-grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>Google Community Surveys</h4>
                            <p class="mb-4">the activities list will be able to switch through the different programs of the use</p>
                            <p class="text-muted">currently fixing the dashboard</p>

                            <!-- embed (22/10/2022)  -->
                            <!-- <iframe class="w-100 tunnel-bg-container shadow" style="border-radius: 25px; overflow: hidden;" height="450" src="https://datastudio.google.com/embed/reporting/2a409a10-e7c0-4375-a22d-bfab63e728db/page/guiJC" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                            <!-- Older embedd: <iframe class="w-100 tunnel-bg-container shadow" style="border-radius: 25px; overflow: hidden;" height="450" src="https://datastudio.google.com/embed/reporting/2a409a10-e7c0-4375-a22d-bfab63e728db/page/guiJC" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                        </div>

                        <div class="wide-grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>News, Resources, Blog and Ads Feed</h4>
                            <small class="text-muted" id="">Content</small>
                            <p style="color: #ffa500;">Stay tuned for helpful resources, media content and the latest news in Sports, Health, Wellness, Lifestyle and Current Affairs News.</p>
                            <div class="text-center">
                                <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="tall-grid-tile grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>News, Resources, Blog and Ads Feed</h4>
                            <small class="text-muted" id="">Content</small>
                            <p style="color: #ffa500;">Stay tuned for helpful resources, media content and the latest news in Sports, Health, Wellness, Lifestyle and Current Affairs News.</p>
                            <div class="text-center">
                                <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="full-wide-grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>One<span style="color: #ffa500">fit</span>.Muse</h4>
                            <p>the activities list will be able to switch through the different programs of the use</p>

                            <div class="row">
                                <div class="col-md-4 p-0">

                                    <p>Playlists</p>

                                    <hr class="text-white">
                                    <div class="p-4 d-grid gap-2">
                                        <button class="onefit-buttons-style-tahiti p-4 shadow mb-4 comfortaa-font">
                                            + Share your <br><span class="fw-bold fs-5" style="color: #fff !important;">Original Music</span>
                                        </button>

                                        <img src="../media/assets/muse_thumbnails/Gym-Playlist-Energetic-Tracks-For-Workout-Fitness-English-2018-20180602225519-500x500.jpg" class="img-fluid shadow my-2" style="border-radius: 25px;" alt="example thumbnail">

                                        <img src="../media/assets/muse_thumbnails/Gym-Playlist-Energetic-Tracks-For-Workout-Fitness-English-2018-20180602225519-500x500.jpg" class="img-fluid shadow my-2" style="border-radius: 25px;" alt="example thumbnail">

                                        <img src="../media/assets/muse_thumbnails/Gym-Playlist-Energetic-Tracks-For-Workout-Fitness-English-2018-20180602225519-500x500.jpg" class="img-fluid shadow my-2" style="border-radius: 25px;" alt="example thumbnail">
                                    </div>
                                </div>
                                <div class="col-md-8 p-0">
                                    <p>Tracks</p>
                                    <hr class="text-white">

                                    <!-- track information and visualizer container -->
                                    <div class="p-0 tunnel-bg-container-static" id="track-info-visualizer-container" style="border-radius: 25px 25px 0 0 !important; overflow: hidden;">
                                        <div class="down-top-grad-dark p-4 h-100 w-100">
                                            <div class="row align-items-center">
                                                <div class="col-md -4 text-center">
                                                    <!--Thumbnail-->
                                                    <div class="p-0 shadow border-bottom" style="min-height: 20vh; border-radius: 25px; color: #fff; background-color: #343434; border-color: #ffa500 !important; border-width: 5px !important; overflow: hidden;">
                                                        <div class="card bg-dark text-white border-0">
                                                            <!-- style="border-radius: 25px !important;" -->
                                                            <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="card-img" alt="..."> <!-- style="border-radius: 25px !important;" -->
                                                            <div class="card-img-overlay down-top-grad-dark d-grid align-items-end">
                                                                <!-- style="border-radius: 25px !important;" -->
                                                                <div class="text-start">
                                                                    <h5 class="card-title" style="color: #ffa500 !important;">Card title</h5>
                                                                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                                                    <div class="d-inline card-text">
                                                                        <span class="material-icons material-icons-outlined" style="color: #ffa500; font-size: 10px !important;">tag</span>
                                                                        <!-- track id - bc -->
                                                                        <span class="barcode-font text-muted" style="color: #ffa500; font-size: 10px !important;">
                                                                            Plylstid_0000001_Trackid_0000001
                                                                        </span>
                                                                        <!-- ./ track id - bc -->
                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!--./ Thumbnail-->

                                                    <div class="d-grid gap-2 w-100">
                                                        <button class="onefit-buttons-style-dark shadow p-2 px-4 my-4" style="transform: translate(0) !important;" id="museplayer-togglebtn" type="button" data-bs-toggle="collapse" data-bs-target="#song-playid-songid" aria-expanded="false" aria-controls="song-playid-songid">
                                                            <div class="row align-items-center w-100 text-center">
                                                                <div class="col-sm text-start">
                                                                    <span class="material-icons material-icons-round rounded-pill shadow -sm p-3" style="font-size: 50px !important;">
                                                                        art_track
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm py-4">
                                                                    Song Title (00:00)
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="col-xlg-8 mb-4 collapse show showz w3-animate-right text-white" id="song-playid-songid">
                                                    <div class="mb-4 py-2">
                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important;">info</span> Track Information.
                                                    </div>

                                                    <hr class="text-white">

                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-center"> <span class="align-middle">Like</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">thumb_up</span></li>
                                                        <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-center"> <span class="align-middle">Share</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">share</span></li>
                                                        <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-center"> <span class="align-middle">Save</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">favorite</span></li>
                                                        <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-center"> <span class="align-middle">follow</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">follow_the_signs</span></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- music player controller buttons -->
                                            <div class="text-center">
                                                <hr class="text-white">
                                                <div class="row my-4">
                                                    <div class="col -sm">
                                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('prev')"><span class="material-icons material-icons-round">skip_previous</span></button>
                                                    </div>
                                                    <div class="col -sm">
                                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('togglePlay')"><span class="material-icons material-icons-round">play_circle</span></button>
                                                    </div>
                                                    <div class="col -sm">
                                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('next')"><span class="material-icons material-icons-round">skip_next</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ./ music player controller buttons -->
                                        </div>

                                    </div>
                                    <!-- ./ track information and visualizer container -->

                                    <!-- selected playlist track list -->
                                    <ul class="list-group list-group-flush list-group-numberedz text-white" style="border-radius: 0 0 25px 25px !important; overflow: hidden; background-color: #343434 !important;">
                                        <li class="list-group-item d-grid comfortaa-font bg-transparent d-block">
                                            <div class="d-inline">
                                                <span class="material-icons material-icons-outlined" style="color: #ffa500; font-size: 10px !important;">tag</span>
                                                <!-- track id - bc -->
                                                <span class="barcode-font text-muted" style="color: #ffa500; font-size: 10px !important;">
                                                    Plylstid_0000001_Trackid_0000001
                                                </span>
                                                <!-- ./ track id - bc -->
                                            </div>


                                            <button class="onefit-buttons-style-light shadow p-2 my-2" style="transform: translate(0) !important;" type="button" data-bs-toggle="collapse" data-bs-target="#TrackOptions-Plylstid_0000001_Trackid_0000001" aria-expanded="false" aria-controls="TrackOptions-Plylstid_0000001_Trackid_0000001">
                                                <div class="row align-items-center w-100">
                                                    <div class="col">
                                                        <span class="material-icons material-icons-round shadow-lg" style="font-size: 20px !important;">
                                                            play_arrow
                                                        </span>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        (00:00) Song Title
                                                    </div>
                                                    <div class="col text-end">
                                                        <span class="material-icons material-icons-round">read_more</span>
                                                    </div>
                                                </div>
                                            </button>

                                            <!-- track options -->
                                            <div class="collapse w3-animate-right" id="TrackOptions-Plylstid_0000001_Trackid_0000001">
                                                <div class="row">
                                                    <div class="col-md d-grid align-items-center">
                                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('togglePlay')"><span class="material-icons material-icons-round">pause_circle</span></button>
                                                    </div>
                                                    <div class="col-md">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Like</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">thumb_up</span></li>
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Share</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">share</span></li>
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Save</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">favorite</span></li>
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">follow</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">follow_the_signs</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- ./ track options -->
                                        </li>
                                        <li class="list-group-item d-grid comfortaa-font bg-transparent d-block">
                                            <div class="d-inline">
                                                <span class="material-icons material-icons-outlined" style="color: #ffa500; font-size: 10px !important;">tag</span>
                                                <!-- track id - bc -->
                                                <span class="barcode-font text-muted" style="color: #ffa500; font-size: 10px !important;">
                                                    Plylstid_0000001_Trackid_0000002
                                                </span>
                                                <!-- ./ track id - bc -->
                                            </div>

                                            <button class="onefit-buttons-style-light shadow p-2 my-2" style="transform: translate(0) !important;" type="button" data-bs-toggle="collapse" data-bs-target="#TrackOptions-Plylstid_0000001_Trackid_0000002" aria-expanded="false" aria-controls="TrackOptions-Plylstid_0000001_Trackid_0000002">
                                                <div class="row align-items-center w-100">
                                                    <div class="col">
                                                        <span class="material-icons material-icons-round shadow-lg" style="font-size: 20px !important;">
                                                            pause
                                                        </span>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        (00:00) Song Title
                                                    </div>
                                                    <div class="col text-end">
                                                        <span class="material-icons material-icons-round">read_more</span>
                                                    </div>
                                                </div>
                                            </button>

                                            <!-- track options -->
                                            <div class="collapse w3-animate-right" id="TrackOptions-Plylstid_0000001_Trackid_0000002">
                                                <div class="row">
                                                    <div class="col-md d-grid align-items-center">
                                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('togglePlay')"><span class="material-icons material-icons-round">play_circle</span></button>
                                                    </div>
                                                    <div class="col-md">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Like</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">thumb_up</span></li>
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Share</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">share</span></li>
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Save</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">favorite</span></li>
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">follow</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">follow_the_signs</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- ./ track options -->
                                        </li>
                                        <li class="list-group-item d-grid comfortaa-font bg-transparent d-block">
                                            <div class="d-inline">
                                                <span class="material-icons material-icons-outlined" style="color: #ffa500; font-size: 10px !important;">tag</span>
                                                <!-- track id - bc -->
                                                <span class="barcode-font text-muted" style="color: #ffa500; font-size: 10px !important;">
                                                    Plylstid_0000001_Trackid_0000003
                                                </span>
                                                <!-- ./ track id - bc -->
                                            </div>

                                            <button class="onefit-buttons-style-light shadow p-2 my-2" style="transform: translate(0) !important;" type="button" data-bs-toggle="collapse" data-bs-target="#TrackOptions-Plylstid_0000001_Trackid_0000003" aria-expanded="false" aria-controls="TrackOptions-Plylstid_0000001_Trackid_0000003">
                                                <div class="row align-items-center w-100">
                                                    <div class="col">
                                                        <span class="material-icons material-icons-round shadow-lg" style="font-size: 20px !important;">
                                                            pause
                                                        </span>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        (00:00) Song Title
                                                    </div>
                                                    <div class="col text-end">
                                                        <span class="material-icons material-icons-round">read_more</span>
                                                    </div>
                                                </div>
                                            </button>

                                            <!-- track options -->
                                            <div class="collapse w3-animate-right" id="TrackOptions-Plylstid_0000001_Trackid_0000003">
                                                <div class="row">
                                                    <div class="col-md d-grid align-items-center">
                                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('togglePlay')"><span class="material-icons material-icons-round">play_circle</span></button>
                                                    </div>
                                                    <div class="col-md">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Like</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">thumb_up</span></li>
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Share</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">share</span></li>
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Save</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">favorite</span></li>
                                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">follow</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">follow_the_signs</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- ./ track options -->
                                        </li>
                                    </ul>
                                    <!-- ./ selected playlist track list -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="TabProfile" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">account_circle</span> Profile</h5>

                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>
                    <!-- <h1 class="text-center">Profile</h1>
                    <hr class="text-white" /> -->

                    <div id="profile-panel-container">
                        <!-- Profile Tab: User Profile -->
                        <div class='container comfortaa-font rounded-pillz shadow pb-4 px-0 m-0z text-white w-100' style='border-radius: 25px; background-color: #343434; overflow: hidden'>
                            <div class='text-center'>
                                <!--<span class='material-icons material-icons-round' style='font-size: 48px !important'> account_circle </span>-->

                                <!-- Users Profile Banner -->
                                <div class="shadow-lg" style="height: 400px; width: 100%; overflow: hidden; background-image: url('../media/images/fitness/Battle-ropes-Cordes-ondulatoires-EVO-Fitness-1200x675.jpg'); background-position: center; background-attachment: local; background-clip: content-box; background-size: cover">
                                </div>
                                <!-- ./ Users Profile Banner -->

                                <!-- Profile Picture -->
                                <div style="margin-top: -100px !important">
                                    <?php echo $currentUserAccountProdImg; ?>
                                </div>
                                <!-- ./ Profile Picture -->
                                <p class='outfit-font mt-2 username-tag' hidden>@<?php echo $currentUser_Usrnm; ?></p>
                            </div>
                            <!--<hr class='text-white' />-->
                            <ol class='list-group list-group-numberedz list-group-flush'>
                                <li class='list-group-item d-flex justify-content-between align-items-start bg-transparent text-white'>
                                    <div class='ms-2 me-auto'>
                                        <div class='fw-bold users-name-tag fs-5' style='color: #ffa500'>
                                            <?php echo $usrprof_name . " " . $usrprof_surname; ?>
                                        </div>
                                        <span class='username-tag'>@<?php echo $currentUser_Usrnm; ?></span><br />
                                        Lvl. 1
                                    </div>
                                    <span class='badge bg-primary rounded-pillz p-4' style='background-color: #ffa500 !important; color: #333 !important; border-radius: 25px'>
                                        <?php echo $verifIcon; ?>
                                    </span>
                                </li>
                                <li class='list-group-item d-flex justify-content-between align-items-start bg-transparent text-white'>
                                    <div class='ms-2 me-auto'>
                                        <div class='fw-bold' style='color: #ffa500'>Followers</div>
                                        <span>2 Mutual Friends</span><br />
                                        <span>6 Messages</span>
                                    </div>
                                    <span class='badge bg-primary rounded-pillz p-4' style='background-color: #ffa500 !important; color: #fff !important; border-radius: 25px'>
                                        <span class='material-icons material-icons-round' style='font-size: 20px !important'> people_alt </span>
                                        <span>6</span>
                                        <span>
                                </li>
                                <li class='list-group-item d-flex justify-content-between align-items-start bg-transparent text-white'>
                                    <div class='ms-2 me-auto'>
                                        <div class='fw-bold' style='color: #ffa500'>Achievements</div>
                                        <span>18 Activities Remaining</span><br />
                                        <span>4 Challenges Remaining</span>
                                    </div>
                                    <span class='badge bg-primary rounded-pillz p-4' style='background-color: #ffa500 !important; color: #fff !important; border-radius: 25px'>
                                        <span class='material-icons material-icons-round' style='font-size: 20px !important'> emoji_events </span>
                                        <span>3</span>
                                    </span>
                                </li>
                            </ol>

                            <!--Users Social Media Links-->
                            <div id='userSocialItems'><?php echo $userSocialItemsList; ?></div>

                            <div class='row my-4 px-4 align-items-start'>
                                <div class='col-lg p-4' style="max-height: 100vh; overflow-y: auto;">
                                    <!-- Share an Update -->
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
                                    <div id='profileUsersPostsList' style='max-height: 100vh, overflow-y: auto;'><?php echo $outputProfileUsersPostsList; ?></div>
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
                            </div>

                            <div class="p-4">
                                <h5 class='fs-1'>Followers</h5>
                                <hr class='text-white' style='height: 5px;'>
                                <div class="grid-container mb-4">

                                </div>

                                <h5 class='fs-1'>Following</h5>
                                <hr class='text-white' style='height: 5px;'>
                                <div class="grid-container mb-4">

                                </div>
                            </div>
                        </div>
                        <!-- ./ Profile Tab: User Profile -->
                    </div>

                </div>
                <div id="TabDiscovery" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-midde" style="color: #ffa500 !important; font-size: 40px;">travel_explore</span> Discovery</h5>
                        <p class="text-center" style="font-size: 10px">powered by AdaptEngine™</p>

                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <div class="row align-items-center my-4">
                        <div class="col-md-10">
                            <input type="search" class="onefit-inputs-style" id="discover-search-input" placeholder="Search" />
                        </div>
                        <div class="col-md-2 text-left">
                            <button class="onefit-buttons-style-light my-4" id="search-discover">
                                <i class="fas fa-search m-4"></i>
                            </button>
                        </div>
                    </div>

                    • Trainees • Trainers • Onefoodie - Healthy Food and Diet Catalogue • Fitness Programs (Categories: Casual,
                    Home, Gym, Athlete "A-Prog", Sports / Team-Based "S-Prog"/"TBA-Prog") • Wellness Programs (Categories:
                    Physical
                    Health, Mental Health, Sports Rehabilitation, Lifestyle) • FitEngine (Internal curated re-search engine)
                    powered
                    by AdaptEngine™

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab-discovery" role="tablist" style="border-color: #ffa500 !important">
                            <button class="nav-link p-4 active" id="nav-discovery-trainers-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-trainers" type="button" role="tab" aria-controls="nav-discovery-trainers" aria-selected="true">Trainers</button>

                            <button class="nav-link p-4" id="nav-discovery-trainees-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-trainees" type="button" role="tab" aria-controls="nav-discovery-trainees" aria-selected="false">Trainees</button>

                            <button class="nav-link p-4" id="nav-discovery-groups-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-groups" type="button" role="tab" aria-controls="nav-discovery-groups" aria-selected="false">Groups</button>

                            <button class="nav-link p-4" id="nav-discovery-posts-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-posts" type="button" role="tab" aria-controls="nav-discovery-posts" aria-selected="false">Community Updates</button>

                            <button class="nav-link p-4" id="nav-discovery-onefoodie-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-onefoodie" type="button" role="tab" aria-controls="nav-discovery-onefoodie" aria-selected="false">Onefoodie&trade;</button>

                            <button class="nav-link p-4" id="nav-discovery-fit-progs-indi-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-fit-progs-indi" type="button" role="tab" aria-controls="nav-discovery-fit-progs-indi" aria-selected="false">Indi-Fitness</button>

                            <button class="nav-link p-4" id="nav-discovery-fit-progs-team-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-fit-progs-team" type="button" role="tab" aria-controls="nav-discovery-fit-progs-team" aria-selected="false">Team-Fitness</button>

                            <button class="nav-link p-4" id="nav-discovery-well-progs-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-well-progs" type="button" role="tab" aria-controls="nav-discovery-well-progs" aria-selected="false">Wellness Programs</button>

                            <button class="nav-link p-4" id="nav-discovery-fitengine-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-fitengine" type="button" role="tab" aria-controls="nav-discovery-fitengine" aria-selected="false">FitEngine&trade;</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tab-DiscoveryContent">
                        <div class="tab-pane fade show active" id="nav-discovery-trainers" role="tabpanel" aria-labelledby="nav-discovery-trainers-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Onefit.Net - Trainers</h1>

                            <div class="grid-container">
                                <?php echo $discoveryAllTrainers; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-trainees" role="tabpanel" aria-labelledby="nav-discovery-trainees-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Onefit.Net - Trainees</h1>

                            <div class="grid-container">
                                <?php echo $discoveryAllTrainees; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="nav-discovery-groups" role="tabpanel" aria-labelledby="nav-discovery-groups-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Onefit.Net - Groups</h1>

                            <div class="grid-container">
                                <?php echo $outputCommunityGroups; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-posts" role="tabpanel" aria-labelledby="nav-discovery-posts-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Onefit.Net - Community Updates</h1>

                            <div class="text-center" id="comm-updates-search-container">
                                <?php echo $outputCommunityUpdates; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-onefoodie" role="tabpanel" aria-labelledby="nav-discovery-onefoodie-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Onefoodie Diet Bar</h1>

                            <div class="d-flex justify-content-center my-4">
                                <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-fit-progs-indi" role="tabpanel" aria-labelledby="nav-discovery-fit-progs-indi-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Indi.Fitness Programs</h1>
                            <div class="grid-container">
                                <?php echo $discoveryFitProgsIndi; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-fit-progs-team" role="tabpanel" aria-labelledby="nav-discovery-fit-progs-team-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Team-Athletics Training Programs</h1>
                            <div class="grid-container">
                                <?php echo $discoveryFitProgsTeams; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-well-progs" role="tabpanel" aria-labelledby="nav-discovery-well-progs-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Wellness &amp; Rehabilitation Programs</h1>

                            <div class="d-flex justify-content-center my-4">
                                <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-fitengine" role="tabpanel" aria-labelledby="nav-discovery-fitengine-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">FitEngine Resources</h1>

                            <div class="d-flex justify-content-center my-4">
                                <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <div class="grid-container">
                                <?php echo $outputCommunityResources; ?>
                            </div>
                        </div>


                    </div>
                </div>
                <div id="TabStudio" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-midde" style="color: #ffa500 !important; font-size: 40px;">play_circle_outline</span> <span style="color: #fff !important"> <span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Studio</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>
                    <!-- <h1 class="text-center"><span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Studio
                    </h1>
                    <hr class="text-white" /> -->

                    • Onefit.Community Streams (Onefit.tv) – Live stream sessions of scheduled Community (public) & Group-based
                    fitness program guidance classes. (Scheduled Program Guidance Classes and Community Events on Onefit App and
                    Socials that are open to all visitors, casual subscribers, and premium members (Onefit.app, Zoom, Skype,
                    Teams)
                    • Personal Training Centre – Scheduling of Private/One-On-One Live Streams and/or physical interaction with
                    Personal Trainers (Streams: Onefit.app, Zoom, Skype, Teams | Physical: Your nearest Gym Company Gym/nearest
                    Virgin Active and House-Call) • Stream library – Live stream recording history (Community and Private) •
                    Onefit.Muse (Music Centre/Music Playlist) • Athlete Fitness Programs • Team-Based Athletic Programs •
                    Individual
                    Home and Gym Fitness
                    Programs • Diet Programs (Pre-Defined & Custom)

                    <div class="grid-container studio-tab-grid">
                        <div class="grid-tile shadow p-4 down-top-grad-dark">
                            <!-- -100 max-100vh-->
                            <h2 class="text-center"><span class="material-icons material-icons-outlined"> tv </span> <span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Community Streams (Onefit.tv)</h2>
                            <p>Live stream sessions of scheduled Community (public) & Group-based fitness program guidance classes.
                                (Scheduled Program Guidance Classes and Community Events on Onefit App and Socials that are open to all
                                visitors, casual subscribers, and premium members (Onefit.app, Zoom, Skype, Teams)</p>

                            <!--<video preload="none" id="player" class="player" settings controls crossorigin data-poster="../media/assets/YouTube Thumbnail 1280x720 px.gif"></video>-->
                            <hr class="text-white" style="height: 5px;">

                            <p style="font-size: 10px">Latest Training Programs | <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span></p>

                            <div class="video-card-container">
                                <img src="../media/assets/YouTube Thumbnail 1280x720 px.gif" alt="" class="img-fluid shadow" />
                                <button class="onefit-buttons-style-light shadow play-btn p-4" onclick="playVideo()">
                                    <span class="material-icons material-icons-round" style="font-size: 50px !important;">
                                        play_circle_outline
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid-container studio-tab-grid">
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4>Stream library</h4>
                            <p>Live stream recording history (Community and Private)</p>
                            <hr class="text-white" />
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4>Personal Training Centre</h4>
                            <p>Scheduling of Private/One-On-One Live Streams and/or physical interaction with Personal Trainers
                                (Streams: Onefit.app, Zoom, Skype, Teams | Physical: Your nearest Gym Company Gym/nearest Virgin Active
                                and House-Call)</p>
                            <hr class="text-white" />
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4><span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Muse<span class="material-icons material-icons-round">
                                    equalizer
                                </span>
                            </h4>
                            <p>Music Centre/Music Playlist</p>

                            <hr class="text-white" />
                            <p class="outfit-font fw-bold text-center">No media playing.</p>
                            <div class="text-center">
                                <div class="row my-4">
                                    <div class="col-sm">
                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('prev')"><span class="material-icons material-icons-round">skip_previous</span></button>
                                    </div>
                                    <div class="col-sm">
                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('togglePlay')"><span class="material-icons material-icons-round">play_circle</span></button>
                                    </div>
                                    <div class="col-sm">
                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('next')"><span class="material-icons material-icons-round">skip_next</span></button>
                                    </div>
                                </div>
                            </div>

                            <!--  -->
                            <div class="row">
                                <div class="col-md-4 p-0">

                                    <p>Playlists</p>

                                    <hr class="text-white">
                                    <div class="p-4 d-grid gap-2">
                                        <button class="onefit-buttons-style-tahiti p-4 shadow mb-4 comfortaa-font">
                                            + Share your <br><span class="fw-bold fs-5" style="color: #fff !important;">Original Music</span>
                                        </button>

                                        <img src="../media/assets/muse_thumbnails/Gym-Playlist-Energetic-Tracks-For-Workout-Fitness-English-2018-20180602225519-500x500.jpg" class="img-fluid shadow my-2" style="border-radius: 25px;" alt="example thumbnail">

                                        <img src="../media/assets/muse_thumbnails/Gym-Playlist-Energetic-Tracks-For-Workout-Fitness-English-2018-20180602225519-500x500.jpg" class="img-fluid shadow my-2" style="border-radius: 25px;" alt="example thumbnail">

                                        <img src="../media/assets/muse_thumbnails/Gym-Playlist-Energetic-Tracks-For-Workout-Fitness-English-2018-20180602225519-500x500.jpg" class="img-fluid shadow my-2" style="border-radius: 25px;" alt="example thumbnail">
                                    </div>
                                </div>
                                <div class="col-md-8 p-0">
                                    <p>Tracks</p>
                                    <hr class="text-white">

                                    <!-- track information and visualizer container -->
                                    <div class="p-0 tunnel-bg-container-static" id="track-info-visualizer-container" style="border-radius: 25px 25px 0 0 !important; overflow: hidden;">
                                        <div class="down-top-grad-dark p-4 h-100 w-100">
                                            <div class="row align-items-center">
                                                <div class="col-md -4 text-center">
                                                    <!--Thumbnail-->
                                                    <div class="p-0 shadow" style="min-height: 20vh; border-radius: 25px; color: #fff; background-color: #343434; overflow: hidden;">
                                                        <div class="card bg-dark text-white border-0">
                                                            <!-- style="border-radius: 25px !important;" -->
                                                            <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="card-img" alt="..."> <!-- style="border-radius: 25px !important;" -->
                                                            <div class="card-img-overlay down-top-grad-dark d-grid align-items-end">
                                                                <!-- style="border-radius: 25px !important;" -->
                                                                <div class="text-start">
                                                                    <h5 class="card-title" style="color: #ffa500 !important;">Card title</h5>
                                                                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                                                    <p class="card-text text-muted">Last updated 3 mins ago</p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--./ Thumbnail-->

                                                    <div class="d-grid gap-2 w-100">
                                                        <button class="onefit-buttons-style-dark shadow p-2 px-4 my-4" id="museplayer-togglebtn" type="button" data-bs-toggle="collapse" data-bs-target="#song-playid-songid" aria-expanded="false" aria-controls="song-playid-songid">
                                                            <div class="row align-items-center w-100 text-center">
                                                                <div class="col-sm rounded-pill shadow-sm bg-whitez">
                                                                    <span class="material-icons material-icons-round" style="font-size: 50px !important;">
                                                                        art_track
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm py-4">
                                                                    Song Title (00:00)
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="col-xlg-8 mb-4 collapse show showz w3-animate-right text-white" id="song-playid-songid">

                                                    Song Information
                                                </div>
                                            </div>

                                            <!-- music player controller buttons *use main controllers -->
                                            <!-- <div class="text-center">
                                                <hr class="text-white">
                                                <div class="row my-4">
                                                    <div class="col -sm">
                                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('prev')"><span class="material-icons material-icons-round">skip_previous</span></button>
                                                    </div>
                                                    <div class="col -sm">
                                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('togglePlay')"><span class="material-icons material-icons-round">play_circle</span></button>
                                                    </div>
                                                    <div class="col -sm">
                                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('next')"><span class="material-icons material-icons-round">skip_next</span></button>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- ./ music player controller buttons -->
                                        </div>

                                    </div>
                                    <!-- ./ track information and visualizer container -->

                                    <!-- selected playlist track list -->
                                    <ul class="list-group list-group-flush list-group-numberedz text-white" style="border-radius: 0 0 25px 25px !important; overflow: hidden; background-color: #343434 !important;">
                                        <li class="list-group-item d-grid comfortaa-font bg-transparent d-block">
                                            <div class="d-inline">
                                                <span class="material-icons material-icons-outlined" style="color: #ffa500; font-size: 10px !important;">tag</span>
                                                <!-- track id - bc -->
                                                <span class="barcode-font text-muted" style="color: #ffa500; font-size: 10px !important;">
                                                    Plylstid_0000001_Trackid_0000001
                                                </span>
                                                <!-- ./ track id - bc -->
                                            </div>


                                            <button class="onefit-buttons-style-light shadow p-2 my-2" style="transform: translate(0) !important;" type="button" data-bs-toggle="collapse" data-bs-target="#TrackOptions-Plylstid_0000001_Trackid_0000001" aria-expanded="false" aria-controls="TrackOptions-Plylstid_0000001_Trackid_0000001">
                                                <div class="row align-items-center w-100">
                                                    <div class="col">
                                                        <span class="material-icons material-icons-round shadow-lg" style="font-size: 20px !important;">
                                                            play_arrow
                                                        </span>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        (00:00) Song Title
                                                    </div>
                                                    <div class="col text-end">
                                                        <span class="material-icons material-icons-round">read_more</span>
                                                    </div>
                                                </div>
                                            </button>

                                            <!-- track options -->
                                            <div class="collapse w3-animate-right" id="TrackOptions-Plylstid_0000001_Trackid_0000001">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Like</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">thumb_up</span></li>
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Share</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">share</span></li>
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Save</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">favorite</span></li>
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">follow</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">follow_the_signs</span></li>
                                                </ul>
                                            </div>
                                            <!-- ./ track options -->
                                        </li>
                                        <li class="list-group-item d-grid comfortaa-font bg-transparent d-block">
                                            <div class="d-inline">
                                                <span class="material-icons material-icons-outlined" style="color: #ffa500; font-size: 10px !important;">tag</span>
                                                <!-- track id - bc -->
                                                <span class="barcode-font text-muted" style="color: #ffa500; font-size: 10px !important;">
                                                    Plylstid_0000001_Trackid_0000002
                                                </span>
                                                <!-- ./ track id - bc -->
                                            </div>

                                            <button class="onefit-buttons-style-light shadow p-2 my-2" style="transform: translate(0) !important;" type="button" data-bs-toggle="collapse" data-bs-target="#TrackOptions-Plylstid_0000001_Trackid_0000002" aria-expanded="false" aria-controls="TrackOptions-Plylstid_0000001_Trackid_0000002">
                                                <div class="row align-items-center w-100">
                                                    <div class="col">
                                                        <span class="material-icons material-icons-round shadow-lg" style="font-size: 20px !important;">
                                                            play_arrow
                                                        </span>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        (00:00) Song Title
                                                    </div>
                                                    <div class="col text-end">
                                                        <span class="material-icons material-icons-round">expand_circle_down</span>
                                                    </div>
                                                </div>
                                            </button>

                                            <!-- track options -->
                                            <div class="collapse w3-animate-right" id="TrackOptions-Plylstid_0000001_Trackid_0000002">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Like</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">thumb_up</span></li>
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Share</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">share</span></li>
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Save</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">favorite</span></li>
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">follow</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">follow_the_signs</span></li>
                                                </ul>
                                            </div>
                                            <!-- ./ track options -->
                                        </li>
                                        <li class="list-group-item d-grid comfortaa-font bg-transparent d-block">
                                            <div class="d-inline">
                                                <span class="material-icons material-icons-outlined" style="color: #ffa500; font-size: 10px !important;">tag</span>
                                                <!-- track id - bc -->
                                                <span class="barcode-font text-muted" style="color: #ffa500; font-size: 10px !important;">
                                                    Plylstid_0000001_Trackid_0000003
                                                </span>
                                                <!-- ./ track id - bc -->
                                            </div>

                                            <button class="onefit-buttons-style-light shadow p-2 my-2" style="transform: translate(0) !important;" type="button" data-bs-toggle="collapse" data-bs-target="#TrackOptions-Plylstid_0000001_Trackid_0000003" aria-expanded="false" aria-controls="TrackOptions-Plylstid_0000001_Trackid_0000003">
                                                <div class="row align-items-center w-100">
                                                    <div class="col">
                                                        <span class="material-icons material-icons-round shadow-lg" style="font-size: 20px !important;">
                                                            play_arrow
                                                        </span>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        (00:00) Song Title
                                                    </div>
                                                    <div class="col text-end">
                                                        <span class="material-icons material-icons-round">more</span>
                                                    </div>
                                                </div>
                                            </button>

                                            <!-- track options -->
                                            <div class="collapse w3-animate-right" id="TrackOptions-Plylstid_0000001_Trackid_0000003">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Like</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">thumb_up</span></li>
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Share</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">share</span></li>
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">Save</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">favorite</span></li>
                                                    <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-end"> <span class="align-middle">follow</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">follow_the_signs</span></li>
                                                </ul>
                                            </div>
                                            <!-- ./ track options -->
                                        </li>
                                    </ul>
                                    <!-- ./ selected playlist track list -->
                                </div>
                            </div>

                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4>Indi-Home and Gym</h4>
                            <p>Home and Gym Fitness Programs &amp; Guides for Individuals</p>
                            <hr class="text-white" />
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4>Indi-Athletics Fitness</h4>
                            <p>Advanced Athletic Fitness Programs &amp; Guides for Individuals.</p>
                            <hr class="text-white" />
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4>Team-Based Athletics</h4>
                            <p>Athletic Fitness Programs for Teams in Sports.</p>
                            <hr class="text-white" />
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4>Diet Menu</h4>
                            <p>Healthy Eating Guide</p>
                            <hr class="text-white" />
                        </div>
                    </div>
                </div>
                <div id="TabStore" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-midde" style="color: #ffa500 !important; font-size: 40px;">storefront</span> <span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Store</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>
                    <!-- <h1 class="text-center"><span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Store
                    </h1>
                    <hr class="text-white" /> -->

                    • Sale of Activity Trackers and Smart Watches (wearables) • Sale of Fitness Equipment (weights, weight
                    benches,
                    treadmills, scales, etc.) • Sale of Supplements and Vitamins • Sale of Membership Subscriptions (3 Month, 6
                    Month, and Annual)

                    <img src="../media/assets/smartwatches/Watch Banner.png" alt="" class="img-fluid w-100 my-4 shadow" style="border-radius: 25px;">

                    <!-- Store Items Container -->
                    <div class="p-4" style="background-color: #343434; border-radius: 25px;">
                        <h5 class="fs-1 fw-bold text-center mb-4">
                            Browse our range of smart watches and activity trackers, weight-lifting and exercise equipment, fitness accessories, apparel, and more!...
                        </h5>
                        <p class="text-center">Need some stuff for your fitness journey, we have you coverd. Browse our selection of products and get them delivered to your door for free. It is in your benefit to become a Member of the Onefit Community today because all registered users and Premium Mmembers get Loyalty Discounts on every purchase. Go ahead and Register today, or better yet, become a Member to reap greater fitness rewards.</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="d-grid gap-2 d-lg-none d-xl-none d-xxl-none">
                                    <button class="onefit-buttons-style-dark p-4 mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#store-items-nav-menu" aria-expanded="true" aria-controls="store-items-nav-menu">
                                        <div class="d-grid gap-2">
                                            <span class="material-icons material-icons-round"> menu </span>
                                            <p style="font-size: 10px;">Store Items</p>
                                        </div>
                                    </button>
                                </div>
                                <div class="collapse show w3-animate-bottom" id="store-items-nav-menu">
                                    <div class="nav flex-column nav-pills" id="v-pills-store-Equipment-tab" role="tablist" aria-orientation="vertical">
                                        <button class="nav-link active" id="v-pills-social-store-wearables-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-wearables" type="button" role="tab" aria-controls="v-pills-social-store-wearables" aria-selected="true">
                                            <span class="material-icons material-icons-outlined">watch</span>
                                            <p>Wearables</p>
                                        </button>
                                        <button class="nav-link" id="v-pills-social-store-weights-bumbells-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-weights-bumbells" type="button" role="tab" aria-controls="v-pills-social-store-weights-bumbells" aria-selected="false">
                                            <div class="d-grid gap-2">
                                                <span class="material-icons material-icons-round">fitness_center</span>
                                                <p style="font-size: 10px;">Weights &amp; Dumbells</p>
                                            </div>
                                        </button>
                                        <button class="nav-link" id="v-pills-social-store-equipment-exercisemachines-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-equipment-exercisemachines" type="button" role="tab" aria-controls="v-pills-social-store-equipment-exercisemachines" aria-selected="false">
                                            <div class="d-grid gap-2">
                                                <span class="material-icons material-icons-round">monitor_weight</span>
                                                <p style="font-size: 10px;">Exercise Machines</p>
                                            </div>
                                        </button>
                                        <button class="nav-link" id="v-pills-social-store-fitness-accessories-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-fitness-accessories" type="button" role="tab" aria-controls="v-pills-social-store-fitness-accessories" aria-selected="false">
                                            <div class="d-grid gap-2">
                                                <span class="material-icons material-icons-round">backpack</span>
                                                <p style="font-size: 10px;">Fitness Accessories</p>
                                            </div>
                                        </button>
                                        <button class="nav-link" id="v-pills-social-store-apparel-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-apparel" type="button" role="tab" aria-controls="v-pills-social-store-apparel" aria-selected="false">
                                            <div class="d-grid gap-2">
                                                <span class="material-icons material-icons-round">checkroom</span>
                                                <p style="font-size: 10px;">Apparel</p>
                                            </div>
                                        </button>
                                        <button class="nav-link" id="v-pills-social-store-nutrition-supplements-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-nutrition-supplements" type="button" role="tab" aria-controls="v-pills-social-store-nutrition-supplements" aria-selected="false">
                                            <div class="d-grid gap-2">
                                                <span class="material-icons material-icons-round">medication</span>
                                                <p style="font-size: 10px;">Nutrition &amp; Supplements</p>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active w3-animate-right" id="v-pills-social-store-wearables" role="tabpanel" aria-labelledby="v-pills-social-store-wearables-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Smart Watches &amp; Activity Trackers</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                        <!-- Smart watch Card Grid -->
                                        <div class="container">
                                            <div class="grid-container" id="store-smart-watch-grid-container">
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Aiwa Smart Band ASB-40</h5>
                                                        <h5 class="card-title">R149</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets//smartwatches/Apple Watch Series 3 GPS 38mm Silver Aluminium Case - White Sport Band R4400.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Apple Watch Series 3 GPS 38mm Silver Aluminium Case - White Sport Band</h5>
                                                        <h5 class="card-title">R4400</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/apple-watch-series-3-receives-a-massive-discount-530399-2.jpg" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Apple Watch Series 3</h5>
                                                        <h5 class="card-title">R4500</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Astrum Wireless Bluetooth IP68 Sports Smart Watch - M2 Black R639.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Astrum Wireless Bluetooth IP68 Sports Smart Watch - M2 Black</h5>
                                                        <h5 class="card-title">R639</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/FITBIT ALTA HR LARGE BLUE_GREY FITNESS TRACKER R24999.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">fitbit Alta HR Large Blue / Grey Fitness Tracker</h5>
                                                        <h5 class="card-title">R2499</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Fitbit Charge 4 Activity Tracker R2900.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Fitbit Charge 4 Activity Tracker</h5>
                                                        <h5 class="card-title">R2900</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/fitbit-versa2-3qtr-black.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">fitbit Versa 2 3QTR Black</h5>
                                                        <h5 class="card-title">R1999</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/FocusFit Pro - X3C IP68 Smartwatch and Fitness Tracker R798.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">FocusFit Pro - X3C IP68 Smartwatch and Fitness Tracker</h5>
                                                        <h5 class="card-title">R798</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/FocusFit Pro-T500 Smartwatch and Fitness Tracker R348.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">FocusFit Pro-T500 Smartwatch and Fitness Tracker</h5>
                                                        <h5 class="card-title">R348</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/G30 smartwatch-heartrate monitor-bluetooth call-blood pressure (black) R799.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">G30 smartwatch-heartrate monitor-bluetooth call-blood pressure (black)</h5>
                                                        <h5 class="card-title">R799</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Genius F2 Activity Smart Watch R579.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Genius F2 Activity Smart Watch</h5>
                                                        <h5 class="card-title">R579</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/HUAWEI WATCH GT 2e Black R2899.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">HUAWEI WATCH GT 2e Black</h5>
                                                        <h5 class="card-title">R2899</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Series 7 Smart Watch Black R549.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Series 7 Smart Watch Black</h5>
                                                        <h5 class="card-title">R549</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/SM-R500NZKABTU_samsung_watch_01.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">SM-R500NZKABTU Samsung Watch</h5>
                                                        <h5 class="card-title">R2990</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Tempo Pulse 2.0 Black Fitness Watch R999.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Tempo Pulse 2.0 Black Fitness Watch</h5>
                                                        <h5 class="card-title">R999</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Xiaomi - Mi Smart Band 4 Android & iOS Fitness Watch - Black R189.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Xiaomi - Mi Smart Band 4 Android & iOS Fitness Watch - Black</h5>
                                                        <h5 class="card-title">R189</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./ Smart watch Card Grid -->
                                    </div>
                                    <div class="tab-pane fade show w3-animate-right" id="v-pills-social-store-weights-bumbells" role="tabpanel" aria-labelledby="v-pills-social-store-weights-bumbells-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Weights &amp; Dumbells</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show w3-animate-right" id="v-pills-social-store-equipment-exercisemachines" role="tabpanel" aria-labelledby="v-pills-social-store-equipment-exercisemachines-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Exercise Machines</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show w3-animate-right" id="v-pills-social-store-fitness-accessories" role="tabpanel" aria-labelledby="v-pills-social-store-fitness-accessories-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Fitness Accessories</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show w3-animate-right" id="v-pills-social-store-apparel" role="tabpanel" aria-labelledby="v-pills-social-store-apparel-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Apparel</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show w3-animate-right" id="v-pills-social-store-nutrition-supplements" role="tabpanel" aria-labelledby="v-pills-social-store-nutrition-supplements-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Nutrition &amp; Supplements</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                        <!-- Meds and Supplements Card Grid -->
                                        <h5 class="fs-1 fw-bold"><span class="material-icons material-icons-round"> medication </span> Supplements and Vitamins</h5>
                                        <div class="card-group">
                                            <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title fs-4">Supplement 1</h5>
                                                    <h5 class="card-title">Supplement Price</h5>
                                                    <p class="card-text">Supplement Description.</p>
                                                    <hr>
                                                    <p class="card-text">Supplement Features</p>
                                                    <ol class="list-group list-group-numbered">
                                                        <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                        <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                        <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                        <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                        <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                    </ol>
                                                </div>
                                                <div class="card-footer d-grid">
                                                    <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                        Add to Cart
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Meds and Supplements Card Grid -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./ Store Items Container -->

                    <!-- Membership Sales Card Grid -->
                    <h5 class="fs-1 fw-bold text-center my-4"><span class="material-icons material-icons-round"> verified_user </span> Membership </h5>
                    <div class="card-groupz grid-container">
                        <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Community Fitness - Free</h5>
                                <p class="card-text">The Community Fitness account offers Trainees with access to the Onefit Community Content and Group Training Programs.
                                    Sign up today to get access to over 100 curated fitness prograns and tailored suggestions, including fitness and wellness tracking features.</p>

                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Fitness Programs and Resources</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Live Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Group-Training Community Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                </ol>
                            </div>
                            <div class="card-footer d-grid">
                                <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                    Free
                                </button>
                            </div>
                        </div>
                        <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Indi.Starter Training (Basic) - 3 Months</h5>
                                <p class="card-text">The Indi.Starter account offers Trainees access to Curated Premium Fitness Programs from Level-1 to Level-3 of our
                                    Catalogue as well as access to Personal Trainer Support services to make transitioning into Fitness Process much easier.</p>

                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                </ol>
                            </div>
                            <div class="card-footer d-grid">
                                <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                    R1800 (3 Months)
                                </button>
                            </div>
                        </div>
                        <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Indi.Pro Training (Pro) - 12 Months</h5>
                                <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>

                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Fitness Programs</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Live Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Group-Training Community Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Weekly</li>
                                </ol>
                            </div>
                            <div class="card-footer d-grid">
                                <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                    R5200 (12 Months)
                                </button>
                            </div>
                        </div>
                        <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Team.Pro Training (Pro) - Contact Sales</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                                    content.
                                    This card has even longer content than the first to show that equal height action.</p>

                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Fitness Programs</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Live Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Group-Training Community Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                </ol>
                            </div>
                            <div class="card-footer d-grid">
                                <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                    Contact Sales
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Membership Sales Card Grid -->
                </div>
                <div id="TabSocial" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-midde" style="color: #ffa500 !important; font-size: 40px;">hub</span> <span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Social</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>
                    <!-- <h1 class="text-center"><span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Social
                    </h1>
                    <hr class="text-white" /> -->

                    • Community Status Update Feed • Shared Resources Feed • Social Chat Messenger • Public Achievements • Public
                    Events Lineup (Community live stream) • Community Rewards Program

                    <!-- User Status Bar -->
                    <div class="horizontal-scroll py-4 no-scroller shadow">
                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Status 1</h5>
                        </div>
                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Status 2</h5>
                        </div>
                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Status 3</h5>
                        </div>
                    </div>
                    <!-- ./ User Status Bar -->

                    <!-- Post new update -->
                    <div class="container-lg" id="social-post-update-container">
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
                    <!-- ./ Post new update -->

                    <!-- Horizontal Tab Selection visible on screens smaller than lg and is fixed to bottom of viewport -->
                    <div class="navbar fixed-bottom navbar-style pb-0 mb-0 d-lg-none">
                        <div class="text-end w-100 align-items-center" style="margin-top: -100px">
                            <!-- toggle H-Menu Button -->
                            <button class="py-2 px-4 ms-0 me-4 shadow onefit-buttons-style-dark comfortaa-font" id="social-toggle-bottom-nav" type="button" data-bs-toggle="collapse" data-bs-target="#social-collapse-bottom-nav" aria-expanded="false" aria-controls="social-collapse-bottom-nav">
                                <!--style="background-color: #ffa500; color: #343434; border: 0; height: 60px; width: 60px"-->
                                <div class="d-grid">
                                    <span class="material-icons material-icons-round" style="font-size: 24px !important;">
                                        style
                                    </span>
                                    <p style="font-size: 10px;">Feeds</p>
                                </div>
                            </button>
                            <!-- ./ toggle H-Menu Button -->

                            <!-- Create button -->
                            <button class="py-2 px-4 ms-0 me-4 shadow onefit-buttons-style-dark comfortaa-font" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCreateCommandList" aria-expanded="false" aria-controls="collapseCreateCommandList">
                                <div class="d-grid">
                                    <span class="material-icons material-icons-round" style="font-size: 24px !important;">
                                        brush
                                    </span>
                                    <p style="font-size: 10px;">Create</p>
                                </div>
                            </button>

                            <div class="collapse p-4 w3-animate-bottom" id="collapseCreateCommandList">
                                <h3 class="text-center">Create Content</h3>
                                <hr class="bg-white">
                                <ul class="list-groupz list-group-flush list-group border-0 text-white fw-bold text-center comfortaa-font" style="overflow: initial !important;">
                                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Social Update</button></li>
                                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Community Resource</button></li>
                                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Share Media</button></li>
                                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Chat Message</button></li>
                                </ul>
                            </div>
                            <!-- ./ Create button -->
                        </div>
                        <div class="collapse w-100 p-4 w3-animate-bottom" id="social-collapse-bottom-nav">
                            <h3 class="text-center">Social Feeds</h3>
                            <hr class="bg-white">
                            <div class="containerz horizontal-scrollz no-scroller">
                                <div class="horizontal-scroll-cardz -nav">
                                    <ul class="nav nav-pills mb-3 align-items-center justify-content-center w-100" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="v-pills-social-commfeed-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-commfeed" type="button" role="tab" aria-controls="v-pills-social-commfeed" aria-selected="true">
                                                <div class="d-grid">
                                                    <p style="font-size: 5px;">Community Updates</p>
                                                    <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                                        dynamic_feed
                                                    </span>
                                                </div>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="v-pills-social-commrewards-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-commrewards" type="button" role="tab" aria-controls="v-pills-social-commrewards" aria-selected="false">
                                                <div class="d-grid">
                                                    <p style="font-size: 5px;">Community Rewards</p>
                                                    <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                                        loyalty
                                                    </span>
                                                </div>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="v-pills-social-resfeed-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-resfeed" type="button" role="tab" aria-controls="v-pills-social-resfeed" aria-selected="false">
                                                <div class="d-grid">
                                                    <p style="font-size: 5px;">Shared Resources</p>
                                                    <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                                        local_library
                                                    </span>
                                                </div>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="v-pills-social-groups-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-groups" type="button" role="tab" aria-controls="v-pills-social-groups" aria-selected="false">
                                                <div class="d-grid">
                                                    <p style="font-size: 5px;">Groups Feed</p>
                                                    <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                                        groups
                                                    </span>
                                                </div>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="v-pills-social-pubevents-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-pubevents" type="button" role="tab" aria-controls="v-pills-social-pubevents" aria-selected="false">
                                                <div class="d-grid">
                                                    <p style="font-size: 5px;">Event Lineup</p>
                                                    <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                                        stream
                                                    </span>
                                                </div>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="v-pills-social-pubachieve-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-pubachieve" type="button" role="tab" aria-controls="v-pills-social-pubachieve" aria-selected="false">
                                                <div class="d-grid">
                                                    <p style="font-size: 5px;">Public Achievements</p>
                                                    <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                                        military_tech
                                                    </span>
                                                </div>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="v-pills-social-followers-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-followers" type="button" role="tab" aria-controls="v-pills-social-followers" aria-selected="false">
                                                <div class="d-grid">
                                                    <p style="font-size: 5px;">0 Followers</p>
                                                    <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                                        group_add
                                                    </span>
                                                </div>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="v-pills-social-following-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-following" type="button" role="tab" aria-controls="v-pills-social-following" aria-selected="false">
                                                <div class="d-grid">
                                                    <p style="font-size: 5px;">0 Following</p>
                                                    <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                                        person_add
                                                    </span>
                                                </div>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./ Horizontal Tab Selection visible on screens smaller than lg and is fixed to bottom of viewport -->

                    <div class="row my-4 p-4 shadow" style="background-color: #333; border-radius: 25px">
                        <div class="col-sm-2 d-none d-lg-block">
                            <!-- Vertical Side Tab Selection visible only on lg screens -->
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-social-commfeed-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-commfeed" type="button" role="tab" aria-controls="v-pills-social-commfeed" aria-selected="true">
                                    <div class="d-grid">
                                        <p style="font-size: 5px;">Community Updates</p>
                                        <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                            dynamic_feed
                                        </span>
                                    </div>
                                </button>

                                <button class="nav-link" id="v-pills-social-commrewards-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-commrewards" type="button" role="tab" aria-controls="v-pills-social-commrewards" aria-selected="false">
                                    <div class="d-grid">
                                        <p style="font-size: 5px;">Community Rewards</p>
                                        <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                            loyalty
                                        </span>
                                    </div>
                                </button>

                                <button class="nav-link" id="v-pills-social-resfeed-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-resfeed" type="button" role="tab" aria-controls="v-pills-social-resfeed" aria-selected="false">
                                    <div class="d-grid">
                                        <p style="font-size: 5px;">Shared Resources</p>
                                        <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                            local_library
                                        </span>
                                    </div>
                                </button>

                                <button class="nav-link" id="v-pills-social-pubevents-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-pubevents" type="button" role="tab" aria-controls="v-pills-social-pubevents" aria-selected="false">
                                    <div class="d-grid">
                                        <p style="font-size: 5px;">Event Lineup</p>
                                        <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                            stream
                                        </span>
                                    </div>
                                </button>

                                <button class="nav-link" id="v-pills-social-pubachieve-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-pubachieve" type="button" role="tab" aria-controls="v-pills-social-pubachieve" aria-selected="false">
                                    <div class="d-grid">
                                        <p style="font-size: 5px;">Public Achievements</p>
                                        <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                            military_tech
                                        </span>
                                    </div>
                                </button>

                                <button class="nav-link" id="v-pills-social-followers-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-followers" type="button" role="tab" aria-controls="v-pills-social-followers" aria-selected="false">
                                    <div class="d-grid">
                                        <p style="font-size: 5px;">0 Followers</p>
                                        <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                            group_add
                                        </span>
                                    </div>
                                </button>

                                <button class="nav-link" id="v-pills-social-following-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-following" type="button" role="tab" aria-controls="v-pills-social-following" aria-selected="false">
                                    <div class="d-grid">
                                        <p style="font-size: 5px;">0 Following</p>
                                        <span class="material-icons material-icons-round" style="font-size: 24px !important">
                                            person_add
                                        </span>
                                    </div>
                                </button>

                            </div>
                            <!-- ./ Vertical Side Tab Selection visible only on lg screens -->
                        </div>
                        <div class="col-md-8">
                            <!-- .Social Main Content Tab Container -->
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane show active w3-animate-right" id="v-pills-social-commfeed" role="tabpanel" aria-labelledby="v-pills-social-commfeed-tab">
                                    <!-- style="max-height: 100vh !important; overflow-y: auto"-->
                                    <h5 class="fs-1 text-center rounded-pill p-4 shadow">Community Updates</h5>
                                    <div class="shadow">
                                        <div class="no-scroller px-2" id="Community-Posts" style="max-height: 100vh; overflow-y: auto; overflow-x: hidden; box-shadow: inset 0px 0px 40px 0px rgba(232, 138, 4, 1); border-radius: 25px">
                                            <!--rgba(232, 138, 4, 1)-->
                                            <?php echo $outputCommunityUpdates; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane w3-animate-right" id="v-pills-social-resfeed" role="tabpanel" aria-labelledby="v-pills-social-resfeed-tab">
                                    <h5 class="fs-1 text-center rounded-pill p-4 shadow">Community Resources</h5>
                                    <div id="Community-Resources" style="max-height: 100vh; overflow-y: auto; overflow-x: hidden;">
                                        <?php echo $outputCommunityResources; ?>
                                    </div>
                                </div>

                                <div class="tab-pane w3-animate-right" id="v-pills-social-groups" role="tabpanel" aria-labelledby="v-pills-social-groups-tab">
                                    <h5 class="fs-1 text-center rounded-pill p-4 shadow">Groups &amp; Clubs</h5>
                                    <div id="Community-Groups" style="max-height: 100vh; overflow-y: auto; overflow-x: hidden;">
                                        <?php echo $outputCommunityGroups; ?>
                                    </div>
                                </div>

                                <div class="tab-pane w3-animate-right" id="v-pills-social-pubevents" role="tabpanel" aria-labelledby="v-pills-social-pubevents-tab">
                                    <h5 class="fs-1 text-center rounded-pill p-4 shadow">Public Events Lineup (Community Live Stream)</h5>
                                    <div class="text-center my-4" style="padding: 100px 10px;">
                                        <small class="text-muted">No items to display. Check back soon.</small>
                                    </div>
                                </div>

                                <div class="tab-pane w3-animate-right" id="v-pills-social-pubachieve" role="tabpanel" aria-labelledby="v-pills-social-pubachieve-tab">
                                    <h5 class="fs-1 text-center rounded-pill p-4 shadow">Public Achievements Feed</h5>
                                    <div class="text-center my-4" style="padding: 100px 10px;">
                                        <small class="text-muted">No items to display. Check back soon.</small>
                                    </div>
                                </div>

                                <div class="tab-pane w3-animate-right" id="v-pills-social-followers" role="tabpanel" aria-labelledby="v-pills-social-followers-tab">
                                    <h5 class="fs-1 text-center rounded-pill p-4 shadow">Followers</h5>
                                    <div id="Community-Followers" style="max-height: 100vh; overflow-y: auto; overflow-x: hidden;">
                                        <?php echo $discoveryAllUsersList; ?>
                                    </div>
                                </div>

                                <div class="tab-pane w3-animate-right" id="v-pills-social-following" role="tabpanel" aria-labelledby="v-pills-social-following-tab">
                                    <h5 class="fs-1 text-center rounded-pill p-4 shadow">Following</h5>
                                    <div id="Community-Following" style="max-height: 100vh; overflow-y: auto; overflow-x: hidden;">
                                        <?php echo $discoveryAllUsersList; ?>
                                    </div>
                                </div>

                                <div class="tab-pane w3-animate-right" id="v-pills-social-commrewards" role="tabpanel" aria-labelledby="v-pills-social-commrewards-tab">
                                    <h5 class="fs-1 text-center rounded-pill p-4 shadow">Community Rewards Program</h5>
                                </div>
                            </div>
                            <!-- ./ .Social Main Content Tab Container -->
                        </div>
                        <div class="col-md">
                            <h5>Trending</h5>
                            <div class="text-center my-4" style="padding: 100px 10px;">
                                <small class="text-muted">No items to display. Check back soon.</small>
                            </div>
                            <hr class="text-white">

                            <h5>Who to follow</h5>
                            <div class="text-center my-4" style="padding: 100px 10px;">
                                <small class="text-muted">No items to display. Check back soon.</small>
                            </div>
                            <hr class="text-white">
                        </div>
                    </div>
                </div>
                <div id="TabData" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h1 class="text-center comfortaa-font">
                            <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">
                                insights
                            </span>
                            Fitness Insights
                        </h1>
                        <p class="text-center my-4 comfortaa-font">Use the Fitness Insights page to track your fitness progression and workout activities.</p>
                    </div>

                    <hr class="text-white" style="height: 5px;">

                    <!-- Timelines and Calender -->
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="my-4 fs-1 text-center">Fitness Calender</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <!-- Activity Calender -->
                    <div id="activities-calender"></div>
                    <!-- ./ Activity Calender -->

                    <!-- Vertical Activity Timeline of user -->

                    <div id="v-timeline" class="w-100 my-4 py-4 shadow border-5 border-bottom" style="background-color: #343434; border-radius: 25px; border-color: #ffa500 !important; overflow-x: auto;">
                        <div class="d-grid text-center">
                            <h5 class="my-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">
                                    view_timeline
                                </span> Activity Timeline
                            </h5>
                        </div>

                        <hr style="color: #ffa500;">

                        <div id="vertical-timeline-varusername no-scroller" style="max-height: 90vh; overflow: auto; border-radius: 25px;">
                            <div class="timeline" style="min-width: 500px; border-radius: 25px;">
                                <div class="timeline-container left">
                                    <div class="date comfortaa-font">15 Dec 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>

                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p class="mb-4">
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-container right">
                                    <div class="date comfortaa-font">22 Oct 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>
                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-container left">
                                    <div class="date comfortaa-font">10 Jul 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>
                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-container right">
                                    <div class="date comfortaa-font">18 May 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>
                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-container left">
                                    <div class="date comfortaa-font">10 Feb 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>
                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-container right">
                                    <div class="date comfortaa-font">01 Jan 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>
                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./ Vertical Activity Timeline of user -->

                    <!-- ./ Timeline and Calender -->

                    <hr class="text-white" style="height: 5px;">

                    <!-- User Smart Device Activity Tracking -->
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center">Activity Tracking</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <div class="container-lg p-4 shadow-lg d-inline-block border-5 border-start border-end" style="border-radius: 25px; border-color: #ffa500 !important; background-color: #343434">
                        <div class="row align-items-center text-center comfortaa-font">
                            <div class="col-sm py-2 text-truncate">
                                <!--<i class="fas fa-heart"></i>-->
                                <div class="d-inline">
                                    <span class="material-icons material-icons-round align-middle"> monitor_heart </span>
                                    <span class="align-middle">Heart rate</span>
                                </div>

                            </div>
                            <div class="col-sm py-2 text-truncate">
                                <div class="d-inline">
                                    <span class="align-middle" style="color: #ffa500">|</span>
                                </div>
                            </div>
                            <div class="col-sm py-2 text-truncate">
                                <!--<i class="fas fa-thermometer-half"></i>-->
                                <div class="d-inline">
                                    <span class="material-icons material-icons-round align-middle"> device_thermostat </span>
                                    <!-- Degree symbol html code: &#176; -->
                                    <span class="align-middle">Temp&#176;</span>
                                </div>
                            </div>
                            <div class="col-sm py-2 text-center">
                                <div class="d-inline">
                                    <button class="btn p-4 onefit-buttons-style-dark my-pulse-animation-tahiti border-5 border" style="border-radius: 25px !important; border-color: #ffa500 !important;" type="button" data-bs-toggle="modal" data-bs-target="#tabCaptureActivityTrackerDataModal">
                                        <!--  data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="heartrate-expand-icon heartrate-data-input-form-container" -->
                                        <img src="../media/assets/icons/icons8-smart-watch-50.png" alt="smartwatch" class="img-fluid mb-2" />
                                        <span class="material-icons material-icons-round">fitbit</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm py-2 text-truncate">
                                <!--<i class="fas fa-bolt"></i>-->
                                <div class="d-inline">
                                    <span class="material-icons material-icons-round align-middle"> bolt </span>
                                    <span class="align-middle">Speed</span>
                                </div>
                            </div>
                            <div class="col-sm py-2 text-truncate">
                                <div class="d-inline">
                                    <span class="align-middle" style="color: #ffa500">|</span>
                                </div>
                            </div>
                            <div class="col-sm py-2 text-truncate">
                                <!--<i class="fas fa-walking"></i>-->
                                <div class="d-inline">
                                    <span class="material-icons material-icons-round align-middle"> directions_walk </span>
                                    <span class="align-middle">Steps</span>
                                </div>
                            </div>
                        </div>

                        <hr class="text-white">

                        <!-- detailed metric list -->
                        <ul class="list-group list-group-flush text-white border-0">
                            <li class="list-group-item bg-transparent text-white" style="border-color: #ffa500;border-radius: 25px;">
                                <div class="row align-items-center">
                                    <div class="col-md -4 text-center">
                                        <h1 class="text-truncate">Heart Rate Monitor</h1>
                                        <div class="d-grid gap-2 mt-4">
                                            <span class="material-icons material-icons-round">
                                                favorite
                                            </span>
                                            <h1>65<span style="font-size: 10px;" class="align-top">BPM</span></h1>
                                            <p class="text-muted fw-bold">75 BPM, 5h ago</p>
                                        </div>

                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#heartrate-data-input-form-container" aria-expanded="false" aria-controls="heartrate-data-input-form-container">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button>
                                    </div>
                                    <div class="col-md -8 py-4 d-flex justify-content-center">

                                        <div class="in-div-button-container">
                                            <!-- refresh button -->
                                            <button class="onefit-buttons-style-light p-4 d-grid text-center in-div-btn mx-4" style="top: 0px !important;right: 0px !important;" onclick="refreshUserActivityTrackerChart('<?php echo $currentUser_Usrnm; ?>','heart_rate_monitor_chart')">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">update</span>
                                                <span class="align-middle" style="font-size: 10px;">Update.</span>
                                            </button>
                                            <!-- ./ refresh button -->

                                            <!-- Canvasjs chart canvas -->
                                            <div class="insight-chart-container no-scroller">
                                                <canvas class="chartjs-chart-light shadow" id="heart_rate_monitor_chart" width="400" height="400"></canvas>
                                            </div>
                                            <!-- ./Canvasjs chart canvas -->
                                        </div>

                                        <!-- submit heartrate data form -->
                                        <div id="heartrate-data-input-form-container" class="collapse mt-4 p-4 mb-4 w3-animate-bottom border-5 border-top border-bottom" style="border-color: #ffa500 !important; border-radius: 25px;">
                                            <div id="heartrate-expand-icon" class="text-center w3-animate-bottom my-4">
                                                <span class="material-icons material-icons-round">
                                                    add_task
                                                </span>
                                            </div>

                                            <div class="align-middle comfortaa-font text-center">
                                                <span class="material-icons material-icons-round align-middle">today</span>

                                                <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                            </div>

                                            <hr class="text-white">

                                            <form id="single-heartrate-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_heartrate.php" autocomplete="off">
                                                <div class="output-container my-2" id="output-container">
                                                    <!--<?php echo $output; ?>-->
                                                </div>

                                                <div class="form-group my-4">
                                                    <label for="heartrate-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="heartrate-workout" id="heartrate-workout" placeholder="Work / Activity (Required)" required>
                                                        <option value='no-selection'>Select a workout / activity.</option>
                                                        <?php echo $workout_activities_list; ?>
                                                        <option value='other'>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="heartrate-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Heart Rate Datasource:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="heartrate-datasource" id="heartrate-datasource" placeholder="Datasource (Required)" required>
                                                        <option value='no-selection'>Select your datasource.</option>
                                                        <option value='datasource-1'>Fitbit waerable</option>
                                                        <option value='datasource-2'>Android wearable</option>
                                                        <option value='datasource-3'>Apple wearable</option>
                                                        <option value='datasource-4'>Treadmill</option>
                                                        <option value='datasource-5'>Electric Spin bike</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="heartrate-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your Heart Rate:</label>
                                                    <input class="form-control-text-input p-4" type="number" name="heartrate-value" id="heartrate-value" placeholder="BPM (Required)" required />
                                                </div>

                                                <!-- submit btn -->
                                                <input id="single-submit-heartrate-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                            </form>
                                            <div class="d-flex justify-content-center">
                                                <!-- visual submit btn - heartrate form -->
                                                <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-heartrate-btn" type="button" onclick="triggerSubmitActivityTrackerData('single','heartrate')">
                                                    <span class="material-icons material-icons-round align-middle">
                                                        add_circle_outline
                                                    </span>
                                                    <span class="align-middle">Save.</span>
                                                </button>
                                                <!-- ./ visual submit btn - heartrate form -->
                                            </div>


                                        </div>
                                        <!-- ./ submit heartrate data form -->

                                        <!-- <div id="heart_rate_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #ffa500;border-radius: 25px;">
                                <div class="row align-items-center">
                                    <div class="col-md -4 text-center">
                                        <h1 class="text-truncate">Body Temp Monitor</h1>
                                        <div class="d-grid gap-2 mt-4">
                                            <span class="material-icons material-icons-round">
                                                device_thermostat
                                            </span>
                                            <h1>36.9<span style="font-size: 10px;" class="align-top">&deg;C</span></h1>
                                            <p class="text-muted fw-bold">37.2&deg;C, 10m ago</p>
                                        </div>

                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#bodytemp-data-input-form-container" aria-expanded="false" aria-controls="bodytemp-data-input-form-container">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button>
                                    </div>
                                    <div class="col-md -8 py-4 d-flex justify-content-center">

                                        <div class="in-div-button-container">
                                            <!-- refresh button -->
                                            <button class="onefit-buttons-style-light p-4 d-grid text-center in-div-btn mx-4" style="top: 0px !important;right: 0px !important;" onclick="refreshUserActivityTrackerChart('<?php echo $currentUser_Usrnm; ?>','body_temp_monitor_chart')">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">update</span>
                                                <span class="align-middle" style="font-size: 10px;">Update.</span>
                                            </button>
                                            <!-- ./ refresh button -->

                                            <!-- Canvasjs chart canvas -->
                                            <div class="insight-chart-container no-scroller">
                                                <canvas class="chartjs-chart-light shadow" id="body_temp_monitor_chart" width="400" height="400"></canvas>
                                            </div>
                                            <!-- ./Canvasjs chart canvas -->
                                        </div>



                                        <!-- submit heartrate data form -->
                                        <div id="bodytemp-data-input-form-container" class="collapse mt-4 p-4 mb-4 w3-animate-bottom border-5 border-top border-bottom" style="border-color: #ffa500 !important; border-radius: 25px;">
                                            <div id="bodytemp-expand-icon" class="text-center w3-animate-bottom my-4">
                                                <span class="material-icons material-icons-round">
                                                    add_task
                                                </span>
                                            </div>

                                            <div class="align-middle comfortaa-font text-center">
                                                <span class="material-icons material-icons-round align-middle">today</span>

                                                <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                            </div>

                                            <hr class="text-white">

                                            <form id="single-bodytemp-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bodytemp.php" autocomplete="off">
                                                <div class="output-container my-2" id="output-container">
                                                    <!--<?php echo $output; ?>-->
                                                </div>

                                                <div class="form-group my-4">
                                                    <label for="bodytemp-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="bodytemp-workout" id="bodytemp-workout" placeholder="Work / Activity (Required)" required>
                                                        <option value='no-selection'>Select a workout / activity.</option>
                                                        <?php echo $workout_activities_list; ?>
                                                        <option value='other'>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="bodytemp-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Heart Rate Datasource:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="bodytemp-datasource" id="bodytemp-datasource" placeholder="Datasource (Required)" required>
                                                        <option value='no-selection'>Select your datasource.</option>
                                                        <option value='datasource-1'>Fitbit waerable</option>
                                                        <option value='datasource-2'>Android wearable</option>
                                                        <option value='datasource-3'>Apple wearable</option>
                                                        <option value='datasource-4'>Treadmill</option>
                                                        <option value='datasource-5'>Electric Spin bike</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="bodytemp-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your current Body Temperature:</label>
                                                    <input class="form-control-text-input p-4" type="number" name="bodytemp-value" id="bodytemp-value" placeholder="Temperature (Required)" required />
                                                </div>

                                                <!-- submit btn -->
                                                <input id="single-submit-bodytemp-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                            </form>
                                            <div class="d-flex justify-content-center">
                                                <!-- visual submit btn - heartrate form -->
                                                <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-bodytemp-btn" type="button" onclick="triggerSubmitActivityTrackerData('single','bodytemp')">
                                                    <span class="material-icons material-icons-round align-middle">
                                                        add_circle_outline
                                                    </span>
                                                    <span class="align-middle">Save.</span>
                                                </button>
                                                <!-- ./ visual submit btn - heartrate form -->
                                            </div>

                                        </div>

                                        <!-- <div id="body_temp_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #ffa500;border-radius: 25px;">
                                <div class="row align-items-center">
                                    <div class="col-md -4 text-center">
                                        <h1 class="text-truncate">Avg. Speed</h1>
                                        <div class="d-grid gap-2 mt-4">
                                            <span class="material-icons material-icons-round">
                                                bolt
                                            </span>
                                            <h1>10<span style="font-size: 10px;" class="align-top">m/s</span></h1>
                                            <p class="text-muted fw-bold">Highest Marked Speed: 15m/s</p>
                                        </div>

                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#speedmonitor-data-input-form-container" aria-expanded="false" aria-controls="speedmonitor-data-input-form-container">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button>
                                    </div>
                                    <div class="col-md -8 py-4 d-flex justify-content-center">

                                        <div class="in-div-button-container">
                                            <!-- refresh button -->
                                            <button class="onefit-buttons-style-light p-4 d-grid text-center in-div-btn mx-4" style="top: 0px !important;right: 0px !important;" onclick="refreshUserActivityTrackerChart('<?php echo $currentUser_Usrnm; ?>','speed_monitor_chart')">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">update</span>
                                                <span class="align-middle" style="font-size: 10px;">Update.</span>
                                            </button>
                                            <!-- ./ refresh button -->

                                            <!-- Canvasjs chart canvas -->
                                            <div class="insight-chart-container no-scroller">
                                                <canvas class="chartjs-chart-light shadow" id="speed_monitor_chart" width="400" height="400"></canvas>
                                            </div>
                                            <!-- ./Canvasjs chart canvas -->
                                        </div>

                                        <!-- submit heartrate data form -->
                                        <div id="speedmonitor-data-input-form-container" class="collapse mt-4 p-4 mb-4 w3-animate-bottom border-5 border-top border-bottom" style="border-color: #ffa500 !important; border-radius: 25px;">
                                            <div id="speedmonitor-expand-icon" class="text-center w3-animate-bottom my-4">
                                                <span class="material-icons material-icons-round">
                                                    add_task
                                                </span>
                                            </div>

                                            <div class="align-middle comfortaa-font text-center">
                                                <span class="material-icons material-icons-round align-middle">today</span>

                                                <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                            </div>

                                            <hr class="text-white">

                                            <form id="single-speed-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_speed.php" autocomplete="off">
                                                <div class="output-container my-2" id="output-container">
                                                    <!--<?php echo $output; ?>-->
                                                </div>

                                                <div class="form-group my-4">
                                                    <label for="speed-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="speed-workout" id="speed-workout" placeholder="Work / Activity (Required)" required>
                                                        <option value='no-selection'>Select a workout / activity.</option>
                                                        <?php echo $workout_activities_list; ?>
                                                        <option value='other'>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="speed-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Speed Datasource:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="speed-datasource" id="speed-datasource" placeholder="Datasource (Required)" required>
                                                        <option value='no-selection'>Select your datasource.</option>
                                                        <option value='datasource-1'>Fitbit waerable</option>
                                                        <option value='datasource-2'>Android wearable</option>
                                                        <option value='datasource-3'>Apple wearable</option>
                                                        <option value='datasource-4'>Treadmill</option>
                                                        <option value='datasource-5'>Electric Spin bike</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="speed-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your max Speed:</label>
                                                    <input class="form-control-text-input p-4" type="number" name="speed-value" id="speed-value" placeholder="Speed (ms - Required)" required />
                                                </div>

                                                <!-- submit btn -->
                                                <input id="single-submit-speed-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                            </form>
                                            <div class="d-flex justify-content-center">
                                                <!-- visual submit btn - heartrate form -->
                                                <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-speed-btn" type="button" onclick="triggerSubmitActivityTrackerData('single','speed')">
                                                    <span class="material-icons material-icons-round align-middle">
                                                        add_circle_outline
                                                    </span>
                                                    <span class="align-middle">Save.</span>
                                                </button>
                                                <!-- ./ visual submit btn - heartrate form -->
                                            </div>

                                        </div>

                                        <!-- <div id="speed_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #ffa500;border-radius: 25px;">
                                <div class="row align-items-center">
                                    <div class="col-md -4 text-center">
                                        <h1 class="text-truncate">Step Counter</h1>
                                        <div class="d-grid gap-2 my-4">
                                            <span class="material-icons material-icons-round">
                                                directions_walk
                                            </span>
                                            <h1>1896<span style="font-size: 10px;" class="align-top">Steps</span></h1>
                                            <p class="text-muted fw-bold">213 Steps remaining (Achievement)</p>
                                        </div>

                                        <img src="../media/assets/smartwatches/branding/fitbit-png-logo-white.png" class="img-fluid mt-4 mb-2" style="max-width: 200px;" alt="fitbit logo">
                                        <p class="comfortaa-font">Connect your Fitbit activity tracker / smartwatch</p>
                                    </div>
                                    <div class="col-md -8 py-4 d-flex justify-content-center">

                                        <div class="in-div-button-container">
                                            <!-- refresh button -->
                                            <button class="onefit-buttons-style-light p-4 d-grid text-center in-div-btn mx-4" style="top: 0px !important;right: 0px !important;" onclick="refreshUserActivityTrackerChart('<?php echo $currentUser_Usrnm; ?>','step_counter_monitor_chart')">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">update</span>
                                                <span class="align-middle" style="font-size: 10px;">Update.</span>
                                            </button>
                                            <!-- ./ refresh button -->

                                            <!-- Canvasjs chart canvas -->
                                            <canvas class="chartjs-chart-light shadow" id="step_counter_monitor_chart" width="400" height="400"></canvas>
                                            <!-- ./Canvasjs chart canvas -->
                                        </div>

                                        <!-- no input form for capturing data. Can only be captured through the fitbit web api -->
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #ffa500;border-radius: 25px;">
                                <div class="row align-items-center">
                                    <div class="col-md -4 text-center">
                                        <h1 class="text-truncate">Weight Monitoring (BMI)</h1>
                                        <div class="d-grid gap-2 mt-4">
                                            <span class="material-icons material-icons-round">
                                                monitor_weight
                                            </span>
                                            <h1>60<span style="font-size: 10px;" class="align-top">kg</span></h1>
                                            <p class="text-muted fw-bold">75kg, 1w ago</p>
                                        </div>

                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#bmiweight-data-input-form-container" aria-expanded="false" aria-controls="">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button>
                                    </div>
                                    <div class="col-md -8 py-4 d-flex justify-content-center">

                                        <div class="in-div-button-container">
                                            <!-- refresh button -->
                                            <button class="onefit-buttons-style-light p-4 d-grid text-center in-div-btn mx-4" style="top: 0px !important;right: 0px !important;" onclick="refreshUserActivityTrackerChart('<?php echo $currentUser_Usrnm; ?>','bmi_weight_monitor_chart')">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">update</span>
                                                <span class="align-middle" style="font-size: 10px;">Update.</span>
                                            </button>
                                            <!-- ./ refresh button -->

                                            <!-- Canvasjs chart canvas -->
                                            <div class="insight-chart-container no-scroller">
                                                <canvas class="chartjs-chart-light shadow" id="bmi_weight_monitor_chart" width="400" height="400"></canvas>
                                            </div>
                                            <!-- ./Canvasjs chart canvas -->
                                        </div>



                                        <!-- submit heartrate data form -->
                                        <div id="bmiweight-data-input-form-container" class="collapse mt-4 p-4 mb-4 w3-animate-bottom border-5 border-top border-bottom" style="border-color: #ffa500 !important; border-radius: 25px;">

                                            <div id="bmiweight-expand-icon" class="text-center w3-animate-bottom my-4">
                                                <span class="material-icons material-icons-round">
                                                    add_task
                                                </span>
                                            </div>

                                            <div class="align-middle comfortaa-font text-center">
                                                <span class="material-icons material-icons-round align-middle">today</span>

                                                <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                            </div>

                                            <hr class="text-white">

                                            <form id="single-weight-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bmiweight.php" autocomplete="off">
                                                <div class="output-container my-2" id="output-container">
                                                    <!--<?php echo $output; ?>-->
                                                </div>

                                                <div class="form-group my-4">
                                                    <label for="heartrate-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="heartrate-workout" id="heartrate-workout" placeholder="Work / Activity (Required)" required>
                                                        <option value='no-selection'>Select a workout / activity.</option>
                                                        <?php echo $workout_activities_list; ?>
                                                        <option value='other'>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="heartrate-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Weight Monitoring Datasource:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="heartrate-datasource" id="heartrate-datasource" placeholder="Datasource (Required)" required>
                                                        <option value='no-selection'>Select your datasource.</option>
                                                        <option value='datasource-1'>Fitbit waerable</option>
                                                        <option value='datasource-2'>Android wearable</option>
                                                        <option value='datasource-3'>Apple wearable</option>
                                                        <option value='datasource-4'>Treadmill</option>
                                                        <option value='datasource-5'>Electric Spin bike</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="weight-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your current Weight:</label>
                                                    <input class="form-control-text-input p-4" type="number" name="weight-value" id="weight-value" placeholder="Weight (kg - Required)" required />
                                                </div>

                                                <!-- submit btn -->
                                                <input id="single-submit-weight-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                            </form>
                                            <div class="d-flex justify-content-center">
                                                <!-- visual submit btn - heartrate form -->
                                                <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-weight-btn" type="button" onclick="triggerSubmitActivityTrackerData('single','weight')">
                                                    <span class="material-icons material-icons-round align-middle">
                                                        add_circle_outline
                                                    </span>
                                                    <span class="align-middle">Save.</span>
                                                </button>
                                                <!-- ./ visual submit btn - heartrate form -->
                                            </div>

                                        </div>

                                        <!-- <div id="weight_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!-- ./ detailed metric list -->
                    </div>
                    <!-- ./ User Smart Device Activity Tracking -->

                    <hr class="text-white" style="height: 5px;">

                    <!-- Weekly Activities -->
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <span class="material-icons material-icons-outlined"> pending_actions </span>
                        <h5 class="mt-4 fs-1 text-center">Weekly Assessments</h5>
                        <p class="fs-5 text-center comfortaa-font"> Training Week: (<span id="weekly-survey-duration-dates">Start Date - End Date</span>)</p>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <!-- weekly assessment horizontal scroll container -->
                    <div id="weekly-assessment-horizontal-scroll-container" class="horizontal-scroll shadow">
                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Sunday (dd/mm/yyyy)</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Monday (dd/mm/yyyy)</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Tuesday (dd/mm/yyyy)</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Wednesday (dd/mm/yyyy)</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Thursday (dd/mm/yyyy)</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Friday (dd/mm/yyyy)</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Saturday (dd/mm/yyyy)</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- ./ weekly assessment horizontal scroll container -->
                    <!-- ./ Weekly Activities -->

                    <hr class="text-white" style="height: 5px;">

                    <!-- Training -->
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <span class="material-icons material-icons-outlined">sports</span>
                        <h5 class="mt-4 fs-1 text-center align-middle">Training</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>2

                    <!-- Features: Tab structured -->
                    <div class="row mt-4 py-4" style="background-color: #333; border-radius: 25px;">
                        <!-- insight catgories tab panels -->
                        <div class="col -md-9 my-4">
                            <p class="text-center m-0"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">horizontal_rule</span></p>
                            <!-- <div class="text-center">
                                <img src="../media/assets/One-Symbol-Logo-Dark-Mix.png" class="img-fluid" style="max-height: 100px;" alt="onefit darkmx logo">
                            </div> -->

                            <!-- display User XP -->
                            <div class="d-grid justify-content-center">
                                <p class="comfortaa-font mb-0 text-center" style="font-size: 10px;">Fitness Progression</p>
                                <div class="text-center px-4 py-0 d-inline comfortaa-font" id="userXPDisplay">
                                    <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">data_exploration</span>
                                    <span class="align-middle fs-2">112</span><sup class="align-bottom" style="color: #ffa500;">xp</sup>
                                </div>
                            </div>
                            <!-- ./ display User XP -->

                            <p class="text-center m-0"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">horizontal_rule</span></p>

                            <!-- more insights categories v-buttons -->
                            <style>
                                .force-inline-nav {
                                    flex-wrap: nowrap !important;
                                }
                            </style>

                            <!-- inline/flex more insights tab controller btns -->
                            <div id="inline-more-insights-tab-btns" class="d-grid align-items-centerz d-lg-none d-xl-none d-xxl-none w3-animate-bottom p-2" style="background: #333; border-radius: 25px; overflow: hidden;">
                                <div class="d-grid gap-2 p-4">
                                    <button class="onefit-buttons-style-dark p-4" type="button" data-bs-toggle="collapse" data-bs-target="#insights-subfeatures-nav-menu" aria-expanded="true" aria-controls="insights-subfeatures-nav-menu">
                                        <div class="d-grid gap-2">
                                            <span class="material-icons material-icons-round"> menu </span>
                                            <p class="m-0" style="font-size: 8px;">More insights</p>
                                        </div>
                                    </button>
                                </div>

                                <div class="w3-animate-bottom my-4 horizontal-scroll no-scroller p-4 collapse" style="overflow-y: hidden;" id="insights-subfeatures-nav-menu">
                                    <nav class="m-0">
                                        <div class="nav force-inline-nav nav-tabs border-0" id="nav-tab-insightsSubFeatureCategories" role="tablist" style="border-color: #ffa500 !important">
                                            <button class="nav-link p-4 comfortaa-font fw-bold active position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-challenges-tab" onclick="clickTrainingProgramCategories('challenges')">
                                                Challenges.
                                                <span class="position-absolute top-50 start-0 translate-middle badge rounded-pill border-2 border p-1  my-pulse-animation-tahiti" style="height: 20px; width: 20px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;">
                                                </span>

                                                <br>
                                                <span id="horizontal-rule-icon-challenges" class="material-icons material-icons-outlined align-middle" style="display: block;">stars</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-googleSurveys-tab" onclick="clickTrainingProgramCategories('googleSurveys')">
                                                Google Surveys.

                                                <br>
                                                <span id="horizontal-rule-icon-googlesurveys" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">poll</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-indiAthlete-tab" onclick="clickTrainingProgramCategories('indiAthlete')">
                                                Indi-Athletics.

                                                <br>
                                                <span id="horizontal-rule-icon-indiathlete" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">sports_gymnastics</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-teamAthletics-tab" onclick="clickTrainingProgramCategories('teamAthletics')">
                                                Team Athletics.

                                                <br>
                                                <span id="horizontal-rule-icon-teamathletics" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">diversity_2</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-wellness-tab" onclick="clickTrainingProgramCategories('wellness')">
                                                Wellness.

                                                <br>
                                                <span id="horizontal-rule-icon-wellness" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">self_improvement</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-nutrition-tab" onclick="clickTrainingProgramCategories('nutrition')">
                                                Nutrition.

                                                <br>
                                                <span id="horizontal-rule-icon-nutrition" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">restaurant</span>
                                            </button>

                                        </div>
                                    </nav>

                                    <!-- Fitness/Training programe categories - hidden display: none -->
                                    <div class="nav d-grid nav-pills d-none" id="v-sub-tab-pills-insights-subfeatures-tab" role="tablist" aria-orientation="vertical" aria-hidden="true">
                                        <button class="nav-link" id="v-sub-tab-pills-insights-challenges-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-challenges" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-challenges" aria-selected="false">
                                            <!--onclick="openLink(event, 'InsightsTabChallenges')"-->
                                            <span class="material-icons material-icons-rounded">stars</span>
                                            <p class="text-break comfortaa-font">Challenges</p>
                                        </button>
                                        <button class="nav-link active" id="v-sub-tab-pills-insights-googlesurveys-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-googlesurveys" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-googlesurveys" aria-selected="true">
                                            <!--onclick="openLink(event, 'InsightsTabGCS')"-->
                                            <span class="material-icons material-icons-rounded">poll</span>
                                            <p class="text-break comfortaa-font">Google Community Surveys</p>
                                        </button>
                                        <button class="nav-link" id="v-sub-tab-pills-insights-indiathlete-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-indiathlete" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-indiathlete" aria-selected="false">
                                            <!--onclick="openLink(event, 'InsightsTabIAT')"-->
                                            <span class="material-icons material-icons-rounded">sports_gymnastics</span>
                                            <p class="text-break comfortaa-font">Indi-Athletics</p>
                                        </button>
                                        <button class="nav-link" id="v-sub-tab-pills-insights-teamathletics-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-teamathletics" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-teamathletics" aria-selected="false">
                                            <!--onclick="openLink(event, 'InsightsTabCTA')"-->
                                            <span class="material-icons material-icons-rounded">diversity_2</span>
                                            <p class="text-break comfortaa-font">Community/Team Athletics</p>
                                        </button>
                                        <button class="nav-link" id="v-sub-tab-pills-insights-wellness-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-wellness" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-wellness" aria-selected="false">
                                            <!--onclick="openLink(event, 'InsightsTabWellness')"-->
                                            <span class="material-icons material-icons-rounded">self_improvement</span>
                                            <p class="text-break comfortaa-font">Wellness</p>
                                        </button>
                                        <button class="nav-link" id="v-sub-tab-pills-insights-nutrition-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-nutrition" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-nutrition" aria-selected="false">
                                            <!--onclick="openLink(event, 'InsightsTabNutrition')"-->
                                            <span class="material-icons material-icons-rounded">restaurant</span>
                                            <p class="text-break comfortaa-font">Nutrition</p>
                                        </button>
                                    </div>
                                    <!-- ./ Fitness/Training programe categories - hidden display: none -->
                                </div>
                            </div>
                            <!-- ./ inline/flex more insights tab controller btns -->
                            <!-- ./ more insight categories v-buttons -->

                            <!-- hide on screens smaller than lg -->
                            <nav class="d-none d-lg-block mt-4">
                                <div class="nav nav-tabs justify-content-center" id="nav-tab-insightsSubFeatureCategories" role="tablist" style="border-color: #ffa500 !important">
                                    <button class="nav-link p-4 comfortaa-font fw-bold active position-relative" id="nav-trainingProgramCategories-challenges-tab" onclick="clickTrainingProgramCategories('challenges')">
                                        Challenges.
                                        <span class="position-absolute top-50 start-0 translate-middle badge rounded-pill border-2 border p-1  my-pulse-animation-tahiti" style="height: 20px; width: 20px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;">
                                        </span>

                                        <br>
                                        <span id="horizontal-rule-icon-challenges" class="material-icons material-icons-outlined align-middle" style="display: block;">stars</span>
                                    </button>

                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" id="nav-trainingProgramCategories-googleSurveys-tab" onclick="clickTrainingProgramCategories('googleSurveys')">
                                        Google Surveys.

                                        <br>
                                        <span id="horizontal-rule-icon-googlesurveys" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">poll</span>
                                    </button>

                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" id="nav-trainingProgramCategories-indiAthlete-tab" onclick="clickTrainingProgramCategories('indiAthlete')">
                                        Indi-Athletics.

                                        <br>
                                        <span id="horizontal-rule-icon-indiathlete" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">sports_gymnastics</span>
                                    </button>

                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" id="nav-trainingProgramCategories-teamAthletics-tab" onclick="clickTrainingProgramCategories('teamAthletics')">
                                        Team Athletics.

                                        <br>
                                        <span id="horizontal-rule-icon-teamathletics" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">diversity_2</span>
                                    </button>

                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" id="nav-trainingProgramCategories-wellness-tab" onclick="clickTrainingProgramCategories('wellness')">
                                        Wellness.

                                        <br>
                                        <span id="horizontal-rule-icon-wellness" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">self_improvement</span>
                                    </button>

                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" id="nav-trainingProgramCategories-nutrition-tab" onclick="clickTrainingProgramCategories('nutrition')">
                                        Nutrition.

                                        <br>
                                        <span id="horizontal-rule-icon-nutrition" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">restaurant</span>
                                    </button>

                                </div>
                            </nav>
                            <!-- ./ hide on screens smaller than lg -->

                            <script>
                                function clickTrainingProgramCategories(selcategory) {
                                    // declaring variable
                                    var challengesBtn = document.getElementById("v-sub-tab-pills-insights-challenges-tab");
                                    var teamAthleticsBtn = document.getElementById("v-sub-tab-pills-insights-teamathletics-tab");
                                    var indiAthleteBtn = document.getElementById("v-sub-tab-pills-insights-indiathlete-tab");
                                    var googleSurveyBtn = document.getElementById("v-sub-tab-pills-insights-googlesurveys-tab");
                                    var wellnessBtn = document.getElementById("v-sub-tab-pills-insights-wellness-tab");
                                    var nutritionBtn = document.getElementById("v-sub-tab-pills-insights-nutrition-tab");

                                    if (selcategory == "challenges") {
                                        challengesBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "block";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";

                                    } else if (selcategory == "googleSurveys") {
                                        googleSurveyBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "block";
                                        document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";

                                    } else if (selcategory == "indiAthlete") {
                                        indiAthleteBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-indiathlete").style.display = "block";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";

                                    } else if (selcategory == "teamAthletics") {
                                        teamAthleticsBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "block";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";

                                    } else if (selcategory == "wellness") {
                                        wellnessBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "block";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";

                                    } else if (selcategory == "nutrition") {
                                        nutritionBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "block";

                                    }
                                }
                            </script>

                            <!-- Team Athlectics Training Panel -->
                            <div class="tab-content" id="v-pills-tabInsightsSubFeatures">
                                <!-- #v-sub-tab-pills -->
                                <div class="tab-pane fade show active w3-animate-bottom no-scroller py-4 px-2 gap-4" id="v-sub-tab-pills-insights-challenges" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-insights-challenges-tab">
                                    <div class="d-grid text-center mt-4 ">
                                        <span class="material-icons material-icons-round">stars</span>
                                        <h5 class="fs-1">Challenges</h5>
                                    </div>

                                    <hr class="text-white">

                                    <!-- fitness progression progress bar -->
                                    <div id="fitness-progression-progress-bar">
                                        <h5 class="mt-4">Fitness Progression</h5>
                                        <div class="progress mt-4" style="height: 4px;">
                                            <div class="progress-bar" role="progressbar" aria-label="Example 1px high" style="width: 25%; background-color: #ffa500 !important; border-right: #343434 10px solid;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="row mt-2" style="margin-bottom: 60px;">
                                            <div class="col text-start comfortaa-font" style="font-size: 12px;">
                                                Current XP <strong>(112)</strong>
                                            </div>
                                            <div class="col text-end comfortaa-font" style="font-size: 12px;">
                                                Target XP <strong>(150)</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ./ fitness progression progress bar -->

                                    <hr class="text-white">

                                    <h5 class="my-4">Daily Challenges</h5>

                                    <div id="daily-challenges-grid" class="grid-container mb-4">
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-body-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-deadlift-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-muscle-flexing-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-exercise-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-fit-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-workout-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                    </div>

                                    <hr class="text-white">

                                    <h5 class="my-4">Weekly Challenges</h5>

                                    <div id="weekly-challenges-grid" class="grid-container mb-4">
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-body-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-deadlift-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-muscle-flexing-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-exercise-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-fit-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-workout-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                    </div>

                                    <hr class="text-white">

                                    <h5 class="my-4">Monthly Monthly</h5>

                                    <div id="monthly-challenges-grid" class="grid-container mb-4">
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-body-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-deadlift-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-muscle-flexing-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-exercise-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-fit-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-workout-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                    </div>

                                    <!-- Next Tab button - Proceed to Google Community Surveys -->
                                    <hr class="text-white">
                                    <div class="my-4 text-center" style="width: 100%">
                                        <div class="d-flex justify-content-center" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabGCS')">
                                                <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_forward</span></p>
                                                <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">sports_gymnastics</span> -->
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Google Community Surveys</p>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- ./Next Tab button - Proceed to Google Community Surveys -->
                                </div>
                                <div class="tab-pane fade w3-animate-bottom no-scroller py-4 px-2" id="v-sub-tab-pills-insights-googlesurveys" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-insights-googlesurveys-tab">
                                    <div class="d-grid text-center mt-4">
                                        <span class="material-icons material-icons-round">poll</span>
                                        <h5 class="fs-1">Google Community Surveys</h5>
                                    </div>

                                    <hr class="text-white">

                                    <!-- Next Tab button - Return to Challenges -->
                                    <div class="my-4 text-center" style="width: 100%">
                                        <div class="d-flex justify-content-center" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabChallenges')">
                                                <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">stars</span> -->
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Challenges</p>
                                                <span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_back</span>
                                            </button>
                                        </div>
                                    </div>
                                    <hr class="text-white">
                                    <!-- ./Next Tab button - Return to Challenges -->

                                    <!-- Community Surveys -->
                                    <div>
                                        <!-- User Wellness Tracking Log -->
                                        <div class="fs-5 fw-bold text-center mb-4 rounded-pill p-4 mb-4 d-grid comfortaa-font">
                                            <i class="fab fa-google mb-2" style="font-size: 40px!important" aria-hidden="true"></i>
                                            <small>Community Fitness Analysis using</small>
                                            <span class="align-center">Google Data Studio</span>
                                        </div>

                                        <hr class="text-white">

                                        <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                                            <h5 class="fs-1 text-center my-4">Wellness Tracking</h5>
                                        </div>

                                        <p class="fs-3 mt-4">Community Wellness Rating: 90%</p>
                                        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSc0sL0-Gm6J-Hy03z_F872L5nQAdigfbZArNYBhBGbB-iOqmg/viewform?embedded=true" height="3016" frameborder="0" marginheight="0" marginwidth="0" class="w-100 no-scroller tunnel-bg-container-inverse" style="max-height: 100vh!important; border-radius: 25px;">Loading…</iframe>
                                        <div class="row my-4">
                                            <div class="col-md-4">
                                                <h5>Survey log</h5>
                                            </div>
                                            <div class="col-md">
                                                <p>Survey Charts / Results</p>
                                            </div>
                                        </div>
                                        <!-- ./ User Wellness Tracking Log -->

                                        <!-- User Load Monitoring Log -->
                                        <hr class="text-white" style="height: 5px;">

                                        <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                                            <h5 class="mt-4 fs-1 text-center mb-4">Load Monitoring</h5>
                                        </div>

                                        <p class="fs-3 mt-4">Community Load Rating: 90%</p>
                                        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeOJqnXT2LxRK9GK6DfmYObzkbu28D-qT_XzN-vUBsUyaOX0Q/viewform?embedded=true" height="1879" frameborder="0" marginheight="0" marginwidth="0" class="w-100 no-scroller tunnel-bg-container-inverse" style="max-height: 100vh!important; border-radius: 25px;">Loading…</iframe>
                                        <div class="row my-4">
                                            <div class="col-md-4">
                                                <h5>Survey log</h5>
                                            </div>
                                            <div class="col-md">
                                                <p>Survey Charts / Results</p>
                                            </div>
                                        </div>
                                        <!-- ./ User Load Monitoring Log -->
                                    </div>
                                    <!-- ./ Community Surveys -->

                                    <!-- Next Tab button - Proceed to Indi-Athlete -->
                                    <hr class="text-white">
                                    <div class="my-4 text-center" style="width: 100%">
                                        <div class="d-flex justify-content-center" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabIAT')">
                                                <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_forward</span></p>

                                                <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">sports_gymnastics</span> -->
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Indi-Athletics</p>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- ./Next Tab button - Proceed to Indi-Athlete -->
                                </div>
                                <div class="tab-pane fade w3-animate-bottom no-scroller py-4 px-2" id="v-sub-tab-pills-insights-indiathlete" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-insights-indiathlete-tab">
                                    <div class="d-grid text-center mt-4">
                                        <span class="material-icons material-icons-round">sports_gymnastics</span>
                                        <h5 class="fs-1">Indi-Athlete.</h5>
                                    </div>

                                    <hr class="text-white">

                                    <!-- Next Tab button - Return to Google community Surveys -->
                                    <div class="my-4 text-center" style="width: 100%">
                                        <div class="d-flex justify-content-center" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabGCS')">
                                                <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_back</span></p>
                                                <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">poll</span> -->
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Google Community Surveys</p>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- ./Next Tab button - Return to Google community Surveys -->

                                    <hr class="text-white">

                                    <!-- Indi Athletics Training Panel -->
                                    <h1 class="my-4 fs-1 text-center p-4 down-top-grad-tahiti rounded-pill">Indi-Athlete Training</h1>
                                    <div class="accordion accordion-flush" id="accordionFlushIATRegiment">
                                        <!-- User Workouts - Bookmarked -->
                                        <div class="accordion-item p-2 my-2 shadow">
                                            <h2 class="accordion-header m-0" id="flush-headingIATTwo">
                                                <button class="accordion-button collapsed fs-5 fw-bold text-truncate" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseIATTwo" aria-expanded="false" aria-controls="flush-collapseIATTwo">
                                                    <span class="material-icons material-icons-round align-middle">bookmark</span>
                                                    <span class="align-middle">My Workouts</span>
                                                </button>
                                            </h2>
                                            <div id="flush-collapseIATTwo" class="accordion-collapse collapse w3-animate-bottom" aria-labelledby="flush-headingIATTwo" data-bs-parent="#accordionFlushIATRegiment">
                                                <div class="accordion-body">
                                                    <div class="my-4">
                                                        <div class="p-4 top-down-grad-dark" style="border-radius: 25px;">
                                                            <!-- <div class="text-center pt-4 mb-4">
                                                                <img src="media/assets/One-Symbol-Logo-White.png" alt="logo" class="img-fluid my-4 p-4 my-pulse-animation-light" style="max-width: 100px;border-radius: 50%;">
                                                            </div> -->

                                                            <div class="row align-items-center">
                                                                <div class="col-md-6">
                                                                    <!-- Onefit.TV Horizontal Content Stream -->
                                                                    <div class="mb-4" id="onefittv-footer-h-content-stream">
                                                                        <div class="content-panel-border-stylez p-4 shadow border-5 border-start border-end text-white" style="padding-bottom: 40px; border-radius: 25px; background-color: #343434; border-color: #ffa500 !important;">

                                                                            <h5 class="fs-1 h4 aligh-middle d-grid text-center" style="color: #ffa500;">
                                                                                <span class="material-icons material-icons-outlined" style="color: #fff;"> tv </span>
                                                                                <span>OnefitNet.TV</span>
                                                                            </h5>
                                                                            <hr class="text-white" />

                                                                            <p class="my-4 text-center" style=" font-size: 10px">Latest Training Programs | <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span></p>

                                                                            <div class="d-lg-none w3-animate-bottom">
                                                                                <!-- d-block d-sm-block d-md-none d-lg-none d-xl-none d-xxl-none -->
                                                                                <!-- <img src="media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid"> -->

                                                                                <div class="video-card-container">
                                                                                    <img src="../media/assets/YouTube Thumbnail 1280x720 px.gif" alt="latest video" class="img-fluid shadow mb-4" style="border-radius: 15px;" />
                                                                                    <button class="onefit-buttons-style-light shadow-lg play-btn p-2 aligh-middle" onclick="playVideo()">
                                                                                        <span class="material-icons material-icons-round aligh-middle" style="font-size: 20px !important;">
                                                                                            play_circle_outline
                                                                                        </span>
                                                                                    </button>
                                                                                </div>

                                                                                <div class="d-grid mt-4 w-100 justify-content-center">
                                                                                    <button class="onefit-buttons-style-dark shadow d-grid p-4 comfortaa-font text-center aligh-middle position-relative">
                                                                                        <span>View Playlist.</span>
                                                                                        <span class="material-icons material-icons-round aligh-middle">playlist_play</span>

                                                                                        <span class="position-absolute top-0 start-100 translate-middle p-2 comfortaa-font border border-light rounded-pill align-middle shadow" style="background-color: #343434 !important; color: #ffa500 !important; border-color: #ffa500 !important;">
                                                                                            <span class="align-middle" style="font-size: 10px !important;">+3</span>
                                                                                            <span class="visually-hidden">Latest Video Count</span>
                                                                                        </span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>


                                                                            <div class="horizontal-scroll d-none d-lg-block w3-animate-bottom">
                                                                                <div class="horizontal-scroll-card p-4">
                                                                                    <img src="../media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4" style="border-radius: 25px;">
                                                                                    <hr class="text-white" style="height: 5px;">

                                                                                    <div class="row my-2 align-items-center">
                                                                                        <div class="col-sm-2 text-center">
                                                                                            <img src="../media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder" style="border-radius: 5px; background-color: #ffa500;">
                                                                                        </div>
                                                                                        <div class="col-sm">
                                                                                            <h5>Ep.1 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                                                                                            <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">timer</span> Duration: 1 hour</p>
                                                                                            <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">category</span>
                                                                                                Category: Resistence
                                                                                            </p>

                                                                                            <button class="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                                                                                                Subscribe on <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="horizontal-scroll-card p-4">
                                                                                    <img src="../media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4" style="border-radius: 25px;">
                                                                                    <hr class="text-white" style="height: 5px;">

                                                                                    <div class="row my-2 align-items-center">
                                                                                        <div class="col-sm-2 text-center">
                                                                                            <img src="../media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder" style="border-radius: 5px; background-color: #ffa500;">
                                                                                        </div>
                                                                                        <div class="col-sm">
                                                                                            <h5>Ep.2 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                                                                                            <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">timer</span> Duration: 1 hour</p>
                                                                                            <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">category</span>
                                                                                                Category: Resistence
                                                                                            </p>

                                                                                            <button class="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                                                                                                Subscribe on <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="horizontal-scroll-card p-4">
                                                                                    <img src="../media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4" style="border-radius: 25px;">
                                                                                    <hr class="text-white" style="height: 5px;">

                                                                                    <div class="row my-2 align-items-center">
                                                                                        <div class="col-sm-2 text-center">
                                                                                            <img src="../media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder" style="border-radius: 5px; background-color: #ffa500;">
                                                                                        </div>
                                                                                        <div class="col-sm">
                                                                                            <h5>Ep.2 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                                                                                            <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">timer</span> Duration: 1 hour</p>
                                                                                            <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">category</span>
                                                                                                Category: Resistence
                                                                                            </p>

                                                                                            <button class="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                                                                                                Subscribe on <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="horizontal-scroll-card p-4">
                                                                                    <img src="../media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4" style="border-radius: 25px;">
                                                                                    <hr class="text-white" style="height: 5px;">

                                                                                    <div class="row my-2 align-items-center">
                                                                                        <div class="col-sm-2 text-center">
                                                                                            <img src="../media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder" style="border-radius: 5px; background-color: #ffa500;">
                                                                                        </div>
                                                                                        <div class="col-sm">
                                                                                            <h5>Ep.2 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                                                                                            <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">timer</span> Duration: 1 hour</p>
                                                                                            <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">category</span>
                                                                                                Category: Resistence
                                                                                            </p>

                                                                                            <button class="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                                                                                                Subscribe on <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="horizontal-scroll-card p-4">
                                                                                    <img src="../media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4" style="border-radius: 25px;">
                                                                                    <hr class="text-white" style="height: 5px;">

                                                                                    <div class="row my-2 align-items-center">
                                                                                        <div class="col-sm-2 text-center">
                                                                                            <img src="../media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder" style="border-radius: 5px; background-color: #ffa500;">
                                                                                        </div>
                                                                                        <div class="col-sm">
                                                                                            <h5>Ep.2 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                                                                                            <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">timer</span> Duration: 1 hour</p>
                                                                                            <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">category</span>
                                                                                                Category: Resistence
                                                                                            </p>

                                                                                            <button class="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                                                                                                Subscribe on <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <!-- ./ Onefit.TV Horizontal Content Stream -->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="comfortaa-font">

                                                                        <div class="border-5 border-top border-bottom p-4 mb-4" style="border-color: #ffa500 !important; border-radius: 25px;">
                                                                            <h5 class="mt-4">Workouts &amp; Wellness programs</h5>

                                                                            <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">horizontal_rule</span>

                                                                            <ul class="list-group list-group-flush mb-4">
                                                                                <li class="list-group-item bg-transparent text-white border-white">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-2 text-center">
                                                                                            <span class="material-icons material-icons-round align-middle">bookmarks</span>
                                                                                        </div>
                                                                                        <div class="col-sm-10">
                                                                                            <span class="align-middle fs-5 comfortaa-font">Bookmarked Workouts</span>
                                                                                            <p class="text-muted" style="color: #ffa500 !important;">You have 3 workouts saved.</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="list-group-item bg-transparent text-white border-white">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-2 text-center">
                                                                                            <span class="material-icons material-icons-round align-middle">sports_gymnastics</span>
                                                                                        </div>
                                                                                        <div class="col-sm-10">
                                                                                            <span class="align-middle fs-5 comfortaa-font">View more workouts</span>
                                                                                            <p class="text-muted" style="color: #ffa500 !important;">50 workouts available</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="list-group-item bg-transparent text-white border-white">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-2 text-center">
                                                                                            <span class="material-icons material-icons-round align-middle">fitness_center</span>
                                                                                        </div>
                                                                                        <div class="col-sm-10">
                                                                                            <span class="align-middle fs-5 comfortaa-font">View more exercises</span>
                                                                                            <p class="text-muted" style="color: #ffa500 !important;">438 exercises available</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>

                                                                        </div>

                                                                        <div class="border-5 border-top border-bottom p-4 mb-4" style="border-color: #ffa500 !important; border-radius: 25px;">
                                                                            <h5 class="align-middle mt-5"><span class="material-icons material-icons-outlined align-middle">push_pin</span> Favourites</h5>

                                                                            <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">horizontal_rule</span>

                                                                            <p class="text-muted comfortaa-font" style="font-size: 12px;">Pin up to 5 of your favourite workouts and wellness programs.</p>

                                                                            <ul class="list-group list-group-flush" style="max-height: 500px; overflow-y: auto;">
                                                                                <li class="list-group-item bg-transparent border-white py-4" style="border-radius: 25px !important;">
                                                                                    <div class="row p-2 pt-4">
                                                                                        <div class="col-md-4 p-4 position-relative">
                                                                                            <span class="rounded-pill position-absolute top-0 start-90 translate-middle align-middle badge border-3 border p-4 fs-5" style="height: 70px; width: 60px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;"> 1. </span>

                                                                                            <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid" style="border-radius: 25px;" alt="placeholder">
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <h5 class="fw-bold comfortaa-font" style="color: #ffa500 !important;">Workout Title.</h5>
                                                                                            <p class="my-4 text-white" style="font-size: 20px !important; max-height: 50px;">
                                                                                                This is a general description of the workout.
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <!-- pinned workout options button -->
                                                                                            <div class="mb-4 d-flex justify-content-end shadow">
                                                                                                <button class="btn onefit-buttons-style-dark p-4 shadow">
                                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">tune</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <!-- ./ pinned workout options button -->
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="list-group-item bg-transparent border-white py-4" style="border-radius: 25px !important;">
                                                                                    <div class="row p-2 pt-4">
                                                                                        <div class="col-md-4 p-4 position-relative">
                                                                                            <span class="rounded-pill position-absolute top-0 start-90 translate-middle align-middle badge border-3 border p-4 fs-5" style="height: 70px; width: 60px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;"> 2. </span>

                                                                                            <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid" style="border-radius: 25px;" alt="placeholder">
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <h5 class="fw-bold comfortaa-font" style="color: #ffa500 !important;">Workout Title.</h5>
                                                                                            <p class="my-4 text-white" style="font-size: 20px !important; max-height: 50px;">
                                                                                                This is a general description of the workout.
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <!-- pinned workout options button -->
                                                                                            <div class="mb-4 d-flex justify-content-end">
                                                                                                <button class="btn onefit-buttons-style-dark p-4 shadow">
                                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">tune</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <!-- ./ pinned workout options button -->
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="list-group-item bg-transparent border-white py-4" style="border-radius: 25px !important;">
                                                                                    <div class="row p-2 pt-4">
                                                                                        <div class="col-md-4 p-4 position-relative">
                                                                                            <span class="rounded-pill position-absolute top-0 start-90 translate-middle align-middle badge border-3 border p-4 fs-5" style="height: 70px; width: 60px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;"> 3. </span>

                                                                                            <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid" style="border-radius: 25px;" alt="placeholder">
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <h5 class="fw-bold comfortaa-font" style="color: #ffa500 !important;">Workout Title.</h5>
                                                                                            <p class="my-4 text-white" style="font-size: 20px !important; max-height: 50px;">
                                                                                                This is a general description of the workout.
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <!-- pinned workout options button -->
                                                                                            <div class="mb-4 d-flex justify-content-end">
                                                                                                <button class="btn onefit-buttons-style-dark p-4 shadow">
                                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">tune</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <!-- ./ pinned workout options button -->
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="list-group-item bg-transparent border-white py-4" style="border-radius: 25px !important;">
                                                                                    <div class="row p-2 pt-4">
                                                                                        <div class="col-md-4 p-4 position-relative">
                                                                                            <span class="rounded-pill position-absolute top-0 start-90 translate-middle align-middle badge border-3 border p-4 fs-5" style="height: 70px; width: 60px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;"> 4. </span>

                                                                                            <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid" style="border-radius: 25px;" alt="placeholder">
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <h5 class="fw-bold comfortaa-font" style="color: #ffa500 !important;">Workout Title.</h5>
                                                                                            <p class="my-4 text-white" style="font-size: 20px !important; max-height: 50px;">
                                                                                                This is a general description of the workout.
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <!-- pinned workout options button -->
                                                                                            <div class="mb-4 d-flex justify-content-end">
                                                                                                <button class="btn onefit-buttons-style-dark p-4 shadow">
                                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">tune</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <!-- ./ pinned workout options button -->
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="list-group-item bg-transparent border-white py-4" style="border-radius: 25px !important;">
                                                                                    <div class="row p-2 pt-4">
                                                                                        <div class="col-md-4 p-4 position-relative">
                                                                                            <span class="rounded-pill position-absolute top-0 start-90 translate-middle align-middle badge border-3 border p-4 fs-5" style="height: 70px; width: 60px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;"> 5. </span>

                                                                                            <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid" style="border-radius: 25px;" alt="placeholder">
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <h5 class="fw-bold comfortaa-font" style="color: #ffa500 !important;">Workout Title.</h5>
                                                                                            <p class="my-4 text-white" style="font-size: 20px !important; max-height: 50px;">
                                                                                                This is a general description of the workout.
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <!-- pinned workout options button -->
                                                                                            <div class="mb-4 d-flex justify-content-end">
                                                                                                <button class="btn onefit-buttons-style-dark p-4 shadow">
                                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">tune</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <!-- ./ pinned workout options button -->
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <hr class="text-white">

                                                        <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                                                            <h1 class="text-center comfortaa-font">
                                                                <span class="material-icons material-icons-round align-middle">bookmarks</span>
                                                                Workout Subscriptions (Bookmarked)
                                                            </h1>

                                                        </div>

                                                        <div id="user-workout-subscriptions-grid" class="grid-container">
                                                            <div class="grid-tile p-4 down-top-grad-white comfortaa-font shadow" style="border-radius: 0 0 25px 25px;">
                                                                <!-- options button -->
                                                                <div class="mb-4 d-flex justify-content-end">
                                                                    <button class="btn onefit-buttons-style-dark p-4">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">tune</span>
                                                                        <span style="font-size: 10px;">Options</span>
                                                                    </button>
                                                                </div>
                                                                <!-- options button -->
                                                                <div class="card bg-transparent border-0">
                                                                    <h5 class="fs-2 fw-bold comfortaa-font text-white">Workout Title</h5>
                                                                    <hr class="text-white">

                                                                    <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid my-4" style="border-radius: 25px;" alt="placeholder">

                                                                    <p class="my-4 text-dark" style="font-size: 20px !important;">
                                                                        <sup><span class="material-icons material-icons-round align-middle" style="font-size: 40px; color: #ffa500 !important;">integration_instructions</span></sup>
                                                                        This is a general description of the workout.
                                                                    </p>

                                                                    <ul class="list-group list-group-flush mb-4">
                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">schedule</span>
                                                                            <span class="align-middle">Duration [10 - 15 min]</span>
                                                                        </li>

                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">view_timeline</span>
                                                                            <span class="align-middle">Experience [Beginner]</span>
                                                                        </li>

                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">accessibility</span>
                                                                            <span class="align-middle">Focus [Arms, Legs, Full body]</span>
                                                                        </li>
                                                                    </ul>

                                                                    <div class="text-center">
                                                                        <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important;">horizontal_rule</span>
                                                                    </div>

                                                                    <div class="card-footer" style="border-radius: 25px;">
                                                                        <div class="d-grid my-4">
                                                                            <button class="btn onefit-buttons-style-dark p-4 fs-5 text-truncate">
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 40px; color: #ffa500;">flag</span>
                                                                                <span class="align-middle fs-5">Begin Workout<span style="color: #ffa500;">.</span></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="grid-tile p-4 down-top-grad-white comfortaa-font shadow" style="border-radius: 0 0 25px 25px;">
                                                                <!-- options button -->
                                                                <div class="mb-4 d-flex justify-content-end">
                                                                    <button class="btn onefit-buttons-style-dark p-4">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">tune</span>
                                                                        <span style="font-size: 10px;">Options</span>
                                                                    </button>
                                                                </div>
                                                                <!-- options button -->
                                                                <div class="card bg-transparent border-0">
                                                                    <h5 class="fs-2 fw-bold comfortaa-font text-white">Workout Title</h5>
                                                                    <hr class="text-white">

                                                                    <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid my-4" style="border-radius: 25px;" alt="placeholder">

                                                                    <p class="my-4 text-dark" style="font-size: 20px !important;">
                                                                        <sup><span class="material-icons material-icons-round align-middle" style="font-size: 40px; color: #ffa500 !important;">integration_instructions</span></sup>
                                                                        This is a general description of the workout.
                                                                    </p>

                                                                    <ul class="list-group list-group-flush mb-4">
                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">schedule</span>
                                                                            <span class="align-middle">Duration [10 - 15 min]</span>
                                                                        </li>

                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">view_timeline</span>
                                                                            <span class="align-middle">Experience [Beginner]</span>
                                                                        </li>

                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">accessibility</span>
                                                                            <span class="align-middle">Focus [Arms, Legs, Full body]</span>
                                                                        </li>
                                                                    </ul>

                                                                    <div class="text-center">
                                                                        <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important;">horizontal_rule</span>
                                                                    </div>

                                                                    <div class="card-footer" style="border-radius: 25px;">
                                                                        <div class="d-grid my-4">
                                                                            <button class="btn onefit-buttons-style-dark p-4 fs-5 text-truncate">
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 40px; color: #ffa500;">flag</span>
                                                                                <span class="align-middle fs-5">Begin Workout<span style="color: #ffa500;">.</span></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="grid-tile p-4 down-top-grad-white comfortaa-font shadow" style="border-radius: 0 0 25px 25px;">
                                                                <!-- options button -->
                                                                <div class="mb-4 d-flex justify-content-end">
                                                                    <button class="btn onefit-buttons-style-dark p-4">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">tune</span>
                                                                        <span style="font-size: 10px;">Options</span>
                                                                    </button>
                                                                </div>
                                                                <!-- options button -->
                                                                <div class="card bg-transparent border-0">
                                                                    <h5 class="fs-2 fw-bold comfortaa-font text-white">Workout Title</h5>
                                                                    <hr class="text-white">

                                                                    <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid my-4" style="border-radius: 25px;" alt="placeholder">

                                                                    <p class="my-4 text-dark" style="font-size: 20px !important;">
                                                                        <sup><span class="material-icons material-icons-round align-middle" style="font-size: 40px; color: #ffa500 !important;">integration_instructions</span></sup>
                                                                        This is a general description of the workout.
                                                                    </p>

                                                                    <ul class="list-group list-group-flush mb-4">
                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">schedule</span>
                                                                            <span class="align-middle">Duration [10 - 15 min]</span>
                                                                        </li>

                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">view_timeline</span>
                                                                            <span class="align-middle">Experience [Beginner]</span>
                                                                        </li>

                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">accessibility</span>
                                                                            <span class="align-middle">Focus [Arms, Legs, Full body]</span>
                                                                        </li>
                                                                    </ul>

                                                                    <div class="text-center">
                                                                        <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important;">horizontal_rule</span>
                                                                    </div>

                                                                    <div class="card-footer" style="border-radius: 25px;">
                                                                        <div class="d-grid my-4">
                                                                            <button class="btn onefit-buttons-style-dark p-4 fs-5 text-truncate">
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 40px; color: #ffa500;">flag</span>
                                                                                <span class="align-middle fs-5">Begin Workout<span style="color: #ffa500;">.</span></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="grid-tile p-4 down-top-grad-white comfortaa-font shadow" style="border-radius: 0 0 25px 25px;">
                                                                <!-- options button -->
                                                                <div class="mb-4 d-flex justify-content-end">
                                                                    <button class="btn onefit-buttons-style-dark p-4">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">tune</span>
                                                                        <span style="font-size: 10px;">Options</span>
                                                                    </button>
                                                                </div>
                                                                <!-- options button -->
                                                                <div class="card bg-transparent border-0">
                                                                    <h5 class="fs-2 fw-bold comfortaa-font text-white">Workout Title</h5>
                                                                    <hr class="text-white">

                                                                    <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid my-4" style="border-radius: 25px;" alt="placeholder">

                                                                    <p class="my-4 text-dark" style="font-size: 20px !important;">
                                                                        <sup><span class="material-icons material-icons-round align-middle" style="font-size: 40px; color: #ffa500 !important;">integration_instructions</span></sup>
                                                                        This is a general description of the workout.
                                                                    </p>

                                                                    <ul class="list-group list-group-flush mb-4">
                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">schedule</span>
                                                                            <span class="align-middle">Duration [10 - 15 min]</span>
                                                                        </li>

                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">view_timeline</span>
                                                                            <span class="align-middle">Experience [Beginner]</span>
                                                                        </li>

                                                                        <li class="list-group-item bg-transparent text-dark border-dark fs-5 text-truncate fw-bold">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">accessibility</span>
                                                                            <span class="align-middle">Focus [Arms, Legs, Full body]</span>
                                                                        </li>
                                                                    </ul>

                                                                    <div class="text-center">
                                                                        <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important;">horizontal_rule</span>
                                                                    </div>

                                                                    <div class="card-footer" style="border-radius: 25px;">
                                                                        <div class="d-grid my-4">
                                                                            <button class="btn onefit-buttons-style-dark p-4 fs-5 text-truncate">
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 40px; color: #ffa500;">flag</span>
                                                                                <span class="align-middle fs-5">Begin Workout<span style="color: #ffa500;">.</span></span>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ./ User Workouts - Bookmarked -->

                                            <!-- Todays user workout activities -->
                                            <div class="accordion-item p-2 my-2 shadow">
                                                <h2 class="accordion-header m-0" id="flush-headingIATOne">
                                                    <button class="accordion-button collapsed fs-5 fw-bold text-truncate" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseIATOne" aria-expanded="true" aria-controls="flush-collapseIATOne">
                                                        <span class="material-icons material-icons-round align-middle">bookmark</span>
                                                        <span class="align-middle"> Your Daily Workout (<span id="training-date-str">Date</span>) </span>
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseIATOne" class="accordion-collapse collapse w3-animate-bottom" aria-labelledby="flush-headingIATOne" data-bs-parent="#accordionFlushIATRegiment">
                                                    <div class="accordion-body">

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ./ Todays user workout activities -->

                                        </div>
                                        <!-- ./ Indi Athlectics Training Panel -->

                                    </div>
                                    <!-- ./ Indi Athletics Training Panel -->

                                    <!-- Next Tab button - Proceed to Team Athletics -->
                                    <hr class="text-white">
                                    <div class="mb-4 text-center" style="width: 100%">
                                        <div class="d-flex justify-content-center" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabCTA')">
                                                <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_forward</span></p>
                                                <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">stars</span> -->
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Team Athletics</p>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- ./Next Tab button - Proceed to Team Athletics -->
                                </div>
                                <div class="tab-pane fade w3-animate-bottom no-scroller py-4 px-2" id="v-sub-tab-pills-insights-teamathletics" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-insights-teamathletics-tab">
                                    <div class="d-grid text-center mt-4">
                                        <span class="material-icons material-icons-round">diversity_2</span>
                                        <h5 class="fs-1">Team Athletics</h5>
                                    </div>

                                    <hr class="text-white">

                                    <!-- Next Tab button - Return to Indi-Athlete -->
                                    <div class="my-4 text-center" style="width: 100%">
                                        <div class="d-flex justify-content-center" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabIAT')">
                                                <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_back</span></p>
                                                <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">sports_gymnastics</span> -->
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Indi-Athletics</p>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- ./Next Tab button - Return to Indi-Athlete -->

                                    <hr class="text-white">

                                    <!-- Team Athletics Training Panel -->
                                    <h1 class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti my-4">Team-Athletics Training</h1>
                                    <div class="mt-4" id="team-athletics-container">
                                        <div class="accordion accordion-flush" id="accordionFlushTATRegiment">
                                            <div class="accordion-item p-2 my-2 shadow">
                                                <h2 class="accordion-header m-0" id="flush-headingOne">
                                                    <button class="accordion-button collapsed fs-5 fw-bold text-truncate" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                                        <span class="material-icons material-icons-round align-middle">bookmark</span>
                                                        <span class="align-middle">Weekly Training Schedule (<span id="weekly-training-date-duration-str">Date</span>)</span>
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne" class="accordion-collapse collapse w3-animate-bottom" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushTATRegiment">
                                                    <div class="accordion-body">
                                                        <h5 class="fs-2 p-4 fw-bold rounded-pill text-center comfortaa-font shadow my-4 down-top-grad-tahiti">Upcoming Match Schedule</h5>
                                                        <div class="table-responsive mb-4">
                                                            <table class="table table-light table-striped my-4 shadow" style="border-radius: 25px !important; overflow: hidden;">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Match #</th>
                                                                        <th scope="col">Match Title</th>
                                                                        <th scope="col">Home Team</th>
                                                                        <th scope="col">Away Team</th>
                                                                        <th scope="col">Match Venue</th>
                                                                        <th scope="col">Match Date</th>
                                                                        <th scope="col">Start Time</th>
                                                                        <th scope="col">Standard Match Duration (Minutes)</th>
                                                                        <th scope="col">Observed Match Duration (Minutes)</th>
                                                                        <th scope="col">Match Result</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">1</th>
                                                                        <td>League Friendly - Team A (Home) vs Team B (Away)</td>
                                                                        <td>Team A</td>
                                                                        <td>Team B</td>
                                                                        <td>Stadium 1</td>
                                                                        <td>Saturday, 5 February 2022</td>
                                                                        <td>13:00</td>
                                                                        <td>90</td>
                                                                        <td>94</td>
                                                                        <td>Pending</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">2</th>
                                                                        <td>League Friendly - Team A (Home) vs Team B (Away)</td>
                                                                        <td>Team A</td>
                                                                        <td>Team B</td>
                                                                        <td>Stadium 1</td>
                                                                        <td>Saturday, 5 February 2022</td>
                                                                        <td>13:00</td>
                                                                        <td>90</td>
                                                                        <td>94</td>
                                                                        <td>Pending</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">3</th>
                                                                        <td>League Friendly - Team A (Home) vs Team B (Away)</td>
                                                                        <td>Team A</td>
                                                                        <td>Team B</td>
                                                                        <td>Stadium 1</td>
                                                                        <td>Saturday, 5 February 2022</td>
                                                                        <td>13:00</td>
                                                                        <td>90</td>
                                                                        <td>94</td>
                                                                        <td>Pending</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <p class="fs-2 p-4 fw-bold rounded-pill text-center comfortaa-font shadow my-4 down-top-grad-tahiti">Weekly Training Schedule</p>
                                                        <img src="../media/assets/example.png" alt="training week for ..." class="img-fluid mb-4" hidden>
                                                        <div class="training-schedule-container p-4 text-center down-top-grad-white comfortaa-font">
                                                            <h5>Training week for those who played 45+ minutes in previous match</h5>

                                                            <script>
                                                                function editAddNewActivityModal(day, grpRefcode) {
                                                                    // open the modal
                                                                    document.getElementById("toggleTabeditWeeklyTeamsTrainingScheduleModalBtn").click();

                                                                    // call the function/code to populate the modal body - use jquery ajax
                                                                    $.loadTeamsActivityCaptureForm(day, grpRefcode);
                                                                }

                                                                function toggleEditDayBar(day, groupRefCode) {
                                                                    // open the modal
                                                                    document.getElementById("toggleTabeditWeeklyTeamsTrainingScheduleModalBtn").click();

                                                                    // call the function/code to populate the modal body - use jquery ajax - "editbar" value (grpRefcode) will load a form for updating the title and rpe
                                                                    var initVal = "editbar";
                                                                    $.loadTeamsActivityCaptureForm(day, initVal);
                                                                }

                                                                function removeWeeklyTrainingActivity(day, groupRefCode, exerciseID) {

                                                                }
                                                            </script>

                                                            <div class="my-4 text-center d-gridz gap-2">
                                                                <button class="onefit-buttons-style-tahiti p-4 my-2" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="add-weekly-activity-btn remove-weekly-activity-btn">
                                                                    <span class="material-icons material-icons-round">
                                                                        edit_calendar
                                                                    </span>
                                                                    <p style="font-size: 10px;">Edit Weekly Schedule</p>
                                                                </button>
                                                            </div>
                                                            <hr class="text-white" style="height: 5px;">

                                                            <!-- script to load weekly schedule -->
                                                            <script>

                                                            </script>

                                                            <div class="row align-items-end text-dark" id="training-schedule-chart-grid">
                                                                <div class="col" id="day-1-col">
                                                                    <!-- Edit training day bar - Day 1 -->
                                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar1">
                                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                                edit
                                                                            </span>
                                                                        </button>
                                                                    </div>
                                                                    <!-- ./ Edit training day bar - Day 1 -->
                                                                    <p id="bar-title-day1" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        Regeneration
                                                                    </p>

                                                                    <p id="bar-rpe-day1" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        RPE 1-3
                                                                    </p>
                                                                    <div id="teams-weekly-activity-barchart-bar-day1" class="chart-col-bar p-2 shadow progress-bar progress-bar-stripedz bg-warningz">
                                                                        <div class="chart-col-bar-item text-center position-relative">
                                                                            <p>Cycling / Spinning</p>
                                                                            <img src="../media/assets/icons/cycling.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Strength & Core</p>
                                                                            <img src="../media/assets/icons/bodybuilder.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                    </div>

                                                                    <hr class="text-dark">

                                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="editAddNewActivityModal('monday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round align-middle">
                                                                                add_circle
                                                                            </span>
                                                                        </button>
                                                                    </div>

                                                                    <p class="text-center fs-5 fw-bold">Monday</p>
                                                                </div>

                                                                <div class="col" id="day-2-col">
                                                                    <!-- Edit training day bar - Day 2 -->
                                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar2">
                                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                                edit
                                                                            </span>
                                                                        </button>
                                                                    </div>
                                                                    <!-- ./ Edit training day bar - Day 2 -->
                                                                    <p id="bar-title-day2" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        Recovery
                                                                    </p>

                                                                    <p id="bar-rpe-day2" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        RPE 0
                                                                    </p>

                                                                    <div id="teams-weekly-activity-barchart-bar-day2" class="chart-col-bar p-2 shadow">
                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Ice Bath</p>
                                                                            <img src="../media/assets/icons/bath-tub.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                    </div>

                                                                    <hr class="text-dark">

                                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="editAddNewActivityModal('tuesday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round align-middle">
                                                                                add_circle
                                                                            </span>
                                                                        </button>
                                                                    </div>

                                                                    <p class="text-center fs-5 fw-bold">Tuesday</p>
                                                                </div>

                                                                <div class="col" id="day-3-col">
                                                                    <!-- Edit training day bar - Day 3 -->
                                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar3">
                                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                                edit
                                                                            </span>
                                                                        </button>
                                                                    </div>
                                                                    <!-- ./ Edit training day bar - Day 3 -->
                                                                    <p id="bar-title-day3" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        Longer pitch / strides
                                                                    </p>

                                                                    <p id="bar-rpe-day3" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        RPE 4-6
                                                                    </p>

                                                                    <div id="teams-weekly-activity-barchart-bar-day3" class="chart-col-bar p-2 shadow">
                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>RST</p>
                                                                            <img src="../media/assets/icons/running.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Tactics</p>
                                                                            <img src="../media/assets/icons/thinking.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Practice Kick-Off</p>
                                                                            <img src="../media/assets/icons/soccer-ball.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                    </div>

                                                                    <hr class="text-dark">

                                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="editAddNewActivityModal('wednesday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round align-middle">
                                                                                add_circle
                                                                            </span>
                                                                        </button>
                                                                    </div>

                                                                    <p class="text-center fs-5 fw-bold">Wednesday</p>
                                                                </div>

                                                                <div class="col" id="day-4-col">
                                                                    <!-- Edit training day bar - Day 4 -->
                                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar4">
                                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                                edit
                                                                            </span>
                                                                        </button>
                                                                    </div>
                                                                    <!-- ./ Edit training day bar - Day 4 -->
                                                                    <p id="bar-title-day4" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        Strength / change of directon
                                                                    </p>

                                                                    <p id="bar-rpe-day4" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        RPE 7-10
                                                                    </p>

                                                                    <div id="teams-weekly-activity-barchart-bar-day4" class="chart-col-bar p-2 shadow">
                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Multi-directional WU</p>
                                                                            <img src="../media/assets/icons/directions.png" alt="" class="img-fluid" style="filter: grayscale(100%);">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>SSGs</p>
                                                                            <img src="../media/assets/icons/running.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Strength</p>
                                                                            <img src="../media/assets/icons/bodybuilder.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Practice Kick-Off</p>
                                                                            <img src="../media/assets/icons/soccer-ball.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                    </div>

                                                                    <hr class="text-dark">

                                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="editAddNewActivityModal('thursday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round align-middle">
                                                                                add_circle
                                                                            </span>
                                                                        </button>
                                                                    </div>

                                                                    <p class="text-center fs-5 fw-bold">Thursday</p>
                                                                </div>

                                                                <div class="col" id="day-5-col">
                                                                    <!-- Edit training day bar - Day 5 -->
                                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar5">
                                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                                edit
                                                                            </span>
                                                                        </button>
                                                                    </div>
                                                                    <!-- ./ Edit training day bar - Day 5 -->
                                                                    <p id="bar-title-day5" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        Taper
                                                                    </p>

                                                                    <p id="bar-rpe-day5" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        RPE 1-3
                                                                    </p>

                                                                    <div id="teams-weekly-activity-barchart-bar-day5" class="chart-col-bar p-2 shadow">
                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Multi-directional WU</p>
                                                                            <img src="../media/assets/icons/directions.png" alt="" class="img-fluid" style="filter: grayscale(100%);">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Tempo runs</p>
                                                                            <img src="../media/assets/icons/running.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                    </div>

                                                                    <hr class="text-dark">

                                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="editAddNewActivityModal('friday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round align-middle">
                                                                                add_circle
                                                                            </span>
                                                                        </button>
                                                                    </div>

                                                                    <p class="text-center fs-5 fw-bold">Friday</p>
                                                                </div>

                                                                <div class="col" id="day-6-col">
                                                                    <!-- Edit training day bar - Day 6 -->
                                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar6">
                                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                                edit
                                                                            </span>
                                                                        </button>
                                                                    </div>
                                                                    <!-- ./ Edit training day bar - Day 6 -->
                                                                    <p id="bar-title-day6" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        Match prep
                                                                    </p>

                                                                    <p id="bar-rpe-day6" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        RPE 2-4
                                                                    </p>

                                                                    <div id="teams-weekly-activity-barchart-bar-day6" class="chart-col-bar p-2 shadow">
                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Multi-directional WU</p>
                                                                            <img src="../media/assets/icons/directions.png" alt="" class="img-fluid" style="filter: grayscale(100%);">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Tactics</p>
                                                                            <img src="../media/assets/icons/thinking.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Short SSGs</p>
                                                                            <img src="../media/assets/icons/running.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                    </div>

                                                                    <hr class="text-dark">

                                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="editAddNewActivityModal('saturday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round align-middle">
                                                                                add_circle
                                                                            </span>
                                                                        </button>
                                                                    </div>

                                                                    <p class="text-center fs-5 fw-bold">Saturday</p>
                                                                </div>

                                                                <div class="col" id="day-7-col">
                                                                    <!-- Edit training day bar - Day 7 -->
                                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar7">
                                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                                edit
                                                                            </span>
                                                                        </button>
                                                                    </div>
                                                                    <!-- ./ Edit training day bar - Day 7 -->
                                                                    <p id="bar-title-day7" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        Match
                                                                    </p>

                                                                    <p id="bar-rpe-day7" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                                        RPE 7-10
                                                                    </p>

                                                                    <div id="teams-weekly-activity-barchart-bar-day7" class="chart-col-bar p-2 shadow">
                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Pre-match WU</p>
                                                                            <img src="../media/assets/icons/running.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                        <div class="chart-col-bar-item text-center">
                                                                            <p>Match Kick-Off - We Play to Win!</p>
                                                                            <img src="../media/assets/icons/soccer-ball.png" alt="" class="img-fluid">

                                                                            <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                                                                                <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('monday','group_ref_code_here','activity_exercise_id')">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                                        delete
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="text-white my-2 p-0" style="height: 5px;">

                                                                    </div>

                                                                    <hr class="text-dark">

                                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="editAddNewActivityModal('sunday','group_ref_code_here')">
                                                                            <span class="material-icons material-icons-round align-middle">
                                                                                add_circle
                                                                            </span>
                                                                        </button>
                                                                    </div>

                                                                    <p class="text-center fs-5 fw-bold">Sunday</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item p-2 my-2 shadow">
                                                <h2 class="accordion-header m-0" id="flush-headingTwo">
                                                    <button class="accordion-button collapsed fs-5 fw-bold text-truncate" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="true" aria-controls="flush-collapseTwo">
                                                        <span class="material-icons material-icons-round align-middle">bookmark</span>
                                                        <span class="align-middle">Weekly Training Schedule (<span id="weekly-training-date-duration-str">Date</span>)</span>
                                                        Daily Workout (<span id="training-date-str">Date</span>)
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseTwo" class="accordion-collapse collapse w3-animate-bottom" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushTATRegiment">
                                                    <div class="accordion-body">
                                                        <p class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti text-white my-4 comfortaa-font">Program Title</p>

                                                        SoccerXpert - Soccer Drill Template
                                                        Source: https://www.soccerxpert.com/drills

                                                        Latest Soccer Drills
                                                        Below you will find a few of the latest soccer drills posted to SoccerXpert

                                                        <p class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti text-white my-4 comfortaa-font">Pre-Training</p>
                                                        <div id="pre-training-activities">
                                                            <div class="card mb-3 shadow" style="background-color: #343434 !important; color: #fff !important; border-radius: 25px !important;">
                                                                <div class="row g-0 align-items-center">
                                                                    <div class="col-md-4 p-4">
                                                                        <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-1-Thumbnail.png" class="img-fluid rounded-startz w-100 shadow" style="border-radius: 25px;" alt="thumbnail placeholder">
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title fw-bold text-center">1v1 Speed and Reaction Game</h5>
                                                                            <hr>
                                                                            <ul class="list-group list-group-horizontal-md border-0 text-center">
                                                                                <li class="list-group-item flex-fill border-0 bg-transparent text-white">
                                                                                    Chris Johnson
                                                                                </li>
                                                                                <li class="list-group-item flex-fill border-0 bg-transparent text-white">
                                                                                    10,871 Views
                                                                                </li>
                                                                                <li class="list-group-item flex-fill border-0 bg-transparent text-white">
                                                                                    Rating 0 (0 Reviews)
                                                                                </li>
                                                                            </ul>
                                                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>

                                                                            <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-1.png" class="img-fluid w-100 my-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <p class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti text-white my-4 comfortaa-font">Warm-Up</p>
                                                        <div id="warm-up-activities">
                                                            <div class="card mb-3 shadow" style="background-color: #343434 !important; color: #fff !important; border-radius: 25px !important;">
                                                                <div class="row g-0 align-items-center">
                                                                    <div class="col-md-4 p-4">
                                                                        <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-1-Thumbnail.png" class="img-fluid rounded-startz w-100 shadow" style="border-radius: 25px;" alt="thumbnail placeholder">
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title fw-bold text-center">1v1 Speed and Reaction Game</h5>
                                                                            <hr>
                                                                            <ul class="list-group list-group-horizontal-md border-0 text-center">
                                                                                <li class="list-group-item flex-fill border-0 bg-transparent text-white">
                                                                                    Chris Johnson
                                                                                </li>
                                                                                <li class="list-group-item flex-fill border-0 bg-transparent text-white">
                                                                                    10,871 Views
                                                                                </li>
                                                                                <li class="list-group-item flex-fill border-0 bg-transparent text-white">
                                                                                    Rating 0 (0 Reviews)
                                                                                </li>
                                                                            </ul>
                                                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>

                                                                            <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-1.png" class="img-fluid w-100 my-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="card mb-3 shadow" style="background-color: #343434 !important; color: #fff !important; border-radius: 25px !important;">
                                                                <div class="row g-0 align-items-center">
                                                                    <div class="col-md-4 p-4">
                                                                        <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-2-Thumbnail.png" class="img-fluid rounded-startz w-100 shadow" style="border-radius: 25px;" alt="thumbnail placeholder">
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title fw-bold text-center">Soccer Tic-Tac-Toe Warm-Up</h5>
                                                                            <hr>
                                                                            <ul class="list-group list-group-horizontal-md border-0 text-center">
                                                                                <li class="list-group-item flex-fill border-0 bg-transparent text-white">
                                                                                    Chris Johnson
                                                                                </li>
                                                                                <li class="list-group-item flex-fill border-0 bg-transparent text-white">
                                                                                    30,837 Views
                                                                                </li>
                                                                                <li class="list-group-item flex-fill border-0 bg-transparent text-white">
                                                                                    Rating 0 (0 Reviews)
                                                                                </li>
                                                                            </ul>
                                                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>

                                                                            <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-2.png" class="img-fluid w-100 mb-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <p class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti text-white my-4 comfortaa-font">Mid-Training</p>
                                                        <div id="mid-training-activities">
                                                            <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-3.png" class="img-fluid w-100 mb-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">
                                                            <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-4.png" class="img-fluid w-100 mb-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">
                                                            <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-5.png" class="img-fluid w-100 mb-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">
                                                            <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-6.png" class="img-fluid w-100 mb-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">
                                                            <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-7.png" class="img-fluid w-100 mb-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">
                                                            <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-8.png" class="img-fluid w-100 mb-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">
                                                            <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-9.png" class="img-fluid w-100 mb-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">
                                                            <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-10.png" class="img-fluid w-100 mb-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">
                                                        </div>


                                                        <p class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti text-white my-4 comfortaa-font">Post-Training</p>
                                                        <h5>Identify Painful Areas</h5>
                                                        <p>Identification of pain on body chart - Select Areas where pain is being experienced</p>
                                                        <p>Themographic Body Chart - Trainer will enter temperature data in a capturing form.</p>
                                                        <p>Rate your Muscle Soreness according to the scale above</p>
                                                        <img src="../media/assets/Muscle Sorness Rating Scale.png" alt="Muscle Soreness Rating Scale" style="border-radius: 15px;" class="img-fluid mb-4 shadow">

                                                        <div class="row align-items-start">
                                                            <div class="col-md no-sroller" style="overflow-x:auto;">
                                                                <h5>(Front)</h5>
                                                                <img src="../media/assets/body_charts/muscle-men-body-map-front.jpg" alt="" class="img-fluidz map image-map-male-front" usemap="#image-map-male-front">
                                                                <map name="image-map-male-front">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Head')" target="" alt="Male-Front-Head " title="Male-Front-Head " coords="249,98,221,109,218,145,210,143,212,156,220,166,221,177,232,190,241,230,246,232,250,237,255,232,258,225,265,192,276,178,279,165,286,156,286,143,280,138,280,122,270,105" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Pectoralis-Major-Left')" target="" alt="Male-Front-Pectoralis-Major-Left" title="Male-Front-Pectoralis-Major-Left" coords="253,305,254,256,265,235,289,236,302,241,317,244,325,257,328,270,319,269,315,282,309,300,295,311,272,314" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Pectoralis-Major-Right')" target="" alt="Male-Front-Pectoralis-Major-Right" title="Male-Front-Pectoralis-Major-Right" coords="246,303,245,254,235,235,211,235,194,241,177,245,173,259,170,274,181,265,184,279,185,293,194,305,213,315,238,310" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Trapezius-Left')" target="" alt="Male-Front-Trapezius-Left" title="Male-Front-Trapezius-Left" coords="275,182,266,195,258,236,276,232,305,226,284,213,274,203" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Trapezius-Right')" target="" alt="Male-Front-Trapezius-Right" title="Male-Front-Trapezius-Right" coords="224,184,230,192,235,213,241,234,231,233,209,230,196,225,214,215,226,207" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Adominalis-Upper-Left')" target="" alt="Male-Front-Adominalis-Upper-Left" title="Male-Front-Adominalis-Upper-Left" coords="250,312,250,369,287,373,286,315,272,315,257,308" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Adominalis-Upper-Right')" target="" alt="Male-Front-Adominalis-Upper-Right" title="Male-Front-Adominalis-Upper-Right" coords="247,310,248,367,213,373,213,317,224,314" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Adominalis-Lower-Left')" target="" alt="Male-Front-Adominalis-Lower-Left" title="Male-Front-Adominalis-Lower-Left" coords="251,374,250,448,253,485,265,485,284,430,287,376,263,373" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Adominalis-Lower-Right')" target="" alt="Male-Front-Adominalis-Lower-Right" title="Male-Front-Adominalis-Lower-Right" coords="230,371,250,374,247,439,246,486,233,484,215,426,215,376" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-External_Oblique-Left')" target="" alt="Male-Front-External_Oblique-Left" title="Male-Front-External_Oblique-Left" coords="290,314,288,379,287,431,291,447,301,435,312,430,316,429,311,386,310,368,314,355,304,334,300,322" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-External_Oblique-Right')" target="" alt="Male-Front-External_Oblique-Right" title="Male-Front-External_Oblique-Right" coords="212,442,213,426,209,395,210,365,211,316,196,329,185,345,192,376,183,423,196,433,205,442" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Serratus_Anterior-Left')" target="" alt="Male-Front-Serratus_Anterior-Left" title="Male-Front-Serratus_Anterior-Left" coords="291,312,300,319,308,340,314,349,318,321,323,327,323,292,326,270,321,269,310,301" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Serratus_Anterior-Right')" target="" alt="Male-Front-Serratus_Anterior-Right" title="Male-Front-Serratus_Anterior-Right" coords="210,315,194,330,184,343,181,320,177,326,176,294,175,270,180,268,184,299,194,307" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Deltoid-Left')" target="" alt="Male-Front-Deltoid-Left" title="Male-Front-Deltoid-Left" coords="357,301,359,268,352,244,327,224,313,224,293,236,320,244,328,257,330,276" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Deltoid-Right')" target="" alt="Male-Front-Deltoid-Right" title="Male-Front-Deltoid-Right" coords="144,298,141,269,145,246,167,227,188,225,206,235,174,244,168,279" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Bicep_Long_Head-Left')" target="" alt="Male-Front-Bicep_Long_Head-Left" title="Male-Front-Bicep_Long_Head-Left" coords="362,365,366,346,363,335,364,320,357,303,331,276,344,302,354,323" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Bicep_Long_Head-Right')" target="" alt="Male-Front-Bicep_Long_Head-Right" title="Male-Front-Bicep_Long_Head-Right" coords="139,362,132,346,135,336,139,315,145,299,170,277,154,305,147,321,142,344" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Bicep_Short_Head-Left')" target="" alt="Male-Front-Bicep_Short_Head-Left" title="Male-Front-Bicep_Short_Head-Left" coords="362,366,346,356,337,333,336,355,324,329,326,273,332,281,352,320,358,348" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Bicep_Short_Head-Right')" target="" alt="Male-Front-Bicep_Short_Head-Right" title="Male-Front-Bicep_Short_Head-Right" coords="138,369,152,357,164,339,165,357,177,326,175,272,164,292,151,315,144,336" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Brachioradialis-Left')" target="" alt="Male-Front-Brachioradialis-Left" title="Male-Front-Brachioradialis-Left" coords="407,451,397,464,384,465,359,420,347,395,338,379,336,366,337,354,338,337,345,349,346,354,363,366,367,345,379,361,387,391,393,414,397,428" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Brachioradialis-Right')" target="" alt="Male-Front-Brachioradialis-Right" title="Male-Front-Brachioradialis-Right" coords="117,465,105,464,94,453,111,408,117,378,131,349,138,358,139,372,152,355,156,346,163,343,163,377,143,419,127,441" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Hand-Lef')" target="" alt="Male-Front-Hand-Left" title="Male-Front-Hand-Left" coords="384,468,397,467,408,454,449,494,441,529,432,543,419,544,401,535,384,491" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Hand-Right')" target="" alt="Male-Front-Hand-Right" title="Male-Front-Hand-Right" coords="94,455,103,465,116,469,101,536,82,543,67,541,58,526,52,491,82,462" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Sartorius-Left')" target="" alt="Male-Front-Sartorius-Left" title="Male-Front-Sartorius-Left" coords="310,432,308,454,305,471,299,495,287,536,278,563,273,603,273,622,285,658,276,642,272,628,269,610,266,590,268,571,268,557,279,515,285,487,292,477,298,453" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Sartorius-Right')" target="" alt="Male-Front-Sartorius-Right" title="Male-Front-Sartorius-Right" coords="189,434,190,447,191,459,197,480,205,513,212,536,223,569,226,599,225,625,220,641,215,655,224,643,227,616,230,603,231,577,231,546,220,511,215,496,211,483,206,475,202,453" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Abductor-Left')" target="" alt="Male-Front-Abductor-Left" title="Male-Front-Abductor-Left" coords="257,502,266,488,275,471,304,437,291,473,281,498,276,522,267,558,267,575,265,588,257,559,256,534,253,520" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Abductor-Right')" target="" alt="Male-Front-Abductor-Right" title="Male-Front-Abductor-Right" coords="245,510,246,523,245,538,242,557,232,597,231,543,213,482,205,469,200,447,191,432,208,453,216,461,227,475,235,493" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Vastus_Medialis-Left')" target="" alt="Male-Front-Vastus_Medialis-Left" title="Male-Front-Vastus_Medialis-Left" coords="287,538,279,562,274,603,273,620,279,629,289,634,297,624,294,595,286,569" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Vastus_Medialis-Right')" target="" alt="Male-Front-Vastus_Medialis-Right" title="Male-Front-Vastus_Medialis-Right" coords="226,631,215,639,205,630,204,610,212,582,215,554,214,545,221,568,225,599" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Vastus_Laterialis-Left')" target="" alt="Male-Front-Vastus_Laterialis-Left" title="Male-Front-Vastus_Laterialis-Left" coords="317,482,326,501,329,537,328,572,324,594,320,608,319,628,311,626,307,611,311,595,319,576,323,538,321,509" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Vastus_Laterialis-Right')" target="" alt="Male-Front-Vastus_Laterialis-Right" title="Male-Front-Vastus_Laterialis-Right" coords="184,480,174,503,171,536,172,572,174,592,179,607,180,621,184,626,190,619,193,608,187,593,179,566,178,524,182,497" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Tensor_Fasciae_Latae-Left')" target="" alt="Male-Front-Tensor_Fasciae_Latae-Left" title="Male-Front-Tensor_Fasciae_Latae-Left" coords="317,427,323,451,324,480,329,505,313,476,310,451,312,434" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Tensor_Fasciae_Latae-Right')" target="" alt="Male-Front-Tensor_Fasciae_Latae-Right" title="Male-Front-Tensor_Fasciae_Latae-Right" coords="183,426,188,434,189,454,185,472,173,506,177,462,178,445" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Tibialis_Anterior-Left')" target="" alt="Male-Front-Tibialis_Anterior-Left" title="Male-Front-Tibialis_Anterior-Left" coords="316,655,317,677,320,713,320,735,309,773,308,827,303,827,306,749,307,702,308,673" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Tibialis_Anterior-Right')" target="" alt="Male-Front-Tibialis_Anterior-Right" title="Male-Front-Tibialis_Anterior-Right" coords="182,657,179,717,179,733,184,750,190,773,191,824,197,825,194,732,191,698,190,678,189,664" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Extensor_Digitorum_Longus-Left')" target="" alt="Male-Front-Extensor_Digitorum_Longus-Left" title="Male-Front-Extensor_Digitorum_Longus-Left" coords="320,716,326,723,325,731,317,775,317,823,309,827,309,775,321,735" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Extensor_Digitorum_Longus-Right')" target="" alt="Male-Front-Extensor_Digitorum_Longus-Right" title="Male-Front-Extensor_Digitorum_Longus-Right" coords="179,720,175,723,173,734,181,773,182,803,183,820,190,825,189,773,178,731" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Peroneus_Longus-Left')" target="" alt="Male-Front-Peroneus_Longus-Left" title="Male-Front-Peroneus_Longus-Left" coords="318,656,325,667,329,698,327,722,321,713" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Peroneus_Longus-Right')" target="" alt="Male-Front-Peroneus_Longus-Right" title="Male-Front-Peroneus_Longus-Right" coords="180,655,174,667,171,702,173,727,178,717,179,690" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Gastrocnemius-Left')" target="" alt="Male-Front-Gastrocnemius-Left" title="Male-Front-Gastrocnemius-Left" coords="282,676,295,702,295,737,287,749,285,760,277,736,278,703" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Gastrocnemius-Right')" target="" alt="Male-Front-Gastrocnemius-Right" title="Male-Front-Gastrocnemius-Right" coords="217,673,205,697,203,738,210,745,215,761,221,737,221,703" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Soleus-Left')" target="" alt="Male-Front-Soleus-Left" title="Male-Front-Soleus-Left" coords="294,826,295,740,288,750,285,761,292,789" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Soleus-Right')" target="" alt="Male-Front-Soleus-Right" title="Male-Front-Soleus-Right" coords="205,825,203,741,209,747,215,764,207,794" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Patella-Left')" target="" alt="Male-Front-Patella-Left" title="Male-Front-Patella-Left" coords="301,646,17" shape="circle">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Patella-Right')" target="" alt="Male-Front-Patella-Right" title="Male-Front-Patella-Right" coords="195,645,17" shape="circle">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Tibia-Left')" target="" alt="Male-Front-Tibia-Left" title="Male-Front-Tibia-Left" coords="301,826,296,825,297,700,283,676,279,654,292,663,302,665,311,662,306,675,306,719" shape="poly">
                                                                    <area data-maphilight='{"strokeColor":"0000ff","strokeWidth":5,"fillColor":"00ff00","fillOpacity":0.6}' onclick="toggleMapSelection('Male-Front-Tibia-Right')" target="" alt="Male-Front-Tibia-Right" title="Male-Front-Tibia-Right" coords="204,826,197,827,195,730,191,665,202,662,210,655,215,660,217,669,204,694,203,712,201,739" shape="poly">
                                                                </map>
                                                            </div>
                                                            <div class="col-md no-sroller" style="overflow-x:auto;">
                                                                <h5>(Back)</h5>
                                                                <img src="../media/assets/body_charts/muscle-men-body-map-back.jpg" alt="" class="img-fluidz" usemap="#image-map-male-back" hiddenz>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <h5>Muscles</h5>
                                                                <ul class="list-group list-group-flush" style="border-radius: 25px !important;">
                                                                    <li class="list-group-item">
                                                                        <div class="row">
                                                                            <div class="col-lg-4">
                                                                                <p class="fs-5 fw-bold">Muscle Title</p>
                                                                            </div>
                                                                            <div class="col-lg-8">
                                                                                <p class="fs-5 fw-bold">Pain Intensity</p>
                                                                                <img src="../media/assets/Muscle Sorness Rating Scale.png" alt="Muscle Soreness Rating Scale" class="img-fluid mb-4">
                                                                                <p>Rate your Muscle Soreness according to the scale above</p>
                                                                                <div class="input-group">
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="radio" name="inlineRadioMuscleIntensity" id="inlineRadioMuscleIntensity1" value="Intensity-1">
                                                                                        <label class="form-check-label" for="inlineRadioMuscleIntensity1">1</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="radio" name="inlineRadioMuscleIntensity" id="inlineRadioMuscleIntensity2" value="Intensity-2">
                                                                                        <label class="form-check-label" for="inlineRadioMuscleIntensity2">2</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="radio" name="inlineRadioMuscleIntensity" id="inlineRadioMuscleIntensity3" value="Intensity-3">
                                                                                        <label class="form-check-label" for="inlineRadioMuscleIntensity3">3</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="radio" name="inlineRadioMuscleIntensity" id="inlineRadioMuscleIntensity4" value="Intensity-4">
                                                                                        <label class="form-check-label" for="inlineRadioMuscleIntensity4">4</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="radio" name="inlineRadioMuscleIntensity" id="inlineRadioMuscleIntensity5" value="Intensity-5">
                                                                                        <label class="form-check-label" for="inlineRadioMuscleIntensity5">5</label>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="">
                                                                                    <p class="fs-5 fw-bold">Temp Reading (&#176;C)</p>
                                                                                    <input type="text" name="" id="" class="onefit-inputs-style" placeholder="Temp Reading (&#176;C)">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item p-2 my-2 shadow">
                                                <h2 class="accordion-header m-0" id="flush-headingThree">
                                                    <button class="accordion-button collapsed fs-5 fw-bold text-truncate" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                        <span class="material-icons material-icons-round align-middle">bookmark</span>
                                                        <span class="align-middle">Match Day Activities (<span id="match-date-str">Date</span>)</span>
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseThree" class="accordion-collapse collapse w3-animate-bottom" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushTATRegiment">
                                                    <div class="accordion-body">
                                                        <!-- Weekly match schedule display -->
                                                        <div class="text-center w-100 comfortaa-font mb-4" style="padding-top: 100px; padding-bottom: 100px">
                                                            No Scheduled Match this week.

                                                            <!-- Team Formation -->
                                                            <div id="teamathletics-team-formation" class="py-4">
                                                                <p class="fs-5 comfortaa-font">Team Formation</p>
                                                                <div class="mb-4" id="soccerfield" style=" overflow-x: auto; border-radius: 25px; padding-bottom: 20px;"></div>

                                                                <!-- starting squad team list -->
                                                                <div class="row">
                                                                    <div class="col-sm">
                                                                        <div class="no-scroller py-0" id="drag-player-pin">
                                                                            <!-- Include a header DIV with the same name as the draggable DIV, followed by "header" -->
                                                                            <div id="drag-player-pinheader">
                                                                                <img src="../media/profiles/0_default/default_profile_pic.png" alt="Player Profile Image" height="50" width="50" class="rounded-circle img-fluid border-1 border-white">
                                                                                <p class="text-white fs-5 fw-bold m-0 mt-2">#9</p>
                                                                            </div>
                                                                            <div class="drag-player-pin-container no-scroller p-0">
                                                                                <div class="collapse no-scroller" id="collapseExample">
                                                                                    <div class="card card-body bg-transparent">
                                                                                        <p class="text-white m-0">Details</p>
                                                                                        <p class="text-white m-0">Details</p>
                                                                                        <p class="text-white m-0">Details</p>
                                                                                        <p class="text-white m-0">Details</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm">
                                                                        Thumbnail
                                                                    </div>
                                                                    <div class="col-sm">
                                                                        Player Names
                                                                    </div>
                                                                    <div class="col-sm">
                                                                        View Profile Btn
                                                                    </div>
                                                                </div>
                                                                <!-- ./ starting squad team list -->

                                                                <!-- Substitude list -->
                                                                <div id="teamathletics-substitutes" class="py-4">
                                                                    <p class="text-end mt-4">Substitutes</p>
                                                                    <ul class="list-group list-group-flush" style="border-radius: 25px !important;">
                                                                        <li class="list-group-item">
                                                                            <div class="row">
                                                                                <div class="col-sm">
                                                                                    Thumbnail
                                                                                </div>
                                                                                <div class="col-sm">
                                                                                    Player Names
                                                                                </div>
                                                                                <div class="col-sm">
                                                                                    View Profile Btn
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- ./ Substitude list -->

                                                                <!-- reserves list -->
                                                                <div id="teamathletics-reserves" class="py-4">
                                                                    <p class="text-end mt-4">Reserves</p>
                                                                    <ul class="list-group list-group-flush" style="border-radius: 25px !important;">
                                                                        <li class="list-group-item">
                                                                            <div class="row">
                                                                                <div class="col-sm">
                                                                                    Thumbnail
                                                                                </div>
                                                                                <div class="col-sm">
                                                                                    Player Names
                                                                                </div>
                                                                                <div class="col-sm">
                                                                                    View Profile Btn
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- ./ reserves list -->
                                                            </div>
                                                            <!-- ./ Team Formation -->

                                                        </div>
                                                        <!-- ./ Weekly match schedule display -->

                                                        <!-- match-day phases breakdown container -->
                                                        <div id="match-day-breakdown-container">
                                                            <!-- Fueling Plan -->
                                                            <p class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti text-white my-4 comfortaa-font">Matchday: Carbohydrate Feuling Plan</p>
                                                            <img src="../media/assets/body_charts/carbohydrate fueling plan.jpeg" alt="carbohydrate fueling plan template" class="img-fluid mb-4 shadow" style="border-radius: 25px;">
                                                            <!-- ./ Fueling Plan -->

                                                            <!-- Pre-Match -->
                                                            <p class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti text-white my-4 comfortaa-font">Pre-Match</p>
                                                            <p>Pe-Match warm up jog / routine / drill</p>
                                                            <!-- ./ Pre-Match -->

                                                            <!-- Mid-Match -->
                                                            <p class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti text-white my-4 comfortaa-font">Mid-Match</p>
                                                            <!-- ./ Mid-Match -->

                                                            <!-- Post-Match -->
                                                            <p class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti text-white my-4 comfortaa-font">Post-Match</p>
                                                            <img src="../media/assets/body_charts/training recovery plan.jpeg" class="img-fluid" alt="recovery chart Sample" hidden>
                                                            <div class="recovery-chart">
                                                                <h5 class="my-4 text-center p-4 rounded-pill comfortaa-font" style="background-color: #ffa500; color: #343434 !important;">WITHIN 30 MINUTES</h5>
                                                                <p class="fw-bold text-center">CHOOSE AT LEAST ONE WHITE BOX OPTION</p>
                                                                <input type="number" value="0" class="form-control" id="min30-selection-count">
                                                                <div class="grid-container my-4">
                                                                    <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center d-inline" style="height: 200px; background: #343434; color: #fff;">
                                                                        <span class="align-middle fw-bold">Carbohydrate / Protein Recovery Drink
                                                                            <hr class="bg-white">
                                                                        </span>
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center" style="height: 200px; background: #343434; color: #fff;">
                                                                        <span class="align-middle fw-bold">Carbohydrate Food
                                                                            <hr class="bg-white">
                                                                        </span>
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('30min','option-1')">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                                                                            <label class="form-check-label text-center" for="min30-option-1-check">
                                                                                <span class="align-middle fw-bold">Light Exercise / Stretch Cool Down</span>
                                                                            </label>
                                                                        </div>
                                                                        <hr class="bg-dark">
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('30min','option-2')">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                                                                            <label class="form-check-label text-center" for="min30-option-2-check">
                                                                                <span class="align-middle fw-bold">Cold Water Immersion - 10 Minutes</span>
                                                                            </label>
                                                                        </div>
                                                                        <hr class="bg-dark">
                                                                    </div>
                                                                </div>

                                                                <h5 class="my-4 text-center p-4 rounded-pill comfortaa-font" style="background-color: #ffa500; color: #343434 !important;">WITHIN 1 HOUR</h5>
                                                                <p class="fw-bold text-center">CHOOSE AT LEAST ONE WHITE BOX OPTION</p>
                                                                <input type="number" value="0" class="form-control" id="hr1-selection-count">
                                                                <div class="grid-container my-4">
                                                                    <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center d-inline" style="height: 200px; background: #343434; color: #fff;">
                                                                        <span class="align-middle fw-bold">1 X 500ML Rehydrate Drink</span>
                                                                        <hr class="bg-white">
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center" style="height: 200px; background: #343434; color: #fff;">
                                                                        <span class="align-middle fw-bold">Carbohydrate Food</span>
                                                                        <hr class="bg-white">
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('1hr','option-1')">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                                                                            <label class="form-check-label text-center" for="hr1-option-1-check">
                                                                                <span class="align-middle fw-bold">Lower Limb Massage</span>
                                                                            </label>
                                                                        </div>
                                                                        <hr class="bg-dark">
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('1hr','option-2')">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                                                                            <label class="form-check-label text-center" for="hr1-option-2-check">
                                                                                <span class="align-middle fw-bold">Compression Tights Until Bed</span>
                                                                            </label>
                                                                        </div>
                                                                        <hr class="bg-dark">
                                                                    </div>
                                                                </div>

                                                                <h5 class="my-4 text-center p-4 rounded-pill comfortaa-font" style="background-color: #ffa500; color: #343434 !important;">WITHIN 24 HOURS</h5>
                                                                <p class="fw-bold text-center">CHOOSE AT LEAST THREE WHITE BOX OPTION</p>
                                                                <input type="number" value="0" class="form-control" id="hr24-selection-count">
                                                                <div class="grid-container my-4">
                                                                    <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center d-inline" style="height: 200px; background: #343434; color: #fff;">
                                                                        <span class="align-middle fw-bold">2 X 500ML Rehydrate Drink</span>
                                                                        <hr class="bg-white">
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center" style="height: 200px; background: #343434; color: #fff;">
                                                                        <span class="align-middle fw-bold">Rest - Aim for 8 Hours Sleep</span>
                                                                        <hr class="bg-white">
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-1')">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                                                                            <label class="form-check-label text-center" for="hr24-option-1-check">
                                                                                <span class="align-middle fw-bold">Light Exercise and Foam Roll</span>
                                                                            </label>
                                                                        </div>
                                                                        <hr class="bg-dark">
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-2')">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                                                                            <label class="form-check-label text-center" for="hr24-option-1-check">
                                                                                <span class="align-middle fw-bold">Contrast Bath - 2 Minutes Hot / 2 Minutes Cold X 4</span>
                                                                            </label>
                                                                        </div>
                                                                        <hr class="bg-dark">
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-3')">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                                                                            <label class="form-check-label text-center" for="hr24-option-1-check">
                                                                                <span class="align-middle fw-bold">Mobility and Stretching in Pool</span>
                                                                            </label>
                                                                        </div>
                                                                        <hr class="bg-dark">
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-4')">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                                                                            <label class="form-check-label text-center" for="hr24-option-1-check">
                                                                                <span class="align-middle fw-bold">Massage</span>
                                                                            </label>
                                                                        </div>
                                                                        <hr class="bg-dark">
                                                                    </div>
                                                                    <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-5')">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                                                                            <label class="form-check-label text-center" for="hr24-option-1-check">
                                                                                <span class="align-middle fw-bold">Recovery Pump Trousers</span>
                                                                            </label>
                                                                        </div>
                                                                        <hr class="bg-dark">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- ./ Post-Match -->
                                                        </div>
                                                        <!-- ./ match-day phases breakdown container -->

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item p-2 my-2 shadow">
                                                <h2 class="accordion-header m-0" id="flush-headingFour">
                                                    <button class="accordion-button collapsed fs-5 fw-bold text-truncate" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                                        <span class="material-icons material-icons-round align-middle">bookmark</span>
                                                        <span class="align-middle">Team-Athletics Training Programs (Administrators)</span>
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseFour" class="accordion-collapse collapse w3-animate-bottom" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushTATRegiment">
                                                    <div class="accordion-body">
                                                        <img src="../media/assets/Soccer_Drills/Soccer_Expert_-_Drill-Filters.png" class="img-fluid w-100 my-4" alt="Soccer Expert Drills Reference Img" style="border-radius: 25px;">

                                                        <div class="grid-container">
                                                            <div class="grid-tile p-4 down-top-grad-tahiti shadow" style="border-radius: 0 0 25px 25px;">
                                                                <p class="fs-2 fw-bold comfortaa-font">Warm-Up Drills</p>
                                                            </div>

                                                            <div class="grid-tile p-4 down-top-grad-tahiti shadow" style="border-radius: 0 0 25px 25px;">
                                                                <p class="fs-2 fw-bold comfortaa-font">Pair Drills</p>
                                                            </div>

                                                            <div class="grid-tile p-4 down-top-grad-tahiti shadow" style="border-radius: 0 0 25px 25px;">
                                                                <p class="fs-2 fw-bold comfortaa-font">Speed & Reaction Drills</p>
                                                            </div>

                                                            <div class="grid-tile p-4 down-top-grad-tahiti shadow" style="border-radius: 0 0 25px 25px;">
                                                                <p class="fs-2 fw-bold comfortaa-font">Dribbling Drills</p>
                                                            </div>

                                                            <div class="grid-tile p-4 down-top-grad-tahiti shadow" style="border-radius: 0 0 25px 25px;">
                                                                <p class="fs-2 fw-bold comfortaa-font">Shooting Drills</p>
                                                            </div>

                                                            <div class="grid-tile p-4 down-top-grad-tahiti shadow" style="border-radius: 0 0 25px 25px;">
                                                                <p class="fs-2 fw-bold comfortaa-font">Shooting Drills</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ./ Team Athletics Training Panel -->

                                    <!-- Next Tab button - Proceed to Wellness Tracking -->
                                    <hr class="text-white">
                                    <div class="mb-4 text-center" style="width: 100%">
                                        <div class="d-flex justify-content-center" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabWell')">
                                                <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_forward</span></p>
                                                <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">self_improvement</span> -->
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Wellness</p>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- ./Next Tab button - Proceed to Wellness Tracking -->

                                </div>
                                <div class="tab-pane fade w3-animate-bottom no-scroller py-4 px-2" id="v-sub-tab-pills-insights-wellness" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-insights-wellness-tab">
                                    <div class="d-grid text-center mt-4">
                                        <span class="material-icons material-icons-round">self_improvement</span>
                                        <h5 class="mt-4 fs-1">Wellness Tracking</h5>
                                    </div>
                                    <hr class="text-white">

                                    <!-- Next Tab button - Return to Team Athletics -->
                                    <div class="mb-4 text-center" style="width: 100%">
                                        <div class="d-flex justify-content-center" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabCTA')">
                                                <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_back</span></p>
                                                <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">diversity_2</span> -->
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Team Athletics</p>
                                            </button>
                                        </div>
                                    </div>
                                    <hr class="text-white">
                                    <!-- ./Next Tab button - Return to Team Athletics -->

                                    <h1 class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti my-4">Wellness Tracking.</h1>

                                    <div class="mt-4" id="wellness-tracking-container">
                                        <img src="../media/assets/smartwatches/9aea1c56ffe237edeb69ecd3988bfd51.jpg" class="img-fluid shadow mb-4" style="border-radius: 25px;" alt="dashboard placeholder">
                                        <img src="../media/assets/smartwatches/fitbit-web1.webp" class="img-fluid shadow mb-4" style="border-radius: 25px;" alt="dashboard placeholder">
                                    </div>

                                    <!-- Next Tab button - Proceed to Nutrition Tracking -->
                                    <hr class="text-white">
                                    <div class="mb-4 text-center" style="width: 100%">
                                        <div class="d-flex justify-content-center" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabCTA')">
                                                <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_forward</span></p>
                                                <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">restaurant</span> -->
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Nutrition</p>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- ./Next Tab button - Proceed to Nutrition Tracking -->
                                </div>
                                <div class="tab-pane fade w3-animate-bottom no-scroller py-4 px-2" id="v-sub-tab-pills-insights-nutrition" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-insights-nutrition-tab">
                                    <div class="d-grid text-center mt-4">
                                        <span class="material-icons material-icons-round">restaurant</span>
                                        <h5 class="mt-4 fs-1">Nutrition Tracking</h5>
                                    </div>

                                    <hr class="text-white">

                                    <!-- Next Tab button - Return to Wellness Tracking -->
                                    <div class="mb-4 text-center" style="width: 100%">
                                        <div class="d-flex justify-content-center" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabCTA')">
                                                <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_back</span></p>
                                                <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">self_improvement</span> -->
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Wellness</p>
                                            </button>
                                        </div>
                                    </div>
                                    <hr class="text-white">
                                    <!-- ./Next Tab button - Return to Wellness Tracking -->

                                    <h1 class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti my-4">Nutrition Tracking.</h1>
                                    <div class="mt-4" id="wellness-tracking-container">
                                        <img src="../media/assets/smartwatches/A8_Dashboard_Overview.png" class="img-fluid shadow mb-4" style="border-radius: 25px;" alt="dashboard placeholder">
                                    </div>
                                </div>
                                <!-- ./ #v-sub-tab-pills -->
                            </div>
                            <!-- ./ Team Athlectics Training Panel -->

                        </div>
                        <!-- ./ insight catgories tab panels -->
                    </div>
                    <!-- ./ Features: Tab structured -->

                    <!-- ads strip -->
                    <div class="text-center d-grid justify-content-center align-items-center" style="max-height: 80vh; overflow-y: auto; min-height: 200px">
                        <h5>Ads<span style="color: #ffa500;">.</span></h5>
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <!-- ./ ads strip -->

                </div>
                <div id="TabAchievements" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-midde" style="color: #ffa500 !important; font-size: 40px;">emoji_events</span> Achievements</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <hr class="text-white" />
                    <h5>Goals</h5>
                    <hr class="text-white">
                    <h5>Timeframes</h5>
                    <hr class="text-white">
                    <h5>Challenges</h5>
                    <hr class="text-white">

                    <h5 class="mt-4">Fitness Progression</h5>
                    <div class="progress mt-4" style="height: 4px;">
                        <div class="progress-bar" role="progressbar" aria-label="Example 1px high" style="width: 25%; background-color: #ffa500 !important; border-right: #343434 10px solid;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row mt-2" style="margin-bottom: 60px;">
                        <div class="col text-start comfortaa-font" style="font-size: 12px;">
                            Current XP <strong>(112)</strong>
                        </div>
                        <div class="col text-end comfortaa-font" style="font-size: 12px;">
                            Target XP <strong>(150)</strong>
                        </div>
                    </div>

                    <h5 class="my-4">Daily Challenges</h5>

                    <div id="daily-challenges-grid" class="grid-container mb-4">
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-body-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-deadlift-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-muscle-flexing-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-exercise-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-fit-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-workout-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                    </div>

                    <h5 class="my-4">Weekly Challenges</h5>

                    <div id="weekly-challenges-grid" class="grid-container mb-4">
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-body-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-deadlift-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-muscle-flexing-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-exercise-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-fit-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-workout-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                    </div>

                    <h5 class="my-4">Monthly Monthly</h5>

                    <div id="monthly-challenges-grid" class="grid-container mb-4">
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-body-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-deadlift-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-muscle-flexing-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-exercise-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-fit-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-workout-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                    </div>

                    <h5>Diary</h5>
                    <hr class="text-white">
                    <h5>Resources</h5>
                    (bookmarked resources, posts or search engine links)
                    <hr class="text-white">
                </div>
                <div id="TabMedia" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-midde" style="color: #ffa500 !important; font-size: 40px;">perm_media</span> Media</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>
                    <!-- <h1 class="text-center">Media</h1>
                    <hr class="text-white" /> -->

                    <h1 class="fs-1 fw-bold rounded-pill p-4 text-center my-4">Photos</h1>
                    <div id="Users-Images" class="grid-container">
                        <?php echo $outputProfileUserMediaList; ?>
                    </div>

                    <h1 class="fs-1 fw-bold rounded-pill p-4 text-center my-4">Videos</h1>

                    <h1 class="fs-1 fw-bold rounded-pill p-4 text-center my-4">Stream library – Live stream recording history (Community and Private)</h1>
                </div>
                <div id="TabCommunication" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-midde" style="color: #ffa500 !important; font-size: 40px;">forum</span> Communications</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>
                    <!-- <h1 class="text-center">Communications</h1>
                    <hr class="text-white" /> -->

                    <p>• Notifications</p>
                    <div id="communicationUserNotifications">
                        <?php echo $outputProfileUserNotifications; ?>
                    </div>
                    <p>• Latest Updates / News</p>
                    <div id="communicationNews">
                        <?php echo $outputCommunityNews; ?>
                    </div>
                    <p>• Chat Messenger</p>
                    <div class="p-0 mb-4 d-grid gap-2 my-pulse-animation-dark rounded-pill">
                        <button class="onefit-buttons-style-dark p-4 text-center fs-1 comfortaa-font shadow rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottomOnefitChat" aria-controls="offcanvasBottomOnefitChat">
                            One<span style="color:#ffa500;">fit.</span>Chat
                        </button>
                    </div>
                    <p>• Social AdMarket</p>
                </div>
                <div id="TabSettings" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-midde" style="color: #ffa500 !important; font-size: 40px;">settings_accessibility</span> Preferences</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>
                    <!-- <h1 class="text-center">Preferences</h1>
                    <hr class="text-white" /> -->

                    <div id="userPrefContainer">
                        <?php echo $profileUserPref; ?>
                    </div>
                </div>
            </div>
            <!-- ./ #tab-container -->
        </div>
        <!-- ./ Tab Content -->
    </div>
    <!-- ./ Main Content -->

    <!-- Footer -->
    <nav class="text-white w-100 m-0 p-0 fixed-bottom navbar-stylez tunnel-bg-container no-scroller" style="max-height: 100vh !important; overflow-y: auto; overflow-x: hidden">
        <!--style="position: fixed; bottom: 0; left: 0; background: #333; z-index: 10002"-->
        <div class="down-top-grad-darkz mainapp-footer px-2">

            <!-- Widgets Container -->
            <div class="collapse m-0 p-0" id="widget-rows-container">
                <div class="navbar p-4">
                    <h1 class="text-center mt-4"><span class="material-icons material-icons-round" style="font-size: 40px !important">
                            widgets </span> Widgets</h1>

                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-toggle="collapse" data-bs-target="#widget-rows-container" aria-controls="widget-rows-container">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>


                <hr class="text-white" />

                <!-- Widget: User Profile Preview List (Widget: UPPL - It is hidden on lg screens) -->
                <div class="container-lg comfortaa-font rounded-pillz shadow pb-4 px-0 m-0z text-white w-100 d-lg-none" style="border-radius: 25px; background-color: #343434; overflow: hidden">
                    <div class="text-center">
                        <!--<span class="material-icons material-icons-round" style="font-size: 48px !important"> account_circle </span>-->

                        <!-- Users Profile Banner -->
                        <div class="shadow-lg" style="height: 200px; width: 100%; overflow: hidden; background-image: url('../media/images/fitness/Battle-ropes-Cordes-ondulatoires-EVO-Fitness-1200x675.jpg'); background-position: center; background-attachment: local; background-clip: content-box; background-size: cover">
                        </div>
                        <!-- ./ Users Profile Banner -->

                        <!-- Profile Picture -->
                        <img src="../media/assets/One-Symbol-Logo-Two-Tone.png" alt="Onefit Logo" class="p-3 img-fluid my-pulse-animation-tahiti borderz" style="margin-top: -100px; max-height: 200px; border-radius: 50%; border-color: #ffa500 !important; background-color: #343434" />
                        <!-- ./ Profile Picture -->
                        <p class="outfit-font mt-2">@Username</p>
                    </div>
                    <!--<hr class="text-white" />-->

                    <div class="row">
                        <div class="col-md">
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Thabang Mposula</div>
                                        @username<br />
                                        Lvl. 1
                                    </div>
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            verified_user </span>
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Followers</div>
                                        2 Mutual Friends<br />
                                        6 Messages
                                    </div>
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px"><span class="material-icons material-icons-round" style="font-size: 20px !important"> people_alt
                                        </span> 6</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold text-center" style="color: #ffa500">Achievements</div>
                                        18 Activities Remaining<br />
                                        4 Challenges Remaining
                                    </div>
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px"><span class="material-icons material-icons-round" style="font-size: 20px !important"> emoji_events
                                        </span> 3</span>
                                </li>
                            </ol>
                        </div>
                        <div class="col-md-5 text-center">
                            <h3>Social</h3>
                            <div class="container-fluid">
                                <div class="row align-items-center" style="font-size: 40px;">
                                    <div class="col m">
                                        <button class="border-0 social-link-icon-insta p-4 my-4" style="cursor: pointer" onClick="launchLink('www.google.com')"><i class="fab fa-instagram"></i>
                                        </button>
                                    </div>

                                    <div class="col">
                                        <button class="border-0 social-link-icon-twitter p-4 my-4" style="cursor: pointer" onClick="launchLink('www.google.com')"><i class="fab fa-twitter"></i>
                                        </button>
                                    </div>

                                    <div class="col">
                                        <button class="border-0 social-link-icon-fb p-4 my-4" style="cursor: pointer" onClick="launchLink('www.google.com')"><i class="fab fa-facebook"></i>
                                        </button>
                                    </div>

                                    <div class="col">
                                        <button class="border-0 social-link-icon-yt p-4 my-4" style="cursor: pointer" onClick="launchLink('www.google.com')">
                                            <i class="fab fa-youtube"></i>
                                        </button>
                                    </div>
                                </div>

                                <hr class="text-white">
                                <!-- Twitter feed -->
                                <div class="m-4 no-scroller" style="border-radius: 25px !important; overflow-y: scroll; max-height: 90vh">
                                    <a class="twitter-timeline" href="https://twitter.com/OnefitNet?ref_src=twsrc%5Etfw">Tweets by
                                        OnefitNet</a>
                                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                </div>
                                <!-- ./ Twitter feed -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./ Widget: User Profile Preview List -->

                <div class="row align-items-center p-4">
                    <div class="col-lg text-center my-4">
                        <div class="container-lg p-4 shadow-lg d-inline-block border-start border-end" style="border-radius: 25px; border-color: #ffa500 !important; background-color: #343434">
                            <div class="row align-items-center text-center comfortaa-font">
                                <div class="col-sm py-2 d-inline">
                                    <!--<i class="fas fa-heart"></i>-->
                                    <span class="material-icons material-icons-round"> monitor_heart </span>
                                    Heart Rate
                                </div>
                                <div class="col-sm py-2 d-inline"><span style="color: #ffa500">|</span></div>
                                <div class="col-sm py-2 d-inline">
                                    <!--<i class="fas fa-thermometer-half"></i>-->
                                    <span class="material-icons material-icons-round"> device_thermostat </span>
                                    Temp
                                </div>
                                <div class="col-sm py-2 d-inline">
                                    <img src="../media/assets/icons/icons8-smart-watch-50.png" alt="smartwatch" class="img-fluid my-pulse-animation-tahiti" />
                                </div>
                                <div class="col-sm py-2 d-inline">
                                    <!--<i class="fas fa-bolt"></i>-->
                                    <span class="material-icons material-icons-round"> bolt </span>
                                    Speed
                                </div>
                                <div class="col-sm py-2 d-inline"><span style="color: #ffa500">|</span></div>
                                <div class="col-sm py-2 d-inline">
                                    <!--<i class="fas fa-walking"></i>-->
                                    <span class="material-icons material-icons-round"> directions_walk </span>
                                    Steps
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 text-center">
                        <div class="py-4 shadow border-start border-end" style="border-radius: 25px; border-color: #ffa500 !important; background-color: #343434">
                            <h5>One<span style="color: #ffa500">fit</span>.Muse <span class="material-icons material-icons-round">
                                    equalizer
                                </span></h5>
                            <hr class="text-white" />
                            <p class="outfit-font fw-bold comfortaa-font">No media playing.</p>
                            <div class="container-lg">
                                <div class="row my-4">
                                    <div class="col-sm">
                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('prev')"><span class="material-icons material-icons-round">skip_previous</span></button>
                                    </div>
                                    <div class="col-sm">
                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('togglePlay')"><span class="material-icons material-icons-round">play_circle</span></button>
                                    </div>
                                    <div class="col-sm">
                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('next')"><span class="material-icons material-icons-round">skip_next</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center py-2">
                    <hr class="text-white" />
                    | Privacy |
                    <p class="m-0 p-0"><span class="m-0 float-right" style="font-size: 10px">Crafted by AdaptivConcept &copy;
                            2021</span></p>
                </div>
            </div>
            <!-- ./ Widgets Container -->
        </div>
    </nav>
    <!-- ./ Footer -->

    <!-- Modals ----------------------------------------------------------------------------------------- -->

    <!-- Button trigger modal>>>>>>>>>> Tab Navigation Modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tabNavModal" hidden>
        Launch #tabNavModal</button>

    <!-- >>>>>>>>>> Tab Navigation Modal -->
    <div class="modal fade" id="tabNavModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tabNavModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content feature-tab-nav-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fs-1" id="tabNavModalLabel"><span style="color: #ffa500;">.apps</span> menu</h5>
                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>
                <hr class="text-white m-0" />
                <div class="modal-body border-0" style="overflow-x: hidden">
                    <!-- Tab Navigation Buttons Container -->
                    <div class="grid-container text-center">
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-dashboard-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabHome')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> dashboard </span>
                                    <div class="d-inline">
                                        <i class="fas fa-home"></i> <span style="color: #fff !important;">Dashboard</span>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-profile-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabProfile')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> account_circle </span>
                                    <span style="color: #fff !important;">Profile
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-discovery-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabDiscovery')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> travel_explore </span>
                                    <span style="color: #fff !important;">Discovery</span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-studio-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabStudio')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> play_circle_outline </span>
                                    <span style="color: #fff !important;">Onefit.Studio</span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-store-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabStore')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> storefront </span>
                                    <span style="color: #fff !important;">Onefit.Store</span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-social-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabSocial')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> hub </span>
                                    <span style="color: #fff !important;">Onefit.Social</span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-insights-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabData')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> insights </span>
                                    <span style="color: #fff !important;">Fitness Insights</span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-achievements-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabAchievements')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> emoji_events </span>
                                    <span class="align-middle" style="color: #fff !important;">Achievements <span class="material-icons material-icons-round text-muted" style="font-size: 12px !important;"> lock </span></span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-media-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabMedia')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> perm_media </span>
                                    <span class="align-middle" style="color: #fff !important;">Media <span class="material-icons material-icons-round text-muted" style="font-size: 12px !important;"> lock </span></span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-comms-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabCommunication')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> forum </span>
                                    <span style="color: #fff !important;">Communications</span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-preferences-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabSettings')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> settings_accessibility </span>
                                    <span style="color: #fff !important;">Preferences</span>
                                </div>
                            </button>
                        </div>
                    </div>
                    <!-- ./ Tab Navigation Buttons Container -->
                </div>
                <hr class="text-white m-0" />
                <div class="modal-footer border-0 d-inline-block">

                    <div class="d-grid gap-2">
                        <button class="onefit-buttons-style-dark fs-5 fw-bold my-4 px-4 pt-4 text-center comfortaa-font border-0" type="button" data-bs-toggle="collapse" data-bs-target="#tab-nav-social-quickpost" aria-expanded="false" aria-controls="tab-nav-social-quickpost"><i class="fas fa-paper-plane"></i> | <span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Social</button>
                    </div>

                    <div class="row align-items-center collapse" id="tab-nav-social-quickpost">
                        <div class="col-sm d-grid gap-2 py-4 px-0">
                            <!-- Quick Post to Social -->
                            <div class="social-quick-post d-grid">
                                <textarea name="" class="w-100 quick-post-input" id="" cols="30" rows="3" placeholder="Share an update with the Community.">Share an update with the Community.</textarea>
                            </div>
                            <!-- ./ Quick Post to Social -->
                        </div>
                        <div class="col-sm-4 d-grid gap-2">
                            <div class="row text-center">
                                <div class="col -sm px-0">
                                    <div class="d-grid">
                                        <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                            <span class="material-icons material-icons-round" style="font-size: 18px !important">
                                                attach_file </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col -sm px-0">
                                    <div class="d-grid">
                                        <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                            <span class="material-icons material-icons-round" style="font-size: 18px !important">
                                                perm_media </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col -sm px-0">
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
            </div>
        </div>
    </div>
    <!-- ./ >>>>>>>>>> Tab Navigation Modal -->

    <!-- >>>>>>>>>> Latest Socials Feed Modal -->
    <div class="modal fade" id="tabLatestSocialModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tabLatestSocialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content feature-tab-nav-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fs-1" id="tabLatestSocialModalLabel">One<span style="color: #ffa500">fit.</span>Net Updates &amp; Socials</h5>
                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>
                <div class="modal-body bg-whitez border-0" style="overflow-x: hidden">
                    <!-- Latest Updates & Socials Container -->
                    <!-- Main User Profile Preview List (Main UPPL - It is hidden on screens smaller than lg) -->
                    <div class="shadow p-0" style="border-radius: 25px; background-color: #343434; overflow: hidden;" id="main-upp-list">
                        <div class="container comfortaa-font p-0 mt-2 text-white mx-4z d-nonez d-lg-blockz">
                            <!-- UPPL Header (with Banner and Profile Pic) -->
                            <div class="text-center">
                                <!--<span class="material-icons material-icons-round" style="font-size: 48px !important"> account_circle </span>-->

                                <!-- Users Profile Banner -->
                                <div class="shadow -lg m-0" style="border-radius: 30px 30px 100% 100%; height: 400px; width: 100%; overflow: hidden; background-image: url('../media/assets/fitness-colage.png'); background-position: center; background-attachment: local; background-clip: content-box; background-size: cover; border-bottom: solid 5px white;">
                                </div>
                                <!-- ./ Users Profile Banner -->

                                <!-- Profile Picture -->
                                <img src="../media/assets/One-Symbol-Logo-Two-Tone.png" alt="Onefit Logo" class="p-3 img-fluid my-pulse-animation-darkz shadow" style="margin-top: -100px; height: 200px; border-radius: 50%; border-color: #ffa500 !important; background-color: #343434" />
                                <!-- ./ Profile Picture -->
                                <p class="mt-2 mt-4 fs-1 fw-bold comfortaa-font">One<span style="color: #ffa500;">fit</span>.app</p>
                            </div>
                            <!-- ./ UPPL Header (with Banner and Profile Pic) -->

                            <div class="row">
                                <div class="col-md">
                                    <ol class="list-group list-group-flush border-0 my-4">
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold" style="color: #ffa500">One-On-One Fitness Network&reg;</div>
                                                @OnefitNet<br />
                                                Community Growth: <br>
                                                1 Trainee (<i class="fas fa-solid fa-dash"></i> 0%)
                                            </div>
                                            <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                                <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                                    workspace_premium </span>
                                                Awards Issued
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold text-end" style="color: #ffa500">Followers</div>
                                                2 Trainees<br />
                                                6 Trainers<br />
                                                20 Groups<br />
                                                16 000 Resources<br />
                                                89 Fitness Programs<br />
                                                20 Diet Programs<br />
                                                5 Wellness Programs
                                            </div>
                                            <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px"><span class="material-icons material-icons-round" style="font-size: 20px !important"> people_alt
                                                </span> 6</span>
                                        </li>
                                    </ol>
                                </div>
                                <div class="col-md-5 text-center">
                                    <h3>Support us on Socials</h3>
                                    <div class="container-fluid">
                                        <div class="row align-items-center" style="font-size: 40px;">
                                            <div class="col m">
                                                <button class="border-0 social-link-icon-insta p-4 my-4 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                                                    <div class="d-grid gap-2">
                                                        <i class="fab fa-instagram"></i>
                                                        <p style="font-size: 10px !important;">Instagram</p>
                                                    </div>
                                                </button>
                                            </div>

                                            <div class="col">
                                                <button class="border-0 social-link-icon-twitter p-4 my-4 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                                                    <div class="d-grid gap-2">
                                                        <i class="fab fa-twitter"></i>
                                                        <p style="font-size: 10px !important;">Twitter</p>
                                                    </div>
                                                </button>
                                            </div>

                                            <div class="col">
                                                <button class="border-0 social-link-icon-fb p-4 my-4 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                                                    <div class="d-grid gap-2">
                                                        <i class="fab fa-facebook"></i>
                                                        <p style="font-size: 10px !important;">Facebook</p>
                                                    </div>
                                                </button>
                                            </div>

                                            <div class="col">
                                                <button class="border-0 social-link-icon-yt p-4 my-4 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                                                    <div class="d-grid gap-2">
                                                        <i class="fab fa-youtube"></i>
                                                        <p style="font-size: 10px !important;">Youtube</p>
                                                    </div>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="text-white">
                            <div class="row my-4">
                                <div class="col-md text-center">
                                    <h4>Twitter Feed</h4>
                                    <!-- Twitter feed -->
                                    <div class="m-4 no-scroller" style="border-radius: 25px !important; overflow-y: scroll;">
                                        <a class="twitter-timeline" href="https://twitter.com/OnefitNet?ref_src=twsrc%5Etfw">Tweets by
                                            OnefitNet</a>
                                        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                    </div>
                                    <!-- ./ Twitter feed -->
                                </div>
                                <div class="col-md text-center border-start border-end border-warning" style="border-color: #ffa500 !important;">
                                    <h4>Facebook Feed</h4>
                                    <div class="d-flex align-items-center">
                                        <div style="display: none;">
                                            <strong>Loading Facebook Feed...</strong>
                                            <div class="spinner-border text-light ms-auto" role="status" aria-hidden="true"></div>
                                        </div>

                                        <!-- Facebook feed -->
                                        <div class="fb-page" data-href="https://web.facebook.com/OnefitnetworkZA" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                            <blockquote cite="https://web.facebook.com/OnefitnetworkZA" class="fb-xfbml-parse-ignore"><a href="https://web.facebook.com/OnefitnetworkZA">One-On-One Fitness Network</a></blockquote>
                                        </div>
                                        <!-- ./ Facebook feed -->
                                    </div>
                                </div>
                                <div class="col-md text-center">
                                    <h4>Instagram Feed</h4>
                                    <div class="text-center">
                                        <div class="spinner-border text-light ms-auto" style="width: 5rem; height: 5rem;" role="status" aria-hidden="true"></div>
                                    </div>
                                </div>
                                <!--<div class="col-md">
                  <h4>Latest on YouTube</h4>
                </div>-->
                            </div>
                        </div>
                    </div>
                    <!-- ./ MainUser Profile Preview List -->
                    <!-- ./ Latest Updates & Socials Container -->
                </div>
                <div class="modal-footer border-0 d-inline-block">
                    <hr class="text-white" />
                    <div class="d-grid gap-2">
                        <button class="onefit-buttons-style-dark fs-5 fw-bold my-4 px-4 pt-4 text-center comfortaa-font border-0" type="button" data-bs-toggle="collapse" data-bs-target="#tab-nav-social-quickpost" aria-expanded="false" aria-controls="tab-nav-social-quickpost"><i class="fas fa-paper-plane"></i> | <span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Social</button>
                    </div>

                    <div class="row align-items-end collapse no-scroller shadow" style="max-height: 50vh !important; overflow-y: auto; border-radius: 25px;" id="tab-nav-social-quickpost">
                        <div class="col-sm d-grid gap-2 py-4 px-0">
                            <!-- Quick Post to Social -->
                            <div class="social-quick-post d-grid">
                                <textarea name="" class="w-100 quick-post-input" id="" cols="30" rows="10" style="height: 40vh!important" placeholder="Share an update with the Community.">Share an update with the Community.</textarea>
                            </div>
                            <!-- ./ Quick Post to Social -->
                        </div>
                        <div class="col-sm-4 d-grid gap-2 py-4" style="overflow-x: hidden">
                            <!-- Onefit.Social Feed - Hide the feed container on screens smaller than large -->
                            <div class="onefit-social-container d-grid gap-2">
                                <button class="onefit-buttons-style-dark p-4 mb-4 shadow comfortaa-font">
                                    <span class="align-middle"> Open <br> <span class="fw-bold" style="color:#ffa500!important; font-size: 40px;">.Social</span></span> <span class="align-middle material-icons material-icons-outlined">hub</span>
                                </button>
                                <div class="mb-4 no-scroller" hidden style="max-height: 18vh; overflow-y: auto;">
                                    <?php echo $outputCommunityUpdates; ?>
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="col -sm px-0">
                                    <div class="d-grid">
                                        <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                            <span class="material-icons material-icons-round" style="font-size: 18px !important">
                                                attach_file </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col -sm px-0">
                                    <div class="d-grid">
                                        <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                            <span class="material-icons material-icons-round" style="font-size: 18px !important">
                                                perm_media </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col -sm px-0">
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
            </div>
        </div>
    </div>
    <!-- ./ >>>>>>>>>> Latest Socials Feed Modal -->

    <!-- >>>>>>>>>> Chat Modal -->
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottomOnefitChat" aria-controls="offcanvasBottomOnefitChat" hidden>Toggle bottom offcanvas</button>

    <div class="offcanvas offcanvas-bottom" style="height: 100vh !important;" tabindex="-1" id="offcanvasBottomOnefitChat" aria-labelledby="offcanvasBottomOnefitChatLabel">
        <div class="offcanvas-body small p-0 no-scroller" style="overflow-x: hidden;">
            <div class="card text-center m-0 border-0" style="height:100%">
                <div class="card-header bg-transparentz border-0 shadow sticky-top" style="background-color: #343434 !important; color: #fff !important;">
                    <div class="offcanvas-header">
                        <button class="onefit-buttons-style-dark p-4 shadow" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMyUserChats" aria-expanded="false" aria-controls="collapseMyUserChats">
                            <span class="material-icons material-icons-round">
                                3p
                            </span>
                        </button>

                        <h3 class="offcanvas-title" id="offcanvasBottomOnefitChatLabel">
                            <span class=" text-truncate">One<span style="color: #ffa500">fit.</span></span>Chat
                        </h3>

                        <!--<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>-->

                        <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="offcanvas" aria-label="Close">
                            <span class="material-icons material-icons-round"> cancel </span>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row h-100 px-4 no-scroller" style="max-height: 70vh; overflow-y: auto !important;">
                        <div class="col-sm-4 collapse w3-animate-top" id="collapseMyUserChats">
                            <!--Users Chats List-->
                            <ul class="list-group list-group-flush text-start top-down-grad-dark" style="padding-bottom: 100px !important;">
                                <?php echo $outputProfileUserChats; ?>
                            </ul>
                            <!-- ./ Users Chats List-->
                        </div>
                        <div class="col-sm shadow no-scroller my-4 p-2 text-white down-top-grad-dark" style="border-radius: 25px; overflow-y: auto; overflow-x: hidden; max-height: 65vh !important;margin-bottom: 200px !important;">
                            <div class="row align-items-center">
                                <div class="col-4 d-grid gap-2">
                                    <!-- Selected Users Friend Chat Profile Strip -->
                                    <button type="button" class="onefit-buttons-style-dark p-2 my-4 position-relative">
                                        <div class="container">
                                            <div class="row align-items-center" style="min-height: 100px;">
                                                <div class="col -3 text-center">
                                                    <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                                </div>
                                                <div class="col text-center">
                                                    <p class="fs-5 my-0 text-truncate">Visit Profile</p>
                                                </div>
                                            </div>
                                        </div>

                                        <span class="position-absolute top-0 start-100 translate-middle p-2 bg-dangerz border border-light rounded-circle my-pulse-animation-tahiti" style="background-color: #ffa500 !important;">
                                            <span class="visually-hidden">New Message Alert</span>
                                        </span>
                                    </button>
                                    <!-- ./ Selected Users Friend Chat Profile Strip -->
                                </div>
                                <div class="col text-dark">
                                    <h1>Stuff</h1>
                                </div>
                            </div>


                            <div class="tunnel-bg-container content-panel-border-style no-scroller p-4 shadow" style="width: 100%; height: 100%; background-color: rgba(52, 52, 52, 0.8) !important; overflow-y: auto !important; overflow-x: hidden !important;">
                                <!-- User Chat Bubble - Left (Users Friend) -->
                                <div class="row align-items-center">
                                    <div class="col-sm text-start">
                                        <div class="d-grid gap-2">
                                            <div class="text-start" style="width: 100%;">
                                                <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>

                                            <div class="talk-bubble shadow tri-right shadow btm-leftz left-top" style="border-radius: 0 25px 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 text-start"></div>
                                </div>
                                <!-- ./ User Chat Bubble - Left (Users Friend) -->

                                <!-- User Chat Bubble - Right (User) -->
                                <div class="row align-items-start">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm text-end">
                                        <div class="d-grid gap-2">
                                            <div class="text-end" style="width: 100%;">
                                                <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>

                                            <div class="talk-bubble shadow tri-right shadow btm-rightz right-top" style="border-radius: 25px 0 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./ User Chat Bubble - Right (User) -->
                                <!-- User Chat Bubble - Left (Users Friend) -->
                                <div class="row align-items-center">
                                    <div class="col-sm text-start">
                                        <div class="d-grid gap-2">
                                            <div class="text-start" style="width: 100%;">
                                                <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>

                                            <div class="talk-bubble shadow tri-right shadow btm-leftz left-top" style="border-radius: 0 25px 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 text-start"></div>
                                </div>
                                <!-- ./ User Chat Bubble - Left (Users Friend) -->

                                <!-- User Chat Bubble - Right (User) -->
                                <div class="row align-items-start">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm text-end">
                                        <div class="d-grid gap-2">
                                            <div class="text-end" style="width: 100%;">
                                                <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>

                                            <div class="talk-bubble shadow tri-right shadow btm-rightz right-top" style="border-radius: 25px 0 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./ User Chat Bubble - Right (User) -->
                                <!-- User Chat Bubble - Left (Users Friend) -->
                                <div class="row align-items-center">
                                    <div class="col-sm text-start">
                                        <div class="d-grid gap-2">
                                            <div class="text-start" style="width: 100%;">
                                                <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>

                                            <div class="talk-bubble shadow tri-right shadow btm-leftz left-top" style="border-radius: 0 25px 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 text-start"></div>
                                </div>
                                <!-- ./ User Chat Bubble - Left (Users Friend) -->

                                <!-- User Chat Bubble - Right (User) -->
                                <div class="row align-items-start">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm text-end">
                                        <div class="d-grid gap-2">
                                            <div class="text-end" style="width: 100%;">
                                                <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>

                                            <div class="talk-bubble shadow tri-right shadow btm-rightz right-top" style="border-radius: 25px 0 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./ User Chat Bubble - Right (User) -->
                                <!-- User Chat Bubble - Left (Users Friend) -->
                                <div class="row align-items-center">
                                    <div class="col-sm text-start">
                                        <div class="d-grid gap-2">
                                            <div class="text-start" style="width: 100%;">
                                                <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>

                                            <div class="talk-bubble shadow tri-right shadow btm-leftz left-top" style="border-radius: 0 25px 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 text-start"></div>
                                </div>
                                <!-- ./ User Chat Bubble - Left (Users Friend) -->

                                <!-- User Chat Bubble - Right (User) -->
                                <div class="row align-items-start">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm text-end">
                                        <div class="d-grid gap-2">
                                            <div class="text-end" style="width: 100%;">
                                                <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>

                                            <div class="talk-bubble shadow tri-right shadow btm-rightz right-top" style="border-radius: 25px 0 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./ User Chat Bubble - Right (User) -->
                                <!-- User Chat Bubble - Left (Users Friend) -->
                                <div class="row align-items-center">
                                    <div class="col-sm text-start">
                                        <div class="d-grid gap-2">
                                            <div class="text-start" style="width: 100%;">
                                                <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>

                                            <div class="talk-bubble shadow tri-right shadow btm-leftz left-top" style="border-radius: 0 25px 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 text-start"></div>
                                </div>
                                <!-- ./ User Chat Bubble - Left (Users Friend) -->

                                <!-- User Chat Bubble - Right (User) -->
                                <div class="row align-items-start">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm text-end">
                                        <div class="d-grid gap-2">
                                            <div class="text-end" style="width: 100%;">
                                                <img src="../media/profiles/0_default/default_profile_pic.png" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>

                                            <div class="talk-bubble shadow tri-right shadow btm-rightz right-top" style="border-radius: 25px 0 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./ User Chat Bubble - Right (User) -->

                                <!--Users Chat Conversation Panel-->

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 fixed-bottom down-top-grad-dark">
                    <div class="row py-4 align-items-end">
                        <div class="col-sm">
                            <textarea class="onefit-inputs-style p-4 shadow" style="border-radius: 25px !important;" name="" id="" cols="30" rows="3">Wassup, Dude?</textarea>
                        </div>
                        <div class="col-sm-2 d-grid gap-2">
                            <button class="onefit-buttons-style-dark p-4 shadow">
                                <span class="material-icons material-icons-round">
                                    try
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ >>>>>>>>>> Chat Modal -->

    <!-- Button trigger modal>>>>>>>>>> Tab Activity Tracker Capture Modal -->
    <button id="toggleTabCaptureActivityTrackerDataModalBtn" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tabCaptureActivityTrackerDataModal" hidden aria-hidden="true">
        Launch #captureactivitytracker</button>

    <!-- >>>>>>>>>> Tab Activity Tracker Capture Modal -->
    <div class="modal fade" id="tabCaptureActivityTrackerDataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tabCaptureActivityTrackerDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content feature-tab-nav-content content-panel-border-stylez">
                <!-- style="border-bottom: #ffa500 5px solid;" -->
                <div class="modal-header border-0">
                    <h5 class="modal-title align-middle" id="tabCaptureActivityTrackerDataModalLabel">
                        <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">
                            analytics
                        </span>
                        <span class=" align-middle">Capture Activity Tracking Data</span>
                    </h5>
                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>
                <hr class="text-white m-0z">
                <div class="modal-body border-0" style="overflow-x: hidden">
                    <div class="row align-items-center text-center comfortaa-font">
                        <div class="col-sm py-2 text-truncate">
                            <!--<i class="fas fa-heart"></i>-->
                            <div class="d-inline">
                                <span class="material-icons material-icons-round align-middle"> monitor_heart </span>
                                <span class="align-middle">Heart rate</span>
                            </div>

                        </div>
                        <div class="col-sm py-2 text-truncate">
                            <div class="d-inline">
                                <span class="align-middle" style="color: #ffa500">|</span>
                            </div>
                        </div>
                        <div class="col-sm py-2 text-truncate">
                            <!--<i class="fas fa-thermometer-half"></i>-->
                            <div class="d-inline">
                                <span class="material-icons material-icons-round align-middle"> device_thermostat </span>
                                <!-- Degree symbol html code: &#176; -->
                                <span class="align-middle">Temp&#176;</span>
                            </div>
                        </div>
                        <div class="col-sm py-2 text-center">
                            <div class="d-inline">
                                <button class="btn p-4 onefit-buttons-style-dark" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="heartrate-expand-icon heartrate-data-input-form-container">
                                    <img src="../media/assets/icons/icons8-smart-watch-50.png" alt="smartwatch" class="img-fluid mb-2" />
                                    <span class="material-icons material-icons-round my-pulse-animation-tahiti p-2">fitbit</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm py-2 text-truncate">
                            <!--<i class="fas fa-bolt"></i>-->
                            <div class="d-inline">
                                <span class="material-icons material-icons-round align-middle"> bolt </span>
                                <span class="align-middle">Speed</span>
                            </div>
                        </div>
                        <div class="col-sm py-2 text-truncate">
                            <div class="d-inline">
                                <span class="align-middle" style="color: #ffa500">|</span>
                            </div>
                        </div>
                        <div class="col-sm py-2 text-truncate">
                            <!--<i class="fas fa-walking"></i>-->
                            <div class="d-inline">
                                <span class="material-icons material-icons-round align-middle"> directions_walk </span>
                                <span class="align-middle">Steps</span>
                            </div>
                        </div>
                    </div>

                    <hr class="text-white">

                    <!-- detailed metric list -->
                    <ul class="list-group list-group-flush text-white border-0">
                        <!-- js submitting activity tracker data foms -->
                        <script>
                            function triggerSubmitActivityTrackerData(formLocation, forForm) {
                                if (forForm == "heartrate" && formLocation == "modal") {
                                    // submit heartrate activity tracker form via jquery ajax trigger
                                    document.getElementById("modal-submit-heartrate-insights-activitytracker-data-form").click();
                                } else if (forForm == "bodytemp" && formLocation == "modal") {
                                    // submit bodytemp activity tracker form via jquery ajax trigger
                                    document.getElementById("modal-submit-bodytemp-insights-activitytracker-data-form").click();
                                } else if (forForm == "speed" && formLocation == "modal") {
                                    // submit speed activity tracker form via jquery ajax trigger
                                    document.getElementById("modal-submit-speed-insights-activitytracker-data-form").click();
                                } else if (forForm == "weight" && formLocation == "modal") {
                                    // submit weight activity tracker form via jquery ajax trigger
                                    document.getElementById("modal-submit-weight-insights-activitytracker-data-form").click();
                                } else {
                                    alert("Alert: Activity Tracker form submitted - formLocation: " + formLocation + " | forForm: " + forForm);
                                }

                                if (forForm == "heartrate" && formLocation == "single") {
                                    // submit heartrate activity tracker form via jquery ajax trigger
                                    document.getElementById("single-submit-heartrate-insights-activitytracker-data-form").click();
                                } else if (forForm == "bodytemp" && formLocation == "single") {
                                    // submit bodytemp activity tracker form via jquery ajax trigger
                                    document.getElementById("single-submit-bodytemp-insights-activitytracker-data-form").click();
                                } else if (forForm == "speed" && formLocation == "single") {
                                    // submit speed activity tracker form via jquery ajax trigger
                                    document.getElementById("single-submit-speed-insights-activitytracker-data-form").click();
                                } else if (forForm == "weight" && formLocation == "single") {
                                    // submit weight activity tracker form via jquery ajax trigger
                                    document.getElementById("single-submit-weight-insights-activitytracker-data-form").click();
                                } else {
                                    alert("Alert: Activity Tracker form submitted - formLocation: " + formLocation + " | forForm: " + forForm);
                                }
                            }
                        </script>
                        <!-- ./ js submitting activity tracker data foms -->

                        <li class="list-group-item bg-transparent text-white pt-4" style="border-color: #ffa500;border-radius: 25px;">
                            <div class="row align-items-center mt-4">
                                <div class="col-xlg -4 text-center">
                                    <h1 class="text-truncate">Heart Rate Monitor</h1>
                                    <div class="d-grid gap-2 mt-4">
                                        <span class="material-icons material-icons-round">
                                            favorite
                                        </span>
                                        <h1>65<span style="font-size: 10px;" class="align-top">BPM</span></h1>
                                        <p class="text-muted fw-bold">75 BPM, 5h ago</p>
                                    </div>

                                    <!-- <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="heartrate-expand-icon heartrate-data-input-form-container">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button> -->
                                </div>
                                <div class="col-xlg -8 py-4 d-flex justify-content-center">
                                    <!-- Canvasjs chart canvas -->
                                    <!-- <canvas class="chartjs-chart-light shadow" id="heart_rate_monitor_chart" width="400" height="400"></canvas> -->
                                    <!-- ./Canvasjs chart canvas -->

                                    <!-- submit heartrate data form -->
                                    <div id="heartrate-expand-icon" class="collapsez showz multi-collapsez text-center w3-animate-bottom my-4">
                                        <span class="material-icons material-icons-round">
                                            add_task
                                        </span>
                                    </div>

                                    <div id="heartrate-data-input-form-container" class="d-grid justify-content-center p-4 mb-4 w3-animate-bottom border-5 border-start border-end" style="border-color: #ffa500 !important; border-radius: 25px;">
                                        <div class="align-middle comfortaa-font text-center">
                                            <span class="material-icons material-icons-round align-middle">today</span>

                                            <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                        </div>

                                        <hr class="text-white">

                                        <form id="modal-heartrate-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_heartrate.php" autocomplete="off">
                                            <div class="output-container my-2" id="output-container">
                                                <!--<?php echo $output; ?>-->
                                            </div>

                                            <div class="form-group my-4">
                                                <label for="heartrate-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                <select class="custom-select form-control-select-input p-4" name="heartrate-workout" id="heartrate-workout" placeholder="Work / Activity (Required)" required>
                                                    <option value='no-selection'>Select a workout / activity.</option>
                                                    <?php echo $workout_activities_list; ?>
                                                    <option value='other'>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="heartrate-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Heart Rate Datasource:</label>
                                                <select class="custom-select form-control-select-input p-4" name="heartrate-datasource" id="heartrate-datasource" placeholder="Datasource (Required)" required>
                                                    <option value='no-selection'>Select your datasource.</option>
                                                    <option value='datasource-1'>Fitbit waerable</option>
                                                    <option value='datasource-2'>Android wearable</option>
                                                    <option value='datasource-3'>Apple wearable</option>
                                                    <option value='datasource-4'>Treadmill</option>
                                                    <option value='datasource-5'>Electric Spin bike</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="heartrate-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your Heart Rate:</label>
                                                <input class="form-control-text-input p-4" type="number" name="heartrate-value" id="heartrate-value" placeholder="BPM" required />
                                            </div>

                                            <!-- submit btn -->
                                            <input id="modal-submit-heartrate-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                        </form>
                                        <!-- visual submit btn - heartrate form -->
                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-heartrate-btn" type="button" onclick="triggerSubmitActivityTrackerData('modal','heartrate')">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                            <span class="align-middle">Save.</span>
                                        </button>
                                        <!-- ./ visual submit btn - heartrate form -->
                                    </div>
                                    <!-- ./ submit heartrate data form -->

                                    <!-- <div id="heart_rate_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent text-white pt-4" style="border-color: #ffa500;border-radius: 25px;">
                            <div class="row align-items-center mt-4">
                                <div class="col-xlg -4 text-center">
                                    <h1 class="text-truncate">Body Temp Monitor</h1>
                                    <div class="d-grid gap-2 mt-4">
                                        <span class="material-icons material-icons-round">
                                            device_thermostat
                                        </span>
                                        <h1>36.9<span style="font-size: 10px;" class="align-top">&deg;C</span></h1>
                                        <p class="text-muted fw-bold">37.2&deg;C, 10m ago</p>
                                    </div>

                                    <!-- <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#bodytemp-data-input-form-container" aria-expanded="false" aria-controls="bodytemp-data-input-form-container">
                                        <span class="material-icons material-icons-round align-middle">
                                            add_circle_outline
                                        </span>
                                    </button> -->
                                </div>
                                <div class="col-xlg -8 py-4 d-flex justify-content-center">
                                    <!-- Canvasjs chart canvas -->
                                    <!-- <canvas class="chartjs-chart-light shadow" id="body_temp_monitor_chart" width="400" height="400"></canvas> -->
                                    <!-- ./Canvasjs chart canvas -->

                                    <!-- submit heartrate data form -->
                                    <div id="bodytemp-expand-icon" class="collapsez showz multi-collapsez text-center w3-animate-bottom my-4">
                                        <span class="material-icons material-icons-round">
                                            add_task
                                        </span>
                                    </div>

                                    <div id="bodytemp-data-input-form-container" class="d-grid justify-content-center p-4 mb-4 w3-animate-bottom border-5 border-start border-end" style="border-color: #ffa500 !important; border-radius: 25px;">
                                        <div class="align-middle comfortaa-font text-center">
                                            <span class="material-icons material-icons-round align-middle">today</span>

                                            <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                        </div>

                                        <hr class="text-white">

                                        <form id="modal-bodytemp-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bodytemp.php" autocomplete="off">
                                            <div class="output-container my-2" id="output-container">
                                                <!--<?php echo $output; ?>-->
                                            </div>

                                            <div class="form-group my-4">
                                                <label for="bodytemp-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                <select class="custom-select form-control-select-input p-4" name="bodytemp-workout" id="bodytemp-workout" placeholder="Work / Activity (Required)" required>
                                                    <option value='no-selection'>Select a workout / activity.</option>
                                                    <?php echo $workout_activities_list; ?>
                                                    <option value='other'>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="bodytemp-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Body Temp Monitoring Datasource:</label>
                                                <select class="custom-select form-control-select-input p-4" name="bodytemp-datasource" id="bodytemp-datasource" placeholder="Datasource (Required)" required>
                                                    <option value='no-selection'>Select your datasource.</option>
                                                    <option value='datasource-1'>Fitbit waerable</option>
                                                    <option value='datasource-2'>Android wearable</option>
                                                    <option value='datasource-3'>Apple wearable</option>
                                                    <option value='datasource-4'>Treadmill</option>
                                                    <option value='datasource-5'>Electric Spin bike</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="bodytemp-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your Body Temp:</label>
                                                <input class="form-control-text-input p-4" type="number" name="bodytemp-value" id="bodytemp-value" placeholder="Temperature (&deg;C)" required />
                                            </div>

                                            <!-- submit btn -->
                                            <input id="modal-submit-bodytemp-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                        </form>
                                        <!-- visual submit btn - bodytemp form -->
                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-bodytemp-btn" type="button" onclick="triggerSubmitActivityTrackerData('modal','bodytemp')">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                            <span class="align-middle">Save.</span>
                                        </button>
                                        <!-- ./ visual submit btn - bodytemp form -->
                                    </div>

                                    <!-- <div id="body_temp_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent text-white pt-4" style="border-color: #ffa500;border-radius: 25px;">
                            <div class="row align-items-center mt-4">
                                <div class="col-xlg -4 text-center">
                                    <h1 class="text-truncate">Avg. Speed</h1>
                                    <div class="d-grid gap-2 mt-4">
                                        <span class="material-icons material-icons-round">
                                            bolt
                                        </span>
                                        <h1>10<span style="font-size: 10px;" class="align-top">m/s</span></h1>
                                        <p class="text-muted fw-bold">Highest Marked Speed: 15m/s</p>
                                    </div>

                                    <!-- <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#speedmonitor-data-input-form-container" aria-expanded="false" aria-controls="">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button> -->
                                </div>
                                <div class="col-xlg -8 py-4 d-flex justify-content-center">
                                    <!-- Canvasjs chart canvas -->
                                    <!-- <canvas class="chartjs-chart-light shadow" id="speed_monitor_chart" width="400" height="400"></canvas> -->
                                    <!-- ./Canvasjs chart canvas -->

                                    <!-- submit heartrate data form -->
                                    <div id="speedmonitor-expand-icon" class="collapsez showz multi-collapsez text-center w3-animate-bottom my-4">
                                        <span class="material-icons material-icons-round">
                                            add_task
                                        </span>
                                    </div>

                                    <div id="speedmonitor-data-input-form-container" class="d-grid justify-content-center p-4 mb-4 w3-animate-bottom border-5 border-start border-end" style="border-color: #ffa500 !important; border-radius: 25px;">
                                        <div class="align-middle comfortaa-font text-center">
                                            <span class="material-icons material-icons-round align-middle">today</span>

                                            <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                        </div>

                                        <hr class="text-white">

                                        <form id="modal-speed-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_speed.php" autocomplete="off">
                                            <div class="output-container my-2" id="output-container">
                                                <!--<?php echo $output; ?>-->
                                            </div>

                                            <div class="form-group my-4">
                                                <label for="speed-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                <select class="custom-select form-control-select-input p-4" name="speed-workout" id="speed-workout" placeholder="Work / Activity (Required)" required>
                                                    <option value='no-selection'>Select a workout / activity.</option>
                                                    <?php echo $workout_activities_list; ?>
                                                    <option value='other'>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="speed-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Speed Mearsuring Datasource:</label>
                                                <select class="custom-select form-control-select-input p-4" name="speed-datasource" id="speed-datasource" placeholder="Datasource (Required)" required>
                                                    <option value='no-selection'>Select your datasource.</option>
                                                    <option value='datasource-1'>Fitbit waerable</option>
                                                    <option value='datasource-2'>Android wearable</option>
                                                    <option value='datasource-3'>Apple wearable</option>
                                                    <option value='datasource-4'>Treadmill</option>
                                                    <option value='datasource-5'>Electric Spin bike</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="speed-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your max Speed:</label>
                                                <input class="form-control-text-input p-4" type="number" name="speed-value" id="speed-value" placeholder="Speed (ms)" required />
                                            </div>

                                            <!-- submit btn -->
                                            <input id="modal-submit-speed-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                        </form>
                                        <!-- visual submit btn - speed form -->
                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-speed-btn" type="button" onclick="triggerSubmitActivityTrackerData('modal','speed')">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                            <span class="align-middle">Save.</span>
                                        </button>
                                        <!-- ./ visual submit btn - speed form -->
                                    </div>

                                    <!-- <div id="speed_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent text-white pt-4" style="border-color: #ffa500;border-radius: 25px;">
                            <div class="row align-items-center mt-4">
                                <div class="col-md -4 text-center">
                                    <h1 class="text-truncate">Step Counter</h1>
                                    <div class="d-grid gap-2 my-4">
                                        <span class="material-icons material-icons-round">
                                            directions_walk
                                        </span>
                                        <h1>1896<span style="font-size: 10px;" class="align-top">Steps</span></h1>
                                        <p class="text-muted fw-bold">213 Steps remaining (Achievement)</p>
                                    </div>

                                </div>
                                <div class="col-md -8 py-4 text-center d-flex justify-content-center">
                                    <!-- Canvasjs chart canvas -->
                                    <!-- <canvas class="chartjs-chart-light shadow" id="step_counter_monitor_chart" width="400" height="400"></canvas> -->
                                    <!-- ./Canvasjs chart canvas -->

                                    <img src="../media/assets/smartwatches/branding/fitbit-png-logo-white.png" class="img-fluid mt-4 mb-2" style="max-width: 200px;" alt="fitbit logo">
                                    <p class="comfortaa-font">Connect your Fitbit activity tracker / smartwatch</p>

                                    <!-- <div id="step_counter_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent text-white pt-4" style="border-color: #ffa500;border-radius: 25px;">
                            <div class="row align-items-center mt-4">
                                <div class="col-xlg -4 text-center">
                                    <h1 class="text-truncate">Weight Monitoring (BMI)</h1>
                                    <div class="d-grid gap-2 mt-4">
                                        <span class="material-icons material-icons-round">
                                            monitor_weight
                                        </span>
                                        <h1>60<span style="font-size: 10px;" class="align-top">kg</span></h1>
                                        <p class="text-muted fw-bold">75kg, 1w ago</p>
                                    </div>

                                    <!-- <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="bmiweight-expand-icon bmiweight-data-input-form-container">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button> -->
                                </div>
                                <div class="col-xlg -8 py-4 d-flex justify-content-center">
                                    <!-- Canvasjs chart canvas -->
                                    <!-- <canvas class="chartjs-chart-light shadow" id="bmi_weight_monitor_chart" width="400" height="400"></canvas> -->
                                    <!-- ./Canvasjs chart canvas -->

                                    <!-- submit heartrate data form -->
                                    <div id="bmiweight-expand-icon" class="collapsez showz multi-collapsez text-center w3-animate-bottom my-4">
                                        <span class="material-icons material-icons-round">
                                            add_task
                                        </span>
                                    </div>

                                    <div id="bmiweight-data-input-form-container" class="d-grid justify-content-center p-4 mb-4 w3-animate-bottom border-5 border-start border-end" style="border-color: #ffa500 !important; border-radius: 25px;">
                                        <div class="align-middle comfortaa-font text-center">
                                            <span class="material-icons material-icons-round align-middle">today</span>

                                            <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                        </div>

                                        <hr class="text-white">

                                        <form id="modal-weight-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bmiweight.php" autocomplete="off">
                                            <div class="output-container my-2" id="output-container">
                                                <!--<?php echo $output; ?>-->
                                            </div>

                                            <div class="form-group my-4">
                                                <label for="weight-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                <select class="custom-select form-control-select-input p-4" name="weight-workout" id="weight-workout" placeholder="Work / Activity (Required)" required>
                                                    <option value='no-selection'>Select a workout / activity.</option>
                                                    <?php echo $workout_activities_list; ?>
                                                    <option value='other'>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="weight-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Weight Monitoring Datasource:</label>
                                                <select class="custom-select form-control-select-input p-4" name="weight-datasource" id="weight-datasource" placeholder="Datasource (Required)" required>
                                                    <option value='no-selection'>Select your datasource.</option>
                                                    <option value='datasource-1'>Fitbit waerable</option>
                                                    <option value='datasource-2'>Android wearable</option>
                                                    <option value='datasource-3'>Apple wearable</option>
                                                    <option value='datasource-4'>Treadmill</option>
                                                    <option value='datasource-5'>Electric Spin bike</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="weight-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your current Weight:</label>
                                                <input class="form-control-text-input p-4" type="number" name="weight-value" id="weight-value" placeholder="Weight (kg)" required />
                                            </div>

                                            <!-- submit btn -->
                                            <input id="modal-submit-weight-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                        </form>
                                        <!-- visual submit btn - bmiweight form -->
                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-weight-btn" type="button" onclick="triggerSubmitActivityTrackerData('modal','weight')">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                            <span class="align-middle">Save.</span>
                                        </button>
                                        <!-- ./ visual submit btn - bmiweight form -->
                                    </div>

                                    <!-- <div id="weight_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- ./ detailed metric list -->

                </div>
            </div>
        </div>
    </div>
    <!-- ./ >>>>>>>>>> Tab Activity Tracker Capture Modal -->

    <!-- Button trigger modal>>>>>>>>>> Tab Edit weekly training schedule for Teams Modal -->
    <button id="toggleTabeditWeeklyTeamsTrainingScheduleModalBtn" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tabeditWeeklyTeamsTrainingScheduleModal" hidden aria-hidden="true">
        Launch #editWeeklyTeamsTrainingSchedule</button>

    <!-- >>>>>>>>>> Tab Edit weekly training schedule for Teams Modal -->
    <div class="modal fade" id="tabeditWeeklyTeamsTrainingScheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tabeditWeeklyTeamsTrainingScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content feature-tab-nav-content content-panel-border-stylez">
                <!-- style="border-bottom: #ffa500 5px solid;" -->
                <div class="modal-header border-0">
                    <h5 class="modal-title align-middle" id="tabeditWeeklyTeamsTrainingScheduleModalLabel">
                        <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">
                            edit_calendar
                        </span>
                        <span id="tabeditWeeklyTeamsTrainingScheduleModalLabelText" class="align-middle">Edit weekly training schedule</span>
                    </h5>
                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>
                <hr class="text-white m-0z">
                <div id="tabEditWeeklyTeamsTrainingScheduleModal_body" class="modal-body border-0" style="overflow-x: hidden">


                </div>
            </div>
        </div>
    </div>
    <!-- ./ >>>>>>>>>> Tab Edit weekly training schedule for Teams Modal -->


    <!-- ./ Modals ----------------------------------------------------------------------------------------- -->

    <script>
        // initialize global activity tracker chart objects
        // initialize activity tracking charts
        // Note: changes to the plugin code is not reflected to the chart, because the plugin is loaded at chart construction time and editor changes only trigger an chart.update().
        const plugin = {
            id: 'custom_canvas_background_color',
            beforeDraw: (chart) => {
                const {
                    ctx
                } = chart;
                ctx.save();
                ctx.globalCompositeOperation = 'destination-over';
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, chart.width, chart.height);
                ctx.restore();
            }
        };


        // draw chart
        // assign default chart data - Heart Rate
        const heartrateChartLabels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ];

        const heartrateChartData = {
            labels: heartrateChartLabels,
            datasets: [{
                label: 'Initial Data',
                backgroundColor: 'rgb(231, 136, 4)',
                borderColor: 'rgb(231, 136, 4)',
                data: [0, 10, 5, 2, 20, 30, 45],
                borderWidth: 5
            }]
        };

        const heartrateChartConfig = {
            type: 'line',
            data: heartrateChartData,
            options: {
                layout: {
                    padding: 40
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: true,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    },
                    position: 'bottom',
                }
            },
            plugins: [plugin]
        };

        const heartrateChart = new Chart(
            document.getElementById('heart_rate_monitor_chart'),
            heartrateChartConfig
        );

        // draw chart
        // assign default chart data - Body Temp
        const bodyTempChartLabels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ];

        const bodyTempChartData = {
            labels: bodyTempChartLabels,
            datasets: [{
                label: 'Initial Data',
                backgroundColor: 'rgb(231, 136, 4)',
                borderColor: 'rgb(231, 136, 4)',
                data: [0, 10, 5, 2, 20, 30, 45],
                borderWidth: 5
            }]
        };

        const bodyTempChartConfig = {
            type: 'line',
            data: bodyTempChartData,
            options: {
                layout: {
                    padding: 40
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: true,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    },
                    position: 'bottom',
                }
            },
            plugins: [plugin]
        };

        const bodytempChart = new Chart(
            document.getElementById('body_temp_monitor_chart'),
            bodyTempChartConfig
        );

        // draw chart
        // assign default chart data - Speed
        const speedChartLabels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ];

        const speedChartData = {
            labels: speedChartLabels,
            datasets: [{
                label: 'Initial Data',
                backgroundColor: 'rgb(231, 136, 4)',
                borderColor: 'rgb(231, 136, 4)',
                data: [0, 10, 5, 2, 20, 30, 45],
                borderWidth: 5
            }]
        };

        const speedChartConfig = {
            type: 'line',
            data: speedChartData,
            options: {
                layout: {
                    padding: 40
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: true,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    },
                    position: 'bottom',
                }
            },
            plugins: [plugin]
        };

        const speedChart = new Chart(
            document.getElementById('speed_monitor_chart'),
            speedChartConfig
        );

        // step count
        // assign default chart data - Step Count
        const stepCountChartLabels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ];

        const stepCountChartData = {
            labels: stepCountChartLabels,
            datasets: [{
                label: 'Initial Data',
                backgroundColor: 'rgb(231, 136, 4)',
                borderColor: 'rgb(231, 136, 4)',
                data: [0, 10, 5, 2, 20, 30, 45],
                borderWidth: 5
            }]
        };

        const stepCountChartConfig = {
            type: 'line',
            data: stepCountChartData,
            options: {
                layout: {
                    padding: 40
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: true,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    },
                    position: 'bottom',
                }
            },
            plugins: [plugin]
        };

        const stepcountChart = new Chart(
            document.getElementById('step_counter_monitor_chart'),
            stepCountChartConfig
        );

        // draw chart
        // assign default chart data - BMI Weight
        const bmiWeightChartLabels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
        ];

        const bmiWeightChartData = {
            labels: bmiWeightChartLabels,
            datasets: [{
                label: 'Initial Data',
                backgroundColor: 'rgb(231, 136, 4)',
                borderColor: 'rgb(231, 136, 4)',
                data: [0, 10, 5, 2, 20, 30, 45],
                borderWidth: 5
            }]
        };

        const bmiWeightChartConfig = {
            type: 'line',
            data: bmiWeightChartData,
            options: {
                layout: {
                    padding: 40
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: true,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    },
                    position: 'bottom',
                }
            },
            plugins: [plugin]
        };

        const weightbmiChart = new Chart(
            document.getElementById('bmi_weight_monitor_chart'),
            bmiWeightChartConfig
        );

        function initializeContent(auth, usernm) {
            if (auth = true) {
                //call all client functions
                //alert("auth = true | User: " + usernm);
                loadActivityCalender();
                getCurrentWeekStartEndDates();

                // loadUserProfile();
                // loadUserSocials();
                // loadUserChallenges();
                // loadUserChat();
                // loadUserFriends();
                // loadUserGroups();
                // loadUserMedia();
                // loadUserNotifications();
                // loadUserPref();
                // loadUserSaves();
                // loadUserGroups();
                // loadCommunityUpdates()
                // loadCommunityGroups();
                // loadCommunityNews();
                // loadCommunityAchievements();
                // loadCommunityEvents();
                // loadCommunityMedia();
                // loadCommunityResources();
                // loadCommunityRewards();
            } else {
                //call guest applicable functions
                alert("auth = false | User: " + usernm);
                // loadCommunityUpdates()
                // loadCommunityGroups();
                // loadCommunityNews();
                // loadCommunityAchievements();
                // loadCommunityEvents();
                // loadCommunityMedia();
                // loadCommunityResources();
                // loadCommunityRewards();
            }

            // check if current_app_tab is set and has a value in localStorage, else set default value: TabHome
            const currentAppTab = localStorage.getItem('current_app_tab');

            if (currentAppTab) {
                var tabName = currentAppTab;
                console.log('Current App Tab: ' + currentAppTab);
                // display the current app tab app-dashboard-btn
                if (tabName == "TabHome") {
                    document.getElementById("app-dashboard-btn").click();
                } else if (tabName == "TabProfile") {
                    document.getElementById("app-profile-btn").click();
                } else if (tabName == "TabDiscovery") {
                    document.getElementById("app-discovery-btn").click();
                } else if (tabName == "TabStudio") {
                    document.getElementById("app-studio-btn").click();
                } else if (tabName == "TabStore") {
                    document.getElementById("app-stor-btn").click();
                } else if (tabName == "TabSocial") {
                    document.getElementById("app-social-btn").click();
                } else if (tabName == "TabData") {
                    document.getElementById("app-insights-btn").click();
                } else if (tabName == "TabAchievements") {
                    document.getElementById("app-achievements-btn").click();
                } else if (tabName == "TabMedia") {
                    document.getElementById("app-media-btn").click();
                } else if (tabName == "TabCommunication") {
                    document.getElementById("app-comms-btn").click();
                } else if (tabName == "TabSettings") {
                    document.getElementById("app-preferences-btn").click();
                }

            } else {
                console.log('Current App Tab not set.');
                // set default value: TabHome
                localStorage.setItem("current_app_tab", "TabHome");
            }

            // hide the loading curtain
            var curtain = document.getElementById("LoadCurtain");
            curtain.style.display = "none";

            // load the weekly activiies bar chart under Teams athletics training (insights tab)
            $.populateWeeklyActivityBarChart();

            // call the function to update the users activity tracker charts from the db - use vanillajs ajax to compile the data
            compileUserActivityTrackerCharts(usernm);

        }

        function compileUserActivityTrackerCharts(usernm) {

            var forChartNameArray = ['heart_rate_monitor_chart', 'body_temp_monitor_chart', 'speed_monitor_chart', 'step_counter_monitor_chart', 'bmi_weight_monitor_chart'];

            forChartNameArray.forEach(chartName => {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var output = this.responseText;

                        if (output.startsWith("error")) {
                            // provide user with error message
                            alert("An error has occured: \n" + output);
                            console.log("An error has occured: \n" + output);
                        } else {
                            // parse outpyt to js json format
                            let chartData = JSON.parse(output);

                            // output the returned data
                            switch (chartName) {
                                case "heart_rate_monitor_chart":
                                    console.log(chartData);
                                    localStorage.setItem('heart_rate_monitor_chart_data', JSON.stringify(chartData));
                                    break;
                                case "body_temp_monitor_chart":
                                    console.log(chartData);
                                    localStorage.setItem('body_temp_monitor_chart_data', JSON.stringify(chartData));
                                    break;
                                case "speed_monitor_chart":
                                    console.log(chartData);
                                    localStorage.setItem('speed_monitor_chart_data', JSON.stringify(chartData));
                                    break;
                                case "step_counter_monitor_chart":
                                    console.log(chartData);
                                    localStorage.setItem('step_counter_monitor_chart_data', JSON.stringify(chartData));
                                    break;
                                case "bmi_weight_monitor_chart":
                                    console.log(chartData);
                                    localStorage.setItem('bmi_weight_monitor_chart_data', JSON.stringify(chartData));
                                    break;
                                default:
                                    break;
                            }
                        }

                    }
                };
                xhttp.open("GET", "../scripts/php/main_app/data_management/activity_tracker_stats_admin/compile/compile_user_stats_activity_tracker.php?forchart=" + chartName + "&u=" + usernm, true);
                xhttp.send();
            });

        }

        function refreshUserActivityTrackerChart(usernm, chartName) {

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;

                    if (output.startsWith("error")) {
                        // provide user with error message
                        // alert(output);
                        console.log("An error has occured: \n" + output);
                    } else {
                        let chartData = JSON.parse(output);
                        console.log(chartData);

                        let date = chartData.map(
                            function(index) {
                                return index.date;
                            }
                        )

                        console.log(date);

                        let time = chartData.map(
                            function(index) {
                                return index.time;
                            }
                        )

                        console.log(time);

                        // output the returned data
                        switch (chartName) {
                            case "heart_rate_monitor_chart":
                                // let chartData = JSON.parse(output);

                                let bpm = chartData.map(
                                    function(index) {
                                        return index.bpm;
                                    }
                                )

                                console.log(bpm);

                                // Uncaught TypeError: Cannot read properties of undefined (reading 'data') at xhttp.onreadystatechange (?userauth=true:8609:69)
                                heartrateChart.heartrateChartConfig.heartrateChartdata.heartrateChartLabels = time;
                                heartrateChart.heartrateChartConfig.heartrateChartdata.datasets[0].label = "Heart rate - BPM";
                                heartrateChart.heartrateChartConfig.heartrateChartdata.datasets[0].data = bpm;
                                heartrateChart.update();
                                break;
                            case "body_temp_monitor_chart":

                                let temperature = chartData.map(
                                    function(index) {
                                        return index.temperature;
                                    }
                                )

                                console.log(temperature);

                                // Uncaught ReferenceError: bodyTempChart is not defined at xhttp.onreadystatechange (?userauth=true:8624:33)
                                bodyTempChart.bodyTempChartConfig.bodyTempChartData.bodyTempChartLabels = time;
                                bodyTempChart.bodyTempChartConfig.bodyTempChartData.datasets[0].label = "Body Temperature - &deg; C";
                                bodyTempChart.bodyTempChartConfig.bodyTempChartData.datasets[0].data = temperature;
                                bodyTempChart.update();
                                break;
                            case "speed_monitor_chart":

                                let speed = chartData.map(
                                    function(index) {
                                        return index.speed;
                                    }
                                )

                                console.log(speed);

                                speedChart.speedChartConfig.speedChartData.speedChartLabels = time;
                                speedChart.speedChartConfig.speedChartData.datasets[0].label = "Speed - ms";
                                speedChart.speedChartConfig.speedChartData.datasets[0].data = speed;
                                speedChart.update();
                                break;
                            case "step_counter_monitor_chart":

                                let steps = chartData.map(
                                    function(index) {
                                        return index.steps;
                                    }
                                )

                                console.log(steps);

                                stepCountChart.stepCountChartConfig.stepCountChartData.stepCountChartLabels = time;
                                stepCountChart.stepCountChartConfig.stepCountChartData.datasets[0].label = "Step counter";
                                stepCountChart.stepCountChartConfig.stepCountChartData.datasets[0].data = steps;
                                stepCountChart.update();
                                break;
                            case "bmi_weight_monitor_chart":

                                let bmi = chartData.map(
                                    function(index) {
                                        return index.bmi;
                                    }
                                )

                                console.log(bmi);

                                let weight = chartData.map(
                                    function(index) {
                                        return index.weight;
                                    }
                                )

                                console.log(weight);

                                bmiWeightChart.bmiWeightChartConfig.bmiWeightChartData.bmiWeightChartLabels = time;
                                bmiWeightChart.bmiWeightChartConfig.bmiWeightChartData.datasets[0].label = "Weight - BMI";
                                bmiWeightChart.bmiWeightChartConfig.bmiWeightChartData.datasets[0].data = bmi;
                                bmiWeightChart.update();
                                break;

                            default:
                                alert("Activity Tracker Chart Update Error \nNo chart passed to function.");
                                console.log("Activity Tracker Chart Update Error \nNo chart passed to function.");
                                break;
                        }
                    }

                }
            };
            xhttp.open("GET", "../scripts/php/main_app/data_management/activity_tracker_stats_admin/compile/compile_user_stats_activity_tracker.php?forchart=" + chartName + "&u=" + usernm, true);
            xhttp.send();
        }

        function setCurrentAppTabID(currentPageID) {
            // get the currently active app page
            // var appTabsNode = document.querySelector(".app-tab");
            // alert("appTabsNode.length: " + appTabsNode.length);
            // for (let i = 0; i < appTabsNode.length; i++) {
            //     currentPageID = appTabsNode[i].id;
            // }

            localStorage.setItem("current_app_tab", currentPageID);
        }

        function toggleMapSelection(selection) {
            alert("Muscle Selected: " + selection);
        }

        function toggleRecoverySelection(period, option) {
            alert("Period: " + period + " | Option Selected: " + option);
        }

        function musePlayerController(playerAction) {
            alert("Muse Player Action: " + playerAction);
        }

        function launchLink(link) {
            window.location.href = link;
        }

        Date.prototype.getWeek = function(start) {
            //Calcing the starting point
            start = start || 0;
            var today = new Date(this.setHours(0, 0, 0, 0));
            var day = today.getDay() - start;
            var date = today.getDate() - day;

            // Grabbing Start/End Dates
            var StartDate = new Date(today.setDate(date));
            var EndDate = new Date(today.setDate(date + 6));
            return [StartDate, EndDate];
        }



        function openLink(evt, tabName) {
            var i, x, tabContainer, tablinks;
            var tabBtnIco = document.getElementById("display-current-tab-button-icon");
            var tabBtnTxt = document.getElementById("display-current-tab-button-text");


            //Change the #display-current-tab-button icon and text
            if (tabName == "TabHome") {
                tabBtnTxt.innerHTML = "Dashboard";
                tabBtnIco.innerHTML = " dashboard ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabProfile") {
                tabBtnTxt.innerHTML = "Profile";
                tabBtnIco.innerHTML = " account_circle ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabDiscovery") {
                tabBtnTxt.innerHTML = "Discovery";
                tabBtnIco.innerHTML = " travel_explore ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabStudio") {
                tabBtnTxt.innerHTML = ".Studio";
                tabBtnIco.innerHTML = " play_circle_outline ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabStore") {
                tabBtnTxt.innerHTML = ".Store";
                tabBtnIco.innerHTML = " storefront ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabSocial") {
                tabBtnTxt.innerHTML = ".Social";
                tabBtnIco.innerHTML = " hub ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabData") {
                tabBtnTxt.innerHTML = "Insights";
                tabBtnIco.innerHTML = " insights ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabAchievements") {
                tabBtnTxt.innerHTML = "Achievements";
                tabBtnIco.innerHTML = " emoji_events ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabMedia") {
                tabBtnTxt.innerHTML = "Media";
                tabBtnIco.innerHTML = " perm_media ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabCommunication") {
                tabBtnTxt.innerHTML = "Communication";
                tabBtnIco.innerHTML = " forum ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabSettings") {
                tabBtnTxt.innerHTML = "Preferences";
                tabBtnIco.innerHTML = " settings_accessibility ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "InsightsTabGCS") {
                /* Insigts sub features app tabs */
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-googlesurveys-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "block";
                document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";
            } else if (tabName == "InsightsTabIAT") {
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-indiathlete-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                document.getElementById("horizontal-rule-icon-indiathlete").style.display = "block";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";
            } else if (tabName == "InsightsTabCTA") {
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-teamathletics-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "block";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";
            } else if (tabName == "InsightsTabChallenges") {
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-challenges-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "block";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";
            } else if (tabName == "InsightsTabWellness") {
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-challenges-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "block";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";
            } else if (tabName == "InsightsTabNutrition") {
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-challenges-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "block";
            }

            // InsightsTabGCS
            // InsightsTabIAT
            // InsightsTabCTA
            // InsightsTabChallenges
            // v-sub-tab-pills-insights-googlesurveys-tab
            // v-sub-tab-pills-insights-indiathlete-tab
            // v-sub-tab-pills-insights-teamathletics-tab
            // v-sub-tab-pills-insights-challenges-tab

            //x = document.getElementsByClassName("content-tab");
            x = tabContainer;

            if (x) {
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                document.getElementById(tabName).style.display = "block";

                // set current App Tab ID
                setCurrentAppTabID(tabName);
            }
        }

        function loadActivityCalender(monthName) {
            //load the activities calender
            //?month='.$prev_month.'&year='.$prev_year."'
            //get current month

            var dateNow = new Date();
            var currMonth = dateNow.getMonth() + 1;
            var currYear = dateNow.getFullYear();

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;

                    if (output.startsWith("|[System Error]|")) {
                        messengerLoader.style.display = "none";
                        //alert(output);

                        convoContainer.innerHTML = `
                        <div class="application-error-msg shadow d-grid gap-2 d-block" id="application-error-msg">
                        <h3 class=" d-block" style="color: red">An error has occured</h3>
                        <p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('` + userParam + `','` + output + `')">support</a></p>
                        <div class="application-error-msg-output d-block" style="font-size: 10px">` + output + `</div>
                        </div>
                        `;

                        var applicationErrMsg = document.getElementById('application-error-msg');

                        applicationErrMsg.addEventListener('click', function() {
                            applicationErrMsg.style.display = "none";
                        });
                    } else {
                        //alert(output);
                        document.getElementById('activities-calender').innerHTML = output;
                    }
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/calender.php?month=" + currMonth + "&year=" + currYear, true);
            xhttp.send();
        }

        function reloadActivityCalender(nMonth, nYear) {
            //reload the activities calender
            var dateNow = new Date();
            //nMonth = dateNow.getMonth() + 1;
            //nYear = dateNow.getFullYear();

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;

                    if (output.startsWith("|[System Error]|")) {
                        // Output error
                        alert(output);
                    } else {
                        //alert(output);
                        document.getElementById('activities-calender').innerHTML = output;
                    }
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/calender.php?month=" + nMonth + "&year=" + nYear, true);
            xhttp.send();
        }

        function navCalender(nMonth, nYear, cmd) {
            //executes on button next or prev btn click
            //alert("clicked: "+cmd+" | Month: "+nMonth+" | Year: "+nYear);

            reloadActivityCalender(nMonth, nYear);
        }

        // Make the DIV element draggable:
        dragElement(document.getElementById("drag-player-pin"));

        function dragElement(elmnt) {
            var pos1 = 0,
                pos2 = 0,
                pos3 = 0,
                pos4 = 0;
            if (document.getElementById(elmnt.id + "header")) {
                // if present, the header is where you move the DIV from:
                document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
            } else {
                // otherwise, move the DIV from anywhere inside the DIV:
                elmnt.onmousedown = dragMouseDown;
            }

            function dragMouseDown(e) {
                e = e || window.event;
                e.preventDefault();
                // get the mouse cursor position at startup:
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                // call a function whenever the cursor moves:
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                e = e || window.event;
                e.preventDefault();
                // calculate the new cursor position:
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // set the element's new position:
                elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
            }

            function closeDragElement() {
                // stop moving when mouse button is released:
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }
    </script>

    <script src="../scripts/js/digital-clock.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>