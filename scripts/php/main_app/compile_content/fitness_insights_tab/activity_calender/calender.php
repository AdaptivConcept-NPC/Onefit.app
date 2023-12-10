<?php
session_start();
include("../../../../config.php");
include("../../../../functions.php");

$monthNames = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
$output = "";
$activitiesCount = 0;
$badgeColor = "white";
$groupGRC = null;
$groupName = "Default_X.";

function getActivitiesCount($Year, $Month, $Day)
{
    global $dbconn, $badgeColor, $groupGRC, $groupName;
    $colorTagString = "white";
    try {
        //code...
        $query = "SELECT DISTINCT(tws.schedule_title), tws.color_code, tws.groups_group_ref_code, twa.* , grps.group_name
        FROM teams_weekly_schedules tws 
        LEFT JOIN team_weekly_activities twa ON twa.teams_weekly_schedules_teams_weekly_schedule_id = tws.teams_weekly_schedule_id 
        LEFT JOIN groups grps ON tws.groups_group_ref_code = grps.group_ref_code
        WHERE tws.schedule_date = '$Year-$Month-$Day'";
        $result = $dbconn->query($query);
        // $result = mysqli_query($dbconn, $query);
        if (!$result) die("Fatal error [2]: " . $dbconn->error);

        $rows = $result->num_rows;

        if ($rows > 0) {
            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $colorTagString = $row["color_code"];
                $groupGRC = $row["groups_group_ref_code"];
                $groupName = $row["group_name"];

                // extract color name/code
                $badgeColor = get_string_between($colorTagString, "[", "]");
            }
        }

        return $rows;
    } catch (\Throwable $th) {
        throw $th;
    }
}

if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");

$cMonth = $_REQUEST["month"];
$cYear = $_REQUEST["year"];
$cDay = 0;

$prev_year = $cYear;
$next_year = $cYear;
$prev_month = $cMonth - 1;
$next_month = $cMonth + 1;

if ($prev_month == 0) {
    $prev_month = 12;
    $prev_year = $cYear - 1;
}
if ($next_month == 13) {
    $next_month = 1;
    $next_year = $cYear + 1;
}

$timestamp = mktime(0, 0, 0, $cMonth, 1, $cYear);
$maxday = date("t", $timestamp);
$thismonth = getdate($timestamp);
$startday = $thismonth['wday'];
for ($i = 0; $i < ($maxday + $startday); $i++) {
    $todayClass = "";
    $todayCheck = "No";

    $todaysDate = date('Y/m/d');
    $cDay = $i - $startday + 1;
    // if $cDay is negative then do not perform the check
    if ($cDay > 0) {
        $cDateStr = date_format(date_create("$cYear/$cMonth/$cDay"), 'Y/m/d');
        // echo <<<_END
        // Todays Date: $todaysDate <br>
        // Cycle Date String: $cDateStr <br><br>
        // Cycle Day: $cDay <br><br>
        // _END; /* test output */
        if ($todaysDate == $cDateStr) $todayCheck = "Yes";
        // echo <<<_END
        // Do they match using ==? $todayCheck <hr><br><br>
        // _END; /* test output */
        if ($todayCheck == "Yes") $todayClass = 'today down-top-grad-white fs-1 py-4';
    }

    if (($i % 7) == 0) $output .= '<tr>';
    if ($i < $startday) {
        $output .= '<td></td>';
    } else {
        // call a function to get the count of scheduled activities activities and the color tag of the latest/last schedule entry for the current day/date 
        $activitiesCount = getActivitiesCount($cYear, $cMonth, $cDay);

        $countBadgeTag = $scheduleTitleBadgeTag = $tdStyling = $borderStyling = $badgeHexColorCode = $badgeTextColor = $badgeBGColorStyling = "";
        $zIndexElevation = "z-index:9;"; // default elevation css value
        if ($activitiesCount > 0) {
            $countBadgeTag = <<<_END
            <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill" 
            style="background-color: $badgeColor;z-index:100;font-size:14px;">
                $activitiesCount activities.
                <span class="visually-hidden">number of activities</span>
            </span>
            _END;

            $scheduleTitleBadgeTag = <<<_END
            <span id="scheduleTitleBadgeTag_$groupGRC" class="text-truncate position-absolute top-100 start-50 translate-middle badge rounded-pill py-2" 
            style="background-color: $badgeColor;z-index:100;font-size:8px;">
                $groupName.
                <span class="visually-hidden">schedule title</span>
            </span>
            _END;

            $borderStyling = <<<_END
            border-top:solid 5px $badgeColor!important;border-bottom:solid 5px $badgeColor!important;
            _END;

            // get the badges text contrast color using the two color mgmnt functions below
            $badgeHexColorCode = color_name_to_hex($badgeColor);
            $badgeTextColor = getContrastColor($badgeHexColorCode);

            $textColorStyling = <<<_END
            color:$badgeTextColor!important;
            _END;

            $badgeBGColorStyling = <<<_END
            background-color:$badgeColor!important;
            _END;
            $zIndexElevation = "z-index:10;";
            $tdStyling .= $zIndexElevation . $borderStyling . $textColorStyling . $badgeBGColorStyling;
        } else {
            $tdStyling = $zIndexElevation;
        }

        // $cDay = $i - $startday + 1;
        $output .= <<<_END
        <td class="calender-day-item position-relative $todayClass" style="coursor:pointer;$tdStyling" align="center" valign="middle" height="20px" 
            onclick="openCalenderActivityForm('$cYear','$cMonth','$cDay')">
            <span data-countBadgeTag> $countBadgeTag </span>
            <span data-cDay> $cDay </span>
            <span data-scheduleTitleBadgeTag> $scheduleTitleBadgeTag </span>
        </td>
        _END;
    }
    if (($i % 7) == 6) $output .= '</tr>';
}

