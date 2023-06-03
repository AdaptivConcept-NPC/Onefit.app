<?php
// include mysql database configuration file
// code sourced from: https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
session_start();
require("../admin_config.php");
require('../functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// 
if (!isset($_GET['giveme'])) $requestfor = "ui_data";
else $requestfor = sanitizeMySQL($dbconn, $_GET['giveme']);

// 
if (!isset($_GET['grpcategory'])) die("no grpcategory to get data for [test flag]");
else $groupcategory = sanitizeMySQL($dbconn, $_GET['grpcategory']);

// check username of admin from session data 
if (isset($_SESSION['currentAdminUsername'])) {
    $current_logged_admin = $_SESSION['currentAdminUsername'];
} else {
    // check if regular user username is available: for test only
    if (!isset($_SESSION['currentUserUsername'])) die("no user to filter for [test flag]");
    else $current_logged_admin = $_SESSION['currentUserUsername'];
}

switch ($groupcategory) {
    case 'teams':
        $query = "SELECT * FROM `groups` WHERE `administrators_username` = '$current_logged_admin' AND `group_category` = '$groupcategory' ORDER BY`group_id` DESC";
        break;
    case 'pro':
        $query = "SELECT * FROM `groups` WHERE `administrators_username` = '$current_logged_admin' AND `group_category` = '$groupcategory' ORDER BY`group_id` DESC";
        break;
    case 'community':
        $query = "SELECT * FROM `groups` WHERE `administrators_username` = '$current_logged_admin' AND `group_category` = '$groupcategory' ORDER BY`group_id` DESC";
        break;

    default:
        die("no grpcategory to get data for [test flag]");
        break;
}

try {
    //declaring variables
    $grps_groupid =
        $grps_refcode =
        $grps_name =
        $grps_description =
        $grps_category =
        $grps_privacy =
        $grps_createdby =
        $grps_createdate = null;

    $result = $dbconn->query($query);

    if (!$result) die("Fatal error: " . $dbconn->error);

    $rows = $result->num_rows;

    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        /**/

        $grps_groupid = $row["group_id"];
        $grps_refcode = $row["group_ref_code"];
        $grps_name = $row["group_name"];
        $grps_description = $row["group_description"];
        $grps_category = $row["group_category"];
        $grps_privacy = $row["group_privacy"];
        $grps_createdby = $row["administrators_username"];
        $grps_createdate = $row["creation_date"];

        $compile .= <<<_END


        <tr>
            <td> $muscle_group_id </td>
            <td> $major_muscle_group </td>
            <td> $sub_muscle_group </td>
            <td> $position_definition </td>

            <td> $grps_groupid =
            <td> $grps_refcode =
            <td> $grps_name =
            <td> $grps_description =
            <td> $grps_category =
            <td> $grps_privacy =
            <td> $grps_createdby =
            <td> $grps_createdate
        </tr>
        _END;
    }

    if ($req == 'ui_data') {
        $output = $compile;
        return $output;
    } elseif ($req == 'json') {
        $output = $row;
        return json_encode($output);
    }
} catch (\Throwable $th) {
    return "Exeption error occured: " . $th->getMessage();
}
