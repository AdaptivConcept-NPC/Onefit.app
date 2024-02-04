<?php
session_start();
require("../../scripts/php/config.php");
require("../../scripts/php/functions.php");

// function to die and display error curtain
function die_error_curtain($error_msg, $error_code)
{
  $error_code = $error_code ?? 0;
  $error_name = null;
  // error codes
  // 0 - no error code
  // 1 - no connection to database
  // 2 - fatal error
  // 3 - exception error
  switch ($error_code) {
    case 1:
      $error_name = "No Connection";
      break;
    case 2:
      $error_name = "Fatal Error";
      break;
    case 3:
      $error_name = "Exception Error";
      break;

    default:
      $error_name = "General Error";
      break;
  }
  $dateYear = date('Y');

  // error curtain
  $error_curtain = <<<_END
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>$error_name Occured | Onefit.app | OnefitNet &copy; $dateYear</title>
      <!-- Google Icons -->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
      <!-- CSS -->
      <link rel="stylesheet" href="../../css/styles.css" />
    </head>
    <body>
        <!-- error Curtain -->
        <div class="offline-curtain" id="error-curtain" style="background-color: var(--secondary-color);">
            <nav class="navbar navbar-light stickyz fixed-top navbar-style bg-transparent" style="z-index: 10000;">
                <div class="container-fluid justify-content-center p-5">
                    <h1 class="navbar-brand fs-1 text-white comfortaa-font m-0">One<span
                            style="color: var(--primary-color)">fit</span>.app<span style="font-size: 10px">&trade;</span>
                    </h1>
                </div>
            </nav>
            <div class="d-flex align-items-center down-top-grad-white" style="width: 100%; height: 100%;">
                <div class="text-center w-100">
                    <div class="ring d-flex align-items-center p-4 shadow-lg">
                        <!-- <span></span> -->
                        <div class="d-flex align-items-center justify-content-center" style="width: 100%;">
                            <img src="../../media/assets/icons/error_black_24dp.svg"
                                class="img-fluid p-4 rounded-circle text-white border-5 border-white shadow"
                                style="height: 130px;background-color:var(--white)!important;" alt="onefit logo">
                        </div>
                    </div>
                </div>
            </div>
            <nav class="text-center text-center p-4 fixed-bottom" alt="">
                <h1 id="output-msg-heading" class="navbar-brand fs-1 fw-bold comfortaa-font d-grid"
                    style="color: var(--secondary-color);">
                    <!--<span class="material-icons material-icons-round align-middle" style="font-size:40px!important;">
                                  error_outline
                                </span> -->
                    <span class="align-middle">Fatal Error.</span>
                </h1>
                <p id="output-msg-text" class="text-center poppins-font" style="color: var(--secondary-color);"> $error_msg
                </p>
                <div class="d-grid gap-2 col-6 mx-auto my-4">
                    <a href="../../" class="onefit-buttons-style-dark btn-lg p-4 poppins-font"
                        style="border-radius: 50px;">Go Back</a>
                </div>
            </nav>
        </div>
        <!-- ./ error Curtain -->
      </body>
  </html>
  _END;

  die($error_curtain);
}

//test connection - if fail then die
if ($dbconn->connect_error) die_error_curtain("DB Connection Error.", 1); // db conn error

// both the pid and uid are required
if (!isset($_GET['pid']) || !isset($_GET['uid'])) die_error_curtain("UID and/or PID not detected.", 2); // fatal error

// store $_POST['pid'] and $_POST['uid'] to $_SESSION variables
$_SESSION['pid'] = $_GET['pid'];
$_SESSION['uid'] = $_GET['uid'];

// declare variables
$get_user_id = $get_user_profile_id = null;

$current_user_id =
  $current_user_name = $current_user_surname =
  $current_user_email = $current_user_contact =
  $current_user_dob = $current_user_gender =
  $current_user_race = $current_user_nation = "Information unavailable.";

$current_user_prof_id = null;

$current_user_prof_img = $current_user_prof_banner = "";

$policy_content_terms =
  $policy_ref_terms =
  $policy_name_terms =
  $policy_date_terms = null;

$policy_content_eula =
  $policy_ref_eula =
  $policy_name_eula =
  $policy_date_eula = null;

$policy_content_privacy =
  $policy_ref_privacy =
  $policy_name_privacy =
  $policy_date_privacy = null;

// assign get param values
$get_user_id = sanitizeMySQL($dbconn, $_GET['uid']);
$get_user_profile_id = sanitizeMySQL($dbconn, $_GET['pid']);
$current_user_prof_id = $get_user_profile_id;

