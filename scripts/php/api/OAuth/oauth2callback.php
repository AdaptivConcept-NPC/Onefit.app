<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

require_once '../../functions.php';
require_once '../../config.php';

session_start();

$client = new Google\Client();
$client->setAuthConfigFile('./GoogleOAuth_CS/testing/client_secret.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/Onefit/scripts/php/api/OAuth/oauth2callback.php');
$client->addScope(Google\Service\OAuth2::USERINFO_PROFILE);
$client->addScope(Google\Service\OAuth2::USERINFO_EMAIL);
$client->addScope(Google\Service\OAuth2::OPENID);

if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();

    // get the name of the user from returned profile information and store $_session values
    $gauth = new Google\Service\OAuth2($client);
    $user_info = $gauth->userinfo->get();
    $user_email = $user_info->email;
    $user_name = $user_info->name;
    $user_fname = $user_info->givenName;
    $user_lname = $user_info->familyName;
    $user_gender = $user_info->gender;
    $user_locale = $user_info->locale;

    // check if email is already registered, if not, create a new temp user record
    function checkUserExists($dbconn, $user_email, $user_name, $user_fname, $user_lname, $user_gender, $user_locale)
    {
        if ($dbconn->connect_error) die("Fatal Error");

        $query = "SELECT * FROM `users` WHERE `user_email` = '$user_email' AND `user_name` LIKE '%$user_fname%'";

        $result = $dbconn->query($query);
        if (!$result) die("[checkUserExists] A Fatal Error has occured. Please try again and if the problem persists, please contact the system administrator.");

        $rows = $result->num_rows;

        if ($rows == 0) {
            //there is no result
            $result->clear();
            return false;
        } else {
            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $_SESSION['currentUserAuth'] = true;
                $_SESSION['currentUserForename'] = $row["user_name"];
                $_SESSION['currentUserSurname'] = $row["user_surname"];
                $_SESSION['currentUserEmail'] = $row["user_email"];
                $_SESSION['currentUserUsername'] = $row["username"];
            }
            return true;
        }
    }

    function createTempUser($dbconn, $user_email, $user_name, $user_fname, $user_lname, $user_gender, $user_locale)
    {
        // temp username
        $usrnm = 'temp_oauth_' . generateAlphaNumericRandomString(6);
        $pwd = generateAlphaNumericRandomString(10);
        $pwdhash = password_hash($pwd, PASSWORD_DEFAULT);
        // generate random string for $id_number_random_string
        $id_number_random_string = "tempt_" . date('Ymd') . generateAlphaNumericRandomString(6);

        $dateNow = date('Y-m-d');

        $query = "INSERT INTO `users` 
        (`user_id`, `username`, `password_hash`, `user_name`, `user_surname`, `id_number`, `user_email`, `contact_number`, `date_of_birth`, `user_gender`, `user_race`, `user_nationality`, `account_active`) 
        VALUES 
        (null, '$usrnm', '$pwdhash', '$user_fname', '$user_lname', '$id_number_random_string', '$user_email', 'No contact', '$dateNow', '$user_gender', null, '$user_locale', 1)";

        $result = $dbconn->query($query);
        if (!$result) return false;

        $_SESSION['currentUserAuth'] = true;
        $_SESSION['currentUserForename'] = $user_fname;
        $_SESSION['currentUserSurname'] = $user_lname;
        $_SESSION['currentUserEmail'] = $user_email;
        $_SESSION['currentUserUsername'] = $usrnm;

        // create a temp profile
        createTempProfile($dbconn, $usrnm);

        return true;
    }

    function createTempProfile($dbconn, $usrnm)
    {
        $user_url_reference = generateAlphaNumericRandomString(20);

        $query = "INSERT INTO `general_user_profiles`
        (`user_profile_id`, `about`, `profile_type`, `verification`, `profile_url`, `profile_image_url`, `profile_banner_url`, `users_username`) 
        VALUES 
        (null,'Tell the community about who you are.','community','unverified','$user_url_reference','0_default/default_profile_pic.svg','0_default/default_profile_banner.jpg','$usrnm')";

        $result = $dbconn->query($query);

        if (!$result) return false;

        // $profile_id = $dbconn->insert_id;

        return true;
    }

    // date and time strings
    $dateNow = date('Y-m-d ');
    $timeNow = date('H-i-s');
    // generate a entry reference string for the activity log entry
    $entry_ref = generateAlphaNumericRandomString(6) . "_" . $dateNow . "_" . $timeNow;

    $userExists = checkUserExists($dbconn, $user_email, $user_name, $user_fname, $user_lname, $user_gender, $user_locale);

    if (!$userExists) {
        // create a new temp user record
        $returned = createTempUser($dbconn, $user_email, $user_name, $user_fname, $user_lname, $user_gender, $user_locale);

        if ($returned === false) {
            // failed to create user
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/Onefit/?return=oauth2_fatal_error';
        } elseif ($returned === true) {
            $currentUserUsername = $_SESSION['currentUserUsername'];
            // created user successfully and assigned session values
            $submissionFlag = log_activity("Google OAuth2", "Signed in.", "$user_name ($currentUserUsername) signed into the app. <br/> <span data-barcode>[ $entry_ref ]</span>", "user_activity", "NULL", $currentUserUsername);
        }
    } else {
        $currentUserUsername = $_SESSION['currentUserUsername'];
        // user exists, session values were assigned in checkUserExists(), log the login interaction
        $submissionFlag = log_activity("user", "Signed in.", "$user_name ($currentUserUsername) signed into the app. <br/> <span data-barcode>[ $entry_ref ]</span>", "user_activity", "NULL", $currentUserUsername);
    }

    // delay execution for 2 seconds
    sleep(2);

    if ($submissionFlag === true) {
        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/Onefit/app/?userauth=true&logged=yes';
    } else {
        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/Onefit/app/?userauth=true&logged=no';
    }

    // kill db connection
    $dbconn->close();

    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
