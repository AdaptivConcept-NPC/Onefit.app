<?php
session_start();
require("../../../../config.php");
require_once("../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// declaring variables
if (isset($_GET['grcode'])) $grc_code = sanitizeMySQL($dbconn, $_GET['grcode']);
else $grc_code = "init";
// die("grcode is not set");

// get param value that tells us if user is requesting upcoming games or previous match history
if (!isset($_GET['period_req'])) $requesting_data = "all"; //by default it should be the entire history of matches (both upcoming and past)
else $requesting_data = sanitizeMySQL($dbconn, $_GET['period_req']);

$current_user_username = $_SESSION['currentUserUsername'];

$team_athletics_match_id
    = $match_title
    = $home_team
    = $away_team
    = $match_venue
    = $match_date
    = $start_time
    = $standard_match_duration
    = $observed_match_duration
    = $match_result
    = $groups_group_ref_code
    = $compile_table_rows = null;

// tst_grp_0001

try {
    // todays date
    $dateToday = date('Y-m-d');
    $timeNow = date('h:i:s');

    switch ($requesting_data) {
        case 'all':
            # sql query string to fetch all records for current grcode
            if ($grc_code === "init") $query = "SELECT * FROM `team_athletics_match_schedules` ORDER BY `match_date` DESC";
            else $query = "SELECT * FROM `team_athletics_match_schedules` WHERE `groups_group_ref_code` = '$grc_code' ORDER BY `team_athletics_match_id` DESC";
            break;
        case 'upcoming':
            # sql query string to fetch records with "pending" in match results column or with match dates greater than todays date for current grcode
            if ($grc_code === "init") $query = "SELECT * FROM `team_athletics_match_schedules` WHERE (`match_result` = 'pending' OR (`match_date` >= '$dateToday' AND `start_time` >= '$timeNow')) ORDER BY `match_date` DESC";
            else $query = "SELECT * FROM `team_athletics_match_schedules` WHERE `groups_group_ref_code` = '$grc_code' AND (`match_result` = 'pending' OR (`match_date` >= '$dateToday' AND `start_time` >= '$timeNow')) ORDER BY `team_athletics_match_id` DESC";
            break;
        case 'played':
            # sql query string to fetch records without "pending" in match results column or with match dates before todays date for current grcode
            if ($grc_code === "init") $query = "SELECT * FROM `team_athletics_match_schedules` WHERE (`match_result` <> 'pending' OR `match_date` < '$dateToday') ORDER BY `match_date` DESC";
            else $query = "SELECT * FROM `team_athletics_match_schedules` WHERE `groups_group_ref_code` = '$grc_code' AND (`match_result` <> 'pending' OR `match_date` < '$dateToday') ORDER BY `team_athletics_match_id` DESC";
            break;

        default:
            # kill script
            die("Unknown period request identifier provided.");
            break;
    }

    $result = $dbconn->query($query);
    if (!$result) die("A Fatal Error has occured. Please try again and if the problem persists, please contact the system administrator.");

    $rows = $result->num_rows;

    if ($rows == 0) {
        //there is no result so notify user that the account cannot be found
        $compile_table_rows = <<<_END
        <tr>
            <td colspan="10" class="text-center fs-5 fw-bold">No matches to display.</td>
        </tr>
        _END;
    } else {
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $team_athletics_match_id = $row["team_athletics_match_id"];
            $match_title = $row["match_title"];
            $home_team = $row["home_team"];
            $away_team = $row["away_team"];
            $match_venue = $row["match_venue"];
            $match_date = $row["match_date"];
            $start_time = $row["start_time"];
            $standard_match_duration = $row["standard_match_duration"];
            $observed_match_duration = $row["observed_match_duration"];
            $match_result = $row["match_result"];
            $groups_group_ref_code = $row["groups_group_ref_code"];

            $compile_table_rows .= <<<_END
            <tr>
                <!--<td colspan="10" class="text-center fs-5 fw-bold">No fixtures available.</td>-->
                <th scope="row">$team_athletics_match_id</th>
                <td>$match_title</td>
                <td>$home_team</td>
                <td>$away_team</td>
                <td>$match_venue</td>
                <td>$match_date <!--Saturday, 5 February 2022--></td>
                <td>$start_time</td>
                <td>$standard_match_duration</td>
                <td>$observed_match_duration</td>
                <td>$match_result</td>
            </tr>
            _END;
        }
    }

    echo $compile_table_rows;

    // $result = null;
    $result = null;
    $dbconn->close();
} catch (\Throwable $th) {
    throw "Exception error: $th";
}
