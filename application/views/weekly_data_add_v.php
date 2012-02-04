<style>
	.disease_input {
		width: 50px;
		height: 20px;
		margin: 0 auto !important;
	}
</style>
<script type="text/javascript">
	$(function() {
		$("#weekending").datepicker({
			altField : "#epiweek",
			altFormat : "DD,d MM, yy",
			firstDay: 1,
			changeYear: true,
			onClose : function(date, inst) {
				var new_date = new Date(date);
				var dave = getWeek(new_date) - 1;
				$("#epiweek").attr("value", dave);
			},
			beforeShowDay : function(date) {
				var day = date.getDay();
				return [(day != 1 && day != 2 && day != 3 && day != 4 && day != 5 && day != 6)];
			}
		});
		$(".zero_reporting").change(function() {

			zeroReporting(this.id);
		});
	});
	function getWeek(date) {
		var checkDate = new Date(date.getTime());
		// Find Sunday of this week starting on Monday
		checkDate.setDate(checkDate.getDate() + 7 - (checkDate.getDay() || 7));
		var time = checkDate.getTime();
		checkDate.setMonth(0);
		// Compare with Jan 1
		checkDate.setDate(1);
		return Math.floor(Math.round((time - checkDate) / 86400000) / 7) + 1;
	}
</script>
<div class="view_content">
	<?php
	$attributes = array('id' => 'entry-form');
	echo form_open('weeklydata_management/save', $attributes);
	echo validation_errors('<p class="error">', '</p>');
	?>
</div>
<table  style="margin: 5px auto; border: 2px solid #EEEEEE;">
	<tr>
		<td><b>Week Ending:</b></td><td>
		<input type="text" name="weekending" id="weekending"/>
		</td>
		<td><b>Epiweek: </b></td>
		<td>
		<input type="text" name="epiweek" id="epiweek"/>
		</td>
	</tr>
	<tr>
		<td><b>Province: </b></td><td>
		<select name="province" id="province">
			<option value="">Select Province</option>
			<?php
			foreach ($provinces as $province) {
				echo '<option value="' . $province -> id . '">' . $province -> Name . '</option>';
			}//end foreach
			?>
		</select></td><td><b>District: </b></td><td>
		<input type="text" name="district" id="district"/>
		</td>
	</tr>
	<tr>
		<td><b>No. of Health Facility/Site reporting</b></td><td>
		<input type="text" name="reportingfacilities" id="reportingfacilities"/>
		</td><td><b>No. of Health Facility/Site reports expected</b></td><td>
		<input type="text" name="expectedfacilities" id="expectedfacilities"/>
		</td>
	</tr>
</table>
<table class="data-table" style="margin: 0 auto;">
	<tr>
		<th rowspan="3">Disease</th>
		<th colspan="4">&le;5 Years</th>
		<th colspan="4">&ge;5 Years</th>
		<th rowspan="3">Zero Reporting (Check as appropriate)</th>
	</tr>
	<tr>
		<th colspan="2">Cases</th>
		<th colspan="2">Deaths</th>
		<th colspan="2">Cases</th>
		<th colspan="2">Deaths</th>
	</tr>
	<tr class="even">
		<th >Males</th>
		<th >Females</th>
		<th >Males</th>
		<th >Females</th>
		<th >Males</th>
		<th >Females</th>
		<th >Males</th>
		<th >Females</th>
	</tr>
	<?php
$counter = 1;
foreach ($diseases as $disease) {
$rem = $counter %2;
$class = "odd";
if($rem == 0){
$class = "even";
}
if($disease -> id != "12"){
	?>
	<tr class="<?php echo $class;?>">
		<td><?php echo $disease -> Name;?></td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="lmcase[]" id="<?php echo "lmcase_" . $disease -> id;?>"  value="" class="disease_input"/>
		</td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="lfcase[]" id="<?php echo "lfcase_" . $disease -> id;?>"  value="" class="disease_input"/>
		</td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="lmdeath[]" id="<?php echo "lmdeath_" . $disease -> id;?>"  value="" class="disease_input"/>
		</td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="lfdeath[]" id="<?php echo "lfdeath_" . $disease -> id;?>"  value="" class="disease_input"/>
		</td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="gmcase[]" id="<?php echo "gmcase_" . $disease -> id;?>"  value="" class="disease_input"/>
		</td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="gfcase[]" id="<?php echo "gfcase_" . $disease -> id;?>" value="" class="disease_input"/>
		</td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="gmdeath[]" id="<?php echo "gmdeath_" . $disease -> id;?>"  value="" class="disease_input"/>
		</td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="gfdeath[]" id="<?php echo "gfdeath_" . $disease -> id;?>" value="" class="disease_input"/>
		</td>
		<td>
		<input type="checkbox" id ="<?php echo "check_" . $disease -> id;?>" class="zero_reporting">
		</td>
	</tr>
	<?php
	}else{
	?>
	<tr class="<?php echo $class;?>">
		<td><?php echo $disease -> Name;?></td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="lmcase[]" id="<?php echo "lmcase_" . $disease -> id;?>"  value="" class="disease_input"/>
		</td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="lfcase[]" id="<?php echo "lfcase_" . $disease -> id;?>"  value="" class="disease_input"/>
		</td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="lmdeath[]" id="<?php echo "lmdeath_" . $disease -> id;?>" value="" class="disease_input"/>
		</td>
		<td style="background-color: #C4E8B7">
		<input type="text" name="lfdeath[]" id="<?php echo "lfdeath_" . $disease -> id;?>"  value="" class="disease_input"/>
		</td>
	</tr>
	<?php
	}//end else if
	$counter ++;
	}//end foreach
	?>
</table>
<table class="data-table" style="margin: 10px auto;">
	<tr class="odd">
		<th colspan="1">Laboratory Weekly Malaria Confirmation</th>
		<th colspan="2">&le;5 years</th>
		<th colspan="7">&ge;5years</th>
	</tr>
	<tr class="even">
		<td colspan="1"><strong> Total Number Tested </strong></td>
		<td colspan="2" style="background-color: #C4E8B7">
		<input type="text"  id="totaltestedmalarials" name="totaltestedlessfive" >
		</td>
		<td colspan="7" style="background-color: #C4E8B7">
		<input type="text" name="totaltestedmalariagr" id="totaltestedgreaterfive">
		</td>
	</tr>
	<tr >
		<td colspan="1"><strong> Total Number Positive </strong></td>
		<td colspan="2" style="background-color: #C4E8B7">
		<input type="text" id="totalpositivemalarials" name="totalpositivelessfive">
		</td>
		<td colspan="7" style="background-color: #C4E8B7">
		<input type="text" id="totalpositivemalariagr" name="totalpositivegreaterfive">
		</td>
	</tr>
	<tr class="even">
		<td colspan="1"><strong> Remarks </strong></td>
		<td colspan="9">		<textarea name="remarks" rows="2" cols="50"></textarea></td>
	</tr>
	<tr>
		<td><strong> Reported by </strong></td>
		<td style="background-color: #C4E8B7"  colspan="4">
		<input type="text" name="reportedby" id="reportedby">
		</td>
		<td colspan="2"><strong> Designation </strong></td>
		<td style="background-color: #C4E8B7"  colspan="4">
		<input type="text" name="designation" id="designation">
		</td>
	</tr>
</table>
<input name="save" type="submit" class="button" value="Save " />
