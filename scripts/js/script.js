// *** Vanilla JS
// *** index.php script



// *** app.php script

// check core script loaded state
function checkCoreScriptLoadState() {
    // coreScriptLoaded_bootstrap_bundle_cdn_js == false ||
    // coreScriptLoaded_bootstrap_bundle_local_js == false ||
    /* coreScriptLoaded_googlefonts_fonts == false || */
    if (coreScriptLoaded_googlefont_icons_css == false ||
        coreScriptLoaded_plyrio_css == false ||
        coreScriptLoaded_plyrio_js == false ||
        coreScriptLoaded_hls_js == false ||
        coreScriptLoaded_bootstrap_local_css == false ||
        coreScriptLoaded_w3_css == false ||
        coreScriptLoaded_custom_styles_css == false ||
        coreScriptLoaded_digiclock_css == false ||
        coreScriptLoaded_digiclock_js == false ||
        coreScriptLoaded_timeline_css == false ||
        coreScriptLoaded_custom_jquery_func_js == false ||
        coreScriptLoaded_custom_script_js == false ||
        coreScriptLoaded_custom_api_req_js == false ||
        coreScriptLoaded_jquery_local_js == false ||
        coreScriptLoaded_moment_js == false ||
        coreScriptLoaded_googlefonts_css == false ||
        coreScriptLoaded_soccerfield_css == false ||
        coreScriptLoaded_soccerfield_js == false ||
        coreScriptLoaded_chartjs_js == false) {
        console.log("Some core scripts were not loaded. Please check your internet connection. \n" +
            "\n googlefont_icons_css: " + coreScriptLoaded_googlefont_icons_css +
            "\n plyrio_css: " + coreScriptLoaded_plyrio_css +
            "\n plyrio_js: " + coreScriptLoaded_plyrio_js +
            "\n hls_js: " + coreScriptLoaded_hls_js +
            "\n bootstrap_local_css: " + coreScriptLoaded_bootstrap_local_css +
            "\n bootstrap_bundle_local_js*not in condition*: " + coreScriptLoaded_bootstrap_bundle_local_js +
            "\n w3_css: " + coreScriptLoaded_w3_css +
            "\n custom_styles_css: " + coreScriptLoaded_custom_styles_css +
            "\n digiclock_css: " + coreScriptLoaded_digiclock_css +
            "\n digiclock_js: " + coreScriptLoaded_digiclock_js +
            "\n timeline_css: " + coreScriptLoaded_timeline_css +
            "\n custom_jquery_func_js: " + coreScriptLoaded_custom_jquery_func_js +
            "\n custom_script_js: " + coreScriptLoaded_custom_script_js +
            "\n custom_api_req_js: " + coreScriptLoaded_custom_api_req_js +
            "\n jquery_local_js: " + coreScriptLoaded_jquery_local_js +
            "\n custom_jquery_func_js: " + coreScriptLoaded_custom_jquery_func_js +
            "\n moment_js: " + coreScriptLoaded_moment_js +
            "\n googlefonts_fonts*not in condition*: " + coreScriptLoaded_googlefonts_fonts +
            "\n googlefonts_css: " + coreScriptLoaded_googlefonts_css +
            "\n soccerfield_css: " + coreScriptLoaded_soccerfield_css +
            "\n soccerfield_js: " + coreScriptLoaded_soccerfield_js +
            "\n chartjs_js: " + coreScriptLoaded_chartjs_js);
        // show offline curtain and pass message of none-loaded scripts
        document.getElementById("output-msg-heading").innerHTML = "You are offline.";
        document.getElementById("output-msg-text").innerHTML = "Some core scripts were not loaded. Please check your internet connection and try reloading the page.<br>If the error persists, please contact <a href='https://http://help.onefit.adaptivconcept.co.za/systems/?errortype=core_script_error' style='color:var(--tahitigold);'>support</a>";
        document.getElementById("offline-curtain").style.display = 'block';
    }
}
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
function openCalenderActivityForm(dateYear, dateMonth, dateDay) {
    // '2023/3/10'
    // alert(`Show modal for calender day: ${dateYear}/${dateMonth}/${dateDay}`);

    // create date object
    var dateQueried = new Date(`${dateYear}/${dateMonth}/${dateDay}`);

    // pass the date value to .calender-date-selected-label elements
    const calenderSelectionDateLabels = document.querySelectorAll('.calender-date-selected-label');
    calenderSelectionDateLabels.forEach(elemLbl => {
        elemLbl.innerHTML = dateQueried.toDateString();
    });

    const calenderActivityFormModalBtn = document.getElementById('toggleCalenderActivityFormeModalBtn');
    calenderActivityFormModalBtn.click();
}
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
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;

            if (output.startsWith("error")) {
                // provide user with error message
                // alert(output);
                console.log("An error has occured: \n" + output);
                showSnackbar("An error has occured: \n" + output, 'alert_error', 'long_15000');
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
                    function (index) {
                        // return new RegExp(rangeDate, "i").test(index.date);
                        // return index.date.includes(rangeDate);
                        // return index.date;

                        var hitDates = index.date || {};
                        // extract all date strings
                        hitDates = Object.keys(hitDates);
                        // improvement: use some. this is an improment because .map()
                        // and .filter() are walking through all elements.
                        // .some() stops this process if one item is found that returns true in the callback function and returns true for the whole expression
                        hitDateMatchExists = hitDates.some(function (dateStr) {
                            var date = new Date(dateStr);
                            return date = rangeDate;
                        });
                        return hitDateMatchExists;
                    }
                )

                console.log("syncUserActivityTrackerChart(...) --> JSON Data filtered with the rangeDate Parameter \n" + dataFilterdWithRangeDateParam);

                let date = dataFilterdWithRangeDateParam.map(
                    function (index) {
                        return index.date;
                    }
                )

                console.log("date data: \n" + date);

                let time = dataFilterdWithRangeDateParam.map(
                    function (index) {
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

                var msg = "";

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
                            function (index) {
                                return index.bpm;
                            }
                        )

                        console.log("heartratebpm data: \n" + bpm);

                        chartObj.data.labels = time;
                        // chartObj.data.labels = predTimeSeries;
                        chartObj.data.datasets[0].label = "Heart rate - BPM";
                        chartObj.data.datasets[0].data = bpm;
                        chartObj.update();
                        // snackbar message output
                        msg = capitalizeFirstLetter(chartName.split("_").pop(" ")) + " has been updated.";
                        showSnackbar(msg);
                        break;
                    case "body_temp_monitor_chart":

                        // let temperature = chartData.map(
                        //     function(index) {
                        //         return index.temperature;
                        //     }
                        // )

                        let temperature = dataFilterdWithRangeDateParam.map(
                            function (index) {
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
                        // snackbar message output
                        msg = capitalizeFirstLetter(chartName.split("_").pop(" ")) + " has been updated.";
                        showSnackbar(msg);
                        break;
                    case "speed_monitor_chart":

                        // let speed = chartData.map(
                        //     function(index) {
                        //         return index.speed;
                        //     }
                        // )

                        let speed = dataFilterdWithRangeDateParam.map(
                            function (index) {
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
                        // snackbar message output
                        msg = capitalizeFirstLetter(chartName.split("_").pop(" ")) + " has been updated.";
                        showSnackbar(msg);
                        break;
                    case "step_counter_monitor_chart":

                        // let steps = chartData.map(
                        //     function(index) {
                        //         return index.steps;
                        //     }
                        // )

                        let steps = dataFilterdWithRangeDateParam.map(
                            function (index) {
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
                        // snackbar message output
                        msg = capitalizeFirstLetter(chartName.split("_").pop(" ")) + " has been updated.";
                        showSnackbar(msg);
                        break;
                    case "bmi_weight_monitor_chart":

                        // let bmi = chartData.map(
                        //     function(index) {
                        //         return index.bmi;
                        //     }
                        // )

                        let bmi = dataFilterdWithRangeDateParam.map(
                            function (index) {
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
                            function (index) {
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
                        // snackbar message output
                        msg = capitalizeFirstLetter(chartName.split("_").pop(" ")) + " has been updated.";
                        showSnackbar(msg);
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
// compile chart data from remote storage and apply to each chartname/ chartObj specified in var forChartNameArray
function compileUserActivityTrackerCharts(usernm) {
    // set username into localstorage
    localStorage.setItem('user_usnm', usernm);

    var forChartNameArray = ['heart_rate_monitor_chart', 'body_temp_monitor_chart', 'speed_monitor_chart', 'step_counter_monitor_chart', 'bmi_weight_monitor_chart'];

    forChartNameArray.forEach(chartName => {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
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

function switchCurrentAppTab(currentAppTab) {
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

Date.prototype.getWeek = function (start) {
    //Calcing the starting point
    start = start || 0;
    var today = new Date(this.setHours(0, 0, 0, 0));
    var day = today.getDay() - start;
    var date = today.getDate() - day;

    // Grabbing Start/End Dates
    var StartDate = new Date(today.setDate(date));
    var EndDate = new Date(today.setDate(date + 7));
    return [StartDate, EndDate];
}

function getLastWeeksDate() {
    const now = new Date();

    return new Date(now.getFullYear(), now.getMonth(), now.getDate() - 7);
    // return getWeekRange(-2);
}

function getNextWeeksDate() {
    const now = new Date();

    return new Date(now.getFullYear(), now.getMonth(), now.getDate() + 7);
    // return getWeekRange(0);
}

function getThisWeeksDate() {
    const now = new Date();

    return new Date(now.getFullYear(), now.getMonth(), now.getDate());
    // return getWeekRange(0);
}

function getCurrentWeekStartEndDates(when) {
    when = when || 'this';
    // test code
    var elemDatesOutput1 = document.querySelectorAll(".weekly-survey-duration-dates");
    // var elemDatesOutput2 = document.getElementById("weekly-training-date-duration-str");
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

    // after we get the weekDatesArray, we loop through each item using a foreach loop to call ...
    // weekDatesArray.forEach(dateStr => {
    //     var dayName = getDayName(dateStr, "en-ZA");
    // });

    /* Deprecated */
    // switch (when) {
    //     case 'last':
    //         var Dates = getLastWeeksDate().getWeek();
    //         break;
    //     case 'next':
    //         var Dates = getNextWeeksDate().getWeek();
    //         break;
    //     case 'this':
    //         var Dates = getThisWeeksDate().getWeek();
    //         break;
    //     default:
    //         var Dates = new Date().getWeek();
    //         break;
    // }

    //alert(Dates[0].toLocaleDateString() + ' to ' + Dates[1].toLocaleDateString());
    console.log(when + " weeks Dates Array:\n" + weekDatesArray);

    function makeLocalDateString(string) {
        const dateStr = new Date(string);
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        let day = dateStr.getDate();
        let month = months[dateStr.getMonth()];
        let year = dateStr.getFullYear();

        return `${day} ${month} ${year}`;
    }

    // loop through all nodes of elemDatesOutput1 and add innerHTML
    elemDatesOutput1.forEach(nodeElem => {
        // nodeElem.innerHTML = Dates[0].toLocaleDateString() + ' to ' + Dates[1].toLocaleDateString();
        nodeElem.innerHTML = makeLocalDateString(weekDatesArray[0]) + ' to ' + makeLocalDateString(weekDatesArray[6]); //.toLocaleString('en-GB')
    });


    // localStorage.setItem('weekly-survey-duration-dates', Dates[0].toLocaleDateString() + ' to ' + Dates[1].toLocaleDateString());
    // localStorage.setItem('weekly-training-date-duration', Dates[0].toLocaleDateString() + ' to ' + Dates[1].toLocaleDateString());
    localStorage.setItem('weekly-survey-duration-dates', weekDatesArray[0] + ' to ' + weekDatesArray[6]);
    localStorage.setItem('weekly-training-date-duration', weekDatesArray[0] + ' to ' + weekDatesArray[6]);
}

function openLink(evt, tabName) {
    var i, x, tabContainer, tablinks;
    var tabBtnIco = document.getElementById("apps-tray-open-btn-icon");
    var tabBtnTxt = document.getElementById("apps-tray-open-btn-text");


    //Change the #apps-tray-open-btn icon and text
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
    xhttp.onreadystatechange = function () {
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

                applicationErrMsg.addEventListener('click', function () {
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
    xhttp.onreadystatechange = function () {
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

//executes on button today, next or prev btn click
function navCalender(nMonth, nYear, cmd) {
    // if cmd is today then we want to reset the calender to this month and year
    if (cmd === "today") {
        var date = new Date();
        // get this month number
        nMonth = date.getMonth();
        // get this years number
        nYear = date.getFullYear();
    }
    // alert("clicked: " + cmd + " | Month: " + nMonth + " | Year: " + nYear);

    reloadActivityCalender(nMonth, nYear);
}

// Make the DIV element draggable:
// dragElement(document.getElementById("drag-player-pinheader")); // hide this for now

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

// *** 

function checkConnection() {
    console.log("Initially " + (window.navigator.onLine ? "on" : "off") + "line");

    window.addEventListener('online', () => isOffline(false));
    window.addEventListener('offline', () => isOffline(true));
}

function isOffline(state) {
    if (state) {
        // true - show curtain
        console.log('Is Offline');
        document.getElementById('offline-curtain').style.display = 'block';
    } else {
        // false - hide curtain
        console.log('Is Online');
        document.getElementById('offline-curtain').style.display = 'none';

        // re-initialize app content (depr)
        // initializeContent("init", "init");

        // add .my-pulse-animation-light class and remove .shadow class from #main-app-refresh-btn
        document.getElementById('main-app-refresh-btn').classList.remove('shadow');
        document.getElementById('main-app-refresh-btn').classList.add('my-pulse-animation-light');
        // $('#main-app-refresh-btn').removeClass('shadow');
        // $('#main-app-refresh-btn').addClass('my-pulse-animation-light');

    }
}

// form validation
// .needs-validation
// (https://getbootstrap.com/docs/5.3/forms/validation/#server-side) Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()

function loadUserProfile() {
    //Declaring variables
    var contentContainerProfile = document.getElementById("profile-panel-container");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
            contentContainerProfile.innerHTML = output;
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_profile.php", true);
    xhttp.send();
}

function loadUserSocials() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/", true);
    xhttp.send();
}

function loadUserChallenges() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_socials.php", true);
    xhttp.send();
}

function loadUserChat() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_chat.php", true);
    xhttp.send();
}

function loadUserFriends() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_friends.php", true);
    xhttp.send();
}

function loadUserGroups() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_groups.php", true);
    xhttp.send();
}

function loadUserMedia() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_media.php", true);
    xhttp.send();
}

function loadUserNotifications() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_notifications.php", true);
    xhttp.send();
}

function loadUserPref() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_pref.php", true);
    xhttp.send();
}

function loadUserSaves() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_saves.php", true);
    xhttp.send();
}

function loadUserGroups() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_groups.php", true);
    xhttp.send();
}

function loadCommunityGroups() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_groups.php", true);
    xhttp.send();
}

function loadCommunityNews() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_news.php", true);
    xhttp.send();
}

function loadCommunityAchievements() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_achievements.php", true);
    xhttp.send();
}

function loadCommunityEvents() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_events.php", true);
    xhttp.send();
}

function loadCommunityMedia() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_media.php", true);
    xhttp.send();
}

function loadCommunityResources() {
    //Declaring variables
    var contentContainerResourceFeed = document.getElementById("v-pills-social-resfeed-content");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);

            contentContainerResourceFeed.innerHTML = output;
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_news.php", true);
    xhttp.send();
}

function loadCommunityRewards() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_rewards.php", true);
    xhttp.send();
}

function loadCommunityUpdates() {
    //Declaring variables
    var contentContainerCommUpdatesA = document.getElementById("homeCommunityPosts");
    var contentContainerCommUpdatesB = document.getElementById("comm-updates-search-container");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            //alert(output);

            contentContainerCommUpdatesA.innerHTML = output;
            contentContainerCommUpdatesB.innerHTML = output;
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_updates.php", true);
    xhttp.send();
}

// *** date functions
// use moment.js to get an array of dates (this week; last week or next weeks dates need to get a modifier that subtracts or adds 7 days to the functions loop cycle???)
// source: https://stackoverflow.com/questions/52108938/how-to-get-last-3-weeks-date-range-using-moment#52109339
function getWeekRange(week = 0) {
    var weekStart = moment().add(week, 'weeks').startOf('week');
    var days = [];
    for (var i = 1; i <= 7; i++) { //start the iteration from 1 (monday) not 0 (sunday), add <= to make sure it iterates a total of 7 times
        days.push(weekStart.clone().add(i, 'day').format('YYYY-MM-DD'));
    }
    return days;
}


function getSpecificWeekRange(dateStr = new Date()) {
    var dateStr = new Date(dateStr);
    var weekStart = moment(dateStr).startOf('week');
    var days = [];
    for (var i = 1; i <= 7; i++) { //start the iteration from 1 (monday) not 0 (sunday), add <= to make sure it iterates a total of 7 times
        days.push(weekStart.clone().add(i, 'day').format('YYYY-MM-DD'));
    }
    return days;
}

// function to get dates day name
// source: http://stackoverflow.com/questions/24998624/ddg#45464959
function getDayName(dateStr, locale) {
    var date = new Date(dateStr);
    return date.toLocaleDateString(locale, { weekday: 'long' });
}
// *** date functions (end)

//Plyr.io JS Code
(function () {
    var video = document.querySelector('#player');

    if (Hls.isSupported()) {
        var hls = new Hls();
        hls.loadSource('https://content.jwplatform.com/manifests/vM7nH0Kl.m3u8');
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED, function () {
            video.play();
        });
    }

    plyr.setup(video);
})();

//get twitter trends
/*var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function () {
  if (this.readyState == 4 && this.status == 200) {
    var output = this.responseText;
    alert(output);
  }
};
xhttp.open("GET", "https://api.twitter.com/1.1/trends/place.json?id=1", true);
xhttp.send();*/

function socialFunctions(action, origin) {
    alert("Action: " + action + " | Origin: " + origin);
}

//freeNBAUnofficial();

// *****snackbar scripting
function showSnackbar(message, alert_type, display_length) {
    // alert_type:alert_google, 
    // alert_type:alert_twitter, 
    // alert_type:alert_facebook,
    // alert_type:alert_fitbit,
    // alert_type:alert_general, 
    // alert_type:alert_error, 
    // alert_type:alert_success, 

    // display_length: short_5000
    // display_length: medium_10000
    // display_length: long_15000
    alert_type = alert_type || 'alert_general'; // initialize
    display_length = display_length || 'medium_10000'; // initialize

    var icon = message.substring(
        message.lastIndexOf("<") + 1,
        message.lastIndexOf(">")
    );

    // replace text between icon: < and > with material icon span tag
    var message = message.replace(/(?<=\<)(.*?)(?=\>)/, 'span class="material-icons material-icons-round"> ' + icon + ' </span');

    var alert_class;

    switch (alert_type) {
        case 'alert_google':
            console.log('snackbar alert: ' + alert_type);
            alert_class = "snackbar-alert-google";
            break;
        case 'alert_twitter':
            console.log('snackbar alert: ' + alert_type);
            alert_class = "snackbar-alert-twitter";
            break;
        case 'alert_facebook':
            console.log('snackbar alert: ' + alert_type);
            alert_class = "snackbar-alert-facebook";
            break;
        case 'alert_fitbit':
            console.log('snackbar alert: ' + alert_type);
            alert_class = "snackbar-alert-fitbit";
            break;
        case 'alert_general':
            console.log('snackbar alert: ' + alert_type);
            alert_class = "snackbar-alert-general";
            break;
        case 'alert_error':
            console.log('snackbar alert: ' + alert_type);
            alert_class = "snackbar-alert-error";
            break;
        case 'alert_success':
            console.log('snackbar alert: ' + alert_type);
            alert_class = "snackbar-alert-success";
            break;
        case 'alert_warning':
            console.log('snackbar alert: ' + alert_type);
            alert_class = "snackbar-alert-warning";
            break;

        default:
            console.log('snackbar alert: default - alert type unrecognized [' + alert_type + ']');
            break;
    }

    var displayLength;
    switch (display_length) {
        case 'short_5000':
            console.log('snackbar alert: dl: ' + display_length);
            displayLength = 5000;
            break;
        case 'medium_10000':
            console.log('snackbar alert: dl: ' + display_length);
            displayLength = 10000;
            break;
        case 'long_15000':
            console.log('snackbar alert: dl: ' + display_length);
            displayLength = 15000;
            break;

        default:
            console.log('snackbar alert: default - display length unrecognized [' + alert_type + ']');
            displayLength = 10000;
            break;
    }

    // Get the snackbar DIV
    var x = document.getElementById("snackbar");

    // Add the "show" class concatenated with the alert_type class to DIV
    x.className = "show " + alert_class;

    // pass the message into #snackbar
    x.innerHTML = message;

    // After 3 seconds, remove the show class from DIV and remove alert_class
    setTimeout(function () {
        x.className = x.className.replace(alert_class, "");
        x.className = x.className.replace("show", "");
    }, displayLength);

}

// capitalize the first letter of passed string
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// formation & tactics functions
function tacticalPlanModification(action, playerId) {
    // params: 'action-','player_id'
}

function modifyFormationPlayerRecord(changeReq, playerId) {
    // params: 'change-requested', 'player_id'
    // changeReq can be: 'position', ???
    switch (changeReq) {
        case 'position':
            // we want to show the position modification modal
            document.getElementById("modifyPlayerDataModalLabel").innerHTML = "Change Player Position (" + playerId + ")";

            // show the modifyPlayerDataModal by clicking the toggle-modifyPlayerDataModal-btn
            document.getElementById("toggle-modifyPlayerDataModal-btn").click();

            break;

        default:
            break;
    }
}

// js cookie functions - https://www.w3schools.com/js/js_cookies.asp
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie(cookieName) {
    let reqCookie = getCookie(cookieName);
    if (reqCookie != "") {
        console.log("checkCookie -> cookie exists: " + reqCookie);
        return true;
    } else {
        console.log("checkCookie -> cookie does not exists: " + reqCookie);
        return false;
    }
}
