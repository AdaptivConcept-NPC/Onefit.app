<?php

session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Declare Variables
    $user_id = null;
    $EULA = $TOU = $policy_ref = $policy_name = $policy_effective_date = null;

    // check if user_id post value is set, if not then get the $_SESSION value
    if (!isset($_POST['user_id'])) {
        // check if the session value is set
        if (!isset($_SESSION['currentUserUsername'])) {
            die("An error occurred while trying to save your details. [ user_id / user_username POST / SESSION value not set ]");
        } else {
            // assign session value to variable
            $user_id = sanitizeMySQL($dbconn, $_SESSION['currentUserUsername']);
        }
    } else {
        // assign posted value to variable 
        $user_id = sanitizeMySQL($dbconn, $_POST['user_id']);
    }

    $policy_ref = generateNumericRandomString(10); // must get this reference from official records of actual policies stored in database

    if (isset($_POST['agree_eula']) && isset($_POST['agree_terms'])) {
        // assign posted values to both variables
        $EULA = sanitizeMySQL($dbconn, $_POST['agree_eula']);
        $TOU = sanitizeMySQL($dbconn, $_POST['agree_terms']);

        $policy_name = "End-User License Agreement (13 October 2022) & Terms of use (13 October 2022)";
        $policy_effective_date = "2022-10-13";
    } elseif (isset($_POST['agree_eula'])) {
        // assign eula value to variable
        $EULA = sanitizeMySQL($dbconn, $_POST['agree_eula']);

        $policy_name = "Terms of use (13 October 2022)";
        $policy_effective_date = "2022-10-13";
    } elseif (isset($_POST['agree_terms'])) {
        // assign tou value to variable
        $TOU = sanitizeMySQL($dbconn, $_POST['agree_terms']);

        $policy_name = "Terms of use (13 October 2022)";
        $policy_effective_date = "2022-10-13";
    } else {
        die("An error occurred while trying to save your details. [ eula or tou not set ]");
    }

    // die("PHP POST Data: user id: $user_id | 
    // EULA Accepted?: $EULA | 
    // TOU Accepted?: $TOU |");

    // try to insert the data
    try {
        $dateNow = date("Y-m-d H:i:s");
        $output = "no message";
        $separator = ",";
        $success_count = 0;

        $current_user_username = "";

        // check if $user_id is a numeric or alphanumeric value
        if (is_numeric($user_id)) {
            // get the username of the current user id
            $query = "SELECT `username` FROM `users` WHERE `user_id` = $user_id";

            $result = $dbconn->query($query);

            if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

            $rows = $result->num_rows;
            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $current_user_username = htmlspecialchars($row['username']);
            }
        } else {
            // get the username of the current user username
            $query = "SELECT `username` FROM `users` WHERE `username` = '$user_id'";

            $result = $dbconn->query($query);

            if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

            $rows = $result->num_rows;
            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $current_user_username = htmlspecialchars($row['username']);
            }
        }

        // if $EULA is set the insert data into database
        if (isset($EULA)) {
            // mysql save EULA acceptance
            $query = "INSERT INTO `user_policy_acceptance`
            (`user_policy_acceptance_id`, `policy_reference`, 'policy_type', `policy_name`, `policy_effective_date`, `user_accepted`, `user_accepted_date`, `users_username`) 
            VALUES 
            (null,'$policy_ref','EULA','$policy_name','$policy_effective_date',1,'$dateNow ','$current_user_username')";

            // echo $query . "<br>";

            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [PolicyAccept Submit Error_01 - " . $dbconn->error . "]");

            $output .= " eula submitted #$policy_ref ";
            $success_count += 1;
        }

        // if $TOU is set the insert data into database
        if (isset($TOU)) {
            // mysql save Terms of Service acceptance
            $query = "INSERT INTO `user_policy_acceptance`
            (`user_policy_acceptance_id`, `policy_reference`, 'policy_type', `policy_name`, `policy_effective_date`, `user_accepted`, `user_accepted_date`, `users_username`) 
            VALUES 
            (null,'$policy_ref','TOU','$policy_name','$policy_effective_date',1,'$dateNow ','$current_user_username')";

            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [PolicyAccept Submit Error_02 - " . $dbconn->error . "]");

            $output .= " tou submitted #$policy_ref ";
            $success_count += 1;
        }

        // if $success_count is between 1 then one policy was submitted 2 then both EULA and TOU were succeeded
        if ($success_count > 0 && $success_count <= 2) {
            echo "success: $output";
        } else {
            echo "error: $output";
        }

        // mysql save EULA acceptance
        // $query = "INSERT INTO `user_policy_acceptance`
        // (`user_policy_acceptance_id`, `policy_reference`, `policy_name`, `policy_effective_date`, `user_accepted`, `user_accepted_date`, `users_username`) 
        // VALUES 
        // (null,'$policy_ref','End-User License Agreement (13 October 2022)','2022-10-13',1,'$dateNow ','$current_user_username')";

        // // echo $query . "<br>";

        // $result = $dbconn->query($query);

        // if (!$result) die("An error occurred while trying to save your details. [PolicyAccept Submit Error_01 - " . $dbconn->error . "]");

        // // mysql save Terms of Service acceptance
        // $query = "INSERT INTO `user_policy_acceptance`
        // (`user_policy_acceptance_id`, `policy_reference`, `policy_name`, `policy_effective_date`, `user_accepted`, `user_accepted_date`, `users_username`) 
        // VALUES 
        // (null,'$policy_ref','Terms of use (13 October 2022)','2022-10-13',1,'$dateNow ','$current_user_username')";

        // $result = $dbconn->query($query);

        // if (!$result) die("An error occurred while trying to save your details. [PolicyAccept Submit Error_02 - " . $dbconn->error . "]");

        // $result = null;

        // activate the users account
        // $query = "UPDATE `users` SET `account_active` = 1 WHERE (`user_id` = $user_id AND `username` = '$current_user_username')";

        // $result = $dbconn->query($query);

        // if (!$result) die("An error occurred while trying to save your details. [PolicyAccept Submit Error_03 - " . $dbconn->error . "]");

        // $result = null;
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
