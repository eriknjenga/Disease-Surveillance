<?php 
include('/connection/authenticate.php');
require_once('/connection/config.php');
include('header3.php');

$sessionuserid = $_SESSION['id']; 
$sessionaccounttype = $_SESSION['accounttype']; 
$autocode=$_GET['q']; //facility code
$savedcommunity=$_GET['p'];

$districtdetails = GetDistrictInfo($sessionaccounttype);
$districtname = $districtdetails['name'];

$typequery=mysql_query("SELECT name as tname FROM diseasetypes where id ='1' ")or die(mysql_error()); 
$tdd=mysql_fetch_array($typequery);
$tname=$tdd['tname'];

$ttypequery=mysql_query("SELECT name as ttname FROM diseasetypes where id ='2' ")or die(mysql_error()); 
$ttdd=mysql_fetch_array($ttypequery);
$ttname=$ttdd['ttname'];
?>
	<script language="JavaScript" src="scripts/FusionMaps.js"></script>
	<script language="JavaScript" src="scripts/FusionCharts.js"></script>
	

	<table >
	<tr>
	<td colspan='5' valign="top">
	
	<div class="section-title">Submitted Samples for Lab Analysis </div>
      <div id="chartdiv1" align="center">  Coverage </div>
	  <script type="text/javascript"> 
			var myChart = new FusionCharts("FusionCharts/MSBar2D.swf", "myChartId", "800", "350", "0", "0");
			myChart.setDataURL("xml/labreceived.php");
			myChart.render("chartdiv1");
		 </script> </td>
	
	
	
	</tr>
	
	<tr bgcolor="#FAFAFA"><td class="subsection-title">Pending Tasks</td>
	<tr >
	<td >
<div class="notice">
Submitted Weekly Forms [ <a href="#">45</a> ] </div>
</td>

</tr>

	
		<tr ><td ><div class="notice">Submitted Case Based Forms [ <a href="#">85</a> ]
</div>

</td>

</tr>
		
	
	<tr ><td ><div class="notice">Submitted Line List Forms [ <a href="#">35</a> ]
</div>

</td>

</tr>
		
		
	</table>	

	<!--End Pending Tasks Div -->
				
</div>

		
 <?php include('footer.php');?>