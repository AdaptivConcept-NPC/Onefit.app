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
$communicationNews = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getCommunityNews();
  } 
}

function getCommunityNews() {
  //news
  $sql = "SELECT * FROM news n INNER JOIN users u ON n.created_by = u.username ORDER BY n.creation_date DESC";

  if($result = mysqli_query($dbconn,$sql)){
    
    while($row = mysqli_fetch_assoc($result)){
      //`article_id`, `article_title`, `content`, `created_by`, `creation_date`

      $news_id = $row["article_id"];
      $news_title = $row["article_title"];
      $news_content = $row["content"];
        $news_createdby = $row["created_by"];
      $news_date = $row["creation_date"];

      $news_poster_name = $row["user_name"];
      $news_poster_surname = $row["user_surname"];

      $communicationNews .= '
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="news-'.$news_id.'">
        <h3>'.$news_title.' <span style="font-size: 10px">By '.$news_poster_name.' '.$news_poster_surname.' (@'.$news_createdby.')</span></h3>
        <p><span style="color: #ffa500">'.$news_content.'</span></p>
        <p class="text-right" style="font-size: 8px">'.$news_date.'</p>
      </div>
      ';
    }

    $output = $communicationNews;
  }else{
    $output_msg = "|[System Error]|:. [Communications load (User notifications) - ".mysqli_error($dbconn)."]";
    $app_err_msg = '<div class="application-error-msg shadow d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">'.$output_msg.'</div></div>';
    //exit();

    $output = $app_err_msg;
  }
  
  return $output;
}
?>