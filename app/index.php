<?php
session_start();
require("../scripts/php/config.php");
require('../scripts/php/functions.php');

//Connection Test==============================================>
if ($dbconn->connect_error) die("Fatal Error");
//end of Connection Test============================================>

// declaring variables
$userAuth = false;
$currentUser_Usrnm = "";

//output/display variables
$outputSocialItems = $outputProfileUserSubsGroupsList = $outputProfileUsersPostsList = $outputProfileUsersResourcesList = $outputProfileUsersProgramsList = $outputProfileUserFriendsList = $outputProfileUsersFavesList = $outputProfileUserMediaList = $outputProfileUserNotifications = $outputProfileUserChats = $outputProfileUserPref = $outputProfileUserChallenges = null;

// misc
$currentuser_img_url = $otheruser_img_url = $verifIcon = $otherUserverifIcon = $output_msg = $app_err_msg = $output = null;
$uctDateTime = new DateTime(date('Y-m-d H:i:s'));
$uctDateTime->setTimezone(new DateTimeZone("UTC"));

// ******* code to initialize the app profile details *******
// check if user is authanticated and execute user profile initialization
if (isset($_SESSION["currentUserAuth"])) {
    if ($_SESSION["currentUserAuth"] === true) {
        // assign data to variables
        $userAuth = sanitizeString($_SESSION["currentUserAuth"]);
        $currentUser_Usrnm = sanitizeString($_SESSION["currentUserUsername"]);

        // *** Load App Content
        // get the user profile information from the db
        $sql = "SELECT * FROM users u INNER JOIN general_user_profiles gup ON u.username = gup.users_username WHERE u.username = '$currentUser_Usrnm';";

        $result = $dbconn->query($sql);

        if (!$result) die("An error occurred while trying to process this request.");

        $rows = $result->num_rows;

        if ($rows  == 0) die("An error occurred while trying to process this request (user not found).");
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            // gup: `user_profile_id`, `about`, `profile_type`, `verification`, `profile_url`, `profile_image_url`, `profile_banner_url`, `users_username`
            // u: `user_id`, `username`, `password_hash`, `user_name`, `user_surname`, `id_number`, `user_email`, `contact_number`, `date_of_birth`, `user_gender`, `user_race`, `user_nationality`, `account_active`
            $usr_userid = $row["user_id"];
            $usrprof_username = $row["username"];
            $usrprof_name = $row["user_name"];
            $usrprof_surname = $row["user_surname"];
            $usrprof_idnumber = $row["id_number"];
            $usrprof_email = $row["user_email"];
            $usrprof_contact = $row["contact_number"];
            $usrprof_dob = $row["date_of_birth"];
            $usrprof_gender = $row["user_gender"];
            $usrprof_race = $row["user_race"];
            $usrprof_nationality = $row["user_nationality"];
            $usrprof_acc_active = $row["account_active"];

            $usr_profileid = $row["user_profile_id"];
            $usr_about = $row["about"];
            $usr_profiletype = $row["profile_type"];
            $usr_profileurl = $row["profile_url"];
            $usr_profilepicurl = $row["profile_image_url"];
            $usr_profilebannerurl = $row["profile_banner_url"];
            $usr_verification = $row["verification"];
        }

        if ($usr_profilepicurl == "default" || $usr_profilepicurl == null || $usr_profilepicurl == "") {
            $usr_profilepicurl = "../media/profiles/0_default/default_profile_pic.svg";
        }

        $currentUserAccountProdImg = '<div class="social-update-profile-pic shadow" style="background-position: center !important; background-size: contain !important; background-repeat: no-repeat !important; background-attachment: local !important; height: 150px !important; width:  150px !important; background: url(' . "'$usr_profilepicurl'" . ') !important"></div>';


        $outputSocialItems = getUserSocials();
        $outputProfileUserSubsGroupsList = getUserGroups();
        $outputProfileUsersPostsList = getUserUpdates();
        $outputProfileUsersResourcesList = getUserResources();
        $outputProfileUsersProgramsList = getUserProgSubs();
        $outputProfileUserFriendsList = getUserFriends();
        $outputProfileUsersFavesList = getUserSaves();
        $outputProfileUserMediaList = getUserMedia();
        $outputProfileUserNotifications = getUserNotifications();
        $outputProfileUserChats = getUserChatConversations();
        $outputProfileUserPref = getUserPref();
        $outputProfileUserChallenges = getUserChallenges();

        // get the community content
        $outputCommunityGroups = getCommunityGroups();
        $outputCommunityNews = getCommunityNews();
        $outputCommunityResources = getCommunityResources();
        $outputCommunityUpdates = getCommunityUpdates();

        // get the discovery content
        $discoveryAllUsersList = getAllUsers();
        $discoveryFitProgsIndi = getFitProgramsIndi();
        $discoveryFitProgsTeams = getFitProgramsTeams();
        $discoveryAllTrainees = getAllTrainees();
        $discoveryAllTrainers = getAllTrainers();

        // verification icon
        if ($usr_verification == true) {
            $verifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
        } else {
            $verifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> groups </span>';
        }

        // call to compile exercise list
        $workout_activities_list = compileSelectInputExerciseList();

        // done.
    } else {
        //destroy session,
        header("Location: ../scripts/php/destroy_session.php");
    }
} else {
    //destroy session,
    $currentUser_Usrnm = "onefitguest_" . generateAlphaNumericRandomString(8) . "_" . generateNumericRandomString(4);
    header("Location: ../scripts/php/destroy_session.php?gulog=$currentUser_Usrnm");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $usrprof_name . " " . $usrprof_surname; ?> - Onefit.app&trade; | Onefit.Net&reg; &copy; <?php echo date('Y'); ?></title>

    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

    <!-- Google Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- Plyr.io Media Player -->
    <link rel="stylesheet" href="https://cdn.plyr.io/1.8.2/plyr.css">

    <!-- Plry.io JS CDN -->
    <script src="https://cdn.plyr.io/1.8.2/plyr.js"></script>
    <script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>

    <!-- Bootstrap local -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- W3 CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />

    <!-- My CSS styles -->
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/digital-clock.css" />
    <link rel="stylesheet" href="../css/timeline-styles.css" />

    <!-- Site Scripts -->
    <script src="../scripts/js/script.js"></script>
    <script src="../scripts/js/api_requests.js"></script>

    <!-- ./ Site Scripts -->

    <!-- JQuery local -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>

    <!-- JQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- ./ JQuery CDN -->

    <!-- For Digital Clock Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script>
    <!-- ./ For Digital Clock Plugin -->

    <!-- Map Highlight -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/maphilight/1.4.0/jquery.maphilight.min.js"></script>
    <script src="../scripts/js/mapoid/mapoid.js"></script> -->
    <!-- ./ Map Highlight -->

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128&display=swap" rel="stylesheet">

    <!-- Soccer field -->
    <link rel="stylesheet" href="../scripts/js/soccer-field-players-positions/soccerfield.min.css" />
    <link rel="stylesheet" href="../scripts/js/soccer-field-players-positions/soccerfield.default.min.css" />
    <script src="../scripts/js/soccer-field-players-positions/jquery.soccerfield.min.js"></script>

    <!-- chartjs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <!-- JQuery Scripts -->
    <script>
        //jQuery Code Only
        //$.noConflict();
        $(document).ready(function() {
            // compile Dashboard content - ajax

            // compile Profile content - ajax
            // user group subscriptions
            $.compileUserProfileHeader = function() {
                $.get("../scripts/php/main_app/compile_content/profile_tab/user_profile_header.php?usnm=<?php echo $currentUser_Usrnm; ?>", function(data, status) {
                    if (status != "success") {
                        console.log("Get Req Failed -> $.compileUserProfileHeader returned: \n[Status]: " + status + "\n[Data]: " + data);
                        alert("Get Req Failed -> $.compileUserProfileHeader returned: \n[Status]: " + status + "\n[Data]: " + data);
                    } else {
                        $('#profile-header-container').html(data);
                    }
                });
            }

            $.compileUserCommunityGroupSubs = function() {
                $.get("../scripts/php/main_app/compile_content/profile_tab/get_user_community_group_subs.php?entry=init", function(data, status) {
                    if (status != "success") {
                        console.log("Get Req Failed -> $.compileUserCommunityGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
                        alert("Get Req Failed -> $.compileUserCommunityGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
                    } else {
                        $('#user-community-groups-subs-list').html(data);
                    }


                });
            }
            $.compileUserTeamsGroupSubs = function() {
                $.get("../scripts/php/main_app/compile_content/profile_tab/get_user_teams_group_subs.php?entry=init", function(data, status) {
                    if (status != "success") {
                        console.log("Get Req Failed -> $.compileUserTeamsGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
                        alert("Get Req Failed -> $.compileUserTeamsGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
                    } else {
                        $('#user-teams-groups-subs-list').html(data);
                    }


                });
            }
            $.compileUserProGroupSubs = function() {
                $.get("../scripts/php/main_app/compile_content/profile_tab/get_user_pro_group_subs.php?entry=init", function(data, status) {
                    if (status != "success") {
                        console.log("Get Req Failed -> $.compileUserProGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
                        alert("Get Req Failed -> $.compileUserProGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
                    } else {
                        $('#user-pro-groups-subs-list').html(data);
                    }


                });
            }

            // complete group lists
            $.compileCommunityGroups = function() {
                $.get("../scripts/php/main_app/compile_content/community_content/community_groups.php?entry=init", function(data, status) {
                    if (status != "success") {
                        console.log("Get Req Failed -> $.compileCommunityGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
                        alert("Get Req Failed -> $.compileCommunityGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
                    } else {
                        $('#community-groups-full-list').html(data);
                    }


                });
            }
            $.compileTeamsGroups = function() {
                $.get("../scripts/php/main_app/compile_content/teams_content/teams_groups.php?entry=init", function(data, status) {
                    if (status != "success") {
                        console.log("Get Req Failed -> $.compileTeamsGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
                        alert("Get Req Failed -> $.compileTeamsGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
                    } else {
                        $('#teams-groups-full-list').html(data);
                    }


                });
            }
            $.compileProGroups = function() {
                $.get("../scripts/php/main_app/compile_content/premium_content/pro_groups.php?entry=init", function(data, status) {
                    if (status != "success") {
                        console.log("Get Req Failed -> $.compileProGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
                        alert("Get Req Failed -> $.compileProGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
                    } else {
                        $('#pro-groups-full-list').html(data);
                    }


                });
            }
            // get user profile header
            $.compileUserProfileHeader();
            // get full groups list
            $.compileCommunityGroups();
            $.compileTeamsGroups();
            $.compileProGroups();
            // get user group subs
            $.compileUserCommunityGroupSubs();
            $.compileUserTeamsGroupSubs();
            $.compileUserProGroupSubs();

            // compile Discovery content - ajax

            // compile Studio content - ajax

            // compile Store content - ajax

            // compile Social content - ajax

            // compile Fitness Insights content - ajax

            // compile Achievements content - ajax

            // compile Media content - ajax
            $.compileMediaTabContent = function() {
                // shared-media-grid-container
                // private-media-grid-container
                // video-media-grid-container
                var mediaClassArray = ['shared', 'private', 'videos'];

                mediaClassArray.forEach(mClass => {
                    $.get("../scripts/php/main_app/compile_content/media_tab/main_user_media_gallery.php?dir=" + mClass, function(data, status) {

                        if (status != "success") {
                            console.log("Get Req Failed -> $.compileMediaTabContent returned: \n[Status]: " + status + "\n[Data]: " + data);
                            alert("Get Req Failed -> $.compileMediaTabContent returned: \n[Status]: " + status + "\n[Data]: " + data);
                        } else {
                            switch (weekday) {
                                case "shared":
                                    $('#shared-media-grid-container').html(data);
                                    break;
                                case "private":
                                    $('#private-media-grid-container').html(data);
                                    break;
                                case "videos":
                                    $('#video-media-grid-container').html(data);
                                    break;

                                default:
                                    console.log("Error [$.compileMediaTabContent]: mClass/Directory: " + mClass);
                                    break;
                            }
                        }
                    });

                });

            }

            // compile Communications content - ajax

            // compile Messages content - ajax

            // compile Preferences content - ajax


            // soccer field player formation
            var data = [{
                    name: 'KEYLOR NAVAS',
                    position: 'C_GK',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'MARCELO',
                    position: 'LC_B',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'SERGIO RAMOS',
                    position: 'C_B',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'CARVAJAL',
                    position: 'RC_B',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'CASEMIRO',
                    position: 'C_DM',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'KROOS',
                    position: 'L_M',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'ISCO',
                    position: 'LC_M',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'ASENSIO',
                    position: 'RC_M',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'MODRIC',
                    position: 'R_M',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'RONALDO',
                    position: 'LC_F',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
                {
                    name: 'BENZEMA',
                    position: 'RC_F',
                    img: '../media/profiles/0_default/soccer-player.png'
                },
            ];

            $("#soccerfield").soccerfield(data, {
                field: {
                    width: "960px",
                    height: "600px",
                    img: '../media/assets/field_diagrams/soccer-field-dimensions-1.jpg',
                    startHidden: false,
                    animate: false,
                    fadeTime: 1000,
                    autoReveal: false,
                    onReveal: function() {
                        // triggered on reveal
                    }
                },
                players: {
                    font_size: 16,
                    reveal: false,
                    sim: true, // reveal simultaneously
                    timeout: 1000,
                    fadeTime: 1000,
                    img: true,
                    onReveal: function() {
                        // triggered on reveal
                    }
                }
            });

            // ***** Locaion: Modal
            // ajax jquery - submit activity tracking data [Heart Rate]
            $("#modal-heartrate-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                // get the localy stored user_usnm
                let user_usnm = localStorage.getItem('user_usnm');

                var form_data = new FormData($('#modal-heartrate-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_heartrate.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Heart Rate]');
                        },
                        success: function(response) {
                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Heart Rate]');
                                console.log("Response: " + response);

                                // run sync function for heartrate chart
                                var dateToday = new Date('Y-m-d');
                                syncUserActivityTrackerChart(heartRateChart, user_usnm, 'heart_rate_monitor_chart', null, dateToday);

                                // reset the form
                                // $('#modal-heartrate-insights-activitytracker-data-form :input').val('');
                                $('#modal-heartrate-insights-activitytracker-data-form[name=checkListItem]').val('');
                            } else {
                                console.log("error: returning response - activity tracking data [Heart Rate]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Heart Rate]

            // ajax jquery - submit activity tracking data [Body Temp]
            $("#modal-bodytemp-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                // get the localy stored user_usnm
                let user_usnm = localStorage.getItem('user_usnm');

                var form_data = new FormData($('#modal-bodytemp-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bodytemp.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Body Temp]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Body Temp]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [Body Temp]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Body Temp]

            // ajax jquery - submit activity tracking data [Speed]
            $("#modal-speed-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                // get the localy stored user_usnm
                let user_usnm = localStorage.getItem('user_usnm');

                var form_data = new FormData($('#modal-speed-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_speed.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Speed]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Speed]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [Speed]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Speed]

            // ajax jquery - submit activity tracking data [BMI Weight]
            $("#modal-weight-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                // get the localy stored user_usnm
                let user_usnm = localStorage.getItem('user_usnm');

                var form_data = new FormData($('#modal-weight-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bmiweight.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [BMI Weight]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [BMI Weight]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [BMI Weight]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [BMI Weight]

            // ***** Locaion: Single
            // ajax jquery - submit activity tracking data [Heart Rate]
            $("#single-heartrate-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                // get the localy stored user_usnm
                let user_usnm = localStorage.getItem('user_usnm');

                var form_data = new FormData($('#single-heartrate-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_heartrate.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Heart Rate]');
                        },
                        success: function(response) {
                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Heart Rate]');
                                console.log("Response: " + response);

                                // run sync function for heartrate chart
                                var dateToday = new Date();
                                syncUserActivityTrackerChart(heartRateChart, user_usnm, 'heart_rate_monitor_chart', null, dateToday);

                                // reset the form
                                $('#single-heartrate-insights-activitytracker-data-form :input').val('');

                            } else {
                                console.log("error: returning response - activity tracking data [Heart Rate]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Heart Rate]

            // ajax jquery - submit activity tracking data [Body Temp]
            $("#single-bodytemp-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                // get the localy stored user_usnm
                let user_usnm = localStorage.getItem('user_usnm');

                var form_data = new FormData($('#single-bodytemp-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bodytemp.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Body Temp]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Body Temp]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [Body Temp]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Body Temp]

            // ajax jquery - submit activity tracking data [Speed]
            $("#single-speed-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                // get the localy stored user_usnm
                let user_usnm = localStorage.getItem('user_usnm');

                var form_data = new FormData($('#single-speed-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_speed.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [Speed]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [Speed]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];
                            } else {
                                console.log("error: returning response - activity tracking data [Speed]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [Speed]

            // ajax jquery - submit activity tracking data [BMI Weight]
            $("#single-weight-insights-activitytracker-data-form").submit(function(e) {
                e.preventDefault();

                // get the localy stored user_usnm
                let user_usnm = localStorage.getItem('user_usnm');

                var form_data = new FormData($('#single-weight-insights-activitytracker-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bmiweight.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submitting activity tracking data [BMI Weight]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - activity tracking data [BMI Weight]');
                                console.log("Response: " + response);

                                // run sync function for heartrate chart
                                var dateToday = new Date();
                                syncUserActivityTrackerChart(bmiWeightChart, user_usnm, 'heart_rate_monitor_chart', null, dateToday);

                                // reset the form
                                $('#modal-heartrate-insights-activitytracker-data-form :input').val('');

                            } else {
                                console.log("error: returning response - activity tracking data [BMI Weight]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit activity tracking data [BMI Weight]

            // load Teams Activity Capturing Form
            $.loadTeamsActivityCaptureForm = function(day, grpRefcode) {
                // alert("../scripts/php/main_app/data_management/system_admin/team_athletics_data/compile_teams_add_new_activity_day_form.php?day=" + day + "&gref=" + grpRefcode);

                // store grpRefcode locally so we can access it later
                localStorage.setItem('grcode', grpRefcode);

                $.get("../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/compile/compile_teams_add_new_activity_day_form.php?day=" + day + "&gref=" + grpRefcode, function(data, status) {
                    console.log("loadTeamsActivityCaptureForm returned: \n[Status]: " + status + "\n[Data]: " + data);

                    if (status.startsWith('exception error')) {
                        // provide an error message
                        console.log("Error loading editing form");
                    } else {
                        // populate the modal body
                        $('#display-activity-bar-preview').html(data);
                    }
                });
            }

            $.populateWeeklyActivityBarChart = function() {
                // inner bar activity containers
                // $('#teams-weekly-activity-barchart-bar-day1').html(data);
                // $('#teams-weekly-activity-barchart-bar-day2').html(data);
                // $('#teams-weekly-activity-barchart-bar-day3').html(data);
                // $('#teams-weekly-activity-barchart-bar-day4').html(data);
                // $('#teams-weekly-activity-barchart-bar-day5').html(data);
                // $('#teams-weekly-activity-barchart-bar-day6').html(data);
                // $('#teams-weekly-activity-barchart-bar-day7').html(data);

                // bar cols
                // $('#day-1-col').html(data);
                // $('#day-2-col').html(data);
                // $('#day-3-col').html(data);
                // $('#day-4-col').html(data);
                // $('#day-5-col').html(data);
                // $('#day-6-col').html(data);
                // $('#day-7-col').html(data);

                var weekDaysArray = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

                // alert("JQuery AJAX populateWeeklyActivityBarChart");
                var grpRefCode = "tst_grp_0001";

                weekDaysArray.forEach(weekday => {
                    $.get("../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/compile/compile_teams_daily_activities.php?day=" + weekday + "&gref=" + grpRefCode, function(data, status) {


                        if (status != "success") {
                            console.log("Get Req Failed -> $.populateWeeklyActivityBarChart returned: \n[Status]: " + status + "\n[Data]: " + data);
                            alert("Get Req Failed -> $.populateWeeklyActivityBarChart returned: \n[Status]: " + status + "\n[Data]: " + data);
                        } else {
                            switch (weekday) {
                                case "monday":
                                    $('#day-1-col').html(data);
                                    break;
                                case "tuesday":
                                    $('#day-2-col').html(data);
                                    break;
                                case "wednesday":
                                    $('#day-3-col').html(data);
                                    break;
                                case "thursday":
                                    $('#day-4-col').html(data);
                                    break;
                                case "friday":
                                    $('#day-5-col').html(data);
                                    break;
                                case "saturday":
                                    $('#day-6-col').html(data);
                                    break;
                                case "sunday":
                                    $('#day-7-col').html(data);
                                    break;

                                default:
                                    console.log("Error [$.populateWeeklyActivityBarChart]: Day: " + weekday + " | grpRefCode" + grpRefCode);
                                    break;
                            }
                        }
                    });

                });

                // populate the weekly assessments list cards as well
                weekDaysArray.forEach(weekday => {
                    // populate the weekly assessments list cards as well
                    $.populateWeeklyAssessmentsHorizCardContainer(weekday, grpRefCode);
                });

            }

            $.populateWeeklyAssessmentsHorizCardContainer = function(weekday, grpRefCode) {
                // var grpRefCode = "tst_grp_0001";
                $.get("../scripts/php/main_app/compile_content/profile_tab/get_users_daily_assessments_and_activities_list.php?day=" + weekday + "&gref=" + grpRefCode, function(data, status) {

                    if (status != "success") {
                        console.log("Get Req Failed -> $.populateWeeklyAssessmentsHorizCardContainer returned: \n[Status]: " + status + "\n[Data]: " + data);
                        alert("Get Req Failed -> $.populateWeeklyAssessmentsHorizCardContainer returned: \n[Status]: " + status + "\n[Data]: " + data);
                    } else {
                        switch (weekday) {
                            case "sunday":
                                $('#weekly-assessment-h-scroll-weekday-card-varsunday').html(data);
                                break;
                            case "monday":
                                $('#weekly-assessment-h-scroll-weekday-card-varmonday').html(data);
                                break;
                            case "tuesday":
                                $('#weekly-assessment-h-scroll-weekday-card-vartuesday').html(data);
                                break;
                            case "wednesday":
                                $('#weekly-assessment-h-scroll-weekday-card-varwednesday').html(data);
                                break;
                            case "thursday":
                                $('#weekly-assessment-h-scroll-weekday-card-varthursday').html(data);
                                break;
                            case "friday":
                                $('#weekly-assessment-h-scroll-weekday-card-varfriday').html(data);
                                break;
                            case "saturday":
                                $('#weekly-assessment-h-scroll-weekday-card-varsaturday').html(data);
                                break;

                            default:
                                console.log("Error: no weekday output to pass to card. [$.populateWeeklyAssessmentsHorizCardContainer]: Day: " + weekday + " | grpRefCode" + grpRefCode);
                                alert("Error: no weekday output to pass to card. [$.populateWeeklyAssessmentsHorizCardContainer]: Day: " + weekday + " | grpRefCode" + grpRefCode);
                                break;
                        }
                    }
                });
            }

            // ajax jquery - submit edited weekly teams activity data [Teams Submit Edited Activities Form]
            $("#teams-add-new-day-activity-data-form").submit(function(e) {
                e.preventDefault();

                var form_data = new FormData($('#teams-add-new-day-activity-data-form')[0]);
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/teams_add_new_activity_day_form_submit.php',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        beforeSend: function() {
                            console.log('beforeSend: submit edited weekly teams activity data [Teams Submit Edited Activities Form]');
                        },
                        success: function(response) {

                            if (response.startsWith("success")) {
                                console.log('success: returning response - submit edited weekly teams activity data [Teams Submit Edited Activities Form]');
                                console.log("Response: " + response);
                                // get the profile image name and append it to the src attribute str
                                // var str = response;
                                // var imgSrcStr = str.split('[').pop().split(']')[0];

                                // call the function/code to populate the modal body - use jquery ajax
                                var local_grpRefcode = localStorage.setItem('grcode');
                                $.loadTeamsActivityCaptureForm(day, local_grpRefcode);
                            } else {
                                console.log("error: returning response - submit edited weekly teams activity data [Teams Submit Edited Activities Form]");
                                console.log("Response: " + response);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
            });
            // ./ ajax jquery - submit edited weekly teams activity data [Teams Submit Edited Activities Form]

            // load interaction model content
            $.loadInteractionContent = function(loadContent) {
                let user_id = localStorage.getItem('user_usnm');
                var getRequestLink, modalHeader = null;

                // show the interaction modal
                // $('#show-interaction-modal-btn').click();

                // set loading display
                $('#interactionsContentContainer').html(
                    `<div class="d-flex justify-content-center">
                        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <p class="text-center">Loading. Please wait.</p>`
                );

                switch (loadContent) {
                    case "TrainingDrillsWorkouts":
                        modalHeader = `<span class="material-icons material-icons-round align-middle">shuffle_on</span>
                        <span class="align-middle d-none d-md-block"> Training Drills &amp; Workouts.</span>`;
                        getRequestLink = '../scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/compile_training_drills_workouts.php?uid=' + user_id;
                        break;
                    case "PhysicalAssessment":
                        modalHeader = `<span class="material-icons material-icons-round align-middle">personal_injury</span>
                        <span class="align-middle d-none d-md-block"> Physical Assessment</span>`;
                        getRequestLink = '../scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/compile_physical_assessment.php?uid=' + user_id;
                        break;
                    case "NutritionBoard":
                        modalHeader = `<span class="material-icons material-icons-round align-middle">developer_board</span>
                        <span class="align-middle d-none d-md-block"> Nutrition Board.</span>`;
                        getRequestLink = '../scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/compile_nutrition_board.php?uid=' + user_id;
                        break;
                    case "CreationTools":
                        modalHeader = `<span class="material-icons material-icons-round align-middle">brush</span>
                        <span class="align-middle d-none d-md-block"> Creation Tools.</span>`;
                        getRequestLink = '../scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/compile_creation_tools.php?uid=' + user_id;
                        break;
                    case "AdminDataMgmt":
                        modalHeader = `<span class="material-icons material-icons-round align-middle">account_tree</span>
                        <span class="align-middle d-none d-md-block"> Data Management.</span>`;
                        getRequestLink = '../scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/compile_data_mgmt.php?uid=' + user_id;
                        break;

                    default:
                        modalHeader = `<span class="material-icons material-icons-round align-middle">account_tree</span>
                        <span class="align-middle d-none d-md-block"> Data Management.</span>`;
                        getRequestLink = 'abort operation';
                        console.log("Error: no content request received. [$.loadInteractionContent]: loadContent Param: " + loadContent);
                        alert("Error: no content request received. [$.loadInteractionContent]: loadContent Param: " + loadContent);
                        break;
                }

                if (getRequestLink != 'abort operation') {
                    $.get(getRequestLink, function(data, status) {

                        if (status.startsWith('return')) {
                            console.log("Get Req Failed -> $.loadInteractionContent returned: \n[Status]: " + status + "\n[Data]: " + data);
                            alert("Get Req Failed -> $.loadInteractionContent returned: \n[Status]: " + status + "\n[Data]: " + data);
                        } else {
                            // show the interaction modal
                            // $('#show-interaction-modal-btn').click();
                            // load the interaction modal with requested content
                            $('#trainingInteractionsContentModalLabel').html(modalHeader);
                            $('#interactionsContentContainer').html(data);
                        }
                    });
                }

            }

            //<!-- script for loading edit forms for weekly teams activities -->
            $.editAddNewActivityModal = function(day, grpRefcode) {
                // open the modal
                // $("#toggleTabeditWeeklyTeamsTrainingScheduleModalBtn").click();

                // call the function/code to populate the modal body - use jquery ajax
                $.loadTeamsActivityCaptureForm(day, grpRefcode);

                // update the modal header label
                $('#tabeditWeeklyTeamsTrainingScheduleModalLabelText').html('Edit weekly training schedule ( ' + day + ' )');
            }

            $.toggleEditDayBar = function(day, groupRefCode) {
                // open the modal
                // $("#toggleTabeditWeeklyTeamsTrainingScheduleModalBtn").click();

                // call the function/code to populate the modal body - use jquery ajax - "editbar" value (grpRefcode) will load a form for updating the title and rpe
                var initVal = "editbar";
                $.loadTeamsActivityCaptureForm(day, initVal);
            }

            $.removeWeeklyTrainingActivity = function(day, groupRefCode, exerciseID) {

            }
            // <!-- ./ script for loading edit forms for weekly teams activities -->

            // $("map[name=image-map-male-front]").mapoid({
            //     click: function(e) {
            //         /*// stroke color
            //         strokeColor: 'black',
            //         // stroke width
            //         strokeWidth: 1,
            //         // fill color
            //         fillColor: 'black',
            //         // 0-1
            //         fillOpacity: 0.5,
            //         // in milliseconds
            //         fadeTime: 500,
            //         // an array of selected areas
            //         selectedArea: false,
            //         // select on click
            //         selectOnClick: true*/

            //         //alert('click');
            //         e.preventDefault();
            //         var clickedArea = $(this); // remember clicked area
            //         // foreach area
            //         $("map[name=image-map-male-front]").each(function() {
            //             hData = $(this).data('maphilight') || {}; // get
            //             hData.alwaysOn = $(this).is(clickedArea); // modify
            //             $(this).data('maphilight', hData).trigger('alwaysOn.maphilight'); // set
            //         });
            //     }
            // });
            //JQuery Image Map Highlighting
            //$('.map').maphilight();

            //$('.map').maphilight();

            /*$('#musclepart').click(function(e) {
                e.preventDefault();
                var clickedArea = $(this); // remember clicked area
                // foreach area
                $('#musclepart').each(function() {
                    hData = $(this).data('maphilight') || {}; // get
                    hData.alwaysOn = $(this).is(clickedArea); // modify
                    $(this).data('maphilight', hData).trigger('alwaysOn.maphilight'); // set
                });
            });*/
        });
    </script>
</head>

<body class="noselect" onload="initializeContent('<?php echo $userAuth; ?>','<?php echo $currentUser_Usrnm; ?>')">
    <!-- imbaChat plugin code/api: -->
    <!-- <script src="https://api.imbachat.com/imbachat/v1/20525/widget"></script>
    <script>
        window.imbaApi.load();
    </script> -->


    <!-- Notification Snackbar (mini) -->
    <!-- <button class="btn btn-primary btn-lg" onclick="showSnackbar('notification message here...')">Show Snackbar</button> -->
    <!-- The actual snackbar -->
    <div id="snackbar">No notification.</div>

    <!-- Load Curtain -->
    <div class="load-curtain" id="LoadCurtain" style="display: block;">
        <!-- twitter social panel -->
        <div class="load-curtain-social-btn-panel comfortaa-font d-grid gap-2 p-4 left-right-grad-tahiti-mineshaft shadow-lgz">
            <!--  d-none d-lg-block p-4 -->
            <div class="d-flex gap-2 w-100 justify-content-end">
                <button class="p-4 m-0 shadow onefit-buttons-style-dark-twitter onefit-buttons-style-light-twitterz" type="button" data-bs-toggle="collapse" data-bs-target="#collapseloadCurtainTweetFeed" aria-expanded="false" aria-controls="collapseloadCurtainTweetFeed">
                    <div class="d-grid">
                        <span class="material-icons material-icons-round" style="font-size: 48px !important;">
                            <i class="fab fa-twitter" style="font-size: 40px;"></i>
                        </span>
                        <p class="comfortaa-font mt-1 mb-0" style="font-size: 10px;">@onefitnet</p>
                    </div>
                </button>
            </div>
            <div class="collapse no-scroller pb-4 w3-animate-bottom" id="collapseloadCurtainTweetFeed" style="overflow-y: auto;">
                <div class="pb-4 no-scroller" style="border-radius: 25px !important; overflow-y: auto; max-height: 90vh; min-width: 500px;">
                    <a class="twitter-timeline comfortaa-font" href="https://twitter.com/OnefitNet?ref_src=twsrc%5Etfw">Tweets by OnefitNet</a>
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
                        <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid p-4" style="height: 130px;" alt="onefit logo">
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

    <!-- Facebook API -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v13.0" nonce="47FC3Uf9"></script>
    <!-- ./ Facebook API -->

    <!-- Navigation bar, Cart & Other functions -->
    <div class="container-xlg -fluid text-center pt-4">
        <a class="navbar-brand my-4 mx-0 p-4 fs-1 text-white comfortaa-font" href="#">
            One<span style="color: #ffa500">fit</span>.app<span style="font-size: 10px">&trade;</span>
        </a>

        <!-- Cart Container  -->
        <div class="container py-4">
            <div class="text-center">
                <button class="navbar-toggler shadowz onefit-buttons-style-dark p-2" type="button" data-bs-toggle="collapse" data-bs-target="#cart-panel" aria-controls="cart-panel">
                    <div class="row px-4 py-2 align-items-centerz">
                        <div class="col-sm border-start border-end border-light p-2">
                            <span class="material-icons material-icons-round align-middle" style="font-size: 50px !important;">
                                verified_user
                            </span>
                        </div>
                        <div class="col-sm border-start border-end border-light p-2">
                            <div class="d-grid gap-2">
                                <span class="material-icons material-icons-round" style="font-size: 20px !important"> shopping_cart </span>
                                <span class="d-nonez d-lg-blockz" id="" style="font-size: 10px;">Cart (<span class="fw-bold comfortaa-font" style="color: #ffa500;">4</span>)</span>
                            </div>
                        </div>
                        <div class="col-sm fw-bold comfortaa-font border-start border-end border-light p-2">
                            <span class="align-middle" style="font-size: 10px; color: #ffa500;">ZAR</span><br> 0.00
                        </div>
                    </div>
                </button>
            </div>

            <div class="collapse showz down-top-grad-dark w3-animate-top comfortaa-font text-white" style="border-radius: 25px; overflow: hidden;" id="cart-panel">
                <div class="p-4 shadow" id="">
                    <div class="text-center d-flex justify-content-between align-items-center">
                        <button class="navbar-toggler shadow onefit-buttons-style-dark p-4 mb-4 w3-animate-right d-grid gap-1" type="button" onclick="openLink(event, 'TabStore')">
                            <span class="material-icons material-icons-round align-middle">
                                storefront
                            </span>
                            <span class="align-middle"><span class="d-none d-lg-block">Visit the </span><span style="color: #ffa500 !important;">.Store</span></span>
                        </button>

                        <div class="w3-animate-top text-center">
                            <!-- <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="max-height: 50px;" alt="logo"> -->
                            <div class="d-grid text-center">
                                <p class="m-0 fs-5 comfortaa-font text-muted">Shopping</p>
                                <p class="m-0 fs-1 comfortaa-font text-muted">Cart.</p>
                            </div>

                        </div>

                        <button class="navbar-toggler shadow onefit-buttons-style-dark p-4 mb-4 w3-animate-left d-grid gap-1" type="button">
                            <span class="material-icons material-icons-round align-middle">
                                point_of_sale
                            </span>
                            <span class="align-middle">
                                <span class="d-none d-lg-block">Proceed to </span><span class="d-none d-lg-block" style="color: #ffa500 !important;">Payment.</span>
                            </span><span class="d-lg-none" style="color: #ffa500 !important;">Pay.</span>
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-xlg-6 py-4">
                            <p class="text-center w3-animate-left comfortaa-font" style="min-height: 30px;">
                                <span class="material-icons material-icons-round align-middle">
                                    checklist
                                </span>
                                Invoice [ <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;">20220201-879ds6fsdf_id</span> ]
                            </p>
                            <hr class="text-white">
                            <h1><span style="color: #ffa500;">Total:</span> R<span id="shop-cart-total-amt">0.00</span> <span class="align-top" style="font-size: 10px; color: #ffa500;">ZAR</span></h1>
                            <ul id="main-cart-items-list" class="list-group list-group-flush list-group-numbered shadow py-4 px-4 w3-animate-left" style="background-color: #343434; overflow-y: auto; border-radius: 25px !important; max-height: 50vh !important;">
                                <li id="main-cart-items-list-item-idvalue" class="list-group-item border-light bg-transparent text-white fs-5 d-flex" style="border-radius: 10px;">
                                    <div class="w-100 align-items-center justify-content-between">

                                        <div class="row align-items-center">
                                            <div class="col-md">
                                                <div class="d-grid gap-2 text-start px-4 pb-2">
                                                    <div class="comfortaa-font">
                                                        <span id="main-cart-items-list-item-name" class="align-middle">Aiwa Smart Band ASB-40</span>
                                                    </div>
                                                    <div class="comfortaa-font">
                                                        <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                                        <span class="fs-5" id="main-cart-items-list-item-price" style="color: #ffa500;">R149.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="d-grid justify-content-center my-4">
                                                    <!-- quantity -->
                                                    <div class="input-group m-0">
                                                        <span class="input-group-text" id="cart-item-quantity-cartitemid" style="font-size: 10px;color:#ffa500!important;background-color:#343434">Qty</span>
                                                        <input type="number" class="form-control text-center" placeholder="qty" aria-label="quantity" aria-describedby="cart-item-quantity-cartitemid" style="border-radius: 0 50rem 50rem 0 !important;background-color: #343434; color: #fff;max-width:80px;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="d-grid justify-content-endz">
                                                    <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 40px !important">
                                                            highlight_off
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                                <li id="main-cart-items-list-item-idvalue" class="list-group-item border-light bg-transparent text-white fs-5 d-flex" style="border-radius: 10px;">
                                    <div class="w-100 align-items-center justify-content-between">

                                        <div class="row align-items-center">
                                            <div class="col-md">
                                                <div class="d-grid gap-2 text-start px-4 pb-2">
                                                    <div class="comfortaa-font">
                                                        <span id="main-cart-items-list-item-name" class="align-middle">Aiwa Smart Band ASB-40</span>
                                                    </div>
                                                    <div class="comfortaa-font">
                                                        <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                                        <span class="fs-5" id="main-cart-items-list-item-price" style="color: #ffa500;">R149.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="d-grid justify-content-center my-4">
                                                    <!-- quantity -->
                                                    <div class="input-group m-0">
                                                        <span class="input-group-text" id="cart-item-quantity-cartitemid" style="font-size: 10px;color:#ffa500!important;background-color:#343434">Qty</span>
                                                        <input type="number" class="form-control text-center" placeholder="qty" aria-label="quantity" aria-describedby="cart-item-quantity-cartitemid" style="border-radius: 0 50rem 50rem 0 !important;background-color: #343434; color: #fff;max-width:80px;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="d-grid justify-content-endz">
                                                    <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 40px !important">
                                                            highlight_off
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                                <li id="main-cart-items-list-item-idvalue" class="list-group-item border-light bg-transparent text-white fs-5 d-flex" style="border-radius: 10px;">
                                    <div class="w-100 align-items-center justify-content-between">

                                        <div class="row align-items-center">
                                            <div class="col-md">
                                                <div class="d-grid gap-2 text-start px-4 pb-2">
                                                    <div class="comfortaa-font">
                                                        <span id="main-cart-items-list-item-name" class="align-middle">Aiwa Smart Band ASB-40</span>
                                                    </div>
                                                    <div class="comfortaa-font">
                                                        <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                                        <span class="fs-5" id="main-cart-items-list-item-price" style="color: #ffa500;">R149.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="d-grid justify-content-center my-4">
                                                    <!-- quantity -->
                                                    <div class="input-group m-0">
                                                        <span class="input-group-text" id="cart-item-quantity-cartitemid" style="font-size: 10px;color:#ffa500!important;background-color:#343434">Qty</span>
                                                        <input type="number" class="form-control text-center" placeholder="qty" aria-label="quantity" aria-describedby="cart-item-quantity-cartitemid" style="border-radius: 0 50rem 50rem 0 !important;background-color: #343434; color: #fff;max-width:80px;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="d-grid justify-content-endz">
                                                    <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 40px !important">
                                                            highlight_off
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ***delete ../scripts/php/main_app/data_management/activity_tracker_stats_admin/compile/get_user_stats_activity_tracker.php -->
                                </li>
                                <li id="main-cart-items-list-item-idvalue" class="list-group-item border-light bg-transparent text-white fs-5 d-flex" style="border-radius: 10px;">
                                    <div class="w-100 align-items-center justify-content-between">
                                        <div class="row align-items-center">
                                            <div class="col-md">
                                                <div class="d-grid gap-2 text-start px-4 pb-2">
                                                    <div class="comfortaa-font">
                                                        <span id="main-cart-items-list-item-name" class="align-middle">Aiwa Smart Band ASB-40</span>
                                                    </div>
                                                    <div class="comfortaa-font">
                                                        <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                                        <span class="fs-5" id="main-cart-items-list-item-price" style="color: #ffa500;">R149.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="d-grid justify-content-center my-4">
                                                    <!-- quantity -->
                                                    <div class="input-group m-0">
                                                        <span class="input-group-text" id="cart-item-quantity-cartitemid" style="font-size: 10px;color:#ffa500!important;background-color:#343434">Qty</span>
                                                        <input type="number" class="form-control text-center" placeholder="qty" aria-label="quantity" aria-describedby="cart-item-quantity-cartitemid" style="border-radius: 0 50rem 50rem 0 !important;background-color: #343434; color: #fff;max-width:80px;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="d-grid justify-content-endz">
                                                    <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 40px !important">
                                                            highlight_off
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                            </ul>
                        </div>
                        <div class="col-xlg-6 py-4">
                            <p class="text-center w3-animate-right comfortaa-font" style="min-height: 30px;">
                                <span class="material-icons material-icons-round align-middle">
                                    shopping_cart
                                </span>
                                Cart Items (<span id="mini-cart-item-count" style="color: #ffa500;">4</span>)
                            </p>
                            <hr class="text-white">
                            <div class="horizontal-scroll p-5 w3-animate-right">
                                <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-top border-end me-4 position-relative" style="border-color: #ffa500 !important;">
                                    <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                        1
                                    </div>
                                    <div class="d-grid gap-2 justify-content-center">
                                        <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">sell</span>
                                        <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                        <div class="text-center">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh;" alt="placeholder">
                                        </div>

                                        <p class="fw-bold text-truncate text-center py-4 comfortaa-font">
                                            <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                            <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                        </p>
                                        <div class="d-grid">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-top border-end me-4 position-relative" style="border-color: #ffa500 !important;">
                                    <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                        2
                                    </div>
                                    <div class="d-grid gap-2 justify-content-center">
                                        <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">sell</span>
                                        <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                        <div class="text-center">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh;" alt="placeholder">
                                        </div>

                                        <p class="fw-bold text-truncate text-center py-4 comfortaa-font">
                                            <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                            <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                        </p>
                                        <div class="d-grid">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-top border-end me-4 position-relative" style="border-color: #ffa500 !important;">
                                    <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                        3
                                    </div>
                                    <div class="d-grid gap-2 justify-content-center">
                                        <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">sell</span>
                                        <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                        <div class="text-center">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh;" alt="placeholder">
                                        </div>

                                        <p class="fw-bold text-truncate text-center py-4 comfortaa-font">
                                            <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                            <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                        </p>
                                        <div class="d-grid">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                                <div class="horizontal-scroll-card p-4 shadow border-5 border-start border-top border-end me-4 position-relative" style="border-color: #ffa500 !important;">
                                    <div class="position-absolute top-0 start-0 translate-middle badge rounded-pillz border-2 border ps-3 pe-4 pt-3 pb-4 align-middle text-center" style="height: 20px; width: 20px; font-size: 10px; border-color: #ffa500 !important; background-color: #343434 !important; border-radius: 5px;">
                                        4
                                    </div>
                                    <div class="d-grid gap-2 justify-content-center">
                                        <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">sell</span>
                                        <span class="barcode-font text-truncate" id="cart-invoice-number-barcode" style="color: #ffa500;font-size: 5px;">20220201-879ds6fsdf_id</span>
                                        <div class="text-center">
                                            <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" Class="img-fluid shadow" style="border-radius: 15px; max-height: 20vh;" alt="placeholder">
                                        </div>

                                        <p class="fw-bold text-truncate text-center py-4 comfortaa-font">
                                            <span class="material-icons material-icons-round text-muted" style="font-size: 10px !important;">monetization_on</span>
                                            <span class="fs-5" id="main-cart-items-horizontal-sub-list-item-price" style="color: #ffa500;">R149.00</span> | Aiwa Smart Band ASB-40
                                        </p>
                                        <div class="d-grid">
                                            <button id="remove-cart-item-itemid" class="onefit-buttons-style-tahiti p-2 text-center">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                                    highlight_off
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./ Cart Container  -->

        <!-- Create Button - hidden on screens smaller than lg -->
        <div class="create-btn-container my-pulse-animation-tahiti comfortaa-font d-grid gap-2 d-none d-lg-block">
            <div class="collapse p-4 w3-animate-bottom" id="collapseCreateCommandList">
                <ul class="list-groupz list-group-flush list-group border-0 text-white fw-bold text-center comfortaa-font" style="overflow: initial !important;">
                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Social Update</button></li>
                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Community Resource</button></li>
                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Share Media</button></li>
                    <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white">Chat Message</button></li>
                </ul>
            </div>
            <div class="d-grid gap-2 w-100">
                <button class="p-4 m-0 shadow onefit-buttons-style-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCreateCommandList" aria-expanded="false" aria-controls="collapseCreateCommandList">
                    <div class="d-grid">
                        <span class="material-icons material-icons-round" style="font-size: 48px !important;">
                            brush
                        </span>
                        <p class="comfortaa-font" style="font-size: 20px;">Create.</p>
                    </div>
                </button>
            </div>

        </div>
        <!-- ./ Create Button - hidden on screens smaller than lg -->
    </div>
    <!-- ./ Navigation bar, Cart & Other functions -->



    <!-- Main Content -->
    <div class="container-lg" style="padding-bottom: 50px">
        <!-- Main Navigation Bar -->
        <nav class="navbar navbar-light sticky-top navbar-style w-100 mb-4" style="border-radius: 25px; max-height: 100vh !important; border-bottom: #ffa500 solid 5px;">
            <!-- App Function Buttons -->
            <div class="container">
                <button class="onefit-buttons-style-dark p-3 shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotifications" aria-controls="offcanvasNotifications">
                    <div class="d-grid gap-2">
                        <span class="material-icons material-icons-round" style="font-size: 24px !important"> notifications </span>
                        <span class="d-none d-lg-block" style="font-size: 10px;">Notifications</span>
                    </div>
                </button>

                <button type="button" id="display-current-tab-button" class="onefit-buttons-style-dark p-3 my-4 shadow comfortaa-font" style="max-width:87px;" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#tabNavModal">
                    <div class="d-grid gap-2">
                        <span class="material-icons material-icons-round" style="font-size: 24px !important;" id="display-current-tab-button-icon">
                            dashboard </span>
                        <span class="d-none d-lg-block text-truncate" id="display-current-tab-button-text" style="font-size: 10px;">Dashboard</span>
                    </div>
                </button>

                <!-- Main UPPL Toggle button -->
                <div class="d-inline gap-2">
                    <button class="onefit-buttons-style-dark p-4 shadow d-nonez d-lg-blockz" style="overflow: hidden; font-size: 10px;" type="button" data-bs-toggle="modal" data-bs-target="#tabLatestSocialModal">
                        <div class="d-grid gap-2 text-center">
                            <!-- Profile Picture -->
                            <img src="../media/assets/One-Symbol-Logo-White.svg" alt="Onefit Logo" class="p-1 img-fluid my-pulse-animation-tahitiz" style="height: 50px; width: 50px; border-radius: 15px; border-color: #ffa500 !important" />
                            <!-- ./ Profile Picture -->
                            <span class="d-none d-lg-block">Latest</span>
                        </div>
                    </button>
                </div>
                <!-- ./ Main UPPL Toggle button -->

                <button type="button" class="onefit-buttons-style-dark p-3 my-4 shadow comfortaa-font" data-bs-toggle="collapse" data-bs-target="#widget-rows-container" aria-controls="widget-rows-container">
                    <div class="d-grid gap-2">
                        <span class="material-icons material-icons-round" style="font-size: 24px !important"> widgets </span>
                        <span class="d-none d-lg-block" style="font-size: 10px;">Widgets</span>
                    </div>
                    <!--<span class="material-icons material-icons-round" style="font-size: 24px !important"> linear_scale </span>-->
                </button>

                <button class="navbar-toggler shadow onefit-buttons-style-dark p-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <div class="d-grid gap-2">
                        <span class="material-icons material-icons-round" style="font-size: 24px !important"> menu_open </span>
                        <span class="d-none d-lg-block" id="" style="font-size: 10px;">Navigation</span>
                    </div>
                </button>

                <!-- Navigation Menu Offcanvas -->
                <div class="offcanvas offcanvas-end offcanvas-menu-primary-style fitness-bg-containerz" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="h-100z" id="offcanvas-menu">
                        <div class="offcanvas-header shadow fs-1" style="background-color: #343434; color: #fff">
                            <img src="../media/assets/One-Symbol-Logo-White.svg" alt="" class="img-fluid logo-size-2 pulse-animation" />

                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel" style="overflow-x: hidden;">
                                Navigation
                            </h5>
                            <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="offcanvas" aria-label="Close">
                                <span class="material-icons material-icons-round"> cancel </span>
                            </button>
                        </div>
                        <div class="offcanvas-body" style="padding-bottom: 40px; overflow-y: auto; overflow-x: hidden; max-height: 80vh;">
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
                                <hr class="text-dark" style="height: 5px;" />
                                <li class="nav-item d-grid gap-2">
                                    <button class="onefit-buttons-style-danger p-4 text-center my-4" style="transform: translate(0) !important;" onclick="launchLink('../scripts/php/destroy_session.php')" style="border-radius: 25px !important;">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                <img src="../media/profiles/0_default/default_profile_pic.svg" class="img-fluid rounded-circle" height="50" width="50" alt="user profile picture">
                                            </div>
                                            <div class="col-md-8">
                                                Sign Out
                                            </div>
                                        </div>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ./Navigation Menu Offcanvas -->

                <!-- Notifocation List Offcanvas -->
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotifications" aria-controls="offcanvasNotifications" hidden>
                    <span class="material-icons material-icons-round" style="font-size: 48px !important"> notifications </span>
                    Notifications
                </button>

                <div class="offcanvas offcanvas-start offcanvas-menu-primary-style fitness-bg-containerz" tabindex="-1" id="offcanvasNotifications" aria-labelledby="offcanvasNotificationsLabel">
                    <div class="offcanvas-header align-center shadow" style="background-color: #343434;">
                        <span class="material-icons material-icons-round" style="font-size: 48px !important"> notifications </span>

                        <h5 id="offcanvasTopLabel" style="overflow-x: hidden;">
                            Notifications</h5>

                        <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="offcanvas" aria-label="Close">
                            <span class="material-icons material-icons-round"> cancel </span>
                        </button>
                    </div>
                    <div class="offcanvas-body top-down-grad-white">
                        <!-- style="background-color: rgba(255, 255, 255, 0.8);" -->
                        <ul class="list-group list-group-flush shadow p-4z" id="notif-list" style="border-radius: 25px; max-height: 60vh;" hidden>
                            <li class="list-group-item border-dark">An item</li>
                            <li class="list-group-item border-dark">A second item</li>
                            <li class="list-group-item border-dark">A third item</li>
                            <li class="list-group-item border-dark">A fourth item</li>
                            <li class="list-group-item border-dark">And a fifth one</li>
                        </ul>
                        <div id="communicationUserNotifications">
                            <?php echo $outputProfileUserNotifications; ?>
                        </div>
                        <?php echo $communicationUserNotifications; ?>
                    </div>
                </div>
                <!-- ./Notifocation List Offcanvas -->
            </div>
            <!-- ./ App Function Buttons -->
        </nav>
        <!-- ./ Main Navigation Bar -->

        <!-- Tab Content -->
        <div class="container-xlg">
            <div class="tab-container" id="tab-container">
                <div id="TabHome" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: block">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">dashboard</span> <span class="align-middle">Dashboard</span></h5>

                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <h5 class="text-center">Hi <?php echo $usrprof_name; ?>.</h5>
                    <p class="my-4 text-center comfortaa-fontr">Welcome to the Dashboard Page. Here, you can find various feeds from the activities we will be doing in the OnefitNet Community.</p>

                    <hr class="text-white">

                    <div class="variable-grid-container">
                        <div class="full-wide-grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">

                            <!-- fitness progression progress bar -->
                            <div id="fitness-progression-progress-bar">
                                <h5 class="mt-4"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">data_exploration</span> <span class="align-middle">Fitness Progression</span></h5>
                                <div class="progress mt-4" style="height: 4px;">
                                    <div class="progress-bar" role="progressbar" aria-label="Example 1px high" style="width: 25%; background-color: #ffa500 !important; border-right: #343434 10px solid;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="row mt-2" style="margin-bottom: 60px;">
                                    <div class="col text-start comfortaa-font" style="font-size: 12px;">
                                        Current XP <strong>(112)</strong>
                                    </div>
                                    <div class="col text-end comfortaa-font" style="font-size: 12px;">
                                        Target XP <strong>(150)</strong>
                                    </div>
                                </div>
                            </div>
                            <!-- ./ fitness progression progress bar -->

                            <hr class="text-white">

                            <h5 class="align-middle text-center"><span class="material-icons material-icons-outlined align-middle">today</span><br> <?php echo date("l"); ?><br> <span style="color: #ffa500;">[</span> <?php echo date("d/m/Y"); ?> <span style="color: #ffa500;">]</span></h5>
                            <!-- Digital Clock -->
                            <div id="clock" class="dark my-4 shadow">
                                <div class="display no-scroller">
                                    <div class="weekdays"></div>
                                    <div class="ampm"></div>
                                    <div class="alarm"></div>
                                    <div class="digits"></div>
                                </div>
                            </div>
                            <!-- ./. Digital Clock -->

                            <div class="mt-4" id="dashboard-activity-lineup-container">
                                <div class="p-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important; margin-top: 60px !important;">
                                    <h4 class="d-grid p-4 text-center border-5 border-top border-bottom" style="background-color: #343434; color: #fff; border-color: #ffa500 !important;border-radius: 15px;">
                                        <span class="material-icons material-icons-round align-middle" style="color: #ffa500 !important">timeline</span>
                                        <span class="p-4 align-middle">Activities lined up.</span>
                                    </h4>

                                    <div class="d-flex align-items-center text-center justify-content-center" id="no-activities-banner-container" style="min-height: 100px;">
                                        <p class="my-4 fs-5 fw-bold comfortaa-font" style="cursor: pointer;" onclick="openLink(event, 'TabStudio')">No activities lined up. Go to the <span style="color: #ffa500;">.Studio</span> to get active.</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Content Card - Dashboard -->
                        <div class="grid-tile down-top-grad-dark p-4 shadow" style="border-radius: 25px">
                            <h4>News, Resources, Blog and Ads Feed</h4>
                            <small class="text-muted" id="">Content</small>
                            <p style="color: #ffa500;">Stay tuned for helpful resources, media content and the latest news in Sports, Health, Wellness, Lifestyle and Current Affairs News.</p>
                            <div class="text-center">
                                <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <!-- Content Card - Dashboard -->

                    </div>
                </div>
                <div id="TabProfile" class="shadow w3-container w3-animate-right content-tab py-4 px-2 app-tab" style="display: none">
                    <!-- Hide this Tab Label -->
                    <!-- <div class="p-4 m-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">account_circle</span> <span class="align-middle">Profile</span></h5>

                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div> -->
                    <!-- <h1 class="text-center">Profile</h1>
                    <hr class="text-white" /> -->

                    <div id="profile-panel-container">
                        <!-- Profile Tab: User Profile -->
                        <div class='container-fluid comfortaa-font rounded-pillz shadow pb-4 px-0 m-0z text-white w-100' style='border-radius: 25px; background-color: #343434; overflow: hidden'>

                            <!-- user profile header -->
                            <!-- iframe to load user profile header script ui output -->
                            <!-- <iframe id="iframe-load-profile-header-section" class="w-100" src="../scripts/php/main_app/compile_content/profile_tab/user_profile_header.php?usnm=<?php echo $currentUser_Usrnm; ?>" frameborder="0" style="height: 50vh;"></iframe> -->
                            <!-- iframe to load user profile header script ui output -->
                            <!-- user profile header -->

                            <!-- use php include for profile header section -->
                            <!-- include("../scripts/php/main_app/compile_content/profile_tab/user_profile_header.php?usnm=$currentUser_Usrnm"); -->

                            <div id="profile-header-container">
                                User Profile Header Here.
                            </div>

                            <!--Users Social Media Links-->
                            <!-- <div id='userSocialItems'>echo $userSocialItemsList; ?></div> -->

                            <!-- section seperator to allow user to touch for scrolling -->
                            <div class="text-center p-4 d-flexz justify-content-betweenz align-items-centerz" style="background-color: #343434; color:#ffa500;">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="d-gridz gap-0">
                                            <!-- left touch for scroll indicator -->
                                            <span class="material-icons material-icons-round align-middle text-muted p-4 rounded-circle shadow" style="font-size: 20px !important;color: #ffa500 !important;">refresh</span><!-- fingerprint -->
                                            <span class="text-white align-middle" style="font-size: 20px !important;"> Refresh</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-gridz gap-0">
                                            <!-- left touch for scroll indicator -->
                                            <span class="material-icons material-icons-round align-middle text-muted p-4 rounded-circle shadow" style="font-size: 20px !important;color: #ffa500 !important;">support_agent</span><!-- fingerprint -->
                                            <span class="text-white align-middle" style="font-size: 20px !important;"> Trainer</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-gridz gap-0">
                                            <img src="../media/assets/onefit-full-logo-standard-darkbg.svg" alt="onefit graphic logo" class="img-fluid shadow p-3" style="max-height: 100px;">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-gridz gap-0">
                                            <!-- right touch for scroll indicator -->
                                            <span class="material-icons material-icons-round align-middle text-muted p-4 rounded-circle shadow" style="font-size: 20px !important;color: #ffa500 !important;">brush</span><!-- fingerprint -->
                                            <span class="text-white align-middle" style="font-size: 20px !important;"> Create</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-gridz gap-0">
                                            <!-- right touch for scroll indicator -->
                                            <span class="material-icons material-icons-round align-middle text-muted p-4 rounded-circle shadow" style="font-size: 20px !important;color: #ffa500 !important;">more_vert</span><!-- fingerprint -->
                                            <span class="text-white align-middle" style="font-size: 20px !important;"> More</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- main profle content -->
                            <!-- iframe to load user profile header script ui output -->
                            <!-- <iframe id="iframe-load-profile-header-section" class="w-100" src="test.html" frameborder="0" style="height: 200vh;"></iframe> -->
                            <!-- iframe to load user profile header script ui output -->
                            <!-- ./ main profle content -->

                            <!-- use php require for profile header section -->
                            <!-- require("../scripts/php/main_app/compile_content/profile_tab/user_profile_header.php?usnm=$currentUser_Usrnm"); -->

                            <!-- inline/flex profile tab subtabs controller btns -->
                            <div id="inline-profile-content-tab-btns" class="d-grid justify-content-center w3-animate-bottom p-2" style="background: #333; border-radius: 25px; overflow: hidden;">
                                <style>
                                    .force-inline-nav {
                                        flex-wrap: nowrap !important;
                                    }
                                </style>

                                <div class="w3-animate-bottom horizontal-scroll no-scroller p-4" style="overflow-y: hidden;" id="insights-subfeatures-nav-menu">
                                    <nav class="m-0">
                                        <div class="nav force-inline-nav nav-tabs border-0 justify-content-centerz" id="nav-tab-profiletab-subtabs-controller-container" role="tablist" style="border-color: #ffa500 !important">
                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative active" style="border-radius: 25px !important;min-width: 130px;" id="nav-profiletab-main-communityfeed-subtab" onclick="clickProfileTabMainSubTabs('community_feed')" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-profile-subtab-communityfeed" type="button" role="tab" aria-controls="v-sub-tab-pills-profile-subtab-communityfeed" aria-selected="true">
                                                <span id="profiletab-main-navs-horizontal-rule-icon-communityfeed" class="material-icons material-icons-outlined align-middle" style="display: block; font-size: 40px !important;">hub</span>
                                                <span class="align-middle">Community
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;min-width: 130px;" id="nav-profiletab-main-posts-subtab" onclick="clickProfileTabMainSubTabs('posts')" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-profile-subtab-posts" type="button" role="tab" aria-controls="v-sub-tab-pills-profile-subtab-posts" aria-selected="false">
                                                <span id="profiletab-main-navs-horizontal-rule-icon-posts" class="material-icons material-icons-outlined align-middle" style=" display: block; font-size: 40px !important;">dynamic_feed</span>
                                                <span class="align-middle">Posts
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;min-width: 130px;" id="nav-profiletab-main-media-subtab" onclick="clickProfileTabMainSubTabs('media')" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-profile-subtab-media" type="button" role="tab" aria-controls="v-sub-tab-pills-profile-subtab-media" aria-selected="false">
                                                <span id="profiletab-main-navs-horizontal-rule-icon-media" class="material-icons material-icons-outlined align-middle" style="display: block; font-size: 40px !important;">perm_media</span>
                                                <span class="align-middle">Media</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;min-width: 130px;" id="nav-profiletab-main-resources-subtab" onclick="clickProfileTabMainSubTabs('resources')" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-profile-subtab-resources" type="button" role="tab" aria-controls="v-sub-tab-pills-profile-subtab-resources" aria-selected="false">
                                                <span id="profiletab-main-navs-horizontal-rule-icon-resources" class="material-icons material-icons-outlined align-middle" style="display: block; font-size: 40px !important;">note_alt</span>
                                                <span class="align-middle">Resources</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;min-width: 130px;" id="nav-profiletab-main-favourites-subtab" onclick="clickProfileTabMainSubTabs('saved')" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-profile-subtab-favourites" type="button" role="tab" aria-controls="v-sub-tab-pills-profile-subtab-favourites" aria-selected="false">
                                                <span id="profiletab-main-navs-horizontal-rule-icon-favourites" class="material-icons material-icons-outlined align-middle" style="display: block; font-size: 40px !important;">bookmarks</span>
                                                <span class="align-middle">Saved</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;min-width: 130px;" id="nav-profiletab-main-groups-subtab" onclick="clickProfileTabMainSubTabs('groups')" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-profile-subtab-groups" type="button" role="tab" aria-controls="v-sub-tab-pills-profile-subtab-groups" aria-selected="false">
                                                <span id="profiletab-main-navs-horizontal-rule-icon-groups" class="material-icons material-icons-outlined align-middle" style="display: block; font-size: 40px !important;">groups_2</span>
                                                <span class="align-middle">Groups</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;min-width: 130px;" id="nav-profiletab-main-interactions-subtab" onclick="clickProfileTabMainSubTabs('interactions')" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-profile-subtab-interactions" type="button" role="tab" aria-controls="v-sub-tab-pills-profile-subtab-interactions" aria-selected="false">
                                                <span id="profiletab-main-navs-horizontal-rule-icon-interactions" class="material-icons material-icons-outlined align-middle" style="display: block; font-size: 40px !important;">handshake</span>
                                                <span class="align-middle">Interactions</span>
                                            </button>

                                        </div>
                                    </nav>

                                </div>
                            </div>
                            <!-- ./ inline/flex profile tab subtabs controller btns -->

                            <div class="row">
                                <!-- user post sharing form and users posts below it -->
                                <div class="col-xlg-8 p-4">
                                    <!-- profile tab sub-tabs container -->
                                    <div class="tab-content" id="v-pills-tab-profiletab-main-subtabs">
                                        <!-- #v-sub-tab-pills-profile-subtab-communityfeed -->
                                        <div class="tab-pane fade show active content-panel-border-style-dark-bg w3-animate-bottom no-scroller p-4 gap-4" style="min-height: 50vh;" id="v-sub-tab-pills-profile-subtab-communityfeed" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-profile-subtab-communityfeed">
                                            <div class="row align-items-start">
                                                <div class="col-md-4 p-4" style="max-height: 90vh;overflow-y: auto">
                                                    <h5><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">
                                                            diversity_3</span><span class="align-middle"> Groups.</span></h5>
                                                    <hr class="text-white">
                                                    <div id="user-community-groups-subs-list">
                                                        <p>User will b able to see a list of their group subscriptions and open the feeds
                                                            specific to the selected group.</p>
                                                    </div>

                                                    <h5><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">
                                                            diversity_2</span><span class="align-middle"> Teams.</span></h5>
                                                    <hr class="text-white">
                                                    <div id="user-teams-groups-subs-list">
                                                        <p>User will b able to see a list of their group subscriptions and open the feeds
                                                            specific to the selected group.</p>
                                                    </div>

                                                    <h5><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">
                                                            verified_user</span><span class="align-middle"> Pro.</span></h5>
                                                    <hr class="text-white">
                                                    <div id="user-pro-groups-subs-list">
                                                        <p>User will b able to see a list of their group subscriptions and open the feeds
                                                            specific to the selected group.</p>
                                                    </div>

                                                </div>
                                                <div class="col-md-8">
                                                    <!-- community posts feed -->
                                                    <div id="profile-community-post-feed-container" class="container shadow mb-4 py-4" style="border-radius: 25px;">
                                                        <h5 class="mb-4 text-center">
                                                            <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">
                                                                hub
                                                            </span>
                                                            <span class="align-middle"> Community Social Feed.</span>
                                                        </h5>

                                                        <hr class="text-white">

                                                        <div id="profile-community-post-social-feed" class="p-0 no-scroller" style="max-height: 90vh;overflow-y: auto">
                                                            <!-- Social Update Card -->
                                                            <div class="my-4 p-0 social-update-card shadow-lg" style="border-bottom: #ffa500 solid 5px;" id="post-' . $usrposts_postid . '-' . $usrposts_user . '">
                                                                <div class="row align-items-top p-0 m-0 display-profile-banner-container border-5 border-top" style="border-radius: 25px!important; max-height: 200px !important; border-color: #ffa500 !important;">
                                                                    <div class="col-md -4 d-grid justify-content-center text-center p-4 down-top-grad-dark">
                                                                        <!-- Profile Picture -->
                                                                        <div class="display-profile-img-container shadow-lg w3-animate-left" style="margin-top: -0px !important; ">
                                                                            <!-- $output_user_account_profile_img -->
                                                                        </div>
                                                                        <!-- ./ Profile Picture -->
                                                                    </div>
                                                                    <div class="col-md-8 text-center p-4 d-none d-lg-block d-flex justify-content-end">
                                                                        <div class="d-grid p-4 w3-animate-bottom" style="border-radius: 15px!important; background-color: rgba(52, 52, 52, 0.8) !important;">
                                                                            <h3 class="text-truncate">
                                                                                Thabang Mposula
                                                                                <span class="material-icons material-icons-round" style="font-size: 20px !important"> verified_user
                                                                                </span>
                                                                            </h3>
                                                                            <span class="mb-2" style="font-size: 10px">@<span style="color: #ffa500">KING_001</span>
                                                                            </span>

                                                                            <!-- main buttons for interacting with user post (hide on <lg) -->
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <!--  -->
                                                                                <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">follow_the_signs</span>
                                                                                    <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                                        <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                                        Follow Me
                                                                                    </span>
                                                                                </button>

                                                                                <!-- visual divide -->
                                                                                <div>
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                                                                                        horizontal_rule
                                                                                    </span>
                                                                                </div>
                                                                                <!-- ./ visual divide -->

                                                                                <!--  -->
                                                                                <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important"> handshake
                                                                                    </span>
                                                                                    <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                                        <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                                        Help
                                                                                    </span>
                                                                                </button>

                                                                                <!-- visual divide -->
                                                                                <div>
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                                                                                        horizontal_rule
                                                                                    </span>
                                                                                </div>
                                                                                <!-- ./ visual divide -->


                                                                                <!--  -->
                                                                                <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important"> 3p </span>
                                                                                    <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                                        <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                                        Message
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                            <!-- ./ main buttons for interacting with user post (hide on <lg) -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="post-content p-4 fs-3 text-break down-top-grad-dark" style="border-radius: 25px!important;">
                                                                    <!-- <hr class="bg-white"> -->

                                                                    <!-- secondary buttons for interacting with user post (hide on >lg) -->
                                                                    <div class="d-md-flex d-lg-none d-flex justify-content-between align-items-center w3-animate-left mb-4">
                                                                        <!--  -->
                                                                        <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">follow_the_signs</span>
                                                                            <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                                <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                                Follow Me
                                                                            </span>
                                                                        </button>

                                                                        <!-- visual divide -->
                                                                        <div>
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                                                                                horizontal_rule
                                                                            </span>
                                                                        </div>
                                                                        <!-- ./ visual divide -->

                                                                        <!--  -->
                                                                        <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important"> handshake </span>
                                                                            <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                                <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                                Help
                                                                            </span>
                                                                        </button>

                                                                        <!-- visual divide -->
                                                                        <div>
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                                                                                horizontal_rule
                                                                            </span>
                                                                        </div>
                                                                        <!-- ./ visual divide -->


                                                                        <!--  -->
                                                                        <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important"> 3p </span>
                                                                            <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                                <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                                Message
                                                                            </span>
                                                                        </button>
                                                                    </div>
                                                                    <!-- ./ secondary buttons for interacting with user post (hide on >lg) -->

                                                                    <div class="row align-items-center">
                                                                        <div class="col-md text-center">
                                                                            <hr class="bg-white">
                                                                        </div>
                                                                        <div class="col-md-4 text-start">
                                                                            <p class="fs-6 m-0 comfortaa-font fw-light text-center text-truncate">
                                                                                <small class="text-decoration-underlinez">
                                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;color: #ffa500;">post_add</span>
                                                                                    <span class="align-middle">
                                                                                        Thabang shared a post.
                                                                                    </span>
                                                                                </small>
                                                                            </p>
                                                                        </div>
                                                                    </div>

                                                                    <!-- post message outer container -->
                                                                    <div id="post-card-message-outer-container" class="fs-3">
                                                                        <p class="my-2 text-break">This is the message area. When the user
                                                                            types, it is supposed to auto update this element.</p>
                                                                    </div>
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-4 text-center">
                                                                            <p class="text-right p-3 rounded-pill m-0" style="font-size: 10px; background-color: #ffa500; color: #343434;">
                                                                                1 day ago
                                                                                <!--(' . $usrposts_postdate . ')-->
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md text-center">
                                                                            <hr class="bg-white">
                                                                        </div>
                                                                    </div>

                                                                    <!--function buttons-->
                                                                    <ul class="list-group list-group-horizontal -sm my-0 no-scroller" style="overflow-x: auto;">
                                                                        <!-- like post function btn -->
                                                                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                                                                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font">
                                                                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                                                                    favorite
                                                                                </span>
                                                                                <span class="d-none d-lg-block text-truncate" style="font-size: 10px !important;">Like</span>
                                                                            </button>

                                                                        </li>
                                                                        <!-- comment on post function btn -->
                                                                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                                                                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font">
                                                                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                                                                    insert_comment
                                                                                </span>
                                                                                <span class="d-none d-lg-block text-truncate" style="font-size: 10px !important;">
                                                                                    Comment
                                                                                </span>
                                                                            </button>
                                                                        </li>
                                                                        <!-- share post function btn -->
                                                                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                                                                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font">
                                                                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                                                                    share
                                                                                </span>
                                                                                <span class="d-none d-lg-block text-truncate" style="font-size: 10px !important;">Share</span>
                                                                            </button>
                                                                        </li>
                                                                        <!-- save post function btn -->
                                                                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                                                                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font">
                                                                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                                                                    bookmarks
                                                                                </span>
                                                                                <span class="d-none d-lg-block text-truncate" style="font-size: 10px !important;">Save</span>
                                                                            </button>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <!-- ./ Social Update Card -->

                                                        </div>
                                                    </div>
                                                    <!-- ./ community posts feed -->
                                                </div>
                                            </div>

                                        </div>
                                        <!-- #v-sub-tab-pills-profile-subtab-posts -->
                                        <div class="tab-pane fade content-panel-border-style-dark-bg w3-animate-bottom no-scroller p-4 gap-4" style="min-height: 50vh;" id="v-sub-tab-pills-profile-subtab-posts" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-profile-subtab-posts">

                                            <!-- user post sharing form and users posts below it -->
                                            <!-- share a community post/update -->
                                            <div id="profile-social-post-update-container" class="container shadow mb-4 py-4 px-0" style="border-radius: 25px;overflow-x: auto;">
                                                <h5 class="px-4">
                                                    <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">
                                                        post_add
                                                    </span>
                                                    <span class="align-middle"> Share an Update.</span>
                                                </h5>
                                                <div class="rowz d-grid align-items-center" id="tab-nav-social-quickpostz">
                                                    <!-- lvl1 Quick Post to Social -->
                                                    <div class="col-lgz d-grid gap-2 p-4">
                                                        <!-- Quick Post to Social -->
                                                        <div class="social-quick-post d-grid comfortaa-font">
                                                            <textarea name="" class="w-100 quick-post-input" id="post-message-community" cols="30" rows="5" placeholder="Share an update with the Community."></textarea>
                                                            <div id="post-message-options" class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex justify-content-start">
                                                                    <!--  -->
                                                                    <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">add_reaction</span>
                                                                        <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                            <span style="color: #ffa500 !important;">+</span>
                                                                            feeling</span>
                                                                    </button>
                                                                    <!--  -->
                                                                    <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">attach_file </span>
                                                                        <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                            <span style="color: #ffa500 !important;">+</span>
                                                                            resource</span>
                                                                    </button>
                                                                    <!--  -->
                                                                    <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">perm_media </span>
                                                                        <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                            <span style="color: #ffa500 !important;">+</span>
                                                                            media</span>
                                                                    </button>
                                                                    <!--  -->
                                                                    <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">link</span>
                                                                        <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                            <span style="color: #ffa500 !important;">+</span>
                                                                            web</span>
                                                                    </button>
                                                                    <!--  -->
                                                                    <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">history_edu</span>
                                                                        <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                            <span style="color: #ffa500 !important;">+</span>
                                                                            quote</span>
                                                                    </button>
                                                                </div>
                                                                <!--  -->
                                                                <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1">
                                                                    <!-- <i class="fas fa-paper-plane" style="font-size: 38px !important"></i> -->
                                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 40px !important;color: #ffa500;"> post_add
                                                                    </span>
                                                                    <span class="align-middle">Send.</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!-- ./ Quick Post to Social -->
                                                    </div>
                                                    <!-- lvl1 Quick Post to Social -->
                                                    <!-- lvl 1 post preview -->
                                                    <div class="col-lg-4z d-grid gap-2 p-4">
                                                        <!-- post preview -->
                                                        <h5 class="text-center">
                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                                preview
                                                            </span>
                                                            <span class="align-middle"> Preview.</span>
                                                        </h5>
                                                        <!-- Social Update Card -->
                                                        <div class="my-4 p-0 social-update-card shadow-lg" style="border-bottom: #ffa500 solid 5px;" id="post-' . $usrposts_postid . '-' . $usrposts_user . '">
                                                            <div class="row align-items-top p-0 m-0 display-profile-banner-container border-5 border-top" style="border-radius: 25px!important; max-height: 200px !important; border-color: #ffa500 !important;">
                                                                <div class="col-md -4 d-grid justify-content-center text-center p-4 down-top-grad-dark">
                                                                    <!-- Profile Picture -->
                                                                    <div class="display-profile-img-container shadow-lg w3-animate-left" style="margin-top: -0px !important; ">
                                                                        <!-- $output_user_account_profile_img -->
                                                                    </div>
                                                                    <!-- ./ Profile Picture -->
                                                                </div>
                                                                <div class="col-md-8 text-center p-4 d-none d-lg-block d-flex justify-content-end">
                                                                    <div class="d-grid p-4 w3-animate-bottom" style="border-radius: 15px!important; background-color: rgba(52, 52, 52, 0.8) !important;">
                                                                        <h3 class="text-truncate">
                                                                            Thabang Mposula
                                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important"> verified_user
                                                                            </span>
                                                                        </h3>
                                                                        <span class="mb-2" style="font-size: 10px">@<span style="color: #ffa500">KING_001</span>
                                                                        </span>

                                                                        <!-- main buttons for interacting with user post (hide on <lg) -->
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <!--  -->
                                                                            <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">follow_the_signs</span>
                                                                                <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                                    <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                                    Follow Me
                                                                                </span>
                                                                            </button>

                                                                            <!-- visual divide -->
                                                                            <div>
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                                                                                    horizontal_rule
                                                                                </span>
                                                                            </div>
                                                                            <!-- ./ visual divide -->

                                                                            <!--  -->
                                                                            <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important"> handshake
                                                                                </span>
                                                                                <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                                    <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                                    Help
                                                                                </span>
                                                                            </button>

                                                                            <!-- visual divide -->
                                                                            <div>
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                                                                                    horizontal_rule
                                                                                </span>
                                                                            </div>
                                                                            <!-- ./ visual divide -->


                                                                            <!--  -->
                                                                            <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important"> 3p </span>
                                                                                <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                                    <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                                    Message
                                                                                </span>
                                                                            </button>
                                                                        </div>
                                                                        <!-- ./ main buttons for interacting with user post (hide on <lg) -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="post-content p-4 fs-3 text-break down-top-grad-dark" style="border-radius: 25px!important;">
                                                                <!-- <hr class="bg-white"> -->

                                                                <!-- secondary buttons for interacting with user post (hide on >lg) -->
                                                                <div class="d-md-flex d-lg-none d-flex justify-content-between align-items-center w3-animate-left mb-4">
                                                                    <!--  -->
                                                                    <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">follow_the_signs</span>
                                                                        <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                            <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                            Follow Me
                                                                        </span>
                                                                    </button>

                                                                    <!-- visual divide -->
                                                                    <div>
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                                                                            horizontal_rule
                                                                        </span>
                                                                    </div>
                                                                    <!-- ./ visual divide -->

                                                                    <!--  -->
                                                                    <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important"> handshake </span>
                                                                        <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                            <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                            Help
                                                                        </span>
                                                                    </button>

                                                                    <!-- visual divide -->
                                                                    <div>
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                                                                            horizontal_rule
                                                                        </span>
                                                                    </div>
                                                                    <!-- ./ visual divide -->


                                                                    <!--  -->
                                                                    <button type="button" class="onefit-buttons-style-dark p-3 m-1 border-1 bg-transparent d-grid">
                                                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important"> 3p </span>
                                                                        <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                                                            <!-- <span style="color: #ffa500 !important;">+</span> -->
                                                                            Message
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                                <!-- ./ secondary buttons for interacting with user post (hide on >lg) -->

                                                                <div class="row align-items-center">
                                                                    <div class="col-md text-center">
                                                                        <hr class="bg-white">
                                                                    </div>
                                                                    <div class="col-md-4 text-start">
                                                                        <p class="fs-6 m-0 comfortaa-font fw-light text-center text-truncate">
                                                                            <small class="text-decoration-underlinez">
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;color: #ffa500;">post_add</span>
                                                                                <span class="align-middle">
                                                                                    Thabang shared a post.
                                                                                </span>
                                                                            </small>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <!-- post message outer container -->
                                                                <div id="post-card-message-outer-container" class="fs-3">
                                                                    <p class="my-2 text-break">This is the message area. When the user
                                                                        types, it is supposed to auto update this element.</p>
                                                                </div>
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-4 text-center">
                                                                        <p class="text-right p-3 rounded-pill m-0" style="font-size: 10px; background-color: #ffa500; color: #343434;">
                                                                            1 day ago
                                                                            <!--(' . $usrposts_postdate . ')-->
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-md text-center">
                                                                        <hr class="bg-white">
                                                                    </div>
                                                                </div>

                                                                <!--function buttons-->
                                                                <ul class="list-group list-group-horizontal -sm my-0 no-scroller" style="overflow-x: auto;">
                                                                    <!-- like post function btn -->
                                                                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                                                                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font">
                                                                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                                                                favorite
                                                                            </span>
                                                                            <span class="d-none d-lg-block text-truncate" style="font-size: 10px !important;">Like</span>
                                                                        </button>

                                                                    </li>
                                                                    <!-- comment on post function btn -->
                                                                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                                                                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font">
                                                                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                                                                insert_comment
                                                                            </span>
                                                                            <span class="d-none d-lg-block text-truncate" style="font-size: 10px !important;">
                                                                                Comment
                                                                            </span>
                                                                        </button>
                                                                    </li>
                                                                    <!-- share post function btn -->
                                                                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                                                                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font">
                                                                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                                                                share
                                                                            </span>
                                                                            <span class="d-none d-lg-block text-truncate" style="font-size: 10px !important;">Share</span>
                                                                        </button>
                                                                    </li>
                                                                    <!-- save post function btn -->
                                                                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                                                                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font">
                                                                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                                                                bookmarks
                                                                            </span>
                                                                            <span class="d-none d-lg-block text-truncate" style="font-size: 10px !important;">Save</span>
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- ./ Social Update Card -->
                                                        <!-- ./ post preview -->

                                                    </div>
                                                    <!-- ./ lvl 1 post preview -->
                                                </div>
                                            </div>
                                            <!-- ./ share a community post/update -->

                                            <hr class="text-white">

                                            <!-- users posts history -->
                                            <div id="profile-user-post-history-container" class="container shadow mb-4 py-4" style="border-radius: 25px;">
                                                <h5 class="mb-4">
                                                    <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">
                                                        timelapse
                                                    </span>
                                                    <span class="align-middle"> My Posts.</span>
                                                </h5>

                                                <div id="profile-user-post-history-feed" class="p-0 no-scroller" style="min-height: 18vh;overflow-y: auto">

                                                </div>
                                            </div>

                                            <!-- ./ users posts history -->
                                        </div>
                                        <!-- #v-sub-tab-pills-profile-subtab-media -->
                                        <div class="tab-pane fade content-panel-border-style-dark-bg w3-animate-bottom no-scroller p-4 gap-4" style="min-height: 50vh;" id="v-sub-tab-pills-profile-subtab-media" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-profile-subtab-media">
                                            hello world 3
                                        </div>
                                        <!-- #v-sub-tab-pills-profile-subtab-resources -->
                                        <div class="tab-pane fade content-panel-border-style-dark-bg w3-animate-bottom no-scroller p-4 gap-4" style="min-height: 50vh;" id="v-sub-tab-pills-profile-subtab-resources" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-profile-subtab-resources">
                                            hello world 4
                                        </div>
                                        <!-- #v-sub-tab-pills-profile-subtab-favourites -->
                                        <div class="tab-pane fade content-panel-border-style-dark-bg w3-animate-bottom no-scroller p-4 gap-4" style="min-height: 50vh;" id="v-sub-tab-pills-profile-subtab-favourites" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-profile-subtab-favourites">
                                            hello world 5
                                        </div>
                                        <!-- #v-sub-tab-pills-profile-subtab-groups -->
                                        <div class="tab-pane fade content-panel-border-style-dark-bg w3-animate-bottom no-scroller p-4 gap-4" style="min-height: 50vh;" id="v-sub-tab-pills-profile-subtab-groups" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-profile-subtab-groups">
                                            <h1 class="text-center">
                                                <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">
                                                    groups_2
                                                </span>
                                                <span class="align-middle"> My Groups.</span>
                                            </h1>
                                            <hr class="text-white">
                                            <h5>
                                                <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">
                                                    diversity_3</span><span class="align-middle"> Community.</span>
                                            </h5>
                                            <hr class="text-white">
                                            <div id="community-groups-full-list">
                                                <p>User will b able to see a list of their group subscriptions and open the feeds
                                                    specific to the selected group.</p>
                                            </div>

                                            <h5>
                                                <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">
                                                    diversity_2</span><span class="align-middle"> Teams.</span>
                                            </h5>
                                            <hr class="text-white">
                                            <div id="teams-groups-full-list">
                                                <p>User will be able to see a list of all teams groups and subscribe or open the groups.</p>
                                            </div>

                                            <h5>
                                                <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">
                                                    verified_user</span><span class="align-middle"> Pro.</span>
                                            </h5>
                                            <hr class="text-white">
                                            <div id="pro-groups-full-list">
                                                <p>User will be able to see a list of all pro groups and subscribe or open the groups.</p>
                                            </div>

                                        </div>
                                        <!-- #v-sub-tab-pills-profile-subtab-interactions -->
                                        <div class="tab-pane fade content-panel-border-style-dark-bg w3-animate-bottom no-scroller p-4 gap-4" style="min-height: 50vh;" id="v-sub-tab-pills-profile-subtab-interactions" role="tabpanel" aria-labelledby="v-sub-tab-pills-profile-subtab-interactions">
                                            <!-- interactions must show the users friends, followers, users/groups 
                                            that the users follows and a panel for seeing the help requests that 
                                            the user has received and/or has been sent to other users.  -->

                                            <div class="row align-items-start">
                                                <!-- help. focus column -->
                                                <div class="col-xlg my-4 border-5 border-start border-end py-4 no-scroller" style="max-height: 90vh;border-radius: 25px;border-color: #ffa500 !important;">
                                                    <!-- Help section also has sub-sections: ( Help Requests, Trainer Support, Trainee Support, Enquiries ) -->
                                                    <!-- friends list grid section -->
                                                    <h5 class="text-center d-grid gap-2"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">
                                                            handshake</span><span class="align-middle"> Help the Community.</span>
                                                    </h5>
                                                    <hr class="text-white">
                                                    <div id="help-sub-sections-accord">
                                                        <!-- help. sub-sections -->
                                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                                            <!-- community help requests support accord segment -->
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="flush-headingOne">
                                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                                        Community help requests.
                                                                    </button>
                                                                </h2>
                                                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                                    <div class="accordion-body">Placeholder content for this accordion,
                                                                        which is intended to demonstrate the <code>.accordion-flush</code>
                                                                        class. This is the first item's accordion body.</div>
                                                                </div>
                                                            </div>
                                                            <!-- trainer support accord segment -->
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="flush-headingTwo">
                                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                                        Trainer support.
                                                                    </button>
                                                                </h2>
                                                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                                                    <div class="accordion-body">Placeholder content for this accordion,
                                                                        which is intended to demonstrate the <code>.accordion-flush</code>
                                                                        class. This is the second item's accordion body. Let's imagine this
                                                                        being filled with some actual content.</div>
                                                                </div>
                                                            </div>
                                                            <!-- trainee support accord segment -->
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="flush-headingThree">
                                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                                        Trainee support.
                                                                    </button>
                                                                </h2>
                                                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                                                    <div class="accordion-body">Placeholder content for this accordion,
                                                                        which is intended to demonstrate the <code>.accordion-flush</code>
                                                                        class. This is the third item's accordion body. Nothing more
                                                                        exciting happening here in terms of content, but just filling up the
                                                                        space to make it look, at least at first glance, a bit more
                                                                        representative of how this would look in a real-world application.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- enquiries support accord segment -->
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="flush-headingThree">
                                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                                                        Enquiries.
                                                                    </button>
                                                                </h2>
                                                                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                                                    <div class="accordion-body">Placeholder content for this accordion,
                                                                        which is intended to demonstrate the <code>.accordion-flush</code>
                                                                        class. This is the third item's accordion body. Nothing more
                                                                        exciting happening here in terms of content, but just filling up the
                                                                        space to make it look, at least at first glance, a bit more
                                                                        representative of how this would look in a real-world application.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- ./ help. sub-sections -->
                                                    </div>

                                                    <!-- Help. leaderboard -->
                                                    <h5 class="text-center d-grid gap-2 mt-4"><span class="material-icons material-icons-outlined align-middle">
                                                            scoreboard</span><span class="align-middle"> Help Leaderboard.</span>
                                                    </h5>

                                                    <hr class="text-white">
                                                    <!-- ./ Help. leaderboard -->

                                                    <h5 class="mt-4 text-center">Ads<span style="color: #ffa500;">.</span></h5>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </div>

                                                    <div class="text-center w-100" style="max-height: 50vh;">
                                                        <img src="../media/assets/advertisment-ph.png" class="img-fluid shadow my-4" alt="placeholder" style="border-radius: 25px;">
                                                    </div>

                                                </div>
                                                <!-- ./ help. focus column -->
                                                <!-- friends, following, followers column -->
                                                <div class="col-xlg my-4 no-scroller p-0" style="max-height: 90vh;">

                                                    <div id="friends-list-grid-section" class="content-panel-border-style-dark-bg mb-4 p-4 w3-animate-bottom" style="min-height: 20vh;">
                                                        <!-- friends list grid section -->
                                                        <h5>
                                                            <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;font-size: 40px!important;">
                                                                diversity_1</span><span class="align-middle"> Friends.</span>
                                                        </h5>

                                                        <hr class="text-white">

                                                        <div class="grid-container">
                                                            <!-- example -->
                                                            <div class="grid-tile p-2">
                                                                <div class="card text-bg-dark border-5 w3-animate-left" style="max-height: 20vw;border-radius: 25px;overflow: hidden;">
                                                                    <img src="../media/profiles/0_default/default_profile_pic.svg" class="card-img" alt="placeholder profile img">
                                                                    <div class="card-img-overlay top-down-grad-dark" style="font-size: 10px!important;background-color: rgba(51, 51, 51, 0.5);border-radius: 15px;">
                                                                        <h5 class="card-title">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 30px !important;">verified_user</span>
                                                                            Name Surname
                                                                        </h5>
                                                                        <p class="text-muted" style="color: #ffa500;">Trainee</p>
                                                                        <p class="card-text p-1 text-start">
                                                                            <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid">
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 8px !important;">
                                                                                    info
                                                                                </span>
                                                                                <span class="align-middle">About me.</span>
                                                                            </a>
                                                                            <span id="friend-card-info-userid" class="collapse">
                                                                                Users
                                                                                biography here.Users biography here.Users
                                                                                biography here.Users biography here.
                                                                                Users biography here.Users biography here.Users
                                                                                biography
                                                                                here.Users biography here.Users biography here.
                                                                                Users biography here.Users biography here.Users
                                                                                biography
                                                                                here.Users biography here.Users biography here.
                                                                                Users biography here.Users biography here.Users
                                                                                biography
                                                                                here.Users biography here.Users biography here.
                                                                            </span>

                                                                        </p>

                                                                    </div>
                                                                </div>
                                                                <!-- user socials -->
                                                                <p class="card-text align-middle w3-animate-bottom">
                                                                    <small class="align-middle" style="color: #ffa500 !important;">Socials:
                                                                    </small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-twitter"></i>
                                                                        @handle |</small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-facebook"></i>
                                                                        /username |</small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-instagram"></i>
                                                                        @handle |</small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-whatsapp"></i>
                                                                        +27-whatsappnum </small>
                                                                </p>
                                                            </div>
                                                            <!-- ./ example -->

                                                            <!-- dynamic ajax list -->
                                                        </div>
                                                    </div>


                                                    <div id="following-list-grid-section" class="content-panel-border-style-dark-bg mb-4 p-4 w3-animate-bottom" style="min-height: 20vh;">
                                                        <h5 class="mb-4">
                                                            <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;font-size: 40px!important;">
                                                                follow_the_signs</span><span class="align-middle"> Your Audience.</span>
                                                        </h5>

                                                        <hr class="text-white">

                                                        <!-- Following list grid section -->
                                                        <h5 class="text-start">
                                                            <!-- <span class="material-icons material-icons-outlined align-middle"
                                                            style="font-size: 40px!important;">
                                                            follow_the_signs</span>  --><span class="align-middle">Following.</span>
                                                        </h5>
                                                        <hr class="text-white">
                                                        <div class="grid-container">
                                                            <!-- example -->
                                                            <div class="grid-tile p-2">
                                                                <div class="card text-bg-dark border-5 w3-animate-left" style="max-height: 20vw;border-radius: 25px;overflow: hidden;">
                                                                    <img src="../media/profiles/0_default/default_profile_pic.svg" class="card-img" alt="placeholder profile img">
                                                                    <div class="card-img-overlay top-down-grad-dark" style="font-size: 10px!important;background-color: rgba(51, 51, 51, 0.5);border-radius: 15px;">
                                                                        <h5 class="card-title">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 30px !important;">verified_user</span>
                                                                            Name Surname
                                                                        </h5>
                                                                        <p class="text-muted" style="color: #ffa500;">Trainee</p>
                                                                        <p class="card-text p-1 text-start">
                                                                            <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid">
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 8px !important;">
                                                                                    info
                                                                                </span>
                                                                                <span class="align-middle">About me.</span>
                                                                            </a>
                                                                            <span id="friend-card-info-userid" class="collapse">
                                                                                Users
                                                                                biography here.Users biography here.Users
                                                                                biography here.Users biography here.
                                                                                Users biography here.Users biography here.Users
                                                                                biography
                                                                                here.Users biography here.Users biography here.
                                                                                Users biography here.Users biography here.Users
                                                                                biography
                                                                                here.Users biography here.Users biography here.
                                                                                Users biography here.Users biography here.Users
                                                                                biography
                                                                                here.Users biography here.Users biography here.
                                                                            </span>

                                                                        </p>

                                                                    </div>
                                                                </div>
                                                                <!-- user socials -->
                                                                <p class="card-text align-middle w3-animate-bottom">
                                                                    <small class="align-middle" style="color: #ffa500 !important;">Socials:
                                                                    </small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-twitter"></i>
                                                                        @handle |</small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-facebook"></i>
                                                                        /username |</small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-instagram"></i>
                                                                        @handle |</small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-whatsapp"></i>
                                                                        +27-whatsappnum </small>
                                                                </p>
                                                            </div>
                                                            <!-- ./ example -->

                                                            <!-- dynamic ajax list -->
                                                        </div>
                                                        <hr class="text-white">
                                                        <!-- Followers list grid section -->
                                                        <h5 class="text-start">
                                                            <!-- <span class="material-icons material-icons-outlined align-middle"
                                                            style="font-size: 40px!important;">
                                                            follow_the_signs</span>  --><span class="align-middle">Followers.</span>
                                                        </h5>
                                                        <hr class="text-white">
                                                        <div class="grid-container">
                                                            <!-- example -->
                                                            <div class="grid-tile p-2">
                                                                <div class="card text-bg-dark border-5 w3-animate-left" style="max-height: 20vw;border-radius: 25px;overflow: hidden;">
                                                                    <img src="../media/profiles/0_default/default_profile_pic.svg" class="card-img" alt="placeholder profile img">
                                                                    <div class="card-img-overlay top-down-grad-dark" style="font-size: 10px!important;background-color: rgba(51, 51, 51, 0.5);border-radius: 15px;">
                                                                        <h5 class="card-title">
                                                                            <span class="material-icons material-icons-round align-middle" style="font-size: 30px !important;">verified_user</span>
                                                                            Name Surname
                                                                        </h5>
                                                                        <p class="text-muted" style="color: #ffa500;">Trainee</p>
                                                                        <p class="card-text p-1 text-start">
                                                                            <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid">
                                                                                <span class="material-icons material-icons-round align-middle" style="font-size: 8px !important;">
                                                                                    info
                                                                                </span>
                                                                                <span class="align-middle">About me.</span>
                                                                            </a>
                                                                            <span id="friend-card-info-userid" class="collapse">
                                                                                Users
                                                                                biography here.Users biography here.Users
                                                                                biography here.Users biography here.
                                                                                Users biography here.Users biography here.Users
                                                                                biography
                                                                                here.Users biography here.Users biography here.
                                                                                Users biography here.Users biography here.Users
                                                                                biography
                                                                                here.Users biography here.Users biography here.
                                                                                Users biography here.Users biography here.Users
                                                                                biography
                                                                                here.Users biography here.Users biography here.
                                                                            </span>

                                                                        </p>

                                                                    </div>
                                                                </div>
                                                                <!-- user socials -->
                                                                <p class="card-text align-middle w3-animate-bottom">
                                                                    <small class="align-middle" style="color: #ffa500 !important;">Socials:
                                                                    </small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-twitter"></i>
                                                                        @handle |</small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-facebook"></i>
                                                                        /username |</small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-instagram"></i>
                                                                        @handle |</small>
                                                                    <small class="align-middle" style="font-size: 8px !important"><i class="fab fa-whatsapp"></i>
                                                                        +27-whatsappnum </small>
                                                                </p>
                                                            </div>
                                                            <!-- ./ example -->

                                                            <!-- dynamic ajax list -->
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- ./ friends, following, followers column -->
                                            </div>

                                        </div>
                                    </div>
                                    <!-- ./ profile tab sub-tabs container -->
                                </div>
                                <!-- more stuff column -->
                                <div class="col-xlg-4 p-4">
                                    <div class="nav">
                                        <!-- more stuff -->
                                        <div id="profile-social-post-update-container" class="container-fluid shadow my-4 py-4 content-panel-border-style-dark-bg w3-animate-top" style="border-radius: 25px;">
                                            <h5 class="text-center"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">
                                                    read_more
                                                </span><span class="align-middle"> More Stuff.</span></h5>
                                            <hr class="text-white">
                                            <div id="more-stuff-container" style="min-height: 30vh;"></div>
                                        </div>

                                        <!-- rss feeds -->
                                        <div id="profile-social-post-update-container" class="container-fluid shadow my-4 py-4 content-panel-border-style-dark-bg w3-animate-bottom" style="border-radius: 25px;">
                                            <h5 class="text-center"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">
                                                    rss_feed
                                                </span><span class="align-middle"> RSS.</span></h5>
                                            <hr class="text-white">
                                            <div id="more-stuff-rss-feed-container" style="min-height: 30vh;">
                                                <iframe style="width: 100%;height:50vh;" src="https://rss.app/embed/v1/imageboard/tqX4YEeGEu1eOKAT" frameborder="0"></iframe>
                                                <!-- width="100%" height="50vh" -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- ./ Profile Tab: User Profile -->
                    </div>

                </div>
                <div id="TabDiscovery" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">travel_explore</span> <span class="align-middle">Discovery</span></h5>
                        <p class="text-center" style="font-size: 10px">powered by AdaptEngine™</p>

                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <div class="row align-items-center my-4">
                        <div class="col-md-10">
                            <input type="search" class="onefit-inputs-style" id="discover-search-input" placeholder="Search" />
                        </div>
                        <div class="col-md-2 text-left">
                            <button class="onefit-buttons-style-light my-4" id="search-discover">
                                <i class="fas fa-search m-4"></i>
                            </button>
                        </div>
                    </div>

                    • Trainees • Trainers • Onefoodie - Healthy Food and Diet Catalogue • Fitness Programs (Categories: Casual,
                    Home, Gym, Athlete "A-Prog", Sports / Team-Based "S-Prog"/"TBA-Prog") • Wellness Programs (Categories:
                    Physical
                    Health, Mental Health, Sports Rehabilitation, Lifestyle) • FitEngine (Internal curated re-search engine)
                    powered
                    by AdaptEngine™

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab-discovery" role="tablist" style="border-color: #ffa500 !important">
                            <button class="nav-link p-4 active" id="nav-discovery-trainers-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-trainers" type="button" role="tab" aria-controls="nav-discovery-trainers" aria-selected="true">Trainers</button>

                            <button class="nav-link p-4" id="nav-discovery-trainees-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-trainees" type="button" role="tab" aria-controls="nav-discovery-trainees" aria-selected="false">Trainees</button>

                            <button class="nav-link p-4" id="nav-discovery-groups-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-groups" type="button" role="tab" aria-controls="nav-discovery-groups" aria-selected="false">Groups</button>

                            <!-- <button class="nav-link p-4" id="nav-discovery-posts-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-posts" type="button" role="tab" aria-controls="nav-discovery-posts" aria-selected="false">Community Updates</button> -->

                            <!-- <button class="nav-link p-4" id="nav-discovery-fit-progs-indi-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-fit-progs-indi" type="button" role="tab" aria-controls="nav-discovery-fit-progs-indi" aria-selected="false">Indi-Fitness</button> -->

                            <button class="nav-link p-4" id="nav-discovery-fit-progs-team-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-fit-progs-team" type="button" role="tab" aria-controls="nav-discovery-fit-progs-team" aria-selected="false">Team-Fitness</button>

                            <button class="nav-link p-4" id="nav-discovery-well-progs-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-well-progs" type="button" role="tab" aria-controls="nav-discovery-well-progs" aria-selected="false">Wellness Programs</button>

                            <button class="nav-link p-4" id="nav-discovery-nutrition-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-nutrition" type="button" role="tab" aria-controls="nav-discovery-nutrition" aria-selected="false">Nutrition</button>

                            <button class="nav-link p-4" id="nav-discovery-fitengine-tab" data-bs-toggle="tab" data-bs-target="#nav-discovery-fitengine" type="button" role="tab" aria-controls="nav-discovery-fitengine" aria-selected="false">FitEngine&trade;</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tab-DiscoveryContent">
                        <div class="tab-pane fade show active" id="nav-discovery-trainers" role="tabpanel" aria-labelledby="nav-discovery-trainers-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Onefit.Net - Trainers</h1>

                            <div class="grid-container">
                                <?php echo $discoveryAllTrainers; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-trainees" role="tabpanel" aria-labelledby="nav-discovery-trainees-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Onefit.Net - Trainees</h1>

                            <div class="grid-container">
                                <?php echo $discoveryAllTrainees; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="nav-discovery-groups" role="tabpanel" aria-labelledby="nav-discovery-groups-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Onefit.Net - Groups</h1>

                            <div class="grid-container">
                                <?php echo $outputCommunityGroups; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-posts" role="tabpanel" aria-labelledby="nav-discovery-posts-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Onefit.Net - Community Updates</h1>

                            <div class="text-center" id="comm-updates-search-container">
                                <?php echo $outputCommunityUpdates; ?>
                            </div>
                        </div>

                        <!-- <div class="tab-pane fade" id="nav-discovery-fit-progs-indi" role="tabpanel" aria-labelledby="nav-discovery-fit-progs-indi-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Indi.Fitness Programs</h1>
                            <div class="grid-container">
                                <php echo $discoveryFitProgsIndi; ?>
                            </div>
                        </div> -->
                        <div class="tab-pane fade" id="nav-discovery-fit-progs-team" role="tabpanel" aria-labelledby="nav-discovery-fit-progs-team-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Team-Athletics Training Programs</h1>
                            <div class="grid-container">
                                <?php echo $discoveryFitProgsTeams; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-nutrition" role="tabpanel" aria-labelledby="nav-discovery-nutrition-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Nutrition</h1>

                            <div class="d-flex justify-content-center my-4">
                                <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-well-progs" role="tabpanel" aria-labelledby="nav-discovery-well-progs-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">Wellness</h1>

                            <div class="d-flex justify-content-center my-4">
                                <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-discovery-fitengine" role="tabpanel" aria-labelledby="nav-discovery-fitengine-tab">
                            <h1 class="text-center p-4 shadow rounded-pill">FitEngine Resources</h1>

                            <div class="d-flex justify-content-center my-4">
                                <div class="spinner-border text-light" role="status" style="width: 5rem; height: 5rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <div class="grid-container">
                                <?php echo $outputCommunityResources; ?>
                            </div>
                        </div>


                    </div>
                </div>
                <div id="TabStudio" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">play_circle_outline</span> <span style="color: #fff !important"> <span class="align-middle"><span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Studio</span></h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>
                    <!-- <h1 class="text-center"><span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Studio
                    </h1>
                    <hr class="text-white" /> -->

                    • Onefit.Community Streams (Onefit.tv) – Live stream sessions of scheduled Community (public) & Group-based
                    fitness program guidance classes. (Scheduled Program Guidance Classes and Community Events on Onefit App and
                    Socials that are open to all visitors, casual subscribers, and premium members (Onefit.app, Zoom, Skype,
                    Teams)
                    • Personal Training Centre – Scheduling of Private/One-On-One Live Streams and/or physical interaction with
                    Personal Trainers (Streams: Onefit.app, Zoom, Skype, Teams | Physical: Your nearest Gym Company Gym/nearest
                    Virgin Active and House-Call) • Stream library – Live stream recording history (Community and Private) •
                    Onefit.Muse (Music Centre/Music Playlist) • Athlete Fitness Programs • Team-Based Athletic Programs •
                    Individual
                    Home and Gym Fitness
                    Programs • Diet Programs (Pre-Defined & Custom)

                    <div class="grid-container studio-tab-grid">
                        <div class="grid-tile shadow p-4 down-top-grad-dark">
                            <!-- -100 max-100vh-->
                            <h2 class="text-center"><span class="material-icons material-icons-outlined"> tv </span> <span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Community Streams (Onefit.tv)</h2>
                            <p>Live stream sessions of scheduled Community (public) & Group-based fitness program guidance classes.
                                (Scheduled Program Guidance Classes and Community Events on Onefit App and Socials that are open to all
                                visitors, casual subscribers, and premium members (Onefit.app, Zoom, Skype, Teams)</p>

                            <!--<video preload="none" id="player" class="player" settings controls crossorigin data-poster="../media/assets/YouTube Thumbnail 1280x720 px.gif"></video>-->
                            <hr class="text-white" style="height: 5px;">

                            <p style="font-size: 10px">Latest Training Programs | <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span></p>

                            <div class="video-card-container">
                                <img src="../media/assets/YouTube Thumbnail 1280x720 px.gif" alt="" class="img-fluid shadow" />
                                <button class="onefit-buttons-style-light shadow play-btn p-4" onclick="playVideo()">
                                    <span class="material-icons material-icons-round" style="font-size: 50px !important;">
                                        play_circle_outline
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid-container studio-tab-grid">
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4>Training Live Stream</h4>
                            <p>Live stream recording history (Community and Private)</p>
                            <hr class="text-white" />
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4>Personal Training Centre</h4>
                            <p>Scheduling of Private/One-On-One Live Streams and/or physical interaction with Personal Trainers
                                (Streams: Onefit.app, Zoom, Skype, Teams | Physical: Your nearest Gym Company Gym/nearest Virgin Active
                                and House-Call)</p>
                            <hr class="text-white" />
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4><span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span> Sound Station<span class="material-icons material-icons-round">
                                    equalizer
                                </span>
                            </h4>
                            <p>Coming Soon</p>

                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4>Athletics Highlights</h4>
                            <p>Athletic Fitness Programs for Teams in Sports.</p>
                            <hr class="text-white" />
                        </div>
                        <div class="grid-tile max-100vh shadow p-4 down-top-grad-dark wide-grid-tile" style="overflow-y: auto;">
                            <h4>Nutrition</h4>
                            <p>Healthy Eating Guide</p>
                            <hr class="text-white" />
                        </div>
                    </div>
                </div>
                <div id="TabStore" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">storefront</span> <span class="align-middle"><span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Store</span></h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>
                    <!-- <h1 class="text-center"><span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Store
                    </h1>
                    <hr class="text-white" /> -->

                    • Sale of Activity Trackers and Smart Watches (wearables) • Sale of Fitness Equipment (weights, weight
                    benches,
                    treadmills, scales, etc.) • Sale of Supplements and Vitamins • Sale of Membership Subscriptions (3 Month, 6
                    Month, and Annual)

                    <img src="../media/assets/smartwatches/Watch Banner.png" alt="" class="img-fluid w-100 my-4 shadow" style="border-radius: 25px;">

                    <!-- Store Items Container -->
                    <div class="p-4" style="background-color: #343434; border-radius: 25px;">
                        <h5 class="fs-1 fw-bold text-center mb-4">
                            Browse our range of smart watches and activity trackers, weight-lifting and exercise equipment, fitness accessories, apparel, and more!...
                        </h5>
                        <p class="text-center">Need some stuff for your fitness journey, we have you coverd. Browse our selection of products and get them delivered to your door for free. It is in your benefit to become a Member of the Onefit Community today because all registered users and Premium Mmembers get Loyalty Discounts on every purchase. Go ahead and Register today, or better yet, become a Member to reap greater fitness rewards.</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="d-grid gap-2 d-lg-none d-xl-none d-xxl-none">
                                    <button class="onefit-buttons-style-dark p-4 mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#store-items-nav-menu" aria-expanded="true" aria-controls="store-items-nav-menu">
                                        <div class="d-grid gap-2">
                                            <span class="material-icons material-icons-round"> menu </span>
                                            <p style="font-size: 10px;">Store Items</p>
                                        </div>
                                    </button>
                                </div>
                                <div class="collapse show w3-animate-bottom" id="store-items-nav-menu">
                                    <div class="nav flex-column nav-pills" id="v-pills-store-Equipment-tab" role="tablist" aria-orientation="vertical">
                                        <button class="nav-link side-nav-link active" id="v-pills-social-store-wearables-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-wearables" type="button" role="tab" aria-controls="v-pills-social-store-wearables" aria-selected="true">
                                            <span class="material-icons material-icons-outlined">watch</span>
                                            <p>Wearables</p>
                                        </button>
                                        <button class="nav-link side-nav-link" id="v-pills-social-store-weights-bumbells-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-weights-bumbells" type="button" role="tab" aria-controls="v-pills-social-store-weights-bumbells" aria-selected="false">
                                            <div class="d-grid gap-2">
                                                <span class="material-icons material-icons-round">fitness_center</span>
                                                <p style="font-size: 10px;">Weights &amp; Dumbells</p>
                                            </div>
                                        </button>
                                        <button class="nav-link side-nav-link" id="v-pills-social-store-equipment-exercisemachines-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-equipment-exercisemachines" type="button" role="tab" aria-controls="v-pills-social-store-equipment-exercisemachines" aria-selected="false">
                                            <div class="d-grid gap-2">
                                                <span class="material-icons material-icons-round">monitor_weight</span>
                                                <p style="font-size: 10px;">Exercise Machines</p>
                                            </div>
                                        </button>
                                        <button class="nav-link side-nav-link" id="v-pills-social-store-fitness-accessories-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-fitness-accessories" type="button" role="tab" aria-controls="v-pills-social-store-fitness-accessories" aria-selected="false">
                                            <div class="d-grid gap-2">
                                                <span class="material-icons material-icons-round">backpack</span>
                                                <p style="font-size: 10px;">Fitness Accessories</p>
                                            </div>
                                        </button>
                                        <button class="nav-link side-nav-link" id="v-pills-social-store-apparel-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-apparel" type="button" role="tab" aria-controls="v-pills-social-store-apparel" aria-selected="false">
                                            <div class="d-grid gap-2">
                                                <span class="material-icons material-icons-round">checkroom</span>
                                                <p style="font-size: 10px;">Apparel</p>
                                            </div>
                                        </button>
                                        <button class="nav-link side-nav-link" id="v-pills-social-store-nutrition-supplements-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social-store-nutrition-supplements" type="button" role="tab" aria-controls="v-pills-social-store-nutrition-supplements" aria-selected="false">
                                            <div class="d-grid gap-2">
                                                <span class="material-icons material-icons-round">medication</span>
                                                <p style="font-size: 10px;">Nutrition &amp; Supplements</p>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active w3-animate-right" id="v-pills-social-store-wearables" role="tabpanel" aria-labelledby="v-pills-social-store-wearables-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Smart Watches &amp; Activity Trackers</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                        <!-- Smart watch Card Grid -->
                                        <div class="container">
                                            <div class="grid-container" id="store-smart-watch-grid-container">
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Aiwa Smart Band ASB-40 R149.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Aiwa Smart Band ASB-40</h5>
                                                        <h5 class="card-title">R149</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets//smartwatches/Apple Watch Series 3 GPS 38mm Silver Aluminium Case - White Sport Band R4400.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Apple Watch Series 3 GPS 38mm Silver Aluminium Case - White Sport Band</h5>
                                                        <h5 class="card-title">R4400</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/apple-watch-series-3-receives-a-massive-discount-530399-2.jpg" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Apple Watch Series 3</h5>
                                                        <h5 class="card-title">R4500</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Astrum Wireless Bluetooth IP68 Sports Smart Watch - M2 Black R639.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Astrum Wireless Bluetooth IP68 Sports Smart Watch - M2 Black</h5>
                                                        <h5 class="card-title">R639</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/FITBIT ALTA HR LARGE BLUE_GREY FITNESS TRACKER R24999.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">fitbit Alta HR Large Blue / Grey Fitness Tracker</h5>
                                                        <h5 class="card-title">R2499</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Fitbit Charge 4 Activity Tracker R2900.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Fitbit Charge 4 Activity Tracker</h5>
                                                        <h5 class="card-title">R2900</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/fitbit-versa2-3qtr-black.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">fitbit Versa 2 3QTR Black</h5>
                                                        <h5 class="card-title">R1999</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/FocusFit Pro - X3C IP68 Smartwatch and Fitness Tracker R798.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">FocusFit Pro - X3C IP68 Smartwatch and Fitness Tracker</h5>
                                                        <h5 class="card-title">R798</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/FocusFit Pro-T500 Smartwatch and Fitness Tracker R348.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">FocusFit Pro-T500 Smartwatch and Fitness Tracker</h5>
                                                        <h5 class="card-title">R348</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/G30 smartwatch-heartrate monitor-bluetooth call-blood pressure (black) R799.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">G30 smartwatch-heartrate monitor-bluetooth call-blood pressure (black)</h5>
                                                        <h5 class="card-title">R799</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Genius F2 Activity Smart Watch R579.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Genius F2 Activity Smart Watch</h5>
                                                        <h5 class="card-title">R579</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/HUAWEI WATCH GT 2e Black R2899.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">HUAWEI WATCH GT 2e Black</h5>
                                                        <h5 class="card-title">R2899</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Series 7 Smart Watch Black R549.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Series 7 Smart Watch Black</h5>
                                                        <h5 class="card-title">R549</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/SM-R500NZKABTU_samsung_watch_01.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">SM-R500NZKABTU Samsung Watch</h5>
                                                        <h5 class="card-title">R2990</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Tempo Pulse 2.0 Black Fitness Watch R999.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Tempo Pulse 2.0 Black Fitness Watch</h5>
                                                        <h5 class="card-title">R999</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                    <img src="../media/assets/smartwatches/Xiaomi - Mi Smart Band 4 Android & iOS Fitness Watch - Black R189.png" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fs-4">Xiaomi - Mi Smart Band 4 Android & iOS Fitness Watch - Black</h5>
                                                        <h5 class="card-title">R189</h5>
                                                        <p class="card-text">Watch Description.</p>
                                                        <hr>
                                                        <p class="card-text">Watch Features</p>
                                                        <ol class="list-group list-group-numbered">
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                            <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                        </ol>
                                                    </div>
                                                    <div class="card-footer d-grid">
                                                        <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./ Smart watch Card Grid -->
                                    </div>
                                    <div class="tab-pane fade show w3-animate-right" id="v-pills-social-store-weights-bumbells" role="tabpanel" aria-labelledby="v-pills-social-store-weights-bumbells-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Weights &amp; Dumbells</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show w3-animate-right" id="v-pills-social-store-equipment-exercisemachines" role="tabpanel" aria-labelledby="v-pills-social-store-equipment-exercisemachines-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Exercise Machines</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show w3-animate-right" id="v-pills-social-store-fitness-accessories" role="tabpanel" aria-labelledby="v-pills-social-store-fitness-accessories-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Fitness Accessories</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show w3-animate-right" id="v-pills-social-store-apparel" role="tabpanel" aria-labelledby="v-pills-social-store-apparel-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Apparel</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show w3-animate-right" id="v-pills-social-store-nutrition-supplements" role="tabpanel" aria-labelledby="v-pills-social-store-nutrition-supplements-tab">
                                        <h5 class="fs-1 fw-bold text-center rounded-pill p-4 shadow">Nutrition &amp; Supplements</h5>
                                        <hr>
                                        <div class="text-center my-4" style="padding: 100px 10px;">
                                            <small class="text-muted">No items to display. Check back soon.</small>
                                        </div>
                                        <!-- Meds and Supplements Card Grid -->
                                        <h5 class="fs-1 fw-bold"><span class="material-icons material-icons-round"> medication </span> Supplements and Vitamins</h5>
                                        <div class="card-group">
                                            <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                                                <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title fs-4">Supplement 1</h5>
                                                    <h5 class="card-title">Supplement Price</h5>
                                                    <p class="card-text">Supplement Description.</p>
                                                    <hr>
                                                    <p class="card-text">Supplement Features</p>
                                                    <ol class="list-group list-group-numbered">
                                                        <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                                        <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                                        <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                                        <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                                        <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                                    </ol>
                                                </div>
                                                <div class="card-footer d-grid">
                                                    <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                                        Add to Cart
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Meds and Supplements Card Grid -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./ Store Items Container -->

                    <!-- Membership Sales Card Grid -->
                    <h5 class="fs-1 fw-bold text-center my-4"><span class="material-icons material-icons-round"> verified_user </span> Membership </h5>
                    <div class="card-groupz grid-container">
                        <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Community Fitness - Free</h5>
                                <p class="card-text">The Community Fitness account offers Trainees with access to the Onefit Community Content and Group Training Programs.
                                    Sign up today to get access to over 100 curated fitness prograns and tailored suggestions, including fitness and wellness tracking features.</p>

                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Fitness Programs and Resources</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Live Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Group-Training Community Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                </ol>
                            </div>
                            <div class="card-footer d-grid">
                                <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                    Free
                                </button>
                            </div>
                        </div>
                        <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Indi.Starter Training (Basic) - 3 Months</h5>
                                <p class="card-text">The Indi.Starter account offers Trainees access to Curated Premium Fitness Programs from Level-1 to Level-3 of our
                                    Catalogue as well as access to Personal Trainer Support services to make transitioning into Fitness Process much easier.</p>

                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 bg-transparent text-white">Access to all Community and Level-1 to Level-2 Fitness Programs</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Access to Community Live Streams and Private 1-</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Premium 1-ON-1 Personal Trainer Support</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                </ol>
                            </div>
                            <div class="card-footer d-grid">
                                <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                    R1800 (3 Months)
                                </button>
                            </div>
                        </div>
                        <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Indi.Pro Training (Pro) - 12 Months</h5>
                                <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>

                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Fitness Programs</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Live Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Group-Training Community Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Weekly</li>
                                </ol>
                            </div>
                            <div class="card-footer d-grid">
                                <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                    R5200 (12 Months)
                                </button>
                            </div>
                        </div>
                        <div class="card grid-tile shadow" style="background-color: #343434 !important; overflow: hidden;">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Team.Pro Training (Pro) - Contact Sales</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                                    content.
                                    This card has even longer content than the first to show that equal height action.</p>

                                <ol class="list-group list-group-numbered">
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Fitness Programs</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Community Live Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Group-Training Community Streams</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Diet-Bar Recommendations</li>
                                    <li class="list-group-item border-0 bg-transparent text-white">Onefoodie Meal-Kit Subscriptions</li>
                                </ol>
                            </div>
                            <div class="card-footer d-grid">
                                <button class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                    Contact Sales
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Membership Sales Card Grid -->
                </div>
                <!-- removed Onefit.Social Tab -->
                <div id="TabData" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h1 class="text-center comfortaa-font">
                            <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">
                                insights
                            </span>
                            <span class="align-middle">Fitness Insights</span>
                        </h1>
                        <p class="text-center my-4 comfortaa-font">Use the Fitness Insights page to track your fitness progression and workout activities.</p>
                    </div>

                    <hr class="text-white" style="height: 5px;">

                    <!-- Timelines and Calender -->
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <span class="material-icons material-icons-round">calendar_month</span>
                        <h5 class="my-4 fs-1 text-center">Fitness Calender</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <!-- Activity Calender -->
                    <div id="activities-calender"></div>
                    <!-- ./ Activity Calender -->

                    <!-- Vertical Activity Timeline of user -->

                    <div id="v-timeline" class="w-100 my-4 py-4 shadow border-5 border-bottom" style="background-color: #343434; border-radius: 25px; border-color: #ffa500 !important; overflow-x: auto;">
                        <div class="d-grid text-center">
                            <h5 class="my-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">
                                    view_timeline
                                </span> Activity Timeline
                            </h5>
                        </div>

                        <hr style="color: #ffa500;">

                        <div id="vertical-timeline-varusername no-scroller" style="max-height: 90vh; overflow: auto; border-radius: 25px;">
                            <div class="timeline" style="min-width: 500px; border-radius: 25px;">
                                <div class="timeline-container left">
                                    <div class="date comfortaa-font">15 Dec 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>

                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p class="mb-4">
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-container right">
                                    <div class="date comfortaa-font">22 Oct 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>
                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-container left">
                                    <div class="date comfortaa-font">10 Jul 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>
                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-container right">
                                    <div class="date comfortaa-font">18 May 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>
                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-container left">
                                    <div class="date comfortaa-font">10 Feb 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>
                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline-container right">
                                    <div class="date comfortaa-font">01 Jan 2022</div>
                                    <span class="icon">
                                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                                            task_alt
                                        </span>
                                    </span>
                                    <div class="content">
                                        <h2 class="comfortaa-font">Lorem ipsum dolor sit amet</h2>
                                        <p>
                                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                                            semper pretium.
                                        </p>
                                        <p class="mt-4" style="color: #ffa500;" style="font-size: 20px !important;">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                                schedule
                                            </span>
                                            <span class="align-middle">10h00</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./ Vertical Activity Timeline of user -->

                    <!-- ./ Timeline and Calender -->

                    <hr class="text-white" style="height: 5px;">

                    <!-- User Smart Device Activity Tracking -->
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <span class="material-icons material-icons-round">track_changes</span>
                        <h5 class="mt-4 fs-1 text-center">Activity Tracking</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <div class="container-fluid p-4 shadow-lg d-inline-block border-5 border-start border-end" style="border-radius: 25px; border-color: #ffa500 !important; background-color: #343434">
                        <div class="row align-items-center text-center comfortaa-font">
                            <div class="col-sm py-2 text-truncate">
                                <!--<i class="fas fa-heart"></i>-->
                                <div class="d-inline">
                                    <span class="material-icons material-icons-round align-middle"> monitor_heart </span>
                                    <span class="align-middle">Heart rate</span>
                                </div>

                            </div>
                            <div class="col-sm py-2 text-truncate">
                                <div class="d-inline">
                                    <span class="align-middle" style="color: #ffa500">|</span>
                                </div>
                            </div>
                            <div class="col-sm py-2 text-truncate">
                                <!--<i class="fas fa-thermometer-half"></i>-->
                                <div class="d-inline">
                                    <span class="material-icons material-icons-round align-middle"> device_thermostat </span>
                                    <!-- Degree symbol html code: &#8451; -->
                                    <span class="align-middle">Temp &#8451;</span>
                                </div>
                            </div>
                            <div class="col-sm py-2 text-center">
                                <div class="d-inline">
                                    <button class="btn p-4 onefit-buttons-style-dark my-pulse-animation-tahiti border-5 border" style="border-radius: 25px !important; border-color: #ffa500 !important;" type="button" data-bs-toggle="modal" data-bs-target="#tabCaptureActivityTrackerDataModal">
                                        <!--  data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="heartrate-expand-icon heartrate-data-input-form-container" -->
                                        <img src="../media/assets/icons/icons8-smart-watch-50.png" alt="smartwatch" class="img-fluid mb-2" />
                                        <span class="material-icons material-icons-round">fitbit</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm py-2 text-truncate">
                                <!--<i class="fas fa-bolt"></i>-->
                                <div class="d-inline">
                                    <span class="material-icons material-icons-round align-middle"> bolt </span>
                                    <span class="align-middle">Speed</span>
                                </div>
                            </div>
                            <div class="col-sm py-2 text-truncate">
                                <div class="d-inline">
                                    <span class="align-middle" style="color: #ffa500">|</span>
                                </div>
                            </div>
                            <div class="col-sm py-2 text-truncate">
                                <!--<i class="fas fa-walking"></i>-->
                                <div class="d-inline">
                                    <span class="material-icons material-icons-round align-middle"> directions_walk </span>
                                    <span class="align-middle">Steps</span>
                                </div>
                            </div>
                        </div>

                        <hr class="text-white">

                        <!-- detailed metric list -->
                        <ul class="list-group list-group-flush text-white border-0">
                            <li class="list-group-item bg-transparent text-white" style="border-color: #ffa500;border-radius: 25px;">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center">
                                        <h1 class="text-truncate">Heart Rate</h1>
                                        <div class="d-grid gap-2 mt-4">
                                            <span class="material-icons material-icons-round">
                                                favorite
                                            </span>
                                            <h1>65<span style="font-size: 10px;" class="align-top">BPM</span></h1>
                                            <p class="text-muted fw-bold">75 BPM, 5h ago</p>
                                        </div>

                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#heartrate-data-input-form-container" aria-expanded="false" aria-controls="heartrate-data-input-form-container">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button>

                                    </div>
                                    <div class="col-md -8 py-4 no-scroller" style="overflow-x: auto;">
                                        <div class=" d-flex justify-content-center">
                                            <div class="in-div-button-container">
                                                <!-- refresh button -->
                                                <button class="onefit-buttons-style-light p-4 d-grid text-center in-div-btn mx-4" style="top: 0px !important;right: 0px !important;" onclick="syncUserActivityTrackerChart(heartRateChart, '<?php echo $currentUser_Usrnm; ?>','heart_rate_monitor_chart')">
                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">update</span>
                                                    <span class="align-middle" style="font-size: 10px;">Update.</span>
                                                </button>
                                                <!-- ./ refresh button -->

                                                <!-- Canvasjs chart canvas -->
                                                <div class="insight-chart-container no-scroller">
                                                    <canvas class="chartjs-chart-light shadow" id="heart_rate_monitor_chart" width="400" height="400"></canvas>
                                                </div>
                                                <!-- ./Canvasjs chart canvas -->
                                            </div>
                                        </div>

                                        <!-- submit heartrate data form -->
                                        <div id="heartrate-data-input-form-container" class="collapse mt-4 p-4 mb-4 w3-animate-bottom border-5 border-top border-bottom" style="border-color: #ffa500 !important; border-radius: 25px;">
                                            <div id="heartrate-expand-icon" class="text-center w3-animate-bottom my-4">
                                                <span class="material-icons material-icons-round">
                                                    add_task
                                                </span>
                                            </div>

                                            <div class="align-middle comfortaa-font text-center">
                                                <span class="material-icons material-icons-round align-middle">today</span>

                                                <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                            </div>

                                            <hr class="text-white">

                                            <form id="single-heartrate-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_heartrate.php" autocomplete="off">
                                                <div class="output-container my-2" id="output-container">
                                                    <!--<?php echo $output; ?>-->
                                                </div>

                                                <div class="form-group my-4">
                                                    <label for="heartrate-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="heartrate-workout" id="heartrate-workout" placeholder="Work / Activity (Required)" required>
                                                        <option value='no-selection'>Select a workout / activity.</option>
                                                        <?php echo $workout_activities_list; ?>
                                                        <option value='other'>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="heartrate-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Heart Rate Datasource:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="heartrate-datasource" id="heartrate-datasource" placeholder="Datasource (Required)" required>
                                                        <option value='no-selection'>Select your datasource.</option>
                                                        <option value='datasource-1'>Fitbit waerable</option>
                                                        <option value='datasource-2'>Android wearable</option>
                                                        <option value='datasource-3'>Apple wearable</option>
                                                        <option value='datasource-4'>Treadmill</option>
                                                        <option value='datasource-5'>Electric Spin bike</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="heartrate-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your Heart Rate:</label>
                                                    <input class="form-control-text-input p-4" type="number" name="heartrate-value" id="heartrate-value" placeholder="BPM (Required)" required />
                                                </div>

                                                <!-- submit btn -->
                                                <input id="single-submit-heartrate-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                            </form>
                                            <div class="d-flex justify-content-center">
                                                <!-- visual submit btn - heartrate form -->
                                                <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-heartrate-btn" type="button" onclick="triggerSubmitActivityTrackerData('single','heartrate')">
                                                    <span class="material-icons material-icons-round align-middle">
                                                        add_circle_outline
                                                    </span>
                                                    <span class="align-middle">Save.</span>
                                                </button>
                                                <!-- ./ visual submit btn - heartrate form -->
                                            </div>


                                        </div>
                                        <!-- ./ submit heartrate data form -->

                                        <!-- <div id="heart_rate_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #ffa500;border-radius: 25px;">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center">
                                        <h1 class="text-truncate">Body Temp</h1>
                                        <div class="d-grid gap-2 mt-4">
                                            <span class="material-icons material-icons-round">
                                                device_thermostat
                                            </span>
                                            <h1>36.9<span style="font-size: 10px;" class="align-top">&deg;C</span></h1>
                                            <p class="text-muted fw-bold">37.2&deg;C, 10m ago</p>
                                        </div>

                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#bodytemp-data-input-form-container" aria-expanded="false" aria-controls="bodytemp-data-input-form-container">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button>

                                    </div>
                                    <div class="col-md -8 py-4 no-scroller" style="overflow-x: auto;">

                                        <div class=" d-flex justify-content-center">
                                            <div class="in-div-button-container">
                                                <!-- refresh button -->
                                                <button class="onefit-buttons-style-light p-4 d-grid text-center in-div-btn mx-4" style="top: 0px !important;right: 0px !important;" onclick="syncUserActivityTrackerChart(bodyTempChart, '<?php echo $currentUser_Usrnm; ?>','body_temp_monitor_chart')">
                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">update</span>
                                                    <span class="align-middle" style="font-size: 10px;">Update.</span>
                                                </button>
                                                <!-- ./ refresh button -->

                                                <!-- Canvasjs chart canvas -->
                                                <div class="insight-chart-container no-scroller">
                                                    <canvas class="chartjs-chart-light shadow" id="body_temp_monitor_chart" width="400" height="400"></canvas>
                                                </div>
                                                <!-- ./Canvasjs chart canvas -->
                                            </div>
                                        </div>

                                        <!-- submit heartrate data form -->
                                        <div id="bodytemp-data-input-form-container" class="collapse mt-4 p-4 mb-4 w3-animate-bottom border-5 border-top border-bottom" style="border-color: #ffa500 !important; border-radius: 25px;">
                                            <div id="bodytemp-expand-icon" class="text-center w3-animate-bottom my-4">
                                                <span class="material-icons material-icons-round">
                                                    add_task
                                                </span>
                                            </div>

                                            <div class="align-middle comfortaa-font text-center">
                                                <span class="material-icons material-icons-round align-middle">today</span>

                                                <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                            </div>

                                            <hr class="text-white">

                                            <form id="single-bodytemp-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bodytemp.php" autocomplete="off">
                                                <div class="output-container my-2" id="output-container">
                                                    <!--<?php echo $output; ?>-->
                                                </div>

                                                <div class="form-group my-4">
                                                    <label for="bodytemp-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="bodytemp-workout" id="bodytemp-workout" placeholder="Work / Activity (Required)" required>
                                                        <option value='no-selection'>Select a workout / activity.</option>
                                                        <?php echo $workout_activities_list; ?>
                                                        <option value='other'>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="bodytemp-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Heart Rate Datasource:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="bodytemp-datasource" id="bodytemp-datasource" placeholder="Datasource (Required)" required>
                                                        <option value='no-selection'>Select your datasource.</option>
                                                        <option value='datasource-1'>Fitbit waerable</option>
                                                        <option value='datasource-2'>Android wearable</option>
                                                        <option value='datasource-3'>Apple wearable</option>
                                                        <option value='datasource-4'>Treadmill</option>
                                                        <option value='datasource-5'>Electric Spin bike</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="bodytemp-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your current Body Temperature:</label>
                                                    <input class="form-control-text-input p-4" type="number" min="0" step="0.1" name="bodytemp-value" id="bodytemp-value" placeholder="Temperature (Required)" required />
                                                </div>

                                                <!-- submit btn -->
                                                <input id="single-submit-bodytemp-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                            </form>
                                            <div class="d-flex justify-content-center">
                                                <!-- visual submit btn - heartrate form -->
                                                <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-bodytemp-btn" type="button" onclick="triggerSubmitActivityTrackerData('single','bodytemp')">
                                                    <span class="material-icons material-icons-round align-middle">
                                                        add_circle_outline
                                                    </span>
                                                    <span class="align-middle">Save.</span>
                                                </button>
                                                <!-- ./ visual submit btn - heartrate form -->
                                            </div>

                                        </div>
                                        <!-- ./ submit heartrate data form -->

                                        <!-- <div id="body_temp_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #ffa500;border-radius: 25px;">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center">
                                        <h1 class="text-truncate">Avg. Speed</h1>
                                        <div class="d-grid gap-2 mt-4">
                                            <span class="material-icons material-icons-round">
                                                bolt
                                            </span>
                                            <h1>10<span style="font-size: 10px;" class="align-top">m/s</span></h1>
                                            <p class="text-muted fw-bold">Highest Marked Speed: 15m/s</p>
                                        </div>

                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#speedmonitor-data-input-form-container" aria-expanded="false" aria-controls="speedmonitor-data-input-form-container">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button>

                                    </div>
                                    <div class="col-md -8 py-4 no-scroller" style="overflow-x: auto;">

                                        <div class=" d-flex justify-content-center">
                                            <div class="in-div-button-container">
                                                <!-- refresh button -->
                                                <button class="onefit-buttons-style-light p-4 d-grid text-center in-div-btn mx-4" style="top: 0px !important;right: 0px !important;" onclick="syncUserActivityTrackerChart(speedChart, '<?php echo $currentUser_Usrnm; ?>','speed_monitor_chart')">
                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">update</span>
                                                    <span class="align-middle" style="font-size: 10px;">Update.</span>
                                                </button>
                                                <!-- ./ refresh button -->

                                                <!-- Canvasjs chart canvas -->
                                                <div class="insight-chart-container no-scroller">
                                                    <canvas class="chartjs-chart-light shadow" id="speed_monitor_chart" width="400" height="400"></canvas>
                                                </div>
                                                <!-- ./Canvasjs chart canvas -->
                                            </div>
                                        </div>

                                        <!-- submit speed data form -->
                                        <div id="speedmonitor-data-input-form-container" class="collapse mt-4 p-4 mb-4 w3-animate-bottom border-5 border-top border-bottom" style="border-color: #ffa500 !important; border-radius: 25px;">
                                            <div id="speedmonitor-expand-icon" class="text-center w3-animate-bottom my-4">
                                                <span class="material-icons material-icons-round">
                                                    add_task
                                                </span>
                                            </div>

                                            <div class="align-middle comfortaa-font text-center">
                                                <span class="material-icons material-icons-round align-middle">today</span>

                                                <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                            </div>

                                            <hr class="text-white">

                                            <form id="single-speed-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_speed.php" autocomplete="off">
                                                <div class="output-container my-2" id="output-container">
                                                    <!--<?php echo $output; ?>-->
                                                </div>

                                                <div class="form-group my-4">
                                                    <label for="speed-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="speed-workout" id="speed-workout" placeholder="Work / Activity (Required)" required>
                                                        <option value='no-selection'>Select a workout / activity.</option>
                                                        <?php echo $workout_activities_list; ?>
                                                        <option value='other'>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="speed-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Speed Datasource:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="speed-datasource" id="speed-datasource" placeholder="Datasource (Required)" required>
                                                        <option value='no-selection'>Select your datasource.</option>
                                                        <option value='datasource-1'>Fitbit waerable</option>
                                                        <option value='datasource-2'>Android wearable</option>
                                                        <option value='datasource-3'>Apple wearable</option>
                                                        <option value='datasource-4'>Treadmill</option>
                                                        <option value='datasource-5'>Electric Spin bike</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="speed-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your max Speed:</label>
                                                    <input class="form-control-text-input p-4" type="number" min="0" step="0.1" name="speed-value" id="speed-value" placeholder="Speed (ms - Required)" required />
                                                </div>

                                                <!-- submit btn -->
                                                <input id="single-submit-speed-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                            </form>
                                            <div class="d-flex justify-content-center">
                                                <!-- visual submit btn - heartrate form -->
                                                <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-speed-btn" type="button" onclick="triggerSubmitActivityTrackerData('single','speed')">
                                                    <span class="material-icons material-icons-round align-middle">
                                                        add_circle_outline
                                                    </span>
                                                    <span class="align-middle">Save.</span>
                                                </button>
                                                <!-- ./ visual submit btn - heartrate form -->
                                            </div>

                                        </div>
                                        <!-- ./ submit speed data form -->

                                        <!-- <div id="speed_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #ffa500;border-radius: 25px;">
                                <div class="row align-items-center">
                                    <div class="col-md -4 text-center">
                                        <h1 class="text-truncate">Step Count</h1>
                                        <div class="d-grid gap-2 my-4">
                                            <span class="material-icons material-icons-round">
                                                directions_walk
                                            </span>
                                            <h1>1896<span style="font-size: 10px;" class="align-top">Steps</span></h1>
                                            <p class="text-muted fw-bold">213 Steps remaining (Achievement)</p>
                                        </div>

                                        <img src="../media/assets/smartwatches/branding/fitbit-png-logo-white.png" class="img-fluid mt-4 mb-2" style="max-width: 200px;" alt="fitbit logo">
                                        <p class="comfortaa-font">Connect your Fitbit activity tracker / smartwatch</p>
                                    </div>
                                    <div class="col-md -8 py-4 d-flex justify-content-center no-scroller d-none" style="overflow-x: auto;">
                                        <div class="in-div-button-container">
                                            <!-- refresh button -->
                                            <button class="onefit-buttons-style-light p-4 d-grid text-center in-div-btn mx-4" style="top: 0px !important;right: 0px !important;" onclick="syncUserActivityTrackerChart(stepCountChart, '<?php echo $currentUser_Usrnm; ?>','step_counter_monitor_chart')">
                                                <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">update</span>
                                                <span class="align-middle" style="font-size: 10px;">Update.</span>
                                            </button>
                                            <!-- ./ refresh button -->

                                            <!-- Canvasjs chart canvas -->
                                            <canvas class="chartjs-chart-light shadow" id="step_counter_monitor_chart" width="400" height="400"></canvas>
                                            <!-- ./Canvasjs chart canvas -->
                                        </div>

                                        <!-- no input form for capturing data. Can only be captured through the fitbit web api -->
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item bg-transparent text-white" style="border-color: #ffa500;border-radius: 25px;">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center">
                                        <h1 class="text-truncate">Weight &amp; BMI</h1>
                                        <div class="d-grid gap-2 mt-4">
                                            <span class="material-icons material-icons-round">
                                                monitor_weight
                                            </span>
                                            <h1>60<span style="font-size: 10px;" class="align-top">kg</span></h1>
                                            <p class="text-muted fw-bold">75kg, 1w ago</p>
                                        </div>

                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#bmiweight-data-input-form-container" aria-expanded="false" aria-controls="">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button>

                                    </div>
                                    <div class="col-md -8 py-4 no-scroller" style="overflow-x: auto;">

                                        <div class="d-flex justify-content-center">
                                            <div class="in-div-button-container">
                                                <!-- refresh button -->
                                                <button class="onefit-buttons-style-light p-4 d-grid text-center in-div-btn mx-4" style="top: 0px !important;right: 0px !important;" onclick="syncUserActivityTrackerChart(bmiWeightChart, '<?php echo $currentUser_Usrnm; ?>','bmi_weight_monitor_chart')">
                                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">update</span>
                                                    <span class="align-middle" style="font-size: 10px;">Update.</span>
                                                </button>
                                                <!-- ./ refresh button -->

                                                <!-- Canvasjs chart canvas -->
                                                <div class="insight-chart-container no-scroller">
                                                    <canvas class="chartjs-chart-light shadow" id="bmi_weight_monitor_chart" width="400" height="400"></canvas>
                                                </div>
                                                <!-- ./Canvasjs chart canvas -->
                                            </div>
                                        </div>

                                        <!-- submit bmiweight data form -->
                                        <div id="bmiweight-data-input-form-container" class="collapse mt-4 p-4 mb-4 w3-animate-bottom border-5 border-top border-bottom" style="border-color: #ffa500 !important; border-radius: 25px;">

                                            <div id="bmiweight-expand-icon" class="text-center w3-animate-bottom my-4">
                                                <span class="material-icons material-icons-round">
                                                    add_task
                                                </span>
                                            </div>

                                            <div class="align-middle comfortaa-font text-center">
                                                <span class="material-icons material-icons-round align-middle">today</span>

                                                <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                            </div>

                                            <hr class="text-white">

                                            <form id="single-weight-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bmiweight.php" autocomplete="off">
                                                <div class="output-container my-2" id="output-container">
                                                    <!--<?php echo $output; ?>-->
                                                </div>

                                                <div class="form-group my-4">
                                                    <label for="heartrate-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="heartrate-workout" id="heartrate-workout" placeholder="Work / Activity (Required)" required>
                                                        <option value='no-selection'>Select a workout / activity.</option>
                                                        <?php echo $workout_activities_list; ?>
                                                        <option value='other'>Other</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="heartrate-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Weight Monitoring Datasource:</label>
                                                    <select class="custom-select form-control-select-input p-4" name="heartrate-datasource" id="heartrate-datasource" placeholder="Datasource (Required)" required>
                                                        <option value='no-selection'>Select your datasource.</option>
                                                        <option value='datasource-1'>Fitbit waerable</option>
                                                        <option value='datasource-2'>Android wearable</option>
                                                        <option value='datasource-3'>Apple wearable</option>
                                                        <option value='datasource-4'>Treadmill</option>
                                                        <option value='datasource-5'>Electric Spin bike</option>
                                                    </select>
                                                </div>
                                                <div class="form-group my-4">
                                                    <label for="weight-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your current Weight:</label>
                                                    <input class="form-control-text-input p-4" type="number" min="0" step="0.1" name="weight-value" id="weight-value" placeholder="Weight (kg - Required)" required />
                                                </div>

                                                <!-- submit btn -->
                                                <input id="single-submit-weight-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                            </form>
                                            <div class="d-flex justify-content-center">
                                                <!-- visual submit btn - heartrate form -->
                                                <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-weight-btn" type="button" onclick="triggerSubmitActivityTrackerData('single','weight')">
                                                    <span class="material-icons material-icons-round align-middle">
                                                        add_circle_outline
                                                    </span>
                                                    <span class="align-middle">Save.</span>
                                                </button>
                                                <!-- ./ visual submit btn - heartrate form -->
                                            </div>

                                        </div>
                                        <!-- ./ submit bmiweight data form -->

                                        <!-- <div id="weight_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!-- ./ detailed metric list -->
                    </div>
                    <!-- ./ User Smart Device Activity Tracking -->

                    <hr class="text-white" style="height: 5px;">

                    <!-- Weekly Activities -->
                    <div class="p-4 my-4 d-flex align-items-middle justify-content-between text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <button id="prev-week-btn-weekly-assessments" class="btn p-2 onefit-buttons-style-transp-leftdir comfortaa-font">
                            <span class="material-icons material-icons-round align-middle" style="color: #ffa500 !important">keyboard_arrow_left</span>
                            <span class="align-middle" style="font-size: 10px;">Last Week</span>
                        </button>
                        <div class="d-grid text-center">
                            <span class="material-icons material-icons-outlined"> pending_actions </span>
                            <h5 class="mt-4 fs-1 text-center">Weekly Assessments</h5>
                            <p class="fs-5 text-center comfortaa-font"> Training Week: (<span id="weekly-survey-duration-dates">Start Date - End Date</span>)</p>
                            <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                            <span class="align-middle" style="font-size: 10px;">This Week</span>
                        </div>
                        <button id="prev-week-btn-weekly-assessments" class="btn p-2 onefit-buttons-style-transp-rightdir comfortaa-font">
                            <span class="align-middle" style="font-size: 10px;">Next Week</span>
                            <span class="material-icons material-icons-round align-middle" style="color: #ffa500 !important">keyboard_arrow_right</span>
                        </button>
                    </div>

                    <!-- weekly assessment horizontal scroll container -->
                    <div id="weekly-assessment-horizontal-scroll-container" class="horizontal-scroll shadow align-items-start">
                        <div id="weekly-assessment-h-scroll-weekday-card-varsunday" class="horizontal-scroll-card p-4 m-1 shadow text-center">
                            <h3 class="my-4">Sunday (dd/mm/yyyy)</h3>

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Assessments</h5>

                            <!-- assessments list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ assessments list -->

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Indi-fitness activities</h5>

                            <!-- indi-athletics activities list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                                        <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                                        <span class="material-icons material-icons-round">self_improvement</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ indi-athletics activities list -->

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Group activities (Teams)</h5>

                            <!-- team-athletics / group activities list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                                        <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                                        <span class="material-icons material-icons-round">diversity_3</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ team-athletics / group activities list -->

                            <span class="material-icons material-icons-round mb-4">horizontal_rule</span>
                        </div>
                        <div id="weekly-assessment-h-scroll-weekday-card-varmonday" class="horizontal-scroll-card p-4 m-1 shadow text-center">
                            <h3 class="my-4">Monday (dd/mm/yyyy)</h3>

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Assessments</h5>

                            <!-- assessments list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ assessments list -->

                            <!-- <hr class="text-white" style="height: 5px;">
                            <h5 class="">Indi-fitness activities</h5> -->

                            <!-- indi-athletics activities list -->
                            <!-- <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!!-- <i class="fab fa-google" style="font-size: 30px!important"></i> --<>
                                        <!!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> --<>
                                        <span class="material-icons material-icons-round">self_improvement</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol> -->
                            <!-- ./ indi-athletics activities list -->

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Group activities (Teams)</h5>

                            <!-- team-athletics / group activities list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                                        <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                                        <span class="material-icons material-icons-round">diversity_3</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ team-athletics / group activities list -->

                            <span class="material-icons material-icons-round mb-4">horizontal_rule</span>
                        </div>
                        <div id="weekly-assessment-h-scroll-weekday-card-vartuesday" class="horizontal-scroll-card p-4 m-1 shadow text-center">
                            <h3 class="my-4">Tuesday (dd/mm/yyyy)</h3>

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Assessments</h5>

                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>

                            <!-- <hr class="text-white" style="height: 5px;">
                            <h5 class="">Indi-fitness activities</h5> -->

                            <!-- indi-athletics activities list -->
                            <!-- <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!!-- <i class="fab fa-google" style="font-size: 30px!important"></i> --<>
                                        <!!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> --<>
                                        <span class="material-icons material-icons-round">self_improvement</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol> -->
                            <!-- ./ indi-athletics activities list -->

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Group activities (Teams)</h5>

                            <!-- team-athletics / group activities list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                                        <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                                        <span class="material-icons material-icons-round">diversity_3</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ team-athletics / group activities list -->

                            <span class="material-icons material-icons-round mb-4">horizontal_rule</span>
                        </div>
                        <div id="weekly-assessment-h-scroll-weekday-card-varwednesday" class="horizontal-scroll-card p-4 m-1 shadow text-center">
                            <h3 class="my-4">Wednesday (dd/mm/yyyy)</h3>
                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Assessments</h5>

                            <!-- assessments list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ assessments list -->

                            <!-- <hr class="text-white" style="height: 5px;">
                            <h5 class="">Indi-fitness activities</h5> -->

                            <!-- indi-athletics activities list -->
                            <!-- <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!!-- <i class="fab fa-google" style="font-size: 30px!important"></i> --<>
                                        <!!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> --<>
                                        <span class="material-icons material-icons-round">self_improvement</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol> -->
                            <!-- ./ indi-athletics activities list -->

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Group activities (Teams)</h5>

                            <!-- team-athletics / group activities list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                                        <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                                        <span class="material-icons material-icons-round">diversity_3</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ team-athletics / group activities list -->

                            <span class="material-icons material-icons-round mb-4">horizontal_rule</span>
                        </div>
                        <div id="weekly-assessment-h-scroll-weekday-card-varthursday" class="horizontal-scroll-card p-4 m-1 shadow text-center">
                            <h3 class="my-4">Thursday (dd/mm/yyyy)</h3>

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Assessments</h5>

                            <!-- assessments list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ assessments list -->

                            <!-- <hr class="text-white" style="height: 5px;">
                            <h5 class="">Indi-fitness activities</h5> -->

                            <!-- indi-athletics activities list -->
                            <!-- <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!!-- <i class="fab fa-google" style="font-size: 30px!important"></i> --<>
                                        <!!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> --<>
                                        <span class="material-icons material-icons-round">self_improvement</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol> -->
                            <!-- ./ indi-athletics activities list -->

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Group activities (Teams)</h5>

                            <!-- team-athletics / group activities list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                                        <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                                        <span class="material-icons material-icons-round">diversity_3</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ team-athletics / group activities list -->

                            <span class="material-icons material-icons-round mb-4">horizontal_rule</span>
                        </div>
                        <div id="weekly-assessment-h-scroll-weekday-card-varfriday" class="horizontal-scroll-card p-4 m-1 shadow text-center">
                            <h3 class="my-4">Friday (dd/mm/yyyy)</h3>

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Assessments</h5>

                            <!-- assessments list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ assessments list -->

                            <!-- <hr class="text-white" style="height: 5px;">
                            <h5 class="">Indi-fitness activities</h5> -->

                            <!-- indi-athletics activities list -->
                            <!-- <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!!-- <i class="fab fa-google" style="font-size: 30px!important"></i> --<>
                                        <!!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> --<>
                                        <span class="material-icons material-icons-round">self_improvement</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol> -->
                            <!-- ./ indi-athletics activities list -->

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Group activities (Teams)</h5>

                            <!-- team-athletics / group activities list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                                        <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                                        <span class="material-icons material-icons-round">diversity_3</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ team-athletics / group activities list -->

                            <span class="material-icons material-icons-round mb-4">horizontal_rule</span>
                        </div>
                        <div id="weekly-assessment-h-scroll-weekday-card-varsaturday" class="horizontal-scroll-card p-4 m-1 shadow text-center">
                            <h3 class="my-4">Saturday (dd/mm/yyyy)</h3>

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Assessments</h5>

                            <!-- assessments list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <i class="fab fa-google" style="font-size: 30px!important"></i>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Optional
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                        <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                            pending_actions </span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                                        Frequency: Daily<br />
                                        Mendatory: Yes
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ assessments list -->

                            <!-- <hr class="text-white" style="height: 5px;">
                            <h5 class="">Indi-fitness activities</h5> -->

                            <!-- indi-athletics activities list -->
                            <!-- <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!!-- <i class="fab fa-google" style="font-size: 30px!important"></i> --<>
                                        <!!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> --<>
                                        <span class="material-icons material-icons-round">self_improvement</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol> -->
                            <!-- ./ indi-athletics activities list -->

                            <hr class="text-white" style="height: 5px;">
                            <h5 class="">Group activities (Teams)</h5>

                            <!-- team-athletics / group activities list -->
                            <ol class="list-group list-group-flush border-0 my-4">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                        <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                                        <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                                        <span class="material-icons material-icons-round">diversity_3</span>
                                    </span>
                                    <div class="ms-2 me-auto">
                                        <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                                    </div>
                                </li>
                            </ol>
                            <!-- ./ team-athletics / group activities list -->

                            <span class="material-icons material-icons-round mb-4">horizontal_rule</span>
                        </div>
                    </div>
                    <!-- ./ weekly assessment horizontal scroll container -->
                    <!-- ./ Weekly Activities -->

                    <hr class="text-white" style="height: 5px;">

                    <!-- Training -->
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <span class="material-icons material-icons-outlined">sports</span>
                        <h5 class="mt-4 fs-1 text-center align-middle">Training.</h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <!-- Features: Tab structured -->
                    <div class="row mt-4 py-4 content-panel-border-style" style="background-color: #333; border-radius: 25px;">
                        <!-- insight catgories tab panels -->
                        <div class="col -md-9 my-4">
                            <p class="text-center m-0"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">horizontal_rule</span></p>
                            <!-- <div class="text-center">
                                <img src="../media/assets/One-Symbol-Logo-Dark-Mix.png" class="img-fluid" style="max-height: 100px;" alt="onefit darkmx logo">
                            </div> -->

                            <!-- display User XP -->
                            <div class="d-grid justify-content-center">
                                <p class="comfortaa-font mb-0 text-center" style="font-size: 10px;">Fitness Progression</p>
                                <div class="text-center px-4 py-0 d-inline comfortaa-font" id="userXPDisplay">
                                    <span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">data_exploration</span>
                                    <span class="align-middle fs-2">112</span><sup class="align-bottom" style="color: #ffa500;">xp</sup>
                                </div>
                            </div>
                            <!-- ./ display User XP -->

                            <p class="text-center m-0"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500;">horizontal_rule</span></p>

                            <!-- more insights categories v-buttons -->
                            <style>
                                .force-inline-nav {
                                    flex-wrap: nowrap !important;
                                }
                            </style>

                            <!-- inline/flex more insights tab controller btns -->
                            <div id="inline-more-insights-tab-btns" class="d-grid align-items-centerz d-lg-none d-xl-none d-xxl-none w3-animate-bottom p-2" style="background: #333; border-radius: 25px; overflow: hidden;">
                                <div class="d-grid gap-2 p-4">
                                    <button class="onefit-buttons-style-dark p-4" type="button" data-bs-toggle="collapse" data-bs-target="#insights-subfeatures-nav-menu" aria-expanded="true" aria-controls="insights-subfeatures-nav-menu">
                                        <div class="d-grid gap-2">
                                            <span class="material-icons material-icons-round"> menu </span>
                                            <p class="m-0" style="font-size: 8px;">More insights</p>
                                        </div>
                                    </button>
                                </div>

                                <div class="w3-animate-bottom my-4 horizontal-scroll no-scroller p-4 collapse" style="overflow-y: hidden;" id="insights-subfeatures-nav-menu">
                                    <nav class="m-0">
                                        <div class="nav force-inline-nav nav-tabs border-0" id="nav-tab-insightsSubFeatureCategories" role="tablist" style="border-color: #ffa500 !important">
                                            <button class="nav-link p-4 comfortaa-font fw-bold active position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-challenges-tab" onclick="clickTrainingProgramCategories('challenges')">
                                                Challenges.
                                                <span class="position-absolute top-50 start-0 translate-middle badge rounded-pill border-2 border p-1  my-pulse-animation-tahiti" style="height: 20px; width: 20px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;">
                                                </span>

                                                <br>
                                                <span id="md-horizontal-rule-icon-challenges" class="material-icons material-icons-outlined align-middle" style="display: block;">stars</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-googleSurveys-tab" onclick="clickTrainingProgramCategories('googleSurveys')">
                                                Google Surveys.

                                                <br>
                                                <span id="md-horizontal-rule-icon-googlesurveys" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">poll</span>
                                            </button>

                                            <!-- <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-indiAthlete-tab" onclick="clickTrainingProgramCategories('indiAthlete')">
                                                Indi-Athletics.

                                                <br>
                                                <span id="md-horizontal-rule-icon-indiathlete" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">sports_gymnastics</span>
                                            </button> -->

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-teamAthletics-tab" onclick="clickTrainingProgramCategories('teamAthletics')">
                                                Team Athletics.

                                                <br>
                                                <span id="md-horizontal-rule-icon-teamathletics" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">diversity_2</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-wellness-tab" onclick="clickTrainingProgramCategories('wellness')">
                                                Wellness.

                                                <br>
                                                <span id="md-horizontal-rule-icon-wellness" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">self_improvement</span>
                                            </button>

                                            <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;" id="nav-trainingProgramCategories-nutrition-tab" onclick="clickTrainingProgramCategories('nutrition')">
                                                Nutrition.

                                                <br>
                                                <span id="md-horizontal-rule-icon-nutrition" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">restaurant</span>
                                            </button>

                                        </div>
                                    </nav>

                                    <!-- Fitness/Training programe categories - hidden display: none -->
                                    <div class="nav d-grid nav-pills d-none" id="v-sub-tab-pills-insights-subfeatures-tab" role="tablist" aria-orientation="vertical" aria-hidden="true">
                                        <button class="nav-link" id="v-sub-tab-pills-insights-challenges-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-challenges" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-challenges" aria-selected="false">
                                            <!--onclick="openLink(event, 'InsightsTabChallenges')"-->
                                            <span class="material-icons material-icons-rounded">stars</span>
                                            <p class="text-break comfortaa-font">Challenges</p>
                                        </button>
                                        <button class="nav-link active" id="v-sub-tab-pills-insights-googlesurveys-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-googlesurveys" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-googlesurveys" aria-selected="true">
                                            <!--onclick="openLink(event, 'InsightsTabGCS')"-->
                                            <span class="material-icons material-icons-rounded">poll</span>
                                            <p class="text-break comfortaa-font">Google Community Surveys</p>
                                        </button>
                                        <button class="nav-link" id="v-sub-tab-pills-insights-indiathlete-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-indiathlete" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-indiathlete" aria-selected="false">
                                            <!--onclick="openLink(event, 'InsightsTabIAT')"-->
                                            <span class="material-icons material-icons-rounded">sports_gymnastics</span>
                                            <p class="text-break comfortaa-font">Indi-Athletics</p>
                                        </button>
                                        <button class="nav-link" id="v-sub-tab-pills-insights-teamathletics-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-teamathletics" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-teamathletics" aria-selected="false">
                                            <!--onclick="openLink(event, 'InsightsTabCTA')"-->
                                            <span class="material-icons material-icons-rounded">diversity_2</span>
                                            <p class="text-break comfortaa-font">Community/Team Athletics</p>
                                        </button>
                                        <button class="nav-link" id="v-sub-tab-pills-insights-wellness-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-wellness" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-wellness" aria-selected="false">
                                            <!--onclick="openLink(event, 'InsightsTabWellness')"-->
                                            <span class="material-icons material-icons-rounded">self_improvement</span>
                                            <p class="text-break comfortaa-font">Wellness</p>
                                        </button>
                                        <button class="nav-link" id="v-sub-tab-pills-insights-nutrition-tab" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-insights-nutrition" type="button" role="tab" aria-controls="v-sub-tab-pills-insights-nutrition" aria-selected="false">
                                            <!--onclick="openLink(event, 'InsightsTabNutrition')"-->
                                            <span class="material-icons material-icons-rounded">restaurant</span>
                                            <p class="text-break comfortaa-font">Nutrition</p>
                                        </button>
                                    </div>
                                    <!-- ./ Fitness/Training programe categories - hidden display: none -->
                                </div>
                                <hr class="text-center" />
                            </div>
                            <!-- ./ inline/flex more insights tab controller btns -->
                            <!-- ./ more insight categories v-buttons -->

                            <!-- hide on screens smaller than lg -->
                            <nav class="d-none d-lg-block mt-4">
                                <div class="nav nav-tabs justify-content-center" id="nav-tab-insightsSubFeatureCategories" role="tablist" style="border-color: #ffa500 !important">
                                    <button class="nav-link p-4 comfortaa-font fw-bold active position-relative" id="nav-trainingProgramCategories-challenges-tab" onclick="clickTrainingProgramCategories('challenges')">
                                        Challenges.
                                        <span class="position-absolute top-50 start-0 translate-middle badge rounded-pill border-2 border p-1  my-pulse-animation-tahiti" style="height: 20px; width: 20px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;">
                                        </span>

                                        <br>
                                        <span id="horizontal-rule-icon-challenges" class="material-icons material-icons-outlined align-middle" style="display: block;">stars</span>
                                    </button>

                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" id="nav-trainingProgramCategories-googleSurveys-tab" onclick="clickTrainingProgramCategories('googleSurveys')">
                                        Google Surveys.

                                        <br>
                                        <span id="horizontal-rule-icon-googlesurveys" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">poll</span>
                                    </button>

                                    <!-- removed selection button for indi-athletics sub-tab -->

                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" id="nav-trainingProgramCategories-teamAthletics-tab" onclick="clickTrainingProgramCategories('teamAthletics')">
                                        Team Athletics.

                                        <br>
                                        <span id="horizontal-rule-icon-teamathletics" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">diversity_2</span>
                                    </button>

                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" id="nav-trainingProgramCategories-wellness-tab" onclick="clickTrainingProgramCategories('wellness')">
                                        Wellness.

                                        <br>
                                        <span id="horizontal-rule-icon-wellness" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">self_improvement</span>
                                    </button>

                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" id="nav-trainingProgramCategories-nutrition-tab" onclick="clickTrainingProgramCategories('nutrition')">
                                        Nutrition.

                                        <br>
                                        <span id="horizontal-rule-icon-nutrition" class="material-icons material-icons-outlined align-middle" style="color: #ffa500; display: none;">restaurant</span>
                                    </button>

                                </div>
                            </nav>
                            <!-- ./ hide on screens smaller than lg -->

                            <script>
                                function clickTrainingProgramCategories(selcategory) {
                                    // declaring variable
                                    var challengesBtn = document.getElementById("v-sub-tab-pills-insights-challenges-tab");
                                    var teamAthleticsBtn = document.getElementById("v-sub-tab-pills-insights-teamathletics-tab");
                                    var indiAthleteBtn = document.getElementById("v-sub-tab-pills-insights-indiathlete-tab");
                                    var googleSurveyBtn = document.getElementById("v-sub-tab-pills-insights-googlesurveys-tab");
                                    var wellnessBtn = document.getElementById("v-sub-tab-pills-insights-wellness-tab");
                                    var nutritionBtn = document.getElementById("v-sub-tab-pills-insights-nutrition-tab");

                                    if (selcategory == "challenges") {
                                        challengesBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "block";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                                        // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";

                                        document.getElementById("md-horizontal-rule-icon-challenges").style.display = "block";
                                        document.getElementById("md-horizontal-rule-icon-googlesurveys").style.display = "none";
                                        // document.getElementById("md-horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-nutrition").style.display = "none";

                                    } else if (selcategory == "googleSurveys") {
                                        googleSurveyBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "block";
                                        // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";

                                        document.getElementById("md-horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-googlesurveys").style.display = "block";
                                        // document.getElementById("md-horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-nutrition").style.display = "none";

                                    } else if (selcategory == "indiAthlete") {
                                        indiAthleteBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                                        // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "block";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";

                                        document.getElementById("md-horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-googlesurveys").style.display = "block";
                                        // document.getElementById("md-horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-nutrition").style.display = "none";

                                    } else if (selcategory == "teamAthletics") {
                                        teamAthleticsBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                                        // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "block";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";

                                        document.getElementById("md-horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-googlesurveys").style.display = "none";
                                        // document.getElementById("md-horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-teamathletics").style.display = "block";
                                        document.getElementById("md-horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-nutrition").style.display = "none";

                                    } else if (selcategory == "wellness") {
                                        wellnessBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                                        // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "block";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";

                                        document.getElementById("md-horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-googlesurveys").style.display = "none";
                                        // document.getElementById("md-horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-wellness").style.display = "block";
                                        document.getElementById("md-horizontal-rule-icon-nutrition").style.display = "none";

                                    } else if (selcategory == "nutrition") {
                                        nutritionBtn.click();

                                        document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                                        // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("horizontal-rule-icon-nutrition").style.display = "block";

                                        document.getElementById("md-horizontal-rule-icon-challenges").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-googlesurveys").style.display = "none";
                                        // document.getElementById("md-horizontal-rule-icon-indiathlete").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-teamathletics").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-wellness").style.display = "none";
                                        document.getElementById("md-horizontal-rule-icon-nutrition").style.display = "block";

                                    }
                                }
                            </script>

                            <!-- Team Athlectics Training Panel -->
                            <div class="tab-content" id="v-pills-tabInsightsSubFeatures">
                                <!-- insights tab - sub-tabs -->
                                <!-- Challenges Tab -->
                                <div class="tab-pane fade show active w3-animate-bottom no-scroller py-4 px-2 gap-4" id="v-sub-tab-pills-insights-challenges" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-insights-challenges-tab">
                                    <div class="d-grid text-center mt-4 ">
                                        <span class="material-icons material-icons-round">stars</span>
                                        <h5 class="fs-1">Challenges</h5>
                                    </div>

                                    <hr class="text-white">

                                    <!-- fitness progression progress bar -->
                                    <div id="fitness-progression-progress-bar">
                                        <h5 class="mt-4">Fitness Progression</h5>
                                        <div class="progress mt-4" style="height: 4px;">
                                            <div class="progress-bar" role="progressbar" aria-label="Example 1px high" style="width: 25%; background-color: #ffa500 !important; border-right: #343434 10px solid;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="row mt-2" style="margin-bottom: 60px;">
                                            <div class="col text-start comfortaa-font" style="font-size: 12px;">
                                                Current XP <strong>(112)</strong>
                                            </div>
                                            <div class="col text-end comfortaa-font" style="font-size: 12px;">
                                                Target XP <strong>(150)</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ./ fitness progression progress bar -->

                                    <hr class="text-white">

                                    <h5 class="my-4">Daily Challenges</h5>

                                    <div id="daily-challenges-grid" class="grid-container mb-4">
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                    </div>

                                    <hr class="text-white">

                                    <h5 class="my-4">Weekly Challenges</h5>

                                    <div id="weekly-challenges-grid" class="grid-container mb-4">
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                    </div>

                                    <hr class="text-white">

                                    <h5 class="my-4">Monthly Monthly</h5>

                                    <div id="monthly-challenges-grid" class="grid-container mb-4">
                                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                                            <p>Challenge Title</p>
                                            <small>Workout / Exercise</small>
                                            <small>Category</small>
                                            <!-- progress bar -->
                                            <p>15 / 25 xp</p>
                                        </div>
                                    </div>

                                    <!-- Next Tab button - Proceed to Google Community Surveys -->
                                    <hr class="text-white">
                                    <div class="my-4 text-center" style="width: 100%">
                                        <div class="d-grid justify-content-endz" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabGCS')">
                                                <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_forward</span></p>
                                                <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">sports_gymnastics</span> -->
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Google Community Surveys</p>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- ./Next Tab button - Proceed to Google Community Surveys -->
                                </div>
                                <!-- ./ Challenges Tab -->
                                <!-- *************************************************** -->
                                <!-- Google Surveys Tab -->
                                <div class="tab-pane fade w3-animate-bottom no-scroller py-4 px-2" id="v-sub-tab-pills-insights-googlesurveys" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-insights-googlesurveys-tab">
                                    <div class="d-grid text-center mt-4">
                                        <span class="material-icons material-icons-round">poll</span>
                                        <h5 class="fs-1">Google Community Surveys</h5>
                                    </div>

                                    <hr class="text-white">

                                    <!-- Community Surveys -->
                                    <div>
                                        <!-- User Wellness Tracking Log -->
                                        <div class="fs-5 fw-bold text-center mb-4 rounded-pill p-4 mb-4 d-grid comfortaa-font">
                                            <i class="fab fa-google mb-2" style="font-size: 40px!important" aria-hidden="true"></i>
                                            <small>Community Fitness Analysis using</small>
                                            <span class="align-center">Google Data Studio</span>
                                        </div>

                                        <hr class="text-white">

                                        <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                                            <h5 class="fs-1 text-center my-4">Wellness Tracking</h5>
                                        </div>

                                        <p class="fs-3 mt-4">Community Wellness Rating: 90%</p>
                                        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSc0sL0-Gm6J-Hy03z_F872L5nQAdigfbZArNYBhBGbB-iOqmg/viewform?embedded=true" height="3016" frameborder="0" marginheight="0" marginwidth="0" class="w-100 no-scroller darkpads-bg-container-inverse" style="max-height: 100vh!important; border-radius: 25px;">Loading…</iframe>
                                        <div class="row my-4">
                                            <div class="col-md-4">
                                                <h5>Survey log</h5>
                                            </div>
                                            <div class="col-md">
                                                <p>Survey Charts / Results</p>
                                            </div>
                                        </div>
                                        <!-- ./ User Wellness Tracking Log -->

                                        <!-- User Load Monitoring Log -->
                                        <hr class="text-white" style="height: 5px;">

                                        <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                                            <h5 class="mt-4 fs-1 text-center mb-4">Load Monitoring</h5>
                                        </div>

                                        <p class="fs-3 mt-4">Community Load Rating: 90%</p>
                                        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeOJqnXT2LxRK9GK6DfmYObzkbu28D-qT_XzN-vUBsUyaOX0Q/viewform?embedded=true" height="1879" frameborder="0" marginheight="0" marginwidth="0" class="w-100 no-scroller darkpads-bg-container-inverse" style="max-height: 100vh!important; border-radius: 25px;">Loading…</iframe>
                                        <div class="row my-4">
                                            <div class="col-md-4">
                                                <h5>Survey log</h5>
                                            </div>
                                            <div class="col-md">
                                                <p>Survey Charts / Results</p>
                                            </div>
                                        </div>
                                        <!-- ./ User Load Monitoring Log -->
                                    </div>
                                    <!-- ./ Community Surveys -->

                                    <hr class="text-white">

                                    <div class="mb-4 text-center" style="width: 100%">
                                        <div class="row">
                                            <div class="col-md d-grid">
                                                <!-- Next Tab button - Return to Challenges -->
                                                <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabChallenges')">
                                                    <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_back</span></p>
                                                    <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Challenges</p>

                                                </button>
                                                <!-- ./Next Tab button - Return to Challenges -->
                                            </div>
                                            <div class="col-md d-grid">
                                                <!-- Next Tab button - Proceed to Team Athletics -->
                                                <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabCTA')">
                                                    <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_forward</span></p>
                                                    <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">stars</span> -->
                                                    <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Team Athletics</p>
                                                </button>
                                                <!-- ./Next Tab button - Proceed to Team Athletics -->
                                            </div>
                                        </div>
                                        <!-- <div class="d-flex justify-content-between" style="width: 100%"></div> -->
                                    </div>

                                </div>
                                <!-- ./ Google Surveys Tab -->
                                <!-- XXXXXX- removed indi-athletics tab here -XXXXXX -->
                                <!-- *************************************************** -->
                                <!-- Team Athletics Tab -->
                                <div class="tab-pane fade w3-animate-bottom no-scroller py-4 px-2" id="v-sub-tab-pills-insights-teamathletics" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-insights-teamathletics-tab">
                                    <div class="d-grid text-center mt-4">
                                        <span class="material-icons material-icons-round">diversity_2</span>
                                        <h5 class="fs-1">Team Athletics</h5>
                                    </div>

                                    <hr class="text-white">

                                    <!-- Team Athletics Training Panel -->
                                    <!-- <h1 class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti my-4">Team-Athletics Training</h1> -->

                                    <div class="mt-4" id="team-athletics-container">
                                        <!-- weekly training schedule and summaries -->
                                        <!-- upcoming match fixtures/schedule header -->
                                        <div class="row align-items-center">
                                            <div class="col-md-2 d-grid">
                                                <button class="onefit-buttons-style-dark p-4 my-2 text-center shadow" type="button">
                                                    <div class="d-grid">
                                                        <span class="material-icons material-icons-round">
                                                            psychology
                                                        </span>
                                                        <span class="align-middle poppins-font" style="font-size: 10px !important">
                                                            Formations &amp; Drills
                                                        </span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-md">
                                                <h5 class="fs-2 p-5 fw-bold rounded-pill text-center comfortaa-font shadow my-4 down-top-grad-whitez" style="border-radius:25px !important;">Upcoming Match Schedule</h5>
                                            </div>
                                            <div class="col-md-2 d-grid">
                                                <button class="onefit-buttons-style-dark p-4 my-2 text-center shadow " type="button">
                                                    <div class="d-grid">
                                                        <span class="material-icons material-icons-round">
                                                            add_circle
                                                        </span>
                                                        <span class="align-middle poppins-font" style="font-size: 10px !important">
                                                            Add to Fixture
                                                        </span>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- ./ upcoming match fixtures/schedule header -->

                                        <!-- match fixtures / schedule table -->
                                        <div class="table-responsive mb-4">
                                            <table class="table table-light table-striped my-4 shadow" style="border-radius: 25px !important; overflow: hidden;">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Match #</th>
                                                        <th scope="col">Match Title</th>
                                                        <th scope="col">Home Team</th>
                                                        <th scope="col">Away Team</th>
                                                        <th scope="col">Match Venue</th>
                                                        <th scope="col">Match Date</th>
                                                        <th scope="col">Start Time</th>
                                                        <th scope="col">Standard Match Duration (Minutes)</th>
                                                        <th scope="col">Observed Match Duration (Minutes)</th>
                                                        <th scope="col">Match Result</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="teams-upcoming-match-schedule-tbody">
                                                    <tr>
                                                        <td colspan="10" class="text-center fs-5 fw-bold">No fixtures available.</td>
                                                        <!-- <th scope="row">1</th>
                                                        <td>League Friendly - Team A (Home) vs Team B (Away)</td>
                                                        <td>Team A</td>
                                                        <td>Team B</td>
                                                        <td>Stadium 1</td>
                                                        <td>Saturday, 5 February 2022</td>
                                                        <td>13:00</td>
                                                        <td>90</td>
                                                        <td>94</td>
                                                        <td>Pending</td> -->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- ./ match fixtures / schedule table -->

                                        <hr class="text-white">

                                        <!-- weekly training schedule header -->
                                        <div class="row align-items-center">
                                            <div class="col-md-2 d-grid">
                                                <button class="onefit-buttons-style-dark p-4 my-2 text-center shadow" type="button">
                                                    <div class="d-grid">
                                                        <span class="material-icons material-icons-round">
                                                            chevron_left
                                                        </span>
                                                        <span class="align-middle poppins-font" style="font-size: 10px !important;">
                                                            Prev Week
                                                        </span>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="col-md">
                                                <p class="fs-2 p-4 fw-bold rounded-pill text-center comfortaa-font shadow my-4 down-top-grad-tahitiz" style="border-radius: 25px !important;">Weekly Training Schedule</p>
                                            </div>
                                            <div class="col-md-2 d-grid">
                                                <button class="onefit-buttons-style-dark p-4 my-2 text-center shadow" type="button">
                                                    <div class="d-grid">
                                                        <span class="material-icons material-icons-round">
                                                            chevron_right
                                                        </span>
                                                        <span class="align-middle poppins-font" style="font-size: 10px!important;">
                                                            Next Week
                                                        </span>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- ./ weekly training schedule header -->

                                        <!-- exmpl placeholder: <img src="../media/assets/example.png" alt="training week for ..." class="img-fluid mb-4" hidden> -->
                                        <!-- Training schedule intensity column graph (to show lists of activities that are planned to be performed for each weekday) -->
                                        <div class="training-schedule-container p-4 text-center down-top-grad-white comfortaa-font">
                                            <h5 class="mb-4" id="teams-weekly-training-schedule-title">
                                                <span class="material-icons material-icons-round align-middle">note_alt</span>
                                                <span id="week-schedule-note" class="align-middle"> Training week for those who played 45+ minutes in previous match. </span>
                                            </h5>

                                            <div class="row mb-4">
                                                <div class="col-md d-grid">
                                                    <button class="onefit-buttons-style-light p-4 my-2 text-center shadow" type="button" onclick="$.populateWeeklyActivityBarChart()">
                                                        <span class="material-icons material-icons-round">
                                                            refresh
                                                        </span>
                                                        <p class="d-nonez d-lg-blockz comfortaa-font" style="font-size: 10px;">Refresh.</p>
                                                    </button>
                                                </div>
                                                <div class="col-md d-grid">
                                                    <button class="onefit-buttons-style-light p-4 my-2 text-center shadow" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="add-weekly-activity-btn remove-weekly-activity-btn">
                                                        <span class="material-icons material-icons-round">
                                                            edit_calendar
                                                        </span>
                                                        <p class="d-nonez d-lg-blockz comfortaa-font" style="font-size: 10px;">Edit Weekly Schedule</p>
                                                    </button>
                                                </div>
                                                <div class="col-md d-grid">
                                                    <button class="onefit-buttons-style-light p-4 my-2 text-center shadow" type="button">
                                                        <span class="material-icons material-icons-round">
                                                            support_agent </span>
                                                        <p class="d-nonez d-lg-blockz comfortaa-font" style="font-size: 10px;">Trainer.</p>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- <div class="my-4 d-flex justify-content-between align-items-center">
                                                <button class="onefit-buttons-style-light p-4 my-2 text-center" type="button" onclick="$.populateWeeklyActivityBarChart()">
                                                    <span class="material-icons material-icons-round">
                                                        refresh
                                                    </span>
                                                    <p class="d-none d-lg-block comfortaa-font" style="font-size: 10px;">Refresh.</p>
                                                </button>

                                                <button class="onefit-buttons-style-light p-4 my-2 text-center" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="add-weekly-activity-btn remove-weekly-activity-btn">
                                                    <span class="material-icons material-icons-round">
                                                        edit_calendar
                                                    </span>
                                                    <p class="d-none d-lg-block comfortaa-font" style="font-size: 10px;">Edit Weekly Schedule</p>
                                                </button>

                                                <button class="onefit-buttons-style-light p-4 shadow" type="button">
                                                    <span class="material-icons material-icons-round">
                                                        support_agent </span>
                                                    <p class="d-none d-lg-block comfortaa-font" style="font-size: 10px;">Trainer.</p>
                                                </button>
                                            </div> -->

                                            <hr class="text-white" style="height: 5px;">

                                            <div class="row align-items-end text-dark" id="training-schedule-chart-grid">
                                                <div class="col" id="day-1-col">
                                                    <!-- Edit training day bar - Day 1 -->
                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar1">
                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                edit
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <!-- ./ Edit training day bar - Day 1 -->
                                                    <p id="bar-title-day1" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        ?
                                                    </p>

                                                    <p id="bar-rpe-day1" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        RPE ?
                                                    </p>
                                                    <div id="teams-weekly-activity-barchart-bar-day1" class="chart-col-bar p-2 shadow progress-bar progress-bar-stripedz bg-warningz">
                                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                                    </div>

                                                    <hr class="text-dark">

                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="$.editAddNewActivityModal('monday','group_ref_code_here')" data-bs-toggle="modal" data-bs-target="#tabeditWeeklyTeamsTrainingScheduleModal">
                                                            <span class="material-icons material-icons-round align-middle">
                                                                add_circle
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Monday</p>
                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Date</p>
                                                </div>

                                                <div class="col" id="day-2-col">
                                                    <!-- Edit training day bar - Day 2 -->
                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar2">
                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                edit
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <!-- ./ Edit training day bar - Day 2 -->
                                                    <p id="bar-title-day2" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        ?
                                                    </p>

                                                    <p id="bar-rpe-day2" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        RPE ?
                                                    </p>

                                                    <div id="teams-weekly-activity-barchart-bar-day2" class="chart-col-bar p-2 shadow">
                                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                                    </div>

                                                    <hr class="text-dark">

                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="$.editAddNewActivityModal('tuesday','group_ref_code_here')" data-bs-toggle="modal" data-bs-target="#tabeditWeeklyTeamsTrainingScheduleModal">
                                                            <span class="material-icons material-icons-round align-middle">
                                                                add_circle
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Tuesday</p>
                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Date</p>
                                                </div>

                                                <div class="col" id="day-3-col">
                                                    <!-- Edit training day bar - Day 3 -->
                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar3">
                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                edit
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <!-- ./ Edit training day bar - Day 3 -->
                                                    <p id="bar-title-day3" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        ?
                                                    </p>

                                                    <p id="bar-rpe-day3" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        RPE ?
                                                    </p>

                                                    <div id="teams-weekly-activity-barchart-bar-day3" class="chart-col-bar p-2 shadow">
                                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                                    </div>

                                                    <hr class="text-dark">

                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="$.editAddNewActivityModal('wednesday','group_ref_code_here')" data-bs-toggle="modal" data-bs-target="#tabeditWeeklyTeamsTrainingScheduleModal">
                                                            <span class="material-icons material-icons-round align-middle">
                                                                add_circle
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Wednesday</p>
                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Date</p>
                                                </div>

                                                <div class="col" id="day-4-col">
                                                    <!-- Edit training day bar - Day 4 -->
                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar4">
                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                edit
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <!-- ./ Edit training day bar - Day 4 -->
                                                    <p id="bar-title-day4" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        ?
                                                    </p>

                                                    <p id="bar-rpe-day4" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        RPE ?
                                                    </p>

                                                    <div id="teams-weekly-activity-barchart-bar-day4" class="chart-col-bar p-2 shadow">
                                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                                    </div>

                                                    <hr class="text-dark">

                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="$.editAddNewActivityModal('thursday','group_ref_code_here')" data-bs-toggle="modal" data-bs-target="#tabeditWeeklyTeamsTrainingScheduleModal">
                                                            <span class="material-icons material-icons-round align-middle">
                                                                add_circle
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Thursday</p>
                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Date</p>
                                                </div>

                                                <div class="col" id="day-5-col">
                                                    <!-- Edit training day bar - Day 5 -->
                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar5">
                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                edit
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <!-- ./ Edit training day bar - Day 5 -->
                                                    <p id="bar-title-day5" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        ?
                                                    </p>

                                                    <p id="bar-rpe-day5" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        RPE ?
                                                    </p>

                                                    <div id="teams-weekly-activity-barchart-bar-day5" class="chart-col-bar p-2 shadow">
                                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                                    </div>

                                                    <hr class="text-dark">

                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="$.editAddNewActivityModal('friday','group_ref_code_here')" data-bs-toggle="modal" data-bs-target="#tabeditWeeklyTeamsTrainingScheduleModal">
                                                            <span class="material-icons material-icons-round align-middle">
                                                                add_circle
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Friday</p>
                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Date</p>
                                                </div>

                                                <div class="col" id="day-6-col">
                                                    <!-- Edit training day bar - Day 6 -->
                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar6">
                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                edit
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <!-- ./ Edit training day bar - Day 6 -->
                                                    <p id="bar-title-day6" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        ?
                                                    </p>

                                                    <p id="bar-rpe-day6" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        RPE ?
                                                    </p>

                                                    <div id="teams-weekly-activity-barchart-bar-day6" class="chart-col-bar p-2 shadow">
                                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                                    </div>

                                                    <hr class="text-dark">

                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="$.editAddNewActivityModal('saturday','group_ref_code_here')" data-bs-toggle="modal" data-bs-target="#tabeditWeeklyTeamsTrainingScheduleModal">
                                                            <span class="material-icons material-icons-round align-middle">
                                                                add_circle
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Saturday</p>
                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Date</p>
                                                </div>

                                                <div class="col" id="day-7-col">
                                                    <!-- Edit training day bar - Day 7 -->
                                                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar7">
                                                        <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('monday','group_ref_code_here')">
                                                            <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                                                                edit
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <!-- ./ Edit training day bar - Day 7 -->
                                                    <p id="bar-title-day7" class="fs-3 fw-bold comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        ?
                                                    </p>

                                                    <p id="bar-rpe-day7" class="comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                                                        RPE ?
                                                    </p>

                                                    <div id="teams-weekly-activity-barchart-bar-day7" class="chart-col-bar p-2 shadow">
                                                        <hr class="text-white my-2 p-0" style="height: 5px;">
                                                    </div>

                                                    <hr class="text-dark">

                                                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                                                        <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="$.editAddNewActivityModal('sunday','group_ref_code_here')" data-bs-toggle="modal" data-bs-target="#tabeditWeeklyTeamsTrainingScheduleModal">
                                                            <span class="material-icons material-icons-round align-middle">
                                                                add_circle
                                                            </span>
                                                        </button>
                                                    </div>

                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Sunday</p>
                                                    <p class="text-center fs-5 fw-bold comfortaa-font">Date</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ./ Training schedule intensity column graph (to show lists of activities that are planned to be performed for each weekday) -->
                                        <!-- ./ weekly training schedule and summaries -->

                                        <hr class="text-white" />

                                        <!-- Section: Interaction buttons (incl: Drills, Physical Assessment, Nutrition board, Program Administration) -->
                                        <section id="interactions-section">
                                            <!-- class="fs-1 comfortaa-font my-5 text-center"  -->
                                            <h1 class="fs-2 p-5 fw-bold rounded-pill text-center comfortaa-font shadow my-4 down-top-grad-whitez" style="border-radius:25px !important;">
                                                <span class="material-icons material-icons-round align-middle">touch_app</span>
                                                <span class="align-middle comfortaa-font"> Interactions.</span>
                                            </h1>

                                            <div class="d-grid gap-2">
                                                <button id="interaction-btn-training-drills" class="onefit-buttons-style-light p-4 my-2 text-center shadow" type="button" data-bs-toggle="modal" data-bs-target="#trainingInteractionsContentModal" onclick="$.loadInteractionContent('TrainingDrillsWorkouts')">
                                                    <span class="material-icons material-icons-round align-middle">shuffle_on</span> <span class="align-middle poppins-font"> Training Drills &amp; Workouts</span>
                                                </button>
                                                <button id="interaction-btn-physical-assess" class="onefit-buttons-style-light p-4 my-2 text-center shadow" type="button" data-bs-toggle="modal" data-bs-target="#trainingInteractionsContentModal" onclick="$.loadInteractionContent('PhysicalAssessment')">
                                                    <span class="material-icons material-icons-round align-middle">personal_injury</span> <span class="align-middle poppins-font"> Physical Assessment</span>
                                                </button>
                                                <button id="interaction-btn-nutrition-board" class="onefit-buttons-style-light p-4 my-2 text-center shadow" type="button" data-bs-toggle="modal" data-bs-target="#trainingInteractionsContentModal" onclick="$.loadInteractionContent('NutritionBoard')">
                                                    <span class="material-icons material-icons-round align-middle">developer_board</span> <span class="align-middle poppins-font"> Nutrition Board</span>
                                                </button>
                                                <button id="interaction-btn-prog-admin" class="onefit-buttons-style-light p-4 my-2 text-center shadow" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInteractionSubAdmin" aria-expanded="false" aria-controls="collapseInteractionSubAdmin">
                                                    <span class="material-icons material-icons-round align-middle">admin_panel_settings</span> <span class="align-middle poppins-font"> Administration</span>
                                                    <div class="text-center">
                                                        <span class="material-icons material-icons-round align-middle">expand_more</span>
                                                    </div>
                                                </button>
                                                <div class="collapse w3-animate-left" id="collapseInteractionSubAdmin">
                                                    <div class="row">
                                                        <div class="col-md d-grid">
                                                            <button id="interaction-btn-prog-admin-create" class="onefit-buttons-style-light p-4 my-2 text-center shadow" type="button" data-bs-toggle="modal" data-bs-target="#trainingInteractionsContentModal" onclick="$.loadInteractionContent('CreationTools')">
                                                                <span class="material-icons material-icons-round align-middle">brush</span>
                                                                <span class="align-middle poppins-font"> Creation Tools.</span>
                                                            </button>
                                                        </div>
                                                        <div class="col-md d-grid">
                                                            <button id="interaction-btn-prog-admin-data-mgmt" class="onefit-buttons-style-light p-4 my-2 text-center shadow" type="button" data-bs-toggle="modal" data-bs-target="#trainingInteractionsContentModal" onclick="$.loadInteractionContent('AdminDataMgmt')">
                                                                <span class="material-icons material-icons-round align-middle">account_tree</span>
                                                                <span class="align-middle poppins-font"> Data Management Tools.</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                    </div>
                                    <!-- ./ Team Athletics Training Panel -->

                                    <hr class="text-white">

                                    <!-- tab navigation buttons -->
                                    <div class="mb-4 text-center" style="width: 100%">
                                        <div class="row">
                                            <div class="col-md d-grid">
                                                <!-- Next Tab button - Return to Google community Surveys -->
                                                <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabGCS')">
                                                    <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_back</span></p>
                                                    <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Google Community Surveys</p>
                                                </button>
                                                <!-- ./Next Tab button - Return to Google community Surveys -->
                                            </div>
                                            <div class="col-md d-grid">
                                                <!-- Next Tab button - Proceed to Wellness Tracking -->
                                                <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabWell')">
                                                    <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_forward</span></p>
                                                    <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Wellness</p>
                                                </button>
                                                <!-- ./Next Tab button - Proceed to Wellness Tracking -->
                                            </div>
                                        </div>
                                        <!-- <div class="d-flex justify-content-between" style="width: 100%"></div> -->
                                    </div>
                                    <!-- ./ tab navigation buttons -->

                                </div>
                                <!-- ./ Team Athletics Tab -->
                                <!-- *********************************** -->
                                <!-- Wellness Tab -->
                                <div class="tab-pane fade w3-animate-bottom no-scroller py-4 px-2" id="v-sub-tab-pills-insights-wellness" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-insights-wellness-tab">
                                    <div class="d-grid text-center mt-4">
                                        <span class="material-icons material-icons-round">self_improvement</span>
                                        <h5 class="mt-4 fs-1">Wellness Tracking</h5>
                                    </div>
                                    <hr class="text-white">

                                    <h1 class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti my-4">Wellness Tracking.</h1>

                                    <div class="mt-4" id="wellness-tracking-container">
                                        <img src="../media/assets/smartwatches/9aea1c56ffe237edeb69ecd3988bfd51.jpg" class="img-fluid shadow mb-4" style="border-radius: 25px;" alt="dashboard placeholder">
                                        <img src="../media/assets/smartwatches/fitbit-web1.webp" class="img-fluid shadow mb-4" style="border-radius: 25px;" alt="dashboard placeholder">
                                    </div>

                                    <hr class="text-white">

                                    <div class="mb-4 text-center" style="width: 100%">
                                        <div class="row">
                                            <div class="col-md d-grid">
                                                <!-- Next Tab button - Return to Team Athletics -->
                                                <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabCTA')">
                                                    <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_back</span></p>
                                                    <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">diversity_2</span> -->
                                                    <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Team Athletics</p>
                                                </button>
                                                <!-- ./Next Tab button - Return to Team Athletics -->
                                            </div>
                                            <div class="col-md d-grid">
                                                <!-- Next Tab button - Proceed to Nutrition Tracking -->
                                                <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabCTA')">
                                                    <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_forward</span></p>
                                                    <!-- <span class="material-icons material-icons-rounded" style="font-size: 20px !important;">restaurant</span> -->
                                                    <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Nutrition</p>
                                                </button>
                                                <!-- ./Next Tab button - Proceed to Nutrition Tracking -->
                                            </div>
                                        </div>
                                        <!-- <div class="d-flex justify-content-between" style="width: 100%"></div> -->
                                    </div>

                                </div>
                                <!-- ./ Wellness Tab -->
                                <!-- ********************************* -->
                                <!-- Nutrition Tab -->
                                <div class="tab-pane fade w3-animate-bottom no-scroller py-4 px-2" id="v-sub-tab-pills-insights-nutrition" style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" role="tabpanel" aria-labelledby="v-sub-tab-pills-insights-nutrition-tab">
                                    <div class="d-grid text-center mt-4">
                                        <span class="material-icons material-icons-round">restaurant</span>
                                        <h5 class="mt-4 fs-1">Nutrition Tracking</h5>
                                    </div>

                                    <hr class="text-white">

                                    <h1 class="fs-1 fw-bold rounded-pill p-4 text-center down-top-grad-tahiti my-4">Nutrition Tracking.</h1>
                                    <div class="mt-4" id="wellness-tracking-container">
                                        <img src="../media/assets/smartwatches/A8_Dashboard_Overview.png" class="img-fluid shadow mb-4" style="border-radius: 25px;" alt="dashboard placeholder">
                                    </div>

                                    <hr class="text-white">

                                    <!-- Next Tab button - Return to Wellness Tracking -->
                                    <div class="mb-4 text-center" style="width: 100%">
                                        <div class="d-grid justify-content-center" style="width: 100%">
                                            <button class="onefit-buttons-style-dark p-4" onclick="openLink(event, 'InsightsTabCTA')">
                                                <p class="m-0 p-0"><span class="material-icons material-icons-rounded" style="font-size: 40px !important;">arrow_back</span></p>
                                                <p class="m-0 p-0 comfortaa-font" style="font-size: 20px !important;">Wellness</p>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- ./Next Tab button - Return to Wellness Tracking -->

                                </div>
                                <!-- ./ Nutrition Tab -->
                                <!-- ./ insights tab - sub-tabs -->

                            </div>
                            <!-- ./ Team Athlectics Training Panel -->

                        </div>
                        <!-- ./ insight catgories tab panels -->
                    </div>
                    <!-- ./ Features: Tab structured -->

                    <!-- removed stream section here -->

                    <!-- ads strip -->
                    <div class="text-center d-grid justify-content-center align-items-center" style="max-height: 80vh; overflow-y: auto; min-height: 200px">
                        <h5>Ads<span style="color: #ffa500;">.</span></h5>
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <!-- ./ ads strip -->

                </div>
                <div id="TabAchievements" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">emoji_events</span> <span class="align-middle">Achievements</span></h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <hr class="text-white" />
                    <h5>Goals</h5>
                    <hr class="text-white">
                    <h5>Timeframes</h5>
                    <hr class="text-white">
                    <h5>Challenges</h5>
                    <hr class="text-white">

                    <h5 class="mt-4">Fitness Progression</h5>
                    <div class="progress mt-4" style="height: 4px;">
                        <div class="progress-bar" role="progressbar" aria-label="Example 1px high" style="width: 25%; background-color: #ffa500 !important; border-right: #343434 10px solid;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row mt-2" style="margin-bottom: 60px;">
                        <div class="col text-start comfortaa-font" style="font-size: 12px;">
                            Current XP <strong>(112)</strong>
                        </div>
                        <div class="col text-end comfortaa-font" style="font-size: 12px;">
                            Target XP <strong>(150)</strong>
                        </div>
                    </div>

                    <h5 class="my-4">Daily Challenges</h5>

                    <div id="daily-challenges-grid" class="grid-container mb-4">
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-body-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-deadlift-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-muscle-flexing-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-exercise-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-fit-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-workout-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                    </div>

                    <h5 class="my-4">Weekly Challenges</h5>

                    <div id="weekly-challenges-grid" class="grid-container mb-4">
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-body-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-deadlift-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-muscle-flexing-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-exercise-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-fit-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-workout-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                    </div>

                    <h5 class="my-4">Monthly Monthly</h5>

                    <div id="monthly-challenges-grid" class="grid-container mb-4">
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-body-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-deadlift-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-muscle-flexing-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-exercise-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-fit-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                        <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                            <img src="../media/assets/icons/icons8-workout-50.png" class="img-fluid rounded mb-4" alt="">
                            <p>Challenge Title</p>
                            <small>Workout / Exercise</small>
                            <small>Category</small>
                            <!-- progress bar -->
                            <p>15 / 25 xp</p>
                        </div>
                    </div>

                    <h5>Diary</h5>
                    <hr class="text-white">
                    <h5>Resources</h5>
                    (bookmarked resources, posts or search engine links)
                    <hr class="text-white">
                </div>
                <div id="TabMedia" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">perm_media</span> <span class="align-middle">Media</span></h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>
                    <!-- <h1 class="text-center">Media</h1>
                    <hr class="text-white" /> -->

                    <!-- main media content -->
                    <!-- iframe to load user media main widget script ui output -->
                    <!-- <iframe id="iframe-load-main-media-section" class="w-100" src="media_main_test.html" frameborder="0" style="height: 100vh; border-radius: 25px; overflow-x: hidden;"></iframe> -->
                    <!-- ./ iframe to load user media main widget script ui output -->
                    <!-- ./ main media content -->

                    <!-- <h1 class="fs-1 fw-bold rounded-pill p-4 text-center my-4">Photos</h1>
                    <div id="Users-Images" class="grid-container">
                        echo $outputProfileUserMediaList;
                    </div>

                    <h1 class="fs-1 fw-bold rounded-pill p-4 text-center my-4">Videos</h1>

                    <h1 class="fs-1 fw-bold rounded-pill p-4 text-center my-4">Stream library – Live stream recording history (Community and Private)</h1> -->

                    <!-- inline/flex media tab subtabs controller btns -->
                    <div id="inline-media-content-tab-btns" class="d-grid justify-content-center w3-animate-bottom p-2 sticky-topz" style="background: #333; border-radius: 25px; overflow: hidden;">
                        <style>
                            .force-inline-nav {
                                flex-wrap: nowrap !important;
                            }
                        </style>

                        <div class="w3-animate-bottom my-4 horizontal-scroll no-scroller p-4" style="overflow-y: hidden;" id="insights-subfeatures-nav-menu">
                            <nav class="m-0">
                                <div class="nav force-inline-nav nav-tabs border-0" id="nav-tab-mediatab-subtabs-controller-container" role="tablist" style="border-color: #ffa500 !important">
                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative active" style="border-radius: 25px !important;min-width: 130px;" id="nav-mediatab-main-sharedmedia-subtab" onclick="clickmediatabMainSubTabs('shared_media')" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-media-subtab-sharedmedia" type="button" role="tab" aria-controls="v-sub-tab-pills-media-subtab-sharedmedia" aria-selected="true">
                                        <span id="mediatab-main-navs-horizontal-rule-icon-sharedmedia" class="material-icons material-icons-outlined align-middle" style="display: block; font-size: 40px !important;">swap_calls</span><br>
                                        <span class="material-icons material-icons-outlined align-middle d-none" style="font-size: 20px !important;">
                                            swap_calls
                                        </span>
                                        <span class="align-middle">Shared</span>
                                    </button>

                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;min-width: 130px;" id="nav-mediatab-main-privatemedia-subtab" onclick="clickmediatabMainSubTabs('private_media')" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-media-subtab-privatemedia" type="button" role="tab" aria-controls="v-sub-tab-pills-media-subtab-privatemedia" aria-selected="false">
                                        <span id="mediatab-main-navs-horizontal-rule-icon-sharedmedia" class="material-icons material-icons-outlined align-middle" style="display: block; font-size: 40px !important;">lock</span><br>
                                        <span class="material-icons material-icons-round align-middle d-none" style="font-size: 20px !important;">
                                            lock
                                        </span>
                                        <span class="align-middle">Private</span>
                                    </button>

                                    <button class="nav-link p-4 comfortaa-font fw-bold border-top border-5 position-relative" style="border-radius: 25px !important;min-width: 130px;" id="nav-mediatab-main-videos-subtab" onclick="clickmediatabMainSubTabs('videos')" data-bs-toggle="pill" data-bs-target="#v-sub-tab-pills-media-subtab-videos" type="button" role="tab" aria-controls="v-sub-tab-pills-media-subtab-videos" aria-selected="false">
                                        <span id="mediatab-main-navs-horizontal-rule-icon-sharedmedia" class="material-icons material-icons-outlined align-middle" style="display: block; font-size: 40px !important;">movie</span><br>
                                        <span class="material-icons material-icons-round align-middle d-none" style="font-size: 20px !important;">
                                            movie
                                        </span>
                                        <span class="align-middle">Videos</span>
                                    </button>

                                </div>
                            </nav>

                        </div>
                    </div>
                    <!-- ./ inline/flex media tab subtabs controller btns -->

                    <!-- pmain media gallery tabs container -->
                    <div class="tab-content" id="v-pills-tab-mediatab-main-subtabs">
                        <!-- #v-sub-tab-pills-media-subtab-sharedmedia -->
                        <div id="v-sub-tab-pills-media-subtab-sharedmedia" class="tab-pane fade show active content-panel-border-style-dark-bg w3-animate-bottom no-scroller p-4 gap-4" role="tabpanel" aria-labelledby="v-sub-tab-pills-media-subtab-sharedmedia">
                            <!-- style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" -->

                            <h1 class="text-center d-gridz fs-1">
                                <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">
                                    swap_calls
                                </span>
                                <span class="align-middle">Shared media.</span>
                            </h1>

                            <hr class="text-white">

                            <!-- media items grid container -->
                            <div id="shared-media-grid-container" class="grid-container p-4" style="border-radius: 25px; max-height: 100vh; overflow-y: auto;overflow-x: hidden;">
                                <!-- media items grid cards -->
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/assets/OnefitNet Profile Pic.png');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->

                                </div>
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/assets/lmm_logo_pattern_blackdark.png');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->
                                </div>
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/images/fitness/7.jpg');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->
                                </div>
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/website_pexels/pexels-cliff-booth-4056964.jpg');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->
                                </div>
                            </div>
                            <!-- ./ media items grid container -->
                        </div>
                        <!-- #v-sub-tab-pills-media-subtab-privatemedia -->
                        <div class="tab-pane fade content-panel-border-style-dark-bg w3-animate-bottom no-scroller p-4 gap-4" id="v-sub-tab-pills-media-subtab-privatemedia" role="tabpanel" aria-labelledby="v-sub-tab-pills-media-subtab-privatemedia">
                            <!-- style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" -->

                            <h1 class="text-center d-gridz fs-1">
                                <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">
                                    lock
                                </span>
                                <span class="align-middle">Private media.</span>
                            </h1>

                            <hr class="text-white">


                            <!-- media items grid container -->
                            <div id="private-media-grid-container" class="grid-container p-4" style="border-radius: 25px; max-height: 100vh; overflow-y: auto;overflow-x: hidden;">
                                <!-- media items grid cards -->
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/assets/OnefitNet Profile Pic.png');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->

                                </div>
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/assets/lmm_logo_pattern_blackdark.png');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->
                                </div>
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/images/fitness/7.jpg');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->
                                </div>
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/website_pexels/pexels-cliff-booth-4056964.jpg');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->
                                </div>
                            </div>
                            <!-- ./ media items grid container -->
                        </div>
                        <!-- #v-sub-tab-pills-media-subtab-videos -->
                        <div class="tab-pane fade content-panel-border-style-dark-bg w3-animate-bottom no-scroller p-4 gap-4" id="v-sub-tab-pills-media-subtab-videos" role="tabpanel" aria-labelledby="v-sub-tab-pills-media-subtab-videos">
                            <!-- style="max-height: 100vh!important; overflow-y: auto; overflow-x: hidden;" -->

                            <h1 class="text-center d-gridz fs-1"><span class="material-icons material-icons-round align-middle" style="color: #ffa500;">
                                    movie
                                </span>
                                <span class="align-middle">Videos.</span>
                            </h1>

                            <hr class="text-white">


                            <!-- media items grid container -->
                            <div id="videos-media-grid-container" class="grid-container p-4" style="border-radius: 25px; max-height: 100vh; overflow-y: auto;overflow-x: hidden;">
                                <!-- media items grid cards -->
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/assets/OnefitNet Profile Pic.png');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->

                                </div>
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/assets/lmm_logo_pattern_blackdark.png');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->
                                </div>
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/images/fitness/7.jpg');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->
                                </div>
                                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="overflow: hidden; max-height: 200px; background-image: url('../media/website_pexels/pexels-cliff-booth-4056964.jpg');">
                                    <button class="onefit-buttons-style-tahiti p-3 d-grid">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                            open_in_new
                                        </span>
                                        <span class="align-middle" style="font-size: 10px !important;">View.</span>
                                    </button>

                                    <!-- media info collapse -->
                                    <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse" href="#friend-card-info-userid" role="button" aria-expanded="false" aria-controls="friend-card-info-userid" class="collapsed">
                                        <span class="material-icons material-icons-round align-middle text-white" style="font-size: 20px !important;">
                                            info
                                        </span>
                                        <span class="align-middle text-white">info.</span>
                                    </a>
                                    <span id="friend-card-info-userid" class="collapse p-1 shadow" style="background-color: rgb(52, 52, 52, 0.5);">
                                        Users
                                        biography here.media info here.Users
                                        biography here.media info here.
                                    </span>
                                    <!-- media info collapse -->
                                </div>
                            </div>
                            <!-- ./ media items grid container -->
                        </div>
                    </div>
                    <!-- ./ main media gallery tabs container -->
                </div>
                <div id="TabCommunication" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">forum</span> <span class="align-middle">Communications</span></h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>

                    <!-- Twitter social buttons / section -->
                    <!-- twitter social panel -->
                    <div class="load-curtain-social-btn-panel darkpads-bg-container-staticz down-top-grad-tahiti comfortaa-font d-grid gap-2 p-4 shadow-lg" style="position: fixed;top: auto;bottom: 5vh;right: 0px; left: auto; border-radius: 25px 0 0 25px !important;">
                        <!-- z-index:auto; -->
                        <!--  d-none d-lg-block p-4 -->
                        <div class="d-flex gap-2 w-100 justify-content-start">
                            <button class="p-4 m-0 shadow onefit-buttons-style-light-twitter" type="button" data-bs-toggle="collapse" data-bs-target="#collapseloadCurtainTweetFeed" aria-expanded="false" aria-controls="collapseloadCurtainTweetFeed">
                                <div class="d-grid">
                                    <span class="material-icons material-icons-round" style="font-size: 48px !important;">
                                        <i class="fab fa-twitter" style="font-size: 40px;"></i>
                                    </span>
                                    <p class="comfortaa-font mt-1 mb-0" style="font-size: 10px;">@onefitnet</p>
                                </div>
                            </button>
                        </div>
                        <div class="collapse no-scroller pb-4 w3-animate-bottom" id="collapseloadCurtainTweetFeed" style="overflow-y: auto;">
                            <div class="pb-4 no-scroller" style="border-radius: 25px !important; overflow-y: auto; max-height: 90vh; min-width: 500px;">
                                <a class="twitter-timeline comfortaa-font" href="https://twitter.com/OnefitNet?ref_src=twsrc%5Etfw">Tweets by OnefitNet</a>
                                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                            </div>
                        </div>
                    </div>
                    <!-- ./ twitter social panel -->
                    <!-- ./ Twitter social buttons / section -->

                    <h2><span class="material-icons material-icons-round align-middle" style="color: #ffa500;">notifications</span> <span class="align-middle">Notifications</span></h2>
                    <div class="mb-4" id="communicationUserNotifications">
                        <?php echo $outputProfileUserNotifications; ?>
                    </div>

                    <hr class="text-white">

                    <h2><span class="material-icons material-icons-round align-middle" style="color: #ffa500;">newspaper</span> <span class="align-middle">Updates / News</span></h2>
                    <div class="mb-4" id="communicationNews">
                        <?php echo $outputCommunityNews; ?>
                    </div>
                    <div class="mb-4 py-4" id="communicationRSSImagebrd">
                        <!-- #FitnessandDiet -->
                        <h5><span class="material-icons material-icons-round align-middle" style="font-size: 22px !important;">rss_feed</span> <span class="align-middle" style="color: #ffa500;"><span class="text-muted">RSS.</span> #FitnessandDiet</span></h5>
                        <div class="mb-4 p-4" style="overflow: hidden; background-color: #333333; border-radius: 25px;">
                            <!-- <rssapp-magazine id="tRprB0QxQKySE340"></rssapp-magazine>
                            <script src="https://widget.rss.app/v1/magazine.js" type="text/javascript" async></script> -->
                            <span class="text-muted">RSS is down.</span>
                        </div>

                        <!-- #Wellness -->
                        <h5><span class="material-icons material-icons-round align-middle" style="font-size: 22px !important;">rss_feed</span> <span class="align-middle" style="color: #ffa500;"><span class="text-muted">RSS.</span> #Wellness</span></h5>
                        <div class="mb-4 p-4" style="overflow: hidden; background-color: #333333; border-radius: 25px;">
                            <!-- <rssapp-magazine id="tdSnePzUjMvFu4nu"></rssapp-magazine>
                            <script src="https://widget.rss.app/v1/magazine.js" type="text/javascript" async></script> -->
                            <span class="text-muted">RSS is down.</span>
                        </div>

                        <!-- #worldofsport feed -->
                        <h5><span class="material-icons material-icons-round align-middle" style="font-size: 22px !important;">rss_feed</span> <span class="align-middle" style="color: #ffa500;"><span class="text-muted">RSS.</span> #WorldofSports</span></h5>
                        <div class="mb-4 p-4" style="overflow: hidden; background-color: #333333; border-radius: 25px;">
                            <!-- <rssapp-magazine id="tqX4YEeGEu1eOKAT"></rssapp-magazine>
                            <script src="https://widget.rss.app/v1/magazine.js" type="text/javascript" async></script> -->
                            <span class="text-muted">RSS is down.</span>
                        </div>

                        <!-- #footballfocus feed -->
                        <h5><span class="material-icons material-icons-round align-middle" style="font-size: 22px !important;">rss_feed</span> <span class="align-middle" style="color: #ffa500;"><span class="text-muted">RSS.</span> #FootballFocus</span></h5>
                        <div class="mb-4 p-4" style="overflow: hidden; background-color: #333333; border-radius: 25px;">
                            <!-- <rssapp-magazine id="omltJunAYvJxQiZc"></rssapp-magazine>
                            <script src="https://widget.rss.app/v1/magazine.js" type="text/javascript" async></script> -->
                            <span class="text-muted">RSS is down.</span>
                        </div>

                        <!-- #HealthandLifestyle -->
                        <h5><span class="material-icons material-icons-round align-middle" style="font-size: 22px !important;">rss_feed</span> <span class="align-middle" style="color: #ffa500;"><span class="text-muted">RSS.</span> #HealthandLifestyle</span></h5>
                        <div class="mb-4 p-4" style="overflow: hidden; background-color: #333333; border-radius: 25px;">
                            <!-- <rssapp-magazine id="tUyOEDFpWEUsTIO4"></rssapp-magazine>
                            <script src="https://widget.rss.app/v1/magazine.js" type="text/javascript" async></script> -->
                            <span class="text-muted">RSS is down.</span>
                        </div>

                    </div>

                    <hr class="text-white">

                    <!-- Onefit.Chat is now Messages. There is a dedicated icon in the .apps menu -->
                    <!-- <h2 class="mb-4"><span class="material-icons material-icons-round align-middle" style="color: #ffa500;">question_answer</span> <span class="align-middle">Messenger</span></h2>
                    <div class="p-0 mb-4 d-grid gap-2 my-pulse-animation-dark rounded-pill mb-4">
                        <button class="onefit-buttons-style-dark p-4 text-center fs-1 comfortaa-font shadow rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottomOnefitChat" aria-controls="offcanvasBottomOnefitChat">
                            One<span style="color:#ffa500;">fit.</span>Chat
                        </button>
                    </div>

                    <hr class="text-white"> -->

                    <h2 class="mb-4"><span class="material-icons material-icons-round align-middle" style="color: #ffa500;">campaign</span> <span class="align-middle">AdMarket</span></h2>
                </div>
                <div id="TabSettings" class="shadow w3-container w3-animate-right content-tab p-4 app-tab" style="display: none">
                    <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius: 25px; border-color: #ffa500 !important;">
                        <h5 class="mt-4 fs-1 text-center align-middle"><span class="material-icons material-icons-outlined align-middle" style="color: #ffa500 !important; font-size: 40px;">settings_accessibility</span> <span class="align-middle">Preferences</span></h5>
                        <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                    </div>
                    <!-- <h1 class="text-center">Preferences</h1>
                    <hr class="text-white" /> -->

                    User Interface<br>
                    Account<br>
                    Privacy<br>
                    Referencing<br>
                    About Us<br>

                    <div id="userPrefContainer">
                        <?php echo $profileUserPref; ?>
                    </div>
                </div>
            </div>
            <!-- ./ #tab-container -->
        </div>
        <!-- ./ Tab Content -->
    </div>
    <!-- ./ Main Content -->

    <!-- Footer -->
    <nav class="text-white w-100 m-0 p-0 fixed-bottom navbar-stylez tunnel-bg-container no-scroller" style="max-height: 100vh !important; overflow-y: auto; overflow-x: hidden">
        <!--style="position: fixed; bottom: 0; left: 0; background: #333; z-index: 10002"-->
        <div class="down-top-grad-darkz mainapp-footer px-2">

            <!-- Widgets Container -->
            <div class="collapse m-0 p-0" id="widget-rows-container">
                <div class="navbar p-4">
                    <h1 class="text-center mt-4 fs-1">
                        <span class="material-icons material-icons-round align-middle" style="font-size: 60px !important; color: #ffa500;">
                            widgets </span>
                        <span class="align-middle">Widgets.</span>
                    </h1>

                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-toggle="collapse" data-bs-target="#widget-rows-container" aria-controls="widget-rows-container">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>

                <!-- Widget: User Profile Preview List (Widget: UPPL - It is hidden on lg screens) -->
                <iframe id="iframe-load-profile-header-section" class="w-100 mx-4 d-lg-none border-5 border-bottom" src="../scripts/php/main_app/compile_content/profile_tab/user_profile_header.php?usnm=KING_001" frameborder="0" style="height: 50vh; border-radius: 25px;border-color: #ffa500 !important;"></iframe>
                <!-- ./ Widget: User Profile Preview List -->

                <div class="row align-items-center mb-4">
                    <div class="col-lg text-center my-4">
                        <!-- Widget: mini profile header -->
                        <div id="mini-profile-header" class="d-none d-lg-block mb-4 container-xlg border-5 border-start border-end" style="border-radius: 25px; overflow: hidden;border-color: #ffa500 !important;">
                            <div class='text-center'>
                                <!-- Users Profile Banner -->
                                <div class="shadow-lg display-profile-banner-container">
                                    <div class="h-100 down-top-grad-dark">
                                        <!-- gradient overlay -->
                                    </div>
                                </div>
                                <!-- ./ Users Profile Banner -->
                                <!-- Profile Picture -->
                                <div class="d-grid justify-content-center">
                                    <div class="display-profile-img-container shadow down-top-grad-dark" style="margin-top: -200px !important">
                                    </div>
                                </div>

                                <!-- ./ Profile Picture -->
                                <p class='poppins-font mt-2 username-tag' hidden>@$user_loggedin_username</p>
                            </div>
                            <!--<hr class='text-white' />-->
                            <!-- main buttons for interacting with user profile -->
                            <div class="d-flex justify-content-around align-items-center p-4" style="background-color: #343434;border-radius:0 0 25px 25px;">
                                <!--  -->
                                <button type="button" class="onefit-buttons-style-dark p-4 m-1 border-1 bg-transparent d-grid">
                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">follow_the_signs</span>
                                    <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                        <!-- <span style="color: #ffa500 !important;">+</span> -->
                                        Follow Me
                                    </span>
                                </button>
                                <!-- visual divide -->
                                <div>
                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                                        horizontal_rule
                                    </span>
                                </div>
                                <!-- ./ visual divide -->
                                <!--  -->
                                <button type="button" class="onefit-buttons-style-dark p-4 m-1 border-1 bg-transparent d-grid">
                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important"> handshake
                                    </span>
                                    <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                        <!-- <span style="color: #ffa500 !important;">+</span> -->
                                        Help
                                    </span>
                                </button>
                                <!-- visual divide -->
                                <div>
                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important; transform: rotate(90deg);">
                                        horizontal_rule
                                    </span>
                                </div>
                                <!-- ./ visual divide -->
                                <!--  -->
                                <button type="button" class="onefit-buttons-style-dark p-4 m-1 border-1 bg-transparent d-grid">
                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important"> 3p </span>
                                    <span class="align-middle d-none d-lg-block" style="font-size: 10px;">
                                        <!-- <span style="color: #ffa500 !important;">+</span> -->
                                        Message
                                    </span>
                                </button>
                            </div>
                            <!-- ./ main buttons for interacting with user post -->
                        </div>
                        <!-- ./ Widget: mini profile header -->

                        <!-- Widget: activity tracker quick capture and view -->
                        <div class="container-xlg p-4 shadow-lg d-inline-blockz border-5 border-start border-end" style="border-radius: 25px; border-color: #ffa500 !important; background-color: #343434">
                            <div class="row align-items-center text-center comfortaa-font">
                                <div class="col-sm py-2 d-grid gap-2">
                                    <!--<i class="fas fa-heart"></i>-->
                                    <span class="align-middle fs-6">89<sup style="color: #ffa500;">b/s</sub></span>
                                    <span class="material-icons material-icons-round align-middle"> monitor_heart </span>

                                </div>
                                <div class="col-sm py-2 d-inline"><span style="color: #ffa500">|</span></div>
                                <div class="col-sm py-2 d-grid gap-2">
                                    <!--<i class="fas fa-thermometer-half"></i>-->
                                    <span class="align-middle fs-6">68.3<sup style="color: #ffa500;">&#8451;</sub></span>
                                    <span class="material-icons material-icons-round align-middle"> device_thermostat </span>

                                </div>
                                <div class="col-sm py-2 d-grid justify-content-center gap-2">
                                    <img src="../media/assets/icons/icons8-smart-watch-50.png" alt="smartwatch" class="img-fluid p-2" />
                                    <span class="material-icons material-icons-round align-middle rounded-circle my-pulse-animation-tahiti fs-6 p-2" style="color: #ffa500;">
                                        add_circle_outline
                                    </span>
                                </div>
                                <div class="col-sm py-2 d-grid gap-2">
                                    <!--<i class="fas fa-bolt"></i>-->
                                    <span class="align-middle fs-6">12.5<sup style="color: #ffa500;">ms</sub></span>
                                    <span class="material-icons material-icons-round align-middle"> bolt </span>

                                </div>
                                <div class="col-sm py-2 d-inline"><span style="color: #ffa500">|</span></div>
                                <div class="col-sm py-2 d-grid gap-2">
                                    <!--<i class="fas fa-walking"></i>-->
                                    <span class="align-middle fs-6">1260<sup style="color: #ffa500; font-size: 10px;"> stps</sub></span>
                                    <span class="material-icons material-icons-round align-middle"> directions_walk </span>

                                </div>
                            </div>
                        </div>
                        <!-- Widget: activity tracker quick capture and view -->

                        <!-- Widget: Digital Clock -->
                        <!-- Digital Clock -->
                        <div id="clock" class="dark my-4 shadow">
                            <div class="display no-scroller">
                                <div class="weekdays"></div>
                                <div class="ampm"></div>
                                <div class="alarm"></div>
                                <div class="digits"></div>
                            </div>
                        </div>
                        <!-- ./. Digital Clock -->
                        <!-- ./ Widget: Digital Clock -->

                    </div>
                    <div class="col-lg-4 text-center">
                        <!-- remove this widget style -->
                        <!-- <div class="py-4 shadow border-start border-end" style="border-radius: 25px; border-color: #ffa500 !important; background-color: #343434">
                            <h5>One<span style="color: #ffa500">fit</span>.Muse <span class="material-icons material-icons-round">
                                    equalizer
                                </span></h5>
                            <hr class="text-white" />
                            <p class="poppins-font fw-bold comfortaa-font">No media playing.</p>
                            <div class="container-xlg">
                                <div class="row my-4">
                                    <div class="col-sm">
                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('prev')"><span class="material-icons material-icons-round">skip_previous</span></button>
                                    </div>
                                    <div class="col-sm">
                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('togglePlay')"><span class="material-icons material-icons-round">play_circle</span></button>
                                    </div>
                                    <div class="col-sm">
                                        <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('next')"><span class="material-icons material-icons-round">skip_next</span></button>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- onefit.muse music widget (new widget style) -->
                        <div class="p-0 darkpads-bg-container-static shadow border-5 border-start border-end border-bottom" id="track-info-visualizer-container" style="border-color: #ffa500 !important; border-radius: 25px !important; overflow: hidden;">
                            <div class="down-top-grad-dark p-4 h-100 w-100">
                                <!-- widget title -->
                                <h5 class="fs-5">
                                    <span class="align-middle">One<span style="color: #ffa500">fit</span>.Muse</span>
                                    <span class="material-icons material-icons-round align-middle">
                                        equalizer
                                    </span>
                                </h5>
                                <hr class="text-white" />
                                <!-- ./ widget title -->

                                <div class="row align-items-center">
                                    <div class="col-md -4 text-center">
                                        <!--Thumbnail-->
                                        <div class="p-0 shadow border-bottom" style="min-height: 20vh; border-radius: 25px; color: #fff; background-color: #343434; border-color: #ffa500 !important; border-width: 5px !important; overflow: hidden;">
                                            <div class="card bg-dark text-white border-0">
                                                <!-- style="border-radius: 25px !important;" -->
                                                <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="card-img" alt="..."> <!-- style="border-radius: 25px !important;" -->
                                                <div class="card-img-overlay down-top-grad-dark d-grid align-items-end">
                                                    <!-- style="border-radius: 25px !important;" -->
                                                    <div class="text-start">
                                                        <h5 class="card-title" style="color: #ffa500 !important;">Card title</h5>
                                                        <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p> -->
                                                        <div class="d-inline card-text">
                                                            <span class="material-icons material-icons-outlined" style="color: #ffa500; font-size: 10px !important;">tag</span>
                                                            <!-- track id - bc -->
                                                            <span class="barcode-font text-muted" style="color: #ffa500; font-size: 10px !important;">
                                                                Plylstid_0000001_Trackid_0000001
                                                            </span>
                                                            <!-- ./ track id - bc -->
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <!--./ Thumbnail-->

                                        <div class="d-grid gap-2 w-100">
                                            <button class="onefit-buttons-style-dark shadow p-2 px-4 my-4" style="transform: translate(0) !important;" id="museplayer-togglebtn" type="button" data-bs-toggle="collapse" data-bs-target="#track-playid-songid" aria-expanded="false" aria-controls="track-playid-songid">
                                                <div class="row align-items-center w-100 text-center">
                                                    <div class="col-sm text-start">
                                                        <span class="material-icons material-icons-round rounded-pill shadow -sm p-3" style="font-size: 50px !important;">
                                                            art_track
                                                        </span>
                                                    </div>
                                                    <div class="col-sm py-4">
                                                        track Title (00:00)
                                                    </div>
                                                </div>
                                            </button>
                                        </div>

                                    </div>
                                    <div class="col-xlg-8 mb-4 collapse w3-animate-right text-white" id="track-playid-songid">
                                        <div class="mb-4 py-2">
                                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: #ffa500 !important;">info</span> Track Information.
                                        </div>

                                        <hr class="text-white">

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-center"> <span class="align-middle">Like</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">thumb_up</span></li>
                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-center"> <span class="align-middle">Share</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">share</span></li>
                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-center"> <span class="align-middle">Save</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">favorite</span></li>
                                            <li class="list-group-item bg-transparent comfortaa-font fs-5 text-white text-center"> <span class="align-middle">follow</span> <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">follow_the_signs</span></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- music player controller buttons -->
                                <div class="text-center">
                                    <hr class="text-white">
                                    <div class="row my-4">
                                        <div class="col -sm">
                                            <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('prev')"><span class="material-icons material-icons-round">skip_previous</span></button>
                                        </div>
                                        <div class="col -sm">
                                            <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('togglePlay')"><span class="material-icons material-icons-round">play_circle</span></button>
                                        </div>
                                        <div class="col -sm">
                                            <button class="onefit-buttons-style-dark p-4" onclick="musePlayerController('next')"><span class="material-icons material-icons-round">skip_next</span></button>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./ music player controller buttons -->
                            </div>

                        </div>
                        <!-- ./ onefit.muse music widget -->
                    </div>
                </div>

                <hr class="text-white">

                <!-- RSS Feed embed -->
                <!-- <div style="overflow: hidden; background-color: #333333; border-radius: 25px;">
                </div> -->
                <h2 class="mt-4"><span class="material-icons material-icons-round align-middle" style="color: #ffa500;">newspaper</span> <span class="align-middle">Updates / News</span></h2>

                <h5><span class="material-icons material-icons-round align-middle" style="font-size: 22px !important;">rss_feed</span> <span class="align-middle" style="color: #ffa500;"><span class="text-muted">RSS.</span> #WorldofSports</span></h5>
                <!-- <rssapp-imageboard class="mt-4" id="tqX4YEeGEu1eOKAT"></rssapp-imageboard>
                <script src="https://widget.rss.app/v1/imageboard.js" type="text/javascript" async></script> -->
                <span class="text-muted">RSS is down.</span>

                <!-- ./ RSS Feed embed -->

                <div class="text-center py-2">
                    <hr class="text-white" />
                    | Privacy |
                    <p class="m-0 p-0"><span class="m-0 float-right" style="font-size: 10px">Crafted by AdaptivConcept &copy;
                            2021</span></p>
                </div>
            </div>
            <!-- ./ Widgets Container -->
        </div>
    </nav>
    <!-- ./ Footer -->

    <!-- Modals ----------------------------------------------------------------------------------------- -->

    <!-- Button trigger modal>>>>>>>>>> Tab Navigation Modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tabNavModal" hidden>
        Launch #tabNavModal</button>

    <!-- >>>>>>>>>> Tab Navigation Modal -->
    <div class="modal fade" id="tabNavModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tabNavModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content feature-tab-nav-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fs-1" id="tabNavModalLabel"><span style="color: #ffa500;">.apps</span> menu</h5>
                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>
                <hr class="text-white m-0" />
                <div class="modal-body border-0" style="overflow-x: hidden">
                    <!-- Tab Navigation Buttons Container -->
                    <div class="grid-container text-center">
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-dashboard-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabHome')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> dashboard </span>
                                    <div class="d-inline">
                                        <i class="fas fa-home"></i> <span style="color: #fff !important;">Dashboard</span>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-profile-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabProfile')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> account_circle </span>
                                    <span style="color: #fff !important;">Profile
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-discovery-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabDiscovery')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> travel_explore </span>
                                    <span style="color: #fff !important;">Discovery</span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-studio-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabStudio')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> play_circle_outline </span>
                                    <span style="color: #fff !important;">Onefit.Studio</span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-store-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabStore')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> storefront </span>
                                    <span style="color: #fff !important;">Onefit.Store</span>
                                </div>
                            </button>
                        </div>
                        <!-- removed onefit.social selection button here -->
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-insights-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabData')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> insights </span>
                                    <span style="color: #fff !important;">Fitness Insights</span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-achievements-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabAchievements')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> emoji_events </span>
                                    <span class="align-middle" style="color: #fff !important;">Achievements <span class="material-icons material-icons-round text-muted" style="font-size: 12px !important;"> lock </span></span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-media-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabMedia')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> perm_media </span>
                                    <span class="align-middle" style="color: #fff !important;">Media <span class="material-icons material-icons-round text-muted" style="font-size: 12px !important;"> lock </span></span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-comms-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabCommunication')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> newspaper </span>
                                    <span style="color: #fff !important;">Communications</span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <!-- open chat modal -->
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-msgs-btn" onclick="openLink(event, 'OffcanvasMessages')">
                                <!-- type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottomOnefitChat" aria-controls="offcanvasBottomOnefitChat" -->
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> forum </span>
                                    <span style="color: #fff !important;">Messages</span>
                                </div>
                            </button>
                        </div>
                        <div class="grid-tile modal-grid-tile-transform">
                            <button class="onefit-buttons-style-dark-modal p-4" id="app-preferences-btn" data-bs-dismiss="modal" onclick="openLink(event, 'TabSettings')">
                                <div class="d-grid gap-2">
                                    <span class="material-icons material-icons-round"> settings_accessibility </span>
                                    <span style="color: #fff !important;">Preferences</span>
                                </div>
                            </button>
                        </div>
                    </div>
                    <!-- ./ Tab Navigation Buttons Container -->
                </div>
                <hr class="text-white m-0" />
                <div class="modal-footer border-0 d-inline-block">

                    <div class="d-grid gap-2">
                        <button class="onefit-buttons-style-dark fs-5 fw-bold my-4 px-4 pt-4 text-center comfortaa-font border-0" type="button" data-bs-toggle="collapse" data-bs-target="#tab-nav-social-quickpost" aria-expanded="false" aria-controls="tab-nav-social-quickpost"><i class="fas fa-paper-plane"></i> | <span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Social</button>
                    </div>

                    <div class="row align-items-center collapse" id="tab-nav-social-quickpost">
                        <div class="col-sm d-grid gap-2 py-4 px-0">
                            <!-- Quick Post to Social -->
                            <div class="social-quick-post d-grid">
                                <textarea name="" class="w-100 quick-post-input" id="" cols="30" rows="3" placeholder="Share an update with the Community.">Share an update with the Community.</textarea>
                            </div>
                            <!-- ./ Quick Post to Social -->
                        </div>
                        <div class="col-sm-4 d-grid gap-2">
                            <div class="row text-center">
                                <div class="col -sm px-0">
                                    <div class="d-grid">
                                        <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                            <span class="material-icons material-icons-round" style="font-size: 18px !important">
                                                attach_file </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col -sm px-0">
                                    <div class="d-grid">
                                        <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                            <span class="material-icons material-icons-round" style="font-size: 18px !important">
                                                perm_media </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col -sm px-0">
                                    <div class="d-grid">
                                        <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                            <span class="material-icons material-icons-round" style="font-size: 18px !important"> link
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="onefit-buttons-style-light p-4">
                                <i class="fas fa-paper-plane" style="font-size: 38px !important"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ >>>>>>>>>> Tab Navigation Modal -->

    <!-- >>>>>>>>>> Latest Socials Feed Modal -->
    <div class="modal fade" id="tabLatestSocialModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tabLatestSocialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content feature-tab-nav-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fs-1" id="tabLatestSocialModalLabel">One<span style="color: #ffa500">fit.</span>Net Updates &amp; Socials</h5>
                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>
                <div class="modal-body bg-whitez border-0" style="overflow-x: hidden">
                    <!-- Latest Updates & Socials Container -->
                    <!-- Main User Profile Preview List (Main UPPL - It is hidden on screens smaller than lg) -->
                    <div class="shadow p-0" style="border-radius: 25px; background-color: #343434; overflow: hidden;" id="main-upp-list">
                        <div class="container comfortaa-font p-0 mt-2 text-white mx-4z d-nonez d-lg-blockz">
                            <!-- UPPL Header (with Banner and Profile Pic) -->
                            <div class="text-center">
                                <!--<span class="material-icons material-icons-round" style="font-size: 48px !important"> account_circle </span>-->

                                <!-- Users Profile Banner -->
                                <div class="shadow -lg m-0" style="border-radius: 30px 30px 100% 100%; height: 400px; width: 100%; overflow: hidden; background-image: url('../media/assets/fitness-colage.png'); background-position: center; background-attachment: local; background-clip: content-box; background-size: cover; border-bottom: solid 5px white;">
                                </div>
                                <!-- ./ Users Profile Banner -->

                                <!-- Profile Picture -->
                                <img src="../media/assets/One-Symbol-Logo-Two-Tone.svg" alt="Onefit Logo" class="p-3 img-fluid my-pulse-animation-darkz shadow" style="margin-top: -100px; height: 200px; border-radius: 50%; border-color: #ffa500 !important; background-color: #343434" />
                                <!-- ./ Profile Picture -->
                                <p class="mt-2 mt-4 fs-1 fw-bold comfortaa-font">One<span style="color: #ffa500;">fit</span>.app</p>
                            </div>
                            <!-- ./ UPPL Header (with Banner and Profile Pic) -->

                            <div class="row">
                                <div class="col-md">
                                    <ol class="list-group list-group-flush border-0 my-4">
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold" style="color: #ffa500">One-On-One Fitness Network&reg;</div>
                                                @OnefitNet<br />
                                                Community Growth: <br>
                                                1 Trainee (<i class="fas fa-solid fa-dash"></i> 0%)
                                            </div>
                                            <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                                                <span class="material-icons material-icons-round" style="font-size: 20px !important">
                                                    workspace_premium </span>
                                                Awards Issued
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold text-end" style="color: #ffa500">Followers</div>
                                                2 Trainees<br />
                                                6 Trainers<br />
                                                20 Groups<br />
                                                16 000 Resources<br />
                                                89 Fitness Programs<br />
                                                20 Diet Programs<br />
                                                5 Wellness Programs
                                            </div>
                                            <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px"><span class="material-icons material-icons-round" style="font-size: 20px !important"> people_alt
                                                </span> 6</span>
                                        </li>
                                    </ol>
                                </div>
                                <div class="col-md-5 text-center">
                                    <h3>Support us on Socials</h3>
                                    <div class="container-fluid">
                                        <div class="row align-items-center" style="font-size: 40px;">
                                            <div class="col m">
                                                <button class="border-0 social-link-icon-insta p-4 my-4 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                                                    <div class="d-grid gap-2">
                                                        <i class="fab fa-instagram"></i>
                                                        <p style="font-size: 10px !important;">Instagram</p>
                                                    </div>
                                                </button>
                                            </div>

                                            <div class="col">
                                                <button class="border-0 social-link-icon-twitter p-4 my-4 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                                                    <div class="d-grid gap-2">
                                                        <i class="fab fa-twitter"></i>
                                                        <p style="font-size: 10px !important;">Twitter</p>
                                                    </div>
                                                </button>
                                            </div>

                                            <div class="col">
                                                <button class="border-0 social-link-icon-fb p-4 my-4 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                                                    <div class="d-grid gap-2">
                                                        <i class="fab fa-facebook"></i>
                                                        <p style="font-size: 10px !important;">Facebook</p>
                                                    </div>
                                                </button>
                                            </div>

                                            <div class="col">
                                                <button class="border-0 social-link-icon-yt p-4 my-4 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                                                    <div class="d-grid gap-2">
                                                        <i class="fab fa-youtube"></i>
                                                        <p style="font-size: 10px !important;">Youtube</p>
                                                    </div>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="text-white">
                            <div class="row my-4">
                                <div class="col-md text-center">
                                    <h4>Twitter Feed</h4>
                                    <!-- Twitter feed -->
                                    <div class="m-4 no-scroller" style="border-radius: 25px !important; overflow-y: scroll;">
                                        <a class="twitter-timeline" href="https://twitter.com/OnefitNet?ref_src=twsrc%5Etfw">Tweets by
                                            OnefitNet</a>
                                        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                    </div>
                                    <!-- ./ Twitter feed -->
                                </div>
                                <div class="col-md text-center border-start border-end border-warning" style="border-color: #ffa500 !important;">
                                    <h4>Facebook Feed</h4>
                                    <div class="d-flex align-items-center">
                                        <div style="display: none;">
                                            <strong>Loading Facebook Feed...</strong>
                                            <div class="spinner-border text-light ms-auto" role="status" aria-hidden="true"></div>
                                        </div>

                                        <!-- Facebook feed -->
                                        <div class="fb-page" data-href="https://web.facebook.com/OnefitnetworkZA" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                            <blockquote cite="https://web.facebook.com/OnefitnetworkZA" class="fb-xfbml-parse-ignore"><a href="https://web.facebook.com/OnefitnetworkZA">One-On-One Fitness Network</a></blockquote>
                                        </div>
                                        <!-- ./ Facebook feed -->
                                    </div>
                                </div>
                                <div class="col-md text-center">
                                    <h4>Instagram Feed</h4>
                                    <div class="text-center">
                                        <div class="spinner-border text-light ms-auto" style="width: 5rem; height: 5rem;" role="status" aria-hidden="true"></div>
                                    </div>
                                </div>
                                <!--<div class="col-md">
                  <h4>Latest on YouTube</h4>
                </div>-->
                            </div>
                        </div>
                    </div>
                    <!-- ./ MainUser Profile Preview List -->
                    <!-- ./ Latest Updates & Socials Container -->
                </div>
                <div class="modal-footer border-0 d-inline-block">
                    <hr class="text-white" />
                    <div class="d-grid gap-2">
                        <button class="onefit-buttons-style-dark fs-5 fw-bold my-4 px-4 pt-4 text-center comfortaa-font border-0" type="button" data-bs-toggle="collapse" data-bs-target="#tab-nav-social-quickpost" aria-expanded="false" aria-controls="tab-nav-social-quickpost"><i class="fas fa-paper-plane"></i> | <span style="color: #fff !important">One</span><span style="color: #ffa500 !important">fit</span>.Social</button>
                    </div>

                    <div class="row align-items-end collapse no-scroller shadow" style="max-height: 50vh !important; overflow-y: auto; border-radius: 25px;" id="tab-nav-social-quickpost">
                        <div class="col-sm d-grid gap-2 py-4 px-0">
                            <!-- Quick Post to Social -->
                            <div class="social-quick-post d-grid">
                                <textarea name="" class="w-100 quick-post-input" id="" cols="30" rows="10" style="height: 40vh!important" placeholder="Share an update with the Community.">Share an update with the Community.</textarea>
                            </div>
                            <!-- ./ Quick Post to Social -->
                        </div>
                        <div class="col-sm-4 d-grid gap-2 py-4" style="overflow-x: hidden">
                            <!-- Onefit.Social Feed - Hide the feed container on screens smaller than large -->
                            <div class="onefit-social-container d-grid gap-2">
                                <button class="onefit-buttons-style-dark p-4 mb-4 shadow comfortaa-font">
                                    <span class="align-middle"> Open <br> <span class="fw-bold" style="color:#ffa500!important; font-size: 40px;">.Social</span></span> <span class="align-middle material-icons material-icons-outlined">hub</span>
                                </button>
                                <div class="mb-4 no-scroller" hidden style="max-height: 18vh; overflow-y: auto;">
                                    <?php echo $outputCommunityUpdates; ?>
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="col -sm px-0">
                                    <div class="d-grid">
                                        <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                            <span class="material-icons material-icons-round" style="font-size: 18px !important">
                                                attach_file </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col -sm px-0">
                                    <div class="d-grid">
                                        <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                            <span class="material-icons material-icons-round" style="font-size: 18px !important">
                                                perm_media </span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col -sm px-0">
                                    <div class="d-grid">
                                        <button type="button" class="onefit-buttons-style-light p-2 m-1">
                                            <span class="material-icons material-icons-round" style="font-size: 18px !important"> link
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="onefit-buttons-style-light p-4">
                                <i class="fas fa-paper-plane" style="font-size: 38px !important"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ >>>>>>>>>> Latest Socials Feed Modal -->

    <!-- >>>>>>>>>> Chat Modal -->
    <button id="toggle-messages-offcanvas" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottomOnefitChat" aria-controls="offcanvasBottomOnefitChat" hidden aria-hidden="true">Toggle Chat Messenger offcanvas</button>

    <div class="offcanvas offcanvas-bottom" style="height: 100vh !important; visibility: visible;" tabindex="-1" id="offcanvasBottomOnefitChat" aria-labelledby="offcanvasBottomOnefitChatLabel" aria-modal="true" role="dialog">
        <div class="offcanvas-body small p-0 no-scroller" style="overflow-x: hidden;">
            <div class="card text-center m-0 border-0" style="height:100vh">
                <div class="card-header bg-transparentz border-0 shadow sticky-top" style="background-color: rgb(52, 52, 52) !important; color: rgb(255, 255, 255) !important; padding-right: 25px; margin-right: -10px;">
                    <div class="offcanvas-header">
                        <button class="onefit-buttons-style-dark p-4 shadow d-grid text-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMyUserChats" aria-expanded="true" aria-controls="collapseMyUserChats">
                            <span class="material-icons material-icons-round">
                                3p
                            </span>
                            <span class="align-middle text-truncate d-none d-lg-block" style="font-size: 10px;">Conversations.</span>
                        </button>

                        <div class="text-center">
                            <h1 class="offcanvas-title" id="offcanvasBottomOnefitChatLabel">
                                Messages
                            </h1>
                        </div>

                        <!--<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>-->

                        <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="offcanvas" aria-label="Close">
                            <span class="material-icons material-icons-round"> cancel </span>
                        </button>
                    </div>
                </div>
                <div class="card-body py-0 px-4 darkpads-bg-container h-100">
                    <div class="row h-100 px-0 no-scroller" style="max-height: 70vh; overflow-y: auto !important;">
                        <div class="col-md-4 w3-animate-top collapse show" id="collapseMyUserChats">
                            <!--Users Chats List-->
                            <ul class="list-group list-group-flush text-start top-down-grad-dark" style="padding-bottom: 100px !important;">
                                <?php echo $outputProfileUserChats; ?>
                            </ul>
                            <!-- ./ Users Chats List-->
                        </div>
                        <div class="col-md shadow no-scroller my-0 p-2 text-white down-top-grad-dark" style="border-radius: 25px; overflow-y: auto; overflow-x: hidden; max-height: 70vh !important;margin-bottom: 0px !important;">
                            <div class="row align-items-center d-none" style="border-radius: 25px; background-color: #343434;">
                                <div class="col-4 d-grid gap-2">
                                    <!-- Selected Users Friend Chat Profile Strip -->
                                    <button type="button" class="onefit-buttons-style-dark p-2 my-4 position-relative">
                                        <div class="container">
                                            <div class="row align-items-center" style="min-height: 100px;">
                                                <div class="col -3 text-center">
                                                    <img src="../media/profiles/0_default/default_profile_pic.svg" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                                </div>
                                                <div class="col text-center">
                                                    <p class="fs-5 my-0 text-truncate">Visit Profile</p>
                                                </div>
                                            </div>
                                        </div>

                                        <span class="position-absolute top-0 start-100 translate-middle p-2 bg-dangerz border border-light rounded-circle my-pulse-animation-tahiti" style="background-color: #ffa500 !important;">
                                            <span class="visually-hidden">New Message Alert</span>
                                        </span>
                                    </button>
                                    <!-- ./ Selected Users Friend Chat Profile Strip -->
                                </div>
                                <div class="col text-dark">
                                    <h1>Stuff</h1>
                                </div>
                            </div>

                            <div class="no-scrollerz p-4 shadow" style="border-radius: 25px;width: 100%; height: 100%; background-color: rgba(52, 52, 52, 0.8) !important; overflow-y: auto !important; overflow-x: hidden !important;">
                                <!-- User Chat Bubble - Left (Users Friend) -->
                                <div class="row align-items-center">
                                    <div class="col-sm text-start">
                                        <div class="d-flex gap-2">
                                            <div class="text-start">
                                                <img src="../media/profiles/0_default/default_profile_pic.svg" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>

                                            <div class="talk-bubble shadow tri-right shadow btm-leftz left-top border-5 border-end border-bottom" style="border-radius: 0 25px 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 text-start"></div>
                                </div>
                                <!-- ./ User Chat Bubble - Left (Users Friend) -->

                                <!-- User Chat Bubble - Right (User) -->
                                <div class="row align-items-start">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm text-end">
                                        <div class="d-flex gap-2">
                                            <div class="talk-bubble shadow tri-right shadow btm-rightz right-top border-5 border-start border-bottom" style="border-radius: 25px 0 25px 25px !important;">
                                                <div class="talktext">
                                                    <p>And now using .round we can smooth the sides down. Also uses .btm-left to show a triangle at the bottom flush to the left.</p>
                                                </div>
                                            </div>

                                            <div class="text-end">
                                                <img src="../media/profiles/0_default/default_profile_pic.svg" class="rounded-circle shadow" style="height: 50px; width: 50px;" alt="placeholder profile pic">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./ User Chat Bubble - Right (User) -->

                                <!--Users Chat Conversation Panel-->

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 fixed-bottom down-top-grad-dark" style="padding-right: 25px;">
                    <div class="row py-4 align-items-end">
                        <div class="col-sm">
                            <textarea class="onefit-inputs-style p-4 shadow" style="border-radius: 25px !important;" name="" id="" cols="30" rows="3">Wassup, Dude?</textarea>
                        </div>
                        <div class="col-sm-2 d-grid gap-2">
                            <button class="onefit-buttons-style-dark p-4 shadow">
                                <span class="material-icons material-icons-round">
                                    try
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ >>>>>>>>>> Chat Modal -->

    <!-- Button trigger modal>>>>>>>>>> Tab Activity Tracker Capture Modal -->
    <button id="toggleTabCaptureActivityTrackerDataModalBtn" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tabCaptureActivityTrackerDataModal" hidden aria-hidden="true">
        Launch #captureactivitytracker</button>

    <!-- >>>>>>>>>> Tab Activity Tracker Capture Modal -->
    <div class="modal fade" id="tabCaptureActivityTrackerDataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tabCaptureActivityTrackerDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content feature-tab-nav-content content-panel-border-stylez">
                <!-- style="border-bottom: #ffa500 5px solid;" -->
                <div class="modal-header border-0">
                    <h5 class="modal-title align-middle" id="tabCaptureActivityTrackerDataModalLabel">
                        <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">
                            analytics
                        </span>
                        <span class=" align-middle">Capture Activity Tracking Data</span>
                    </h5>
                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>
                <hr class="text-white m-0z">
                <div class="modal-body border-0" style="overflow-x: hidden">
                    <div class="row align-items-center text-center comfortaa-font">
                        <div class="col-sm py-2 text-truncate">
                            <!--<i class="fas fa-heart"></i>-->
                            <div class="d-inline">
                                <span class="material-icons material-icons-round align-middle"> monitor_heart </span>
                                <span class="align-middle">Heart rate</span>
                            </div>

                        </div>
                        <div class="col-sm py-2 text-truncate">
                            <div class="d-inline">
                                <span class="align-middle" style="color: #ffa500">|</span>
                            </div>
                        </div>
                        <div class="col-sm py-2 text-truncate">
                            <!--<i class="fas fa-thermometer-half"></i>-->
                            <div class="d-inline">
                                <span class="material-icons material-icons-round align-middle"> device_thermostat </span>
                                <!-- Degree symbol html code: &#8451; -->
                                <span class="align-middle">Temp &#8451;</span>
                            </div>
                        </div>
                        <div class="col-sm py-2 text-center">
                            <div class="d-inline">
                                <button class="btn p-4 onefit-buttons-style-dark" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="heartrate-expand-icon heartrate-data-input-form-container">
                                    <img src="../media/assets/icons/icons8-smart-watch-50.png" alt="smartwatch" class="img-fluid mb-2" />
                                    <span class="material-icons material-icons-round my-pulse-animation-tahiti p-2">fitbit</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm py-2 text-truncate">
                            <!--<i class="fas fa-bolt"></i>-->
                            <div class="d-inline">
                                <span class="material-icons material-icons-round align-middle"> bolt </span>
                                <span class="align-middle">Speed</span>
                            </div>
                        </div>
                        <div class="col-sm py-2 text-truncate">
                            <div class="d-inline">
                                <span class="align-middle" style="color: #ffa500">|</span>
                            </div>
                        </div>
                        <div class="col-sm py-2 text-truncate">
                            <!--<i class="fas fa-walking"></i>-->
                            <div class="d-inline">
                                <span class="material-icons material-icons-round align-middle"> directions_walk </span>
                                <span class="align-middle">Steps</span>
                            </div>
                        </div>
                    </div>

                    <hr class="text-white">

                    <!-- detailed metric list -->
                    <ul class="list-group list-group-flush text-white border-0">
                        <!-- js submitting activity tracker data foms -->
                        <script>
                            function triggerSubmitActivityTrackerData(formLocation, forForm) {
                                if (forForm == "heartrate" && formLocation == "modal") {
                                    // submit heartrate activity tracker form via jquery ajax trigger
                                    document.getElementById("modal-submit-heartrate-insights-activitytracker-data-form").click();
                                } else if (forForm == "bodytemp" && formLocation == "modal") {
                                    // submit bodytemp activity tracker form via jquery ajax trigger
                                    document.getElementById("modal-submit-bodytemp-insights-activitytracker-data-form").click();
                                } else if (forForm == "speed" && formLocation == "modal") {
                                    // submit speed activity tracker form via jquery ajax trigger
                                    document.getElementById("modal-submit-speed-insights-activitytracker-data-form").click();
                                } else if (forForm == "weight" && formLocation == "modal") {
                                    // submit weight activity tracker form via jquery ajax trigger
                                    document.getElementById("modal-submit-weight-insights-activitytracker-data-form").click();
                                } else {
                                    alert("Alert: Activity Tracker form submitted - formLocation: " + formLocation + " | forForm: " + forForm);
                                }

                                if (forForm == "heartrate" && formLocation == "single") {
                                    // submit heartrate activity tracker form via jquery ajax trigger
                                    document.getElementById("single-submit-heartrate-insights-activitytracker-data-form").click();
                                } else if (forForm == "bodytemp" && formLocation == "single") {
                                    // submit bodytemp activity tracker form via jquery ajax trigger
                                    document.getElementById("single-submit-bodytemp-insights-activitytracker-data-form").click();
                                } else if (forForm == "speed" && formLocation == "single") {
                                    // submit speed activity tracker form via jquery ajax trigger
                                    document.getElementById("single-submit-speed-insights-activitytracker-data-form").click();
                                } else if (forForm == "weight" && formLocation == "single") {
                                    // submit weight activity tracker form via jquery ajax trigger
                                    document.getElementById("single-submit-weight-insights-activitytracker-data-form").click();
                                } else {
                                    alert("Alert: Activity Tracker form submitted - formLocation: " + formLocation + " | forForm: " + forForm);
                                }
                            }
                        </script>
                        <!-- ./ js submitting activity tracker data foms -->

                        <li class="list-group-item bg-transparent text-white pt-4" style="border-color: #ffa500;border-radius: 25px;">
                            <div class="row align-items-center mt-4">
                                <div class="col-xlg -4 text-center">
                                    <h1 class="text-truncate">Heart Rate</h1>
                                    <div class="d-grid gap-2 mt-4">
                                        <span class="material-icons material-icons-round">
                                            favorite
                                        </span>
                                        <h1>65<span style="font-size: 10px;" class="align-top">BPM</span></h1>
                                        <p class="text-muted fw-bold">75 BPM, 5h ago</p>
                                    </div>

                                    <!-- <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="heartrate-expand-icon heartrate-data-input-form-container">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button> -->
                                </div>
                                <div class="col-xlg -8 py-4 d-flex justify-content-center">
                                    <!-- Canvasjs chart canvas -->
                                    <!-- <canvas class="chartjs-chart-light shadow" id="heart_rate_monitor_chart" width="400" height="400"></canvas> -->
                                    <!-- ./Canvasjs chart canvas -->

                                    <!-- submit heartrate data form -->
                                    <div id="heartrate-expand-icon" class="collapsez showz multi-collapsez text-center w3-animate-bottom my-4">
                                        <span class="material-icons material-icons-round p-4" style="background-color:#ffa500;color: #343434;border-radius: 25px 0 0 25px;">
                                            add_task
                                        </span>
                                    </div>

                                    <div id="heartrate-data-input-form-container" class="d-grid justify-content-center p-4 mb-4 w3-animate-bottom border-5 border-start border-end" style="border-color: #ffa500 !important; border-radius: 25px;">
                                        <div class="align-middle comfortaa-font text-center">
                                            <span class="material-icons material-icons-round align-middle">today</span>

                                            <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                        </div>

                                        <hr class="text-white">

                                        <form id="modal-heartrate-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_heartrate.php" autocomplete="off">
                                            <div class="output-container my-2" id="output-container">
                                                <!--<?php echo $output; ?>-->
                                            </div>

                                            <div class="form-group my-4">
                                                <label for="heartrate-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                <select class="custom-select form-control-select-input p-4" name="heartrate-workout" id="heartrate-workout" placeholder="Work / Activity (Required)" required>
                                                    <option value='no-selection'>Select a workout / activity.</option>
                                                    <?php echo $workout_activities_list; ?>
                                                    <option value='other'>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="heartrate-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Heart Rate Datasource:</label>
                                                <select class="custom-select form-control-select-input p-4" name="heartrate-datasource" id="heartrate-datasource" placeholder="Datasource (Required)" required>
                                                    <option value='no-selection'>Select your datasource.</option>
                                                    <option value='datasource-1'>Fitbit waerable</option>
                                                    <option value='datasource-2'>Android wearable</option>
                                                    <option value='datasource-3'>Apple wearable</option>
                                                    <option value='datasource-4'>Treadmill</option>
                                                    <option value='datasource-5'>Electric Spin bike</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="heartrate-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your Heart Rate:</label>
                                                <input class="form-control-text-input p-4" type="number" step="1" name="heartrate-value" id="heartrate-value" placeholder="BPM" required />
                                            </div>

                                            <!-- submit btn -->
                                            <input id="modal-submit-heartrate-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                        </form>
                                        <!-- visual submit btn - heartrate form -->
                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-heartrate-btn" type="button" onclick="triggerSubmitActivityTrackerData('modal','heartrate')">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                            <span class="align-middle">Save.</span>
                                        </button>
                                        <!-- ./ visual submit btn - heartrate form -->
                                    </div>
                                    <!-- ./ submit heartrate data form -->

                                    <!-- <div id="heart_rate_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent text-white pt-4" style="border-color: #ffa500;border-radius: 25px;">
                            <div class="row align-items-center mt-4">
                                <div class="col-xlg -4 text-center">
                                    <h1 class="text-truncate">Body Temp</h1>
                                    <div class="d-grid gap-2 mt-4">
                                        <span class="material-icons material-icons-round">
                                            device_thermostat
                                        </span>
                                        <h1>36.9<span style="font-size: 10px;" class="align-top">&deg;C</span></h1>
                                        <p class="text-muted fw-bold">37.2&deg;C, 10m ago</p>
                                    </div>

                                    <!-- <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#bodytemp-data-input-form-container" aria-expanded="false" aria-controls="bodytemp-data-input-form-container">
                                        <span class="material-icons material-icons-round align-middle">
                                            add_circle_outline
                                        </span>
                                    </button> -->
                                </div>
                                <div class="col-xlg -8 py-4 d-flex justify-content-center">
                                    <!-- Canvasjs chart canvas -->
                                    <!-- <canvas class="chartjs-chart-light shadow" id="body_temp_monitor_chart" width="400" height="400"></canvas> -->
                                    <!-- ./Canvasjs chart canvas -->

                                    <!-- submit heartrate data form -->
                                    <div id="bodytemp-expand-icon" class="collapsez showz multi-collapsez text-center w3-animate-bottom my-4">
                                        <span class="material-icons material-icons-round p-4" style="background-color:#ffa500;color: #343434;border-radius: 25px 0 0 25px;">
                                            add_task
                                        </span>
                                    </div>

                                    <div id="bodytemp-data-input-form-container" class="d-grid justify-content-center p-4 mb-4 w3-animate-bottom border-5 border-start border-end" style="border-color: #ffa500 !important; border-radius: 25px;">
                                        <div class="align-middle comfortaa-font text-center">
                                            <span class="material-icons material-icons-round align-middle">today</span>

                                            <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                        </div>

                                        <hr class="text-white">

                                        <form id="modal-bodytemp-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bodytemp.php" autocomplete="off">
                                            <div class="output-container my-2" id="output-container">
                                                <!--<?php echo $output; ?>-->
                                            </div>

                                            <div class="form-group my-4">
                                                <label for="bodytemp-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                <select class="custom-select form-control-select-input p-4" name="bodytemp-workout" id="bodytemp-workout" placeholder="Work / Activity (Required)" required>
                                                    <option value='no-selection'>Select a workout / activity.</option>
                                                    <?php echo $workout_activities_list; ?>
                                                    <option value='other'>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="bodytemp-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Body Temp Monitoring Datasource:</label>
                                                <select class="custom-select form-control-select-input p-4" name="bodytemp-datasource" id="bodytemp-datasource" placeholder="Datasource (Required)" required>
                                                    <option value='no-selection'>Select your datasource.</option>
                                                    <option value='datasource-1'>Fitbit waerable</option>
                                                    <option value='datasource-2'>Android wearable</option>
                                                    <option value='datasource-3'>Apple wearable</option>
                                                    <option value='datasource-4'>Treadmill</option>
                                                    <option value='datasource-5'>Electric Spin bike</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="bodytemp-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your Body Temp:</label>
                                                <input class="form-control-text-input p-4" type="number" min="0" step="0.1" name="bodytemp-value" id="bodytemp-value" placeholder="Temperature (&deg;C)" required />
                                            </div>

                                            <!-- submit btn -->
                                            <input id="modal-submit-bodytemp-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                        </form>
                                        <!-- visual submit btn - bodytemp form -->
                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-bodytemp-btn" type="button" onclick="triggerSubmitActivityTrackerData('modal','bodytemp')">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                            <span class="align-middle">Save.</span>
                                        </button>
                                        <!-- ./ visual submit btn - bodytemp form -->
                                    </div>

                                    <!-- <div id="body_temp_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent text-white pt-4" style="border-color: #ffa500;border-radius: 25px;">
                            <div class="row align-items-center mt-4">
                                <div class="col-xlg -4 text-center">
                                    <h1 class="text-truncate">Avg. Speed</h1>
                                    <div class="d-grid gap-2 mt-4">
                                        <span class="material-icons material-icons-round">
                                            bolt
                                        </span>
                                        <h1>10<span style="font-size: 10px;" class="align-top">m/s</span></h1>
                                        <p class="text-muted fw-bold">Highest Marked Speed: 15m/s</p>
                                    </div>

                                    <!-- <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#speedmonitor-data-input-form-container" aria-expanded="false" aria-controls="">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button> -->
                                </div>
                                <div class="col-xlg -8 py-4 d-flex justify-content-center">
                                    <!-- Canvasjs chart canvas -->
                                    <!-- <canvas class="chartjs-chart-light shadow" id="speed_monitor_chart" width="400" height="400"></canvas> -->
                                    <!-- ./Canvasjs chart canvas -->

                                    <!-- submit heartrate data form -->
                                    <div id="speedmonitor-expand-icon" class="collapsez showz multi-collapsez text-center w3-animate-bottom my-4">
                                        <span class="material-icons material-icons-round p-4" style="background-color:#ffa500;color: #343434;border-radius: 25px 0 0 25px;">
                                            add_task
                                        </span>
                                    </div>

                                    <div id="speedmonitor-data-input-form-container" class="d-grid justify-content-center p-4 mb-4 w3-animate-bottom border-5 border-start border-end" style="border-color: #ffa500 !important; border-radius: 25px;">
                                        <div class="align-middle comfortaa-font text-center">
                                            <span class="material-icons material-icons-round align-middle">today</span>

                                            <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                        </div>

                                        <hr class="text-white">

                                        <form id="modal-speed-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_speed.php" autocomplete="off">
                                            <div class="output-container my-2" id="output-container">
                                                <!--<?php echo $output; ?>-->
                                            </div>

                                            <div class="form-group my-4">
                                                <label for="speed-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                <select class="custom-select form-control-select-input p-4" name="speed-workout" id="speed-workout" placeholder="Work / Activity (Required)" required>
                                                    <option value='no-selection'>Select a workout / activity.</option>
                                                    <?php echo $workout_activities_list; ?>
                                                    <option value='other'>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="speed-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Speed Mearsuring Datasource:</label>
                                                <select class="custom-select form-control-select-input p-4" name="speed-datasource" id="speed-datasource" placeholder="Datasource (Required)" required>
                                                    <option value='no-selection'>Select your datasource.</option>
                                                    <option value='datasource-1'>Fitbit waerable</option>
                                                    <option value='datasource-2'>Android wearable</option>
                                                    <option value='datasource-3'>Apple wearable</option>
                                                    <option value='datasource-4'>Treadmill</option>
                                                    <option value='datasource-5'>Electric Spin bike</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="speed-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your max Speed:</label>
                                                <input class="form-control-text-input p-4" type="number" min="0" step="0.1" name="speed-value" id="speed-value" placeholder="Speed (ms)" required />
                                            </div>

                                            <!-- submit btn -->
                                            <input id="modal-submit-speed-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                        </form>
                                        <!-- visual submit btn - speed form -->
                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-speed-btn" type="button" onclick="triggerSubmitActivityTrackerData('modal','speed')">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                            <span class="align-middle">Save.</span>
                                        </button>
                                        <!-- ./ visual submit btn - speed form -->
                                    </div>

                                    <!-- <div id="speed_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent text-white pt-4" style="border-color: #ffa500;border-radius: 25px;">
                            <div class="row align-items-center mt-4">
                                <div class="col-md -4 text-center">
                                    <h1 class="text-truncate">Step Count</h1>
                                    <div class="d-grid gap-2 my-4">
                                        <span class="material-icons material-icons-round">
                                            directions_walk
                                        </span>
                                        <h1>1896<span style="font-size: 10px;" class="align-top">Steps</span></h1>
                                        <p class="text-muted fw-bold">213 Steps remaining (Achievement)</p>
                                    </div>

                                </div>
                                <div class="col-md -8 py-4 text-center d-grid justify-content-center">
                                    <!-- Canvasjs chart canvas -->
                                    <!-- <canvas class="chartjs-chart-light shadow" id="step_counter_monitor_chart" width="400" height="400"></canvas> -->
                                    <!-- ./Canvasjs chart canvas -->

                                    <img src="../media/assets/smartwatches/branding/fitbit-png-logo-white.png" class="img-fluid mt-4 mb-2" style="max-height: 100px;" alt="fitbit logo">
                                    <p class="comfortaa-font">Connect your Fitbit activity tracker / smartwatch</p>

                                    <!-- <div id="step_counter_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item bg-transparent text-white pt-4" style="border-color: #ffa500;border-radius: 25px;">
                            <div class="row align-items-center mt-4">
                                <div class="col-xlg -4 text-center">
                                    <h1 class="text-truncate">Weight & (BMI)</h1>
                                    <div class="d-grid gap-2 mt-4">
                                        <span class="material-icons material-icons-round">
                                            monitor_weight
                                        </span>
                                        <h1>60<span style="font-size: 10px;" class="align-top">kg</span></h1>
                                        <p class="text-muted fw-bold">75kg, 1w ago</p>
                                    </div>

                                    <!-- <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" style="border-radius: 25px !important;" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="bmiweight-expand-icon bmiweight-data-input-form-container">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                        </button> -->
                                </div>
                                <div class="col-xlg -8 py-4 d-flex justify-content-center">
                                    <!-- Canvasjs chart canvas -->
                                    <!-- <canvas class="chartjs-chart-light shadow" id="bmi_weight_monitor_chart" width="400" height="400"></canvas> -->
                                    <!-- ./Canvasjs chart canvas -->

                                    <!-- submit heartrate data form -->
                                    <div id="bmiweight-expand-icon" class="collapsez showz multi-collapsez text-center w3-animate-bottom my-4">
                                        <span class="material-icons material-icons-round p-4" style="background-color:#ffa500;color: #343434;border-radius: 25px 0 0 25px;">
                                            add_task
                                        </span>
                                    </div>

                                    <div id="bmiweight-data-input-form-container" class="d-grid justify-content-center p-4 mb-4 w3-animate-bottom border-5 border-start border-end" style="border-color: #ffa500 !important; border-radius: 25px;">
                                        <div class="align-middle comfortaa-font text-center">
                                            <span class="material-icons material-icons-round align-middle">today</span>

                                            <span class="align-middle fw-bold">17 Oct 2022 | 13:04</span>
                                        </div>

                                        <hr class="text-white">

                                        <form id="modal-weight-insights-activitytracker-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/activity_tracker_stats_admin/user_capture_stats_bmiweight.php" autocomplete="off">
                                            <div class="output-container my-2" id="output-container">
                                                <!--<?php echo $output; ?>-->
                                            </div>

                                            <div class="form-group my-4">
                                                <label for="weight-workout" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                                                <select class="custom-select form-control-select-input p-4" name="weight-workout" id="weight-workout" placeholder="Work / Activity (Required)" required>
                                                    <option value='no-selection'>Select a workout / activity.</option>
                                                    <?php echo $workout_activities_list; ?>
                                                    <option value='other'>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="weight-datasource" class="comfortaa-font fs-5" style="color: #ffa500;">2. Weight Monitoring Datasource:</label>
                                                <select class="custom-select form-control-select-input p-4" name="weight-datasource" id="weight-datasource" placeholder="Datasource (Required)" required>
                                                    <option value='no-selection'>Select your datasource.</option>
                                                    <option value='datasource-1'>Fitbit waerable</option>
                                                    <option value='datasource-2'>Android wearable</option>
                                                    <option value='datasource-3'>Apple wearable</option>
                                                    <option value='datasource-4'>Treadmill</option>
                                                    <option value='datasource-5'>Electric Spin bike</option>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="weight-value" class="comfortaa-font fs-5" style="color: #ffa500;">3. Please provide your current Weight:</label>
                                                <input class="form-control-text-input p-4" type="number" min="0" step="0.1" name="weight-value" id="weight-value" placeholder="Weight (kg)" required />
                                            </div>

                                            <!-- submit btn -->
                                            <input id="modal-submit-weight-insights-activitytracker-data-form" type="submit" value="submit" hidden aria-hidden="true">

                                        </form>
                                        <!-- visual submit btn - bmiweight form -->
                                        <button class="btn p-4 mt-4 onefit-buttons-style-tahiti" id="visual-submit-weight-btn" type="button" onclick="triggerSubmitActivityTrackerData('modal','weight')">
                                            <span class="material-icons material-icons-round align-middle">
                                                add_circle_outline
                                            </span>
                                            <span class="align-middle">Save.</span>
                                        </button>
                                        <!-- ./ visual submit btn - bmiweight form -->
                                    </div>

                                    <!-- <div id="weight_monitor_chart" class="shadow no-scroller bg-white p-4z" style="border-radius: 25px !important; overflow: hidden; overflow-x: auto !important;"></div> -->
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- ./ detailed metric list -->

                </div>
            </div>
        </div>
    </div>
    <!-- ./ >>>>>>>>>> Tab Activity Tracker Capture Modal -->

    <!-- Button trigger modal>>>>>>>>>> Tab Edit weekly training schedule for Teams Modal -->
    <button id="toggleTabeditWeeklyTeamsTrainingScheduleModalBtn" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tabeditWeeklyTeamsTrainingScheduleModal" hidden aria-hidden="true">
        Launch #editWeeklyTeamsTrainingSchedule</button>

    <!-- >>>>>>>>>> Tab Edit weekly training schedule for Teams Modal -->
    <div class="modal fade" id="tabeditWeeklyTeamsTrainingScheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tabeditWeeklyTeamsTrainingScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content feature-tab-nav-content content-panel-border-stylez">
                <!-- style="border-bottom: #ffa500 5px solid;" -->
                <div class="modal-header border-0">
                    <h5 class="modal-title align-middle" id="tabeditWeeklyTeamsTrainingScheduleModalLabel">
                        <span class="material-icons material-icons-round align-middle" style="color: #ffa500;">
                            edit_calendar
                        </span>
                        <span id="tabeditWeeklyTeamsTrainingScheduleModalLabelText" class="align-middle">Edit weekly training schedule</span>
                    </h5>
                    <button type="button" class="onefit-buttons-style-danger p-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="material-icons material-icons-round"> cancel </span>
                    </button>
                </div>
                <hr class="text-white m-0z">
                <div id="tabEditWeeklyTeamsTrainingScheduleModal_body" class="modal-body border-0" style="overflow-x: hidden">
                    <div class="row px-4 align-items-end">
                        <div id="display-activity-bar-preview" class="col-md-4 p-4 text-center">
                            <!-- display activity bar here -->
                        </div>
                        <div class="col-md-8">
                            <form id="teams-add-new-day-activity-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/system_admin/team_athletics_data/submit/teams_add_new_activity_day_form_submit.php" autocomplete="off">
                                <div class="form-group my-4">
                                    <label for="activity-title" class="comfortaa-font fs-5 text-start" style="color: #ffa500;">Activity title:</label>
                                    <input class="form-control-text-input p-4" type="text" name="activity-title" id="activity-title" placeholder="Activity Title (Required)" required />
                                </div>
                                <div class="form-group my-4">
                                    <label for="rpe" class="comfortaa-font fs-5 text-start" style="color: #ffa500;">RPE:</label>
                                    <input class="form-control-text-input p-4" type="number" name="rpe" id="rpe" placeholder="RPE (Required)" required />
                                </div>
                                <div class="form-group my-4">
                                    <h5 class="text-start" style="color: #ffa500;">Assign an icon:</h5>
                                    <div class="input-group gap-2 chart-col-bar-item" style="transform: scale(1,1) !important;">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-cycling" value="../media/assets/icons/cycling.png">
                                            <label class="form-check-label" for="activity-icon-cycling">
                                                <img src="../media/assets/icons/cycling.png" alt="cycling/spinning" style="height: 50px; width: auto"> Cycling / Spinning
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-strength" value="../media/assets/icons/bodybuilder.png">
                                            <label class="form-check-label" for="activity-icon-strength">
                                                <img src="../media/assets/icons/bodybuilder.png" alt="strength" style="height: 50px; width: auto"> Strength
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-icebath" value="../media/assets/icons/bath-tub.png">
                                            <label class="form-check-label" for="activity-icon-icebath">
                                                <img src="../media/assets/icons/bath-tub.png" alt="ice bath" style="height: 50px; width: auto"> Ice bath
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-running" value="../media/assets/icons/running.png">
                                            <label class="form-check-label" for="activity-icon-running">
                                                <img src="../media/assets/icons/running.png" alt="running" style="height: 50px; width: auto"> Running
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-tactics" value="../media/assets/icons/thinking.png">
                                            <label class="form-check-label" for="activity-icon-tactics">
                                                <img src="../media/assets/icons/thinking.png" alt="tactics" style="height: 50px; width: auto"> Tactics
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-kickoff" value="../media/assets/icons/soccer-ball.png">
                                            <label class="form-check-label" for="activity-icon-kickoff">
                                                <img src="../media/assets/icons/soccer-ball.png" alt="kick-off" style="height: 50px; width: auto"> Kick-off
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-multidir" value="../media/assets/icons/directions.png">
                                            <label class="form-check-label" for="activity-icon-multidir">
                                                <img src="../media/assets/icons/directions.png" alt="multi-directional" style="height: 50px; width: auto"> Multi-directional
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group my-4">
                                    <label for="activity-select" class="comfortaa-font fs-5 text-start" style="color: #ffa500;">1. Workout / Activity:</label>
                                    <select class="custom-select form-control-select-input p-4" name="activity-selectt" id="activity-select" required>
                                        <option value='no-selection'>Select a workout / activity.</option>
                                        $workout_activities_list
                                        <option value='specified'>Specify</option>
                                    </select>
                                </div>
                                <!-- submit btn -->
                                <button id="submit-teams-add-new-day-activity-data-form" class="btn onefit-buttons-style-tahiti p-4" type="submit" value="submit">
                                    <span class="material-icons material-icons-round align-middle"> add_circle </span>
                                    <span class="align-middle">Add.</span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ./ >>>>>>>>>> Tab Edit weekly training schedule for Teams Modal -->

    <!-- Button trigger modal>>>>>>>>>> Insights Interactions: Physical Assessment Modal -->
    <button id="show-interaction-modal-btn" class="onefit-buttons-style-light p-4 my-2 text-center shadow" type="button" data-bs-toggle="modal" data-bs-target="#trainingInteractionsContentModal" hidden>
        <span class="align-middle poppins-font"> Show Interactions Modal</span>
    </button>

    <!-- Version 1 -->
    <div class="modal fade" id="trainingInteractionsContentModal" tabindex="-1" aria-labelledby="trainingInteractionsContentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="color: #fff; background-color: #343434!important;">
                <div class="modal-header bg-transparent p-4 border-5 border-bottom top-down-grad-tahiti w3-animate-top" style="border-radius: 0 0 25px 25px !important;border-color: var(--tahitigold)!important;">
                    <button type="button" class="onefit-buttons-style-light p-4 shadow w3-animate-left" data-bs-dismiss="modal">
                        <div class="d-grid">
                            <span class="material-icons material-icons-round align-middle" style="font-size: 30px!important;">arrow_back</span>
                            <span class="align-middle d-none d-lg-block" style="font-size: 10px !important;"> Back.</span>
                        </div>
                    </button>

                    <h1 class="modal-title fs-3 text-white text-truncate text-center my-0 w3-animate-right" id="trainingInteractionsContentModalLabel">
                        <span class="material-icons material-icons-round align-middle">shuffle_on</span>
                        <span class="align-middle d-none d-md-block"> Interaction Title.</span>
                    </h1>

                    <button type="button" class="onefit-buttons-style-light p-4 shadow w3-animate-right" data-bs-dismiss="modal">
                        <div class="d-grid">
                            <span class="material-icons material-icons-round align-middle" style="font-size: 30px!important;">support_agent</span>
                            <span class="align-middle d-none d-lg-block" style="font-size: 10px !important;"> Trainer.</span>
                        </div>
                    </button>
                </div>
                <div id="interactionsContentContainer" class="modal-body w3-animate-right">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <p class="text-center comfortaa-font">Loading. Please wait.</p>
                </div>
                <div class="modal-footer justify-content-between border-5 border-top d-none" style="border-radius: 25px 25px 0 0 !important;">
                    <!-- <button type="button" class="onefit-buttons-style-dark p-2 px-4 shadow" data-bs-dismiss="modal">
                        <span class="material-icons material-icons-round align-middle">arrow_back</span>
                        <span class="align-middle"> Close</span>
                    </button>

                    <button type="button" class="onefit-buttons-style-dark p-4 shadow">
                        <span class="align-middle">Save changes </span>
                        <span class="material-icons material-icons-round align-middle">add_circle</span>
                    </button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Insights Interactions: Training Drills Modal -->
    <!-- <div class="modal fade" id="trainingDrillsModal" tabindex="-1" aria-labelledby="trainingDrillsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="color: #fff; background-color: #343434!important;">
                <div class="modal-header p-5 border-5 border-bottom down-top-grad-white" style="border-radius: 0 0 25px 25px !important;border-color: var(--tahitigold)!important;">
                    <button type="button" class="onefit-buttons-style-dark p-4 shadow" data-bs-dismiss="modal">
                        <span class="material-icons material-icons-round align-middle" style="font-size: 30px!important;">arrow_back</span>
                        <span class="align-middle"> Close</span>
                    </button>

                    <h1 class="modal-title fs-1 text-dark" id="trainingDrillsModalLabel">
                        <span class="material-icons material-icons-round align-middle">shuffle_on</span>
                        <span class="align-middle"> Training Drills &amp; Workouts.</span>
                    </h1>
                </div>
                <div class="modal-body">
                    

                </div>
                <div class="modal-footer justify-content-between border-5 border-top d-none" style="border-radius: 25px 25px 0 0 !important;">
                    <button type="button" class="onefit-buttons-style-dark p-2 px-4 shadow" data-bs-dismiss="modal">
                        <span class="material-icons material-icons-round align-middle">arrow_back</span>
                        <span class="align-middle"> Close</span>
                    </button>

                    <button type="button" class="onefit-buttons-style-dark p-4 shadow">
                        <span class="align-middle">Save changes </span>
                        <span class="material-icons material-icons-round align-middle">add_circle</span>
                    </button>
                </div>
            </div>
        </div>
    </div> -->

    <!-- ./ Insights Interactions: Training Drills Modal -->

    <!-- Insights Interactions: Physical Assessment Modal -->
    <!-- <div class="modal fade" id="phyisicalAssessmentModal" tabindex="-1" aria-labelledby="phyisicalAssessmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="color: #fff; background-color: #343434!important;">
                <div class="modal-header p-5 border-5 border-bottom" style="border-radius: 0 0 25px 25px !important;"> -->
    <!-- <div class="d-flex justify-content-between">
                        
                    </div> -->
    <!-- <h1 class="modal-title fs-1" id="phyisicalAssessmentModalLabel">
                        <span class="material-icons material-icons-round align-middle">personal_injury</span>
                        <span class="align-middle"> Physical Assessment</span>
                    </h1> -->

    <!-- <div class="row align-items-center">
                        <div class="col">
                            
                        </div>
                        <div class="col text-center">
                            <img src="../media/assets/One-Symbol-Logo-White.svg" alt="onefit logo" style="max-height: 50px;" class="img-fluid my-4 shadow">
                        </div>
                        <div class="col">
                            <button type="button" class="onefit-buttons-style-dark p-4 shadow">
                                <span class="material-icons material-icons-round align-middle">support_agent</span>
                                <span class="align-middle"> Trainer Support.</span>
                            </button>
                        </div>
                    </div> -->
    <!-- </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer justify-content-between border-5 border-top" style="border-radius: 25px 25px 0 0 !important;">
                    <button type="button" class="onefit-buttons-style-danger p-4 shadow" data-bs-dismiss="modal">
                        <span class="material-icons material-icons-round align-middle">cancel</span>
                        <span class="align-middle"> Close</span>
                    </button>

                    <div style="max-width: 60vw">
                        <p class="fs-5 fw-bold text-center">Rate your Muscle Soreness according to the scale below:</p>
                        <img src="../media/assets/Muscle Sorness Rating Scale.png" alt="Muscle Soreness Rating Scale" style="border-radius: 15px;" class="img-fluid mb-4 shadow">
                    </div>

                    <button type="button" class="onefit-buttons-style-dark p-4 shadow">
                        <span class="align-middle"> Save changes</span>
                        <span class="material-icons material-icons-round align-middle">add_circle</span>
                    </button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- ./ Insights Interactions: Physical Assessment Modal -->

    <!-- Insights Interactions: Nutrition Board Modal -->
    <!-- <div class="modal fade" id="nutritionBoardModal" tabindex="-1" aria-labelledby="nutritionBoardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="color: #fff; background-color: #343434!important;">
                <div class="modal-header p-5 border-5 border-bottom" style="border-radius: 0 0 25px 25px !important;">
                    <h1 class="modal-title fs-1" id="nutritionBoardModalLabel">
                        <span class="material-icons material-icons-round align-middle">developer_board</span>
                        <span class="align-middle"> Nutrition Board.</span>
                    </h1>
                </div>
                <div class="modal-body">

                    
                </div>
                <div class="modal-footer justify-content-between border-5 border-top" style="border-radius: 25px 25px 0 0 !important;">
                    <button type="button" class="onefit-buttons-style-danger p-4 shadow" data-bs-dismiss="modal">
                        <span class="material-icons material-icons-round align-middle">cancel</span>
                        <span class="align-middle"> Close</span>
                    </button>

                    <button type="button" class="onefit-buttons-style-dark p-4 shadow">
                        <span class="align-middle"> Save changes</span>
                        <span class="material-icons material-icons-round align-middle">add_circle</span>
                    </button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- ./ Insights Interactions: Nutrition Board Modal -->

    <!-- Insights Interactions: Administration: Creation Tools Modal -->
    <!-- <div class="modal fade" id="creationToolsModal" tabindex="-1" aria-labelledby="creationToolsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="color: #fff; background-color: #343434!important;">
                <div class="modal-header p-5 border-5 border-bottom" style="border-radius: 0 0 25px 25px !important;">
                    <h1 class="modal-title fs-1" id="creationToolsModalLabel">
                        <span class="material-icons material-icons-round align-middle">brush</span>
                        <span class="align-middle"> Creation Tools.</span>
                    </h1>
                </div>
                <div class="modal-body">
                    

                </div>
                <div class="modal-footer justify-content-between border-5 border-top" style="border-radius: 25px 25px 0 0 !important;">
                    <button type="button" class="onefit-buttons-style-danger p-4 shadow" data-bs-dismiss="modal">
                        <span class="material-icons material-icons-round align-middle">cancel</span>
                        <span class="align-middle"> Close</span>
                    </button>

                    <button type="button" class="onefit-buttons-style-dark p-4 shadow">
                        <span class="align-middle"> Save changes</span>
                        <span class="material-icons material-icons-round align-middle">add_circle</span>
                    </button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- ./ Insights Interactions: Administration: Creation Tools Modal -->

    <!-- Insights Interactions: Administration: Data Management Tools Modal -->
    <!-- <div class="modal fade" id="dataMgmtToolsModal" tabindex="-1" aria-labelledby="dataMgmtToolsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="color: #fff; background-color: #343434!important;">
                <div class="modal-header p-5 border-5 border-bottom" style="border-radius: 0 0 25px 25px !important;">
                    <h1 class="modal-title fs-1" id="dataMgmtToolsModalLabel">
                        <span class="material-icons material-icons-round align-middle">account_tree</span>
                        <span class="align-middle"> Data Management.</span>
                    </h1>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            Data Managemeht Options
                        </div>
                        <div class="col-md border-1 border-start border-end border-white">
                            Load table data and lists (preview window)
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between border-5 border-top" style="border-radius: 25px 25px 0 0 !important;">
                    <button type="button" class="onefit-buttons-style-danger p-4 shadow" data-bs-dismiss="modal">
                        <span class="material-icons material-icons-round align-middle">cancel</span>
                        <span class="align-middle"> Close</span>
                    </button>

                    <button type="button" class="onefit-buttons-style-dark p-4 shadow">
                        <span class="align-middle"> Save changes</span>
                        <span class="material-icons material-icons-round align-middle">add_circle</span>
                    </button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- ./ Insights Interactions: Administration: Data Management Modal -->


    <!-- ./ Modals ----------------------------------------------------------------------------------------- -->

    <script>
        // initialize global activity tracker chart objects
        // initialize activity tracking charts
        // Note: changes to the plugin code is not reflected to the chart, because the plugin is loaded at chart construction time and editor changes only trigger an chart.update().
        Chart.defaults.font.size = 12; // global setting to change font size on all charts
        Chart.defaults.font.family = "'Poppins', sans-serif"; // global setting to change font family on all charts
        const plugin = {
            id: 'custom_canvas_background_color',
            beforeDraw: (chart) => {
                const {
                    ctx
                } = chart;
                ctx.save();
                ctx.globalCompositeOperation = 'destination-over';
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, chart.width, chart.height);
                ctx.restore();
            }
        };

        // function for converting chart time default format to 12 hr format
        function formatAMPM(date) {
            var paramDate = new Date(date);
            console.log("Received param date: " + paramDate);
            var hours = paramDate.getHours();
            var minutes = paramDate.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }

        // retrying Chartjs shenanigans
        var heartrateCTX = document.getElementById("heart_rate_monitor_chart").getContext("2d");
        var bodytempCTX = document.getElementById("body_temp_monitor_chart").getContext("2d");
        var speedCTX = document.getElementById("speed_monitor_chart").getContext("2d");
        var stepsCTX = document.getElementById("step_counter_monitor_chart").getContext("2d");
        var bmiweightCTX = document.getElementById("bmi_weight_monitor_chart").getContext("2d");

        // initialize the charts
        var heartRateChart = new Chart(heartrateCTX, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: "My First dataset",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: [],
                    spanGaps: false,
                }]
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Beats Per Minute (BPM) '
                        }
                    },
                    x: {
                        // type: 'time',
                        title: {
                            display: true,
                            text: 'Time'
                        },
                        ticks: {
                            // convert uct to 12 hr using func formatAMPM()
                            // callback: function(value, index, ticks) {
                            //     // var hr = (new Date()).getHours(); //get hours of the day in 24Hr format (0-23)

                            //     console.log("Test: Heart Rate Chart: ticks parameter output:");
                            //     console.log(ticks);

                            //     // return value + ' ' + am_pm;
                            //     return formatAMPM(new Date(value));
                            // },
                            autoSkip: false,
                            maxRotation: 40,
                            minRotation: 40
                        }
                    }
                },
                layout: {
                    padding: 40
                },
                legend: {
                    display: true,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    },
                    position: 'bottom',
                }
            },
            plugins: [plugin]
        });

        var bodyTempChart = new Chart(bodytempCTX, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: "My First dataset",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: [],
                    spanGaps: false,
                }]
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Temperature (°C)',
                        }
                    },
                    x: {
                        // type: 'time',
                        title: {
                            display: true,
                            text: 'Time'
                        },
                        ticks: {
                            // convert uct to 12 hr using func formatAMPM()
                            // callback: function(value, index, ticks) {
                            //     // var hr = (new Date()).getHours(); //get hours of the day in 24Hr format (0-23)

                            //     // return value + ' ' + am_pm;
                            //     return formatAMPM(new Date(value));
                            // },
                            autoSkip: false,
                            maxRotation: 40,
                            minRotation: 40
                        }
                    }
                },
                layout: {
                    padding: 40
                },
                legend: {
                    display: true,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    },
                    position: 'bottom',
                }
            },
            plugins: [plugin]
        });

        var speedChart = new Chart(speedCTX, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: "My First dataset",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: [],
                    spanGaps: false,
                }]
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Speed - Meters Per Second (m/s)'
                        }
                    },
                    x: {
                        // type: 'time',
                        title: {
                            display: true,
                            text: 'Time'
                        },
                        ticks: {
                            // convert uct to 12 hr using func formatAMPM()
                            // callback: function(value, index, ticks) {
                            //     // var hr = (new Date()).getHours(); //get hours of the day in 24Hr format (0-23)

                            //     // return value + ' ' + am_pm;
                            //     return formatAMPM(new Date(value));
                            // },
                            autoSkip: false,
                            maxRotation: 40,
                            minRotation: 40
                        }
                    }
                },
                layout: {
                    padding: 40
                },
                legend: {
                    display: true,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    },
                    position: 'bottom',
                }
            },
            plugins: [plugin]
        });

        var stepCountChart = new Chart(stepsCTX, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: "My First dataset",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: [],
                    spanGaps: false,
                }]
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Steps taken'
                        }
                    },
                    x: {
                        // type: 'time',
                        title: {
                            display: true,
                            text: 'Time'
                        },
                        ticks: {
                            // convert uct to 12 hr using func formatAMPM()
                            // callback: function(value, index, ticks) {
                            //     // var hr = (new Date()).getHours(); //get hours of the day in 24Hr format (0-23)

                            //     // return value + ' ' + am_pm;
                            //     return formatAMPM(new Date(value));
                            // },
                            autoSkip: false,
                            maxRotation: 40,
                            minRotation: 40
                        }
                    }
                },
                layout: {
                    padding: 40
                },
                legend: {
                    display: true,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    },
                    position: 'bottom',
                }
            },
            plugins: [plugin]
        });

        var bmiWeightChart = new Chart(bmiweightCTX, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: "My First dataset",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: [],
                    spanGaps: false,
                }]
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Body weight - kilograms (kg)'
                        }
                    },
                    x: {
                        // type: 'time',
                        title: {
                            display: true,
                            text: 'Date / Time'
                        },
                        ticks: {
                            // convert uct to 12 hr using func formatAMPM()
                            // callback: function(value, index, ticks) {
                            //     // var hr = (new Date()).getHours(); //get hours of the day in 24Hr format (0-23)

                            //     // return value + ' ' + am_pm;
                            //     return formatAMPM(new Date(value));
                            // },
                            autoSkip: false,
                            maxRotation: 40,
                            minRotation: 40
                        }
                    }
                },
                layout: {
                    padding: 40
                },
                legend: {
                    display: true,
                    labels: {
                        color: 'rgb(255, 99, 132)'
                    },
                    position: 'bottom',
                }
            },
            plugins: [plugin]
        });

        // sync data stored in local storage with remote storage for specified chartObj
        function syncUserActivityTrackerChart(chartObj, usernm, chartName, data, rangeDate) {
            // in-case nothing is passwed to the data parameter, it will be evaluated to {}
            var data = data || {};

            // set the rangeDate to todays date if it was not passed as a parameter
            const timeElapsed = Date.now('yyyy-MM-dd');
            const today = new Date(timeElapsed);
            var rangeDate = rangeDate || today.toLocaleDateString('en-US');

            console.log("rangeDateParam: \n" + rangeDate);

            // users.filter(it => new RegExp('oli', "i").test(it.name));

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;

                    if (output.startsWith("error")) {
                        // provide user with error message
                        // alert(output);
                        console.log("An error has occured: \n" + output);
                    } else {
                        let chartData = JSON.parse(output);
                        console.log("Parsed JSON for " + chartName + ": \n" + output);

                        // let date = chartData.map(
                        //     function(index) {
                        //         return index.date;
                        //     }
                        // )

                        // console.log(date);

                        // let time = chartData.map(
                        //     function(index) {
                        //         return index.time;
                        //     }
                        // )

                        // console.log(time);

                        // users.filter(it => it.name.includes('oli'));

                        // get date specified in rangeDate parameter
                        let dataFilterdWithRangeDateParam = chartData.filter(
                            function(index) {
                                // return new RegExp(rangeDate, "i").test(index.date);
                                // return index.date.includes(rangeDate);
                                // return index.date;

                                var hitDates = index.date || {};
                                // extract all date strings
                                hitDates = Object.keys(hitDates);
                                // improvement: use some. this is an improment because .map()
                                // and .filter() are walking through all elements.
                                // .some() stops this process if one item is found that returns true in the callback function and returns true for the whole expression
                                hitDateMatchExists = hitDates.some(function(dateStr) {
                                    var date = new Date(dateStr);
                                    return date = rangeDate;
                                });
                                return hitDateMatchExists;
                            }
                        )

                        console.log("syncUserActivityTrackerChart(...) --> JSON Data filtered with the rangeDate Parameter \n" + dataFilterdWithRangeDateParam);

                        let date = dataFilterdWithRangeDateParam.map(
                            function(index) {
                                return index.date;
                            }
                        )

                        console.log("date data: \n" + date);

                        let time = dataFilterdWithRangeDateParam.map(
                            function(index) {
                                // return index.time;
                                console.log("time map: " + index.time);
                                return formatAMPM(rangeDate + " " + index.time);
                            }
                        )

                        console.log("time data: \n" + time);


                        // test: use predefined x-axis labels/series instead of mapped time series
                        predTimeSeries = [
                            ['00:00:00', rangeDate], '02:00:00', '04:00:00',
                            '06:00:00', '08:00:00', '10:00:00',
                            '12:00:00', '14:00:00', '16:00:00',
                            '18:00:00', '20:00:00', '22:00:00'

                        ];

                        // output the returned data
                        switch (chartName) {
                            case "heart_rate_monitor_chart":
                                // let chartData = JSON.parse(output);

                                // let bpm = chartData.map(
                                //     function(index) {
                                //         return index.bpm;
                                //     }
                                // )

                                // let bpm = chartData.map(
                                //     function(index) {
                                //         return index.bpm;
                                //     }
                                // )

                                let bpm = dataFilterdWithRangeDateParam.map(
                                    function(index) {
                                        return index.bpm;
                                    }
                                )

                                console.log("heartratebpm data: \n" + bpm);

                                chartObj.data.labels = time;
                                // chartObj.data.labels = predTimeSeries;
                                chartObj.data.datasets[0].label = "Heart rate - BPM";
                                chartObj.data.datasets[0].data = bpm;
                                chartObj.update();
                                break;
                            case "body_temp_monitor_chart":

                                // let temperature = chartData.map(
                                //     function(index) {
                                //         return index.temperature;
                                //     }
                                // )

                                let temperature = dataFilterdWithRangeDateParam.map(
                                    function(index) {
                                        return index.temperature;
                                    }
                                )

                                console.log("body temp data: \n" + temperature);

                                // Uncaught ReferenceError: bodyTempChart is not defined at xhttp.onreadystatechange (?userauth=true:8624:33)
                                chartObj.data.labels = time;
                                // chartObj.data.labels = predTimeSeries;
                                chartObj.data.datasets[0].label = "Body Temperature - °C";
                                chartObj.data.datasets[0].data = temperature;
                                chartObj.update();
                                break;
                            case "speed_monitor_chart":

                                // let speed = chartData.map(
                                //     function(index) {
                                //         return index.speed;
                                //     }
                                // )

                                let speed = dataFilterdWithRangeDateParam.map(
                                    function(index) {
                                        return index.speed;
                                    }
                                )

                                console.log("speed data: \n" + speed);


                                // chartObj.data.labels = time;
                                // chartObj.data.labels = predTimeSeries;
                                chartObj.data.labels = date;
                                chartObj.data.datasets[0].label = "A-B Acceleration / Speed - m/s";
                                chartObj.data.datasets[0].data = speed;
                                chartObj.update();
                                break;
                            case "step_counter_monitor_chart":

                                // let steps = chartData.map(
                                //     function(index) {
                                //         return index.steps;
                                //     }
                                // )

                                let steps = dataFilterdWithRangeDateParam.map(
                                    function(index) {
                                        return index.steps;
                                    }
                                )

                                console.log("step count data: \n" + steps);


                                // chartObj.data.labels = time;
                                // chartObj.data.labels = predTimeSeries;
                                chartObj.data.labels = date;
                                chartObj.data.datasets[0].label = "Step counter";
                                chartObj.data.datasets[0].data = steps;
                                chartObj.update();
                                break;
                            case "bmi_weight_monitor_chart":

                                // let bmi = chartData.map(
                                //     function(index) {
                                //         return index.bmi;
                                //     }
                                // )

                                let bmi = dataFilterdWithRangeDateParam.map(
                                    function(index) {
                                        return index.bmi;
                                    }
                                )

                                console.log("bmi data: \n" + bmi);

                                // let weight = chartData.map(
                                //     function(index) {
                                //         return index.weight;
                                //     }
                                // )

                                let weight = dataFilterdWithRangeDateParam.map(
                                    function(index) {
                                        return index.weight;
                                    }
                                )

                                console.log("bmi - weight data: \n" + weight);


                                // chartObj.data.labels = time;
                                // chartObj.data.labels = predTimeSeries;
                                chartObj.data.labels = date;
                                chartObj.data.datasets[0].label = "Weight & BMI";
                                chartObj.data.datasets[0].data = bmi;
                                chartObj.update();
                                break;

                            default:
                                alert("Activity Tracker Chart Update Error \nNo chart passed to function.");
                                console.log("Activity Tracker Chart Update Error \nNo chart passed to function.");
                                break;
                        }
                    }

                }
            };
            xhttp.open("GET", "../scripts/php/main_app/compile_content/fitness_insights_tab/activity_tracking/get_user_stats_activity_tracker.php?forchart=" + chartName + "&u=" + usernm, true);
            xhttp.send();
        }


        function initializeContent(auth, usernm) {
            if (auth = true) {
                //call all client functions
                //alert("auth = true | User: " + usernm);
                loadActivityCalender();
                getCurrentWeekStartEndDates();

                // loadUserProfile();
                // loadUserSocials();
                // loadUserChallenges();
                // loadUserChat();
                // loadUserFriends();
                // loadUserGroups();
                // loadUserMedia();
                // loadUserNotifications();
                // loadUserPref();
                // loadUserSaves();
                // loadUserGroups();
                // loadCommunityUpdates()
                // loadCommunityGroups();
                // loadCommunityNews();
                // loadCommunityAchievements();
                // loadCommunityEvents();
                // loadCommunityMedia();
                // loadCommunityResources();
                // loadCommunityRewards();
            } else {
                //call guest applicable functions
                alert("auth = false | User: " + usernm);
                // loadCommunityUpdates()
                // loadCommunityGroups();
                // loadCommunityNews();
                // loadCommunityAchievements();
                // loadCommunityEvents();
                // loadCommunityMedia();
                // loadCommunityResources();
                // loadCommunityRewards();
            }

            // check if current_app_tab is set and has a value in localStorage, else set default value: TabHome
            const currentAppTab = localStorage.getItem('current_app_tab');

            if (currentAppTab) {
                var tabName = currentAppTab;
                console.log('Current App Tab: ' + currentAppTab);
                // display the current app tab app-dashboard-btn
                if (tabName == "TabHome") {
                    document.getElementById("app-dashboard-btn").click();
                } else if (tabName == "TabProfile") {
                    document.getElementById("app-profile-btn").click();
                } else if (tabName == "TabDiscovery") {
                    document.getElementById("app-discovery-btn").click();
                } else if (tabName == "TabStudio") {
                    document.getElementById("app-studio-btn").click();
                } else if (tabName == "TabStore") {
                    document.getElementById("app-store-btn").click();
                }
                // else if (tabName == "TabSocial") {
                //     document.getElementById("app-social-btn").click();
                // } 
                else if (tabName == "TabData") {
                    document.getElementById("app-insights-btn").click();
                } else if (tabName == "TabAchievements") {
                    document.getElementById("app-achievements-btn").click();
                } else if (tabName == "TabMedia") {
                    document.getElementById("app-media-btn").click();
                } else if (tabName == "TabCommunication") {
                    document.getElementById("app-comms-btn").click();
                } else if (tabName == "TabSettings") {
                    document.getElementById("app-preferences-btn").click();
                }

            } else {
                console.log('Current App Tab not set.');
                // set default value: TabHome
                localStorage.setItem("current_app_tab", "TabHome");
            }

            // hide the loading curtain
            var curtain = document.getElementById("LoadCurtain");
            curtain.style.display = "none";

            // load the weekly activiies bar chart under Teams athletics training (insights tab)
            $.populateWeeklyActivityBarChart();

            // call the function to update the users activity tracker charts from the db - use vanillajs ajax to compile the data
            compileUserActivityTrackerCharts(usernm);

        }

        // compile chart data from remote storage and apply to each chartname/ chartObj specified in var forChartNameArray
        function compileUserActivityTrackerCharts(usernm) {
            // set username into localstorage
            localStorage.setItem('user_usnm', usernm);

            var forChartNameArray = ['heart_rate_monitor_chart', 'body_temp_monitor_chart', 'speed_monitor_chart', 'step_counter_monitor_chart', 'bmi_weight_monitor_chart'];

            forChartNameArray.forEach(chartName => {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var output = this.responseText;

                        if (output.startsWith("error")) {
                            // provide user with error message
                            alert("An error has occured: \n" + output);
                            console.log("An error has occured: \n" + output);
                        } else {
                            // parse outpyt to js json format
                            let chartData = JSON.parse(output);

                            // output the returned data
                            switch (chartName) {
                                case "heart_rate_monitor_chart":
                                    console.log(chartData);
                                    localStorage.setItem('heart_rate_monitor_chart_data', JSON.stringify(chartData));
                                    syncUserActivityTrackerChart(heartRateChart, usernm, chartName);

                                    break;
                                case "body_temp_monitor_chart":
                                    console.log(chartData);
                                    localStorage.setItem('body_temp_monitor_chart_data', JSON.stringify(chartData));
                                    syncUserActivityTrackerChart(bodyTempChart, usernm, chartName);
                                    break;
                                case "speed_monitor_chart":
                                    console.log(chartData);
                                    localStorage.setItem('speed_monitor_chart_data', JSON.stringify(chartData));
                                    syncUserActivityTrackerChart(speedChart, usernm, chartName);
                                    break;
                                case "step_counter_monitor_chart":
                                    console.log(chartData);
                                    localStorage.setItem('step_counter_monitor_chart_data', JSON.stringify(chartData));
                                    syncUserActivityTrackerChart(stepCountChart, usernm, chartName);
                                    break;
                                case "bmi_weight_monitor_chart":
                                    console.log(chartData);
                                    localStorage.setItem('bmi_weight_monitor_chart_data', JSON.stringify(chartData));
                                    syncUserActivityTrackerChart(bmiWeightChart, usernm, chartName);

                                    break;
                                default:
                                    break;
                            }
                        }

                    }
                };
                xhttp.open("GET", "../scripts/php/main_app/compile_content/fitness_insights_tab/activity_tracking/get_user_stats_activity_tracker.php?forchart=" + chartName + "&u=" + usernm, true);
                xhttp.send();
            });

        }

        function setCurrentAppTabID(currentPageID) {
            // get the currently active app page
            // var appTabsNode = document.querySelector(".app-tab");
            // alert("appTabsNode.length: " + appTabsNode.length);
            // for (let i = 0; i < appTabsNode.length; i++) {
            //     currentPageID = appTabsNode[i].id;
            // }

            localStorage.setItem("current_app_tab", currentPageID);
        }

        function toggleMapSelection(selection) {
            alert("Muscle Selected: " + selection);
        }

        function toggleRecoverySelection(period, option) {
            alert("Period: " + period + " | Option Selected: " + option);
        }

        function musePlayerController(playerAction) {
            alert("Muse Player Action: " + playerAction);
        }

        function launchLink(link) {
            window.location.href = link;
        }

        Date.prototype.getWeek = function(start) {
            //Calcing the starting point
            start = start || 0;
            var today = new Date(this.setHours(0, 0, 0, 0));
            var day = today.getDay() - start;
            var date = today.getDate() - day;

            // Grabbing Start/End Dates
            var StartDate = new Date(today.setDate(date));
            var EndDate = new Date(today.setDate(date + 6));
            return [StartDate, EndDate];
        }

        function getCurrentWeekStartEndDates() {
            // test code
            var elemDatesOutput1 = document.getElementById("weekly-survey-duration-dates");
            // var elemDatesOutput2 = document.getElementById("weekly-training-date-duration-str");

            var Dates = new Date().getWeek();
            //alert(Dates[0].toLocaleDateString() + ' to ' + Dates[1].toLocaleDateString());

            elemDatesOutput1.innerHTML = Dates[0].toLocaleDateString() + ' to ' + Dates[1].toLocaleDateString();
            localStorage.setItem('weekly-survey-duration-dates', Dates[0].toLocaleDateString() + ' to ' + Dates[1].toLocaleDateString());
            // elemDatesOutput2.innerHTML = Dates[0].toLocaleDateString() + ' to ' + Dates[1].toLocaleDateString();
            localStorage.setItem('weekly-training-date-duration', Dates[0].toLocaleDateString() + ' to ' + Dates[1].toLocaleDateString());
        }

        function openLink(evt, tabName) {
            var i, x, tabContainer, tablinks;
            var tabBtnIco = document.getElementById("display-current-tab-button-icon");
            var tabBtnTxt = document.getElementById("display-current-tab-button-text");


            //Change the #display-current-tab-button icon and text
            if (tabName == "TabHome") {
                tabBtnTxt.innerHTML = "Dashboard";
                tabBtnIco.innerHTML = " dashboard ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabProfile") {
                tabBtnTxt.innerHTML = "Profile";
                tabBtnIco.innerHTML = " account_circle ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabDiscovery") {
                tabBtnTxt.innerHTML = "Discovery";
                tabBtnIco.innerHTML = " travel_explore ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabStudio") {
                tabBtnTxt.innerHTML = ".Studio";
                tabBtnIco.innerHTML = " play_circle_outline ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabStore") {
                tabBtnTxt.innerHTML = ".Store";
                tabBtnIco.innerHTML = " storefront ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabSocial") {
                tabBtnTxt.innerHTML = ".Social";
                tabBtnIco.innerHTML = " hub ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabData") {
                tabBtnTxt.innerHTML = "Insights";
                tabBtnIco.innerHTML = " insights ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabAchievements") {
                tabBtnTxt.innerHTML = "Achievements";
                tabBtnIco.innerHTML = " emoji_events ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabMedia") {
                tabBtnTxt.innerHTML = "Media";
                tabBtnIco.innerHTML = " perm_media ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabCommunication") {
                tabBtnTxt.innerHTML = "Communication";
                tabBtnIco.innerHTML = " forum ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "TabSettings") {
                tabBtnTxt.innerHTML = "Preferences";
                tabBtnIco.innerHTML = " settings_accessibility ";
                tabContainer = document.getElementsByClassName("content-tab");
            } else if (tabName == "InsightsTabGCS") {
                /* Insigts sub features app tabs */
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-googlesurveys-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "block";
                // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";
            } else if (tabName == "InsightsTabIAT") {
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-indiathlete-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "block";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";
            } else if (tabName == "InsightsTabCTA") {
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-teamathletics-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "block";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";
            } else if (tabName == "InsightsTabChallenges") {
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-challenges-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "block";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";
            } else if (tabName == "InsightsTabWellness") {
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-challenges-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "block";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "none";
            } else if (tabName == "InsightsTabNutrition") {
                tabContainer = null;
                document.getElementById("v-sub-tab-pills-insights-challenges-tab").click();

                document.getElementById("horizontal-rule-icon-challenges").style.display = "none";
                document.getElementById("horizontal-rule-icon-googlesurveys").style.display = "none";
                // document.getElementById("horizontal-rule-icon-indiathlete").style.display = "none";
                document.getElementById("horizontal-rule-icon-teamathletics").style.display = "none";
                document.getElementById("horizontal-rule-icon-wellness").style.display = "none";
                document.getElementById("horizontal-rule-icon-nutrition").style.display = "block";
            } else if (tabName == "OffcanvasMessages") {
                document.getElementById("toggle-messages-offcanvas").click();
            }

            // InsightsTabGCS
            // InsightsTabIAT
            // InsightsTabCTA
            // InsightsTabChallenges
            // v-sub-tab-pills-insights-googlesurveys-tab
            // v-sub-tab-pills-insights-indiathlete-tab
            // v-sub-tab-pills-insights-teamathletics-tab
            // v-sub-tab-pills-insights-challenges-tab

            //x = document.getElementsByClassName("content-tab");
            x = tabContainer;

            if (x) {
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                document.getElementById(tabName).style.display = "block";

                // set current App Tab ID
                setCurrentAppTabID(tabName);
            }
        }

        function loadActivityCalender(monthName) {
            //load the activities calender
            //?month='.$prev_month.'&year='.$prev_year."'
            //get current month

            var dateNow = new Date();
            var currMonth = dateNow.getMonth() + 1;
            var currYear = dateNow.getFullYear();

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;

                    if (output.startsWith("|[System Error]|")) {
                        messengerLoader.style.display = "none";
                        //alert(output);

                        convoContainer.innerHTML = `
                        <div class="application-error-msg shadow d-grid gap-2 d-block" id="application-error-msg">
                        <h3 class=" d-block" style="color: red">An error has occured</h3>
                        <p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('` + userParam + `','` + output + `')">support</a></p>
                        <div class="application-error-msg-output d-block" style="font-size: 10px">` + output + `</div>
                        </div>
                        `;

                        var applicationErrMsg = document.getElementById('application-error-msg');

                        applicationErrMsg.addEventListener('click', function() {
                            applicationErrMsg.style.display = "none";
                        });
                    } else {
                        //alert(output);
                        document.getElementById('activities-calender').innerHTML = output;
                    }
                }
            };
            xhttp.open("GET", "../scripts/php/main_app/compile_content/fitness_insights_tab/activity_calender/calender.php?month=" + currMonth + "&year=" + currYear, true);
            xhttp.send();
        }

        function reloadActivityCalender(nMonth, nYear) {
            //reload the activities calender
            var dateNow = new Date();
            //nMonth = dateNow.getMonth() + 1;
            //nYear = dateNow.getFullYear();

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var output = this.responseText;

                    if (output.startsWith("|[System Error]|")) {
                        // Output error
                        alert(output);
                    } else {
                        //alert(output);
                        document.getElementById('activities-calender').innerHTML = output;
                    }
                }
            };
            xhttp.open("GET", "../scripts/php/main_app/compile_content/fitness_insights_tab/activity_calender/calender.php?month=" + nMonth + "&year=" + nYear, true);
            xhttp.send();
        }

        function navCalender(nMonth, nYear, cmd) {
            //executes on button next or prev btn click
            //alert("clicked: "+cmd+" | Month: "+nMonth+" | Year: "+nYear);

            reloadActivityCalender(nMonth, nYear);
        }

        // Make the DIV element draggable:
        // dragElement(document.getElementById("drag-player-pin"));  // hide this for now

        function dragElement(elmnt) {
            var pos1 = 0,
                pos2 = 0,
                pos3 = 0,
                pos4 = 0;
            if (document.getElementById(elmnt.id + "header")) {
                // if present, the header is where you move the DIV from:
                document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
            } else {
                // otherwise, move the DIV from anywhere inside the DIV:
                elmnt.onmousedown = dragMouseDown;
            }

            function dragMouseDown(e) {
                e = e || window.event;
                e.preventDefault();
                // get the mouse cursor position at startup:
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                // call a function whenever the cursor moves:
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                e = e || window.event;
                e.preventDefault();
                // calculate the new cursor position:
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // set the element's new position:
                elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
            }

            function closeDragElement() {
                // stop moving when mouse button is released:
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }
    </script>

    <script src="../scripts/js/digital-clock.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>