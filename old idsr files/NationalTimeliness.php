<?php
$link = 'home';
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

if (isset($_GET['epiweek'])) {
	$epiweek = $_GET['epiweek'];
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		var chart = new FusionCharts("FusionCharts/MSLine.swf", "trends_graph", "470", "300", "0", "0");
		chart.setDataURL("TrendTimeliness.php");
		chart.render("trends_graph");

		var chart = new FusionCharts("FusionCharts/Line.swf", "timeliness_graph", "470", "300", "0", "0");
		chart.setDataURL("NationalTimeliness_XML.php");
		chart.render("timeliness_graph");
	});

</script>
<style "text/css">
	#filter_box {
		border: 2px solid #CFCFCF;
		width: 700px;
		margin: 0 auto;
	}
	.dashboard_box {
		width: 470px;
		float: left;
		margin: 5px;
		border-right: 1px solid #CFCFCF;
		border-left: 1px solid #CFCFCF;
	}
	#dashboard_container {
		width: 980px;
		margin: 0 auto;
	}
</style>
<div id="filter_box">
	<form action="NationalTimeliness.php?epiweek=<?php echo $_GET['epiweek'];?>" method="get" name="NationalTimeliness">
		<table>
			<tr>
				<td> Select Epiweek: </td>
				<td>
				<select name="epiweek">
					<?php
					$epiweeksql = mysql_query("select distinct epiweek from surveillance where date = '" . date('Y') . "' order by epiweek DESC");
					while ($epires = mysql_fetch_assoc($epiweeksql)) {
						if ($_GET['epiweek'] == $epires[epiweek]) {
							echo "<option selected value=$epires[epiweek]>" . $epires['epiweek'];
						} else {
							echo "<option value=$epires[epiweek]>" . $epires['epiweek'];
						}
					}
					?>
					</option>
				</select></td>
				<td> Select Filter Level: </td>
				<td>
				<select name="province">
					<?php
					$province = mysql_query("select id,name from provinces");
					while ($prores = mysql_fetch_assoc($province)) {
						echo "<option value=$prores[id]>" . $prores['name'];
					}
					?>
					</option>
				</select></td>
				<td>
				<input type="submit" name="submit" value="Filter Dashboard" class="button"/>
				</td>
		</table>
	</form>
</div>
<div id="dashboard_container">
	<div class="dashboard_box" id="timeliness_graph"></div>
	<div class="dashboard_box" id="trends_graph"></div>
	<div class="dashboard_box" id="pie_chart">
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

		}//end else
		?>
	</div>
	<div class="dashboard_box" id="pie_chart">
		<table>
			<tr>
				<td class="text"><div id="chartdiv2"></div></td>
				<td valign="top" class="text" align="center">
				<table class="data-table" valign="top" title="National Statistics">
					<b>National Statictics for epiweek <?php echo $_GET['epiweek'];?></b>
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
					?>
			</tr>
			<td> Total Districts </td>
			<td><?php echo $districtCount;?></td>
			<tr>
				<td> Total Reporting Districts </td>
				<td><?php echo $districtSurveyedCount;?></td>
			</tr>
			<tr>
				<td> Reporting Percentage </td>
				<td><?php echo floor(($districtSurveyedCount / $districtCount) * 100);?>%

</td>
</tr>
<tr>
<td>
Timeliness Percentage
</td>
<td>
<?php echo floor(($districtTimeliness / $districtCount) * 100);?></td>
			</tr>
		</table>
		</td>
		</tr>
		</table>
	</div>
</div>
<?php
$sqlFetchDistricts = mysql_query("SELECT name FROM districts WHERE id NOT IN(SELECT DISTINCT district FROM surveillance WHERE epiweek = '" . $_GET['epiweek'] . "')") or die(mysql_error());
?>
<div id="non-reporting districts">
	<table class="data-table">
		<th>Non Reporting Districts for Epiweek <?php echo $_GET['epiweek'];?></th>
		<?php
		while ($fetchDistrictResults = mysql_fetch_assoc($sqlFetchDistricts)) {
			$nonReporters = $fetchDistrictResults['name'];
			echo "<tr><td>$nonReporters</td></tr>";
		}//end while
		?>
	</table>
</div>
