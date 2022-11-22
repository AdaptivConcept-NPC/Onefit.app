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
$profileUserFriendsList = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getUserFriends();
  } 
}

function getUserFriends() {
  //users friends list
  $sql = "SELECT * FROM friends f INNER JOIN users u ON f.friend_username = u.username WHERE f.username = '$currentUser_Usrnm' AND f.friendship_status = 1";

  if($result = mysqli_query($dbconn,$sql)){
    
    while($row = mysqli_fetch_assoc($result)){
      $friendid = $row["friend_username"];
      $friendUsername = $row["friend_username"];

      $friendName = $row["user_name"];
      $friendSurname = $row["user_surname"];

      $profileUserFriendsList .= '
      <div class="grid-tile px-2 mx-0 container-fluid content-panel-border-style my-4" id="friend-'.$friendid.'-'.$friendUsername.'">
        <div class="row align-items-center">
          <div class="col-lg-2 text-center">
            <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
          </div>
          <div class="col-lg-6 text-center">
            <h3>'.$friendName.' '.$friendSurname.' <span style="font-size: 10px">@'.$friendUsername.'</span></h3>
          </div>
          <div class="col-lg-4 text-center">
            <button class="null-btn shadow" onclick="openProfiler('."'".$friendUsername."'".')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
          </div>
        </div>
      </div>';
    }

    $output = $profileUserFriendsList;
  }else{
    $output_msg = "|[System Error]|:. [Profile load (Users friends) - ".mysqli_error($dbconn)."]";
    $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
    //exit();

    $output = $app_err_msg;
  }

  return $output;
}
