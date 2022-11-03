<?php
session_start();
require("../../../config.php");
require_once("../../../functions.php");

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
  $usrnm = "onefit_ZA" . generateAlphaNumericRandomString(8); // sanitizeMySQL($dbconn, $_POST['reg-username']);
  $pwd = sanitizeMySQL($dbconn, $_POST['reg-confirmpassword']);
  $pwdhash = password_hash($pwd, PASSWORD_DEFAULT);

  // create user account record
  $query = "INSERT INTO `users` 
  (`user_id`, `username`, `password_hash`, `user_name`, `user_surname`, `id_number`, `user_email`, `contact_number`, `date_of_birth`, `user_gender`, `user_race`, `user_nationality`, `account_active`) 
  VALUES 
  (null, '$usrnm', '$pwdhash', '$name', '$surname', '$idnum', '$email', '$contact', '$dob', '$gender', '$race', '$nation', 0)";
  // die($query);
  $result = $dbconn->query($query);

  if (!$result) die("An error occurred while trying to save your details. [Reg-Err_01: " . $dbconn->error . "]");

  $user_id = $dbconn->insert_id;
  $result = null;

  $user_url_reference = generateAlphaNumericRandomString(20);

  // create user profile record
  $query = "INSERT INTO `general_user_profiles`
  (`user_profile_id`, `about`, `profile_type`, `verification`, `profile_url`, `profile_image_url`, `profile_banner_url`, `users_username`) 
  VALUES 
  (null,'Tell the community about who you are.','community','unverified','$user_url_reference','0_default/default_profile_pic.png','0_default/default_profile_banner.png','$usrnm')";

  $result = $dbconn->query($query);

  if (!$result) die("An error occurred while trying to save your details. [Reg-Err_02: " . $dbconn->error . "]");

  $profile_id = $dbconn->insert_id;

  $result = null;
  $dbconn->close();

  // create a media folder for the user 
  $dir_path = '../../../../../media/' . $usrnm;

  // Checking whether the directory exists or not
  if (!is_dir($dir_path)) {
    // does not exist, create a new file or direcotry
    if (mkdir($dir_path, 0777, true)) echo "User media folder created successfully";
    else die("User media folder creation failed [Directory path: $dir_path");
  } else {
    echo "$usrnm - user media folder already exists";
  }

  header("Location: ../../../../../registration/build_profile/?pid=$profile_id&uid=$user_id"); //index.php

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
