<?php
require_once('/connection/config.php');
$link = 'confirmed_diseases';
include('national_header.php');

$year = date('Y');
$disease = 5;
?>
<script type="text/javascript">
$(document).ready(function() {
 
	   $(".Disease").change(function() { 
		   var years = $(".Disease_Year");
		   var year = "";
		   for(x=0; x<years.size();x++){
			   var current = $(years[x]).css("font-weight"); 
			   if(current=="bold"){
				   year = years[x].id;
			   } 
		   }
		   
		   var disease = $("#Disease").attr('value'); 
		   var url = "xml/confirmed_diseases.php?parameters="+disease+"_"+year+"";
		   var chart = new FusionCharts("FusionCharts/Charts/Line.swf", "ChartId", "900", "550", "0", "1");
		   chart.setDataURL(url);	
		   chart.addParam("WMode", "Transparent");	   
		   chart.render("Confirmed_Diseases_Chart");
	   });
	   $(".Disease_Year").click(function() { 
		   var chosen = $(this).css("font-weight");
		   if(chosen == "normal"){
		   $(".Disease_Year").css("font-weight","normal");
		   $(this).css("font-weight","bold");		   
		   var disease = $("#Disease").attr('value');
		   var year = this.id;
		   var url = "xml/confirmed_diseases.php?parameters="+disease+"_"+year+"";
		   var chart = new FusionCharts("FusionCharts/Charts/Line.swf", "ChartId", "900", "550", "0", "1");
		   chart.setDataURL(url);	
		   chart.addParam("WMode", "Transparent");	   
		   chart.render("Confirmed_Diseases_Chart");
		   }
	   });
 
 
		
	 });

 
 
 
</script>
<style type="text/css">
select {
	width: 250;
} 
.chart_container{
	border-left: 2px solid #DDD;
	border-bottom: 2px solid #DDD;
	border-right: 2px solid #DDD;
	padding: 3px;
	margin-bottom:15px;
	width:950px;
		margin-left:auto;
	margin-right:auto
}
  
 
 

</style>
 

<div class="xtop">
<div id="left_container">
<div class="section-title">Laboratory Confirmed Cases</div>
<table>
			<tr>
			
			<td><a href="RR_Trends.php">Average RR Trends</a> | <a href="Confirmed_Diseases.php">Laboratory Confirmed Cases</a> | <a href="Fatality_Rates.php">Case Fatality Rates</a> </td>
			
			</td>
			
			
			</tr>
			
			</table>

<div id = "Confirmed_Diseases" class="chart_container">
	Disease: <select name="Disease" id="Disease" class="Disease">
		<?php
		$sql_diseases = "SELECT * from Diseases";
		$sql_result_diseases = mysql_query($sql_diseases) or die(mysql_error());
		$diseases = array();	
		while($disease_resultset = mysql_fetch_assoc($sql_result_diseases)){
		$diseases[$disease_resultset['id']] = $disease_resultset['name'];
			if($disease == $disease_resultset['id']){?>
					<option value=<?php echo $disease_resultset['id']?> selected><?php echo  $disease_resultset['name']?>
					</option>
				<?php }
				else{
				?>
					<option value=<?php echo $disease_resultset['id']?>><?php echo $disease_resultset['name']?>
					</option>
				<?php
				}					
			mysql_data_seek($sql_result_diseases);
		}
		?>
	</select>
 Year:
	<?php
	$sql_year = "SELECT distinct datecreated from surveillance order by datecreated desc";
	$sql_result_year = mysql_query($sql_year) or die(mysql_error());
	$years= array();

	while($year_resultset = mysql_fetch_assoc($sql_result_year)){
		$year_array = explode('-',$year_resultset['datecreated']);
		$years[$year_array[0]] = $year_array[0];	
		mysql_data_seek($sql_result_year);
	}
 
		foreach($years as $year_object){ 
		if($year == $year_object){?>
		<a class="Disease_Year" id=<?php echo $year_object?> style="color:#00849E; font-weight:bold"> <?php echo  $year_object?> </a>
			 
		<?php }
		else{
		?>
			<a class="Disease_Year" id=<?php echo $year_object?> style="color:#00849E"> <?php echo  $year_object?> </a>
		<?php
		}	
	}
	?>
 
 

	<div id="Confirmed_Diseases_Chart" style="z-index: -20">
	</div>
</div>
</div>

 

<script type="text/javascript">
   var chart = new FusionCharts("FusionCharts/Charts/Line.swf", "ChartId", "900", "550", "0", "1");
   chart.setDataURL("xml/confirmed_diseases.php");	
   chart.addParam("WMode", "Transparent");	   
   chart.render("Confirmed_Diseases_Chart");
</script>
 
</div>
</div>

	<?php include('footer.php');?>