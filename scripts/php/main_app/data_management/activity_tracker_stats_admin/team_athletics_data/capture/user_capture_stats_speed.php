<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // declare variables and assign post values
    $speed_workout =
        $speed_datasource =
        $speed_value =
        $dateNow =
        $timeNow =
        $users_username =
        $user_profile_id = null;

    try {
        $speed_workout = sanitizeMySQL($dbconn, $_POST['speed-workout']);
        $speed_datasource = sanitizeMySQL($dbconn, $_POST['speed-datasource']);
        $speed_value = sanitizeMySQL($dbconn, $_POST['speed-value']);
        $dateNow = date('Y-m-d');
        $timeNow = date('H:i:s');

        $users_username = $_SESSION["currentUserUsername"];


        // try to get the users profile id
        $query = "SELECT user_profile_id FROM general_user_profiles WHERE users_username = '$users_username'";

        $result = $dbconn->query($query);

        if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator. [speed Submit Error_01 - " . $dbconn->error . "]");

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $user_profile_id = $row["user_profile_id"];
        }

        // die("HR workout($speed_workout) |
        // HR datasoufce($speed_datasource) |
        // HR value($speed_value) |
        // HR datenow($dateNow) |
        // HR timenow($timeNow) |
        // HR usernm($users_username) |
        // HR usrprofid($user_profile_id) |");

        $result = null;

        // try to insert the data
        $query = "INSERT INTO `user_profile_fitness_stats_speed`
        (`fitness_stats_speed_id`, `workout_activity`, `datasource`, `speed`, `date`, `time`, `user_profiles_user_profile_id`, `exercises_exercise_id`)
        VALUES 
        (null,'$speed_workout','$speed_datasource','$speed_value','$dateNow','$timeNow',$user_profile_id,$speed_workout)";

        $result = $dbconn->query($query);

        if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator. [speed Submit Error_02 - " . $dbconn->error . "]");

        $result = null;
        $dbconn->close();

        echo "success: activity tracker speed data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error: [speed Except Err_01] " . $th;
    }
}
