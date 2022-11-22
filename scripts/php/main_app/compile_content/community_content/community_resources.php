<?php
session_start();
require("../scripts/php/config.php");

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
$homeCommunityResources = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getCommunityResources();
  } 
}

function getCommunityResources() {
  //fitness resources (latest 50 resources)
  $sql = "SELECT * FROM community_resources";

  if($result = mysqli_query($dbconn,$sql)){
    
    while($row = mysqli_fetch_assoc($result)){
      //`resource_title`, `resource_description`, `resource_type`, `resource_link`, `shared_by`, `share_date`
      $resourceid = $row["comm_resource_id"];
      $resource_title = $row["resource_title"];
      $resource_descr = $row["resource_description"];
      $resource_type = $row["resource_type"];
      $resource_link = $row["resource_link"];
      $sharedbyUsername = $row["shared_by"];
      $sharedate = $row["share_date"];

      if($resource_type == "external link"){
        $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openExtLink('."'".$resource_link."'".')"><i class="fas fa-link"></i> Follow link</button>';
      }else if($resource_type == "profile link"){
        $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'profile'".')"><i class="fas fa-id-badge"></i> View profile</button>';
      }else if($resource_type == "post link"){
        $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'post'".')"><i class="fas fa-sticky-note"></i> Open post</button>';
      }else if($resource_type == "document link"){
        $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'document'".')"><i class="fas fa-file-alt"></i> View document</button>';
      }else if($resource_type == "media link"){
        $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'media'".')"><i class="fas fa-photo-video"></i> View media</button>';
      }

      $homeCommunityResources .= '
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="resource-'.$resourceid.'-'.$sharedbyUsername.'">
        <div class="row align-items-center">
          <div class="col-md-4 text-center">
            <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
          </div>
          <div class="col-md-8">
            <h3>'.$resource_title.' <span style="font-size: 10px">'.$resource_type.'</span></h3>
            <p><span style="color: #ffa500">'.$resource_descr.'</span></p>
            <p><i class="fas fa-link"></i> | '.$resource_link.'</p>
            <p>Shared by: @'.$sharedbyUsername.'</p>

            '.$openlinkbtn.'

            <p class="text-right" style="font-size: 8px;">'.$sharedate.'</p>
          </div>
        </div>
      </div>';
    }
    //$discoverResourcesList = $homeCommunityResources;
    $output = $homeCommunityResources;
  }else{
    $output_msg = "|[System Error]|:. [Home load (Community resources) - ".mysqli_error($dbconn)."]";
    $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
    //exit();

    $output = $app_err_msg;
  }

  return $output;
}
