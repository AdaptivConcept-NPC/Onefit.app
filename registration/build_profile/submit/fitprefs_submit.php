<?php

session_start();
require("../../../scripts/php/config.php");
require_once("../../../scripts/php/functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Declare Variables
    $user_id = 0;
    $ctgry_3_q1_questionsummary
        = $ctgry_3_q2_questionsummary
        = $ctgry_3_q3_questionsummary
        = $ctgry_3_q4_questionsummary
        = $ctgry_3_q5_questionsummary
        = $ctgry_3_q6_questionsummary
        = $ctgry_3_q7_questionsummary
        = $ctgry_3_q8_questionsummary
        = $ctgry_3_q9_questionsummary = null;

    $user_id = sanitizeMySQL($dbconn, $_POST['user-id']);

    $separator = ",";
    foreach ($_POST['category-3-question-1-field'] as $arrayitem) {
        $ctgry_3_q1_questionsummary .= sanitizeMySQL($dbconn, $arrayitem . $separator); //[]
    }
    foreach ($_POST['category-3-question-2-field'] as $arrayitem) {
        $ctgry_3_q2_questionsummary .= sanitizeMySQL($dbconn, $arrayitem . $separator); //[]
    }
    foreach ($_POST['category-3-question-3-field'] as $arrayitem) {
        $ctgry_3_q3_questionsummary .= sanitizeMySQL($dbconn, $arrayitem . $separator); //[]
    }
    foreach ($_POST['category-3-question-4-field'] as $arrayitem) {
        $ctgry_3_q4_questionsummary .= sanitizeMySQL($dbconn, $arrayitem . $separator); //[]
    }
    foreach ($_POST['category-3-question-5-field'] as $arrayitem) {
        $ctgry_3_q5_questionsummary .= sanitizeMySQL($dbconn, $arrayitem . $separator); //[]
    }
    foreach ($_POST['category-3-question-6-field'] as $arrayitem) {
        $ctgry_3_q6_questionsummary .= sanitizeMySQL($dbconn, $arrayitem . $separator); //[]
    }
    foreach ($_POST['category-3-question-7-field'] as $arrayitem) {
        $ctgry_3_q7_questionsummary .= sanitizeMySQL($dbconn, $arrayitem . $separator); //[]
    }
    foreach ($_POST['category-3-question-8-field'] as $arrayitem) {
        $ctgry_3_q8_questionsummary .= sanitizeMySQL($dbconn, $arrayitem . $separator); //[]
    }
    foreach ($_POST['category-3-question-9-field'] as $arrayitem) {
        $ctgry_3_q9_questionsummary .= sanitizeMySQL($dbconn, $arrayitem . $separator); //[]
    }

    die("PHP POST Data: user id: $user_id | 
    category-3-question-1-field: $ctgry_3_q1_questionsummary | 
    category-3-question-2-field: $ctgry_3_q2_questionsummary | 
    category-3-question-3-field: $ctgry_3_q3_questionsummary | 
    category-3-question-4-field: $ctgry_3_q4_questionsummary | 
    category-3-question-5-field: $ctgry_3_q5_questionsummary | 
    category-3-question-6-field: $ctgry_3_q6_questionsummary | 
    category-3-question-7-field: $ctgry_3_q7_questionsummary | 
    category-3-question-8-field: $ctgry_3_q8_questionsummary | 
    category-3-question-9-field: $ctgry_3_q9_questionsummary |");

    // create general_user_profile recod with default values


    // 
    $query = "";

    $result = $dbconn->query($query);
    //if (!$result) die("An error occurred - " . mysqli_error($dbconn)); //Admin
    if (!$result) die("An error occurred while trying to save your details.");

    $user_id = $dbconn->insert_id;

    $result = null;
    $dbconn->close();

    //   header("Location: ../../../../registration/profile_builder.html?panel=1&uid=$user_id");
} else {
    echo "error: (REQUEST_METHOD) - no Post received.";
}
