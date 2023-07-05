// *** JQuery
// $(document).ready(function () {});
// correct timezone support:
Date.prototype.toDateInputValue = (function () {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0, 10);
});

// add todays date as the default to all output labels with #training-week-date-range-input
// document.getElementById('training-week-date-range-input').value = new Date().toDateInputValue();
$('.training-week-date-range-input').val(new Date().toDateInputValue());

// function to smooth scroll
$.smoothScroll = function (containerElemID, scrollToElemID, scrollSpeed) {
    scrollSpeed = scrollSpeed || 100;
    if (!containerElemID.startsWith("#")) {
        containerElemID = "#" + containerElemID;
    }
    if (!scrollToElemID.startsWith("#")) {
        scrollToElemID = "#" + scrollToElemID;
    }
    $(containerElemID).animate({ // "#main-form-window-scroll-container" [document.documentElement, document.body]
        scrollTop: $(scrollToElemID).offset().top // "#user-welcome-header"
    }, scrollSpeed);
}

// run function when scrolled to #main-content-container
$(window).scroll(function () {
    // var left_side_panel_visibility_state = localStorage.getItem('left_side_panel_visibility_state');
    // var right_side_panel_visibility_state = localStorage.getItem('right_side_panel_visibility_state');

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

        // make sure to reset the margins to 0xp (deprecated)
        // $('#twitter-social-panel').css('margin-left', '0px');
        // $('#creation-tools-content-panel').css('margin-right', '0px');

        // fadeout and remove fixed top class from main navbar and fade back in
        $('#main-navbar').fadeOut('slow');
        $('#main-navbar').removeClass('fixed-top');
        $('#main-navbar').fadeIn('slow');
    } else {
        $('#twitter-social-panel').css('top', '20vh');
        $('#creation-tools-content-panel').css('top', '20vh');

        // make sure to reset the margins to 0xp (deprecated)
        // $('#twitter-social-panel').css('margin-left', '0px');
        // $('#creation-tools-content-panel').css('margin-right', '0px');

        // fadeout and add fixed top class to main navbar and fade back in
        $('#main-navbar').fadeOut('slow');
        $('#main-navbar').addClass('fixed-top');
        $('#main-navbar').fadeIn('slow');
    }
});

// event listener for click on elems with .hide-side-panels
$('.hide-side-panels').on('click', () => {
    // call $.hideSidePanelsDisplay function
    $.hideSidePanelsDisplay();
});

$('.hide-left-side-panels').on('click', () => {
    // hide only the left side panel
    $('#twitter-social-panel').addClass('d-none');
    localStorage.setItem('left_side_panel_visibility_state', false);

});

$('.hide-right-side-panels').on('click', () => {
    // hide only the right side panel
    $('#creation-tools-content-panel').addClass('d-none');
    localStorage.setItem('right_side_panel_visibility_state', false);

});

$.hideSidePanelsDisplay = function () {
    // $('#twitter-social-panel').css('margin-left', '-300px');
    // $('#creation-tools-content-panel').css('margin-right', '-300px');
    $('#twitter-social-panel').addClass('d-none');
    $('#creation-tools-content-panel').addClass('d-none');

    localStorage.setItem('left_side_panel_visibility_state', false);
    localStorage.setItem('right_side_panel_visibility_state', false);

    console.log('($.hideSidePanelsDisplay) side panels have been hidden');
}

// event listener for click on elems with .show-side-panels
$('.show-side-panels').on('click', () => {
    // call $.showSidePanelsDisplay function
    $.showSidePanelsDisplay();
});

$('.show-left-side-panels').on('click', () => {
    // show only the left side panel
    $('#twitter-social-panel').removeClass('d-none');
    localStorage.setItem('left_side_panel_visibility_state', true);

});

$('.show-right-side-panels').on('click', () => {
    // show only the right side panel
    $('#creation-tools-content-panel').removeClass('d-none');
    localStorage.setItem('right_side_panel_visibility_state', true);

});

$.showSidePanelsDisplay = function () {
    // $('#twitter-social-panel').css('margin-left', '0px');
    // $('#creation-tools-content-panel').css('margin-right', '-0px');
    $('#twitter-social-panel').removeClass('d-none');
    $('#creation-tools-content-panel').removeClass('d-none');

    localStorage.setItem('left_side_panel_visibility_state', true);
    localStorage.setItem('right_side_panel_visibility_state', true);

    console.log('($.showSidePanelsDisplay) side panels have been shown');
}

// function for hiding single side panel
$.hideSingleSidePanel = function (panelId, position) {
    // alert("panelId: " + panelId);
    if (!panelId.startsWith('#')) panelId = '#' + panelId;
    if (position === 'left' || position === 'right') {
        // update left_side_panel_visibility_state on localstorage
        switch (position) {
            case 'left':
                localStorage.setItem('left_side_panel_visibility_state', false);
                break;
            case 'right':
                localStorage.setItem('right_side_panel_visibility_state', false);
                break;

            default:
                break;
        }
        // change the margin to move panel out of viewport
        // $(panelId).css(`margin-${position}`, '-300px');
        $(panelId).addClass('d-none');
        console.log("($.hideSingleSidePanel) panel has been hidden: " + panelId);
    }
}

// onclick event listeners for apps tray open and close buttons
$("#apps-tray-open-btn").on('click', () => {
    // $('#twitter-social-panel').css('margin-left', '-300px');
    // $('#creation-tools-content-panel').css('margin-right', '-300px');

    $.hideSidePanelsDisplay();

    console.log('#apps-tray-open-btn was clicked');
});

