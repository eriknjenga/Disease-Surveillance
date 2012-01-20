<?php 
include("/connection/config.php");
$epiweek = $_GET['epiweek'];
$year = $_GET['year'];

echo "<span style='margin:10px; border-bottom:1px solid #DDD; font-weight:bold'>Statistics for ".$year." epiweek ".$epiweek."</span>";

$sql_total_submission = "SELECT sum(distinct submitted) as submitted FROM surveillance WHERE weekending like '%".$year."%' and epiweek = $epiweek limit 1";
$sql_result_submission = mysql_query($sql_total_submission) or die(mysql_error());
$current_sub = mysql_fetch_assoc($sql_result_submission);
$current = $current_sub['submitted'];


$past_epiweek = $epiweek - 1;
$sql_past_total_submission = "SELECT sum(distinct submitted) as submitted FROM surveillance WHERE weekending like '%".$year."%' and epiweek = $past_epiweek limit 1";
$sql_past_result_submission = mysql_query($sql_past_total_submission) or die(mysql_error());
$past_sub = mysql_fetch_assoc($sql_past_result_submission);
$past = $past_sub['submitted'];




$sql_get_data = "select sum(distinct submitted) as total_submitted, sum(distinct expected) as total_expected from surveillance where epiweek = '$epiweek' and weekending like '%".$year."%'";
$sql_result_get_data = mysql_query($sql_get_data) or die(mysql_error());
$get_data_resultset = mysql_fetch_assoc($sql_result_get_data);
$expected_current = $get_data_resultset['total_expected']; 
$submitted_current = $get_data_resultset['total_submitted']; 
$rr_current = floor(($submitted_current/$expected_current)*100);

$past_epiweek = $epiweek - 1;
$sql_get_data = "select sum(distinct submitted) as total_submitted, sum(distinct expected) as total_expected from surveillance where epiweek = '$past_epiweek' and weekending like '%".$year."%'";
$sql_result_get_data = mysql_query($sql_get_data) or die(mysql_error());
$get_data_resultset = mysql_fetch_assoc($sql_result_get_data);
$expected_past = $get_data_resultset['total_expected']; 
$submitted_past = $get_data_resultset['total_submitted']; 
$rr_past = floor(($submitted_past/$expected_past)*100);


		
		
?>
<table>
<tr>
<td>
<b>Submission</b>
</td>
<td>
From
</td>
<td>
<?php if(isset($past)){echo $past;} else {echo "Not Available";}?>
</td>
<td> To: </td>
<td><?php echo $current;?></td>

<?php if(isset($past)){?>
<td>
(
<?php 
$change = $current - $past;
if($change>0){?>
	<span style="color:green; font-weight:bold"><?php echo $change;?> increase</span>
<?php }
else if ($change == 0){?>
<span style="color:blue; font-weight:bold"><?php echo $change;?> - No change</span>
<?php }

else{?>
<span style="color:red; font-weight:bold"><?php echo $change;?> decrease</span>
<?php }
?>
)
</td>
<?php 
}
?>

</tr>

<tr>
<td>
<b>Intra-District Reporting Rate</b> 
</td>
<td>
From:
</td>
<td>
<?php if(isset($rr_past)){echo $rr_past;} else {echo "Not Available";}?>
</td>
<td> To: </td>
<td><?php echo $rr_current;?></td>

<?php if(isset($past)){?>
<td>
(
<?php 
$change = $rr_current - $rr_past;
if($change>0){?>
	<span style="color:green; font-weight:bold"><?php echo $change;?>% increase</span>
<?php }
else if($change ==0){?>
	<span style="color:blue; font-weight:bold"><?php echo $change;?>% - No Change</span>
<?php }

else{?>
<span style="color:red; font-weight:bold"><?php echo $change;?>% decrease</span>
<?php }
?>
)
</td>
<?php 
}
?>

</tr>



</table>