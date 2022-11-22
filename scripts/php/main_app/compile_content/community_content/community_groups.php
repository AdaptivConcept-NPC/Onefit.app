<?php
session_start();
require("../../../config.php");
require("../../../functions.php");

//Connection Test==============================================>
if ($dbconn->connect_error) die("Fatal Error");
//end of Connection Test============================================>

//Declaring variables
$communityGroupsList = $app_err_msg = $output = null;

if (isset($_SESSION["currentUserAuth"])) {
  if ($_SESSION["currentUserAuth"] == true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn, $_SESSION["currentUserAuth"]);

    echo getCommunityGroups();
  }
}
