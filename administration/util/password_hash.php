<?php
require_once("../scripts/php/functions.php");

if (!isset($_GET['convertstring']) || $_GET['convertstring'] == "") die("No string in get params.");
else $convertstring = $_GET['convertstring'];

$hashedString = password_hash($convertstring, PASSWORD_DEFAULT);
echo "This is your PWD Hash: </br>$hashedString";