$("#apps-tray-close-btn").on('click', () => {
    // $('#twitter-social-panel').css('margin-left', '0px');
    // $('#creation-tools-content-panel').css('margin-right', '0px');

    $.showSidePanelsDisplay();

    console.log('#apps-tray-close-btn was clicked');
});

$("#main-nav-notifications-btn").on('click', () => {
    // $('#twitter-social-panel').css('margin-left', '-300px');

    $.hideSingleSidePanel('#twitter-social-panel', 'left');

    console.log('#main-nav-notifications-btn was clicked');
});

$("#main-nav-ext-links-btn").on('click', () => {
    // $('#creation-tools-content-panel').css('margin-right', '-300px');

    $.hideSingleSidePanel('#creation-tools-content-panel', 'right');

    console.log('#main-nav-ext-links-btn was clicked');
});

// Main App Refresh button onclick lister - function to toggle pulse animation from #main-app-refresh-btn
$('#main-app-refresh-btn').on('click', () => {
    $('#main-app-refresh-btn').removeClass('my-pulse-animation-light');
    $('#main-app-refresh-btn').addClass('shadow');
});


// get store product items
$.getStoreProducts = function (request, elemid) {
    var elemid = elemid || '#store-products-list'; // initialize output elemid if it was not passed through params
    $.get("../scripts/php/main_app/compile_content/store_tab/wearables.php?giveme=" + request, function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getStoreProducts returned: \n[Status]: " + status + "\n[Data]: " + data);
            // alert("Get Req Failed -> $.getCommunityGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            // console log if json was requested
            if (request == 'json') console.log('Store Products Json: \n'.data);
            else $(elemid).html(data);// '#store-products-list'
        }
    });
}

$.getFitnessProgressionUIWidgets = function (username, widgetType) {
    // widgetType should either be bar or mini - strictly
    // scripts/php/main_app/compile_content/fitness_insights_tab/fitness_progression
    $.get("../scripts/php/main_app/compile_content/fitness_insights_tab/fitness_progression/fp_widget.php?usnm=" + username + "&wtype=" + widgetType, function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getFitnessProgressionUIWidgets returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getFitnessProgressionUIWidgets returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            switch (widgetType) {
                case 'bar':
                    $('.bar-fpwidget').html(data);
                    break;

                case 'mini':
                    $('.mini-fpwidget').html(data);
                    break;

                default:
                    var nowidget = `Please specify the widget type to display.`;
                    $('.bar-fpwidget').html(nowidget);
                    $('.mini-fpwidget').html(nowidget);
                    break;
            }

        }
    });
}

// get store products json - test
$.getStoreProducts('json');

// get Dashboard content - ajax
$.getUserWeekActivities = function (username) {
    $.get("../scripts/php/main_app/compile_content/dashboard_tab/user_daily_activity_lineup.php?usnm=" + username, function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getUserWeekActivities returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getUserWeekActivities returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            $('#week-activities-list-container').html(data);
        }
    });
}

// get team match schedule
function getSchedule(grcode, elemId, periodRequest) {
    $.get("../scripts/php/main_app/compile_content/fitness_insights_tab/weekly_assesments_and_activities/get_match_schedules.php?grcode=" + grcode + "&period_req=" + periodRequest, function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getTeamMatchSchedule returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getTeamMatchSchedule returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            $(elemId).html(data);
        }
    });
}
$.getTeamMatchSchedule = function (grcode) {
    const periods = ["upcoming", "history"];

    periods.forEach(period => {
        switch (period) {
            case 'upcoming':
                getSchedule(grcode, '#teams-upcoming-match-schedule-tbody', 'upcoming');
                break;
            case 'history':
                getSchedule(grcode, '#teams-match-history-tbody', 'played');
                break;

            default:
                showSnackbar('Error while compiling match schedules. Check console for more information.', 'alert_error', 'long_15000');
                console.log('Invalid period selector: Error while computing match schedules. Check console for more information -> ' + period);
                break;
        }
    });

}

// get Profile content - ajax
// user group subscriptions
$.getUserProfileHeader = function (username) {

    $.get("../scripts/php/main_app/compile_content/profile_tab/user_profile_header.php?usnm=" + username, function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getUserProfileHeader returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getUserProfileHeader returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            $('#profile-header-container').html(data);
        }
    });
}

// get user media files for profile tab and media tab
$.getUsersMediaFiles = function () {
    var dirs = ["shared", "private", "video", "audio"];

    dirs.forEach(dir => {
        // scripts/php/main_app/compile_content/media_tab/main_user_media_gallery.php
        $.get("../scripts/php/main_app/compile_content/media_tab/main_user_media_gallery.php?dir=" + dir, function (data, status) {
            if (status != "success") {
                console.log("Get Req Failed -> $.getUsersMediaFiles returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.getUsersMediaFiles returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                switch (dir) {
                    case 'shared':
                        $('#shared-media-grid-container').html(data);
                        break;
                    case 'private':
                        $('#private-media-grid-container').html(data);
                        break;
                    case 'video':
                        $('#video-media-grid-container').html(data);
                        break;
                    case 'audio':
                        // $('#').html(data); do nothing, no container available atm
                        break;

                    default:
                        break;
                }
            }

        });
    });

}

$.getUserCommunityGroupSubs = function () {
    $.get("../scripts/php/main_app/compile_content/profile_tab/get_user_community_group_subs.php?entry=init", function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getUserCommunityGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getUserCommunityGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            $('#user-community-groups-subs-list').html(data);
        }


    });
}
$.getUserTeamsGroupSubs = function () {
    $.get("../scripts/php/main_app/compile_content/profile_tab/get_user_teams_group_subs.php?entry=init", function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getUserTeamsGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getUserTeamsGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            $('#user-teams-groups-subs-list').html(data);
        }


    });
}
$.getUserProGroupSubs = function () {
    $.get("../scripts/php/main_app/compile_content/profile_tab/get_user_pro_group_subs.php?entry=init", function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getUserProGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getUserProGroupSubs returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            $('#user-pro-groups-subs-list').html(data);
        }


    });
}

