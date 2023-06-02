<?php
// include mysql database configuration file
// code sourced from: https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
session_start();
require("../admin_config.php");
require('../functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// global variables
$output =
    $compile =
    $product_id =
    $inventory_number =
    $product_name =
    $product_brand =
    $product_category =
    $purchase_price_zar =
    $selling_price_zar =
    $product_description =
    $product_specifications =
    $product_weight =
    $inventory_status =
    $product_tag =
    $product_image_url = null;

if (!isset($_GET['giveme'])) $requestfor = "";
else $requestfor = sanitizeMySQL($dbconn, $_GET['giveme']);

try {
    // 
    $query = "SELECT * FROM `store_products` ORDER BY `inventory_number` DESC";

    $result = $dbconn->query($query);

    if (!$result) die($output);

    $rows = $result->num_rows;

    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        $product_id = $row["product_id"];
        $inventory_number = $row["inventory_number"];
        $product_name = $row["product_name"];
        $product_brand = $row["product_brand"];
        $product_category = $row["product_category"];
        $purchase_price_zar = $row["purchase_price_zar"];
        $selling_price_zar = $row["selling_price_zar"];
        $product_description = $row["product_description"];
        $product_specifications = $row["product_specifications"];
        $product_weight = $row["product_weight"];
        $inventory_status = $row["inventory_status"];
        $product_tag = $row["product_tag"];
        $product_image_url = $row["product_image_url"];

        $compile .= <<<_END
        <tr>
            <td>$product_id</td>
            <td>$inventory_number</td>
            <td>$product_name</td>
            <td>$product_brand</td>
            <td>$product_category</td>
            <td>R $purchase_price_zar</td>
            <td>R $selling_price_zar</td>
            <td>$product_description</td>
            <td>$product_specifications</td>
            <td>$product_weight</td>
            <td>$inventory_status</td>
            <td>$product_tag</td>
            <td><img src="$product_image_url" class="img-fluid" alt="$product_name"/></td>
        </tr>
        _END;
    }

    if ($requestfor == 'ui_data') {
        $output = $compile;
        echo $output;
    } elseif ($requestfor == 'json') {
        $output = $result;
        echo json_encode($output);
    }

    // echo $output;
} catch (\Throwable $th) {
    throw "Exeption error occured: " . $th->getMessage();
}
