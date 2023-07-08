<?php

session_start();

// submission validity check: compare session uid to url get user_id. user_id is a required parameter in the url
if ($_SESSION['uid'] != $_GET['user_id']) {
    die("Error: Access Denied");

    // php get current relative path
    // $currentPath = $_SERVER['PHP_SELF']; // /path/to/file.php

    // if not equal then redirect to error page
    // header("Location: ../../../../../error.php");
    // exit();
}

require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Declare Variables
    $separator = ",";
    $user_id = $user_profile_id = 0;
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

    // try to assign post values to variables
    try {
        // assign profile id to variable
        $user_profile_id = sanitizeMySQL($dbconn, $_POST['profile_id']);

        foreach ($_POST['category_3_question_1_field'] as $arrayitem) {
            $ctgry_3_q1_howfitareyou = sanitizeMySQL($dbconn, $arrayitem); //[]
        }
        foreach ($_POST['category_3_question_2_field'] as $arrayitem) {
            $ctgry_3_q2_lastidealweight = sanitizeMySQL($dbconn, $arrayitem); //[]
        }
        foreach ($_POST['category_3_question_3_field'] as $arrayitem) {
            $ctgry_3_q3_bodytype = sanitizeMySQL($dbconn, $arrayitem); //[]
        }
        foreach ($_POST['category_3_question_4_field'] as $arrayitem) {
            $ctgry_3_q4_sufferjointpain = sanitizeMySQL($dbconn, $arrayitem); //[]
        }
        foreach ($_POST['category_3_question_5_field'] as $arrayitem) {
            $ctgry_3_q5_howactiveindailylife = sanitizeMySQL($dbconn, $arrayitem); //[]
        }
        foreach ($_POST['category_3_question_6_field'] as $arrayitem) {
            $ctgry_3_q6_energylevelsinday = sanitizeMySQL($dbconn, $arrayitem); //[]
        }
        foreach ($_POST['category_3_question_7_field'] as $arrayitem) {
            $ctgry_3_q7_hoursnightsleep = sanitizeMySQL($dbconn, $arrayitem); //[]
        }
        foreach ($_POST['category_3_question_8_field'] as $arrayitem) {
            $ctgry_3_q8_dailywaterintake = sanitizeMySQL($dbconn, $arrayitem); //[]
        }
        foreach ($_POST['category_3_question_9_field'] as $arrayitem) {
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
    } catch (\Throwable $th) {
        //throw $th;
        die("exception error:  [FitPrefs Except Err_01] " . $th);
    }

    // try to insert the data
    try {
        function newUserProfile()
        {
            global $dbconn, $dateNow, $user_profile_id, $ctgry_3_q1_howfitareyou, $ctgry_3_q2_lastidealweight, $ctgry_3_q3_bodytype, $ctgry_3_q4_sufferjointpain, $ctgry_3_q5_howactiveindailylife, $ctgry_3_q6_energylevelsinday, $ctgry_3_q7_hoursnightsleep, $ctgry_3_q8_dailywaterintake, $ctgry_3_q9_prefclasses;

            $query = "INSERT INTO `user_profile_fitprefs`
            (`user_profile_fitpref_id`, `how_fit_are_you`, `last_time_ideal_weight`, 
            `body_type`, `suffer_from_joint_pain`, `daily_life_activity`,
            `energy_levels_during_day`, `night_sleep_hours`, `daily_water_intake`, 
            `prefared_classes`, `log_date`, `general_user_profiles_user_profile_id`) 
            VALUES 
            (null,'$ctgry_3_q1_howfitareyou','$ctgry_3_q2_lastidealweight',
            '$ctgry_3_q3_bodytype','$ctgry_3_q4_sufferjointpain','$ctgry_3_q5_howactiveindailylife',
            '$ctgry_3_q6_energylevelsinday','$ctgry_3_q7_hoursnightsleep','$ctgry_3_q8_dailywaterintake',
            '$ctgry_3_q9_prefclasses','$dateNow', $user_profile_id)";

            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [AboutYou Submit Error_Insert - " . $dbconn->error . "]"); //return false;
            else return true;
        }

        function updateUserProfile()
        {
            global $dbconn, $dateNow, $user_profile_id, $ctgry_3_q1_howfitareyou, $ctgry_3_q2_lastidealweight, $ctgry_3_q3_bodytype, $ctgry_3_q4_sufferjointpain, $ctgry_3_q5_howactiveindailylife, $ctgry_3_q6_energylevelsinday, $ctgry_3_q7_hoursnightsleep, $ctgry_3_q8_dailywaterintake, $ctgry_3_q9_prefclasses;

            $query = "UPDATE `user_profile_fitprefs` 
            SET `how_fit_are_you` = '$ctgry_3_q1_howfitareyou', `last_time_ideal_weight` = '$ctgry_3_q2_lastidealweight', 
            `body_type` = '$ctgry_3_q3_bodytype', `suffer_from_joint_pain` = '$ctgry_3_q4_sufferjointpain', `daily_life_activity` = '$ctgry_3_q5_howactiveindailylife',
            `energy_levels_during_day` = '$ctgry_3_q6_energylevelsinday', `night_sleep_hours` = '$ctgry_3_q7_hoursnightsleep', `daily_water_intake` = '$ctgry_3_q8_dailywaterintake', 
            `prefared_classes` = '$ctgry_3_q9_prefclasses', `log_date`  = '$dateNow'
            WHERE `general_user_profiles_user_profile_id` = $user_profile_id";

            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [AboutYou Submit Error_Update - " . $dbconn->error . "]"); //return false;
            else return true;
        }

        // check if $profile_id exists in user_profile_goalsetting table
        $query = "SELECT user_profile_fitpref_id FROM user_profile_fitprefs WHERE general_user_profiles_user_profile_id = $user_profile_id";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [FitPrefs Query Error_01 _ " . $dbconn->error . "] | query: " . $query . "");

        $row_cnt = $result->num_rows;

        $isSaved = null;

        if ($row_cnt <= 0) {
            $isSaved = newUserProfile();
            if ($isSaved === true) echo "success: new profile";
            else echo "error: new profile";
        } else {
            $isSaved = updateUserProfile();
            if ($isSaved === true) echo "success: updated profile";
            else echo "error: updated profile";
        }

        $result = null;
        $dbconn->close();

        // echo "success: Fitness Prefarances data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error:  [FitPrefs Except Err_02] " . $th;
        $dbconn->close();
    }
} else {
    echo "error: (REQUEST_METHOD) - no Post received.";
}
