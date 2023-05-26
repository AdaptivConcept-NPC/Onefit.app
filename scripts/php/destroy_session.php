<?php
session_start();
require_once("./config.php");
require_once("./functions.php");

if ($dbconn->connect_error) die("Fatal Error");

$currentUserFName = $_SESSION['currentUserForename'];
$currentUserLName = $_SESSION['currentUserSurname'];
$currentUserUsername = $_SESSION['currentUserUsername'];

$dateNow = date('Y-m-d ');
$timeNow = date('H-i-s');
// generate a entry reference string
$entry_ref = generateAlphaNumericRandomString(6) . "_" . $dateNow . "_" . $timeNow;

$submissionFlag = log_activity("user", "Signed out.", "$currentUserFName $currentUserLName ($currentUserUsername) signed out of the app. <br/> <span data-barcode>[ $entry_ref ]</span>", "user_activity", "NULL", $currentUserUsername);

$dbconn->close();

//destroy the users session.
$_SESSION = array();
setcookie(session_name(), '', time() - 2592000, '/');
session_destroy();

$currentServerPath = $_SERVER["PHP_SELF"];

if ($submissionFlag === true) {
  // die($currentServerPath . " | logged=true");
  //navigate to Home
  header("Location: ../../?return=sess_end&logged=true");
} else {
  // die($currentServerPath . " | logged=false");
  // die($submissionFlag);
  //navigate to Home
  header("Location: ../../?return=sess_end&logged=false");
}
