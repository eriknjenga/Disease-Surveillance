<?php 
include('/connection/authenticate.php');
require_once('/connection/config.php');
include('header2.php');

$sessionuserid = $_SESSION['id']; 
$sessionaccounttype = $_SESSION['accounttype']; 

$districtdetails = GetDistrictInfo($sessionaccounttype);

$districtname = $districtdetails['name'];

?>
	<script language="JavaScript" src="scripts/FusionMaps.js"></script>
	<script language="JavaScript" src="scripts/FusionCharts.js"></script>

<div  class="section">
		
	    <table  border="0"  width="85%" cellpadding="5" cellspacing="5">
    <tr>
    
    <td valign="top" colspan="6" > <div class="section-title">Disease Fatality Rate</div>
	<form name="trial">
	<div>Select Disease 
	  <?php
				  	$drugtype = "SELECT id,name FROM diseases";
						
					$result = mysql_query($drugtype) or die('Error, query failed'); //onchange='submitForm();'
				
				  	echo "<select name='disease' ;>\n";
					echo " <option value=''> Select One </option>";
					
					  while ($row = mysql_fetch_array($result))
					  {
							 $ID = $row['id'];
							$type = $row['name'];
						echo "<option value='$ID'> $type</option>\n";
					  }
					  
					echo "</select>\n";
				  ?>
	  
	&nbsp;&nbsp;|&nbsp;&nbsp; Select Province 
	  <?php
				  	$drugtype = "SELECT ID,name FROM provinces";
						
					$result = mysql_query($drugtype) or die('Error, query failed'); //onchange='submitForm();'
				
				  	echo "<select name='province' ;>\n";
					echo " <option value=''> Select One </option>";
					
					  while ($row = mysql_fetch_array($result))
					  {
							 $ID = $row['ID'];
							$type = $row['name'];
						echo "<option value='$ID'> $type</option>\n";
					  }
					  
					echo "</select>\n";
				  ?>
    
		<input type="submit" name="graph" value="Show Graph" class="button" />
		</div>
	</form>
	<?php 
		if ($_REQUEST['graph'])
		{
		?>
				<div id="chartdiv1" align="center">  Coverage </div>
				<script type="text/javascript"> 
					var myChart = new FusionCharts("FusionCharts/msline.swf", "myChartId", "800", "250", "0", "0");
					myChart.setDataURL("xml/fatalityrate.php");
					myChart.render("chartdiv1");
				 </script> 
				 </td>
   <!--///////////////////////////////////////////////////// -->
  </tr>
  <tr>
    <td valign="top"> <div class="section-title">Under 5 Years Fatality Rate </div>	
      <div id="chartdiv2" align="center">  Under 5 Years Disease Surveillance </div>
		<script type="text/javascript"> 
			var myChart = new FusionCharts("FusionCharts/msline.swf", "myChartId", "500", "250", "0", "0");
			myChart.setDataURL("xml/fatalcaseover.php");
			myChart.render("chartdiv2");
		 </script>	</td>
		
	<!--//////////////////////////////////////////////////////////////////// -->
	
    <td valign="top"> <div class="section-title">Above 5 Years Fatality Rate </div>	
      <div id="chartdiv3" align="center">  Above 5 Years Disease Surveillance </div>
		<script type="text/javascript"> 
			var myChart = new FusionCharts("FusionCharts/msline.swf", "myChartId", "500", "250", "0", "0");
			myChart.setDataURL("xml/fatalcasebelow.php");
			myChart.render("chartdiv3");
		 </script>	</td>
  </tr>
		<?php
		}
		?>   
</table>
	
 <?php include('footer.php');?>