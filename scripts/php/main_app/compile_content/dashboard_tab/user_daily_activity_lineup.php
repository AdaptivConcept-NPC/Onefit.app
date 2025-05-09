<?php
session_start();
require("../../../config.php");
require("../../../functions.php");
// scripts/php/main_app/compile_content/dashboard_tab/user_daily_activity_lineup.php

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// global variables
if (!isset($_SESSION['currentUserUsername'])) die("Fatal Error");
else $current_user_username = $_SESSION['currentUserUsername'];
// echo "Current User: $current_user_username <br/>";

// compile the request date of today to be used for capture_dates
$dateToday = date("Y-m-d");
$dateDayNumber = date("N", strtotime($dateToday));
$query_date = null;

// check if qdate is set, if not then set to today
if (!isset($_GET['qdate'])) $query_date = $dateToday;
else $query_date = date("Y-m-d", strtotime($_GET['qdate']));
// echo "Query Date: $query_date <br/>";

// twa vars
$teams_activity_id =
    $activity_title =
    $activity_description =
    $activity_icon =
    $teams_weekly_schedules_teams_weekly_schedule_id =
    $exercises_exercise_id = null;

$grouprefcode = null;
$userGroupRefSubsArray = array();

$teamsReturnFlag = $indiReturnFlag = $proReturnFlag = $grefFound = false;

// function to get the current users group reference codes (groups they are subbed to)
function getUserGroupRefCodes($current_user_username, $userGroupRefSubsArray, $dbconn, $groupType, $grefFound)
{
    switch ($groupType) {
        case 'teams':
            $query = "SELECT `groups_group_ref_code` FROM `teams_group_members` WHERE `users_username` = '$current_user_username' AND `active` = 1";
            break;
        case 'indi':
            $query = "SELECT `groups_group_ref_code` FROM `community_group_members` WHERE `users_username` = '$current_user_username' AND `active` = 1";
            break;
        case 'pro':
            $query = "SELECT `groups_group_ref_code` FROM `premium_group_members` WHERE `users_username` = '$current_user_username' AND `active` = 1";
            break;

        default:
            return "undefined group type: $groupType";
            break;
    }

    $result = $dbconn->query($query);
    if (!$result) die("An error occurred while trying to process this request.");

    $rows = $result->num_rows;
    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        $grefFound = true;

        // push/insert the groups_group_ref_code values to the $userGroupRefSubsArray array variable
        $grouprefcode = $row["groups_group_ref_code"];
        if (!in_array($grouprefcode, $userGroupRefSubsArray)) $userGroupRefSubsArray[] = $grouprefcode;
    }

    // dump the $result variable
    // $result = null;
    unset($result);

    return $grefFound;
}

