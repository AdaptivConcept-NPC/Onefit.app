<?php

session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Declare Variables
    $user_id = 0;
    $EULA = $TOU = null;

    $user_id = sanitizeMySQL($dbconn, $_POST['user-id']);

    $EULA = sanitizeMySQL($dbconn, $_POST['agree-eula']);
    $TOU = sanitizeMySQL($dbconn, $_POST['agree-terms']);

    $dateNow = date("Y-m-d H:i:s");

    $separator = ",";

    $policy_ref = generateNumericRandomString(10); // must get this reference from official records of actual policies stored in database

    $current_user_username = "";


    // die("PHP POST Data: user id: $user_id | 
    // EULA Accepted?: $EULA | 
    // TOU Accepted?: $TOU |");

    // try to insert the data
    try {
        // get the username of the current user id
        $query = "SELECT `username` FROM `users` WHERE `user_id` = $user_id";

        $result = $dbconn->query($query);

        if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

        $rows = $result->num_rows;
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $current_user_username = htmlspecialchars($row['username']);
        }

        // mysql save EULA acceptance
        $query = "INSERT INTO `user_policy_acceptance`
        (`user_policy_acceptance_id`, `policy_reference`, `policy_name`, `policy_effective_date`, `user_accepted`, `user_accepted_date`, `users_username`) 
        VALUES 
        (null,'$policy_ref','End-User License Agreement (13 October 2022)','2022-10-13',1,'$dateNow ','$current_user_username')";

        // echo $query . "<br>";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [PolicyAccept Submit Error_01 - " . $dbconn->error . "]");

        // mysql save Terms of Service acceptance
        $query = "INSERT INTO `user_policy_acceptance`
        (`user_policy_acceptance_id`, `policy_reference`, `policy_name`, `policy_effective_date`, `user_accepted`, `user_accepted_date`, `users_username`) 
        VALUES 
        (null,'$policy_ref','Terms of use (13 October 2022)','2022-10-13',1,'$dateNow ','$current_user_username')";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [PolicyAccept Submit Error_02 - " . $dbconn->error . "]");

        $result = null;

        // activate the users account
        $query = "UPDATE `users` SET `account_active` = 1 WHERE (`user_id` = $user_id AND `username` = '$current_user_username')";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [PolicyAccept Submit Error_03 - " . $dbconn->error . "]");

        $result = null;
        $dbconn->close();

        echo "success: Policy Acceptance data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error:  [PolicyAccept Except Err_01] " . $th;
    }
} else {
    echo "error: (REQUEST_METHOD) - no Post received.";
}
