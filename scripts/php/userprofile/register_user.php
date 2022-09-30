<?php
session_start();
require("../config.php");
require_once("../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Declare Variables
  $name = $surname = $email = $contact = $idnum = $dob = $gender = $race = $nation = $usrnm = $pwdhash = "";

  $name = sanitizeMySQL($dbconn, $_POST['reg-name']);
  $surname = sanitizeMySQL($dbconn, $_POST['reg-surname']);
  $email = sanitizeMySQL($dbconn, $_POST['reg-email']);
  $contact = sanitizeMySQL($dbconn, $_POST['reg-contact']);
  $idnum = sanitizeMySQL($dbconn, $_POST['reg-idnum']);
  $dob = sanitizeMySQL($dbconn, $_POST['reg-dob']);
  $gender = sanitizeMySQL($dbconn, $_POST['reg-gender']);
  $race = sanitizeMySQL($dbconn, $_POST['reg-race']);
  $nation = sanitizeMySQL($dbconn, $_POST['reg-nationality']);
  $usrnm = sanitizeMySQL($dbconn, $_POST['reg-username']);
  $pwd = sanitizeMySQL($dbconn, $_POST['reg-confirmpassword']);
  $pwdhash = password_hash($pwd, PASSWORD_DEFAULT);

  $query = "INSERT INTO users VALUES(null, '$usrnm', '$pwdhash', '$name', '$surname', '$idnum', '$email', '$contact', '$dob', '$gender', '$race', '$nation', 0)";

  $result = $dbconn->query($query);
  //if (!$result) die("An error occurred - " . mysqli_error($dbconn)); //Admin
  if (!$result) die("An error occurred while trying to save your details.");

  $dbconn->close();

  header("Location: ../../../registration/profile_builder.html?panel=1&id=");

  //Prepare Statement - Getting Fata Error:  Uncaught Error: Cannot pass parameter 2 by reference in C:\wamp64\www\Onefit\scripts\php\userprofile\register_user.php on line 15
  /* $stmt = $dbconn->prepare('INSERT INTO users VALUES(?,?,?, ?,?,?, ?,?,?, ?,?,?, ?)');
  $stmt->bind_param('isssssssssssi', null, $usrnm, $pwdhash, $name, $surname, $idnum, $email, $contact, $dob, $gender, $race, $nation, 0);

  $name = sanitizeMySQL($dbconn, $_POST['reg-name']);
  $surname = sanitizeMySQL($dbconn, $_POST['reg-surname']);
  $email = sanitizeMySQL($dbconn, $_POST['reg-email']);
  $contact = sanitizeMySQL($dbconn, $_POST['reg-contact']);
  $idnum = sanitizeMySQL($dbconn, $_POST['reg-idnum']);
  $dob = sanitizeMySQL($dbconn, $_POST['reg-dob']);
  $gender = sanitizeMySQL($dbconn, $_POST['reg-gender']);
  $race = sanitizeMySQL($dbconn, $_POST['reg-race']);
  $nation = sanitizeMySQL($dbconn, $_POST['reg-nationality']);
  $usrnm = sanitizeMySQL($dbconn, $_POST['reg-username']);
  $pwd = sanitizeMySQL($dbconn, $_POST['reg-confirmpassword']);
  $pwdhash = password_hash($pwd, PASSWORD_DEFAULT);

  $stmt->execute();
  printf("%d Row inserted.\n", $stmt->affected_rows);

  $stmt->close();
  $dbconn->close();

  header("Location: ../../../registration/profile_builder.html?panel=1&id="); */
}

?>

/*$query = "INSERT INTO users(user_id, username, password_hash, user_name, user_surname, id_number, user_email, contact_number, date_of_birth, user_gender, user_race, user_nationality, account_active) VALUES (null, '$name', '$surname', '$email', '$contact', '$idnum', '$dob', '$gender', '$race', '$nation', '$usrnm', '$pwdhash', 0)";*/

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