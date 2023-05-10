<?php
// include mysql database configuration file
// code sourced from: https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
session_start();
require("../admin_config.php");
require('../functions.php');

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
        if (!empty($_FILES['csvfile-store_products']['name']) && in_array($_FILES['csvfile-store_products']['type'], $fileMimes)) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['csvfile-store_products']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
                // Get row data
                // exercise_drill_id	
                // drill_title	
                // thumbnail	
                // drill_demo_vid	
                // training_level	
                // target_area	
                // benefits	
                // instructions	
                $exercise_drill_id = $getData[0];
                $drill_title = $getData[1];
                $thumbnail = $getData[2];
                $drill_demo_vid = $getData[3];
                $training_level = $getData[4];
                $target_area = $getData[5];
                $benefits = $getData[6];
                $instructions = $getData[7];

                // mysql query to check If user an identifier exists in the database, in this case we want to query if there
                // are records in the database that have the same inventory number
                $query = "SELECT * FROM `exercise_drills` WHERE `exercise_drill_id` =  '$exercise_drill_id'";
                // run the check in the db using the query string above
                $check = mysqli_query($dbconn, $query);

                if ($check->num_rows > 0) {
                    // record exists, update the existing record with the new data/values
                    $result = mysqli_query($dbconn, "UPDATE `exercise_drills` SET 
                    `sport`='$sport',
                    `drill_title`='$drill_title',
                    `thumbnail`='$thumbnail',
                    `drill_demo_vid`='$drill_demo_vid',
                    `training_level`='$training_level',
                    `target_area`='$target_area',
                    `benefits`='$benefits',
                    `instructions`='$instructions'
                    WHERE `exercise_drill_id`=$exercise_drill_id");

                    if (!$result) die("An error occurred while trying to update the existing record [ exercise_drill_id: $exercise_drill_id | sport: $sport | drill_title: $drill_title ]: " . $dbconn->error . "]");
                } else {
                    // record does not exist, insert/create a new record 
                    $result = mysqli_query($dbconn, "INSERT INTO `exercise_drills` 
                    (`exercise_drill_id`, `sport`, `drill_title`, `thumbnail`, `drill_demo_vid`, `training_level`, `target_area`, `benefits`, 
                    `instructions`, `administrators_username`) 
                    VALUES (null,'$sport','$drill_title','$thumbnail','$drill_demo_vid','$training_level','$target_area','$benefits',
                    '$instructions','$administrators_username')");

                    // $result = $dbconn->query($query);

                    if (!$result) die("An error occurred while trying to save the new record [ exercise_drill_id: $exercise_drill_id | sport: $sport | drill_title: $drill_title ]: " . $dbconn->error . "]");
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
