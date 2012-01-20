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
$epiloop = "select distinct epiweek from surveillance";
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

    $deadlines[$deadcount] = $sWedDate;
    $deadcount++;
}

$strXML = "<chart caption='Timeliness Completion' xAxisName='Province' yAxisName='Proportion of districts that reported on time' showValues='0' decimals='0' formatNumberScale='0'>";


$getprovinces = mysql_query("select ID,name from provinces") or die(mysql_error());

while (list($ID, $name) = mysql_fetch_array($getprovinces)) {
//get total no of ditrcuts per province
    $dno = mysql_query("SELECT * from districts where flag=1 and province='$ID'");
    $numofdists = mysql_num_rows($dno);

//those districts tht hav submitted  
    $d = mysql_query("SELECT DISTINCT(surveillance.district) as nos from surveillance,districts,provinces where surveillance.district=districts.ID AND districts.province='$ID' and epiweek = 18 and datemodified > '$deadlines[0]'");
    $submitted = mysql_num_rows($d);
//calulate percentage 
    $percentage = round(($submitted / $numofdists) * 100);

    $strXML .= "<set label='$name' value='$percentage' />";
}

$strXML .= "</chart>";
echo renderChart("FusionCharts/Column3D.swf", "", $strXML, "", 800, 500, false, false);

?>
