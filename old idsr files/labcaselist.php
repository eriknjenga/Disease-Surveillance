<?php 
include('/connection/authenticate.php');
require_once('/connection/config.php');
include('header3.php');

$sessionuserid = $_SESSION['id']; 
$sessionaccounttype = $_SESSION['accounttype']; 
$autocode=$_GET['q']; //facility code
$savedcommunity=$_GET['p'];

$districtdetails = GetDistrictInfo($sessionaccounttype);
$districtname = $districtdetails['name'];

$typequery=mysql_query("SELECT name as tname FROM diseasetypes where id ='1' ")or die(mysql_error()); 
$tdd=mysql_fetch_array($typequery);
$tname=$tdd['tname'];

$ttypequery=mysql_query("SELECT name as ttname FROM diseasetypes where id ='2' ")or die(mysql_error()); 
$ttdd=mysql_fetch_array($ttypequery);
$ttname=$ttdd['ttname'];
?>
	<div class="section-title">Submitted Case Based Samples for Lab Analysis </div>
 <?php include('footer.php');?>