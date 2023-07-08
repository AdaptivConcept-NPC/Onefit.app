<?php

session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Declare Variables
    $user_id = $profile_id = $policy_ref = $policy_type = $policy_name = $policy_effective_date = $current_user_username = null;

    $dateNow = date("Y-m-d H:i:s");
    $output = "no message";

    $user_id = $_SESSION['uid'];

    // try to insert the data
    try {
        // check if user_id post value is set, if not then get the $_SESSION value
        if (isset($_POST['terms_profile_id'])) {
            // assign posted value to variable if set
            $profile_id = sanitizeMySQL($dbconn, $_POST['terms_profile_id']);

            $policy_type = "terms";

            $policy_ref = sanitizeMySQL($dbconn, $_POST['terms_policy_ref']);
            $policy_name = sanitizeMySQL($dbconn, $_POST['terms_policy_name']);
            $policy_effective_date = sanitizeMySQL($dbconn, $_POST['terms_policy_date']);
            $policy_effective_date = date("Y-m-d", strtotime($policy_effective_date));
        } elseif (isset($_POST['eula_profile_id'])) {
            // assign posted value to variable if set
            $profile_id = sanitizeMySQL($dbconn, $_POST['eula_profile_id']);

            $policy_type = "eula";

            $policy_ref = sanitizeMySQL($dbconn, $_POST['eula_policy_ref']);
            $policy_name = sanitizeMySQL($dbconn, $_POST['eula_policy_name']);
            $policy_effective_date = sanitizeMySQL($dbconn, $_POST['eula_policy_date']);
            $policy_effective_date = date("Y-m-d", strtotime($policy_effective_date));
        } else {
            // die
            die("An error occurred while trying to save your details. [ user_id POST value not set ]");
        }

        // get username of the $user_id 
        $query = "SELECT `username` FROM `users` WHERE `user_id` = $user_id";

        $result = $dbconn->query($query);

        if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

        $rows = $result->num_rows;
        if ($rows <= 0) {
            // die: user not found in users table
            die("An error occurred while trying to save your details. [ user not found in users table ]");
        } else {
            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $current_user_username = htmlspecialchars($row['username']);
            }
        }

        $result = null;

        // function to check if user has already submitted the policy acceptence
        function checkPolicyAcceptance($dbconn, $policy_ref, $policy_type, $current_user_username)
        {
            $query = "SELECT `user_policy_acceptance_id` FROM `user_policy_acceptance` WHERE `policy_reference` = '$policy_ref' AND `policy_type` = '$policy_type' AND `users_username` = '$current_user_username'";

            $result = $dbconn->query($query);

            if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

            $rows = $result->num_rows;
            if ($rows <= 0) {
                // user not found in users table
                return false;
            } else {
                return true;
            }
        }

        // if $EULA is set the insert data into database
        if ($policy_type == "eula") {
            // mysql save EULA acceptance
            if (!checkPolicyAcceptance($dbconn, $policy_ref, $policy_type, $current_user_username)) {
                // user has already accepted the policy, update the record
                $query = "INSERT INTO `user_policy_acceptance`
                (`user_policy_acceptance_id`, `policy_reference`, `policy_type`, `policy_name`, `policy_effective_date`, `user_accepted`, `user_accepted_date`, `users_username`) 
                VALUES 
                (null,'$policy_ref','eula','$policy_name','$policy_effective_date',1,'$dateNow ','$current_user_username')";
            } else {
                // user has not accepted the policy, insert new record
                $query = "UPDATE `user_policy_acceptance` 
                SET `policy_reference` = '$policy_ref', `policy_type` = 'eula', `policy_name` = '$policy_name', `policy_effective_date` = '$policy_effective_date', `user_accepted` = 1, `user_accepted_date` = '$dateNow' 
                WHERE `policy_type` = '$policy_type' AND `users_username` = '$current_user_username'";
            }

            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [PolicyAccept Submit Error_01 - " . $dbconn->error . "]");

            echo "success: EULA Policy Acceptance saved successfully.";
        } elseif ($policy_type == "terms") {
            // mysql save Terms of Service acceptance
            if (!checkPolicyAcceptance($dbconn, $policy_ref, $policy_type, $current_user_username)) {
                // user has already accepted the policy, update the record
                $query = "INSERT INTO `user_policy_acceptance`
                (`user_policy_acceptance_id`, `policy_reference`, `policy_type`, `policy_name`, `policy_effective_date`, `user_accepted`, `user_accepted_date`, `users_username`) 
                VALUES 
                (null,'$policy_ref','terms','$policy_name','$policy_effective_date',1,'$dateNow ','$current_user_username')";
            } else {
                // user has not accepted the policy, insert new record
                $query = "UPDATE `user_policy_acceptance` 
                SET `policy_reference` = '$policy_ref', `policy_type` = 'terms', `policy_name` = '$policy_name', `policy_effective_date` = '$policy_effective_date', `user_accepted` = 1, `user_accepted_date` = '$dateNow' 
                WHERE `policy_type` = '$policy_type' AND `users_username` = '$current_user_username'";
            }

            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [PolicyAccept Submit Error_02 - " . $dbconn->error . "]");

            echo "success: Terms of Use Policy Acceptance saved successfully.";
        }

        $result = null;
        $dbconn->close();
    } catch (\Throwable $th) {
        //throw $th;
        echo "exception error:  [PolicyAccept Except Err_01] " . $th;
    }
} else {
    echo "error: (REQUEST_METHOD) - no Post received.";
}
