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

// user profile demographic details
$usr_userid = $usrprof_username = $usrprof_name = $usrprof_surname = $usrprof_idnumber = $usrprof_email = $usrprof_contact = $usrprof_dob = $usrprof_gender = $usrprof_race = $usrprof_nationality = $usrprof_acc_active = $usr_profileid = $usr_about = $usr_profiletype = $usr_profilepicurl = $usr_verification = "";

// storing the other profile details
$socialItems = $profileUserSubsGroupsList = $profileUsersPostsList = $profileUsersResourcesList = $profileUsersProgramsList = $profileUserFriendsList = $profileUsersFavesList = $profileUserMediaList = $profileUserNotifications = $profileUserChats = $profileUserPref = $profileUserChallenges = $currentUserAccountProdImg = "";

// storing the community content
$outputCommunityGroups = $outputCommunityNews = $outputCommunityResources = $outputCommunityUpdates = "";

// storing the discovery content
$discoveryAllUsersList = $discoveryFitProgsIndi = $discoveryFitProgsTeams = $discoveryAllTrainees = $discoveryAllTrainers = "";

//getUserChats
$convo_conversationid = $convo_secondaryuser = $secondaryuser_name = $secondaryuser_surname = $communicationUserMessages = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getUserFriends
$friendid = $friendUsername = $friendName = $friendSurname = $profileUserFriendsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getUserGroups
$grps_groupid = $grps_refcode = $grps_name = $grps_description = $grps_category = $grps_privacy = $grps_createdby = $grps_createdate = $profileUserSubsGroupsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getUserMedia
$fileList = $profileUserMediaList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getUserNotifications
$notif_id = $notif_title = $notif_message = $notif_date = $communicationUserNotifications =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getUserPref

//getUserProgSubs
$programs_progid = $programs_refcode = $programs_title = $programs_description = $programs_duration = $programs_category = $programs_privacy = $programs_creator = $programs_active = $profileUsersProgramsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getUserResources
$usrresources_resourceid = $usrresources_title = $usrresources_description = $usrresources_type = $usrresources_link = $usrresources_sharedate = $usrresources_sharename = $usrresources_sharesurname = $profileUsersResourcesList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getUserSaves
$fave_id = $fave_ref = $fave_date = $post_id = $post_date = $post_msg = $mod_date = $poster_name = $poster_surname = $poster_username = $profileUsersFavesList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getUserSocials
$usr_socialnet = $usr_socialhandle = $usr_sociallink = $socialNetworkIcon = $socialItems = $userSocialItemsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getUserUpdates
$usrposts_postid = $usrposts_postdate = $usrposts_message = $usrposts_user = $usrposts_faveref  = $usrposts_name = $usrposts_surname = $profileUsersPostsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getCommunityGroups
$grps_groupid = $grps_refcode = $grps_name = $grps_description = $grps_category = $grps_privacy = $grps_createdby = $grps_createdate = $discoverGroupsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getCommunityNews
$news_id = $news_title = $news_content = $news_createdby = $news_date = $news_poster_name = $news_poster_surname = $communicationNews = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getCommunityResources
$resourceid = $resource_title = $resource_descr = $resource_type = $resource_link = $sharedbyUsername = $sharedate = $openlinkbtn = $outputCommunityResources = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

$commpost_postid = $commpost_postdate = $commpost_message = $commpost_user = $commpost_faveref = $commpost_usr_name = $commpost_usr_surname = $communityPosts = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getAllUsers
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $usrs_prof_acctype = $discoverPeopleList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getFitProgramsIndi
$indi_programs_progid = $indi_programs_refcode = $indi_programs_title = $indi_programs_description = $indi_programs_duration = $indi_programs_category = $indi_programs_privacy = $indi_programs_creator = $indi_programs_active = $discoverIndiProgramsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getFitProgramsTeams
$team_programs_progid = $team_programs_refcode = $team_programs_title = $team_programs_description = $team_programs_duration = $team_programs_category = $team_programs_privacy = $team_programs_creator = $team_programs_active = $discoverteamProgramsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getAllTrainees
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $activitiesTraineesList = $usrs_prof_acctype = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

//getAllTrainers
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $activitiesTrainersList = $usrs_prof_acctype = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

// misc
$currentuser_img_url = $otheruser_img_url = $verifIcon = $output_msg = $app_err_msg = $output = $uctDateTime = "";


if (isset($_SESSION["currentUserAuth"])) {
    if ($_SESSION["currentUserAuth"] == true) {
        $userAuth = sanitizeString($_SESSION["currentUserAuth"]);
        $currentUser_Usrnm = sanitizeString($_SESSION["currentUserUsername"]);

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

            $currentuser_img_url = "'../media/profiles/$currentUser_Usrnm/$usr_profilepicurl'";

            $currentUserAccountProdImg = '<div class="social-update-profile-pic shadow-sm" style="height: 200px !important; width:  200px !important; margin-top: -100px; background-color: url(' . $currentuser_img_url . ')"></div>';

            $currentUserAccountProdImg = '<div class="social-update-profile-pic shadow-sm" style="height: 200px !important; width:  200px !important; margin-top: -100px; background-color: url(' . $currentuser_img_url . ')"></div>';

            $outputSocialItems = getUserSocials();
            $outputProfileUserSubsGroupsList = getUserGroups();
            $outputProfileUsersPostsList = getUserUpdates();
            $outputProfileUsersResourcesList = getUserResources();
            $outputProfileUsersProgramsList = getUserProgSubs();
            $outputProfileUserFriendsList = getUserFriends();
            $outputProfileUsersFavesList = getUserSaves();
            $outputProfileUserMediaList = getUserMedia();
            $outputProfileUserNotifications = getUserNotifications();
            $outputProfileUserChats = getUserChats();
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
            $output_msg = "|[System Error]|:. [Profile load (Account details) - " . mysqli_error($dbconn) . "]";
            $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';

            $output = $app_err_msg;
        }
    } else {
        //destroy session,
        header("Location: ../scripts/php/destroy_session.php");
    }
} else {
    $uctDateTime->setTimezone(new DateTimeZone("UTC"));
    $currentUser_Usrnm = "Guest-" . generateRandomString(8) . "_" . $uctDateTime;
}

