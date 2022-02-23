<?php
//String Sanitization
function sanitizeString($var){
  if(get_magic_quotes_gpc())
  $var = stripslashes($var);
  $var = strip_tags($var);
  $var = htmlentities($var);
  return $var;
}
function sanitizeMySQL($connection, $var){
  $var = $connection->real_escape_string($var);
  $var = sanitizeString($var);
  return $var;
}
function generateRandomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

// //Content Load Functions - User Profile
// function getUserChallenges() {
//   $output = "Loading...";

//   return $output;
// }
// function getUserChats() {
//   //messages
//   //$sql = "SELECT * FROM messages msg INNER JOIN users u ON msg.receiver = u.username WHERE msg.sender = '$currentUser_Usrnm';";
//   /*$sql = "SELECT * FROM ((user_conversations uc 
//   INNER JOIN users u ON uc.secondary_user = u.username) 
//   INNER JOIN user_conversation_messages ucm  ON ucm.conversation_id = uc.conversation_id) 
//   WHERE uc.primary_user = '$currentUser_Usrnm' ORDER BY ucm.send_date DESC LIMIT 1;";*/
//   $sql = "SELECT * FROM user_conversations uc 
//   INNER JOIN users u ON uc.secondary_user = u.username
//   WHERE uc.primary_user = '$currentUser_Usrnm' ORDER BY uc.conversation_id DESC;";

//   //LEFT OUTER JOIN user_conversation_messages ucm  ON ucm.conversation_id = uc.conversation_id) 

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //ucm: `message_id`, `conversation_id`, `message`, `sender`, `receiver`, `send_date`, `message_read`
//       //uc: `conversation_id`, `primary_user`, `secondary_user`, `conversation_start_date`
//       //$msg_id = $row["message_id"];
      
//       $convo_conversationid = $row["conversation_id"];
//       //$convo_lastmsg = $row["message"];
//       $convo_secondaryuser = $row["secondary_user"];
//       //$convo_lastmsgdate = $row["send_date"];
//       //$convo_msgread = $row["message_read"];

//       $secondaryuser_name = $row["user_name"];
//       $secondaryuser_surname = $row["user_surname"];

//       $communicationUserMessages .= '
//       <li class="list-group-item bg-transparent my-2" id="conversation-'.$convo_conversationid.'">
//         <div class="row align-items-center content-panel-border-style" style="border-radius: 25px 0 25px 25px; overflow: hidden; background: #333">
//           <div class="col-sm-4">
//             <img src="../media/images/fitness/10.jpg" class="img-fluid" alt="" style="border-radius: 25px" />
//           </div>
//           <div class="col-sm py-2">
//             <div class="">'.$secondaryuser_name.' '.$secondaryuser_surname.' <span id="" class="msgr-username-tag">(@'.$convo_secondaryuser.')</span></div>
//           </div>
//           <div class="col-sm-2 py-2 text-center">
//             <button class="null-btn text-white shadow btn-block" onclick="openMessenger('."'".$convo_conversationid."'".', '."'".$currentUser_Usrnm."'".', '."'".$convo_secondaryuser."'".')" style="font-size: large"><i class="fas fa-chevron-right"></i></button>
//           </div>
//         </div>
//       </li>';

//       $output = $communicationUserMessages;
//     }
//   }else{
//     $output_msg = "|[System Error]|:. [Communications load (User conversations list) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow d-block" id="application-error-msg"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();
    
//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserFriends() {
//   //users friends list
//   $sql = "SELECT * FROM friends f INNER JOIN users u ON f.friend_username = u.username WHERE f.username = '$currentUser_Usrnm' AND f.friendship_status = 1";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       $friendid = $row["friend_username"];
//       $friendUsername = $row["friend_username"];

//       $friendName = $row["user_name"];
//       $friendSurname = $row["user_surname"];

