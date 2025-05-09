<?php
session_start();
require("../../../config.php");
require_once("../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['date']) && isset($_GET['grcode'])) {
    // declaring variables
    $paramDayName = $grcode = $activities_card_content = $inner_activities_card_content = "";

    // execute query
    $paramDate = date_create(sanitizeMySQL($dbconn, $_GET['date']));
    $paramDayName = date_format($paramDate, "l"); //strtolower()
    $dayNum = date_format($paramDate, 'N');
    $dayDateThisWeek = date_format($paramDate, 'd/m/Y');

    $grcode = sanitizeMySQL($dbconn, $_GET['grcode']);
    // $when = sanitizeMySQL($dbconn, $_GET['when']) || 'this'; // this / last / next

    // teams variables
    // tws
    $teams_weekly_schedule_id =
        $schedule_title =
        $schedule_rpe =
        $schedule_day =
        $schedule_date =
        $groups_group_ref_code = null;
    // twa
    $teams_activity_id =
        $activity_title =
        $activity_description =
        $activity_icon =
        $teams_weekly_schedules_teams_weekly_schedule_id =
        $exercises_exercise_id = null;

    // indi variales
    $indi_weekly_schedule_id = $indi_activity_id =
        $indi_weekly_schedules_indi_weekly_schedule_id = null;

    // inner card content variables
    $inner_activities_hscroll_card_content_indi = $inner_activities_hscroll_card_content_teams = "";

    $wtypes = array('indi', 'teams');

    $grcodeReqStatement = "";

    foreach ($wtypes as $type) {
        # choose sql script to execute based on the current array item
        if ($type == "indi") {
            if ($grcode != 'all') {
                # include the "indiws.groups_group_ref_code = '$grcode' AND " statement after the WHERE clause in our sql query
                $grcodeReqStatement = "indiws.groups_group_ref_code = '$grcode' AND";
            }
            // sql code to compile the indi daily activities in the daily activities chart bars
            $query = "SELECT indiws.indi_weekly_schedule_id, indiws.schedule_title, indiws.schedule_rpe, indiws.schedule_day, indiws.schedule_date, indiws.groups_group_ref_code, 
            indiwa.indi_activity_id, indiwa.activity_title, indiwa.activity_description, indiwa.activity_icon, indiwa.indi_weekly_schedules_indi_weekly_schedule_id, indiwa.exercises_exercise_id 
            FROM indi_weekly_schedules indiws 
            INNER JOIN indi_weekly_activities indiwa ON indiwa.indi_weekly_schedules_indi_weekly_schedule_id = indiws.indi_weekly_schedule_id 
            WHERE $grcodeReqStatement indiws.schedule_day = '$paramDayName' AND indiws.schedule_date = '$dayDateThisWeek'";
        } elseif ($type == "teams") {
            if ($grcode != 'all') {
                # include the "teamsws.groups_group_ref_code = '$grcode' AND " statement after the WHERE clause in our sql query
                $grcodeReqStatement = "teamsws.groups_group_ref_code = '$grcode' AND";
            }
            // sql code to compile the teams daily activities in the daily activities chart bars
            $query = "SELECT teamsws.teams_weekly_schedule_id, teamsws.schedule_title, teamsws.schedule_rpe, teamsws.schedule_day, teamsws.schedule_date, teamsws.groups_group_ref_code, 
            teamswa.teams_activity_id, teamswa.activity_title, teamswa.activity_description, teamswa.activity_icon, teamswa.teams_weekly_schedules_teams_weekly_schedule_id, teamswa.exercises_exercise_id 
            FROM teams_weekly_schedules teamsws 
            INNER JOIN team_weekly_activities teamswa ON teamswa.teams_weekly_schedules_teams_weekly_schedule_id = teamsws.teams_weekly_schedule_id 
            WHERE $grcodeReqStatement teamsws.schedule_day = '$paramDayName' AND teamsws.schedule_date = '$dayDateThisWeek'";
        } else {
            die("error: Invalid request.");
        }

        try {
            // try to execute the request
            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [compile teams daily activities Submit Error_01 - " . $dbconn->error . "]");

            $rows = $result->num_rows;

            if ($rows == 0) {
                //there is no result so notify user that the account cannot be found
                if ($type == "indi") {
                    // if request is for indi then populate the indi related variable
                    $inner_activities_hscroll_card_content_indi = <<<_END
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                        <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: var(--secondary-color) !important; border-radius: 25px">
                            <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                            <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                            <span class="material-icons material-icons-round">self_improvement</span>
                        </span>
                        <div class="ms-2 me-auto">
                            <p class="fw-bold text-center text-muted" style="color: var(--primary-color)">No activities lined up.</p>
                        </div>
                    </li>
                    _END;
                } elseif ($type == "teams") {
                    // if request is for teams then populate the teams related variable
                    $inner_activities_hscroll_card_content_teams = <<<_END
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                        <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: var(--secondary-color) !important; border-radius: 25px">
                            <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                            <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                            <span class="material-icons material-icons-round">self_improvement</span>
                        </span>
                        <div class="ms-2 me-auto">
                            <p class="fw-bold text-center text-muted" style="color: var(--primary-color)">No activities lined up.</p>
                        </div>
                    </li>
                    _END;
                } else {
                    die("error: [01] Invalid request.");
                }
            } else {

                for ($j = 0; $j < $rows; ++$j) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    if ($type == "indi") {
                        // indiws
                        $indi_weekly_schedule_id = $row["indi_weekly_schedule_id"];
                        $schedule_title = $row["schedule_title"];
                        $schedule_rpe = $row["schedule_rpe"];
                        $schedule_day = ucfirst($row["schedule_day"]);
                        $schedule_date = date("d/m/Y", strtotime($row["schedule_date"]));
                        $groups_group_ref_code = $row["groups_group_ref_code"];

                        // indiwa
                        $indi_activity_id = $row["indi_activity_id"];
                        $activity_title = $row["activity_title"];
                        $activity_description = $row["activity_description"];
                        $activity_icon = $row["activity_icon"];
                        $indi_weekly_schedules_indi_weekly_schedule_id = $row["indi_weekly_schedules_indi_weekly_schedule_id"];
                        $exercises_exercise_id = $row["exercises_exercise_id"];

                        $inner_activities_hscroll_card_content_indi .= <<<_END
                        <li class="list-group-item d-grid justify-content-betweenz align-items-center bg-transparent text-white" style="border-color: #fff !important;border-radius: 25px;">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: var(--secondary-color) !important; border-radius: 25px">
                                    <img src="$activity_icon" src="$schedule_title - $activity_title" class="img-fluidz" style="width: 48px;">
                                </span>
                                <div class="d-grid gap-2 text-start px-4 pb-2">
                                    <p class="fw-bold fs-4" style="color: var(--primary-color)"> $schedule_title </p>
                                    <p class="fw-bold fs-5" style="color: var(--primary-color)"> $activity_title </p>
                                    <p class="fw-bold"> $activity_description </p>
                                </div>
                                <div class="d-grid justify-content-end">
                                    <button id="remove-cart-item-itemid" class="onefit-buttons-style-light p-2 text-center" type="button" onclick="openLink('start_workout_wrkoutid[$exercises_exercise_id]', 'GoPageWorkout')">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                            visibility
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </li>   
                        _END;
                    } elseif ($type == "teams") {
                        // teamsws
                        $teams_weekly_schedule_id = $row["teams_weekly_schedule_id"];
                        $schedule_title = $row["schedule_title"];
                        $schedule_rpe = $row["schedule_rpe"];
                        $schedule_day = ucfirst($row["schedule_day"]);
                        $schedule_date = date("d/m/Y", strtotime($row["schedule_date"]));
                        $groups_group_ref_code = $row["groups_group_ref_code"];

                        // teamswa
                        $teams_activity_id = $row["teams_activity_id"];
                        $activity_title = $row["activity_title"];
                        $activity_description = $row["activity_description"];
                        $activity_icon = $row["activity_icon"];
                        $teams_weekly_schedules_teams_weekly_schedule_id = $row["teams_weekly_schedules_teams_weekly_schedule_id"];
                        $exercises_exercise_id = $row["exercises_exercise_id"];

                        $inner_activities_hscroll_card_content_teams .= <<<_END
                        <li class="list-group-item d-grid justify-content-betweenz align-items-center bg-transparent text-white" style="border-color: #fff !important;border-radius: 25px;">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: var(--secondary-color) !important; border-radius: 25px">
                                    <img src="$activity_icon" src="$schedule_title - $activity_title" class="img-fluidz" style="width: 48px;">
                                </span>
                                <div class="d-grid gap-2 text-start px-4 pb-2">
                                    <p class="fw-bold fs-4" style="color: var(--primary-color)"> $schedule_title </p>
                                    <p class="fw-bold fs-5" style="color: var(--primary-color)"> $activity_title </p>
                                    <p class="fw-bold"> $activity_description </p>
                                </div>
                                <div class="d-grid justify-content-end">
                                    <button id="remove-cart-item-itemid" class="onefit-buttons-style-light p-2 text-center" type="button" onclick="openLink('start_workout_wrkoutid[$exercises_exercise_id]', 'GoPageWorkout')">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important">
                                            visibility
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </li>     
                        _END;
                    } else {
                        die("error: [02] Invalid request.");
                    }
                }
            }

            // echo "success";
        } catch (\Throwable $th) {
            //throw $th;
            die("error: [except 03]" . $th->getMessage);
        }
    }

    // $result->close();
    $result = null;
    $dbconn->close();

    $weekdayCardOutput = <<<_END
    <h3 class="mt-0 mb-2 poppins-font fs-3">$paramDayName.</h3>
    <p class="mb-4 text-mutedz poppins-font" style="color: var(--primary-color);">$dayDateThisWeek</p>
    <hr class="text-white" style="height: 5px;">
    <!-- assessments list -->
    <ol class="list-group list-group-flush border-0 my-4">
        <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important;border-radius: 15px;">
            <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: var(--secondary-color) !important; border-radius: 25px">
                <i class="fab fa-google" style="font-size: 48px!important"></i>
            </span>
            <div class="ms-2 me-auto text-start">
                <div class="fw-bold" style="color: var(--primary-color)">Daily Load Monitoring Survey</div>
                <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">recycling</span> Frequency: Daily<br />
                <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">assignment_late</span> Required: Optional
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important;border-radius: 15px;">
            <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: var(--secondary-color) !important; border-radius: 25px">
                <i class="fab fa-google" style="font-size: 48px!important"></i>
            </span>
            <div class="ms-2 me-auto text-start">
                <div class="fw-bold" style="color: var(--primary-color)">Wellness Tracking Survey</div>
                <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">recycling</span> Frequency: Daily<br />
                <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">assignment_late</span> Required: Optional
            </div>
        </li>
    </ol>
    <!-- ./ assessments list -->
    <div class="d-none">
        <hr class="text-white" style="height: 5px;">
        <h5 class="">Indi-fitness activities</h5>
        <!-- indi-athletics activities list -->
        <ol class="list-group list-group-flush border-0 my-4">
            $inner_activities_hscroll_card_content_indi
        </ol>
        <!-- ./ indi-athletics activities list -->
        <hr class="text-white" style="height: 5px;">
        <h5 class="">Group activities (Teams)</h5>
        <!-- team-athletics / group activities list -->
        <ol class="list-group list-group-flush border-0 my-4">
            $inner_activities_hscroll_card_content_teams
        </ol>
        <!-- ./ team-athletics / group activities list -->
        <span class="material-icons material-icons-round mb-4">horizontal_rule</span>
    </div>
    _END;

    echo $weekdayCardOutput;
} else {
    die("No request parameters were provided.");
}

// phpunit unit testing
// require_once("../../../tests/unit_tests/phpunit.php");