<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // declare variables and assign post values
    $weight_workout =
        $weight_datasource =
        $weight_value =
        $bmi_value =
        $bmi_status =
        $dateNow =
        $timeNow =
        $users_username =
        $user_height =
        $user_profile_id = null;

    try {
        $weight_workout = sanitizeMySQL($dbconn, $_POST['weight-workout']);
        $weight_datasource = sanitizeMySQL($dbconn, $_POST['weight-datasource']);
        $weight_value = sanitizeMySQL($dbconn, $_POST['weight-value']);
        $dateNow = date('Y-m-d');
        $timeNow = date('H:i:s');

        $users_username = $_SESSION["currentUserUsername"];


        // try to get the users profile id
        $query = "SELECT user_profile_id FROM general_user_profiles WHERE users_username = '$users_username'";

        $result = $dbconn->query($query);

        if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator. [weight Submit Error_01 - " . $dbconn->error . "]");

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $user_profile_id = $row["user_profile_id"];
        }

        // die("HR workout($weight_workout) |
        // HR datasoufce($weight_datasource) |
        // HR value($weight_value) |
        // HR datenow($dateNow) |
        // HR timenow($timeNow) |
        // HR usernm($users_username) |
        // HR usrprofid($user_profile_id) |");

        $result = null;

        // get the height and age of the user from his/her profile/account information
        $query = "SELECT `height` FROM `user_profile_about` WHERE `general_user_profiles_user_profile_id` = $user_profile_id";

        $result = $dbconn->query($query);

        if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator. [weight Submit Error_02 - " . $dbconn->error . "]");

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $user_height = $row["height"];
        }

        // perform a bmi calculation with the users weight and height values (sources: https://www.wikihow.com/Calculate-Your-Body-Mass-Index-(BMI) | Source: https://www.cdc.gov/nccdphp/dnpao/growthcharts/training/bmiage/page5_2.html)
        // A BMI below 18.5 means that you are underweight.
        // A BMI of 18.6 to 24.9 is healthy.
        // A BMI of 25 to 29.9 means that you are overweight.
        // A BMI of 30 or greater indicates obesity.
        // formulas (will have to stick to one formula method for consistency->Metric): 
        // Metric mearsurment: (weight)kg / (height*height)m2
        // English measurements (lb=pound, in=inch, conversion_factor=703):  weight (lb) / [height (in)]2 x 703 
        $bmi_value = $weight_value / ($user_height * $user_height);

        switch (true) {
            case $bmi_value < 18.5:
                # underweight
                $bmi_status = 'underweight';
                break;
            case $bmi_value >= 18.5 && $bmi_value <= 24.9:
                # healthy
                $bmi_status = 'healthy';
                break;
            case  $bmi_value >= 25 && $bmi_value <= 29.9:
                # overweight
                $bmi_status = 'overweight';
                break;
            case  $bmi_value >= 30:
                # obese
                $bmi_status = 'obese';
                break;

            default:
                # no default - error occurred
                $bmi_status = 'error - recalculation required';
                break;
        }

        // try to insert the data
        $query = "INSERT INTO `user_profile_fitness_stats_bmi`
        (`fitness_stats_bmi_id`, `workout_activity`, `datasource`, `bmi`, `bmi_status`, `weight`, `date`, `time`, `user_profiles_user_profile_id`, `exercises_exercise_id`)
        VALUES 
        (null,'$weight_workout','$weight_datasource', $bmi_value, '$bmi_status', $weight_value,'$dateNow','$timeNow',$user_profile_id,$weight_workout)";

        $result = $dbconn->query($query);

        if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator. [weight Submit Error_03 - " . $dbconn->error . "]");

        // $result->close();
        $result = null;
        $dbconn->close();

        echo "success: activity tracker weight data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error: [weight Except Err_04] " . $th->getMessage;
    }
}
