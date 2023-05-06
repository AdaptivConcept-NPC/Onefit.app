<?php
// include mysql database configuration file
// code sourced from: https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
session_start();
require("../scripts/php/admin_config.php");
// require('../scripts/php/functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // if (isset($_POST['submit'])) {

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
        if (!empty($_FILES['csvfile-muscle_groups']['name']) && in_array($_FILES['csvfile-muscle_groups']['type'], $fileMimes)) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['csvfile-muscle_groups']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
                // Get row data
                // muscle_group_id	
                // major_muscle_group	
                // sub_muscle_group	
                // position_definition
                $muscle_group_id = $getData[0];
                $major_muscle_group = $getData[1];
                $sub_muscle_group = $getData[2];
                $position_definition = $getData[3];

                // mysql query to check If user an identifier exists in the database, in this case we want to query if there
                // are records in the database that have the same muscle_group_id
                $query = "SELECT * FROM `muscle_groups` WHERE `muscle_group_id` =  '$muscle_group_id'";
                // run the check in the db using the query string above
                $check = mysqli_query($dbconn, $query);

                if ($check->num_rows > 0) {
                    // record exists, update the existing record with the new data/values
                    $result = mysqli_query($dbconn, "UPDATE `muscle_groups` SET 
                    `major_muscle_group`='$major_muscle_group',
                    `sub_muscle_group`='$sub_muscle_group' ,
                    `position_definition`='$position_definition' 
                    WHERE `muscle_group_id`='$muscle_group_id'");

                    if (!$result) die("An error occurred while trying to update the existing record [ muscle_group_id: $muscle_group_id ]: " . $dbconn->error . "]");
                } else {
                    // record does not exist, insert/create a new record 
                    $result = mysqli_query($dbconn, "INSERT INTO 
                    `muscle_groups`(`muscle_group_id`, `major_muscle_group`, `sub_muscle_group`, `position_definition`) 
                    VALUES (null,'$major_muscle_group','$sub_muscle_group','$position_definition')");

                    // $result = $dbconn->query($query);

                    if (!$result) die("An error occurred while trying to save the new record [ muscle_group_id: $muscle_group_id ]: " . $dbconn->error . "]");
                }
            }

            // Close opened CSV file
            fclose($csvFile);

            // header("Location: index.php");

            // return success message
            echo "success";
        } else {
            echo "Request could not be processed. Please select a valid file. *or no data was received \n" .
                "_FILES['csvfile-muscle_groups']['name']?=> " . $_FILES['csvfile-muscle_groups']['name'] . " \n " .
                "_FILES['csvfile-muscle_groups']['type']?=> " . $_FILES['csvfile-muscle_groups']['type'] . " \n";
        }
    } catch (\Throwable $th) {
        throw "Exeption error occured: " . $th->getMessage();
    }
}
