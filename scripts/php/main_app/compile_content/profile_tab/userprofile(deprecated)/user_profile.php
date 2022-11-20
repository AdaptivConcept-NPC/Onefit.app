<?php
session_start();
require("../config.php");
// require_once("../functions.php");

//User Content Functions
// require_once("user_challenges.php");
// require_once("user_chat.php");
// require_once("user_friend.php");
// require_once("user_groups.php");
// require_once("user_media.php");
// require_once("user_notifications.php");
// require_once("user_pref.php");
// require_once("user_program_subs.php");
// require_once("user_resources.php"); 
// require_once("user_saves.php");
// require_once("user_socials.php");
// require_once("user_updates.php");

//Community Content Functions
// require_once("../main_app/community_sharing/community_achievements.php");
// require_once("../main_app/community_sharing/community_events.php");
// require_once("../main_app/community_sharing/community_groups.php");
// require_once("../main_app/community_sharing/community_media.php");
// require_once("../main_app/community_sharing/community_news.php");
// require_once("../main_app/community_sharing/community_resources.php");
// require_once("../main_app/community_sharing/community_rewards.php");
// require_once("../main_app/community_sharing/community_updates.php");

//Discovery Content Functions
// require_once("../main_app/discovery/allusers.php");
// require_once("../main_app/discovery/fitness_programs_indi.php");
// require_once("../main_app/discovery/fitness_programs_teams.php");
// require_once("../main_app/discovery/trainees.php");
// require_once("../main_app/discovery/trainers.php");

//Connection Test==============================================>
// Check connection
/*if ($dbconn->connect_error) {
      die("Connection failed: " . $dbconn->connect_error);
  }
  echo "Connected successfully";*/
if ($dbconn->connect_error) die("Fatal Error");
//end of Connection Test============================================>

//Declaring variables
$app_err_msg = "";
$accountProdImg = "";
$userProfilePanel = "";
$homeCommunityPosts = "";
$homeCommunityResources = "";
$profileUserSubsGroupsList = "";
$profileUsersPostsList = "";
$profileUsersResourcesList = "";
$profileUsersProgramsList = "";
$profileUserFriendsList = "";
$profileUsersFavesList = "";
$profileUserMediaList = "";
$socialItems = "";
$userSocialItems = "";
$discoverPeopleList = "";
$usr_profilepicurl = "";
$discoverPostsList = '<div class="text-center" style="margin-top: 25vh"><h4><i class="fas fa-search"></i>Type on the search bar to see some posts</h4></div>';
$discoverGroupsList = "";
$discoverResourcesList = "";
$discoverProgramsList = "";
$activitiesTrainersList = "";
$communicationUserNotifications = "";
$communicationNews = "";
$communicationUserMessages = "";
$output = "";

