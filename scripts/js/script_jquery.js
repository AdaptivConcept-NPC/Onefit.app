$(document).ready(function () {
  // load the chat conversations
  $.loadChatConversation = function (
    conversationId,
    currentUserUsrnm,
    conversationRef
  ) {
    // show #load-wait-screen-curtain
    $("#load-wait-screen-curtain").show();
    $.get(
      "../scripts/php/main_app/compile_content/communications_tab/get_user_chats.php?cref=" +
        conversationRef +
        "&cid=" +
        conversationId,
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.loadChatConversation returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          // alert("Get Req Failed -> $.loadChatConversation returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
          // pass returned data to #chat-message-container
          $("#chat-message-container").html(data);
          // smooth scroll to the last .row div in #chat-message-container
          $("#chat-message-container").animate(
            {
              scrollTop: $("#chat-message-container").prop("scrollHeight"),
            },
            1000
          );
        }
        setTimeout(() => {
          // hide #load-wait-screen-curtain
          $("#load-wait-screen-curtain").hide();
        }, 2000);
      }
    );
    // post request for the chat conversation
    // $.ajax({
    //     url: '../scripts/php/main_app/data_management/chat_data/get_chat_conversation.php',
    //     type: 'POST',
    //     data: {
    //         conversationId: conversationId,
    //         currentUserUsrnm: currentUserUsrnm,
    //         conversationRef: conversationRef
    //     },
    //     success: function(data) {
    //         //console.log(data);
    //         // parse the json data
    //         var chatConversation = JSON.parse(data);
    //         //console.log(chatConversation);
    //         //console.log(chatConversation[0].conversation_id);
    //         //console.log(chatConversation[0].conversation_title);
    //         //console.log(chatConversation[0].conversation_description);
    //         //console.log(chatConversation[0].conversation_created_by);
    //         //console.log(chatConversation[0].conversation_created_on);
    //         //console.log(chatConversation[0].conversation_last_updated);
    //         //console.log(chatConversation[0].conversation_last_updated_by);
    //         //console.log(chatConversation[0].conversation_last_updated_on);
    //         //console.log(chatConversation[0].conversation_status);
    //         //console.log(chatConversation[0].conversation_type);
    //         //console.log(chatConversation[0].conversation_members);
    //         //console.log(chatConversation[0].conversation_messages);
    //         //console.log(chatConversation[0].conversation_messages[0].message_id);
    //         //console.log(chatConversation[0].conversation_messages[0].message_content);
    //         //console.log(chatConversation[0].conversation_messages[0].message_created_by);
    //         //console.log(chatConversation[0].conversation_messages[0].message_created_on);
    //         //console.log(chatConversation[0].conversation_messages[0].message_status);
    //         //console.log(chatConversation[0].conversation_messages[0].message_type);
    //         //console.log(chatConversation[0].conversation_messages[0].message_attachments);
    //         //console.log(chatConversation[0].conversation_messages[0].message_attachments[0].attachment_id);
    //         //console.log(chatConversation[0].conversation_messages[0].message_attachments[0].attachment_name);
    //         //console.log(chatConversation[0].conversation_messages[0].message_attachments[0].attachment_type);
    //         //console.log(chatConversation[0].conversation_messages[0].message_attachments[0].attachment_size);
    //         //console.log(chatConversation[0].conversation_messages[0].message_attachments[0].attachment_url);
    //         //console.log(chatConversation[0].conversation_messages[0].message_attachments[0].attachment_created_by);
    //         //console.log(chatConversation[0].conversation_messages[0].message_attachments[
    //     }
    // });
  };

  // toggle notification indicator
  // state is a bool, icon is a string, priority is a bool
  $.toggleNotificationIndicator = function (state, icon, priority) {
    priority = priority || false;
    if (state === true) {
      $("#notification-indicator").show();
      $("#notification-indicator-icon").html(icon);

      if (priority === true) {
        document
          .getElementById("notification-indicator-icon")
          .classList.add("my-pulse-animation-light");
      }
    } else {
      $("#notification-indicator").hide();
      $("#notification-indicator-icon").html("pending");
      document
        .getElementById("notification-indicator-icon")
        .classList.remove("my-pulse-animation-light");
    }
  };

  // transfer activity calender html to #activities-calender-container
  $("#app-insights-btn").click(function () {
    // if #activities-calender-container is empty, move calender from training to ##activities-calender-container, else do nothing
    // !$.trim( $('#leftmenu').html() ).length src: http://stackoverflow.com/questions/4665466/ddg#4665468
    if ($.trim($("#activities-calender-container").html()).length) {
      var calenderLocationIndicator = `<div class="text-center fs-5 text-muted comfortaa-font my-5 p-4 border-1 border" style="border-radius: 15px;"> <span class="material-icons material-icons-round" style="font-size: 24px !important"> sports </span> Training tab. </div>`;

      var calenderHTML = localStorage.getItem("activity_calender_output"); // $('#training-tab-calender-container').html();

      $("#activities-calender-container").html(
        `<div id="activities-calender">${calenderHTML}</div>`
      );
      // replace with "Check widgets panel"
      $("#training-tab-calender-container").html(calenderLocationIndicator);
    }
  });

  // transfer activity calender html to #training-tab-calender-container
  $("#app-training-btn").click(function () {
    // if #activities-calender-container is empty, move calender from training to ##activities-calender-container, else do nothing
    // !$.trim( $('#leftmenu').html() ).length src: http://stackoverflow.com/questions/4665466/ddg#4665468
    if ($.trim($("#activities-calender-container").html()).length) {
      var calenderLocationIndicator = `<div class="text-center fs-5 text-muted comfortaa-font my-5 p-4 border-1 border" style="border-radius: 15px;"> <span class="material-icons material-icons-round" style="font-size: 24px !important"> sports </span> Training tab. </div>`;

      var calenderHTML = localStorage.getItem("activity_calender_output"); //$('#activities-calender-container').html();

      $("#training-tab-calender-container").html(
        `<div id="activities-calender">${calenderHTML}</div>`
      );
      // replace with "Check widgets panel"
      $("#activities-calender-container").html(calenderLocationIndicator);
    }
  });

  // jquery evelnt listerner for #open-widgets-panel-btn click
  $("#open-widgets-panel-btn").click(function () {
    // transfer #clock html content into #widgets-panel-clock,
    var clockHtml = `
            <div id="clock" class="dark my-4 shadow">
                <div class="display no-scroller">
                    <div class="weekdays"></div>
                    <div class="ampm"></div>
                    <div class="alarm"></div>
                    <div class="digits"></div>
                </div>
            </div>`;

    var widgetLocationIndicator = `<div class="text-center fs-5 text-muted comfortaa-font my-5 p-4 border-1 border" style="border-radius: 15px;"> <span class="material-icons material-icons-round" style="font-size: 24px !important"> interests </span> Widgets panel. </div>`;

    $("#widgets-panel-clock").html(clockHtml);
    // replace with "Check widgets panel"
    $("#dashboard-tab-clock").html(widgetLocationIndicator);

    // reload the digital clock script
    //source: https://stackoverflow.com/questions/9642205/how-to-force-a-script-reload-and-re-execute
    function reloadJs(src) {
      src = $('script[src$="' + src + '"]').attr("src");
      $('script[src$="' + src + '"]').remove();
      $("<script/>").attr("src", src).appendTo("head");
      //console log the script selector (test)
      console.log(
        'moving clock from Dashboard tab to Widgets panel | script[src$="' +
          src +
          '"]'
      );
    }

    reloadJs("../scripts/js/digital-clock.js");
  });

  // jquery evelnt listerner for #close-widgets-panel  click
  $("#close-widgets-panel").click(function () {
    // transfer #clock html content from #widgets-panel-clock, back to #dashboard-tab-clock
    var clockHtml = `
            <div id="clock" class="dark my-4 shadow">
                <div class="display no-scroller">
                    <div class="weekdays"></div>
                    <div class="ampm"></div>
                    <div class="alarm"></div>
                    <div class="digits"></div>
                </div>
            </div>`;

    var widgetLocationIndicator = `<div class="text-center fs-5 text-muted comfortaa-font my-5 p-4 border-1 border" style="border-radius: 15px;"> <span class="material-icons material-icons-round" style="font-size: 24px !important"> dashboard </span> Dashboard tab. </div>`;

    $("#dashboard-tab-clock").html(clockHtml);
    // replace with "Check widgets panel"
    $("#widgets-panel-clock").html(widgetLocationIndicator);

    // reload the digital clock script
    //source: https://stackoverflow.com/questions/9642205/how-to-force-a-script-reload-and-re-execute
    function reloadJs(src) {
      src = $('script[src$="' + src + '"]').attr("src");
      $('script[src$="' + src + '"]').remove();
      $("<script/>").attr("src", src).appendTo("head");
      //console log the script selector (test)
      console.log(
        'moving clock back to Dashboard tab | script[src$="' + src + '"]'
      );
    }

    reloadJs("../scripts/js/digital-clock.js");
  });

  // *** script.js functions

  // form validation
  // .needs-validation
  // (https://getbootstrap.com/docs/5.3/forms/validation/#server-side) Example starter JavaScript for disabling form submissions if there are invalid fields
  (() => {
    "use strict";

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll(".needs-validation");

    // Loop over them and prevent submission
    Array.from(forms).forEach((form) => {
      form.addEventListener(
        "submit",
        (event) => {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }

          form.classList.add("was-validated");
        },
        false
      );
    });
  })();

  // *** ./ script.js functions

  // *** script_jquery.js functions

  // add todays date as the default to all output labels with #training-week-date-range-input
  // document.getElementById('training-week-date-range-input').value = new Date().toDateInputValue();
  $(".training-week-date-range-input").val(new Date().toDateInputValue());

  // function to smooth scroll
  $.smoothScroll = function (containerElemID, scrollToElemID, scrollSpeed) {
    // scrollDirection = scrollDirection || "pageUp";
    scrollSpeed = scrollSpeed || 100;
    if (!containerElemID.startsWith("#")) {
      containerElemID = "#" + containerElemID;
    }
    if (!scrollToElemID.startsWith("#")) {
      scrollToElemID = "#" + scrollToElemID;
    }
    $(containerElemID).animate(
      {
        // "#main-form-window-scroll-container" [document.documentElement, document.body]
        scrollTop: $(scrollToElemID).offset().top, // "#user-welcome-header"
      },
      scrollSpeed
    );
    console.log(
      "smoothScroll: window.offset().top => " + $(scrollToElemID).offset().top
    );
  };

  // run function when scrolled to #main-content-container
  $(window).scroll(function () {
    // var left_side_panel_visibility_state = localStorage.getItem('left_side_panel_visibility_state');
    // var right_side_panel_visibility_state = localStorage.getItem('right_side_panel_visibility_state');

    var hT = $("#nav-bar-header").offset().top,
      hH = $("#nav-bar-header").outerHeight(),
      wH = $(window).height(),
      wS = $(this).scrollTop();
    // console.log('hT:\n' + hT + '\nhH:\n' + hH + '\nwH:\n' + wH + '\nwS:\n' + wS);
    if (wS == 0) {
      //(hT + hH - wH) | < is at the start (top) of element
      console.log("#nav-bar-header is in view! at the top");

      // assign top:5vh if wS is equal to 0
      $("#twitter-social-panel").css("top", "18vh");
      $("#creation-tools-content-panel").css("top", "18vh");

      // make sure to reset the margins to 0xp (deprecated)
      // $('#twitter-social-panel').css('margin-left', '0px');
      // $('#creation-tools-content-panel').css('margin-right', '0px');

      // remove fixed top class from main navbar
      if ($("#main-navbar").hasClass("fixed-top")) {
        $("#main-navbar").fadeOut(100);
        setTimeout(function () {
          // change bg color to dark
          $("#main-navbar").addClass("top-down-grad-dark");
          $("#main-navbar").removeClass("top-down-grad-tahiti");

          $("#main-navbar").css("border-radius", "25px");
          $("#main-navbar").removeClass("fixed-top");
          $("#main-navbar").fadeIn(300);
        }, 300);
      }
    } else {
      $("#twitter-social-panel").css("top", "25vh");
      $("#creation-tools-content-panel").css("top", "25vh");

      // make sure to reset the margins to 0xp (deprecated)
      // $('#twitter-social-panel').css('margin-left', '0px');
      // $('#creation-tools-content-panel').css('margin-right', '0px');

      // add fixed-top class to main navbar and set border radius to 0
      if (!$("#main-navbar").hasClass("fixed-top")) {
        $("#main-navbar").fadeOut(100);
        setTimeout(function () {
          // change bg color to tahiti (or light color)
          $("#main-navbar").addClass("top-down-grad-tahiti");
          $("#main-navbar").removeClass("top-down-grad-dark");

          $("#main-navbar").css("border-radius", "0px");
          $("#main-navbar").addClass("fixed-top");
          $("#main-navbar").fadeIn(300);
        }, 300);
      }
    }
  });

  // event listener for click on elems with .hide-side-panels
  $(".hide-side-panels").on("click", () => {
    // call $.hideSidePanelsDisplay function
    $.hideSidePanelsDisplay();
  });

  $(".hide-left-side-panels").on("click", () => {
    // hide only the left side panel
    $("#twitter-social-panel").addClass("d-none");
    localStorage.setItem("left_side_panel_visibility_state", false);
  });

  $(".hide-right-side-panels").on("click", () => {
    // hide only the right side panel
    $("#creation-tools-content-panel").addClass("d-none");
    localStorage.setItem("right_side_panel_visibility_state", false);
  });

  $.hideSidePanelsDisplay = function () {
    // $('#twitter-social-panel').css('margin-left', '-300px');
    // $('#creation-tools-content-panel').css('margin-right', '-300px');
    $("#twitter-social-panel").addClass("d-none");
    $("#creation-tools-content-panel").addClass("d-none");

    localStorage.setItem("left_side_panel_visibility_state", false);
    localStorage.setItem("right_side_panel_visibility_state", false);

    console.log("($.hideSidePanelsDisplay) side panels have been hidden");
  };

  // event listener for click on elems with .show-side-panels
  $(".show-side-panels").on("click", () => {
    // call $.showSidePanelsDisplay function
    $.showSidePanelsDisplay();
  });

  $(".show-left-side-panels").on("click", () => {
    // show only the left side panel
    $("#twitter-social-panel").removeClass("d-none");
    localStorage.setItem("left_side_panel_visibility_state", true);
  });

  $(".show-right-side-panels").on("click", () => {
    // show only the right side panel
    $("#creation-tools-content-panel").removeClass("d-none");
    localStorage.setItem("right_side_panel_visibility_state", true);
  });

  $.showSidePanelsDisplay = function () {
    // $('#twitter-social-panel').css('margin-left', '0px');
    // $('#creation-tools-content-panel').css('margin-right', '-0px');
    $("#twitter-social-panel").removeClass("d-none");
    $("#creation-tools-content-panel").removeClass("d-none");

    localStorage.setItem("left_side_panel_visibility_state", true);
    localStorage.setItem("right_side_panel_visibility_state", true);

    console.log("($.showSidePanelsDisplay) side panels have been shown");
  };

  // function for hiding single side panel
  $.hideSingleSidePanel = function (panelId, position) {
    // alert("panelId: " + panelId);
    if (!panelId.startsWith("#")) panelId = "#" + panelId;
    if (position === "left" || position === "right") {
      // update left_side_panel_visibility_state on localstorage
      switch (position) {
        case "left":
          localStorage.setItem("left_side_panel_visibility_state", false);
          break;
        case "right":
          localStorage.setItem("right_side_panel_visibility_state", false);
          break;

        default:
          break;
      }
      // change the margin to move panel out of viewport
      // $(panelId).css(`margin-${position}`, '-300px');
      $(panelId).addClass("d-none");
      console.log("($.hideSingleSidePanel) panel has been hidden: " + panelId);
    }
  };

  // onclick event listeners for apps tray open and close buttons
  $("#apps-tray-open-btn").on("click", () => {
    // $('#twitter-social-panel').css('margin-left', '-300px');
    // $('#creation-tools-content-panel').css('margin-right', '-300px');

    $.hideSidePanelsDisplay();

    console.log("#apps-tray-open-btn was clicked");
  });

  $("#apps-tray-close-btn").on("click", () => {
    // $('#twitter-social-panel').css('margin-left', '0px');
    // $('#creation-tools-content-panel').css('margin-right', '0px');

    $.showSidePanelsDisplay();

    console.log("#apps-tray-close-btn was clicked");
  });

  $("#main-nav-notifications-btn").on("click", () => {
    // $('#twitter-social-panel').css('margin-left', '-300px');

    $.hideSingleSidePanel("#twitter-social-panel", "left");

    console.log("#main-nav-notifications-btn was clicked");
  });

  $("#main-nav-ext-links-btn").on("click", () => {
    // $('#creation-tools-content-panel').css('margin-right', '-300px');

    $.hideSingleSidePanel("#creation-tools-content-panel", "right");

    console.log("#main-nav-ext-links-btn was clicked");
  });

  // Main App Refresh button onclick lister - function to toggle pulse animation from #main-app-refresh-btn
  $("#main-app-refresh-btn").on("click", () => {
    $("#main-app-refresh-btn").removeClass("my-pulse-animation-light");
    $("#main-app-refresh-btn").addClass("shadow");
  });

  // get store product items
  $.getStoreProducts = function (request, elemid) {
    var elemid = elemid || "#store-products-list"; // initialize output elemid if it was not passed through params
    $.get(
      "../scripts/php/main_app/compile_content/store_tab/wearables.php?giveme=" +
        request,
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getStoreProducts returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          // console log if json was requested
          if (request == "json") console.log("Store Products Json: \n" + data);
          else $(elemid).html(data); // '#store-products-list'
        }
      }
    );
  };

  $.getUserCart = function () {
    //$.get function that load content from php into #dynamic-user-cart on status: success
    $.get(
      "../scripts/php/main_app/compile_content/store_tab/user_cart_widget.php",
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getUserCart returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $("#dynamic-user-cart").html(data);
        }
      }
    );
  };

  $.getFitnessProgressionUIWidgets = function (username, widgetType) {
    // widgetType should either be bar or mini - strictly
    // scripts/php/main_app/compile_content/fitness_insights_tab/fitness_progression
    $.get(
      "../scripts/php/main_app/compile_content/fitness_insights_tab/fitness_progression/fp_widget.php?usnm=" +
        username +
        "&wtype=" +
        widgetType,
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getFitnessProgressionUIWidgets returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getFitnessProgressionUIWidgets returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          switch (widgetType) {
            case "bar":
              $(".bar-fpwidget").html(data);
              break;

            case "mini":
              $(".mini-fpwidget").html(data);
              break;

            default:
              var nowidget = `Please specify the widget type to display.`;
              $(".bar-fpwidget").html(nowidget);
              $(".mini-fpwidget").html(nowidget);
              break;
          }
        }
      }
    );
  };

  // get store products json - test
  $.getStoreProducts("json");

  // get Dashboard content - ajax
  $.getUserWeekActivities = function (username, elemId, queryDate) {
    elemId = elemId || ".general-weekly-activities-container";
    queryDate = formatDate(queryDate) || formatDate(Date.now()); // default: date today
    console.log(queryDate);
    $.get(
      "../scripts/php/main_app/compile_content/dashboard_tab/user_daily_activity_lineup.php?usnm=" +
        username +
        "&qdate=" +
        queryDate,
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getUserWeekActivities returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getUserWeekActivities returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $(elemId).html(data);
        }
      }
    );
  };

  // get team match schedule
  function getSchedule(grcode, elemId, periodRequest) {
    // if grcode is 'r' the assign grcode from localstorage
    if (grcode == "r") grcode = localStorage.getItem("grcode");

    $.get(
      "../scripts/php/main_app/compile_content/fitness_insights_tab/weekly_assesments_and_activities/get_match_schedules.php?grcode=" +
        grcode +
        "&period_req=" +
        periodRequest,
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getTeamMatchSchedule returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getTeamMatchSchedule returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $(elemId).html(data);
          console.log("Match schedule loaded:" + periodRequest);
        }
      }
    );

    showSnackbar(
      "Match schedule loaded:" + periodRequest,
      "alert_general",
      "short_5000"
    );
  }
  $.getTeamMatchSchedule = function (grcode) {
    grcode = grcode || localStorage.getItem("grcode");

    const periods = ["upcoming", "history"];

    periods.forEach((period) => {
      switch (period) {
        case "upcoming":
          getSchedule(
            grcode,
            "#teams-upcoming-match-schedule-tbody",
            "upcoming"
          );
          break;
        case "history":
          getSchedule(grcode, "#teams-match-history-tbody", "played");
          break;

        default:
          showSnackbar(
            "Error while compiling match schedules. Check console for more information.",
            "alert_general",
            "long_15000"
          );
          console.log(
            "Invalid period selector: Error while computing match schedules. Check console for more information -> " +
              period
          );
          break;
      }
    });
  };

  // get Profile content - ajax
  // user group subscriptions
  $.getUserProfileHeader = function (username) {
    $.get(
      "../scripts/php/main_app/compile_content/profile_tab/user_profile_header.php?usnm=" +
        username,
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getUserProfileHeader returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getUserProfileHeader returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $("#profile-header-container").html(data);
        }
      }
    );
  };

  // get user media files for profile tab and media tab
  $.getUsersMediaFiles = function () {
    var dirs = ["shared", "private", "video", "audio"];

    dirs.forEach((dir) => {
      // scripts/php/main_app/compile_content/media_tab/main_user_media_gallery.php
      $.get(
        "../scripts/php/main_app/compile_content/media_tab/main_user_media_gallery.php?dir=" +
          dir,
        function (data, status) {
          if (status != "success") {
            console.log(
              "Get Req Failed -> $.getUsersMediaFiles returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
            alert(
              "Get Req Failed -> $.getUsersMediaFiles returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
          } else {
            switch (dir) {
              case "shared":
                $(".shared-media-grid-container").html(data);
                break;
              case "private":
                $(".private-media-grid-container").html(data);
                break;
              case "video":
                $(".video-media-grid-container").html(data);
                break;
              case "audio":
                // $('#').html(data); do nothing, no container available atm
                console.log(
                  "$.getUsersMediaFiles -> Audio gallery unavailable."
                );
                break;

              default:
                break;
            }
          }
        }
      );
    });
  };

  $.getUserCommunityGroupSubs = function () {
    $.get(
      "../scripts/php/main_app/compile_content/profile_tab/get_user_community_group_subs.php?entry=init",
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getUserCommunityGroupSubs returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getUserCommunityGroupSubs returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $("#user-community-groups-subs-list").html(data);
        }
      }
    );
  };
  $.getUserTeamsGroupSubs = function () {
    $.get(
      "../scripts/php/main_app/compile_content/profile_tab/get_user_teams_group_subs.php?entry=init",
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getUserTeamsGroupSubs returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getUserTeamsGroupSubs returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $("#user-teams-groups-subs-list").html(data);
        }
      }
    );
  };
  $.getUserProGroupSubs = function () {
    $.get(
      "../scripts/php/main_app/compile_content/profile_tab/get_user_pro_group_subs.php?entry=init",
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getUserProGroupSubs returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getUserProGroupSubs returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $("#user-pro-groups-subs-list").html(data);
        }
      }
    );
  };

  // complete group lists
  $.getCommunityGroups = function () {
    $.get(
      "../scripts/php/main_app/compile_content/community_content/community_groups.php?entry=init",
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getCommunityGroups returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getCommunityGroups returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $("#community-groups-full-list").html(data);
        }
      }
    );
  };
  $.getTeamsGroups = function () {
    $.get(
      "../scripts/php/main_app/compile_content/teams_content/teams_groups.php?entry=init",
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getTeamsGroups returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getTeamsGroups returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $("#teams-groups-full-list").html(data);
        }
      }
    );
  };
  $.getProGroups = function () {
    $.get(
      "../scripts/php/main_app/compile_content/premium_content/pro_groups.php?entry=init",
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getProGroups returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getProGroups returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $("#pro-groups-full-list").html(data);
        }
      }
    );
  };
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
    var mediaClassArray = ["shared", "private", "videos"];

    mediaClassArray.forEach((mClass) => {
      $.get(
        "../scripts/php/main_app/compile_content/media_tab/main_user_media_gallery.php?dir=" +
          mClass,
        function (data, status) {
          if (status != "success") {
            console.log(
              "Get Req Failed -> $.getMediaTabContent returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
            alert(
              "Get Req Failed -> $.getMediaTabContent returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
          } else {
            switch (weekday) {
              case "shared":
                $("#shared-media-grid-container").html(data);
                break;
              case "private":
                $("#private-media-grid-container").html(data);
                break;
              case "videos":
                $("#video-media-grid-container").html(data);
                break;

              default:
                console.log(
                  "Error [$.getMediaTabContent]: mClass/Directory: " + mClass
                );
                break;
            }
          }
        }
      );
    });
  };

  // compile Communications content - ajax

  // compile Messages content - ajax

  // compile Preferences content - ajax

  // get teams group information - select input list
  $.getTeamsSelectInputList = function (privacyType) {
    //
    $.get(
      "../scripts/php/main_app/compile_content/fitness_insights_tab/training/teams/get_teams_groups_list.php?get_privacy=" +
        privacyType,
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getTeamsSelectInputList returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getTeamsSelectInputList returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $("#formation-team-selection").html(data);
          $(".team-selection-list").html(data);
        }
      }
    );
  };

  // get sports information - select input list
  $.getSportsSelectInputList = function (sportCategory) {
    sportCategory = sportCategory || "all";
    //
    $.get(
      "../scripts/php/main_app/compile_content/fitness_insights_tab/training/teams/get_sports_list.php?sp-category=" +
        sportCategory,
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getSportsSelectInputList returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getSportsSelectInputList returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          $(".sport-selection-list").html(data);
        }
      }
    );
  };

  // get teams group information - table of group members
  $.getTeamsGroupMembersTableItems = function (grcode) {
    const membersReqArray = ["starting", "benched", "reserve", "technical"];

    var outputElemId = null;
    var output = null;

    function getRequestedGMList(grcode, memberItem, outputElemId) {
      $.get(
        "../scripts/php/main_app/compile_content/fitness_insights_tab/training/teams/get_teams_group_members.php?grc=" +
          grcode +
          "&memtype=" +
          memberItem,
        function (data, status) {
          if (status != "success") {
            console.log(
              "Get Req Failed -> $.getRequestedGMList returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
            alert(
              "Get Req Failed -> $.getRequestedGMList returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
          } else {
            $(outputElemId).html(data);
          }
        }
      );
    }

    membersReqArray.forEach((memberItem) => {
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
          return alert(
            "($.getTeamsGroupMembersTableItems) Requested type not supported. type:[ " +
              memberItem +
              " ]"
          );
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
  };

  // get json data for players
  // function getRequestedGMJSONList(grcode) {}
  function getRequestedGMJSONList(grcode) {
    const memtype = "starting";
    $.get(
      "../scripts/php/main_app/compile_content/fitness_insights_tab/training/teams/get_teams_group_members.php?returntype=json&grc=" +
        grcode +
        "&memtype=" +
        memtype,
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getRequestedGMJSONList returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getRequestedGMJSONList returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          return false;
        } else {
          console.log("Successfull response: \n" + JSON.stringify(data));

          let responseJSONData = data; // data; //we used JSON_PRETTY_PRINT param on json_encode in php
          console.log("responseJSONData:");
          console.log(responseJSONData);

          return responseJSONData;

          // let responseJSONData = data; //JSON.parse(data);
          // console.log("responseJSONData");
          // console.log(responseJSONData);

          // var playerData = [];
          // // responseJSONData.forEach(record => {
          // //     playerData.push(`{name: '${responseJSONData['user_name']} ${responseJSONData['user_surname']}', position: '${responseJSONData['field_position']}', img: '../media/profiles/0_default/soccer-player.png'}`);
          // // });
          // // this is the way!!! - source: https://www.sitepoint.com/loop-through-json-response-javascript/
          // // https://masteringjs.io/tutorials/fundamentals/foreach-object
          // Object.entries(responseJSONData).forEach((entry) => {
          //     const [key, value] = entry;
          //     var user_name, user_surname, field_position;
          //     // console.log(entry);
          //     console.log(`${key}: ${value}`);
          //     if (key === 'user_name') {
          //         user_name = value;
          //     } else if (key === 'user_surname') {
          //         user_surname = value;
          //     } else if (key === 'field_position') {
          //         field_position = value;
          //     }
          //     playerData.push(`{name: '${user_name} ${user_surname}', position: '${field_position}', img: '../media/profiles/0_default/soccer-player.png'}`);
          // });
          // console.log("players array (mapped): \n" + playerData);
          // *** TESTING ********************************
        }
      }
    );
  }

  $.initializeSoccerfieldFormation = function (grcode) {
    // soccer field player formation

    var playerPositionData = [];
    // {
    //     name: 'KEYLOR NAVAS',
    //     position: 'C_GK',
    //     img: '../media/profiles/0_default/soccer-player.png'
    // },
    // {
    //     name: 'MARCELO',
    //     position: 'LC_B',
    //     img: '../media/profiles/0_default/soccer-player.png'
    // },
    // {
    //     name: 'SERGIO RAMOS',
    //     position: 'C_B',
    //     img: '../media/profiles/0_default/soccer-player.png'
    // },
    // {
    //     name: 'CARVAJAL',
    //     position: 'RC_B',
    //     img: '../media/profiles/0_default/soccer-player.png'
    // },
    // {
    //     name: 'CASEMIRO',
    //     position: 'C_DM',
    //     img: '../media/profiles/0_default/soccer-player.png'
    // },
    // {
    //     name: 'KROOS',
    //     position: 'L_M',
    //     img: '../media/profiles/0_default/soccer-player.png'
    // },
    // {
    //     name: 'ISCO',
    //     position: 'LC_M',
    //     img: '../media/profiles/0_default/soccer-player.png'
    // },
    // {
    //     name: 'ASENSIO',
    //     position: 'RC_M',
    //     img: '../media/profiles/0_default/soccer-player.png'
    // },
    // {
    //     name: 'MODRIC',
    //     position: 'R_M',
    //     img: '../media/profiles/0_default/soccer-player.png'
    // },
    // {
    //     name: 'RONALDO',
    //     position: 'LC_F',
    //     img: '../media/profiles/0_default/soccer-player.png'
    // },
    // {
    //     name: 'BENZEMA',
    //     position: 'RC_F',
    //     img: '../media/profiles/0_default/soccer-player.png'
    // },

    const memtype = "starting";
    $.get(
      "../scripts/php/main_app/compile_content/fitness_insights_tab/training/teams/get_teams_group_members.php?returntype=json&grc=" +
        grcode +
        "&memtype=" +
        memtype,
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getRequestedGMJSONList returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getRequestedGMJSONList returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          return false;
        } else {
          console.log("Successfull response: \n" + JSON.stringify(data));

          let responseJSONData = data; // data; //we used JSON_PRETTY_PRINT param on json_encode in php
          console.log("responseJSONData:");
          console.log(responseJSONData);

          playerPositionData.push(responseJSONData);
          console.log(playerPositionData);
        }
      }
    );

    // let getPlayerPosJSON = getRequestedGMJSONList(grcode);

    // playerPositionData.push(getPlayerPosJSON);
    // console.log(playerPositionData);

    function getKeyByValue(object, value) {
      return Object.keys(object).find((key) => object[key] === value);
    }

    // let fieldPositionDataArray = [];

    // fieldPositionDataArray = JSON.parse(getRequestedGMJSONList(grcode));
    // console.log("fieldPositionDataArray \n" + fieldPositionDataArray);

    // create api to get json data from our database
    // run getRequestedGMJSONList function to test what output we get
    // let compiledPlayerPositionData = getRequestedGMJSONList(grcode);

    // console.log("compiledPlayerPositionData: \n" + compiledPlayerPositionData);

    if (playerPositionData !== false) {
      // clear the #soccefield container
      $("#soccerfield").empty();
      // compile initialize soccerfield
      $("#soccerfield").soccerfield(playerPositionData, {
        field: {
          width: "960px",
          height: "600px",
          img: "../media/assets/field_diagrams/soccer-field-dimensions-1.jpg",
          startHidden: false,
          animate: false,
          fadeTime: 1000,
          autoReveal: false,
          onReveal: function () {
            // triggered on reveal
            showSnackbar("Field - Soccerfield loaded.");
            console.log("Field - Soccerfield loaded.");
          },
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
            showSnackbar("Players - Soccerfield plugin has been loaded.");
            console.log("Players - soccerfield plugin has been loaded.");
          },
        },
      });
    }
  };

  $.fetchTeamData = function (grcode) {
    //alert("($.fetchTeamData) group ref code from this.value: " + grcode);

    // compile player position data array from a php.get function for starting lineup players
    $.initializeSoccerfieldFormation(grcode);

    // retrieve the text of the selected team item in the #formation-team-selection elem - http://stackoverflow.com/questions/610336/ddg#610344
    function getSelectedText(elementId) {
      var elt = document.getElementById(elementId);

      if (elt.selectedIndex == -1) return null;

      return elt.options[elt.selectedIndex].text;
    }

    var panelHeaderText = getSelectedText("formation-team-selection");

    // show #formation-guidelines-container
    $("#formation-guidelines-container").show();
    // show #formation-title
    $("#formation-title").show();

    $("#offcanvasTeamFormationLabel").text(panelHeaderText);

    $("#loading-formation-data-spinner").show();
    $.getTeamsGroupMembersTableItems(grcode);
    $("#loading-formation-data-spinner").hide();
    // $.get("../scripts/php/main_app/compile_content/fitness_insights_tab/training/teams/get_teams_formation_data.php?grc=" + grcode, function (data, status) {

    //     if (status != "success") {
    //         console.log("Get Req Failed -> $.fetchTeamData returned: \n[Status]: " + status + "\n[Data]: " + data);
    //         alert("Get Req Failed -> $.fetchTeamData returned: \n[Status]: " + status + "\n[Data]: " + data);
    //     } else {
    //         $('#addOutputIDHere').html(data);
    //     }
    // });
  };

  // get user activity timeline
  $.getUserActivityTimeline = function (username) {
    // scripts/php/main_app/compile_content/fitness_insights_tab/activity_timeline/get_user_activity_history.php
    $.get(
      "../scripts/php/main_app/compile_content/fitness_insights_tab/activity_timeline/get_user_activity_history.php?usernm=" +
        username,
      function (data, status) {
        // console.log("getUserActivityTimeline returned: \n[Status]: " + status + "\n[Data]: " + data);

        if (status != "success") {
          // provide an error message
          console.log(
            "Get Req Failed -> $.getUserActivityTimeline returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.getUserActivityTimeline returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          // populate the activity timeline container
          $("#user-activity-timeline").html(data);

          // enclose the entry ref (attr: data-barcode) in the description container with a class, barcode-font
          // $('[data-barcode=true]')
          $("span[data-barcode]").attr("class", "barcode-font");
          $("span[data-barcode]").attr("style", "font-size: 10px!important;");
        }
      }
    );
  };

  // *** training interactions tabs
  // get users challenges
  $.getUserChallenges = function (username) {
    // perform a for loop to loop through workoutFreq array
    const workoutCycle = ["daily", "weekly"];
    workoutCycle.forEach((cycle) => {
      // scripts/php/main_app/compile_content/fitness_insights_tab/training/challenges/get_user_challenges.php
      $.get(
        "../scripts/php/main_app/compile_content/fitness_insights_tab/training/challenges/get_user_challenges.php?usernm=" +
          username +
          "&cycle=" +
          cycle,
        function (data, status) {
          // console.log("getUserChallenges returned: \n[Status]: " + status + "\n[Data]: " + data);

          if (status != "success") {
            // provide an error message
            console.log(
              "Get Req Failed -> $.getUserChallenges returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
            alert(
              "Get Req Failed -> $.getUserChallenges returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
          } else {
            switch (cycle) {
              case "daily":
                // populate the #daily-challenges-grid containers
                $(".daily-challenges-grid").html(data);

                break;
              case "weekly":
                // populate the #weekly-challenges-grid containers
                $(".weekly-challenges-grid").html(data);
                break;

              default:
                return console.log(
                  "error: unknown frequency detected ($.getUserChallenges)"
                );
            }
          }
        }
      );
    });
  };

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
      requestFormat = requestFormat || "ui_default";

      $.get(
        "../scripts/php/main_app/compile_content/fitness_insights_tab/activity_tracking/tracker_stats_widget.php?request=" +
          requestFormat,
        function (data, status) {
          // console.log("getActivityTrackerStatsWidget returned: \n[Status]: " + status + "\n[Data]: " + data);

          if (status != "success") {
            // provide an error message
            console.log(
              "Get Req Failed -> $.getActivityTrackerStatsSummaryWidget returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
            alert(
              "Get Req Failed -> $.getActivityTrackerStatsSummaryWidget returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
          } else {
            // update the stats in the main widget on the insights tab. We will call a specific function that get the stats in json format and stores the json to localstorage
            switch (requestFormat) {
              case "ui_default":
                // ui returns and push it to the elems with .activity-tracker-stats-widget-container
                $(".activity-tracker-stats-widget-container").html(data);
                break;
              case "json":
                // store results in localstorage and push/map values to the ui elems on the main widget on the insights tab
                localStorage.setItem("ActivityTrackerStatsSummaryJson", data);
                console.log(
                  "($.getActivityTrackerStatsSummaryWidget) Returned JSON: \n" +
                    data
                );
                // alert("Output Test - Check JSON output on the console."); //test notification
                // we will take the values returned from the json object and pass them to the main activity tracker stats widget ui on the insights tab
                let summaryStatsJsonData = JSON.parse(data);

                // 'averageHeartrate' => null, 'averageTemp' => null, 'averageSpeed' => null, 'totalSteps' => null
                $(".heartrate-avg-stat").html(
                  summaryStatsJsonData["averageHeartrate"]
                );
                $(".temp-avg-stat").html(summaryStatsJsonData["averageTemp"]);
                $(".speed-avg-stat").html(summaryStatsJsonData["averageSpeed"]);
                $(".steps-taken-stat").html(summaryStatsJsonData["totalSteps"]);
                $(".avg-bmi-stat").html(summaryStatsJsonData["averageBMI"]);

                // go back to the locally stored chart js json data and get the latest entries or max entries according to the requirments of the various tracked data types
                // heartrate - get the highest heart rate
                let highestHeartrateEntry = getMax(
                  JSON.parse(
                    localStorage.getItem("heart_rate_monitor_chart_data")
                  ),
                  "bpm"
                );
                $(".latest-heartrate-entry-value").html(
                  highestHeartrateEntry["bpm"] + " bpm"
                );
                $(".avg-heartrate-latest-update-datetime").html(
                  moment(
                    highestHeartrateEntry["date"] +
                      " " +
                      highestHeartrateEntry["time"]
                  ).fromNow()
                );
                // temperature
                let highestTempEntry = getMax(
                  JSON.parse(
                    localStorage.getItem("body_temp_monitor_chart_data")
                  ),
                  "temperature"
                );
                $(".latest-temp-entry-value").html(
                  highestTempEntry["temperature"] + " °C"
                );
                $(".avg-temp-latest-update-datetime").html(
                  moment(
                    highestTempEntry["date"] + " " + highestTempEntry["time"]
                  ).fromNow()
                );
                // speed
                let highestSpeedEntry = getMax(
                  JSON.parse(localStorage.getItem("speed_monitor_chart_data")),
                  "speed"
                );
                $(".highest-speed-entry-value").html(
                  highestSpeedEntry["speed"] + " m/s"
                );
                $(".highest-speed-entry-datetime").html(
                  moment(
                    highestSpeedEntry["date"] + " " + highestSpeedEntry["time"]
                  ).fromNow()
                );
                // steps - using fitbit data if available
                // weight / bmi
                let highestBMIEntry = getMax(
                  JSON.parse(
                    localStorage.getItem("bmi_weight_monitor_chart_data")
                  ),
                  "bmi"
                );
                $(".latest-bmi-entry-value").html(
                  highestBMIEntry["bmi"] +
                    " (weight: " +
                    highestBMIEntry["weight"] +
                    ")"
                );
                $(".bmi-latest-update-datetime").html(
                  moment(
                    highestBMIEntry["date"] + " " + highestBMIEntry["time"]
                  ).fromNow()
                );
                break;

              default:
                // request format is unknown. console log and notify user
                console.log(
                  "($.getActivityTrackerStatsSummaryWidget) Requested unknown request format: " +
                    requestFormat
                );
                alert(
                  "Activity Tracker Summary Stats Widget Error \nRequested unknown request format: " +
                    requestFormat
                );
                break;
            }
          }
        }
      );
    }

    const requestFormats = ["ui_default", "json"];

    requestFormats.forEach((reqformat) => {
      compileWidget(reqformat);
    });
  };

  $.trainingSubTabMainTeamSelection = function (team_grcode) {
    let mainTeamSelectionGRCode = team_grcode;

    if (mainTeamSelectionGRCode == "noselection") {
      alert("Please select a team from the Switch Team Selection.");
      // console.log focus event
      console.log(
        "[$.trainingSubTabMainTeamSelection] focus event: #trainingSubTabMainTeamSelection"
      );
      $("#trainingSubTabMainTeamSelection").focus();
    } else {
      // store grpRefcode locally so we can access it later
      grpRefcode = mainTeamSelectionGRCode;
      // localStorage.setItem('teams_training_main_grcode', grpRefcode);
      $.setDefaultTeamSelect(grpRefcode);

      // *** fetch training data for selected team (grcode) and update the UI ***
    }
  };

  // load Teams Activity Capturing Form
  $.loadTeamsActivityCaptureForm = function (day, grpRefcode) {
    console.log("$.loadTeamsActivityCaptureForm Day: " + day);
    // alert("../scripts/php/main_app/data_management/system_admin/team_athletics_data/compile_teams_add_new_activity_day_form.php?day=" + day + "&gref=" + grpRefcode);

    // show the elem with id #question-6-activities
    document.getElementById("question-6-activities").style.display = "block";

    // get the currently selected teams grcode from #trainingSubTabMainTeamSelection :. onchange func for this elem is $.trainingSubTabMainTeamSelection
    let mainTeamSelectionGRCode = $("#trainingSubTabMainTeamSelection").val(); // or
    // let mainTeamSelectionGRCode = localStorage.getItem('teams_training_main_grcode');

    if (mainTeamSelectionGRCode == "noselection") {
      alert(
        "Please select a team from the Switch Team Selection and try again."
      );
      // smooth scroll - do not smooth scroll to the #trainingSubTabMainTeamSelection elem as it is already in view
      // $.smoothScroll('#v-sub-tab-pills-insights-teamathletics', '#trainingSubTabMainTeamSelection');
      // click the #collapseTeamSelectBtn elem to show the collapseed team selection panel
      $("#collapseTeamSelectBtn").click();
      // console.log focus event
      console.log(
        "[$.loadTeamsActivityCaptureForm] focus event: #trainingSubTabMainTeamSelection"
      );
      // set focus
      $("#trainingSubTabMainTeamSelection").focus();
    } else {
      // store grpRefcode locally so we can access it later
      grpRefcode = mainTeamSelectionGRCode;
      localStorage.setItem("grcode", grpRefcode);

      // get - compile the preview column-bar content
      $.get(
        "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/compile/compile_teams_day_activities_preview_column_bar.php?day=" +
          day +
          "&gref=" +
          grpRefcode,
        function (data, status) {
          console.log(
            "loadTeamsActivityCaptureForm returned [GET 1]: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );

          if (status != "success") {
            // provide an error message
            console.log(
              "Get Req Failed -> $.loadTeamsActivityCaptureForm returned [GET 1]: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
            alert(
              "Get Req Failed -> $.loadTeamsActivityCaptureForm returned [GET 1]: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
            showSnackbar("Failed to Load Activities Bar Preview.");
          } else {
            // populate the modal body
            $("#display-activity-bar-preview").html(data);
            // $('#toggleTabeditWeeklyTeamsTrainingScheduleModalBtn').click();
            // showSnackbar("Activities Bar Preview Loaded.");
          }
        }
      );

      // move html inside #add-new-schedule-form-container to #add-new-day-activity-form-container
      /* $("#add-new-day-activity-form-container").html(
        $("#add-new-schedule-form-container").html()
      ); */

      // place location indicator in the #add-new-schedule-form-container
      /* var widgetLocationIndicator = `
        <div class="text-center fs-5 text-muted comfortaa-font my-5 p-4 border-1 border" 
          style="border-radius: 15px;"> 
            <span class="material-icons material-icons-round" style="font-size: 24px !important"> 
              form </span> Editing Day Schedule. 
        </div>`;
      $("#add-new-schedule-form-container").html(widgetLocationIndicator); */

      // clear #add-new-schedule-form-container
      $("#add-new-schedule-form-container").html("");

      // get - compile the data update form
      $.get(
        "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/compile/compile_teams_schedule_activity_submit_form.php?day=" +
          day +
          "&gref=" +
          grpRefcode,
        function (data, status) {
          console.log(
            "loadTeamsActivityCaptureForm returned [GET 2]: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );

          if (status != "success") {
            // provide an error message
            console.log(
              "Get Req Failed -> $.loadTeamsActivityCaptureForm returned [GET 2]: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
            alert(
              "Get Req Failed -> $.loadTeamsActivityCaptureForm returned [GET 2]: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
            showSnackbar("Failed to Load Activities Bar Preview.");
          } else {
            // check the returned result, if equals to "new_schedule_form" then transfer form html inside #add-new-schedule-form-container elem to #add-new-day-activity-form-container elem
            if (data == "new_schedule_form") {
              // transfer form html inside #add-new-schedule-form-container elem to #add-new-day-activity-form-container elem
              let newScheduleForm = $(
                "#add-new-schedule-form-container"
              ).html();
              console.log("New Schedule Form: \n" + newScheduleForm);
              $("#add-new-day-activity-form-container").html(newScheduleForm);
              // update the date and day
              $("#add-to-calender-activity-day-value").val(day);
              $("#add-to-calender-activity-date-value").val(
                formatDate(Date.now())
              );
            } else {
              console.log("Returned data: \n" + data);
              // populate the modal body
              $("#add-new-day-activity-form-container").html(data);
            }

            // showSnackbar("Add exercise / activity form loaded.");
          }
        }
      );

      //
      $("#toggleTabeditWeeklyTeamsTrainingScheduleModalBtn").click();
    }
  };

  $.setDefaultTeamSelect = function (grcode) {
    // location: 'main','fixture'
    localStorage.setItem("teams_training_main_grcode", grcode);
  };

  $.getDefaultTeamSelect = function () {
    // if 'teams_training_main_grcode' is not set in localstorage, set "noselection"
    if (localStorage.getItem("teams_training_main_grcode") == null) {
      localStorage.setItem("teams_training_main_grcode", "noselection");
    } else {
      let DefaultTeamSelect = localStorage.getItem(
        "teams_training_main_grcode"
      );

      // select item with value=DefaultTeamSelect .team-selection-list
      // $('.team-selection-list').val(DefaultTeamSelect).change();

      // foreach node in .team-selection-list, change selected item with value
      $(".team-selection-list").each(function () {
        if ($(this).val() == DefaultTeamSelect) {
          $(this).attr("selected", "selected");
        }
      });
    }
  };

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
  };

  // function to get the #training-week-date-range-input selected date and sync the Weekly Training Activities in the activity bar chart
  $.getRequestedTrainingWeekActivities = function () {
    // get the #training-week-date-range-input selected date
    var rangeDate = new Date($("#training-week-date-range-input").val());

    // call function to sync the Weekly Training Activities in the activity bar chart
    $.populateWeeklyActivityBarChart("specific_range", null, true, rangeDate);
  };

  $.populateWeeklyActivityBarChart = function (
    when,
    grcode,
    dateQuery,
    dateQueryStr
  ) {
    // when is the week request (this/last/next week)
    when = when || "this";
    grcode = grcode || localStorage.getItem("teams_training_main_grcode"); // 'test_grp_001'; // get the local stored global grcode
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
    const loadingIndicator = `<div class="d-flex justify-content-center">
                    <div class="spinner-grow" style="width:3rem;height3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>`;
    $("#day-1-col").html(loadingIndicator);
    $("#day-2-col").html(loadingIndicator);
    $("#day-3-col").html(loadingIndicator);
    $("#day-4-col").html(loadingIndicator);
    $("#day-5-col").html(loadingIndicator);
    $("#day-6-col").html(loadingIndicator);
    $("#day-7-col").html(loadingIndicator);

    showSnackbar(`Loading ${when} weeks activities.`);

    // var weekDaysArray = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    // alert("JQuery AJAX populateWeeklyActivityBarChart");

    function getDayActivityData(dateStr, grcode, elemId) {
      $.get(
        "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/compile/compile_teams_daily_activities.php?date=" +
          dateStr +
          "&grcode=" +
          grcode,
        function (data, status) {
          if (status != "success") {
            console.log(
              "Get Req Failed -> $.populateWeeklyActivityBarChart returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
            alert(
              "Get Req Failed -> $.populateWeeklyActivityBarChart returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
          } else {
            $(elemId).html(data);
          }
        }
      );
    }

    // for each date from getWeekRange array we received, make a request for the bar/column data
    // use -1 for last week, 0 for this week and 1 for next week
    var snackbarOutput = "";
    var weekDatesArray = [];
    switch (when) {
      case "last":
        weekDatesArray = getWeekRange(-1);
        snackbarOutput = `${capitalizeFirstLetter(
          when
        )} weeks actvities bar chart has been loaded.`;
        break;
      case "this":
        weekDatesArray = getWeekRange(0);
        snackbarOutput = `${capitalizeFirstLetter(
          when
        )} weeks actvities bar chart has been loaded.`;
        break;
      case "next":
        weekDatesArray = getWeekRange(1);
        snackbarOutput = `${capitalizeFirstLetter(
          when
        )} weeks actvities bar chart has been loaded.`;
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
    weekDatesArray.forEach((dateStr) => {
      var dayName = getDayName(dateStr, "en-ZA");

      switch (dayName) {
        case "Monday":
          // execute function to get the current dates activity data
          getDayActivityData(dateStr, grcode, "#day-1-col");

          break;
        case "Tuesday":
          getDayActivityData(dateStr, grcode, "#day-2-col");
          break;
        case "Wednesday":
          getDayActivityData(dateStr, grcode, "#day-3-col");
          break;
        case "Thursday":
          getDayActivityData(dateStr, grcode, "#day-4-col");
          break;
        case "Friday":
          getDayActivityData(dateStr, grcode, "#day-5-col");
          break;
        case "Saturday":
          getDayActivityData(dateStr, grcode, "#day-6-col");
          break;
        case "Sunday":
          getDayActivityData(dateStr, grcode, "#day-7-col");
          break;

        default:
          console.log(
            "Error [$.populateWeeklyActivityBarChart]: Day: " +
              dayName +
              " | grcode" +
              grcode
          );
          // alert("Error [$.populateWeeklyActivityBarChart]: Day: " + dayName + " | grcode" + grcode);
          break;
      }
    });

    showSnackbar(snackbarOutput);
  };

  $.populateWeeklyAssessmentsHorizCardContainer = function (when, grcode) {
    when = when || "this";
    grcode = grcode || "all";

    // show the loading indicator/spinners on each card / bar
    const loadingIndicator = `<div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>`;
    $("#weekly-assessment-h-scroll-weekday-card-varmonday").html(
      loadingIndicator
    );
    $("#weekly-assessment-h-scroll-weekday-card-vartuesday").html(
      loadingIndicator
    );
    $("#weekly-assessment-h-scroll-weekday-card-varwednesday").html(
      loadingIndicator
    );
    $("#weekly-assessment-h-scroll-weekday-card-varthursday").html(
      loadingIndicator
    );
    $("#weekly-assessment-h-scroll-weekday-card-varfriday").html(
      loadingIndicator
    );
    $("#weekly-assessment-h-scroll-weekday-card-varsaturday").html(
      loadingIndicator
    );
    $("#weekly-assessment-h-scroll-weekday-card-varsunday").html(
      loadingIndicator
    );

    showSnackbar(`Loading ${when} weeks assessments.`);

    function getDayAssessmentData(dateStr, grcode, elemId) {
      $.get(
        "../scripts/php/main_app/compile_content/profile_tab/get_users_daily_assessments_and_activities_list.php?date=" +
          dateStr +
          "&grcode=" +
          grcode,
        function (data, status) {
          if (status != "success") {
            console.log(
              "Get Req Failed -> $.populateWeeklyAssessmentsHorizCardContainer returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
            alert(
              "Get Req Failed -> $.populateWeeklyAssessmentsHorizCardContainer returned: \n[Status]: " +
                status +
                "\n[Data]: " +
                data
            );
          } else {
            $(elemId).html(data);
          }
        }
      );
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
    weekDatesArray.forEach((dateStr) => {
      var dayName = getDayName(dateStr, "en-ZA");

      switch (dayName) {
        case "Monday":
          getDayAssessmentData(
            dateStr,
            grcode,
            "#weekly-assessment-h-scroll-weekday-card-varmonday"
          );
          break;
        case "Tuesday":
          getDayAssessmentData(
            dateStr,
            grcode,
            "#weekly-assessment-h-scroll-weekday-card-vartuesday"
          );
          break;
        case "Wednesday":
          getDayAssessmentData(
            dateStr,
            grcode,
            "#weekly-assessment-h-scroll-weekday-card-varwednesday"
          );
          break;
        case "Thursday":
          getDayAssessmentData(
            dateStr,
            grcode,
            "#weekly-assessment-h-scroll-weekday-card-varthursday"
          );
          break;
        case "Friday":
          getDayAssessmentData(
            dateStr,
            grcode,
            "#weekly-assessment-h-scroll-weekday-card-varfriday"
          );
          break;
        case "Saturday":
          getDayAssessmentData(
            dateStr,
            grcode,
            "#weekly-assessment-h-scroll-weekday-card-varsaturday"
          );
          break;
        case "Sunday":
          getDayAssessmentData(
            dateStr,
            grcode,
            "#weekly-assessment-h-scroll-weekday-card-varsunday"
          );
          break;
        default:
          console.log(
            "Error: no weekday output to pass to card. [$.populateWeeklyAssessmentsHorizCardContainer]: Day: " +
              dayName +
              " | grcode" +
              grcode
          );
          // alert("Error: no weekday output to pass to card. [$.populateWeeklyAssessmentsHorizCardContainer]: Day: " + dayName + " | grcode" + grcode);
          break;
      }
    });

    showSnackbar(
      `${capitalizeFirstLetter(when)} weeks assessment cards have been loaded.`
    );
  };

  // ***** Locaion: Modal
  // ajax jquery - submit activity tracking data [Heart Rate]
  $("#modal-heartrate-insights-activitytracker-data-form").on(
    "submit",
    function (e) {
      e = e || window.event;
      e.preventDefault();

      // get the localy stored user_usnm
      let user_usnm = localStorage.getItem("user_usnm");

      var form_data = new FormData(
        $("#modal-heartrate-insights-activitytracker-data-form")[0]
      );
      setTimeout(function () {
        $.ajax({
          type: "POST",
          url: "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_heartrate.php",
          processData: false,
          contentType: false,
          async: false,
          cache: false,
          data: form_data,
          beforeSend: function () {
            console.log(
              "beforeSend: submitting activity tracking data [Heart Rate]"
            );
            // disable the form submit btn
            $(
              '#modal-heartrate-insights-activitytracker-data-form > [type="submit"]'
            ).attr("disabled", true);
            // show #load-wait-screen-curtain
            $("#load-wait-screen-curtain").show();
          },
          success: function (response) {
            if (response.startsWith("success")) {
              console.log(
                "success: returning response - activity tracking data [Heart Rate]"
              );
              console.log("Response: " + response);

              // run sync function for heartrate chart
              var dateToday = new Date("Y-m-d");
              syncUserActivityTrackerChart(
                heartRateChart,
                user_usnm,
                "heart_rate_monitor_chart",
                null,
                dateToday
              );

              // reset the form
              // $('#modal-heartrate-insights-activitytracker-data-form :input').val('');
              $(
                "#modal-heartrate-insights-activitytracker-data-form[name=checkListItem]"
              ).val("");
            } else {
              console.log(
                "error: returning response - activity tracking data [Heart Rate]"
              );
              console.log("Response: " + response);
            }

            // enable the form submit btn
            $(
              '#modal-heartrate-insights-activitytracker-data-form > [type="submit"]'
            ).attr("disabled", false);
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(
              "exception error: " +
                thrownError +
                "\r\n" +
                xhr.statusText +
                "\r\n" +
                xhr.responseText
            );
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
        });
      }, 1000);

      e.stopImmediatePropagation();
      return false;
    }
  );
  // ./ ajax jquery - submit activity tracking data [Heart Rate]

  // ajax jquery - submit activity tracking data [Body Temp]
  $("#modal-bodytemp-insights-activitytracker-data-form").on(
    "submit",
    function (e) {
      e = e || window.event;
      e.preventDefault();

      // get the localy stored user_usnm
      let user_usnm = localStorage.getItem("user_usnm");

      var form_data = new FormData(
        $("#modal-bodytemp-insights-activitytracker-data-form")[0]
      );
      setTimeout(function () {
        $.ajax({
          type: "POST",
          url: "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bodytemp.php",
          processData: false,
          contentType: false,
          async: false,
          cache: false,
          data: form_data,
          beforeSend: function () {
            console.log(
              "beforeSend: submitting activity tracking data [Body Temp]"
            );
            // show #load-wait-screen-curtain
            $("#load-wait-screen-curtain").show();
          },
          success: function (response) {
            if (response.startsWith("success")) {
              console.log(
                "success: returning response - activity tracking data [Body Temp]"
              );
              console.log("Response: " + response);
              // get the profile image name and append it to the src attribute str
              // var str = response;
              // var imgSrcStr = str.split('[').pop().split(']')[0];
            } else {
              console.log(
                "error: returning response - activity tracking data [Body Temp]"
              );
              console.log("Response: " + response);
            }
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(
              "exception error: " +
                thrownError +
                "\r\n" +
                xhr.statusText +
                "\r\n" +
                xhr.responseText
            );
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
        });
      }, 1000);

      e.stopImmediatePropagation();
      return false;
    }
  );
  // ./ ajax jquery - submit activity tracking data [Body Temp]

  // ajax jquery - submit activity tracking data [Speed]
  $("#modal-speed-insights-activitytracker-data-form").on(
    "submit",
    function (e) {
      e = e || window.event;
      e.preventDefault();

      // get the localy stored user_usnm
      let user_usnm = localStorage.getItem("user_usnm");

      var form_data = new FormData(
        $("#modal-speed-insights-activitytracker-data-form")[0]
      );
      setTimeout(function () {
        $.ajax({
          type: "POST",
          url: "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_speed.php",
          processData: false,
          contentType: false,
          async: false,
          cache: false,
          data: form_data,
          beforeSend: function () {
            console.log(
              "beforeSend: submitting activity tracking data [Speed]"
            );
            // show #load-wait-screen-curtain
            $("#load-wait-screen-curtain").show();
          },
          success: function (response) {
            if (response.startsWith("success")) {
              console.log(
                "success: returning response - activity tracking data [Speed]"
              );
              console.log("Response: " + response);
              // get the profile image name and append it to the src attribute str
              // var str = response;
              // var imgSrcStr = str.split('[').pop().split(']')[0];
            } else {
              console.log(
                "error: returning response - activity tracking data [Speed]"
              );
              console.log("Response: " + response);
            }
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(
              "exception error: " +
                thrownError +
                "\r\n" +
                xhr.statusText +
                "\r\n" +
                xhr.responseText
            );
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
        });
      }, 1000);

      e.stopImmediatePropagation();
      return false;
    }
  );
  // ./ ajax jquery - submit activity tracking data [Speed]

  // ajax jquery - submit activity tracking data [BMI Weight]
  $("#modal-weight-insights-activitytracker-data-form").on(
    "submit",
    function (e) {
      e = e || window.event;
      e.preventDefault();

      // get the localy stored user_usnm
      let user_usnm = localStorage.getItem("user_usnm");

      var form_data = new FormData(
        $("#modal-weight-insights-activitytracker-data-form")[0]
      );
      setTimeout(function () {
        $.ajax({
          type: "POST",
          url: "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bmiweight.php",
          processData: false,
          contentType: false,
          async: false,
          cache: false,
          data: form_data,
          beforeSend: function () {
            console.log(
              "beforeSend: submitting activity tracking data [BMI Weight]"
            );
            // show #load-wait-screen-curtain
            $("#load-wait-screen-curtain").show();
          },
          success: function (response) {
            if (response.startsWith("success")) {
              console.log(
                "success: returning response - activity tracking data [BMI Weight]"
              );
              console.log("Response: " + response);
              // get the profile image name and append it to the src attribute str
              // var str = response;
              // var imgSrcStr = str.split('[').pop().split(']')[0];
            } else {
              console.log(
                "error: returning response - activity tracking data [BMI Weight]"
              );
              console.log("Response: " + response);
            }
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(
              "exception error: " +
                thrownError +
                "\r\n" +
                xhr.statusText +
                "\r\n" +
                xhr.responseText
            );
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
        });
      }, 1000);

      e.stopImmediatePropagation();
      return false;
    }
  );
  // ./ ajax jquery - submit activity tracking data [BMI Weight]

  // ***** Locaion: Single
  // ajax jquery - submit activity tracking data [Heart Rate]
  $("#single-heartrate-insights-activitytracker-data-form").on(
    "submit",
    function (e) {
      e = e || window.event;
      e.preventDefault();

      // get the localy stored user_usnm
      let user_usnm = localStorage.getItem("user_usnm");

      var form_data = new FormData(
        $("#single-heartrate-insights-activitytracker-data-form")[0]
      );
      setTimeout(function () {
        $.ajax({
          type: "POST",
          url: "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_heartrate.php",
          processData: false,
          contentType: false,
          async: false,
          cache: false,
          data: form_data,
          beforeSend: function () {
            console.log(
              "beforeSend: submitting activity tracking data [Heart Rate]"
            );
            // show #load-wait-screen-curtain
            $("#load-wait-screen-curtain").show();
          },
          success: function (response) {
            if (response.startsWith("success")) {
              console.log(
                "success: returning response - activity tracking data [Heart Rate]"
              );
              console.log("Response: " + response);

              // run sync function for heartrate chart
              var dateToday = new Date();
              syncUserActivityTrackerChart(
                heartRateChart,
                user_usnm,
                "heart_rate_monitor_chart",
                null,
                dateToday
              );

              // reset the form
              $(
                "#single-heartrate-insights-activitytracker-data-form :input"
              ).val("");
            } else {
              console.log(
                "error: returning response - activity tracking data [Heart Rate]"
              );
              console.log("Response: " + response);
            }

            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(
              "exception error: " +
                thrownError +
                "\r\n" +
                xhr.statusText +
                "\r\n" +
                xhr.responseText
            );
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
        });
      }, 1000);

      e.stopImmediatePropagation();
      return false;
    }
  );
  // ./ ajax jquery - submit activity tracking data [Heart Rate]

  // ajax jquery - submit activity tracking data [Body Temp]
  $("#single-bodytemp-insights-activitytracker-data-form").on(
    "submit",
    function (e) {
      e = e || window.event;
      e.preventDefault();

      // get the localy stored user_usnm
      let user_usnm = localStorage.getItem("user_usnm");

      var form_data = new FormData(
        $("#single-bodytemp-insights-activitytracker-data-form")[0]
      );
      setTimeout(function () {
        $.ajax({
          type: "POST",
          url: "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bodytemp.php",
          processData: false,
          contentType: false,
          async: false,
          cache: false,
          data: form_data,
          beforeSend: function () {
            console.log(
              "beforeSend: submitting activity tracking data [Body Temp]"
            );
            // show #load-wait-screen-curtain
            $("#load-wait-screen-curtain").show();
          },
          success: function (response) {
            if (response.startsWith("success")) {
              console.log(
                "success: returning response - activity tracking data [Body Temp]"
              );
              console.log("Response: " + response);
              // get the profile image name and append it to the src attribute str
              // var str = response;
              // var imgSrcStr = str.split('[').pop().split(']')[0];
            } else {
              console.log(
                "error: returning response - activity tracking data [Body Temp]"
              );
              console.log("Response: " + response);
            }
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(
              "exception error: " +
                thrownError +
                "\r\n" +
                xhr.statusText +
                "\r\n" +
                xhr.responseText
            );
            // hide #load-wait-screen-curtain
            // show #load-wait-screen-curtain
            $("#load-wait-screen-curtain").show();
          },
        });
      }, 1000);

      e.stopImmediatePropagation();
      return false;
    }
  );
  // ./ ajax jquery - submit activity tracking data [Body Temp]

  // ajax jquery - submit activity tracking data [Speed]
  $("#single-speed-insights-activitytracker-data-form").on(
    "submit",
    function (e) {
      e = e || window.event;
      e.preventDefault();

      // get the localy stored user_usnm
      let user_usnm = localStorage.getItem("user_usnm");

      var form_data = new FormData(
        $("#single-speed-insights-activitytracker-data-form")[0]
      );
      setTimeout(function () {
        $.ajax({
          type: "POST",
          url: "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_speed.php",
          processData: false,
          contentType: false,
          async: false,
          cache: false,
          data: form_data,
          beforeSend: function () {
            console.log(
              "beforeSend: submitting activity tracking data [Speed]"
            );
            // show #load-wait-screen-curtain
            $("#load-wait-screen-curtain").show();
          },
          success: function (response) {
            if (response.startsWith("success")) {
              console.log(
                "success: returning response - activity tracking data [Speed]"
              );
              console.log("Response: " + response);
              // get the profile image name and append it to the src attribute str
              // var str = response;
              // var imgSrcStr = str.split('[').pop().split(']')[0];
            } else {
              console.log(
                "error: returning response - activity tracking data [Speed]"
              );
              console.log("Response: " + response);
            }
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(
              "exception error: " +
                thrownError +
                "\r\n" +
                xhr.statusText +
                "\r\n" +
                xhr.responseText
            );
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
        });
      }, 1000);

      e.stopImmediatePropagation();
      return false;
    }
  );
  // ./ ajax jquery - submit activity tracking data [Speed]

  // ajax jquery - submit activity tracking data [BMI Weight]
  $("#single-weight-insights-activitytracker-data-form").on(
    "submit",
    function (e) {
      e = e || window.event;
      e.preventDefault();

      // get the localy stored user_usnm
      let user_usnm = localStorage.getItem("user_usnm");

      var form_data = new FormData(
        $("#single-weight-insights-activitytracker-data-form")[0]
      );
      setTimeout(function () {
        $.ajax({
          type: "POST",
          url: "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/user_capture_stats_bmiweight.php",
          processData: false,
          contentType: false,
          async: false,
          cache: false,
          data: form_data,
          beforeSend: function () {
            console.log(
              "beforeSend: submitting activity tracking data [BMI Weight]"
            );
            // show #load-wait-screen-curtain
            $("#load-wait-screen-curtain").show();
          },
          success: function (response) {
            if (response.startsWith("success")) {
              console.log(
                "success: returning response - activity tracking data [BMI Weight]"
              );
              console.log("Response: " + response);

              // run sync function for heartrate chart
              var dateToday = new Date();
              syncUserActivityTrackerChart(
                bmiWeightChart,
                user_usnm,
                "heart_rate_monitor_chart",
                null,
                dateToday
              );

              // reset the form
              $(
                "#modal-heartrate-insights-activitytracker-data-form :input"
              ).val("");
            } else {
              console.log(
                "error: returning response - activity tracking data [BMI Weight]"
              );
              console.log("Response: " + response);
            }
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            console.log(
              "exception error: " +
                thrownError +
                "\r\n" +
                xhr.statusText +
                "\r\n" +
                xhr.responseText
            );
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          },
        });
      }, 1000);

      e.stopImmediatePropagation();
      return false;
    }
  );
  // ./ ajax jquery - submit activity tracking data [BMI Weight]

  // ajax jquery - submit edited weekly teams activity data [Teams Submit Edited Activities Form]
  $("#teams-add-new-day-activity-data-form").on("submit", function (e) {
    e = e || window.event;
    e.preventDefault();

    var form_data = new FormData($("#teams-add-new-day-activity-data-form")[0]);
    setTimeout(function () {
      $.ajax({
        type: "POST",
        url: "../scripts/php/main_app/data_management/activity_tracker_stats_admin/team_athletics_data/capture/teams_add_new_activity_day_form_submit.php",
        processData: false,
        contentType: false,
        async: false,
        cache: false,
        data: form_data,
        beforeSend: function () {
          console.log(
            "beforeSend: submit edited weekly teams activity data [Teams Submit Edited Activities Form]"
          );
          // show #load-wait-screen-curtain
          $("#load-wait-screen-curtain").show();
        },
        success: function (response) {
          if (response.startsWith("success")) {
            console.log(
              "success: returning response - submit edited weekly teams activity data [Teams Submit Edited Activities Form]"
            );
            console.log("Response: " + response);
            // get the profile image name and append it to the src attribute str
            // var str = response;
            // var imgSrcStr = str.split('[').pop().split(']')[0];

            // call the function/code to populate the modal body - use jquery ajax
            var local_grpRefcode = localStorage.setItem("grcode");
            $.loadTeamsActivityCaptureForm(day, local_grpRefcode);
          } else {
            console.log(
              "error: returning response - submit edited weekly teams activity data [Teams Submit Edited Activities Form]"
            );
            console.log("Response: " + response);
          }
          // hide #load-wait-screen-curtain
          $("#load-wait-screen-curtain").hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          console.log(
            "exception error: " +
              thrownError +
              "\r\n" +
              xhr.statusText +
              "\r\n" +
              xhr.responseText
          );
          // hide #load-wait-screen-curtain
          $("#load-wait-screen-curtain").hide();
        },
      });
    }, 1000);

    e.stopImmediatePropagation();
    return false;
  });
  // ./ ajax jquery - submit edited weekly teams activity data [Teams Submit Edited Activities Form]

  // ajax jquery - submit add new activity data form on the calender view modal
  $("#add-new-schedule-form").on("submit", function (e) {
    e = e || window.event;
    e.preventDefault();

    // get the localy stored user_usnm
    let user_usnm = localStorage.getItem("user_usnm");

    var form_data = new FormData($("#add-new-schedule-form")[0]);
    setTimeout(function () {
      $.ajax({
        type: "POST",
        url:
          "../scripts/php/main_app/compile_content/fitness_insights_tab/activity_calender/add_to_teams_training_schedule.php?submitted_by=" +
          user_usnm,
        processData: false,
        contentType: false,
        async: false,
        cache: false,
        data: form_data,
        beforeSend: function () {
          console.log(
            "beforeSend: submitting add new activity data form on the calender view modal"
          );

          // show #load-wait-screen-curtain
          $("#load-wait-screen-curtain").show();

          // check if team has been selected from #add-to-calender-team-select
          if ($("#add-to-calender-team-select").val() == "noselection") {
            alert("Please select a team to assign this schedule to.");
            $("#add-to-calender-team-select").focus();
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
            return false;
          }
        },
        success: function (response) {
          if (response.startsWith("success")) {
            console.log(
              "success: returning response - added new activity data form on the calender view modal"
            );
            console.log("Response: " + response);

            showSnackbar("Schedule created successfully.", "alert_success");

            // test output
            // alert("Success: returning response - added new activity data form on the calender view modal \nResponse: " + response);
            //
            $("#add-new-schedule-form > #output-container")
              .html(`<div class="alert alert-success p-4 text-center" style="border-radius:25px;">
                        <span class="material-icons material-icons-round align-middle text-success" style="color:var(--secondary-color);font-size:48px!important;">
                        check_circle
                        </span> 
                        Schedule created  successfully.
                        </div>`);

            // reset the form
            // click the "Remove all selected" btn #remove-all-from-selected-activities-list-btn
            $("remove-all-from-selected-activities-list-btn").click();
            // reset the form using .trigger("change"): $('form#myform select, form input[type=checkbox]') | source: https://stackoverflow.com/questions/16452699/how-to-reset-a-form-using-jquery-with-reset-method
            $(
              'form #add-new-activity-form select:not("#add-to-calender-team-select"), form input[type=checkbox], *'
            ).trigger("change");

            // loop through this form and clear all inputs / reset them to default values
            // $('#add-new-activity-form *').filter(':input').each(function(this) {
            //     //set each input value to ''
            //     $(this).val('');
            // });
            // $('#id="add-new-schedule-form :input').val(''); // alternative one-liner
            // $('#id="add-new-schedule-form[name=checkListItem]').val(''); // alternative one-liner
          } else {
            console.log(
              "error: returning response - add new activity data form on the calender view modal"
            );
            console.log("Response: " + response);
            $("#add-new-schedule-form > #output-container")
              .html(`<div class="alert alert-danger p-4 text-center" style="border-radius:25px;">
                        <span class="material-icons material-icons-round align-middle text-danger" style="color:var(--text-color);font-size:48px!important;">
                        error_outline
                        </span> 
                        ${response}
                        </div>`);

            // test output
            // alert("Failure: returning response - failed to add new activity data form on the calender view modal \nResponse: " + response);
          }

          // set 2 second timeout to hide the loading indicator curtain
          setTimeout(function () {
            // scroll to the output-container for the form - params (containerElemID, scrollToElemID, scrollSpeed)
            $.smoothScroll(
              "#CalenderActivityFormeModal_body",
              "#output-container",
              1000
            );
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          }, 2000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          var errorMsg =
            "exception error: " +
            thrownError +
            "\r\n" +
            xhr.statusText +
            "\r\n" +
            xhr.responseText;
          console.log(errorMsg);

          // output error message on form
          $("#add-new-schedule-form > #output-container")
            .html(`<div class="alert alert-danger p-4 text-center" style="border-radius:25px;">
                        <span class="material-icons material-icons-round align-middle text-danger" style="color:var(--text-color);font-size:48px!important;">
                        error_outline
                        </span> 
                        An error has occurred. Please contact <a href="#">support.</a>.
                        </div>`);

          // show error snackbar to notify the user
          showSnackbar(errorMsg, "alert_error", "medium_10000");

          // set 2 second timeout to hide the loading indicator curtain
          setTimeout(function () {
            // scroll to the output-container for the form - params (containerElemID, scrollToElemID, scrollSpeed)
            $.smoothScroll(
              "#CalenderActivityFormeModal_body",
              "#output-container",
              1000
            );
            // hide #load-wait-screen-curtain
            $("#load-wait-screen-curtain").hide();
          }, 2000);
        },
      });
    }, 1000);

    e.stopImmediatePropagation();
    return false;
  });
  // ./ ajax jquery - submit add new activity data form on the calender view modal

  // ajax jquery - submit add match to fixture data form
  $("#add-match-fixture-form").on("submit", function (e) {
    e = e || window.event;
    e.preventDefault();

    // get the localy stored user_usnm
    let user_usnm = localStorage.getItem("user_usnm");

    // scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/create/add_match_to_fixture.php
    var form_data = new FormData($("#add-match-fixture-form")[0]);
    setTimeout(function () {
      $.ajax({
        type: "POST",
        url:
          "../scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/create/add_match_to_fixture.php?submitted_by=" +
          user_usnm,
        processData: false,
        contentType: false,
        async: false,
        cache: false,
        data: form_data,
        beforeSend: function () {
          console.log("beforeSend: submitting add match to fixture data form");
          // show #load-wait-screen-curtain
          $("#load-wait-screen-curtain").show();
        },
        success: function (response) {
          if (response.startsWith("success")) {
            console.log(
              "success: returning response - added add match to fixture data form"
            );
            console.log("Response: " + response);

            // test output
            // alert("Success: returning response - added new activity data form on the calender view modal \nResponse: " + response);
            //
            $("#add-match-fixture-form > #output-container").html(`
                        <div class="alert alert-success p-4 text-center" style="border-radius:25px;">
                        <span class="material-icons material-icons-round align-middle" 
                        style="color:var(--secondary-color);font-size:48px!important;">
                        check_circle
                        </span> 
                        Data saved successfully.
                        </div>
                        `);

            // // scroll to the output-container for the form - params (containerElemID, scrollToElemID, scrollSpeed)
            $.smoothScroll(
              "#add-match-fixture-body-container",
              "#output-container",
              1000
            );

            // // reset the form
            // // loop through this form and clear all inputs / reset them to default values
            // $('#add-new-activity-form *').filter(':input').each(function(key, value) {
            //     //set each input value to ''
            //     $(this).val('');
            // });
            // $('#id="add-match-fixture-form :input').val(''); // alternative one-liner
            // $('#id="add-match-fixture-form[name=checkListItem]').val(''); // alternative one-liner
          } else {
            console.log(
              "error: returning response - add match to fixture data form"
            );
            console.log("Response: " + response);
            $("#add-match-fixture-form > #output-container").html(`
                        <div class="alert alert-danger p-4 text-center" style="border-radius:25px;">
                        <span class="material-icons material-icons-round align-middle" style="color:var(--text-color);font-size:48px!important;">
                        error_outline
                        </span> 
                        ${response}
                        </div>
                        `);

            // // scroll to the output-container for the form - params (containerElemID, scrollToElemID, scrollSpeed - ms)
            $.smoothScroll(
              "#add-match-fixture-body-container",
              "#output-container",
              1000
            );

            // test output
            // alert("Failure: returning response - failed to add new activity data form on the calender view modal \nResponse: " + response);
          }
          // hide #load-wait-screen-curtain
          $("#load-wait-screen-curtain").hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          console.log(
            "exception error: " +
              thrownError +
              "\r\n" +
              xhr.statusText +
              "\r\n" +
              xhr.responseText
          );
          // hide #load-wait-screen-curtain
          $("#load-wait-screen-curtain").hide();
        },
      });
    }, 1000);

    e.stopImmediatePropagation();
    return false;
  });
  // ./ ajax jquery - submit add match to fixture data form

  // initialize image map highlighting plugin - interactions physical assessment
  function initMapHighlight() {
    console.log("initializing Map Highlight");
    // Initialize maphilight plugin
    $("img[usemap]").maphilight();

    // Handle area click events
    $("area").on("click", function () {
      // Get the value of the 'onclick' attribute and execute the function
      var onClickFunction = $(this).attr("onclick");
      if (onClickFunction) {
        eval(onClickFunction);
      }

      // Add your custom code here, for example, show an alert
      alert("Area clicked: " + $(this).attr("alt"));
    });

    // area mouseover
    const imageMap = document.getElementById("image-map-front");
    // const areas = $('image-map-front > area'); //document.querySelectorAll('area');

    // areas = query get area elements from name="image-map-male-front-indi"
    const areas = Array.from(
      $('#map-area-front[name="image-map-male-front-indi"]')
    );

    areas.forEach(function (area) {
      area.addEventListener("mouseover", function () {
        area.classList.add("highlight");
      });

      area.addEventListener("mouseout", function () {
        area.classList.remove("highlight");
      });

      area.addEventListener("click", function () {
        alert("Area clicked: " + area.getAttribute("alt"));
        // createMarker(); // Call your function here
      });
    });

    // save state to localstorage
    localStorage.setItem("imageMapState", true);
  }

  // load interaction model content
  $.loadInteractionContent = function (loadContent) {
    let user_id = localStorage.getItem("user_usnm");
    var getRequestLink,
      modalHeader = null;

    // show the interaction modal
    // $('#show-interaction-modal-btn').click();

    // set loading display
    $("#interactionsContentContainer").html(
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
        getRequestLink =
          "../scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/compile_training_drills_workouts.php?uid=" +
          user_id;
        break;
      case "PhysicalAssessment":
        modalHeader = `<span class="material-icons material-icons-round align-middle">personal_injury</span>
        <span class="align-middle d-none d-md-block"> Physical Assessment</span>`;
        getRequestLink =
          "../scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/compile_physical_assessment.php?uid=" +
          user_id;
        break;
      case "NutritionBoard":
        modalHeader = `<span class="material-icons material-icons-round align-middle">developer_board</span>
        <span class="align-middle d-none d-md-block"> Nutrition Board.</span>`;
        getRequestLink =
          "../scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/compile_nutrition_board.php?uid=" +
          user_id;
        break;
      case "CreationTools":
        modalHeader = `<span class="material-icons material-icons-round align-middle">brush</span>
        <span class="align-middle d-none d-md-block"> Creation Tools.</span>`;
        getRequestLink =
          "../scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/compile_creation_tools.php?uid=" +
          user_id;
        break;
      case "AdminDataMgmt":
        modalHeader = `<span class="material-icons material-icons-round align-middle">account_tree</span>
        <span class="align-middle d-none d-md-block"> Data Management.</span>`;
        getRequestLink =
          "../scripts/php/main_app/compile_content/fitness_insights_tab/training/interactions/compile_data_mgmt.php?uid=" +
          user_id;
        break;

      default:
        modalHeader = `<span class="material-icons material-icons-round align-middle">account_tree</span>
        <span class="align-middle d-none d-md-block"> Data Management.</span>`;
        getRequestLink = "abort operation";
        console.log(
          "Error: no content request received. [$.loadInteractionContent]: loadContent Param: " +
            loadContent
        );
        alert(
          "Error: no content request received. [$.loadInteractionContent]: loadContent Param: " +
            loadContent
        );
        break;
    }

    if (loadContent == "PhysicalAssessment") {
      // call initMapHighlight function
      initMapHighlight();
    }

    if (getRequestLink != "abort operation") {
      $.get(getRequestLink, function (data, status) {
        if (status.startsWith("return")) {
          console.log(
            "Get Req Failed -> $.loadInteractionContent returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          alert(
            "Get Req Failed -> $.loadInteractionContent returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
        } else {
          // show the interaction modal
          // $('#show-interaction-modal-btn').click();
          // load the interaction modal with requested content
          $("#trainingInteractionsContentModalLabel").html(modalHeader);
          // update the onclick function for the modal header label
          $("#trainingInteractionsContentModalLabel").attr(
            "onclick",
            `$.loadInteractionContent('${loadContent}')`
          );
          $("#interactionsContentContainer").html(data);
        }
      });
    }
  };

  //<!-- script for loading edit forms for weekly teams activities -->
  $.editAddNewActivityModal = function (day, grpRefcode) {
    // open the modal
    // $("#toggleTabeditWeeklyTeamsTrainingScheduleModalBtn").click();

    // call the function/code to populate the modal body - use jquery ajax
    $.loadTeamsActivityCaptureForm(day, grpRefcode);

    // update the modal header label
    $("#tabeditWeeklyTeamsTrainingScheduleModalLabelText").html(
      "Edit weekly training schedule ( " + day + " )"
    );
  };

  $.toggleEditDayBar = function (day, groupRefCode) {
    // open the modal
    // $("#toggleTabeditWeeklyTeamsTrainingScheduleModalBtn").click();

    // call the function/code to populate the modal body - use jquery ajax - "editbar" value (grpRefcode) will load a form for updating the title and rpe
    var initVal = "editbar";
    $.loadTeamsActivityCaptureForm(day, initVal);
  };

  $.removeWeeklyTrainingActivity = function (day, groupRefCode, exerciseID) {
    alert(
      `Flag: $.removeWeeklyTrainingActivity \n day: ${day} | grcode: ${groupRefCode} | exerciseID: ${exerciseID}`
    );
  };
  // <!-- ./ script for loading edit forms for weekly teams activities -->

  // function to save custom color tag to db on form #add-new-activity-form
  $.newCustomColorTag = function (tagColor) {
    try {
      var tagTitle = $(
        "#add-to-calender-activity-custom-colorcode-title-value"
      ).val();
      tagTitle = tagTitle.split(" ").join("_"); // .replace(/ /g,"_"); replace empty space with underscore
      var saveTagValue = $(
        "#add-to-calender-activity-custom-colorcode-save-tag"
      ).val();
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
      $("#add-to-calender-activity-colorcode-value > option:last").before(
        `<option value="${tagTitle}[${tagColor}]" style="color: ${tagColor};"> ${tagTitle} </option>`
      );
      $("#add-to-calender-activity-colorcode-value").val(
        `${tagTitle}[${tagColor}]`
      );
      console.log(
        `$.newCustomColorTag\n tagTitle: ${tagTitle}\n saveTagValue: ${saveTagValue}\n saveTag: ${saveTag}`
      );
      return true;

      $.post(
        "scripts/php/main_app/compile_content/fitness_insights_tab/activity_calender/new_teams_color_tag.php", // url
        {
          tag_name: tagTitle,
          tag_color: tagColor,
          save_tag: saveTag,
        }, // data to be submit
        function (data, status, xhr) {
          // success callback function
          alert("status: " + status + ", data: " + data.responseData);
        },
        "json"
      ); // response data format
    } catch (error) {
      console.log("Exception Error: [$.newCustomColorTag] \n" + error);
      return false;
    }
  };

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
    $(origin).find(":selected").appendTo(dest);
  }

  function moveAllItems(origin, dest) {
    $(origin).children().appendTo(dest);
    $("#selected-xp-counter").html(`Total xp: 0 | 0 activities.`); //reset the selected xp count
  }

  function calculateWorkoutTotalXP() {
    // reinitialize the sumXP
    var sumXP = 0;
    var sumRPE = 0;
    var listCount = 0;
    $("#select-workout-exercises-selected > option").each(function () {
      // console.log(this.text + ' ' + this.value);
      // extract the exercise xp value from this.text
      var selectedExerciseText = this.text;

      sumXP += parseInt(selectedExerciseText.split("X[").pop().split("]P")[0]);

      // calculate the total / sumRPE
      sumRPE += parseInt(
        selectedExerciseText.split("RPE[").pop().split("]R")[0]
      );

      listCount += 1;
    });

    // update #selected-xp-counter field with sumXP value
    $("#selected-xp-counter").html(
      `Total xp: ${sumXP} | ${listCount} activities.`
    );
    // assign sumRPE to #add-to-calender-activity-rpe-value
    $("#add-to-calender-activity-rpe-value").val(sumRPE);
  }

  // move/add to selected list
  $("#add-selection-to-activities-selectlist-btn").on("click", function () {
    // direction:  init to selected list
    moveItems(
      "#add-to-calender-activity-selection",
      "#select-workout-exercises-selected"
    );
    calculateWorkoutTotalXP();
  });

  $.resetThisForm = function (formElemId, elemType) {
    // loop through all option elems in #add-to-calender-activity-selection and remove the selected attribute
    $(`${formElemId} *`)
      .filter(`:${elemType}`)
      .each(function (key, value) {
        //set each input value to ''
        switch (elemType) {
          case "input":
            //
            $(this).val("");
            break;
          case "option":
            //
            $(this).removeAttr("selected");
            break;

          default:
            alert(
              "Unable to reset the requested form. Check the console for more details."
            );
            console.log("Cannot find/reset this element: <" + elemType + " />");
            break;
        }
      });
  };

  // text-input: pass title and definitionstrings to selected list
  $("#add-selection-to-activities-textinput-btn").on("click", function (e) {
    e = e || window.event;
    e.preventDefault();

    let newExerciseTitle = $("#add-to-calender-activity-specify-title").val();

    let newExerciseDescription = $(
      "#add-to-calender-activity-specify-new-description"
    ).val();
    let newExerciseGuidelines = $(
      "#add-to-calender-activity-specify-new-guidelines"
    ).val();

    let newExerciseSets = $("#add-to-calender-activity-specify-sets").val();
    let newExerciseReps = $("#add-to-calender-activity-specify-reps").val();
    let newExerciseRests = $("#add-to-calender-activity-specify-rests").val();

    let newExerciseXP = $("#add-to-calender-activity-specify-xp").val();
    let newExerciseTrainingPhase = $(
      "#add-to-calender-specify-training-phase"
    ).val();

    var exerciseSaveStatus = null;

    // check if input fields are empty, if true the warning alert message is displayed
    if (
      newExerciseTitle == "" ||
      newExerciseDescription == "" ||
      newExerciseSets <= 0 ||
      newExerciseReps <= 0 ||
      newExerciseRests < 0 ||
      newExerciseXP <= 0 ||
      newExerciseTrainingPhase == ""
    ) {
      alert("Please provide information in all fields.");
    } else {
      // add the exercise/activity to the db
      try {
        $.post(
          "../administration/scripts/php/capture/new_exercise.php",
          {
            exerciseTitle: newExerciseTitle,
            exerciseDescription: newExerciseDescription,
            exerciseGuidelines: newExerciseGuidelines,
            exerciseSets: newExerciseSets,
            exerciseReps: newExerciseReps,
            exerciseRests: newExerciseRests,
            xp_points: newExerciseXP,
            trainingPhase: newExerciseTrainingPhase,
          },
          function (data, status) {
            console.log(
              "$.post(../administration/scripts/php/capture/new_exercise.php) status: \n" +
                status
            );
            // data returned is the exercise_id
            let exercise_id = data;
            if (status == "success") {
              exerciseSaveStatus = "success";
              console.log(
                "$(#add-selection-to-activities-textinput-btn) -> status: " +
                  status +
                  ", \ndata: " +
                  data
              );
              // alert('Successfull. \n$(#add-selection-to-activities-textinput-btn) -> status: ' + status + ', \ndata: ' + data);
            } else {
              exerciseSaveStatus = "fail";
              console.log(
                "$(#add-selection-to-activities-textinput-btn) -> fail returned: " +
                  status +
                  ", \ndata: " +
                  data
              );
              // alert("Failure. \n$(#add-selection-to-activities-textinput-btn) -> fail returned: " + status + ', \ndata: ' + data);
            }

            // and then create new <options>  node to #add-to-calender-activity-selection, and then move the added node to #select-workout-exercises-selected
            switch (exerciseSaveStatus) {
              case "success":
                // loop through all option elems in #add-to-calender-activity-selection and remove the selected attribute
                // $('#add-to-calender-activity-selection *').filter(':option')
                $("#add-to-calender-activity-selection > option").each(
                  function (key, value) {
                    //remove the selected attribute from all select child nodes
                    $(this).removeAttr("selected");
                  }
                );
                // so that we can set the selected attribute to the new exercise/activity record item we have created in the db
                // $('#add-to-calender-activity-selection').append(`<option value="${exercise_id}" flagnew> ${newExerciseTitle} - ( ${newExerciseDescription} ) X[${newExerciseXP}]P </option>`);
                // after which we add the option item to the '#select-workout-exercises-selected list
                $("#select-workout-exercises-selected").append(
                  `<option value="${parseInt(
                    exercise_id
                  )}" flagnew> ${newExerciseTitle} - ( ${newExerciseDescription} ) X[${newExerciseXP}]P </option>`
                );
                // and then we sort the list
                sortSelect("select-workout-exercises-selected");
                // recalculate the total xp
                calculateWorkoutTotalXP();
                // reset/clear all inputs
                $("#add-to-calender-activity-specify-title").val("");

                $("#add-to-calender-activity-specify-new-description").val("");
                $("#add-to-calender-activity-specify-new-guidelines").val("");

                $("#add-to-calender-activity-specify-sets").val("1");
                $("#add-to-calender-activity-specify-reps").val("1");
                $("#add-to-calender-activity-specify-rests").val("0");

                $("#add-to-calender-activity-specify-xp").val("");
                $("#add-to-calender-specify-training-phase").val("beginner");

                showSnackbar(
                  "New Exercise was saved successfully.",
                  "alert_success",
                  "medium_5000"
                );

                break;
              case "fail":
                showSnackbar(
                  "A fail error has occured. We are unable to save your new exercise entry. Contact Support.",
                  "alert_error",
                  "long_15000"
                );
                console.log(
                  "A fail error has occured. We are unable to save your new exercise entry. Contact Support."
                );
                break;

              default:
                // error - status unknown
                showSnackbar(
                  "Default Error: status unknown. Contact Support. \nStatus: " +
                    status,
                  "alert_error",
                  "long_15000"
                );
                console.log("Default Error: status unknown. Contact Support.");
                break;
            }
          }
        )
          .done(function () {
            console.log("New exercise entry submission is complete.");
          })
          .fail(function () {
            console.log(
              "$(#add-selection-to-activities-textinput-btn) -> post fail error"
            );
            alert(
              "Failure. \n$(#add-selection-to-activities-textinput-btn) -> post fail error"
            );
          });
      } catch (error) {
        console.log(
          "$(#add-selection-to-activities-textinput-btn) -> Exception error: \n" +
            error
        );
        console.log(
          "An exception error occured. We are unable to save your new exercise entry. Contact Support."
        );
        showSnackbar(
          "An exception error occured. We are unable to save your new exercise entry. Contact Support.",
          "alert_error",
          "long_15000"
        );
      }
    }

    e.stopImmediatePropagation();
    return false;
  });

  // remove selected item from selected list
  $("#remove-selection-from-selected-activities-list-btn").on(
    "click",
    function () {
      // direction: selected to init list
      moveItems(
        "#select-workout-exercises-selected",
        "#add-to-calender-activity-selection"
      );
      sortSelect("add-to-calender-activity-selection");
      calculateWorkoutTotalXP();
    }
  );
  // remove all items in selected list to initial
  $("#remove-all-from-selected-activities-list-btn").on("click", function () {
    // direction: selected to init list
    moveAllItems(
      "#select-workout-exercises-selected",
      "#add-to-calender-activity-selection"
    );
    sortSelect("add-to-calender-activity-selection");
    calculateWorkoutTotalXP();
  });

  // ** admin requests **
  // get indi exercises items (called from app/index.php)
  $.getIndiExercises = function (request, elemid) {
    var elemid = elemid || "#add-to-calender-activity-selection"; // initialize output elemid if it was not passed through params
    $.get(
      "../administration/scripts/php/get_items/get_indi_exercises.php?giveme=" +
        request,
      function (data, status) {
        if (status != "success") {
          console.log(
            "Get Req Failed -> $.getIndiExercises returned: \n[Status]: " +
              status +
              "\n[Data]: " +
              data
          );
          // alert("Get Req Failed -> $.getCommunityGroups returned: \n[Status]: " + status + "\n[Data]: " + data);
        } else {
          if (request == "json") {
            console.log("Indi Exercises Json: \n" + data);
          } else {
            $(elemid).html(data); // '#add-to-calender-activity-selection'
          }
        }
      }
    );
  };

  // function to auto-hide/show the side panels on page load
  $.checkSidePanelVisibility = function () {
    var left_side_panel_visibility_state = localStorage.getItem(
      "left_side_panel_visibility_state"
    );
    var right_side_panel_visibility_state = localStorage.getItem(
      "right_side_panel_visibility_state"
    );

    if (left_side_panel_visibility_state != true) {
      $("#twitter-social-panel").addClass("d-none");
      // $.hideSingleSidePanel('#twitter-social-panel', 'left');
    } else {
      $("#twitter-social-panel").removeClass("d-none");
      // $.showSingleSidePanel('#twitter-social-panel', 'left');
    }

    if (right_side_panel_visibility_state != true) {
      $("#creation-tools-content-panel").addClass("d-none");
      // $.hideSingleSidePanel('#creation-tools-content-panel', 'left');
    } else {
      $("#creation-tools-content-panel").removeClass("d-none");
      // $.showSingleSidePanel('#creation-tools-content-panel', 'left');
    }
  };

  // *** ./ script_jquery.js functions
  // paste date: 2024-Jan-13 11:10:00
});
