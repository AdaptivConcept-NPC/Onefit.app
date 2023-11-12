<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// $_SERVER["REQUEST_METHOD"] == "POST"

if (isset($_GET['uid'])) {
    // get the sports list and compile list items
    // declararions of vars and assigning defaults
    $sportList = <<<_END
    <li><button class="dropdown-item" onclick="alert('Filter Sport: all')">All</button></li>
    _END;

    $drillsList = <<<_END
    <div id="launch-user-drill-designer" class="grid-tile p-4 shadow border-5 border-bottom down-top-grad-whitez drills-tile d-grid justify-content-center" style="border-radius: 0 0 25px 25px;border-color: var(--tahitigold)!important;;max-width:25%;">
        <button class="onefit-buttons-style-light p-4 d-flex gap-2 align-items-center" onclick="alert('Workout designer is unavailable at the moment.')">
            <span class="material-icons material-icons-outline align-middle" style="font-size:40px !important;">add_circle</span>
            <span class="fs-2z fw-bold comfortaa-font text-start">Create a Training Drill.</span>
        </button>
    </div>
    _END;

    $workoutcardtheme_1 = <<<_END
    class="grid-tile p-4 shadow text-center border-5 border-bottom position-relative down-top-grad-tahitiz workouts-tile-premium-tahiti"
    _END; // tahiti
    $workoutcardtheme_2 = <<<_END
    class="grid-tile p-4 shadow text-center border-5 border-bottom position-relative down-top-grad-whitez workouts-tile-premium-light"
    _END; // light/white
    $workoutcardtheme_3 = <<<_END
    class="grid-tile p-4 shadow text-center border-5 border position-relative workouts-tile-community-light"
    _END; // transparent/no_bg

    $thumbnail = "../media/assets/OnefitNet Profile PicArtboard 2.jpg";

    $workoutsList_Theme_Classes = $workoutcardtheme_1; //visual test: use the first style classes 
    $workoutsList = <<<_END
    <div id="launch-user-workout-designer" class="grid-tile p-4 shadow text-center border-5 border position-relative down-top-grad-white" style="background-color: #343434; border-color: #ffa500 !important;max-width:25%;">
        <img src="$thumbnail" class="img-fluid shadow mb-4" style="border-radius: 25px; max-height: 300px;" alt="default thumbnail">
        <button class="onefit-buttons-style-light p-4 fs-5 d-flex gap-2 align-items-center" onclick="alert('Workout designer is unavailable at the moment.')">
            <span class="material-icons material-icons-outline align-middle" style="font-size:40px !important;">add_circle</span>
            <span class="text-start">Design your own workout.</span>
        </button>
    </div>
    _END;

    function getSportsList($dbconn)
    {
        global $sportList;

        try {
            $query = "SELECT * FROM sports_list ORDER BY `name` ASC";
            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [" . $dbconn->error . "]");

            $rows = $result->num_rows;

            if ($rows == 0) {
                // no results were found
                return false;
            } else {
                $sport_id =
                    $category =
                    $name =
                    $administrators_username =  null;

                for ($j = 0; $j < $rows; ++$j) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    // assign values from db
                    $sport_id = $row["sport_id"];
                    $category = $row["category"];
                    $name = $row["name"];
                    // $administrators_username = $row["administrators_username"];

                    $sportList .= <<<_END
                    <li id="sport-id-$sport_id" data-category="$category"><button class="dropdown-item" onclick="alert('Filter Sport: $sport_id - $name - $category')"> $name </button></li>
                    _END;
                }

                return true;
            }
        } catch (\Throwable $th) {
            return -1;
        }
    }

    function getDrillsList($dbconn)
    {
        global $drillsList;

        // try to get the exercise/teams training drills
        try {
            $query = "SELECT * FROM exercise_drills";
            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [" . $dbconn->error . "]");

            $rows = $result->num_rows;

            if ($rows == 0) {
                // no results were found
                $found = false;
            } else {
                $found = true;
                // variables
                $drillsList = null; // initialize
                $exercise_drill_id =
                    $sport =
                    $drill_title =
                    $thumbnail =
                    $drill_demo_vid =
                    $training_level =
                    $target_area =
                    $benefits =
                    $rpe =
                    $instructions =
                    $administrators_username = null;

                for ($j = 0; $j < $rows; ++$j) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    // assign values from db
                    $exercise_drill_id =        $row["exercise_drill_id"];
                    $sport =                    $row["sport"];
                    $drill_title =              $row["drill_title"];
                    $thumbnail =                $row["thumbnail"];
                    $drill_demo_vid =           $row["drill_demo_vid"];
                    $training_level =           $row["training_level"];
                    $target_area =              $row["target_area"];
                    $benefits =                 $row["benefits"];
                    $rpe =                      $row["rpe"];
                    $instructions =             $row["instructions"];
                    $administrators_username =  $row["administrators_username"];

                    // assign default thumbnail if $thumbnail is empty
                    if (empty($thumbnail)) {
                        $thumbnail = "../media/assets/OnefitNet Profile PicArtboard 2.jpg";
                    }

                    $drillsList .= <<<_END
                        <div id="training-drill-card-$exercise_drill_id" class="grid-tile p-4 down-top-grad-white shadow border-5 text-center border-bottom drills-tile d-grid justify-content-centerz">
                            <!-- row-body -->
                            <div class="row justify-content-center align-items-centerz">
                                <div class="col-xlg-6 text-center top-down-grad-tahiti p-4" 
                                    style="border-radius: 25px;">
                                    <img src="$thumbnail" class="img-fluid shadow w-100" style="border-radius: 15px; filter: invert(0);" alt="$drill_title @ $training_level">
                                </div>
                                <div class="col-xlg-6 text-center down-top-grad-dark p-4 py-5 mb-4" style="border-radius:25px;overflow-x:auto;">
                                    <h5 class="fs-2 text-wrap comfortaa-font"> $drill_title </h5>
                                    <p class="mb-4 text-wrap">
                                        <strong>Benefits:</strong> $benefits <br>
                                        <strong>Intensity (RPE):</strong> $rpe / 10 <br>
                                    </p>
                                    <p class="mt-4 text-wrap text-mutedz text-whitez"><span class="material-icons material-icons-round align-middle" style="font-size: 10px !important; color: #ffa500 !important;">schedule</span>
                                        <strong>Target area(s):</strong> $target_area
                                    </p>
                                </div>
                            </div>
                            <!-- /.row-body --> 
                            <hr class="mt-0"/>
                            <button class="onefit-buttons-style-dark p-4 fs-5 d-flex gap-2 align-items-center justify-content-center text-center" onclick="alert('launch trainer')">
                                <span class="material-icons material-icons-rounded align-middle" style="font-size:40px !important;">run_circle</span>
                                <span class="text-start">Start.</span>
                            </button>
                        </div>
                        _END;

                    // $result->close();
                }
            }
        } catch (\Throwable $th) {
            $output = <<<_END
            <div class="text-center py-5">
                <h1 class="fs-1 fw-bold text-center my-5">😅 Oops. The content could not be loaded.</h1> 
                <p class="text-center">An error occured while loading your content, please refresh the page. If the error persists, please let us know: <a href="#?return=exception_error">Support</a>.</p>   
            </div>
            _END;
            die($output);
        }
    }
    // ./ end getDrillsList();

    function getWorkoutsList($dbconn)
    {
        global $workoutsList_Theme_Classes, $workoutsList;

        function countExercises($dbconn, $workout_id)
        {
            $exercise_count = 0;
            try {
                // get the number of exercises for the $workout_id
                $query = "SELECT COUNT(exercises.exercise_id) AS exercise_count
                FROM workouts 
                LEFT JOIN workout_training ON workout_training.workouts_workout_id = workouts.workout_id 
                LEFT JOIN exercises ON exercises.exercise_id = workout_training.exercises_exercise_id
                WHERE workouts.workout_id = $workout_id";
                $result = $dbconn->query($query);

                if (!$result) die("An error occurred while trying to save your details. [" . $dbconn->error . "]");

                $rows = $result->num_rows;

                for ($j = 0; $j < $rows; ++$j) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    // assign values from db
                    $exercise_count = $row["exercise_count"];
                }

                // $result->close();

                return $exercise_count;
            } catch (\Throwable $th) {
                return -1;
            }
        }
        // ./ end countExercises();

        // try to get the workouts
        try {
            $query = "SELECT 
                workout_id,
                workout_name,
                workout_description,
                goal_definition,
                total_xp_points,
                premium,
                category_class_category_class_code,
                category_class_name,	
                exercise_id,
                exercise_name,	
                instructions,
                guidelines,
                `sets`,
                reps,
                rests,
                rpe,
                xp_points,
                training_phase 
                FROM workouts 
                LEFT JOIN category_class ON category_class.category_class_code = workouts.category_class_category_class_code
                LEFT JOIN workout_training ON workout_training.workouts_workout_id = workouts.workout_id 
                LEFT JOIN exercises ON exercises.exercise_id = workout_training.exercises_exercise_id
                ORDER BY workouts.premium ASC, workouts.workout_name ASC;";
            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [" . $dbconn->error . "]");

            $rows = $result->num_rows;

            if ($rows == 0) {
                // no results were found
                $found = false;
            } else {
                $found = true;
                // variables
                $workoutsList = null; // initialize
                $workout_id =
                    $workout_name =
                    $workout_description =
                    $goal_definition =
                    $total_xp_points =
                    $premium =
                    $category_class_category_class_code =
                    $exercise_id =
                    $exercise_name =
                    $instructions =
                    $guidelines =
                    $sets =
                    $reps =
                    $rests =
                    $rpe =
                    $xp_points =
                    $training_phase  = null;

                for ($j = 0; $j < $rows; ++$j) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    // assign values from db
                    $workout_id =                          $row["workout_id"];
                    $workout_name =                        $row["workout_name"];
                    $workout_description =                 $row["workout_description"];
                    $goal_definition =                     $row["goal_definition"];
                    $total_xp_points =                     $row["total_xp_points"];
                    $premium =                             $row["premium"];
                    $category_class_category_class_code =  $row["category_class_category_class_code"];
                    $category_class_name =                 $row["category_class_name"];
                    $exercise_id =                         $row["exercise_id"];
                    $exercise_name =                       $row["exercise_name"];
                    $instructions =                        $row["instructions"];
                    $guidelines =                          $row["guidelines"];
                    $sets =                                $row["sets"];
                    $reps =                                $row["reps"];
                    $rests =                               $row["rests"];
                    $rpe =                                 $row["rpe"];
                    $xp_points =                           $row["xp_points"];
                    $training_phase =                      $row["training_phase"];

                    // assign default thumbnail if $thumbnail is empty
                    if (empty($thumbnail)) {
                        $thumbnail = "../media/assets/OnefitNet Profile PicArtboard 2.jpg";
                    }

                    // set card theme based on premium type:
                    /* switch ($premium) {
                        case true:
                            $workoutsList_Theme_Classes = $workoutcardtheme_1;
                            break;
                        case false:
                            $workoutsList_Theme_Classes = $workoutcardtheme_2;
                            break;

                        default:
                            $workoutsList_Theme_Classes = $workoutcardtheme_3;
                            break;
                    } */

                    // get the count of exercises of this workout
                    $exercise_count = countExercises($dbconn, $workout_id);

                    if ($exercise_count == -1) {
                        // exception error occured
                        $exercise_count_str = "Could not find exercises.";
                    } else {
                        $exercise_count_str = "$exercise_count exercises.";
                    }

                    $workoutsList .= <<<_END
                        <div id="workout-card-$workout_id" $workoutsList_Theme_Classes>
                            <div class="card bg-transparent border-0 h-100">
                                <div class="card-body bg-transparent border-0 down-top-grad-dark" style="border-radius:25px;">
                                    <img src="$thumbnail" class="img-fluid shadow mb-4" style="border-radius: 25px; max-height: 300px;" alt="$workout_name">
                                    <div class="workout-card-info-content no-scroller">
                                        <p class="fs-2 comfortaa-font"> $workout_name </p>
                                        <p class="mb-4 text-start"> 
                                            <strong>Guideline:</strong> <br> $guidelines <br>
                                            <strong>Goal:</strong> $goal_definition <br>
                                            <strong>Intensity (RPE):</strong> $rpe / 10 <br>
                                        </p>
                                        <p class="mt-4 text-start"><span class="material-icons material-icons-round align-middle" style="font-size: 10px !important; color: #ffa500 !important;">schedule</span>
                                            <strong>Avg. Workout Duration:</strong> *? mins / day <br>
                                            <strong>Category/Class:</strong> $category_class_name <br>
                                            <strong>Activities:</strong> $exercise_count_str <br>
                                            <strong>Workout XP:</strong> $total_xp_points <br>
                                        </p>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 d-grid p-0">
                                <hr class="my-2"/>
                                    <button class="onefit-buttons-style-dark p-4 fs-5 d-flex gap-2 align-items-center justify-content-center text-center" onclick="alert('launch trainer')">
                                        <span class="material-icons material-icons-rounded align-middle" style="font-size:40px !important;">run_circle</span>
                                        <span class="text-start">Start.</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        _END;

                    // $result->close();
                }
            }
        } catch (\Throwable $th) {
            $output = <<<_END
            <div class="text-center py-5">
                <h1 class="fs-1 fw-bold text-center my-5">😅 Oops. The content could not be loaded.</h1> 
                <p class="text-center">An error occured while loading your content, please refresh the page. If the error persists, please let us know: <a href="#?return=exception_error">Support</a>.</p>   
            </div>
            _END;
            die($output);
        }
    }
    // ./ end getWorkoutsList();

    // get the sports list
    getSportsList($dbconn);
    // get the drills list
    getDrillsList($dbconn);
    // get the workouts list
    getWorkoutsList($dbconn);

    // compile output
    $output = <<<_END
    <div class="modal-body w3-animate-top rounded-5 top-down-grad-dark" style="/* background: var(--white); */">
        <h1 class="fs-1 fw-bold text-center my-5">Teams Training Drills.</h1>
        <p class="text-center"> 
            <span class="material-icons material-icons-outlined align-middle" style="font-size: 20px !important;"> info </span> 
            You can filter the dills by Sports &amp; Category. Click on a drill tile to open it.
        </p>
        <div class="input-group mb-4 justify-content-center">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Training Category Dropdown</span>
                <span class="material-icons material-icons-round align-middle" style="font-size: 30px!important;">filter_list</span>
                <span class="align-middle" style="font-size: 20px!important;">🏅 Sports.</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end onefit-dropdown-menu-style p-0" style="max-height:50vh;overflow-y:auto;">
                $sportList
                <li><hr class="dropdown-divider"></li>
                <li class="sticky-bottom bg-white"><a class="dropdown-item" href="#"><span class="align-middle fw-bold">Sort by: </span> <span class="material-icons material-icons-round align-middle" style="font-size:30px !important;">chevron_right</span> </a></li>
            </ul>
            <input type="text" class="form-control" aria-label="Search for drills or workouts." placeholder="Search for drills or workouts." style="max-width: 300px;">
            <button type="button" class="btn btn-outline-secondary">
                <span class="material-icons material-icons-round align-middle" style="font-size:30px!important;">search</span>
                <span class="align-middle" style="font-size:10px!important;"> Search.</span>
            </button>
        </div>
        <div class="container">
            <div class="grid-container">
                $drillsList
            </div>
        </div>
        <hr class="text-white">
        <h1 class="fs-1 fw-bold text-center my-5">Indi-Fitness Workouts.</h1>
        <div class="container">
            <div id="personal-training-workouts-grid" class="grid-container gap-5 mb-4" style="max-width: 100% !important;">
                $workoutsList
            </div>
        </div>
    </div>
    _END;
    // if ($found) {
    // } else {
    //     // output html to indicate that the content was not loaded successfully, offer link to support
    // }

    echo $output;

    $result = null;
    $dbconn->close();
} else {
    $output = <<<_END
    <div class="text-center py-5">
        <h1 class="fs-1 fw-bold text-center my-5">😅 Oops. The content could not be loaded.</h1> 
        <p class="text-center">An error occured while loading your content, please refresh the page. If the error persists, please let us know: <a href="#?return=empty_parameters">Support</a>.</p>   
    </div>
    _END;
    echo  $output;
}
