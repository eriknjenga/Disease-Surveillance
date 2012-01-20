s<?php 
require_once('connection/config.php');
$link = 'add_district';
include('national_header.php');
//get the district information
$name=$_GET['name'];
$province=$_GET['province'];
$comment=$_GET['comment'];

$success=$_GET['p'];
//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
//check for duplicate facility code
$qry = "SELECT * FROM districts WHERE name='$name' AND province='$province'";
		$result = mysql_query($qry);
		if($result)
		 {
			if(mysql_num_rows($result) > 0)
			 {
				$errmsg_arr[]= 'District already added, enter another one';
				$errflag = true;
			}
			@mysql_free_result($result);
		}
		else 
		{
			die("failed");
		}
//save the district details
if ($_REQUEST['save'])
{	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		
	}
	else
	{
		$districts = Savedistrict($name,$province,$comment);
		if ($districts) //check if all records entered
		{
				$st="District: ".$name.", ". "has been added.";
				//header("location:districtslist.php?p=$st"); //direct to users list view
			  	echo '<script type="text/javascript">' ;
				echo "window.location.href='districtslist.php?p=$st'";
				echo '</script>';

		}
		else
		{
				$st="Save District Failed, please try again.";
		
		}
	}

}
else if ($_REQUEST['add'])
{  if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		
	}
	else
	{
		$districts = Savedistrict($name,$province,$comment);
		if ($districts) //check if all records entered
		{
				$st="District: ".$name.", ". "has been added.";
					echo '<script type="text/javascript">' ;
echo "window.location.href='national_add_district.php?p=$st'";
echo '</script>';

		}
		else
		{
				$st="Save District Failed, please try again.";
		
		}
	}

}
//end of saving user details


?>
<style type="text/css">
select {
width: 250;}
</style>
<script type="text/javascript" src="includes/validatedistricts.js"></script>
<link rel="stylesheet" href="includes/validation.css" type="text/css" media="screen" />

		<div>
		
		<div class="section-title">ADD DISTRICT </div>
		
		<!--*********************************************************************** -->
		<div class="xtop">
		<?php  //validation errors
	if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<table>
				  <tr>
					<td style="width:auto" ><div class="error">';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
			echo '<strong>'.$msg . '</strong>'; 
		}
		echo '</div></td>
				  </tr>
				</table>';
		unset($_SESSION['ERRMSG_ARR']);
	}
?>
		<!--display the save message -->
				<?php if ($success !="")
				{
				?> 
				<table>
				  <tr>
					<td style="width:auto" >
					<div class="success">
					<?php echo  '<strong>'.' <font color="#666600">'.$success.'</strong>'.' </font>';?>
					</div>
					</td>
				  </tr>
				</table>
				<?php } ?>
				<?php if ($st !="")
						{
						?> 
						<table   >
				  <tr>
					<td style="width:auto" >
					<div class="error">
					<?php echo  '<strong>'.' <font color="#666600">'.$st.'</strong>'.' </font>';?></div>
					</td>
				  </tr>
				</table>
				<?php } ?>
		<!-- end display the save message -->
		</div>
		<!--*********************************************************************** -->
		
		<form id="customForm"  method="get" action=""  >
		<table>
			<tr>
              <td width="444"><em>The fields indicated asterix (<span class="mandatory">*</span>) are mandatory.</em></td>
            </tr>
			
		</table>
		<div>
		  <table border="0" class="data-table">
		  	
            <tr>
              <td colspan="2" class="subsection-title">District Information </td>
            </tr>
            
            <tr>
              <td><span class="mandatory">* </span>Name</td>
              <td ><div><input type="text" name="name" id="name" size="20" class="text" /><span id='nameInfo'></span></div></td>
            </tr>
            <tr>
              <td><span class="mandatory">* </span>Province</td>
              <td ><div><?php
		   		$groupquery = "SELECT ID,name FROM provinces";
				
				$result = mysql_query($groupquery) or die('Error, query failed'); 
		
				   echo "<select name='province' id='province' ;>\n";
					echo " <option value=''> Select Province </option>";
				  //Now fill the table with data
				  while ($row = mysql_fetch_array($result))
				  {
						 $ID = $row['ID'];
						$name = $row['name'];
					echo "<option value='$ID'> $name</option>\n";
				  }
				  echo "</select>\n";
		  	?><span id='provInfo'></span></div></td>
            </tr>
            <tr>
              <td>Comment / Description (if any) </td>
              <td><textarea name="comment" rows="3" cols="44"></textarea></td>
            </tr>
            <tr >
              <td></td>
              <td colspan="3">
		  	    <input name="save" type="submit" class="button" value="Save District" />
		  	    <input name="add" type="submit" class="button" value="Save & Add District" />
		  	    <input name="reset" type="submit" class="button" value="Reset" /></td>
            </tr>
          </table>
		  </div>
		  </form>
		</div>
		</div>
		
 <?php include('../includes/footer.php');?>