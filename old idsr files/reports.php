<?php 
include('header2.php');

$sessionuserid = $_SESSION['id']; 
$sessionaccounttype = $_SESSION['accounttype']; 

$mwaka=$_GET['year'];
$mwezi=$_GET['mwezi'];

$displaymonth=GetMonthName($mwezi);
if (isset($mwaka))
{
	if (isset($mwezi))
	{
	$defaultmonth=$displaymonth .' - '.$mwaka ; //get current month and year
	$currentmonth=$mwezi;
	$currentyear=$mwaka;
	
	}
	else
	{
	$defaultmonth=$mwaka ; //get current month and year
	$currentmonth=0;
	//get current month and year
	$currentyear=$mwaka;
	
	
	
	}
}
else
{
$defaultmonth=date("M-Y"); //get current month and year
$currentmonth=date("m");
$currentyear=date("Y");
}

$province=$_GET['province']; // Use this line or below line if register_global is off

$provincequery=mysql_query("select Name from provinces where ID='$province'")or die(mysql_error());
$provarray=mysql_fetch_array($provincequery);
$provincename=$provarray['Name'];

if ($_REQUEST['districtfilter'])
{
$dcode=$_POST['dcode']; // Use this line or below line if register_global is off
$dname=GetDistrictName($dcode);

if ($dcode !="")
{
$dist= ",". '<u>'.$dname . " District" .'</u>';
}
else
{
$dist="";


}
//echo "District: ".$dname . " - ".$currentyear ." / " .$currentmonth;
}
if ($_REQUEST['facilityfilter'])
{
//$fcode=$_POST['fcode']; // Use this line or below line if register_global is off
$fcode=  $_POST['cat'];
$fname=GetFacilityName($fcode);
//facility

if ($fcode !="")
{
$dist= ",". '<u>'.$fname .'</u>';
}
else
{
$dist="";


}
//echo "Facility: ".$fname . " - ".$currentyear ." / " .$currentmonth;

if (!(isset($fcode)))
{
$fcode=0;
}
if (!(isset($dcode)))
{
$dcode=0;
}
 
}
?>
<script type="text/javascript" src="includes/jquery.min.js"></script>
<script type="text/javascript" src="includes/jquery.js"></script>
<script type='text/javascript' src='includes/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="includes/jquery.autocomplete.css" />
<script type="text/javascript">
$().ready(function() {
	
	$("#facility").autocomplete("get_facility.php?prov=<?php echo $province; ?>", {
		width: 260,
		matchContains: true,
		mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	
	$("#facility").result(function(event, data, formatted) {
		$("#fcode").val(data[1]);
	});
});
</script>
<script type="text/javascript">
$().ready(function() {
	
	$("#district").autocomplete("get_district.php?prov=<?php echo $province; ?>", {
		width: 260,
		matchContains: true,
		mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	
	$("#district").result(function(event, data, formatted) {
		$("#dcode").val(data[1]);
	});
});
</script>

	<script language="JavaScript" src="scripts/FusionMaps.js"></script>
	<script language="JavaScript" src="scripts/FusionCharts.js"></script>
<script>
		window.dhx_globalImgPath="../img/";
	</script>
<script src="dhtmlxcombo_extra.js"></script>
 <link rel="STYLESHEET" type="text/css" href="dhtmlxcombo.css">
  <script src="dhtmlxcommon.js"></script>
  <script src="dhtmlxcombo.js"></script>

<div class="section-title">Alert Reports </div>	
		 <form id="customForm" method="get" action="" target="_blank"  >
   <table class="data-table" >
          <!-- <tr>
            <td>Date of Birth</td>
            <td><p><div><input id="dob" type="text" name="pdobb" class="text" size="31" ><span id="dobInfo"></span></div></p>


<div type="text" id="dob">
</div></td>
          </tr>-->
		  <tr class="even">
            <td width="171" class="data-table">Select  Epi Week</td>
            <td>
			<?php
			$maximumyear=52;
			$lowestdate=1;
			$years = range ($maximumyear, $lowestdate); 
			
			// Make the years pull-down menu.
			echo '<select name="monthyear" style"width=100px" >';
				foreach ($years as $value)
			 	{
					echo "<option value=\"$value\">$value</option>\n";
				}
				
			echo '</select>';
	   
	  ?> 	</td>
          </tr>
		 
		 
		  <tr class="even">
            <td >Select Criteria</td>
            <td>
			<table cellspacing="2" cellpadding="2" border="0">
	<tr>
	<td> <input type="radio" name="radio" value="radio1" /> </td>
	<td colspan="2"> Overall </td>
	
   </tr>
	<tr>
	<td> <input type="radio" name="radio" value="radio2" /> </td>
	<td> Province </td>
	<td><?php
	   $pmtctquery = "SELECT ID,name FROM provinces ";
			
			$result = mysql_query($pmtctquery) or die('Error, query failed'); //onchange='submitForm();'
	
	   echo "<select name='province' id='province' style='width:230px';>\n";
	    echo " <option value=''> Select Province  </option>";

     // echo "<option>-- Select Group --</option>\n";
   // echo "<option>--  --</option>\n";
      //Now fill the table with data
      while ($row = mysql_fetch_array($result))
      {
             $ID = $row['ID'];
			$name = $row['name'];
        echo "<option value='$ID'> $name</option>\n";
      }
      echo "</select>\n";
	  ?></td> 
   </tr>
<tr>
<td> <input type="radio" name="radio" value="radio3" /> </td>
	<td> District </td>
	<td><select  style="width:230px"  id='dcode' name="dcode">
    
  </select>  
  <script>
    var combo = dhtmlXComboFromSelect("dcode");
	combo.enableFilteringMode(true,"getalldistricts.php",true);
	

</script></td> 
   </tr>
   <tr>
   <td> <input type="radio" name="radio" value="radio4" /> </td>
    <td> Facility </td>
	<td><select  style="width:230px"  id='fcode' name="fcode">
    
  </select>  
  <script>
    var combo = dhtmlXComboFromSelect("fcode");
	combo.enableFilteringMode(true,"getallfacilitys.php",true);
	

</script></td> 
  
   </tr>
   
</table>
		    </td>
          </tr>
          <tr align="center">
		  	
            <td align="center" colspan="2">
			<input name="generatereport" type="submit" class="button" value="Generate Report" /></td>
          </tr>
		  
	</table>
</form>  
	
 <?php include('footer.php');?>