<?php 
include('/connection/authenticate.php');
require_once('/connection/config.php');
require_once('classes/tc_calendar.php');
include('header.php');

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
	$( "#dateseen" ).datepicker({ minDate: "-18M", maxDate: "+2D" });
	});


//  });
  </script>
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
	
	function getLabtests(specimentaken) {		
		
		var strURL="getLabtests.php?rejid="+specimentaken;
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
		<div class="section-title"> <strong>LINE LISTING FORM </strong></div>
		<div class="xtop">
		<?php if ($autocode !="")
		{
		?> 
		<table   >
			<tr>
				<td style="width:auto" ><div class="success"><?php 
				
				echo  '<strong>'.' <font color="#666600">'. $savedcommunity . ' Community Unit Plan Successfully Saved'. '<br/>'.' Please Enter Details for the other Community Unit'   .'</strong>'.' </font>';
				
				?></div></th>
			</tr>
		</table>
<?php } ?>

				 <form id="customForm" method="get" action="" >

		
		  <table  border="0" class="data-table" >
		    <tr>
              <td colspan="4" width="414"><em>Enter required details below:-</em></td>
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
            <td><div>
			<!--calendar-->
	 			 <input id="datereceived" type="text" name="sdrec" class="text"  size="31" ><span id="sdrecInfo"></span></div>


<div type="text" id="datereceived">
</div>
	  		<!--end calendar-->	  		</td>
          </tr>
		  <tr>
            <td><span class="mandatory">*</span> Disease / Condition </td>
            <td><div><?php
	   $entryquery = "SELECT ID,name FROM diseases ";
			
			$result = mysql_query($entryquery) or die('Error, query failed'); //onchange='submitForm();'
	
	   echo "<select name='disease_type' id='disease_type' style='width:188px' ;>\n";
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
		  <table class="data-table" >
		  
		
            <th class="subsection-title" colspan="2">Patient Information</th>
          
          <tr>
            <td width="171"> Names </td>
            <td>
			<div>
<input type="text" name="pid" size="31" class="text" id="pid" value=""/><input name='cancelbatch' type='hidden' value='<?php echo $cancelbatch; ?>' /><span id="pidInfo"></span></div></td>
          </tr>
		  <tr>
            <td>Type </td>
            <td><div><select name="patient_type" style="width:157px">
          <option value="0">Select Patient Type</option>
          <option value="1">Out Patient</option>
          <option value="2">In Patient</option>
        </select>  <span id="patient_type"></span></div></td>
          </tr>
          <tr>
            <td>Sex</td>
            <td><input name="pgender" type="radio" value="M" />
              Male&nbsp;
              <input name="pgender" type="radio" value="F" />
              Female </td>
          </tr>
          <!-- <tr>
            <td>Date of Birth</td>
            <td><p><div><input id="dob" type="text" name="pdobb" class="text" size="31" ><span id="dobInfo"></span></div></p>


<div type="text" id="dob">
</div></td>
          </tr>-->
          <tr>
            <td> Age ( Age in years if more than 12months, otherwise indicate in months)</td>
            <td> <div>		<input type="text" value="0" name="age" size="18" id="age" class="text"/>
            Months
                <span id="ageInfo"></span></div>
              <div>		<input type="text" value="0" name="ageweeks" size="18" id="ageweeks" class="text"/>
                Years
            <span id="ageweeksInfo"></span></div>      </td>
          </tr>
		  
		  
         
            <th class="subsection-title" colspan="2">Visit Details </th>
         
          <tr>
            <td>Date seen at Health Facility </td>
            <td><div>
			<p> <input id="dateseen" type="text" name="sdoc" class="text"  size="31" ><span id="sdocInfo"></span></div>
			<div type="text" id="dateseen">
</div></td>
          </tr>
          <tr>
            <td>Date of Onset of Disease </td>
            <td><div>
			 <input id="dateonset" type="text" name="datedispatched" class="text"  size="31" ><span id="datedispatchedInfo"></span></div> 
			 <div type="text" id="dateonset">
</div></td>
          </tr>
          <tr>
            <td width="400px">Number of Doses of vaccine (exclude doses given within 14 days of onset)</td>
            <td><div><input type="text" name="pid" size="31" class="text" id="pid" value=""/> <span id="mentpointInfo"></span></div></td>
          </tr>
          
          
          
            <th class="subsection-title" colspan="2">Lab Tests </th>
         
          <tr>
            <td> Specimen taken </td>
            <td> <div> 
			<input name="specimentaken" type="radio" value="Y" onclick="getLabtests(this.value)" />
             Y&nbsp;
              <input name="specimentaken" type="radio" value="N" onclick="getLabtests(this.value)" />
              N 
		  <span id="spotInfo"></span></div></td>
          </tr>
          
		   <tr>
            <td colspan="2">  <div id="statediv"></div> </td>
           
          </tr>
		  
		 
		 		 
		  
		   <tr>
            <td>Lab Comments</td>
            <td>
			<!--calendar-->
	 			 <textarea name="labcomment" rows="3" cols="41"></textarea>
	  		<!--end calendar-->	  		</td>
          </tr>
          <tr align="center">
		  	<td></td>
            <td align="center">
			<input name="addonly" type="submit" class="button" value="Save List Form" />
     <input name="saveadd"  type="submit" class="button" value="Save & Add List Form"  onclick = "dis()" />
	

            <input name="reset" type="reset" class="button" value="Reset" /></td>
          </tr>
	</table>
		</form>
        </div>
		</div>
		
 <?php include('footer.php');?>