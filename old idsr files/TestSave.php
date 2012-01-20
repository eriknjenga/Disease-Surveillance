<?php
include 'national_header.php';
include 'FusionCharts/FusionCharts.php';

function WeekToDate($week, $year) {
    $Jan1 = mktime(1, 1, 1, 1, 1, $year);
    $iYearFirstWeekNum = (int) strftime("%W", mktime(1, 1, 1, 1, 1, $year));

    if ($iYearFirstWeekNum == 1) {
        $week = $week - 1;
    }

    $weekdayJan1 = date('w', $Jan1);
    $FirstMonday = strtotime(((4 - $weekdayJan1) % 7 - 3) . ' days', $Jan1);
    $CurrentMondayTS = strtotime(($week) . ' weeks', $FirstMonday);
    return ($CurrentMondayTS);
}

function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

$epiweeks = array();
$count = 0;
$epiloop = "select distinct epiweek from surveillance order by epiweek asc";
$epiquery = mysql_query($epiloop);
while ($epires = mysql_fetch_assoc($epiquery)) {
    $epiweeks[$count] = $epires['epiweek'];
    $count++;
}

$deadlines = array();
$otherdeadlines = array();
$deadcount = 0;
$otherdeadcount = 0;


foreach ($epiweeks as $epiweek) {
    $iWeekNum = $epiweek;
    $iYear = date("Y");

    $sStartTS = WeekToDate($iWeekNum, $iYear);
    $sStartDate = date("Y-m-d", $sStartTS);
    $sWedDate = date("Y-m-d", $sStartTS + (2 * 24 * 60 * 60));
    
    $epiinsert = mysql_query("insert into deadlines (epiweek,deadline) values ('$epiweek','$sWedDate') ") or die(mysql_error());
    $deadlines[$deadcount] = $sWedDate;
    $deadcount++;
}
