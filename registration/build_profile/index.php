<?php
session_start();
require("../../scripts/php/config.php");
require_once("../../scripts/php/functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (!isset($_GET['uid'])) die("Fatal Error: User ID not set.");
// declare variables
$get_current_user_id = $get_current_user_profile_id = null;

// assign get param values
$get_current_user_id = sanitizeMySQL($dbconn, $_GET['uid']);
if (isset($_GET['pid'])) {
  $get_current_user_profile_id = sanitizeMySQL($dbconn, $_GET['pid']);
}

try {
  $query = "SELECT * FROM `users` WHERE `user_id` = $get_current_user_id";

  $result = $dbconn->query($query);

  if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

  $rows = $result->num_rows;
  //echo $rows."<br>";
  $current_user_profile_id = $get_current_user_profile_id;
  $current_user_id =
    $current_user_name = $current_user_surname =
    $current_user_email = $current_user_contact =
    $current_user_dob = $current_user_gender =
    $current_user_race = $current_user_nation = "Information unavailable.";

  $current_user_prof_img = $current_user_prof_banner = "";

  $policy_id =
    $policy_ref =
    $policy_type =
    $policy_name =
    $policy_content =
    $policy_date =
    $administrators_username = null;

  if ($rows <= 0) {
    //notify user that a record cannot be found
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
  $query = "SELECT `profile_image_url`,`profile_banner_url` FROM `general_user_profiles` WHERE `users_username` = '$current_user_username'";

  $result = $dbconn->query($query);

  if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

  $rows = $result->num_rows;

  if ($rows <= 0) {
    //notify user that a record cannot be found
    echo '<div class="alert alert-danger p-4 text-start" role="alert" aria-hidden="true">Error: No user profile information found.</div>';
  } else {
    for ($j = 0; $j < $rows; ++$j) {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $current_user_prof_img = htmlspecialchars($row['profile_image_url']);
      $current_user_prof_banner = htmlspecialchars($row['profile_banner_url']);
    }
  }

  $result = null;

  // get latest policy content using policy_date
  $query = "SELECT * FROM `app_policies` ORDER BY `policy_date` DESC LIMIT 1";

  $result = $dbconn->query($query);

  if (!$result) die("A Fatal Error has occured. Please reload the page, and if the problem persists, please contact the system administrator.");

  $rows = $result->num_rows;

  if ($rows <= 0) {
    //notify user that a record cannot be found
    echo '<div class="alert alert-danger p-4 text-start" role="alert" aria-hidden="true">Error: No policy content found.</div>';
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
        //  "Terms of Service"
        $policy_content_tou = $policy_content;
      } else if ($policy_type == "eula") {
        // "End User License Agreement"
        $policy_content_eula = $policy_content;
      } else if ($policy_type == "privacy") {
        // "Privacy Policy"
        $policy_content_privacy = $policy_content;
      }
    }
  }

  // $result = null;
  $result = null;
  $dbconn->close();
} catch (\Throwable $th) {
  die("Exepction error: $th");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create your Profile | Onefit.app | OnefitNet &copy; 2022</title>

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
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
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
        $("#main-form-window-scroll-container").animate({ // [document.documentElement, document.body]
          scrollTop: $("#user-welcome-header").offset().top
        }, 2000);
      });

      // #aboutyou-back-panel-btn => #category-about-you-tab-pane
      $("#aboutyou-back-panel-btn").click(function() {
        $("#main-form-window-scroll-container").animate({ //[document.documentElement, document.body]
          scrollTop: $("#user-welcome-header").offset().top
        }, 2000);
      });

      // #fitprefs-next-panel-btn => #category-fitness-prefs-tab-pane
      $("#fitprefs-next-panel-btn").click(function() {
        $("#main-form-window-scroll-container").animate({ // [document.documentElement, document.body]
          scrollTop: $("#user-welcome-header").offset().top
        }, 2000);
      });

      // #eu-agreements-next-panel-btn => #category-eu-agreements-tab-pane
      $("#eu-agreements-next-panel-btn").click(function() {
        $("#main-form-window-scroll-container").animate({ // [document.documentElement, document.body]
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
      $("#uploadProfileImgForm").submit(function(e) {
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
                var imgSrcStr = str.split('[').pop().split(']')[0];

                var user_media_folder = "../media/profile/<?php echo $current_user_username; ?>/profile_img/";
                // "../upload/"
                $("#prof-pic-img-preview").attr("src", user_media_folder + imgSrcStr);
              } else {
                console.log("Profile Image Uploaded Process Completed.");
                console.log("Response: " + response);
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              $('#prof-img-spinner').hide();
              console.log("Profile Image Upload Exception: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
          });
        }, 1000);
        e.stopImmediatePropagation();
        return false;
      });

      // banner images upload ajax jquery
      $("#uploadBannerImgForm").submit(function(e) {
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
                var imgSrcStr = str.split('[').pop().split(']')[0];

                var user_media_folder = "../media/profile/<?php echo $current_user_username; ?>/profile_banner/";

                // set the background image 
                $("#prof-banner-img-preview").css("background-image", "url('" + user_media_folder + imgSrcStr + "')") // .attr("src", imgSrcStr);
              } else {
                console.log("Banner Image Uploaded Process Completed.");
                console.log("Response: " + response);
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              $('#banner-img-spinner').hide();
              console.log("Profile Image Upload Exception: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
          });
        }, 1000);
        e.stopImmediatePropagation();
        return false;
      });
      // ./ banner images upload ajax jquery


      // ajax: submit aboutyou data
      $("#aboutyou-info-form").submit(function(e) {
        e = e || window.event;
        e.preventDefault();

        var form_data = new FormData($('#aboutyou-info-form')[0]);
        setTimeout(function() {
          $.ajax({
            type: 'POST',
            url: '../../scripts/php/main_app/data_management/system_admin/user_registration/submit/aboutyou_submit.php',
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data: form_data,
            beforeSend: function() {
              // do something
              console.log("BeforeSend: submitting aboutyou form");
            },
            success: function(response) {
              // do something
              console.log("Success Response: " + response);
              $('#aboutyou-confirmation-icon').html = `<span class="material-icons material-icons-round" style="color: var(--green) !important"> check_circle </span>`;
              $('#aboutyou-confirmation-icon').show();
              // update the Form Status variables to reflect success status
              aboutyouFormSubmitStatus = true;
            },
            error: function(xhr, ajaxOptions, thrownError) {
              // do something
              console.log("Error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              $('#aboutyou-confirmation-icon').html = `<span class="material-icons material-icons-round" style="color: var(--red) !important"> error </span>`;
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
      $("#goalsetting-info-form").submit(function(e) {
        e = e || window.event;
        e.preventDefault();

        var form_data = new FormData($('#goalsetting-info-form')[0]);
        setTimeout(function() {
          $.ajax({
            type: 'POST',
            url: '../../scripts/php/main_app/data_management/system_admin/user_registration/submit/goalsetting_submit.php',
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data: form_data,
            beforeSend: function() {
              // do something
              console.log("BeforeSend: submitting goalsetting form");
            },
            success: function(response) {
              // do something
              console.log("Success Response: " + response);
              $('#goalsetting-confirmation-icon').html = `<span class="material-icons material-icons-round" style="color: var(--green) !important"> check_circle </span>`;
              $('#goalsetting-confirmation-icon').show();
              // update the Form Status variables to reflect success status
              goalsettingFormSubmitStatus = true;
            },
            error: function(xhr, ajaxOptions, thrownError) {
              // do something
              console.log("Error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              $('#goalsetting-confirmation-icon').html = `<span class="material-icons material-icons-round" style="color: var(--red) !important"> error </span>`;
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
      $("#fitprefs-info-form").submit(function(e) {
        e = e || window.event;
        e.preventDefault();

        var form_data = new FormData($('#fitprefs-info-form')[0]);
        setTimeout(function() {
          $.ajax({
            type: 'POST',
            url: '../../scripts/php/main_app/data_management/system_admin/user_registration/submit/fitprefs_submit.php',
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data: form_data,
            beforeSend: function() {
              // do something
              console.log("BeforeSend: submitting fitprefs form");
            },
            success: function(response) {
              // do something
              console.log("Success Response: " + response);
              $('#fitprefs-confirmation-icon').html = `<span class="material-icons material-icons-round" style="color: var(--green) !important"> check_circle </span>`;
              $('#fitprefs-confirmation-icon').show();
              // update the Form Status variables to reflect success status
              fitprefsFormSubmitStatus = true;
            },
            error: function(xhr, ajaxOptions, thrownError) {
              // do something
              console.log("Error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              $('#fitprefs-confirmation-icon').html = `<span class="material-icons material-icons-round" style="color: var(--red) !important"> error </span>`;
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
      $("#eula-policy-info-form").submit(function(e) {
        e = e || window.event;
        e.preventDefault();

        // get and assign user id from localstorage
        var user_id = localStorage.getItem("registration_user_id");

        var form_data = new FormData($('#eula-policy-info-form')[0]);
        setTimeout(function() {
          $.ajax({
            type: 'POST',
            url: '../../scripts/php/main_app/data_management/system_admin/user_registration/submit/policy_acceptance_submit.php?user_id=' + user_id + '&agree_eula=true',
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data: form_data,
            beforeSend: function() {
              // do something
              console.log("BeforeSend: submitting End-User License Agreement (EULA) Policy acceptance form | user_id: " + user_id);
            },
            success: function(response) {
              // do something
              console.log("Success Response: " + response);

              // update the Form Status variables to reflect success status
              eulaPolicyFormSubmitStatus = true;

              // notify user that data was submitted by showing snackbar
              showSnackbar("<workspace_premium>  EULA Accepted.", "alert_success");
              proceedToMain();
            },
            error: function(xhr, ajaxOptions, thrownError) {
              // do something
              console.log("Error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              // update the Form Status variables to reflect error status
              eulaPolicyFormSubmitStatus = false;
              // notify user that data could not be submitted by showing snackbar
              showSnackbar("<error> Error: EULA Acceptence could not be saved. Check console.", "alert_error");
              alert("Error: EULA Acceptence could not be saved. Check console.");
            }
          });
        }, 1000);

        e.stopImmediatePropagation();
        return false;
      });

      // ajax: submit user tou policy acceptance data
      $("#tou-policy-info-form").submit(function(e) {
        e = e || window.event;
        e.preventDefault();

        // get and assign user id from localstorage
        var user_id = localStorage.getItem("registration_user_id");

        var form_data = new FormData($('#tou-policy-info-form')[0]);
        setTimeout(function() {
          $.ajax({
            type: 'POST',
            url: '../../scripts/php/main_app/data_management/system_admin/user_registration/submit/policy_acceptance_submit.php?user_id=' + user_id + '&agree_tou=true',
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data: form_data,
            beforeSend: function() {
              // do something
              console.log("BeforeSend: submitting Terms of Use (TOU) Policy acceptance form");
            },
            success: function(response) {
              // do something
              console.log("Success Response: " + response);

              // update the Form Status variables to reflect success status
              touPolicyFormSubmitStatus = true;

              var formNotSubmittedString = "";

              // check if all forms have been submitted, if not notify user
              if (eulaPolicyFormSubmitStatus === false || aboutyouFormSubmitStatus === false || fitprefsFormSubmitStatus === false || goalsettingFormSubmitStatus === false || touPolicyFormSubmitStatus === false) {
                if (eulaPolicyFormSubmitStatus === false) {
                  formNotSubmittedString += "End-User License Agreement (EULA) Policy Acceptance Form, ";
                }
                if (touPolicyFormSubmitStatus === false) {
                  formNotSubmittedString += "Terms of Use (TOU) Policy Acceptance Form, ";
                }
                if (aboutyouFormSubmitStatus === false) {
                  formNotSubmittedString += "About You Form, ";
                }
                if (goalsettingFormSubmitStatus === false) {
                  formNotSubmittedString += "Goal Setting Form, ";
                }
                if (fitprefFormSubmitStatus === false) {
                  formNotSubmittedString += "Fitness Preferences Form, ";
                }

                // notify user that data was not submitted by showing alert
                alert("Some of your information has not been submitted. Please check the " + formNotSubmittedString + " provide your information and click the Save button.");

                // notify user that data was not submitted by showing snackbar
                showSnackbar("<error>  Some of your information has not been submitted. Please check the " + formNotSubmittedString + " provide your information and click the Save button.", "alert_error");
                return false;
              } else {
                // notify user that data was submitted by showing snackbar
                showSnackbar("<check_circle> Your Profile has been created successfully.", "alert_success");

                window.location.href = "complete/";
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              // do something
              console.log("Error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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

      // final submission, validate all forms and submit each if all forms are valid
      $(function() {
        $("#final-submit-data-btn").click(function() {
          console.log("Final submit btn clicked");

          // validate all tab forms and submit each if all forms are valid
          const formsArray = [
            "#eula-policy-info-form",
            "#aboutyou-info-form",
            "#goalsetting-info-form",
            "#fitprefs-info-form",
            "#tou-policy-info-form"
          ];

          var isValid = true;

          formsArray.forEach(formid => {
            switch (formid) {

              case "#eula-policy-info-form":
                isValid = $.validateForm(formid);
                if (isValid) {
                  console.log("Success: EULA form is valid");
                  // click the form submit button
                  // $("#submit-eula-policy-info-form").click();
                } else {
                  console.log("Success: EULA form is not valid");
                  showSnackbar("Alert: EULA form is not valid", "danger");
                  // return false;
                }
                break;
              case "#aboutyou-info-form":
                isValid = $.validateForm(formid);
                if (isValid) {
                  console.log("Success: About You form is valid");
                  // click the form submit button
                  // $("#submit-aboutyou-info-form").click();
                } else {
                  console.log("Success: About You form is not valid");
                  showSnackbar("Alert: Please complete the About You form to continue", "danger");
                  // return false;
                }
                break;
              case "#goalsetting-info-form":
                isValid = $.validateForm(formid);
                if (isValid) {
                  console.log("Success: Goal Setting form is valid");
                  // click the form submit button
                  // $("#submit-goalsetting-info-form").click();
                } else {
                  console.log("Success: Goal Setting form is not valid");
                  showSnackbar("Alert: Please complete the Goal Setting form to continue", "danger");
                  // return false;
                }
                break;
              case "#fitprefs-info-form":
                isValid = $.validateForm(formid);
                if (isValid) {
                  console.log("Success: fitprefs form is valid");
                  // click the form submit button
                  // $("#submit-fitprefs-info-form").click();
                } else {
                  console.log("Success: fitprefs form is not valid");
                  showSnackbar("Alert: Please complete the Fitness Preferences form to continue", "danger");
                  // return false;
                }
                break;
              case "#tou-policy-info-form":
                isValid = $.validateForm(formid);
                if (isValid) {
                  console.log("Success: Terms Of Use form is valid");
                  // click the form submit button
                  // $("#submit-tou-policy-info-form").click();
                } else {
                  console.log("Success: Terms Of Use form is not valid");
                  showSnackbar("Alert: Please accept the Terms Of Use to continue", "danger");
                  // return false;
                }
                break;

              default:
                // do nothing
                console.log("error: unknown form - formid: " + formid);
                showSnackbar("Alert: unknown form - formid: " + formid, "danger");
                isValid = false;
                return isValid;
                break;
            }
          });

          // if all forms are valid, submit all forms
          if (isValid) {
            console.log("Success: All forms are valid");
            showSnackbar("We are submitting your information. Please wait.", "alert_general");
            // submit all forms
            formsArray.forEach(formid => {
              // $(formid).submit();
              switch (formid) {
                case "#eula-policy-info-form":
                  // click the form submit button
                  $("#submit-eula-policy-info-form").click();
                  break;
                case "#aboutyou-info-form":
                  // click the form submit button
                  $("#submit-aboutyou-info-form").click();
                  break;
                case "#goalsetting-info-form":
                  // click the form submit button
                  $("#submit-goalsetting-info-form").click();
                  break;
                case "#fitprefs-info-form":
                  // click the form submit button
                  $("#submit-fitprefs-info-form").click();
                  break;
                case "#tou-policy-info-form":
                  // click the form submit button
                  $("#submit-tou-policy-info-form").click();
                  break;

                default:
                  // 
                  console.log("ERROR: Unknown form submission request");
                  alert("ERROR: Unknown form submission request [" + formid + "]");
                  break;
              }
            });
            console.log("Success: All forms submitted");
          } else {
            console.log("Error: Not all forms are valid");
            showSnackbar("Alert: Not all forms are valid", "danger");
            return false;
          }
        });
      });

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
  </style>

  <script src="../../scripts/js/script.js"></script>
  <script src="../../scripts/js/formValidationScripts.js"></script>
</head>

<body class="noselect" onload="toggleLoadCurtain();storeCurrentUserId('<?php echo $current_user_id; ?>')">

  <!-- snackbar -->
  <div class="snackbar d-grid gap-1 align-items-center" id="snackbar">
    No messages available
  </div>
  <!-- ./ snackbar -->

  <!-- Load Curtain -->
  <div class="load-curtain" id="LoadCurtain" style="display: block;">
    <!-- twitter social panel -->
    <div class="load-curtain-social-btn-panel comfortaa-font d-grid gap-2 p-4">
      <!--  d-none d-lg-block p-4 -->
      <div class="d-flex gap-2 w-100">
        <button class="p-4 m-0 shadow onefit-buttons-style-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseloadCurtainTweetFeed" aria-expanded="false" aria-controls="collapseloadCurtainTweetFeed">
          <div class="d-grid">
            <span class="material-icons material-icons-round" style="font-size: 48px !important;">
              <i class="fab fa-twitter" style="font-size: 40px; color: #fff !important;"></i>
            </span>
            <p class="comfortaa-font mt-1 mb-0" style="font-size: 10px;">@onefitnet</p>
          </div>
        </button>
      </div>
      <div class="collapse no-scroller pb-4 w3-animate-bottom" id="collapseloadCurtainTweetFeed" style="overflow-y: auto;">
        <div class="pb-4 no-scroller" style="border-radius: 25px !important; overflow-y: auto; max-height: 90vh; min-width: 500px;">
          <a class="twitter-timeline comfortaa-font" href="https://twitter.com/OnefitNet?ref_src=twsrc%5Etfw">Tweets by
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
            <img src="../../media/assets/One-Symbol-Logo-White.svg" class="img-fluid p-4" style="max-height: 20vh;" alt="">
          </div>
        </div>
      </div>
    </div>
    <nav class="text-center text-center p-4 fixed-bottom" alt="">
      <p class="navbar-brand fs-1 text-white comfortaa-font">One<span style="color: #ffa500">fit</span>.app<span style="font-size: 10px">&trade;</span></p>
      <p class="text-center comfortaa-font" styl="font-size: 10px !important;">Loading. Please wait.</p>
    </nav>
  </div>
  <!-- ./Load Curtain -->

  <!-- eula curtain -->
  <div id="eula-curtain" class="eula-curtain" style="display: block;">
    <div class="p-4 h-100" style="overflow-y: auto;">
      <div class="fixed-top p-4" style="background: #343434;">
        <h1 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end" style="border-radius: 25px; background-color: #343434; color: #fff; border-color: #ffa500;">
          <!-- <span class="material-icons material-icons-round" style="color: #ffa500;">
            looks_3
          </span> -->
          <span class="comfortaa-font">
            <u>End-User License Agreement</u>
          </span>
        </h1>
      </div>


      <!-- EULA -->
      <div id="eula-container" class="text-white comfortaa-font px-2 mb-4" style="overflow-y: auto; max-height: 100vh;padding-top: 180px;">
        <?php echo $policy_content; ?>
        <h1 class="text-center">End-User License Agreement &#40;"Agreement"&#41;</h1>
        <p class="text-center mb-4">Last updated: October 13, 2022</p>
        <p class="mt-4">Please read this End-User License Agreement carefully before clicking the "I
          Agree"
          button, downloading or using Onefit.app.</p>
        <h1>Interpretation and Definitions</h1>
        <h2>Interpretation</h2>
        <p>The words of which the initial letter is capitalized have meanings defined under the following
          conditions. The following definitions shall have the same meaning regardless of whether they
          appear in singular or in plural.</p>
        <h2>Definitions</h2>
        <p>For the purposes of this End-User License Agreement:</p>
        <ul>
          <li>
            <p><strong>Agreement</strong> means this End-User License Agreement that forms the entire
              agreement between You and the Company regarding the use of the Application. This Agreement
              has
              been created with the help of the <a href="https://www.privacypolicies.com/eula-generator/" target="_blank">EULA Generator</a>.</p>
          </li>
          <li>
            <p><strong>Application</strong> means the software program provided by the Company downloaded
              by
              You to a Device, named Onefit.app</p>
          </li>
          <li>
            <p><strong>Company</strong> &#40;referred to as either "the Company", "We",
              "Us" or "Our" in this Agreement&#41; refers to AdaptivConcept NPC, Unit 201,
              Anchor Towers, 2 Plein Steet, Johannesburg.</p>
          </li>
          <li>
            <p><strong>Content</strong> refers to content such as text, images, or other information that
              can be posted, uploaded, linked to or otherwise made available by You, regardless of the
              form
              of that content.</p>
          </li>
          <li>
            <p><strong>Country</strong> refers to: South Africa</p>
          </li>
          <li>
            <p><strong>Device</strong> means any device that can access the Application such as a
              computer,
              a cellphone or a digital tablet.</p>
          </li>
          <li>
            <p><strong>Third-Party Services</strong> means any services or content &#40;including data,
              information, applications and other products services&#41; provided by a third-party that may be
              displayed, included or made available by the Application.</p>
          </li>
          <li>
            <p><strong>You</strong> means the individual accessing or using the Application or the
              company,
              or other legal entity on behalf of which such individual is accessing or using the
              Application, as applicable.</p>
          </li>
        </ul>
        <h1>Acknowledgment</h1>
        <p>By clicking the "I Agree" button, downloading or using the Application, You are
          agreeing to be bound by the terms and conditions of this Agreement. If You do not agree to the
          terms of this Agreement, do not click on the "I Agree" button, do not download or do
          not
          use the Application.</p>
        <p>This Agreement is a legal document between You and the Company and it governs your use of the
          Application made available to You by the Company.</p>
        <p>The Application is licensed, not sold, to You by the Company for use strictly in accordance
          with
          the terms of this Agreement.</p>
        <h1>License</h1>
        <h2>Scope of License</h2>
        <p>The Company grants You a revocable, non-exclusive, non-transferable, limited license to
          download,
          install and use the Application strictly in accordance with the terms of this Agreement.</p>
        <p>The license that is granted to You by the Company is solely for your personal, non-commercial
          purposes strictly in accordance with the terms of this Agreement.</p>
        <h1>Third-Party Services</h1>
        <p>The Application may display, include or make available third-party content &#40;including data,
          information, applications and other products services&#41; or provide links to third-party websites
          or
          services.</p>
        <p>You acknowledge and agree that the Company shall not be responsible for any Third-party
          Services,
          including their accuracy, completeness, timeliness, validity, copyright compliance, legality,
          decency, quality or any other aspect thereof. The Company does not assume and shall not have any
          liability or responsibility to You or any other person or entity for any Third-party Services.
        </p>
        <p>You must comply with applicable Third parties&#39; Terms of agreement when using the Application.
          Third-party Services and links thereto are provided solely as a convenience to You and You
          access
          and use them entirely at your own risk and subject to such third parties&#39; Terms and conditions.
        </p>
        <h1>Term and Termination</h1>
        <p>This Agreement shall remain in effect until terminated by You or the Company.
          The Company may, in its sole discretion, at any time and for any or no reason, suspend or
          terminate this Agreement with or without prior notice.</p>
        <p>This Agreement will terminate immediately, without prior notice from the Company, in the event
          that you fail to comply with any provision of this Agreement. You may also terminate this
          Agreement by deleting the Application and all copies thereof from your Device or from your
          computer.</p>
        <p>Upon termination of this Agreement, You shall cease all use of the Application and delete all
          copies of the Application from your Device.</p>
        <p>Termination of this Agreement will not limit any of the Company&#39;s rights or remedies at law or
          in
          equity in case of breach by You &#40;during the term of this Agreement&#41; of any of your obligations
          under the present Agreement.</p>
        <h1>Indemnification</h1>
        <p>You agree to indemnify and hold the Company and its parents, subsidiaries, affiliates,
          officers,
          employees, agents, partners and licensors &#40;if any&#41; harmless from any claim or demand, including
          reasonable attorneys&#39; fees, due to or arising out of your: &#40;a&#41; use of the Application; &#40;b&#41;
          violation of this Agreement or any law or regulation; or &#40;c&#41; violation of any right of a third
          party.</p>
        <h1>No Warranties</h1>
        <p>The Application is provided to You "AS IS" and "AS AVAILABLE" and with all
          faults and defects without warranty of any kind. To the maximum extent permitted under
          applicable
          law, the Company, on its own behalf and on behalf of its affiliates and its and their respective
          licensors and service providers, expressly disclaims all warranties, whether express, implied,
          statutory or otherwise, with respect to the Application, including all implied warranties of
          merchantability, fitness for a particular purpose, title and non-infringement, and warranties
          that
          may arise out of course of dealing, course of performance, usage or trade practice. Without
          limitation to the foregoing, the Company provides no warranty or undertaking, and makes no
          representation of any kind that the Application will meet your requirements, achieve any
          intended
          results, be compatible or work with any other software, applications, systems or services,
          operate
          without interruption, meet any performance or reliability standards or be error free or that any
          errors or defects can or will be corrected.</p>
        <p>Without limiting the foregoing, neither the Company nor any of the company&#39;s provider makes any
          representation or warranty of any kind, express or implied: &#40;i&#41; as to the operation or
          availability of the Application, or the information, content, and materials or products included
          thereon; &#40;ii&#41; that the Application will be uninterrupted or error-free; &#40;iii&#41; as to the
          accuracy,
          reliability, or currency of any information or content provided through the Application; or &#40;iv&#41;
          that the Application, its servers, the content, or e-mails sent from or on behalf of the Company
          are free of viruses, scripts, trojan horses, worms, malware, timebombs or other harmful
          components.</p>
        <p>Some jurisdictions do not allow the exclusion of certain types of warranties or limitations on
          applicable statutory rights of a consumer, so some or all of the above exclusions and
          limitations
          may not apply to You. But in such a case the exclusions and limitations set forth in this
          section
          shall be applied to the greatest extent enforceable under applicable law. To the extent any
          warranty exists under law that cannot be disclaimed, the Company shall be solely responsible for
          such warranty.</p>
        <h1>Limitation of Liability</h1>
        <p>Notwithstanding any damages that You might incur, the entire liability of the Company and any
          of
          its suppliers under any provision of this Agreement and your exclusive remedy for all of the
          foregoing shall be limited to the amount actually paid by You for the Application or through the
          Application or 100 USD if You haven&#39;t purchased anything through the Application.</p>
        <p>To the maximum extent permitted by applicable law, in no event shall the Company or its
          suppliers
          be liable for any special, incidental, indirect, or consequential damages whatsoever &#40;including,
          but not limited to, damages for loss of profits, loss of data or other information, for business
          interruption, for personal injury, loss of privacy arising out of or in any way related to the
          use
          of or inability to use the Application, third-party software and/or third-party hardware used
          with
          the Application, or otherwise in connection with any provision of this Agreement&#41;, even if the
          Company or any supplier has been advised of the possibility of such damages and even if the
          remedy
          fails of its essential purpose.</p>
        <p>Some states/jurisdictions do not allow the exclusion or limitation of incidental or
          consequential
          damages, so the above limitation or exclusion may not apply to You.</p>
        <h1>Severability and Waiver</h1>
        <h2>Severability</h2>
        <p>If any provision of this Agreement is held to be unenforceable or invalid, such provision will
          be
          changed and interpreted to accomplish the objectives of such provision to the greatest extent
          possible under applicable law and the remaining provisions will continue in full force and
          effect.
        </p>
        <h2>Waiver</h2>
        <p>Except as provided herein, the failure to exercise a right or to require performance of an
          obligation under this Agreement shall not effect a party&#39;s ability to exercise such right or
          require such performance at any time thereafter nor shall the waiver of a breach constitute a
          waiver of any subsequent breach.</p>
        <h1>Product Claims</h1>
        <p>The Company does not make any warranties concerning the Application.</p>
        <h1>United States Legal Compliance</h1>
        <p>You represent and warrant that &#40;i&#41; You are not located in a country that is subject to the
          United
          States government embargo, or that has been designated by the United States government as a
          "terrorist supporting" country, and &#40;ii&#41; You are not listed on any United States
          government list of prohibited or restricted parties.</p>
        <h1>Changes to this Agreement</h1>
        <p>The Company reserves the right, at its sole discretion, to modify or replace this Agreement at
          any time. If a revision is material we will provide at least 30 days&#39; notice prior to any new
          terms taking effect. What constitutes a material change will be determined at the sole
          discretion
          of the Company.</p>
        <p>By continuing to access or use the Application after any revisions become effective, You agree
          to
          be bound by the revised terms. If You do not agree to the new terms, You are no longer
          authorized
          to use the Application.</p>
        <h1>Governing Law</h1>
        <p>The laws of the Country, excluding its conflicts of law rules, shall govern this Agreement and
          your use of the Application. Your use of the Application may also be subject to other local,
          state, national, or international laws.</p>
        <h1>Entire Agreement</h1>
        <p>The Agreement constitutes the entire agreement between You and the Company regarding your use
          of
          the Application and supersedes all prior and contemporaneous written or oral agreements between
          You and the Company.</p>
        <p>You may be subject to additional terms and conditions that apply when You use or purchase other
          Company&#39;s services, which the Company will provide to You at the time of such use or purchase.
        </p>
        <h1>Contact Us</h1>
        <p>If you have any questions about this Agreement, You can contact Us:</p>
        <ul>
          <li>
            <p>By email: admin@adaptivconcept.co.za</p>
          </li>
          <li>
            <p>By visiting this page on our website: <a href="https://adaptivconcept.co.za/contact" rel="external nofollow noopener" target="_blank">https://adaptivconcept.co.za/contact</a>
            </p>
          </li>
          <li>
            <p>By phone number: 0818118095</p>
          </li>
        </ul>
      </div>
      <!-- ./ EULA -->

      <hr class="text-white">

      <!-- #policy-info-form -->
      <!--<?php echo $output; ?>-->
      <!-- ../../scripts/php/main_app/data_management/system_admin/user_registration/submit/policy_acceptance_submit.php -->
      <form id="eula-policy-info-form" action="../../scripts/php/main_app/data_management/system_admin/user_registration/submit/policy_acceptance_submit.php?user_id=<?php echo $current_user_id; ?>&agree_eula=true" method="post" autocomplete="off">
        <!-- user id hidden -->
        <div class="form-group my-4">
          <input class="form-control-text-input p-4" type="number" name="eula_user_id" id="user-id-policy-eula" value="<?php echo $current_user_id; ?>" readonly placeholder="user id" required="" hidden="">
        </div>
        <!-- ./ user id hidden -->

        <div class="d-grid gap-4 justify-content-center">
          <div class="form-check align-items-center align-middle">
            <!-- form-check-inline form-switch -->
            <input class="form-check-input me-4" value="accepted-eula" type="checkbox" role="switch" name="agree_eula" id="agree-eula" onchange="eulaAcceptanceState()">
            <label class="form-check-label p-2 align-middle pt-2 text-white" for="agree-eula">Do you agree to the
              above End-User Licence Agreement?</label>
          </div>
        </div>

        <!-- hidden submit btn -->
        <!-- <div class="d-block justify-content-center">
          <input id="submit-policy-info-form" style="font-size: 40px !important;" type="submit" value="submit" hidden=""
            aria-hidden="true">
        </div> -->

        <hr class="text-white" style="margin-bottom: 80px;">

        <!-- Procession Buttons -->
        <div class="comfortaa-font text-center mt-4 text-white" style="margin-bottom: 40px; font-size: 20px;">
          <div class="d-grid gap-0 w-100 text-white">
            <span class="rounded-pill p-4" style="background-color: #343434;">
              One<span style="color: #ffa500;">fit</span>.app
            </span>

            <span class="material-icons material-icons-outlined" style="color: #ffa500;">
              horizontal_rule
            </span>
          </div>
          <div class="row align-items-center">
            <div class="col-md py-4 d-grid">
              <!--  gap-2 justify-content-center -->

              <!-- EULA Acceptence Message -->
              <div id="eula-acceptence-msg" style="display: block;">
                <div class="d-grid gap-2 text-center">
                  <div class="d-flex text-center justify-content-center">
                    <span class="material-icons material-icons-round p-4" style="font-size: 80px !important; background-color: #c20000; color: #fff; border-radius: 25px;">
                      rule </span>
                  </div>

                  <span>Please accept the End-User License Agreement (EULA) to start creating your profile.</span>
                </div>
              </div>
              <!-- ./ EULA Acceptence Message -->

              <!-- onclick="proceedToMain()" -->
              <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow" form="eula-policy-info-form" type="submit" id="proceed-btn" style="display: none;">
                <div class="d-grid gap-2 justify-content-center text-center fw-bold">
                  <span class="material-icons material-icons-round" style="font-size: 40px !important; color: #ffa500;">
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
      <a class="navbar-brand fs-1 text-white comfortaa-font" href="../index.php">One<span style="color: #ffa500">fit</span>.app<span style="font-size: 10px">&trade;</span></a>
      <button class="navbar-toggler shadow onefit-buttons-style-dark p-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <!--<span class="navbar-toggler-icon"></span>-->
        <!--<img src="./media/assets/One-Symbol-Logo-Two-Tone.svg" alt="" class="img-fluid logo-size-1" />-->
        <span class="material-icons material-icons-round align-middle" style="font-size: 28px!important;"> public
          <!-- menu_open --> </span>
      </button>
      <div class="offcanvas offcanvas-end offcanvas-menu-primary-style" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="h-100z" id="offcanvas-menu">
          <div class="offcanvas-header fs-1" style="background-color: #343434; color: #fff">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
              <img src="../../media/assets/One-Symbol-Logo-White.svg" alt="icon" class="img-fluid logo-size-2" />
              Navigation
            </h5>
            <button type="button" class="onefit-buttons-style-light rounded-pill shadow p-2" data-bs-dismiss="offcanvas" aria-label="Close">
              <span class="material-icons material-icons-round align-middle" style="font-size:20px!important;"> close
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
                <a class="nav-link active p-4" style="border-radius: 25px !important;" aria-current="page" href="#">Onefit.app&trade;</a>
              </li>
              <li class="nav-item">
                <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">Onefit.Edu&trade; (Blog)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link p-4" style="border-radius: 25px !important;" href="#">Onefit.Shop&trade;</a>
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
    <div id="main-body-row-container" class="row w-100Z align-items-center m-0 no-scroller" style="height: 100vh !important; overflow-y: auto;">
      <div class="col-md -4 text-white h-100z p-0 no-scroller" style="max-height: 100vh; padding-top: 80px !important; overflow-y: auto;">
        <div class="container top-down-grad-dark p-4" style="border-radius: 25px 25px 0 0 !important;">
          <h3 class="text-center p-4 bg-transparent fw-bold comfortaa-font text-truncate border-5 border-start border-end down-top-grad-tahitiz" style="color: #fff !important; border-color: #ffa500 !important; cursor: pointer; border-radius: 25px;">
            <!-- class="text-center rounded-pillz p-4 mb-4 text-truncate shadow"
            style="background-color: #ffa500; color: #343434 !important; border-radius: 25px !important;" -->
            <div class="d-grid justify-content-center text-center comfortaa-font">
              <div class="text-center">
                <img src="../../media/assets/One-Logo.svg" class="img-fluid my-4 px-4 text-center" style="border-radius: 25px; width: 100%; max-width: 400px!important;" alt="logo">
              </div>

              <hr class="my-4" style="color: #ffa500;">

              <span class="material-icons material-icons-round">
                person_add
              </span>
              <p class=" comfortaa-font text-wrap" style="font-size: 40px !important;">
                Let's build your profile!
              </p>
            </div>

          </h3>

          <hr class="text-white" style="margin-top: 80px; margin-bottom: 80px;">

          <div class="p-4 d-grid justify-content-center text-center border-5 border-start border-end down-top-grad-dark" style="border-radius: 25px; border-color: #ffa500 !important;">
            <div class="d-flex align-items-center justify-content-center align-middle">
              <span class="material-icons material-icons-round" style="color: #ffa500;">
                looks_one
              </span>
              <h5 class="comfortaa-font my-4">Set your profile picture</h5>
            </div>

            <div class="in-div-button-container text-center justify-content-center">

              <div class="d-grid justify-content-center">
                <img src="../../media/assets/OnefitNet Profile Pic Redone.png" class="img-fluid shadow my-4" style="border-radius: 25px; border-bottom: #ffa500 solid 5px;" alt="placeholder">
              </div>


              <button class="onefit-buttons-style-dark shadow in-div-btn text-center p-3 m-4 shadow" onclick="launchProfileImgsEditor()">
                <div class="d-grid align-items-center">
                  <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                    change_circle
                  </span>
                  <span class="comfortaa-font" style="font-size: 10px;">change</span>
                </div>
              </button>

            </div>
          </div>

          <hr class="text-white" style="margin-top: 80px; margin-bottom: 80px;">

          <ul class="pb-4z text-center list-group list-group-flush down-top-grad-dark border-white border-5 border-start border-end" style="border-radius: 25px !important; border-color: #ffa500 !important;">
            <li id="toggle-main-form-window-list-btn" class="pt-4 list-group-item bg-transparent fw-bold comfortaa-font text-truncate down-top-grad-dark" style="color: #fff !important; border-color: #ffa500 !important; cursor: pointer;" onclick="switchTab('mainfrmwindow')">
              <div class="d-grid gap-2 text-center justify-content-center">
                <div class="d-flex align-items-center justify-content-center align-middle text-wrap">
                  <span class="material-icons material-icons-round" style="color: #ffa500;">
                    looks_two
                  </span>
                  <span class="pt-4 fs-5">Create your Profile</span>
                </div>


                <span class="material-icons material-icons-round" style="color: #ffa500;">
                  <!-- style="color: #ffa500; cursor: pointer;" -->
                  expand_more
                </span>
              </div>

            </li>

            <li id="category-selector-about-you" class="down-top-grad-dark list-group-item bg-transparent fw-bold comfortaa-font text-truncate profile-item-button collapse multi-collapse align-middle" style="color: #ffa500; border-color: #ffa500 !important;" onclick="switchTab('aboutyou')">
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
            <li id="category-selector-goal-setting" class="down-top-grad-dark list-group-item bg-transparent fw-bold comfortaa-font text-truncate profile-item-button collapse multi-collapse align-middle" style="color: #ffa500; border-color: #ffa500 !important;" onclick="switchTab('goalsetting')">
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
            <li id="category-selector-fitness-prefs" class="down-top-grad-dark list-group-item bg-transparent fw-bold comfortaa-font text-truncate profile-item-button collapse multi-collapse align-middle" style="color: #ffa500; border-color: #ffa500 !important;" onclick="switchTab('fitprefs')">
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
            <li id="category-selector-eu-agreements" class="down-top-grad-dark list-group-item bg-transparent fw-bold comfortaa-font text-truncate profile-item-button collapse multi-collapse align-middle" style="color: #ffa500; border-color: #ffa500 !important;" onclick="switchTab('eu-agreements')" hidden>
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

            <span class="material-icons material-icons-outlined" style="color: #ffa500; cursor: pointer;" onclick="switchTab('mainfrmwindow')">
              <!--  -->
              horizontal_rule
            </span>

            <!-- hidden links href="#main-form-window"-->
            <button class="btn btn-primary" id="toggle-category-selectors" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="main-form-window category-selector-about-you category-selector-goal-setting category-selector-fitness-prefs" hidden aria-hidden="true">
              Toggle Category Selector List Buttons
            </button>

            <a class="btn btn-primary" id="toggle-main-form-window" data-bs-toggle="collapse" href="#main-form-window" role="button" aria-expanded="false" aria-controls="main-form-window" hidden aria-hidden="true">
              Toggle main form window
            </a>

            <a class="btn btn-primary" id="toggle-main-form-window" data-bs-toggle="collapse" href="#main-form-window" role="button" aria-expanded="false" aria-controls="main-form-window" hidden aria-hidden="true">
              Toggle show final tabpanel in main form window tab
            </a>

            <a class="btn btn-primary" id="toggle-aboutyou-check-icon" data-bs-toggle="collapse" href="#aboutyou-confirmation-icon" role="button" aria-expanded="false" aria-controls="aboutyou-confirmation-icon" hidden aria-hidden="true">
              Toggle aboutyou check icon
            </a>

            <a class="btn btn-primary" id="toggle-goalsetting-check-icon" data-bs-toggle="collapse" href="#goalsetting-confirmation-icon" role="button" aria-expanded="false" aria-controls="goalsetting-confirmation-icon" hidden aria-hidden="true">
              Toggle goalsetting check icon
            </a>

            <a class="btn btn-primary" id="toggle-fitprefs-check-icon" data-bs-toggle="collapse" href="#fitprefs-confirmation-icon" role="button" aria-expanded="false" aria-controls="fitprefs-confirmation-icon" hidden aria-hidden="true">
              Toggle fitprefs check icon
            </a>
          </ul>

          <div class="my-4 text-center down-top-grad-dark p-4" style="border-radius: 0 0 25px 25px !important;">
            <p class="text-white fs-5 align-end me-4z text-center comfortaa-font"> <span style="font-size: 10px;">Crafted by
                AdaptivConcept&trade; NPC
                &copy;
                2022</span> | <a href="http://www.AdaptivConcept.co.za" class="comfortaa-font" style=" color: #ffa500;">Support</a>
            </p>
          </div>
        </div>

      </div>

      <div class="col-md-8 collapse px-2 text-white h-100z down-top-grad-dark no-scroller w3-animate-bottom" style="height: 90vh; padding-top: 80px !important; overflow-y: auto; overflow-x: hidden; border-radius: 25px !important; border-bottom: #ffa500 solid 5px;" id="main-form-window">

        <div id="main-form-window-scroll-container" class="down-top-grad-white p-4 mb-4 w3-animate-top" style="max-height: 80vh; width: 100%; border-radius: 25px !important; border-bottom: #ffa500 solid 5px; overflow-y: auto; overflow-x: hidden;">

          <div class="p-4 shadow text-center mb-4 comfortaa-font border-5 border-start border-end top-down-grad-dark sticky-top" style="border-radius: 25px; border-color: #ffa500 !important;">
            <!-- background-color: #343434;  -->
            <h1 class="align-middle" id="user-welcome-header">
              <span class="material-icons material-icons-outlined align-middle" style="color: var(--tahitigold) !important; font-size: 40px;">account_circle</span>
              Hi <?php echo "$current_user_name $current_user_surname"; ?>.
            </h1>
            <hr style="color: var(--white);">
            <p class="comfortaa-font" style="font-size: 12px !important;">Please provide us with a few more details so that we can understand more about you
              and your preferences.
            </p>
            <div id="tab-title-header-display">
              <h1 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center mt-4 border-5 border-start border-end sticky-top" style="border-radius: 25px;background-color: var(--mineshaft);color: var(--white) !important;border-color: var(--tahitigold) !important;"> About You </h1>
            </div>
          </div>


          <!-- form category tabs -->
          <div id="form-category-tabs" style="height: 100%;">
            <ul class="nav nav-tabs" id="fitness-profile-form-tab" style="display: none;" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="category-about-you-tab" data-bs-toggle="tab" data-bs-target="#category-about-you-tab-pane" type="button" role="tab" aria-controls="category-about-you-tab-pane" aria-selected="true">About you</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="category-goal-setting-tab" data-bs-toggle="tab" data-bs-target="#category-goal-setting-tab-pane" type="button" role="tab" aria-controls="category-goal-setting-tab-pane" aria-selected="false">Set your Goals</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="category-fitness-prefs-tab" data-bs-toggle="tab" data-bs-target="#category-fitness-prefs-tab-pane" type="button" role="tab" aria-controls="category-fitness-prefs-tab-pane" aria-selected="false">Fitness Preferences</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="category-eu-agreements-tab" data-bs-toggle="tab" data-bs-target="#category-eu-agreements-tab-pane" type="button" role="tab" aria-controls="category-eu-agreements-tab-pane" aria-selected="false">End-User Agreements</button>
              </li>
            </ul>

            <div class="tab-content comfortaa-font" id="fitness-profile-form-tabContent">
              <div class="tab-pane fade show active w3-animate-bottom comfortaa-font" id="category-about-you-tab-pane" role="tabpanel" aria-labelledby="category-about-you-tab" tabindex="0">

                <div class="my-4" id="category-about-you-tab-questions-pane">
                  <div class="p-4 content-panel-border-style shadow" style="border-radius: 25px; background: #343434;">
                    <h2 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4" style="border-radius: 25px; background-color: #343434; color: #fff; margin-bottom: 60px !important;">
                      Tell us about yourself.
                    </h2>

                    <p class="fs-5 comfortaa-font align-middle text-center my-4" style="margin-bottom: 40px !important;">Your account details.</p>
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
                    <div class="row">
                      <div class="col-lg">
                        <div class="text-start d-grid gap-2" id="user-account-details">
                          <div id="question-variable">
                            <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">1)</span>
                              Your name</p>

                            <p class="fs-5" style="color: #ffa500;">
                              <?php echo $current_user_name; ?>
                            </p>
                          </div>

                        </div>

                        <div class="text-start d-grid gap-2" id="user-account-details">
                          <div id="question-variable">
                            <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">2)</span>
                              Your surname</p>

                            <p class="fs-5" style="color: #ffa500;">
                              <?php echo $current_user_surname; ?>
                            </p>
                          </div>

                        </div>

                        <div class="text-start d-grid gap-2" id="user-account-details">
                          <div id="question-variable">
                            <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">3)</span>
                              Your email address</p>

                            <p class="fs-5" style="color: #ffa500;">
                              <?php echo $current_user_email; ?>
                            </p>
                          </div>

                        </div>

                        <div class="text-start d-grid gap-2" id="user-account-details">
                          <div id="question-variable">
                            <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">4)</span>
                              Your contact number</p>

                            <p class="fs-5" style="color: #ffa500;">
                              <?php echo $current_user_contact; ?>
                            </p>
                          </div>

                        </div>

                      </div>
                      <div class="col-lg">
                        <div class="text-start d-grid gap-2" id="user-account-details">
                          <div id="question-variable">
                            <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">5)</span>
                              Your date of birth</p>

                            <p class="fs-5" style="color: #ffa500;">
                              <?php echo $current_user_dob; ?>
                            </p>
                          </div>

                        </div>

                        <div class="text-start d-grid gap-2" id="user-account-details">
                          <div id="question-variable">
                            <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">6)</span>
                              Your gender</p>

                            <p class="fs-5" style="color: #ffa500;">
                              <?php echo $current_user_gender; ?>
                            </p>
                          </div>

                        </div>

                        <div class="text-start d-grid gap-2" id="user-account-details">
                          <div id="question-variable">
                            <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">7)</span>
                              Your race</p>

                            <p class="fs-5" style="color: #ffa500;">
                              <?php echo $current_user_race; ?>
                            </p>
                          </div>

                        </div>

                        <div class="text-start d-grid gap-2" id="user-account-details">
                          <div id="question-variable">
                            <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">8)</span>
                              Your Nationality</p>

                            <p class="fs-5" style="color: #ffa500;">
                              <?php echo $current_user_nation; ?>
                            </p>
                          </div>

                        </div>
                      </div>
                    </div>
                    <!-- ./ user details - output -->

                    <hr class="text-white" style="margin: 80px 0px;">

                    <!-- #aboutyou-info-form -->
                    <!-- scripts/php/main_app/data_management/system_admin/user_registration/submit/aboutyou_submit.php -->
                    <form id="aboutyou-info-form" action="scripts/php/main_app/data_management/system_admin/user_registration/submit/aboutyou_submit.php" method="post" autocomplete="off">
                      <!-- user id hidden -->
                      <div class="form-group my-4">
                        <input class="form-control-text-input p-4" type="number" name="user_profile_id" id="user-profile-id-aboutyou" value="<?php echo $current_user_profile_id; ?>" placeholder="user profile id" required hidden aria-hidden="true" />
                      </div>
                      <!-- ./ user id hidden -->

                      <p class="fs-5 comfortaa-font align-middle text-center my-4" style="margin-bottom: 40px !important;">Please provide us with your
                        Height (in
                        Centimeters) and Weight (in Kilograms)</p>

                      <p class="fs-5 comfortaa-font align-middle text-center"><span class="fs-2" style="color: #ffa500;">9)</span>
                        Your weight (kg)</p>

                      <div class="form-group my-4">
                        <input class="form-control-text-input p-4" type="number" step="2" name="category_1_weight_field" id="user-weight" placeholder="Weight (kg)" required />
                      </div>

                      <p class="fs-5 comfortaa-font align-middle text-center"><span class="fs-2" style="color: #ffa500;">10)</span>
                        Your height (cm)</p>

                      <div class="form-group my-4">
                        <input class="form-control-text-input p-4" type="number" step="2" name="category_1_height_field" id="user-height" placeholder="Height (cm)" required />
                      </div>

                      <!-- submit btn -->
                      <div class="d-grid justify-content-center">
                        <input id="submit-aboutyou-info-form" style="font-size: 20px !important;" class="onefit-buttons-style-tahiti p-4 text-center comfortaa-font shadow fw-bold" type="submit" value="Save.">
                      </div>

                      <!-- hidden aria-hidden="true" -->
                    </form>
                    <!-- ./ #aboutyou-info-form -->

                    <hr class="text-white" style="margin: 80px 0px;">

                    <!-- Procession Buttons -->
                    <div class="comfortaa-font text-center mt-4" style="margin-bottom: 40px; font-size: 20px;">
                      <div class="d-grid gap-0 w-100 text-white">
                        <span class="rounded-pill p-4" style="background-color: #343434;">
                          One<span style="color: #ffa500;">fit</span>.app
                        </span>

                        <span class="material-icons material-icons-outlined" style="color: #ffa500;">
                          horizontal_rule
                        </span>
                      </div>
                      <div class="row align-items-center">
                        <div class="col-lg py-4">
                          <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow" id="goalsetting-next-panel-btn" onclick="survey_controller('aboutyou','goalsetting')">
                            <div class="d-grid gap-2 justify-content-center text-center fw-bold">
                              <span class="material-icons material-icons-round" style="font-size: 40px !important; color: #ffa500;">
                                arrow_forward_ios </span>
                              <span>Goal setting.</span>
                            </div>

                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- ./ Procession Buttons -->

                  </div>

                </div>

              </div>
              <div class="tab-pane fade w3-animate-bottom comfortaa-font" id="category-goal-setting-tab-pane" role="tabpanel" aria-labelledby="category-goal-setting-tab" tabindex="0">

                <div class="my-4" id="category-goal-setting-tab-questions-pane">
                  <div class="p-4 content-panel-border-style shadow" style="border-radius: 25px; background: #343434;">
                    <h2 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4" style="border-radius: 25px; background-color: #343434; color: #fff; margin-bottom: 60px !important;">
                      Set your Fitness Goals.
                    </h2>

                    <div form="main-submission-form" id="emailHelp" class="form-text text-center fw-bold my-4" style=" color: #fff">We have a responsibility
                      to
                      keep your keep your Identity &amp; Privacy safe! <br>
                      - <a href="http://" style=" color: #ffa500;">Privacy
                        Policy</a> -
                    </div>

                    <hr class="text-white" style="margin: 80px 0px;">

                    <!-- #goalsetting-info-form -->
                    <!-- ../../scripts/php/main_app/data_management/system_admin/user_registration/submit/goalsetting_submit.php -->
                    <form id="goalsetting-info-form" action="../../scripts/php/main_app/data_management/system_admin/user_registration/submit/goalsetting_submit.php" method="post" autocomplete="off">
                      <!-- user id hidden -->
                      <div class="form-group my-4">
                        <input class="form-control-text-input p-4" type="number" name="user_profile_id" id="user-profile-id-goalsetting" value="<?php echo $current_user_profile_id; ?>" placeholder="user profile id" required hidden aria-hidden="true" />
                      </div>
                      <!-- ./ user id hidden -->

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
                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">1)</span>
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
                            <input class="form-check-input me-4" value="Be more active" type="checkbox" name="category_2_question_1_field[]" id="category-2-be-more-active-field">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              Be more active
                            </label>
                          </div>

                          <div class="form-check">
                            <input class="form-check-input me-4" value="Lose weight" type="checkbox" name="category_2_question_1_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Lose weight
                            </label>
                          </div>

                          <div class="form-check">
                            <input class="form-check-input me-4" value="Stay toned" type="checkbox" name="category_2_question_1_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              Stay toned
                            </label>
                          </div>

                          <div class="form-check">
                            <input class="form-check-input me-4" value="Build muscle" type="checkbox" name="category_2_question_1_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Build muscle
                            </label>
                          </div>

                          <div class="form-check">
                            <input class="form-check-input me-4" value="Reduce Stress" type="checkbox" name="category_2_question_1_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              Reduce Stress
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="Stay healthy" type="checkbox" name="category_2_question_1_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
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
                          <p class="fs-5 comfortaa-font align-middle"><span class=" fs-2" style="color: #ffa500;">2)</span>
                            Please set
                            your own Goal statement</p>
                        </div>
                        <div class="col-lg -6 p-2 text-truncate">
                          <div class="form-group text-truncate">
                            <textarea class="form-control-text-input p-4" style="border-radius: 25px !important;" rows="10" type="text" name="category_2_question_2_field" id="goal-statement" placeholder="My goal statement" required></textarea>
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
                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">3)</span>
                            By when do
                            you want to have realized this Goal?</p>
                        </div>
                        <div class="col-lg -6 p-2 text-truncate">
                          <div class="form-group text-truncate">
                            <input class="form-control-text-input p-4" type="date" name="category_2_question_3_field" id="reach-goal-date" required />
                          </div>

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
                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">4)</span>
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
                            <input class="form-check-input me-4" value="Glutes" type="checkbox" name="category_2_question_4_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              Glutes
                            </label>
                          </div>


                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="Abs" type="checkbox" name="category_2_question_4_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Abs
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="Arms" type="checkbox" name="category_2_question_4_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              Arms
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="Legs" type="checkbox" name="category_2_question_4_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Legs
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="Back" type="checkbox" name="category_2_question_4_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Back
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="Butt" type="checkbox" name="category_2_question_4_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Butt
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="Upper Body" type="checkbox" name="category_2_question_4_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Upper Body
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="Lower Body" type="checkbox" name="category_2_question_4_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              Lower Body
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="Total Body" type="checkbox" name="category_2_question_4_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
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
                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">5)</span>
                            How many workouts per week do you want to do?</p>
                        </div>
                        <div class="col-lg -6 p-2">
                          <!-- 
                        `2-3
                        `3-4
                        `4-5
                        `5+
                        -->

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="2 - 3 weeks" type="radio" name="category_2_question_5_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              2 - 3
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="3 - 4 weeks" type="radio" name="category_2_question_5_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              3 - 4
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="4 - 5 weeks" type="radio" name="category_2_question_5_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              4 - 5
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="5+ weeks" type="radio" name="category_2_question_5_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
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
                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">6)</span>
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
                            <input class="form-check-input me-4" value="5 - 10 minutes" type="radio" name="category_2_question_6_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              5 - 10 Minutes
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="15 - 20 minutes" type="radio" name="category_2_question_6_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              15 - 20 Minutes
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="25 - 30 minutes" type="radio" name="category_2_question_6_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              25 - 30 Minutes
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="30+ minutes" type="radio" name="category_2_question_6_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
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
                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">7)</span>
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
                            <input class="form-check-input me-4" value="4" type="radio" name="category_2_question_7_field[]" id="flexCheckDefault" onchange="toggleCtgy2SpecifyOther('hide')">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              4 Weeks
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="8" type="radio" name="category_2_question_7_field[]" id="flexCheckDefault" onchange="toggleCtgy2SpecifyOther('hide')">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              8 Weeks
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="12" type="radio" name="category_2_question_7_field[]" id="flexCheckDefault" onchange="toggleCtgy2SpecifyOther('hide')">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              12 Weeks
                            </label>
                          </div>

                          <!-- specify -->
                          <div class="form-check text-truncate my-4">
                            <input class="form-check-input me-4" value="specified" type="radio" name="category_2_question_7_field[]" id="specify-weeks" onchange="toggleCtgy2SpecifyOther('show')">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Specify
                            </label>
                          </div>

                          <script>
                            function toggleCtgy2SpecifyOther(state) {
                              var specifyCheckInput = document.getElementById("specify-weeks").value;
                              var specifyFieldContainer = document.getElementById("category-2-question-8-specify");

                              if (state == "show") {
                                specifyFieldContainer.style.display = "block";
                              } else {
                                specifyFieldContainer.style.display = "none";
                              }
                            }
                          </script>

                          <div class="form-group mt-4 mb-0 w3-animate-right" id="category-2-question-8-specify" style="display: none;">
                            <input class="form-control-text-input p-4" type="number" value="1" name="category_2_question_7_specify_weeks_field" id="specific-weeks" placeholder="Specify the number of weeks" />
                            <!-- style="position: relative;"  -->
                            <p class="comfortaa-font text-center fs-5 mt-2 mb-0" style="color: #ffa500;">
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
                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">8)</span>
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
                            <input class="form-check-input me-4" value="I eat a lot of sweets or sugary treats" type="checkbox" name="category_2_question_8_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2 text-wrap" for="flexCheckDefault">
                              I eat a lot of sweets or sugary treats
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="I do not sleep enough" type="checkbox" name="category_2_question_8_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              I do not sleep enough
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="I eat a lot of fatty foods / fast foods" type="checkbox" name="category_2_question_8_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              I eat a lot of fatty foods / fast foods
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="I eat late at night" type="checkbox" name="category_2_question_8_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              I eat late at night
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="I am a smoker" type="checkbox" name="category_2_question_8_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              I am a smoker
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="None" type="checkbox" name="category_2_question_8_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
                              None whatsoever
                            </label>
                          </div>

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
                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">9)</span>
                            Are you prepared to do what is necessay to let go of bed habits?</p>
                        </div>
                        <div class="col-lg -6 p-2">
                          <!-- 
                        Yes
                        No
                        -->

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="Yes" type="radio" name="category_2_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Yes
                            </label>
                          </div>

                          <div class="form-check text-truncate">
                            <input class="form-check-input me-4" value="No" type="radio" name="category_2_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckDefault">
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
                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">10)</span>
                            Please select your prefarred "Cheat-Day".</p>
                        </div>
                        <div class="col-lg -6 p-2">
                          <div class="form-groupz my-4">

                            <select class="custom-select form-control-select-input p-4" name="category_2_question_10_field" id="cheatday-selection" required>
                              <option value="Monday">Monday</option>
                              <option value="Tuesday">Tuesday</option>
                              <option value="Wednesday">Wednesday</option>
                              <option value="Thursday" selected="selected">Thursday</option>
                              <option value="Friday">Friday</option>
                              <option value="Saturday">Saturday</option>
                              <option value="Sunday">Sunday</option>
                            </select>

                          </div>

                        </div>
                      </div>
                      <!-- ./ Question: Please select your prefarred "Cheat-Day" -->

                      <hr class="text-white">

                      <!-- 11. Question: What will you do on your "Cheat-Day"? -->
                      <div class="row align-items-center">
                        <div class="col-lg-6 p-2 text-start">
                          <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">
                          sports_score
                        </span> -->
                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">11)</span>
                            What will you do on your "Cheat-Day"?</p>
                        </div>
                        <div class="col-lg -6 p-2">
                          <div class="form-group">
                            <p class=" text-center mb-4">I promise that I will only</p>
                            <textarea class="form-control-text-input p-4" style="border-radius: 25px !important;" rows="3" type="text" name="category_2_question_11_field" id="cheat-day-promise" placeholder=" … " required></textarea>
                            <p class="text-center mt-4">on my "cheat-day".</p>
                          </div>

                        </div>
                      </div>
                      <!-- ./ Question: What will you do on your "Cheat-Day"? -->

                      <!-- submit btn -->
                      <div class="d-grid justify-content-center">
                        <input id="submit-goalsetting-info-form" style="font-size: 20px !important;" class="onefit-buttons-style-tahiti p-4 text-center comfortaa-font shadow fw-bold" type="submit" value="Save.">
                      </div>

                      <!-- hidden aria-hidden="true" -->
                    </form>
                    <!-- ./ #goalsetting-info-form -->

                    <hr class="text-white" style="margin: 80px 0px;">

                    <!-- Procession Buttons -->
                    <div class="comfortaa-font text-center mt-4" style="margin-bottom: 40px; font-size: 20px;">
                      <div class="d-grid gap-0 w-100 text-white">
                        <span class="rounded-pill p-4" style="background-color: #343434;">
                          One<span style="color: #ffa500;">fit</span>.app
                        </span>

                        <span class="material-icons material-icons-outlined" style="color: #ffa500;">
                          horizontal_rule
                        </span>
                      </div>
                      <div class="row align-items-center">
                        <div class="col-lg py-4 d-grid">
                          <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow" id="aboutyou-back-panel-btn" onclick="survey_controller('goalsetting','aboutyou')">
                            <div class="d-grid gap-2 justify-content-center text-center fw-bold">
                              <span class="material-icons material-icons-round" style="font-size: 40px !important; color: #ffa500;">
                                arrow_back_ios </span>
                              <span>About you.</span>
                            </div>

                          </button>
                        </div>
                        <div class="col-lg py-4 d-grid">
                          <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow" id="fitprefs-next-panel-btn" onclick="survey_controller('goalsetting','fitprefs')">
                            <div class="d-grid gap-2 justify-content-center text-center fw-bold">
                              <span class="material-icons material-icons-round" style="font-size: 40px !important; color: #ffa500;">
                                arrow_forward_ios </span>
                              <span>Fitness Preferances.</span>
                            </div>

                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- ./ Procession Buttons -->

                  </div>
                </div>

              </div>
              <div class="tab-pane fade w3-animate-bottom comfortaa-font" id="category-fitness-prefs-tab-pane" role="tabpanel" aria-labelledby="category-fitness-prefs-tab" tabindex="0">

                <div class="my-4" id="category-fitness-prefs-tab-questions-pane">

                  <div class="p-4 content-panel-border-style shadow" style="border-radius: 25px; background: #343434;">
                    <h4 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end" style="border-radius: 25px; background-color: #343434; color: #fff; border-color: #ffa500; margin-bottom: 80px !important;">
                      Tell us about your Training History and Fitness Preferances.
                    </h4>

                    <div form="main-submission-form" id="emailHelp" class="form-text text-center fw-bold my-4" style=" color: #fff">We have a responsibility
                      to
                      keep your keep your Identity &amp; Privacy safe! <br>
                      - <a href="http://" style=" color: #ffa500;">Privacy
                        Policy</a> -
                    </div>

                    <hr class="text-white" style="margin: 80px 0px;">

                    <!-- #fitprefs-info-form -->
                    <!-- ../../scripts/php/main_app/data_management/system_admin/user_registration/submit/ -->
                    <form id="fitprefs-info-form" action="../../scripts/php/main_app/data_management/system_admin/user_registration/submit//fitprefs_submit.php" method="post" autocomplete="off">
                      <!-- user id hidden -->
                      <div class="form-group my-4">
                        <input class="form-control-text-input p-4" type="number" name="user_profile_id" id="user-profile-id-fitprefs" value="<?php echo $current_user_profile_id; ?>" placeholder="user profile id" required hidden aria-hidden="true" />
                      </div>
                      <!-- ./ user id hidden -->

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

                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">1)</span>
                            How fit are you?</p>

                        </div>
                        <div class="col-lg -8 p-2 text-truncate">
                          <!-- 
                          Not fit
                          Fit
                          Very fit
                          -->

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Not fit" type="radio" name="category_3_question_1_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Not fit
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Fit" type="radio" name="category_3_question_1_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Fit
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Very fit" type="radio" name="category_3_question_1_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Very fit
                            </label>
                          </div>

                        </div>
                      </div>

                      <hr class="text-white">

                      <!-- Question 2: When was the last time you were at your Ideal weight? -->
                      <div class="row align-items-center">
                        <div class="col-lg -4 p-2">

                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">2)</span>
                            When was the last time you were at your Ideal weight?</p>

                        </div>
                        <div class="col-lg -8 p-2 text-truncate">
                          <!-- 
                            Less than a year ago
                            1-2 years ago
                            More than 2 years ago
                            never
                          -->

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Less than a year ago" type="radio" name="category_3_question_2_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Less than a year ago
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="1-2 years ago" type="radio" name="category_3_question_2_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              1-2 years ago
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="More than 2 years ago" type="radio" name="category_3_question_2_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              More than 2 years ago
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Never" type="radio" name="category_3_question_2_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Never
                            </label>
                          </div>

                        </div>
                      </div>

                      <hr class="text-white">

                      <!-- Question 3: What is your body type? -->
                      <div class="row align-items-center">
                        <div class="col-lg -4 p-2">

                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">3)</span>
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

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Slim_Slender" type="radio" name="category_3_question_3_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Slim / Slender
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Ideal" type="radio" name="category_3_question_3_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Ideal
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Flabby" type="radio" name="category_3_question_3_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Flabby
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Heavy" type="radio" name="category_3_question_3_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Heavy
                            </label>
                          </div>

                          <!-- probably worth removing Obsese as an option -->
                          <!-- <div class="form-check mb-4 text-truncate">
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

                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">4)</span>
                            Do you suffer from any joint pain?</p>

                        </div>
                        <div class="col-lg -8 p-2 text-truncate">
                          <!-- 
                        Yes / No
                       -->

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Yes" type="radio" name="category_3_question_4_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Yes
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="No" type="radio" name="category_3_question_4_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              No
                            </label>
                          </div>

                        </div>
                      </div>

                      <hr class="text-white">

                      <!-- Question 5: How active are you in your daily life? -->
                      <div class="row align-items-center">
                        <div class="col-lg -4 p-2">

                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">5)</span>
                            How active are you in your daily life?</p>

                        </div>
                        <div class="col-lg -8 p-2 text-truncate">
                          <!-- 
                        Not active
                        Slightly active
                        Active
                        Very active
                       -->

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Not active" type="radio" name="category_3_question_5_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Not active
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Slightly active" type="radio" name="category_3_question_5_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Slightly active
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Active" type="radio" name="category_3_question_5_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Active
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Very active" type="radio" name="category_3_question_5_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Very active
                            </label>
                          </div>

                        </div>
                      </div>

                      <hr class="text-white">

                      <!-- Question 6: How are your energy levels during the day? -->
                      <div class="row align-items-center">
                        <div class="col-lg -4 p-2">

                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">6)</span>
                            How are your energy levels during the day?</p>

                        </div>
                        <div class="col-lg -8 p-2 text-truncate">
                          <!-- 
                        Stable throughout the day
                        I have energy for half the day / until around lunchtime
                        I always feel sleepy after meals
                       -->

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Stable throughout the day" type="radio" name="category_3_question_6_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Stable throughout the day
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="I have energy for half the day or until around lunchtime" type="radio" name="category_3_question_6_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              I have energy for half the day / until around lunchtime
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="I always feel sleepy after meals" type="radio" name="category_3_question_6_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              I always feel sleepy after meals
                            </label>
                          </div>

                        </div>
                      </div>

                      <hr class="text-white">

                      <!-- Question 7: How much do you sleep every night? -->
                      <div class="row align-items-center">
                        <div class="col-lg -4 p-2">

                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">7)</span>
                            How much do you sleep every night?</p>

                        </div>
                        <div class="col-lg -8 p-2 text-truncate">
                          <!-- 
                          More than 8 hours
                          7-8 hours
                          6-7 hours
                          less than 6 hours
                          -->

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="More than 8 hours" type="radio" name="category_3_question_7_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              More than 8 hours
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="7-8 hours" type="radio" name="category_3_question_7_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              7-8 hours
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="6-7 hours" type="radio" name="category_3_question_7_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              6-7 hours
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="less than 6 hours" type="radio" name="category_3_question_7_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              less than 6 hours
                            </label>
                          </div>

                        </div>
                      </div>

                      <hr class="text-white">

                      <!-- Question 8: What is your daily water intake? -->
                      <div class="row align-items-center">
                        <div class="col-lg -4 p-2">

                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">8)</span>
                            What is your daily water intake?</p>

                        </div>
                        <div class="col-lg -8 p-2 text-truncate">
                          <!-- 
                        more than 6 glasses
                        3 to 6 glasses
                        2 glasses
                        I only drink soft-drinks / coffee
                       -->

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="More than 6 glasses" type="radio" name="category_3_question_8_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              More than 6 glasses
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="3 to 6 glasses" type="radio" name="category_3_question_8_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              3 to 6 glasses
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="2 glasses" type="radio" name="category_3_question_8_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              2 glasses
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="I only drink soft-drinks or coffee" type="radio" name="category_3_question_8_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              I only drink soft-drinks / coffee
                            </label>
                          </div>

                        </div>
                      </div>

                      <hr class="text-white">

                      <!-- Question 9: Select the type of classes you are looing to do: -->
                      <div class="row align-items-center">
                        <div class="col-lg -4 p-2">

                          <p class="fs-5 comfortaa-font align-middle"><span class="fs-2" style="color: #ffa500;">9)</span>
                            Select the type of classes you are looing to do</p>

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

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Cardio" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Cardio
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Strength" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Strength
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="HIIT" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              HIIT
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Toning" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Toning
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Dance_Aerobics" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Dance / Aerobics
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Kickboxing" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Kickboxing
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="default" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Barre
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Pilates" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Pilates
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Meditation" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Meditation
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Stretch_Resistence" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Stretch / Resistence
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Yoga" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Yoga
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Spinning" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Spinning
                            </label>
                          </div>

                          <div class="form-check mb-4 text-truncate">
                            <input class="form-check-input me-4" value="Treadmill" type="checkbox" name="category_3_question_9_field[]" id="flexCheckDefault">
                            <label class="form-check-label p-2" for="flexCheckChecked">
                              Treadmill
                            </label>
                          </div>

                        </div>
                      </div>

                      <!-- submit btn -->
                      <div class="d-grid justify-content-center">
                        <input id="submit-fitprefs-info-form" class="onefit-buttons-style-tahiti p-4 text-center comfortaa-font shadow fw-bold" style="font-size: 20px !important;" type="submit" value="Save.">
                      </div>

                    </form>
                    <!-- ./ #fitprefs-info-form -->

                    <hr class="text-white" style="margin: 80px 0px;">

                    <!-- Procession Buttons -->
                    <div class="comfortaa-font text-center mt-4" style="margin-bottom: 40px; font-size: 20px;">
                      <div class="d-grid gap-0 w-100 text-white">
                        <span class="rounded-pill p-4" style="background-color: #343434;">
                          One<span style="color: #ffa500;">fit</span>.app
                        </span>

                        <span class="material-icons material-icons-outlined" style="color: #ffa500;">
                          horizontal_rule
                        </span>
                      </div>
                      <div class="row align-items-center">
                        <div class="col-lg py-4 d-grid">
                          <!--  gap-2 justify-content-center -->
                          <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow" id="goalsetting-back-panel-btn" onclick="survey_controller('fitprefs','goalsetting')">
                            <div class="d-grid gap-2 justify-content-center text-center fw-bold">
                              <span class="material-icons material-icons-round" style="font-size: 40px !important; color: #ffa500;">
                                arrow_back_ios </span>
                              <span>Goal setting.</span>
                            </div>

                          </button>
                        </div>
                        <div class="col-lg py-4 d-grid">
                          <!--  gap-2 justify-content-center -->
                          <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow" id="eu-agreements-next-panel-btn" onclick="survey_controller('finish','finish')">
                            <div class="d-grid gap-2 justify-content-center text-center fw-bold">
                              <span class="material-icons material-icons-round" style="font-size: 40px !important; color: #ffa500;">
                                check_circle_outline </span>
                              <span>Finish.</span>
                            </div>

                          </button>
                        </div>
                      </div>
                    </div>
                    <!-- ./ Procession Buttons -->

                  </div>

                </div>

              </div>
              <div class="tab-pane fade w3-animate-bottom comfortaa-font" id="category-eu-agreements-tab-pane" role="tabpanel" aria-labelledby="category-eu-agreements-tab" tabindex="0">

                <div class="my-4" id="category-eula-tab-questions-pane">

                  <div class="p-4 content-panel-border-style shadow" style="border-radius: 25px; background: #343434;">
                    <h1 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end" style="border-radius: 25px; background-color: #343434; color: #fff; border-color: #ffa500; margin-bottom: 80px !important;">
                      <span class="material-icons material-icons-round" style="color: #ffa500;">
                        looks_3
                      </span>
                      <span class="comfortaa-font">
                        <u>Terms of Use</u>
                      </span>
                    </h1>

                    <!-- Terms of Use -->
                    <div id="terms-container" class="text-white comfortaa-font px-2 mb-4" style="overflow-y: auto; max-height: 100vh;">

                      <h2 style="text-align: center;"><b>TERMS AND CONDITIONS</b></h2>
                      <p>Last updated: 2023-06-30</p>
                      <p>1. <b>Introduction</b></p>
                      <p>Welcome to <b>AdaptivConcept NPC</b> &#40;“Company”, “we”, “our”, “us”&#41;!</p>
                      <p>These Terms of Service &#40;“Terms”, “Terms of Service”&#41; govern your use of our website
                        located at
                        <b>Onefit.app</b> &#40;together or individually “Service”&#41; operated by <b>AdaptivConcept
                          NPC</b>.
                      </p>
                      <p>Our Privacy Policy also governs your use of our Service and explains how we collect, safeguard
                        and disclose
                        information that results from your use of our web pages.</p>
                      <p>Your agreement with us includes these Terms and our Privacy Policy &#40;“Agreements”&#41;. You
                        acknowledge that you
                        have read and understood Agreements, and agree to be bound of them.</p>
                      <p>If you do not agree with &#40;or cannot comply with&#41; Agreements, then you may not use the
                        Service,
                        but please let
                        us know by emailing at <b>admin@adaptivconcept.co.za</b> so we can try to find a solution. These
                        Terms apply
                        to all visitors, users and others who wish to access or use Service.</p>
                      <p>2. <b>Communications</b></p>
                      <p>By using our Service, you agree to subscribe to newsletters, marketing or promotional materials
                        and other
                        information we may send. However, you may opt out of receiving any, or all, of these
                        communications from us
                        by following the unsubscribe link or by emailing at admin@adaptivconcept.co.za.</p>
                      <p>3. <b>Purchases</b></p>
                      <p>If you wish to purchase any product or service made available through Service
                        &#40;“Purchase”&#41;, you
                        may be asked
                        to supply certain information relevant to your Purchase including but not limited to, your
                        credit or debit
                        card number, the expiration date of your card, your billing address, and your shipping
                        information.</p>
                      <p>You represent and warrant that: &#40;i&#41; you have the legal right to use any card&#40;s&#41;
                        or other
                        payment method&#40;s&#41; in
                        connection with any Purchase; and that &#40;ii&#41; the information you supply to us is true,
                        correct
                        and complete.
                      </p>
                      <p>We may employ the use of third party services for the purpose of facilitating payment and the
                        completion of
                        Purchases. By submitting your information, you grant us the right to provide the information to
                        these third
                        parties subject to our Privacy Policy.</p>
                      <p>We reserve the right to refuse or cancel your order at any time for reasons including but not
                        limited to:
                        product or service availability, errors in the description or price of the product or service,
                        error in your
                        order or other reasons.</p>
                      <p>We reserve the right to refuse or cancel your order if fraud or an unauthorized or illegal
                        transaction is
                        suspected.</p>
                      <p>4. <b>Contests, Sweepstakes and Promotions</b></p>
                      <p>Any contests, sweepstakes or other promotions &#40;collectively, “Promotions”&#41; made
                        available
                        through Service may
                        be governed by rules that are separate from these Terms of Service. If you participate in any
                        Promotions,
                        please review the applicable rules as well as our Privacy Policy. If the rules for a Promotion
                        conflict with
                        these Terms of Service, Promotion rules will apply.</p>
                      <p>5. <b>Subscriptions</b></p>
                      <p>Some parts of Service are billed on a subscription basis &#40;"Subscription&#40;s&#41;"&#41;.
                        You will be
                        billed in advance
                        on a recurring and periodic basis &#40;"Billing Cycle"&#41;. Billing cycles will be set
                        depending on the
                        type of
                        subscription plan you select when purchasing a Subscription.</p>
                      <p>At the end of each Billing Cycle, your Subscription will automatically renew under the exact
                        same conditions
                        unless you cancel it or AdaptivConcept NPC cancels it. You may cancel your Subscription renewal
                        either
                        through your online account management page or by contacting admin@adaptivconcept.co.za customer
                        support
                        team.</p>
                      <p>A valid payment method is required to process the payment for your subscription. You shall
                        provide
                        AdaptivConcept NPC with accurate and complete billing information that may include but not
                        limited to full
                        name, address, state, postal or zip code, telephone number, and a valid payment method
                        information. By
                        submitting such payment information, you automatically authorize AdaptivConcept NPC to charge
                        all
                        Subscription fees incurred through your account to any such payment instruments.</p>
                      <p>Should automatic billing fail to occur for any reason, AdaptivConcept NPC reserves the right to
                        terminate
                        your access to the Service with immediate effect.</p>
                      <p>6. <b>Free Trial</b></p>
                      <p>AdaptivConcept NPC may, at its sole discretion, offer a Subscription with a free trial for a
                        limited period
                        of time &#40;"Free Trial"&#41;.</p>
                      <p>You may be required to enter your billing information in order to sign up for Free Trial.</p>
                      <p>If you do enter your billing information when signing up for Free Trial, you will not be
                        charged by
                        AdaptivConcept NPC until Free Trial has expired. On the last day of Free Trial period, unless
                        you cancelled
                        your Subscription, you will be automatically charged the applicable Subscription fees for the
                        type of
                        Subscription you have selected.</p>
                      <p>At any time and without notice, AdaptivConcept NPC reserves the right to &#40;i&#41; modify
                        Terms of
                        Service of Free
                        Trial offer, or &#40;ii&#41; cancel such Free Trial offer.</p>
                      <p>7. <b>Fee Changes</b></p>
                      <p>AdaptivConcept NPC, in its sole discretion and at any time, may modify Subscription fees for
                        the
                        Subscriptions. Any Subscription fee change will become effective at the end of the then-current
                        Billing
                        Cycle.</p>
                      <p>AdaptivConcept NPC will provide you with a reasonable prior notice of any change in
                        Subscription fees to give
                        you an opportunity to terminate your Subscription before such change becomes effective.</p>
                      <p>Your continued use of Service after Subscription fee change comes into effect constitutes your
                        agreement to
                        pay the modified Subscription fee amount.</p>
                      <p>8. <b>Refunds</b></p>
                      <p>We issue refunds for Contracts within <b>30 days</b> of the original purchase of the Contract.
                      </p>
                      <p>9. <b>Content</b></p>
                      <p>Our Service allows you to post, link, store, share and otherwise make available certain
                        information, text,
                        graphics, videos, or other material &#40;“Content”&#41;. You are responsible for Content that
                        you post
                        on or through
                        Service, including its legality, reliability, and appropriateness.</p>
                      <p>By posting Content on or through Service, You represent and warrant that: &#40;i&#41; Content
                        is yours
                        &#40;you own it&#41;
                        and/or you have the right to use it and the right to grant us the rights and license as provided
                        in these
                        Terms, and &#40;ii&#41; that the posting of your Content on or through Service does not violate
                        the
                        privacy rights,
                        publicity rights, copyrights, contract rights or any other rights of any person or entity. We
                        reserve the
                        right to terminate the account of anyone found to be infringing on a copyright.</p>
                      <p>You retain any and all of your rights to any Content you submit, post or display on or through
                        Service and
                        you are responsible for protecting those rights. We take no responsibility and assume no
                        liability for
                        Content you or any third party posts on or through Service. However, by posting Content using
                        Service you
                        grant us the right and license to use, modify, publicly perform, publicly display, reproduce,
                        and distribute
                        such Content on and through Service. You agree that this license includes the right for us to
                        make your
                        Content available to other users of Service, who may also use your Content subject to these
                        Terms.</p>
                      <p>AdaptivConcept NPC has the right but not the obligation to monitor and edit all Content
                        provided by users.
                      </p>
                      <p>In addition, Content found on or through this Service are the property of AdaptivConcept NPC or
                        used with
                        permission. You may not distribute, modify, transmit, reuse, download, repost, copy, or use said
                        Content,
                        whether in whole or in part, for commercial purposes or for personal gain, without express
                        advance written
                        permission from us.</p>
                      <p>10. <b>Prohibited Uses</b></p>
                      <p>You may use Service only for lawful purposes and in accordance with Terms. You agree not to use
                        Service:</p>
                      <p>0.1. In any way that violates any applicable national or international law or regulation.</p>
                      <p>0.2. For the purpose of exploiting, harming, or attempting to exploit or harm minors in any way
                        by exposing
                        them to inappropriate content or otherwise.</p>
                      <p>0.3. To transmit, or procure the sending of, any advertising or promotional material, including
                        any “junk
                        mail”, “chain letter,” “spam,” or any other similar solicitation.</p>
                      <p>0.4. To impersonate or attempt to impersonate Company, a Company employee, another user, or any
                        other person
                        or entity.</p>
                      <p>0.5. In any way that infringes upon the rights of others, or in any way is illegal,
                        threatening, fraudulent,
                        or harmful, or in connection with any unlawful, illegal, fraudulent, or harmful purpose or
                        activity.</p>
                      <p>0.6. To engage in any other conduct that restricts or inhibits anyone&#39;s use or enjoyment of
                        Service, or
                        which, as determined by us, may harm or offend Company or users of Service or expose them to
                        liability.</p>
                      <p>Additionally, you agree not to:</p>
                      <p>0.1. Use Service in any manner that could disable, overburden, damage, or impair Service or
                        interfere with
                        any other party&#39;s use of Service, including their ability to engage in real time activities
                        through Service.
                      </p>
                      <p>0.2. Use any robot, spider, or other automatic device, process, or means to access Service for
                        any purpose,
                        including monitoring or copying any of the material on Service.</p>
                      <p>0.3. Use any manual process to monitor or copy any of the material on Service or for any other
                        unauthorized
                        purpose without our prior written consent.</p>
                      <p>0.4. Use any device, software, or routine that interferes with the proper working of Service.
                      </p>
                      <p>0.5. Introduce any viruses, trojan horses, worms, logic bombs, or other material which is
                        malicious or
                        technologically harmful.</p>
                      <p>0.6. Attempt to gain unauthorized access to, interfere with, damage, or disrupt any parts of
                        Service, the
                        server on which Service is stored, or any server, computer, or database connected to Service.
                      </p>
                      <p>0.7. Attack Service via a denial-of-service attack or a distributed denial-of-service attack.
                      </p>
                      <p>0.8. Take any action that may damage or falsify Company rating.</p>
                      <p>0.9. Otherwise attempt to interfere with the proper working of Service.</p>
                      <p>11. <b>Analytics</b></p>
                      <p>We may use third-party Service Providers to monitor and analyze the use of our Service.</p>
                      <p>12. <b>No Use By Minors</b></p>
                      <p>Service is intended only for access and use by individuals at least eighteen &#40;18&#41; years
                        old. By
                        accessing or
                        using Service, you warrant and represent that you are at least eighteen &#40;18&#41; years of
                        age and
                        with the full
                        authority, right, and capacity to enter into this agreement and abide by all of the terms and
                        conditions of
                        Terms. If you are not at least eighteen &#40;18&#41; years old, you are prohibited from both the
                        access
                        and usage of
                        Service.</p>
                      <p>13. <b>Accounts</b></p>
                      <p>When you create an account with us, you guarantee that you are above the age of 18, and that
                        the information
                        you provide us is accurate, complete, and current at all times. Inaccurate, incomplete, or
                        obsolete
                        information may result in the immediate termination of your account on Service.</p>
                      <p>You are responsible for maintaining the confidentiality of your account and password, including
                        but not
                        limited to the restriction of access to your computer and/or account. You agree to accept
                        responsibility for
                        any and all activities or actions that occur under your account and/or password, whether your
                        password is
                        with our Service or a third-party service. You must notify us immediately upon becoming aware of
                        any breach
                        of security or unauthorized use of your account.</p>
                      <p>You may not use as a username the name of another person or entity or that is not lawfully
                        available for use,
                        a name or trademark that is subject to any rights of another person or entity other than you,
                        without
                        appropriate authorization. You may not use as a username any name that is offensive, vulgar or
                        obscene.</p>
                      <p>We reserve the right to refuse service, terminate accounts, remove or edit content, or cancel
                        orders in our
                        sole discretion.</p>
                      <p>14. <b>Intellectual Property</b></p>
                      <p>Service and its original content &#40;excluding Content provided by users&#41;, features and
                        functionality are and
                        will remain the exclusive property of AdaptivConcept NPC and its licensors. Service is protected
                        by
                        copyright, trademark, and other laws of and foreign countries. Our trademarks may not be used in
                        connection
                        with any product or service without the prior written consent of AdaptivConcept NPC.</p>
                      <p>15. <b>Copyright Policy</b></p>
                      <p>We respect the intellectual property rights of others. It is our policy to respond to any claim
                        that Content
                        posted on Service infringes on the copyright or other intellectual property rights
                        &#40;“Infringement”&#41; of any
                        person or entity.</p>
                      <p>If you are a copyright owner, or authorized on behalf of one, and you believe that the
                        copyrighted work has
                        been copied in a way that constitutes copyright infringement, please submit your claim via email
                        to
                        admin@adaptivconcept.co.za, with the subject line: “Copyright Infringement” and include in your
                        claim a
                        detailed description of the alleged Infringement as detailed below, under “DMCA Notice and
                        Procedure for
                        Copyright Infringement Claims”</p>
                      <p>You may be held accountable for damages &#40;including costs and attorneys&#39; fees&#41; for
                        misrepresentation or
                        bad-faith claims on the infringement of any Content found on and/or through Service on your
                        copyright.</p>
                      <p>16. <b>DMCA Notice and Procedure for Copyright Infringement Claims</b></p>
                      <p>You may submit a notification pursuant to the Digital Millennium Copyright Act &#40;DMCA&#41;
                        by
                        providing our
                        Copyright Agent with the following information in writing &#40;see 17 U.S.C
                        512&#40;c&#41;&#40;3&#41; for further
                        detail&#41;:</p>
                      <p>0.1. an electronic or physical signature of the person authorized to act on behalf of the owner
                        of the
                        copyright&#39;s interest;</p>
                      <p>0.2. a description of the copyrighted work that you claim has been infringed, including the URL
                        &#40;i.e., web
                        page address&#41; of the location where the copyrighted work exists or a copy of the copyrighted
                        work;</p>
                      <p>0.3. identification of the URL or other specific location on Service where the material that
                        you claim is
                        infringing is located;</p>
                      <p>0.4. your address, telephone number, and email address;</p>
                      <p>0.5. a statement by you that you have a good faith belief that the disputed use is not
                        authorized by the
                        copyright owner, its agent, or the law;</p>
                      <p>0.6. a statement by you, made under penalty of perjury, that the above information in your
                        notice is accurate
                        and that you are the copyright owner or authorized to act on the copyright owner&#39;s behalf.
                      </p>
                      <p>You can contact our Copyright Agent via email at admin@adaptivconcept.co.za.</p>
                      <p>17. <b>Error Reporting and Feedback</b></p>
                      <p>You may provide us either directly at admin@adaptivconcept.co.za or via third party sites and
                        tools with
                        information and feedback concerning errors, suggestions for improvements, ideas, problems,
                        complaints, and
                        other matters related to our Service &#40;“Feedback”&#41;. You acknowledge and agree that:
                        &#40;i&#41; you shall
                        not retain,
                        acquire or assert any intellectual property right or other right, title or interest in or to the
                        Feedback;
                        &#40;ii&#41; Company may have development ideas similar to the Feedback; &#40;iii&#41; Feedback
                        does not contain
                        confidential information or proprietary information from you or any third party; and
                        &#40;iv&#41;
                        Company is not
                        under any obligation of confidentiality with respect to the Feedback. In the event the transfer
                        of the
                        ownership to the Feedback is not possible due to applicable mandatory laws, you grant Company
                        and its
                        affiliates an exclusive, transferable, irrevocable, free-of-charge, sub-licensable, unlimited
                        and perpetual
                        right to use &#40;including copy, modify, create derivative works, publish, distribute and
                        commercialize&#41;
                        Feedback in any manner and for any purpose.</p>
                      <p>18. <b>Links To Other Web Sites</b></p>
                      <p>Our Service may contain links to third party web sites or services that are not owned or
                        controlled by
                        AdaptivConcept NPC.</p>
                      <p>AdaptivConcept NPC has no control over, and assumes no responsibility for the content, privacy
                        policies, or
                        practices of any third party web sites or services. We do not warrant the offerings of any of
                        these
                        entities/individuals or their websites.</p>
                      <p>For example, the outlined <a href="https://policymaker.io/terms-and-conditions/">Terms of
                          Use</a> have been
                        created using <a href="https://policymaker.io/">PolicyMaker.io</a>, a free web application for
                        generating
                        high-quality legal documents. PolicyMaker&#39;s <a href="https://policymaker.io/terms-and-conditions/">Terms and
                          Conditions generator</a> is an easy-to-use free tool for creating an excellent standard Terms
                        of Service
                        template for a website, blog, e-commerce store or app.</p>
                      <p>YOU ACKNOWLEDGE AND AGREE THAT COMPANY SHALL NOT BE RESPONSIBLE OR LIABLE, DIRECTLY OR
                        INDIRECTLY, FOR ANY
                        DAMAGE OR LOSS CAUSED OR ALLEGED TO BE CAUSED BY OR IN CONNECTION WITH USE OF OR RELIANCE ON ANY
                        SUCH
                        CONTENT, GOODS OR SERVICES AVAILABLE ON OR THROUGH ANY SUCH THIRD PARTY WEB SITES OR SERVICES.
                      </p>
                      <p>WE STRONGLY ADVISE YOU TO READ THE TERMS OF SERVICE AND PRIVACY POLICIES OF ANY THIRD PARTY WEB
                        SITES OR
                        SERVICES THAT YOU VISIT.</p>
                      <p>19. <b>Disclaimer Of Warranty</b></p>
                      <p>THESE SERVICES ARE PROVIDED BY COMPANY ON AN “AS IS” AND “AS AVAILABLE” BASIS. COMPANY MAKES NO
                        REPRESENTATIONS OR WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, AS TO THE OPERATION OF THEIR
                        SERVICES, OR THE
                        INFORMATION, CONTENT OR MATERIALS INCLUDED THEREIN. YOU EXPRESSLY AGREE THAT YOUR USE OF THESE
                        SERVICES,
                        THEIR CONTENT, AND ANY SERVICES OR ITEMS OBTAINED FROM US IS AT YOUR SOLE RISK.</p>
                      <p>NEITHER COMPANY NOR ANY PERSON ASSOCIATED WITH COMPANY MAKES ANY WARRANTY OR REPRESENTATION
                        WITH RESPECT TO
                        THE COMPLETENESS, SECURITY, RELIABILITY, QUALITY, ACCURACY, OR AVAILABILITY OF THE SERVICES.
                        WITHOUT
                        LIMITING THE FOREGOING, NEITHER COMPANY NOR ANYONE ASSOCIATED WITH COMPANY REPRESENTS OR
                        WARRANTS THAT THE
                        SERVICES, THEIR CONTENT, OR ANY SERVICES OR ITEMS OBTAINED THROUGH THE SERVICES WILL BE
                        ACCURATE, RELIABLE,
                        ERROR-FREE, OR UNINTERRUPTED, THAT DEFECTS WILL BE CORRECTED, THAT THE SERVICES OR THE SERVER
                        THAT MAKES IT
                        AVAILABLE ARE FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS OR THAT THE SERVICES OR ANY SERVICES
                        OR ITEMS
                        OBTAINED THROUGH THE SERVICES WILL OTHERWISE MEET YOUR NEEDS OR EXPECTATIONS.</p>
                      <p>COMPANY HEREBY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, STATUTORY, OR
                        OTHERWISE,
                        INCLUDING BUT NOT LIMITED TO ANY WARRANTIES OF MERCHANTABILITY, NON-INFRINGEMENT, AND FITNESS
                        FOR PARTICULAR
                        PURPOSE.</p>
                      <p>THE FOREGOING DOES NOT AFFECT ANY WARRANTIES WHICH CANNOT BE EXCLUDED OR LIMITED UNDER
                        APPLICABLE LAW.</p>
                      <p>20. <b>Limitation Of Liability</b></p>
                      <p>EXCEPT AS PROHIBITED BY LAW, YOU WILL HOLD US AND OUR OFFICERS, DIRECTORS, EMPLOYEES, AND
                        AGENTS HARMLESS FOR
                        ANY INDIRECT, PUNITIVE, SPECIAL, INCIDENTAL, OR CONSEQUENTIAL DAMAGE, HOWEVER IT ARISES
                        &#40;INCLUDING
                        ATTORNEYS&#39; FEES AND ALL RELATED COSTS AND EXPENSES OF LITIGATION AND ARBITRATION, OR AT
                        TRIAL OR
                        ON APPEAL,
                        IF ANY, WHETHER OR NOT LITIGATION OR ARBITRATION IS INSTITUTED&#41;, WHETHER IN AN ACTION OF
                        CONTRACT,
                        NEGLIGENCE, OR OTHER TORTIOUS ACTION, OR ARISING OUT OF OR IN CONNECTION WITH THIS AGREEMENT,
                        INCLUDING
                        WITHOUT LIMITATION ANY CLAIM FOR PERSONAL INJURY OR PROPERTY DAMAGE, ARISING FROM THIS AGREEMENT
                        AND ANY
                        VIOLATION BY YOU OF ANY FEDERAL, STATE, OR LOCAL LAWS, STATUTES, RULES, OR REGULATIONS, EVEN IF
                        COMPANY HAS
                        BEEN PREVIOUSLY ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. EXCEPT AS PROHIBITED BY LAW, IF THERE
                        IS
                        LIABILITY FOUND ON THE PART OF COMPANY, IT WILL BE LIMITED TO THE AMOUNT PAID FOR THE PRODUCTS
                        AND/OR
                        SERVICES, AND UNDER NO CIRCUMSTANCES WILL THERE BE CONSEQUENTIAL OR PUNITIVE DAMAGES. SOME
                        STATES DO NOT
                        ALLOW THE EXCLUSION OR LIMITATION OF PUNITIVE, INCIDENTAL OR CONSEQUENTIAL DAMAGES, SO THE PRIOR
                        LIMITATION
                        OR EXCLUSION MAY NOT APPLY TO YOU.</p>
                      <p>21. <b>Termination</b></p>
                      <p>We may terminate or suspend your account and bar access to Service immediately, without prior
                        notice or
                        liability, under our sole discretion, for any reason whatsoever and without limitation,
                        including but not
                        limited to a breach of Terms.</p>
                      <p>If you wish to terminate your account, you may simply discontinue using Service.</p>
                      <p>All provisions of Terms which by their nature should survive termination shall survive
                        termination,
                        including, without limitation, ownership provisions, warranty disclaimers, indemnity and
                        limitations of
                        liability.</p>
                      <p>22. <b>Governing Law</b></p>
                      <p>These Terms shall be governed and construed in accordance with the laws of South Africa, which
                        governing law
                        applies to agreement without regard to its conflict of law provisions.</p>
                      <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of
                        those rights.
                        If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining
                        provisions
                        of these Terms will remain in effect. These Terms constitute the entire agreement between us
                        regarding our
                        Service and supersede and replace any prior agreements we might have had between us regarding
                        Service.</p>
                      <p>23. <b>Changes To Service</b></p>
                      <p>We reserve the right to withdraw or amend our Service, and any service or material we provide
                        via Service, in
                        our sole discretion without notice. We will not be liable if for any reason all or any part of
                        Service is
                        unavailable at any time or for any period. From time to time, we may restrict access to some
                        parts of
                        Service, or the entire Service, to users, including registered users.</p>
                      <p>24. <b>Amendments To Terms</b></p>
                      <p>We may amend Terms at any time by posting the amended terms on this site. It is your
                        responsibility to review
                        these Terms periodically.</p>
                      <p>Your continued use of the Platform following the posting of revised Terms means that you accept
                        and agree to
                        the changes. You are expected to check this page frequently so you are aware of any changes, as
                        they are
                        binding on you.</p>
                      <p>By continuing to access or use our Service after any revisions become effective, you agree to
                        be bound by the
                        revised terms. If you do not agree to the new terms, you are no longer authorized to use
                        Service.</p>
                      <p>25. <b>Waiver And Severability</b></p>
                      <p>No waiver by Company of any term or condition set forth in Terms shall be deemed a further or
                        continuing
                        waiver of such term or condition or a waiver of any other term or condition, and any failure of
                        Company to
                        assert a right or provision under Terms shall not constitute a waiver of such right or
                        provision.</p>
                      <p>If any provision of Terms is held by a court or other tribunal of competent jurisdiction to be
                        invalid,
                        illegal or unenforceable for any reason, such provision shall be eliminated or limited to the
                        minimum extent
                        such that the remaining provisions of Terms will continue in full force and effect.</p>
                      <p>26. <b>Acknowledgement</b></p>
                      <p>BY USING SERVICE OR OTHER SERVICES PROVIDED BY US, YOU ACKNOWLEDGE THAT YOU HAVE READ THESE
                        TERMS OF SERVICE
                        AND AGREE TO BE BOUND BY THEM.</p>
                      <p>27. <b>Contact Us</b></p>
                      <p>Please send your feedback, comments, requests for technical support by email:
                        <b>admin@adaptivconcept.co.za</b>.
                      </p>
                      <p style="margin-top: 5em; font-size: 0.7em;">These <a href="https://policymaker.io/terms-and-conditions/">Terms
                          of Service</a> were created for <b>Onefit.app</b> by <a href="https://policymaker.io">PolicyMaker.io</a>
                        on 2023-06-30.</p>

                    </div>
                    <!-- ./ Terms of Use -->

                    <hr class="text-white">

                    <!-- #policy-info-form -->
                    <!--<?php echo $output; ?>-->
                    <!-- ../../scripts/php/main_app/data_management/system_admin/user_registration/submit -->
                    <form id="tou-policy-info-form" action="../../scripts/php/main_app/data_management/system_admin/user_registration/submit/policy_acceptance_submit.php?user_id=<?php echo $current_user_id; ?>&agree_tou=true" method="post" autocomplete="off">
                      <!-- user id hidden -->
                      <div class="form-group my-4">
                        <input class="form-control-text-input p-4" type="number" name="tou_user_id" id="user-id-policy-tou" value="<?php echo $current_user_id; ?>" placeholder="user id" required hidden aria-hidden="true" />
                      </div>
                      <!-- ./ user id hidden -->

                      <div class="d-grid gap-4 justify-content-center">
                        <div class="form-check align-items-center align-middle">
                          <!-- form-check-inline form-switch -->
                          <input class="form-check-input me-4" value="accepted-terms" type="checkbox" role="switch" name="agree_terms" id="agree-terms" onchange="termsAcceptanceState()">
                          <label class="form-check-label p-2 align-middle pt-2" for="agree-terms">Do you agree to the
                            above Terms of Use?</label>
                        </div>
                      </div>

                      <!-- submit btn -->
                      <!-- <div class="d-block justify-content-center">
                        <input id="submit-policy-info-form" style="font-size: 40px !important;" class="onefit-buttons-style-tahiti p-4 text-center comfortaa-font shadow" type="submit" value="submit">
                      </div> -->

                      <hr class="text-white" style="margin-bottom: 80px;">

                      <!-- Procession Buttons -->
                      <div class="comfortaa-font text-center mt-4" style="margin-bottom: 40px; font-size: 20px;">
                        <div class="d-grid gap-0 w-100 text-white">
                          <span class="rounded-pill p-4" style="background-color: #343434;">
                            One<span style="color: #ffa500;">fit</span>.app
                          </span>

                          <span class="material-icons material-icons-outlined" style="color: #ffa500;">
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
                                  <span class="material-icons material-icons-round p-4" style="font-size: 80px !important; background-color: #c20000; color: #fff; border-radius: 25px;">
                                    rule </span>
                                </div>

                                <span>Please accept the Terms of Use to complete your profile.</span>
                              </div>
                            </div>
                            <!-- ./ Terms of Use Acceptence Message -->

                            <button form="tou-policy-info-form" class="onefit-buttons-style-dark p-4 text-center comfortaa-font shadow" type="submit" class="my-4 p-4 onefit-buttons-style-dark btn-lg" id="final-submit-data-btn" style="display: none;">
                              <!--  onclick="survey_controller('fwd','finish')" -->
                              <div class="d-grid gap-2 justify-content-center text-center fw-bold">
                                <span class="material-icons material-icons-round" style="font-size: 40px !important; color: #ffa500;">
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
                        var submitDataBtn = document.getElementById("final-submit-data-btn");
                        var termsAcceptenceMsg = document.getElementById("terms-acceptence-msg");

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
  <button id="toggleTabProfileImgModalBtn" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tabProfileImgModal" hidden>
    Launch #tabProfileImgModal</button>

  <!-- >>>>>>>>>> Tab Navigation Modal -->
  <div class="modal fade" id="tabProfileImgModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tabProfileImgModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
      <div class="modal-content feature-tab-nav-content content-panel-border-stylez">
        <!-- style="border-bottom: #ffa500 5px solid;" -->
        <div class="modal-header border-0">
          <h5 class="modal-title align-middle" id="tabProfileImgModalLabel">
            <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">
              account_circle
            </span>
            <span class=" align-middle">Upload your profle picture and banner image</span>
          </h5>
          <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="modal" aria-label="Close">
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
            <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">add_a_photo</span>
            <span class="align-middle">Profle Picture</span><span style="color: #ffa500;">.</span>
          </h1>

          <!-- image preview -->
          <div class="in-div-button-container text-center d-grid justify-content-center" style="max-width: none !important;">

            <div class="d-grid justify-content-center">
              <img src="../../media/profiles/<?php echo $current_user_prof_img; ?>" id="prof-pic-img-preview" class="img-fluid shadow my-4" style="border-radius: 25px; border-bottom: #ffa500 solid 5px;" alt="placeholder">
            </div>


            <button class="onefit-buttons-style-dark shadow in-div-btn text-center p-3 m-4 shadow" onclick="launchProfileImgsEditor()">
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
            <form class="d-grid justify-content-center" method="post" id="uploadProfileImgForm" enctype="multipart/form-data" action="../upload/prof-img-upload.php">
              <label for="profpicformFileLg" class="form-label comfortaa-font text-center">Choose an image.</label>
              <input class="form-control form-control-lg" id="profpicformFileLg" name="profpicformFileLg" type="file">
              <input id="submit-profpicformFileLg" type="submit" value="submit" hidden aria-hidden="true">
            </form>

            <!-- upload process spinner -->
            <div class="d-grid justify-content-center mt-4">
              <div id="prof-img-spinner text-warning" role="status" class="spinner-border text-center" style="width: 3rem; height: 3rem; display: none;" role="status">
                <span class="visually-hidden">uploading profile image</span>
              </div>

            </div>
            <!-- upload process spinner -->
          </div>

          <hr class="text-white" style="margin: 40px 0;">

          <h1 class="text-center my-4">
            <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">wallpaper</span>
            <span class="align-middle">Profle Banner</span><span style="color: #ffa500;">.</span>
          </h1>

          <!-- image preview -->
          <div id="prof-banner-img-preview" class="shadow-lg my-4" style="border-bottom: #ffa500 solid 5px; border-radius: 25px; height: 400px; width: 100%; overflow: hidden; background-image: url('../../media/profiles/<?php echo $current_user_prof_banner; ?>'); background-position: center; background-attachment: local; background-clip: content-box; background-size: cover">
          </div>
          <!-- ./ image preview -->

          <div class="d-grid justify-content-center" style="margin-bottom: 40px;">
            <form class="d-grid justify-content-center" method="post" id="uploadBannerImgForm" enctype="multipart/form-data" action="../upload/prof-banner-upload.php">
              <label for="profbannerformFileLg" class="form-label comfortaa-font text-center">Choose an image.</label>
              <input class="form-control form-control-lg" id="profbannerformFileLg" name="profbannerformFileLg" type="file">
              <input id="submit-profbannerformFileLg" type="submit" value="submit" hidden aria-hidden="true">
            </form>

            <!-- upload process spinner -->
            <div class="d-grid justify-content-center mt-4">
              <div id="banner-img-spinner text-warning" role="status" class="spinner-border text-center" style="width: 3rem; height: 3rem; display: none;" role="status">
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
                style="color: #ffa500 !important">fit</span>.Social</button>
          </div> -->
      </div>
    </div>
  </div>
  <!-- ./ >>>>>>>>>> Tab Navigation Modal -->
  <!-- ./ Modals -->

  <script>
    let aboutyouFormSubmitStatus = false;
    let goalsettingFormSubmitStatus = false;
    let fitprefFormSubmitStatus = false;
    let eulaPolicyFormSubmitStatus = false;
    let touPolicyFormSubmitStatus = false;

    function storeCurrentUserId(user_id) {
      var currentUserId = user_id;

      localStorage.setItem("registration_user_id", currentUserId);
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
        document.getElementById("tab-title-header-display").innerHTML = `<h5 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end sticky-top" style="border-radius: 25px; background-color: var(--mineshaft);color: var(--white) !important;border-color: var(--tahitigold) !important;"> About You </h5>`; //"About You";
        document.getElementById("category-about-you-tab").click();

      } else if (tab == "goalsetting") {
        // goal setting
        document.getElementById("tab-title-header-display").innerHTML = `<h5 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end sticky-top" style="border-radius: 25px; background-color: var(--mineshaft);color: var(--white) !important;border-color: var(--tahitigold) !important;"> Goal Setting </h5>`; //"Goal Setting";
        document.getElementById("category-goal-setting-tab").click();

      } else if (tab == "fitprefs") {
        // fitness preferences
        document.getElementById("tab-title-header-display").innerHTML = `<h5 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end sticky-top" style="border-radius: 25px; background-color: var(--mineshaft);color: var(--white) !important;border-color: var(--tahitigold) !important;"> Fitness Preferences </h5>`; //"Fitness Preferences";
        document.getElementById("category-fitness-prefs-tab").click();

      } else if (tab == "finish" || tab == "eu-agreements") {
        // end-user agreements
        document.getElementById("tab-title-header-display").innerHTML = `<h5 class="d-grid gap-2 p-4 rounded-pillz align-items-center justify-content-center align-middle text-center my-4 border-5 border-start border-end sticky-top" style="border-radius: 25px; background-color: var(--mineshaft);color: var(--white) !important;border-color: var(--tahitigold) !important;"> Terms of Use Policy </h5>`; //"Policy / Licence Agreements";
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>