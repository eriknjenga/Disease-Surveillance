<?php
session_start();
if ($_SESSION['role'] !== '4') {
    header('location:access_denied.php');
} 
$link = 'raw_data';
include('national_header.php');
include('/connection/authenticate.php');
$current_year = date('Y');
$earliest_year = $current_year - 5;
$latest_year = $current_year+5;
?>

<style type="text/css">
#filter {
	border: 2px solid #DDD;
	display: block;
	width: 80%;
	margin: 10px auto;
}

.filter_input {
	border: 1px solid black;
}
</style>
<div id="filter">
<form action="data_export.php" method="post">
<fieldset><legend> Select Filter Options</legend> <label for="year_from">Select
Year</label> <select name="year_from">
<?php
for($x=$earliest_year;$x<=$latest_year;$x++){?>
	<option value="<?php echo $x;?>"
	<?php if($x == $current_year){echo "selected";}?>><?php echo $x;?></option>
	<?php }
	?>
</select> <label for="epiweek_from">Starting Epiweek</label> <select
	name="epiweek_from">
	<?php
	for($x=1;$x<=52;$x++){?>
	<option value="<?php echo $x;?>"><?php echo $x;?></option>
	<?php }
	?>
</select> -- 
<label for="epiweek_to">Final Epiweek</label> <select
	name="epiweek_to">
	<?php
	for($x=1;$x<=52;$x++){?>
	<option value="<?php echo $x;?>"><?php echo $x;?></option>
	<?php }
	?>
</select> 
<input type="submit" name="surveillance" class="button"	value="Download Surveillance Data" />
<input type="submit" name="malaria" class="button"	value="Download Malaria Lab Data" />	
	</fieldset>
</form>
</div>
