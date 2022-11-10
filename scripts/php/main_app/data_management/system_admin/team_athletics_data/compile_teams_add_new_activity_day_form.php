<?php
session_start();
require("../../../../config.php");
require_once("../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['day']) && isset($_GET['gref'])) {
    // declaring variables
    $getDay = $getGrpRef = $workout_activities_list = "";

    // execute query
    $getDay = sanitizeMySQL($dbconn, $_GET['day']);
    $getGrpRef = sanitizeMySQL($dbconn, $_GET['gref']);

    $dayNum = date("N", strtotime("$getDay this week"));

    $dayDateThisWeek = date('Y-m-d', strtotime("$getDay this week"));

    if ($getGrpRef == "editbar") {
        # compile a form for editing the title and rpe and bars overall

    } else {
        # compile a form for eding new activities/exercises to the bar

        // try to compile the modal body html
        try {
            //get existing/current activities 
            $currentActivityItems = <<<_END
            <div class="chart-col-bar-item text-center position-relative">
                <p>Cycling / Spinning</p>
                <img src="../media/assets/icons/cycling.png" alt="" class="img-fluid">
                <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                    <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('$getDay','$getGrpRef')">
                        <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                            delete
                        </span>
                    </button>
                </div>
            </div>
            <hr class="text-white my-2 p-0" style="height: 5px;">
            <div class="chart-col-bar-item text-center">
                <p>Strength & Core</p>
                <img src="../media/assets/icons/bodybuilder.png" alt="" class="img-fluid">
                <div class="collapse multi-collapse w3-animate-bottom" id="remove-weekly-activity-btn">
                    <button class="onefit-buttons-style-danger rounded-circle p-4 my-2" onclick="removeWeeklyTrainingActivity('$getDay','$getGrpRef')">
                        <span class="material-icons material-icons-round" style="font-size: 20px !important;">
                            delete
                        </span>
                    </button>
                </div>
            </div>
            _END;

            // call to compile exercise list
            $workout_activities_list = compileSelectInputExerciseList();

            $formHTML = <<<_END
            <div class="row px-4 align-items-end">
                <div class="col-md-4 p-4 text-center">
                    <p id="bar-title-day$dayNum" class="fs-3 fw-bold">
                        Regeneration
                    </p>
                    <p>
                        RPE 1-3
                    </p>
                    <div id="indi-weekly-activity-barchart-bar-day$dayNum" class="chart-col-bar p-2 shadow progress-bar progress-bar-stripedz bg-warningz">
                        $currentActivityItems
                        <hr class="text-white my-2 p-0" style="height: 5px;">
                    </div>
                    <hr class="text-dark">
                    <div class="collapse multi-collapse w3-animate-top" id="add-weekly-activity-btn">
                        <button class="onefit-buttons-style-tahiti rounded-circle p-2 my-2" onclick="editAddNewActivityModal('$getDay','$getGrpRef')">
                            <span class="material-icons material-icons-round">
                                add_circle
                            </span>
                        </button>
                    </div>
                    <p class="text-center fs-5 fw-bold">$getDay</p>
                    <p class="text-center fs-5 fw-bold">$dayDateThisWeek</p>
                </div>
                <div class="col-md-8">
                    <form id="teams-add-new-day-activity-data-form" class="text-center p-4 comfortaa-font fs-5 shadow" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/data_management/system_admin/team_athletics_data/submit/teams_add_new_activity_day_form_submit.php" autocomplete="off">
                        <div class="form-group my-4">
                            <label for="activity-title" class="comfortaa-font fs-5" style="color: #ffa500;">Activity title:</label>
                            <input class="form-control-text-input p-4" type="number" name="activity-title" id="activity-title" placeholder="Activity Title (Required)" required />
                        </div>
                        <div class="form-group my-4">
                            <label for="rpe" class="comfortaa-font fs-5" style="color: #ffa500;">RPE:</label>
                            <input class="form-control-text-input p-4" type="number" name="rpe" id="rpe" placeholder="RPE (Required)" required />
                        </div>
                        <div class="form-group my-4">
                            <h5>Assign an icon:</h5>
                            <div class="input-group gap-2 chart-col-bar-item" style="transform: scale(1,1) !important;">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-cycling" value="../media/assets/icons/cycling.png">
                                    <label class="form-check-label" for="activity-icon-cycling">
                                        <img src="../media/assets/icons/cycling.png" alt="cycling/spinning" style="height: 50px; width: auto"> Cycling / Spinning 
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-strength" value="../media/assets/icons/bodybuilder.png">
                                    <label class="form-check-label" for="activity-icon-strength">
                                        <img src="../media/assets/icons/bodybuilder.png" alt="strength" style="height: 50px; width: auto"> Strength 
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-icebath" value="../media/assets/icons/bath-tub.png">
                                    <label class="form-check-label" for="activity-icon-icebath">
                                        <img src="../media/assets/icons/bath-tub.png" alt="ice bath" style="height: 50px; width: auto"> Ice bath 
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-running" value="../media/assets/icons/running.png">
                                    <label class="form-check-label" for="activity-icon-running">
                                        <img src="../media/assets/icons/running.png" alt="running" style="height: 50px; width: auto"> Running 
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-tactics" value="../media/assets/icons/thinking.png">
                                    <label class="form-check-label" for="activity-icon-tactics">
                                        <img src="../media/assets/icons/thinking.png" alt="tactics" style="height: 50px; width: auto"> Tactics 
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-kickoff" value="../media/assets/icons/soccer-ball.png">
                                    <label class="form-check-label" for="activity-icon-kickoff">
                                        <img src="../media/assets/icons/soccer-ball.png" alt="kick-off" style="height: 50px; width: auto"> Kick-off 
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-multidir" value="../media/assets/icons/directions.png">
                                    <label class="form-check-label" for="activity-icon-multidir">
                                        <img src="../media/assets/icons/directions.png" alt="multi-directional" style="height: 50px; width: auto"> Multi-directional 
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group my-4">
                            <label for="activity-select" class="comfortaa-font fs-5" style="color: #ffa500;">1. Workout / Activity:</label>
                            <select class="custom-select form-control-select-input p-4" name="activity-selectt" id="activity-select" required>
                                <option value='no-selection'>Select a workout / activity.</option>
                                $workout_activities_list
                                <option value='specified'>Specify</option>
                            </select>
                        </div>
                        <!-- submit btn -->
                        <button id="submit-teams-add-new-day-activity-data-form" class="btn onefit-buttons-style-tahiti p-4" type="submit" value="submit">
                            <span class="material-icons material-icons-round align-middle"> add_circle </span>
                            <span class="align-middle">Save.</span>
                        </button>
                    </form>
                </div>
            </div>
            _END;

            echo $formHTML;
        } catch (\Throwable $th) {
            //throw $th;
            echo "exception error: [indi edit-add new activity] " . $th->getMessage;
        }
    }
}

