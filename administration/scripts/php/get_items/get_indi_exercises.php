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
    $exercise_id =
    $exercise_name =
    $instructions =
    $guidelines =
    $sets =
    $reps =
    $rests =
    $xp_points =
    $training_phase = null;

if (!isset($_GET['giveme'])) $requestfor = "ui_data";
else $requestfor = sanitizeMySQL($dbconn, $_GET['giveme']);

try {
    // 
    $query = "SELECT * FROM `exercises` ORDER BY `exercise_name` ASC";

    $result = $dbconn->query($query);

    if (!$result) die($output);

    $rows = $result->num_rows;

    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        $exercise_id = $row["exercise_id"];
        $exercise_name = $row["exercise_name"];
        $instructions = $row["instructions"];
        $guidelines = $row["guidelines"];
        $sets = $row["sets"];
        $reps = $row["reps"];
        $rests = $row["rests"];
        $xp_points = $row["xp_points"];
        $training_phase = $row["training_phase"];

        $compile .= <<<_END
        <option value="$exercise_id"> $exercise_name X[$xp_points]P </option>
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