//       $profileUserFriendsList .= '
//       <div class="grid-tile px-2 mx-0 container-fluid content-panel-border-style my-4" id="friend-'.$friendid.'-'.$friendUsername.'">
//         <div class="row align-items-center">
//           <div class="col-lg-2 text-center">
//             <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
//           </div>
//           <div class="col-lg-6 text-center">
//             <h3>'.$friendName.' '.$friendSurname.' <span style="font-size: 10px">@'.$friendUsername.'</span></h3>
//           </div>
//           <div class="col-lg-4 text-center">
//             <button class="null-btn shadow" onclick="openProfiler('."'".$friendUsername."'".')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
//           </div>
//         </div>
//       </div>';
//     }

//     $output = $profileUserFriendsList;
//   }else{
//     $output_msg = "|[System Error]|:. [Profile load (Users friends) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserGroups() {
//   //groups that the user is a member of
//   $sql = "SELECT * FROM groups g INNER JOIN group_members gm ON  g.group_ref_code = gm.group_ref_code WHERE gm.username = '$currentUser_Usrnm';"; //

//   $groupMemsArray = array();
//   $foundGroup = false;

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       $foundGroup = true;

//       $grps_groupid = $row["group_id"];
//       $grps_refcode = $row["group_ref_code"];

//       $grps_name = $row["group_name"];
//       $grps_description = $row["group_description"];
//       $grps_category = $row["group_category"];
//       $grps_privacy = $row["group_privacy"];
//       $grps_createdby = $row["created_by"];
//       $grps_createdate = $row["creation_date"];

//       $profileUserSubsGroupsList .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="group-'.$grps_groupid.'-'.$grps_refcode.'">
//         <div class="row align-items-center">
//           <div class="col-md -4 text-center">
//             <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
//           </div>
//           <div class="col-md -8">
//             <h3>'.$grps_name.' <span style="font-size: 10px">'.$grps_privacy.'</span></h3>
//             <p><span style="color: #ffa500">'.$grps_description.'</span></p>
//             <p>'.$grps_category.'</p>
//             <button class="null-btn shadow mt-4" onclick="openGroup('."'".$grps_refcode."'".')"><i class="fas fa-chevron-circle-right"></i> Open group</button>
//             <p class="text-right" style="font-size: 8px;">'.$grps_createdate.'</p>
//           </div>
//         </div>
//       </div>';

//         $groupMemsArray = $row;
//     }
//     /*echo $discoverGroupsList;
//     echo "<br>";
//     echo "<br>";
//     echo "<br>";
//     echo json_encode($groupMemsArray);
//     die();*/

//     $output = $profileUserSubsGroupsList;
//   }else{
//     $output_msg = "|[System Error]|:. [Profile load (Users groups) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserMedia() {
//   //users media items
//   //Get a list of file paths using the glob function.
//   $fileList = glob("../../media/profiles/$currentUser_Usrnm/*");

//   //Loop through the array that glob returned.
//   foreach($fileList as $filename){
//   //Simply print them out onto the screen.
//   //echo $filename, '<br>'; 
//   $profileUserMediaList .= '
//     <div class="grid-tile p-0 mx-0 content-panel-border-style my-4 center-container" style="overflow: hidden; max-height: 200px">
//     <img src="'.$filename.'" class="img-fluidz" alt="media image" style="height: 100%">
//     </div>';
//   }

//   $output = $profileUserMediaList;

//   return $output;
// }
// function getUserNotifications() {
//   //notifications
//   $sql = "SELECT * FROM notifications WHERE notify_user = '$currentUser_Usrnm' ORDER BY created_by DESC";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //`notification_id`, `notification_title`, `notification_message`, `notify_user`, `created_by`, `notification_date`, `notification_read`

//       $notif_id = $row["notification_id"];
//       $notif_title = $row["notification_title"];
//       $notif_message = $row["notification_message"];
//       $notif_date = $row["notification_date"];

