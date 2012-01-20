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
?>

<html>
    <head>
        <script language="javascript" src="FusionCharts/FusionCharts.js"></script>
    </head>
    <body>
        <?        

        $namesnids = array();
        $testSql = "SELECT count( DISTINCT (district) ) AS Submitters from surveillance where epiweek=18 and datecreated > (select deadline from deadlines where epiweek = 19)";
        $districtsquery = mysql_query("select count(id) as expected from districts");
        $districtres = mysql_fetch_assoc($districtsquery);
        $testBuffer = mysql_query($testSql) or die(mysql_error());
        $counter = 0;
        while ($testResult = mysql_fetch_array($testBuffer)) {
            $namesnids[$counter][1] = $testResult['Names'];
            $namesnids[$counter][2] = $testResult['Submitters'];
            $counter++;
        }


        echo "<p align=center><b> National Reporting Timeliness Performances </b></p>";
        $strXML = "<chart formatNumberScale='0'>";
        foreach ($namesnids as $names) {
            $strXML .= "<set label='" . $names[1] . "' value='" . $names[2] . "' />";
            $strXML .= "<set label='" . $names[1] . "' value='" . ($districtres['expected'] - $names[2]) . "' />";
        }

        $strXML .= "</chart>";

        echo renderChart("FusionCharts/Line.swf", "", $strXML, "", 800, 500, false, false);
        ?>
    </body>
</html>