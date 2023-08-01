<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// declaring variables
if (isset($_GET['sp-category'])) $req_sport_category = sanitizeMySQL($dbconn, $_GET['sp-category']);
else $req_sport_category =  "all";

$current_user_username = sanitizeMySQL($dbconn, $_SESSION['currentUserUsername']);
$compileList = <<<_END
<option value="noselection" selected>⚽️ Select Sport. 🏀</option>
_END;
$sport_id
    = $sport_category
    = $sport_name = null;

try {
    // select query string based on group privacy that has been requested
    if ($req_sport_category == 'all') {
        $query = "SELECT * FROM sports_list ORDER BY `name` ASC";
    } else {
        $query = "SELECT * FROM sports_list WHERE `category` = '$req_sport_category' ORDER BY `name` ASC";
    }

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to compile the requested data. [output - " . $dbconn->error . "]");

    $rows = $result->num_rows;

    if ($rows == 0) {
        //there is no result
        $compileList = <<<_END
        <option value="error" selected>No Sports found.</option>
        _END;
    } else {
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $sport_id = $row["sport_id"];
            $sport_category = $row["category"];
            $sport_name = $row["name"];

            $compileList .= <<<_END
            <option value="$sport_id" sp-category="$sport_category"> $sport_name </option>
            _END;
        }
    }

    echo $compileList;

    // close connection
    // $result = null;
    $result = null;
    $dbconn->close();
} catch (\Throwable $th) {
    throw "Exception Error: " . $th;
}