$currentServerPath = $_SERVER["PHP_SELF"];

$calenderHeading = $monthNames[$cMonth - 1]; // . " " . $cYear;

echo <<<_END
<div class="table-responsive pb-4 top-down-grad-dark" style="border-radius: 25px;">
    <table class="table table-hover mb-0">
        <thead style="background: #fff; color: #343434;">
            <tr>
                <td class="px-4 py-2 text-center fw-bold fs-5" colspan="7"
                    style="background:var(--tahitigold);color:var(--mineshaft);">
                    $cYear Training calender.
                </td>
            </tr>
            <tr class="comfortaa-font p-4" align="center" style="font-size: 30px">
                <td class="p-4" colspan="7">
                    <div class="w-100 h-100 d-flex gap-4 justify-content-between">
                        <button class="onefit-buttons-style-light p-3 shadow -sm" onclick="navCalender('$prev_month','$prev_year','prev')">
                            <div class="d-flex gap-2 align-items-center">
                                <i class="fas fa-chevron-left align-middle" style="color:var(--tahitigold);"></i> 
                                <span class="align-middle text-start" style="font-size:16px;">Last month.</span>
                            </div>
                        </button>
                        <div class="onefit-buttons-style-light p-4 d-grid gap-2" colspan="5" style="font-size:50px;cursor:pointer;" onclick="navCalender(null,null,'today')">
                            <strong class="text-truncate"> $calenderHeading. </strong>
                            <span class="material-icons material-icons-round" style="color: #ffa500 !important">keyboard_arrow_down</span>
                        </div>
                        <button class="onefit-buttons-style-light p-3 shadow -sm" onclick="navCalender('$next_month','$next_year','next')">
                            <div class="d-flex gap-2 align-items-center">
                                <span class="align-middle text-end" style="font-size:16px;">Next month.</span>
                                <i class="fas fa-chevron-right align-middle" style="color:var(--tahitigold);"></i>
                            </div>
                        </button>
                    </div>
                </td>
            </tr>
            <tr class="border-0">
                <th class="text-center border-0" scope="col">Sunday</th>
                <th class="text-center border-0" scope="col">Monday</th>
                <th class="text-center border-0" scope="col">Tuesday</th>
                <th class="text-center border-0" scope="col">Wednesday</th>
                <th class="text-center border-0" scope="col">Thursday</th>
                <th class="text-center border-0" scope="col">Friday</th>
                <th class="text-center border-0" scope="col">Saturday</th>
            </tr>
        </thead>
        <tbody class="text-white down-top-grad-tahiti" style="font-size: 30px">
            $output
        </tbody>
    </table>
</div>
_END;
