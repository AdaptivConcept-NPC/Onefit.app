<?php
session_start();
require("../config.php");

//Connection Test==============================================>
  // Check connection
  /*if ($dbconn->connect_error) {
      die("Connection failed: " . $dbconn->connect_error);
  }
  echo "Connected successfully";*/
  if($dbconn->connect_error) die("Fatal Error");
//end of Connection Test============================================>

//Declaring variables
$app_err_msg = "";
$output = "";
$profileUsersResourcesList = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getUserResources();
  }
}

function getUserResources() {
  //community and resource shares (latest 50 posts each)
  $sql = "SELECT * FROM community_resources cr INNER JOIN users u ON cr.shared_by = u.username WHERE cr.shared_by = '$currentUser_Usrnm';";

  if($result = mysqli_query($dbconn,$sql)){
    
    while($row = mysqli_fetch_assoc($result)){
      //`comm_resource_id`, `resource_title`, `resource_description`, `resource_type`, `resource_link`, `shared_by`, `share_date`
      $usrresources_resourceid = $row["comm_resource_id"];
      $usrresources_title = $row["resource_title"];
      $usrresources_description = $row["resource_description"];
      $usrresources_type = $row["resource_type"];
      $usrresources_link = $row["resource_link"];
      $usrresources_sharedate = $row["share_date"];

      $usrresources_sharename = $row["user_name"];
      $usrresources_sharesurname = $row["user_surname"];

      if($usrresources_type == "external link"){
        $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openExtLink('."'".$usrresources_link."'".')"><i class="fas fa-link"></i> Follow link</button>';
      }else if($usrresources_type == "profile link"){
        $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'profile'".')"><i class="fas fa-id-badge"></i> View profile</button>';
      }else if($usrresources_type == "post link"){
        $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'post'".')"><i class="fas fa-sticky-note"></i> Open post</button>';
      }else if($usrresources_type == "document link"){
        $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'document'".')"><i class="fas fa-file-alt"></i> View document</button>';
      }
      else if($usrresources_type == "media link"){
        $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'media'".')"><i class="fas fa-photo-video"></i> View media</button>';
      }

      $profileUsersResourcesList .= '
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="resource-'.$usrresources_resourceid.'-'.$currentUser_Usrnm.'" style="max-width: 100%!important">
        <div>
          <h3>'.$usrresources_title.' <span style="font-size: 10px">'.$usrresources_type.'</span></h3>
          <p><span style="color: #ffa500">'.$usrresources_description.'</span></p>
          <p><i class="fas fa-link"></i> | '.$usrresources_link.'</p>
          <p>Shared by: @'.$usrresources_type.'</p>

          '.$openlinkbtn.'

          <p class="text-right" style="font-size: 8px">'.$usrresources_sharedate.'</p>
        </div>
      </div>';
    }

    $output = $profileUsersResourcesList;
  }else{
    $output_msg = "|[System Error]|:. [Profile load (Users posts) - ".mysqli_error($dbconn)."]";
    $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
    //exit();

    $output = $app_err_msg;
  }

  return $output;
}
?>