try {
  $query = "SELECT * FROM `users` WHERE `user_id` = $get_user_id";

  $result = $dbconn->query($query);

  if (!$result) die_error_curtain("Please reload the page, and if the problem persists, please contact the system
administrator.", 2);
  /* die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system
administrator."); */

  $rows = $result->num_rows;

  if ($rows <= 0) { //notify user that a record cannot be found
    echo '<div class="alert alert-danger p-4 text-start" role="alert" aria-hidden="true">Error: No user account information found.</div>';
  } else {
    for ($j = 0; $j < $rows; ++$j) {
      $row = $result->fetch_array(MYSQLI_ASSOC);

      $current_user_id = htmlspecialchars($row['user_id']);
      $current_user_username = htmlspecialchars($row['username']);
      $current_user_name = htmlspecialchars($row['user_name']);
      $current_user_surname = htmlspecialchars($row['user_surname']);
      $current_user_email = htmlspecialchars($row['user_email']);
      $current_user_contact = htmlspecialchars($row['contact_number']);
      $current_user_dob = htmlspecialchars($row['date_of_birth']);
      $current_user_gender = htmlspecialchars($row['user_gender']);
      $current_user_race = htmlspecialchars($row['user_race']);
      $current_user_nation = htmlspecialchars($row['user_nationality']);
    }
  }

  // dump $result data
  $result = null;

  // get users default profile details
  $query = "SELECT `profile_image_url`,`profile_banner_url` FROM `general_user_profiles` WHERE `users_username` =
    '$current_user_username'";

  $result = $dbconn->query($query);

  if (!$result) die_error_curtain("Please reload the page, and if the problem persists, please contact the system
    administrator.", 2); /* die("A Fatal Error has occured. Please reload the page, and if the problem persists, please
    contact the system administrator."); */

  $rows = $result->num_rows;

  if ($rows <= 0) { //notify user that a record cannot be found
    echo '<div class="alert alert-danger p-4 text-start" role="alert" aria-hidden="true">Error: No user profile information found.</div>';
  } else {
    for ($j = 0; $j < $rows; ++$j) {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $current_user_prof_img = htmlspecialchars($row['profile_image_url']);
      $current_user_prof_banner = htmlspecialchars($row['profile_banner_url']);
    }
  }

  // dump $result data
  $result = null;

  function getPolicy($policy_type)
  {
    global $dbconn;

    // policy content vars
    global $policy_content_terms, $policy_ref_terms, $policy_name_terms, $policy_date_terms;
    global $policy_content_eula, $policy_ref_eula, $policy_name_eula, $policy_date_eula;
    global $policy_content_privacy, $policy_ref_privacy, $policy_name_privacy, $policy_date_privacy;

    // declaring local variables
    $policy_id =
      $policy_ref =
      $policy_name =
      $policy_content =
      $policy_date = null;

    switch ($policy_type) {
      case 'terms':
        $query = "SELECT * FROM `app_policies` WHERE `policy_type` = 'terms' ORDER BY `policy_date` DESC LIMIT 1";
        break;
      case 'eula':
        $query = "SELECT * FROM `app_policies` WHERE `policy_type` = 'eula' ORDER BY `policy_date` DESC LIMIT 1";
        break;
      case 'privacy':
        return false; // no privacy policy yet available
        $query = "SELECT * FROM `app_policies` WHERE `policy_type` = 'privacy' ORDER BY `policy_date` DESC LIMIT 1";
        break;

      default:
        return false;
        break;
    }

    $result = $dbconn->query($query);

    if (!$result) die_error_curtain("Please reload the page, and if the problem persists, please contact the system
        administrator..", 2); /* die("A Fatal Error has occured. Please reload the page, and if the problem persists,
        please contact the system administrator."); */

    $rows = $result->num_rows;

    if ($rows <= 0) { //notify user that a record cannot be found
      $policy_content = '<div class="alert alert-warning p-4 fs-5 text-start rounded-pill" role="alert" aria-hidden="true">Error: No policy content found.</div>';
      if ($policy_type == "terms") { // "Terms of Service"
        $policy_content_terms = '<div class="alert alert-warning p-4 fs-5 text-start rounded-pill" role="alert" aria-hidden="true">Error: No policy content found.</div>';
      } else if ($policy_type == "eula") { // "End User License Agreement"
        $policy_content_eula = '<div class="alert alert-warning p-4 fs-5 text-start rounded-pill" role="alert" aria-hidden="true">Error: No policy content found.</div>';
      } else if ($policy_type == "privacy") { // "Privacy Policy"
        $policy_content_privacy = '<div class="alert alert-warning p-4 fs-5 text-start rounded-pill" role="alert" aria-hidden="true">Error: No policy content found.</div>';
      }
    } else {
      for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        $policy_id = $row['policy_id'];
        $policy_ref = $row['policy_ref'];
        $policy_type = $row['policy_type'];
        $policy_name = $row['policy_name'];
        $policy_content = $row['policy_content'];
        $policy_date = $row['policy_date'];
        // $administrators_username = $row['administrators_username'];

        if ($policy_type == "terms") {
          // "Terms of Service"
          $policy_content_terms = $policy_content;
          $policy_ref_terms = $policy_ref;
          $policy_name_terms = $policy_name;
          $policy_date_terms = $policy_date;
        } else if ($policy_type == "eula") {
          // "End User License Agreement"
          $policy_content_eula = $policy_content;
          $policy_ref_eula = $policy_ref;
          $policy_name_eula = $policy_name;
          $policy_date_eula = $policy_date;
        } else if ($policy_type == "privacy") {
          // "Privacy Policy"
          $policy_content_privacy = $policy_content;
          $policy_ref_privacy = $policy_ref;
          $policy_name_privacy = $policy_name;
          $policy_date_privacy = $policy_date;
        }
      }
    }
  }

  // get latest EULA policy content using policy_date
  // array for policy type
  $policy_type_array = array("terms", "eula", "privacy");

  // for each $policy_type_array, call getPolicy() function
  foreach ($policy_type_array as $type) {
    getPolicy($type);
  }

  // $result = null;
  $result = null;
  $dbconn->close();
} catch (\Throwable $th) {
  die_error_curtain($th, 3); // die("Exepction error: $th");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create your Profile | Onefit.app | OnefitNet &copy; <?php echo date('Y'); ?></title>

    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

    <!-- W3 CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />

    <!-- Google Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- JQuery local -->
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
    <!-- ./ JQuery local -->

    <!-- JQuery validation local -->
    <script src="../../node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
    <!-- ./ JQuery validation local -->

    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="../../css/styles.css" />

    <!-- JQuery Scripts -->
    <script>
    //jQuery Code Only
    //$.noConflict();
    $(document).ready(function() {
        // hide the load curtain
        // hide the loading curtain
        // $("LoadCurtain").hide();
        // hide the loading curtain


        // ******** smooth scroll to element
        // #goalsetting - next - panel - btn => #category - goal - setting - tab - pane
        $("#goalsetting-next-panel-btn").click(function() {
            $("#main-form-window-scroll-container")
                .animate({ // [document.documentElement, document.body]
                    scrollTop: $("#user-welcome-header").offset().top
                }, 2000);
        });

        // #aboutyou-back-panel-btn => #category-about-you-tab-pane
        $("#aboutyou-back-panel-btn").click(function() {
            $("#main-form-window-scroll-container")
                .animate({ //[document.documentElement, document.body]
                    scrollTop: $("#user-welcome-header").offset().top
                }, 2000);
        });

        // #fitprefs-next-panel-btn => #category-fitness-prefs-tab-pane
        $("#fitprefs-next-panel-btn").click(function() {
            $("#main-form-window-scroll-container")
                .animate({ // [document.documentElement, document.body]
                    scrollTop: $("#user-welcome-header").offset().top
                }, 2000);
        });

        // #eu-agreements-next-panel-btn => #category-eu-agreements-tab-pane
        $("#eu-agreements-next-panel-btn").click(function() {
            $("#main-form-window-scroll-container")
                .animate({ // [document.documentElement, document.body]
                    scrollTop: $("#user-welcome-header").offset().top
                }, 2000);
        });

        $("#toggle-main-form-window-list-btn").click(function() {
            $("main-body-row-container").animate({
                scrollTop: $("#main-form-window").offset().bottom
            }, 2000);
        });

        // #goalsetting-next-panel-btn => #category-goal-setting-tab-pane => #category-goal-setting-tab-questions-pane
        // #aboutyou-back-panel-btn => #category-about-you-tab-pane => #category-about-you-tab-questions-pane
        // #fitprefs-next-panel-btn => #category-fitness-prefs-tab-pane => #category-fitness-prefs-tab-questions-pane
        // #eu-agreements-next-panel-btn => #category-eu-agreements-tab-pane => #category-eula-tab-questions-pane

        // profile images upload ajax jquery
        $("#uploadProfileImgForm").on("submit", function(e) {
            e = e || window.event;
            e.preventDefault();


            var form_data = new FormData($('#uploadProfileImgForm')[0]);
            setTimeout(function() {
                $.ajax({
                    type: 'POST',
                    url: '../upload/prof-img-upload.php',
                    processData: false,
                    contentType: false,
                    async: false,
                    cache: false,
                    data: form_data,
                    beforeSend: function() {
                        // show spinner
                        $('#prof-img-spinner').show();
                    },
                    success: function(response) {
                        // hide spinner
                        $('#prof-img-spinner').hide();

                        if (response.startsWith("success")) {
                            console.log("Success: " + response);
                            // get the profile image name and append it to the src attribute str
                            var str = response;
                            var imgSrcStr = str.split('[').pop().split(
                                ']')[0];

                            var user_media_folder =
                                "../media/profile/<?php echo $current_user_username; ?>/profile_img/";
                            // "../upload/"
                            $("#prof-pic-img-preview").attr("src",
                                user_media_folder + imgSrcStr);
                        } else {
                            console.log(
                                "Profile Image Uploaded Process Completed."
                            );
                            console.log("Response: " + response);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $('#prof-img-spinner').hide();
                        console.log("Profile Image Upload Exception: " +
                            thrownError + "\r\n" + xhr.statusText +
                            "\r\n" + xhr.responseText);
                    }
                });
            }, 1000);
            e.stopImmediatePropagation();
            return false;
        });

        // banner images upload ajax jquery
        $("#uploadBannerImgForm").on("submit", function(e) {
            e = e || window.event;
            e.preventDefault();

            var form_data = new FormData($('#uploadBannerImgForm')[0]);
            setTimeout(function() {
                $.ajax({
                    type: 'POST',
                    url: '../upload/prof-banner-upload.php',
                    processData: false,
                    contentType: false,
                    async: false,
                    cache: false,
                    data: form_data,
                    beforeSend: function() {
                        // show spinner
                        $('#banner-img-spinner').show();
                    },
                    success: function(response) {
                        // hide spinner
                        $('#banner-img-spinner').hide();

                        if (response.startsWith("success")) {
                            console.log("Success: " + response);
                            // get the profile image name and append it to the src attribute str
                            var str = response;
                            var imgSrcStr = str.split('[').pop().split(
                                ']')[0];

                            var user_media_folder =
                                "../media/profile/<?php echo $current_user_username; ?>/profile_banner/";

                            // set the background image 
                            $("#prof-banner-img-preview").css(
                                "background-image", "url('" +
                                user_media_folder + imgSrcStr + "')"
                            ) // .attr("src", imgSrcStr);
                        } else {
                            console.log(
                                "Banner Image Uploaded Process Completed."
                            );
                            console.log("Response: " + response);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $('#banner-img-spinner').hide();
                        console.log("Profile Image Upload Exception: " +
                            thrownError + "\r\n" + xhr.statusText +
                            "\r\n" + xhr.responseText);
                    }
                });
            }, 1000);
            e.stopImmediatePropagation();
            return false;
        });
        // ./ banner images upload ajax jquery


        // ajax: submit aboutyou data
        $("#aboutyou-info-form").on("submit", function(e) {
            e = e || window.event;
            e.preventDefault();

            // get and assign user id  and profile id from localstorage
            var user_id = localStorage.getItem("registration_user_id");
            var profile_id = localStorage.getItem("registration_profile_id");

            var form_data = new FormData($('#aboutyou-info-form')[0]);
            setTimeout(function() {
                $.ajax({
                    type: 'POST',
                    url: '../../scripts/php/main_app/data_management/system_admin/user_registration/submit/aboutyou_submit.php$user_id=' +
                        user_id,
                    processData: false,
                    contentType: false,
                    async: false,
                    cache: false,
                    data: form_data,
                    beforeSend: function() {
                        // do something
                        console.log(
                            "BeforeSend: submitting aboutyou form | user_id: " +
                            user_id);
                    },
                    success: function(response) {
                        // do something

                        // if response contains error, show error
                        if (response.includes("error")) {
                            console.log("Error Response: " + response);

                            // update the Form Status variables to reflect error status
                            aboutyouFormSubmitStatus = false;
                            // notify user that data could not be submitted by showing snackbar
                            showSnackbar(
                                "<error> Error: About You data could not be saved. Check console.",
                                "alert_error");
                            alert(
                                "Error: About You data could not be saved. Check console."
                            );

                            $('#aboutyou-confirmation-icon').html =
                                `<span class="material-icons material-icons-round" style="color: var(--red) !important;"> error </span>`;
                            $('#aboutyou-confirmation-icon').show();

                            return;
                        } else {
                            console.log("Success Response: " +
                                response);

                            // update the Form Status variables to reflect success status
                            aboutyouFormSubmitStatus = true;

                            // notify user that data was submitted by showing snackbar
                            showSnackbar(
                                "<check_circle>  About You data was saved successfully.",
                                "alert_success");

                            $('#aboutyou-confirmation-icon').html =
                                `<span class="material-icons material-icons-round" style="color: var(--green) !important;"> check_circle </span>`;
                            $('#aboutyou-confirmation-icon').show();

                            // disable #submit-aboutyou-info-form button and show #goalsetting-next-panel-btn button
                            $('#submit-aboutyou-info-form').hide();
                            $('#goalsetting-next-panel-btn').show();

                            // set all form inputs to readonly
                            $('#aboutyou-info-form :input').attr(
                                "readonly", true);
                        }

                        // console.log("Success Response: " + response);
                        // $('#aboutyou-confirmation-icon').html = `<span class="material-icons material-icons-round" style="color: var(--green) !important"> check_circle </span>`;
                        // $('#aboutyou-confirmation-icon').show();
                        // // update the Form Status variables to reflect success status
                        // aboutyouFormSubmitStatus = true;
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        // do something
                        console.log("Error: " + thrownError + "\r\n" +
                            xhr.statusText + "\r\n" + xhr
                            .responseText);
                        $('#aboutyou-confirmation-icon').html =
                            `<span class="material-icons material-icons-round" style="color: var(--red) !important"> error </span>`;
                        $('#aboutyou-confirmation-icon').show();
                        // update the Form Status variables to reflect error status
                        aboutyouFormSubmitStatus = false;
                    }
                });
            }, 1000);

            e.stopImmediatePropagation();
            return false;
        });

        // ajax: submit goalsetting data
        $("#goalsetting-info-form").on("submit", function(e) {
            e = e || window.event;
            e.preventDefault();

            // get and assign user id  and profile id from localstorage
            var user_id = localStorage.getItem("registration_user_id");
            var profile_id = localStorage.getItem("registration_profile_id");

            var form_data = new FormData($('#goalsetting-info-form')[0]);
            setTimeout(function() {
                $.ajax({
                    type: 'POST',
                    url: '../../scripts/php/main_app/data_management/system_admin/user_registration/submit/goalsetting_submit.php?user_id=' +
                        user_id,
                    processData: false,
                    contentType: false,
                    async: false,
                    cache: false,
                    data: form_data,
                    beforeSend: function() {
                        // do something
                        console.log(
                            "BeforeSend: submitting goalsetting form | user_id: " +
                            user_id);
                    },
                    success: function(response) {
                        // do something

                        // if response contains error, show error
                        if (response.includes("error")) {
                            console.log("Error Response: " + response);

                            // update the Form Status variables to reflect error status
                            goalsettingFormSubmitStatus = false;
                            // notify user that data could not be submitted by showing snackbar
                            showSnackbar(
                                "<error> Error: Goal Setting data could not be saved. Check console.",
                                "alert_error");
                            alert(
                                "Error: Goal Setting data could not be saved. Check console."
                            );

                            $('#goalsetting-confirmation-icon').html =
                                `<span class="material-icons material-icons-round" style="color: var(--red) !important;"> error </span>`;
                            $('#goalsetting-confirmation-icon').show();

                            // remove return false onclick attribute to inpute type checkbox and radio
                            $('#goalsetting-info-form input[type="checkbox"]')
                                .removeAttr("onclick");
                            $('#goalsetting-info-form input[type="radio"]')
                                .removeAttr("onclick");

                            return;
                        } else {
                            console.log("Success Response: " +
                                response);

                            // update the Form Status variables to reflect success status
                            goalsettingFormSubmitStatus = true;

                            // notify user that data was submitted by showing snackbar
                            showSnackbar(
                                "<check_circle>  Goal Setting data was saved successfully.",
                                "alert_success");

                            $('#goalsetting-confirmation-icon').html =
                                `<span class="material-icons material-icons-round" style="color: var(--green) !important;"> check_circle </span>`;
                            $('#goalsetting-confirmation-icon').show();

                            // disable #submit-goalsetting-info-form button and show #aboutyou-back-panel-btn & #fitprefs-next-panel-btn buttons
                            $('#submit-goalsetting-info-form').hide();
                            $('#aboutyou-back-panel-btn').show();
                            $('#fitprefs-next-panel-btn').show();

                            // set all form inputs to readonly
                            $('#goalsetting-info-form :input').attr(
                                "readonly", true);
                            // assign return false onclick attribute to inpute type checkbox and radio
                            $('#goalsetting-info-form input[type="checkbox"]')
                                .attr("onclick", "return false;");
                            $('#goalsetting-info-form input[type="radio"]')
                                .attr("onclick", "return false;");
                        }

                        // console.log("Success Response: " + response);
                        // $('#goalsetting-confirmation-icon').html = `<span class="material-icons material-icons-round" style="color: var(--green) !important"> check_circle </span>`;
                        // $('#goalsetting-confirmation-icon').show();
                        // // update the Form Status variables to reflect success status
                        // goalsettingFormSubmitStatus = true;
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        // do something
                        console.log("Error: " + thrownError + "\r\n" +
                            xhr.statusText + "\r\n" + xhr
                            .responseText);
                        $('#goalsetting-confirmation-icon').html =
                            `<span class="material-icons material-icons-round" style="color: var(--red) !important"> error </span>`;
                        $('#goalsetting-confirmation-icon').show();
                        // update the Form Status variables to reflect error status
                        goalsettingFormSubmitStatus = false;
                    }
                });
            }, 1000);

            e.stopImmediatePropagation();
            return false;
        });

        // ajax: submit fitprefs data
        $("#fitprefs-info-form").on("submit", function(e) {
            e = e || window.event;
            e.preventDefault();

            // get and assign user id  and profile id from localstorage
            var user_id = localStorage.getItem("registration_user_id");
            var profile_id = localStorage.getItem("registration_profile_id");

            var form_data = new FormData($('#fitprefs-info-form')[0]);
            setTimeout(function() {
                $.ajax({
                    type: 'POST',
                    url: '../../scripts/php/main_app/data_management/system_admin/user_registration/submit/fitprefs_submit.php?user_id=' +
                        user_id,
                    processData: false,
                    contentType: false,
                    async: false,
                    cache: false,
                    data: form_data,
                    beforeSend: function() {
                        // do something
                        console.log(
                            "BeforeSend: submitting fitprefs form | user_id: " +
                            user_id);
                    },
                    success: function(response) {
                        // do something

                        // if response contains error, show error
                        if (response.includes("error")) {
                            console.log("Error Response: " + response);

                            // update the Form Status variables to reflect error status
                            goalsettingFormSubmitStatus = false;
                            // notify user that data could not be submitted by showing snackbar
                            showSnackbar(
                                "<error> Error: Fitness Preference data could not be saved. Check console.",
                                "alert_error");
                            alert(
                                "Error: Fitness Preference data could not be saved. Check console."
                            );

                            $('#fitprefs-confirmation-icon').html =
                                `<span class="material-icons material-icons-round" style="color: var(--red) !important;"> error </span>`;
                            $('#fitprefs-confirmation-icon').show();

                            return;
                        } else {
                            console.log("Success Response: " +
                                response);

                            // update the Form Status variables to reflect success status
                            goalsettingFormSubmitStatus = true;

                            // notify user that data was submitted by showing snackbar
                            showSnackbar(
                                "<check_circle>  Fitness Preference data was saved successfully.",
                                "alert_success");

                            $('#fitprefs-confirmation-icon').html =
                                `<span class="material-icons material-icons-round" style="color: var(--green) !important;"> check_circle </span>`;
                            $('#fitprefs-confirmation-icon').show();

                            // disable #submit-fitprefs-info-form button and show #goalsetting-back-panel-btn & #eu-agreements-next-panel-btn
                            $('#submit-fitprefs-info-form').hide();
                            $('#goalsetting-back-panel-btn').show();
                            $('#eu-agreements-next-panel-btn').show();

                            // set all form inputs to readonly
                            $('#fitprefs-info-form :input').attr(
                                "readonly", true);
                        }

                        // console.log("Success Response: " + response);
                        // $('#fitprefs-confirmation-icon').html = `<span class="material-icons material-icons-round" style="color: var(--green) !important"> check_circle </span>`;
                        // $('#fitprefs-confirmation-icon').show();
                        // // update the Form Status variables to reflect success status
                        // fitprefsFormSubmitStatus = true;
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        // do something
                        console.log("Error: " + thrownError + "\r\n" +
                            xhr.statusText + "\r\n" + xhr
                            .responseText);
                        $('#fitprefs-confirmation-icon').html =
                            `<span class="material-icons material-icons-round" style="color: var(--red) !important"> error </span>`;
                        $('#fitprefs-confirmation-icon').show();
                        // update the Form Status variables to reflect error status
                        fitprefsFormSubmitStatus = false;
                    }
                });
            }, 1000);

            e.stopImmediatePropagation();
            return false;
        });

        // ajax: submit user eula policy acceptance data
        $("#eula-policy-info-form").on("submit", function(e) {
            e = e || window.event;
            e.preventDefault();

            // get and assign user id  and profile id from localstorage
            var user_id = localStorage.getItem("registration_user_id");
            var profile_id = localStorage.getItem("registration_profile_id");

            var form_data = new FormData($('#eula-policy-info-form')[0]);
            setTimeout(function() {
                $.ajax({
                    type: 'POST',
                    url: '../../scripts/php/main_app/data_management/system_admin/user_registration/submit/policy_acceptance_submit.php?user_id=' +
                        user_id + '&agree_eula=true',
                    processData: false,
                    contentType: false,
                    async: false,
                    cache: false,
                    data: form_data,
                    beforeSend: function() {
                        // do something
                        console.log(
                            "BeforeSend: submitting End-User License Agreement (EULA) Policy acceptance form | user_id: " +
                            user_id);
                    },
                    success: function(response) {
                        // do something

                        // if response contains error, show error
                        if (response.includes("error")) {
                            console.log("Error Response: " + response);

                            // update the Form Status variables to reflect error status
                            eulaPolicyFormSubmitStatus = false;
                            // notify user that data could not be submitted by showing snackbar
                            showSnackbar(
                                "<error> Error: EULA Acceptence could not be saved. Check console.",
                                "alert_error");
                            alert(
                                "Error: EULA Acceptence could not be saved. Check console."
                            );

                            return;
                        } else {
                            console.log("Success Response: " +
                                response);

                            // update the Form Status variables to reflect success status
                            eulaPolicyFormSubmitStatus = true;

                            // notify user that data was submitted by showing snackbar
                            showSnackbar(
                                "<workspace_premium>  EULA Accepted.",
                                "alert_success");
                            proceedToMain();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        // do something
                        console.log("Error Response: " + thrownError +
                            "\r\n" + xhr.statusText + "\r\n" + xhr
                            .responseText);
                        // update the Form Status variables to reflect error status
                        eulaPolicyFormSubmitStatus = false;
                        // notify user that data could not be submitted by showing snackbar
                        showSnackbar(
                            "<error> Error: EULA Acceptence could not be saved. Check console.",
                            "alert_error");
                        alert(
                            "Error: EULA Acceptence could not be saved. Check console."
                        );
                    }
                });
            }, 1000);

            e.stopImmediatePropagation();
            return false;
        });

        // ajax: submit user tou policy acceptance data
        $("#tou-policy-info-form").on("submit", function(e) {
            e = e || window.event;
            e.preventDefault();

            // get and assign user id  and profile id from localstorage
            var user_id = localStorage.getItem("registration_user_id");
            var profile_id = localStorage.getItem("registration_profile_id");

            var form_data = new FormData($('#tou-policy-info-form')[0]);
            setTimeout(function() {
                $.ajax({
                    type: 'POST',
                    url: '../../scripts/php/main_app/data_management/system_admin/user_registration/submit/policy_acceptance_submit.php?user_id=' +
                        user_id + '&agree_tou=true',
                    processData: false,
                    contentType: false,
                    async: false,
                    cache: false,
                    data: form_data,
                    beforeSend: function() {
                        // do something
                        console.log(
                            "BeforeSend: submitting Terms of Use (TOU) Policy acceptance form | user_id: " +
                            user_id);
                    },
                    success: function(response) {
                        // do something
                        console.log("Success Response: " + response);

                        // update the Form Status variables to reflect success status
                        touPolicyFormSubmitStatus = true;

                        var formNotSubmittedString = "";

                        // check if all forms have been submitted, if not notify user
                        if (eulaPolicyFormSubmitStatus === false ||
                            aboutyouFormSubmitStatus === false ||
                            fitprefsFormSubmitStatus === false ||
                            goalsettingFormSubmitStatus === false ||
                            touPolicyFormSubmitStatus === false) {
                            if (eulaPolicyFormSubmitStatus === false) {
                                formNotSubmittedString +=
                                    "End-User License Agreement (EULA) Policy Acceptance Form, ";
                            }
                            if (touPolicyFormSubmitStatus === false) {
                                formNotSubmittedString +=
                                    "Terms of Use (TOU) Policy Acceptance Form, ";
                            }
                            if (aboutyouFormSubmitStatus === false) {
                                formNotSubmittedString +=
                                    "About You Form, ";
                            }
                            if (goalsettingFormSubmitStatus === false) {
                                formNotSubmittedString +=
                                    "Goal Setting Form, ";
                            }
                            if (fitprefsFormSubmitStatus === false) {
                                formNotSubmittedString +=
                                    "Fitness Preferences Form, ";
                            }

                            // notify user that data was not submitted by showing alert
                            alert("Some of your information has not been submitted. Please check the " +
                                formNotSubmittedString +
                                " provide any missing information and click the Save button."
                            );

                            // notify user that data was not submitted by showing snackbar
                            showSnackbar(
                                "<error>  Some of your information has not been submitted. Please check the " +
                                formNotSubmittedString +
                                " provide any missing information and click the Save button.",
                                "alert_error");
                            return false;
                        } else {
                            // notify user that data was submitted by showing snackbar
                            showSnackbar(
                                "<check_circle> Your Profile has been created successfully.",
                                "alert_success");

                            window.location.href = "complete/";
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        // do something
                        console.log("Error: " + thrownError + "\r\n" +
                            xhr.statusText + "\r\n" + xhr
                            .responseText);
                        // update the Form Status variables to reflect error status
                        touPolicyFormSubmitStatus = false;
                    }
                });
            }, 1000);

            e.stopImmediatePropagation();
            return false;
        });

        // detect if file has been selected - Profile Image Upload
        $(function() {
            $("#profpicformFileLg").change(function() {
                console.log("img selected - Profile Image Upload");
                // get the file name
                var fileName = $(this).val();
                // click the submit button to start server side upload
                $("#submit-profpicformFileLg").click();
                // $('#prof-img-spinner').css("display", "block");
                // $('#prof-img-spinner').show();
            });
        });

        // detect if file has been selected - Profile Banner Upload
        $(function() {
            $("#profbannerformFileLg").change(function() {
                console.log("img selected - Banner Image Upload");
                // get the file name
                var fileName = $(this).val();
                // click the submit button to start server side upload
                $("#submit-profbannerformFileLg").click();
                // $('#banner-img-spinner').css("display", "block");
                // $('#banner-img-spinner').show();
            });
        });

        // obsolete: final submission, validate all forms and submit each if all forms are valid
        // $(function() {
        //   $("#final-submit-data-btn").click(function() {
        //     console.log("Final submit btn clicked");



        //     // validate all tab forms and submit each if all forms are valid
        //     // const formsArray = [
        //     //   "#eula-policy-info-form",
        //     //   "#aboutyou-info-form",
        //     //   "#goalsetting-info-form",
        //     //   "#fitprefs-info-form",
        //     //   "#tou-policy-info-form"
        //     // ];

        //     // var isValid = true;

        //     // formsArray.forEach(formid => {
        //     //   switch (formid) {

        //     //     case "#eula-policy-info-form":
        //     //       isValid = $.validateForm(formid);
        //     //       if (isValid) {
        //     //         console.log("Success: EULA form is valid");
        //     //         // click the form submit button
        //     //         // $("#submit-eula-policy-info-form").click();
        //     //       } else {
        //     //         console.log("Success: EULA form is not valid");
        //     //         showSnackbar("Alert: EULA form is not valid", "danger");
        //     //         // return false;
        //     //       }
        //     //       break;
        //     //     case "#aboutyou-info-form":
        //     //       isValid = $.validateForm(formid);
        //     //       if (isValid) {
        //     //         console.log("Success: About You form is valid");
        //     //         // click the form submit button
        //     //         // $("#submit-aboutyou-info-form").click();
        //     //       } else {
        //     //         console.log("Success: About You form is not valid");
        //     //         showSnackbar("Alert: Please complete the About You form to continue", "danger");
        //     //         // return false;
        //     //       }
        //     //       break;
        //     //     case "#goalsetting-info-form":
        //     //       isValid = $.validateForm(formid);
        //     //       if (isValid) {
        //     //         console.log("Success: Goal Setting form is valid");
        //     //         // click the form submit button
        //     //         // $("#submit-goalsetting-info-form").click();
        //     //       } else {
        //     //         console.log("Success: Goal Setting form is not valid");
        //     //         showSnackbar("Alert: Please complete the Goal Setting form to continue", "danger");
        //     //         // return false;
        //     //       }
        //     //       break;
        //     //     case "#fitprefs-info-form":
        //     //       isValid = $.validateForm(formid);
        //     //       if (isValid) {
        //     //         console.log("Success: fitprefs form is valid");
        //     //         // click the form submit button
        //     //         // $("#submit-fitprefs-info-form").click();
        //     //       } else {
        //     //         console.log("Success: fitprefs form is not valid");
        //     //         showSnackbar("Alert: Please complete the Fitness Preferences form to continue", "danger");
        //     //         // return false;
        //     //       }
        //     //       break;
        //     //     case "#tou-policy-info-form":
        //     //       isValid = $.validateForm(formid);
        //     //       if (isValid) {
        //     //         console.log("Success: Terms Of Use form is valid");
        //     //         // click the form submit button
        //     //         // $("#submit-tou-policy-info-form").click();
        //     //       } else {
        //     //         console.log("Success: Terms Of Use form is not valid");
        //     //         showSnackbar("Alert: Please accept the Terms Of Use to continue", "danger");
        //     //         // return false;
        //     //       }
        //     //       break;

        //     //     default:
        //     //       // do nothing
        //     //       console.log("error: unknown form - formid: " + formid);
        //     //       showSnackbar("Alert: unknown form - formid: " + formid, "danger");
        //     //       isValid = false;
        //     //       return isValid;
        //     //       break;
        //     //   }
        //     // });

        //     // // if all forms are valid, submit all forms
        //     // if (isValid) {
        //     //   console.log("Success: All forms are valid");
        //     //   showSnackbar("We are submitting your information. Please wait.", "alert_general");
        //     //   // submit all forms
        //     //   formsArray.forEach(formid => {
        //     //     // $(formid).on("submit", );
        //     //     switch (formid) {
        //     //       case "#eula-policy-info-form":
        //     //         // click the form submit button
        //     //         $("#submit-eula-policy-info-form").click();
        //     //         break;
        //     //       case "#aboutyou-info-form":
        //     //         // click the form submit button
        //     //         $("#submit-aboutyou-info-form").click();
        //     //         break;
        //     //       case "#goalsetting-info-form":
        //     //         // click the form submit button
        //     //         $("#submit-goalsetting-info-form").click();
        //     //         break;
        //     //       case "#fitprefs-info-form":
        //     //         // click the form submit button
        //     //         $("#submit-fitprefs-info-form").click();
        //     //         break;
        //     //       case "#tou-policy-info-form":
        //     //         // click the form submit button
        //     //         $("#submit-tou-policy-info-form").click();
        //     //         break;

        //     //       default:
        //     //         // 
        //     //         console.log("ERROR: Unknown form submission request");
        //     //         alert("ERROR: Unknown form submission request [" + formid + "]");
        //     //         break;
        //     //     }
        //     //   });
        //     //   console.log("Success: All forms submitted");
        //     // } else {
        //     //   console.log("Error: Not all forms are valid");
        //     //   showSnackbar("Alert: Not all forms are valid", "danger");
        //     //   return false;
        //     // }
        //   });
        // });

    });
    </script>
    <!-- ./ JQuery Scripts -->

    <style>
    .eula-curtain {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        /* background-color: rgba(0, 0, 0, 0.5); */
        background: #343434;
        z-index: 9999;
        display: none;
    }

    a {
        color: var(--primary-color) !important;
    }
    </style>

    <script src="../../scripts/js/script.js"></script>
    <script src="../../scripts/js/formValidationScripts.js"></script>
</head>

<body class="noselect"
    onload="toggleLoadCurtain();storeCurrentUserIDs('<?php echo $current_user_id; ?>','<?php echo $current_user_prof_id; ?>');fetchUserData()">

    <!-- snackbar -->
    <div class="snackbar d-grid gap-1 align-items-center" id="snackbar">
        No messages available
    </div>
    <!-- ./ snackbar -->

    <!-- loading wait screen -->
    <div id="load-wait-screen-curtain" class="wait-load-curtain" style="display: none;">
        <div class="d-flex justify-content-center align-items-center h-100 w-100">
            <div class="d-grid gap-4 justify-content-center text-center">
                <div class="spinner-border text-white" role="status"
                    style="width:10rem;height:10rem;border-width:20px;border-right: 20px var(--tahitigold) solid">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-center fs-5 fw-bold text-white">Just a moment.</p>
            </div>
        </div>
    </div>
    <!-- ./ loading wait screen -->

    <!-- Load Curtain -->
    <div class="load-curtain" id="LoadCurtain" style="display: block;">
        <!-- twitter social panel -->
        <div class="load-curtain-social-btn-panel comfortaa-font d-grid gap-2 p-4">
            <!--  d-none d-lg-block p-4 -->
            <div class="d-flex gap-2 w-100">
                <button class="p-4 m-0 shadow onefit-buttons-style-dark" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseloadCurtainTweetFeed" aria-expanded="false"
                    aria-controls="collapseloadCurtainTweetFeed">
                    <div class="d-grid">
                        <span class="material-icons material-icons-round" style="font-size: 48px !important;">
                            <i class="fab fa-twitter" style="font-size: 40px; color: #fff !important;"></i>
                        </span>
                        <p class="comfortaa-font mt-1 mb-0" style="font-size: 10px;">@onefitnet</p>
                    </div>
                </button>
            </div>
            <div class="collapse no-scroller pb-4 w3-animate-bottom" id="collapseloadCurtainTweetFeed"
                style="overflow-y: auto;">
                <div class="pb-4 no-scroller"
                    style="border-radius: 25px !important; overflow-y: auto; max-height: 90vh; min-width: 500px;">
                    <a class="twitter-timeline comfortaa-font"
                        href="https://twitter.com/OnefitNet?ref_src=twsrc%5Etfw">Tweets by
                        OnefitNet</a>
                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>
            </div>
        </div>
        <!-- ./ twitter social panel -->

        <div class="d-flex align-items-center top-down-grad-tahiti" style="width: 100%; height: 100%;">
            <div class="text-center w-100">
                <div class="ring d-flex align-items-center p-4 my-pulse-animation-light">
                    <!-- <span></span> -->
                    <div style="width: 100%;">
                        <img src="../../media/assets/One-Symbol-Logo-White.svg" class="img-fluid p-4"
                            style="max-height: 20vh;" alt="">
                    </div>
                </div>
            </div>
        </div>
        <nav class="text-center text-center p-4 fixed-bottom" alt="">
            <p class="navbar-brand fs-1 text-white comfortaa-font">One<span
                    style="color: var(--primary-color)">fit</span>.app<span style="font-size: 10px">&trade;</span></p>
            <p class="text-center comfortaa-font" styl="font-size: 10px !important;">Loading. Please wait.
            </p>
        </nav>
    </div>
    <!-- ./Load Curtain -->

    <!-- eula curtain -->
    <div id="eula-curtain" class="eula-curtain" style="display: block;">
        <div class="p-4 h-100" style="overflow-y: auto;">
            <div class="fixed-top p-4" style="background: #343434;">
                <h1 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end"
                    style="border-radius: 25px; background-color: var(--secondary-color); color: #fff; border-color: var(--primary-color);">
                    <!-- <span class="material-icons material-icons-round" style="color: var(--primary-color);">
            looks_3
          </span> -->
                    <span class="comfortaa-font">
                        <u>End-User License Agreement</u>
                    </span>
                </h1>
            </div>


            <!-- EULA -->
            <div id="eula-container" class="text-white comfortaa-font px-2 mb-4"
                style="overflow-y: auto; max-height: 100vh;padding-top: 180px;">
                <?php echo $policy_content_eula; ?>
            </div>
            <!-- ./ EULA -->

            <hr class="text-white">

            <!-- #policy-info-form -->
            <!--<?php echo $output; ?>-->
            <!-- ../../scripts/php/main_app/data_management/system_admin/user_registration/submit/policy_acceptance_submit.php -->
            <form id="eula-policy-info-form"
                action="../../scripts/php/main_app/data_management/system_admin/user_registration/submit/policy_acceptance_submit.php?agree_eula=true"
                method="post" autocomplete="off">
                <!-- user id hidden -->
                <div class="form-group my-4">
                    <input class="form-control-text-input p-4" type="hidden" name="eula_profile_id"
                        id="user-id-policy-eula" value="<?php echo $current_user_prof_id; ?>" readonly
                        placeholder="user id" required readonly />
                </div>
                <!-- ./ user id hidden -->

                <!-- eula policy ref hidden -->
                <div class="form-group my-4">
                    <input class="form-control-text-input p-4" type="hidden" name="eula_policy_ref" id="eula-policy-ref"
                        value="<?php echo $policy_ref_eula; ?>" readonly placeholder="EULA Policy Reference Number"
                        required />
                </div>
                <!-- ./ eula policy ref hidden -->

                <!-- eula policy name hidden -->
                <div class="form-group my-4">
                    <input class="form-control-text-input p-4" type="hidden" name="eula_policy_name"
                        id="eula-policy-name" value="<?php echo $policy_name_eula; ?>" readonly
                        placeholder="EULA Policy Name" required />
                </div>
                <!-- ./ eula policy name hidden -->

                <!-- eula policy date hidden -->
                <div class="form-group my-4">
                    <input class="form-control-text-input p-4" type="hidden" name="eula_policy_date"
                        id="eula-policy-date" value="<?php echo $policy_date_eula; ?>" readonly
                        placeholder="EULA Policy Effective Date" required />
                </div>
                <!-- ./ eula policy date hidden -->

                <div class="d-grid gap-4 justify-content-center">
                    <div class="form-check align-items-center align-middle">
                        <!-- form-check-inline form-switch -->
                        <input class="form-check-input me-4" value="accepted-eula" type="checkbox" role="switch"
                            name="agree_eula" id="agree-eula" onchange="eulaAcceptanceState()">
                        <label class="form-check-label p-2 align-middle pt-2 text-white" for="agree-eula">Do
                            you agree to the
                            above End-User Licence Agreement?</label>
                    </div>
                </div>

                <hr class="text-white" style="margin-bottom: 80px;">

                <!-- Procession Buttons -->
                <div class="comfortaa-font text-center mt-4 text-white" style="margin-bottom: 40px; font-size: 20px;">
                    <div class="d-grid gap-0 w-100 text-white">
                        <span class="rounded-pill p-4" style="background-color: var(--secondary-color);">
                            One<span style="color: var(--primary-color);">fit</span>.app
                        </span>

                        <span class="material-icons material-icons-outlined" style="color: var(--primary-color);">
                            horizontal_rule
                        </span>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md py-4 d-grid">
                            <!--  gap-2 justify-content-center -->

                            <!-- EULA Acceptence Message -->
                            <div id="eula-acceptence-msg" class="w3-animate-left" style="display: block;">
                                <div class="d-grid gap-2 text-center">
                                    <div class="d-flex text-center justify-content-center">
                                        <span class="material-icons material-icons-round p-4"
                                            style="font-size: 80px !important; background-color: #c20000; color: #fff; border-radius: 25px;">
                                            rule </span>
                                    </div>

                                    <span>Please accept the End-User License Agreement (EULA) to start
                                        creating your profile.</span>
                                </div>
                            </div>
                            <!-- ./ EULA Acceptence Message -->

                            <!-- onclick="proceedToMain()" -->
                            <button
                                class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow w3-animate-left"
                                form="eula-policy-info-form" type="submit" id="proceed-btn" style="display: none;">
                                <div class="d-grid gap-2 justify-content-center text-center fw-bold">
                                    <span class="material-icons material-icons-round"
                                        style="font-size: 40px !important; color: var(--primary-color);">
                                        workspace_premium </span>
                                    <span>Proceed.</span>
                                </div>
                            </button>

                        </div>
                    </div>
                </div>
                <!-- ./ Procession Buttons -->

            </form>
            <!-- ./ #policy-info-form -->

            <script>
            function eulaAcceptanceState() {
                const eulaAgreementState = document.getElementById("agree-eula");
                const proceedBtn = document.getElementById("proceed-btn");
                const eulaAcceptenceMsg = document.getElementById("eula-acceptence-msg");

                // alert("Check State: " + eulaAgreementState.checked);

                if (eulaAgreementState.checked) {
                    proceedBtn.style.display = "block";
                    eulaAcceptenceMsg.style.display = "none";

                } else {
                    proceedBtn.style.display = "none";
                    eulaAcceptenceMsg.style.display = "block";

                }
            }
            </script>

        </div>
    </div>
    <!-- ./ eula curtain -->

    <!-- Navigation bar -->
    <nav class="navbar navbar-light sticky-topz fixed-top navbar-stylez top-down-grad-dark">
        <div class="container-fluid">
            <a class="navbar-brand fs-1 text-white comfortaa-font" href="../index.php">One<span
                    style="color: var(--primary-color)">fit</span>.app<span style="font-size: 10px">&trade;</span></a>
            <button class="navbar-toggler shadow onefit-buttons-style-dark p-4" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <!--<span class="navbar-toggler-icon"></span>-->
                <!--<img src="./media/assets/One-Symbol-Logo-Two-Tone.svg" alt="" class="img-fluid logo-size-1" />-->
                <span class="material-icons material-icons-round align-middle" style="font-size: 28px!important;">
                    public
                    <!-- menu_open -->
                </span>
            </button>
            <div class="offcanvas offcanvas-end offcanvas-menu-primary-style" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="h-100z" id="offcanvas-menu">
                    <div class="offcanvas-header fs-1" style="background-color: var(--secondary-color); color: #fff">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                            <img src="../../media/assets/One-Symbol-Logo-White.svg" alt="icon"
                                class="img-fluid logo-size-2" />
                            Navigation
                        </h5>
                        <button type="button" class="onefit-buttons-style-light rounded-pill shadow p-2"
                            data-bs-dismiss="offcanvas" aria-label="Close">
                            <span class="material-icons material-icons-round align-middle"
                                style="font-size:20px!important;"> close
                            </span>
                        </button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 py-3 comfortaa-font fs-3">
                            <li class="nav-item">
                                <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">Contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active p-4" style="border-radius: 25px !important;"
                                    aria-current="page" href="#">Onefit.app&trade;</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-4" style="border-radius: 25px !important;"
                                    href="#">Onefit.Edu&trade; (Blog)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link p-4" style="border-radius: 25px !important;"
                                    href="#">Onefit.Shop&trade;</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- ./ Navigation bar -->

    <!-- Main Body -->
    <div class="container-fluid w-100" id="main-container" style="height: 100vh; overflow: hidden;">
        <div id="main-body-row-container" class="row w-100Z align-items-center m-0 no-scroller"
            style="height: 100vh !important; overflow-y: auto;">
            <div class="col-md -4 text-white h-100z p-0 no-scroller"
                style="max-height: 100vh; padding-top: 80px !important; overflow-y: auto;">
                <div class="container top-down-grad-dark p-4" style="border-radius: 25px 25px 0 0 !important;">
                    <h3 class="text-center p-4 bg-transparent fw-bold comfortaa-font text-truncate border-5 border-start border-end down-top-grad-tahitiz"
                        style="color: #fff !important; border-color: var(--primary-color) !important; cursor: pointer; border-radius: 25px;">
                        <!-- class="text-center rounded-pillz p-4 mb-4 text-truncate shadow"
            style="background-color: var(--primary-color); color: var(--secondary-color) !important; border-radius: 25px !important;" -->
                        <div class="d-grid justify-content-center text-center comfortaa-font">
                            <div class="text-center">
                                <img src="../../media/assets/One-Logo.svg" class="img-fluid my-4 px-4 text-center"
                                    style="border-radius: 25px; width: 100%; max-width: 400px!important;" alt="logo">
                            </div>

                            <hr class="my-4" style="color: var(--primary-color);">

                            <span class="material-icons material-icons-round">
                                person_add
                            </span>
                            <p class=" comfortaa-font text-wrap" style="font-size: 40px !important;">
                                Let's build your profile!
                            </p>
                        </div>

                    </h3>

                    <hr class="text-white" style="margin-top: 80px; margin-bottom: 80px;">

                    <div class="p-4 d-grid justify-content-center text-center border-5 border-start border-end down-top-grad-dark"
                        style="border-radius: 25px; border-color: var(--primary-color) !important;">
                        <div class="d-flex align-items-center justify-content-center align-middle">
                            <span class="material-icons material-icons-round" style="color: var(--primary-color);">
                                looks_one
                            </span>
                            <h5 class="comfortaa-font my-4">Set your profile picture</h5>
                        </div>

                        <div class="in-div-button-container text-center justify-content-center">

                            <div class="d-grid justify-content-center">
                                <img src="../../media/assets/OnefitNet Profile Pic Redone.png"
                                    class="img-fluid shadow my-4"
                                    style="border-radius: 25px; border-bottom: #ffa500 solid 5px;" alt="placeholder">
                            </div>


                            <button class="onefit-buttons-style-dark shadow in-div-btn text-center p-3 m-4 shadow"
                                onclick="launchProfileImgsEditor()">
                                <div class="d-grid align-items-center">
                                    <span class="material-icons material-icons-round"
                                        style="font-size: 20px !important;">
                                        change_circle
                                    </span>
                                    <span class="comfortaa-font" style="font-size: 10px;">change</span>
                                </div>
                            </button>

                        </div>
                    </div>

                    <hr class="text-white" style="margin-top: 80px; margin-bottom: 80px;">

                    <ul class="pb-4z text-center list-group list-group-flush down-top-grad-dark border-white border-5 border-start border-end"
                        style="border-radius: 25px !important; border-color: var(--primary-color) !important;">
                        <li id="toggle-main-form-window-list-btn"
                            class="pt-4 list-group-item bg-transparent fw-bold comfortaa-font text-truncate down-top-grad-dark"
                            style="color: #fff !important; border-color: var(--primary-color) !important; cursor: pointer;"
                            onclick="switchTab('mainfrmwindow')">
                            <div class="d-grid gap-2 text-center justify-content-center">
                                <div class="d-flex align-items-center justify-content-center align-middle text-wrap">
                                    <span class="material-icons material-icons-round"
                                        style="color: var(--primary-color);">
                                        looks_two
                                    </span>
                                    <span class="pt-4 fs-5">Create your Profile</span>
                                </div>


                                <span class="material-icons material-icons-round" style="color: var(--primary-color);">
                                    <!-- style="color: var(--primary-color); cursor: pointer;" -->
                                    expand_more
                                </span>
                            </div>

                        </li>

                        <li id="category-selector-about-you"
                            class="down-top-grad-dark list-group-item bg-transparent fw-bold comfortaa-font text-truncate profile-item-button collapse multi-collapse align-middle"
                            style="color: var(--primary-color); border-color: var(--primary-color) !important;"
                            onclick="switchTab('aboutyou')">
                            <div class="row align-items-center">
                                <div class="col-md text-truncate">
                                    <span>About You</span>
                                </div>
                                <div class="col-md-6 collapse w3-animate-right" id="aboutyou-confirmation-icon">
                                    <span class="material-icons material-icons-round ms-4z">
                                        check_circle
                                    </span>
                                </div>
                            </div>

                        </li>
                        <li id="category-selector-goal-setting"
                            class="down-top-grad-dark list-group-item bg-transparent fw-bold comfortaa-font text-truncate profile-item-button collapse multi-collapse align-middle"
                            style="color: var(--primary-color); border-color: var(--primary-color) !important;"
                            onclick="switchTab('goalsetting')">
                            <div class="row align-items-center">
                                <div class="col-md text-truncate">
                                    <span>Goal Setting</span>
                                </div>
                                <div class="col-md-6 collapse w3-animate-right" id="goalsetting-confirmation-icon">
                                    <span class="material-icons material-icons-round ms-4z">
                                        check_circle
                                    </span>
                                </div>
                            </div>

                        </li>
                        <li id="category-selector-fitness-prefs"
                            class="down-top-grad-dark list-group-item bg-transparent fw-bold comfortaa-font text-truncate profile-item-button collapse multi-collapse align-middle"
                            style="color: var(--primary-color); border-color: var(--primary-color) !important;"
                            onclick="switchTab('fitprefs')">
                            <div class="row align-items-center">
                                <div class="col-md text-truncate">
                                    <span class="text-truncate">Fitness Preferances</span>
                                </div>
                                <div class="col-md-6 collapse w3-animate-right" id="fitprefs-confirmation-icon">
                                    <span class="material-icons material-icons-round ms-4z">
                                        check_circle
                                    </span>
                                </div>
                            </div>

                        </li>
                        <li id="category-selector-eu-agreements"
                            class="down-top-grad-dark list-group-item bg-transparent fw-bold comfortaa-font text-truncate profile-item-button collapse multi-collapse align-middle"
                            style="color: var(--primary-color); border-color: var(--primary-color) !important;"
                            onclick="switchTab('eu-agreements')" hidden>
                            <div class="row align-items-center">
                                <div class="col-md">
                                    <span>End-User Agreements</span>
                                </div>
                                <div class="col-md-4 collapse w3-animate-right" id="eu-agreements-confirmation-icon">
                                    <span class="material-icons material-icons-round ms-4z">
                                        check_circle
                                    </span>
                                </div>
                            </div>

                        </li>

                        <span class="material-icons material-icons-outlined"
                            style="color: var(--primary-color); cursor: pointer;" onclick="switchTab('mainfrmwindow')">
                            <!--  -->
                            horizontal_rule
                        </span>

                        <!-- hidden links href="#main-form-window"-->
                        <button class="btn btn-primary" id="toggle-category-selectors" type="button"
                            data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false"
                            aria-controls="main-form-window category-selector-about-you category-selector-goal-setting category-selector-fitness-prefs"
                            hidden aria-hidden="true">
                            Toggle Category Selector List Buttons
                        </button>

                        <a class="btn btn-primary" id="toggle-main-form-window" data-bs-toggle="collapse"
                            href="#main-form-window" role="button" aria-expanded="false"
                            aria-controls="main-form-window" hidden aria-hidden="true">
                            Toggle main form window
                        </a>

                        <a class="btn btn-primary" id="toggle-main-form-window" data-bs-toggle="collapse"
                            href="#main-form-window" role="button" aria-expanded="false"
                            aria-controls="main-form-window" hidden aria-hidden="true">
                            Toggle show final tabpanel in main form window tab
                        </a>

                        <a class="btn btn-primary" id="toggle-aboutyou-check-icon" data-bs-toggle="collapse"
                            href="#aboutyou-confirmation-icon" role="button" aria-expanded="false"
                            aria-controls="aboutyou-confirmation-icon" hidden aria-hidden="true">
                            Toggle aboutyou check icon
                        </a>

                        <a class="btn btn-primary" id="toggle-goalsetting-check-icon" data-bs-toggle="collapse"
                            href="#goalsetting-confirmation-icon" role="button" aria-expanded="false"
                            aria-controls="goalsetting-confirmation-icon" hidden aria-hidden="true">
                            Toggle goalsetting check icon
                        </a>

                        <a class="btn btn-primary" id="toggle-fitprefs-check-icon" data-bs-toggle="collapse"
                            href="#fitprefs-confirmation-icon" role="button" aria-expanded="false"
                            aria-controls="fitprefs-confirmation-icon" hidden aria-hidden="true">
                            Toggle fitprefs check icon
                        </a>
                    </ul>

                    <div class="my-4 text-center down-top-grad-dark p-4"
                        style="border-radius: 0 0 25px 25px !important;">
                        <p class="text-white fs-5 align-end me-4z text-center comfortaa-font"> <span
                                style="font-size: 10px;">Crafted by
                                AdaptivConcept&trade; FL
                                &copy;
                                2022. All rights reserved.</span> | <a href="http://www.AdaptivConcept.co.za"
                                class="comfortaa-font" style=" color: var(--primary-color);">Support</a>
                        </p>
                    </div>
                </div>

            </div>

            <div class="col-md-8 collapse px-2 text-white h-100z down-top-grad-dark no-scroller w3-animate-bottom"
                style="height: 90vh; padding-top: 80px !important; overflow-y: auto; overflow-x: hidden; border-radius: 25px !important; border-bottom: #ffa500 solid 5px;"
                id="main-form-window">

                <div id="main-form-window-scroll-container" class="down-top-grad-white p-4 mb-4 w3-animate-top"
                    style="max-height: 80vh; width: 100%; border-radius: 25px !important; border-bottom: #ffa500 solid 5px; overflow-y: auto; overflow-x: hidden;">

                    <div class="p-4 shadow text-center mb-4 comfortaa-font border-5 border-start border-end top-down-grad-dark sticky-topz"
                        style="border-radius: 25px; border-color: var(--primary-color) !important;">
                        <!-- background-color: var(--secondary-color);  -->
                        <h1 class="align-middle" id="user-welcome-header">
                            <span class="material-icons material-icons-outlined align-middle"
                                style="color: var(--primary-color) !important; font-size: 40px;">account_circle</span>
                            Hi <?php echo "$current_user_name $current_user_surname"; ?>.
                        </h1>
                        <hr style="color: var(--text-color);">
                        <p class="comfortaa-font" style="font-size: 12px !important;">Please provide us with
                            a few more details so that we can understand more about you
                            and your preferences.
                        </p>
                        <div id="tab-title-header-display">
                            <h1 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center mt-4 border-5 border-start border-end sticky-top"
                                style="border-radius: 25px;background-color: var(--secondary-color);color: var(--text-color) !important;border-color: var(--primary-color) !important;">
                                About You </h1>
                        </div>
                    </div>


                    <!-- form category tabs -->
                    <div id="form-category-tabs" style="height: 100%;">
                        <ul class="nav nav-tabs" id="fitness-profile-form-tab" style="display: none;" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="category-about-you-tab" data-bs-toggle="tab"
                                    data-bs-target="#category-about-you-tab-pane" type="button" role="tab"
                                    aria-controls="category-about-you-tab-pane" aria-selected="true">About you</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="category-goal-setting-tab" data-bs-toggle="tab"
                                    data-bs-target="#category-goal-setting-tab-pane" type="button" role="tab"
                                    aria-controls="category-goal-setting-tab-pane" aria-selected="false">Set your
                                    Goals</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="category-fitness-prefs-tab" data-bs-toggle="tab"
                                    data-bs-target="#category-fitness-prefs-tab-pane" type="button" role="tab"
                                    aria-controls="category-fitness-prefs-tab-pane" aria-selected="false">Fitness
                                    Preferences</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="category-eu-agreements-tab" data-bs-toggle="tab"
                                    data-bs-target="#category-eu-agreements-tab-pane" type="button" role="tab"
                                    aria-controls="category-eu-agreements-tab-pane" aria-selected="false">End-User
                                    Agreements</button>
                            </li>
                        </ul>

                        <div class="tab-content comfortaa-font" id="fitness-profile-form-tabContent">
                            <div class="tab-pane fade show active w3-animate-bottom comfortaa-font"
                                id="category-about-you-tab-pane" role="tabpanel"
                                aria-labelledby="category-about-you-tab" tabindex="0">

                                <div class="my-4" id="category-about-you-tab-questions-pane">
                                    <div class="p-4 content-panel-border-style shadow"
                                        style="border-radius: 25px; background: #343434;">
                                        <h2 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4"
                                            style="border-radius: 25px; background-color: var(--secondary-color); color: #fff; margin-bottom: 60px !important;">
                                            Tell us about yourself.
                                        </h2>

                                        <p class="fs-5 comfortaa-font align-middle text-center my-4"
                                            style="margin-bottom: 40px !important;">Your account details.
                                        </p>
                                        <!-- Name
                    Surname
                    ID Number
                    Email
                    Contact Number
                    Date of birth
                    Gender
                    Race
                    Nationality
                    Height
                    Weight -->

                                        <!-- user details - output -->
                                        <div id="user-info-list" class="row">
                                            <div class="col-lg">
                                                <div class="text-start d-grid gap-2" id="user-account-details">
                                                    <div id="question-variable">
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">1)</span>
                                                            Your name</p>

                                                        <p class="fs-5" style="color: var(--primary-color);">
                                                            <?php echo $current_user_name; ?>
                                                        </p>
                                                    </div>

                                                </div>

                                                <div class="text-start d-grid gap-2" id="user-account-details">
                                                    <div id="question-variable">
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">2)</span>
                                                            Your surname</p>

                                                        <p class="fs-5" style="color: var(--primary-color);">
                                                            <?php echo $current_user_surname; ?>
                                                        </p>
                                                    </div>

                                                </div>

                                                <div class="text-start d-grid gap-2" id="user-account-details">
                                                    <div id="question-variable">
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">3)</span>
                                                            Your email address</p>

                                                        <p class="fs-5" style="color: var(--primary-color);">
                                                            <?php echo $current_user_email; ?>
                                                        </p>
                                                    </div>

                                                </div>

                                                <div class="text-start d-grid gap-2" id="user-account-details">
                                                    <div id="question-variable">
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">4)</span>
                                                            Your contact number</p>

                                                        <p class="fs-5" style="color: var(--primary-color);">
                                                            <?php echo $current_user_contact; ?>
                                                        </p>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-lg">
                                                <div class="text-start d-grid gap-2" id="user-account-details">
                                                    <div id="question-variable">
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">5)</span>
                                                            Your date of birth</p>

                                                        <p class="fs-5" style="color: var(--primary-color);">
                                                            <?php echo $current_user_dob; ?>
                                                        </p>
                                                    </div>

                                                </div>

                                                <div class="text-start d-grid gap-2" id="user-account-details">
                                                    <div id="question-variable">
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">6)</span>
                                                            Your gender</p>

                                                        <p class="fs-5" style="color: var(--primary-color);">
                                                            <?php echo $current_user_gender; ?>
                                                        </p>
                                                    </div>

                                                </div>

                                                <div class="text-start d-grid gap-2" id="user-account-details">
                                                    <div id="question-variable">
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">7)</span>
                                                            Your race</p>

                                                        <p class="fs-5" style="color: var(--primary-color);">
                                                            <?php echo $current_user_race; ?>
                                                        </p>
                                                    </div>

                                                </div>

                                                <div class="text-start d-grid gap-2" id="user-account-details">
                                                    <div id="question-variable">
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">8)</span>
                                                            Your Nationality</p>

                                                        <p class="fs-5" style="color: var(--primary-color);">
                                                            <?php echo $current_user_nation; ?>
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- .info-list contains the list view elems if a user has an existing record in the db for this form -->
                                        <!-- <div class="info-list" style="display: none;"></div> -->
                                        <!-- ./ user details - output -->

                                        <hr class="text-white mt-4">

                                        <!-- #aboutyou-info-form -->
                                        <form id="aboutyou-info-form"
                                            action="scripts/php/main_app/data_management/system_admin/user_registration/submit/aboutyou_submit.php"
                                            method="post" autocomplete="off">
                                            <!-- user id hidden -->
                                            <div class="form-group my-4">
                                                <input class="form-control-text-input p-4" type="hidden"
                                                    name="profile_id" id="user-profile-id-aboutyou"
                                                    value="<?php echo $current_user_prof_id; ?>"
                                                    placeholder="user profile id" required readonly />
                                            </div>
                                            <!-- ./ user id hidden -->

                                            <!-- .info-list contains the list view elems if a user has an existing record in the db for this form -->
                                            <div class="info-list" style="display: none;"></div>

                                            <!-- .input-section contains the input elems of this form -->
                                            <div class="input-section" style="display: block;">
                                                <p class="fs-5 comfortaa-font align-middle text-center my-4"
                                                    style="margin-bottom: 40px !important;">Please provide
                                                    us with your
                                                    Height (in
                                                    Centimeters) and Weight (in Kilograms)</p>

                                                <p class="fs-5 comfortaa-font align-middle text-center">
                                                    <span class="fs-2" style="color: var(--primary-color);">9)</span>
                                                    Your weight (kg)
                                                </p>

                                                <div class="form-group my-4">
                                                    <input class="form-control-text-input p-4" type="number" min="0"
                                                        oninput="validity.valid||(value='');" step="2"
                                                        name="category_1_weight_field" id="user-weight"
                                                        placeholder="Weight (kg)" required />
                                                </div>

                                                <p class="fs-5 comfortaa-font align-middle text-center">
                                                    <span class="fs-2" style="color: var(--primary-color);">10)</span>
                                                    Your height (cm)
                                                </p>

                                                <div class="form-group my-4">
                                                    <!-- set max to 180 - avg-max height rules -->
                                                    <input class="form-control-text-input p-4" type="number" min="0"
                                                        max="180" oninput="validity.valid||(value='');" step="2"
                                                        name="category_1_height_field" id="user-height"
                                                        placeholder="Height (cm)" required />
                                                </div>
                                            </div>

                                            <hr class="text-white" style="margin-bottom: 80px;">

                                            <!-- Procession Buttons -->
                                            <div class="comfortaa-font text-center mt-4"
                                                style="margin-bottom: 40px; font-size: 20px;">

                                                <div class="d-grid gap-0 w-100 text-white">
                                                    <span class="rounded-pill p-4"
                                                        style="background-color: var(--secondary-color);">
                                                        One<span style="color: var(--primary-color);">fit</span>.app
                                                    </span>
                                                    <span class="material-icons material-icons-outlined"
                                                        style="color: var(--primary-color);">
                                                        horizontal_rule
                                                    </span>
                                                </div>

                                                <!-- submit btn -->
                                                <div class="d-grid justify-content-center">
                                                    <input id="submit-aboutyou-info-form"
                                                        style="font-size: 20px !important;"
                                                        class="onefit-buttons-style-tahiti p-4 text-center comfortaa-font shadow fw-bold submit-btn"
                                                        type="submit" value="Save.">
                                                </div>
                                                <!-- ./ submit btn -->

                                                <!-- Procession Buttons -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg py-4">
                                                        <button type="button"
                                                            class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow panel-nav-btn"
                                                            id="goalsetting-next-panel-btn"
                                                            onclick="survey_controller('aboutyou','goalsetting')"
                                                            style="display:none;">
                                                            <div
                                                                class="d-grid gap-2 justify-content-center text-center fw-bold">
                                                                <span class="material-icons material-icons-round"
                                                                    style="font-size: 40px !important; color: var(--primary-color);">
                                                                    arrow_forward_ios </span>
                                                                <span>Goal setting.</span>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- ./ Procession Buttons -->

                                            </div>
                                            <!-- ./ Procession Buttons -->

                                            <!-- hidden aria-hidden="true" -->
                                        </form>
                                        <!-- ./ #aboutyou-info-form -->

                                    </div>

                                </div>

                            </div>
                            <div class="tab-pane fade w3-animate-bottom comfortaa-font"
                                id="category-goal-setting-tab-pane" role="tabpanel"
                                aria-labelledby="category-goal-setting-tab" tabindex="0">

                                <div class="my-4" id="category-goal-setting-tab-questions-pane">
                                    <div class="p-4 content-panel-border-style shadow"
                                        style="border-radius: 25px; background: #343434;">
                                        <h2 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4"
                                            style="border-radius: 25px; background-color: var(--secondary-color); color: #fff; margin-bottom: 60px !important;">
                                            Set your Fitness Goals.
                                        </h2>

                                        <div form="main-submission-form" id="emailHelp"
                                            class="form-text text-center fw-bold my-4" style=" color: #fff">
                                            We have a responsibility
                                            to
                                            keep your keep your Identity &amp; Privacy safe! <br>
                                            - <a href="http://" style=" color: var(--primary-color);">Privacy
                                                Policy</a> -
                                        </div>

                                        <hr class="text-white" style="margin-top: 80px;">

                                        <!-- #goalsetting-info-form -->
                                        <!-- ../../scripts/php/main_app/data_management/system_admin/user_registration/submit/goalsetting_submit.php -->
                                        <form id="goalsetting-info-form"
                                            action="../../scripts/php/main_app/data_management/system_admin/user_registration/submit/goalsetting_submit.php"
                                            method="post" autocomplete="off">
                                            <!-- user id hidden -->
                                            <div class="form-group my-4">
                                                <input class="form-control-text-input p-4" type="hidden"
                                                    name="profile_id" id="user-profile-id-goalsetting"
                                                    value="<?php echo $current_user_prof_id; ?>"
                                                    placeholder="user profile id" required readonly />
                                            </div>
                                            <!-- ./ user id hidden -->

                                            <!-- .info-list contains the list view elems if a user has an existing record in the db for this form -->
                                            <div class="info-list" style="display: none;"></div>

                                            <!-- .input-section contains the input elems of this form -->
                                            <div class="input-section" style="display: block;">
                                                <!-- 
                        1. What is your Goal?
                        2. Please set your own Goal statement
                        3. By when do you want to have realized this Goal?
                        4. Which areas of your body do you want to work on?
                        5. How many workouts per week do you want to do?
                        6. How much time do you have to workout?
                        7. How many weeks do you want to start with?
                        8. Do you have any bad habits?
                        9. Are you prepared to do what is necessay to let go of bed habits?
                        10. Please select your prefarred "Cheat-Day"
                        11. What will you do on your "Cheat-Day"?
                        -->

                                                <!-- 1. Question: What are your Fitness Goals? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6 p-2 text-start">
                                                        <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                              sports_score
                            </span> -->
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">1)</span>
                                                            What are
                                                            your Fitness
                                                            Goals?</p>
                                                    </div>
                                                    <div class="col-lg -6 p-2">
                                                        <!-- 
                            Be more active
                            Lose weight
                            Stay toned
                            Build muscle
                            Reduce Stress
                            Stay healthy
                            -->
                                                        <div class="form-check">
                                                            <input class="form-check-input me-4" value="Be more active"
                                                                type="checkbox" name="category_2_question_1_field[]"
                                                                id="category-2-be-more-active-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-be-more-active-field">
                                                                Be more active
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input me-4" value="Lose weight"
                                                                type="checkbox" name="category_2_question_1_field[]"
                                                                id="category-2-lose-weight-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-lose-weight-field">
                                                                Lose weight
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input me-4" value="Stay toned"
                                                                type="checkbox" name="category_2_question_1_field[]"
                                                                id="category-2-stay-toned-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-stay-toned-field">
                                                                Stay toned
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input me-4" value="Build muscle"
                                                                type="checkbox" name="category_2_question_1_field[]"
                                                                id="category-2-build-muscle-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-build-muscle-field">
                                                                Build muscle
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input me-4" value="Reduce Stress"
                                                                type="checkbox" name="category_2_question_1_field[]"
                                                                id="category-2-reduce-stress-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-reduce-stress-field">
                                                                Reduce Stress
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Stay healthy"
                                                                type="checkbox" name="category_2_question_1_field[]"
                                                                id="category-2-stay-healty-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-stay-healty-field">
                                                                Stay healthy
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- ./ Question: What are your Fitness Goals? -->

                                                <hr class="text-white">

                                                <!-- 2. Question: Please set your own Goal statement? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6 p-2 text-start">
                                                        <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                          sports_score
                        </span> -->
                                                        <p class="fs-5 comfortaa-font align-middle"><span class=" fs-2"
                                                                style="color: var(--primary-color);">2)</span>
                                                            Please set
                                                            your own Goal statement</p>
                                                    </div>
                                                    <div class="col-lg -6 p-2 text-truncate">
                                                        <div class="form-group text-truncate">
                                                            <textarea class="form-control-text-input p-4"
                                                                style="border-radius: 25px !important;" rows="10"
                                                                type="text" name="category_2_question_2_field"
                                                                id="goal-statement" placeholder="My goal statement"
                                                                required></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- ./ Question: Please set your own Goal statement? -->

                                                <hr class="text-white">

                                                <!-- 3. Question: By when do you want to have realized this Goal? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6 p-2 text-start">
                                                        <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                          sports_score
                        </span> -->
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">3)</span>
                                                            By when do
                                                            you want to have realized this Goal?</p>
                                                        <!-- radio buttons to dynamically set date depending on selection of week range -->
                                                        <div class="d-block gap-2 justify-content-between">
                                                            <!-- one (1) week from now -->
                                                            <div class="form-check text-truncate">
                                                                <input class="form-check-input me-4" type="radio"
                                                                    onchange="" value="1" name="dynamic-date-select-q3"
                                                                    id="q3-1-dynamic-date-select" selected>
                                                                <label class="form-check-label p-2"
                                                                    for="q3-1-dynamic-date-select"
                                                                    style="font-size: 10px !important;">
                                                                    1 week
                                                                </label>
                                                            </div>
                                                            <!-- two (2) week from now -->
                                                            <div class="form-check text-truncate">
                                                                <input class="form-check-input me-4 valu" type="radio"
                                                                    value="2" name="dynamic-date-select-q3"
                                                                    id="q3-2-dynamic-date-select">
                                                                <label class="form-check-label p-2"
                                                                    for="q3-2-dynamic-date-select"
                                                                    style="font-size: 10px !important;">
                                                                    2 week
                                                                </label>
                                                            </div>
                                                            <!-- three (3) week from now -->
                                                            <div class="form-check text-truncate">
                                                                <input class="form-check-input me-4" type="radio"
                                                                    value="3" name="dynamic-date-select-q3"
                                                                    id="q3-3-dynamic-date-select">
                                                                <label class="form-check-label p-2"
                                                                    for="q3-3-dynamic-date-select"
                                                                    style="font-size: 10px !important;">
                                                                    3 week
                                                                </label>
                                                            </div>
                                                            <!-- four (4) week from now -->
                                                            <div class="form-check text-truncate">
                                                                <input class="form-check-input me-4" type="radio"
                                                                    value="4" name="dynamic-date-select-q3"
                                                                    id="q3-4-dynamic-date-select">
                                                                <label class="form-check-label p-2"
                                                                    for="q3-4-dynamic-date-select"
                                                                    style="font-size: 10px !important;">
                                                                    4 week
                                                                </label>
                                                            </div>
                                                            <!-- four (4) week from now -->
                                                            <div class="form-check text-truncate">
                                                                <input class="form-check-input me-4" type="radio"
                                                                    value="5" name="dynamic-date-select-q3"
                                                                    id="q3-5-dynamic-date-select">
                                                                <label class="form-check-label p-2"
                                                                    for="q3-5-dynamic-date-select"
                                                                    style="font-size: 10px !important;">
                                                                    5 week
                                                                </label>
                                                            </div>

                                                            <!-- function to set future date to #reach-goal-date based on selection made on ynamic-date-select-q3[] -->
                                                            <script>
                                                            $(document).ready(function() {
                                                                $('input[type=radio][name=dynamic-date-select-q3]')
                                                                    .change(function() {
                                                                        var today = new Date();
                                                                        var dd = today
                                                                            .getDate();
                                                                        var mm = today
                                                                            .getMonth() +
                                                                            1; //January is 0 so need to add 1 to make it 1!
                                                                        var yyyy = today
                                                                            .getFullYear();
                                                                        var daysToAdd = this
                                                                            .value * 7;
                                                                        var futureDate =
                                                                            new Date();
                                                                        futureDate.setDate(today
                                                                            .getDate() +
                                                                            daysToAdd);
                                                                        var futuredd =
                                                                            futureDate
                                                                            .getDate();
                                                                        var futuremm =
                                                                            futureDate
                                                                            .getMonth() +
                                                                            1; //January is 0 so need to add 1 to make it 1!
                                                                        var futureyyyy =
                                                                            futureDate
                                                                            .getFullYear();
                                                                        if (futuredd < 10) {
                                                                            futuredd = '0' +
                                                                                futuredd;
                                                                        }
                                                                        if (futuremm < 10) {
                                                                            futuremm = '0' +
                                                                                futuremm;
                                                                        }
                                                                        var futureDate =
                                                                            futureyyyy + '-' +
                                                                            futuremm + '-' +
                                                                            futuredd;
                                                                        document.getElementById(
                                                                                "reach-goal-date"
                                                                            ).value =
                                                                            futureDate;

                                                                        // if #q3-4-dynamic-date-select to #q3-5-dynamic-date-select is checked, check #category-2-4weeks-field 
                                                                        if (document
                                                                            .getElementById(
                                                                                "q3-1-dynamic-date-select"
                                                                            ).checked ||
                                                                            document
                                                                            .getElementById(
                                                                                "q3-2-dynamic-date-select"
                                                                            ).checked ||
                                                                            document
                                                                            .getElementById(
                                                                                "q3-3-dynamic-date-select"
                                                                            ).checked ||
                                                                            document
                                                                            .getElementById(
                                                                                "q3-4-dynamic-date-select"
                                                                            ).checked ||
                                                                            document
                                                                            .getElementById(
                                                                                "q3-5-dynamic-date-select"
                                                                            ).checked) {
                                                                            document
                                                                                .getElementById(
                                                                                    "category-2-4weeks-field"
                                                                                ).checked =
                                                                                true;
                                                                        } else {
                                                                            document
                                                                                .getElementById(
                                                                                    "category-2-4weeks-field"
                                                                                ).checked =
                                                                                false;
                                                                        }
                                                                    });
                                                                // ./ end of function
                                                            });
                                                            </script>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg -6 p-2 text-truncate">
                                                        <div class="form-group text-truncate">
                                                            <input class="form-control-text-input p-4"
                                                                onchange="checkReachGoalDate()" type="date"
                                                                name="category_2_question_3_field" id="reach-goal-date"
                                                                required />
                                                        </div>

                                                        <!-- javascript function to detect if date selected on #category_2_question_3_field is before todays date -->
                                                        <script>
                                                        function checkReachGoalDate() {
                                                            var selectedDate = document.getElementById(
                                                                "reach-goal-date").value;
                                                            var now = new Date();
                                                            var today = new Date(now.getFullYear(), now
                                                                .getMonth(), now.getDate());
                                                            if (new Date(selectedDate) < today) {
                                                                alert("Please select a date in the future");
                                                                document.getElementById("reach-goal-date")
                                                                    .value = "";
                                                                document.getElementById("reach-goal-date")
                                                                    .focus();
                                                            } else {
                                                                // if selectedDate is greater than date in 5 weeks time, check #category-2-4weeks-field
                                                                // var today = new Date();
                                                                var dd = today.getDate();
                                                                var mm = today.getMonth() +
                                                                    1; //January is 0 so need to add 1 to make it 1!
                                                                var yyyy = today.getFullYear();
                                                                var daysToAdd = 5 * 7;
                                                                var futureDate = new Date();
                                                                futureDate.setDate(today.getDate() +
                                                                    daysToAdd);

                                                                // check if futureDate is greater than selectedDate
                                                                if (new Date(selectedDate) < futureDate) {
                                                                    document.getElementById(
                                                                            "category-2-4weeks-field")
                                                                        .checked = true;
                                                                } else {
                                                                    document.getElementById(
                                                                            "category-2-4weeks-field")
                                                                        .checked = false;
                                                                }

                                                                // get number of weeks from today to selectedDate
                                                                var oneDay = 24 * 60 * 60 *
                                                                    1000; // hours*minutes*seconds*milliseconds
                                                                var secondDate = new Date(selectedDate);
                                                                var diffDays = Math.round(Math.abs((today -
                                                                    secondDate) / oneDay));
                                                                var weeks = Math.floor(diffDays / 7);

                                                                // assign weeks value to #specific-weeks
                                                                document.getElementById("specific-weeks")
                                                                    .value = weeks;
                                                            }
                                                        }
                                                        </script>

                                                    </div>
                                                </div>
                                                <!-- ./ Question: By when do you want to have realized this Goal? -->

                                                <hr class="text-white">

                                                <!-- 4. Question: Which areas of your body do you want to work on? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6 p-2 text-start">
                                                        <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                          sports_score
                        </span> -->
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">4)</span>
                                                            Which areas
                                                            of your body do you want to work on?</p>
                                                    </div>
                                                    <div class="col-lg -6 p-2">
                                                        <!-- 
                          Glutes
                          Abs
                          Arms
                          Upper Body
                          Lower Body
                          Total Body
                          Legs
                          Back
                          Butt
                          -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Glutes"
                                                                type="checkbox" name="category_2_question_4_field[]"
                                                                id="category-2-glutes-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-glutes-field">
                                                                Glutes
                                                            </label>
                                                        </div>


                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Abs"
                                                                type="checkbox" name="category_2_question_4_field[]"
                                                                id="category-2-abs-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-abs-field">
                                                                Abs
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Arms"
                                                                type="checkbox" name="category_2_question_4_field[]"
                                                                id="category-2-arms-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-arms-field">
                                                                Arms
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Legs"
                                                                type="checkbox" name="category_2_question_4_field[]"
                                                                id="category-2-legs-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-legs-field">
                                                                Legs
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Back"
                                                                type="checkbox" name="category_2_question_4_field[]"
                                                                id="category-2-back-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-back-field">
                                                                Back
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Butt"
                                                                type="checkbox" name="category_2_question_4_field[]"
                                                                id="category-2-butt-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-butt-field">
                                                                Butt
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Upper Body"
                                                                type="checkbox" name="category_2_question_4_field[]"
                                                                id="category-2-upper-body-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-upper-body-field">
                                                                Upper Body
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Lower Body"
                                                                type="checkbox" name="category_2_question_4_field[]"
                                                                id="category-2-lower-body-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-lower-body-field">
                                                                Lower Body
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Total Body"
                                                                type="checkbox" name="category_2_question_4_field[]"
                                                                id="category-2-total-body-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-total-body-field">
                                                                Total Body
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- ./ Question: Which areas of your body do you want to work on? -->

                                                <hr class="text-white">

                                                <!-- 5. Question: How many workouts per week do you want to do? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6 p-2 text-start">
                                                        <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                          sports_score
                        </span> -->
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">5)</span>
                                                            How many workouts per week do you want to do?
                                                        </p>
                                                    </div>
                                                    <div class="col-lg -6 p-2">
                                                        <!-- 
                        `2-3
                        `3-4
                        `4-5
                        `5+
                        -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="2 - 3 weeks"
                                                                type="radio" name="category_2_question_5_field[]"
                                                                id="category-2-2_3-weeks-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-2_3-weeks-field">
                                                                2 - 3
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="3 - 4 weeks"
                                                                type="radio" name="category_2_question_5_field[]"
                                                                id="category-2-3_4-weeks-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-3_4-weeks-field">
                                                                3 - 4
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="4 - 5 weeks"
                                                                type="radio" name="category_2_question_5_field[]"
                                                                id="category-2-4_5-weeks-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-4_5-weeks-field">
                                                                4 - 5
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="5+ weeks"
                                                                type="radio" name="category_2_question_5_field[]"
                                                                id="category-2-more_5-weeks-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-more_5-weeks-field">
                                                                5+
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- ./ Question: How many workouts per week do you want to do? -->

                                                <hr class="text-white">

                                                <!-- 6. Question: How much time do you have to workout? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6 p-2 text-start">
                                                        <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                          sports_score
                        </span> -->
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">6)</span>
                                                            How much time do you have to workout?</p>
                                                    </div>
                                                    <div class="col-lg -6 p-2">
                                                        <!-- 
                        5-10 Minutes
                        15-20 Minutes
                        25-30 Minutes
                        30+ Minutes
                        -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="5 - 10 minutes"
                                                                type="radio" name="category_2_question_6_field[]"
                                                                id="category-2-5_10-mins-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-5_10-mins-field">
                                                                5 - 10 Minutes
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="15 - 20 minutes"
                                                                type="radio" name="category_2_question_6_field[]"
                                                                id="category-2-15_20-mins-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-15_20-mins-field">
                                                                15 - 20 Minutes
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="25 - 30 minutes"
                                                                type="radio" name="category_2_question_6_field[]"
                                                                id="category-2-25_30-mins-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-25_30-mins-field">
                                                                25 - 30 Minutes
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="30+ minutes"
                                                                type="radio" name="category_2_question_6_field[]"
                                                                id="category-2-more_30-mins-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-more_30-mins-field">
                                                                30+ Minutes
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- ./ Question: How much time do you have to workout? -->

                                                <hr class="text-white">

                                                <!-- 7. Question: How many weeks do you want to start with? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6 p-2 text-start">
                                                        <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                          sports_score
                        </span> -->
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">7)</span>
                                                            How many weeks do you want to start with?</p>
                                                    </div>
                                                    <div class="col-lg -6 p-2">
                                                        <!-- 
                        4 Weeks
                        8 Weeks
                        12 Weeks
                        Specify
                        -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="4" type="radio"
                                                                name="category_2_question_7_field[]"
                                                                id="category-2-4weeks-field"
                                                                onchange="toggleCtgy2SpecifyOther('hide')">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-4weeks-field">
                                                                4 Weeks
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="8" type="radio"
                                                                name="category_2_question_7_field[]"
                                                                id="category-2-8weeks-field"
                                                                onchange="toggleCtgy2SpecifyOther('hide')">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-8weeks-field">
                                                                8 Weeks
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="12" type="radio"
                                                                name="category_2_question_7_field[]"
                                                                id="category-2-12weeks-field"
                                                                onchange="toggleCtgy2SpecifyOther('hide')">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-12weeks-field">
                                                                12 Weeks
                                                            </label>
                                                        </div>

                                                        <!-- specify -->
                                                        <div class="form-check text-truncate my-4">
                                                            <input class="form-check-input me-4" value="specified"
                                                                type="radio" name="category_2_question_7_field[]"
                                                                id="specify-weeks"
                                                                onchange="toggleCtgy2SpecifyOther('show')">
                                                            <label class="form-check-label p-2" for="specify-weeks">
                                                                Specify.
                                                            </label>
                                                        </div>

                                                        <script>
                                                        function toggleCtgy2SpecifyOther(state) {
                                                            var specifyCheckInput = document.getElementById(
                                                                "specify-weeks").value;
                                                            var specifyFieldContainer = document
                                                                .getElementById(
                                                                    "category-2-question-8-specify");

                                                            if (state == "show") {
                                                                specifyFieldContainer.style.display =
                                                                    "block";
                                                                // set #specific-weeks input type to "number"
                                                                document.getElementById("specific-weeks")
                                                                    .type = "number";
                                                            } else {
                                                                specifyFieldContainer.style.display =
                                                                    "none";
                                                                // set #specific-weeks input type to "hidden"
                                                                document.getElementById("specific-weeks")
                                                                    .type = "hidden";
                                                            }
                                                        }
                                                        </script>

                                                        <div class="form-group mt-4 mb-0 w3-animate-right"
                                                            id="category-2-question-8-specify" style="display: none;">
                                                            <input class="form-control-text-input p-4" type="number"
                                                                value="specify"
                                                                name="category_2_question_7_specify_weeks_field"
                                                                id="specific-weeks"
                                                                placeholder="Specify the number of weeks" />
                                                            <!-- style="position: relative;"  -->
                                                            <p class="comfortaa-font text-center fs-5 mt-2 mb-0"
                                                                style="color: var(--primary-color);"
                                                                for="specific-weeks">
                                                                <!-- style="position: absolute; top: 50%; right: 20px; margin-top: -25%; transform: translate(10px, 10px) !important; -ms-transform: translate(10px, 10px) !important;" -->
                                                                Weeks
                                                            </p>
                                                        </div>
                                                        <!-- ./ specify -->

                                                    </div>
                                                </div>
                                                <!-- ./ Question: How many weeks do you want to start with? -->

                                                <hr class="text-white">

                                                <!-- 8. Question: Do you have any bad habits? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6 p-2 text-start">
                                                        <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                          sports_score
                        </span> -->
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">8)</span>
                                                            Do you have any bad habits?</p>
                                                    </div>
                                                    <div class="col-lg -6 p-2">
                                                        <!-- 
                        I eat a lot of sweets or sugary treats
                        I drink a lot of sugary drinks
                        I do not sleep enough
                        I eat a lot of fatty foods / fast foods
                        I eat late at night
                        None whatsoever
                        -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="I eat a lot of sweets or sugary treats"
                                                                type="checkbox" name="category_2_question_8_field[]"
                                                                id="category-2-badhabits-a-field">
                                                            <label class="form-check-label p-2 text-wrap"
                                                                for="category-2-badhabits-a-field">
                                                                I eat a lot of sweets or sugary treats
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="I do not sleep enough" type="checkbox"
                                                                name="category_2_question_8_field[]"
                                                                id="category-2-badhabits-b-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-badhabits-b-field">
                                                                I do not sleep enough
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="I eat a lot of fatty foods / fast foods"
                                                                type="checkbox" name="category_2_question_8_field[]"
                                                                id="category-2-badhabits-c-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-badhabits-c-field">
                                                                I eat a lot of fatty foods / fast foods
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="I eat late at night" type="checkbox"
                                                                name="category_2_question_8_field[]"
                                                                id="category-2-badhabits-d-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-badhabits-d-field">
                                                                I eat late at night
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="I am a smoker"
                                                                type="checkbox" name="category_2_question_8_field[]"
                                                                id="category-2-badhabits-e-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-badhabits-e-field">
                                                                I am a smoker
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="None"
                                                                type="checkbox" name="category_2_question_8_field[]"
                                                                id="category-2-badhabits-none-field" checked>
                                                            <label class="form-check-label p-2"
                                                                for="category-2-badhabits-none-field">
                                                                None whatsoever
                                                            </label>
                                                        </div>

                                                        <!-- if #category-2-badhabits-none-field is checked, uncheck other name="category_2_question_8_field[]" inputs -->
                                                        <script>
                                                        var category2BadHabitsNoneField = document
                                                            .getElementById(
                                                                "category-2-badhabits-none-field");
                                                        var category2BadHabitsAField = document
                                                            .getElementById("category-2-badhabits-a-field");
                                                        var category2BadHabitsBField = document
                                                            .getElementById("category-2-badhabits-b-field");
                                                        var category2BadHabitsCField = document
                                                            .getElementById("category-2-badhabits-c-field");
                                                        var category2BadHabitsDField = document
                                                            .getElementById("category-2-badhabits-d-field");
                                                        var category2BadHabitsEField = document
                                                            .getElementById("category-2-badhabits-e-field");

                                                        category2BadHabitsNoneField.addEventListener(
                                                            "click",
                                                            function() {
                                                                if (category2BadHabitsNoneField
                                                                    .checked == true) {
                                                                    category2BadHabitsAField.checked =
                                                                        false;
                                                                    category2BadHabitsBField.checked =
                                                                        false;
                                                                    category2BadHabitsCField.checked =
                                                                        false;
                                                                    category2BadHabitsDField.checked =
                                                                        false;
                                                                    category2BadHabitsEField.checked =
                                                                        false;
                                                                }
                                                            });

                                                        // if inputs beside #category-2-badhabits-none-field are checked, unchecked #category-2-badhabits-none-field
                                                        category2BadHabitsAField.addEventListener("click",
                                                            function() {
                                                                if (category2BadHabitsAField.checked ==
                                                                    true) {
                                                                    category2BadHabitsNoneField
                                                                        .checked = false;
                                                                }
                                                            });
                                                        category2BadHabitsBField.addEventListener("click",
                                                            function() {
                                                                if (category2BadHabitsBField.checked ==
                                                                    true) {
                                                                    category2BadHabitsNoneField
                                                                        .checked = false;
                                                                }
                                                            });
                                                        category2BadHabitsCField.addEventListener("click",
                                                            function() {
                                                                if (category2BadHabitsCField.checked ==
                                                                    true) {
                                                                    category2BadHabitsNoneField
                                                                        .checked = false;
                                                                }
                                                            });
                                                        category2BadHabitsDField.addEventListener("click",
                                                            function() {
                                                                if (category2BadHabitsDField.checked ==
                                                                    true) {
                                                                    category2BadHabitsNoneField
                                                                        .checked = false;
                                                                }
                                                            });
                                                        category2BadHabitsEField.addEventListener("click",
                                                            function() {
                                                                if (category2BadHabitsEField.checked ==
                                                                    true) {
                                                                    category2BadHabitsNoneField
                                                                        .checked = false;
                                                                }
                                                            });
                                                        </script>

                                                    </div>
                                                </div>
                                                <script>
                                                // add js code to uncheck other inputs if "None whatsoever" is selected/checked
                                                </script>
                                                <!-- ./ Question: Do you have any bad habits?? -->

                                                <hr class="text-white">

                                                <!-- 9. Question: Are you prepared to do what is necessay to let go of bed habits? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6 p-2 text-start">
                                                        <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                            sports_score
                          </span> -->
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">9)</span>
                                                            Are you prepared to do what is necessay to let
                                                            go of bed habits?</p>
                                                    </div>
                                                    <div class="col-lg -6 p-2">
                                                        <!-- 
                          Yes
                          No
                          -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Yes"
                                                                type="radio" name="category_2_question_9_field[]"
                                                                id="category-2-prepared-stop-badhabits-yes-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-prepared-stop-badhabits-yes-field">
                                                                Yes
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="No" type="radio"
                                                                name="category_2_question_9_field[]"
                                                                id="category-2-prepared-stop-badhabits-no-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-2-prepared-stop-badhabits-no-field">
                                                                No
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- ./ Question: Are you prepared to do what is necessay to let go of bed habits? -->

                                                <hr class="text-white">

                                                <!-- 10. Question: Please select your prefarred "Cheat-Day" -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg-6 p-2 text-start">
                                                        <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                          sports_score
                        </span> -->
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">10)</span>
                                                            Please select your prefarred "Cheat-Day".</p>
                                                    </div>
                                                    <div class="col-lg -6 p-2">
                                                        <div class="form-groupz my-4">

                                                            <select class="custom-select form-control-select-input p-4"
                                                                onchange="cheatDaySelection()"
                                                                name="category_2_question_10_field"
                                                                id="cheatday-selection" required>
                                                                <option value="no_cheat" selected="selected">No Cheat
                                                                    Days
                                                                </option>
                                                                <option value="Monday">Monday</option>
                                                                <option value="Tuesday">Tuesday</option>
                                                                <option value="Wednesday">Wednesday</option>
                                                                <option value="Thursday">Thursday</option>
                                                                <option value="Friday">Friday</option>
                                                                <option value="Saturday">Saturday</option>
                                                                <option value="Sunday">Sunday</option>
                                                            </select>

                                                            <script>
                                                            function cheatDaySelection() {
                                                                var x = document.getElementById(
                                                                    "cheatday-selection").value;

                                                                if (x == "no_cheat") {
                                                                    $("#cheat-day-pledge").hide();
                                                                    $("#cheat-day-pledge-divide").hide();
                                                                    // assign hidden attr to #cheat-day-promise select element
                                                                    $("#cheat-day-promise").attr("type",
                                                                        "hidden");
                                                                    // set "not cheat" value to #cheat-day-promise input element
                                                                    $("#cheat-day-promise").val(
                                                                        "not cheat");
                                                                } else {
                                                                    $("#cheat-day-pledge").show();
                                                                    $("#cheat-day-pledge-divide").show();
                                                                    // assign text attr from #cheat-day-promise select element
                                                                    $("#cheat-day-promise").attr("type",
                                                                        "text");
                                                                    // set "" value to #cheat-day-promise input element
                                                                    $("#cheat-day-promise").val("");
                                                                }

                                                            }
                                                            </script>

                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- ./ Question: Please select your prefarred "Cheat-Day" -->

                                                <hr class="text-white" id="cheat-day-pledge-divide"
                                                    style="display: none;">

                                                <!-- 11. Question: What will you do on your "Cheat-Day"? -->
                                                <div class="row align-items-center w3-animate-left"
                                                    id="cheat-day-pledge" style="display: none;">
                                                    <div class="col-lg-6 p-2 text-start">
                                                        <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                          sports_score
                        </span> -->
                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">11)</span>
                                                            What will you do on your "Cheat-Day"?</p>
                                                    </div>
                                                    <div class="col-lg -6 p-2">
                                                        <div class="form-group">
                                                            <p class=" text-center mb-4" for="cheat-day-promise">I
                                                                promise that I
                                                                will only</p>
                                                            <textarea class="form-control-text-input p-4"
                                                                style="border-radius: 25px !important;" rows="3"
                                                                type="text" name="category_2_question_11_field"
                                                                id="cheat-day-promise" placeholder=" … "
                                                                required></textarea>
                                                            <p class="text-center mt-4" for="cheat-day-promise">on my
                                                                "cheat-day".
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- ./ Question: What will you do on your "Cheat-Day"? -->
                                            </div>



                                            <hr class="text-white" style="margin-bottom: 80px;">

                                            <!-- Procession Buttons -->
                                            <div class="comfortaa-font text-center mt-4"
                                                style="margin-bottom: 40px; font-size: 20px;">

                                                <div class="d-grid gap-0 w-100 text-white">
                                                    <span class="rounded-pill p-4"
                                                        style="background-color: var(--secondary-color);">
                                                        One<span style="color: var(--primary-color);">fit</span>.app
                                                    </span>

                                                    <span class="material-icons material-icons-outlined"
                                                        style="color: var(--primary-color);">
                                                        horizontal_rule
                                                    </span>
                                                </div>

                                                <!-- submit btn -->
                                                <div class="d-grid justify-content-center">
                                                    <input id="submit-goalsetting-info-form"
                                                        style="font-size: 20px !important;"
                                                        class="onefit-buttons-style-tahiti p-4 text-center comfortaa-font shadow fw-bold submit-btn"
                                                        type="submit" value="Save.">
                                                </div>
                                                <!-- ./ submit btn -->

                                                <!-- Procession Buttons -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg py-4 d-grid">
                                                        <button type="button"
                                                            class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow panel-nav-btn"
                                                            id="aboutyou-back-panel-btn"
                                                            onclick="survey_controller('goalsetting','aboutyou')"
                                                            style="display: none;">
                                                            <div
                                                                class="d-grid gap-2 justify-content-center text-center fw-bold">
                                                                <span class="material-icons material-icons-round"
                                                                    style="font-size: 40px !important; color: var(--primary-color);">
                                                                    arrow_back_ios </span>
                                                                <span>About you.</span>
                                                            </div>

                                                        </button>
                                                    </div>
                                                    <div class="col-lg py-4 d-grid">
                                                        <button type="button"
                                                            class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow panel-nav-btn"
                                                            id="fitprefs-next-panel-btn"
                                                            onclick="survey_controller('goalsetting','fitprefs')"
                                                            style="display: none;">
                                                            <div
                                                                class="d-grid gap-2 justify-content-center text-center fw-bold">
                                                                <span class="material-icons material-icons-round"
                                                                    style="font-size: 40px !important; color: var(--primary-color);">
                                                                    arrow_forward_ios </span>
                                                                <span>Fitness Preferances.</span>
                                                            </div>

                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- ./ Procession Buttons -->

                                            </div>
                                            <!-- ./ Procession Buttons -->

                                        </form>
                                        <!-- ./ #goalsetting-info-form -->

                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade w3-animate-bottom comfortaa-font"
                                id="category-fitness-prefs-tab-pane" role="tabpanel"
                                aria-labelledby="category-fitness-prefs-tab" tabindex="0">

                                <div class="my-4" id="category-fitness-prefs-tab-questions-pane">

                                    <div class="p-4 content-panel-border-style shadow"
                                        style="border-radius: 25px; background: #343434;">
                                        <h4 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end"
                                            style="border-radius: 25px; background-color: var(--secondary-color); color: #fff; border-color: var(--primary-color); margin-bottom: 80px !important;">
                                            Tell us about your Training History and Fitness Preferances.
                                        </h4>

                                        <div form="main-submission-form" id="emailHelp"
                                            class="form-text text-center fw-bold my-4" style=" color: #fff">
                                            We have a responsibility
                                            to
                                            keep your keep your Identity &amp; Privacy safe! <br>
                                            - <a href="http://" style=" color: var(--primary-color);">Privacy
                                                Policy</a> -
                                        </div>

                                        <hr class="text-white" style="margin-top: 80px;">

                                        <!-- #fitprefs-info-form -->
                                        <!-- ../../scripts/php/main_app/data_management/system_admin/user_registration/submit/ -->
                                        <form id="fitprefs-info-form"
                                            action="../../scripts/php/main_app/data_management/system_admin/user_registration/submit//fitprefs_submit.php"
                                            method="post" autocomplete="off">
                                            <!-- user id hidden -->
                                            <div class="form-group my-4">
                                                <input class="form-control-text-input p-4" type="hidden"
                                                    name="profile_id" id="user-profile-id-fitprefs"
                                                    value="<?php echo $current_user_prof_id; ?>"
                                                    placeholder="user profile id" required readonly />
                                            </div>
                                            <!-- ./ user id hidden -->

                                            <!-- .info-list contains the list view elems if a user has an existing record in the db for this form -->
                                            <div class="info-list" style="display: none;"></div>

                                            <!-- .input-section contains the input elems of this form -->
                                            <div class="input-section" style="display: block;">
                                                <!-- 
                        How fit are you?
                        When was the last time you were at your Ideal weight?
                        What is your body type?
                        Do you suffer from any joint pain?
                        How active are you in your daily life?
                        How are your energy levels during the day?
                        How much do you sleep every night?
                        What is your daily water intake?
                        Select the type of classes you are looing to do:
                        -->

                                                <!-- Question 1: How fit are you? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg -4 p-2">

                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">1)</span>
                                                            How fit are you?</p>

                                                    </div>
                                                    <div class="col-lg -8 p-2 text-truncate">
                                                        <!-- 
                          Not fit
                          Fit
                          Very fit
                          -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Not fit"
                                                                type="radio" name="category_3_question_1_field[]"
                                                                id="category-3-not-fit-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-not-fit-field">
                                                                Not fit
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Fit"
                                                                type="radio" name="category_3_question_1_field[]"
                                                                id="category-3-fit-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-fit-field">
                                                                Fit
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Very fit"
                                                                type="radio" name="category_3_question_1_field[]"
                                                                id="category-3-very-fit-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-very-fit-field">
                                                                Very fit
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <hr class="text-white">

                                                <!-- Question 2: When was the last time you were at your Ideal weight? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg -4 p-2">

                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">2)</span>
                                                            When was the last time you were at your Ideal
                                                            weight?</p>

                                                    </div>
                                                    <div class="col-lg -8 p-2 text-truncate">
                                                        <!-- 
                            Less than a year ago
                            1-2 years ago
                            More than 2 years ago
                            never
                          -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="Less than a year ago" type="radio"
                                                                name="category_3_question_2_field[]"
                                                                id="category-3-less-than-1year-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-less-than-1year-field">
                                                                Less than a year ago
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="1-2 years ago"
                                                                type="radio" name="category_3_question_2_field[]"
                                                                id="category-3-less-between-1_2year-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-less-between-1_2year-field">
                                                                1-2 years ago
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="More than 2 years ago" type="radio"
                                                                name="category_3_question_2_field[]"
                                                                id="category-3-more-than-2year-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-more-than-2year-field">
                                                                More than 2 years ago
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Never"
                                                                type="radio" name="category_3_question_2_field[]"
                                                                id="category-3-never-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-never-field">
                                                                Never
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <hr class="text-white">

                                                <!-- Question 3: What is your body type? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg -4 p-2">

                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">3)</span>
                                                            What is your body type?</p>

                                                    </div>
                                                    <div class="col-lg -8 p-2 text-truncate">
                                                        <!-- 
                            Slim / Slender
                            Ideal
                            Flabby
                            Heavy
                            Obese
                          -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Slim_Slender"
                                                                type="radio" name="category_3_question_3_field[]"
                                                                id="category-3-slim-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-slim-field">
                                                                Slim / Slender
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Ideal"
                                                                type="radio" name="category_3_question_3_field[]"
                                                                id="category-3-ideal-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-ideal-field">
                                                                Ideal
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Flabby"
                                                                type="radio" name="category_3_question_3_field[]"
                                                                id="category-3-flabby-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-flabby-field">
                                                                Flabby
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Heavy"
                                                                type="radio" name="category_3_question_3_field[]"
                                                                id="category-3-heavy-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-heavy-field">
                                                                Heavy
                                                            </label>
                                                        </div>

                                                        <!-- probably worth removing Obsese as an option -->
                                                        <!-- <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="Obese" type="radio" name="category_3_question_3_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Obese
                            </label>
                          </div> -->

                                                    </div>
                                                </div>

                                                <hr class="text-white">

                                                <!-- Question 4: Do you suffer from any joint pain? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg -4 p-2">

                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">4)</span>
                                                            Do you suffer from any joint pain?</p>

                                                    </div>
                                                    <div class="col-lg -8 p-2 text-truncate">
                                                        <!-- 
                        Yes / No
                       -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Yes"
                                                                type="radio" name="category_3_question_4_field[]"
                                                                id="category-3-joint-pain-yes-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-joint-pain-yes-field">
                                                                Yes
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="No" type="radio"
                                                                name="category_3_question_4_field[]"
                                                                id="category-3-joint-pain-no-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-joint-pain-no-field">
                                                                No
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <hr class="text-white">

                                                <!-- Question 5: How active are you in your daily life? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg -4 p-2">

                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">5)</span>
                                                            How active are you in your daily life?</p>

                                                    </div>
                                                    <div class="col-lg -8 p-2 text-truncate">
                                                        <!-- 
                        Not active
                        Slightly active
                        Active
                        Very active
                       -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Not active"
                                                                type="radio" name="category_3_question_5_field[]"
                                                                id="category-3-not-active-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-not-active-field">
                                                                Not active
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Slightly active"
                                                                type="radio" name="category_3_question_5_field[]"
                                                                id="category-3-slightly-active-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-slightly-active-field">
                                                                Slightly active
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Active"
                                                                type="radio" name="category_3_question_5_field[]"
                                                                id="category-3-active-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-active-field">
                                                                Active
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Very active"
                                                                type="radio" name="category_3_question_5_field[]"
                                                                id="category-3-very-active-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-very-active-field">
                                                                Very active
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <hr class="text-white">

                                                <!-- Question 6: How are your energy levels during the day? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg -4 p-2">

                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">6)</span>
                                                            How are your energy levels during the day?</p>

                                                    </div>
                                                    <div class="col-lg -8 p-2 text-truncate">
                                                        <!-- 
                        Stable throughout the day
                        I have energy for half the day / until around lunchtime
                        I always feel sleepy after meals
                       -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="Stable throughout the day" type="radio"
                                                                name="category_3_question_6_field[]"
                                                                id="category-3-energy-level-stable-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-energy-level-stable-field">
                                                                Stable throughout the day
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="I have energy for half the day or until around lunchtime"
                                                                type="radio" name="category_3_question_6_field[]"
                                                                id="category-3-energy-level-half-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-energy-level-half-field">
                                                                I have energy for half the day / until
                                                                around lunchtime
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="I always feel sleepy after meals" type="radio"
                                                                name="category_3_question_6_field[]"
                                                                id="category-3-energy-level-sleepy-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-energy-level-sleepy-field">
                                                                I always feel sleepy after meals
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <hr class="text-white">

                                                <!-- Question 7: How much do you sleep every night? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg -4 p-2">

                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">7)</span>
                                                            How much do you sleep every night?</p>

                                                    </div>
                                                    <div class="col-lg -8 p-2 text-truncate">
                                                        <!-- 
                            More than 8 hours
                            7-8 hours
                            6-7 hours
                            less than 6 hours
                            -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="More than 8 hours" type="radio"
                                                                name="category_3_question_7_field[]"
                                                                id="category-3-sleep-duration-more8hrs-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-sleep-duration-more8hrs-field">
                                                                More than 8 hours
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="7-8 hours"
                                                                type="radio" name="category_3_question_7_field[]"
                                                                id="category-3-sleep-duration-7_8hrs-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-sleep-duration-7_8hrs-field">
                                                                7-8 hours
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="6-7 hours"
                                                                type="radio" name="category_3_question_7_field[]"
                                                                id="category-3-sleep-duration-6_7hrs-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-sleep-duration-6_7hrs-field">
                                                                6-7 hours
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="less than 6 hours" type="radio"
                                                                name="category_3_question_7_field[]"
                                                                id="category-3-sleep-duration-less6hrs-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-sleep-duration-less6hrs-field">
                                                                less than 6 hours
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <hr class="text-white">

                                                <!-- Question 8: What is your daily water intake? -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg -4 p-2">

                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">8)</span>
                                                            What is your daily water intake?</p>

                                                    </div>
                                                    <div class="col-lg -8 p-2 text-truncate">
                                                        <!-- 
                            more than 6 glasses
                            3 to 6 glasses
                            2 glasses
                            I only drink soft-drinks / coffee
                          -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="More than 6 glasses" type="radio"
                                                                name="category_3_question_8_field[]"
                                                                id="category-3-water-intake-more6glasses-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-water-intake-more6glasses-field">
                                                                More than 6 glasses
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="3 to 6 glasses"
                                                                type="radio" name="category_3_question_8_field[]"
                                                                id="category-3-water-intake-3_6glasses-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-water-intake-3_6glasses-field">
                                                                3 to 6 glasses
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="2 glasses"
                                                                type="radio" name="category_3_question_8_field[]"
                                                                id="category-3-water-intake-2glasses-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-water-intake-2glasses-field">
                                                                2 glasses
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="I only drink soft-drinks or coffee" type="radio"
                                                                name="category_3_question_8_field[]"
                                                                id="category-3-water-intake-onlysoftdrink-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-water-intake-onlysoftdrink-field">
                                                                I only drink soft-drinks / coffee
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <hr class="text-white">

                                                <!-- Question 9: Select the type of classes you are looing to do: -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg -4 p-2">

                                                        <p class="fs-5 comfortaa-font align-middle"><span class="fs-2"
                                                                style="color: var(--primary-color);">9)</span>
                                                            Select the type of classes you are looing to do
                                                        </p>

                                                    </div>
                                                    <div class="col-lg -8 p-2 text-truncate">
                                                        <!-- 
                          Cardio
                          Strength
                          HIIT
                          Toning
                          Dance
                          Kickboxing
                          Barre
                          Pilates
                          Meditation
                          Stretch
                          Resistence
                          Yoga
                          Spinning
                          Treadmill
                          -->

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Cardio"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-cardio-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-cardio-field">
                                                                Cardio
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Strength"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-strength-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-strength-field">
                                                                Strength
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="HIIT"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-hiit-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-hiit-field">
                                                                HIIT
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Toning"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-toning-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-toning-field">
                                                                Toning
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Dance_Aerobics"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-dance_aerobics-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-dance_aerobics-field">
                                                                Dance / Aerobics
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Kickboxing"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-kickboxing-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-kickboxing-field">
                                                                Kickboxing
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="default"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-barre-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-barre-field">
                                                                Barre
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Pilates"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-pilates-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-pilates-field">
                                                                Pilates
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Meditation"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-meditation-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-meditation-field">
                                                                Meditation
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4"
                                                                value="Stretch_Resistence" type="checkbox"
                                                                name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-stretch_resistence-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-stretch_resistence-field">
                                                                Stretch / Resistence
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Yoga"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-yoga-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-yoga-field">
                                                                Yoga
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Spinning"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-spinning-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-spinning-field">
                                                                Spinning
                                                            </label>
                                                        </div>

                                                        <div class="form-check text-truncate">
                                                            <input class="form-check-input me-4" value="Treadmill"
                                                                type="checkbox" name="category_3_question_9_field[]"
                                                                id="category-3-classtype-select-treadmill-field">
                                                            <label class="form-check-label p-2"
                                                                for="category-3-classtype-select-treadmill-field">
                                                                Treadmill
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="text-white" style="margin-bottom: 80px;">

                                            <!-- Procession Buttons -->
                                            <div class="comfortaa-font text-center mt-4"
                                                style="margin-bottom: 40px; font-size: 20px;">

                                                <div class="d-grid gap-0 w-100 text-white">
                                                    <span class="rounded-pill p-4"
                                                        style="background-color: var(--secondary-color);">
                                                        One<span style="color: var(--primary-color);">fit</span>.app
                                                    </span>

                                                    <span class="material-icons material-icons-outlined"
                                                        style="color: var(--primary-color);">
                                                        horizontal_rule
                                                    </span>
                                                </div>

                                                <!-- submit btn -->
                                                <div class="d-grid justify-content-center">
                                                    <input id="submit-fitprefs-info-form"
                                                        class="onefit-buttons-style-tahiti p-4 text-center comfortaa-font shadow fw-bold submit-btn"
                                                        style="font-size: 20px !important;" type="submit" value="Save.">
                                                </div>
                                                <!-- ./ submit btn -->

                                                <!-- Procession Buttons -->
                                                <div class="row align-items-center">
                                                    <div class="col-lg py-4 d-grid">
                                                        <!--  gap-2 justify-content-center -->
                                                        <button type="button"
                                                            class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow panel-nav-btn"
                                                            id="goalsetting-back-panel-btn"
                                                            onclick="survey_controller('fitprefs','goalsetting')"
                                                            style="display: none;">
                                                            <div
                                                                class="d-grid gap-2 justify-content-center text-center fw-bold">
                                                                <span class="material-icons material-icons-round"
                                                                    style="font-size: 40px !important; color: var(--primary-color);">
                                                                    arrow_back_ios </span>
                                                                <span>Goal setting.</span>
                                                            </div>

                                                        </button>
                                                    </div>
                                                    <div class="col-lg py-4 d-grid">
                                                        <!--  gap-2 justify-content-center -->
                                                        <button type="button"
                                                            class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow panel-nav-btn"
                                                            id="eu-agreements-next-panel-btn"
                                                            onclick="survey_controller('finish','finish')"
                                                            style="display: none;">
                                                            <div
                                                                class="d-grid gap-2 justify-content-center text-center fw-bold">
                                                                <span class="material-icons material-icons-round"
                                                                    style="font-size: 40px !important; color: var(--primary-color);">
                                                                    check_circle_outline </span>
                                                                <span>Finish.</span>
                                                            </div>

                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- ./ Procession Buttons -->

                                            </div>
                                            <!-- ./ Procession Buttons -->

                                        </form>
                                        <!-- ./ #fitprefs-info-form -->

                                    </div>

                                </div>

                            </div>
                            <div class="tab-pane fade w3-animate-bottom comfortaa-font"
                                id="category-eu-agreements-tab-pane" role="tabpanel"
                                aria-labelledby="category-eu-agreements-tab" tabindex="0">

                                <div class="my-4" id="category-eula-tab-questions-pane">

                                    <div class="p-4 content-panel-border-style shadow"
                                        style="border-radius: 25px; background: #343434;">
                                        <h1 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end"
                                            style="border-radius: 25px; background-color: var(--secondary-color); color: #fff; border-color: var(--primary-color); margin-bottom: 80px !important;">
                                            <span class="material-icons material-icons-round"
                                                style="color: var(--primary-color);">
                                                looks_3
                                            </span>
                                            <span class="comfortaa-font">
                                                <u>Terms of Use</u>
                                            </span>
                                        </h1>

                                        <!-- Terms of Use -->
                                        <div id="terms-container" class="text-white comfortaa-font px-2 mb-4"
                                            style="overflow-y: auto; max-height: 100vh;">
                                            <?php echo $policy_content_terms; ?>
                                        </div>
                                        <!-- ./ Terms of Use -->

                                        <hr class="text-white">

                                        <!-- #policy-info-form -->
                                        <!--<?php echo $output; ?>-->
                                        <!-- ../../scripts/php/main_app/data_management/system_admin/user_registration/submit -->
                                        <form id="tou-policy-info-form"
                                            action="../../scripts/php/main_app/data_management/system_admin/user_registration/submit/policy_acceptance_submit.php?&agree_tou=true"
                                            method="post" autocomplete="off">
                                            <!-- user id hidden -->
                                            <div class="form-group my-4">
                                                <input class="form-control-text-input p-4" type="hidden"
                                                    name="terms_profile_id" id="user-id-policy-terms"
                                                    value="<?php echo $current_user_prof_id; ?>" placeholder="user id"
                                                    required readonly />
                                            </div>
                                            <!-- ./ user id hidden -->

                                            <!-- terms policy ref hidden -->
                                            <div class="form-group my-4">
                                                <input class="form-control-text-input p-4" type="hidden"
                                                    name="terms_policy_ref" id="terms-policy-ref"
                                                    value="<?php echo $policy_ref_terms; ?>" readonly
                                                    placeholder="Terms of Use Policy Reference Number" required />
                                            </div>
                                            <!-- ./ terms policy ref hidden -->

                                            <!-- terms policy name hidden -->
                                            <div class="form-group my-4">
                                                <input class="form-control-text-input p-4" type="hidden"
                                                    name="terms_policy_name" id="terms-policy-name"
                                                    value="<?php echo $policy_name_terms; ?>" readonly
                                                    placeholder="Terms of Use Policy Name" required />
                                            </div>
                                            <!-- ./ terms policy name hidden -->

                                            <!-- terms policy date hidden -->
                                            <div class="form-group my-4">
                                                <input class="form-control-text-input p-4" type="hidden"
                                                    name="terms_policy_date" id="terms-policy-date"
                                                    value="<?php echo $policy_date_terms; ?>" readonly
                                                    placeholder="Terms of Use Policy Effective Date" required />
                                            </div>
                                            <!-- ./ terms policy date hidden -->

                                            <div class="d-grid gap-4 justify-content-center">
                                                <div class="form-check align-items-center align-middle">
                                                    <!-- form-check-inline form-switch -->
                                                    <input class="form-check-input me-4" value="accepted-terms"
                                                        type="checkbox" role="switch" name="agree_terms"
                                                        id="agree-terms" onchange="termsAcceptanceState()">
                                                    <label class="form-check-label p-2 align-middle pt-2"
                                                        for="agree-terms">Do you agree to the
                                                        above Terms of Use?</label>
                                                </div>
                                            </div>

                                            <!-- submit btn -->
                                            <!-- <div class="d-block justify-content-center">
                        <input id="submit-policy-info-form" style="font-size: 40px !important;" class="onefit-buttons-style-tahiti p-4 text-center comfortaa-font shadow" type="submit" value="submit">
                      </div> -->

                                            <hr class="text-white" style="margin-bottom: 80px;">

                                            <!-- Procession Buttons -->
                                            <div class="comfortaa-font text-center mt-4"
                                                style="margin-bottom: 40px; font-size: 20px;">
                                                <div class="d-grid gap-0 w-100 text-white">
                                                    <span class="rounded-pill p-4"
                                                        style="background-color: var(--secondary-color);">
                                                        One<span style="color: var(--primary-color);">fit</span>.app
                                                    </span>

                                                    <span class="material-icons material-icons-outlined"
                                                        style="color: var(--primary-color);">
                                                        horizontal_rule
                                                    </span>
                                                </div>
                                                <div class="row align-items-center">
                                                    <div class="col-md py-4 d-grid">
                                                        <!--  gap-2 justify-content-center -->

                                                        <!-- Terms of Use Acceptence Message -->
                                                        <div id="terms-acceptence-msg">
                                                            <div class="d-grid gap-2 text-center">
                                                                <div class="d-flex text-center justify-content-center">
                                                                    <span
                                                                        class="material-icons material-icons-round p-4"
                                                                        style="font-size: 80px !important; background-color: #c20000; color: #fff; border-radius: 25px;">
                                                                        rule </span>
                                                                </div>

                                                                <span>Please accept the Terms of Use to
                                                                    complete your profile.</span>
                                                            </div>
                                                        </div>
                                                        <!-- ./ Terms of Use Acceptence Message -->

                                                        <button form="tou-policy-info-form"
                                                            class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow"
                                                            type="submit"
                                                            class="my-4 p-4 onefit-buttons-style-dark btn-lg"
                                                            id="final-submit-data-btn" style="display: none;">
                                                            <!--  onclick="survey_controller('fwd','finish')" -->
                                                            <div
                                                                class="d-grid gap-2 justify-content-center text-center fw-bold">
                                                                <span class="material-icons material-icons-round"
                                                                    style="font-size: 40px !important; color: var(--primary-color);">
                                                                    workspace_premium </span>
                                                                <span>Lets Go.</span>
                                                            </div>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ./ Procession Buttons -->

                                        </form>
                                        <!-- ./ #policy-info-form -->

                                        <script>
                                        function termsAcceptanceState() {
                                            var touAgreementState = document.getElementById("agree-terms");
                                            var submitDataBtn = document.getElementById(
                                                "final-submit-data-btn");
                                            var termsAcceptenceMsg = document.getElementById(
                                                "terms-acceptence-msg");

                                            // alert("Check State: " + eulaAgreementState.checked);

                                            if (touAgreementState.checked) {
                                                submitDataBtn.style.display = "block";
                                                termsAcceptenceMsg.style.display = "none";

                                            } else {
                                                submitDataBtn.style.display = "none";
                                                termsAcceptenceMsg.style.display = "block";

                                            }
                                        }
                                        </script>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- ./ form category tabs -->

                </div>

            </div>
        </div>
    </div>
    <!-- ./ Main Body -->

    <!-- Modals -->
    <!-- Button trigger modal>>>>>>>>>> Tab Upload Modal -->
    <button id="toggleTabProfileImgModalBtn" type="button" class="btn btn-primary" data-bs-toggle="modal"
        data-bs-target="#tabProfileImgModal" hidden>
        Launch #tabProfileImgModal</button>

    <!-- >>>>>>>>>> Tab Navigation Modal -->
    <div class="modal fade" id="tabProfileImgModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="tabProfileImgModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content feature-tab-nav-content content-panel-border-stylez">
                <!-- style="border-bottom: #ffa500 5px solid;" -->
                <div class="modal-header border-0">
                    <h5 class="modal-title align-middle" id="tabProfileImgModalLabel">
                        <span class="material-icons material-icons-round align-middle"
                            style="color: var(--primary-color);">
                            account_circle
                        </span>
                        <span class=" align-middle">Upload your profle picture and banner image</span>
                    </h5>
                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="material-icons material-icons-round"> close </span>
                    </button>
                </div>
                <hr class="text-white m-0z">
                <div class="modal-body border-0" style="overflow-x: hidden">
                    <style>
                    .form-control {
                        display: block;
                        width: 100%;
                        padding: 0.375rem 0.75rem;
                        font-size: 1rem;
                        font-weight: 400;
                        line-height: 1.5;
                        color: #212529;
                        background-color: #fff;
                        background-clip: padding-box;
                        border: 10px solid #fff;
                        -webkit-appearance: none;
                        -moz-appearance: none;
                        appearance: none;
                        border-radius: 0.50rem;
                        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                    }
                    </style>

                    <h1 class="text-center my-4">
                        <span class="material-icons material-icons-round align-middle"
                            style="color: var(--primary-color);">add_a_photo</span>
                        <span class="align-middle">Profle Picture</span><span
                            style="color: var(--primary-color);">.</span>
                    </h1>

                    <!-- image preview -->
                    <div class="in-div-button-container text-center d-grid justify-content-center"
                        style="max-width: none !important;">

                        <div class="d-grid justify-content-center">
                            <img src="../../media/profiles/<?php echo $current_user_prof_img; ?>"
                                id="prof-pic-img-preview" class="img-fluid shadow my-4"
                                style="border-radius: 25px; border-bottom: #ffa500 solid 5px;" alt="placeholder">
                        </div>


                        <button class="onefit-buttons-style-dark shadow in-div-btn text-center p-3 m-4 shadow"
                            onclick="launchProfileImgsEditor()">
                            <div class="d-grid align-items-center">
                                <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                    restart_alt
                                </span>
                                <span class="comfortaa-font" style="font-size: 10px;">Reset.</span>
                            </div>
                        </button>

                    </div>
                    <!-- ./ image preview -->

                    <div class="d-grid justify-content-center">
                        <form class="d-grid justify-content-center" method="post" id="uploadProfileImgForm"
                            enctype="multipart/form-data" action="../upload/prof-img-upload.php">
                            <label for="profpicformFileLg" class="form-label comfortaa-font text-center">Choose an
                                image.</label>
                            <input class="form-control form-control-lg" id="profpicformFileLg" name="profpicformFileLg"
                                type="file">
                            <input id="submit-profpicformFileLg" type="submit" value="submit" hidden aria-hidden="true">
                        </form>

                        <!-- upload process spinner -->
                        <div class="d-grid justify-content-center mt-4">
                            <div id="prof-img-spinner text-warning" role="status" class="spinner-border text-center"
                                style="width: 3rem; height: 3rem; display: none;" role="status">
                                <span class="visually-hidden">uploading profile image</span>
                            </div>

                        </div>
                        <!-- upload process spinner -->
                    </div>

                    <hr class="text-white" style="margin: 40px 0;">

                    <h1 class="text-center my-4">
                        <span class="material-icons material-icons-round align-middle"
                            style="color: var(--primary-color);">wallpaper</span>
                        <span class="align-middle">Profle Banner</span><span
                            style="color: var(--primary-color);">.</span>
                    </h1>

                    <!-- image preview -->
                    <div id="prof-banner-img-preview" class="shadow-lg my-4"
                        style="border-bottom: #ffa500 solid 5px; border-radius: 25px; height: 400px; width: 100%; overflow: hidden; background-image: url('../../media/profiles/<?php echo $current_user_prof_banner; ?>'); background-position: center; background-attachment: local; background-clip: content-box; background-size: cover">
                    </div>
                    <!-- ./ image preview -->

                    <div class="d-grid justify-content-center" style="margin-bottom: 40px;">
                        <form class="d-grid justify-content-center" method="post" id="uploadBannerImgForm"
                            enctype="multipart/form-data" action="../upload/prof-banner-upload.php">
                            <label for="profbannerformFileLg" class="form-label comfortaa-font text-center">Choose an
                                image.</label>
                            <input class="form-control form-control-lg" id="profbannerformFileLg"
                                name="profbannerformFileLg" type="file">
                            <input id="submit-profbannerformFileLg" type="submit" value="submit" hidden
                                aria-hidden="true">
                        </form>

                        <!-- upload process spinner -->
                        <div class="d-grid justify-content-center mt-4">
                            <div id="banner-img-spinner text-warning" role="status" class="spinner-border text-center"
                                style="width: 3rem; height: 3rem; display: none;" role="status">
                                <span class="visually-hidden">uploading banner image</span>
                            </div>
                        </div>
                        <!-- upload process spinner -->
                    </div>

                </div>

                <!--<hr class="text-white m-0z">
        <div class="modal-footer border-0 d-inline-block">
          <div class="d-gridz gap-2">
            <button
              class="onefit-buttons-style-dark fs-5 p-4 fw-bold my-4 px-4 pt-4 text-center comfortaa-font border-0 shadow"
              type="button" data-bs-toggle="collapse" data-bs-target="#tab-nav-social-quickpost" aria-expanded="false"
              aria-controls="tab-nav-social-quickpost"><i class="fas fa-paper-plane"></i> | <span
                style="color: #fff !important">One</span><span
                style="color: var(--primary-color) !important">fit</span>.Social</button>
          </div> -->
            </div>
        </div>
    </div>
    <!-- ./ >>>>>>>>>> Tab Navigation Modal -->
    <!-- ./ Modals -->

    <script>
    let aboutyouFormSubmitStatus = false;
    let goalsettingFormSubmitStatus = false;
    let fitprefsFormSubmitStatus = false;
    let eulaPolicyFormSubmitStatus = false;
    let touPolicyFormSubmitStatus = false;

    // function to fetch user data from database: loop through array of form ids and fetch data from database
    function fetchUserData() {

        // function will controll if form submit buttons are disabled or enabled
        function fetchUserDataFromDB(formId) {
            // variables
            let scriptUrl, formName;

            // toggle display of form submit buttons, panel navigation buttons and input fields container
            function managePanelElements(formId, status, response) {
                response = response ? response : "";

                if (status === true) {
                    // set response html in $(formId + " .info-list") and show it
                    $(formId + " .info-list").html(response);
                    $(formId + " .info-list").show();

                    // hide .input-section in $(formId)
                    $(formId + " .input-section").hide();

                    // jquery hide button with "submit-btn" class in $(formId)
                    $(formId + " .submit-btn").hide();
                    // jquery show button with "panel-nav-btn" class in $(formId) 
                    $(formId + " .panel-nav-btn").show();
                    // set all inputs to readonly state
                    $(formId + " input textarea").attr("readonly", true);
                    // set all selects to return false onchange
                    $(formId + " select").attr("onchange", "return false;");

                    // show icon on corresponding button on [ 2. create your profile panel controller ]
                    switch (formId) {
                        case "#aboutyou-info-form":
                            $("#aboutyou-confirmation-icon").show();
                            // set submit status variable to true
                            aboutyouFormSubmitStatus = true;
                            break;
                        case "#goalsetting-info-form":
                            $("#goalsetting-confirmation-icon").show();
                            // set submit status variable to true
                            goalsettingFormSubmitStatus = true;
                            break;
                        case "#fitprefs-info-form":
                            $("#fitprefs-confirmation-icon").show();
                            // set submit status variable to true
                            fitprefsFormSubmitStatus = true;
                            break;

                        default:
                            break;
                    }
                } else {
                    // hide .info-list in $(formId)
                    $(formId + " .info-list").hide();

                    // show .input-section in $(formId)
                    $(formId + " .input-section").show();

                    // jquery show button with "submit-btn" class in $(formId)
                    $(formId + " .submit-btn").show();
                    // jquery hide button with "panel-nav-btn" class in $(formId) 
                    $(formId + " .panel-nav-btn").hide();

                    // hide icon on corresponding button on [ 2. create your profile panel controller ]
                    switch (formId) {
                        case "#aboutyou-info-form":
                            $("#aboutyou-confirmation-icon").hide();
                            // set submit status variable to false
                            aboutyouFormSubmitStatus = false;
                            break;
                        case "#goalsetting-info-form":
                            $("#goalsetting-confirmation-icon").hide();
                            // set submit status variable to false
                            goalsettingFormSubmitStatus = false;
                            break;
                        case "#fitprefs-info-form":
                            $("#fitprefs-confirmation-icon").hide();
                            // set submit status variable to false
                            fitprefsFormSubmitStatus = false;
                            break;

                        default:
                            break;
                    }
                }
            }

            // assign formName and scriptUrl based on formId
            switch (formId) {
                case "#aboutyou-info-form":
                    formName = "aboutyou";
                    scriptUrl =
                        "../../scripts/php/main_app/data_management/system_admin/user_registration/profile_build_controller.php?panel=aboutyou&secure=" +
                        SECURE_REQUEST_PWD_ENCODED;
                    // console.log("SecureInfo - encoded url" + scriptUrl);
                    break;
                case "#goalsetting-info-form":
                    formName = "goalsetting";
                    scriptUrl =
                        "../../scripts/php/main_app/data_management/system_admin/user_registration/profile_build_controller.php?panel=goalsetting&secure=" +
                        SECURE_REQUEST_PWD_ENCODED;
                    // console.log("SecureInfo - encoded url" + scriptUrl);
                    break;
                case "#fitprefs-info-form":
                    formName = "fitprefs";
                    scriptUrl =
                        "../../scripts/php/main_app/data_management/system_admin/user_registration/profile_build_controller.php?panel=fitprefs&secure=" +
                        SECURE_REQUEST_PWD_ENCODED;
                    // console.log("SecureInfo - encoded url" + scriptUrl);
                    break;

                default:
                    return false;
                    break;
            }

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myResponse = this.responseText;
                    if (myResponse === false) {
                        // console.log("SecureInfo - No Data OR Error occured, responseText: " + myResponse);
                        // call managePanelElements(formId, status) function
                        managePanelElements(formId, false, null);
                        // do nothing ?
                    } else {
                        // console.log("SecureInfo - Existing Data, responseText: " + myResponse);
                        // call togglePanelProcessionButtons(formId, status) function
                        managePanelElements(formId, true, myResponse);
                    }
                } else {
                    console.log("AJAX: " + this.status + " - " + this.statusText);
                }
            };
            xhttp.open("GET", scriptUrl, true);
            xhttp.send();
        }
        // *** end of function: fetchUserDataFromDB(formId) ***

        // variables
        const formIds = ["#aboutyou-info-form", "#goalsetting-info-form", "#fitprefs-info-form"];
        let currentUserProfileId = localStorage.getItem("registration_profile_id");
        const SECURE_REQUEST_PWD = "$2y$10$DH00KRtrX9Qh/.R9vc/YhO/Af9QkJX05sfFaeW2h0PST3ualPnSgC"
        // url encode SECURE_REQUEST_PWD
        const SECURE_REQUEST_PWD_ENCODED = encodeURIComponent(SECURE_REQUEST_PWD);

        formIds.forEach(formId => {
            fetchUserDataFromDB(formId);
        });

        // for (var i = 0; i < formIds.length; i++) {
        //   var formId = formIds[i];

        //   fetchUserDataFromDB(formId);
        // }
    }


    function storeCurrentUserIDs(user_id, profile_id) {
        var currentUserId = user_id;
        var currentProfileId = profile_id;

        localStorage.setItem("registration_user_id", currentUserId);
        localStorage.setItem("registration_profile_id", currentProfileId);
    }

    function toggleLoadCurtain() {
        var curtain = document.getElementById("LoadCurtain");
        curtain.style.display = "none";
    }

    function launchProfileImgsEditor() {
        var profileImgModalToggleBtn = document.getElementById("toggleTabProfileImgModalBtn");

        profileImgModalToggleBtn.click();
    }

    function proceedToMain() {
        const eulaCurtain = document.getElementById("eula-curtain");

        eulaCurtain.style.display = "none";

        // showSnackbar("EULA Accepted");
    }

    function switchTab(tab) {
        // aboutyou
        // goalsetting
        // fitprefs
        // ctgryselect
        // mainfrmwindow

        // toggle-aboutyou-check-icon
        // toggle-goalsetting-check-icon
        // toggle-fitprefs-check-icon

        if (tab == "aboutyou") {
            // about you
            document.getElementById("tab-title-header-display").innerHTML =
                `<h5 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end sticky-top" style="border-radius: 25px; background-color: var(--secondary-color);color: var(--text-color) !important;border-color: var(--primary-color) !important;"> About You </h5>`; //"About You";
            document.getElementById("category-about-you-tab").click();

        } else if (tab == "goalsetting") {
            // goal setting
            document.getElementById("tab-title-header-display").innerHTML =
                `<h5 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end sticky-top" style="border-radius: 25px; background-color: var(--secondary-color);color: var(--text-color) !important;border-color: var(--primary-color) !important;"> Goal Setting </h5>`; //"Goal Setting";
            document.getElementById("category-goal-setting-tab").click();

        } else if (tab == "fitprefs") {
            // fitness preferences
            document.getElementById("tab-title-header-display").innerHTML =
                `<h5 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end sticky-top" style="border-radius: 25px; background-color: var(--secondary-color);color: var(--text-color) !important;border-color: var(--primary-color) !important;"> Fitness Preferences </h5>`; //"Fitness Preferences";
            document.getElementById("category-fitness-prefs-tab").click();

        } else if (tab == "finish" || tab == "eu-agreements") {
            // end-user agreements
            document.getElementById("tab-title-header-display").innerHTML =
                `<h5 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end sticky-top" style="border-radius: 25px; background-color: var(--secondary-color);color: var(--text-color) !important;border-color: var(--primary-color) !important;"> Terms of Use Policy </h5>`; //"Policy / Licence Agreements";
            document.getElementById("category-eu-agreements-tab").click();
        } else if (tab == "mainfrmwindow") {
            // toggle main form window
            // alert("toggle-main-form-window");
            document.getElementById("toggle-main-form-window").click();
            // toggle category selectors
            document.getElementById("toggle-category-selectors").click();

            document.getElementById('main-form-window').scrollIntoView();
        }
    }

    function survey_controller(fromtab, tabpanel) {
        var main = document.getElementById("main-container");

        var switchToTab = tabpanel;
        // var isValid = false;

        // switch to requested tab only
        switchTab(switchToTab);

        // validate this tabs form (JQuery validation): 
        // (bug) method always returns true even for invalid forms 
        // function validateMyForm(tabpanel) {
        //   // input validation - check if all required fields have inputs
        //   var proceedTabSwitch;

        //   if (tabpanel == "aboutyou") {
        //     proceedTabSwitch = $.validateForm("aboutyou-info-form");
        //     console.log("aboutyou proceed: " + proceedTabSwitch);
        //   } else if (tabpanel == "goalsetting") {
        //     proceedTabSwitch = $.validateForm("goalsetting-info-form");
        //     console.log("goalsetting proceed: " + proceedTabSwitch);
        //   } else if (tabpanel == "fitprefs") {
        //     proceedTabSwitch = $.validateForm("fitprefs-info-form");
        //     console.log("fitprefs proceed: " + proceedTabSwitch);
        //   } else if (tabpanel == "finish") {
        //     proceedTabSwitch = $.validateForm("tou-policy-info-form");
        //     console.log("finish proceed: " + proceedTabSwitch);
        //   }

        //   if (proceedTabSwitch === true) {
        //     // console log validation success message
        //     console.log("form validation success: for tab[ " + tabpanel + " ] proceed: [ " + proceedTabSwitch + " ]")
        //     return true
        //   } else {
        //     // console log validation error message
        //     console.log("form validation error: for tab[ " + tabpanel + " ] proceed: [ " + proceedTabSwitch + " ]")
        //     return false;
        //   }
        // }

        // isValid = validateMyForm(fromtab); // JQuery validation call

        // toggle confirmation icons
        // switch (fromtab) {
        //   case "aboutyou":
        //     // if successfull then show the corresponding confirmation icon
        //     if (isValid) {
        //       document.getElementById("aboutyou-confirmation-icon").style.display = "block";
        //       // switch to tab
        //       switchTab(switchToTab);
        //     } else {
        //       showSnackbar("About You: Please fill out all required fields.");
        //     }
        //     break;
        //   case "goalsetting":
        //     // if successfull then show the corresponding confirmation icon
        //     if (isValid) {
        //       document.getElementById("goalsetting-confirmation-icon").style.display = "block";
        //       // switch to tab
        //       switchTab(switchToTab);
        //     } else {
        //       showSnackbar("Goal Setting: Please fill out all required fields.");
        //     }
        //     break;
        //   case "fitprefs":
        //     // if successfull then show the corresponding confirmation icon
        //     if (isValid) {
        //       document.getElementById("fitprefs-confirmation-icon").style.display = "block";
        //       // switch to tab
        //       switchTab(switchToTab);
        //     } else {
        //       showSnackbar("Fitness Preferences: Please fill out all required fields.");
        //     }
        //     break;
        //   case "finish":
        //     // if successfull then show the corresponding confirmation icon
        //     if (isValid) {
        //       document.getElementById("fitprefs-confirmation-icon").style.display = "block";
        //       // switch to tab
        //       switchTab("eu-agreements");
        //     } else {
        //       showSnackbar("Fitness Preferences - Finish: Please fill out all required fields.");
        //     }
        //     break;

        //   default:
        //     console.log("Unknown tab (from): " + fromtab);
        //     break;
        // }

        // ------------------ AJAX ------------------

        // var xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function () {
        //   if (this.readyState == 4 && this.status == 200) {
        //     main.innerHTML = this.responseText;
        //   }
        // };
        // xhttp.open("GET", "../scripts/php/userprofile/user_reg_controller.php?panel=" + panelnum, true);
        // xhttp.send();
        /*xhttp.open("POST", "../scripts/php/userprofile/user_reg_controller.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("panel=" + panelnum);*/
    };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>