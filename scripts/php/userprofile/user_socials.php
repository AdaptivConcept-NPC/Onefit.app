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

//declaring variables
$app_err_msg = "";
$socialItems = "";
$userSocialItemsList = "";
$output = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getUserSocials();
  } 
}

function getUserSocials() {
  //get the social details
  $sql = "SELECT social_network, handle, link FROM user_socials WHERE username = '$currentUser_Usrnm'";

  if($result = mysqli_query($dbconn,$sql)){
    
    while($row = mysqli_fetch_assoc($result)){
        //u.user_id, u.username, u.user_name, u.user_surname, u.id_number, u.user_email, u.contact_number, u.date_of_birth, u.user_gender, u.user_race, u.user_nationality, u.account_active
        $usr_socialnet = $row["social_network"];
        $usr_socialhandle = $row["handle"];
        $usr_sociallink = $row["link"];

        if($usr_socialnet == "facebook"){
          $socialNetworkIcon = '<i class="fab fa-facebook"></i>';
        }else if($usr_socialnet == "twitter"){
          $socialNetworkIcon = '<i class="fab fa-twitter"></i>';
        }else if($usr_socialnet == "instagram"){
          $socialNetworkIcon = '<i class="fab fa-instagram"></i>';
        }else if($usr_socialnet == "tumbler"){
          $socialNetworkIcon = '<i class="fab fa-tumblr"></i>';
        }else if($usr_socialnet == "whatsapp"){
          $socialNetworkIcon = '<i class="fab fa-whatsapp"></i>';
        }else if($usr_socialnet == "reddit"){
          $socialNetworkIcon = '<i class="fab fa-reddit"></i>';
        }else{
          $socialNetworkIcon = '<i class="fas fa-globe-africa"></i>';
        }

        $socialItems .= '<li class="list-group-item text-center text-dark bg-transparent rounded-pill shadow my-2 mx-1 social-link"><span class="p-2 mr-2 bg-warning" style="border-radius: 5px">'.$socialNetworkIcon.'</span><a href="'.$usr_sociallink.'">'.$usr_socialhandle.'</a></li>';
    }
    //echo $discoverPeopleList;
    //die();

    $userSocialItemsList = <<<_END
    <ul class="list-group list-group-horizontal-sm justify-content-center p-2 shadow" style="border-radius: 25px; background: #333">$socialItems</ul>
    _END;

    $output = $userSocialItemsList;
  }else{
    $output_msg = "|[System Error]|:. [Profile load (Social details) - ".mysqli_error($dbconn)."]";
    $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
    $output = $app_err_msg;
    //exit();
  }

  return $output;
}
?>