//Functions
//Content Load Functions - User Profile
function getUserChallenges()
{
    $output = "Loading...";

    return $output;
}
function getUserChats()
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
      <li class="list-group-item bg-transparent my-2" id="conversation-' . $convo_conversationid . '">
        <div class="row align-items-center content-panel-border-style" style="border-radius: 25px 0 25px 25px; overflow: hidden; background: #333">
          <div class="col-sm-4">
            <img src="../media/images/fitness/10.jpg" class="img-fluid" alt="" style="border-radius: 25px" />
          </div>
          <div class="col-sm py-2">
            <div class="">' . $secondaryuser_name . ' ' . $secondaryuser_surname . ' <span id="" class="msgr-username-tag">(@' . $convo_secondaryuser . ')</span></div>
          </div>
          <div class="col-sm-2 py-2 text-center">
            <button class="null-btn text-white shadow btn-block" onclick="openMessenger(' . "'" . $convo_conversationid . "'" . ', ' . "'" . $currentUser_Usrnm . "'" . ', ' . "'" . $convo_secondaryuser . "'" . ')" style="font-size: large"><i class="fas fa-chevron-right"></i></button>
          </div>
        </div>
      </li>';

            $output = $communicationUserMessages;
        }
    } else {
        $output_msg = "|[System Error]|:. [Communications load (User conversations list) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-block" id="application-error-msg"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserFriends()
{
    global $friendid, $friendUsername, $friendName, $friendSurname, $profileUserFriendsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //users friends list
    $sql = "SELECT * FROM friends f INNER JOIN users u ON f.friend_username = u.username WHERE f.username = '$currentUser_Usrnm' AND f.friendship_status = 1";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $friendid = $row["friend_username"];
            $friendUsername = $row["friend_username"];

            $friendName = $row["user_name"];
            $friendSurname = $row["user_surname"];

            $profileUserFriendsList .= '
      <!-- User Friends - dark Grad -->
  <div class="grid-tile">
    <div class="my-4 container-fluid tunnel-bg-container" id="friend-' . $friendid . '-' . $friendUsername . '"
      style="border-radius: 25px;">
      <div class="top-down-grad-light" style="border-radius: 25px;">
        <div
          class="row align-items-center content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaftz left-right-grad-mineshaft">
          <div class="col-xlg-2 text-center p-0">
            <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;"
              alt="prof thumbnail">
          </div>
          <div class="col-xlg-6 text-center p-0">
            <h3 class="text-white">' . $friendName . ' ' . $friendSurname . '</h3>
            <p style="font-size: 10px">@' . $friendUsername . '</p>
            <p style="font-size: 10px">Level.: 1</p>
            <span class="material-icons material-icons-round">public</span>
          </div>
          <div class="col-xlg-4 text-center p-0">
            <button class="onefit-buttons-style-light p-4 my-4 shadow" onclick="openProfiler(' . "'" . $friendUsername . "'" . ')>
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
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
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
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="group-' . $grps_groupid . '-' . $grps_refcode . '">
        <div class="row align-items-center">
          <div class="col-md -4 text-center">
            <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
          </div>
          <div class="col-md -8">
            <h3>' . $grps_name . ' <span style="font-size: 10px">' . $grps_privacy . '</span></h3>
            <p><span style="color: #ffa500">' . $grps_description . '</span></p>
            <p>' . $grps_category . '</p>
            <button class="null-btn shadow mt-4" onclick="openGroup(' . "'" . $grps_refcode . "'" . ')"><i class="fas fa-chevron-circle-right"></i> Open group</button>
            <p class="text-right" style="font-size: 8px;">' . $grps_createdate . '</p>
          </div>
        </div>
      </div>';

            $groupMemsArray = $row;
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
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
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
    $fileList = glob("../../media/profiles/$currentUser_Usrnm/*");

    //Loop through the array that glob returned.
    foreach ($fileList as $filename) {
        //Simply print them out onto the screen.
        //echo $filename, '<br>'; 
        $profileUserMediaList .= '
      <div class="grid-tile p-0 mx-0 content-panel-border-style my-4 center-container" style="overflow: hidden; max-height: 200px">
      <img src="' . $filename . '" class="img-fluidz" alt="media image" style="height: 100%">
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

        while ($row = mysqli_fetch_assoc($result)) {
            //`notification_id`, `notification_title`, `notification_message`, `notify_user`, `created_by`, `notification_date`, `notification_read`

            $notif_id = $row["notification_id"];
            $notif_title = $row["notification_title"];
            $notif_message = $row["notification_message"];
            $notif_date = $row["notification_date"];

            $communicationUserNotifications .= '
      <!-- Notifications Card for Communications Tab -->
      <div class="grid-tile">
        <div class="px-2 mx-0 content-panel-border-style my-4" id="notifcation-' . $notif_id . '">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1 fw-bold text-truncate">' . $notif_title . '</h5>
            <small class="text-end">' . $notif_date . ' (# days ago)</small>
          </div>
          <p class="mb-1">' . $notif_message . '</p>
          <small>' . $grps_category . '</small>
          <br>
          <div class="d-flex justify-content-between gap-2 w-100">
            <button class="badge onefit-buttons-style-light p-2 fw-bold fs-5 comfortaa-font shadow my-4"
              onclick="viewNotification(' . $notif_id . ')">
              <span class="material-icons material-icons-round" style="font-size: 20px !important;"> delete </span>
            </button>
            <button class="badge onefit-buttons-style-light p-2 fw-bold fs-5 comfortaa-font shadow my-4"
              onclick="viewNotification(' . $notif_id . ')">
              <span class="material-icons material-icons-round" style="font-size: 20px !important;"> open_in_full
              </span>
            </button>
          </div>
        </div>
      </div>
      <!-- ./ Notifications Card for Communications Tab -->
      ';
        }

        $output = $communicationUserNotifications;
    } else {
        $output_msg = "|[System Error]|:. [Communications load (User notifications) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output_msg . '</div></div>';
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
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="discover_programs-' . $programs_progid . '-' . $programs_refcode . '">
        <div class="card bg-transparent">
          <div class="card-body">
            <h3 class="card-title">' . $programs_title . ' <span style="font-size: 10px">(' . $programs_privacy . ')</span></h3>
            <p class="card-subtitle ">Trainer: @' . $programs_creator . '</p>
            <p class="card-text">' . $programs_description . '</p>
            <div class="text-center">
              <button class="null-btn m-4 shadow" onclick="openProgram(' . "'" . $programs_refcode . "'" . ')"><i class="fas fa-chevron-circle-right"></i> View program</button>
            </div>
          </div>
        </div>
      </div>';
        }

        $output = $profileUsersProgramsList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
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
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="resource-' . $usrresources_resourceid . '-' . $currentUser_Usrnm . '" style="max-width: 100%!important">
        <div>
          <h3>' . $usrresources_title . ' <span style="font-size: 10px">' . $usrresources_type . '</span></h3>
          <p><span style="color: #ffa500">' . $usrresources_description . '</span></p>
          <p><i class="fas fa-link"></i> | ' . $usrresources_link . '</p>
          <p>Shared by: @' . $usrresources_type . '</p>

          ' . $openlinkbtn . '

          <p class="text-right" style="font-size: 8px">' . $usrresources_sharedate . '</p>
        </div>
      </div>';
        }

        $output = $profileUsersResourcesList;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Users posts) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
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
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="fave-' . $fave_id . '">
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
          <ul class="list-group list-group-horizontal -sm mt-4">
            <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
              <i class="fas fa-heart"></i> <span class="d-none d-lg-block">Dope</span>
            </li>
            <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
              <i class="fas fa-comment-alt"></i> <span class="d-none d-lg-block">Comment</span>
            </li>
            <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
              <i class="fas fa-share-alt"></i> <span class="d-none d-lg-block">Share</span>
            </li>
            <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-0">
              <i class="fas fa-bookmark"></i> <span class="d-none d-lg-block">Fave</span>
            </li>
          </ul>
        </div>
      </div>';
        }

        $output = $profileUsersFavesList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';

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
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        $output = $app_err_msg;
        //exit();
    }

    return $output;
}
function getUserUpdates()
{
    global $usrposts_postid, $usrposts_postdate, $usrposts_message, $usrposts_user, $usrposts_faveref, $currentUserAccountProdImg, $usrposts_name, $usrposts_surname, $profileUsersPostsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    $sql = "SELECT * FROM community_posts cp INNER JOIN users u ON cp.username = u.username WHERE cp.username = '$currentUser_Usrnm';";

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

            $profileUsersPostsList .= '
         <!-- Social Update Card -->
    <div class="mb-4 p-0 social-update-card shadow-lg" style="border-bottom: #e88a04 solid 5px;"
      id="post-' . $usrposts_postid . '-' . $usrposts_user . '">
      <div class="row align-items-center px-4 py-4 m-0 down-top-grad-darkz" style="border-radius: 25px!important;">
        <div class="col-4 -md text-center">
          ' . $currentUserAccountProdImg . '
          
        </div>
        <div class="col-8 -md text-end">
          <div class="d-grid gap-4">
            <h3 class="text-truncate">' . $usrposts_name . ' ' . $usrposts_surname . '</h3>
            <span style="font-size: 10px">@<span style="color: #ffa500">' . $usrposts_user . '</span>
          </div>
        </div>
      </div>
      <div class="post-content px-4 px-0 fs-4 text-break down-top-grad-dark" style="border-radius: 25px!important;">
        <hr class="bg-white">
        <div>
          <p class="my-2">' . $usrposts_message . '</p>
        </div>
        <div class="row align-items-center">
          <div class="col-md text-center">
            <hr class="bg-white">
          </div>
          <div class="col-md-3 text-center">
            <p class="text-right p-3 rounded-pill bg-white text-dark m-0" style="font-size: 10px">' . $usrposts_postdate . '
            </p>
          </div>
        </div>

        <!--function buttons-->
        <ul class="list-group list-group-horizontal -sm my-4">
          <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
              onclick="socialFunctions(action, origin)">
              <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                favorite
              </span>
              <span class="d-none d-lg-block">Like</span>
            </button>

          </li>
          <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
              onclick="socialFunctions(action, origin)">
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
              onclick="socialFunctions(action, origin)">
              <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                share
              </span>
              <span class="d-none d-lg-block">Share</span>
            </button>

          </li>
          <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
              onclick="socialFunctions(action, origin)">
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
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
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
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
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
        $app_err_msg = '<div class="application-error-msg shadow d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output_msg . '</div></div>';
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
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
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

    //community posts (latest 50 posts)
    $sql = "SELECT * FROM community_posts cp INNER JOIN users u ON cp.username = u.username;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //`post_id`, `post_date`, `post_message`, `username`, `modified_date`, `favourite_ref`FROM `community_posts` WHERE 
            $commpost_postid = $row["post_id"];
            $commpost_postdate = $row["post_date"];
            $commpost_message = $row["post_message"];
            $commpost_user = $row["username"];
            $commpost_faveref = $row["favourite_ref"];
            $commpost_usr_name = $row["user_name"];
            $commpost_usr_surname = $row["user_surname"];

            $commpost_img_url = "../media/profiles/$currentUser_Usrnm/photo-1574680096145-d05b474e2155.jpg";

            $communityPosts .= '
      <!-- Community Update Card -->
    <div class="px-2 mx-0 my-4 social-update-card" style="border-bottom: #e88a04 solid 5px;" id="post-' . $commpost_postid . '-' . $commpost_user . '">
      <div class="row align-items-center px-4 py-4 m-0" style="border-radius: 25px!important;">
        <div class="col-4 -md text-center">

          <div class="social-update-profile-pic shadow-sm"></div>
        </div>
        <div class="col-8 -md text-end">
          <div class="d-grid gap-4">
            <h3 class="text-truncate">' . $commpost_usr_name . ' ' . $commpost_usr_surname . '</h3>
            <span style="font-size: 10px">@<span style="color: #ffa500">' . $commpost_user . '</span></span>
          </div>
        </div>
      </div>
      <div class="post-content">
        <hr class="bg-white">
        <div>
          <p class="my-2">' . $commpost_message . '</p>
        </div>
        <div class="row align-items-center">
          <div class="col-md text-center">
            <hr class="bg-white">
          </div>
          <div class="col-md-3 text-center">
            <p class="text-right p-3 rounded-pill bg-white text-dark m-0" style="font-size: 10px">' . $commpost_postdate . '
            </p>
          </div>
        </div>

        <!-- function buttons -->
        <ul class="list-group list-group-horizontal -sm my-4">
          <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
              onclick="socialFunctions(action, origin)">
              <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                favorite
              </span>
              <span class="d-none d-lg-block">Like</span>
            </button>

          </li>
          <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
              onclick="socialFunctions(action, origin)">
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
              onclick="socialFunctions(action, origin)">
              <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                share
              </span>
              <span class="d-none d-lg-block">Share</span>
            </button>

          </li>
          <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
              onclick="socialFunctions(action, origin)">
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
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}