//       $communicationUserNotifications .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="notifcation-'.$notif_id.'">
//         <h3>'.$notif_title.'</h3>
//         <p><span style="color: #ffa500">'.$notif_message.'</span></p>
//         <p>'.$grps_category.'</p>
//         <p class="text-right" style="font-size: 8px">'.$notif_date.'</p>
//       </div>
//       ';
//     }

//     $output = $communicationUserNotifications;
//   }else{
//     $output_msg = "|[System Error]|:. [Communications load (User notifications) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserPref() {
//   $output = "Loading...";
//   return $output;
// }
// function getUserProgSubs() {
//   //subscriptions (programs)
//   //$sql = "SELECT * FROM training_programs;";
//   $sql = "SELECT ps.prog_subscriber_id, ps.username, ps.program_ref_code, ps.subscribe_date, tp.program_id, tp.program_title, tp.program_description, tp.program_duration, tp.program_category, tp.program_privacy, tp.created_by, tp.active 
//   FROM program_subscribers ps 
//   INNER JOIN training_programs tp ON ps.program_ref_code = tp.program_ref_code 
//   WHERE username = '$currentUser_Usrnm'";

//   if($result = mysqli_query($dbconn,$sql)){
//     while($row = mysqli_fetch_assoc($result)){
//       //TP: `program_id`, `program_ref_code`, `program_title`, `program_description`, `program_duration`, `program_category`, `program_privacy`, `created_by`, `creation_date`, `active` 
//       //PA: `prog_activity_id`, `activity_title`, `activity_description`, `activity_duration`, `activity_reps`, `activity_sets`, `achievement_id`, `program_ref_code`
//       $programs_progid = $row["program_id"];
//       $programs_refcode = $row["program_ref_code"];
//       $programs_title = $row["program_title"];
//       $programs_description = $row["program_description"];
//       $programs_duration = $row["program_duration"];
//       $programs_category = $row["program_category"];
//       $programs_privacy = $row["program_privacy"];
//       $programs_creator = $row["created_by"];
//       $programs_active = $row["active"];

//       /*$programs_activityid = $row["prog_activity_id"];
//       $programs_activitytitle = $row["activity_title"];
//       $programs_activityduration = $row["activity_duration"];*/

//       $profileUsersProgramsList .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="discover_programs-'.$programs_progid.'-'.$programs_refcode.'">
//         <div class="card bg-transparent">
//           <div class="card-body">
//             <h3 class="card-title">'.$programs_title.' <span style="font-size: 10px">('.$programs_privacy.')</span></h3>
//             <p class="card-subtitle ">Trainer: @'.$programs_creator.'</p>
//             <p class="card-text">'.$programs_description.'</p>
//             <div class="text-center">
//               <button class="null-btn m-4 shadow" onclick="openProgram('."'".$programs_refcode."'".')"><i class="fas fa-chevron-circle-right"></i> View program</button>
//             </div>
//           </div>
//         </div>
//       </div>';
//     }

//     $output = $profileUsersProgramsList;
//    } else{
//     $output_msg = "|[System Error]|:. [Discover load (All Groups) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserResources() {
//   //community and resource shares (latest 50 posts each)
//   $sql = "SELECT * FROM community_resources cr INNER JOIN users u ON cr.shared_by = u.username WHERE cr.shared_by = '$currentUser_Usrnm';";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //`comm_resource_id`, `resource_title`, `resource_description`, `resource_type`, `resource_link`, `shared_by`, `share_date`
//       $usrresources_resourceid = $row["comm_resource_id"];
//       $usrresources_title = $row["resource_title"];
//       $usrresources_description = $row["resource_description"];
//       $usrresources_type = $row["resource_type"];
//       $usrresources_link = $row["resource_link"];
//       $usrresources_sharedate = $row["share_date"];

//       $usrresources_sharename = $row["user_name"];
//       $usrresources_sharesurname = $row["user_surname"];

