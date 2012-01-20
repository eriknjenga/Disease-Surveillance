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
	<div class="section-title">Submitted Line List Samples for Lab Analysis </div>


<table class="data-table">
  <tr>
  <th scope="col">No</th>
    <th scope="col">Facility</th>
    <th scope="col">Date Submitted</th>
    <th scope="col">Task</th>
  </tr>
  <tr class="even">
    <td>1</td>
	<td> Gachege Dispensary</td>
    <td>&nbsp;4th Mar 2011</td>
    <td> <a href="linelistdetails.php">View Details</a> </td>
  </tr>
  <tr class="even">
    <td>2</td>
	<td> Gakui Dispensary</td>
    <td>&nbsp;14th Mar 2011</td>
    <td> <a href="linelistdetails.php">View Details</a> </td>
  </tr>
  <tr class="even">
    <td>3</td>
	<td> Thika Hospital</td>
    <td>&nbsp;24th Mar 2011</td>
    <td> <a href="linelistdetails.php">View Details</a> </td>
  </tr>
</table>

 <?php include('footer.php');?>