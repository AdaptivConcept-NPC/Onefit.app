<?php
session_start();
require("../admin_config.php");
require('../functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // declare variables
    // H. Category Class
    // #select-workout-category

    // I. Workout Info
    #input-workout-name
    #input-workout-description
    #input-workout-goal-definition
    #input-workout-xp
    #select-workout-premium

    // J. Workout Summary
    #input-workout-main-goal
    #input-workout-type
    #select-workout-training-level
    #input-workout-program-duration
    #input-workout-exercise-days-week
    #select-workout-target-gender
    #select-workout-recommeded-supplements []

    // K. Workout Training / Exercises
    #select-workout-exercises-selected []
    $i_count = 0;
    $workout_id
        = $exerciseid
        = $workout_category
        = $workout_name
        = $workout_description
        = $workout_goal_definition
        = $workout_xp
        = $workout_premium
        = $workout_main_goal
        = $workout_type
        = $workout_training_level
        = $workout_program_duration
        = $workout_exercise_days_week
        = $workout_target_gender
        = $workout_recommeded_supplements
        = $workout_exercises_selected
        = $recommended_supp_json = null;

    // for each exercise passed in the $workout_exercises_selected variable:
    function insertWorkoutTrainingRecord($eid, $wid, $i_count)
    {
        global $dbconn;

        try {
            // clear the $result and run a new query to add a new record to the workout_training table
            $result = null;
            $query = "INSERT INTO `workout_training`
                    (`workout_training_id`, `workouts_workout_id`, `exercises_exercise_id`) 
                    VALUES (null,$wid,$eid)";

            $result = mysqli_query($dbconn, $query);
            if (!$result) die("Fatal error [3][iteration: $i_count][wid: $wid| eid: $eid]: " . $dbconn->error);

            // clear result
            $result = null;
        } catch (\Throwable $th) {
            throw "Exception Error Occured - [insertWorkoutTrainingRecord][iteration: $i_count][wid: $wid| eid: $eid]: $th";
        }
    }

    try {
        // assign POST values to variables
        $workout_category = sanitizeMySQL($dbconn, $_POST['select-workout-category']);
        $workout_name = sanitizeMySQL($dbconn, $_POST['input-workout-name']);
        $workout_description = sanitizeMySQL($dbconn, $_POST['input-workout-description']);
        $workout_goal_definition = sanitizeMySQL($dbconn, $_POST['input-workout-goal-definition']);
        $workout_xp = sanitizeMySQL($dbconn, $_POST['input-workout-xp']);
        if (sanitizeMySQL($dbconn, $_POST['select-workout-premium']) == 1) $workout_premium = true;
        else $workout_premium = false;
        // $workout_premium = sanitizeMySQL($dbconn, $_POST['select-workout-premium']);

        $workout_main_goal = sanitizeMySQL($dbconn, $_POST['input-workout-main-goal']);
        $workout_type = sanitizeMySQL($dbconn, $_POST['input-workout-type']);
        $workout_training_level = sanitizeMySQL($dbconn, $_POST['select-workout-training-level']);
        $workout_program_duration = sanitizeMySQL($dbconn, $_POST['input-workout-program-duration']);
        $workout_exercise_days_week = sanitizeMySQL($dbconn, $_POST['input-workout-exercise-days-week']);
        $workout_target_gender = sanitizeMySQL($dbconn, $_POST['select-workout-target-gender']);
        $workout_recommeded_supplements = sanitizeMySQL($dbconn, $_POST['select-workout-recommeded-supplements']);
        $recommended_supp_json = json_encode($workout_recommeded_supplements);

        $workout_exercises_selected = sanitizeMySQL($dbconn, $_POST['select-workout-exercises-selected']);

        // create new workout record on workouts table
        $query = "INSERT INTO `workouts`
        (`workout_id`, `workout_name`, `workout_description`, `goal_definition`, `total_xp_points`, `premium`, `category_class_category_class_code`) 
        VALUES (null,'$workout_name','$workout_description','$workout_goal_definition',$workout_xp,$workout_premium,'$workout_category')";

        // $result = $dbconn->query($query);
        $result = mysqli_query($dbconn, $query);
        if (!$result) die("Fatal error [1]: " . $dbconn->error);

        // get the last insert_id (workout_id) from record created in the workouts table
        $workout_id = $dbconn->insert_id;

        // clear the result and run a new query to add a new record to the workout_summary table
        $result = null;
        $query = "INSERT INTO `workout_summary`
        (`workout_summary_id`, `main_goal`, `workout_type`, `training_level`, `program_duration`, `days_per_week`, `target_gender`, `recommended_supplements`, `workouts_workout_id`) 
        VALUES (null,'$workout_main_goal','$workout_type','$workout_training_level','$workout_program_duration',$workout_exercise_days_week,'$workout_target_gender','$recommended_supp_json',$workout_id)";

        $result = mysqli_query($dbconn, $query);
        if (!$result) die("Fatal error [2]: " . $dbconn->error);

        foreach ($_POST['select-workout-exercises-selected'] as $arrayitem) {
            // increment the $i_count
            $i_count += 1;
            $exerciseid = $arrayitem;
            // create a record for each exercise selected and call a function to run the sql query on each iteration of the loop
            insertWorkoutTrainingRecord($exerciseid, $workoutid, $i_count);
        }

        // close connection to database
        $result = null;
        $dbconn->close();
    } catch (\Throwable $th) {
        throw "Exception Error Occured: $th";
    }
}
