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
    $result = $innerResult = null;

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
    $result = $innerResult = null;

    // echo count($userGroupRefSubsArray) . "<br/>";

    // init variables
    $recordsFound = $recordsFound_Indi = $recordsFound_Teams = false;
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
        WHERE grps.group_ref_code  = '$grouprefcode'"; // AND (indiws.schedule_date = '$dateToday' OR teamsws.schedule_date = '$dateToday')

        // echo "grc( $grc ) <br /> $query<br />";

        $result = $dbconn->query($query);
        if (!$result) die("Fata Error");

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $recordsFound = true;

            // indiws
            $indi_weekly_schedule_id = $row["indiws_id"];
            $indi_schedule_title = $row["indiws_title"];
            $indi_schedule_rpe = $row["indiws_rpe"];
            $indi_schedule_day = ucfirst($row["indiws_day"]);
            $indi_schedule_date = date("d/m/Y", strtotime($row["indiws_date"]));
            $indi_group_ref_code = $row["indiws_grc"];

            // check if indiws_id is NULL, if not NULL then set $recordsFound_Indi to true and append 
            // ui element to display data to output var
            if ($indi_weekly_schedule_id != "NULL") {
                $recordsFound_Indi = true;
                // do something
                $indi_elems .= <<<_END
                <button type="button" class="list-group-item list-group-item-action" aria-current="false" onclick="goTrainer('$indi_weekly_schedule_id', '$indi_group_ref_code')">
                    <div class="row">
                        <div class="col">
                            <p class="fs-bold">Schedule</p> 
                            <p>Title: $indi_schedule_title</p>
                            <p>RPE: $indi_schedule_rpe</p>
                            <p>Date: $indi_schedule_day ($indi_schedule_date)</p>
                        </div>
                    </div>
                </button>
                _END;
            }

            /* <div class="col">
                <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                    <img src="$activity_icon" src="$schedule_title - $activity_title" class="img-fluidz" style="width: 48px;">
                </span>
            </div> */

            // teamsws
            $teams_weekly_schedule_id = $row["teamsws_id"];
            $teams_schedule_title = $row["teamsws_title"];
            $teams_schedule_rpe = $row["teamsws_rpe"];
            $teams_schedule_day = ucfirst($row["teamsws_day"]);
            $teams_schedule_date = date("d/m/Y", strtotime($row["teamsws_date"]));
            $teams_group_ref_code = $row["teamsws_grc"];

            // check if indiws_id is NULL, if not NULL then set $recordsFound_Indi to true and append 
            // ui element to display data to output var
            if ($teams_weekly_schedule_id != "NULL") {
                $recordsFound_Teams = true;
                // do something
                $teams_elems .= <<<_END
                <button type="button" class="list-group-item list-group-item-action" aria-current="false" onclick="goTrainer('$teams_weekly_schedule_id', '$teams_group_ref_code')">
                    <div class="row">
                        <div class="col">
                            <p class="fs-bold">Schedule</p> 
                            <p>Title: $teams_schedule_title</p>
                            <p>RPE: $teams_schedule_rpe</p>
                            <p>Date: $teams_schedule_day ($teams_schedule_date)</p>
                        </div>
                    </div>
                </button>
                _END;
            }

            // indiwa
            // $indi_activity_id = $row["indi_activity_id"];
            // $activity_title = $row["activity_title"];
            // $activity_description = $row["activity_description"];
            // $activity_icon = $row["activity_icon"];
            // $teams_weekly_schedules_teams_weekly_schedule_id = $row["teams_weekly_schedules_teams_weekly_schedule_id"];
            // $exercises_exercise_id = $row["exercises_exercise_id"];
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
        $ui_output_elems .= <<<_END
        <li class="list-group-item list-group-item-actionz">
            <h5>Indi &amp; Community activities.</h5>
        </li>
        $indi_elems
        <li class="list-group-item list-group-item-actionz">
            <h5>Teams activities.</h5>
        </li>
        $teams_elems
        _END;
    }

    echo $ui_output_elems;
} catch (\Throwable $th) {
    // throw $th;
    die("error: [exception 01]" . $th->getMessage);
}

$result = null;
$dbconn->close();
