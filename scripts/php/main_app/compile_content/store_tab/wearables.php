<?php
// include mysql database configuration file
// code sourced from: https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
session_start();
require("../../../config.php");
require('../../../functions.php');

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

if (!isset($_GET['giveme'])) $requestfor = "json";
else $requestfor = sanitizeMySQL($dbconn, $_GET['giveme']);

try {
    // 
    $query = "SELECT * FROM `store_products` WHERE `product_category` = 'wearables' ORDER BY `inventory_number` DESC";

    $result = $dbconn->query($query);

    if (!$result) die($output);

    if ($requestfor == 'json') {
        $output = $result;
        die(json_encode($output));
    }

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

        $addToCartBtn = null;
        if ($inventory_status === 0) {
            $addToCartBtn = <<<_END
            <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold" disabled>
                Sold Out
            </button>
            _END;
        } else {
            $addToCartBtn = <<<_END
            <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                Add to Cart
            </button>
            _END;
        }

        $compile .= <<<_END
        <div id="inventory-$inventory_number" class="card grid-tile shadow" style="background-color: var(--secondary-color) !important; overflow: hidden;">
            <img src="$product_image_url" class="card-img-top" alt="$product_name | $product_category | $product_tag">
            <div class="card-body">
                <h5 class="card-title fs-4">$product_name</h5>
                <h5 class="card-title">R $selling_price_zar</h5>
                <p class="card-text">$product_description</p>
                <hr>
                <p class="card-text">Specifications</p>
                <div>
                    $product_specifications
                </div>
            </div>
            <div class="card-footer d-grid">
                $addToCartBtn
            </div>
        </div>
        _END;
    }

    // echo ui_data
    $output = $compile;
    echo $output;
} catch (\Throwable $th) {
    throw "Exeption error occured: " . $th->getMessage();
}
