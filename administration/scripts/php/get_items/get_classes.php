<?php
// include mysql database configuration file
// code sourced from: https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
session_start();
require("../../../../scripts/php/config.php");
require('../../../../scripts/php/functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// global variables
$output = $category_class_id = $category_class_code = $category_class_name = null;

$compile = <<<_END
<option value="noselection">Select</option>
_END;

if (!isset($_GET['giveme'])) $requestfor = "";
else $requestfor = sanitizeMySQL($dbconn, $_GET['giveme']);

try {
    // 
    $query = "SELECT * FROM `category_class` ORDER BY `category_class_name` ASC";

    $result = $dbconn->query($query);

    if (!$result) die($output);

    $rows = $result->num_rows;

    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        $category_class_id = $row["category_class_id"];
        $category_class_code = $row["category_class_code"];
        $category_class_name = $row["category_class_name"];

        $compile .= <<<_END
        <option value="$category_class_code"> $category_class_name </option>
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
