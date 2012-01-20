<?php 
include('/connection/authenticate.php');
require_once('/connection/config.php');
include('header.php');

$sessionuserid = $_SESSION['id']; 
$sessionaccounttype = $_SESSION['accounttype']; 

$districtdetails = GetDistrictInfo($sessionaccounttype);

$districtname = $districtdetails['name'];

?>
	<script language="JavaScript" src="scripts/FusionMaps.js"></script>
	<script language="JavaScript" src="scripts/FusionCharts.js"></script>

<div  class="section">
		<div class="section-title"><?php echo strtoupper($districtname);?> DISTRICT DASHBOARD FOR THE YEAR</div>
	    <table  border="0"  width="85%" cellpadding="5" cellspacing="5">
    <tr>
    
    <td valign="top" colspan="6" > <div class="section-title">Cases Surveillance by Disease </div>
      <div id="chartdiv1" align="center">  Coverage </div>
		<script type="text/javascript"> 
			var myChart = new FusionCharts("FusionCharts/stackedcolumn2d.swf", "myChartId", "800", "250", "0", "0");
			myChart.setDataURL("xml/diseasecase.php");
			myChart.render("chartdiv1");
		 </script> 
   </td>
   <!--///////////////////////////////////////////////////// -->
   
  </tr>
  <tr>
    <td valign="top"> <div class="section-title">Under 5 Years Disease Surveillance </div>	
      <div id="chartdiv2" align="center">  Under 5 Years Disease Surveillance </div>
		<script type="text/javascript"> 
			var myChart = new FusionCharts("FusionCharts/stackedcolumn2d.swf", "myChartId", "500", "250", "0", "0");
			myChart.setDataURL("xml/diseasecaseover.php");
			myChart.render("chartdiv2");
		 </script> 
	</td>
		
	<!--//////////////////////////////////////////////////////////////////// -->
	
    <td valign="top"> <div class="section-title">Above 5 Years Disease Surveillance </div>	
      <div id="chartdiv3" align="center">  Above 5 Years Disease Surveillance </div>
		<script type="text/javascript"> 
			var myChart = new FusionCharts("FusionCharts/stackedcolumn2d.swf", "myChartId", "500", "250", "0", "0");
			myChart.setDataURL("xml/diseasecasebelow.php");
			myChart.render("chartdiv3");
		 </script> 
	</td>
  </tr>
</table>
	
 <?php include('footer.php');?>