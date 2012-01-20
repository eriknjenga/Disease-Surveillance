<?php
error_reporting(0);
require_once('/connection/config.php');
include('national_header2.php');

$year = date('Y');
$disease = 5;
?>
<link rel="stylesheet" type="text/css" href="pro_dropdown_2/pro_dropdown_2.css" />

<script src="pro_dropdown_2/stuHover.js" type="text/javascript"></script>
<ul id="nav">
	<li class="top"><a href="#nogo1" class="top_link"><span>Home</span></a></li>
	<li class="top"><a href="#" class="top_link"><span>Submission List</span></a></li>
	<li class="top"><a href="#" class="top_link"><span>Weekly Epidemiological Summary</span></a></li>
	<li class="top"><a href="#" class="top_link"><span>Dashboard</span></a></li>
	
    <li class="top"><a href="#" class="top_link"><span  style="float:right;">Log Out</span></a></li>
</ul>
<script type="text/javascript">
$(document).ready(function() {

	getReports();
	   $(".RR_Year").change(function() { 
		   var year = $("#RR_Year").attr('value');
		   var chart = new FusionCharts("FusionCharts/Charts/MSLine.swf", "ChartId", "600", "350", "0", "1");
		   chart.setDataURL("xml/RR_Trends.php?year="+year);	
		   chart.addParam("WMode", "Transparent");	   
		   chart.render("RR_Trends_Chart");
	   });
	   $(".Disease").change(function() { 
		   var disease = $("#Disease").attr('value');
		   var year = $("#Disease_Year").attr('value');
		   var url = "xml/confirmed_diseases.php?parameters="+disease+"_"+year+"";
		   var chart = new FusionCharts("FusionCharts/Charts/Line.swf", "ChartId", "600", "350", "0", "1");
		   chart.setDataURL(url);	
		   chart.addParam("WMode", "Transparent");	   
		   chart.render("Confirmed_Diseases_Chart");
	   });
	   $(".Disease_Year").change(function() { 
		   var disease = $("#Disease").attr('value');
		   var year = $("#Disease_Year").attr('value');
		   var url = "xml/confirmed_diseases.php?parameters="+disease+"_"+year+"";
		   var chart = new FusionCharts("FusionCharts/Charts/Line.swf", "ChartId", "600", "350", "0", "1");
		   chart.setDataURL(url);	
		   chart.addParam("WMode", "Transparent");	   
		   chart.render("Confirmed_Diseases_Chart");
	   });
	   $(".Malaria_Cases_Year").change(function() { 
		   var year = $("#Malaria_Cases_Year").attr('value');
		   var chart = new FusionCharts("FusionCharts/Charts/MSLine.swf", "ChartId", "600", "350", "0", "1");
		   chart.setDataURL("xml/malaria_cases.php?year="+year);	
		   chart.addParam("WMode", "Transparent");	   
		   chart.render("Malaria_Cases_Chart");
	   });
	   $(".Reporting_Year").change(function() { 
			getReports();
	   });
	   $(".Reporting_Epiweek").change(function() { 
		   getEpiweekReport();
	   });
	   $(".Fatality_Rate_Province").change(function() { 
			getFatalityRate();
	   });
	   $(".Fatality_Rate_Year").change(function() { 
			getFatalityRate();
	   });
	   $(".Fatality_Rate_Disease").change(function() { 
			getFatalityRate();
	   });
	 });

function getFatalityRate(){
	   var disease = $("#Fatality_Rate_Disease").attr('value');
	   var year = $("#Fatality_Rate_Year").attr('value');
	   var province = $("#Fatality_Rate_Province").attr('value');
	   var url = "xml/fatality_rate.php?parameters="+disease+"_"+year+"_"+province+"";
	   var chart = new FusionCharts("FusionCharts/Charts/Line.swf", "ChartId", "600", "350", "0", "1");
	   chart.setDataURL(url);	
	   chart.addParam("WMode", "Transparent");	   
	   chart.render("Fatality_Rate_Chart");
	
}
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
	width:600px;
}
#left_container{
	float:left;
}
#right_container{
	float:right;
}
.xtop{
min-width:1200px;
}

</style>

