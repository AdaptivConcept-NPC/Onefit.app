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
        if (!empty($_FILES['csvfile-supplements']['name']) && in_array($_FILES['csvfile-supplements']['type'], $fileMimes)) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['csvfile-supplements']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
                // Get row data
                // supplements_id	
                // category_tags	
                // supplement_type	
                // description	
                // recommended_dosage	
                // source
                $supplements_id = sanitizeMySQL($dbconn, $getData[0]);
                $category_tags = sanitizeMySQL($dbconn, $getData[1]);
                $supplement_type = sanitizeMySQL($dbconn, $getData[2]);
                $description = sanitizeMySQL($dbconn, str_replace("'", '`', $getData[3])); // str_replace to replace ' to `
                $recommended_dosage = sanitizeMySQL($dbconn, $getData[4]);
                $source = sanitizeMySQL($dbconn, $getData[5]);

                // echo "\n" . $supplements_id;
                // echo "\n" . $category_tags;
                // echo "\n" . $supplement_type;
                // echo "\n" . $description;
                // echo "\n" . $recommended_dosage;
                // echo "\n" . $source;

                // mysql query to check If user an identifier exists in the database, in this case we want to query if there
                // are records in the database that have the same supplements_id
                $query = "SELECT * FROM `supplements_list` WHERE `supplements_id` =  $supplements_id";
                // echo $query;
                // run the check in the db using the query string above
                $check = mysqli_query($dbconn, $query);

                // if (!$check) die("No supplements found.");

                if ($check->num_rows > 0) {
                    // record exists, update the existing record with the new data/values
                    $result = mysqli_query($dbconn, "UPDATE `supplements_list` SET 
                    `category_tags`='$category_tags',
                    `supplement_type`='$supplement_type',
                    `description`='$description',
                    `recommended_dosage`='$recommended_dosage',
                    `source`='$source'");

                    if (!$result) die("An error occurred while trying to update the existing record [ supplements_id: $supplements_id | supplement_type: $supplement_type ]: " . $dbconn->error . "]");
                } else {
                    // record does not exist, insert/create a new record 
                    $result = mysqli_query($dbconn, "INSERT INTO 
                    `supplements_list`(`supplements_id`, `category_tags`, `supplement_type`, `description`, `recommended_dosage`, `source`) 
                    VALUES (null,'$category_tags','$supplement_type','$description','$recommended_dosage','$source')");

                    // $result = $dbconn->query($query);

                    if (!$result) die("An error occurred while trying to save the new record [ supplements_id: $supplements_id ]: " . $dbconn->error . "]");
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
