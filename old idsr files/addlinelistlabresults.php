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
<script>
		window.dhx_globalImgPath="img/";
	</script>
<script type="text/javascript" src="validation.js"></script>
<script src="dhtmlxcombo_extra.js"></script>
 <link rel="STYLESHEET" type="text/css" href="dhtmlxcombo.css">
  <script src="dhtmlxcommon.js"></script>
  <script src="dhtmlxcombo.js"></script>

<link rel="stylesheet" href="validation.css" type="text/css" media="screen" />

<link type="text/css" href="calendar.css" rel="stylesheet" />	

<link href="base/jquery-ui.css" rel="stylesheet" type="text/css"/>
 <script src="jquery-ui.min.js"></script>

   <script>
  $(document).ready(function() {
   // $("#dob").datepicker();
	$( "#dob" ).datepicker({ minDate: "-18M", maxDate: "+2D" });
	});


//  });
  </script>
	<div class="section-title">Add Line list Test Results for Gachege Dispensary </div>
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
			    <td><div>
			<!--calendar-->
	 			 <input id="dob" type="text" name="sdrec" class="text"  size="20" ><span id="sdrecInfo"></span></div>


<div type="text" id="dob">
</div></td>
			<td><div><select name="patient_type" style="width:80px">
          <option value="0">Select Type</option>
          <option value="1">Stool</option>
          <option value="2">Blood</option>
		  <option value="3">CSF</option>
		    <option value="4">OPS</option>
        </select>  <span id="patient_type"></span></div></td>
			<td width="70"><input type="text" name="pid" size="15" class="text" id="pid" value=""/></td>
				<td width="41">&nbsp;</td>
			<td width="51">&nbsp;</td>
			<td  colspan="3" ><textarea name="labcomment" rows="3" cols="21"></textarea> </td>
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
			    <td><div>
			<!--calendar-->
	 			 <input id="dob" type="text" name="sdrec" class="text"  size="20" ><span id="sdrecInfo"></span></div>


<div type="text" id="dob">
</div></td>
			<td><div><select name="patient_type" style="width:80px">
          <option value="0">Select Type</option>
          <option value="1">Stool</option>
          <option value="2">Blood</option>
		  <option value="3">CSF</option>
		    <option value="4">OPS</option>
        </select>  <span id="patient_type"></span></div></td>
			<td width="70"><input type="text" name="pid" size="15" class="text" id="pid" value=""/></td>
				<td width="41">&nbsp;</td>
			<td width="51">&nbsp;</td>
			<td  colspan="3" ><textarea name="labcomment" rows="3" cols="21"></textarea></td>
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
			    <td><div>
			<!--calendar-->
	 			 <input id="dob" type="text" name="sdrec" class="text"  size="20" ><span id="sdrecInfo"></span></div>


<div type="text" id="dob">
</div></td>
			<td><div><select name="patient_type" style="width:80px">
          <option value="0">Select Type</option>
          <option value="1">Stool</option>
          <option value="2">Blood</option>
		  <option value="3">CSF</option>
		    <option value="4">OPS</option>
        </select>  <span id="patient_type"></span></div></td>
			<td width="70"><input type="text" name="pid" size="15" class="text" id="pid" value=""/></td>
				<td width="41">&nbsp;</td>
			<td width="51">&nbsp;</td>
			<td width="83" colspan="3" ><textarea name="labcomment" rows="3" cols="21"></textarea></td>
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
			    <td><div>
			<!--calendar-->
	 			 <input id="dob" type="text" name="sdrec" class="text"  size="20" ><span id="sdrecInfo"></span></div>


<div type="text" id="dob">
</div></td>
			<td><div><select name="patient_type" style="width:80px">
          <option value="0">Select Type</option>
          <option value="1">Stool</option>
          <option value="2">Blood</option>
		  <option value="3">CSF</option>
		    <option value="4">OPS</option>
        </select>  <span id="patient_type"></span></div></td>
			<td width="70"><input type="text" name="pid" size="15" class="text" id="pid" value=""/></td>
			<td width="41">A</td>
			<td width="51">&nbsp;</td>
			<td width="83" colspan="3" ><textarea name="labcomment" rows="3" cols="21"></textarea> </td>
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
			    <td><div>
			<!--calendar-->
	 			 <input id="dob" type="text" name="sdrec" class="text"  size="20" ><span id="sdrecInfo"></span></div>


<div type="text" id="dob">
</div></td>
			<td><div><select name="patient_type" style="width:80px">
          <option value="0">Select Type</option>
          <option value="1">Stool</option>
          <option value="2">Blood</option>
		  <option value="3">CSF</option>
		    <option value="4">OPS</option>
        </select>  <span id="patient_type"></span></div></td>
			<td width="70"><input type="text" name="pid" size="15" class="text" id="pid" value=""/></td>
				<td width="41">A</td>
			<td width="51">&nbsp;</td>
			<td width="83" colspan="3" ><textarea name="labcomment" rows="3" cols="21"></textarea> </td>
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
			    <td><div>
			<!--calendar-->
	 			 <input id="dob" type="text" name="sdrec" class="text"  size="20" ><span id="sdrecInfo"></span></div>


<div type="text" id="dob">
</div></td>
			<td><div><select name="patient_type" style="width:80px">
          <option value="0">Select Type</option>
          <option value="1">Stool</option>
          <option value="2">Blood</option>
		  <option value="3">CSF</option>
		    <option value="4">OPS</option>
        </select>  <span id="patient_type"></span></div></td>
		<td width="70"><input type="text" name="pid" size="15" class="text" id="pid" value=""/></td>
				<td width="41">&nbsp;</td>
			<td width="51">&nbsp;</td>
			<td width="83" colspan="3" ><textarea name="labcomment" rows="3" cols="21"></textarea></td>
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
			    <td><div>
			<!--calendar-->
	 			 <input id="dob" type="text" name="sdrec" class="text"  size="20" ><span id="sdrecInfo"></span></div>


<div type="text" id="dob">
</div></td>
			<td><div><select name="patient_type" style="width:80px">
          <option value="0">Select Type</option>
          <option value="1">Stool</option>
          <option value="2">Blood</option>
		  <option value="3">CSF</option>
		    <option value="4">OPS</option>
        </select>  <span id="patient_type"></span></div></td>
		<td width="70"><a href="#"></a><input type="text" name="pid" size="15" class="text" id="pid" value=""/></td>
				<td width="41">&nbsp;</td>
			<td width="51">&nbsp;</td>
			<td width="83" colspan="3" ><textarea name="labcomment" rows="3" cols="21"></textarea></td>
		</tr>
		<tr align="center">
		  	
            <td align="center" colspan="21">
			<input name="addonly" type="submit" class="button" value="Save Results" />
			<input name="reset" type="reset" class="button" value="Reset" /></td>
          </tr>
		</table>
	
        <?php include('footer.php');?>