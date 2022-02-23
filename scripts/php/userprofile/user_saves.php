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
$profileUsersFavesList = "";
$output = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getUserSaves();
  }
}

function getUserSaves() {
  //Favourites
  $sql = "SELECT * FROM ((fave_saves fs
  INNER JOIN users u ON fs.username = u.username) 
  INNER JOIN community_posts cp ON fs.fave_ref = cp.favourite_ref)
  WHERE fs.username = '$currentUser_Usrnm';";

  if($result = mysqli_query($dbconn,$sql)){
    while($row = mysqli_fetch_assoc($result)){
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
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="fave-'.$fave_id.'">
        <div class="row align-items-center p-2">
          <div class="col-md-4 text-center">
            <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
          </div>
          <div class="col-md-8">
            <h3>'.$poster_name.' '.$poster_surname.' <span style="font-size: 10px">@<span style="color: #ffa500">'.$poster_username.'</span></span></h3>
          </div>
        </div>
        <div class="post-content">
          <hr class="bg-white">

          <p class="my-2">'.$post_msg.'</p>
          <p class="text-right" style="font-size: 8px">'.$post_date.'</p>

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

    $output = $profileUsersFavesList;
  }else{
    $output_msg = "|[System Error]|:. [Discover load (All Groups) - ".mysqli_error($dbconn)."]";
    $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';

    $output = $app_err_msg;
  }

  return $output;
}
?>