<?php
session_start();
require("../config.php");

//Connection Test==============================================>
// Check connection
/*if ($dbconn->connect_error) {
      die("Connection failed: " . $dbconn->connect_error);
  }
  echo "Connected successfully";*/
if ($dbconn->connect_error) die("Fatal Error");
//end of Connection Test============================================>

//Declaring variables
$app_err_msg = "";
$communicationUserNotifications = "";
$output = "";

if (isset($_SESSION["currentUserAuth"])) {
  if ($_SESSION["currentUserAuth"] == true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn, $_SESSION["currentUserAuth"]);

    echo getUserNotifications();
  }
}

function getUserNotifications()
{
  //notifications
  $sql = "SELECT * FROM notifications WHERE notify_user = '$currentUser_Usrnm' ORDER BY created_by DESC";

  if ($result = mysqli_query($dbconn, $sql)) {

    while ($row = mysqli_fetch_assoc($result)) {
      //`notification_id`, `notification_title`, `notification_message`, `notify_user`, `created_by`, `notification_date`, `notification_read`

      $notif_id = $row["notification_id"];
      $notif_title = $row["notification_title"];
      $notif_message = $row["notification_message"];
      $notif_date = $row["notification_date"];

      $communicationUserNotifications .= '
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="notifcation-' . $notif_id . '">
        <h3>' . $notif_title . '</h3>
        <p><span style="color: var(--primary-color)">' . $notif_message . '</span></p>
        <p>' . $grps_category . '</p>
        <p class="text-right" style="font-size: 8px">' . $notif_date . '</p>
      </div>
      ';
    }

    $output = $communicationUserNotifications;
  } else {
    $output_msg = "|[System Error]|:. [Communications load (User notifications) - " . mysqli_error($dbconn) . "]";
    $app_err_msg = '<div class="application-error-msg shadow d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output_msg . '</div></div>';
    //exit();

    $output = $app_err_msg;
  }

  return $output;
}
