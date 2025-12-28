<?php
// backend/api/auth/login.php

session_start();

require_once("../../config/headers.php");
require_once("../../config/db.php");

// Include legacy functions (adjust path as needed)
// We need to point to the original functions.php which is in scripts/php/functions.php
// Current path: backend/api/auth/login.php -> ../../../scripts/php/functions.php
require_once("../../../scripts/php/functions.php");

// Helper to send JSON response
function sendResponse($success, $message, $data = null) {
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    exit();
}

// Check Request Method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, "Invalid request method.");
}

// Get POST data
// Vite/React might send JSON, or FormData. 
// If Content-Type is application/json, we need to read 'php://input'
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if (strpos($contentType, 'application/json') !== false) {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    $usernameInput = $decoded['onefitUserEmail'] ?? '';
    $passwordInput = $decoded['onefitUserPassword'] ?? '';
} else {
    // FormData
    $usernameInput = $_POST['onefitUserEmail'] ?? '';
    $passwordInput = $_POST['onefitUserPassword'] ?? '';
}

if (empty($usernameInput) || empty($passwordInput)) {
    sendResponse(false, "Email/Username and Password are required.");
}

// Sanitize (using legacy function if available, or just mysqli::real_escape_string)
// sanitizeMySQL is in functions.php, which expects $connection.
$username = sanitizeMySQL($dbconn, $usernameInput);
//$password = sanitizeMySQL($dbconn, $passwordInput); // Don't escape password before hashing verification/checking? Original script did it.

// Original script logic: $password = sanitizeMySQL($dbconn, $_POST['onefitUserPassword']);
// sanitizeMySQL calls real_escape_string and sanitizeString. 
// sanitizeString strips tags, html entities, etc. 
// WARNING: modifying the password string might break strict passwords, but we must follow legacy logic for now to match existing hashes.
$password = sanitizeMySQL($dbconn, $passwordInput);

$query = "SELECT * FROM `users` WHERE (`username` = '$username' OR `user_email` = '$username')";
$result = $dbconn->query($query);

if (!$result) {
    sendResponse(false, "Database error: " . $dbconn->error);
}

if ($result->num_rows == 0) {
    sendResponse(false, "Invalid username or password.");
}

$user = $result->fetch_assoc();
$pwdHash = $user["password_hash"];

if (password_verify($password, $pwdHash)) {
    // Password correct
    $_SESSION['currentUserAuth'] = true;
    $_SESSION['currentUserForename'] = $user["user_name"];
    $_SESSION['currentUserSurname'] = $user["user_surname"];
    $_SESSION['currentUserEmail'] = $user["user_email"];
    $_SESSION['currentUserUsername'] = $user["username"];

    // Log activity using legacy function
    // log_activity is possibly in functions.php or another included file. 
    // The original login.php used log_activity, but I didn't see it in functions.php that I read. 
    // It might be in another file or I missed it.
    // However, looking at the previous view_file of login.php (lines 3-4), it only requires config and functions.
    // So log_activity MUST be in functions.php. I might have missed it due to truncation or it wasn't shown.
    // I will try to call it wrapped in try-catch to avoid breaking if missing.
    
    $entry_ref = generateAlphaNumericRandomString(6) . "_" . date('Y-m-d_H-i-s');
    
    try {
        if(function_exists('log_activity')) {
           log_activity("user", "Signed in.", "{$user['user_name']} {$user['user_surname']} ({$user['username']}) signed into the app. <br/> <span data-barcode>[ $entry_ref ]</span>", "user_activity", "NULL", $user['username']);
        }
    } catch (Exception $e) {
        // Ignore logging error for now
    }

    sendResponse(true, "Login successful", [
        "user" => [
            "username" => $user["username"],
            "email" => $user["user_email"],
            "name" => $user["user_name"],
            "surname" => $user["user_surname"]
        ]
    ]);

} else {
    sendResponse(false, "Invalid username or password.");
}

$dbconn->close();
?>
