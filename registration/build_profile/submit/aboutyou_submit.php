<?php

session_start();
require("../../../scripts/php/config.php");
require_once("../../../scripts/php/functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Declare Variables
    $user_id = $user_profile_id = $height = $weight = 0;
    $dateNow = date('Y-md-d h:i:s');

    $user_profile_id = sanitizeMySQL($dbconn, $_POST['user-profile-id']);
    // floatval(); - convert text to float
    $weight = floatval(sanitizeMySQL($dbconn, $_POST['category-1-weight-field']));
    $height = floatval(sanitizeMySQL($dbconn, $_POST['category-1-height-field']));

    // die("PHP POST Data: user profile id: $user_profile_id | weight: $weight | height: $height");

    // try to insert the data
    try {
        $query = "INSERT INTO `user_profile_about`
        (`user_profile_about_id`, `height`, `weight`, `log_date`, `general_user_profiles_user_profile_id`) 
        VALUES 
        (null,$height,$weight,'$dateNow',$user_profile_id)";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [AboutYou Submit Error_01 - " . $dbconn->error . "]");

        $user_id = $dbconn->insert_id;

        $result = null;
        $dbconn->close();

        echo "success: About You data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error: Failed to upload Profile Image: " . $th;
    }
} else {
    echo "error: (REQUEST_METHOD) - no Post received.";
}