// try to get the current users group reference codes (groups they are subbed to)
try {
    // look for linked grc codes of the current user from the teams, indi and pro groups
    $teamsReturnFlag = getUserGroupRefCodes($current_user_username, $userGroupRefSubsArray, $dbconn, "teams", false);
    $indiReturnFlag = getUserGroupRefCodes($current_user_username, $userGroupRefSubsArray, $dbconn, "indi", false);
    $proReturnFlag = getUserGroupRefCodes($current_user_username, $userGroupRefSubsArray, $dbconn, "pro", false);

    // test: print the $userGroupRefSubsArray // debug
    // echo "Row count: ".count($userGroupRefSubsArray) . "<br/>";
    // print_r($userGroupRefSubsArray); // debug 
    // echo "<br/>"; // debug

    // init variables
    $recordsFound = $recordsFound_Indi = $recordsFound_Teams = false;
    $group_name =
        $group_category =
        $group_privacy = null;
    $teams_weekly_schedule_id =
        $teams_schedule_title =
        $teams_schedule_rpe =
        $teams_schedule_day =
        $teams_schedule_date =
        $teams_group_ref_code = null;
    $teams_activity_id = $$activity_title =
        $activity_description =
        $activity_icon =
        $teams_weekly_schedule =
        $exercises_exercise_id = null;
    $indi_weekly_schedule_id =
        $indi_schedule_title =
        $indi_schedule_rpe =
        $indi_schedule_day =
        $indi_schedule_date =
        $indi_group_ref_code = null;
    $ui_output_elems = $indi_schedule_cards_content = $teams_schedule_cards_content = null;

    $privacy_icon = null;

    // compile the activities for each grc code in the array ($userGroupRefSubsArray)
    foreach ($userGroupRefSubsArray as $grc) {

        // extract date elements from $query_date
        $query_date_Year = date('Y', strtotime($query_date));
        $query_date_Month = date('m', strtotime($query_date));
        $query_date_Date = date('d', strtotime($query_date));

        // getScheduledTrainingDayActivities function (functions.php) should return a json object
        $twaResult = json_decode(getScheduledTrainingDayActivities($query_date_Year, $query_date_Month, $query_date_Date, $grc), true); // use this function to get $result object for TrainingDayActivities data

        // check if returned $result is an object, if not then string returned -> check if string contains "error"
        if (is_array($twaResult) === false) {
            // check if string contains "error", if true then die
            if (!$twaResult || strpos($twaResult, "error")) die("Fatal Error: " . $dbconn->error);
        } else {
            // loop through the $result object and extract the data
            foreach ($twaResult as $row) {
                // set $recordsFound to true (flag) to indicate that records were found
                $recordsFound = true;

                // assign group details to group details variables
                $group_name = $row['group_name'];
                $group_category = $row['group_category'];
                $group_privacy = $row['group_privacy'];

                // teams weekly schedule details (tws)
                $teams_weekly_schedule_id = $row["tws_id"];
                $teams_schedule_title = $row["schedule_title"];
                $teams_schedule_rpe = $row["schedule_rpe"];
                $teams_schedule_day = ucfirst($row["schedule_day"]);
                $teams_schedule_date = date("d/m/Y", strtotime($row["schedule_date"]));
                $teams_schedule_color_tag = $row["color_code"];
                preg_match('/\[(.*?)\]/', $teams_schedule_color_tag, $matches); // extract text between []
                $teams_schedule_color_tag = !empty($matches[1]) ? $matches[1] : "var(--white)"; // default to "var(--white)" if blank or error
                $teams_group_ref_code = $row["groups_group_ref_code"];

                // teams weekly activities details (twa)
                $teams_activity_id = $row["twa_id"];
                $activity_title = $row["activity_title"];
                $activity_description = $row["activity_description"];
                $activity_icon = !empty($row["activity_icon"]) ? $row["activity_icon"] : "../media/assets/icons/icons8-bench-press-50.png"; // check if activity_icon is empty, if empty then set default icon
                $teams_weekly_schedules_teams_weekly_schedule_id = $row["teams_weekly_schedules_teams_weekly_schedule_id"];
                $exercises_exercise_id = $row["exercises_exercise_id"];

                // check group_privacy and set privacy icon
                switch ($group_privacy) {
                    case 'public':
                        # code...
                        $privacy_icon = <<<_END
                        <span class="material-icons material-icons-outlined align-middle" style="font-size:20px!important;">
                            lock_open
                        </span>
                        _END;
                        break;
                    case 'private':
                        # code...
                        $privacy_icon = <<<_END
                        <span class="material-icons material-icons-outlined align-middle" style="font-size:20px!important;">
                            lock
                        </span>
                        _END;
                        break;
                    case 'pro':
                        # code...
                        $privacy_icon = <<<_END
                        <span class="material-icons material-icons-outlined align-middle" style="font-size:20px!important;">
                            lock
                        </span>
                        _END;
                        break;
                    case 'teams':
                        # code...
                        $privacy_icon = <<<_END
                            <span class="material-icons material-icons-outlined align-middle" style="font-size:20px!important;">
                                lock
                            </span>
                            _END;
                        break;

                    default:
                        # public
                        $privacy_icon = <<<_END
                    <span class="material-icons material-icons-outlined align-middle" style="font-size:20px!important;">
                        lock_open
                    </span>
                    _END;
                        break;
                }

                // init column bar html
                $teams_column_bar_activities = null;

                // check if indiws_id is NULL, if not NULL then set $recordsFound_Indi to true and append 
                // ui element to display data to output var
                if ($group_category == "teams" || $group_category == "pro") {
                    $recordsFound_Teams = true;
                    // do something
                    $teams_schedule_cards_content .= <<<_END
                    <div id="daily-activity-tile-$teams_weekly_schedule_id" class="card grid-tile down-top-grad-tahiti shadow" style="background-color: $teams_schedule_color_tag;">
                        <div class="card-body d-flex gap-2 align-items-center justify-content-between text-center mb-2" id="no-activities-banner-container" style="min-height: 100px;">
                            <div class="activity-icon shadow">
                                <img src="$activity_icon" class="img-fluid rounded-circle p-4 border border-white border-5" alt="activity icon" style="max-height:100px;width:auto;">
                                <!-- ../media/assets/icons/icons8-bench-press-50.png -->
                            </div>
                            <div class="activity-details text-end">
                                <p class="text-start" style="font-size:10px;">
                                    <span class="align-middle">$group_name</span> | 
                                    <span class="align-middle">$group_category</span> | 
                                    $privacy_icon 
                                    <span class="align-middle">$group_privacy</span>
                                </p>
                                <p><span style="color: var(--primary-color)!important;">Activity title:</span><br/> $activity_title</p>
                                <p><span style="color: var(--secondary-color)!important;">RPE:</span><br/> $teams_schedule_rpe</p>
                                <p class="mb-4"><span style="color: var(--secondary-color)!important;">Date:</span><br/> $teams_schedule_day, $teams_schedule_date</p>
                                <p class="m-0"><span style="color: var(--secondary-color)!important;">Description:</span></p>
                                <p class="text-start light-scroller" style="max-height:100px;overflow-y:auto;font-size:12px;">$activity_description</p>
                            </div>
                        </div>
                        <div class="card-footer d-grid p-4" style="border-radius:25px;">
                            <button type="button" class="onefit-buttons-style-light p-2 shadow" aria-current="false" onclick="goTrainer($teams_weekly_schedule_id, $teams_activity_id, '$teams_group_ref_code')">
                                Start.
                            </button>
                        </div>
                    </div>
                    _END;

                    $teams_column_bar_activities .= <<<_END
                    <div class="d-grid gap-1" 
                        style="cursor:pointer;">
                        <div class="activity-icon rounded-circle shadow p-4 border border-white border-5">
                            <img src="$activity_icon" alt="activity icon" style="height:50px!important;width:auto;">
                            <!-- ../media/assets/icons/icons8-bench-press-50.png -->
                        </div>
                        <p><span style="color: var(--text-color)!important;">Activity title:</span><br/> $activity_title</p>
                        <p><span style="color: var(--text-color)!important;">RPE:</span><br/> $teams_schedule_rpe</p>
                        <p class="mb-4"><span style="color: var(--text-color)!important;">Date:</span><br/> $teams_schedule_day, $teams_schedule_date</p>
                        <hr class="text-white my-2 p-0" style="height: 5px;">
                    </div>
                    _END;
                }
            }
        }
    }

    // init variables
    $teams_content = $indi_content = $columnBarHTML = null;

    if ($recordsFound === false) {
        // if $recordsFound is false, no activities found
        $ui_output_elems = <<<_END
        <div class="d-flex align-items-center text-center justify-content-center mb-4" id="no-activities-banner-container" style="min-height: 100px;">
            <p class="my-4 fs-5 fw-bold comfortaa-font" style="cursor: pointer;" onclick="openLink(event, 'TabStudio')">No community &amp; teams activities lined up. Go to the <span style="color: var(--primary-color);">.Studio</span> to get active.</p>
        </div>
        _END;
    } else {
        $teamsColumnBarHTML = <<<_END
        <div id="calender-activities-bar-$teams_schedule_day" 
            class="fw-bold fs-3 fw-bold text-dark comfortaa-font top-down-grad-tahiti p-4 h-100" 
            style="border-radius: 25px 25px 0 0;">
            <p class="text-center fs-5 fw-bold comfortaa-font" style="color:var(--text-color) !important;background-color: $teams_schedule_color_tag;">$teams_schedule_title</p>
            <hr>
            $teams_column_bar_activities
            <hr>
            <p class="text-center fs-5 fw-bold comfortaa-font" style="color:var(--text-color) !important">$teams_schedule_day</p>
            <p class="text-center fs-5 fw-bold comfortaa-font" style="color:var(--text-color) !important">$teams_schedule_date</p>
        </div>
        _END;

        // if $recordsFound is true, compile $ui_output_elems variable for final output
        if ($recordsFound_Teams) {
            # if true then add $teams_schedule_cards_content to ui output
            $teams_content .= <<<_END
            <h5 class="fs-2 py-4">Teams activities.</h5>
            <div class="row">
                <div class="col-4 align-self-end">
                <!-- activity bar -->
                    $teamsColumnBarHTML
                </div>
                <div class="col-8">
                    <!-- activities cards -->
                    <div class="w-100" style="overflow-x:auto;">
                        <div class="grid-container mb-4">
                            $teams_schedule_cards_content
                        </div>
                    </div>
                </div>
            </div>
            _END;
        }
        // if ($recordsFound_Indi) {
        //     # if true then add indi_schedule_cards_content to ui output
        //     $indi_content .= <<<_END
        //     <h5 class="fs-2 py-4">Indi activities.</h5>
        //     <div class="row">
        //         <div class="col-md-4">
        //         <!-- activity bar -->
        //             $indiColumnBarHTML
        //         </div>
        //         <div class="col-md">
        //             <!-- activities cards -->
        //             <div class="w-100" style="overflow-x:auto;">
        //                 <div class="grid-container mb-4">
        //                     $indi_schedule_cards_content
        //                 </div>
        //             </div>
        //         </div>
        //     </div>
        //     _END;
        // }
    }

    $ui_output_elems = <<<_END
    <div class="container-fluid">
        $teams_content
        $indi_content
    </div>
    _END;

    echo $ui_output_elems;
} catch (\Throwable $th) {
    // throw $th;
    die("error: [exception 01] " . $th);
}

