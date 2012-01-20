<?php 
include('/connection/authenticate.php');
require_once('/connection/config.php');
require_once('classes/tc_calendar.php');
include('district_header.php');

$currentyear = date ('Y');
$yearsago = $currentyear - 5;
$sessionuserid = $_SESSION['id']; 
$sessionaccounttype = $_SESSION['accounttype']; 

$autocode=$_GET['q']; //facility code

$districtdetails = GetDistrictInfo($sessionaccounttype);

$districtname = $districtdetails['name'];
?>

<style type="text/css">
select {
width: 250;}
</style>
		<div  class="section">
		<div class="section-title"> <strong><?php echo $districtname; ?> Dashboard </strong></div>
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