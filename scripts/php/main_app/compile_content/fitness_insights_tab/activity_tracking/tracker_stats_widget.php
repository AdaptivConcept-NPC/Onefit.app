<?php
session_start();
require("../../../../config.php");
require_once("../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// check if request has been set on get params, if false then default $requestFormat to 'ui_request'
$requestFormat = null;
if (!isset($_GET['request'])) $requestFormat = 'ui_default';
else $requestFormat = sanitizeMySQL($dbconn, $_GET['request']);

// declaring variables
$initJsonArray = array('averageHeartrate' => null, 'averageTemp' => null, 'averageSpeed' => null, 'totalSteps' => null, 'averageBMI' => null);
$averageHeartrate = <<<_END
<div class="spinner-grow text-white" style="width:10px;height:10px;" role="status">
    <span class="visually-hidden">Loading Avg Heartrate...</span>
</div>
_END;
$averageTemp = <<<_END
<div class="spinner-grow text-white" style="width:10px;height:10px;" role="status">
    <span class="visually-hidden">Loading Avg Temparature...</span>
</div>
_END;
$averageSpeed = <<<_END
<div class="spinner-grow text-white" style="width:10px;height:10px;" role="status">
    <span class="visually-hidden">Loading Avg Speed...</span>
</div>
_END;
$totalSteps = <<<_END
<div class="spinner-grow text-white" style="width:10px;height:10px;" role="status">
    <span class="visually-hidden">Loading Steps taken...</span>
</div>
_END;
$averageWeightBMI = <<<_END
<div class="spinner-grow text-white" style="width:10px;height:10px;" role="status">
    <span class="visually-hidden">Loading Avg BMI...</span>
</div>
_END;

function getActivityStat($queryStr, $activityType)
{
    global $averageHeartrate, $averageTemp, $averageSpeed, $totalSteps, $averageWeightBMI, $dbconn, $requestFormat, $initJsonArray;

    $query = $queryStr;
    $result = null;
    try {
        $result = $dbconn->query($query);
        if (!$result) die("A fatal error occurred while processing query.");

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if ($requestFormat == 'json') {
                // 
                switch ($activityType) {
                    case 'heartrate':
                        $initJsonArray['averageHeartrate'] = number_format($row["SummaryValue"], 1);
                        break;
                    case 'temp':
                        $initJsonArray['averageTemp'] = number_format($row["SummaryValue"], 1);
                        break;
                    case 'speed':
                        $initJsonArray['averageSpeed'] = number_format($row["SummaryValue"], 1);
                        break;
                    case 'steps':
                        $initJsonArray['totalSteps'] = number_format($row["SummaryValue"], 0);
                        break;
                    case 'bmi':
                        $initJsonArray['averageBMI'] = number_format($row["SummaryValue"], 0);
                        break;

                    default:
                        die("unknown activity type: " . $activityType);
                        break;
                }
            } else {
                switch ($activityType) {
                    case 'heartrate':
                        $averageHeartrate = number_format($row["SummaryValue"], 1);
                        break;
                    case 'temp':
                        $averageTemp = number_format($row["SummaryValue"], 1);
                        break;
                    case 'speed':
                        $averageSpeed = number_format($row["SummaryValue"], 1);
                        break;
                    case 'steps':
                        $totalSteps = number_format($row["SummaryValue"], 0);
                        break;
                    case 'bmi':
                        $averageWeightBMI = number_format($row["SummaryValue"], 1);
                        break;

                    default:
                        die("unknown activity type: " . $activityType);
                        break;
                }
            }

            // echo "$userprofileid<br><br>";
        }
        // dump the $result
        $result = null;
    } catch (\Throwable $th) {
        die("An exception error has occured: $th");
    }
}

// loop through the different activity types stats and get the averages or counts
$activitiesArray = array("heartrate", "temp", "speed", "steps", "bmi");

