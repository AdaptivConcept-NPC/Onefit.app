<?php
    session_start();
    include("config.php");

    $monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $output = "";

    if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
    if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");

    $cMonth = $_REQUEST["month"];
    $cYear = $_REQUEST["year"];

    $prev_year = $cYear;
    $next_year = $cYear;
    $prev_month = $cMonth-1;
    $next_month = $cMonth+1;

    if ($prev_month == 0 ) {
        $prev_month = 12;
        $prev_year = $cYear - 1;
    }
    if ($next_month == 13 ) {
        $next_month = 1;
        $next_year = $cYear + 1;
    }

    $timestamp = mktime(0,0,0,$cMonth,1,$cYear);
    $maxday = date("t",$timestamp);
    $thismonth = getdate ($timestamp);
    $startday = $thismonth['wday'];
    for ($i=0; $i<($maxday+$startday); $i++) {
        if(($i % 7) == 0 ) $output .= '<tr>';
        if($i < $startday) $output .= '<td></td>';
        else $output .= '<td align="center" valign="middle" height="20px" onclick="openForm('."'".$cYear."/".$cMonth."/".($i - $startday + 1)."'".')">'. ($i - $startday + 1).'</td>';
        if(($i % 7) == 6 ) $output.= '</tr>';
    }

    $currentServerPath = $_SERVER["PHP_SELF"];

    echo '<div class="table-responsive pb-0" style="border-radius: 25px;">
            <table class="table table-striped mb-0" style="background: #ffa500; color: #333">
                <thead style="background: #fff;">
                    <tr align="center" style="font-size: 30px">
                        <td colspan="1" align="left"><button class="onefit-buttons-style p-3" onclick="navCalender($currentServerPath?month=$prev_month&year=$prev_year)"><i class="fas fa-chevron-left"></i> Prev</button></td>
                        <td colspan="5" style="font-size: 50px"><strong class="text-truncate">'.$monthNames[$cMonth-1].' '.$cYear.'</strong></td>
                        <td colspan="1" align="right"><button class="onefit-buttons-style p-3" onclick="navCalender('.$currentServerPath.'?month='.$next_month.'&year='.$next_year."'".')">Next <i class="fas fa-chevron-right"></i></button></td>
                    </tr>
                    <tr>
                        <th scope="col">Sunday</th>
                        <th scope="col">Monday</th>
                        <th scope="col">Tuesday</th>
                        <th scope="col">Wednesday</th>
                        <th scope="col">Thursday</th>
                        <th scope="col">Friday</th>
                        <th scope="col">Saturday</th>
                    </tr>
                </thead>
                <tbody style="font-size: 30px">
                    '.$output.'
                </tbody>
            </table>
        </div>';
?>