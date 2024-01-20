<?php
require_once(__DIR__ . "/../../vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "\..\.."); // Update the path to include the correct directory
$dotenv->load();

$open_ai_key = getenv('OPEN_AI_KEY');

echo "flag <br>";
echo empty($open_ai_key) ? "No key found" : "Key: " . $open_ai_key;
