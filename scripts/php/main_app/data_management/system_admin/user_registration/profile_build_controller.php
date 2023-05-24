<?php
session_start();
require("../../../../config.php");
require("../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

//initialize Variables
$panelNumber = 0;

if (isset($_GET["panel"])) {
  $panelNumber = sanitizeString($_GET["panel"]);
  echo "Panel Number: " . $panelNumber;
} else {
  echo "Error: var panel - not set";
};

// function sanitizeString($var){
//   if(get_magic_quotes_gpc())
//   $var = stripslashes($var);
//   $var = strip_tags($var);
//   $var = htmlentities($var);
//   return $var;
// }

// function sanitizeMySQL($connection, $var){
//   $var = $connection->real_escape_string($var);
//   $var = sanitizeString($var);
//   return $var;
// }
