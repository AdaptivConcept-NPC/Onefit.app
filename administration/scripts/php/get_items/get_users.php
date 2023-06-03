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
    $user_id =
    $username =
    $password_hash =
    $user_name =
    $user_surname =
    $id_number =
    $user_email =
    $contact_number =
    $date_of_birth =
    $user_gender =
    $user_race =
    $user_nationality =
    $account_active = null;

if (!isset($_GET['giveme'])) $requestfor = "ui_data";
else $requestfor = sanitizeMySQL($dbconn, $_GET['giveme']);

try {
    // 
    $query = "SELECT * FROM `users` ORDER BY `user_id` DESC";

    $result = $dbconn->query($query);

    if (!$result) die($output);

    $rows = $result->num_rows;

    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        $user_id = $row["user_id"];
        $username = $row["username"];
        // $password_hash = $row["password_hash"];
        $user_name = $row["user_name"];
        $user_surname = $row["user_surname"];
        $id_number = $row["id_number"];
        $user_email = $row["user_email"];
        $contact_number = $row["contact_number"];
        $date_of_birth = $row["date_of_birth"];
        $user_gender = $row["user_gender"];
        $user_race = $row["user_race"];
        $user_nationality = $row["user_nationality"];
        $account_active = $row["account_active"];

        $compile .= <<<_END
        <tr>
            <th scope="row"> $user_id </th>
            <td> $username </td>
            <!-- <td>Password</td> -->
            <td> $user_name </td>
            <td> $user_surname </td>
            <td> $id_number </td>
            <td> $user_email </td>
            <td> $contact_number </td>
            <td> $date_of_birth </td>
            <td> $user_gender </td>
            <td> $user_race </td>
            <td> $user_nationality </td>
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