function compileSelectInputExerciseList()
{
    global $dbconn;
    $exercise_id = $xp_points = 0;
    $exercise_name = $workout_name = "";
    $compile_workout_activities_list = "";

    // $sql = "SELECT ex.exercise_id, ex.exercise_name, ex.xp_points, wk.workout_name, wk.workout_category FROM exercises ex
    // INNER JOIN workout_training wt ON wt.exercises_exercise_id = ex.exercise_id
    // INNER JOIN workouts wk ON w.workout_id = wt.workouts_workout_id
    // ORDER BY ex.exercise_name ASC";

    $sql = "SELECT `exercise_id`, `exercise_name`, `xp_points` FROM `exercises` ORDER BY `exercise_name` ASC";

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $exercise_id = $row["exercise_id"];
            $exercise_name = $row["exercise_name"];
            $xp_points = $row["xp_points"];

            // echo <<<_END
            // <div class="alert alert-success p-3">upid: $exercise_id | exercise name: $exercise_name | xp: $xp_points</div>
            // _END;

            $compile_workout_activities_list .= <<<_END
            <option value="$exercise_id"> $exercise_name ($xp_points<sub style="color: #ffa500;">xp</sub>)</option>
            _END;
        }
    } else {
        // echo <<<_END
        //     <div class="alert alert-danger p-3">No exercise items found.</div>
        //     _END;
        $compile_workout_activities_list = '<option value="error">No exercise items found.</option>';
    }

    return $compile_workout_activities_list;
}
