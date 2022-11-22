<?php
session_start();
include("../scripts/config.php");

//Connection Test==============================================>
// Check connection
/*if ($db->connect_error) {
            die("<div class='p-4 alert alert-danger'>Connection failed: " . $db->connect_error) . "</div>";
        }
        echo "Connected successfully";
        die();*/
//end of Connection Test============================================>

//Declaring variables
$myusername = mysqli_real_escape_string($db, $_GET['usr']);

$app_err_msg = "";
$accountProdImg = "";

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
$discoverPostsList = '<div class="text-center" style="margin-top: 25vh"><h4><i class="fas fa-search"></i>Type on the search bar to see some posts</h4></div>';
$discoverGroupsList = "";
$discoverResourcesList = "";
$discoverProgramsList = "";

$activitiesTrainersList = "";

$communicationUserNotifications = "";
$communicationNews = "";
$communicationUserMessages = "";

//Load the user profile information
$sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username WHERE u.username = '$myusername';";
//SELECT `social_network`, `link` FROM `user_socials` WHERE `username` = ''

if ($result = mysqli_query($db, $sql)) {

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

  if ($usr_profilepicurl == "default") {
    $accountProdImg = '<img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">';
  } else if ($usr_profilepicurl == "") {
    $accountProdImg = '<img src="../media/assets/One-Symbol-Logo-Black.svg" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">';
  } else {
    $accountProdImg = '<img src="../media/profiles/' . $myusername . '/' . $usr_profilepicurl . '" class="img-fluid" style="border-radius: 25px 25px 25px 0; border-left: #ffa500 solid 5px; border-bottom: #ffa500 solid 5px" alt="' . $myusername . ' profile picture">';
  }
  //echo $discoverPeopleList;
  //die();
} else {
  $output = "|[System Error]|:. [Profile load (Account details) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//get the social details
$sql = "SELECT social_network, handle, link FROM user_socials WHERE username = '$myusername'";

if ($result = mysqli_query($db, $sql)) {

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

    $socialItems .= '<li class="list-group-item text-center text-dark bg-transparent rounded-pill shadow my-2 mx-1 social-link"><span class="p-2 mr-2 bg-warning" style="border-radius: 5px">' . $socialNetworkIcon . '</span><a href="' . $usr_sociallink . '">' . $usr_socialhandle . '</a></li>';
  }
  //echo $discoverPeopleList;
  //die();

  $userSocialItems = '<ul class="list-group list-group-horizontal-sm justify-content-center p-2 shadow" style="border-radius: 25px; background: #333">' . $socialItems . '</ul>';
} else {
  $output = "|[System Error]|:. [Profile load (Social details) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//loading: Home tab
//latest (community post, program, group post (for each group that the user is a member of),
//overdue and pending activities,etc)

//fitness resources (latest 50 resources)
$sql = "SELECT * FROM community_resources";

if ($result = mysqli_query($db, $sql)) {

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

    $homeCommunityResources .= '
          <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="resource-' . $resourceid . '-' . $sharedbyUsername . '">
            <div class="row align-items-center">
              <div class="col-md-4 text-center">
                <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
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
  $discoverResourcesList = $homeCommunityResources;
} else {
  $output = "|[System Error]|:. [Home load (Community resources) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//community posts (latest 50 posts)
$sql = "SELECT * FROM community_posts cp INNER JOIN users u ON cp.username = u.username;";

if ($result = mysqli_query($db, $sql)) {

  while ($row = mysqli_fetch_assoc($result)) {
    //`post_id`, `post_date`, `post_message`, `username`, `modified_date`, `favourite_ref`FROM `community_posts` WHERE 
    $commpost_postid = $row["post_id"];
    $commpost_postdate = $row["post_date"];
    $commpost_message = $row["post_message"];
    $commpost_user = $row["username"];
    $commpost_faveref = $row["favourite_ref"];

    $commpost_usr_name = $row["user_name"];
    $commpost_usr_surname = $row["user_surname"];

    $homeCommunityPosts .= '
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="post-' . $commpost_postid . '-' . $commpost_user . '">
              <div class="row align-items-center p-2">
                <div class="col-md-4 text-center">
                  ' . $accountProdImg . '
                </div>
                <div class="col-md-8">
                  <h3>' . $commpost_usr_name . ' ' . $commpost_usr_surname . ' <span style="font-size: 10px">@<span style="color: #ffa500">' . $commpost_user . '</span></span></h3>
                </div>
              </div>
              <div class="post-content">
                <hr class="bg-white">

                <p class="my-2 text-wrap">' . $commpost_message . '</p>
                <p class="text-right" style="font-size: 8px">' . $commpost_postdate . '</p>

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
} else {
  $output = "|[System Error]|:. [Home load (Community posts) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//=====================================================================================>

//loading: Dashboard

//=====================================================================================>

//loading: Profile

//community and resource shares (latest 50 posts each)
$sql = "SELECT * FROM community_resources cr INNER JOIN users u ON cr.shared_by = u.username WHERE cr.shared_by = '$myusername';";

if ($result = mysqli_query($db, $sql)) {

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
      $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openExtLink(' . "'" . $usrresources_link . "'" . ')"><i class="fas fa-link"></i> Follow link</button>';
    } else if ($usrresources_type == "profile link") {
      $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'profile'" . ')"><i class="fas fa-id-badge"></i> View profile</button>';
    } else if ($usrresources_type == "post link") {
      $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'post'" . ')"><i class="fas fa-sticky-note"></i> Open post</button>';
    } else if ($usrresources_type == "document link") {
      $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'document'" . ')"><i class="fas fa-file-alt"></i> View document</button>';
    } else if ($usrresources_type == "media link") {
      $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'media'" . ')"><i class="fas fa-photo-video"></i> View media</button>';
    }

    $profileUsersResourcesList .= '
          <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="resource-' . $usrresources_resourceid . '-' . $myusername . '" style="max-width: 100%!important">
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
} else {
  $output = "|[System Error]|:. [Profile load (Users posts) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

$sql = "SELECT * FROM community_posts cp INNER JOIN users u ON cp.username = u.username WHERE cp.username = '$myusername';";

if ($result = mysqli_query($db, $sql)) {

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
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="post-' . $usrposts_postid . '-' . $usrposts_user . '">
              <div class="row align-items-center p-2">
                <div class="col-md-4 text-center">
                  ' . $accountProdImg . '
                </div>
                <div class="col-md-8">
                  <h3>' . $usrposts_name . ' ' . $usrposts_surname . ' <span style="font-size: 10px">@<span style="color: #ffa500">' . $usrposts_user . '</span></span></h3>
                </div>
              </div>
              <div class="post-content">
                <hr class="bg-white">

                <p class="my-2">' . $usrposts_message . '</p>
                <p class="text-right" style="font-size: 8px">' . $usrposts_postdate . '</p>

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
} else {
  $output = "|[System Error]|:. [Profile load (Users posts) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//users media items
//Get a list of file paths using the glob function.
$fileList = glob("../media/profiles/$myusername/*");

//Loop through the array that glob returned.
foreach ($fileList as $filename) {
  //Simply print them out onto the screen.
  //echo $filename, '<br>'; 
  $profileUserMediaList .= '
       <div class="grid-tile p-0 mx-0 content-panel-border-style my-4 center-container" style="overflow: hidden; max-height: 200px">
        <img src="' . $filename . '" class="img-fluidz" alt="media image" style="height: 100%">
       </div>';
}

//subscriptions (programs)
//$sql = "SELECT * FROM training_programs;";
$sql = "SELECT ps.prog_subscriber_id, ps.username, ps.program_ref_code, ps.subscribe_date, tp.program_id, tp.program_title, tp.program_description, tp.program_duration, tp.program_category, tp.program_privacy, tp.created_by, tp.active 
    FROM program_subscribers ps 
    INNER JOIN training_programs tp ON ps.program_ref_code = tp.program_ref_code 
    WHERE username = '$myusername'";

if ($result = mysqli_query($db, $sql)) {
  while ($row = mysqli_fetch_assoc($result)) {
    //TP: `program_id`, `program_ref_code`, `program_title`, `program_description`, `program_duration`, `program_category`, `program_privacy`, `created_by`, `creation_date`, `active` 
    //PA: `prog_activity_id`, `activity_title`, `activity_description`, `activity_duration`, `activity_reps`, `activity_sets`, `achievement_id`, `program_ref_code`
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
} else {
  $output = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//Favourites
$sql = "SELECT * FROM ((fave_saves fs
    INNER JOIN users u ON fs.username = u.username) 
    INNER JOIN community_posts cp ON fs.fave_ref = cp.favourite_ref)
    WHERE fs.username = '$myusername';";

if ($result = mysqli_query($db, $sql)) {
  while ($row = mysqli_fetch_assoc($result)) {
    //``, ``, ``, ``
    //``, ``, ``, ``, ``, ``
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
              <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
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
} else {
  $output = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
}

//users friends list
$sql = "SELECT * FROM friends f INNER JOIN users u ON f.friend_username = u.username WHERE f.username = '$myusername' AND f.friendship_status = 1";

if ($result = mysqli_query($db, $sql)) {

  while ($row = mysqli_fetch_assoc($result)) {
    $friendid = $row["friend_username"];
    $friendUsername = $row["friend_username"];

    $friendName = $row["user_name"];
    $friendSurname = $row["user_surname"];

    $profileUserFriendsList .= '
          <div class="grid-tile px-2 mx-0 container-fluid content-panel-border-style my-4" id="friend-' . $friendid . '-' . $friendUsername . '">
            <div class="row align-items-center">
              <div class="col-lg-2 text-center">
                <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
              </div>
              <div class="col-lg-6 text-center">
                <h3>' . $friendName . ' ' . $friendSurname . ' <span style="font-size: 10px">@' . $friendUsername . '</span></h3>
              </div>
              <div class="col-lg-4 text-center">
                <button class="null-btn shadow" onclick="openProfiler(' . "'" . $friendUsername . "'" . ')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
              </div>
            </div>
          </div>';
  }
} else {
  $output = "|[System Error]|:. [Profile load (Users friends) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//groups that the user is a member of
$sql = "SELECT * FROM groups g INNER JOIN group_members gm ON  g.group_ref_code = gm.group_ref_code WHERE gm.username = '$myusername';"; //

$groupMemsArray = array();
$foundGroup = false;

if ($result = mysqli_query($db, $sql)) {

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
                <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
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
} else {
  $output = "|[System Error]|:. [Profile load (Users groups) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//=====================================================================================>

//loading: Discover (load max of 50 records)
//People
$sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username;";

if ($result = mysqli_query($db, $sql)) {

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
                  <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
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

    //compile list of trainers
    if ($usrs_prof_acctype == "trainer") {
      $activitiesTrainersList .= '
              <div class="grid-tile px-2 mx-0 container content-panel-border-style my-4" id="discover_people-' . $usrs_userid . '-' . $usrs_username . '">
                <div class="card bg-transparent align-items-center">
                  <div class="text-center">
                    <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
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
} else {
  $output = "|[System Error]|:. [Discover load (All People) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//Posts (no query for this, it will only be done once the user performs a search)

//groups
$sql = "SELECT * FROM groups";

if ($result = mysqli_query($db, $sql)) {

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
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="discover_groups-' . $grps_groupid . '-' . $grps_refcode . '">
              <div class="row align-items-center">
                <div class="col-md -4 text-center">
                  <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
                </div>
                <div class="col-md -8">
                  <h3>' . $grps_name . ' <span style="font-size: 10px">' . $grps_privacy . '</span></h3>
                  <p><span style="color: #ffa500">' . $grps_description . '</span></p>
                  <p>' . $grps_category . '</p>
                  <button class="null-btn shadow mt-4" onclick="openGroup(' . "'" . $grps_refcode . "'" . ')"><i class="fas fa-chevron-circle-right"></i> Open group</button>
                  <p class="text-right" style="font-size: 8px">' . $grps_createdate . '</p>
                </div>
              </div>
            </div>';
  }
  //echo $discoverPeopleList;
  //die();
} else {
  $output = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//Programs
//$sql = "SELECT * FROM training_programs tp INNER JOIN program_activities pa ON tp.program_ref_code = pa.program_ref_code;";
$sql = "SELECT * FROM training_programs;";

if ($result = mysqli_query($db, $sql)) {
  while ($row = mysqli_fetch_assoc($result)) {
    //TP: `program_id`, `program_ref_code`, `program_title`, `program_description`, `program_duration`, `program_category`, `program_privacy`, `created_by`, `creation_date`, `active` 
    //PA: `prog_activity_id`, `activity_title`, `activity_description`, `activity_duration`, `activity_reps`, `activity_sets`, `achievement_id`, `program_ref_code`
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

    $discoverProgramsList .= '
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
} else {
  $output = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//=====================================================================================>

//loading: Activities
//community pposts (latest 50 posts)

//fitness programs (all)

//trainers (max 50)

//gym assist (all)

//=====================================================================================>








//=====================================================================================>
//loading: Communication
//notifications
$sql = "SELECT * FROM notifications WHERE notify_user = '$myusername' ORDER BY created_by DESC";

if ($result = mysqli_query($db, $sql)) {

  while ($row = mysqli_fetch_assoc($result)) {
    //`notification_id`, `notification_title`, `notification_message`, `notify_user`, `created_by`, `notification_date`, `notification_read`

    $notif_id = $row["notification_id"];
    $notif_title = $row["notification_title"];
    $notif_message = $row["notification_message"];
    $notif_date = $row["notification_date"];

    $communicationUserNotifications .= '
          <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="notifcation-' . $notif_id . '">
            <h3>' . $notif_title . '</h3>
            <p><span style="color: #ffa500">' . $notif_message . '</span></p>
            <p>' . $grps_category . '</p>
            <p class="text-right" style="font-size: 8px">' . $notif_date . '</p>
          </div>
          ';
  }
} else {
  $output = "|[System Error]|:. [Communications load (User notifications) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//news
$sql = "SELECT * FROM news n INNER JOIN users u ON n.created_by = u.username ORDER BY n.creation_date DESC";

if ($result = mysqli_query($db, $sql)) {

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
} else {
  $output = "|[System Error]|:. [Communications load (User notifications) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}

//messages
//$sql = "SELECT * FROM messages msg INNER JOIN users u ON msg.receiver = u.username WHERE msg.sender = '$myusername';";
/*$sql = "SELECT * FROM ((user_conversations uc 
    INNER JOIN users u ON uc.secondary_user = u.username) 
    INNER JOIN user_conversation_messages ucm  ON ucm.conversation_id = uc.conversation_id) 
    WHERE uc.primary_user = '$myusername' ORDER BY ucm.send_date DESC LIMIT 1;";*/
$sql = "SELECT * FROM user_conversations uc 
    INNER JOIN users u ON uc.secondary_user = u.username
    WHERE uc.primary_user = '$myusername' ORDER BY uc.conversation_id DESC;";

//LEFT OUTER JOIN user_conversation_messages ucm  ON ucm.conversation_id = uc.conversation_id) 

if ($result = mysqli_query($db, $sql)) {

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
                <button class="null-btn text-white shadow btn-block" onclick="openMessenger(' . "'" . $convo_conversationid . "'" . ', ' . "'" . $myusername . "'" . ', ' . "'" . $convo_secondaryuser . "'" . ')" style="font-size: large"><i class="fas fa-chevron-right"></i></button>
              </div>
            </div>
          </li>';
  }
} else {
  $output = "|[System Error]|:. [Communications load (User conversations list) - " . mysqli_error($db) . "]";
  $app_err_msg = '<div class="application-error-msg shadow d-block" id="application-error-msg"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $myusername . "'" . ',' . "'" . $output . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output . '</div></div>';
  //exit();
}


/////////////////////////////////////////////////////////////////////////////////////////
//Form Post Section
/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //locally assign values to variables
        //$var = mysqli_real_escape_string($db,$_POST['param']);
      
      }*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />
  <!--fontawesome-->
  <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

  <link rel="stylesheet" href="../css/styles_depracated.css" />

  <title>onefit&trade; &copy; 2021 AdaptivConcept</title>

  <style>
    .nav-pills .nav-link {
      border-radius: 25px 25px 25px 0 !important;
      /*0.25rem*/
    }

    .btn-link {
      font-weight: 400;
      color: #ffa500 !important;
      text-decoration: none;
    }

    .btn.focus,
    .btn:focus {
      outline: 0 !important;
      box-shadow: 0 !important;
    }

    .messenger-side-panel {
      position: fixed;
      top: 0;
      right: 0;
      width: 0;
      height: 100vh !important;
      color: #fff;
      /*border-left: #ffa500 solid 5px;*/
      margin: 0;
      padding: 0;
      z-index: 1032;

      transition: 0.3s;
    }

    .header {
      height: 10vh;
      width: 100%;
      padding: 0 20px;
    }

    .conversation-container {
      height: 60vh;
      width: 100%;
      overflow-y: ;
      overflow-x: hidden;

    }

    .extras-function-container {
      height: 10vh;
      width: 100%;
      padding: 0 20px;
      z-index: 1033;
      overflow-x: hidden !important;
    }

    .input-function-container {
      height: 20vh;
      width: 100%;
      overflow-y: visible;
      overflow-x: hidden;
      z-index: 1033;
    }

    .input-function-container textarea {
      border-radius: 25px 25px 0 25px;
      border-right: #ffa500 solid 5px;
      border-bottom: #ffa500 solid 5px;
      border-left: 0;
      border-top: 0;
      padding: 10px;
      color: #333;
      width: 100%;
    }

    /*fitblog*/
    .fitblog-post-designer-panel {
      position: fixed;
      top: 0;
      width: 100%;
      height: 100%;
      background: #333;
      color: #fff;
      display: none;
      z-index: 1100;
    }

    .fitblog-designer-preview-window {
      border-radius: 25px;
      height: 100%;
      width: 100%;
      border-left: #ffa500 solid 5px;
      border-right: #ffa500 solid 5px;
      overflow-y: auto;
      overflow-x: hidden;
      z-index: 1101;
    }

    .fitblog-designer-tools-panel {
      /*position: absolute;
        left: 0;
        top: 50%;
        height: 50vh;*/
      /*margin-top: -20%;*/
      margin-left: 0px;
      /*-236.46px*/
      background: #ffa500;
      color: #333;
      border-radius: 25px;
      border-right: #fff solid 5px;
      z-index: 1104;
      transition: 0.3s;
      width: 100%;
      font-size: 10px
    }

    .fitblog-designer-tools-panel:hover {
      margin-left: 0;
    }

    .item-heading {
      cursor: pointer;
    }

    .section-card-white {
      border-radius: 25px;
      color: #333;
      background: #fff;
      border-left: #333 solid 5px;
      border-bottom: #333 solid 5px;
    }

    .section-card-dark {
      border-radius: 25px;
      color: #fff;
      background: #333;
    }

    .section-card-orange {
      border-radius: 25px;
      color: #333;
      background: #ffa500;
    }

    .social-link a {
      color: #fff !important;
      font-size: 10px;
    }

    /* On smaller screens, where width is less than 450px, change the style of the messenger side panel (and a smaller font size) */
    @media screen and (max-width: 450px) {
      .messenger-side-panel {
        /*width: 100%;*/
        font-size: 10px !important;
      }

      .messenger-side-panel h3 {
        font-size: 15px !important;
      }

      .fitblog-designer-tools-panel {
        margin-top: -25%;
      }
    }

    /*set designer .row-col container heights*/
    @media screen and (max-width: 767px) {
      .fitblog-designer-post-items-container {
        height: 50% !important;
      }

      .fitblog-designer-preview-window-container {
        height: 50% !important;
      }
    }
  </style>
</head>

<body style="height: 100vh !important">
  <!--
    Application error message
    <div class="application-error-msg shadow">
      <div>
        <h3 style="color: red">An error has occured</h3>

      </div>
    </div>-->
  <?php if ($app_err_msg != "") {
    echo $app_err_msg;
  } ?>

  <div class="new-item-button  py-3 pl-3 shadow-lg">
    <div class="row align-items-center">
      <div class="col text-center p-0">
        <i class="fas fa-fingerprint" style="font-sizez: 10px;transform: rotate(-90deg);"></i>
        <i class="fas fa-bars"></i>
      </div>
      <div class="col text-center p-0">
        <button class="d-inline menu-toggle p-3" style="border-bottom-right-radius: 0px" type="button" data-toggle="modal" data-target="#createModal">
          <img src="../media/assets/icons/icons8-create-50.png" class="img-fluid d-block" alt="create button">
          <p class="m-0" style="font-size: 10px">create</p>
        </button>
      </div>
    </div>
  </div>

  <!--create modal-->
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content content-panel-border-style" style="border-radius: 25px !important; background: #333">
        <div class="modal-header border-0">
          <h5 class="modal-title text-center" id="navigationModalLabel" style="color: #ffa500"><span><img src="../media/assets/icons/icons8-create-50-White.png" class="img-fluid" style="max-height: 30px;" alt="create icon"></span> | Create</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-0">
          <hr class="bg-white m-0" />
          <div class="row align-items-center py-4">
            <div class="col-lg-4 border-right border-white">
              <!--<ul class="list-group">
                  <li class="list-group-item bg-transparent border-0 navigation-item" id="nav-to-about" style="cursor: pointer">New post</li>
                  <li class="list-group-item bg-transparent border-0 navigation-item" id="nav-to-services" style="cursor: pointer">Share resource</li>
                  <li class="list-group-item bg-transparent border-0 navigation-item" id="nav-to-register" style="cursor: pointer">Start a chat</li>
                  <li class="list-group-item bg-transparent border-0 navigation-item" id="nav-to-contact" style="cursor: pointer">Post to <span style="color: #ffa500">fit</span>blog</li>
                  <li class="list-group-item bg-transparent border-0 navigation-item" id="nav-to-forgotpwd" style="cursor: pointer">Post to group</li>
                </ul>-->

              <div class="nav flex-column nav-pills" id="v-create-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link text-truncate active" style="color: #fff; font-size: 20px" id="v-create-nw-post-tab" data-toggle="pill" href="#v-pills-nw-post-home" role="tab" aria-controls="v-pills-nw-post-home" aria-selected="true">
                  <div class="px-4 text-center h-100" style="width: 100%; border-radius: 50rem 0; background: #333; border-bottom: #fff solid 5px;">New post</div>
                </a>
                <a class="nav-link text-truncate" style="color: #fff; font-size: 20px" id="v-create-nw-resource-tab" data-toggle="pill" href="#v-pills-nw-resource" role="tab" aria-controls="v-pills-nw-resource" aria-selected="false">
                  <div class="px-4 text-center h-100" style="width: 100%; border-radius: 50rem 0; background: #333; border-bottom: #fff solid 5px;">Share resource</div>
                </a>
                <a class="nav-link text-truncate" style="color: #fff; font-size: 20px" id="v-create-nw-chat-tab" data-toggle="pill" href="#v-pills-nw-chat" role="tab" aria-controls="v-pills-nw-chat" aria-selected="false">
                  <div class="px-4 text-center h-100" style="width: 100%; border-radius: 50rem 0; background: #333; border-bottom: #fff solid 5px;">Start a chat</div>
                </a>
                <a class="nav-link text-truncate" style="color: #fff; font-size: 20px" id="v-create-nw-fitblogpost-tab" onclick="openFitblogDesigner()" data-toggle="pill" href="#v-pills-nw-fitblogpost" role="tab" aria-controls="v-pills-nw-fitblogpost" aria-selected="false">
                  <div class="px-4 text-center h-100" style="width: 100%; border-radius: 50rem 0; background: #333; border-bottom: #fff solid 5px;"><span style="color: #ffa500; -webkit-text-strokez: 0.5px #333;">fit</span>blog Article</div>
                </a>
                <a class="nav-link text-truncate" style="color: #fff; font-size: 20px" id="v-create-nw-grouppost-tab" data-toggle="pill" href="#v-pills-nw-grouppost" role="tab" aria-controls="v-pills-nw-grouppost" aria-selected="false">
                  <div class="px-4 text-center h-100" style="width: 100%; border-radius: 50rem 0; background: #333; border-bottom: #fff solid 5px;">Post to group</div>
                </a>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="tab-content" id="v-create-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-nw-post-home" role="tabpanel" aria-labelledby="v-create-nw-post-tab">
                  <div class="text-center">
                    <textarea class="onefit-inputs-style" style="border-radius: 25px; border: 0; padding: 10px; min-height: 300px" rows="10" placeholder="What's new about you?"></textarea>
                  </div>
                  <div class="text-right">
                    <button type="button" class="onefit-buttons-style p-3"><i class="fas fa-paper-plane"></i> Post</button>
                  </div>
                </div>
                <div class="tab-pane fade" id="v-pills-nw-resource" role="tabpanel" aria-labelledby="v-create-nw-resource-tab">...</div>
                <div class="tab-pane fade" id="v-pills-nw-chat" role="tabpanel" aria-labelledby="v-create-nw-chat-tab">...</div>
                <div class="tab-pane fade" id="v-pills-nw-fitblogpost" role="tabpanel" aria-labelledby="v-create-nw-fitblogpost-tab">
                  <div class="d-flex align-items-center m-4" id="post-designer-active">
                    <strong style="color: #ffa500"><i class="fas fa-paint-brush"></i>Designer</strong>
                    <div class="spinner-border text-light ml-auto" role="status" aria-hidden="true"></div>
                  </div>
                </div>
                <div class="tab-pane fade" id="v-pills-nw-grouppost" role="tabpanel" aria-labelledby="v-create-nw-grouppost-tab">
                  <div class="container my-2">
                    <div class="row">
                      <div class="col-lg-4">
                        <h5 class="text-truncate"><i class="fas fa-users"></i> | My Groups</h5>
                      </div>
                      <div class="col-lg-8 border-left border-white">

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer border-0">
          <button type="button" class="onefit-buttons-style p-4" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!--Messenger side panel - right align-->
  <div class="messenger-side-panel tunnel-bg-white shadow-lg" id="messenger-side-panel">
    <div class="header py-0" style="color: #fff; background: #333">

      <div class="container-fluid h-100">
        <div class="row align-items-center h-100">
          <div class="col">
            <button type="button" class="onefit-buttons-style p-2" onclick="closeMessenger()" id="messenger-back-btn"><i class="fas fa-arrow-left"></i> Back</button>
          </div>
          <div class="col text-right">
            <h3><i class="fas fa-comments"></i> | <span style="color: #ffa500">Messenger</span></h3>
            <div style="visibility: visible;" id="conversation-id"></div>
            <div style="visibility: visible;" id="sndr-username"></div>
            <div style="visibility: visible;" id="rcvr-username"></div>
          </div>
        </div>
      </div>

    </div>

    <div class="conversation-container dark-grad-fade-panel">
      <div class="d-flex align-items-center m-4" id="messenger-loader" style="display: none">
        <strong style="color: #ffa500" id="messenger-loader-action">Loading...</strong>
        <div class="spinner-border text-light ml-auto" role="status" aria-hidden="true"></div>
      </div>
      <div id="conversation-container"></div>
    </div>

    <div class="container-fluid input-function-container py-4">
      <div class="row align-items-center h-100z" style="position: absolute; bottom: 52px; width: 100%">
        <div class="col-lg-10 p-1">
          <textarea type="text" id="draft-conversation-msg-input" class="mx-1" row="6" placeholder="Message"></textarea>
        </div>
        <div class="col-lg-2 p-1 text-center">
          <button type="button" class="onefit-buttons-style p-3" id="send-message-btn" onclick="sendConversationMessage()"><i class="fas fa-paper-plane"></i> Send</button>
        </div>
      </div>
    </div>

    <div class="extras-function-container px-0">
      <ul class="list-group list-group-horizontal -lg align-items-centerz justify-content-endz bg-transparent" id="extras-buttons" style="position: absolute; bottom: 0px; width: 100%; displayz: none">
        <li class="list-group-item h-100 border-0 py-2 mx-0" style="background: #333!important; border-top-left-radius: 0px!important; border-bottom-left-radius: 0px!important"><i class="fas fa-ellipsis-h"></i></li>
        <li class="list-group-item h-100 border-0 py-2 mx-0" style="background: #333!important;"><i class="fas fa-paperclip"></i></li>
        <li class="list-group-item h-100 border-0 py-2 mx-0" style="background: #333!important; border-top-right-radius: 25px!important; border-bottom-right-radius: 0px!important"><i class="fas fa-share-square"></i></li>
      </ul>
    </div>
  </div>

  <!--fitblog post designer-->
  <div class="fitblog-post-designer-panel p-0" id="fitblog-post-designer">
    <div class="row h-100">
      <div class="col-md mx-2 fitblog-designer-preview-window-container fitness-bgz bg-dark py-4" style="overflow-y: auto; border-radius: 25px;height: 100%;">
        <!-- -->

        <div class="fitblog-designer-preview-window tunnel-bgz no-scroller shadow">
          <div class="text-center mt-4 p-2" id="main-item-heading-1-content-card">
            <!--<div class="center-container mb-2"></div>-->
            <div class="container-fluid" style="background: rgba(255,165,0,0.9);rgba(255,255,255,0.9);rgba(51,51,51, 0.7); border-radius: 25px; border-bottom: #333 solid 10px; border-left: #333 solid 10px;">
              <div class="row align-items-center">
                <div class="col-md">
                  <h1 class="p-4 text-dark" style="">Physical Heat Sync Training (A brand new concept for heat treatment)</h1>
                </div>
                <div class="col-md" style="border-radius: 25px">
                  <img src="../media/images/fitness/8.jpg" class="img-fluid shadow-lg" style="border-radius: 15px" alt="placeholder">
                </div>
              </div>
            </div>

            <div class="row align-items-center text-left mb-4">
              <div class="col-sm-2">
                <div class="center-container profile-img-container text-center d-inline" style="max-height: 100px!important;max-width: 100px!important">
                  <img src="../media/images/fitness/photo-1574680096145-d05b474e2155.jpg" class="" id="" alt="" />
                </div>
              </div>
              <div class="col-sm">
                <p class="d-inline">by Thabang Mposula <span style="color: #ffa500; font-size: 10px">@system_tmp</span></p>
                <hr class="bg-white m-0 p-0">
                <p class="text-truncate"><i class="fas fa-quote-left"></i> <?php echo $usr_about; ?> <i class="fas fa-quote-right"></i></p>
              </div>
              <div class="col-sm text-right">
                <p class="d-inline py-1 px-2 bg-dark" style="font-size: 10px; color: #fff; border-radius: 50rem 50rem 0 50rem; border-right: #ffa500 solid 5px; border-bottom: #ffa500 solid 5px;">2021/05/30</p>
              </div>
            </div>

            <hr class="bg-white">

            <div class="" id="">
              <p class="section-card-white shadow-lg p-4 mb-4 text-left">
                <span style="font-size: 40px" class="text-truncate font-weight-bold">Heading one | </span>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sit amet aliquam id diam maecenas ultricies mi. Augue interdum velit euismod in pellentesque massa. Ut sem nulla pharetra diam sit amet nisl suscipit. Vestibulum mattis ullamcorper velit sed ullamcorper morbi. Enim lobortis scelerisque fermentum dui faucibus in ornare quam. Consequat nisl vel pretium lectus quam. Fermentum posuere urna nec tincidunt praesent semper feugiat nibh sed. At auctor urna nunc id cursus metus aliquam eleifend. Nascetur ridiculus mus mauris vitae ultricies leo integer. Eget egestas purus viverra accumsan in nisl. Mauris in aliquam sem fringilla ut morbi tincidunt. Ut etiam sit amet nisl. Lorem ipsum dolor sit amet. Viverra suspendisse potenti nullam ac tortor vitae purus faucibus. Eget nulla facilisi etiam dignissim diam quis. Enim nulla aliquet porttitor lacus luctus. Id consectetur purus ut faucibus pulvinar elementum integer. Amet tellus cras adipiscing enim eu turpis. Placerat orci nulla pellentesque dignissim.

                Lorem donec massa sapien faucibus et molestie ac feugiat. Convallis aenean et tortor at risus viverra adipiscing at. Purus semper eget duis at. Cursus sit amet dictum sit amet justo donec enim. Mus mauris vitae ultricies leo integer malesuada nunc. Mattis nunc sed blandit libero volutpat sed cras ornare. Enim nunc faucibus a pellentesque sit amet porttitor eget. Tellus in hac habitasse platea dictumst vestibulum. Venenatis tellus in metus vulputate eu scelerisque felis imperdiet proin. Faucibus purus in massa tempor nec feugiat. In vitae turpis massa sed elementum tempus. Nibh sit amet commodo nulla facilisi nullam vehicula. Nunc sed velit dignissim sodales ut.

                Ipsum a arcu cursus vitae congue mauris. Nec nam aliquam sem et tortor consequat id porta. At imperdiet dui accumsan sit amet nulla. Viverra justo nec ultrices dui sapien. Enim nunc faucibus a pellentesque sit amet porttitor. Duis ultricies lacus sed turpis tincidunt id aliquet. Urna duis convallis convallis tellus id interdum velit. Consectetur adipiscing elit ut aliquam purus sit amet. Sit amet aliquam id diam maecenas ultricies mi. Nisl condimentum id venenatis a. Dignissim convallis aenean et tortor at risus viverra. Quis imperdiet massa tincidunt nunc. Ultrices vitae auctor eu augue ut lectus arcu. Vel elit scelerisque mauris pellentesque pulvinar. Dapibus ultrices in iaculis nunc sed augue. Amet nisl purus in mollis nunc sed. Dictum varius duis at consectetur lorem. Nec dui nunc mattis enim ut tellus elementum. Adipiscing at in tellus integer feugiat.

                Nulla facilisi etiam dignissim diam quis enim lobortis scelerisque. Mattis molestie a iaculis at erat pellentesque adipiscing commodo elit. Lectus proin nibh nisl condimentum id venenatis a. Sem fringilla ut morbi tincidunt. Diam maecenas ultricies mi eget mauris. Neque aliquam vestibulum morbi blandit cursus. Convallis a cras semper auctor neque. Metus aliquam eleifend mi in. Rutrum tellus pellentesque eu tincidunt tortor. Id donec ultrices tincidunt arcu non sodales neque sodales ut. Sed faucibus turpis in eu mi bibendum. Pharetra et ultrices neque ornare aenean euismod elementum nisi. Mattis pellentesque id nibh tortor id. Vitae tortor condimentum lacinia quis. Condimentum mattis pellentesque id nibh tortor id aliquet lectus. Aenean sed adipiscing diam donec. Cras tincidunt lobortis feugiat vivamus at augue. Amet nulla facilisi morbi tempus. Pellentesque massa placerat duis ultricies.

                Malesuada pellentesque elit eget gravida cum sociis natoque penatibus. Amet justo donec enim diam vulputate ut pharetra sit. Massa tincidunt dui ut ornare lectus. Cursus euismod quis viverra nibh. Felis bibendum ut tristique et egestas quis. Gravida dictum fusce ut placerat. Est placerat in egestas erat imperdiet sed euismod nisi porta. Tincidunt dui ut ornare lectus sit amet est placerat. Ultricies leo integer malesuada nunc vel. Dignissim cras tincidunt lobortis feugiat vivamus. Odio facilisis mauris sit amet massa. Ante metus dictum at tempor commodo ullamcorper a. Turpis massa tincidunt dui ut ornare. Urna cursus eget nunc scelerisque viverra mauris. Tortor aliquam nulla facilisi cras fermentum odio eu feugiat.
              </p>

              <p class="section-card-white shadow-lg p-4 mb-4 text-left">
                <span style="font-size: 40px" class="text-truncate font-weight-bold">Heading two | </span>

                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sit amet aliquam id diam maecenas ultricies mi. Augue interdum velit euismod in pellentesque massa. Ut sem nulla pharetra diam sit amet nisl suscipit. Vestibulum mattis ullamcorper velit sed ullamcorper morbi. Enim lobortis scelerisque fermentum dui faucibus in ornare quam. Consequat nisl vel pretium lectus quam. Fermentum posuere urna nec tincidunt praesent semper feugiat nibh sed. At auctor urna nunc id cursus metus aliquam eleifend. Nascetur ridiculus mus mauris vitae ultricies leo integer. Eget egestas purus viverra accumsan in nisl. Mauris in aliquam sem fringilla ut morbi tincidunt. Ut etiam sit amet nisl. Lorem ipsum dolor sit amet. Viverra suspendisse potenti nullam ac tortor vitae purus faucibus. Eget nulla facilisi etiam dignissim diam quis. Enim nulla aliquet porttitor lacus luctus. Id consectetur purus ut faucibus pulvinar elementum integer. Amet tellus cras adipiscing enim eu turpis. Placerat orci nulla pellentesque dignissim.

                Lorem donec massa sapien faucibus et molestie ac feugiat. Convallis aenean et tortor at risus viverra adipiscing at. Purus semper eget duis at. Cursus sit amet dictum sit amet justo donec enim. Mus mauris vitae ultricies leo integer malesuada nunc. Mattis nunc sed blandit libero volutpat sed cras ornare. Enim nunc faucibus a pellentesque sit amet porttitor eget. Tellus in hac habitasse platea dictumst vestibulum. Venenatis tellus in metus vulputate eu scelerisque felis imperdiet proin. Faucibus purus in massa tempor nec feugiat. In vitae turpis massa sed elementum tempus. Nibh sit amet commodo nulla facilisi nullam vehicula. Nunc sed velit dignissim sodales ut.

                Ipsum a arcu cursus vitae congue mauris. Nec nam aliquam sem et tortor consequat id porta. At imperdiet dui accumsan sit amet nulla. Viverra justo nec ultrices dui sapien. Enim nunc faucibus a pellentesque sit amet porttitor. Duis ultricies lacus sed turpis tincidunt id aliquet. Urna duis convallis convallis tellus id interdum velit. Consectetur adipiscing elit ut aliquam purus sit amet. Sit amet aliquam id diam maecenas ultricies mi. Nisl condimentum id venenatis a. Dignissim convallis aenean et tortor at risus viverra. Quis imperdiet massa tincidunt nunc. Ultrices vitae auctor eu augue ut lectus arcu. Vel elit scelerisque mauris pellentesque pulvinar. Dapibus ultrices in iaculis nunc sed augue. Amet nisl purus in mollis nunc sed. Dictum varius duis at consectetur lorem. Nec dui nunc mattis enim ut tellus elementum. Adipiscing at in tellus integer feugiat.

                Nulla facilisi etiam dignissim diam quis enim lobortis scelerisque. Mattis molestie a iaculis at erat pellentesque adipiscing commodo elit. Lectus proin nibh nisl condimentum id venenatis a. Sem fringilla ut morbi tincidunt. Diam maecenas ultricies mi eget mauris. Neque aliquam vestibulum morbi blandit cursus. Convallis a cras semper auctor neque. Metus aliquam eleifend mi in. Rutrum tellus pellentesque eu tincidunt tortor. Id donec ultrices tincidunt arcu non sodales neque sodales ut. Sed faucibus turpis in eu mi bibendum. Pharetra et ultrices neque ornare aenean euismod elementum nisi. Mattis pellentesque id nibh tortor id. Vitae tortor condimentum lacinia quis. Condimentum mattis pellentesque id nibh tortor id aliquet lectus. Aenean sed adipiscing diam donec. Cras tincidunt lobortis feugiat vivamus at augue. Amet nulla facilisi morbi tempus. Pellentesque massa placerat duis ultricies.

                Malesuada pellentesque elit eget gravida cum sociis natoque penatibus. Amet justo donec enim diam vulputate ut pharetra sit. Massa tincidunt dui ut ornare lectus. Cursus euismod quis viverra nibh. Felis bibendum ut tristique et egestas quis. Gravida dictum fusce ut placerat. Est placerat in egestas erat imperdiet sed euismod nisi porta. Tincidunt dui ut ornare lectus sit amet est placerat. Ultricies leo integer malesuada nunc vel. Dignissim cras tincidunt lobortis feugiat vivamus. Odio facilisis mauris sit amet massa. Ante metus dictum at tempor commodo ullamcorper a. Turpis massa tincidunt dui ut ornare. Urna cursus eget nunc scelerisque viverra mauris. Tortor aliquam nulla facilisi cras fermentum odio eu feugiat.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md mx-2 fitblog-designer-post-items-container no-scroller" style="overflow-y: auto; border-radius: 0 0 25px 25px;height: 100%;">
        <!--height: 50%; -->
        <div class="sticky-topz container border-bottom border-left border-white shadow py-4" style="widthz:100%; z-index: 1101; background:#333; border-radius: 25px 0 25px 25px;">
          <div class="row align-items-center">
            <div class="col-2 p-0 h-100 text-center" style="width: 20%; overflow-y: visible; max-height: 60px">
              <button class="onefit-buttons-style p-3" onclick="closeFitblogDesigner()" type="button" data-toggle="collapse" data-target="#item-heading-1-input-container" aria-expanded="false" aria-controls="item-heading-1-input-container">
                <!--<i class="fas fa-door-open"></i>--><i class="fas fa-arrow-left"></i>
              </button>

            </div>
            <div class="col-10 h-100" style="width: 80%">
              <h5 class="p-4 text-center" style="border-radius: 25px; border-left: #ffa500 solid 5px; border-right: #ffa500 solid 5px;"><img src="../media/assets/One-Logo-Vertical.svg" class="img-fluid d-inline" style="max-height: 5vh;" alt="onefit logo"> | <span style="color:#ffa500">fit</span>blog</h5>

              <div class="row align-items-end">
                <div class="col-sm text-left">
                  <p style="font-size: 10px"><i class="fas fa-paint-brush"></i> Post Designer</p>
                </div>
                <div class="col-sm text-right"><button class="onefit-buttons-style p-3 mt-4z"><i class="fas fa-redo-alt"></i></button> | <button class="onefit-buttons-style p-3" type="button" data-toggle="collapse" data-target="#item-heading-1-input-container" aria-expanded="false" aria-controls="item-heading-1-input-container">
                    <!--<i class="fas fa-door-open"></i>--><i class="fas fa-paper-plane"></i> Publish
                  </button></div>
              </div>
            </div>
          </div>
        </div>

        <div class="h-100 no-scroller mt-4" style="padding-topz: 220px;">
          <div class="row align-items-endz" style="border-radius: 25px; overflow: hidden">
            <div class="col-md-3 fitness-bg sticky-top" style="border-radius: 0 25px 25px 0;">
              <div class="fitblog-designer-tools-panel shadow-lg text-center px-1 py-2 my-3">
                <p><i class="fas fa-plus-circle paint-brush"></i> Insert</p>
                <hr class="bg-white">
                <ul class="list-group list-group-horizontalz -sm">
                  <li class="list-group-item bg-transparent border-0 p-0"><button class="null-btn p-2"><i class="fas fa-heading" style="color: #333 !important;"></i><br> Heading</button></li>
                  <li class="list-group-item bg-transparent border-0 p-0"><button class="null-btn p-2"><i class="fas fa-paragraph sticky-note align-left" style="color: #333 !important;"></i><br> Paragraph</button></li>
                  <li class="list-group-item bg-transparent border-0 p-0"><button class="null-btn p-2"><i class="fas fa-quote-right" style="color: #333 !important;"></i><br> Quote</button></li>
                  <li class="list-group-item bg-transparent border-0 p-0"><button class="null-btn p-2"><i class="fas fa-photo-video" style="color: #333 !important;"></i><br> Media</button></li>
                  <li class="list-group-item bg-transparent border-0 p-0"><button class="null-btn p-2"><i class="fas fa-link" style="color: #333 !important;"></i><br> Links</button></li>
                </ul>
              </div>

              <hr class="bg-white">
              <div class="p-2 mb-4" style="color: #fff; background: #333; border-radius: 25px; min-height: 50px">
                <h3>Reference</h3>
              </div>
            </div>
            <div class="col-md-9">
              <div class="accordion bg-transparent" id="accordionExample">
                <div class="card bg-transparent">
                  <div class="card-header bg-transparent" id="headingOne">
                    <h2 class="mb-0">
                      <button class="btn btn-link btn-block text-left bg-transparent rounded-pill shadow" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fas fa-fingerprint"></i> Head content
                      </button>
                    </h2>
                  </div>

                  <div id="collapseOne" class="collapse show bg-transparent" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                      <ul class="list-group list-group-flush" id="" style="padding-leftz: 20px">
                        <li class="list-group-item bg-transparent border-bottom border-right border-white mb-4" style="border-radius: 25px">
                          <div class="item-heading" type="button" data-toggle="collapse" data-target="#item-heading-1-input-container" aria-expanded="false" aria-controls="item-heading-1-input-container">
                            <h3>
                              <span class="py-2 px-4 mr-2" style="color:#333; background: #ffa500; border-radius: 15px 15px 15px 0;font-size: 20px;">1.</span>
                              <i class="fas fa-heading"></i> | <u>Post Title</u>
                            </h3>
                            <div class="mt-4">
                              <p style="font-size: 10px!important"></span>Preview: <i class="fas fa-eye"></i></p>
                              <p id="item-heading-1-content-preview" class="text-truncate" style="color:#fff;">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sit amet aliquam id diam maecenas ultricies mi. Augue interdum velit euismod in pellentesque massa. Ut sem nulla pharetra diam sit amet nisl suscipit. Vestibulum mattis ullamcorper velit sed ullamcorper morbi. Enim lobortis scelerisque fermentum dui faucibus in ornare quam. Consequat nisl vel pretium lectus quam. Fermentum posuere urna nec tincidunt praesent semper feugiat nibh sed. At auctor urna nunc id cursus metus aliquam eleifend. Nascetur ridiculus mus mauris vitae ultricies leo integer. Eget egestas purus viverra accumsan in nisl. Mauris in aliquam sem fringilla ut morbi tincidunt. Ut etiam sit amet nisl. Lorem ipsum dolor sit amet. Viverra suspendisse potenti nullam ac tortor vitae purus faucibus. Eget nulla facilisi etiam dignissim diam quis. Enim nulla aliquet porttitor lacus luctus. Id consectetur purus ut faucibus pulvinar elementum integer. Amet tellus cras adipiscing enim eu turpis. Placerat orci nulla pellentesque dignissim.

                                Lorem donec massa sapien faucibus et molestie ac feugiat. Convallis aenean et tortor at risus viverra adipiscing at. Purus semper eget duis at. Cursus sit amet dictum sit amet justo donec enim. Mus mauris vitae ultricies leo integer malesuada nunc. Mattis nunc sed blandit libero volutpat sed cras ornare. Enim nunc faucibus a pellentesque sit amet porttitor eget. Tellus in hac habitasse platea dictumst vestibulum. Venenatis tellus in metus vulputate eu scelerisque felis imperdiet proin. Faucibus purus in massa tempor nec feugiat. In vitae turpis massa sed elementum tempus. Nibh sit amet commodo nulla facilisi nullam vehicula. Nunc sed velit dignissim sodales ut.

                                Ipsum a arcu cursus vitae congue mauris. Nec nam aliquam sem et tortor consequat id porta. At imperdiet dui accumsan sit amet nulla. Viverra justo nec ultrices dui sapien. Enim nunc faucibus a pellentesque sit amet porttitor. Duis ultricies lacus sed turpis tincidunt id aliquet. Urna duis convallis convallis tellus id interdum velit. Consectetur adipiscing elit ut aliquam purus sit amet. Sit amet aliquam id diam maecenas ultricies mi. Nisl condimentum id venenatis a. Dignissim convallis aenean et tortor at risus viverra. Quis imperdiet massa tincidunt nunc. Ultrices vitae auctor eu augue ut lectus arcu. Vel elit scelerisque mauris pellentesque pulvinar. Dapibus ultrices in iaculis nunc sed augue. Amet nisl purus in mollis nunc sed. Dictum varius duis at consectetur lorem. Nec dui nunc mattis enim ut tellus elementum. Adipiscing at in tellus integer feugiat.

                                Nulla facilisi etiam dignissim diam quis enim lobortis scelerisque. Mattis molestie a iaculis at erat pellentesque adipiscing commodo elit. Lectus proin nibh nisl condimentum id venenatis a. Sem fringilla ut morbi tincidunt. Diam maecenas ultricies mi eget mauris. Neque aliquam vestibulum morbi blandit cursus. Convallis a cras semper auctor neque. Metus aliquam eleifend mi in. Rutrum tellus pellentesque eu tincidunt tortor. Id donec ultrices tincidunt arcu non sodales neque sodales ut. Sed faucibus turpis in eu mi bibendum. Pharetra et ultrices neque ornare aenean euismod elementum nisi. Mattis pellentesque id nibh tortor id. Vitae tortor condimentum lacinia quis. Condimentum mattis pellentesque id nibh tortor id aliquet lectus. Aenean sed adipiscing diam donec. Cras tincidunt lobortis feugiat vivamus at augue. Amet nulla facilisi morbi tempus. Pellentesque massa placerat duis ultricies.

                                Malesuada pellentesque elit eget gravida cum sociis natoque penatibus. Amet justo donec enim diam vulputate ut pharetra sit. Massa tincidunt dui ut ornare lectus. Cursus euismod quis viverra nibh. Felis bibendum ut tristique et egestas quis. Gravida dictum fusce ut placerat. Est placerat in egestas erat imperdiet sed euismod nisi porta. Tincidunt dui ut ornare lectus sit amet est placerat. Ultricies leo integer malesuada nunc vel. Dignissim cras tincidunt lobortis feugiat vivamus. Odio facilisis mauris sit amet massa. Ante metus dictum at tempor commodo ullamcorper a. Turpis massa tincidunt dui ut ornare. Urna cursus eget nunc scelerisque viverra mauris. Tortor aliquam nulla facilisi cras fermentum odio eu feugiat.
                              </p>
                            </div>
                          </div>

                          <div class="collapse" id="item-heading-1-input-container">
                            <input id="item-heading-1" class="onefit-inputs-style my-2">
                            <button class="onefit-buttons-style p-3" type="button" data-toggle="collapse" data-target="#item-heading-1-input-container" aria-expanded="false" aria-controls="item-heading-1-input-container"><i class="fas fa-check"></i> Done</button>
                          </div>
                        </li>
                        <li class="list-group-item bg-transparent border-bottom border-right border-white mb-4" style="border-radius: 25px">
                          <div class="item-heading" type="button" data-toggle="collapse" data-target="#item-heading-1-input-container" aria-expanded="false" aria-controls="item-heading-1-input-container">
                            <h3>
                              <span class="py-2 px-4 mr-2" style="color:#333; background: #ffa500; border-radius: 15px 15px 15px 0;font-size: 20px;">2.</span>
                              <i class="fas fa-photo-video"></i> | <u>Banner</u>
                            </h3>
                            <div class="mt-4">
                              <p style="font-size: 10px!important"></span>Preview: <i class="fas fa-eye"></i></p>
                              <img src="../media/images/fitness/8.jpg" class="img-fluid" alt="placeholder" style="border-radius: 25px">
                            </div>
                          </div>

                          <div class="collapse" id="item-heading-1-input-container">
                            <input id="item-heading-1" class="onefit-inputs-style my-2">
                            <button class="onefit-buttons-style p-3" type="button" data-toggle="collapse" data-target="#item-heading-1-input-container" aria-expanded="false" aria-controls="item-heading-1-input-container"><i class="fas fa-check"></i> Done</button>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card bg-transparent">
                  <div class="card-header bg-transparent" id="headingTwo">
                    <h2 class="mb-0">
                      <button class="btn btn-link btn-block text-left collapsed bg-transparent rounded-pill shadow" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="fas fa-fingerprint"></i> Body content
                      </button>
                    </h2>
                  </div>
                  <div id="collapseTwo" class="collapse bg-transparent" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                      Some placeholder content for the second accordion panel. This panel is hidden by default.
                    </div>
                  </div>
                </div>
                <div class="card bg-transparent">
                  <div class="card-header bg-transparent" id="headingThree">
                    <h2 class="mb-0">
                      <button class="btn btn-link btn-block text-left collapsed bg-transparent rounded-pill shadow" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <i class="fas fa-fingerprint"></i> Foot content
                      </button>
                    </h2>
                  </div>
                  <div id="collapseThree" class="collapse bg-transparent" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                      And lastly, the placeholder content for the third and final accordion panel. This panel is hidden by default.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <nav class="navbar text-white fixed-top m-0" style="background: #333">
    <a class="navbar-brand align-items-center" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="false">
      <img src="../media/assets/One-Symbol-Logo-Two-Tone.svg" class="d-inline-block align-top" alt="onefit logo" style="height: 50px; width: auto" />
    </a>
    <h1 class="light-h-text">one<span style="color: #ffa500 !important">fit</span><span style="font-size: 10px">&trade;</span></h1>
    <button class="menu-toggle" type="button" data-toggle="modal" data-target="#navigationModal">
      <i class="fas fa-fingerprint m-4"></i>
    </button>
  </nav>
  <div class="row p-0 m-0 fitness-bg" style="height: 100%">
    <div class="col-1 px-0" style="background: #333; color: #fff; max-height: 100vh; overflow-y: auto">
      <ul class="nav nav-pills list-group bg-transparent border-0 navigation-bar" id="v-pills-navigation-tab" role="tablist" style="width: 100%; padding-top: 100px; padding-bottom: 50px;">
        <li class="nav-item list-group-item bg-transparent border-0 text-center p-0">
          <a class="nav-link active p-1" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true" style="color: white">Home
            <!--<img src="../media/assets/icons/icons8-home-50.png" class="img-fluid" alt="Icons8 - Home icon" />-->
          </a>
        </li>
        <li class="nav-item list-group-item bg-transparent border-0 text-center p-0">
          <a class="nav-link p-1" id="v-pills-dashboard-tab" data-toggle="pill" href="#v-pills-dashboard" role="tab" aria-controls="v-pills-dashboard" aria-selected="false" style="color: white">Dashboard
            <!--<img src="../media/assets/icons/icons8-line-chart-50.png" class="img-fluid" alt="Icons8" />-->
          </a>
        </li>
        <li class="nav-item list-group-item bg-transparent border-0 text-center p-0">
          <a class="nav-link p-1" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false" style="color: white">Profile
            <!--<img src="../media/assets/icons/icons8-name-tag-50.png" class="img-fluid" alt="Icons8 - contacts icon" />-->
          </a>
        </li>
        <li class="nav-item list-group-item bg-transparent border-0 text-center p-0">
          <a class="nav-link p-1" id="v-pills-discover-tab" data-toggle="pill" href="#v-pills-discover" role="tab" aria-controls="v-pills-discover" aria-selected="false" style="color: white">Discover
            <!--<img src="../media/assets/icons/icons8-connect-50.png" class="img-fluid" alt="Icons8 - connect icon" />-->
          </a>
        </li>
        <li class="nav-item list-group-item bg-transparent border-0 text-center p-0">
          <a class="nav-link p-1" id="v-pills-activities-tab" data-toggle="pill" href="#v-pills-activities" role="tab" aria-controls="v-pills-activities" aria-selected="false" style="color: white">Activities
            <!--<img src="../media/assets/icons/icons8-check-all-50.png" class="img-fluid" alt="Icons8 - check all icon" />-->
          </a>
        </li>
        <li class="nav-item list-group-item bg-transparent border-0 text-center p-0">
          <a class="nav-link p-1" id="v-pills-tracking-tab" data-toggle="pill" href="#v-pills-tracking" role="tab" aria-controls="v-pills-tracking" aria-selected="false" style="color: white">Tracking
            <!--<img src="../media/assets/icons/icons8-binoculars-50.png" class="img-fluid" alt="Icons8 - binoculars icon" />-->
          </a>
        </li>
        <li class="nav-item list-group-item bg-transparent border-0 text-center p-0">
          <a class="nav-link p-1" id="v-pills-fitblog-tab" data-toggle="pill" href="#v-pills-fitblog" role="tab" aria-controls="v-pills-fitblog" aria-selected="false" style="color: white">fitblog
            <!--<img src="../media/assets/icons/icons8-for-you-50.png" class="img-fluid" alt="Icons8 - for you icon" />-->
          </a>
        </li>
        <li class="nav-item list-group-item bg-transparent border-0 text-center p-0">
          <a class="nav-link p-1" id="v-pills-communication-tab" data-toggle="pill" href="#v-pills-communication" role="tab" aria-controls="v-pills-communication" aria-selected="false" style="color: white">Communication
            <!--<img src="../media/assets/icons/icons8-communication-50.png" class="img-fluid" alt="Icons8 - news icon" />-->
          </a>
        </li>
        <li class="nav-item list-group-item border-0 text-center py-0" style="z-index: 2; position: fixed; bottom: 0px; background: #ffa500 !important; border-radius: 0 25px 25px 0; overflow: hidden">
          <a class="nav-link my-0" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><img src="../media/assets/icons/icons8-settings-50.png" class="img-fluid" alt="Icons8 - settings icon" /></a>
        </li>
      </ul>
    </div>
    <div class="col" style="padding: 0; height: 100vh; overflow-y: auto; overflow-x: hidden; color: #fff; background: rgba(51, 51, 51, 0.7)">
      <!--/* rgba(225, 225, 225, 0.5)*/-->
      <div class="tab-content" id="v-pills-tabContent">
        <!--Home tab-->
        <div class="tab-pane fade show active py-4 pl-2 pr-0" style="padding-top: 100px !important" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
          <h1 class="mb-4" stylez="border-radius: 25px; color: #ffa500; font-weight: 100"><span class="tunnel-bgz" stylez="border-left: #ffa500 solid 10px; padding: 20px; border-radius: 25px 25px 25px 0">Home</span></h1>

          <div class="content-panel dark-grad-fade-panel">
            <h2 class="my-2">Quick Nav</h2>
            <hr class="bg-white" />

            <div class="row ">
              <div class="col-lg">
                <!--<div class="d-flex justify-content-center">
                      <div class="spinner-border" role="status">
                        <span class="sr-only">Loading latest/trending...</span>
                      </div>
                    </div>-->
                <ul class="list-group list-group-flush text-center">
                  <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-bullseye" style="color: #ffa500; font-size: 25px"></i> Community Feed</li>
                  <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-bullseye" style="color: #ffa500; font-size: 25px"></i> Your Dashboard</li>
                  <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-bullseye" style="color: #ffa500; font-size: 25px"></i> Discover People</li>
                  <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-bullseye" style="color: #ffa500; font-size: 25px"></i> Discover Posts</li>
                  <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-bullseye" style="color: #ffa500; font-size: 25px"></i> Discover Groups</li>
                  <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-bullseye" style="color: #ffa500; font-size: 25px"></i> Discover Resources</li>
                  <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-bullseye" style="color: #ffa500; font-size: 25px"></i> Discover Programs</li>
                </ul>
              </div>
              <div class="col-lg border-left border-white">
                <h3><i class="fab fa-twitter"></i> Social @one<span style="color: #ffa500">fit_za</span></h3>
                <div class="twitter-social-container">
                  <a class="twitter-timeline" href="https://twitter.com/OnefitNet?ref_src=twsrc%5Etfw">Tweets by OnefitNet</a>
                  <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>
              </div>
            </div>

            <h2>
              <span style="color: #ffa500">Fitness</span> Resources <button class="null-btn text-white border border-white"><i class="fas fa-plus-circle"></i> Share</button>
            </h2>
            <hr class="bg-white" />
            <div class="resource-container">
              <div class="grid-container">
                <?php echo $homeCommunityResources; ?>
              </div>

              <!--<div class="resource-item">
                  <div class="resource-subs">
                    <button id="resource-subs-btn"><i class="fas fa-wind"></i> Subscribe</button>
                  </div>
                </div>

                <div class="resource-item">
                  <div class="resource-subs">
                    <button id="resource-subs-btn"><i class="fas fa-wind"></i> Subscribe</button>
                  </div>
                </div>

                <div class="resource-item">
                  <div class="resource-subs">
                    <button id="resource-subs-btn"><i class="fas fa-wind"></i> Subscribe</button>
                  </div>
                </div>

                <div class="resource-item">
                  <div class="resource-subs">
                    <button id="resource-subs-btn"><i class="fas fa-wind"></i> Subscribe</button>
                  </div>
                </div>

                <div class="resource-item">
                  <div class="resource-subs">
                    <button id="resource-subs-btn"><i class="fas fa-wind"></i> Subscribe</button>
                  </div>
                </div>

                <div class="resource-item">
                  <div class="resource-subs">
                    <button id="resource-subs-btn"><i class="fas fa-wind"></i> Subscribe</button>
                  </div>
                </div>

                <div class="resource-item">
                  <div class="resource-subs">
                    <button id="resource-subs-btn"><i class="fas fa-wind"></i> Subscribe</button>
                  </div>
                </div>-->
            </div>

            <h2>
              <i class="fas fa-stream"></i> Community feed <button class="null-btn text-white border border-white"><i class="fas fa-plus-circle"></i> Share</button>
            </h2>
            <hr class="bg-white" />
            <div class="grid-container">
              <?php echo $homeCommunityPosts; ?>
            </div>
          </div>
        </div>
        <!--Dashboard tab-->
        <div class="tab-pane fade py-4 pl-2 pr-0" style="padding-top: 100px !important" id="v-pills-dashboard" role="tabpanel" aria-labelledby="v-pills-dashboard-tab">
          <h1 class="mb-4">Dashboard</h1>

          <div class="content-panel dark-grad-fade-panel">
            <iframe class="tunnel-bg-white survey-frame" src="https://datastudio.google.com/embed/reporting/2a409a10-e7c0-4375-a22d-bfab63e728db/page/guiJC" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>
        </div>
        <!--Profile tab-->
        <div class="tab-pane fade py-4 pl-2 pr-0" style="padding-top: 100px !important" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          <h1 class="mb-4">Profile</h1>

          <div class="content-panel dark-grad-fade-panel">
            <div class="row align-items-center tunnel-bg m-2" style="border-radius: 25px">
              <div class="col-lg text-center center-container">


                <div class="profile-img-container center-container shadow-lg">
                  <img src="../media/images/fitness/photo-1574680096145-d05b474e2155.jpg" class="" id="" alt="" />
                  <button class="onefit-buttons-style p-3" style="position: absolute; bottom: 0; margin-bottom: -28px; text-align: center; z-indexz: 2;" type="button" id="edit-prof-pic-btn"><i class="fas fa-camera"></i></button>
                </div>

              </div>
              <div class="col-lg-8 py-4 shadow-lg" style="background: rgba(51, 51, 51, 0.7); border-radius: 25px">
                <div class="text-center border-top border-warning" style="font-size: 50px; font-family: 'MuseoModerno', cursive; border-radius: 25px"><?php echo $usrprof_name . ' ' . $usrprof_surname . ' <span id="" class="profile-username-tag" style="font-size: 25px">@' . $usrprof_username . '</span>'; ?></div>
                <hr class="bg-white" hidden>
                <div class="text-center">
                  <div class="my-4 pb-4 border-bottom border-warning" id="user-about" style="font-size: 20px; border-radius: 25px">
                    <?php echo $usr_about; ?>
                  </div>

                  <?php echo $userSocialItems; ?>
                </div>
              </div>
            </div>

            <!--<div class="my-4">
                <ul class="list-group list-group-horizontal-lg justify-content-center">
                    <li class="list-group-item bg-transparent border-0 py-0 pl-0 pr-2">
                      <p class="font-weight-bold" style="color: #ffa500"><u>About</u></p class="font-weight-bold" style="color: #ffa500">
                      <div class="text-wrap">
                        <?php echo $usr_about; ?>
                      </div>
                    </li>
                    <li class="list-group-item bg-transparent border-0 py-0 pl-0 pr-2">
                      <p class="font-weight-bold" style="color: #ffa500"><u>Mutual</u></p class="font-weight-bold" style="color: #ffa500">
                      <div class="">
                        
                      </div>
                    </li>
                    <li class="list-group-item bg-transparent border-0 py-0 pl-0 pr-2">
                      <p class="font-weight-bold" style="color: #ffa500"><u>Achievements</u></p class="font-weight-bold" style="color: #ffa500">
                      <div class="">
                        
                      </div>
                    </li>
                    <li class="list-group-item bg-transparent border-0 py-0 pl-0 pr-2">
                      <p class="font-weight-bold" style="color: #ffa500"><u>Social</u></p class="font-weight-bold" style="color: #ffa500">
                      <div class="">
                        <?php echo $userSocialItems; ?>
                      </div>
                    </li>
                  </ul>
              </div>-->

            <hr class="bg-white" />
            <div class="row dark-grad-fade-panel">
              <div class="col-lg-8">
                <nav class="">
                  <div class="nav nav-tabs justify-content-center content-tab align-items-center" id="nav-tab-profile" role="tablist">
                    <a class="nav-item nav-link align-items-center" id="create-new-post" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus-circle d-inline" style="font-size: 8px"></i> <img src="../media/assets/icons/icons8-create-50-White.png" class="img-fluid d-inline" style="max-height: 30px" alt="create button"></a>
                    <a class="nav-item nav-link active" id="profile-nav-shares-tab" data-toggle="tab" href="#profile-nav-shares" role="tab" aria-controls="profile-nav-shares" aria-selected="true">Shares</a>
                    <a class="nav-item nav-link" id="profile-nav-media-tab" data-toggle="tab" href="#profile-nav-media" role="tab" aria-controls="discover-nav-media" aria-selected="false">Media</a>
                    <a class="nav-item nav-link" id="profile-nav-subs-tab" data-toggle="tab" href="#profile-nav-subs" role="tab" aria-controls="discover-nav-subs" aria-selected="false">Training Subs</a>
                    <a class="nav-item nav-link" id="profile-nav-favs-tab" data-toggle="tab" href="#profile-nav-favs" role="tab" aria-controls="discover-nav-favs" aria-selected="false">Faves</a>
                    <a class="nav-item nav-link" id="profile-nav-friends-tab" data-toggle="tab" href="#profile-nav-friends" role="tab" aria-controls="discover-nav-friends" aria-selected="false">Friends</a>
                    <a class="nav-item nav-link" id="profile-nav-groups-tab" data-toggle="tab" href="#profile-nav-groups" role="tab" aria-controls="discover-nav-groups" aria-selected="false">Groups</a>
                  </div>
                </nav>
                <div class="tab-content" id="nav-tabContent-profile">
                  <div class="tab-pane fade show active" id="profile-nav-shares" role="tabpanel" aria-labelledby="profile-nav-shares-tab">
                    <div class="row py-4">
                      <div class="col-lg-8">
                        <h3>My Posts</h3>
                        <hr class="bg-white">
                        <?php echo $profileUsersPostsList; ?>
                      </div>
                      <div class="col border-left border-white">
                        <h3>My Resources</h3>
                        <hr class="bg-white">
                        <?php echo $profileUsersResourcesList; ?>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="profile-nav-media" role="tabpanel" aria-labelledby="profile-nav-media-tab">
                    <div class="grid-container">
                      <?php echo $profileUserMediaList; ?>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="profile-nav-subs" role="tabpanel" aria-labelledby="profile-nav-subs-tab">
                    <?php echo $profileUsersProgramsList; ?>
                  </div>
                  <div class="tab-pane fade" id="profile-nav-favs" role="tabpanel" aria-labelledby="profile-nav-favs-tab">
                    <?php echo $profileUsersFavesList; ?>
                  </div>
                  <div class="tab-pane fade" id="profile-nav-friends" role="tabpanel" aria-labelledby="profile-nav-friends-tab">
                    <?php echo $profileUserFriendsList; ?>
                  </div>
                  <div class="tab-pane fade" id="profile-nav-groups" role="tabpanel" aria-labelledby="profile-nav-groups-tab">
                    <div class="grid-container">
                      <?php echo $profileUserSubsGroupsList; ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg border-left border-white">
                <div class="d-flex justify-content-center">
                  <!--<div class="spinner-border" role="status">
                      <span class="sr-only">Loading promo...</span>
                    </div>-->
                  <img src="../media/images/advertisment-ph.png" class="img-fluid" style="border-radius: 15px 0 15px 15px" alt="advertisment placeholder">
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--Discover tab-->
        <div class="tab-pane fade py-4 pl-2 pr-0" id="v-pills-discover" role="tabpanel" aria-labelledby="v-pills-discover-tab">

          <!-- Search bar - centered -->
          <div class="sticky-top dark-grad-fade-panel" style="padding-top: 100px !important">
            <h1 class="mb-4">Discover</h1>

            <div class="row align-items-center">
              <div class="col-md-10">
                <input type="search" class="onefit-inputs-style" id="discover-search-input" placeholder="Search" />
              </div>
              <div class="col-md-2 text-left">
                <button class="onefit-buttons-style my-4" id="search-discover">
                  <i class="fas fa-search m-4"></i>
                </button>
              </div>
            </div>
          </div>

          <nav class="">
            <div class="nav nav-tabs justify-content-center content-tab align-items-center" id="nav-tab-discover" role="tablist">
              <a class="nav-item nav-link active" id="discover-nav-people-tab" data-toggle="tab" href="#discover-nav-people" role="tab" aria-controls="discover-nav-people" aria-selected="true">People</a>
              <a class="nav-item nav-link" id="discover-nav-posts-tab" data-toggle="tab" href="#discover-nav-posts" role="tab" aria-controls="discover-nav-posts" aria-selected="false">Posts</a>
              <a class="nav-item nav-link" id="discover-nav-groups-tab" data-toggle="tab" href="#discover-nav-groups" role="tab" aria-controls="discover-nav-groups" aria-selected="false">Groups</a>
              <a class="nav-item nav-link" id="discover-nav-resources-tab" data-toggle="tab" href="#discover-nav-resources" role="tab" aria-controls="discover-nav-resources" aria-selected="false">Resources</a>
              <a class="nav-item nav-link" id="discover-nav-programs-tab" data-toggle="tab" href="#discover-nav-programs" role="tab" aria-controls="discover-nav-programs" aria-selected="false">programs</a>
            </div>
          </nav>

          <div class="tab-content" id="nav-tabContent-discover">
            <div class="tab-pane fade show active" id="discover-nav-people" role="tabpanel" aria-labelledby="discover-nav-people-tab">
              <div class="grid-container"><?php echo $discoverPeopleList; ?></div>
            </div>
            <div class="tab-pane fade" id="discover-nav-posts" role="tabpanel" aria-labelledby="discover-nav-posts-tab"><?php echo $discoverPostsList; ?></div>
            <div class="tab-pane fade" id="discover-nav-groups" role="tabpanel" aria-labelledby="discover-nav-groups-tab">
              <div class="grid-container"><?php echo $discoverGroupsList; ?></div>
            </div>
            <div class="tab-pane fade" id="discover-nav-resources" role="tabpanel" aria-labelledby="discover-nav-resources-tab">
              <div class="grid-container"><?php echo $discoverResourcesList; ?></div>
            </div>
            <div class="tab-pane fade" id="discover-nav-programs" role="tabpanel" aria-labelledby="discover-nav-programs-tab">
              <div class="grid-container"><?php echo $discoverProgramsList; ?></div>
            </div>
          </div>
        </div>
        <!--Activities tab-->
        <div class="tab-pane fade py-4 pl-2 pr-0" style="padding-top: 100px !important" id="v-pills-activities" role="tabpanel" aria-labelledby="v-pills-activities-tab">
          <h1 class="mb-4">Activities</h1>

          <!--Calender and daily ativities panel-->
          <div class="content-panel dark-grad-fade-panel mb-4">
            <div class="activities-calender-container text-center mb-4">
              <!--<img src="../media/assets/12month-calendar.png" class="img-fluid" alt="calender sample" />-->
              <div id="activities-calender"></div>
            </div>

            <div class="text-center text-truncate"><span class="" id="calender-date">18 May 2021</span></div>
            <div class="text-center"><i class="fas fa-clock" style="color: #ffa500"></i> <span class="" id="clock-time">00:00:00</span></div>

            <hr class="bg-white" />
            <div class="text-left">
              Line up
              <ul class="list-group list-group-flush p-0 m-0">
                <li class="list-group-item bg-transparent px-0">
                  <div class="py-4 text-truncate" id="">
                    <!--<i class="fas fa-chevron-right"></i> <span id="">16:12</span> | <span id="">blah blah blahiiiiiiiiiiiiiiiiiiiii oooooooooooooooooooooooooooo nnnnnnnnnnnnnnnnnnnnnnnnnn jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj</span>--> No activities
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="content-panel dark-grad-fade-panel">

            <div class="row">
              <div class="col-lg" style="max-height: 70vh; overflow-y: auto">
                <h3 class=""><i class="fas fa-stream"></i> Community Feed</h3>
                <hr class="bg-white" />

                <!--<div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                      <span class="sr-only">Loading community feed...</span>
                    </div>
                  </div>-->
                <div class="">
                  <?php echo $homeCommunityPosts ?>
                </div>
                <div class="text-center my-2">
                  <hr class="bg-white">
                  <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="max-height: 50px" alt="end of feed">
                </div>
              </div>

              <div class="col-lg -8 border-left border-white" style="max-height: 70vh; overflow-y: auto">
                <h3 class=""><span style="color: #ffa500">Fitness</span> Programs</h3>
                <hr class="bg-white" />
                <div id="activities-fitprograms-container" style="min-height: 50vh">
                  <?php echo $discoverResourcesList; ?>
                </div>

                <h3 class="">Trainers</h3>
                <hr class="bg-white" />
                <div id="activities-trainers-container" style="min-height: 50vh">
                  <?php echo $activitiesTrainersList; ?>
                </div>

                <h3 class="">Gym Assist</h3>
                <hr class="bg-white" />
                <div id="activities-gymassist-container" style="min-height: 50vh"></div>
              </div>
            </div>
          </div>
        </div>
        <!--Tracking tab-->
        <div class="tab-pane fade py-4 pl-2 pr-0" style="padding-top: 100px !important" id="v-pills-tracking" role="tabpanel" aria-labelledby="v-pills-tracking-tab">
          <h1 class="mb-4">Tracking</h1>

          <div class="content-panel dark-grad-fade-panel mb-4">
            <h3 class="mb-4"><img src="../media/assets/icons/icons8-smart-watch-50.png" class="img-fluid" alt="smart vitals"><span style="color: #ffa500">Smart</span> Vitals</h3>

            <p class="text-center" style="font-size: 25px">
              Soon, one<span style="color: #ffa500">fit</span>&trade; will be integrating smart watch and activity tracker data to form part of your daily fitness analysis.
            </p>

            <div class="text-center">
              <img src="../media/assets/smartwatches/Watch Banner.png" class="img-fluid" style="border-radius: 25px" alt="smartwatch integration banner">
            </div>
          </div>

          <div class="content-panel dark-grad-fade-panel mb-4">
            <h3 class="mb-4">Data Centre</h3>
            <div class="row">
              <div class="col-md">
                <h5>Surveys</h5>
                <hr class="bg-white">
                <!--Tab list of the different types of surveys-->
                <div class="row">
                  <div class="col-md-3">
                    <div class="nav flex-column nav-pills" id="v-pills-surveys-tab" role="tablist" aria-orientation="vertical">
                      <a class="nav-link active" style="color: #fff!important" id="v-pills-aws-tab" data-toggle="pill" href="#v-pills-aws" role="tab" aria-controls="v-pills-aws" aria-selected="true">Athlete Wellness Survey</a>
                      <a class="nav-link" style="color: #fff!important" id="v-pills-dlm-tab" data-toggle="pill" href="#v-pills-dlm" role="tab" aria-controls="v-pills-dlm" aria-selected="false">Daily Load Monitoring</a>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="tab-content" id="v-pills-surveys-tabContent">
                      <div class="tab-pane fade show active" id="v-pills-aws" role="tabpanel" aria-labelledby="v-pills-aws-tab">
                        <iframe class="tunnel-bg-white survey-frame" src="https://docs.google.com/forms/d/e/1FAIpQLSc0sL0-Gm6J-Hy03z_F872L5nQAdigfbZArNYBhBGbB-iOqmg/viewform?embedded=true" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
                      </div>
                      <div class="tab-pane fade" id="v-pills-dlm" role="tabpanel" aria-labelledby="v-pills-dlm-tab">
                        <iframe class="tunnel-bg-white survey-frame" src="https://docs.google.com/forms/d/e/1FAIpQLSeOJqnXT2LxRK9GK6DfmYObzkbu28D-qT_XzN-vUBsUyaOX0Q/viewform?embedded=true" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <h5>Training Progress</h5>
                <hr class="bg-white">
                <p>*Placeholder</p>
                <img src="../media/assets/example.png" class="img-fluid mb-4" alt="example chart">

                <h5>My Schedule <button class="null-btn text-white border border-white"><i class="fas fa-plus-circle"></i></button></h5>
                <hr class="bg-white">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item bg-transparent text-center">No activities</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!--fitblog tab-->
        <div class="tab-pane fade py-4 pl-2 pr-0" style="padding-top: 100px !important" id="v-pills-fitblog" role="tabpanel" aria-labelledby="v-pills-fitblog-tab">
          <h1><span style="color: #ffa500">fit</span>blog</h1>

          <div class="content-panel dark-grad-fade-panel text-center">
            <div class="d-flex justify-content-center">
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading fitblog...</span>
              </div>
            </div>
          </div>
        </div>
        <!--Communication tab-->
        <div class="tab-pane fade py-4 pl-2 pr-0" style="padding-top: 100px !important" id="v-pills-communication" role="tabpanel" aria-labelledby="v-pills-communication-tab">
          <div class="row mx-2">
            <div class="col-xl py-4">
              <h1 class="mb-4 text-truncate">Communication</h1>

              <ul class="nav nav-tabs content-tab align-items-center" id="nav-tab-communication" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="communication-nav-notifications-tab" data-toggle="tab" href="#communication-nav-notifications" role="tab" aria-controls="communication-nav-notifications" aria-selected="true">Notifications</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="communication-nav-news-tab" data-toggle="tab" href="#communication-nav-news" role="tab" aria-controls="communication-nav-news" aria-selected="false">News</a>
                </li>
              </ul>
              <div class="tab-content" id="nav-tabcontent-communication">
                <div class="tab-pane fade show active" id="communication-nav-notifications" role="tabpanel" aria-labelledby="communication-nav-notifications-tab">
                  <?php echo $communicationUserNotifications; ?>
                </div>
                <div class="tab-pane fade" id="communication-nav-news" role="tabpanel" aria-labelledby="communication-nav-news-tab">
                  <?php echo  $communicationNews; ?>
                </div>
              </div>
            </div>
            <div class="col-xl py-4 tunnel-bg-whitez 80 content-panel dark-grad-fade-panel" style="border-radius: 25px">
              <h1 class="" style="color: #fff">Messages</h1>
              <hr class="bg-white" />
              <ul class="list-group list-group-flush" id="communication-messenger-list">
                <?php echo $communicationUserMessages; ?>

                <!--<li class="list-group-item bg-transparent my-2">
                    <div class="row align-items-center">
                      <div class="col-lg-4">
                        <img src="../media/images/fitness/10.jpg" class="img-fluid" alt="" style="border-radius: 25px" />
                      </div>
                      <div class="col-lg py-2">
                        <div class="">Name Surname <span id="" class="msgr-username-tag">(@username)</span></div>
                        <div class="min-h-full-w text-truncate">Message...</div>
                        <div class="msgr-last-date-tag text-right">12/05/2021</div>
                      </div>
                      <div class="col-lg-2 py-2 text-center">
                        <button class="null-btn text-white shadow btn-block" style="font-size: large"><i class="fas fa-chevron-right"></i></button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item bg-transparent my-2">
                    <div class="row align-items-center">
                      <div class="col-lg-4">
                        <img src="../media/images/fitness/10.jpg" class="img-fluid" alt="" style="border-radius: 25px" />
                      </div>
                      <div class="col-lg py-2">
                        <div class="">Name Surname <span id="" class="msgr-username-tag">(@username)</span></div>
                        <div class="min-h-full-w text-truncate">Message...</div>
                        <div class="msgr-last-date-tag text-right">12/05/2021</div>
                      </div>
                      <div class="col-lg-2 py-2 text-center">
                        <button class="null-btn text-white shadow btn-block" style="font-size: large"><i class="fas fa-chevron-right"></i></button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item bg-transparent my-2">
                    <div class="row align-items-center">
                      <div class="col-lg-4">
                        <img src="../media/images/fitness/10.jpg" class="img-fluid" alt="" style="border-radius: 25px" />
                      </div>
                      <div class="col-lg py-2">
                        <div class="">Name Surname <span id="" class="msgr-username-tag">(@username)</span></div>
                        <div class="min-h-full-w text-truncate">Message...</div>
                        <div class="msgr-last-date-tag text-right">12/05/2021</div>
                      </div>
                      <div class="col-lg-2 py-2 text-center">
                        <button class="null-btn text-white shadow btn-block" style="font-size: large"><i class="fas fa-chevron-right"></i></button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item bg-transparent my-2">
                    <div class="row align-items-center">
                      <div class="col-lg-4">
                        <img src="../media/images/fitness/10.jpg" class="img-fluid" alt="" style="border-radius: 25px" />
                      </div>
                      <div class="col-lg py-2">
                        <div class="">Name Surname <span id="" class="msgr-username-tag">(@username)</span></div>
                        <div class="min-h-full-w text-truncate">Message...</div>
                        <div class="msgr-last-date-tag text-right">12/05/2021</div>
                      </div>
                      <div class="col-lg-2 py-2 text-center">
                        <button class="null-btn text-white shadow btn-block" style="font-size: large"><i class="fas fa-chevron-right"></i></button>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item bg-transparent my-2">
                    <div class="row align-items-center">
                      <div class="col-lg-4">
                        <img src="../media/images/fitness/10.jpg" class="img-fluid" alt="" style="border-radius: 25px" />
                      </div>
                      <div class="col-lg py-2">
                        <div class="">Name Surname <span id="" class="msgr-username-tag">(@username)</span></div>
                        <div class="min-h-full-w text-truncate">Message...</div>
                        <div class="msgr-last-date-tag text-right">12/05/2021</div>
                      </div>
                      <div class="col-lg-2 py-2 text-center">
                        <button class="null-btn text-white shadow btn-block" style="font-size: large"><i class="fas fa-chevron-right"></i></button>
                      </div>
                    </div>
                  </li>-->
              </ul>
            </div>
          </div>
        </div>
        <!--Settings tab-->
        <div class="tab-pane fade py-4 pl-2 pr-0" style="padding-top: 100px !important" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
          <h1 class="mb-4">Settings</h1>

          <div class="content-panel tunnel-bgz">
            <div class="row">
              <div class="col-lg-4">User Interface</div>
              <div class="col border-left border-white"></div>
            </div>

            <div class="row">
              <div class="col-lg-4">Account</div>
              <div class="col border-left border-white"></div>
            </div>

            <div class="row">
              <div class="col-lg-4">Privacy</div>
              <div class="col border-left border-white"></div>
            </div>

            <div class="row">
              <div class="col-lg-4">Referencing</div>
              <div class="col border-left border-white"></div>
            </div>

            <div class="row">
              <div class="col-lg-4">About Us</div>
              <div class="col border-left border-white"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../js/script.js"></script>

  <script>
    //current time
    var clock = setInterval(updateClock, 1000);
    var clockContainer = document.getElementById("clock-time");

    function updateClock() {
      var d = new Date();
      clockContainer.innerHTML = d.toLocaleTimeString();
    }

    function getUrlVars() {
      var vars = {};
      var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
        vars[key] = value;
      });
      return vars;
    }

    function getUrlParam(parameter, defaultvalue) {
      var urlparameter = defaultvalue;
      if (window.location.href.indexOf(parameter) > -1) {
        urlparameter = getUrlVars()[parameter];
      }
      return urlparameter;
    }

    var userParam = getUrlParam("usr", "null");

    /* Set the width of the sidebar to 250px (show it) */
    function openMessenger(conversationid, requestingUser, secondaryUser) {
      var vpw = window.innerWidth;
      var vph = window.innerHeight;

      if (vpw < 450) {
        //alert(vpw+" - 100%");
        document.getElementById("messenger-side-panel").style.width = "100%";
      } else {
        //alert(vpw+" - 50vw");
        document.getElementById("messenger-side-panel").style.width = "50vw";
      }


      //get converstaion messeges and load them in the conversation-container
      var convoContainer = document.getElementById('conversation-container');
      var messengerLoader = document.getElementById('messenger-loader');

      document.getElementById("messenger-loader-action").innerHTML = "Loading conversation...";

      //display the loader
      messengerLoader.style.display = "block";

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
            messengerLoader.style.display = "none";

            //add the conversation id in the conversation-id container on the messenger panel
            document.getElementById("conversation-id").innerHTML = conversationid;
            document.getElementById("sndr-username").innerHTML = requestingUser;
            document.getElementById("rcvr-username").innerHTML = secondaryUser;

            convoContainer.innerHTML = output;
          }
        }
      };
      xhttp.open("GET", "../scripts/get-conversation.php?cid=" + conversationid + "&requser=" + requestingUser, true);
      xhttp.send();
    }

    /* Set the width of the sidebar to 0 (hide it) */
    function closeMessenger() {
      document.getElementById("messenger-side-panel").style.width = "0";
    }

    function sendConversationMessage() {
      var message = document.getElementById("draft-conversation-msg-input").value;
      var conv_id = document.getElementById("conversation-id").innerHTML;

      var convoContainer = document.getElementById('conversation-container');
      var messengerLoader = document.getElementById('messenger-loader');

      document.getElementById("messenger-loader-action").innerHTML = `<i class="fas fa-paper-plane"></i> Sending...`;

      messengerLoader.style.display = "block";

      var messengerSender = document.getElementById('sndr-username').innerHTML;
      var messengerReceiver = document.getElementById('rcvr-username').innerHTML;

      //var d = new Date();
      var dateNow = Date.now();

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
          } else if (output == "sent") {
            messengerLoader.style.display = "none";

            convoContainer.innerHTML += `
              <div class="container bubble-right my-4 py-4 shadow" id="message-` + conv_id + `-null">
                <div class="row align-items-end">
                  <div class="col-10 border-right border-white">
                      <p class="d-block text-wrap">` + message + `</p>
                      <div class="d-block text-right">
                          <div class="d-inline">` + dateNow + `</div>
                          <div class="d-inline" style="color: #ffa500">--</div>
                      </div>
                  </div>
                  <div class="col-2 px-1 text-center">
                      <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" alt="profile thumbnail">
                  </div>
                </div>
              </div>`;

            document.getElementById("draft-conversation-msg-input").value = "";
          } else {
            convoContainer.innerHTML = `
              <div class="application-error-msg shadow d-block" id="application-error-msg">
                <h3 class=" d-block" style="color: red">An error has occured</h3>
                <p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('` + userParam + `','` + output + `')">support</a></p>
                <div class="application-error-msg-output d-block" style="font-size: 10px">Message not sent - Unexpected output: ` + output + `</div>
              </div>
              `;
          }
        }
      };
      xhttp.open("POST", "../scripts/send-message.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("msg=" + message + "&convid=" + conv_id + "&sndr=" + messengerSender + "&rcvr=" + messengerReceiver);
    }

    function contactSupport(username, otputmsg) {
      alert("Flag - Opening support request modal");
    }

    function openProfiler(user) {

    }

    function openFitblogDesigner() {
      var designerPanel = document.getElementById('fitblog-post-designer');

      designerPanel.style.display = "block";
    }

    function closeFitblogDesigner() {
      var designerPanel = document.getElementById('fitblog-post-designer');

      designerPanel.style.display = "none";
    }

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
    xhttp.open("GET", "../scripts/calender.php?month=" + currMonth + "&year=" + currYear, true);
    xhttp.send();
  </script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>

</html>