//       if($usrresources_type == "external link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openExtLink('."'".$usrresources_link."'".')"><i class="fas fa-link"></i> Follow link</button>';
//       }else if($usrresources_type == "profile link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'profile'".')"><i class="fas fa-id-badge"></i> View profile</button>';
//       }else if($usrresources_type == "post link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'post'".')"><i class="fas fa-sticky-note"></i> Open post</button>';
//       }else if($usrresources_type == "document link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'document'".')"><i class="fas fa-file-alt"></i> View document</button>';
//       }
//       else if($usrresources_type == "media link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'media'".')"><i class="fas fa-photo-video"></i> View media</button>';
//       }

//       $profileUsersResourcesList .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="resource-'.$usrresources_resourceid.'-'.$currentUser_Usrnm.'" style="max-width: 100%!important">
//         <div>
//           <h3>'.$usrresources_title.' <span style="font-size: 10px">'.$usrresources_type.'</span></h3>
//           <p><span style="color: #ffa500">'.$usrresources_description.'</span></p>
//           <p><i class="fas fa-link"></i> | '.$usrresources_link.'</p>
//           <p>Shared by: @'.$usrresources_type.'</p>

//           '.$openlinkbtn.'

//           <p class="text-right" style="font-size: 8px">'.$usrresources_sharedate.'</p>
//         </div>
//       </div>';
//     }

//     $output = $profileUsersResourcesList;
//   }else{
//     $output_msg = "|[System Error]|:. [Profile load (Users posts) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserSaves() {
//   //Favourites
//   $sql = "SELECT * FROM ((fave_saves fs
//   INNER JOIN users u ON fs.username = u.username) 
//   INNER JOIN community_posts cp ON fs.fave_ref = cp.favourite_ref)
//   WHERE fs.username = '$currentUser_Usrnm';";

//   if($result = mysqli_query($dbconn,$sql)){
//     while($row = mysqli_fetch_assoc($result)){
//       $fave_id = $row['fave_id'];
//       $fave_ref = $row['fave_ref'];
//       $fave_date = $row['fave_date'];
//       $post_id = $row['post_id'];
//       $post_date = $row['post_date'];
//       $post_msg = $row['post_message'];
//       $mod_date = $row['modified_date'];

//       $poster_name = $row['user_name'];
//       $poster_surname = $row['user_surname'];
//       $poster_username = $row['username'];

//       $profileUsersFavesList .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="fave-'.$fave_id.'">
//         <div class="row align-items-center p-2">
//           <div class="col-md-4 text-center">
//             <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
//           </div>
//           <div class="col-md-8">
//             <h3>'.$poster_name.' '.$poster_surname.' <span style="font-size: 10px">@<span style="color: #ffa500">'.$poster_username.'</span></span></h3>
//           </div>
//         </div>
//         <div class="post-content">
//           <hr class="bg-white">

//           <p class="my-2">'.$post_msg.'</p>
//           <p class="text-right" style="font-size: 8px">'.$post_date.'</p>

//           <!--function buttons-->
//           <ul class="list-group list-group-horizontal -sm mt-4">
//             <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//               <i class="fas fa-heart"></i> <span class="d-none d-lg-block">Dope</span>
//             </li>
//             <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//               <i class="fas fa-comment-alt"></i> <span class="d-none d-lg-block">Comment</span>
//             </li>
//             <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//               <i class="fas fa-share-alt"></i> <span class="d-none d-lg-block">Share</span>
//             </li>
//             <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-0">
//               <i class="fas fa-bookmark"></i> <span class="d-none d-lg-block">Fave</span>
//             </li>
//           </ul>
//         </div>
//       </div>';
//     }

//     $output = $profileUsersFavesList;
//   }else{
//     $output_msg = "|[System Error]|:. [Discover load (All Groups) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserSocials() {
//   //get the social details
//   $sql = "SELECT social_network, handle, link FROM user_socials WHERE username = '$currentUser_Usrnm'";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//         //u.user_id, u.username, u.user_name, u.user_surname, u.id_number, u.user_email, u.contact_number, u.date_of_birth, u.user_gender, u.user_race, u.user_nationality, u.account_active
//         $usr_socialnet = $row["social_network"];
//         $usr_socialhandle = $row["handle"];
//         $usr_sociallink = $row["link"];

