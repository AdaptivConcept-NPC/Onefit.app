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
if ($dbconn->connection_error) die("Fatal Error");
//end of Connection Test============================================>

$username = sanitizeMySQL($dbconn, $_POST['onefitUserEmail']);
$password = sanitizeMySQL($dbconn, $_POST['onefitUserPassword']);
$userDetailsArray = array();
$foundUser = false;
$hashBypass = "";

$query = "SELECT * FROM `users` WHERE (`username` = '$username' OR `user_email` = '$username') #AND `password_hash` = '$password'";

$result = $dbconn->query($query);
if (!$result) die("A Fatal Error has occured. Please try again and if the problem persists, please contact the system administrator.");
//$output = "|[System Error]|:. [".mysqli_error($dbconn)."]";

$rows = $result->num_rows;

if ($rows == 0) {
  //there is no result so notify user that the account cannot be found
  header("Location: ../../../../../index.html?return=unf&usrn=$username");
} else {
  for ($j = 0; $j < $rows; ++$j) {
    $row = $result->fetch_array(MYSQLI_ASSOC);

    $_SESSION['currentUserAuth'] = true;
    $_SESSION['currentUserForename'] = $row["user_name"];
    $_SESSION['currentUserSurname'] = $row["user_surname"];
    $_SESSION['currentUserEmail'] = $row["user_email"];
    $_SESSION['currentUserUsername'] = $row["username"];
    $pwdHash = $row["password_hash"];
  }

  $result->close();
  $dbconn->close();

  //HASH Bypass - Remove after fixing current password hashes in the db
  //$hashBypass = password_hash($password, PASSWORD_DEFAULT);

  if (password_verify($password, $pwdHash)) header("Location: ../../../../../app/?userauth=true");
  else header("Location: ../../../../../index.html?return=mismatch&usrn=$username");
}

//Sanitization
/* function sanitizeString($var){
  if(get_magic_quotes_gpc())
  $var = stripslashes($var);
  $var = strip_tags($var);
  $var = htmlentities($var);
  return $var;
}

function sanitizeMySQL($connection, $var){
  $var = $connection->real_escape_string($var);
  $var = sanitizeString($var);
  return $var;
} */