// complete group lists
$.getCommunityGroups = function () {
    $.get("../scripts/php/main_app/compile_content/community_content/community_groups.php?entry=init", function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getCommunityGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getCommunityGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            $('#community-groups-full-list').html(data);
        }


    });
}
$.getTeamsGroups = function () {
    $.get("../scripts/php/main_app/compile_content/teams_content/teams_groups.php?entry=init", function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getTeamsGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getTeamsGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            $('#teams-groups-full-list').html(data);
        }


    });
}
$.getProGroups = function () {
    $.get("../scripts/php/main_app/compile_content/premium_content/pro_groups.php?entry=init", function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getProGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getProGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            $('#pro-groups-full-list').html(data);
        }


    });
}
// get user profile header
$.getUserProfileHeader();
// get full groups list
$.getCommunityGroups();
$.getTeamsGroups();
$.getProGroups();
// get user group subs
$.getUserCommunityGroupSubs();
$.getUserTeamsGroupSubs();
$.getUserProGroupSubs();

// compile Discovery content - ajax

// compile Studio content - ajax

// compile Store content - ajax

// compile Social content - ajax

// compile Fitness Insights content - ajax

// compile Achievements content - ajax

// compile Media content - ajax
$.getMediaTabContent = function () {
    // shared-media-grid-container
    // private-media-grid-container
    // video-media-grid-container
    var mediaClassArray = ['shared', 'private', 'videos'];

    mediaClassArray.forEach(mClass => {
        $.get("../scripts/php/main_app/compile_content/media_tab/main_user_media_gallery.php?dir=" + mClass, function (data, status) {

            if (status != "success") {
                console.log("Get Req Failed -> $.getMediaTabContent returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.getMediaTabContent returned: \n[Status]: " + status + "\n[Data]: " + data);
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
                        console.log("Error [$.getMediaTabContent]: mClass/Directory: " + mClass);
                        break;
                }
            }
        });

    });

}

// compile Communications content - ajax

// compile Messages content - ajax

// compile Preferences content - ajax

