<?php
$link = 'home';
include 'ReadOnlyHeader.php';
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

if (isset($_GET['epiweek'])) {
    $epiweek = $_GET['epiweek'];
}
?>
<form action="NationalTimeliness.php?epiweek=<?php echo $_GET['epiweek']; ?>" method="get" name="NationalTimeliness">
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
                    <select name="province">

                        <?php
                        $province = mysql_query("select id,name from provinces");
                        while ($prores = mysql_fetch_assoc($province)) {
                            echo "<option value=$prores[id]>" . $prores['name'];
                        }
                        ?></option>
                    </select>
                </td>
                <td>

                </td>
            </tr>     
    </div>

</form>


<tr> 
    <td class="text"> <div id="chartdiv2"> 
        </div>
        <script type="text/javascript">
            var chart = new FusionCharts("FusionCharts/MSLine.swf", "chartdiv2", "500", "300", "0", "0");
            chart.setDataURL("NationalTimeliess.php");		   
            chart.render("chartdiv2");
        </script> </td>

    <td valign="top" class="text" align="center">
        <table class="data-table" valign="top" title="National Statistics">
            <b>National Statictics for epiweek <?php echo $_GET['epiweek']; ?></b>
            <th>Total Districts</th>                
            <th>Total Reporting Districts</th>
            <th>Reporting Percentage in %</th>
            <th>Timeliness Percentage</th>                


            <?php
            $sqlGetDistricts = mysql_query("SELECT COUNT( (districts.id) ) as districts FROM districts, provinces WHERE districts.province = provinces.id");
            $districtResults = mysql_fetch_array($sqlGetDistricts);

            $sqlGetSurveyedDistricts = mysql_query("SELECT COUNT( distinct(surveillance.district) ) as surveyed FROM surveillance, districts WHERE surveillance.district = districts.id and epiweek = '" . $_GET['epiweek'] . "' ");
            $districtSurveyedResults = mysql_fetch_array($sqlGetSurveyedDistricts);

            $timeliness = mysql_query("SELECT COUNT( distinct(surveillance.district) ) as timeliness FROM surveillance, districts WHERE surveillance.district = districts.id and epiweek = '" . $_GET['epiweek'] . "' and datemodified > (select deadline from deadlines where epiweek = '" . $_GET['epiweek'] . "') ");
            $districtTimeliness = mysql_fetch_array($timeliness);


            $districtCount = $districtResults['districts'];
            $districtTimeliness = $districtTimeliness['timeliness'];
            $districtSurveyedCount = $districtSurveyedResults['surveyed'];

            echo "<tr><td>" . $districtCount . "</td><td>" . $districtSurveyedCount . "</td><td>" . floor(($districtSurveyedCount / $districtCount) * 100) . "%" . "</td><td>" . floor(($districtTimeliness / $districtCount) * 100) . "</td></tr>";
            ?>
</tr>
</table>
</td>
</tr>
<tr>
    <td valign="top" class="text" align="center"></td>
    <td valign="top" class="text" align="center"></td>
</tr>
<tr>
    <td valign="top" class="text" align="center"></td>
    <td valign="top" class="text" align="center"></td>
</tr>
<tr>
    <td valign="top" class="text" align="center"></td>
    <td valign="top" class="text" align="center"></td>
</tr>
<tr>
    <td valign="top" class="text" align="center"></td>
    <td valign="top" class="text" align="center"></td>
</tr>
<tr>
    <td valign="top" class="text" align="center"></td>
    <td valign="top" class="text" align="center"></td>
</tr>
<tr><td>
        <?php
        if ($_REQUEST['submit']) {
            $namesnids = array();
            $testSql = "SELECT count( DISTINCT (district) ) AS Submitters,provinces.name as Names from surveillance,provinces,districts where provinces.id = districts.province and surveillance.district = districts.id and provinces.id = '" . $_GET['province'] . "' and epiweek= '" . $_GET[epiweek] . "' ";
            $districtsquery = mysql_query("select count(id) as expected from districts where province = '" . $_GET['province'] . "'");
            $districtres = mysql_fetch_assoc($districtsquery);
            $testBuffer = mysql_query($testSql) or die(mysql_error());
            $counter = 0;
            while ($testResult = mysql_fetch_array($testBuffer)) {
                $namesnids[$counter][1] = $testResult['Names'];
                $namesnids[$counter][2] = $testResult['Submitters'];
                $counter++;
            }


            echo "<p align=center><b> Number of Reporting Districts with respect to Province For Epiweek $_GET[epiweek]</b></p>";
            $strXML = "<chart formatNumberScale='0' bgColor='ffffff' showBorder='0'>";
            foreach ($namesnids as $names) {
                $strXML .= "<set label='" . $names[1] . "' value='" . $names[2] . "' />";
                $strXML .= "<set label='" . $names[1] . "' value='" . ($districtres['expected'] - $names[2]) . "' />";
            }

            $strXML .= "</chart>";

            echo renderChart("FusionCharts/Pie2D.swf", "", $strXML, "chart3", 500, 300, false, false);
        } else {
            $namesnids = array();
            $testSql = "SELECT COUNT( DISTINCT (district) ) AS Submitters FROM surveillance, provinces, districts WHERE provinces.id = districts.province AND surveillance.district = districts.id AND epiweek ='".$_GET['epiweek']."' ";
            $districtsquery = mysql_query("select count(id) as expected from districts");
            $districtres = mysql_fetch_assoc($districtsquery);
            $testBuffer = mysql_query($testSql) or die(mysql_error());
            $erickofala = 0;
            while ($testResult = mysql_fetch_array($testBuffer)) {
                $namesnids[$erickofala][1] = $testResult['Names'];
                $namesnids[$erickofala][2] = $testResult['Submitters'];
                $erickofala++;
            }


            echo "<p align=center><b> Natioanl Reporting Statistics For Epiweek $_GET[epiweek]</b></p>";
            $strXML = "<chart formatNumberScale='0' bgColor='ffffff' showBorder='0'>";
            foreach ($namesnids as $names) {
                $strXML .= "<set label='" . $names[1] . "' value='" . $names[2] . "' />";
                $strXML .= "<set label='" . $names[1] . "' value='" . ($districtres['expected'] - $names[2]) . "' />";
            }

            $strXML .= "</chart>";

            echo renderChart("FusionCharts/Pie2D.swf", "", $strXML, "chart3", 500, 300, false, false);
        }//end else
        ?></td>



    <td valign="top" class="text" align="center"><div id="chartdivx" align="center"> 
        </div>     <script type="text/javascript">
            var chart = new FusionCharts("FusionCharts/MSLine.swf", "chartdivx", "500", "300", "0", "0");
            chart.setDataURL("TrendTimeliness.php");		   
            chart.render("chartdivx");
        </script></td>
</tr>
</table>
