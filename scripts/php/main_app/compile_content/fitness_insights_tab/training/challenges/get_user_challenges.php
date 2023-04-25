<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['usernm']) && isset($_GET['cycle'])) {
    $username = sanitizeMySQL($dbconn, $_GET['usernm']);
    $cycle = sanitizeMySQL($dbconn, $_GET['cycle']);

    $workout_challenge_id
        = $category_class_category_class_code
        = $challenge_title
        = $challenge_xp
        = $instructions
        = $guidelines
        = $sets
        = $reps
        = $rests
        = $challenge_frequency
        = $challenge_cycle
        = $created
        = $created_by
        = $modified
        = $modified_by
        = $workouts_workout_id
        = $exercises_exercise_id
        = $challenges
        = $totalChallengeXP
        = $xp_bar = null;

    // joined table cols variables
    $workout_name
        = $total_xp_points
        = $premium
        = $workout_cc_code = null;
    $exercise_name
        = $xp_points
        = $training_phase = null;
    $category_class_name = null;

    try {
        //get the users activity timeline/history
        $query = "SELECT wc.*, w.workout_name, w.total_xp_points, w.premium, w.category_class_category_class_code AS workout_cc_code, 
        e.exercise_name, e.xp_points, e.training_phase, 
        cc.category_class_name
        FROM workout_challenges wc
        INNER JOIN workouts w ON w.workout_id = wc.workouts_workout_id
        inner JOIN exercises e ON e.exercise_id = wc.exercises_exercise_id
        INNER JOIN category_class cc on cc.category_class_code = w.category_class_category_class_code
        WHERE wc.created_by = '$username' AND wc.challenge_cycle = '$cycle' ORDER BY `reps` ASC";
        // `workout_id`, `workout_name`, `workout_description`, `goal_definition`, `total_xp_points`, `premium`, `category_class_category_class_code`
        // `exercise_id`, `exercise_name`, `instructions`, `guidelines`, `sets`, `reps`, `rests`, `xp_points`, `training_phase`
        // `category_class_id`, `category_class_code`, `category_class_name`

        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to compile the requested data. [output - " . $dbconn->error . "]");

        $rows = $result->num_rows;

        if ($rows == 0) {
            //there is no result echo the label
            echo <<<_END
            <div class="grid-tile p-4 shadow text-center border-1 border" style="background-color: #343434;">
                <h1 class="fs-5">No challenges available.</h1>
            </div>
            _END;
        } else {
            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $workout_challenge_id = $row["workout_challenge_id"];
                $category_class_category_class_code = $row["category_class_category_class_code"];
                $challenge_title = $row["challenge_title"];
                $challenge_xp = $row["challenge_xp"];
                $instructions = $row["instructions"];
                $guidelines = $row["guidelines"];
                $sets = $row["sets"];
                $reps = $row["reps"];
                $rests = $row["rests"];
                $challenge_frequency = $row["challenge_frequency"];
                $challenge_cycle = $row["challenge_cycle"];
                $created = $row["created"];
                $created_by = $row["created_by"];
                $modified = $row["modified"];
                $modified_by = $row["modified_by"];
                $workouts_workout_id = $row["workouts_workout_id"];
                $exercises_exercise_id = $row["exercises_exercise_id"];

                $workout_name = $row["workout_name"];
                $total_xp_points = $row["total_xp_points"];
                $premium = $row["premium"];
                $workout_cc_code = $row["workout_cc_code"];

                $exercise_name = $row["exercise_name"];
                $xp_points = $row["xp_points"];
                $training_phase = $row["training_phase"];

                $category_class_name = $row["category_class_name"];

                $totalChallengeXP = $challenge_xp * $challenge_frequency;



                $xp_bar = <<<_END
                <div class="progress mb-2 bg-white" style="height:5px;">
                    <!-- border:1px solid white !important; -->
                    <div class="progress-bar" role="progressbar" aria-label="Challenge XP Progression" style="width: 10%;background-color:var(--tahitigold)!important;" aria-valuenow="1" aria-valuemin="1" aria-valuemax="$totalChallengeXP"></div>
                </div>
                _END;

                $challenges .= <<<_END
                <div class="grid-tile p-4 shadow text-center border-5 border-start border-end shadow" style="background-color: #343434;">
                    <img src="../media/assets/icons/icons8-bench-press-50.png" class="img-fluid rounded mb-4" alt="">
                    <p>$challenge_title</p>
                    <p class="mb-0" style="font-size:10px;color:var(--tahitigold);">Workout:</p>
                    <p onclick="viewWorkout('$workouts_workout_id')" style="cursor:pointer;"><small>$workout_name</small></p>
                    <p class="mb-0" style="font-size:10px;color:var(--tahitigold);">Exercise to perform:</p>
                    <p onclick="viewWorkout('$exercises_exercise_id')" style="cursor:pointer;"><small>$exercise_name</small></p>
                    <p class="mb-0" style="font-size:10px;color:var(--tahitigold);">Category / Class:</p>
                    <p><small>$category_class_name</small></p>
                    <!-- progress bar -->
                    <p class="mb-2" style="font-size:10px;color:var(--tahitigold);">Challenge progress:</p>
                    <div id="challenge-xp-progress-container">
                        $xp_bar
                    </div>
                    <p class="text-end mb-0">? / $totalChallengeXP xp</p>
                </div>
                _END;
            }

            // output the timeline information and close connections
            echo $challenges;
            $result = null;
            $dbconn->close();
        }
    } catch (\Throwable $th) {
        throw "Exception error: $th";
    }
}
