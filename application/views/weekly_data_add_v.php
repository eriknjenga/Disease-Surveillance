<style>
	.disease_input {
		width: 50px;
		height: 20px;
		margin: 0 auto !important;
	}
</style>
<script type="text/javascript">
	$(function() {
		$("#province").change(function() {
			//Get the selected province
			var province = $(this).attr("value");
			$("#district").children('option').remove();
			$.each($("#district_container").children('option'), function(i, v) {
				var current_province = $(this).attr("province");
				if(current_province == province) {
					$("#district").append($("<option></option>").attr("value", $(this).attr("value")).text($(this).text()));
				} else if(province == 0) {
					$("#district").append($("<option></option>").attr("value", $(this).attr("value")).text($(this).text()));
				}
			});
			//Loop through the list of all districts and display the ones from this province

		});
		$("#weekending").datepicker({
			altField : "#epiweek",
			altFormat : "DD,d MM, yy",
			firstDay : 1,
			changeYear : true,
			onClose : function(date, inst) {
				//Create a new date object from the date selected
				var new_date = new Date(date);
				//Retrieve the week number and reporting year for this date object
				var week_data = getWeek(new_date);
				$("#epiweek").attr("value", week_data[0]);
				$("#reporting_year").attr("value", week_data[1]);
			},
			beforeShowDay : function(date) {
				//Disable all days except sundays
				var day = date.getDay();
				return [(day != 1 && day != 2 && day != 3 && day != 4 && day != 5 && day != 6)];
			}
		});
		$(".zero_reporting").change(function() {

			zeroReporting(this.id);
		});
	});
	/*
	 * Function that calculates the epiweek of a given date
	 */
	function getWeek(date) {
		var reporting_year = "";
		var checkDate = new Date(date.getTime());
		//Retrieve the reporting year from this date
		reporting_year = checkDate.getFullYear();
		// Find Sunday of this week starting on Monday
		checkDate.setDate(checkDate.getDate() + 7 - (checkDate.getDay() || 7));
		//get the time for that sunday
		var time = checkDate.getTime();
		//Compare this with January 1st of that year
		//set the month to january
		checkDate.setMonth(0);
		//set the date to 1st january
		checkDate.setDate(1);
		//Calculate the modulous of the difference to determine how many days in that year fall in the first week
		var week_days_in_year = (((time - checkDate) / 86400000) % 7) + 1;
		//Calculate the week number
		var week_number = Math.floor(Math.round((time - checkDate) / 86400000) / 7);
		//If the number of days falling in the first week are greater than 4, increment the weeknumber by 1 since these days will be considered as the first week of the year
		if(week_days_in_year >= 4) {
			week_number += 1;
		}
		//If the week number is '0' assign the week number of the last week of the previous year
		if(week_number == 0) {
			//Set the year to the previous year
			checkDate.setYear(checkDate.getFullYear() - 1);
			//Retrieve the reporting year from this date
			reporting_year = checkDate.getFullYear();
			//set month as december
			checkDate.setMonth(11);
			//set date as 24th
			checkDate.setDate(24);
			//Call this function again to retrieve the week number of the 2nd last week of the previous year. 24th December is set as the date since it is guaranteed to be in this last week.
			var last_week = arguments.callee(checkDate);
			//Increment this week number to get the last week of that year
			week_number = last_week[0] += 1;
		}
		var return_array = new Array(week_number, reporting_year);
		return return_array;
	}

	function zeroReporting(id) {
		var temp = id.split("_");
		var disease = temp[1];
		var lmcase = "lmcase_" + disease;
		$("#" + lmcase).attr("value", "0");
		var lfcase = "lfcase_" + disease;
		$("#" + lfcase).attr("value", "0");
		var lmdeath = "lmdeath_" + disease;
		$("#" + lmdeath).attr("value", "0");
		var lfdeath = "lfdeath_" + disease;
		$("#" + lfdeath).attr("value", "0");
		var gmcase = "gmcase_" + disease;
		$("#" + gmcase).attr("value", "0");
		var gfcase = "gfcase_" + disease;
		$("#" + gfcase).attr("value", "0");
		var gmdeath = "gmdeath_" + disease;
		$("#" + gmdeath).attr("value", "0");
		var gfdeath = "gfdeath_" + disease;
		$("#" + gfdeath).attr("value", "0");
	}