//         if($usr_socialnet == "facebook"){
//           $socialNetworkIcon = '<i class="fab fa-facebook"></i>';
//         }else if($usr_socialnet == "twitter"){
//           $socialNetworkIcon = '<i class="fab fa-twitter"></i>';
//         }else if($usr_socialnet == "instagram"){
//           $socialNetworkIcon = '<i class="fab fa-instagram"></i>';
//         }else if($usr_socialnet == "tumbler"){
//           $socialNetworkIcon = '<i class="fab fa-tumblr"></i>';
//         }else if($usr_socialnet == "whatsapp"){
//           $socialNetworkIcon = '<i class="fab fa-whatsapp"></i>';
//         }else if($usr_socialnet == "reddit"){
//           $socialNetworkIcon = '<i class="fab fa-reddit"></i>';
//         }else{
//           $socialNetworkIcon = '<i class="fas fa-globe-africa"></i>';
//         }

//         $socialItems .= '<li class="list-group-item text-center text-dark bg-transparent rounded-pill shadow my-2 mx-1 social-link"><span class="p-2 mr-2 bg-warning" style="border-radius: 5px">'.$socialNetworkIcon.'</span><a href="'.$usr_sociallink.'">'.$usr_socialhandle.'</a></li>';
//     }
//     //echo $discoverPeopleList;
//     //die();

//     $userSocialItemsList = <<<_END
//     <ul class="list-group list-group-horizontal-sm justify-content-center p-2 shadow" style="border-radius: 25px; background: #333">$socialItems</ul>
//     _END;

//     $output = $userSocialItemsList;
//   }else{
//     $output_msg = "|[System Error]|:. [Profile load (Social details) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     $output = $app_err_msg;
//     //exit();
//   }

//   return $output;
// }
// function getUserUpdates() {
//   $sql = "SELECT * FROM community_posts cp INNER JOIN users u ON cp.username = u.username WHERE cp.username = '$currentUser_Usrnm';";

//     if($result = mysqli_query($dbconn,$sql)){
      
//       while($row = mysqli_fetch_assoc($result)){
//         //`post_id`, `post_date`, `post_message`, `username`, `modified_date`, `favourite_ref`FROM `community_posts` WHERE 
//         $usrposts_postid = $row["post_id"];
//         $usrposts_postdate = $row["post_date"];
//         $usrposts_message = $row["post_message"];
//         $usrposts_user = $row["username"];
//         $usrposts_faveref = $row["favourite_ref"];

//         $usrposts_name = $row["user_name"];
//         $usrposts_surname = $row["user_surname"];

//         $profileUsersPostsList .= '
//           <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="post-'.$usrposts_postid.'-'.$usrposts_user.'">
//             <div class="row align-items-center p-2">
//               <div class="col-md-4 text-center">
//                 '.$accountProdImg.'
//               </div>
//               <div class="col-md-8">
//                 <h3>'.$usrposts_name.' '.$usrposts_surname.' <span style="font-size: 10px">@<span style="color: #ffa500">'.$usrposts_user.'</span></span></h3>
//               </div>
//             </div>
//             <div class="post-content">
//               <hr class="bg-white">

//               <p class="my-2">'.$usrposts_message.'</p>
//               <p class="text-right" style="font-size: 8px">'.$usrposts_postdate.'</p>

//               <!--function buttons-->
//               <ul class="list-group list-group-horizontal -sm mt-4">
//                 <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                   <i class="fas fa-heart"></i> <span class="d-none d-lg-block">Dope</span>
//                 </li>
//                 <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                   <i class="fas fa-comment-alt"></i> <span class="d-none d-lg-block">Comment</span>
//                 </li>
//                 <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                   <i class="fas fa-share-alt"></i> <span class="d-none d-lg-block">Share</span>
//                 </li>
//                 <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-0">
//                   <i class="fas fa-bookmark"></i> <span class="d-none d-lg-block">Fave</span>
//                 </li>
//               </ul>
//             </div>
//           </div>';
//       }

