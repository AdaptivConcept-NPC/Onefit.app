<?php

session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Declare Variables
    $user_id = 0;
    $ctgry_3_q1_howfitareyou
        = $ctgry_3_q2_lastidealweight
        = $ctgry_3_q3_bodytype
        = $ctgry_3_q4_sufferjointpain
        = $ctgry_3_q5_howactiveindailylife
        = $ctgry_3_q6_energylevelsinday
        = $ctgry_3_q7_hoursnightsleep
        = $ctgry_3_q8_dailywaterintake
        = $ctgry_3_q9_prefclasses = null;
    $dateNow = date('Y-m-d h:i:s');

    $user_id = sanitizeMySQL($dbconn, $_POST['user-id']);

    $separator = ",";
    foreach ($_POST['category-3-question-1-field'] as $arrayitem) {
        $ctgry_3_q1_howfitareyou = sanitizeMySQL($dbconn, $arrayitem); //[]
    }
    foreach ($_POST['category-3-question-2-field'] as $arrayitem) {
        $ctgry_3_q2_lastidealweight = sanitizeMySQL($dbconn, $arrayitem); //[]
    }
    foreach ($_POST['category-3-question-3-field'] as $arrayitem) {
        $ctgry_3_q3_bodytype = sanitizeMySQL($dbconn, $arrayitem); //[]
    }
    foreach ($_POST['category-3-question-4-field'] as $arrayitem) {
        $ctgry_3_q4_sufferjointpain = sanitizeMySQL($dbconn, $arrayitem); //[]
    }
    foreach ($_POST['category-3-question-5-field'] as $arrayitem) {
        $ctgry_3_q5_howactiveindailylife = sanitizeMySQL($dbconn, $arrayitem); //[]
    }
    foreach ($_POST['category-3-question-6-field'] as $arrayitem) {
        $ctgry_3_q6_energylevelsinday = sanitizeMySQL($dbconn, $arrayitem); //[]
    }
    foreach ($_POST['category-3-question-7-field'] as $arrayitem) {
        $ctgry_3_q7_hoursnightsleep = sanitizeMySQL($dbconn, $arrayitem); //[]
    }
    foreach ($_POST['category-3-question-8-field'] as $arrayitem) {
        $ctgry_3_q8_dailywaterintake = sanitizeMySQL($dbconn, $arrayitem); //[]
    }
    foreach ($_POST['category-3-question-9-field'] as $arrayitem) {
        $ctgry_3_q9_prefclasses .= sanitizeMySQL($dbconn, $arrayitem . $separator); //[]
    }

    // die("PHP POST Data: user id: $user_id | 
    // category-3-question-1-field: $ctgry_3_q1_howfitareyou | 
    // category-3-question-2-field: $ctgry_3_q2_lastidealweight | 
    // category-3-question-3-field: $ctgry_3_q3_bodytype | 
    // category-3-question-4-field: $ctgry_3_q4_sufferjointpain | 
    // category-3-question-5-field: $ctgry_3_q5_howactiveindailylife | 
    // category-3-question-6-field: $ctgry_3_q6_energylevelsinday | 
    // category-3-question-7-field: $ctgry_3_q7_hoursnightsleep | 
    // category-3-question-8-field: $ctgry_3_q8_dailywaterintake | 
    // category-3-question-9-field: $ctgry_3_q9_prefclasses |")


    // try to insert the data
    try {
        $query = "INSERT INTO `user_profile_fitprefs`
        (`user_profile_fitpref_id`, `how_fit_are_you`, `last_time_ideal_weight`, 
        `body_type`, `suffer_from_joint_pain`, `daily_life_activity`,
         `energy_levels_during_day`, `night_sleep_hours`, `daily_water_intake`, 
         `prefared_classes`, `log_date`, `general_user_profiles_user_profile_id`) 
        VALUES 
        (null,'$ctgry_3_q1_howfitareyou','$ctgry_3_q2_lastidealweight',
        '$ctgry_3_q3_bodytyp','$ctgry_3_q4_sufferjointpain','$ctgry_3_q5_howactiveindailylife','[value-7]',
        '$ctgry_3_q6_energylevelsinday','$ctgry_3_q7_hoursnightsleep','$ctgry_3_q8_dailywaterintake',
        '$ctgry_3_q9_prefclasses','$dateNow')";

        // echo $query . "<br>";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [FitPrefs Submit Error_01 - " . $dbconn->error . "]");

        // $result = null;
        $result = null;
        $dbconn->close();

        echo "success: Fitness Prefarances data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error:  [FitPrefs Except Err_01] " . $th;
    }
} else {
    echo "error: (REQUEST_METHOD) - no Post received.";
}
