<?php
session_start();
// scripts\php\functions.php
// scripts\php\main_app\compile_content\fitness_insights_tab\training\interactions\create\add_match_to_fixture.php
require("../../../../../../config.php");
require_once("../../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");
// echo "hello";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // declaring variables
    // #add-match-fixture-match-status
    // #add-match-fixture-match-title
    // #add-match-fixture-home-team
    // #add-match-fixture-away-team
    // #add-match-fixture-match-venue
    // #add-match-fixture-match-date
    // #add-match-fixture-match-start-time
    // #add-match-fixture-standard-match-duration
    // #add-match-fixture-observed-match-duration
    // #add-match-fixture-match-results-home-team
    // #add-match-fixture-match-results-away-team

    $addToFixture_user_grcode
        = $addToFixture_match_status
        = $addToFixture_match_title
        = $addToFixture_home_team
        = $addToFixture_away_team
        = $addToFixture_match_venue
        = $addToFixture_match_date
        = $addToFixture_match_start_time
        = $addToFixture_standard_match_duration
        = $addToFixture_observed_match_duration
        = $addToFixture_match_results_home_team
        = $addToFixture_match_results_away_team = null;

    $addToFixture_user_grcode = sanitizeMySQL($dbconn, $_POST["add-match-fixture-group-selected"]);
    $addToFixture_match_status = sanitizeMySQL($dbconn, $_POST["add-match-fixture-match-status"]);
    $addToFixture_match_title = sanitizeMySQL($dbconn, $_POST["add-match-fixture-match-title"]);
    $addToFixture_home_team = sanitizeMySQL($dbconn, $_POST["add-match-fixture-home-team"]);
    $addToFixture_away_team = sanitizeMySQL($dbconn, $_POST["add-match-fixture-away-team"]);
    $addToFixture_match_venue = sanitizeMySQL($dbconn, $_POST["add-match-fixture-match-venue"]);
    $addToFixture_match_date = sanitizeMySQL($dbconn, $_POST["add-match-fixture-match-date"]);
    $addToFixture_match_start_time = sanitizeMySQL($dbconn, $_POST["add-match-fixture-match-start-time"]);
    $addToFixture_standard_match_duration = sanitizeMySQL($dbconn, $_POST["add-match-fixture-standard-match-duration"]);
    $addToFixture_observed_match_duration = sanitizeMySQL($dbconn, $_POST["add-match-fixture-observed-match-duration"]);
    $addToFixture_match_results_home_team = sanitizeMySQL($dbconn, $_POST["add-match-fixture-match-results-home-team"]);
    $addToFixture_match_results_away_team = sanitizeMySQL($dbconn, $_POST["add-match-fixture-match-results-away-team"]);

    try {
        // check if a record with the same data exists in the database, if true then do not submit
        $query = "INSERT INTO `team_athletics_match_schedules`
        (`team_athletics_match_id`, `match_title`, `home_team`, 
        `away_team`, `match_venue`, `match_date`, `start_time`, 
        `standard_match_duration`, `observed_match_duration`, 
        `match_result`, `groups_group_ref_code`) 
        VALUES 
        (null,'$addToFixture_match_title','$addToFixture_home_team',
        '$addToFixture_away_team','$addToFixture_match_venue','$addToFixture_match_date','$addToFixture_match_start_time',
        $addToFixture_standard_match_duration,$addToFixture_observed_match_duration,
        '$addToFixture_match_results_home_team - $addToFixture_match_results_away_team', '$addToFixture_user_grcode')";

        $result = $dbconn->query($query);
        $result = mysqli_query($dbconn, $query);

        if (!$result) die("Fatal error: " . $dbconn->error);

        echo "success";

        $result = null;
        $dbconn->close();
    } catch (\Throwable $th) {
        throw $th;
    }
} else {
    echo "failed: no data posted.";
}
