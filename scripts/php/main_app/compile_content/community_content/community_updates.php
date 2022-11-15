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
$homeCommunityPosts = "";
$output = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getCommunityUpdates();
  }
}

function getCommunityUpdates() {
  //community posts (latest 50 posts)
  $sql = "SELECT * FROM community_posts cp INNER JOIN users u ON cp.username = u.username;";

  if($result = mysqli_query($dbconn,$sql)){
    
    while($row = mysqli_fetch_assoc($result)){
      //`post_id`, `post_date`, `post_message`, `username`, `modified_date`, `favourite_ref`FROM `community_posts` WHERE 
      $commpost_postid = $row["post_id"];
      $commpost_postdate = $row["post_date"];
      $commpost_message = $row["post_message"];
      $commpost_user = $row["username"];
      $commpost_faveref = $row["favourite_ref"];

      $commpost_usr_name = $row["user_name"];
      $commpost_usr_surname = $row["user_surname"];

      $homeCommunityPosts .= '
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="post-'.$commpost_postid.'-'.$commpost_user.'">
          <div class="row align-items-center p-2">
            <div class="col-md-4 text-center">
              '.$accountProdImg.'
            </div>
            <div class="col-md-8">
              <h3>'.$commpost_usr_name.' '.$commpost_usr_surname.' <span style="font-size: 10px">@<span style="color: #ffa500">'.$commpost_user.'</span></span></h3>
            </div>
          </div>
          <div class="post-content">
            <hr class="bg-white">

            <p class="my-2 text-wrap">'.$commpost_message.'</p>
            <p class="text-right" style="font-size: 8px">'.$commpost_postdate.'</p>

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

    $output = $homeCommunityPosts;
  }else{
    $output_msg = "|[System Error]|:. [Home load (Community posts) - ".mysqli_error($dbconn)."]";
    $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
    //exit();

    $output = $app_err_msg;
  }
  
  return $output;
}
?>