<?php
session_start();
require("../admin_config.php");
require('../functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // declaring variables
    $exercisetitle
        = $exercisedescription
        = $exerciseguidelines
        = $exerciseSets
        = $exerciseReps
        = $exerciseRests
        = $xp_points
        = $trainingPhase = null;

    $exercisetitle = sanitizeMySQL($dbconn, $_POST["exerciseTitle"]);
    $exercisedescription = sanitizeMySQL($dbconn, $_POST["exerciseDescription"]);
    $exerciseguidelines = sanitizeMySQL($dbconn, $_POST["exerciseGuidelines"]);
    $exerciseSets = sanitizeMySQL($dbconn, $_POST["exerciseSets"]);
    $exerciseReps = sanitizeMySQL($dbconn, $_POST["exerciseReps"]);
    $exerciseRests = sanitizeMySQL($dbconn, $_POST["exerciseRests"]);
    $xp_points = sanitizeMySQL($dbconn, $_POST["xp_points"]);
    $trainingPhase = sanitizeMySQL($dbconn, $_POST["trainingPhase"]);

    try {
        // check if a record with the same data exists in the database, if true then do not submit
        $query = "SELECT exercise_name, instructions FROM exercises WHERE exercise_name = '$exercisetitle' AND instructions = '$exercisedescription'";

        $result = $dbconn->query($query);
        $result = mysqli_query($dbconn, $query);
        if (!$result) {
            // die("Fatal error [1]: " . $dbconn->error);
            # insert 
            $query = "INSERT INTO `exercises`
            (`exercise_id`, `exercise_name`, `instructions`, `guidelines`, `sets`, `reps`, `rests`, `xp_points`, `training_phase`) 
            VALUES 
            (null,'$exercisetitle','$exercisedescription','$exerciseguidelines',$exerciseSets,$exerciseReps,$exerciseRests,$xp_points,'$trainingPhase')";

            $result = $dbconn->query($query);
            $result = mysqli_query($dbconn, $query);
            if (!$result) die("Fatal error [2]: " . $dbconn->error);

            $exercise_id = $dbconn->insert_id;

            echo $exercise_id;
        } else {
            echo "cancelled: duplicate entry";
        }
    } catch (\Throwable $th) {
        throw $th;
    }
} else {
    echo "failed: no data posted.";
}
