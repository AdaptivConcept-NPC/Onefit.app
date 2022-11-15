<?php
session_start();
require("../../../config.php");
require("../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// global variables
if (!isset($_SESSION['currentUserUsername'])) die("Fatal Error");
else $current_user_username = $_SESSION['currentUserUsername'];
$current_user_indi_subbed_grouprefcode = null;
$current_user_teams_subbed_grouprefcode = null;
$current_user_premium_subbed_grouprefcode = null;

$dateToday = date("Y-m-d");
$dateDayNumber = date("N", strtotime($dateToday));

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

// community_group_member
// `group_mem_id`, `group_role`, `group_join_date`, `active`, `status`, `users_username`, `groups_group_ref_code`

// inner card content variables
$inner_activities_hscroll_card_content_indi =
    $inner_activities_hscroll_card_content_teams =
    $inner_activities_schedule_title_indi =
    $inner_activities_schedule_title_teams =
    $output = null;

$wtypes = array();
$new_array_count = null;

// get the current users group reference codes (groups they are subbed to)
try {
    // check if the user is part of any indi/community groups. If he/she is then add the indi type item to the $wtype array
    $query = "SELECT `groups_group_ref_code` FROM `community_group_members` WHERE `users_username` = '$current_user_username' AND `active` = 1";
    $result = $dbconn->query($query);
    if (!$result) die("An error occurred while trying to process this request.");

    $rows = $result->num_rows;
    if ($rows > 0) {
        // push indi type to array. 
        $new_array_count = array_push($wtypes, 'indi');

        // get the groups_group_ref_code value and save it to global variable
        $current_user_indi_subbed_grouprefcode = $row["groups_group_ref_code"];
    }

    // clear the resultset
    $result = null;

    // check if the user is part of any teams groups. If he/she is then add the teams type item to the $wtype array
    $query = "SELECT `groups_group_ref_code` FROM `teams_group_members` WHERE `users_username` = '$current_user_username' AND `active` = 1";
    $result = $dbconn->query($query);
    if (!$result) die("An error occurred while trying to process this request.");

    $rows = $result->num_rows;
    if ($rows > 0) {
        // push indi type to array. 
        $new_array_count = array_push($wtypes, 'teams');

        // get the groups_group_ref_code value and save it to global variable
        $current_user_teams_subbed_grouprefcode = $row["groups_group_ref_code"];
    }

    // clear the resultset
    $result = null;

    // check if the user is part of any premium groups. If he/she is then add the premium type item to the $wtype array
    $query = "SELECT `groups_group_ref_code` FROM `teams_group_members` WHERE `users_username` = '$current_user_username' AND `active` = 1";
    $result = $dbconn->query($query);
    if (!$result) die("An error occurred while trying to process this request.");

    $rows = $result->num_rows;
    if ($rows > 0) {
        // push indi type to array. 
        $new_array_count = array_push($wtypes, 'premium');

        // get the groups_group_ref_code value and save it to global variable
        $current_user_premium_subbed_grouprefcode = $row["groups_group_ref_code"];
    }
} catch (\Throwable $th) {
    // throw $th;
    die("error: [except 03]" . $th->getMessage);
}

if (is_null($new_array_count)) die("user is not subscribed to any groups. unable to proceed.");

// compile the daily activities from indi (community), teams and premium
// $wtypes = array('indi', 'teams'); //, 'premium'
foreach ($wtypes as $type) {
    # choose sql script to execute based on the current array item
    if ($type == "indi") {
        // sql code to compile the indi daily activities in the daily activities chart bars
        $query = "SELECT indiws.indi_weekly_schedule_id, indiws.schedule_title, indiws.schedule_rpe, indiws.schedule_day, indiws.schedule_date, indiws.groups_group_ref_code, 
            indiwa.indi_activity_id, indiwa.activity_title, indiwa.activity_description, indiwa.activity_icon, indiwa.indi_weekly_schedules_indi_weekly_schedule_id, indiwa.exercises_exercise_id 
            FROM indi_weekly_schedules indiws 
            INNER JOIN indi_weekly_activities indiwa ON indiwa.indi_weekly_schedules_indi_weekly_schedule_id = indiws.indi_weekly_schedule_id 
            WHERE indiws.groups_group_ref_code = '$current_user_indi_subbed_grouprefcode' AND indiws.schedule_date = '$dateToday'";
    } elseif ($type == "teams") {
        // sql code to compile the teams daily activities in the daily activities chart bars
        $query = "SELECT teamsws.teams_weekly_schedule_id, teamsws.schedule_title, teamsws.schedule_rpe, teamsws.schedule_day, teamsws.schedule_date, teamsws.groups_group_ref_code, 
            teamswa.teams_activity_id, teamswa.activity_title, teamswa.activity_description, teamswa.activity_icon, teamswa.teams_weekly_schedules_teams_weekly_schedule_id, teamswa.exercises_exercise_id 
            FROM teams_weekly_schedules teamsws 
            INNER JOIN team_weekly_activities teamswa ON teamswa.teams_weekly_schedules_teams_weekly_schedule_id = teamsws.teams_weekly_schedule_id 
            WHERE teamsws.groups_group_ref_code = '$current_user_teams_subbed_grouprefcode' AND teamsws.schedule_date = '$dateToday'";
    } elseif ($type == "premium") {
        // sql code to compile the teams daily activities in the daily activities chart bars
        $query = "SELECT teamsws.teams_weekly_schedule_id, teamsws.schedule_title, teamsws.schedule_rpe, teamsws.schedule_day, teamsws.schedule_date, teamsws.groups_group_ref_code, 
            teamswa.teams_activity_id, teamswa.activity_title, teamswa.activity_description, teamswa.activity_icon, teamswa.teams_weekly_schedules_teams_weekly_schedule_id, teamswa.exercises_exercise_id 
            FROM teams_weekly_schedules teamsws 
            INNER JOIN team_weekly_activities teamswa ON teamswa.teams_weekly_schedules_teams_weekly_schedule_id = teamsws.teams_weekly_schedule_id 
            WHERE teamsws.groups_group_ref_code = '$current_user_premium_subbed_grouprefcode' AND teamsws.schedule_date = '$dateToday'";
    } else {
        die("error: invalid request.");
    }

    try {
        // try to execute the request
        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to process this request. [wtype error: $type - " . $dbconn->error . "]");

        $rows = $result->num_rows;

        if ($rows == 0) {
            //there is no result so notify user that the account cannot be found
            if ($type == "indi") {
                // if request is for indi then populate the indi related variable
                $inner_activities_hscroll_card_content_indi = <<<_END
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                        <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                            <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                            <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                            <span class="material-icons material-icons-round">self_improvement</span>
                        </span>
                        <div class="ms-2 me-auto">
                            <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                        </div>
                    </li>
                    _END;
            } elseif ($type == "teams") {
                // if request is for teams then populate the teams related variable
                $inner_activities_hscroll_card_content_teams = <<<_END
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-white" style="border-color: #fff !important">
                        <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                            <!-- <i class="fab fa-google" style="font-size: 30px!important"></i> -->
                            <!-- <i class="fas fa-solid fa-face-relieved" style="font-size: 30px!important"></i> -->
                            <span class="material-icons material-icons-round">self_improvement</span>
                        </span>
                        <div class="ms-2 me-auto">
                            <p class="fw-bold text-center text-muted" style="color: #ffa500">No activities lined up.</p>
                        </div>
                    </li>
                    _END;
            } else {
                die("error: invalid request.");
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

                    $inner_activities_schedule_title_indi = <<<_END
                    <div class="down-top-grad-tahiti py-4 mb-4" style="border-radius: 0 0 25px 25px;">
                        <p class="fs-5 fw-bold">
                            $schedule_title
                        </p>
                        <p style="color: #343434;">
                            RPE $schedule_rpe
                        </p>
                    </div>
                    _END;

                    $inner_activities_hscroll_card_content_indi .= <<<_END
                        <li class="list-group-item d-grid justify-content-betweenz align-items-center bg-transparent text-white" style="border-color: #fff !important;border-radius: 25px;">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                    <img src="$activity_icon" src="$schedule_title - $activity_title" class="img-fluidz" style="width: 48px;">
                                </span>
                                <div class="d-grid gap-2 text-start px-4 pb-2">
                                    <p class="fw-bold fs-4" style="color: #ffa500"> $schedule_title </p>
                                    <p class="fw-bold fs-5" style="color: #ffa500"> $activity_title </p>
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

                    $inner_activities_schedule_title_teams = <<<_END
                    <div class="down-top-grad-tahiti py-4 mb-4" style="border-radius: 0 0 25px 25px;">
                        <p class="fs-5 fw-bold">
                            $schedule_title
                        </p>
                        <p style="color: #343434;">
                            RPE $schedule_rpe
                        </p>
                    </div>
                    _END;

                    $inner_activities_hscroll_card_content_teams .= <<<_END
                    <li class="list-group-item d-grid justify-content-betweenz align-items-center bg-transparent text-white" style="border-color: #fff !important;border-radius: 25px;">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                                <img src="$activity_icon" src="$schedule_title - $activity_title" class="img-fluidz" style="width: 48px;">
                            </span>
                            <div class="d-grid gap-2 text-start px-4 pb-2">
                                <p class="fw-bold fs-4" style="color: #ffa500"> $schedule_title </p>
                                <p class="fw-bold fs-5" style="color: #ffa500"> $activity_title </p>
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

                    // compile for the vertical bar on the dashboard as well.
                    // $inner_activities_v_card_content_teams .= <<<_END
                    // <div class="chart-col-bar-item text-center position-relative">
                    //     <p>$activity_title</p>
                    //     <img src="$activity_icon" alt="$schedule_title - $activity_title" class="img-fluid">
                    // </div>
                    // <hr class="text-white my-2 p-0" style="height: 5px;">
                    // _END;
                } else {
                    die("error: invalid request.");
                }
            }
        }
    } catch (\Throwable $th) {
        //throw $th;
        die("error: exception error has occured: " . $th->getMessage);
    }
}

