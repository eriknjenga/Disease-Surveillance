<?php 
include("/connection/config.php");
$year = $_GET['year'];
$sql_epiweeks = "SELECT distinct epiweek FROM surveillance WHERE weekending like '%".$year."%' order by epiweek asc";
$sql_result_epiweeks = mysql_query($sql_epiweeks) or die(mysql_error());
while($epiweek = mysql_fetch_assoc($sql_result_epiweeks)){
?>
			<option value=<?php echo $epiweek['epiweek']?>><?php echo $epiweek['epiweek']?>
			</option>

<?php }


?>