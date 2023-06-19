<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['uid'])) {
    // check if user (uid) is an administrator
    $user_id = sanitizeMySQL($dbconn, $_GET['uid']);

    // output
    echo <<<_END
    <!-- Administration Portal. -->
    <div class="container h-100 w-100">
        <iframe id="admin-portal-frame" class="h-100 w-100 light-scroller" src="../administration/?admin=$user_id" style="min-height:10vh;">
        </iframe>
    </div>
    _END;
} else {
    echo "return: No POST request received";
}
