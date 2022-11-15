<?php
session_start();
require("../../config.php");

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
$profileUsersPostsList = "";
$output = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getUserUpdates();
  }
}

function getUserUpdates() {
  $sql = "SELECT * FROM community_posts cp INNER JOIN users u ON cp.username = u.username WHERE cp.username = '$currentUser_Usrnm';";

    if($result = mysqli_query($dbconn,$sql)){
      
      while($row = mysqli_fetch_assoc($result)){
        //`post_id`, `post_date`, `post_message`, `username`, `modified_date`, `favourite_ref`FROM `community_posts` WHERE 
        $usrposts_postid = $row["post_id"];
        $usrposts_postdate = $row["post_date"];
        $usrposts_message = $row["post_message"];
        $usrposts_user = $row["username"];
        $usrposts_faveref = $row["favourite_ref"];

        $usrposts_name = $row["user_name"];
        $usrposts_surname = $row["user_surname"];

        $profileUsersPostsList .= '
          <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="post-'.$usrposts_postid.'-'.$usrposts_user.'">
            <div class="row align-items-center p-2">
              <div class="col-md-4 text-center">
                '.$accountProdImg.'
              </div>
              <div class="col-md-8">
                <h3>'.$usrposts_name.' '.$usrposts_surname.' <span style="font-size: 10px">@<span style="color: #ffa500">'.$usrposts_user.'</span></span></h3>
              </div>
            </div>
            <div class="post-content">
              <hr class="bg-white">

              <p class="my-2">'.$usrposts_message.'</p>
              <p class="text-right" style="font-size: 8px">'.$usrposts_postdate.'</p>

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

      $output = $profileUsersPostsList;
    }else{
      $output_msg = "|[System Error]|:. [Profile load (Users posts) - ".mysqli_error($dbconn)."]";
      $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
      //exit();

      $output = $app_err_msg;
    }
  
  return $output;
}
?>