<div class="section">
<div class="section-title"><strong>IDSR NATIONAL DASHBOARD</strong></div>

<div class="xtop">
<div id="left_container">
<div class="section-title">Provincial Average Intra-Province RR Trends</div>
<div id="RR_Trends" class="chart_container">

Year: <select name="RR_Year" id="RR_Year" class="RR_Year">
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
<div id="RR_Trends_Chart" style="z-index: -20"></div>
</div>


<div class="section-title">Confirmed Disease Cases</div>
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
		Year: <select name="Disease_Year" id="Disease_Year" class="Disease_Year">
		<?php
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

	<div id="Confirmed_Diseases_Chart" style="z-index: -20">
	</div>
</div>


<div class="section-title">Malaria Cases - Summary</div>
<div id="Malaria_Cases" class="chart_container">
Year: <select name="Malaria_Cases_Year" id="Malaria_Cases_Year" class="Malaria_Cases_Year">
	<?php
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



<div id="Malaria_Cases_Chart" style="z-index: -20"></div>
</div>
</div>

<div id="right_container">
<div class="section-title">National Reporting Performance</div>
<div id="Reporting_Performance" class="chart_container">
Year: <select name="Reporting_Year" id="Reporting_Year" class="Reporting_Year">
	<?php
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

<div class="section-title">Fatality Rates</div>
<div id="Fatality_Rate" class="chart_container">
Yr: <select name="Fatality_Rate_Year" id="Fatality_Rate_Year" class="Fatality_Rate_Year">
	<?php
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
Disease: <select name="Fatality_Rate_Disease" id="Fatality_Rate_Disease" class="Fatality_Rate_Disease">
	<?php
	$counter = 0;
	$disease_keys = array_keys($diseases);
	foreach($diseases as $disease_object){ 
		if($disease_keys[$counter]== $disease){?>
			<option value=<?php echo $disease_keys[$counter]?> selected><?php echo  $disease_object?>
			</option>
		<?php }
		else{
		?>
			<option value=<?php echo $disease_keys[$counter]?>><?php echo $disease_object?>
			</option>
		<?php
		}	
		$counter ++;
	}
	?>
</select>
	Prov: <select name="Fatality_Rate_Province" id="Fatality_Rate_Province" class="Fatality_Rate_Province">
		<?php
		$sql_provinces = "SELECT * from provinces";
		$sql_result_provinces = mysql_query($sql_provinces) or die(mysql_error());	
		while($province_resultset = mysql_fetch_assoc($sql_result_provinces)){
				?>
					<option value=<?php echo $province_resultset['ID']?>><?php echo $province_resultset['name']?>
					</option>
				<?php				
			mysql_data_seek($sql_result_provinces);
		}
		?>
	</select>


<div id="Fatality_Rate_Chart">
</div>

</div>


</div>


<script type="text/javascript">
   var chart = new FusionCharts("FusionCharts/Charts/Line.swf", "ChartId", "600", "350", "0", "1");
   chart.setDataURL("xml/reported_diseases.php");	
   chart.addParam("WMode", "Transparent");	   
   chart.render("Confirmed_Diseases_Chart");
</script>
		

 <script type="text/javascript">
   var chart = new FusionCharts("FusionCharts/Charts/MSLine.swf", "ChartId", "600", "350", "0", "1");
   chart.setDataURL("xml/RR_Trends.php");	
   chart.addParam("WMode", "Transparent");	   
   chart.render("RR_Trends_Chart");
</script>	
		
 <script type="text/javascript">
   var chart = new FusionCharts("FusionCharts/Charts/MSLine.swf", "ChartId", "600", "350", "0", "1");
   chart.setDataURL("xml/malaria_cases.php");	
   chart.addParam("WMode", "Transparent");	   
   chart.render("Malaria_Cases_Chart");
   
</script>	
 <script type="text/javascript">
   var chart = new FusionCharts("FusionCharts/Charts/Line.swf", "ChartId", "600", "350", "0", "1");
   chart.setDataURL("xml/fatality_rate.php");	
   chart.addParam("WMode", "Transparent");	   
   chart.render("Fatality_Rate_Chart");
   
</script>
</div>
</div>

	<?php include('footer.php');?>