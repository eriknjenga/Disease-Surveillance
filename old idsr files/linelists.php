<?php 
include('/connection/authenticate.php');
require_once('/connection/config.php');
include('header.php');

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

<style type="text/css">
select {
width: 250;}
</style>

<script>
		window.dhx_globalImgPath="img/";
	</script>
<script type="text/javascript" src="validation.js"></script>
<script src="dhtmlxcombo_extra.js"></script>
 <link rel="STYLESHEET" type="text/css" href="dhtmlxcombo.css">
  <script src="dhtmlxcommon.js"></script>
  <script src="dhtmlxcombo.js"></script>


<link type="text/css" href="calendar.css" rel="stylesheet" />	

<link href="base/jquery-ui.css" rel="stylesheet" type="text/css"/>
 <script src="jquery-ui.min.js"></script>

 
   <script>
  $(document).ready(function() {
   // $("#datecollected").datepicker();
$( "#datecollected" ).datepicker({ minDate: "-18M", maxDate: "+12D" });

  });
  </script>
  
   <script>
  $(document).ready(function() {
   // $("#datedispatched").datepicker();
$( "#dateonset" ).datepicker({ minDate: "-18M", maxDate: "+0D" });

  });
  </script>
  
   <script>
  $(document).ready(function() {
    //$("#datereceived").datepicker();
$( "#datereceived" ).datepicker({ minDate: "-28D", maxDate: "+0D" });


  });
  </script>
<script language="javascript" type="text/javascript">
// Roshan's Ajax dropdown code with php
// This notice must stay intact for legal use
// Copyright reserved to Roshan Bhattarai - nepaliboy007@yahoo.com
// If you have any problem contact me at http://roshanbh.com.np
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	
	function getLineList(disease) {		
		
		var strURL="getLineList.php?rejid="+disease;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('statediv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	</script>
		<div  class="section">
		<div class="section-title"> <strong>IDSR HEALTH FACILITY LINE LISTIN FORM  FOR <?php echo strtoupper($districtname);?> DISTRICT </strong></div>
		<div class="xtop"></div>
		<div>
		 <form id="customForm" method="get" action="" >

		
		  <table  border="0" class="data-table" >
		    <tr>
              <td colspan="4" width="414"><em>Select Facility &amp; Disease to view facility line listin form </em></td>
            </tr>
			
          
          
          <tr>
            <td width="171"><span class="mandatory">*</span> Facility</td>
            <td width="352" colspan="3"><div>	<?php 
				if ($autocode !="")
{		
$facilityname=GetFacility($autocode);
echo "<input name='catname' type='text' id='catname'  class='textbox' value='$facilityname' size=45 />";
echo"<input name='cat' type='hidden' value='$autocode' />";
}
	else
	{	?>	
		  <select  style="width:262px"  id='cat' name="cat">
  </select>
  <script>
    var combo = dhtmlXComboFromSelect("cat");
	combo.enableFilteringMode(true,"get_district_facilitys.php",true);
	
		

	

</script>
	<?php }
?>
		<br>	<span id='codeInfo'></span></div></td>
          </tr>
		  <tr>
            <td><span class="mandatory">*</span> Date Received </td>
           
		    <td><table>
			<tr>
  <td><input name="pgender" type="radio" value="M" /></td>
    <td >   
	
	<div>
			<!--calendar-->
	 			 <input id="datereceived" type="text" name="sdrec" class="text"  size="31" ></div>


<div type="text" id="datereceived"></div>	</td>  
    <td colspan="2"> Or </td>

	 
  </tr>
  <tr>
  <td><input name="pgender" type="radio" value="M" /></td>
    <td >   
	
	<div>
			<!--calendar-->
	 			 <input id="dateonset" type="text" name="sdrec" class="text"  size="31" ></div>


<div type="text" id="dateonset"></div>	</td>  <td> To </td>

	   <td >   
	
	<div>
			<!--calendar-->
	 			 <input id="datecollected" type="text" name="sdrec" class="text"  size="31" ></div>


<div type="text" id="datecollected"></div>	</td>
  </tr>
</table>

	  		<!--end calendar-->	  		</td>
          </tr>
		  <tr>
            <td><span class="mandatory">*</span> Disease / Condition </td>
            <td><div><?php
	   $entryquery = "SELECT ID,name FROM diseases ";
			
			$result = mysql_query($entryquery) or die('Error, query failed'); //onchange='submitForm();'
	
	   echo "<select name='disease' id='disease' style='width:188px' onchange='getLineList(this.value)' ;>\n";
	    echo " <option value=''> Select Disease </option>";

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
	  ?> <span id="mentpointInfo"></span></div></td>
          </tr>
          </table>
		 	<table class="data-table">
		<tr>
          <td  colspan="7"> &nbsp; <div id="statediv"></div> </td>
           
          </tr></table> </form>
	
		</div>
		
 <?php include('footer.php');?>