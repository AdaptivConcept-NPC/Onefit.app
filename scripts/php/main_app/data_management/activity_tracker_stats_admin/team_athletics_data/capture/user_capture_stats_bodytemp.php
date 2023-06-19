<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // declare variables and assign post values
    $bodytemp_workout =
        $bodytemp_datasource =
        $bodytemp_value =
        $dateNow =
        $timeNow =
        $users_username =
        $user_profile_id = null;

    try {
        $bodytemp_workout = sanitizeMySQL($dbconn, $_POST['bodytemp-workout']);
        $bodytemp_datasource = sanitizeMySQL($dbconn, $_POST['bodytemp-datasource']);
        $bodytemp_value = sanitizeMySQL($dbconn, $_POST['bodytemp-value']);
        $dateNow = date('Y-m-d');
        $timeNow = date('H:i:s');

        $users_username = $_SESSION["currentUserUsername"];


        // try to get the users profile id
        $query = "SELECT user_profile_id FROM general_user_profiles WHERE users_username = '$users_username'";

        $result = $dbconn->query($query);

        if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator. [bodytemp Submit Error_01 - " . $dbconn->error . "]");

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $user_profile_id = $row["user_profile_id"];
        }

        // die("HR workout($bodytemp_workout) |
        // HR datasoufce($bodytemp_datasource) |
        // HR value($bodytemp_value) |
        // HR datenow($dateNow) |
        // HR timenow($timeNow) |
        // HR usernm($users_username) |
        // HR usrprofid($user_profile_id) |");

        $result = null;

        // try to insert the data
        $query = "INSERT INTO `user_profile_fitness_stats_body_temp`
        (`fitness_stats_bt_id`, `workout_activity`, `datasource`, `temperature`, `date`, `time`, `user_profiles_user_profile_id`, `exercises_exercise_id`)
        VALUES 
        (null,'$bodytemp_workout','$bodytemp_datasource','$bodytemp_value','$dateNow','$timeNow',$user_profile_id,$bodytemp_workout)";

        $result = $dbconn->query($query);

        if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator. [bodytemp Submit Error_02 - " . $dbconn->error . "]");

        // $result = null;
        $result = null;
        $dbconn->close();

        echo "success: activity tracker bodytemp data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error: [bodytemp Except Err_01] " . $th;
    }
}
