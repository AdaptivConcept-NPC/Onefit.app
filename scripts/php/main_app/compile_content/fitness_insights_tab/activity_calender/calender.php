<?php
session_start();
include("../../../../config.php");
include("../../../../functions.php");

$monthNames = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
$output = "";

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
        if ($todayCheck == "Yes") $todayClass = 'today';
    }

    if (($i % 7) == 0) $output .= '<tr>';
    if ($i < $startday) {
        $output .= '<td></td>';
    } else {
        // $cDay = $i - $startday + 1;
        $output .= <<<_END
        <td class="calender-day-item $todayClass" align="center" valign="middle" height="20px" 
            onclick="openCalenderActivityForm('$cYear','$cMonth','$cDay')">
            $cDay
        </td>
        _END;
    }
    if (($i % 7) == 6) $output .= '</tr>';
}

$currentServerPath = $_SERVER["PHP_SELF"];

$calenderHeading = $monthNames[$cMonth - 1] . " " . $cYear;

echo <<<_END
<div class="table-responsive pb-0" style="border-radius: 25px;">
    <table class="table table-hover mb-0" style="background: var(--mineshaft);">
        <thead style="background: #fff; color: #343434;">
            <tr class="comfortaa-font p-4" align="center" style="font-size: 30px">
                <td class="p-4" colspan="1" align="left"><button class="onefit-buttons-style-light p-3" onclick="navCalender('$prev_month','$prev_year','prev')"><i class="fas fa-chevron-left"></i> Prev</button></td>
                <td class="p-4" colspan="5" style="font-size:50px;cursor:pointer;" onclick="navCalender(null,null,'today')"><strong class="text-truncate"> $calenderHeading </strong></td>
                <td class="p-4" colspan="1" align="right"><button class="onefit-buttons-style-light p-3" onclick="navCalender('$next_month','$next_year','next')">Next <i class="fas fa-chevron-right"></i></button></td>
            </tr>
            <tr>
                <th class="text-center" scope="col">Sunday</th>
                <th class="text-center" scope="col">Monday</th>
                <th class="text-center" scope="col">Tuesday</th>
                <th class="text-center" scope="col">Wednesday</th>
                <th class="text-center" scope="col">Thursday</th>
                <th class="text-center" scope="col">Friday</th>
                <th class="text-center" scope="col">Saturday</th>
            </tr>
        </thead>
        <tbody class="text-white down-top-grad-tahiti" style="font-size: 30px">
            $output
        </tbody>
    </table>
</div>
_END;
