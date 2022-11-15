<?php

session_start();
require("../../../scripts/php/config.php");
require_once("../../../scripts/php/functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Declare Variables
    $user_id = $user_profile_id = $height = $weight = 0;
    $dateNow = date('Y-m-d h:i:s');

    $user_profile_id = sanitizeMySQL($dbconn, $_POST['user-profile-id']);
    // floatval(); - convert text to float
    $weight = floatval(sanitizeMySQL($dbconn, $_POST['category-1-weight-field']));
    $height = floatval(sanitizeMySQL($dbconn, $_POST['category-1-height-field']));

    $bmi_value = 0;
    $bmi_status = "NULL";

    // die("PHP POST Data: user profile id: $user_profile_id | weight: $weight | height: $height");

    // perform a bmi calculation with the users weight and height values (sources: https://www.wikihow.com/Calculate-Your-Body-Mass-Index-(BMI) | Source: https://www.cdc.gov/nccdphp/dnpao/growthcharts/training/bmiage/page5_2.html)
    // A BMI below 18.5 means that you are underweight.
    // A BMI of 18.6 to 24.9 is healthy.
    // A BMI of 25 to 29.9 means that you are overweight.
    // A BMI of 30 or greater indicates obesity.
    // formulas (will have to stick to one formula method for consistency->Metric): 
    // Metric mearsurment: (weight)kg / (height*height)m2
    // English measurements (lb=pound, in=inch, conversion_factor=703):  weight (lb) / [height (in)]2 x 703 
    $bmi_value = $weight / ($height * $height);

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
    try {
        $query = "INSERT INTO `user_profile_about`
        (`user_profile_about_id`, `height`, `weight`, `bmi`, `bmi_status`, `log_date`, `general_user_profiles_user_profile_id`) 
        VALUES 
        (null,$height,$weight,$bmi_value,'$bmi_status','$dateNow',$user_profile_id)";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [AboutYou Submit Error_01 - " . $dbconn->error . "]");

        $result->close();
        $dbconn->close();

        echo "success: About You data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error: [AboutYou Except Err_01] " . $th;
    }
} else {
    echo "error: (REQUEST_METHOD) - no Post received.";
}
