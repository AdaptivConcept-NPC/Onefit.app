<?php

session_start();
require_once("../scripts/php/admin_config.php");
require_once("../scripts/php/functions.php");

$prefix = $policy_type = null;
if (isset($_GET['prefix'])) {
    $prefix = sanitizeMySQL($dbconn, $_GET['prefix']);
} else {
    $prefix = "onefitapp";
}
if (isset($_GET['policy_type'])) {
    $policy_type = sanitizeMySQL($dbconn, $_GET['policy_type']);
} else {
    $policy_type = "pt";
}

echo $prefix . "_policy_" . $policy_type . "_" . generateNumericRandomString(6) . "_" . generateAlphaNumericRandomString(4);