// get teams group information - select input list
$.getTeamsSelectInputList = function (privacyType) {
    // 
    $.get("../scripts/php/main_app/compile_content/fitness_insights_tab/training/teams/get_teams_groups_list.php?get_privacy=" + privacyType, function (data, status) {

        if (status != "success") {
            console.log("Get Req Failed -> $.getTeamsSelectInputList returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getTeamsSelectInputList returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            $('#formation-team-selection').html(data);
            $('.team-selection-list').html(data);
        }
    });
}

// get teams group information - table of group members
$.getTeamsGroupMembersTableItems = function (grcode) {
    const membersReqArray = ["starting", "benched", "reserve", "technical"];

    var outputElemId = null;
    var output = null;

    function getRequestedGMList(grcode, memberItem, outputElemId) {
        $.get("../scripts/php/main_app/compile_content/fitness_insights_tab/training/teams/get_teams_group_members.php?grc=" + grcode + "&memtype=" + memberItem, function (data, status) {
            if (status != "success") {
                console.log("Get Req Failed -> $.getRequestedGMList returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.getRequestedGMList returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                $(outputElemId).html(data);
            }
        });
    }

    membersReqArray.forEach(memberItem => {
        switch (memberItem) {
            case "starting":
                outputElemId = "#teams-formation-starting-lineup-table-list";
                break;
            case "benched":
                outputElemId = "#teams-formation-substitutes-table-list";
                break;
            case "reserve":
                outputElemId = "#teams-formation-reserves-table-list";
                break;
            case "technical":
                outputElemId = "#teams-formation-technical-team-table-list";
                break;

            default:
                return alert("($.getTeamsGroupMembersTableItems) Requested type not supported. type:[ " + memberItem + " ]");
            // break;
        }

        // update tbody of outputElemId to show loading spinner.
        $(outputElemId).html(`
        <tr>
            <td class="text-center" colspan="5">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </td>
        </tr>`);

        getRequestedGMList(grcode, memberItem, outputElemId);

        // if (output === false) {
        //     // if output received is false then alert user
        //     console.log("$.getRequestedGMList -> $.getTeamsGroupMembersTableItems data output:\n outputElemID: " + outputElemId + " \n Data: " + output);
        //     showSnackbar("An error occurred while compiling the requested teams data. Please contact the administrator.", 'alert_error', 'long_15000')
        // } else {
        //     console.log("outputing to " + outputElemId + " \n Html Data: " + output);
        //     $(outputElemId).html(output);
        // }

    });

}

$.initializeSoccerfieldFormation = function (grcode) {
    // soccer field player formation

    function getRequestedGMJSONList(grcode) {
        const memtype = 'starting';
        $.get("../scripts/php/main_app/compile_content/fitness_insights_tab/training/teams/get_teams_group_members.php?returntype=json&grc=" + grcode + "&memtype=" + memtype, function (data, status) {
            if (status != "success") {
                console.log("Get Req Failed -> $.getRequestedGMJSONList returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.getRequestedGMJSONList returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                let responseJSONData = JSON.parse(data); //data; //we used JSON_PRETTY_PRINT param on json_encode in php 
                // alert("Successfull response from getRequestedGMJSONList(). Check console for details.");
                console.log("Successfull response: \n" + JSON.stringify(responseJSONData));
                // return JSON.stringify(responseJSONData);

                // run getRequestedGMJSONList function to test what output we get
                // let compiledPlayerPositionData = JSON.stringify(responseJSONData);

                // console.log("compiledPlayerPositionData: \n" + compiledPlayerPositionData);

                // *** TESTING ********************************
                // use .map to create a new array of players positions
                var players = responseJSONData.map(
                    function (index) {
                        var arrayItem = `
                        {
                            name: '${index.user_name} ${index.user_surname}',
                            position: '${index.field_position}',
                            img: '../media/profiles/0_default/soccer-player.png'
                        }`
                        return arrayItem;
                    }
                );
                console.log("players array (mapped): \n" + players);
                // *** TESTING ********************************
            }
        });
    }

    // clear the #soccefield container
    $('#soccefield').empty();

    getRequestedGMJSONList(grcode);

    // create api to get json data from our database
    // run getRequestedGMJSONList function to test what output we get
    // let compiledPlayerPositionData = getRequestedGMJSONList(grcode);

    // console.log("compiledPlayerPositionData: \n" + compiledPlayerPositionData);



    var playerPositionData = [{
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

    $("#soccerfield").soccerfield(playerPositionData, {
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
                console.log("soccerfield plugin has been loaded.");
            }
        }
    });
}

$.fetchTeamData = function (grcode) {
    alert("($.fetchTeamData) group ref code from this.value: " + grcode);

    // compile player position data array from a php.get function for starting lineup players
    $.initializeSoccerfieldFormation(grcode);


    // retrieve the text of the selected team item in the #formation-team-selection elem - http://stackoverflow.com/questions/610336/ddg#610344
    function getSelectedText(elementId) {
        var elt = document.getElementById(elementId);

        if (elt.selectedIndex == -1)
            return null;

        return elt.options[elt.selectedIndex].text;
    }

    var panelHeaderText = getSelectedText('formation-team-selection');

    $('#offcanvasTeamFormationLabel').text(panelHeaderText);

    $('#loading-formation-data-spinner').show();
    $.getTeamsGroupMembersTableItems(grcode);
    $('#loading-formation-data-spinner').hide();
    // $.get("../scripts/php/main_app/compile_content/fitness_insights_tab/training/teams/get_teams_formation_data.php?grc=" + grcode, function (data, status) {

    //     if (status != "success") {
    //         console.log("Get Req Failed -> $.fetchTeamData returned: \n[Status]: " + status + "\n[Data]: " + data);
    //         alert("Get Req Failed -> $.fetchTeamData returned: \n[Status]: " + status + "\n[Data]: " + data);
    //     } else {
    //         $('#addOutputIDHere').html(data);
    //     }
    // });
}

// get user activity timeline
$.getUserActivityTimeline = function (username) {
    // scripts/php/main_app/compile_content/fitness_insights_tab/activity_timeline/get_user_activity_history.php
    $.get("../scripts/php/main_app/compile_content/fitness_insights_tab/activity_timeline/get_user_activity_history.php?usernm=" + username, function (data, status) {
        // console.log("getUserActivityTimeline returned: \n[Status]: " + status + "\n[Data]: " + data);

        if (status != "success") {
            // provide an error message
            console.log("Get Req Failed -> $.getUserActivityTimeline returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.getUserActivityTimeline returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            // populate the activity timeline container
            $('#user-activity-timeline').html(data);
        }
    });
}

// *** training interactions tabs
// get users challenges
$.getUserChallenges = function (username) {
    // perform a for loop to loop through workoutFreq array
    const workoutCycle = ['daily', 'weekly'];
    workoutCycle.forEach(cycle => {
        // scripts/php/main_app/compile_content/fitness_insights_tab/training/challenges/get_user_challenges.php
        $.get("../scripts/php/main_app/compile_content/fitness_insights_tab/training/challenges/get_user_challenges.php?usernm=" + username + "&cycle=" + cycle, function (data, status) {
            // console.log("getUserChallenges returned: \n[Status]: " + status + "\n[Data]: " + data);

            if (status != "success") {
                // provide an error message
                console.log("Get Req Failed -> $.getUserChallenges returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.getUserChallenges returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                switch (cycle) {
                    case 'daily':
                        // populate the #daily-challenges-grid containers
                        $('.daily-challenges-grid').html(data);

                        break;
                    case 'weekly':
                        // populate the #weekly-challenges-grid containers
                        $('.weekly-challenges-grid').html(data);
                        break;

                    default:
                        return console.log('error: unknown frequency detected ($.getUserChallenges)');
                }
            }
        });
    });
}

// function for getting the max/highest requested prop (property/key) value from a json object or array - source: https://stackoverflow.com/questions/22949597/getting-max-values-in-json-array
function getMax(arr, prop) {
    var max;
    for (var i = 0; i < arr.length; i++) {
        if (max == null || parseInt(arr[i][prop]) > parseInt(max[prop]))
            max = arr[i];
    }
    return max;
}

$.getActivityTrackerStatsSummaryWidget = function () {
    function compileWidget(requestFormat) {
        // if request format value can either be: ui_default / json. If request format is not passed default it to ui_default
        requestFormat = requestFormat || 'ui_default';

        $.get("../scripts/php/main_app/compile_content/fitness_insights_tab/activity_tracking/tracker_stats_widget.php?request=" + requestFormat, function (data, status) {
            // console.log("getActivityTrackerStatsWidget returned: \n[Status]: " + status + "\n[Data]: " + data);

            if (status != "success") {
                // provide an error message
                console.log("Get Req Failed -> $.getActivityTrackerStatsSummaryWidget returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.getActivityTrackerStatsSummaryWidget returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                // update the stats in the main widget on the insights tab. We will call a specific function that get the stats in json format and stores the json to localstorage
                switch (requestFormat) {
                    case 'ui_default':
                        // ui returns and push it to the elems with .activity-tracker-stats-widget-container
                        $('.activity-tracker-stats-widget-container').html(data);
                        break;
                    case 'json':
                        // store results in localstorage and push/map values to the ui elems on the main widget on the insights tab 
                        localStorage.setItem('ActivityTrackerStatsSummaryJson', data);
                        console.log("($.getActivityTrackerStatsSummaryWidget) Returned JSON: \n" + data);
                        // alert("Output Test - Check JSON output on the console."); //test notification
                        // we will take the values returned from the json object and pass them to the main activity tracker stats widget ui on the insights tab
                        let summaryStatsJsonData = JSON.parse(data);

                        // 'averageHeartrate' => null, 'averageTemp' => null, 'averageSpeed' => null, 'totalSteps' => null
                        $('.heartrate-avg-stat').html(summaryStatsJsonData['averageHeartrate']);
                        $('.temp-avg-stat').html(summaryStatsJsonData['averageTemp']);
                        $('.speed-avg-stat').html(summaryStatsJsonData['averageSpeed']);
                        $('.steps-taken-stat').html(summaryStatsJsonData['totalSteps']);
                        $('.avg-bmi-stat').html(summaryStatsJsonData['averageBMI']);

                        // go back to the locally stored chart js json data and get the latest entries or max entries according to the requirments of the various tracked data types
                        // heartrate - get the highest heart rate
                        let highestHeartrateEntry = getMax(JSON.parse(localStorage.getItem('heart_rate_monitor_chart_data')), 'bpm');
                        $('.latest-heartrate-entry-value').html(highestHeartrateEntry['bpm'] + " bpm");
                        $('.avg-heartrate-latest-update-datetime').html(moment(highestHeartrateEntry['date'] + " " + highestHeartrateEntry['time']).fromNow());
                        // temperature
                        let highestTempEntry = getMax(JSON.parse(localStorage.getItem('body_temp_monitor_chart_data')), 'temperature');
                        $('.latest-temp-entry-value').html(highestTempEntry['temperature'] + " °C");
                        $('.avg-temp-latest-update-datetime').html(moment(highestTempEntry['date'] + " " + highestTempEntry['time']).fromNow());
                        // speed
                        let highestSpeedEntry = getMax(JSON.parse(localStorage.getItem('speed_monitor_chart_data')), 'speed');
                        $('.highest-speed-entry-value').html(highestSpeedEntry['speed'] + " m/s");
                        $('.highest-speed-entry-datetime').html(moment(highestSpeedEntry['date'] + " " + highestSpeedEntry['time']).fromNow());
                        // steps - using fitbit data if available
                        // weight / bmi
                        let highestBMIEntry = getMax(JSON.parse(localStorage.getItem('bmi_weight_monitor_chart_data')), 'bmi');
                        $('.latest-bmi-entry-value').html(highestBMIEntry['bmi'] + " (weight: " + highestBMIEntry['weight'] + ")");
                        $('.bmi-latest-update-datetime').html(moment(highestBMIEntry['date'] + " " + highestBMIEntry['time']).fromNow());
                        break;

                    default:
                        // request format is unknown. console log and notify user
                        console.log('($.getActivityTrackerStatsSummaryWidget) Requested unknown request format: ' + requestFormat);
                        alert('Activity Tracker Summary Stats Widget Error \nRequested unknown request format: ' + requestFormat);
                        break;
                }

            }
        });
    }

    const requestFormats = ["ui_default", "json"];

    requestFormats.forEach(reqformat => {
        compileWidget(reqformat);
    });
}

// load Teams Activity Capturing Form
$.loadTeamsActivityCaptureForm = function (day, grpRefcode) {
    // alert("../scripts/php/main_app/data_management/system_admin/team_athletics_data/compile_teams_add_new_activity_day_form.php?day=" + day + "&gref=" + grpRefcode);

    // store grpRefcode locally so we can access it later
    localStorage.setItem('grcode', grpRefcode);

    $.get("../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/compile/compile_teams_add_new_activity_day_form.php?day=" + day + "&gref=" + grpRefcode, function (data, status) {
        console.log("loadTeamsActivityCaptureForm returned: \n[Status]: " + status + "\n[Data]: " + data);

        if (status != "success") {
            // provide an error message
            console.log("Get Req Failed -> $.loadTeamsActivityCaptureForm returned: \n[Status]: " + status + "\n[Data]: " + data);
            alert("Get Req Failed -> $.loadTeamsActivityCaptureForm returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            // populate the modal body
            $('#display-activity-bar-preview').html(data);
        }
    });
}

// function for switching weekly view of assessment cards and the activity chart
$.switchWeeklyActivityView = (when, grcode) => {
    const testgrcode = "tst_grp_0001";
    grcode = grcode || testgrcode;

    // update the weekly date range label
    getCurrentWeekStartEndDates(when);

    // initialize the activity bar chart
    $.populateWeeklyActivityBarChart(when, grcode);
    // initialize the assessment cards
    $.populateWeeklyAssessmentsHorizCardContainer(when, grcode);
}

// function to get the #training-week-date-range-input selected date and sync the Weekly Training Activities in the activity bar chart
$.getRequestedTrainingWeekActivities = function () {
    // get the #training-week-date-range-input selected date 
    var rangeDate = new Date($('#training-week-date-range-input').val());

    // call function to sync the Weekly Training Activities in the activity bar chart
    $.populateWeeklyActivityBarChart('specific_range', null, true, rangeDate);
}

$.populateWeeklyActivityBarChart = function (when, grcode, dateQuery, dateQueryStr) { // when is the week request (this/last/next week)
    when = when || 'this';
    grcode = grcode || 'test_grp_001';
    // dateQuery flag variables for fetching training week activity data of dateQueryStr date. (function (when = null, *grcode, *bool = dateQuery, *date = dateQueryStr))
    dateQuery = dateQuery || null;
    dateQueryStr = dateQueryStr || null;

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

    // show the loading indicator/spinners on each card / bar
    const loadingIndicator =
        `<div class="d-flex justify-content-center">
        <div class="spinner-grow" style="width:3rem;height3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>`;
    $('#day-1-col').html(loadingIndicator);
    $('#day-2-col').html(loadingIndicator);
    $('#day-3-col').html(loadingIndicator);
    $('#day-4-col').html(loadingIndicator);
    $('#day-5-col').html(loadingIndicator);
    $('#day-6-col').html(loadingIndicator);
    $('#day-7-col').html(loadingIndicator);

    showSnackbar(`Loading ${when} weeks activities.`);

    // var weekDaysArray = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    // alert("JQuery AJAX populateWeeklyActivityBarChart");


    function getDayActivityData(dateStr, grcode, elemId) {
        $.get("../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/compile/compile_teams_daily_activities.php?date=" + dateStr + "&grcode=" + grcode, function (data, status) {
            if (status != "success") {
                console.log("Get Req Failed -> $.populateWeeklyActivityBarChart returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.populateWeeklyActivityBarChart returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                $(elemId).html(data);
            }
        });
    };

    // for each date from getWeekRange array we received, make a request for the bar/column data
    // use -1 for last week, 0 for this week and 1 for next week
    var snackbarOutput = "";
    var weekDatesArray = [];
    switch (when) {
        case "last":
            weekDatesArray = getWeekRange(-2);
            snackbarOutput = `${capitalizeFirstLetter(when)} weeks actvities bar chart has been loaded.`;
            break;
        case "this":
            weekDatesArray = getWeekRange(-1);
            snackbarOutput = `${capitalizeFirstLetter(when)} weeks actvities bar chart has been loaded.`;
            break;
        case "next":
            weekDatesArray = getWeekRange(0);
            snackbarOutput = `${capitalizeFirstLetter(when)} weeks actvities bar chart has been loaded.`;
            break;
        case "specific_range":
            // get weekdays array of the specific date passed in
            weekDatesArray = getSpecificWeekRange(dateQueryStr);
            snackbarOutput = `Training week actvities bar chart has been loaded for [ ${dateQueryStr} ].`;
            break;

        default:
            return false;
    }

    // after we get the weekDatesArray, we loop through each item using a foreach loop and call getDayActivityData function to get data for that specific day
    weekDatesArray.forEach(dateStr => {
        var dayName = getDayName(dateStr, "en-ZA");

        switch (dayName) {
            case "Monday":
                // execute function to get the current dates activity data
                getDayActivityData(dateStr, grcode, '#day-1-col');

                break;
            case "Tuesday":
                getDayActivityData(dateStr, grcode, '#day-2-col');
                break;
            case "Wednesday":
                getDayActivityData(dateStr, grcode, '#day-3-col');
                break;
            case "Thursday":
                getDayActivityData(dateStr, grcode, '#day-4-col');
                break;
            case "Friday":
                getDayActivityData(dateStr, grcode, '#day-5-col');
                break;
            case "Saturday":
                getDayActivityData(dateStr, grcode, '#day-6-col');
                break;
            case "Sunday":
                getDayActivityData(dateStr, grcode, '#day-7-col');
                break;

            default:
                console.log("Error [$.populateWeeklyActivityBarChart]: Day: " + dayName + " | grcode" + grcode);
                // alert("Error [$.populateWeeklyActivityBarChart]: Day: " + dayName + " | grcode" + grcode);
                break;
        }
    });

    showSnackbar(snackbarOutput);
}

$.populateWeeklyAssessmentsHorizCardContainer = function (when, grcode) {
    when = when || 'this';
    grcode = grcode || 'all';

    // show the loading indicator/spinners on each card / bar
    const loadingIndicator =
        `<div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>`;
    $('#weekly-assessment-h-scroll-weekday-card-varmonday').html(loadingIndicator);
    $('#weekly-assessment-h-scroll-weekday-card-vartuesday').html(loadingIndicator);
    $('#weekly-assessment-h-scroll-weekday-card-varwednesday').html(loadingIndicator);
    $('#weekly-assessment-h-scroll-weekday-card-varthursday').html(loadingIndicator);
    $('#weekly-assessment-h-scroll-weekday-card-varfriday').html(loadingIndicator);
    $('#weekly-assessment-h-scroll-weekday-card-varsaturday').html(loadingIndicator);
    $('#weekly-assessment-h-scroll-weekday-card-varsunday').html(loadingIndicator);

    showSnackbar(`Loading ${when} weeks assessments.`);

    function getDayAssessmentData(dateStr, grcode, elemId) {
        $.get("../scripts/php/main_app/compile_content/profile_tab/get_users_daily_assessments_and_activities_list.php?date=" + dateStr + "&grcode=" + grcode, function (data, status) {

            if (status != "success") {
                console.log("Get Req Failed -> $.populateWeeklyAssessmentsHorizCardContainer returned: \n[Status]: " + status + "\n[Data]: " + data);
                alert("Get Req Failed -> $.populateWeeklyAssessmentsHorizCardContainer returned: \n[Status]: " + status + "\n[Data]: " + data);
            } else {
                $(elemId).html(data);
            }
        });
    }

    var weekDatesArray = [];
    switch (when) {
        case "last":
            var weekDatesArray = getWeekRange(-2);
            break;
        case "this":
            var weekDatesArray = getWeekRange(-1);
            break;
        case "next":
            var weekDatesArray = getWeekRange(0);
            break;

        default:
            return false;
    }

    // after we get the weekDatesArray, we loop through each item using a foreach loop and call getDayActivityData function to get data for that specific day
    weekDatesArray.forEach(dateStr => {
        var dayName = getDayName(dateStr, "en-ZA");

        switch (dayName) {
            case "Monday":
                getDayAssessmentData(dateStr, grcode, '#weekly-assessment-h-scroll-weekday-card-varmonday');
                break;
            case "Tuesday":
                getDayAssessmentData(dateStr, grcode, '#weekly-assessment-h-scroll-weekday-card-vartuesday');
                break;
            case "Wednesday":
                getDayAssessmentData(dateStr, grcode, '#weekly-assessment-h-scroll-weekday-card-varwednesday');
                break;
            case "Thursday":
                getDayAssessmentData(dateStr, grcode, '#weekly-assessment-h-scroll-weekday-card-varthursday');
                break;
            case "Friday":
                getDayAssessmentData(dateStr, grcode, '#weekly-assessment-h-scroll-weekday-card-varfriday');
                break;
            case "Saturday":
                getDayAssessmentData(dateStr, grcode, '#weekly-assessment-h-scroll-weekday-card-varsaturday');
                break;
            case "Sunday":
                getDayAssessmentData(dateStr, grcode, '#weekly-assessment-h-scroll-weekday-card-varsunday');
                break;
            default:
                console.log("Error: no weekday output to pass to card. [$.populateWeeklyAssessmentsHorizCardContainer]: Day: " + dayName + " | grcode" + grcode);
                // alert("Error: no weekday output to pass to card. [$.populateWeeklyAssessmentsHorizCardContainer]: Day: " + dayName + " | grcode" + grcode);
                break;
        }
    });

    showSnackbar(`${capitalizeFirstLetter(when)} weeks assessment cards have been loaded.`);
}

// ***** Locaion: Modal
// ajax jquery - submit activity tracking data [Heart Rate]
$("#modal-heartrate-insights-activitytracker-data-form").submit(function (e) {
    e = e || window.event;
    e.preventDefault();
    e.stopImmediatePropagation();

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
    e = e || window.event;
    e.preventDefault();
    e.stopImmediatePropagation();

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
    e = e || window.event;
    e.preventDefault();
    e.stopImmediatePropagation();

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
    e = e || window.event;
    e.preventDefault();
    e.stopImmediatePropagation();

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
    e = e || window.event;
    e.preventDefault();
    e.stopImmediatePropagation();

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
    e = e || window.event;
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

    e.stopImmediatePropagation();
    return false;
});
// ./ ajax jquery - submit activity tracking data [Body Temp]

// ajax jquery - submit activity tracking data [Speed]
$("#single-speed-insights-activitytracker-data-form").submit(function (e) {
    e = e || window.event;
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

    e.stopImmediatePropagation();
    return false;
});
// ./ ajax jquery - submit activity tracking data [Speed]

// ajax jquery - submit activity tracking data [BMI Weight]
$("#single-weight-insights-activitytracker-data-form").submit(function (e) {
    e = e || window.event;
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

    e.stopImmediatePropagation();
    return false;
});
// ./ ajax jquery - submit activity tracking data [BMI Weight]


// ajax jquery - submit edited weekly teams activity data [Teams Submit Edited Activities Form]
$("#teams-add-new-day-activity-data-form").submit(function (e) {
    e = e || window.event;
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

    e.stopImmediatePropagation();
    return false;
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
    alert(`Flag: $.removeWeeklyTrainingActivity \n day: ${day} | grcode: ${groupRefCode} | exerciseID: ${exerciseID}`);
}
// <!-- ./ script for loading edit forms for weekly teams activities -->

// function to save custom color tag to db on form #add-new-activity-form
$.newCustomColorTag = function (tagColor) {
    try {
        var tagTitle = $('#add-to-calender-activity-custom-colorcode-title-value').val();
        tagTitle = tagTitle.split(' ').join('_'); // .replace(/ /g,"_"); replace empty space with underscore 
        var saveTagValue = $('#add-to-calender-activity-custom-colorcode-save-tag').val();
        var saveTag = false;

        if (tagTitle == "") {
            tagTitle = "color_tag";
        }

        switch (saveTagValue) {
            case 0:
                saveTag = false;
                break;
            case 1:
                saveTag = true;
                break;

            default:
                saveTag = false;
                break;
        }
        // create option child element inside #add-to-calender-activity-colorcode-value select element before the last child element (create custom tag option)
        $('#add-to-calender-activity-colorcode-value > option:last').before(`<option value="${tagTitle}[${tagColor}]" style="color: ${tagColor};"> ${tagTitle} </option>`);
        $("#add-to-calender-activity-colorcode-value").val(`${tagTitle}[${tagColor}]`);
        console.log(`$.newCustomColorTag\n tagTitle: ${tagTitle}\n saveTagValue: ${saveTagValue}\n saveTag: ${saveTag}`);
        return true;

        $.post('scripts/php/main_app/compile_content/fitness_insights_tab/activity_calender/new_teams_color_tag.php',  // url 
            {
                tag_name: tagTitle,
                tag_color: tagColor,
                save_tag: saveTag
            }, // data to be submit
            function (data, status, xhr) {   // success callback function
                alert('status: ' + status + ', \ndata: ' + data.responseData);
            },
            'json'); // response data format
    } catch (error) {
        console.log("Exception Error: [$.newCustomColorTag] \n" + error);
        return false;
    }
}

// function for sorting the select options - https://stackoverflow.com/questions/278089/javascript-to-sort-contents-of-select-element
function sortSelect(selElemID) {
    let selElem = document.getElementById(selElemID);
    var tmpAry = new Array();
    for (var i = 0; i < selElem.options.length; i++) {
        tmpAry[i] = new Array();
        tmpAry[i][0] = selElem.options[i].text;
        tmpAry[i][1] = selElem.options[i].value;
    }
    tmpAry.sort();
    while (selElem.options.length > 0) {
        selElem.options[0] = null;
    }
    for (var i = 0; i < tmpAry.length; i++) {
        var op = new Option(tmpAry[i][0], tmpAry[i][1]);
        selElem.options[i] = op;
    }
    return;
}

// move multiple list items between two multi-select elements
function moveItems(origin, dest) {
    $(origin).find(':selected').appendTo(dest);
}

function moveAllItems(origin, dest) {
    $(origin).children().appendTo(dest);
    $('#selected-xp-counter').html(`Total xp: 0 | 0 activities.`); //reset the selected xp count
}

function calculateWorkoutTotalXP() {
    // reinitialize the sumXP
    var sumXP = 0;
    var listCount = 0;
    $("#select-workout-exercises-selected > option").each(function () {
        // console.log(this.text + ' ' + this.value);
        // extract the exercise xp value from this.text
        var selectedExerciseText = this.text;

        sumXP += parseInt(selectedExerciseText.split('X[').pop().split(']P')[0])

        listCount += 1;
    });

    // update #selected-xp-counter field with sumXP value
    $('#selected-xp-counter').html(`Total xp: ${sumXP} | ${listCount} activities.`);
}

// move/add to selected list
$('#add-selection-to-activities-selectlist-btn').on('click', function () {
    // direction:  init to selected list
    moveItems('#add-to-calender-activity-selection', '#select-workout-exercises-selected');
    calculateWorkoutTotalXP();
});

// text-input: pass title and definitionstrings to selected list
$('#add-selection-to-activities-textinput-btn').on('click', function () {
    var newActivityTitle = $('#add-to-calender-activity-specify-title').val();
    var newActivityDefinition = $('#add-to-calender-activity-specify-new-instructions').val();
    var newActivityXP = $('#add-to-calender-activity-specify-xp').val();

    // check if input fields are empty, if true the warning alert message is displayed
    if (newActivityTitle == "" || newActivityDefinition == "" || newActivityXP == 0) {
        alert('Please provide a new activity title and a new activity definition and xp allocation.');
    } else {
        $('#select-workout-exercises-selected').append(`<option value="new_activity({title: '${newActivityTitle}', definition: '${newActivityDefinition}', xp_pts: ${newActivityXP}})" flagnew> ${newActivityTitle} - ( ${newActivityDefinition} ) X[${newActivityXP}]P </option>`);
    }

});

// remove selected item from selected list
$('#remove-selection-from-selected-activities-list-btn').on('click', function () {
    // direction: selected to init list
    moveItems('#select-workout-exercises-selected', '#add-to-calender-activity-selection');
    sortSelect('add-to-calender-activity-selection');
    calculateWorkoutTotalXP();
});
// remove all items in selected list to initial
$('#remove-all-from-selected-activities-list-btn').on('click', function () {
    // direction: selected to init list
    moveAllItems('#select-workout-exercises-selected', '#add-to-calender-activity-selection');
    sortSelect('add-to-calender-activity-selection');
    calculateWorkoutTotalXP();
});

// ** admin requests **
// get indi exercises items (called from app/index.php)
$.getIndiExercises = function (request, elemid) {

    var elemid = elemid || '#add-to-calender-activity-selection'; // initialize output elemid if it was not passed through params
    $.get("../administration/scripts/php/get_items/get_indi_exercises.php?giveme=" + request, function (data, status) {
        if (status != "success") {
            console.log("Get Req Failed -> $.getIndiExercises returned: \n[Status]: " + status + "\n[Data]: " + data);
            // alert("Get Req Failed -> $.getCommunityGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
            if (request == 'json') {
                console.log('Indi Exercises Json: \n'.data);
            } else {
                $(elemid).html(data);// '#add-to-calender-activity-selection'
            }
        }
    });
}

// function to auto-hide/show the side panels on page load
$.checkSidePanelVisibility = function () {
    var left_side_panel_visibility_state = localStorage.getItem('left_side_panel_visibility_state');
    var right_side_panel_visibility_state = localStorage.getItem('right_side_panel_visibility_state');

    if (left_side_panel_visibility_state != true) {
        $('#twitter-social-panel').addClass('d-none');
        // $.hideSingleSidePanel('#twitter-social-panel', 'left');
    }
    else {
        $('#twitter-social-panel').removeClass('d-none');
        // $.showSingleSidePanel('#twitter-social-panel', 'left');
    }

    if (right_side_panel_visibility_state != true) {
        $('#creation-tools-content-panel').addClass('d-none');
        // $.hideSingleSidePanel('#creation-tools-content-panel', 'left');
    }
    else {
        $('#creation-tools-content-panel').removeClass('d-none');
        // $.showSingleSidePanel('#creation-tools-content-panel', 'left');
    }
}

$.loadIframe = function (iframeName, url) {
    var $iframe = $('#' + iframeName);
    if ($iframe.length) {
        $iframe.attr('src', url);
        return false;
    }
    return true;
}


// if not set already, set default (visible) visibility state record on localstorage for side panels (twitter panel and create panel)
if (localStorage.getItem('left_side_panel_visibility_state') === null) localStorage.setItem('left_side_panel_visibility_state', true);
if (localStorage.getItem('right_side_panel_visibility_state') === null) localStorage.setItem('right_side_panel_visibility_state', true);
