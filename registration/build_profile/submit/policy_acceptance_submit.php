<?php

session_start();
require("../../../scripts/php/config.php");
require_once("../../../scripts/php/functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Declare Variables
    $user_id = 0;
    $EULA = $TOU = null;

    $user_id = sanitizeMySQL($dbconn, $_POST['user-id']);

    $EULA = sanitizeMySQL($dbconn, $_POST['agree-eula']);
    $TOU = sanitizeMySQL($dbconn, $_POST['agree-terms']);

    $separator = ",";


    die("PHP POST Data: user id: $user_id | 
    EULA Accepted?: $EULA | 
    TOU Accepted?: $TOU |");

    // create general_user_profile recod with default values


    // 
    $query = "";

    $result = $dbconn->query($query);
    //if (!$result) die("An error occurred - " . mysqli_error($dbconn)); //Admin
    if (!$result) die("An error occurred while trying to save your details.");

    $user_id = $dbconn->insert_id;

    $result = null;
    $dbconn->close();

    //   header("Location: ../../../../registration/profile_builder.html?panel=1&uid=$user_id");
} else {
    echo "error: (REQUEST_METHOD) - no Post received.";
}
