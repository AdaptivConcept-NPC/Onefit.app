<?php

session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection _ if fail then die
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
    $dateNow = date('Y_m_d h:i:s');

    $user_profile_id = sanitizeMySQL($dbconn, $_POST['user_profile_id']);

    foreach ($_POST['category_2_question_1_field'] as $arrayitem) {
        $ctgry_1_q1_fitnessgoals .=  sanitizeMySQL($dbconn, $arrayitem . $separator);
    }
    // $ctgry_1_q1_questionsummary = sanitizeMySQL($dbconn, $_POST['category_2_question_1_field']); //[]
    $ctgry_1_q2_goalstatement = sanitizeMySQL($dbconn, $_POST['category_2_question_2_field']);
    // die($_POST['category_2_question_3_field']);
    $ctgry_1_q3_realizegoaldate = sanitizeMySQL($dbconn, $_POST['category_2_question_3_field']);
    foreach ($_POST['category_2_question_4_field'] as $arrayitem) {
        $ctgry_1_q4_bodyfocusareas .=  sanitizeMySQL($dbconn, $arrayitem . $separator);
    }
    // $ctgry_1_q4_questionsummary = sanitizeMySQL($dbconn, $_POST['category_2_question_4_field']); //[]
    foreach ($_POST['category_2_question_5_field'] as $arrayitem) {
        $ctgry_1_q5_workoutsperweek =  sanitizeMySQL($dbconn, $arrayitem);
    }
    // $ctgry_1_q5_questionsummary = sanitizeMySQL($dbconn, $_POST['category_2_question_5_field']); //[]
    foreach ($_POST['category_2_question_6_field'] as $arrayitem) {
        $ctgry_1_q6_timetoworkout =  sanitizeMySQL($dbconn, $arrayitem);
    }
    // $ctgry_1_q6_questionsummary = sanitizeMySQL($dbconn, $_POST['category_2_question_6_field']); //[]
    foreach ($_POST['category_2_question_7_field'] as $arrayitem) {
        $ctgry_1_q7_startingweeks =  sanitizeMySQL($dbconn, $arrayitem);
    }

    // $ctgry_1_q7_questionsummary = sanitizeMySQL($dbconn, $_POST['category_2_question_7_field']); //[]
    if ($ctgry_1_q7_startingweeks == "specify") $ctgry_1_q7_startingweeks = sanitizeMySQL($dbconn, $_POST['category_2_question_7_specify_weeks_field']) . " weeks (specified)";

    foreach ($_POST['category_2_question_8_field'] as $arrayitem) {
        $ctgry_1_q8_badhabits .=  sanitizeMySQL($dbconn, $arrayitem . $separator);
    }
    // $ctgry_1_q8_questionsummary = sanitizeMySQL($dbconn, $_POST['category_2_question_8_field']); //[]
    foreach ($_POST['category_2_question_9_field'] as $arrayitem) {
        if (sanitizeMySQL($dbconn, $arrayitem) == "Yes") $ctgry_1_q9_letgoofbadhabits = 1; //Yes
        else $ctgry_1_q9_letgoofbadhabits = 0; //No
    }
    // $ctgry_1_q9_questionsummary = sanitizeMySQL($dbconn, $_POST['category_2_question_9_field']); //[]
    if (sanitizeMySQL($dbconn, $_POST['category_2_question_10_field']) == "Yes") $ctgry_1_q10_cheatday = 1;
    else $ctgry_1_q10_cheatday = 0;

    $ctgry_1_q11_cheatdaypromise = sanitizeMySQL($dbconn, $_POST['category_2_question_11_field']);

    // die("PHP POST Data: user id: $user_id | 
    // category_2_question_1_field: $ctgry_1_q1_fitnessgoals | 
    // category_2_question_2_field: $ctgry_1_q2_goalstatement | 
    // category_2_question_3_field: $ctgry_1_q3_realizegoaldate | 
    // category_2_question_4_field: $ctgry_1_q4_bodyfocusareas | 
    // category_2_question_5_field: $ctgry_1_q5_workoutsperweek | 
    // category_2_question_6_field: $ctgry_1_q6_timetoworkout | 
    // category_2_question_7_field: $ctgry_1_q7_startingweeks | 
    // category_2_question_7_specify_weeks_field: $ctgry_1_q7Specify_startingweeks | 
    // category_2_question_8_field: $ctgry_1_q8_badhabits | 
    // category_2_question_9_field: $ctgry_1_q9_letgoofbadhabits | 
    // category_2_question_10_field: $ctgry_1_q10_cheatday | 
    // category_2_question_11_field: $ctgry_1_q11_cheatdaypromise |");

    // try to insert the data
    try {
        $query = "INSERT INTO `user_profile_goalsetting`
        (`user_profile_goal_id`, `fitness_goals`, `goal_statement`, `realize_goal_date`, 
        `body_area_focus`, `workouts_to_do_week`, `time_to_workout`, `weeks_to_start`, `bad_habits`, 
        `prepared_letgoof_badhabits`, `pref_cheat_day`, `will_do_cheat_day`, `log_date`, 
        `general_user_profiles_user_profile_id`) 
        VALUES 
        (null,'$ctgry_1_q1_fitnessgoals','$ctgry_1_q2_goalstatement','$ctgry_1_q3_realizegoaldate',
        '$ctgry_1_q4_bodyfocusareas','$ctgry_1_q5_workoutsperweek','$ctgry_1_q6_timetoworkout','$ctgry_1_q7_startingweeks','$ctgry_1_q8_badhabits',
        $ctgry_1_q9_letgoofbadhabits,'$ctgry_1_q10_cheatday','$ctgry_1_q11_cheatdaypromise','$dateNow',
        $user_profile_id)";

        // echo $query . "<br>";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [GoalSetting Submit Error_01 _ " . $dbconn->error . "]");

        // $result = null;
        $result = null;
        $dbconn->close();

        echo "success: Goal Setting data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error:  [GoalSetting Except Err_01] " . $th;
    }
} else {
    echo "error: (REQUEST_METHOD) _ no Post received.";
}