//Content Load Functions - Discovery Specific Content
function getAllUsers()
{
    global $dbconn, $usrs_userid, $usrs_username, $usrs_name, $usrs_surname, $usrs_idnumber, $usrs_email, $usrs_contact, $usrs_dob, $usrs_gender, $usrs_race, $usrs_nationality, $usrs_acc_active, $usrs_prof_acctype, $discoverPeopleList, $activitiesTraineesList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //loading: Discover (load max of 50 records)
    //People
    $sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {

            $usrs_userid = $row["user_id"];
            $usrs_username = $row["username"];
            $usrs_name = $row["user_name"];
            $usrs_surname = $row["user_surname"];
            $usrs_idnumber = $row["id_number"];
            $usrs_email = $row["user_email"];
            $usrs_contact = $row["contact_number"];
            $usrs_dob = $row["date_of_birth"];
            $usrs_gender = $row["user_gender"];
            $usrs_race = $row["user_race"];
            $usrs_nationality = $row["user_nationality"];
            $usrs_acc_active = $row["account_active"];

            $usrs_prof_acctype = $row["profile_type"];

            $discoverPeopleList .= '
      <div class="grid-tile px-2 mx-0 container content-panel-border-style my-4" id="discover_people-' . $usrs_userid . '-' . $usrs_username . '">
        <div class="card bg-transparent align-items-center">
          <div class="text-center">
            <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
          </div>
          <div class="card-body">
            <h3>' . $usrs_name . ' ' . $usrs_surname . '</h3>
            <p>@<span style="color: #ffa500">' . $usrs_username . '</span></p>
            <div class="text-center">
              <button class="null-btn m-4 shadow" onclick="openProfiler(' . "'" . $usrs_username . "'" . ')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
            </div>
          </div>
        </div>
      </div>';
        }
        //echo $discoverPeopleList;
        //die();

        $output = $activitiesTraineesList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All People) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
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
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
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
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getAllTrainees()
{
    global $dbconn, $usrs_userid, $usrs_username, $usrs_name, $usrs_surname, $usrs_idnumber, $usrs_email, $usrs_contact, $usrs_dob, $usrs_gender, $usrs_race, $usrs_nationality, $usrs_acc_active, $activitiesTraineesList, $usrs_prof_acctype, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //loading: Discover (load max of 50 records)
    //People
    $sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {

            $usrs_userid = $row["user_id"];
            $usrs_username = $row["username"];
            $usrs_name = $row["user_name"];
            $usrs_surname = $row["user_surname"];
            $usrs_idnumber = $row["id_number"];
            $usrs_email = $row["user_email"];
            $usrs_contact = $row["contact_number"];
            $usrs_dob = $row["date_of_birth"];
            $usrs_gender = $row["user_gender"];
            $usrs_race = $row["user_race"];
            $usrs_nationality = $row["user_nationality"];
            $usrs_acc_active = $row["account_active"];
            $usrs_prof_acctype = $row["profile_type"];

            /*$discoverPeopleList .= '
      <div class="grid-tile px-2 mx-0 container content-panel-border-style my-4" id="discover_people-'.$usrs_userid.'-'.$usrs_username.'">
        <div class="card bg-transparent align-items-center">
          <div class="text-center">
            <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
          </div>
          <div class="card-body">
            <h3>'.$usrs_name.' '.$usrs_surname.'</h3>
            <p>@<span style="color: #ffa500">'.$usrs_username.'</span></p>
            <div class="text-center">
              <button class="null-btn m-4 shadow" onclick="openProfiler('."'".$usrs_username."'".')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
            </div>
          </div>
        </div>
      </div>';*/

            //compile list of trainers
            if ($usrs_prof_acctype == "trainee") {
                $activitiesTraineesList .= '
        <div class="grid-tile px-2 mx-0 container content-panel-border-style my-4" id="discover_people-' . $usrs_userid . '-' . $usrs_username . '">
          <div class="card bg-transparent align-items-center">
            <div class="text-center">
              <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
            </div>
            <div class="card-body">
              <h3>' . $usrs_name . ' ' . $usrs_surname . '</h3>
              <p>@<span style="color: #ffa500">' . $usrs_username . '</span></p>
              <div class="text-center">
                <button class="null-btn m-4 shadow" onclick="openProfiler(' . "'" . $usrs_username . "'" . ')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
              </div>
            </div>
          </div>
        </div>';
            }
        }
        //echo $discoverPeopleList;
        //die();

        $output = $activitiesTraineesList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All People) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getAllTrainers()
{
    global $dbconn, $usrs_userid, $usrs_username, $usrs_name, $usrs_surname, $usrs_idnumber, $usrs_email, $usrs_contact, $usrs_dob, $usrs_gender, $usrs_race, $usrs_nationality, $usrs_acc_active, $activitiesTrainersList, $usrs_prof_acctype, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //loading: Discover (load max of 50 records)
    //People
    $sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {

            $usrs_userid = $row["user_id"];

            $usrs_username = $row["username"];
            $usrs_name = $row["user_name"];
            $usrs_surname = $row["user_surname"];
            $usrs_idnumber = $row["id_number"];
            $usrs_email = $row["user_email"];
            $usrs_contact = $row["contact_number"];
            $usrs_dob = $row["date_of_birth"];
            $usrs_gender = $row["user_gender"];
            $usrs_race = $row["user_race"];
            $usrs_nationality = $row["user_nationality"];
            $usrs_acc_active = $row["account_active"];

            $usrs_prof_acctype = $row["profile_type"];

            /*$discoverPeopleList .= '
      <div class="grid-tile px-2 mx-0 container content-panel-border-style my-4" id="discover_people-'.$usrs_userid.'-'.$usrs_username.'">
        <div class="card bg-transparent align-items-center">
          <div class="text-center">
            <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
          </div>
          <div class="card-body">
            <h3>'.$usrs_name.' '.$usrs_surname.'</h3>
            <p>@<span style="color: #ffa500">'.$usrs_username.'</span></p>
            <div class="text-center">
              <button class="null-btn m-4 shadow" onclick="openProfiler('."'".$usrs_username."'".')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
            </div>
          </div>
        </div>
      </div>';*/

            //compile list of trainers
            if ($usrs_prof_acctype == "trainee") {
                $activitiesTrainersList .= '
        <div class="grid-tile px-2 mx-0 container content-panel-border-style my-4" id="discover_people-' . $usrs_userid . '-' . $usrs_username . '">
          <div class="card bg-transparent align-items-center">
            <div class="text-center">
              <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
            </div>
            <div class="card-body">
              <h3>' . $usrs_name . ' ' . $usrs_surname . '</h3>
              <p>@<span style="color: #ffa500">' . $usrs_username . '</span></p>
              <div class="text-center">
                <button class="null-btn m-4 shadow" onclick="openProfiler(' . "'" . $usrs_username . "'" . ')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
              </div>
            </div>
          </div>
        </div>';
            }
        }
        //echo $discoverPeopleList;
        //die();

        $output = $activitiesTrainersList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All People) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
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
    <title>Document</title>

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

    <!-- Google Charts Code -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Timeline chart -->
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['timeline']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var container = document.getElementById('timeline');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();

            dataTable.addColumn({
                type: 'string',
                id: 'Term'
            });
            dataTable.addColumn({
                type: 'string',
                id: 'Name'
            });
            dataTable.addColumn({
                type: 'date',
                id: 'Start'
            });
            dataTable.addColumn({
                type: 'date',
                id: 'End'
            });

            dataTable.addRows([
                ['1', 'George Washington', new Date(1789, 3, 30), new Date(1797, 2, 4)],
                ['2', 'John Adams', new Date(1797, 2, 4), new Date(1801, 2, 4)],
                ['3', 'Thomas Jefferson', new Date(1801, 2, 4), new Date(1809, 2, 4)]
            ]);

            var options = {
                timeline: {
                    showRowLabels: true
                }
            };

            chart.draw(dataTable, options);
        }
    </script>
    <!-- ./ Google Charts Code -->

    <!-- Site Scripts -->
    <script src="../scripts/js/script.js"></script>
    <script src="../scripts/js/ap_requests.js"></script>
    <!-- ./ Site Scripts -->
</head>

