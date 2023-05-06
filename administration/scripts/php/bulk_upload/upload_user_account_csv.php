<?php
// include mysql database configuration file
// code sourced from: https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
session_start();
require("../scripts/php/admin_config.php");
// require('../scripts/php/functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // global variables
    $usrn = "";

    try {
        // Allowed mime types
        $fileMimes = array(
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain'
        );

        // Validate whether selected file is a CSV file
        if (!empty($_FILES['csvfile-user_accounts']['name']) && in_array($_FILES['csvfile-user_accounts']['type'], $fileMimes)) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['csvfile-user_accounts']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
                // generate new username for each record being submitted
                $new_usrnm = "onefitza_" . strtolower(generateAlphaNumericRandomString(8)) . strtolower(generateNumericRandomString(2));
                // generate random password string for each record being submitted
                $pwd = generateAlphaNumericRandomString(10);
                $new_pwdhash = password_hash($pwd, PASSWORD_DEFAULT);

                // Get row data
                // user_id	
                // username	
                // password_hash	
                // user_name	
                // user_surname	
                // id_number	
                // user_email	
                // contact_number	
                // date_of_birth	
                // user_gender	
                // user_race	
                // user_nationality	
                // account_active
                $user_id = sanitizeMySQL($dbconn, $getData[0]); //will not use this
                $username = sanitizeMySQL($dbconn, $getData[1]); // $new_usrnm
                $password_hash = sanitizeMySQL($dbconn, $getData[2]); // $new_pwdhash
                $user_name = sanitizeMySQL($dbconn, $getData[3]);
                $user_surname = sanitizeMySQL($dbconn, $getData[4]);
                $id_number = sanitizeMySQL($dbconn, $getData[5]);
                $user_email = sanitizeMySQL($dbconn, $getData[6]);
                $contact_number = sanitizeMySQL($dbconn, $getData[7]);
                $date_of_birth = sanitizeMySQL($dbconn, $getData[8]);
                $user_gender = sanitizeMySQL($dbconn, $getData[9]);
                $user_race = sanitizeMySQL($dbconn, $getData[10]);
                $user_nationality = sanitizeMySQL($dbconn, $getData[11]);
                $account_active = sanitizeMySQL($dbconn, $getData[12]);

                // mysql query to check If user an identifier exists in the database, in this case we want to query if there
                // are records in the database that have the same email address, name and surname
                $query = "SELECT * FROM `users` WHERE `username` = '$username' AND `user_email` = '$user_email' AND `user_name`='$user_name' AND `user_surname`='$user_surname'";
                // run the check in the db using the query string above
                $check = mysqli_query($dbconn, $query);

                if ($check->num_rows > 0) {
                    // record exists, update the existing record with the new data/values
                    $result = mysqli_query($dbconn, "UPDATE `users` SET 
                    `password_hash`='$password_hash',
                    `user_name`='$user_name',
                    `user_surname`='$user_surname',
                    `id_number`='$id_number',
                    `user_email`='$user_email',
                    `contact_number`='$contact_number',
                    `date_of_birth`='$date_of_birth',
                    `user_gender`='$user_gender',
                    `user_race`='$user_race',
                    `user_nationality`='$user_nationality',
                    `account_active`=$account_active 
                    WHERE `user_email`='$user_email' AND `username`='$username'");

                    if (!$result) die("An error occurred while trying to update the existing record [ user_id: $user_id | username: $username | user_email: $user_email | user_name: $user_name | user_surname: $user_surname ]: " . $dbconn->error . "]");
                } else {
                    // record does not exist, insert/create a new record 
                    $result = mysqli_query($dbconn, "INSERT INTO `users` 
                    (`user_id`, `username`, `password_hash`, `user_name`, `user_surname`, `id_number`, `user_email`, `contact_number`, `date_of_birth`, `user_gender`, `user_race`, `user_nationality`, `account_active`) 
                    VALUES 
                    (null, '$new_usrnm', '$new_pwdhash', '$user_name', '$user_surname', '$id_number', '$user_email', '$contact_number', '$date_of_birth', '$user_gender', '$user_race', '$user_nationality', $account_active)");

                    // $result = $dbconn->query($query);

                    if (!$result) die("An error occurred while trying to save the new record [ user_id: $user_id | username: $new_usrnm | user_email: $user_email | user_name: $user_name | user_surname: $user_surname ]: " . $dbconn->error . "]");
                }
            }

            // Close opened CSV file
            fclose($csvFile);

            // header("Location: index.php");

            // return success message
            echo "success";
        } else {
            echo "Request could not be processed. Please select a valid file. *or no data was received \n" .
                "_FILES['csvfile-store_products']['name']?=> " . $_FILES['csvfile-store_products']['name'] . " \n " .
                "_FILES['csvfile-store_products']['type']?=> " . $_FILES['csvfile-store_products']['type'] . " \n";
        }
    } catch (\Throwable $th) {
        throw "Exeption error occured: " . $th->getMessage();
    }
}
