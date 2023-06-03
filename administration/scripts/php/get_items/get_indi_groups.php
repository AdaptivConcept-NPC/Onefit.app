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
    $current_logged_admin =
    $group_ref_code =
    $group_name =
    $group_description =
    $group_category =
    $group_privacy =
    $creation_date =
    $administrators_username = null;

// giveme param is required for determining content output type 
if (!isset($_GET['giveme'])) $requestfor = "ui_data";
else $requestfor = sanitizeMySQL($dbconn, $_GET['giveme']);

// check username of admin from session data 
if (isset($_SESSION['currentAdminUsername'])) {
    $current_logged_admin = $_SESSION['currentAdminUsername'];
} else {
    // check if regular user username is available: for test only
    if (!isset($_SESSION['currentUserUsername'])) die("no user to filter for [test flag]");
    else $current_logged_admin = $_SESSION['currentUserUsername'];
}

try {
    // 
    $query = "SELECT * FROM `groups` WHERE `group_category` = 'indi' AND `administrators_username` = '$current_logged_admin' ORDER BY `creation_date` DESC";

    $result = $dbconn->query($query);

    if (!$result) die($output);

    $rows = $result->num_rows;

    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        /* group_id, 
        group_ref_code, 
        group_name, 
        group_description, 
        group_category, 
        group_privacy, 
        creation_date, 
        administrators_username */

        $group_id = $row["group_id"];
        $group_ref_code =  $row["group_ref_code"];
        $group_name  = $row["group_name"];
        $group_description  = $row["group_description"];
        $group_category  = $row["group_category"];
        $group_privacy  = $row["group_privacy"];
        $creation_date  = $row["creation_date"];
        $administrators_username = $row["administrators_username"];



        $compile .= <<<_END
        <tr>
            <td> $group_id </td>
            <td> $group_ref_code </td>
            <td> $group_name </td>
            <td> $group_description </td>
            <td> $group_category </td>
            <td> $group_privacy </td>
            <td> $creation_date </td>
            <td> $administrators_username </td>
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
