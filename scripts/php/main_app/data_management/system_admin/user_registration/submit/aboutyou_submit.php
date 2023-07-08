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
    $user_id = $user_profile_id = $user_username = $height = $weight = 0;
    $dateNow = date('Y-m-d h:i:s');

    $bmi_value = 0;
    $bmi_status = "NULL";

    // try to assign post values to variables
    try {
        // assign profile id to variable
        $user_profile_id = sanitizeMySQL($dbconn, $_POST['profile_id']);

        // Height(cm) and Weight(kg) are float values : floatval(); _ convert text to float. 
        $weight = floatval(sanitizeMySQL($dbconn, $_POST['category_1_weight_field']));
        $height = floatval(sanitizeMySQL($dbconn, $_POST['category_1_height_field']));
        // die("PHP POST Data: user profile id: $user_id | weight: $weight | height: $height");

        // convert $height from cm to meters
        $height = $height / 100; // 1 meter = 100 centimeters

        // average height of Men & Women is South Africa - source: https://en.wikipedia.org/wiki/Average_human_height_by_country
        // South Africa: Men: 168 cm (5 ft 6 in) | Women: 159 cm (5 ft 2+1⁄2 in)
        $avgMaxMaleHeight = (168 + 2) / 100; // add two centimeters to indicate Max acceptable height : 1 meter = 100 centimeters
        $avgMaxFemaleHeight = (159 + 1) / 100; // add one centimeter to indicate Max acceptable height : 1 meter = 100 centimeters

        // if $height is greater than $avgMaxMaleHeight then die 
        if ($height > $avgMaxMaleHeight) die("Error: Height is greater than acceptable max average height range.");

        // perform a bmi calculation with the users weight and height values (sources: https://www.wikihow.com/Calculate-Your-Body-Mass-Index-(BMI) | Source: https://www.cdc.gov/nccdphp/dnpao/growthcharts/training/bmiage/page5_2.html)
        // A BMI below 18.5 means that you are underweight.
        // A BMI of 18.6 to 24.9 is healthy.
        // A BMI of 25 to 29.9 means that you are overweight.
        // A BMI of 30 or greater indicates obesity.
        // formulas (will have to stick to one formula method for consistency->Metric): 
        // Metric mearsurment: (weight)kg / (height)m^2
        // English measurements (lb=pound, in=inch, conversion_factor=703):  weight (lb) / [height (in)]2 x 703 
        $bmi_value = $weight / ($height ^ 2);

        switch (true) {
            case $bmi_value < 18.5:
                # underweight
                $bmi_status = 'Underweight';
                break;
            case $bmi_value >= 18.5 && $bmi_value <= 24.9:
                # healthy
                $bmi_status = 'Healthy';
                break;
            case  $bmi_value >= 25 && $bmi_value <= 29.9:
                # overweight
                $bmi_status = 'Overweight';
                break;
            case  $bmi_value >= 30:
                # obese
                $bmi_status = 'Obese';
                break;

            default:
                # no default - error occurred
                $bmi_status = 'error - recalculation required';
                break;
        }
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error: [AboutYou Except Err_01] " . $th;
    }

    // try to insert the data
    try {
        // create a new record
        function newUserProfile()
        {
            global $dbconn, $user_profile_id, $height, $weight, $bmi_value, $bmi_status, $dateNow;

            $query = "INSERT INTO `user_profile_about`
            (`user_profile_about_id`, `height`, `weight`, `bmi`, `bmi_status`, `log_date`, `general_user_profiles_user_profile_id`) 
            VALUES 
            (null,$height,$weight,$bmi_value,'$bmi_status','$dateNow',$user_profile_id)";

            $result = $dbconn->query($query);

            if (!$result) return false; //die("An error occurred while trying to save your details. [AboutYou Submit Error_Insert - " . $dbconn->error . "]");
            else return true;
        }
        // update existing record
        function updateUserProfile()
        {
            global $dbconn, $user_profile_id, $height, $weight, $bmi_value, $bmi_status, $dateNow;

            $query = "UPDATE `user_profile_about` SET 
            `height` = $height, `weight` = $weight, `bmi` = $bmi_value, `bmi_status` = '$bmi_status', `log_date` = '$dateNow'
            WHERE `general_user_profiles_user_profile_id` = $user_profile_id";

            $result = $dbconn->query($query);

            if (!$result) return false; //die("An error occurred while trying to save your details. [AboutYou Submit Error_Update - " . $dbconn->error . "]");
            else return true;
        }

        // check if $profile_id exists in user_profile_about table
        $query = "SELECT user_profile_about_id FROM user_profile_about WHERE general_user_profiles_user_profile_id = $user_profile_id";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [AboutYou Query Error_01 _ " . $dbconn->error . "] | query: " . $query . "");

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

        // echo "success: About You data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error: [AboutYou Except Err_02] " . $th;
        $dbconn->close();
    }
} else {
    echo "error: (REQUEST_METHOD) - no Post received.";
}
