<?php

session_start();
require("../../../scripts/php/config.php");
require_once("../../../scripts/php/functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Declare Variables
    $separator = ",";
    $user_id = $user_profile_id = 0;
    $ctgry_1_q1_fitnessgoals
        = $ctgry_1_q2_goalstatement
        = $ctgry_1_q3_realizegoaldate
        = $ctgry_1_q4_bodyfocusareas
        = $ctgry_1_q5_workoutsperweek
        = $ctgry_1_q6_timetoworkout
        = $ctgry_1_q7_startingweeks
        = $ctgry_1_q7Specify_startingweeks
        = $ctgry_1_q8_badhabits
        = $ctgry_1_q9_letgoofbadhabits
        = $ctgry_1_q10_cheatday
        = $ctgry_1_q11_cheatdaypromise = null;
    $dateNow = date('Y-md-d h:i:s');

    $user_profile_id = sanitizeMySQL($dbconn, $_POST['user-profile-id']);

    foreach ($_POST['category-2-question-1-field'] as $arrayitem) {
        $ctgry_1_q1_fitnessgoals .=  sanitizeMySQL($dbconn, $arrayitem . $separator);
    }
    // $ctgry_1_q1_questionsummary = sanitizeMySQL($dbconn, $_POST['category-2-question-1-field']); //[]
    $ctgry_1_q2_goalstatement = sanitizeMySQL($dbconn, $_POST['category-2-question-2-field']);
    $ctgry_1_q3_realizegoaldate = date('Y-md-d', sanitizeMySQL($dbconn, $_POST['category-2-question-3-field']));
    foreach ($_POST['category-2-question-4-field'] as $arrayitem) {
        $ctgry_1_q4_bodyfocusareas .=  sanitizeMySQL($dbconn, $arrayitem . $separator);
    }
    // $ctgry_1_q4_questionsummary = sanitizeMySQL($dbconn, $_POST['category-2-question-4-field']); //[]
    foreach ($_POST['category-2-question-5-field'] as $arrayitem) {
        $ctgry_1_q5_workoutsperweek =  sanitizeMySQL($dbconn, $arrayitem);
    }
    // $ctgry_1_q5_questionsummary = sanitizeMySQL($dbconn, $_POST['category-2-question-5-field']); //[]
    foreach ($_POST['category-2-question-6-field'] as $arrayitem) {
        $ctgry_1_q6_timetoworkout =  sanitizeMySQL($dbconn, $arrayitem);
    }
    // $ctgry_1_q6_questionsummary = sanitizeMySQL($dbconn, $_POST['category-2-question-6-field']); //[]
    foreach ($_POST['category-2-question-7-field'] as $arrayitem) {
        $ctgry_1_q7_startingweeks =  sanitizeMySQL($dbconn, $arrayitem);
    }

    // $ctgry_1_q7_questionsummary = sanitizeMySQL($dbconn, $_POST['category-2-question-7-field']); //[]
    if ($ctgry_1_q7_startingweeks == "specify") $ctgry_1_q7_startingweeks = sanitizeMySQL($dbconn, $_POST['category-2-question-7-specify-weeks-field']) . " weeks (specified)";

    foreach ($_POST['category-2-question-8-field'] as $arrayitem) {
        $ctgry_1_q8_badhabits .=  sanitizeMySQL($dbconn, $arrayitem . $separator);
    }
    // $ctgry_1_q8_questionsummary = sanitizeMySQL($dbconn, $_POST['category-2-question-8-field']); //[]
    foreach ($_POST['category-2-question-9-field'] as $arrayitem) {
        $ctgry_1_q9_letgoofbadhabits .=  sanitizeMySQL($dbconn, $arrayitem . $separator);
    }
    // $ctgry_1_q9_questionsummary = sanitizeMySQL($dbconn, $_POST['category-2-question-9-field']); //[]
    if (sanitizeMySQL($dbconn, $_POST['category-2-question-10-field']) == "Yes") $ctgry_1_q10_cheatday = 1;
    else $ctgry_1_q10_cheatday = 0;

    $ctgry_1_q11_cheatdaypromise = sanitizeMySQL($dbconn, $_POST['category-2-question-11-field']);

    // die("PHP POST Data: user id: $user_id | 
    // category-2-question-1-field: $ctgry_1_q1_fitnessgoals | 
    // category-2-question-2-field: $ctgry_1_q2_goalstatement | 
    // category-2-question-3-field: $ctgry_1_q3_realizegoaldate | 
    // category-2-question-4-field: $ctgry_1_q4_bodyfocusareas | 
    // category-2-question-5-field: $ctgry_1_q5_workoutsperweek | 
    // category-2-question-6-field: $ctgry_1_q6_timetoworkout | 
    // category-2-question-7-field: $ctgry_1_q7_startingweeks | 
    // category-2-question-7-specify-weeks-field: $ctgry_1_q7Specify_startingweeks | 
    // category-2-question-8-field: $ctgry_1_q8_badhabits | 
    // category-2-question-9-field: $ctgry_1_q9_letgoofbadhabits | 
    // category-2-question-10-field: $ctgry_1_q10_cheatday | 
    // category-2-question-11-field: $ctgry_1_q11_cheatdaypromise |");

    // try to insert the data
    try {
        $query = "INSERT INTO 
        `user_profile_goalsetting`(`user_profile_goal_id`, `fitness_goals`, `goal_statement`, `realize_goal_date`, 
        `body_area_focus`, `workouts_to_do_week`, `time_to_workout`, `weeks_to_start`, `bad_habits`, 
        `prepared_letgoof_badhabits`, `pref_cheat_day`, `will_do_cheat_day`, `log_date`, 
        `general_user_profiles_user_profile_id`) 
        VALUES 
        (null,'$ctgry_1_q1_fitnessgoals','$ctgry_1_q2_goalstatement','$ctgry_1_q3_realizegoaldate',
        '$ctgry_1_q4_bodyfocusareas','$ctgry_1_q5_workoutsperweek','$ctgry_1_q6_timetoworkout',$ctgry_1_q7_startingweeks,'$ctgry_1_q8_badhabits',
        '$ctgry_1_q9_letgoofbadhabits','$ctgry_1_q10_cheatday','$ctgry_1_q11_cheatdaypromise','$dateNow',
        $user_profile_id)";

        echo $query . "<br>";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [GoalSetting Submit Error_01 - " . $dbconn->error . "]");

        $user_id = $dbconn->insert_id;

        $result = null;
        $dbconn->close();

        echo "success: Goal Setting data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error: Failed to upload Profile Image: " . $th;
    }
} else {
    echo "error: (REQUEST_METHOD) - no Post received.";
}
