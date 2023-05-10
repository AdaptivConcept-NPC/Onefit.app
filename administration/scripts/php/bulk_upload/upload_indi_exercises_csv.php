<?php
session_start();
require("../admin_config.php");
require('../functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // if (isset($_POST['submit'])) {
    // include mysql database configuration file
    // code sourced from: https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
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
        if (!empty($_FILES['csvfile-exercises']['name']) && in_array($_FILES['csvfile-exercises']['type'], $fileMimes)) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['csvfile-exercises']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
                // Get row data
                // exercise_id	
                // exercise_name	
                // instructions	
                // guidelines	
                // sets	
                // reps	
                // rests	
                // xp_points	
                // training_phase
                $exercise_id = sanitizeMySQL($dbconn, $getData[0]);
                $exercise_name = sanitizeMySQL($dbconn, $getData[1]);
                $instructions = sanitizeMySQL($dbconn, $getData[2]);
                $guidelines = sanitizeMySQL($dbconn, $getData[3]);
                $sets = sanitizeMySQL($dbconn, $getData[4]);
                $reps = sanitizeMySQL($dbconn, $getData[5]);
                $rests = sanitizeMySQL($dbconn, $getData[6]);
                $xp_points = sanitizeMySQL($dbconn, $getData[7]);
                $training_phase = sanitizeMySQL($dbconn, $getData[8]);

                // mysql query to check If user an identifier exists in the database, in this case we want to query if there
                // are records in the database that have the same inventory number
                $query = "SELECT * FROM `exercises` WHERE `exercise_id` =  $exercise_id";
                // run the check in the db using the query string above
                $check = mysqli_query($dbconn, $query);

                if ($check->num_rows > 0) {
                    // record exists, update the existing record with the new data/values
                    $result = mysqli_query($dbconn, "UPDATE `exercises` SET 
                    `exercise_name`='$exercise_name',
                    `instructions`='$instructions',
                    `guidelines`='$guidelines',
                    `sets`=$sets,
                    `reps`=$reps,
                    `rests`=$rests,
                    `xp_points`=$xp_points,
                    `training_phase`='$training_phase' 
                    WHERE `exercise_id` =  $exercise_id");

                    if (!$result) die("An error occurred while trying to update the existing record [ exercise_id: $exercise_id : exercise_name: $exercise_name ]: " . $dbconn->error . "]");
                } else {
                    // record does not exist, insert/create a new record 
                    $result = mysqli_query($dbconn, "INSERT INTO 
                    `exercises`(`exercise_id`, `exercise_name`, `instructions`, `guidelines`, `sets`, `reps`, `rests`, `xp_points`, `training_phase`) 
                    VALUES (null,'$exercise_name','$instructions','$guidelines',$sets,$reps,$rests,$xp_points,'$training_phase')");

                    // $result = $dbconn->query($query);

                    if (!$result) die("An error occurred while trying to save the new record [ exercise_id: $exercise_id : exercise_name: $exercise_name ]: " . $dbconn->error . "]");
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
