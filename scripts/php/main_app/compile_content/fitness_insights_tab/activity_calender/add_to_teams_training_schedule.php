<?php
session_start();
include("../../../../config.php");
include("../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // get submitted_by username from get parameter
    $is_Admin = false;
    if (!isset($_GET['submitted_by'])) {
        $submitted_by_username = $_SESSION['currentUserUsername'];
        // method to check if username exists and is an administrator username
        $is_Admin = verifyAdminUsername($submitted_by_username);
        if (!$is_Admin) {
            # if not admin then kill the process and return restriction message
            die("User is not an Administrator or account is deactivated: [ $submitted_by_username ] - SESSION");
        }
    } else {
        $submitted_by_username = sanitizeMySQL($dbconn, $_GET['submitted_by']);
        // method to check if username exists and is an administrator username
        $is_Admin = verifyAdminUsername($submitted_by_username);
        if (!$is_Admin) {
            # if not admin then kill the process and return restriction message
            die("User is not an Administrator or account is deactivated: [ $submitted_by_username ] - GET");
        }
    }

    // declaring variables
    // add-to-calender-activity-title-value
    // add-to-calender-activity-rpe-value
    // add-to-calender-activity-day-value
    // add-to-calender-activity-date-value
    // add-to-calender-activity-colorcode-value
    // select-workout-exercises-selected[]
    $tws_id
        = $activity_title
        = $activity_rpe
        = $activity_day
        = $activity_date
        = $activity_colorcode
        = $workout_exercises
        = $gr_code = null;

    $activitiesArray = array();

    $gr_code = sanitizeMySQL($dbconn, $_POST['add-to-calender-team-select']);
    $activity_title = sanitizeMySQL($dbconn, $_POST['add-to-calender-activity-title-value']);
    $activity_rpe   = sanitizeMySQL($dbconn, $_POST['add-to-calender-activity-rpe-value']);
    $activity_day   = sanitizeMySQL($dbconn, $_POST['add-to-calender-activity-day-value']);
    $activity_date  = sanitizeMySQL($dbconn, $_POST['add-to-calender-activity-date-value']);
    $activity_colorcode = sanitizeMySQL($dbconn, $_POST['add-to-calender-activity-colorcode-value']);
    $workout_exercises  = $_POST['select-workout-exercises-selected']; // select-workout-exercises-selected
    // die(print_r($workout_exercises));

    try {
        // ****************************************************************
        function getExerciseDetailsAddToSchedule($lookup_id)
        {
            global $dbconn, $tws_id;
            $teams_activity_id
                = $activity_title
                = $activity_description
                = $activity_icon
                = $teams_weekly_schedules_teams_weekly_schedule_id
                = $exercises_exercise_id =  null;

            $exercise_id =
                $exercise_name =
                $instructions =
                $guidelines =
                $sets =
                $reps =
                $rests =
                $xp_points = null;

            try {
                // get exercise details from the exercise database table and if found, add the exercise details to the teams weekly activities table
                $query = "SELECT * FROM `exercises` WHERE `exercise_id` = $lookup_id";
                $result = mysqli_query($dbconn, $query);
                if (!$result) die("Fatal error [1]: " . $dbconn->error);

                $rows = $result->num_rows;

                if ($rows > 0) {
                    for ($j = 0; $j < $rows; ++$j) {
                        $row = $result->fetch_array(MYSQLI_ASSOC);

                        // $teams_activity_id = $row['teams_activity_id'];
                        // $activity_title = $row['activity_title'];
                        // $activity_description = $row['activity_description'];
                        // $activity_icon = $row['activity_icon'];
                        // $teams_weekly_schedules_teams_weekly_schedule_id = $row['teams_weekly_schedules_teams_weekly_schedule_id'];
                        // $exercises_exercise_id = $row['exercises_exercise_id'];

                        $exercise_id = $row["exercise_id"];
                        $exercise_name = $row["exercise_name"];
                        $instructions = $row["instructions"];
                        $guidelines = $row["guidelines"];
                        $sets = $row["sets"];
                        $reps = $row["reps"];
                        $rests = $row["rests"];
                        $xp_points = $row["xp_points"];
                    }

                    addScheduleExerciseActivity(
                        /* $activity_title */
                        $exercise_name,
                        /* $activity_description */
                        $instructions,
                        /* $activity_icon */
                        "NULL",
                        /* $tws_id */
                        $tws_id,
                        /* $exercise_activity_id */
                        $exercise_id,
                        /* pass 1 iteration count */
                        1
                    );

                    return true;
                } else {
                    return false;
                }
            } catch (\Throwable $th) {
                echo "Exception error occured -> (addScheduleActivities.php>getExerciseDetails()): $th <br/>";
                return false;
            }
        }

        function addScheduleExerciseActivity($exercisetitle, $exercisedescription, $iconurl, $twsid, $exercise_activity_id, $i_count)
        {
            global $dbconn;

            if ($iconurl == "NULL") {
                $iconurl = "../media/assets/icons/icons8-stretching-50.png";
            }

            # insert 
            $query = "INSERT INTO `team_weekly_activities`
                (`teams_activity_id`, `activity_title`, 
                `activity_description`, `activity_icon`, 
                `teams_weekly_schedules_teams_weekly_schedule_id`, 
                `exercises_exercise_id`) 
                VALUES 
                (null,'$exercisetitle',
                '$exercisedescription','$iconurl',
                $twsid,
                $exercise_activity_id)";

            $result = $dbconn->query($query);
            $result = mysqli_query($dbconn, $query);
            if (!$result) die("Fatal error [2 - iterations: $i_count - activityid/exerciseid: $exercise_activity_id]: (Query: $query) " . $dbconn->error);
            else return true;
        }
        // ****************************************************************

        foreach ($workout_exercises as $exercise_activity) {
            # add selection to activities array
            $activitiesArray[] = sanitizeMySQL($dbconn, $exercise_activity);
        }
        // print_r($activitiesArray); //test
        // echo "<br/>";

        // insert the submitted schedule record
        $query = "INSERT INTO `teams_weekly_schedules` 
        (`teams_weekly_schedule_id`, `schedule_title`, `schedule_rpe`, `schedule_day`, `schedule_date`, `color_code`, `groups_group_ref_code`) 
        VALUES 
        (null,'$activity_title','$activity_rpe','$activity_day','$activity_date','$activity_colorcode','$gr_code')";

        $result = $dbconn->query($query);
        $result = mysqli_query($dbconn, $query);
        if (!$result) die("Fatal error [1]: " . $dbconn->error);

        // get the last insert_id (teams_weekly_schedule_id) from record created in the workouts table
        $tws_id = $dbconn->insert_id;

        // dump the results
        $result = null;

        // insert each item into the teams schedule activities table
        $new_activity_array = array();
        $iterations = 0;
        foreach ($activitiesArray as $activity) {
            $iterations += 1;
            # if the $item is numeric (exercise_id), then get the exercise details
            if (is_numeric($activity)) {
                $exercise_id = $activity;
                // get the exercise details of the exercise id (title, description) and add them to the team_weekly_activities table, if True is returned positive flag, otherwise an error occured
                $statusflag = getExerciseDetailsAddToSchedule($exercise_id);
                // false: no exercise found, kill script execution
                if ($statusflag !== true) die("Fatal error: could not find exercise details ( $exercise_id ) | output: $statusflag");
                else echo "success";
            } else {
                // error, kill script and output notification
                die("Fatal error: invalid exercise id provided: $activity");
            }
        }

        $result = null;
        $dbconn->close();
    } catch (\Throwable $th) {
        $dbconn->close();
        throw "Expection Error has occured: $th";
    }
}

// try {
//     //code to break array string to iterable object...
//     $exercise_id = 2;
//     // new_activity({title: 'Test', definition: 'Definition_instructions', xp_pts: 5})
//     // extract title, definition and xp
//     $input = $activity;  //"[modid=256]";
//     preg_match('~=(.*?)]~', $input, $output);
//     echo $output[1] . "<br/>"; // 256
//     $new_activity_array = explode(',', $output[1]);

//     echo "New Activity (exploded array):<br/>";
//     print_r($new_activity_array);
//     echo "<br/>";

//     // create a new exercise activity record
//     addScheduleExerciseActivity(
//         /* $activity_title */
//         $new_activity_array['teams_activity_id'],
//         /* $activity_description */
//         $new_activity_array['activity_description'],
//         /* $activity_icon */
//         "NULL",
//         /* $tws_id */
//         $tws_id,
//         /* $exercise_activity_id */
//         /* if the $exercise_activity_id is new link the new exercise item using exercise_id: 2 */
//         $exercise_id,
//         $iterations
//     );
// } catch (\Throwable $th) {
//     $dbconn->close();
//     throw "Exception error:  $th";
// }