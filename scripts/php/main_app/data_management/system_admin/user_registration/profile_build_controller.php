<?php
session_start();
require("../../../../config.php");
require("../../../../functions.php");

// verify has $_GET"secure"], if not secure then kill operation - user data protection
if (isset($_GET["secure"])) {
  $secureHash = $_GET["secure"];

  if (!password_verify("Onefit_app_SecureInfo_Request_2023", $secureHash)) die("Error: Not secure");
} else {
  die("Error: Not secure");
}

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");;

if (isset($_GET["panel"])) {
  $panelName = sanitizeString($_GET["panel"]);
  $htmlOutput = <<<_END
  <span id="$panelName-info-return-state" style="display: none;">success</span>
  _END;

  try {
    // get pid from session
    $profile_id = $_SESSION["pid"];

    $questionNumber = 0;

    switch ($panelName) {
      case 'aboutyou':
        // sql query get all from user_profile_about table
        $query = "SELECT `height` AS `Height:`, `weight` AS `Weight:`, `bmi` AS `Body Mass Index (BMI):`, `bmi_status` AS `Your BMI Status:`, `log_date` AS `Submitted on:` FROM user_profile_about WHERE general_user_profiles_user_profile_id = $profile_id";
        $questionNumber = 8; // start count from 8
        break;
      case 'goalsetting':
        $query = "SELECT `fitness_goals` AS `What are your Fitness Goals?`,`goal_statement` AS `Your Goal statement:`,`realize_goal_date` AS `Goal realization target date:`,`body_area_focus` AS `Areas of your body to focus on:`,`workouts_to_do_week` AS `Your workouts per week:`,`time_to_workout` AS `Time available to workout:`,`weeks_to_start` AS `Number of weeks to start training:`,`bad_habits` AS `Your bad habits:`,`prepared_letgoof_badhabits` AS `Are you prepered to let go of your bad habits?`,`pref_cheat_day` AS `Your preferred Cheat day:`,`will_do_cheat_day` AS `Cheat day Pledge:`,`log_date` AS `Submitted on:` FROM user_profile_goalsetting WHERE general_user_profiles_user_profile_id = $profile_id";
        break;
      case 'fitprefs':
        $query = "SELECT `how_fit_are_you` AS `How Fit are you?`,`last_time_ideal_weight` AS `Your last ideal weight was:`,`body_type` AS `Your body type:`,`suffer_from_joint_pain` AS `Do you suffer from Joint pain?`,`daily_life_activity` AS `How active are you in your daily life?`,`energy_levels_during_day` AS `Your energy levels during the day:`,`night_sleep_hours` AS `How much do you sleep every night?`,`daily_water_intake` AS `Your daily water intake:`,`prefared_classes` AS `Your preferred training classes / categories:`,`log_date` AS `Submitted on:` FROM user_profile_fitprefs WHERE general_user_profiles_user_profile_id = $profile_id";
        break;

      default:
        die("Error: Unknown panel name: $panelName");
        break;
    }

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to save your details. [$panelName Query Error_01 _ " . $dbconn->error . "] | query: " . $query . "");

    $row_cnt = $result->num_rows;

    if ($row_cnt <= 0) {
      $result->close();
      $dbconn->close();
      die(false);
    } else {
      // guide: https://stackoverflow.com/questions/6962771/whilerow-mysql-fetch-assocresult-how-to-foreach-row
      $row = $result->fetch_assoc();
      foreach ($row as $key => $value) {
        $questionNumber += 1;

        // assign $value to $recordValue
        // $recordValue = $row[$key];
        $recordValue = ucfirst($value);

        // assign $key to $question after removing any underscores
        $question = str_replace("_", " ", $key);

        /* *** specific column value formatting rules ***  */
        // remove last comma from value string
        $recordValue = rtrim($recordValue, ",");

        // insert space after comma
        $recordValue = str_replace(",", ", ", $recordValue);

        // convert log_date/submitted on date time 
        if ($key == "Submitted on:") {
          // F to get full Month name
          $recordValue = date("d M Y - h:i A", strtotime($recordValue));
        }

        if ($key == "Height:") {
          // convert height m to cm
          $recordValue = $recordValue * 100;
          $recordValue = "$recordValue cm";
        }

        if ($key == "Weight:") {
          $recordValue = "$recordValue kg";
        }

        if ($key == "Are you prepered to let go of your bad habits?") {
          if ($recordValue == 1) {
            $recordValue = "Yes";
          } else {
            $recordValue = "No";
          }
        }

        if ($key == "Number of weeks to start training:") {
          $recordValue = "$recordValue Week(s)";
        }

        if ($key == "Your preferred Cheat day:") {
          if ($recordValue == "No_cheat" || $recordValue == "no_cheat") {
            $recordValue = "No cheat day";
          }
        }

        if ($key == "Cheat day Pledge:") {
          $recordValue = "I promise to <b>$recordValue</b> on my cheat day.";
        }

        /* *** end of specific column value formatting rules ***  */

        $htmlOutput .= <<<_END
        <div class="row align-items-center">
          <div class="col-lg-6 p-2 text-start">
            <!-- <span class="material-icons material-icons-outlined" style="font-size: 180px !important;">sports_score</span> -->
            <p class="fs-5 comfortaa-font align-middle"><span class=" fs-2" style="color: var(--primary-color);">$questionNumber)</span>
              $question
            </p>
          </div>
          <div class="col-lg p-2">
            <div class="form-group">
              <p class="fs-5" style="color: var(--primary-color);"> $recordValue </p>
            </div>
          </div>
        </div>
        _END;
      }
    }

    echo $htmlOutput;

    $result->close();
    $dbconn->close();
  } catch (\Throwable $th) {
    //throw $th;
    echo "exception error: [$panelName Except Err] " . $th;
    $dbconn->close();
  }
} else {
  echo "Error: get panel - not set";
};
