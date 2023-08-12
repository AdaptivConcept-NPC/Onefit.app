<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['date']) && isset($_GET['grcode'])) {
    // declaring variables
    $paramDayName = $grcode = $activities_bar_content = $inner_activities_bar_content = "";

    try {
        // try to calculate dates
        // '2023','5','24' 2023-05-24
        // $paramDayName = ucfirst(strtolower(sanitizeMySQL($dbconn, $_GET['day'])));
        $paramDate = date_create(sanitizeMySQL($dbconn, $_GET['date']));
        $paramDayName = date_format($paramDate, "l"); //strtolower()
        $dayNum = date_format($paramDate, 'N');;
        $dayDateThisWeek = date_format($paramDate, 'Y/m/d');
    } catch (\Throwable $th) {
        throw "Date compilation exception error: $th";
    }


    $grcode = sanitizeMySQL($dbconn, $_GET['grcode']);
    // $when = sanitizeMySQL($dbconn, $_GET['when']) || 'this'; // this / last / next

    // tws
    $teams_weekly_schedule_id =
        $schedule_title =
        $schedule_rpe =
        $schedule_day =
        $groups_group_ref_code = null;
    // twa
    $teams_activity_id =
        $activity_title =
        $activity_description =
        $activity_icon =
        $teams_weekly_schedules_teams_weekly_schedule_id =
        $exercises_exercise_id = null;

    try {
        if ($grcode == 'all') {
            $grcodeReqStatement = "";
        } else {
            # include the "indiws.groups_group_ref_code = '$grcode' AND " statement after the WHERE clause in our sql query
            $grcodeReqStatement = "tws.groups_group_ref_code = '$grcode' AND";
        }
        //code to compile the teams daily activities in the daily activities chart bars
        $query = "SELECT tws.teams_weekly_schedule_id, tws.schedule_title, tws.schedule_rpe, tws.schedule_day, tws.schedule_date, tws.groups_group_ref_code, 
        twa.teams_activity_id, twa.activity_title, twa.activity_description, twa.activity_icon, twa.teams_weekly_schedules_teams_weekly_schedule_id, twa.exercises_exercise_id 
        FROM teams_weekly_schedules tws 
        INNER JOIN team_weekly_activities twa ON twa.teams_weekly_schedules_teams_weekly_schedule_id = tws.teams_weekly_schedule_id 
        WHERE $grcodeReqStatement tws.schedule_date = '$dayDateThisWeek'";

        // $query = "SELECT DISTINCT(tws.schedule_title), tws.color_code, tws.groups_group_ref_code, twa.* , grps.group_name
        // FROM teams_weekly_schedules tws 
        // LEFT JOIN team_weekly_activities twa ON twa.teams_weekly_schedules_teams_weekly_schedule_id = tws.teams_weekly_schedule_id 
        // LEFT JOIN groups grps ON tws.groups_group_ref_code = grps.group_ref_code
        // WHERE $grcodeReqStatement tws.schedule_date = '$dayDateThisWeek'";

        // echo $query;
        // echo "<br>";

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to save your details. [compile teams daily activities Submit Error_01 - " . $dbconn->error . "]");

        $rows = $result->num_rows;

        if ($rows == 0) {
            //there is no result so notify user that the account cannot be found
            // echo "possible error: No schedule and activities found.";
            $activities_bar_content = <<<_END
            <!-- test: query string -->
            <div class="d-none"> $query </div>
            <p id="bar-title-day$dayNum" class="fw-bold poppins-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;font-size:18px!important;">
                No activities
            </p>
            <div id="teams-weekly-activity-barchart-bar-day$dayNum" class="chart-col-bar p-2 shadow down-top-grad-tahiti d-grid text-center pt-4">
                <span class="material-icons material-icons-round align-middle"> bed </span>
                <p>Rest.</p>
            </div>
            <hr class="text-dark">
            <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="$.loadTeamsActivityCaptureForm('$paramDayName','$grcode')">
                    <span class="material-icons material-icons-round align-middle">
                        add_circle
                    </span>
                </button>
            </div>
            <p class="text-center fs-5 fw-bold poppins-font">$paramDayName</p>
            <p class="text-center fs-5 fw-bold poppins-font">$dayDateThisWeek</p>
            _END;
            echo $activities_bar_content;
        } else {
            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                // tws
                $teams_weekly_schedule_id = $row["teams_weekly_schedule_id"];
                $schedule_title = $row["schedule_title"];
                $schedule_rpe = $row["schedule_rpe"];
                $schedule_day = ucfirst($row["schedule_day"]);
                $schedule_date = date("d/m/Y", strtotime($row["schedule_date"]));
                $groups_group_ref_code = $row["groups_group_ref_code"];

                // twa
                $teams_activity_id = $row["teams_activity_id"];
                $activity_title = $row["activity_title"];
                $activity_description = $row["activity_description"];
                $activity_icon = $row["activity_icon"];
                $teams_weekly_schedules_teams_weekly_schedule_id = $row["teams_weekly_schedules_teams_weekly_schedule_id"];
                $exercises_exercise_id = $row["exercises_exercise_id"];

                // echo "<hr />";

                // echo "teams weekly schedules data: <br/>";
                // echo $teams_weekly_schedule_id . "<br/>";
                // echo $schedule_title . "<br/>";
                // echo $schedule_rpe . "<br/>";
                // echo $schedule_day . "<br/>";
                // echo $groups_group_ref_code . "<br/>";

                // echo "teams weekly activities <br/>";
                // echo $teams_activity_id . "<br/>";
                // echo $activity_title . "<br/>";
                // echo $activity_description . "<br/>";
                // echo $activity_icon . "<br/>";
                // echo $teams_weekly_schedules_teams_weekly_schedule_id . "<br/>";
                // echo $exercises_exercise_id . "<br/>";

                $inner_activities_bar_content .= <<<_END
                <div class="chart-col-bar-item text-center position-relativez">
                    <p>$activity_title</p>
                    <img src="$activity_icon" alt="../media/assets/icons/icon.png" class="img-fluid">
                    <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar$dayNum">
                        <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('$schedule_day','$grcode','$exercises_exercise_id')">
                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                delete
                            </span>
                        </button>
                    </div>
                </div>
                <hr class="text-white my-2 p-0" style="height: 5px;">
                _END;
            }

            $activities_bar_content = <<<_END
            <!-- Edit training day bar - Day $dayNum -->
            <div class="collapse multi-collapse w3-animate-bottom" id="edit-bar-weekly-activity-btn-day$dayNum">
                <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('$schedule_day','$grcode')">
                    <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                        edit
                    </span>
                </button>
            </div>
            <!-- ./ Edit training day bar - Day $dayNum -->
            <p id="bar-title-day$dayNum" class="fw-bold poppins-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;font-size:18px!important;">
                $schedule_title
            </p>
            <p id="bar-rpe-day$dayNum" class="poppins-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                Exercise Intensity (RPE): <br> $schedule_rpe / 10
            </p>
            <div id="teams-weekly-activity-barchart-bar-day$dayNum" class="chart-col-bar p-2 shadow down-top-intensity-bar-bg-grad">
                $inner_activities_bar_content
            </div>
            <hr class="text-dark">
            <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="$.loadTeamsActivityCaptureForm('$schedule_day','$grcode')">
                    <span class="material-icons material-icons-round align-middle">
                        add_circle
                    </span>
                </button>
            </div>
            <p class="text-center fs-5 fw-bold poppins-font">$schedule_day</p>
            <p class="text-center fs-5 fw-bold poppins-font">$schedule_date</p>
            _END;

            echo $activities_bar_content;
        }

        // $result->close();
        $result = null;
        $dbconn->close();

        // echo "success: About You data saved successfully.";
    } catch (\Throwable $th) {
        //throw $th;
        echo "error: " . $th->getMessage;
    }
} else {
    echo "Get params not set.";
}

// get teams weekly activity bar chart