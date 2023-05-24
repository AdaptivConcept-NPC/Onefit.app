<?php
session_start();
require("../../../config.php");
require("../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// global variables
if (!isset($_SESSION['currentUserUsername'])) die("Fatal Error");
else $current_user_username = $_SESSION['currentUserUsername'];

$dateToday = date("Y-m-d");
$dateDayNumber = date("N", strtotime($dateToday));
$query_date = null;

if (!isset($_GET['qdate'])) $query_date = $dateToday;
else $query_date = date("Y-m-d", $_GET['qdate']);


// twa
$teams_activity_id =
    $activity_title =
    $activity_description =
    $activity_icon =
    $teams_weekly_schedules_teams_weekly_schedule_id =
    $exercises_exercise_id = null;

$grouprefcode = null;
$userGroupRefSubsArray = array();

// get the current users group reference codes (groups they are subbed to)
try {
    // get linked grc codes of the current user from the teams members tbl
    $query = "SELECT `groups_group_ref_code` FROM `teams_group_members` WHERE `users_username` = '$current_user_username' AND `active` = 1";
    $result = $dbconn->query($query);
    if (!$result) die("An error occurred while trying to process this request.");

    $rows = $result->num_rows;
    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        // push/insert the groups_group_ref_code values to the $userGroupRefSubsArray array variable
        $grouprefcode = $row["groups_group_ref_code"];
        if (!in_array($grouprefcode, $userGroupRefSubsArray)) $userGroupRefSubsArray[] = $grouprefcode;
    }

    $result = null;

    // get linked grc codes of the current user from the community/indi members tbl
    $query = "SELECT `groups_group_ref_code` FROM `community_group_members` WHERE `users_username` = '$current_user_username' AND `active` = 1";
    $result = $dbconn->query($query);
    if (!$result) die("An error occurred while trying to process this request.");

    $rows = $result->num_rows;
    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        // push/insert the groups_group_ref_code values to the $userGroupRefSubsArray array variable
        $grouprefcode = $row["groups_group_ref_code"];
        if (!in_array($grouprefcode, $userGroupRefSubsArray)) $userGroupRefSubsArray[] = $grouprefcode;
    }

    // clear the resultsets
    $result = null;

    // get linked grc codes of the current user from the premium members tbl
    $query = "SELECT `groups_group_ref_code` FROM `premium_group_members` WHERE `users_username` = '$current_user_username' AND `active` = 1";
    $result = $dbconn->query($query);
    if (!$result) die("An error occurred while trying to process this request.");

    $rows = $result->num_rows;
    for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        // push/insert the groups_group_ref_code values to the $userGroupRefSubsArray array variable
        $grouprefcode = $row["groups_group_ref_code"];
        if (!in_array($grouprefcode, $userGroupRefSubsArray)) $userGroupRefSubsArray[] = $grouprefcode;
    }

    // clear the resultsets
    $result = null;

    // test: print the $userGroupRefSubsArray
    // print_r($userGroupRefSubsArray);
    // echo "<br/>";

    // echo count($userGroupRefSubsArray) . "<br/>";

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
    $indi_weekly_schedule_id =
        $indi_schedule_title =
        $indi_schedule_rpe =
        $indi_schedule_day =
        $indi_schedule_date =
        $indi_group_ref_code = null;
    $ui_output_elems = $indi_elems = $teams_elems = null;

    $privacy_icon = null;

    // compile the activities for each grc code in the array
    foreach ($userGroupRefSubsArray as $grc) {
        // we use LEFT JOIN in this query to satisfy the result of the grps table as grps will have 
        // a complete set of grc codes whereas the teamsws and indiws tables may not
        $query = "SELECT grps.*
        ,indiws.indi_weekly_schedule_id AS indiws_id
        ,indiws.schedule_title AS indiws_title
        ,indiws.schedule_rpe AS indiws_rpe
        ,indiws.schedule_day AS indiws_day
        ,indiws.schedule_date AS indiws_date
        ,indiws.groups_group_ref_code AS indiws_grc
        ,teamsws.teams_weekly_schedule_id AS teamsws_id
        ,teamsws.schedule_title AS teamsws_title
        ,teamsws.schedule_rpe AS teamsws_rpe
        ,teamsws.schedule_day AS teamsws_day
        ,teamsws.schedule_date AS teamsws_date
        ,teamsws.groups_group_ref_code AS teamsws_grc 
        FROM groups grps 
        LEFT JOIN indi_weekly_schedules indiws 
            ON indiws.groups_group_ref_code = grps.group_ref_code 
        LEFT JOIN teams_weekly_schedules teamsws 
            ON teamsws.groups_group_ref_code = grps.group_ref_code 
        WHERE grps.group_ref_code  = '$grc' AND (indiws.schedule_date = '$query_date' OR teamsws.schedule_date = '$query_date')"; // AND (indiws.schedule_date = '$query_date' OR teamsws.schedule_date = '$query_date')

        // echo "grc( $grc ) <br /> $query<br />";

        $result = $dbconn->query($query);
        if (!$result) die("Fata Error");

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $recordsFound = true;

            // group details
            $group_name = $row['group_name'];
            $group_category = $row['group_category'];
            $group_privacy = $row['group_privacy'];

            // indiws details
            $indi_weekly_schedule_id = $row["indiws_id"];
            $indi_schedule_title = $row["indiws_title"];
            $indi_schedule_rpe = $row["indiws_rpe"];
            $indi_schedule_day = ucfirst($row["indiws_day"]);
            $indi_schedule_date = date("d/m/Y", strtotime($row["indiws_date"]));
            $indi_group_ref_code = $row["indiws_grc"];

            // teamsws details
            $teams_weekly_schedule_id = $row["teamsws_id"];
            $teams_schedule_title = $row["teamsws_title"];
            $teams_schedule_rpe = $row["teamsws_rpe"];
            $teams_schedule_day = ucfirst($row["teamsws_day"]);
            $teams_schedule_date = date("d/m/Y", strtotime($row["teamsws_date"]));
            $teams_group_ref_code = $row["teamsws_grc"];

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

                default:
                    # public
                    $privacy_icon = <<<_END
                    <span class="material-icons material-icons-outlined align-middle" style="font-size:20px!important;">
                        lock_open
                    </span>
                    _END;
                    break;
            }

            // check if indiws_id is NULL, if not NULL then set $recordsFound_Indi to true and append 
            // ui element to display data to output var
            if ($indi_weekly_schedule_id != "NULL" && $group_category == "indi") {
                $recordsFound_Indi = true;
                // do something
                $indi_elems .= <<<_END
                <div id="daily-activity-tile-$indi_weekly_schedule_id" class="card grid-tile down-top-grad-tahiti shadow border-5 border-bottom border-white">
                    <div class="card-body d-flex gap-2 align-items-center justify-content-between text-center mb-2" id="no-activities-banner-container" style="min-height: 100px;">
                        <div class="activity-icon rounded-circle shadow p-4 border border-white border-5">
                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded" alt="" height="50" width="50">
                        </div>
                        <div class="activity-details text-end">
                            <p class="text-start"><span class="align-middle" style="font-size:10px;">$group_name</span> | <span class="align-middle" style="font-size:10px;">$group_category</span> | $privacy_icon <span class="align-middle" style="font-size:10px;">$group_privacy</span></p>
                            <p>Activity title:<br/> $indi_schedule_title</p>
                            <p>RPE:<br/> $indi_schedule_rpe</p>
                            <p>Date:<br/> $indi_schedule_day, $indi_schedule_date</p>
                        </div>
                    </div>
                    <div class="card-footer d-grid p-4" style="border-radius:25px;">
                        <button type="button" class="onefit-buttons-style-light p-2 shadow" aria-current="false" onclick="goTrainer('$indi_weekly_schedule_id', '$indi_group_ref_code')">
                            Start.
                        </button>
                    </div>
                </div>
                _END;
            }

            // check if indiws_id is NULL, if not NULL then set $recordsFound_Indi to true and append 
            // ui element to display data to output var
            if ($teams_weekly_schedule_id != "NULL" && $group_category == "teams") {
                $recordsFound_Teams = true;
                // do something
                $teams_elems .= <<<_END
                <div id="daily-activity-tile-$teams_weekly_schedule_id" class="card grid-tile down-top-grad-tahiti shadow border-5 border-bottom border-white">
                    <div class="card-body d-flex gap-2 align-items-center justify-content-between text-center mb-2" id="no-activities-banner-container" style="min-height: 100px;">
                        <div class="activity-icon rounded-circle shadow p-4 border border-white border-5">
                            <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded" alt="" height="50" width="50">
                        </div>
                        <div class="activity-details text-end">
                            <p class="text-start"><span class="align-middle" style="font-size:10px;">$group_name</span> | <span class="align-middle" style="font-size:10px;">$group_category</span> | $privacy_icon <span class="align-middle" style="font-size:10px;">$group_privacy</span></p>
                            <p>Activity title:<br/> $teams_schedule_title</p>
                            <p>RPE:<br/> $teams_schedule_rpe</p>
                            <p>Date:<br/> $teams_schedule_day, $teams_schedule_date</p>
                        </div>
                    </div>
                    <div class="card-footer d-grid p-4" style="border-radius:25px;">
                        <button type="button" class="onefit-buttons-style-light p-2 shadow" aria-current="false" onclick="goTrainer('$teams_weekly_schedule_id', '$teams_group_ref_code')">
                            Start.
                        </button>
                    </div>
                </div>
                _END;
            }
        }
    }

    // if $recordsFound is true, compile $ui_output_elems variable for final output
    if (!$recordsFound) {
        $ui_output_elems = <<<_END
        <div class="d-flex align-items-center text-center justify-content-center mb-4" id="no-activities-banner-container" style="min-height: 100px;">
            <p class="my-4 fs-5 fw-bold comfortaa-font" style="cursor: pointer;" onclick="openLink(event, 'TabStudio')">No community &amp; teams activities lined up. Go to the <span style="color: #ffa500;">.Studio</span> to get active.</p>
        </div>
        _END;
    } else {
        if ($recordsFound_Teams) {
            # if true then add teams_elems to ui output
            $ui_output_elems .= <<<_END
            <h5 class="fs-2 py-4">Teams activities.</h5>
            <div class="w-100" style="overflow-x:auto;">
                <div class="grid-container mb-4">
                    $teams_elems
                </div>
            </div>
            _END;
        }
        if ($recordsFound_Indi) {
            # if true then add indi_elems to ui output
            $ui_output_elems .= <<<_END
            <h5 class="fs-2 py-4">Indi activities.</h5>
            <div class="w-100" style="overflow-x:auto;">
                <div class="grid-container mb-4">
                    $indi_elems
                </div>
            </div>
            _END;
        }
    }

    echo $ui_output_elems;
} catch (\Throwable $th) {
    // throw $th;
    die("error: [exception 01]" . $th->getMessage);
}

$result = null;
$dbconn->close();
