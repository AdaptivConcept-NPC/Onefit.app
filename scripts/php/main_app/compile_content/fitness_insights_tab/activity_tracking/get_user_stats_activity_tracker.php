<?php
session_start();
require("../../../../config.php");
require_once("../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['forchart']) && isset($_GET['u'])) {
    // declaring variables
    $userid = null;
    $forChart = sanitizeMySQL($dbconn, $_GET['forchart']);
    $username = sanitizeMySQL($dbconn, $_GET['u']);

    // check if u value is the same as session variable value
    if ($username != $_SESSION["currentUserUsername"]) die("Error: Session invalid");

    // execute query
    try {
        // get the user id from username provided
        $query = "SELECT `user_profile_id` FROM `general_user_profiles` WHERE `users_username` = '$username'";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [compile user stats activity tracker Submit Error_01 - " . $dbconn->error . "]");

        $rows = $result->num_rows;

        if ($rows == 0) {
            //there is no result so kill the script
            die("error: No schedule and activities found.");
        } else {

            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $userprofileid = $row["user_profile_id"];

                // echo "$userprofileid<br><br>";
            }

            // echo "Flag<br>";
        }

        // $result = null;
        // $rows = null;

        switch ($forChart) {
            case "heart_rate_monitor_chart":
                $query = "SELECT * FROM `user_profile_fitness_stats_heart_rate` WHERE `user_profiles_user_profile_id` = $userprofileid";
                break;
            case "body_temp_monitor_chart":
                $query = "SELECT * FROM `user_profile_fitness_stats_body_temp` WHERE `user_profiles_user_profile_id` = $userprofileid";
                break;
            case "speed_monitor_chart":
                $query = "SELECT * FROM `user_profile_fitness_stats_speed` WHERE `user_profiles_user_profile_id` = $userprofileid";
                break;
            case "step_counter_monitor_chart":
                $query = "SELECT * FROM `user_profile_fitness_stats_step_count` WHERE `user_profiles_user_profile_id` = $userprofileid";
                break;
            case "bmi_weight_monitor_chart":
                $query = "SELECT * FROM `user_profile_fitness_stats_bmi` WHERE `user_profiles_user_profile_id` = $userprofileid";
                break;

            default:
                die("error: no chart identifyer available.");
                break;
        }

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [compile user stats activity tracker Submit Error_02 - " . $dbconn->error . "]");

        $outputArray = array();
        // $rows = $result->num_rows;

        if ($rows == 0) {
            //there is no result so kill the script
            die("error: No statistics found.");
        } else {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $outputArray[] = $row;
            }
        }

        echo json_encode($outputArray);

        $result->close();
        $dbconn->close();
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error: " . $th->getMessage();
    }
}