//       $output = $profileUsersPostsList;
//     }else{
//       $output_msg = "|[System Error]|:. [Profile load (Users posts) - ".mysqli_error($dbconn)."]";
//       $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//       //exit();

//       $output = $app_err_msg;
//     }
  
//   return $output;
// }

// //Content Load Functions - Community Content
// function getCommunityGroups() {
//   //groups
//   $sql = "SELECT * FROM groups";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//         //`group_id`, `group_ref_code`, `group_name`, `group_description`, `group_category`, `group_privacy`, `created_by`, `creation_date`
        
//         $grps_groupid = $row["group_id"];
//         $grps_refcode = $row["group_ref_code"];
//         $grps_name = $row["group_name"];
//         $grps_description = $row["group_description"];
//         $grps_category = $row["group_category"];
//         $grps_privacy = $row["group_privacy"];
//         $grps_createdby = $row["created_by"];
//         $grps_createdate = $row["creation_date"];

//         $discoverGroupsList .= '
//         <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="discover_groups-'.$grps_groupid.'-'.$grps_refcode.'">
//           <div class="row align-items-center">
//             <div class="col-md -4 text-center">
//               <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
//             </div>
//             <div class="col-md -8">
//               <h3>'.$grps_name.' <span style="font-size: 10px">'.$grps_privacy.'</span></h3>
//               <p><span style="color: #ffa500">'.$grps_description.'</span></p>
//               <p>'.$grps_category.'</p>
//               <button class="null-btn shadow mt-4" onclick="openGroup('."'".$grps_refcode."'".')"><i class="fas fa-chevron-circle-right"></i> Open group</button>
//               <p class="text-right" style="font-size: 8px">'.$grps_createdate.'</p>
//             </div>
//           </div>
//         </div>';
//     }
//     //echo $discoverPeopleList;
//     //die();

//     $output = $discoverGroupsList;
//   }else{
//     $output_msg = "|[System Error]|:. [Discover load (All Groups) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }
  
//   return $output;
// }
// function getCommunityNews() {
//   //news
//   $sql = "SELECT * FROM news n INNER JOIN users u ON n.created_by = u.username ORDER BY n.creation_date DESC";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //`article_id`, `article_title`, `content`, `created_by`, `creation_date`

//       $news_id = $row["article_id"];
//       $news_title = $row["article_title"];
//       $news_content = $row["content"];
//         $news_createdby = $row["created_by"];
//       $news_date = $row["creation_date"];

//       $news_poster_name = $row["user_name"];
//       $news_poster_surname = $row["user_surname"];

//       $communicationNews .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="news-'.$news_id.'">
//         <h3>'.$news_title.' <span style="font-size: 10px">By '.$news_poster_name.' '.$news_poster_surname.' (@'.$news_createdby.')</span></h3>
//         <p><span style="color: #ffa500">'.$news_content.'</span></p>
//         <p class="text-right" style="font-size: 8px">'.$news_date.'</p>
//       </div>
//       ';
//     }

//     $output = $communicationNews;
//   }else{
//     $output_msg = "|[System Error]|:. [Communications load (User notifications) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }
  
//   return $output;
// }
// function getCommunityResources() {
//   //fitness resources (latest 50 resources)
//   $sql = "SELECT * FROM community_resources";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //`resource_title`, `resource_description`, `resource_type`, `resource_link`, `shared_by`, `share_date`
//       $resourceid = $row["comm_resource_id"];
//       $resource_title = $row["resource_title"];
//       $resource_descr = $row["resource_description"];
//       $resource_type = $row["resource_type"];
//       $resource_link = $row["resource_link"];
//       $sharedbyUsername = $row["shared_by"];
//       $sharedate = $row["share_date"];

