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
$communicationUserMessages = "";
$output = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getUserChats();
  }
}

function getUserChats() {
  //messages
  //$sql = "SELECT * FROM messages msg INNER JOIN users u ON msg.receiver = u.username WHERE msg.sender = '$currentUser_Usrnm';";
  /*$sql = "SELECT * FROM ((user_conversations uc 
  INNER JOIN users u ON uc.secondary_user = u.username) 
  INNER JOIN user_conversation_messages ucm  ON ucm.conversation_id = uc.conversation_id) 
  WHERE uc.primary_user = '$currentUser_Usrnm' ORDER BY ucm.send_date DESC LIMIT 1;";*/
  $sql = "SELECT * FROM user_conversations uc 
  INNER JOIN users u ON uc.secondary_user = u.username
  WHERE uc.primary_user = '$currentUser_Usrnm' ORDER BY uc.conversation_id DESC;";

  //LEFT OUTER JOIN user_conversation_messages ucm  ON ucm.conversation_id = uc.conversation_id) 

  if($result = mysqli_query($dbconn,$sql)){
    
    while($row = mysqli_fetch_assoc($result)){
      //ucm: `message_id`, `conversation_id`, `message`, `sender`, `receiver`, `send_date`, `message_read`
      //uc: `conversation_id`, `primary_user`, `secondary_user`, `conversation_start_date`
      //$msg_id = $row["message_id"];
      
      $convo_conversationid = $row["conversation_id"];
      //$convo_lastmsg = $row["message"];
      $convo_secondaryuser = $row["secondary_user"];
      //$convo_lastmsgdate = $row["send_date"];
      //$convo_msgread = $row["message_read"];

      $secondaryuser_name = $row["user_name"];
      $secondaryuser_surname = $row["user_surname"];

      $communicationUserMessages .= '
      <li class="list-group-item bg-transparent my-2" id="conversation-'.$convo_conversationid.'">
        <div class="row align-items-center content-panel-border-style" style="border-radius: 25px 0 25px 25px; overflow: hidden; background: #333">
          <div class="col-sm-4">
            <img src="../media/images/fitness/10.jpg" class="img-fluid" alt="" style="border-radius: 25px" />
          </div>
          <div class="col-sm py-2">
            <div class="">'.$secondaryuser_name.' '.$secondaryuser_surname.' <span id="" class="msgr-username-tag">(@'.$convo_secondaryuser.')</span></div>
          </div>
          <div class="col-sm-2 py-2 text-center">
            <button class="null-btn text-white shadow btn-block" onclick="openMessenger('."'".$convo_conversationid."'".', '."'".$currentUser_Usrnm."'".', '."'".$convo_secondaryuser."'".')" style="font-size: large"><i class="fas fa-chevron-right"></i></button>
          </div>
        </div>
      </li>';

      $output = $communicationUserMessages;
    }
  }else{
    $output_msg = "|[System Error]|:. [Communications load (User conversations list) - ".mysqli_error($dbconn)."]";
    $app_err_msg = '<div class="application-error-msg shadow d-block" id="application-error-msg"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">'.$output_msg.'</div></div>';
    //exit();
    
    $output = $app_err_msg;
  }

  return $output;
}
?>