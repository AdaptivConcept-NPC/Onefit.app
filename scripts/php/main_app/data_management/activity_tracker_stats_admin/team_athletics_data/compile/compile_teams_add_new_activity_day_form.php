<?php
session_start();
require("../../../../../config.php");
require("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['day']) && isset($_GET['gref'])) {
    // declaring variables
    $getDay = $getGrpRef = $workout_activities_list = "";

    // execute query
    $getDay = sanitizeMySQL($dbconn, $_GET['day']);
    $getGrpRef = sanitizeMySQL($dbconn, $_GET['gref']);

    if (isset($_GET['when'])) $when = sanitizeMySQL($dbconn, $_GET['when']); // this / last / next
    else  $when = 'this';

    $dayNum = date("N", strtotime("$getDay $when week"));

    $dayDateThisWeek = date('Y-m-d', strtotime("$getDay $when week"));

    echo "dayDateThisWeek: $dayDateThisWeek <br/>";

    if ($getGrpRef == "editbar") {
        # compile a form for editing the title and rpe and bars overall

    } else {
        # compile a form for eding new activities/exercises to the bar

        // try to compile the modal body html
        try {
            // declare variables
            // tws vars
            $teams_weekly_schedule_id = $schedule_title = $schedule_rpe = $schedule_day = $schedule_date = $groups_group_ref_code = null;
            // twa vars
            $teams_activity_id = $activity_title = $activity_description = $activity_icon = $teams_weekly_schedules_teams_weekly_schedule_id = $exercises_exercise_id = null;
            // compilation & output vars
            $activities_bar_content = $inner_activities_bar_content = $currentActivityItem =  $workout_activities_list = $formHTML = null;

            //code to compile the teams daily activities in the daily activities chart bars
            $query = "SELECT tws.teams_weekly_schedule_id, tws.schedule_title, tws.schedule_rpe, tws.schedule_day, tws.schedule_date, tws.groups_group_ref_code, 
            twa.teams_activity_id, twa.activity_title, twa.activity_description, twa.activity_icon, twa.teams_weekly_schedules_teams_weekly_schedule_id, twa.exercises_exercise_id 
            FROM teams_weekly_schedules tws 
            INNER JOIN team_weekly_activities twa ON twa.teams_weekly_schedules_teams_weekly_schedule_id = tws.teams_weekly_schedule_id 
            WHERE tws.groups_group_ref_code = '$getGrpRef' AND tws.schedule_day = '$getDay' AND tws.schedule_date = '$dayDateThisWeek'";

            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [compile teams daily activities Submit Error_01 - " . $dbconn->error . "]");

            $rows = $result->num_rows;

            if ($rows == 0) {
                //there is no result
                echo <<<_END
                <p class="text-center my-4 p-4" style="border-radius:25px;color:var(--mineshaft)">No activities found. Add new activities.</p>
                _END;

                // tws
                $teams_weekly_schedule_id = 0;
                $schedule_title = "Capture Title";
                $schedule_rpe = 0;
                $schedule_day = $getDay; //ucfirst($row["schedule_day"]);
                $schedule_date = date("d/m/Y", strtotime("$getDay this week"));
                $groups_group_ref_code = "no_refcode";
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

                    $inner_activities_bar_content .= <<<_END
                    <div class="chart-col-bar-item text-center position-relative">
                        <p>$activity_title</p>
                        <img src="$activity_icon" alt="../media/assets/icons/icon.png" class="img-fluid">
                        <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn-bar$dayNum">
                            <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('$schedule_day','$getGrpRef','$exercises_exercise_id')">
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
                    <button class="onefit-buttons-style-dark rounded-circle p-4 my-2" onclick="toggleEditDayBar('$schedule_day','$getGrpRef')">
                        <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                            edit
                        </span>
                    </button>
                </div>
                <!-- ./ Edit training day bar - Day $dayNum -->
                <!--<p id="bar-title-day$dayNum" class="fs-3 fw-bold comfortaa-font">
                    $schedule_title
                </p>
                <p id="bar-rpe-day$dayNum" class="comfortaa-font">
                    RPE $schedule_rpe
                </p>-->
                <div id="teams-weekly-activity-barchart-bar-day$dayNum" class="chart-col-bar p-2 shadow down-top-intensity-bar-bg-grad">
                    $inner_activities_bar_content
                </div>
                <hr class="text-dark">
                <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                    <button class="onefit-buttons-style-tahiti rounded-5 p-2 my-2" onclick="$.loadTeamsActivityCaptureForm('$schedule_day','$getGrpRef')">
                        <span class="material-icons material-icons-round align-middle">
                            add_circle
                        </span>
                    </button>
                </div>
                _END;

                // echo $activities_bar_content;
            }

            //get existing/current activities 
            $currentActivityItems =  $activities_bar_content;

            // call to compile exercise list
            $workout_activities_list = compileSelectInputExerciseList();

            $formHTML = <<<_END
            <p id="form-bar-title-day$dayNum" class="fw-bold fs-3 fw-bold text-dark comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                $schedule_title
            </p>
            <p id="form-bar-rpe-day$dayNum" class="fw-bold text-dark comfortaa-font top-down-grad-white p-4" style="border-radius: 25px 25px 0 0;">
                RPE $schedule_rpe
            </p>
            <div id="form-indi-weekly-activity-barchart-bar-day$dayNum" class="chart-col-bar p-2 shadow progress-bar mb-4">
                $currentActivityItems
            </div>
            <hr class="text-white my-2 p-0" style="height: 5px;">
            <p class="text-center fs-5 fw-bold comfortaa-font">$schedule_day</p>
            <p class="text-center fs-5 fw-bold comfortaa-font">$schedule_date</p>
            _END;

            echo $formHTML;
        } catch (\Throwable $th) {
            //throw $th;
            echo "exception error: [indi edit-add new activity] " . $th->getMessage;
        }

        $result = null;
        $dbconn->close();
    }
} else {
    die("Error: No day or grcode provided");
}

// function compileSelectInputExerciseList()
// {
//     global $dbconn;
//     $exercise_id = $xp_points = 0;
//     $exercise_name = $workout_name = "";
//     $compile_workout_activities_list = "";

//     // $sql = "SELECT ex.exercise_id, ex.exercise_name, ex.xp_points, wk.workout_name, wk.workout_category FROM exercises ex
//     // INNER JOIN workout_training wt ON wt.exercises_exercise_id = ex.exercise_id
//     // INNER JOIN workouts wk ON w.workout_id = wt.workouts_workout_id
//     // ORDER BY ex.exercise_name ASC";

//     $sql = "SELECT `exercise_id`, `exercise_name`, `xp_points` FROM `exercises` ORDER BY `exercise_name` ASC";

//     if ($result = mysqli_query($dbconn, $sql)) {
//         while ($row = mysqli_fetch_assoc($result)) {
//             $exercise_id = $row["exercise_id"];
//             $exercise_name = $row["exercise_name"];
//             $xp_points = $row["xp_points"];

//             // echo <<<_END
//             // <div class="alert alert-success p-3">upid: $exercise_id | exercise name: $exercise_name | xp: $xp_points</div>
//             // _END;

//             $compile_workout_activities_list .= <<<_END
//             <option value="$exercise_id"> $exercise_name ($xp_points<sub style="color: #ffa500;">xp</sub>)</option>
//             _END;
//         }
//     } else {
//         // echo <<<_END
//         //     <div class="alert alert-danger p-3">No exercise items found.</div>
//         //     _END;
//         $compile_workout_activities_list = '<option value="error">No exercise items found.</option>';
//     }

//     return $compile_workout_activities_list;
// }
