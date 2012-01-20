<?php
$link = 'timeliness';
include 'national_header.php';
include 'FusionCharts/FusionCharts.php';
include 'FusionCharts/Code/PHPClass/Class/FusionCharts_Gen.php';

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

mysql_connect("localhost", "root", "");
mysql_select_db("idsr");
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

<form action="Timeliness.php?epiweek=<?php echo $_GET['epiweek']; ?>" method="get" name="Timeliness">
    <div style="position: absolute; top: 200px; left: 250px">
        <table>
            <tr><td>
                    <input type="submit" name="submit" value="Filter by Epiweek" class="button"/>
                </td>
            </tr>
            <tr><td>
                    <select name="epiweek">

                        <?php
                        $epiweeksql = mysql_query("select distinct epiweek from surveillance");
                        while ($epires = mysql_fetch_assoc($epiweeksql)) {
                            if($_GET['epiweek'] == $epires[epiweek]){
                            echo "<option selected value=$epires[epiweek]>" . $epires['epiweek'];
                            }
                            else{
                            echo "<option value=$epires[epiweek]>" . $epires['epiweek'];    
                            }
                        }
                        ?></option>
                    </select>                   
                </td>
                <td>

                </td>
            </tr>     
    </div>
</div>

</form>


<?php
$namesnids = array();
$testSql = "SELECT count( DISTINCT (district) ) AS Submitters from surveillance where epiweek='" . $_GET['epiweek'] . "' and datecreated > (select deadline from deadlines where epiweek = '" . $_GET['epiweek'] . "')";
$districtsquery = mysql_query("select count(id) as expected from districts");
$districtres = mysql_fetch_assoc($districtsquery);
$testBuffer = mysql_query($testSql) or die(mysql_error());

$counter = 0;
while ($testResult = mysql_fetch_array($testBuffer)) {
    $namesnids[$counter][1] = $testResult['Names'];
    $namesnids[$counter][2] = $testResult['Submitters'];
    $counter++;
}


echo "<p align=center><b> National Timeliness Performances </b></p>";
$strXML2 = "<chart formatNumberScale='0' showBorder='0' bgColor='ffffff' caption='Completeness of reporting for epiweek $_GET[epiweek]'>";
foreach ($namesnids as $namer) {
    $strXML2 .= "<set label='" . $namer[1] . "Total Reporting Districts" . "' value='" . $namer[2] . "' color='black'/>";
    $strXML2 .= "<set label='" . $namer[1] . "Non Reporting Districts" . "' value='" . ($districtres['expected'] - $namer[2]) . "' />";
}

$strXML2 .= "</chart>";

?>
<table><tr><td><?php
echo renderChart("FusionCharts/Pie2D.swf", "", $strXML2, "chart2", 600, 400, false, false);


  
    $strXML = "<chart caption='Timeliness Completion' xAxisName='Province' yAxisName='Districts that reported on time (Epiweek $_GET[epiweek])' showBorder='0' bgColor='FFFFFF' useRoundEdges='1'>";


    $getprovinces = mysql_query("select ID,name from provinces") or die(mysql_error());

    while (list($ID, $name) = mysql_fetch_array($getprovinces)) {
//get total no of ditrcuts per province
        $dno = mysql_query("SELECT * from districts where flag=1 and province='$ID'");
        $numofdists = mysql_num_rows($dno);

//those districts tht hav submitted  
        $d = mysql_query("SELECT DISTINCT(surveillance.district) as nos from surveillance,districts,provinces where surveillance.district=districts.ID AND districts.province='$ID' and epiweek = '" . $_GET['epiweek'] . "' and datemodified > (select deadline from deadlines where epiweek = '" . $_GET['epiweek'] . "')");
        $submitted = mysql_num_rows($d);
//calulate percentage 
        $percentage = round(($submitted / $numofdists) * 100);

        $strXML .= "<set label='$name' value='$percentage' />";
    }

    $strXML .= "</chart>";

echo "<td>" . renderChart("FusionCharts/Column2D.swf", "", $strXML, "chart1", 500, 300, false, false) . "</td>";
echo "</tr></table>";

?>

<table class="data-table">
	<th>Districts Submitting Late Reports</th>
	<th>District</th><th>Reporting Date</th><th>Deadline</th>
</table>