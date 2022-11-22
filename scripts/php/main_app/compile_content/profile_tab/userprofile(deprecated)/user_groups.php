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
$profileUserSubsGroupsList = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getUserGroups();
  } 
}

function getUserGroups() {
  //groups that the user is a member of
  $sql = "SELECT * FROM groups g INNER JOIN group_members gm ON  g.group_ref_code = gm.group_ref_code WHERE gm.username = '$currentUser_Usrnm';"; //

  $groupMemsArray = array();
  $foundGroup = false;

  if($result = mysqli_query($dbconn,$sql)){
    
    while($row = mysqli_fetch_assoc($result)){
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
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="group-'.$grps_groupid.'-'.$grps_refcode.'">
        <div class="row align-items-center">
          <div class="col-md -4 text-center">
            <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
          </div>
          <div class="col-md -8">
            <h3>'.$grps_name.' <span style="font-size: 10px">'.$grps_privacy.'</span></h3>
            <p><span style="color: #ffa500">'.$grps_description.'</span></p>
            <p>'.$grps_category.'</p>
            <button class="null-btn shadow mt-4" onclick="openGroup('."'".$grps_refcode."'".')"><i class="fas fa-chevron-circle-right"></i> Open group</button>
            <p class="text-right" style="font-size: 8px;">'.$grps_createdate.'</p>
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
  }else{
    $output_msg = "|[System Error]|:. [Profile load (Users groups) - ".mysqli_error($dbconn)."]";
    $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
    //exit();

    $output = $app_err_msg;
  }

  return $output;
}
