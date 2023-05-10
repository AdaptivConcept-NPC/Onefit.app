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
        if (!empty($_FILES['csvfile-category_class']['name']) && in_array($_FILES['csvfile-category_class']['type'], $fileMimes)) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['csvfile-category_class']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
                // Get row data
                // category_class_id
                // category_class_code
                // category_class_name
                $category_class_id = sanitizeMySQL($dbconn, $getData[0]);
                $category_class_code = sanitizeMySQL($dbconn, $getData[1]);
                $category_class_name = sanitizeMySQL($dbconn, $getData[2]);

                // If user category/class exists in the database with the same category_class_code
                $query = "SELECT * FROM `category_class` WHERE `category_class_code` = '$category_class_code'";

                $check = mysqli_query($dbconn, $query);

                if ($check->num_rows > 0) {
                    // update the existing record with the new data/values
                    mysqli_query($dbconn, "UPDATE `category_class` 
                    SET `category_class_code`='$category_class_code',`category_class_name`='$category_class_name' 
                    WHERE `category_class_code` = '$category_class_code'");
                } else {
                    // insert/create a new record 
                    mysqli_query($dbconn, "INSERT INTO `category_class`
                    (`category_class_id`, `category_class_code`, `category_class_name`) 
                    VALUES 
                    (null,'$category_class_code','$category_class_name')");
                }
            }

            // Close opened CSV file
            fclose($csvFile);

            // header("Location: index.php");

            // return success message
            echo "success";
        } else {
            echo "Request could not be processed. Please select a valid file. *or no data was received";
        }
    } catch (\Throwable $th) {
        throw "Exeption error occured: " . $th->getMessage();
    }
}
