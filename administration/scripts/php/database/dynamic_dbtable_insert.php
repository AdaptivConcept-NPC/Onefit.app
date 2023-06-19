<?php
session_start();
require("../admin_config.php");
require('../functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // check the table name from get param: tblsubmit
    if (!isset($_GET["tblsubmit"])) die("Fatal error: Submit table not set");
    else $tblSubmit = $_GET["tblsubmit"];

    // get post data index variables (keys) and create null variables dynamically
    foreach ($_POST as $param_name => $param_val) {
        echo "Param: $param_name; Value: $param_val<br />\n";
        // assign variables param values to the index variables created
        $$param_name = sanitizeMySQL($dbconn, $param_val);
        $columnNames .= $$param_name;
        echo $$param_name . "<br />\n";
        $submitValues .= "$param_val,";
    }

    function submit_data($tblSubmit, $queryString)
    {
        // i should try using transaction method instead to handle the different data type values insertions?
        echo "Table to submit to: " . $tblSubmit . " | Query string: " . $queryString;
    }

    // remove comma from the end of the query $submitValues string
    $submitValues = rtrim(trim($submitValues), ',');

    $queryString = "INSERT INTO $tblSubmit VALUES ($submitValues)";

    submit_data($tblSubmit, $queryString);
} else {
    die("Fatal Error: no post data");
}
