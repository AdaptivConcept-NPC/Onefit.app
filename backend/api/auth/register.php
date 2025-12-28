<?php
// backend/api/auth/register.php

require_once("../../config/headers.php");
require_once("../../config/db.php");
require_once("../../../scripts/php/functions.php");

function sendResponse($success, $message, $data = null) {
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, "Invalid request method.");
}

// Get POST data (handle JSON or FormData)
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if (strpos($contentType, 'application/json') !== false) {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    $_POST = $decoded; // Use $_POST for easy access
}

// Map frontend fields (from src/services/authService.js -> register -> userData) to backend expected fields
// Frontend RegistrationForm.jsx:
// - name -> reg-name
// - surname -> reg-surname
// - email -> reg-email
// - contact -> reg-contact
// - dob -> reg-dob
// - gender -> reg-gender
// - race -> reg-race
// - nationality -> reg-nationality
// - password -> reg-password
// - confirmPassword -> reg-confirmpassword

// Sanitize Inputs
$name = sanitizeMySQL($dbconn, $_POST['reg-name'] ?? '');
$surname = sanitizeMySQL($dbconn, $_POST['reg-surname'] ?? '');
$email = sanitizeMySQL($dbconn, $_POST['reg-email'] ?? '');
$contact = sanitizeMySQL($dbconn, $_POST['reg-contact'] ?? '');
$dob = sanitizeMySQL($dbconn, $_POST['reg-dob'] ?? '');
$gender = sanitizeMySQL($dbconn, $_POST['reg-gender'] ?? '');
$race = sanitizeMySQL($dbconn, $_POST['reg-race'] ?? '');
$nation = sanitizeMySQL($dbconn, $_POST['reg-nationality'] ?? '');
$pwd = sanitizeMySQL($dbconn, $_POST['reg-confirmpassword'] ?? '');
// username generation:
$usrnm = "onefitza_" . strtolower(generateAlphaNumericRandomString(8)) . strtolower(generateNumericRandomString(2));
$pwdhash = password_hash($pwd, PASSWORD_DEFAULT);

if (empty($email) || empty($pwd)) {
    sendResponse(false, "Email and Password are required.");
}

// Insert User
$id_number_random_string = "tempt_" . date('Ymd') . generateAlphaNumericRandomString(6);

$query = "INSERT INTO `users` 
(`user_id`, `username`, `password_hash`, `user_name`, `user_surname`, `id_number`, `user_email`, `contact_number`, `date_of_birth`, `user_gender`, `user_race`, `user_nationality`, `account_active`) 
VALUES 
(null, '$usrnm', '$pwdhash', '$name', '$surname', '$id_number_random_string', '$email', '$contact', '$dob', '$gender', '$race', '$nation', 0)";

$result = $dbconn->query($query);

if (!$result) {
    sendResponse(false, "Registration Failed (User): " . $dbconn->error);
}

$user_id = $dbconn->insert_id;
$user_url_reference = generateAlphaNumericRandomString(20);

// Insert Profile
$queryProfile = "INSERT INTO `general_user_profiles`
(`user_profile_id`, `about`, `profile_type`, `verification`, `profile_url`, `profile_image_url`, `profile_banner_url`, `users_username`) 
VALUES 
(null,'Tell the community about who you are.','community','unverified','$user_url_reference','0_default/default_profile_pic.svg','0_default/default_profile_banner.jpg','$usrnm')";

$resultProfile = $dbconn->query($queryProfile);

if (!$resultProfile) {
    sendResponse(false, "Registration Failed (Profile): " . $dbconn->error);
}

$profile_id = $dbconn->insert_id;

// Create Directories (Media)
// Path relative to: backend/api/auth/register.php -> ../../../../../media/profiles/
$dir_path = '../../../../../media/profiles/' . $usrnm;

if (!is_dir($dir_path)) {
    if (mkdir($dir_path, 0777, true)) {
        mkdir($dir_path . "/profile_images", 0777, true);
        mkdir($dir_path . "/profile_banners", 0777, true);
        mkdir($dir_path . "/shared_media", 0777, true);
        mkdir($dir_path . "/private_media", 0777, true);
        mkdir($dir_path . "/video_media", 0777, true);
    } else {
        // Log error but don't fail registration completely? Or warn?
        // sendResponse(false, "User media folder creation failed.");
    }
}

$dbconn->close();

sendResponse(true, "Registration successful", [
    "user_id" => $user_id,
    "username" => $usrnm,
    "profile_id" => $profile_id
]);
?>
