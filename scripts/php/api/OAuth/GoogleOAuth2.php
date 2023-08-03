<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once 'oauth2callback.php';


session_start();

$client = new Google\Client();
$client->setAuthConfigFile('./GoogleOAuth_CS/testing/client_secret.json');
$client->addScope(Google\Service\OAuth2::USERINFO_PROFILE);
$client->addScope(Google\Service\OAuth2::USERINFO_EMAIL);
$client->addScope(Google\Service\OAuth2::OPENID);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);

  // get the users profile information and email address
  $gauth = new Google\Service\OAuth2($client);
  $user_info = $gauth->userinfo->get();
  $user_email = $user_info->email;
  $user_name = $user_info->name;
  $user_fname = $user_info->givenName;
  $user_lname = $user_info->familyName;
  $user_gender = $user_info->gender;
  $user_locale = $user_info->locale;

  // echo <<<_END
  // success: Currently signed in: Name: $user_name, FName: $user_fname, LName: $user_lname, Gender: $user_gender, Email: $user_email
  // _END;

  // call proceed function from oauth2callback.php
  function proceedLogin($dbconn, $user_email, $user_name, $user_fname, $user_lname, $user_gender, $user_locale)
  {
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

  proceedLogin($dbconn, $user_email, $user_name, $user_fname, $user_lname, $user_gender, $user_locale);

  // $files = $drive->files->listFiles(array())->getItems(); /* drive example */
  // echo json_encode($files); /* drive example */
} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/Onefit/scripts/php/api/OAuth/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

// source: https://developers.google.com/identity/protocols/oauth2
// $client = new Google\Client();
// // 
// $client->setAuthConfig('../../../../GoogleOAuth/testing/client_secret_667146645843-kl770iiu0vd35uq4k2u870sgegv12jab.apps.googleusercontent.com.json');
// $client->addScope(Google\Service\Drive::DRIVE_METADATA_READONLY);
// $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
// // offline access will give you both an access and refresh token so that
// // your app can refresh the access token without user interaction.
// $client->setAccessType('offline');
// // Using "consent" ensures that your application always receives a refresh token.
// // If you are not using offline access, you can omit this.
// $client->setApprovalPrompt('consent');
// $client->setIncludeGrantedScopes(true);   // incremental auth