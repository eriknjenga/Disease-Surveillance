<?php
require_once('/connection/config.php');
include('national_header.php');

$year = date('Y');
$disease = 5;

$mwaka = $_GET['yr'];
$tarafa = $_GET['dist'];
$uwele = $_GET['diz'];

echo $mwaka;
echo $tarafa;
echo $uwele;
?>
<script type="text/javascript">
$(document).ready(function() {
 
	   $(".Fatality_Rate_Province").change(function() { 
		   var years = $(".Fatality_Rate_Year");
		   var year = "";
		   for(x=0; x<years.size();x++){
			   var current = $(years[x]).css("font-weight"); 
			   if(current=="bold"){
				   year = years[x].id;
			   } 
		   }
		   getFatalityRate(year);
	   });
	   $(".Fatality_Rate_Year").click(function() { 
		   var chosen = $(this).css("font-weight");
		   if(chosen == "normal"){
		   $(".Fatality_Rate_Year").css("font-weight","normal");
		   $(this).css("font-weight","bold");	
			getFatalityRate(this.id);
		   }
	   });
	   $(".Fatality_Rate_Disease").change(function() { 
		   var years = $(".Fatality_Rate_Year");
		   var year = "";
		   for(x=0; x<years.size();x++){
			   var current = $(years[x]).css("font-weight"); 
			   if(current=="bold"){
				   year = years[x].id;
			   } 
		   }
		   getFatalityRate(year);
			
	   });

 
		
	 });

 
function getFatalityRate(year){
	   var disease = $("#Fatality_Rate_Disease").attr('value'); 
	   var province = $("#Fatality_Rate_Province").attr('value');
	   var url = "xml/fatality_rate.php?parameters="+disease+"_"+year+"_"+province+"";
	   var chart = new FusionCharts("FusionCharts/Charts/Line.swf", "ChartId", "900", "550", "0", "1");
	   chart.setDataURL(url);	
	   chart.addParam("WMode", "Transparent");	   
	   chart.render("Fatality_Rate_Chart");
	
}
 
</script>
<script type="text/javascript">
                function dave(form){
                    var val = form.province.options[form.province.options.selectedIndex].value;
                    self.location = 'submissionlist.php?province=' + val;
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
<style type="text/css">
            select {
                width: 250;}
            </style>

            <script>
                window.dhx_globalImgPath="img/";
            </script>

            <script src="dhtmlxcombo_extra.js"></script>
            <link rel="STYLESHEET" type="text/css" href="dhtmlxcombo.css">
            <link type="text/css" href="calendar.css" rel="stylesheet" />
            <link href="base/jquery-ui.css" rel="stylesheet" type="text/css"/>

            <script src="dhtmlxcommon.js"></script>
            <script src="dhtmlxcombo.js"></script>

<div class="section">

<div class="xtop">
<div id="right_container">

<div class="section-title">Case Fatality Rates</div>
<table>
			<tr>
			
			<td><a href="RR_Trends.php">Average RR Trends</a> | <a href="Reported_Diseases.php">Reported Disease Cases</a> | <a href="Fatality_Rates.php">Case Fatality Rates</a> </td>
			
			</td>
			
			
			</tr>
			
			</table>
            <form action="district_fatality.php" method="post" name="frm">
            <div id="Fatality_Rate" class="chart_container">
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
		<a class="Fatality_Rate_Year" id=<?php echo $year_object?> style="color:#00849E; font-weight:bold"> <?php echo  $year_object?> </a>
			 
		<?php }
		else{
		?>
			<a class="Fatality_Rate_Year" id=<?php echo $year_object?> style="color:#00849E"> <?php echo  $year_object?> </a>
		<?php
		}	
	}
	?>
	Disease: <select name="Fatality_Rate_Disease" id="Fatality_Rate_Disease" class="Fatality_Rate_Disease">
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
	
	
	Province: <select name="Fatality_Rate_Province" id="Fatality_Rate_Province" class="Fatality_Rate_Province">
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
    <?php
                    if ($autocode != "") {
                        ?>
    
    <div class="notice">
                                    <?php
                                    $facilityname = GetFacility($autocode);
                                    echo '<strong>' . $facilityname . '</strong>';
                                    echo"<input id=\"facility\" name='facility' type='hidden' value='$autocode' />";
                                    ?>
                                </div>
                                 <?php
                    } else {
                        ?>
                        <strong>
                                    Select District:<select  style="width:262px"  id="cat" name="cat" class="validate[required]">

                                    </select>
                                    <script>
                                        var combo = dhtmlXComboFromSelect("cat");
                                        combo.enableFilteringMode(true,"get_districts.php",true);
                                    </script>
                                </strong>
                                 <?php } ?>
                                 <input name="MM_go" type="hidden" value="go" />
                                 <input name="filter" type="submit" class="button" value="Filter"></div></form>
                                 
                                 <?php if((isset($_POST["MM_go"])) && ($_POST["MM_go"] == "go")){
									 $yr = $_POST['$year_object'];
									 $diz = $_POST['Fatality_Rate_Disease'];
									 $dist = $_POST['cat'];
								 }?>




<div id="Fatality_Rate_Chart">
</div>

</div>
 
 

</div>

 
 
 <script type="text/javascript">
   var chart = new FusionCharts("FusionCharts/Charts/Line.swf", "ChartId", "900", "550", "0", "1");
   chart.setDataURL("xml/fatality_rate.php");	
   chart.addParam("WMode", "Transparent");	   
   chart.render("Fatality_Rate_Chart");
   
</script>
</div>


	<?php include('footer.php');?>