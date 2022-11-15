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
$profileUserMediaList = "";
$output = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getUserMedia();
  }
}

function getUserMedia() {
  //users media items
  //Get a list of file paths using the glob function.
  $fileList = glob("../../media/profiles/$currentUser_Usrnm/*");

  //Loop through the array that glob returned.
  foreach($fileList as $filename){
  //Simply print them out onto the screen.
  //echo $filename, '<br>'; 
  $profileUserMediaList .= '
    <div class="grid-tile p-0 mx-0 content-panel-border-style my-4 center-container" style="overflow: hidden; max-height: 200px">
    <img src="'.$filename.'" class="img-fluidz" alt="media image" style="height: 100%">
    </div>';
  }

  $output = $profileUserMediaList;

  return $output;
}
?>