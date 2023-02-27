<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo <<<_END
    
    _END;
} else {
    echo "return: No POST request received";
}