// $result = null;
$result = null;
$dbconn->close();


// xxxxxxxxxxxx
// we use LEFT JOIN in this query to satisfy the result of the grps table as grps will have 
// a complete set of grc codes whereas the teamsws and indiws tables may not
// $query = "SELECT grps.*
// ,indiws.indi_weekly_schedule_id AS indiws_id
// ,indiws.schedule_title AS indiws_title
// ,indiws.schedule_rpe AS indiws_rpe
// ,indiws.schedule_day AS indiws_day
// ,indiws.schedule_date AS indiws_date
// ,indiws.groups_group_ref_code AS indiws_grc
// ,teamsws.teams_weekly_schedule_id AS teamsws_id
// ,teamsws.schedule_title AS teamsws_title
// ,teamsws.schedule_rpe AS teamsws_rpe
// ,teamsws.schedule_day AS teamsws_day
// ,teamsws.schedule_date AS teamsws_date
// ,teamsws.groups_group_ref_code AS teamsws_grc 
// FROM groups grps 
// LEFT JOIN indi_weekly_schedules indiws 
//     ON indiws.groups_group_ref_code = grps.group_ref_code 
// LEFT JOIN teams_weekly_schedules teamsws 
//     ON teamsws.groups_group_ref_code = grps.group_ref_code 
// WHERE grps.group_ref_code  = '$grc' AND (indiws.schedule_date = '$query_date' OR teamsws.schedule_date = '$query_date')"; // AND (indiws.schedule_date = '$query_date' OR teamsws.schedule_date = '$query_date')

