<?php 
include('/connection/authenticate.php');
require_once('/connection/config.php');
require_once('classes/tc_calendar.php');
include('header.php');

$sessionuserid = $_SESSION['id']; 
$sessionaccounttype = $_SESSION['accounttype']; 
$autocode=$_GET['q']; //facility code
$savedcommunity=$_GET['p'];
$districtdetails = GetDistrictInfo($sessionaccounttype);

$districtname = $districtdetails['name'];

$currentyear = date('Y');	
$yearsago = $currentyear - 5;
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
	$( "#datereceived" ).datepicker({ minDate: "-18M", maxDate: "+2D" });
	});


//  });
  </script>

		<div  class="section">
		<div class="section-title"> <strong>ADD &ge; 5 Years Disease Survey </strong></div>
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

				 <!--<form id="customForm" method="get" action="" > -->
				 
				 <table>
				 <tr>
				 	<td>Week Ending</td>
					<td>
					<?php
						 $myCalendar = new tc_calendar("endmonth", true);
						  $myCalendar->setDate(date('d'), date('m'), date('Y'));
						  $myCalendar->setPath("calendar/");
						  $myCalendar->setYearInterval($yearsago, $currentyear);
						  //$myCalendar->dateAllow('1960-01-01', '2015-03-01');
						  $myCalendar->writeScript();	
					?>
					</td>
				 </tr>
				<?php 
				if ($autocode !="")
				{		
				?>
					<tr>
						<td> Select Health Facility </td>
						<td >
							<div class="notice">
							<?php 
							$facilityname=GetFacility($autocode);
							echo '<strong>'.$facilityname.'</strong>';
							echo"<input name='facility' type='hidden' value='$autocode' />";
							?>
							</div>
						</td>
					</tr>
				<?php
				
				}
				else
				{	?>
			 <tr>
			
              <td><span class="mandatory">* </span>Health Facility </td>
              <td ><strong>
                 <select  style="width:262px"  id='cat' name="cat">
    
  </select>
  <script>
    var combo = dhtmlXComboFromSelect("cat");
	combo.enableFilteringMode(true,"get_district_facilitys.php",true);
	
		

	

</script>
              </strong></td>
			 </tr>
		    <?php } ?>
		   </table>
		   
			   <table class="data-table">						
					  <th>No.</th>
					  <th>Disease</th>
					  <th colspan="2" >Cases</th>
					  <th colspan="2" >Deaths</th>
				  
				  <tr class="even">
					  <td colspan="2">&nbsp;</td>
					  <th >Males</th>
					  <th >Females</th>
					  <th >Males</th>
					  <th >Females</th>
				  </tr>
				<?php 
				 //ORDER BY name ASC
				
				$qury = "SELECT id,name,type FROM diseases WHERE id!= 12";			
				$result = mysql_query($qury) or die('Error, query failed');
				$no=mysql_num_rows($result);
				
				if ($no !=0)
				{
				// print the districts info in table
				
					 $k = 0;
					 $i = 0;
					$samplesPerColumn = 1; 
					
					$count = 0;
					
					while(list($id,$name,$type) = mysql_fetch_array($result))
					{  
						$count++;
						
							if ($k % $samplesPerColumn == 0) 
							{								
								echo '<tr class="even">';
							}
					
						?> 
				<td><?php echo $count.")";?></td>
				<td ><?php echo $name;?> <input type="hidden" name="testid[]" value="<?php echo $id;?>" /></td>
				<td><input type="text" class="text" name="mcase[]" size="7" value="0"/></td>
				<td><input type="text" class="text" name="fcase[]" size="7" value="0"/></td>
				<td><input type="text" class="text" name="mdeath[]" size="7" value="0"/></td>
				<td><input type="text" class="text" name="fdeath[]" size="7" value="0"/></td>
				
				<?php
					
					  if ($k % $samplesPerColumn == $samplesPerColumn - 1) {
							echo '</tr>';
						}
						
						$k += 1;
					}
					
					}
					?>
				</tr>
				 <tr >
				  <td></td>
				  <td colspan="6">
					<input name="save" type="submit" class="button" value="Save " />
					<input name="add" type="submit" class="button" value="Save & Continue " />
					<input name="reset" type="submit" class="button" value="Reset" /></td>
				</tr>
				</table>
			
				<!-- </form> -->
		
		</div>
		</div>
		
 <?php include('footer.php');?>