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
        if (!empty($_FILES['csvfile']['name']) && in_array($_FILES['csvfile']['type'], $fileMimes)) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['csvfile']['tmp_name'], 'r');

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
                // product_tag	product_image

                $inventory_number = $getData[0];
                $product_name = $getData[1];
                $product_brand = $getData[2];
                $product_category = $getData[3];
                $purchase_price_zar = $getData[4];
                $selling_price_zar = $getData[5];
                $product_description = $getData[6];
                $product_specifications = $getData[7];
                $product_weight = $getData[8];
                $inventory_status = $getData[9];
                $product_tag = $getData[10];
                $product_image = $getData[11];

                // mysql query to check If user an identifier exists in the database, in this case we want to query if there
                // are records in the database that have the same inventory number
                $query = "SELECT * FROM `store_products` WHERE `inventory_number` =  '$inventory_number'";
                // run the check in the db using the query string above
                $check = mysqli_query($dbconn, $query);

                if ($check->num_rows > 0) {
                    // record exists, update the existing record with the new data/values
                    mysqli_query($dbconn, "UPDATE `store_products` SET 
                    `product_name`='[value-3]',
                    `product_brand`='[value-4]',
                    `product_category`='[value-5]',
                    `purchase_price_zar`='[value-6]',
                    `selling_price_zar`='[value-7]',
                    `product_description`='[value-8]',
                    `product_specifications`='[value-9]',
                    `product_weight`='[value-10]',
                    `inventory_status`='[value-11]',
                    `product_tag`='[value-12]',
                    `product_image_url`='[value-13]' 
                    WHERE `inventory_number`='[value-2]'");
                } else {
                    // record does not exist, insert/create a new record 
                    mysqli_query($dbconn, "INSERT INTO 
                    `store_products`(`product_id`, `inventory_number`, `product_name`, `product_brand`, `product_category`, `purchase_price_zar`, `selling_price_zar`, 
                    `product_description`, `product_specifications`, `product_weight`, `inventory_status`, `product_tag`, `product_image_url`) 
                    VALUES (null,'$inventory_number','$product_name','$product_brand','$product_category',$purchase_price_zar,$selling_price_zar,
                    '$product_description','$product_specifications',$product_weight,$inventory_status,'$product_tag','$product_image')");
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
