<?php
// include mysql database configuration file
// code sourced from: https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
session_start();
require("../../../../scripts/php/config.php");
require('../../../../scripts/php/functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// global variables
$output =
    $supplement_id =
    $category_tags =
    $supplement_type =
    $description =
    $recommended_dosage =
    $source = null;

$compile = <<<_END
<option value="none"> None </option>
_END;

if (!isset($_GET['giveme'])) $requestfor = "";
else $requestfor = sanitizeMySQL($dbconn, $_GET['giveme']);

try {
    // 
    $query = "SELECT * FROM `supplements_list` ORDER BY `supplement_type` ASC";

    $result = $dbconn->query($query);

    if (!$result) die($output);

    $rows = $result->num_rows;

    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        $supplement_id = $row["supplement_id"];
        $category_tags = $row["category_tags"];
        $supplement_type = $row["supplement_type"];
        $description = $row["description"];
        $recommended_dosage = $row["recommended_dosage"];
        $source = $row["source"];

        $compile .= <<<_END
        <option value="$supplement_id"> [for: $category_tags] $supplement_type </option>
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