</script>
<div class="view_content">
	<?php
	$attributes = array('id' => 'entry-form');
	echo form_open('weekly_data_management/save', $attributes);
	echo validation_errors('<p class="error">', '</p>');
	?>
</div>
<table  style="margin: 5px auto; border: 2px solid #EEEEEE;">
	<tr>
		<td><b>Week Ending:</b></td><td>
		<input type="text" name="week_ending" id="weekending"/>
		</td>
		<td><b>Epiweek: </b></td>
		<td>
		<input type="text" name="epiweek" id="epiweek" readonly=""/>
		<input type="hidden" name="reporting_year" id="reporting_year"/>
		</td>
	</tr>
	<tr>
		<td><b>Province: </b></td><td>
		<select name="province" id="province">
			<option value="0">Select Province</option>
			<?php
			foreach ($provinces as $province) {
				echo '<option value="' . $province -> id . '">' . $province -> Name . '</option>';
			}//end foreach
			?>
		</select></td>
		<td><b>District: </b></td>
		<td>
		<select name="district" id="district">
			<option value="">Select District</option>
			<?php
			foreach ($districts as $district) {
				echo '<option value="' . $district -> id . '" province="' . $district -> Province . '" >' . $district -> Name . '</option>';
			}//end foreach
			?>
		</select></td>
		<td>
		<select id="district_container" style="display: none">
			<option value="">Select District</option>
			<?php
			foreach ($districts as $district) {
				echo '<option value="' . $district -> id . '" province="' . $district -> Province . '" >' . $district -> Name . '</option>';
			}//end foreach
			?>
		</select></td>
	</tr>
	<tr>
		<td><b>No. of Health Facility/Site reporting</b></td><td>
		<input type="text" name="reporting_facilities" id="reporting_facilities"/>
		</td><td><b>No. of Health Facility/Site reports expected</b></td><td>
		<input type="text" name="expected_facilities" id="expected_facilities"/>
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
		<td style="background-color: #C4E8B7"> - </td>
		<td style="background-color: #C4E8B7"> - </td>
		<td style="background-color: #C4E8B7"> - </td>
		<td style="background-color: #C4E8B7"> - </td>
		<td>
		<input type="checkbox" id ="<?php echo "check_" . $disease -> id;?>" class="zero_reporting">
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
		<input type="text"  id="total_tested_less_than_five" name="total_tested_less_than_five" >
		</td>
		<td colspan="7" style="background-color: #C4E8B7">
		<input type="text" name="total_tested_greater_than_five" id="total_tested_greater_than_five">
		</td>
	</tr>
	<tr >
		<td colspan="1"><strong> Total Number Positive </strong></td>
		<td colspan="2" style="background-color: #C4E8B7">
		<input type="text" id="total_positive_less_than_five" name="total_positive_less_than_five">
		</td>
		<td colspan="7" style="background-color: #C4E8B7">
		<input type="text" id="total_positive_greater_than_five" name="total_positive_greater_than_five">
		</td>
	</tr>
	<tr class="even">
		<td colspan="1"><strong> Remarks </strong></td>
		<td colspan="9">		<textarea name="remarks" rows="2" cols="50"></textarea></td>
	</tr>
	<tr>
		<td><strong> Reported by </strong></td>
		<td style="background-color: #C4E8B7"  colspan="4">
		<input type="text" name="reported_by" id="reported_by">
		</td>
		<td colspan="2"><strong> Designation </strong></td>
		<td style="background-color: #C4E8B7"  colspan="4">
		<input type="text" name="designation" id="designation">
		</td>
	</tr>
</table>
<table style="margin: 5px auto;">
	<tr>
		<td>
		<input name="save" type="submit" class="button" value="Save " style="width:200px; height: 30px; font-size: 16px; letter-spacing: 2px !important" />
		</td>
	</tr>
</table>
</form> 