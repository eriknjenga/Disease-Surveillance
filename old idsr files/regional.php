<?php 
include('header2.php');

$sessionuserid = $_SESSION['id']; 
$sessionaccounttype = $_SESSION['accounttype']; 

$mwaka=$_GET['year'];
$mwezi=$_GET['mwezi'];

$displaymonth=GetMonthName($mwezi);
if (isset($mwaka))
{
	if (isset($mwezi))
	{
	$defaultmonth=$displaymonth .' - '.$mwaka ; //get current month and year
	$currentmonth=$mwezi;
	$currentyear=$mwaka;
	
	}
	else
	{
	$defaultmonth=$mwaka ; //get current month and year
	$currentmonth=0;
	//get current month and year
	$currentyear=$mwaka;
	
	
	
	}
}
else
{
$defaultmonth=date("M-Y"); //get current month and year
$currentmonth=date("m");
$currentyear=date("Y");
}

$province=$_GET['province']; // Use this line or below line if register_global is off

$provincequery=mysql_query("select Name from provinces where ID='$province'")or die(mysql_error());
$provarray=mysql_fetch_array($provincequery);
$provincename=$provarray['Name'];

if ($_REQUEST['districtfilter'])
{
$dcode=$_POST['dcode']; // Use this line or below line if register_global is off
$dname=GetDistrictName($dcode);

if ($dcode !="")
{
$dist= ",". '<u>'.$dname . " District" .'</u>';
}
else
{
$dist="";


}
//echo "District: ".$dname . " - ".$currentyear ." / " .$currentmonth;
}
if ($_REQUEST['facilityfilter'])
{
//$fcode=$_POST['fcode']; // Use this line or below line if register_global is off
$fcode=  $_POST['cat'];
$fname=GetFacilityName($fcode);
//facility

if ($fcode !="")
{
$dist= ",". '<u>'.$fname .'</u>';
}
else
{
$dist="";


}
//echo "Facility: ".$fname . " - ".$currentyear ." / " .$currentmonth;

if (!(isset($fcode)))
{
$fcode=0;
}
if (!(isset($dcode)))
{
$dcode=0;
}
 
}
?>
<script type="text/javascript" src="includes/jquery.min.js"></script>
<script type="text/javascript" src="includes/jquery.js"></script>
<script type='text/javascript' src='includes/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="includes/jquery.autocomplete.css" />
<script type="text/javascript">
$().ready(function() {
	
	$("#facility").autocomplete("get_facility.php?prov=<?php echo $province; ?>", {
		width: 260,
		matchContains: true,
		mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	
	$("#facility").result(function(event, data, formatted) {
		$("#fcode").val(data[1]);
	});
});
</script>
<script type="text/javascript">
$().ready(function() {
	
	$("#district").autocomplete("get_district.php?prov=<?php echo $province; ?>", {
		width: 260,
		matchContains: true,
		mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	
	$("#district").result(function(event, data, formatted) {
		$("#dcode").val(data[1]);
	});
});
</script>

	<script language="JavaScript" src="scripts/FusionMaps.js"></script>
	<script language="JavaScript" src="scripts/FusionCharts.js"></script>
<script>
		window.dhx_globalImgPath="../img/";
	</script>
<script src="dhtmlxcombo_extra.js"></script>
 <link rel="STYLESHEET" type="text/css" href="dhtmlxcombo.css">
  <script src="dhtmlxcommon.js"></script>
  <script src="dhtmlxcombo.js"></script>

<form method="post" name="f3" action="">
		   <table width="1001" border="0" cellpadding="2" cellspacing="2">
             <tr valign="top"> 			
               <td colspan="2" class="xtop"> <a href="regional.php">All </a>  |  <a href="regional.php?province=<?php echo 5;?>&mwezi=<?php echo $currentmonth;?>&year=<?php echo $currentyear;?>">Nairobi </a>  |  <a href="regional.php?province=<?php echo 1;?>&mwezi=<?php echo $currentmonth;?>&year=<?php echo $currentyear;?>">Central </a>  |   <a href="regional.php?province=<?php echo 2;?>&mwezi=<?php echo $currentmonth;?>&year=<?php echo $currentyear;?>">Coast </a>  |   <a href="regional.php?province=<?php echo 3;?>&mwezi=<?php echo $currentmonth;?>&year=<?php echo $currentyear;?>">Eastern </a>  |  <a href="regional.php?province=<?php echo 6;?>&mwezi=<?php echo $currentmonth;?>&year=<?php echo $currentyear;?>">North Eastern </a>  |   <a href="regional.php?province=<?php echo 9;?>&mwezi=<?php echo $currentmonth;?>&year=<?php echo $currentyear;?>">Western</a>  |  <a href="regional.php?province=<?php echo 7;?>&mwezi=<?php echo $currentmonth;?>&year=<?php echo $currentyear;?>">Nyanza </a>  |  <a href="regional.php?province=<?php echo 8;?>&mwezi=<?php echo $currentmonth;?>&year=<?php echo $currentyear;?>">Rift Valley </a>		       </td>
             </tr>
             <tr>
               <td width="600">
			   

<table cellspacing="2" cellpadding="2" border="0">
<tr>
	<td> District </td>
	<td><select  style="width:210px"  id='dcode' name="dcode">
    
  </select>  
  <script>
    var combo = dhtmlXComboFromSelect("dcode");
	combo.enableFilteringMode(true,"getprovincedistrict.php?province=<?php echo $province; ?>",true);
	

</script></td> 
<td><input type="submit" name="districtfilter" value="Filter" class="button"/></td> 
	<td> Facility </td>
	<td><select  style="width:210px"  id='cat' name="cat">
    
  </select>  
  <script>
    var combo = dhtmlXComboFromSelect("cat");
	combo.enableFilteringMode(true,"getprovincefacility.php?province=<?php echo $province; ?>",true);
	

</script></td> 
<td><input type="submit" name="facilityfilter" value="Filter" class="button"/></td> 
</tr>
</table>

<div  class="section">
		
	    <table  border="0"  width="85%" cellpadding="5" cellspacing="5">
    <tr>
    
    <td valign="top" colspan="" > <div class="section-title">Cases Surveillance by Disease for  <?php echo $defaultmonth;?> </div>
      <div id="chartdiv1" align="center">  Coverage </div>
		<script type="text/javascript"> 
			var myChart = new FusionCharts("FusionCharts/stackedcolumn2d.swf", "myChartId", "750", "450", "0", "0");
			myChart.setDataURL("xml/diseasecase.php");
			myChart.render("chartdiv1");
		 </script> 
   </td>
   <!--///////////////////////////////////////////////////// -->
  <td>
		<table width="100%" height="100%" border="0"  cellpadding="0" cellspacing="0">
		<!--<tr><td> <br /><br /><br />&nbsp;</td></tr> -->
		<tr>
			<td ><div class="section-title">% Overall Reporting Rate</div>
			<div id="chartdiv12" align="center"> Overall Reporting </div>
			<script type="text/javascript"> 
			var myChart = new FusionCharts("FusionWidgets/Charts/AngularGauge.swf", "myChartId", "285", "150", "0", "0");
			myChart.setDataURL("xml/coverage.xml");
			myChart.render("chartdiv12");
			</script>		
			</td>
		</tr>
		<tr>
		<td ><div class="section-title">% Timeliness of Reporting Rate</div>
		<div id="chartdivr" align="center">  Timely Reporting </div>
		<script type="text/javascript"> 
		var myChart = new FusionCharts("FusionWidgets/Charts/AngularGauge.swf", "myChartId", "285", "150", "0", "0");
		myChart.setDataURL("xml/coverage.xml");
		myChart.render("chartdivr");
		</script>		</td>
		</tr>
		
		<tr><td> <br /><br /><br />&nbsp;</td></tr> 
		</table>
  </td>
  </tr>
  <tr>
    <td valign="top"> <div class="section-title">Under 5 Years Disease Surveillance </div>	
      <div id="chartdiv2" align="center">  Under 5 Years Disease Surveillance </div>
		<script type="text/javascript"> 
			var myChart = new FusionCharts("FusionCharts/stackedcolumn2d.swf", "myChartId", "500", "300", "0", "0");
			myChart.setDataURL("xml/diseasecaseover.php");
			myChart.render("chartdiv2");
		 </script> 
	</td>
		
	<!--//////////////////////////////////////////////////////////////////// -->
	
    <td valign="top" colspan="3"> <div class="section-title">Above 5 Years Disease Surveillance </div>	
      <div id="chartdiv3" align="center">  Above 5 Years Disease Surveillance </div>
		<script type="text/javascript"> 
			var myChart = new FusionCharts("FusionCharts/stackedcolumn2d.swf", "myChartId", "500", "300", "0", "0");
			myChart.setDataURL("xml/diseasecasebelow.php");
			myChart.render("chartdiv3");
		 </script> 
	</td>
  </tr>
</table>
	
 <?php include('footer.php');?>