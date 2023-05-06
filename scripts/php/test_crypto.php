<?php
require("./functions.php");

if (isset($_GET['length'])) $length = $_GET['length']; // custom length passed through url param
else $length = 38; //default length

$generateRandomBytesFunctionOutput = generateRandomBytes($length);

$randomBytesOutput = random_bytes($length);

$format_uuidv4FunctionOutput = format_uuidv4($randomBytesOutput);

echo <<<_END
<h1>Testing Crytographic Functionality</h1>
<br>
generateRandomBytes(int: $length ) => <strong>$generateRandomBytesFunctionOutput</strong>
<br>
<br>
random_bytes(int: $length ) => <strong>$randomBytesOutput</strong>
<br>
<br>
format_uuidv4(random_bytes: $randomBytesOutput ) => <strong>$format_uuidv4FunctionOutput</strong>
<br>
<br>
_END;
