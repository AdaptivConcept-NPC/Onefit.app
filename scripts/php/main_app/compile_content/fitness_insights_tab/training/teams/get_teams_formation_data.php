<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// declaring variables
if (isset($_GET['grc'])) $grc_code = sanitizeMySQL($dbconn, $_GET['grc']);
else die("grc_code is not set");