if (isset($_SESSION["currentUserAuth"])) {
  if ($_SESSION["currentUserAuth"] == true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn, $_SESSION["currentUserAuth"]);

    //Load the user profile information
    $sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username WHERE u.username = '$currentUser_Usrnm';";
    //SELECT `social_network`, `link` FROM `user_socials` WHERE `username` = ''

    if ($result = mysqli_query($dbconn, $sql)) {

      while ($row = mysqli_fetch_assoc($result)) {
        //u.user_id, u.username, u.user_name, u.user_surname, u.id_number, u.user_email, u.contact_number, u.date_of_birth, u.user_gender, u.user_race, u.user_nationality, u.account_active
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

      //get the other profile details
      $socialItems = getUserSocials();
      $profileUserSubsGroupsList = getUserGroups();
      $profileUsersPostsList = getUserUpdates();
      $profileUsersResourcesList = getUserResources();
      $profileUsersProgramsList = getUserProgSubs();
      $profileUserFriendsList = getUserFriends();
      $profileUsersFavesList = getUserSaves();
      $profileUserMediaList = getUserMedia();

      //echo $discoverPeopleList;
      //die();

      if ($usr_verification == true) {
        $verifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user</span>';
      } else {
        $verifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> groups</span>';
      }
      //<<<_END 
      $output =  "<!-- Profile Tab: User Profile -->
          <div class='container comfortaa-font rounded-pillz shadow pb-4 px-0 m-0z text-white w-100'
            style='border-radius: 25px; background-color: #343434; overflow: hidden'>
            <div class='text-center'>
              <!--<span class='material-icons material-icons-round' style='font-size: 48px !important'> account_circle </span>-->

              <!-- Users Profile Banner -->
              <div class='shadow-lg'
                style='height: 400px; width: 100%; overflow: hidden; background-image: url('../media/images/fitness/Battle-ropes-Cordes-ondulatoires-EVO-Fitness-1200x675.jpg'); background-position: center; background-attachment: local; background-clip: content-box; background-size: cover'>
              </div>
              <!-- ./ Users Profile Banner -->

              <!-- Profile Picture -->
                $accountProdImg
              <!-- ./ Profile Picture -->
              <p class='poppins-font mt-2 username-tag'>@$currentUser_Usrnm</p>
            </div>
            <!--<hr class='text-white' />-->
            <ol class='list-group list-group-numberedz list-group-flush'>
              <li class='list-group-item d-flex justify-content-between align-items-start bg-transparent text-white'>
                <div class='ms-2 me-auto'>
                  <div class='fw-bold users-name-tag' style='color: #ffa500'>$usrprof_name $usrprof_surnames</div>
                  <span class='username-tag'>@$currentUser_Usrnm</span><br />
                  Lvl. 1
                </div>
                <span class='badge bg-primary rounded-pillz p-4'
                  style='background-color: #ffa500 !important; color: #333 !important; border-radius: 25px'>
                  $verifIcon
                </span>
              </li>
              <li class='list-group-item d-flex justify-content-between align-items-start bg-transparent text-white'>
                <div class='ms-2 me-auto'>
                  <div class='fw-bold' style='color: #ffa500'>Followers</div>
                  <span>2 Mutual Friends</span><br />
                  <span>6 Messages</span>
                </div>
                <span class='badge bg-primary rounded-pillz p-4'
                  style='background-color: #ffa500 !important; color: #fff !important; border-radius: 25px'>
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
                <span class='badge bg-primary rounded-pillz p-4'
                  style='background-color: #ffa500 !important; color: #fff !important; border-radius: 25px'>
                  <span class='material-icons material-icons-round' style='font-size: 20px !important'> emoji_events </span> 
                  <span>3</span>
                </span>
              </li>
            </ol>

            <!--Users Social Media Links-->
            <div id='userSocialItems'>$socialItems</div>

            <div class='row my-4'>
              <div class='col-md p-4'>
                <h5 class='fs-1'>Updates</h5>
                <div id='profileUsersPostsList' style='max-height: 100vh, overflow-y: auto;'>$profileUsersPostsList</div>
              </div>
              <div class='col-md-4 p-4'>
                <h5 class='fs-1'>Media</h5>
                <div id='profileUserMediaList'>$profileUserMediaList</div>
                <hr class='text-white' style='height: 5px;'>
                <h5 class='fs-1'>Resources</h5>
                <div id='profileUsersResourcesList'>$profileUsersResourcesList</div>
                <hr class='text-white' style='height: 5px;'>
                <h5 class='fs-1'>Friends</h5>
                <div id='profileUserFriendsList'>$profileUserFriendsList</div>
                <hr class='text-white' style='height: 5px;'>
                <h5 class='fs-1'>Followers</h5>
                <hr class='text-white' style='height: 5px;'>
                <h5 class='fs-1'>Following</h5>
                <hr class='text-white' style='height: 5px;'>
                <h5 class='fs-1'>Programs</h5>
                <div id='profileUsersProgramsList'>$profileUsersProgramsList</div>
                <hr class='text-white' style='height: 5px;'>
                <h5 class='fs-1'>Saved</h5>
                <div id='profileUsersFavesList'>$profileUsersFavesList</div>
                <hr class='text-white' style='height: 5px;'>
                <h5 class='fs-1'>Groups</h5>
                <div id='profileUserSubsGroupsList'>$profileUserSubsGroupsList</div>
              </div>
            </div>
          </div>
          <!-- ./ Profile Tab: User Profile -->";
      //_END;
      echo $output;
    } else {
      $output = "|[System Error]|:. [Profile load (Account details) - " . mysqli_error($dbconn) . "]";
      $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
      //exit();
    }
  }
}

//functions