foreach ($activitiesArray as $activityType) {
    # loop through the $activitArray and call the getActivityStat function to get the statistical summaries of the various activity types
    switch ($activityType) {
        case 'heartrate':
            $queryStr = "SELECT AVG(`bpm`) AS SummaryValue FROM `user_profile_fitness_stats_heart_rate`";
            getActivityStat($queryStr, $activityType);
            break;
        case 'temp':
            $queryStr = "SELECT AVG(`temperature`) AS SummaryValue FROM `user_profile_fitness_stats_body_temp`";
            getActivityStat($queryStr, $activityType);
            break;
        case 'speed':
            $queryStr = "SELECT AVG(`speed`) AS SummaryValue FROM `user_profile_fitness_stats_speed`";
            getActivityStat($queryStr, $activityType);
            break;
        case 'steps':
            $queryStr = "SELECT COUNT(`steps`) AS SummaryValue FROM `user_profile_fitness_stats_step_count`";
            getActivityStat($queryStr, $activityType);
            break;
        case 'bmi':
            $queryStr = "SELECT COUNT(`bmi`) AS SummaryValue FROM `user_profile_fitness_stats_bmi`";
            getActivityStat($queryStr, $activityType);
            break;

        default:
            die("unknown activity type: " . $activityType);
            break;
    }
}
switch ($requestFormat) {
    case 'ui_default':
        # create the html ui output and embed the summary stats values within the html
        $output = <<<_END
        <div class="container-xlg p-4 shadow-lg d-inline-blockz border-5 border-start border-end" style="border-radius: 25px; border-color: #ffa500 !important; background-color: #343434">
            <div class="row align-items-center text-center comfortaa-font">
                <div class="col-sm py-2 text-truncate">
                    <div class="d-none">
                        <span class="material-icons material-icons-round align-middle"> monitor_heart </span>
                        <span class="align-middle">Heart rate</span>
                    </div>
                    <div class="d-grid gap-2">
                        <span class="align-middle fs-6">
                            <span class="heartrate-avg-stat">
                                $averageHeartrate
                            </span>
                            <sup style="color: #ffa500;">b/s</sup>
                        </span>
                        <span class="material-icons material-icons-round align-middle"> monitor_heart </span>
                    </div>
                </div>
                <div class="col-sm py-2 text-truncate">
                    <div class="d-inline">
                        <span class="align-middle" style="color: #ffa500">|</span>
                    </div>
                </div>
                <div class="col-sm py-2 text-truncate">
                    <div class="d-none">
                        <span class="material-icons material-icons-round align-middle"> device_thermostat </span>
                        <!-- Degree symbol html code: &#8451; -->
                        <span class="align-middle">Temp ℃</span>
                    </div>
                    <div class="d-grid gap-2">
                        <span class="align-middle fs-6">
                            <span class="temp-avg-stat">
                                $averageTemp
                            </span>
                            <sup style="color: #ffa500;">℃</sup>
                        </span>
                        <span class="material-icons material-icons-round align-middle"> device_thermostat </span>
                    </div>
                </div>
                <div class="col-sm py-2 text-truncate">
                    <div class="d-inline">
                        <span class="align-middle" style="color: #ffa500">|</span>
                    </div>
                </div>
                <div class="col-sm py-2 text-center">
                    <div class="d-inline">
                        <button class="btn p-4 onefit-buttons-style-dark my-pulse-animation-fitbit border-5 border hide-side-panels" style="border-radius: 25px !important; border-color: var(--fitbit-light-blue) !important;" type="button" 
                        data-bs-toggle="collapse" data-bs-target="#fitbit-manage-panel" aria-expanded="false" aria-controls="fitbit-manage-panel">
                            <img src="../media/assets/icons/icons8-smart-watch-50.png" alt="smartwatch" class="img-fluid mb-2">
                            <span class="material-icons material-icons-round align-middle" style="color: var(--fitbit-light-blue);">fitbit</span>
                        </button>
                    </div>
                </div>
                <div class="col-sm py-2 text-truncate">
                    <div class="d-inline">
                        <span class="align-middle" style="color: #ffa500">|</span>
                    </div>
                </div>
                <div class="col-sm py-2 text-truncate">
                    <!--<i class="fas fa-bolt"></i>-->
                    <div class="d-none">
                        <span class="material-icons material-icons-round align-middle"> bolt </span>
                        <span class="align-middle">Speed</span>
                    </div>
                    <div class="d-grid gap-2">
                        <!--<i class="fas fa-bolt"></i>-->
                        <span class="align-middle fs-6">
                            <span class="speed-avg-stat">
                                $averageSpeed
                            </span>
                            <sup style="color: #ffa500;">ms</sup>
                        </span>
                        <span class="material-icons material-icons-round align-middle"> bolt </span>
                    </div>
                </div>
                <div class="col-sm py-2 text-truncate">
                    <div class="d-inline">
                        <span class="align-middle" style="color: #ffa500">|</span>
                    </div>
                </div>
                <div class="col-sm py-2 text-truncate">
                    <!--<i class="fas fa-walking"></i>-->
                    <div class="d-none">
                        <span class="material-icons material-icons-round align-middle"> directions_walk </span>
                        <span class="align-middle">Steps</span>
                    </div>
                    <div class="d-grid gap-2">
                        <!--<i class="fas fa-walking"></i>-->
                        <div class="align-middle fs-6">
                            <span class="steps-taken-stat">
                                $totalSteps
                            </span>
                            <sup style="color: #ffa500; font-size: 10px;"> stps</sup>
                        </div>
                        <span class="material-icons material-icons-round align-middle"> directions_walk </span>
                    </div>
                </div>
            </div>  
            <!-- fitbit management options panel -->  
            <div id="fitbit-manage-panel" class="collapse p-4 w3-animate-left">
                <h1 class="fs-5">
                    <span class="material-icons material-icons-round align-middle" style="color: var(--fitbit-light-blue);">fitbit</span>
                    <span>fitbit account.</span>
                </h1>
            </div>
            <!-- ./ fitbit management options panel -->  
        </div>
        _END;
        break;
    case 'json':
        # pass the returned array and convert it to json format string
        $output = json_encode($initJsonArray);
        break;

    default:
        # error, unknown request type/format so kill the script
        die('Unknown data request format: ' . $requestFormat);
        break;
}


echo $output;

// close the db connection
$dbconn->close();
