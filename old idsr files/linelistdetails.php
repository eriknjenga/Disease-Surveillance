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
	<div class="section-title">Line List Details </div>
	
	<table class="data-table">
		<tr>
			<th width="58">&nbsp;</th>
			<th colspan="4">&nbsp;</th>
			<th colspan="4">&nbsp;</th>
			<th colspan="4">&nbsp;</th>
			<th colspan="2">&nbsp;</th>
			<th colspan="3">Lab Tests </th>
			<th colspan="2" rowspan="2">Outcome </th>
			<th  colspan="3" rowspan="3">Comments</th>
		</tr>
		<tr>
			<th>Names</th>
			<th colspan="2">Patients</th>
			<th colspan="2">Village or town </th>
			<th colspan="2">Sex</th>
			<th colspan="2">Age</th>
			<th colspan="2" rowspan="2">Date Seen at HF </th>
			<th colspan="2" rowspan="2">Date of onset of disease </th>
			<th colspan="2" rowspan="2">number of doses </th>
			<th colspan="2">specimen taken  </th>
				<th colspan="1" rowspan="2">Lab Results  </th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th width="63">Out Patient </th>
			<th width="58">In Patient </th>
			
			<th colspan="2">&nbsp;</th>
			<th colspan="2">&nbsp;</th>
			<th colspan="2">&nbsp;</th>
			
			
		
			<th width="41">date</th>
			<th width="48">Type</th>
			<th width="41">A-Alive</th>
			<th >D -Dead </th>
		</tr>
		
		<tr class="even">
			<td>Patrick</td>
			<td>Y</td>
			<td>&nbsp;</td>
			<tD colspan="2">Wamuini</tD>
			<tD colspan="2">M</tD>
			<tD colspan="2">23</tD>
			<tD colspan="2">25/03/2011</tD>
		<td colspan="2">2/02/2011</td>	
				<td colspan="2">7</td>	
			    <td>07/04/2011</td>
			<td>Stool</td>
			<td width="70">Positive</td>
				<td width="41">A</td>
			<td width="51">&nbsp;</td>
			<td  colspan="3" >Comments here </td>
		</tr>
		<tr class="even">
			<td>James</td>
			<td>Y</td>
			<td>&nbsp;</td>
			<td colspan="2">Wamuini</td>
			<td colspan="2">M</td>
			<td colspan="2">34</td>
			<td colspan="2">25/03/2011</td>
			<td colspan="2">2/02/2011</td>	
				<td colspan="2">5</td>	
			    <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td width="70"><a href="#"></a></td>
				<td width="41">&nbsp;</td>
			<td width="51">&nbsp;</td>
			<td  colspan="3" >&nbsp;</td>
		</tr>
		<tr class="even">
			<td>Stella</td>
			<td>&nbsp;</td>
			<td>N</td>
			<td colspan="2">Wamuini</td>
			<td colspan="2">F</td>
			<td colspan="2">17</td>
			<td colspan="2">25/03/2011</td>
				<td colspan="2">12/03/2011</td>	
				<td colspan="2">12</td>	
			    <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td width="70"><a href="#"></a></td>
				<td width="41">&nbsp;</td>
			<td width="51">&nbsp;</td>
			<td width="83" colspan="3" >&nbsp;</td>
		</tr>
		<tr class="even">
			<td>Janice</td>
			<td>&nbsp;</td>
			<td>N</td>
			<td colspan="2">Wamuini</td>
			<td colspan="2">F</td>
			<td colspan="2">45</td>
			<td colspan="2">21/03/2011</td>
				<td colspan="2">2/02/2011</td>	
				<td colspan="2">5</td>	
			    <td>03/04/2011</td>
			<td>Blood</td>
			<td width="70">Negative</td>
				<td width="41">A</td>
			<td width="51">&nbsp;</td>
			<td width="83" colspan="3" >Comments here </td>
		</tr>
		<tr class="even">
			<td>Melow</td>
			<td>Y</td>
			<td>&nbsp;</td>
			<td colspan="2">Wamuini</td>
			<td colspan="2">F</td>
			<td colspan="2">22</td>
			<td colspan="2">5/03/2011</td>
				<td colspan="2">6/02/2011</td>	
				<td colspan="2">4</td>	
			    <td>25/03/2011</td>
			<td>Stool</td>
			<td width="70">Negative</td>
				<td width="41">A</td>
			<td width="51">&nbsp;</td>
			<td width="83" colspan="3" >Comments here </td>
		</tr>
		<tr class="even">
			<td>Atieno</td>
			<td>Y</td>
			<td>&nbsp;</td>
			<td colspan="2">Njokeni</td>
			<td colspan="2">F</td>
			<td colspan="2">27</td>
			<td colspan="2">5/03/2011</td>
				<td colspan="2">8/02/2011</td>	
				<td colspan="2">7</td>	
			    <td>&nbsp;</td>
			<td>&nbsp;</td>
		<td width="70"><a href="#"></a></td>
				<td width="41">&nbsp;</td>
			<td width="51">&nbsp;</td>
			<td width="83" colspan="3" >&nbsp;</td>
		</tr>
		<tr class="even">
			<td>Nyeooko</td>
			<td>Y</td>
			<td>&nbsp;</td>
			<td colspan="2">Njokeni</td>
			<td colspan="2">M</td>
			<td colspan="2">34</td>
			<td colspan="2">15/03/2011</td>
				<td colspan="2">22/02/2011</td>	
				<td colspan="2">5</td>	
			    <td>&nbsp;</td>
			<td>&nbsp;</td>
		<td width="70"><a href="#"></a></td>
				<td width="41">&nbsp;</td>
			<td width="51">&nbsp;</td>
			<td width="83" colspan="3" >&nbsp;</td>
		</tr>
		</table>
 <?php include('footer.php');?>