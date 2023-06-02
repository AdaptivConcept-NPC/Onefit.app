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
    $admin_id =
    $username =
    $password_hash =
    $admin_name =
    $admin_surname =
    $id_number =
    $admin_email =
    $contact_number =
    $date_of_birth =
    $admin_gender =
    $admin_race =
    $admin_nationality =
    $account_active = null;

if (!isset($_GET['giveme'])) $requestfor = "";
else $requestfor = sanitizeMySQL($dbconn, $_GET['giveme']);

try {
    // 
    $query = "SELECT * FROM `administrators` ORDER BY `admin_id` DESC";

    $result = $dbconn->query($query);

    if (!$result) die($output);

    $rows = $result->num_rows;

    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        /* admin_id, 
        username, 
        password_hash, 
        admin_name, 
        admin_surname, 
        id_number, 
        admin_email, 
        contact_number, 
        date_of_birth, 
        admin_gender, 
        admin_race, 
        admin_nationality, 
        account_active */

        $admin_id = $row["admin_id"];
        $username = $row["username"];
        // $password_hash = $row["password_hash"];
        $admin_name = $row["admin_name"];
        $admin_surname = $row["admin_surname"];
        $id_number = $row["id_number"];
        $admin_email = $row["admin_email"];
        $contact_number = $row["contact_number"];
        $date_of_birth = $row["date_of_birth"];
        $admin_gender = $row["admin_gender"];
        $admin_race = $row["admin_race"];
        $admin_nationality = $row["admin_nationality"];
        $account_active = $row["account_active"];

        $compile .= <<<_END
        <tr>
            <th scope="row"> $admin_id </th>
            <td> $username </td>
            <!-- <td>Password</td> -->
            <td> $admin_name </td>
            <td> $admin_surname </td>
            <td> $id_number </td>
            <td> $admin_email </td>
            <td> $contact_number </td>
            <td> $date_of_birth </td>
            <td> $admin_gender </td>
            <td> $admin_race </td>
            <td> $admin_nationality </td>
            <td> $account_active </td>
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
