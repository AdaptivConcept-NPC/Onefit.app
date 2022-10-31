<?php

session_start();
require("../../scripts/php/config.php");
require_once("../../scripts/php/functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Declare Variables
    $user_id = $height = $weight = 0;



    $user_id = sanitizeMySQL($dbconn, $_POST['user-id']);
    $weight = sanitizeMySQL($dbconn, $_POST['category-1-weight-field']);
    $height = sanitizeMySQL($dbconn, $_POST['category-1-height-field']);

    die("");

    // create general_user_profile recod with default values


    // 
    $query = "INSERT INTO users VALUES(null, '$usrnm', '$pwdhash', '$name', '$surname', '$idnum', '$email', '$contact', '$dob', '$gender', '$race', '$nation', 0)";

    $result = $dbconn->query($query);
    //if (!$result) die("An error occurred - " . mysqli_error($dbconn)); //Admin
    if (!$result) die("An error occurred while trying to save your details.");

    $user_id = $dbconn->insert_id;

    $dbconn->close();

    //   header("Location: ../../../../registration/profile_builder.html?panel=1&uid=$user_id");
} else {
}
