<?php
// include mysql database configuration file
// code sourced from: https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
session_start();
require("../../../scripts/php/config.php");
require('../../../scripts/php/functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // if (isset($_POST['submit'])) {

    // global scope variable
    $_SESSION['currentUserUsername'] = "KING_001"; // LOCAL TEST ONLY
    $currentAdmin_Usrnm = sanitizeString($_SESSION['currentUserUsername']);

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
        if (!empty($_FILES['csvfile-sports_list']['name']) && in_array($_FILES['csvfile-sports_list']['type'], $fileMimes)) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['csvfile-sports_list']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
                // Get row data
                // sport_id	
                // category	
                // name
                $sport_id = $getData[0];
                $category = $getData[1];
                $name = $getData[2];

                // mysql query to check If user an identifier exists in the database, in this case we want to query if there
                // are records in the database that have the same sport_id
                $query = "SELECT * FROM `sports_list` WHERE `sport_id` =  '$sport_id'";
                // run the check in the db using the query string above
                $check = mysqli_query($dbconn, $query);

                if ($check->num_rows > 0) {
                    // record exists, update the existing record with the new data/values
                    $result = mysqli_query($dbconn, "UPDATE `sports_list` SET 
                    `category`='$category',
                    `name`='$name' 
                    WHERE `muscle_group_id`='$muscle_group_id'");

                    if (!$result) die("An error occurred while trying to update the existing record [ sport_id: $sport_id | category: $category | name: $name ]: " . $dbconn->error . "]");
                } else {
                    // record does not exist, insert/create a new record 
                    $result = mysqli_query($dbconn, "INSERT INTO 
                    `store_products`(`sport_id`, `category`, `name`, `administrators_username`) 
                    VALUES (null,'$category','$name','$currentAdmin_Usrnm')");

                    // $result = $dbconn->query($query);

                    if (!$result) die("An error occurred while trying to save the new record [ sport_id: $sport_id | category: $category | name: $name ]: " . $dbconn->error . "]");
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