<body onload="initializeContent('<?php echo $userAuth; ?>','<?php echo $currentUser_Usrnm; ?>')">
    <!-- Navigation bar -->
    <div class="container py-4 text-center">
        <a class="navbar-brand m-0 fs-1 text-white comfortaa-font" href="#">
            One<span style="color: #e88a04">fit</span>.app<span style="font-size: 10px">&trade;</span>
        </a>
    </div>
    <!-- ./ Navigation bar -->

    <!-- Main Content -->
    <div class="container-fluid px-0" style="padding-bottom: 100px">
        <!--   -->
        <nav class="navbar navbar-light sticky-top navbar-style" style="border-radius: 0 0 25px 25px; max-height: 100vh !important;">
            <!-- App Function Buttons -->
            <div class="container -fluid">
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
                            <img src="../media/assets/One-Symbol-Logo-White.png" alt="Onefit Logo" class="p-1 img-fluid my-pulse-animationz" style="height: 50px; width: 50px; border-radius: 15px; border-color: #e88a04 !important" />
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
                <div class="offcanvas offcanvas-end offcanvas-menu-primary-style" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="h-100" id="offcanvas-menu">
                        <div class="offcanvas-header shadow fs-1" style="background-color: #343434; color: #fff">
                            <img src="../media/assets/One-Symbol-Logo-Dark-Mix.png" alt="" class="img-fluid logo-size-2 pulse-animation" />

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
                                    <a class="nav-link" href="#">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Contact</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Onefit.app&trade;</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Onefit.Edu&trade; (Blog)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Onefit.Shop&trade;</a>
                                </li>
                                <hr class="text-dark" style="height: 5px;" />
                                <li class="nav-item">
                                    <a class="nav-link onefit-buttons-style-dark p-4 text-center" href="#" style="border-bottom: 0 !important">Account Registration</a>
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

                <div class="offcanvas offcanvas-start offcanvas-menu-primary-style" tabindex="-1" id="offcanvasNotifications" aria-labelledby="offcanvasNotificationsLabel">
                    <div class="offcanvas-header align-center shadow" style="background-color: #fff;">
                        <span class="material-icons material-icons-round" style="font-size: 48px !important"> notifications </span>

                        <h5 id="offcanvasTopLabel" style="overflow-x: hidden;">
                            Notifications</h5>

                        <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="offcanvas" aria-label="Close">
                            <span class="material-icons material-icons-round"> cancel </span>
                        </button>
                    </div>
                    <div class="offcanvas-body" style="background-color: rgba(255, 255, 255, 0.8);">
                        <ul class="list-group list-group-flush shadow p-4z" id="notif-list" style="border-radius: 25px; max-height: 60vh;">
                            <li class="list-group-item border-dark">An item</li>
                            <li class="list-group-item border-dark">A second item</li>
                            <li class="list-group-item border-dark">A third item</li>
                            <li class="list-group-item border-dark">A fourth item</li>
                            <li class="list-group-item border-dark">And a fifth one</li>
                        </ul>
                    </div>
                </div>
                <!-- ./Notifocation List Offcanvas -->
            </div>
            <!-- ./ App Function Buttons -->
        </nav>

        <!-- Tab Content -->
        <div class="container">
            <div class="tab-container" id="tab-container">
                <div id="TabHome" class="shadow w3-container w3-animate-right content-tab p-4" style="display: none">
                    <h1>Dashboard</h1>
                    <p>This is the Dashboard Page.</p>

                    <div class="variable-grid-container">
                        <div class="wide-grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>Activities list/lineup</h4>
                            <p>the activities list will be able to switch through the different programs of the use</p>
                        </div>
                        <div class="tall-grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>Social Updates Feed</h4>
                            <p>the activities list will be able to switch through the different programs of the use</p>
                        </div>
                        <div class="grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>Resources, blog and Ads Feed</h4>
                            <p>the activities list will be able to switch through the different programs of the use</p>
                        </div>
                        <div class="grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>Resources, blog and Ads Feed</h4>
                            <p>the activities list will be able to switch through the different programs of the use</p>
                        </div>
                        <div class="grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>Resources, blog and Ads Feed</h4>
                            <p>the activities list will be able to switch through the different programs of the use</p>
                        </div>
                        <div class="grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>Resources, blog and Ads Feed</h4>
                            <p>the activities list will be able to switch through the different programs of the use</p>
                        </div>
                        <div class="grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>Resources, blog and Ads Feed</h4>
                            <p>the activities list will be able to switch through the different programs of the use</p>
                        </div>
                        <div class="wide-grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>Resources, blog and Ads Feed</h4>
                            <p>the activities list will be able to switch through the different programs of the use</p>
                        </div>
                    </div>

                    <div class="row" hidden>
                        <div class="col-md-4">
                            <h1>Activities list/lineup</h1>
                            <p>the activities list will be able to switch through the different programs of the use</p>
                        </div>
                        <div class="col-md-6">
                            <h1>Social Updates Feed</h1>
                        </div>
                        <div class="col-md-2">
                            <h1>Resources, blog and Ads Feed</h1>
                            <p>AdMarket, Onefoodie and Store</p>
                        </div>
                    </div>
                </div>
                <div id="TabProfile" class="shadow w3-container w3-animate-right content-tab p-4" style="display: none">
                    <h1>Profile</h1>
                    <hr class="text-white" />
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
                                <?php echo $currentUserAccountProdImg; ?>
                                <!-- ./ Profile Picture -->
                                <p class='outfit-font mt-2 username-tag'>@<?php echo $currentUser_Usrnm; ?></p>
                            </div>
                            <!--<hr class='text-white' />-->
                            <ol class='list-group list-group-numberedz list-group-flush'>
                                <li class='list-group-item d-flex justify-content-between align-items-start bg-transparent text-white'>
                                    <div class='ms-2 me-auto'>
                                        <div class='fw-bold users-name-tag' style='color: #e88a04'>
                                            <?php echo $usrprof_name . " " . $usrprof_surname; ?></div>
                                        <span class='username-tag'>@<?php echo $currentUser_Usrnm; ?></span><br />
                                        Lvl. 1
                                    </div>
                                    <span class='badge bg-primary rounded-pillz p-4' style='background-color: #e88a04 !important; color: #333 !important; border-radius: 25px'>
                                        <?php echo $verifIcon; ?>
                                    </span>
                                </li>
                                <li class='list-group-item d-flex justify-content-between align-items-start bg-transparent text-white'>
                                    <div class='ms-2 me-auto'>
                                        <div class='fw-bold' style='color: #e88a04'>Followers</div>
                                        <span>2 Mutual Friends</span><br />
                                        <span>6 Messages</span>
                                    </div>
                                    <span class='badge bg-primary rounded-pillz p-4' style='background-color: #e88a04 !important; color: #fff !important; border-radius: 25px'>
                                        <span class='material-icons material-icons-round' style='font-size: 20px !important'> people_alt </span>
                                        <span>6</span>
                                        <span>
                                </li>
                                <li class='list-group-item d-flex justify-content-between align-items-start bg-transparent text-white'>
                                    <div class='ms-2 me-auto'>
                                        <div class='fw-bold' style='color: #e88a04'>Achievements</div>
                                        <span>18 Activities Remaining</span><br />
                                        <span>4 Challenges Remaining</span>
                                    </div>
                                    <span class='badge bg-primary rounded-pillz p-4' style='background-color: #e88a04 !important; color: #fff !important; border-radius: 25px'>
                                        <span class='material-icons material-icons-round' style='font-size: 20px !important'> emoji_events </span>
                                        <span>3</span>
                                    </span>
                                </li>
                            </ol>

                            <!--Users Social Media Links-->
                            <div id='userSocialItems'><?php echo $userSocialItemsList; ?></div>

                            <div class='row my-4'>
                                <div class='col-md p-4'>
                                    <h5 class='fs-1'>Updates</h5>
                                    <div id='profileUsersPostsList' style='max-height: 100vh, overflow-y: auto;'><?php echo $outputProfileUsersPostsList; ?></div>
                                </div>
                                <div class='col-md-4 p-4'>
                                    <h5 class='fs-1'>Media</h5>
                                    <div id='profileUserMediaList'> <?php echo $outputProfileUserMediaList; ?> </div>
                                    <hr class='text-white' style='height: 5px;'>
                                    <h5 class='fs-1'>Resources</h5>
                                    <div id='profileUsersResourcesList'> <?php echo $outputProfileUsersResourcesList; ?> </div>
                                    <hr class='text-white' style='height: 5px;'>
                                    <h5 class='fs-1'>Friends</h5>
                                    <div id='profileUserFriendsList'> <?php echo $outputProfileUserFriendsList; ?> </div>
                                    <hr class='text-white' style='height: 5px;'>
                                    <h5 class='fs-1'>Followers</h5>
                                    <hr class='text-white' style='height: 5px;'>
                                    <h5 class='fs-1'>Following</h5>
                                    <hr class='text-white' style='height: 5px;'>
                                    <h5 class='fs-1'>Programs</h5>
                                    <div id='profileUsersProgramsList'> <?php echo $outputProfileUsersProgramsList; ?> </div>
                                    <hr class='text-white' style='height: 5px;'>
                                    <h5 class='fs-1'>Saved</h5>
                                    <div id='profileUsersFavesList'> <?php echo $outputProfileUsersFavesList; ?> </div>
                                    <hr class='text-white' style='height: 5px;'>
                                    <h5 class='fs-1'>Groups</h5>
                                    <div id='profileUserSubsGroupsList'> <?php echo $profileUserSubsGroupsList; ?> </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./ Profile Tab: User Profile -->
                    </div>


                </div>
                <div id="TabDiscovery" class="shadow w3-container w3-animate-right content-tab p-4" style="display: none">
                    <h1>Discovery</h1>
                    <p class="text-right" style="font-size: 10px">powered by AdaptEngine™</p>

                    <div class="row align-items-center">
                        <div class="col-md -10">
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
                        <div class="nav nav-tabs" id="nav-tab-discovery" role="tablist" style="border-color: #e88a04 !important">
                            <button class="nav-link active" id="nav-discovery-trainers-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-trainers" type="button" role="tab" aria-controls="nav-discovery-trainers" aria-selected="true">Trainers</button>

                            <button class="nav-link" id="nav-discovery-trainees-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-trainees" type="button" role="tab" aria-controls="nav-discovery-trainees" aria-selected="false">Trainees</button>

                            <button class="nav-link" id="nav-discovery-posts-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-posts" type="button" role="tab" aria-controls="nav-discovery-posts" aria-selected="false">Updates</button>

                            <button class="nav-link" id="nav-discovery-onefoodie-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-onefoodie" type="button" role="tab" aria-controls="nav-discovery-onefoodie" aria-selected="false">Onefoodie&trade;</button>

                            <button class="nav-link" id="nav-discovery-fit-progs-indi-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-fit-progs-indi" type="button" role="tab" aria-controls="nav-discovery-fit-progs-indi" aria-selected="false">Fitness Programs</button>

                            <button class="nav-link" id="nav-discovery-fit-progs-team-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-fit-progs-team" type="button" role="tab" aria-controls="nav-discovery-fit-progs-team" aria-selected="false">Fitness Programs</button>

                            <button class="nav-link" id="nav-discovery-well-progs-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-well-progs" type="button" role="tab" aria-controls="nav-discovery-well-progs" aria-selected="false">Wellness Programs</button>

                            <button class="nav-link" id="nav-discovery-fitengine-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-fitengine" type="button" role="tab" aria-controls="nav-discovery-fitengine" aria-selected="false">FitEngine&trade;</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tab-DiscoveryContent">
                        <div class="tab-pane fade" id="nav-discovery-trainers" role="tabpanel" aria-labelledby="nav-discovery-trainers-tab">
                            <?php echo $discoveryAllTrainers; ?>
                        </div>
                        <div class="tab-pane fade show active" id="nav-discovery-trainees" role="tabpanel" aria-labelledby="nav-discovery-trainees-tab">
                            <?php echo $discoveryAllTrainees; ?>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-posts" role="tabpanel" aria-labelledby="nav-discovery-posts-tab">
                            <div class="text-center" style="margin: 25vh 0" id="comm-updates-search-container">
                                <h4><i class="fas fa-search"></i>Type on the search bar to see some posts</h4>

                                <?php echo $outputCommunityUpdates; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-onefoodie" role="tabpanel" aria-labelledby="nav-discovery-onefoodie-tab">
                            <!--<php echo $onefoodieDietBar; ?>-->
                            <p>Onefoodie Diet Bar</p>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-fit-progs-indi" role="tabpanel" aria-labelledby="nav-discovery-fit-progs-indi-tab">
                            <p>Indi</p>
                            <?php echo $discoveryFitProgsIndi; ?>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-fit-progs-team" role="tabpanel" aria-labelledby="nav-discovery-fit-progs-team-tab">
                            <p>Team Athletics</p>
                            <?php echo $discoveryFitProgsTeams; ?>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-well-progs" role="tabpanel" aria-labelledby="nav-discovery-well-progs-tab">
                            <?php echo $output; ?>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-fitengine" role="tabpanel" aria-labelledby="nav-discovery-fitengine-tab">
                            Loading...
                        </div>


                    </div>
                </div>
                <div id="TabStudio" class="shadow w3-container w3-animate-right content-tab p-4" style="display: none">
                    <h1><span style="color: #fff !important">One</span><span style="color: #e88a04 !important">fit</span>.Studio
                    </h1>
                    <hr class="text-white" />
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
                        <div class="grid-tile -100 max-100vh shadow p-4 down-top-grad-dark">
                            <h2><span style="color: #fff !important">One</span><span style="color: #e88a04 !important">fit</span>.Community Streams (Onefit.tv)</h2>
                            <p>Live stream sessions of scheduled Community (public) & Group-based fitness program guidance classes.
                                (Scheduled Program Guidance Classes and Community Events on Onefit App and Socials that are open to all
                                visitors, casual subscribers, and premium members (Onefit.app, Zoom, Skype, Teams)</p>

                            <!--<video preload="none" id="player" class="player" settings controls crossorigin
                data-poster="../media/assets/fitness-colage.png"></video>-->
                        </div>
                    </div>

                    <div class="grid-container studio-tab-grid">
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark">
                            <h4>Personal Training Centre</h4>
                            <p>Scheduling of Private/One-On-One Live Streams and/or physical interaction with Personal Trainers
                                (Streams: Onefit.app, Zoom, Skype, Teams | Physical: Your nearest Gym Company Gym/nearest Virgin Active
                                and House-Call)</p>
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark">
                            <h4>Stream library</h4>
                            <p>Live stream recording history (Community and Private)</p>
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark">
                            <h4><span style="color: #fff !important">One</span><span style="color: #e88a04 !important">fit</span>.Muse
                            </h4>
                            <p>Music Centre/Music Playlist</p>
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark">
                            <h4>Athletic Fitness</h4>
                            <p>Athletic Fitness Programs for Individuals.</p>
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark">
                            <h4>Team-Based Athletics</h4>
                            <p>Athletic Fitness Programs for Teams in Sports.</p>
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark">
                            <h4>Indi-Home and Gym</h4>
                            <p>Home and Gym Fitness Programs for Individuals</p>
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark">
                            <h4>Diet Menu</h4>
                            <p>Healthy Eating Guide</p>
                        </div>
                    </div>
                </div>
                <div id="TabStore" class="shadow w3-container w3-animate-right content-tab p-4" style="display: none">
                    <h1><span style="color: #fff !important">One</span><span style="color: #e88a04 !important">fit</span>.Store
                    </h1>
                    <hr class="text-white" />
                    • Sale of Activity Trackers and Smart Watches (wearables) • Sale of Fitness Equipment (weights, weight
                    benches,
                    treadmills, scales, etc.) • Sale of Supplements and Vitamins • Sale of Membership Subscriptions (3 Month, 6
                    Month, and Annual)

                    <h5 class="fs-1 fw-bold"><span class="material-icons material-icons-round"> devices_other </span> Activity
                        Trackers and Smart Watches (wearables)</h5>
                    <img src="../media/assets/smartwatches/Watch Banner.png" alt="" class="img-fluid">

                    <h5 class="fs-1 fw-bold"><span class="material-icons material-icons-round"> fitness_center </span> Fitness
                        Equipment (weights, weight benches, treadmills, scales, etc.)</h5>

                    <h5 class="fs-1 fw-bold"><span class="material-icons material-icons-round"> medication </span> Supplements and
                        Vitamins</h5>

                    <h5 class="fs-1 fw-bold"><span class="material-icons material-icons-round"> verified_user </span> Membership
                    </h5>
                    <div class="card-group">
                        <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Basic Starter - 3 Month</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                                    content.
                                    This content is a little bit longer.</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </div>
                        </div>
                        <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Onefit.Training</h5>
                                <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </div>
                        </div>
                        <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Team Athletics - Annual</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                                    content.
                                    This card has even longer content than the first to show that equal height action.</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="TabSocial" class="shadow w3-container w3-animate-right content-tab p-4" style="display: block">
                    <h1><span style="color: #fff !important">One</span><span style="color: #e88a04 !important">fit</span>.Social
                    </h1>
                    <hr class="text-white" />
                    • Community Status Update Feed • Shared Resources Feed • Social Chat Messenger • Public Achievements • Public
                    Events Lineup (Community live stream) • Community Rewards Program

                    <!-- Horizontal Tab Selection visible on screens smaller than lg and is fixed to bottom of viewport -->
                    <div class="navbar fixed-bottom navbar-style pb-0 mb-0 d-lg-none">
                        <div class="text-end w-100" style="margin-top: -85px">
                            <button class="py-2 px-4 mx-4 shadow onefit-buttons-style-light" type="button" data-bs-toggle="collapse" data-bs-target="#social-collapse-bottom-nav" aria-expanded="false" aria-controls="social-collapse-bottom-nav">
                                <!--style="background-color: #e88a04; color: #343434; border: 0; height: 60px; width: 60px"-->
                                <span class="material-icons material-icons-round" id="social-toggle-bottom-nav" style="font-size: 24px !important;">
                                    style
                                </span>
                            </button>
                        </div>
                        <div class="collapse" id="social-collapse-bottom-nav">
                            <div class="container horizontal-scroll no-scroller">
                                <div class="horizontal-scroll-card -nav">
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
                                <div class="tab-pane fade show active" id="v-pills-social-commfeed" role="tabpanel" aria-labelledby="v-pills-social-commfeed-tab" style="max-height: 100vh !important; overflow-y: auto">
                                    <h5 class="fs-1">Community Updates</h5>
                                    <div id="Community-Posts" style="max-height: 100vh; overflow-y auto; overflow-x: hidden;">
                                        <?php echo $outputCommunityUpdates; ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-social-resfeed" role="tabpanel" aria-labelledby="v-pills-social-resfeed-tab">
                                    <h5 class="fs-1">Community Resources</h5>
                                    <div id="Community-Resources" style="max-height: 100vh; overflow-y auto; overflow-x: hidden;">
                                        <?php echo $outputCommunityResources; ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-social-groups" role="tabpanel" aria-labelledby="v-pills-social-groups-tab">
                                    <h5 class="fs-1">Groups &amp; Clubs</h5>
                                    <div id="Community-Groups" style="max-height: 100vh; overflow-y auto; overflow-x: hidden;">
                                        <?php echo $outputCommunityGroups; ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-social-pubevents" role="tabpanel" aria-labelledby="v-pills-social-pubevents-tab">
                                    <h5 class="fs-1">Public Events Lineup (Community Live Stream)</h5>
                                </div>

                                <div class="tab-pane fade" id="v-pills-social-pubachieve" role="tabpanel" aria-labelledby="v-pills-social-pubachieve-tab">
                                    <h5 class="fs-1">Public Achievements Feed</h5>
                                </div>

                                <div class="tab-pane fade" id="v-pills-social-followers" role="tabpanel" aria-labelledby="v-pills-social-followers-tab">
                                    <h5 class="fs-1">Followers</h5>
                                    <div id="Community-Followers" style="max-height: 100vh; overflow-y auto; overflow-x: hidden;">
                                        <?php echo $discoveryAllUsersList; ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-social-following" role="tabpanel" aria-labelledby="v-pills-social-following-tab">
                                    <h5 class="fs-1">Following</h5>
                                    <div id="Community-Following" style="max-height: 100vh; overflow-y auto; overflow-x: hidden;">
                                        <?php echo $discoveryAllUsersList; ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-social-commrewards" role="tabpanel" aria-labelledby="v-pills-social-commrewards-tab">
                                    <h5 class="fs-1">Community Rewards Program</h5>
                                </div>

                            </div>
                            <!-- ./ .Social Main Content Tab Container -->
                        </div>
                        <div class="col-md">
                            <h5>Trending</h5>
                            <h5>Who to follow</h5>
                        </div>
                    </div>
                </div>
                <div id="TabData" class="shadow w3-container w3-animate-right content-tab p-4" style="display: none">
                    <h1>Fitness Insights</h1>
                    <p>Data Centre</p>
                    <hr class="text-white" style="height: 5px;">

                    <!-- Timelines and Calender -->
                    <h5 class="mt-4 fs-1">Fitness Timeline</h5>
                    <!-- Activity Calender -->
                    <div id="activities-calender" hidden></div>
                    <img src="../media/assets/12month-calendar.png" alt="calender placeholder" class="img-fluid mb-4">
                    <!-- ./ Activity Calender -->
                    <!-- Timeline Chart -->
                    <div id="timeline" class="w-100 my-4" style="min-height: 200px; overflow-x: auto;"></div>
                    <!-- ./ Timeline Chart -->
                    <!-- ./ Timeline and Calender -->

                    <!-- User Smart Device Activity Tracking -->
                    <hr class="text-white" style="height: 5px;">
                    <h5 class="mt-4 fs-1">Activity Tracking</h5>
                    <div class="container p-4 shadow-lg d-inline-block border-start border-end" style="border-radius: 25px; border-color: #e88a04 !important; background-color: #343434">
                        <div class="row align-items-center text-center comfortaa-font">
                            <div class="col-sm py-2 d-inline">
                                <!--<i class="fas fa-heart"></i>-->
                                <span class="material-icons material-icons-round"> monitor_heart </span>
                                HeartRate
                            </div>
                            <div class="col-sm py-2 d-inline"><span style="color: #e88a04">|</span></div>
                            <div class="col-sm py-2 d-inline">
                                <!--<i class="fas fa-thermometer-half"></i>-->
                                <span class="material-icons material-icons-round"> device_thermostat </span>
                                Temp
                            </div>
                            <div class="col-sm py-2 d-inline">
                                <img src="../media/assets/icons/icons8-smart-watch-50.png" alt="smartwatch" class="img-fluid my-pulse-animation" />
                            </div>
                            <div class="col-sm py-2 d-inline">
                                <!--<i class="fas fa-bolt"></i>-->
                                <span class="material-icons material-icons-round"> bolt </span>
                                Speed
                            </div>
                            <div class="col-sm py-2 d-inline"><span style="color: #e88a04">|</span></div>
                            <div class="col-sm py-2 d-inline">
                                <!--<i class="fas fa-walking"></i>-->
                                <span class="material-icons material-icons-round"> directions_walk </span>
                                Steps
                            </div>
                        </div>
                        <hr class="text-white">
                        <!-- detailed metric list -->
                        <ul class="list-group list-group-flush text-white border-0">
                            <li class="list-group-item bg-transparent text-white" style="border-color: #e88a04;">
                                <div class="row">
                                    <div class="col-4">Metric 1</div>
                                    <div class="col">
                                        Chart
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #e88a04;">
                                <div class="row">
                                    <div class="col-4">Metric 2</div>
                                    <div class="col">
                                        Chart
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #e88a04;">
                                <div class="row">
                                    <div class="col-4">Metric 3</div>
                                    <div class="col">
                                        Chart
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #e88a04;">
                                <div class="row">
                                    <div class="col-4">Metric 4</div>
                                    <div class="col">
                                        Chart
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #e88a04;">
                                <div class="row">
                                    <div class="col-4">Metric 5</div>
                                    <div class="col">
                                        Chart
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!-- ./ detailed metric list -->
                    </div>
                    <!-- ./ User Smart Device Activity Tracking -->

                    <!-- Weekly Surveys -->
                    <hr class="text-white" style="height: 5px;">
                    <h5 class="mt-4 fs-1">Weekly Surveys (Start Date - End Date)</h5>
                    <div class="horizontal-scroll shadow">
                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Monday</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Tuesday</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Wednesday</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Thursday</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Friday</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Saturday</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <div class="horizontal-scroll-card p-4 m-1 shadow">
                            <h5>Sunday</h5>
                            <hr class="text-white" style="height: 5px;">

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- ./ Weekly Surveys -->

                    <!-- User Wellness Tracking Log -->
                    <hr class="text-white" style="height: 5px;">
                    <h5 class="mt-4 fs-1">Wellness Tracking</h5>
                    <p class="fs-3">Wellness Rating: 90%</p>
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
                    <h5 class="mt-4 fs-1">Load Monitoring</h5>
                    <p class="fs-3">Load Rating: 90%</p>
                    <div class="row my-4">
                        <div class="col-md-4">
                            <h5>Survey log</h5>
                        </div>
                        <div class="col-md">
                            <p>Survey Charts / Results</p>
                        </div>
                    </div>
                    <!-- ./ User Load Monitoring Log -->

                    <hr class="text-white" style="height: 5px;">
                    <h5 class="mt-4 fs-1">Indi-Training / Indi-Athlete-Training</h5>

                    <hr class="text-white" style="height: 5px;">
                    <h5 class="nt-4 fs-1">Team Athletics Training</h5>
                    <div id="team-athletics-container">
                        <p class="fs-5">Training Schedule</p>
                        <div class="training-schedule-container p-4 text-center down-top-grad-white">
                            <h1>Training week for those who played 45+ minutes in previous match</h1>
                            <hr class="text-white" style="height: 5px;">

                            <div class="row align-items-end text-dark" id="training-schedule-chart-grid">
                                <div class="col" id="day-1-col">
                                    <p class="fs-3 fw-bold">Regeneration</p>
                                    <p>RPE 1-3</p>
                                    <div class="chart-col-bar p-2 shadow progress-bar progress-bar-stripedz bg-warningz">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Cycling / Spinning</p>
                                            <img src="../media/assets/icons/cycling.png" alt="" class="img-fluid">
                                        </div>
                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Strength & Core</p>
                                            <img src="../media/assets/icons/bodybuilder.png" alt="" class="img-fluid">
                                        </div>
                                    </div>

                                    <hr class="text-white">
                                    <p class="text-center">Day 1/-6</p>
                                </div>

                                <div class="col" id="day-1-col">
                                    <p class="fs-3 fw-bold">Recovery</p>
                                    <p>RPE 0</p>
                                    <div class="chart-col-bar p-2 shadow">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Ice Bath</p>
                                            <img src="../media/assets/icons/bath-tub.png" alt="" class="img-fluid">
                                        </div>

                                    </div>

                                    <hr class="text-white">
                                    <p class="text-center">Day 2/-5</p>
                                </div>

                                <div class="col" id="day-1-col">
                                    <p class="fs-3 fw-bold">Longer picth / strides</p>
                                    <p>RPE 4-6</p>
                                    <div class="chart-col-bar p-2 shadow">
                                        <div class="chart-col-bar-item text-center">
                                            <p>RST</p>
                                            <img src="../media/assets/icons/running.png" alt="" class="img-fluid">
                                        </div>
                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Tactics</p>
                                            <img src="../media/assets/icons/thinking.png" alt="" class="img-fluid">
                                        </div>
                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Practice Kick-Off</p>
                                            <img src="../media/assets/icons/soccer-ball.png" alt="" class="img-fluid">
                                        </div>
                                    </div>

                                    <hr class="text-white">
                                    <p class="text-center">Day 3/-4</p>
                                </div>

                                <div class="col" id="day-1-col">
                                    <p class="fs-3 fw-bold">Strength / change of directon</p>
                                    <p>RPE 7-10</p>
                                    <div class="chart-col-bar p-2 shadow">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Multi-directional WU</p>
                                            <img src="../media/assets/icons/directions.png" alt="" class="img-fluid" style="filter: grayscale(100%);">
                                        </div>
                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                        <div class="chart-col-bar-item text-center">
                                            <p>SSGs</p>
                                            <img src="../media/assets/icons/running.png" alt="" class="img-fluid">
                                        </div>
                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Strength</p>
                                            <img src="../media/assets/icons/bodybuilder.png" alt="" class="img-fluid">
                                        </div>
                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Practice Kick-Off</p>
                                            <img src="../media/assets/icons/soccer-ball.png" alt="" class="img-fluid">
                                        </div>
                                    </div>

                                    <hr class="text-white">
                                    <p class="text-center">Day 4/-3</p>
                                </div>

                                <div class="col" id="day-1-col">
                                    <p class="fs-3 fw-bold">Taper</p>
                                    <p>RPE 1-3</p>
                                    <div class="chart-col-bar p-2 shadow">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Multi-directional WU</p>
                                            <img src="../media/assets/icons/directions.png" alt="" class="img-fluid" style="filter: grayscale(100%);">
                                        </div>
                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Tempo runs</p>
                                            <img src="../media/assets/icons/running.png" alt="" class="img-fluid">
                                        </div>
                                    </div>

                                    <hr class="text-white">
                                    <p class="text-center">Day 5/-2</p>
                                </div>
                                <div class="col" id="day-1-col">
                                    <p class="fs-3 fw-bold">Match prep</p>
                                    <p>RPE 2-4</p>
                                    <div class="chart-col-bar p-2 shadow">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Multi-directional WU</p>
                                            <img src="../media/assets/icons/directions.png" alt="" class="img-fluid" style="filter: grayscale(100%);">
                                        </div>
                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Tactics</p>
                                            <img src="../media/assets/icons/thinking.png" alt="" class="img-fluid">
                                        </div>
                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Short SSGs</p>
                                            <img src="../media/assets/icons/running.png" alt="" class="img-fluid">
                                        </div>
                                    </div>

                                    <hr class="text-white">
                                    <p class="text-center">Day 6/-1</p>
                                </div>
                                <div class="col" id="day-1-col">
                                    <p class="fs-3 fw-bold">Match</p>
                                    <p>RPE 7-10</p>
                                    <div class="chart-col-bar p-2 shadow">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Pre-match WU</p>
                                            <img src="../media/assets/icons/running.png" alt="" class="img-fluid">
                                        </div>
                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                        <div class="chart-col-bar-item text-center">
                                            <p>Match Kick-Off - We Play to Win!</p>
                                            <img src="../media/assets/icons/soccer-ball.png" alt="" class="img-fluid">
                                        </div>
                                    </div>

                                    <hr class="text-white">
                                    <p class="text-center">Match Day</p>
                                </div>
                            </div>
                        </div>

                        <img src="../media/assets/example.png" alt="training week for ..." class="img-fluid my-4" hidden>

                        <p class="fs-5">Match Schedule</p>
                        <table class="table table-dark table-striped my-4">
                            <thead>
                                <tr>
                                    <th scope="col">Match #</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Venue</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Team A vs Team B</td>
                                    <td>Stadium 1</td>
                                    <td>Saturday, 5 February 2022</td>
                                    <td>13:00</td>
                                </tr>
                            </tbody>
                        </table>

                        <p class="fs-5 fw-bold">Daily Activities</p>
                        <div class="accordion accordion-flush" id="accordionFlushTATRegiment">
                            <div class="accordion-item p-2 my-2 shadow">
                                <h2 class="accordion-header m-0" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Training Day (<span id="training-date-str">Date</span>)
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushTATRegiment">
                                    <div class="accordion-body">
                                        <p class="fs-2">Program Title: Here</p>

                                        <p class="fs-5">Pre-Training</p>
                                        <p>Warm-Up</p>

                                        <p class="fs-5">Mid-Training</p>
                                        <p>Activities List</p>

                                        <p class="fs-5">Post-Training</p>
                                        <p>Identification of pain on body chart - Select Areas where pain is being experienced</p>
                                        <p>Themographic Body Chart - Trainer will enter temperature data in a capturing form.</p>
                                        <div class="row">
                                            <div class="col-md">
                                                <h5>Identify Painful Areas</h5>
                                                <img src="../media/assets/body charts/muscle-men-bodies-is-part-body-vector-37707857.jpg" alt="" class="img-fluid">
                                            </div>
                                            <div class="col-md">
                                                <h5>Muscles</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item p-2 my-2 shadow">
                                <h2 class="accordion-header m-0" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                        Match Day (<span id="match-date-str">Date</span>)
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushTATRegiment">
                                    <div class="accordion-body">
                                        <p class="fs-2">Matchday: Carbohydrate Feuling Plan</p>
                                        <img src="../media/assets/body charts/carbohydrate fueling plan.jpeg" alt="carbohydrate fueling plan template" class="img-fluid mb-4">

                                        <p class="fs-5">Pre-Match</p>
                                        <p>Pe-Match warm up jog / routine / drill</p>
                                        <p class="fs-5">Mid-Match</p>
                                        <div class="row">
                                            <div class="col-md">
                                                <h5>Formation</h5>
                                                <img src="../media/assets/body charts/SoccerFieldDimensions.jpg" alt="" class="img-fluid">
                                            </div>
                                            <div class="col-md">
                                                <h5>Players</h5>
                                            </div>
                                        </div>
                                        <p class="fs-5">Post-Match</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item p-2 my-2 shadow">
                                <h2 class="accordion-header m-0" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                        Training Programs
                                    </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushTATRegiment">
                                    <div class="accordion-body">
                                        <div class="grid-container">
                                            <div class="grid-tile p-4 down-top-grad-tahiti shadow" style="border-radius: 0 0 25px 25px;">
                                                <p class="fs-2 fw-bold">Hello</p>
                                            </div>

                                            <div class="grid-tile p-4 down-top-grad-tahiti shadow" style="border-radius: 0 0 25px 25px;">
                                                <p class="fs-2 fw-bold">Hello</p>
                                            </div>

                                            <div class="grid-tile p-4 down-top-grad-tahiti shadow" style="border-radius: 0 0 25px 25px;">
                                                <p class="fs-2 fw-bold">Hello</p>
                                            </div>

                                            <div class="grid-tile p-4 down-top-grad-tahiti shadow" style="border-radius: 0 0 25px 25px;">
                                                <p class="fs-2 fw-bold">Hello</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="text-white" style="height: 5px;">
                    <h5 class="mt-4 fs-1"><span class="material-icons material-icons-round">stars</span> Challenges</h5>
                    <p>Daily Challenges</p>
                    <p>Weekly Challenges</p>
                    <p>Monthly Monthly</p>
                </div>
                <div id="TabAchievements" class="shadow w3-container w3-animate-right content-tab p-4" style="display: none">
                    <h1>Achievements</h1>
                    <hr class="text-white" />
                    <h5>Goals</h5>
                    <hr class="text-white">
                    <h5>Timeframes</h5>
                    <hr class="text-white">
                    <h5>Diary</h5>
                    <hr class="text-white">
                    <h5>Resources</h5>
                    (bookmarked resources, posts or search engine links)
                    <hr class="text-white">
                </div>
                <div id="TabMedia" class="shadow w3-container w3-animate-right content-tab p-4" style="display: none">
                    <h1>Media</h1>
                    <hr class="text-white" />
                    <p>Photos</p>
                    <div id="Users-Images">
                        <?php echo $profileUserMediaList; ?>
                    </div>
                    <p>Videos</p>
                    <p>Stream library – Live stream recording history (Community and Private)</p>
                </div>
                <div id="TabCommunication" class="shadow w3-container w3-animate-right content-tab p-4" style="display: none">
                    <h1>Communications</h1>
                    <hr class="text-white" />
                    <p>• Notifications</p>
                    <div id="communicationUserNotifications">
                        <?php echo $outputProfileUserNotifications; ?>
                    </div>
                    <p>• Latest Updates / News</p>
                    <div id="communicationNews">
                        <?php echo $outputCommunityNews; ?>
                    </div>
                    <p>• Social AdMarket</p>
                </div>
                <div id="TabSettings" class="shadow w3-container w3-animate-right content-tab p-4" style="display: none">
                    <h1>Preferences</h1>
                    <hr class="text-white" />
                    <div id="userPrefContainer">
                        <?php echo $profileUserPref; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ./ Tab Content -->
    </div>
    <!-- ./ Main Content -->

    <!-- Footer -->
    <nav class="text-white w-100 m-0 p-0 fixed-bottom navbar-stylez fitness-bg-container no-scroller" style="max-height: 100vh !important; overflow-y: auto; overflow-x: hidden">
        <!--style="position: fixed; bottom: 0; left: 0; background: #333; z-index: 10002"-->
        <div class="down-top-grad-darkz mainapp-footer px-2">

            <!-- Widgets Container -->
            <div class="collapse m-0 p-0" id="widget-rows-container">
                <div class="navbar">
                    <h1 class="text-center"><span class="material-icons material-icons-round" style="font-size: 24px !important">
                            widgets </span> Widgets</h1>

                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-toggle="collapse" data-bs-target="#widget-rows-container" aria-controls="widget-rows-container">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>


                <hr class="text-white" />

                <!-- Widget: User Profile Preview List (Widget: UPPL - It is hidden on lg screens) -->
                <div class="container comfortaa-font rounded-pillz shadow pb-4 px-0 m-0z text-white w-100 d-lg-none" style="border-radius: 25px; background-color: #343434; overflow: hidden">
                    <div class="text-center">
                        <!--<span class="material-icons material-icons-round" style="font-size: 48px !important"> account_circle </span>-->

                        <!-- Users Profile Banner -->
                        <div class="shadow-lg" style="height: 200px; width: 100%; overflow: hidden; background-image: url('../media/images/fitness/Battle-ropes-Cordes-ondulatoires-EVO-Fitness-1200x675.jpg'); background-position: center; background-attachment: local; background-clip: content-box; background-size: cover">
                        </div>
                        <!-- ./ Users Profile Banner -->

                        <!-- Profile Picture -->
                        <img src="../media/assets/One-Symbol-Logo-Two-Tone.png" alt="Onefit Logo" class="p-3 img-fluid my-pulse-animation borderz" style="margin-top: -100px; max-height: 200px; border-radius: 50%; border-color: #e88a04 !important; background-color: #343434" />
                        <!-- ./ Profile Picture -->
                        <p class="outfit-font mt-2">@Username</p>
                    </div>
                    <!--<hr class="text-white" />-->

                    <div class="row">
                        <div class="col-md">
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Thabang Mposula</div>
                                        @username<br />
                                        Lvl. 1
                                    </div>
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            verified_user </span>
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Followers</div>
                                        2 Mutual Friends<br />
                                        6 Messages
                                    </div>
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px"><span class="material-icons material-icons-round" style="font-size: 20px !important"> people_alt
                                        </span> 6</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #e88a04">Achievements</div>
                                        18 Activities Remaining<br />
                                        4 Challenges Remaining
                                    </div>
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px"><span class="material-icons material-icons-round" style="font-size: 20px !important"> emoji_events
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

                <div class="row align-items-center">
                    <div class="col-lg text-center my-4">
                        <div class="container p-4 shadow-lg d-inline-block border-start border-end" style="border-radius: 25px; border-color: #e88a04 !important; background-color: #343434">
                            <div class="row align-items-center text-center comfortaa-font">
                                <div class="col-sm py-2 d-inline">
                                    <!--<i class="fas fa-heart"></i>-->
                                    <span class="material-icons material-icons-round"> monitor_heart </span>
                                    HeartRate
                                </div>
                                <div class="col-sm py-2 d-inline"><span style="color: #e88a04">|</span></div>
                                <div class="col-sm py-2 d-inline">
                                    <!--<i class="fas fa-thermometer-half"></i>-->
                                    <span class="material-icons material-icons-round"> device_thermostat </span>
                                    Temp
                                </div>
                                <div class="col-sm py-2 d-inline">
                                    <img src="../media/assets/icons/icons8-smart-watch-50.png" alt="smartwatch" class="img-fluid my-pulse-animation" />
                                </div>
                                <div class="col-sm py-2 d-inline">
                                    <!--<i class="fas fa-bolt"></i>-->
                                    <span class="material-icons material-icons-round"> bolt </span>
                                    Speed
                                </div>
                                <div class="col-sm py-2 d-inline"><span style="color: #e88a04">|</span></div>
                                <div class="col-sm py-2 d-inline">
                                    <!--<i class="fas fa-walking"></i>-->
                                    <span class="material-icons material-icons-round"> directions_walk </span>
                                    Steps
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 text-center">
                        <div class="py-4 shadow border-start border-end" style="border-radius: 25px; border-color: #e88a04 !important; background-color: #343434">
                            <h5>One<span style="color: #e88a04">fit</span>.Muse <span class="material-icons material-icons-round">
                                    equalizer
                                </span></h5>
                            <hr class="text-white" />
                            <p class="outfit-font fw-bold">No media playing.</p>
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
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tabNavModal" hidden>Launch
        Launch #tabNavModal</button>

    <!-- >>>>>>>>>> Tab Navigation Modal -->
    <div class="modal fade" id="tabNavModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tabNavModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content feature-tab-nav-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fs-1" id="tabNavModalLabel">Menu</h5>
                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>
                <div class="modal-body bg-whitez border-0" style="overflow-x: hidden">
                    <!-- Tab Navigation Buttons Container -->
                    <div class="grid-container text-center">
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" data-bs-dismiss="modal" onclick="openLink(event, 'TabHome')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> dashboard </span>
                                    <div class="d-inline">
                                        <i class="fas fa-home"></i> Dashboard
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" data-bs-dismiss="modal" onclick="openLink(event, 'TabProfile')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> account_circle </span>
                                    Profile
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" data-bs-dismiss="modal" onclick="openLink(event, 'TabDiscovery')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> travel_explore </span>
                                    Discovery
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" data-bs-dismiss="modal" onclick="openLink(event, 'TabStudio')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> play_circle_outline </span>
                                    Onefit.Studio
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" data-bs-dismiss="modal" onclick="openLink(event, 'TabStore')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> storefront </span>
                                    Onefit.Store
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" data-bs-dismiss="modal" onclick="openLink(event, 'TabSocial')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> hub </span>
                                    Onefit.Social
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" data-bs-dismiss="modal" onclick="openLink(event, 'TabData')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> insights </span>
                                    Fitness Insights
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" data-bs-dismiss="modal" onclick="openLink(event, 'TabAchievements')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> emoji_events </span>
                                    Achievements (Private)
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" data-bs-dismiss="modal" onclick="openLink(event, 'TabMedia')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> perm_media </span>
                                    Media (Private)
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" data-bs-dismiss="modal" onclick="openLink(event, 'TabCommunication')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> forum </span>
                                    Communications
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" data-bs-dismiss="modal" onclick="openLink(event, 'TabSettings')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> settings_accessibility </span>
                                    Preferences
                                </div>
                            </button>
                        </div>
                    </div>
                    <!-- ./ Tab Navigation Buttons Container -->
                </div>
                <div class="modal-footer border-0 d-inline-block">
                    <hr class="text-white" />
                    <div class="d-grid gap-2">
                        <button class="onefit-buttons-style-dark fs-5 fw-bold my-4 px-4 pt-4 text-center comfortaa-font border-0" type="button" data-bs-toggle="collapse" data-bs-target="#tab-nav-social-quickpost" aria-expanded="false" aria-controls="tab-nav-social-quickpost"><i class="fas fa-paper-plane"></i> | <span style="color: #fff !important">One</span><span style="color: #e88a04 !important">fit</span>.Social</button>
                    </div>

                    <div class="row align-items-center collapse" id="tab-nav-social-quickpost">
                        <div class="col-sm d-grid gap-2 py-4">
                            <!-- Quick Post to Social -->
                            <div class="social-quick-post d-grid">
                                <textarea name="" class="w-100 quick-post-input" id="" cols="30" rows="3" placeholder="Share an update with the Community.">Share an update with the Community.</textarea>
                            </div>
                            <!-- ./ Quick Post to Social -->
                        </div>
                        <div class="col-sm-4 d-grid gap-2">
                            <div class="row text-center">
                                <div class="col -sm pr-0">
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
                                <div class="col -sm pl-0">
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
                    <h5 class="modal-title fs-1" id="tabLatestSocialModalLabel">Latest Updates & Socials</h5>
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
                                <div class="shadow -lg m-0" style="border-radius: 25px 25px 0 0; height: 200px; width: 100%; overflow: hidden; background-image: url('../media/images/fitness/Battle-ropes-Cordes-ondulatoires-EVO-Fitness-1200x675.jpg'); background-position: center; background-attachment: local; background-clip: content-box; background-size: cover">
                                </div>
                                <!-- ./ Users Profile Banner -->

                                <!-- Profile Picture -->
                                <img src="../media/assets/One-Symbol-Logo-Two-Tone.png" alt="Onefit Logo" class="p-3 img-fluid my-pulse-animation borderz" style="margin-top: -50px; max-height: 100px; border-radius: 50%; border-color: #e88a04 !important; background-color: #343434" />
                                <!-- ./ Profile Picture -->
                                <p class="outfit-font mt-2">@Username</p>
                            </div>
                            <!-- ./ UPPL Header (with Banner and Profile Pic) -->

                            <div class="row">
                                <div class="col-md">
                                    <ol class="list-group list-group-flush border-0 my-4">
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold" style="color: #e88a04">Thabang Mposula</div>
                                                @username<br />
                                                Lvl. 1
                                            </div>
                                            <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px">
                                                <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                                    verified_user </span>
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold" style="color: #e88a04">Followers</div>
                                                2 Mutual Friends<br />
                                                6 Messages
                                            </div>
                                            <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px"><span class="material-icons material-icons-round" style="font-size: 20px !important"> people_alt
                                                </span> 6</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold" style="color: #e88a04">Achievements</div>
                                                18 Activities Remaining<br />
                                                4 Challenges Remaining
                                            </div>
                                            <span class="badge bg-primary rounded-pillz p-4" style="background-color: #e88a04 !important; color: #343434 !important; border-radius: 25px"><span class="material-icons material-icons-round" style="font-size: 20px !important"> emoji_events
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
                                <div class="col-md text-center">
                                    <h4>Facebook Feed</h4>
                                    <div class="d-flex align-items-center">
                                        <strong>Loading...</strong>
                                        <div class="spinner-border text-light ms-auto" role="status" aria-hidden="true"></div>
                                    </div>
                                </div>
                                <div class="col-md text-center">
                                    <h4>Instagram Feed</h4>
                                    <div class="d-flex align-items-center">
                                        <strong>Loading...</strong>
                                        <div class="spinner-border text-light ms-auto" role="status" aria-hidden="true"></div>
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
                        <button class="onefit-buttons-style-dark fs-5 fw-bold my-4 px-4 pt-4 text-center comfortaa-font border-0" type="button" data-bs-toggle="collapse" data-bs-target="#tab-nav-social-quickpost" aria-expanded="false" aria-controls="tab-nav-social-quickpost"><i class="fas fa-paper-plane"></i> | <span style="color: #fff !important">One</span><span style="color: #e88a04 !important">fit</span>.Social</button>
                    </div>

                    <div class="row align-items-center collapse" id="tab-nav-social-quickpost">
                        <div class="col-sm d-grid gap-2 py-4">
                            <!-- Quick Post to Social -->
                            <div class="social-quick-post d-grid">
                                <textarea name="" class="w-100 quick-post-input" id="" cols="30" rows="3" placeholder="Share an update with the Community.">Share an update with the Community.</textarea>
                            </div>
                            <!-- ./ Quick Post to Social -->
                        </div>
                        <div class="col-sm-4 d-grid gap-2">
                            <div class="row text-center">
                                <div class="col -sm pr-0">
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
                                <div class="col -sm pl-0">
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

    <!-- ./ Modals ----------------------------------------------------------------------------------------- -->

    <script>
        function initializeContent(auth, usernm) {
            //Declaring variables
            // var contentContainer = document.getElementById("");

            if (auth = true) {
                //call all client functions
                alert("auth = true | User: " + usernm);

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
        }

        function loadUserProfile() {
            //Declaring variables
            var contentContainerProfile = document.getElementById("profile-panel-container");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                    contentContainerProfile.innerHTML = output;
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/user_profile.php", true);
            xhttp.send();
        }

        function loadUserSocials() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/", true);
            xhttp.send();
        }

        function loadUserChallenges() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/user_socials.php", true);
            xhttp.send();
        }

        function loadUserChat() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/user_chat.php", true);
            xhttp.send();
        }

        function loadUserFriends() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/user_friends.php", true);
            xhttp.send();
        }

        function loadUserGroups() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/user_groups.php", true);
            xhttp.send();
        }

        function loadUserMedia() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/user_media.php", true);
            xhttp.send();
        }

        function loadUserNotifications() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/user_notifications.php", true);
            xhttp.send();
        }

        function loadUserPref() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/user_pref.php", true);
            xhttp.send();
        }

        function loadUserSaves() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/user_saves.php", true);
            xhttp.send();
        }

        function loadUserGroups() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/userprofile/user_groups.php", true);
            xhttp.send();
        }

        function loadCommunityGroups() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_groups.php", true);
            xhttp.send();
        }

        function loadCommunityNews() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_news.php", true);
            xhttp.send();
        }

        function loadCommunityAchievements() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_achievements.php", true);
            xhttp.send();
        }

        function loadCommunityEvents() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_events.php", true);
            xhttp.send();
        }

        function loadCommunityMedia() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_media.php", true);
            xhttp.send();
        }

        function loadCommunityResources() {
            //Declaring variables
            var contentContainerResourceFeed = document.getElementById("v-pills-social-resfeed-content");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);

                    contentContainerResourceFeed.innerHTML = output;
                }
            };
            xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_news.php", true);
            xhttp.send();
        }

        function loadCommunityRewards() {
            //Declaring variables
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    alert(output);
                }
            };
            xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_rewards.php", true);
            xhttp.send();
        }

        function loadCommunityUpdates() {
            //Declaring variables
            var contentContainerCommUpdatesA = document.getElementById("homeCommunityPosts");
            var contentContainerCommUpdatesB = document.getElementById("comm-updates-search-container");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");
            //// var contentContainer = document.getElementById("");

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;
                    //alert(output);

                    contentContainerCommUpdatesA.innerHTML = output;
                    contentContainerCommUpdatesB.innerHTML = output;
                }
            };
            xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_updates.php", true);
            xhttp.send();
        }

        function openLink(evt, tabName) {
            var i, x, tablinks;
            var tabBtnIco = document.getElementById("display-current-tab-button-icon");
            var tabBtnTxt = document.getElementById("display-current-tab-button-text");

            x = document.getElementsByClassName("content-tab");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "block";

            //Change the #display-current-tab-button icon and text
            if (tabName == "TabHome") {
                tabBtnTxt.innerHTML = "Dashboard";
                tabBtnIco.innerHTML = " dashboard ";
            } else if (tabName == "TabProfile") {
                tabBtnTxt.innerHTML = "Profile";
                tabBtnIco.innerHTML = " account_circle ";
            } else if (tabName == "TabDiscovery") {
                tabBtnTxt.innerHTML = "Discovery";
                tabBtnIco.innerHTML = " travel_explore ";
            } else if (tabName == "TabStudio") {
                tabBtnTxt.innerHTML = ".Studio";
                tabBtnIco.innerHTML = " play_circle_outline ";
            } else if (tabName == "TabStore") {
                tabBtnTxt.innerHTML = ".Store";
                tabBtnIco.innerHTML = " storefront ";
            } else if (tabName == "TabSocial") {
                tabBtnTxt.innerHTML = ".Social";
                tabBtnIco.innerHTML = " hub ";
            } else if (tabName == "TabData") {
                tabBtnTxt.innerHTML = "Insights";
                tabBtnIco.innerHTML = " insights ";
            } else if (tabName == "TabAchievements") {
                tabBtnTxt.innerHTML = "Achievements";
                tabBtnIco.innerHTML = " emoji_events ";
            } else if (tabName == "TabMedia") {
                tabBtnTxt.innerHTML = "Media";
                tabBtnIco.innerHTML = " perm_media ";
            } else if (tabName == "TabCommunication") {
                tabBtnTxt.innerHTML = "Communication";
                tabBtnIco.innerHTML = " forum ";
            } else if (tabName == "TabSettings") {
                tabBtnTxt.innerHTML = "Preferences";
                tabBtnIco.innerHTML = " settings_accessibility ";
            }
        }

        function loadActivityCalender() {
            //load the activities calender
            //?month='.$prev_month.'&year='.$prev_year."'
            //get current month

            var dateNow = new Date();
            var currMonth = dateNow.getMonth();
            var currYear = dateNow.getFullYear();

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;

                    if (output.startsWith("|[System Error]|")) {
                        messengerLoader.style.display = "none";
                        //alert(output);

                        convoContainer.innerHTML = `
                <div class="application-error-msg shadow d-block" id="application-error-msg">
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
            xhttp.open("GET", "../scripts/php/calender.php?month=" + currMonth + "&year=" + currYear, true);
            xhttp.send();
        }

        //Plyr.io JS Code
        (function() {
            var video = document.querySelector('#player');

            if (Hls.isSupported()) {
                var hls = new Hls();
                hls.loadSource('https://content.jwplatform.com/manifests/vM7nH0Kl.m3u8');
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, function() {
                    video.play();
                });
            }

            plyr.setup(video);
        })();

        //get twitter trends
        /*var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
          }
        };
        xhttp.open("GET", "https://api.twitter.com/1.1/trends/place.json?id=1", true);
        xhttp.send();*/

        function socialFunctions(action, origin) {
            alert("Action: " + action + " | Origin: " + origin);
        }
    </script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>