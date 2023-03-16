// *** JQuery
$(document).ready(function () {
    // get store product items
    $.getStoreProducts = function (request, elemid) {
        var elemid = elemid || '#store-products-list'; // initialize output elemid if it was not passed through params
        $.get("../scripts/php/main_app/compile_content/store_tab/wearables.php?giveme=" + request, function (data, status) {
            if (status != "success") {
                console.log("Get Req Failed -> $.getStoreProducts returned: \n[Status]: " + status + "\n[Data]: " + data);
                // alert("Get Req Failed -> $.compileCommunityGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                // console log if json was requested
                if (request == 'json') console.log('Store Products Json: \n'.data);
                else $(elemid).html(data);// '#store-products-list'
            }
        });
    };

    // run function when scrolled to #main-content-container
    $(window).scroll(function () {
        var hT = $('#nav-bar-header').offset().top,
            hH = $('#nav-bar-header').outerHeight(),
            wH = $(window).height(),
            wS = $(this).scrollTop();
        // console.log('hT:\n' + hT + '\nhH:\n' + hH + '\nwH:\n' + wH + '\nwS:\n' + wS);
        if (wS == 0) { //(hT + hH - wH) | < is at the start (top) of element
            console.log('#nav-bar-header is in view! at the top');

            // assign top:5vh if wS is equal to 0
            $('#twitter-social-panel').css('top', '5vh');
            $('#creation-tools-content-panel').css('top', '5vh');
        } else {
            $('#twitter-social-panel').css('top', '20vh');
            $('#creation-tools-content-panel').css('top', '20vh');
        }
    });

    // onclick event listeners for apps tray open and close buttons
    $("#apps-tray-open-btn").click(function () {
        // $('#twitter-social-panel').css('display', 'none!important');
        // document.getElementById('twitter-social-panel').style.display = 'none!important';
        // $('#creation-tools-content-panel').css('display', 'none!important');
        // document.getElementById('creation-tools-content-panel').style.display = 'none!important';
        $('#twitter-social-panel').css('top', '80vh');
        $('#creation-tools-content-panel').css('top', '80vh');

        console.log('#apps-tray-open-btn was clicked');
    });

    $("#apps-tray-close-btn").click(function () {
        // $('#twitter-social-panel').css('display', 'block!important');
        // document.getElementById('twitter-social-panel').style.display = 'block!important';
        // $('#creation-tools-content-panel').css('display', 'block!important');
        // document.getElementById('creation-tools-content-panel').style.display = 'block!important';
        $('#twitter-social-panel').css('top', '20vh');
        $('#creation-tools-content-panel').css('top', '20vh');

        console.log('#apps-tray-close-btn was clicked');
    });

    // get store products json - test
    $.getStoreProducts('json');

    // compile Dashboard content - ajax

    // compile Profile content - ajax
    // user group subscriptions
    $.compileUserProfileHeader = function () {
        $.get("../scripts/php/main_app/compile_content/profile_tab/user_profile_header.php?usnm=<?php echo $currentUser_Usrnm; ?>", function (data, status) {
            if (status != "success") {
                console.log("Get Req Failed -> $.compileUserProfileHeader returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.compileUserProfileHeader returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                $('#profile-header-container').html(data);
            }
        });
    }

    $.compileUserCommunityGroupSubs = function () {
        $.get("../scripts/php/main_app/compile_content/profile_tab/get_user_community_group_subs.php?entry=init", function (data, status) {
            if (status != "success") {
                console.log("Get Req Failed -> $.compileUserCommunityGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.compileUserCommunityGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                $('#user-community-groups-subs-list').html(data);
            }


        });
    }
    $.compileUserTeamsGroupSubs = function () {
        $.get("../scripts/php/main_app/compile_content/profile_tab/get_user_teams_group_subs.php?entry=init", function (data, status) {
            if (status != "success") {
                console.log("Get Req Failed -> $.compileUserTeamsGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.compileUserTeamsGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                $('#user-teams-groups-subs-list').html(data);
            }


        });
    }
    $.compileUserProGroupSubs = function () {
        $.get("../scripts/php/main_app/compile_content/profile_tab/get_user_pro_group_subs.php?entry=init", function (data, status) {
            if (status != "success") {
                console.log("Get Req Failed -> $.compileUserProGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.compileUserProGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                $('#user-pro-groups-subs-list').html(data);
            }


        });
    }

    // complete group lists
    $.compileCommunityGroups = function () {
        $.get("../scripts/php/main_app/compile_content/community_content/community_groups.php?entry=init", function (data, status) {
            if (status != "success") {
                console.log("Get Req Failed -> $.compileCommunityGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.compileCommunityGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                $('#community-groups-full-list').html(data);
            }


        });
    }
    $.compileTeamsGroups = function () {
        $.get("../scripts/php/main_app/compile_content/teams_content/teams_groups.php?entry=init", function (data, status) {
            if (status != "success") {
                console.log("Get Req Failed -> $.compileTeamsGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.compileTeamsGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                $('#teams-groups-full-list').html(data);
            }


        });
    }
    $.compileProGroups = function () {
        $.get("../scripts/php/main_app/compile_content/premium_content/pro_groups.php?entry=init", function (data, status) {
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
    $.compileMediaTabContent = function () {
        // shared-media-grid-container
        // private-media-grid-container
        // video-media-grid-container
        var mediaClassArray = ['shared', 'private', 'videos'];

        mediaClassArray.forEach(mClass => {
            $.get("../scripts/php/main_app/compile_content/media_tab/main_user_media_gallery.php?dir=" + mClass, function (data, status) {

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
            onReveal: function () {
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
            onReveal: function () {
                // triggered on reveal
            }
        }
    });

    // ***** Locaion: Modal
    // ajax jquery - submit activity tracking data [Heart Rate]
    $("#modal-heartrate-insights-activitytracker-data-form").submit(function (e) {
        e.preventDefault();

        // get the localy stored user_usnm
        let user_usnm = localStorage.getItem('user_usnm');

        var form_data = new FormData($('#modal-heartrate-insights-activitytracker-data-form')[0]);
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_heartrate.php',
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                data: form_data,
                beforeSend: function () {
                    console.log('beforeSend: submitting activity tracking data [Heart Rate]');
                },
                success: function (response) {
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
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }, 1000);
    });
    // ./ ajax jquery - submit activity tracking data [Heart Rate]

    // ajax jquery - submit activity tracking data [Body Temp]
    $("#modal-bodytemp-insights-activitytracker-data-form").submit(function (e) {
        e.preventDefault();

        // get the localy stored user_usnm
        let user_usnm = localStorage.getItem('user_usnm');

        var form_data = new FormData($('#modal-bodytemp-insights-activitytracker-data-form')[0]);
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bodytemp.php',
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                data: form_data,
                beforeSend: function () {
                    console.log('beforeSend: submitting activity tracking data [Body Temp]');
                },
                success: function (response) {

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
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }, 1000);
    });
    // ./ ajax jquery - submit activity tracking data [Body Temp]

    // ajax jquery - submit activity tracking data [Speed]
    $("#modal-speed-insights-activitytracker-data-form").submit(function (e) {
        e.preventDefault();

        // get the localy stored user_usnm
        let user_usnm = localStorage.getItem('user_usnm');

        var form_data = new FormData($('#modal-speed-insights-activitytracker-data-form')[0]);
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_speed.php',
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                data: form_data,
                beforeSend: function () {
                    console.log('beforeSend: submitting activity tracking data [Speed]');
                },
                success: function (response) {

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
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }, 1000);
    });
    // ./ ajax jquery - submit activity tracking data [Speed]

    // ajax jquery - submit activity tracking data [BMI Weight]
    $("#modal-weight-insights-activitytracker-data-form").submit(function (e) {
        e.preventDefault();

        // get the localy stored user_usnm
        let user_usnm = localStorage.getItem('user_usnm');

        var form_data = new FormData($('#modal-weight-insights-activitytracker-data-form')[0]);
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bmiweight.php',
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                data: form_data,
                beforeSend: function () {
                    console.log('beforeSend: submitting activity tracking data [BMI Weight]');
                },
                success: function (response) {

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
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }, 1000);
    });
    // ./ ajax jquery - submit activity tracking data [BMI Weight]

    // ***** Locaion: Single
    // ajax jquery - submit activity tracking data [Heart Rate]
    $("#single-heartrate-insights-activitytracker-data-form").submit(function (e) {
        e.preventDefault();

        // get the localy stored user_usnm
        let user_usnm = localStorage.getItem('user_usnm');

        var form_data = new FormData($('#single-heartrate-insights-activitytracker-data-form')[0]);
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_heartrate.php',
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                data: form_data,
                beforeSend: function () {
                    console.log('beforeSend: submitting activity tracking data [Heart Rate]');
                },
                success: function (response) {
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
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }, 1000);
    });
    // ./ ajax jquery - submit activity tracking data [Heart Rate]

    // ajax jquery - submit activity tracking data [Body Temp]
    $("#single-bodytemp-insights-activitytracker-data-form").submit(function (e) {
        e.preventDefault();

        // get the localy stored user_usnm
        let user_usnm = localStorage.getItem('user_usnm');

        var form_data = new FormData($('#single-bodytemp-insights-activitytracker-data-form')[0]);
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bodytemp.php',
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                data: form_data,
                beforeSend: function () {
                    console.log('beforeSend: submitting activity tracking data [Body Temp]');
                },
                success: function (response) {

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
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }, 1000);
    });
    // ./ ajax jquery - submit activity tracking data [Body Temp]

    // ajax jquery - submit activity tracking data [Speed]
    $("#single-speed-insights-activitytracker-data-form").submit(function (e) {
        e.preventDefault();

        // get the localy stored user_usnm
        let user_usnm = localStorage.getItem('user_usnm');

        var form_data = new FormData($('#single-speed-insights-activitytracker-data-form')[0]);
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_speed.php',
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                data: form_data,
                beforeSend: function () {
                    console.log('beforeSend: submitting activity tracking data [Speed]');
                },
                success: function (response) {

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
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }, 1000);
    });
    // ./ ajax jquery - submit activity tracking data [Speed]

    // ajax jquery - submit activity tracking data [BMI Weight]
    $("#single-weight-insights-activitytracker-data-form").submit(function (e) {
        e.preventDefault();

        // get the localy stored user_usnm
        let user_usnm = localStorage.getItem('user_usnm');

        var form_data = new FormData($('#single-weight-insights-activitytracker-data-form')[0]);
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bmiweight.php',
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                data: form_data,
                beforeSend: function () {
                    console.log('beforeSend: submitting activity tracking data [BMI Weight]');
                },
                success: function (response) {

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
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }, 1000);
    });
    // ./ ajax jquery - submit activity tracking data [BMI Weight]

    // load Teams Activity Capturing Form
    $.loadTeamsActivityCaptureForm = function (day, grpRefcode) {
        // alert("../scripts/php/main_app/data_management/system_admin/team_athletics_data/compile_teams_add_new_activity_day_form.php?day=" + day + "&gref=" + grpRefcode);

        // store grpRefcode locally so we can access it later
        localStorage.setItem('grcode', grpRefcode);

        $.get("../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/compile/compile_teams_add_new_activity_day_form.php?day=" + day + "&gref=" + grpRefcode, function (data, status) {
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

    $.populateWeeklyActivityBarChart = function () {
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
            $.get("../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/compile/compile_teams_daily_activities.php?day=" + weekday + "&gref=" + grpRefCode, function (data, status) {


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

    $.populateWeeklyAssessmentsHorizCardContainer = function (weekday, grpRefCode) {
        // var grpRefCode = "tst_grp_0001";
        $.get("../scripts/php/main_app/compile_content/profile_tab/get_users_daily_assessments_and_activities_list.php?day=" + weekday + "&gref=" + grpRefCode, function (data, status) {

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
    $("#teams-add-new-day-activity-data-form").submit(function (e) {
        e.preventDefault();

        var form_data = new FormData($('#teams-add-new-day-activity-data-form')[0]);
        setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: '../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/teams_add_new_activity_day_form_submit.php',
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                data: form_data,
                beforeSend: function () {
                    console.log('beforeSend: submit edited weekly teams activity data [Teams Submit Edited Activities Form]');
                },
                success: function (response) {

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
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }, 1000);
    });
    // ./ ajax jquery - submit edited weekly teams activity data [Teams Submit Edited Activities Form]

    // load interaction model content
    $.loadInteractionContent = function (loadContent) {
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
            $.get(getRequestLink, function (data, status) {

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
    $.editAddNewActivityModal = function (day, grpRefcode) {
        // open the modal
        // $("#toggleTabeditWeeklyTeamsTrainingScheduleModalBtn").click();

        // call the function/code to populate the modal body - use jquery ajax
        $.loadTeamsActivityCaptureForm(day, grpRefcode);

        // update the modal header label
        $('#tabeditWeeklyTeamsTrainingScheduleModalLabelText').html('Edit weekly training schedule ( ' + day + ' )');
    }

    $.toggleEditDayBar = function (day, groupRefCode) {
        // open the modal
        // $("#toggleTabeditWeeklyTeamsTrainingScheduleModalBtn").click();

        // call the function/code to populate the modal body - use jquery ajax - "editbar" value (grpRefcode) will load a form for updating the title and rpe
        var initVal = "editbar";
        $.loadTeamsActivityCaptureForm(day, initVal);
    }

    $.removeWeeklyTrainingActivity = function (day, groupRefCode, exerciseID) {

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