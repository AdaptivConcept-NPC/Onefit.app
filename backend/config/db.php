<?php
// backend/config/db.php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'adaptivc_onefit_admin');
define('DB_PASSWORD', '8MEw3Ps!dJLksWf');
define('DB_DATABASE', 'adaptivc_onefit_db');

$dbconn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if ($dbconn->connect_error) {
    die(json_encode([
        "success" => false, 
        "message" => "Database connection failed: " . $dbconn->connect_error
    ]));
}
?>