//       if($resource_type == "external link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openExtLink('."'".$resource_link."'".')"><i class="fas fa-link"></i> Follow link</button>';
//       }else if($resource_type == "profile link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'profile'".')"><i class="fas fa-id-badge"></i> View profile</button>';
//       }else if($resource_type == "post link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'post'".')"><i class="fas fa-sticky-note"></i> Open post</button>';
//       }else if($resource_type == "document link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'document'".')"><i class="fas fa-file-alt"></i> View document</button>';
//       }else if($resource_type == "media link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'media'".')"><i class="fas fa-photo-video"></i> View media</button>';
//       }

//       $homeCommunityResources .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="resource-'.$resourceid.'-'.$sharedbyUsername.'">
//         <div class="row align-items-center">
//           <div class="col-md-4 text-center">
//             <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
//           </div>
//           <div class="col-md-8">
//             <h3>'.$resource_title.' <span style="font-size: 10px">'.$resource_type.'</span></h3>
//             <p><span style="color: #ffa500">'.$resource_descr.'</span></p>
//             <p><i class="fas fa-link"></i> | '.$resource_link.'</p>
//             <p>Shared by: @'.$sharedbyUsername.'</p>

//             '.$openlinkbtn.'

//             <p class="text-right" style="font-size: 8px;">'.$sharedate.'</p>
//           </div>
//         </div>
//       </div>';
//     }
//     //$discoverResourcesList = $homeCommunityResources;
//     $output = $homeCommunityResources;
//   }else{
//     $output_msg = "|[System Error]|:. [Home load (Community resources) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getCommunityUpdates() {
//   //community posts (latest 50 posts)
//   $sql = "SELECT * FROM community_posts cp INNER JOIN users u ON cp.username = u.username;";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //`post_id`, `post_date`, `post_message`, `username`, `modified_date`, `favourite_ref`FROM `community_posts` WHERE 
//       $commpost_postid = $row["post_id"];
//       $commpost_postdate = $row["post_date"];
//       $commpost_message = $row["post_message"];
//       $commpost_user = $row["username"];
//       $commpost_faveref = $row["favourite_ref"];

//       $commpost_usr_name = $row["user_name"];
//       $commpost_usr_surname = $row["user_surname"];

//       $homeCommunityPosts .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="post-'.$commpost_postid.'-'.$commpost_user.'">
//           <div class="row align-items-center p-2">
//             <div class="col-md-4 text-center">
//               '.$accountProdImg.'
//             </div>
//             <div class="col-md-8">
//               <h3>'.$commpost_usr_name.' '.$commpost_usr_surname.' <span style="font-size: 10px">@<span style="color: #ffa500">'.$commpost_user.'</span></span></h3>
//             </div>
//           </div>
//           <div class="post-content">
//             <hr class="bg-white">

//             <p class="my-2 text-wrap">'.$commpost_message.'</p>
//             <p class="text-right" style="font-size: 8px">'.$commpost_postdate.'</p>

//             <!--function buttons-->
//             <ul class="list-group list-group-horizontal -sm mt-4">
//               <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                 <i class="fas fa-heart"></i> <span class="d-none d-lg-block">Dope</span>
//               </li>
//               <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                 <i class="fas fa-comment-alt"></i> <span class="d-none d-lg-block">Comment</span>
//               </li>
//               <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                 <i class="fas fa-share-alt"></i> <span class="d-none d-lg-block">Share</span>
//               </li>
//               <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-0">
//                 <i class="fas fa-bookmark"></i> <span class="d-none d-lg-block">Fave</span>
//               </li>
//             </ul>
//           </div>
//         </div>';
//     }

//     $output = $homeCommunityPosts;
//   }else{
//     $output_msg = "|[System Error]|:. [Home load (Community posts) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }
  
//   return $output;
// }
?>