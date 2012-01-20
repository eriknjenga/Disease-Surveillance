<?php 
include('header2.php');

$sessionuserid = $_SESSION['id']; 
$sessionaccounttype = $_SESSION['accounttype']; 

$districtdetails = GetDistrictInfo($sessionaccounttype);

$districtname = $districtdetails['name'];

$year = $_GET['year'];

if ($year == '') {$year = date('Y');}
else if ($year != '') {$year = $year;}
?>
		
		<table width="100%" cellpadding="5" cellspacing="5">
		<tr><td width="55%">
		<div class="section-title">Kenya Summary as of <?php echo $year;?></div>
		<div id="mapDiv">
			The map will replace this text. If any users do not have Flash Player 8 (or above), they'll see this message.
		</div>
		<script type="text/javascript">
			var map = new FusionMaps("FusionMaps/Maps/FCMap_Kenya.swf", "KenyaMap", "670", "400", "0", "0");
			
			map.setDataURL("xml/map.xml");
			map.render("mapDiv");
		</script>
		</td>
		<td valign="top">
		<div class="section-title">National Statistics</div>
		<table width="100%" height="100%" border="0"  cellpadding="0" cellspacing="0">
  <tr>
    <td ><span class="style8"># of Expected Reports</span></td>
    <td ><span class="style8">14,000</span></td>
  </tr>
  <tr>
    <td><span class="style8"># of Reports Received</span></td>
    <td> <span class="style8">985  [  4.9 %  ]</span></td>
  </tr>
  <tr>
    <td><span class="style8">Overall Reporting Rate</span></td>
    <td> <span class="style8">438  [  35 %  ]</span></td>
  </tr>
<!--<tr><td> <br /><br /><br />&nbsp;</td></tr> -->
<tr>
	<td ><div class="section-title">% Overall Reporting Rate</div>
	<div id="chartdiv2" align="center"> Overall Reporting </div>
			<script type="text/javascript"> 
		var myChart = new FusionCharts("FusionWidgets/Charts/AngularGauge.swf", "myChartId", "285", "150", "0", "0");
		myChart.setDataURL("xml/coverage.xml");
		myChart.render("chartdiv2");
	   </script> 
	</td>
	<td ><div class="section-title">% Timeliness of Reporting Rate</div>
	<div id="chartdivr" align="center">  Timely Reporting </div>
			<script type="text/javascript"> 
		var myChart = new FusionCharts("FusionWidgets/Charts/AngularGauge.swf", "myChartId", "285", "150", "0", "0");
		myChart.setDataURL("xml/coverage.xml");
		myChart.render("chartdivr");
	   </script> 
	</td>
</tr>

<tr><td> <br /><br /><br /><br />&nbsp;</td></tr> 

</table></td>
		</tr>
		</table>
		<table width="100%" cellpadding="5" cellspacing="5">
		<tr>
		   <td valign="top"> 
		<div class="section-title">Under 5 Years Disease Surveillance </div>	
      <div id="chartdiv22" align="center">  Under 5 Years Disease Surveillance </div>
		<script type="text/javascript"> 
			var myChart = new FusionCharts("FusionCharts/stackedcolumn2d.swf", "myChartId", "500", "250", "0", "0");
			myChart.setDataURL("xml/diseasecaseover.php");
			myChart.render("chartdiv22");
		 </script> </td>
		   <td valign="top"> 
		<div class="section-title">Above 5 Years Disease Surveillance </div>	
      <div id="chartdiv3" align="center">  Above 5 Years Disease Surveillance </div>
		<script type="text/javascript"> 
			var myChart = new FusionCharts("FusionCharts/stackedcolumn2d.swf", "myChartId", "500", "250", "0", "0");
			myChart.setDataURL("xml/diseasecasebelow.php");
			myChart.render("chartdiv3");
		 </script> </td>
		</tr>
		</table>
		
		</div>

		<div class="clearer">&nbsp;</div>

	</div>

	<div id="footer">

		<div class="right" id="footer-right">
			
		 <p>&copy; 1987-2010 MOHCW.ZW All rights Reserved</p>

			<p class="quiet"></p>
			
			<div class="clearer">&nbsp;</div>

		</div>


		<div class="clearer">&nbsp;</div>

	</div>

</div>

</body>
</html>