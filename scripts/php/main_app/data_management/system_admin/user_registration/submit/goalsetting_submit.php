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
    $dateNow = date('Y-m-d h:i:s');

    // try to assign post values to variables
    try {
        // assign profile id to variable
        $user_profile_id = sanitizeMySQL($dbconn, $_POST['profile_id']);

        // 1) What are your Fitness Goals?
        foreach ($_POST['category_2_question_1_field'] as $arrayitem) {
            $ctgry_1_q1_fitnessgoals .=  sanitizeMySQL($dbconn, $arrayitem . $separator);
        }

        // 2) Please set your own Goal statement
        $ctgry_1_q2_goalstatement = sanitizeMySQL($dbconn, $_POST['category_2_question_2_field']);

        // 3) By when do you want to have realized this Goal?
        $ctgry_1_q3_realizegoaldate = sanitizeMySQL($dbconn, $_POST['category_2_question_3_field']);

        // 4) Which areas of your body do you want to work on?
        foreach ($_POST['category_2_question_4_field'] as $arrayitem) {
            $ctgry_1_q4_bodyfocusareas .=  sanitizeMySQL($dbconn, $arrayitem . $separator);
        }

        // 5) How many workouts per week do you want to do?
        foreach ($_POST['category_2_question_5_field'] as $arrayitem) {
            $ctgry_1_q5_workoutsperweek =  sanitizeMySQL($dbconn, $arrayitem);
        }

        // 6) How much time do you have to workout?
        foreach ($_POST['category_2_question_6_field'] as $arrayitem) {
            $ctgry_1_q6_timetoworkout =  sanitizeMySQL($dbconn, $arrayitem);
        }

        // 7) How many weeks do you want to start with?
        foreach ($_POST['category_2_question_7_field'] as $arrayitem) {
            $ctgry_1_q7_startingweeks =  sanitizeMySQL($dbconn, $arrayitem);
        }
        if ($ctgry_1_q7_startingweeks == "specify") $ctgry_1_q7_startingweeks = sanitizeMySQL($dbconn, $_POST['category_2_question_7_specify_weeks_field']) . " weeks (specified)" ||  "4 weeks (default)"; // if not set for some reason, set default to 4 weeks

        // 8) Do you have any bad habits?
        foreach ($_POST['category_2_question_8_field'] as $arrayitem) {
            $ctgry_1_q8_badhabits .=  sanitizeMySQL($dbconn, $arrayitem . $separator);
        }

        // 9) Are you prepared to do what is necessay to let go of bed habits?
        foreach ($_POST['category_2_question_9_field'] as $arrayitem) {
            if (sanitizeMySQL($dbconn, $arrayitem) == "Yes") $ctgry_1_q9_letgoofbadhabits = 1; //Yes
            else $ctgry_1_q9_letgoofbadhabits = 0; //No
        }

        // 10) Please select your prefarred "Cheat-Day".
        if (sanitizeMySQL($dbconn, $_POST['category_2_question_10_field']) == "Yes") $ctgry_1_q10_cheatday = 1;
        else $ctgry_1_q10_cheatday = 0;

        // 11) What will you do on your "Cheat-Day"?
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
    } catch (\Throwable $th) {
        //throw $th;
        die("exception error:  [GoalSetting Except Err_01] " . $th);
    }

    // try to insert the data
    try {
        // create a new record
        function newUserProfile()
        {
            global $dbconn, $user_profile_id, $ctgry_1_q1_fitnessgoals, $ctgry_1_q2_goalstatement, $ctgry_1_q3_realizegoaldate, $ctgry_1_q4_bodyfocusareas, $ctgry_1_q5_workoutsperweek, $ctgry_1_q6_timetoworkout, $ctgry_1_q7_startingweeks, $ctgry_1_q8_badhabits, $ctgry_1_q9_letgoofbadhabits, $ctgry_1_q10_cheatday, $ctgry_1_q11_cheatdaypromise, $dateNow;

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

            $result = $dbconn->query($query);

            if (!$result) return false; //die("An error occurred while trying to save your details. [AboutYou Submit Error_Insert - " . $dbconn->error . "]");
            else return true;
        }
        // update existing record
        function updateUserProfile()
        {
            global $dbconn, $user_profile_id, $ctgry_1_q1_fitnessgoals, $ctgry_1_q2_goalstatement, $ctgry_1_q3_realizegoaldate, $ctgry_1_q4_bodyfocusareas, $ctgry_1_q5_workoutsperweek, $ctgry_1_q6_timetoworkout, $ctgry_1_q7_startingweeks, $ctgry_1_q8_badhabits, $ctgry_1_q9_letgoofbadhabits, $ctgry_1_q10_cheatday, $ctgry_1_q11_cheatdaypromise, $dateNow;

            $query = "UPDATE `user_profile_goalsetting` 
            SET `fitness_goals` = '$ctgry_1_q1_fitnessgoals', `goal_statement` = '$ctgry_1_q2_goalstatement', `realize_goal_date` = '$ctgry_1_q3_realizegoaldate', 
            `body_area_focus` = '$ctgry_1_q4_bodyfocusareas', `workouts_to_do_week` = '$ctgry_1_q5_workoutsperweek', `time_to_workout` = '$ctgry_1_q6_timetoworkout', `weeks_to_start` = '$ctgry_1_q7_startingweeks', `bad_habits` = '$ctgry_1_q8_badhabits', 
            `prepared_letgoof_badhabits` = $ctgry_1_q9_letgoofbadhabits, `pref_cheat_day` = '$ctgry_1_q10_cheatday', `will_do_cheat_day` = '$ctgry_1_q11_cheatdaypromise', `log_date` = '$dateNow'
            WHERE `general_user_profiles_user_profile_id` = $user_profile_id";

            $result = $dbconn->query($query);

            if (!$result) return false; //die("An error occurred while trying to save your details. [AboutYou Submit Error_Update - " . $dbconn->error . "]");
            else return true;
        }

        // check if $profile_id exists in user_profile_goalsetting table
        $query = "SELECT user_profile_goal_id FROM user_profile_goalsetting WHERE general_user_profiles_user_profile_id = $user_profile_id";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [GoalSetting Query Error_01 _ " . $dbconn->error . "] | query: " . $query . "");

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

        // echo "success: Goal Setting data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error:  [GoalSetting Except Err_02] " . $th;
        $dbconn->close();
    }
} else {
    echo "error: (REQUEST_METHOD) _ no Post received.";
}
