<?php
$link = 'rr_trends';
require_once('/connection/config.php');
include('national_header.php');

$year = date('Y');
$disease = 5;
?>
<script type="text/javascript">
$(document).ready(function() {
	getReports();
	   $(".RR_Year").click(function() { 
		   var chosen = $(this).css("font-weight");
		   if(chosen == "normal"){
		   $(".RR_Year").css("font-weight","normal");
		   $(this).css("font-weight","bold");
		   var year = this.id;
		   var chart = new FusionCharts("FusionCharts/Charts/MSLine.swf", "ChartId", "900", "550", "0", "1");
		   chart.setDataURL("xml/RR_Trends.php?year="+year);	
		   chart.addParam("WMode", "Transparent");	   
		   chart.render("RR_Trends_Chart");
		   }
	   });
	    
	   $(".Reporting_Year").change(function() { 
			getReports();
	   });
	   $(".Reporting_Epiweek").change(function() { 
		   getEpiweekReport();
	   });
	 });
function getReports(){
   	var year_chosen = $("#Reporting_Year").attr('value');
	$.get('get_epiweeks.php',{ year: year_chosen }, function(data) {
		  $('.Reporting_Epiweek').html(data);
		  $(".Reporting_Epiweek").change();
	});
		
}
function getEpiweekReport(){
	
   	var year_chosen = $("#Reporting_Year").attr('value');
   	var epiweek_chosen = $("#Reporting_Epiweek").attr('value');
	$.get('get_epiweek_report.php',{ year: year_chosen, epiweek:epiweek_chosen }, function(data) {
		  $('#Reporting_Year_Chart').html(data);
	});	
}
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
 
.xtop{
min-width:1300px;
}
#Larger_Graph{
width:900px;
}
 

</style>

<div class="section"> 

<div class="xtop">
<div id="left_container">
<div class="section-title">National Reporting Performance</div>
<table>
			<tr>
			
			<td><a href="RR_Trends.php">Average RR Trends</a> | <a href="Confirmed_Diseases.php">Laboratory Confirmed Cases</a> | <a href="Fatality_Rates.php">Case Fatality Rates</a> </td>
			
			</td>
			
			
			</tr>
			
			</table>
<div id="Reporting_Performance" class="chart_container">
 

Year: <select name="Reporting_Year" id="Reporting_Year" class="Reporting_Year">
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
			<option value=<?php echo $year_object?> selected><?php echo  $year_object?>
			</option>
		<?php }
		else{
		?>
			<option value=<?php echo $year_object?>><?php echo $year_object?>
			</option>
		<?php
		}	
	}
	?>
</select>
 
 
Epiweek:<select name="Reporting_Epiweek" id="Reporting_Epiweek" class="Reporting_Epiweek">
</select>
<div id="Reporting_Year_Chart">
</div>

</div>
<div class="section-title">Provincial Average Intra-Province RR Trends</div>
<div id="RR_Trends" class="chart_container">
Year
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
		?>
		<a class="RR_Year" id=<?php echo $year_object?> style="color:#00849E"> <?php echo  $year_object?> </a>
		<?php
	
	}
	?>
<div id="RR_Trends_Chart" style="z-index: -20"></div>
</div>


 
</div>
 

	

 <script type="text/javascript">
   var chart = new FusionCharts("FusionCharts/Charts/MSLine.swf", "ChartId", "900", "550", "0", "1");
   chart.setDataURL("xml/RR_Trends.php");	
   chart.addParam("WMode", "Transparent");	   
   chart.render("RR_Trends_Chart");
</script>	

</div>
</div>

	<?php include('footer.php');?>