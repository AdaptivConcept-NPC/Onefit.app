<?php
session_start();
require("../../../config.php");
require_once("../../../functions.php");

//Connection Test==============================================>
// Check connection
/*if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
  }
  echo "Connected successfully";*/
if ($dbconn->connect_error) die("Fatal Error");
//end of Connection Test============================================>

$username = sanitizeMySQL($dbconn, $_POST['onefitUserEmail']);
$password = sanitizeMySQL($dbconn, $_POST['onefitUserPassword']);
$userDetailsArray = array();
$foundUser = false;
$hashBypass = "";
$currentUserUsername =
  $currentUserFName =
  $currentUserLName = null;
$dateNow = date('Y-m-d ');
$timeNow = date('H-i-s');
$entry_ref = null;

$query = "SELECT * FROM `users` WHERE (`username` = '$username' OR `user_email` = '$username')";

$result = $dbconn->query($query);
if (!$result) die("A Fatal Error has occured. Please try again and if the problem persists, please contact the system administrator.");
//$output = "|[System Error]|:. [".mysqli_error($dbconn)."]";

$rows = $result->num_rows;

if ($rows == 0) {
  //there is no result so notify user that the account cannot be found
  header("Location: ../../../../../index.php?return=unf&usrn=$username");
} else {
  for ($j = 0; $j < $rows; ++$j) {
    $row = $result->fetch_array(MYSQLI_ASSOC);

    $_SESSION['currentUserAuth'] = true;
    $_SESSION['currentUserForename'] = $row["user_name"];
    $_SESSION['currentUserSurname'] = $row["user_surname"];
    $_SESSION['currentUserEmail'] = $row["user_email"];
    $_SESSION['currentUserUsername'] = $row["username"];
    $pwdHash = $row["password_hash"];

    $currentUserUsername = $row["username"];
    $currentUserFName = $row["user_name"];
    $currentUserLName = $row["user_surname"];
  }

  function closeDBConnection()
  {
    global $result, $dbconn;
    // $result->close();
    $result = null;
    $dbconn->close();
  }

  //HASH Bypass - Remove after fixing current password hashes in the db
  //$hashBypass = password_hash($password, PASSWORD_DEFAULT);

  $submissionFlag = false;

  // generate a entry reference string
  $entry_ref = generateAlphaNumericRandomString(6) . "_" . $dateNow . "_" . $timeNow;

  if (password_verify($password, $pwdHash)) {
    $submissionFlag = log_activity("user", "Signed in.", "$currentUserFName $currentUserLName ($currentUserUsername) signed into the app. <br/> <span data-barcode>[ $entry_ref ]</span>", "user_activity", "NULL", $currentUserUsername);
    if ($submissionFlag === true) {
      closeDBConnection();
      header("Location: ../../../../../app/?userauth=true&logged=yes");
    } else {
      closeDBConnection();
      die($submissionFlag);
      header("Location: ../../../../../app/?userauth=true&logged=no");
    }
  } else {
    closeDBConnection();
    header("Location: ../../../../../index.php?return=mismatch&usrn=$username");
  }
}