$result->close();
$dbconn->close();

$output = <<<_END
<div class="d-flex align-items-center text-center justify-content-center" id="no-activities-banner-container" style="min-height: 100px;">
<p class="my-4 fs-5 fw-bold comfortaa-font" style="cursor: pointer;" onclick="openLink(event, 'TabStudio')">No activities lined up. Go to the <span style="color: #ffa500;">.Studio</span> to get active.</p>
</div>

<div class="row align-items-start text-white" id="tabdahsboard-training-schedule-chart-grid">
    <div class="col-md-8">
        <div class="horizontal-scroll-card w-100 p-4 shadow">
            <h3 class="text-center">Your Assessments for the day</h3>
            <hr class="text-white" style="height: 5px;">
            <h5 class="my-4 text-muted">$dateToday</h5>
            <hr class="text-white" style="height: 5px;">
            <h5 class="">Assessments</h5>
            <!-- assessments list -->
            <ol class="list-group list-group-flush border-0 my-4">
                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important;border-radius: 15px;">
                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                        <i class="fab fa-google" style="font-size: 48px!important"></i>
                    </span>
                    <div class="ms-2 me-auto text-start">
                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">recycling</span> Frequency: Daily<br />
                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">assignment_late</span> Required: Optional
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important;border-radius: 15px;">
                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #fff !important; color: #343434 !important; border-radius: 25px">
                        <i class="fab fa-google" style="font-size: 48px!important"></i>
                    </span>
                    <div class="ms-2 me-auto text-start">
                        <div class="fw-bold" style="color: #ffa500">Wellness Tracking Survey</div>
                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">recycling</span> Frequency: Daily<br />
                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">assignment_late</span> Required: Optional
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important;border-radius: 15px;">
                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                        <span class="material-icons material-icons-round" style="font-size: 48px !important">
                            pending_actions </span>
                    </span>
                    <div class="ms-2 me-auto text-start">
                        <div class="fw-bold" style="color: #ffa500">Daily Load Monitoring Survey</div>
                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">recycling</span> Frequency: Daily<br />
                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">assignment_late</span> Required: Optional
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent text-white" style="border-color: #fff !important;border-radius: 15px;">
                    <span class="badge bg-primary rounded-pillz p-4" style="background-color: #ffa500 !important; color: #343434 !important; border-radius: 25px">
                        <span class="material-icons material-icons-round" style="font-size: 48px !important">
                            pending_actions </span>
                    </span>
                    <div class="ms-2 me-auto text-start">
                        <div class="fw-bold" style="color: #ffa500">Athlete Wellness Survey</div>
                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">recycling</span> Frequency: Daily<br />
                        <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important">assignment_late</span> Required: Optional
                    </div>
                </li>
            </ol>
            <!-- ./ assessments list -->
            <span class="material-icons material-icons-round mb-4">horizontal_rule</span>
        </div>
    </div>
    <div class="col-md-4 text-white text-center" id="home-day-1-col">
        <div class="chart-col-bar p-2 shadow comfortaa-font">
            <h5>Today's Workout Activities</h5>
            <hr class="text-white" style="height: 5px;">
            $inner_activities_schedule_title_indi
            <hr class="text-white" style="height: 5px;">
            <h5 class="">Indi-fitness activities</h5>
            <!-- indi-athletics activities list -->
            <ol class="list-group list-group-flush border-0 my-4">
                $inner_activities_hscroll_card_content_indi
            </ol>
            <!-- ./ indi-athletics activities list -->
            $inner_activities_schedule_title_teams
            <hr class="text-white" style="height: 5px;">
            <h5 class="">Group activities (Teams)</h5>
            <!-- team-athletics / group activities list -->
            <ol class="list-group list-group-flush border-0 my-4">
                $inner_activities_hscroll_card_content_teams
            </ol>
            <!-- ./ team-athletics / group activities list -->
            <span class="material-icons material-icons-round mb-4">horizontal_rule</span>
            <p class="text-center fs-5 fw-bold">Sunday, $dateToday</p>
        </div>
    </div>
</div>
_END;

echo $output;
