<?php
session_start();
require("../../../config.php");
require_once("../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");
