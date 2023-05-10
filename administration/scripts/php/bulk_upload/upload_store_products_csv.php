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
                // product_id	
                // inventory_number	
                // product_name	
                // product_brand	
                // product_category	 
                // purchase_price_zar 	 
                // selling_price_zar 	
                // product_description	
                // product_specifications	
                // product_weight	
                // inventory_status	
                // product_tag	
                // product_image_url
                $product_id = sanitizeMySQL($dbconn, $getData[0]);
                $inventory_number = sanitizeMySQL($dbconn, $getData[1]);
                $product_name = sanitizeMySQL($dbconn, $getData[2]);
                $product_brand = sanitizeMySQL($dbconn, $getData[3]);
                $product_category = sanitizeMySQL($dbconn, $getData[4]);
                $purchase_price_zar = sanitizeMySQL($dbconn, $getData[5]);
                $selling_price_zar = sanitizeMySQL($dbconn, $getData[6]);
                $product_description = sanitizeMySQL($dbconn, $getData[7]);
                $product_specifications = sanitizeMySQL($dbconn, $getData[8]);
                $product_weight = sanitizeMySQL($dbconn, $getData[9]);
                $inventory_status = sanitizeMySQL($dbconn, $getData[10]);
                $product_tag = sanitizeMySQL($dbconn, $getData[11]);
                $product_image_url = sanitizeMySQL($dbconn, $getData[12]);

                // mysql query to check If user an identifier exists in the database, in this case we want to query if there
                // are records in the database that have the same inventory number
                $query = "SELECT * FROM `store_products` WHERE `inventory_number` =  '$inventory_number'";
                // run the check in the db using the query string above
                $check = mysqli_query($dbconn, $query);

                if ($check->num_rows > 0) {
                    // record exists, update the existing record with the new data/values
                    $result = mysqli_query($dbconn, "UPDATE `store_products` SET 
                    `product_name`='$product_name',
                    `product_brand`='$product_name',
                    `product_category`='$product_category',
                    `purchase_price_zar`=$purchase_price_zar,
                    `selling_price_zar`=$selling_price_zar,
                    `product_description`='$product_description',
                    `product_specifications`='$product_specifications',
                    `product_weight`=$product_weight,
                    `inventory_status`=$inventory_status,
                    `product_tag`='$product_tag',
                    `product_image_url`='$product_image_url' 
                    WHERE `inventory_number`='$inventory_number'");

                    if (!$result) die("An error occurred while trying to update the existing record [ $inventory_number ]: " . $dbconn->error . "]");
                } else {
                    // record does not exist, insert/create a new record 
                    $result = mysqli_query($dbconn, "INSERT INTO 
                    `store_products`(`product_id`, `inventory_number`, `product_name`, `product_brand`, `product_category`, `purchase_price_zar`, `selling_price_zar`, 
                    `product_description`, `product_specifications`, `product_weight`, `inventory_status`, `product_tag`, `product_image_url`) 
                    VALUES (null,'$inventory_number','$product_name','$product_brand','$product_category',$purchase_price_zar,$selling_price_zar,
                    '$product_description','$product_specifications',$product_weight,$inventory_status,'$product_tag','$product_image_url')");

                    // $result = $dbconn->query($query);

                    if (!$result) die("An error occurred while trying to save the new record [ $inventory_number ]: " . $dbconn->error . "]");
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
