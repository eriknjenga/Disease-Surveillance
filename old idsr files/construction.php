<?php 
session_start();
require_once('/connection/config.php');
include('header.php');



if ($_REQUEST['save'])
{
	$facility = $_GET['facility'];
	$community= $_GET['community'];
	$intervention= $_GET['intervention'];
	$objective = $_GET['objective'];
	$baseline = $_GET['baseline'];
	$target = $_GET['target'];
	
	echo "Facility ".$facility." Community ".$community." Intervention ".$intervention." Objective ".$objective." Baseline ".$baseline." Target ".$target;
	
	//$saveinfo = SaveCommunityPlan($facility,$community,$intervention);
	
}
else if ($_REQUEST['add'])
{

}
?>

<style type="text/css">
select {
width: 250;}
</style>
		<div  class="section">
		<div class="section-title"> <strong>PAGE UNDER CONSTRUCTION </strong></div>
		</div>
		
		<div >
		<table>
		<tr><td>
					<A HREF='javascript:history.back(-1)'><img src='img/back.gif' alt='Go Back'/></A>
		</td>
		</tr>
		</table>
				
		<img src="img/construction2.jpg" alt="Page Under Construction" width="400" height="300" />	
		
		</div>
		<?php include('footer.php');?>