// $indiColumnBarHTML = null;
// check if indiws_id is NULL, if not NULL then set $recordsFound_Indi to true and append 
// ui element to display data to output var
// if ($indi_weekly_schedule_id != "NULL" && $group_category == "indi") {
//     $recordsFound_Indi = true;
//     // do something
//     $indi_schedule_cards_content .= <<<_END
//     <div id="daily-activity-tile-$indi_weekly_schedule_id" class="card grid-tile down-top-grad-tahiti shadow border-5 border-bottom border-white">
//         <div class="card-body d-flex gap-2 align-items-center justify-content-between text-center mb-2" id="no-activities-banner-container" style="min-height: 100px;">
//             <div class="activity-icon rounded-circle shadow p-4 border border-white border-5">
//                 <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded" alt="" height="50" width="50">
//             </div>
//             <div class="activity-details text-end">
//                 <p class="text-start"><span class="align-middle" style="font-size:10px;">$group_name</span> | <span class="align-middle" style="font-size:10px;">$group_category</span> | $privacy_icon <span class="align-middle" style="font-size:10px;">$group_privacy</span></p>
//                 <p>Activity title:<br/> $indi_schedule_title</p>
//                 <p>RPE:<br/> $indi_schedule_rpe</p>
//                 <p>Date:<br/> $indi_schedule_day, $indi_schedule_date</p>
//             </div>
//         </div>
//         <div class="card-footer d-grid p-4" style="border-radius:25px;">
//             <button type="button" class="onefit-buttons-style-light p-2 shadow" aria-current="false" onclick="goTrainer('$indi_weekly_schedule_id', '$indi_group_ref_code')">
//                 Start.
//             </button>
//         </div>
//     </div>
//     _END;

// $indiColumnBarHTML= <<<_END
// <div class="d-grid gap-1" 
//     style="cursor:pointer;">
//     <div class="activity-icon rounded-circle shadow p-4 border border-white border-5">
//         <img src="$activity_icon" alt="activity icon" style="height:50px!important;width:50px!important;">
//         <!-- ../media/assets/icons/icons8-bench-press-50.png -->
//     </div>
//     <p><span style="color: var(--primary-color)!important;">Activity title:</span><br/> $activity_title</p>
//     <p><span style="color: var(--secondary-color)!important;">RPE:</span><br/> $teams_schedule_rpe</p>
//     <p class="mb-4"><span style="color: var(--secondary-color)!important;">Date:</span><br/> $teams_schedule_day, $teams_schedule_date</p>
//     <hr class="text-white my-2 p-0" style="height: 5px;">
// </div>
// _END;
// }

// test output // debug
// echo "tws_id: " . $teams_weekly_schedule_id . "<br/>";
// echo "tws_title: " . $teams_schedule_title . "<br/>";
// echo "tws_rpe: " . $teams_schedule_rpe . "<br/>";
// echo "tws_day: " . $teams_schedule_day . "<br/>";
// echo "tws_date: " . $teams_schedule_date . "<br/>";
// echo "tws_color: " . $teams_schedule_color_tag . "<br/>";
// echo "tws_grcode: " . $teams_group_ref_code . "<br/>";