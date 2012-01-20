<?php
include('admin_header.php');
//get the search variable
$searchparameter = $_GET['search'];
$success = $_GET['p'];

?>
<script type="text/javascript" src="../includes/jquery.min.js"></script>
<script type="text/javascript" src="../includes/jquery.js"></script>
<script type='text/javascript' src='../includes/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="../includes/jquery.autocomplete.css" />
<script type="text/javascript">
$().ready(function() {
	
	$("#facility").autocomplete("get_facility.php", {
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
<div>
	<div class="section-title">FACILITITES LIST</div>
	<?php if ($success !="")
		{
		?> 
		<table>
  			<tr>
    			<td style="width:auto" ><div class="success"><?php echo  '<strong>'.' <font color="#666600">'.$success.'</strong>'.' </font>';?></div></td>
  			</tr>
		</table>
	<?php 
		} 
	
			$showfacility = "SELECT id,facilitycode,name,district,ftype, FROM facilitys WHERE flag = 1";
			
			$displayfacilities = @mysql_query($showfacility) or die(mysql_error());
			$facilitycount = mysql_num_rows($displayfacilities);
		
if ($facilitycount != 0)
{		
	$rowsPerPage = 20; //number of rows to be displayed per page

		// by default we show first page
		$pageNum = 1;
		
		// if $_GET['page'] defined, use it as page number
		if(isset($_GET['page']))
		{
		$pageNum = $_GET['page'];
		}
		
		// counting the offset
		$offset = ($pageNum - 1) * $rowsPerPage;
		
	if (empty($searchparameter))
	{
		echo "Total Facilities:<strong>" .GetTotalFacilities();	
		echo "</strong>";
		
			?>
				<div>
					<form name="filterform" method="get">
					<table border="0"   >
					<tr>
					<td>Province</td>
					<td><!--show the lab types -->
					<?php
				   $accountquery = "SELECT ID,name FROM provinces";
						
					$result = mysql_query($accountquery) or die('Error, query failed'); //onchange='submitForm();'
				
				   echo "<select name='prov';>\n";
					echo " <option value=''> Select One </option>";
					
				  while ($row = mysql_fetch_array($result))
				  {
						 $ID = $row['ID'];
						$name = $row['name'];
					echo "<option value='$ID'> $name</option>\n";
				  }
				  echo "</select>\n";
				  	?>
					<input type="submit" name="provincefilter" value="Filter" class="button"/><br/>
					</td>
					<td> | </td>
					<td>District</td>
					  <td>
					  <?php
				   $accountquery = "SELECT ID,name FROM districts";
						
					$result = mysql_query($accountquery) or die('Error, query failed'); //onchange='submitForm();'
				
				   echo "<select name='district';>\n";
					echo " <option value=''> Select One </option>";
					
				  while ($row = mysql_fetch_array($result))
				  {
						 $ID = $row['ID'];
						$name = $row['name'];
					echo "<option value='$ID'> $name</option>\n";
				  }
				  echo "</select>\n";
				  ?><input type="submit" name="districtfilter" value="Filter" class="button"/><br/>
					  </td>
					  <td> | </td>
					<td>Facility</td>
					  <td>
					
					  <input name="facility" id="facility" type="text" class="text" size="25" />
					    <input type="hidden" name="fcode" id="fcode" />&nbsp; 
					 		  <input type="submit" name="facilityfilter" value="Search" class="button"/>
					<br/>
					  </td>
					</tr>
					
					
					
					
					
					</table>
					</form>
				</div>
		
			<?php
			
			if ($_REQUEST['provincefilter'])
			{
				$provid = $_GET['prov'];
				
				///////GET PROVINCE NAME///////////////////////////////////////////////////////////////////////////////////////////////////////
				$provname=GetProvname($provid);
				///////END GET PROVINE NAME////////////////////////////////////////////////////////////////////////////////////////////////////
				
				///////GET FACILITY COUNT////////////////////////////////////////////////////////////////////////////////////////////////////				
				$showprovincefacility = "SELECT  f.ID,f.facilitycode,f.name,f.district,f.ftype,FROM facilitys f, districts d WHERE f.district = d.ID AND d.province = $provid";
				
				$displayprovincefacilities = @mysql_query($showprovincefacility) or die(mysql_error());
				
				$displayprovincefacilitiescount = mysql_num_rows($displayprovincefacilities);				
				///////END GET FACILITY COUNT////////////////////////////////////////////////////////////////////////////////////////////////////
				
				echo "The filter for <strong>$provname</strong> returned <strong>$displayprovincefacilitiescount</strong> results. <a href='facilitieslist.php'><strong>Click here to refresh page.</strong></a>";
				
				/////get the facilities
				$showprovincefacility = "SELECT f.ID,f.facilitycode,f.name,f.district,f.ftype FROM facilitys f, districts d WHERE f.district = d.ID AND d.province = $provid LIMIT $offset, $rowsPerPage";
				
				$displayprovincefacilities = @mysql_query($showprovincefacility) or die(mysql_error());
				
				//end get facilities
				
				echo "<table border=0  class='data-table'>
			<tr ><th>Facility Code</th><th>Facility Name</th><th>District</th><th>Province</th><th>Task</th></tr>";
					
				//list the variables that you would like to get
				while(list($ID,$facilitycode,$name,$district,$ftype,$telephone,$telephone2,$email,$contactperson,$PostalAddress ) = mysql_fetch_array($displayprovincefacilities))
				{  
					//get select district name and province id	
					$distname=GetDistrictName($district);
					//get province ID
					$provid=GetProvid($district);
					
							echo "<tr class='even'>
									<td >$facilitycode</td>
									<td >$name</td> 
									<td >$distname</td> 
								<td >$provname</td>
									<td ><a href=\"facilitydetails.php" ."?ID=$ID" . "\" title='Click to view Facility Details'>View </a> | <a href=\"editfacility.php" ."?ID=$ID" . "\" title='Click to view Facility Details'>Edit</a>  |  <a href=\"deletefacility.php" ."?ID=$ID&fname=$name" . "\" title='Click to Delete Facility' OnClick=\"return confirm('Are you sure you want to delete Worksheet $name');\" >Delete   </a>
							</td>
								</tr>";
				}
				echo "</table>";
			
				$numrows=$displayprovincefacilitiescount; //get total no of batches
				
					// how many pages we have when using paging?
					$maxPage = ceil($numrows/$rowsPerPage);
				
				// print the link to access each page
				$self = $_SERVER['PHP_SELF'];
				$nav  = '';
				for($page = 1; $page <= $maxPage; $page++)
				{
				   if ($page == $pageNum)
				   {
					  $nav .= " $page "; // no need to create a link to current page
				   }
				   else
				   {
					  $nav .= " <a href=\"$self?page=$page\">$page</a> ";
				   }
				}
				
				// creating previous and next link
				// plus the link to go straight to
				// the first and last page
				
				if ($pageNum > 1)
				{
				   $page  = $pageNum - 1;
				   $prev  = " <a href=\"$self?page=$page\"> | Prev </a> ";
				
				   $first = " <a href=\"$self?page=1\"> First Page </a> ";
				}
				else
				{
				   $prev  = '&nbsp;'; // we're on page one, don't print previous link
				   $first = '&nbsp;'; // nor the first page link
				}
				
				if ($pageNum < $maxPage)
				{
				   $page = $pageNum + 1;
				   $next = " <a href=\"$self?page=$page\"> | Next |</a> ";
				
				   $last = " <a href=\"$self?page=$maxPage\">Last Page</a> ";
				}
				else
				{
				   $next = '&nbsp;'; // we're on the last page, don't print next link
				   $last = '&nbsp;'; // nor the last page link
				}
				
				// print the navigation link
				echo '<center>'. $first . $prev . $next . $last .'</center>';
				exit();
			}
			else if ($_REQUEST['facilityfilter'])
			{
				$fcode = $_GET['fcode'];
				$fname = $_GET['facility'];
				///////////////////////////////////////////////////////////////////////////////////////////
				
				///////GET FACILITY COUNT////////////////////////////////////////////////////////////////////////////////////////////////////				
				$showprovincefacility = "SELECT ID,facilitycode,name,district,ftype,telephone,telephone2,ContactEmail,contactperson,PostalAddress FROM facilitys WHERE ID ='$fcode'";
				
				$displayprovincefacilities = @mysql_query($showprovincefacility) or die(mysql_error());
				
				$displayprovincefacilitiescount = mysql_num_rows($displayprovincefacilities);				
				///////END GET FACILITY COUNT////////////////////////////////////////////////////////////////////////////////////////////////////
				
				echo "The filter for <strong>$provname</strong> returned <strong>$displayprovincefacilitiescount</strong> results. <a href='facilitieslist.php'><strong>Click here to refresh page.</strong></a>";
				
				/////get the facilities
				$showprovincefacility = "SELECT ID,facilitycode,name,district,ftype,telephone,telephone2,ContactEmail,contactperson,PostalAddress FROM facilitys WHERE ID ='$fcode' ";
				
				$displayprovincefacilities = @mysql_query($showprovincefacility) or die(mysql_error());
				
				//end get facilities
				
				echo "<table border=0  class='data-table'>
			<tr ><th>Facility Code</th><th>Facility Name</th><th>District</th><th>Province</th><th>Land Line</th><th>Mobile No</th><th>Address</th><th>Email Address</th><th>Contact Person</th><th>Task</th></tr>";
					
				//list the variables that you would like to get
				while(list($ID,$facilitycode,$name,$district,$ftype,$telephone,$telephone2,$email,$contactperson,$PostalAddress ) = mysql_fetch_array($displayprovincefacilities))
				{  
					//get select district name and province id	
					$distname=GetDistrictName($district);
					//get province ID
					$provid=GetProvid($district);
					
							echo "<tr class='even'>
									<td >$facilitycode</td>
									<td >$name</td> 
									<td >$distname</td> 
								<td >$provname</td>
									<td >$telephone</td>
									<td >$telephone2</td>
									<td>$PostalAddress </td>
									<td ><a href='mailto:$email'>$email</a></td>
									<td >$contactperson</td>
									<td ><a href=\"facilitydetails.php" ."?ID=$ID" . "\" title='Click to view Facility Details'>View </a> | <a href=\"editfacility.php" ."?ID=$ID" . "\" title='Click to view Facility Details'>Edit</a>  |  <a href=\"deletefacility.php" ."?ID=$ID&fname=$name" . "\" title='Click to Delete Facility' OnClick=\"return confirm('Are you sure you want to delete Worksheet $name');\" >Delete   </a>
							</td>
								</tr>";
				}
				echo "</table>";
			exit();
		
			}
			else if ($_REQUEST['districtfilter'])
			{
				$district = $_GET['district'];
				
				///////GET DISTRICT NAME///////////////////////////////////////////////////////////////////////////////////////////////////////
				$distname=GetDistrictName($district);
				///////END GET DISTRICT NAME////////////////////////////////////////////////////////////////////////////////////////////////////
				
				///////GET DISTRICT FACILITY COUNT////////////////////////////////////////////////////////////////////////////////////////////////////				
				$showdistrictfacility = "SELECT ID,facilitycode,name,district,ftype,telephone,telephone2,ContactEmail,contactperson,PostalAddress FROM facilitys  WHERE district = '$district'";
				
				$displaydistrictfacilities = @mysql_query($showdistrictfacility) or die(mysql_error());
				
				$displaydistrictfacilitiescount = mysql_num_rows($displaydistrictfacilities);				
				///////END COUNT////////////////////////////////////////////////////////////////////////////////////////////////////
				
				echo "The filter for <strong>$distname</strong> returned <strong>$displaydistrictfacilitiescount</strong> results. <a href='facilitieslist.php'><strong>Click here to refresh page.</strong></a>";
				
				/////get the facilities
				$showdistrictfacility = "SELECT ID,facilitycode,name,district,ftype,telephone,telephone2,ContactEmail,contactperson,PostalAddress FROM facilitys WHERE district = '$district' LIMIT $offset, $rowsPerPage";
				
				$displaydistrictfacilities = @mysql_query($showdistrictfacility) or die(mysql_error());
				
				//end get facilities
				
				echo "<table border=0  class='data-table'>
			<tr ><th>Facility Code</th><th>Facility Name</th><th>District</th><th>Province</th><th>Land Line</th><th>Mobile No</th><th>Address</th><th>Email Address</th><th>Contact Person</th><th>Task</th></tr>";
					
				//list the variables that you would like to get
				while(list($ID,$facilitycode,$name,$district,$ftype,$telephone,$telephone2,$email,$contactperson,$PostalAddress ) = mysql_fetch_array($displaydistrictfacilities))
				{  
					//get province ID
					$provid=GetProvid($district);
					$provname=GetProvname($provid);
							echo "<tr class='even'>
									<td >$facilitycode</td>
									<td >$name</td> 
									<td >$distname</td> 
								<td >$provname</td>
									<td >$telephone</td>
									<td >$telephone2</td>
									<td>$PostalAddress </td>
									<td ><a href='mailto:$email'>$email</a></td>
									<td >$contactperson</td>
									<td ><a href=\"facilitydetails.php" ."?ID=$ID" . "\" title='Click to view Facility Details'>View </a> | <a href=\"editfacility.php" ."?ID=$ID" . "\" title='Click to view Facility Details'>Edit</a>  |  <a href=\"deletefacility.php" ."?ID=$ID&fname=$name" . "\" title='Click to Delete Facility' OnClick=\"return confirm('Are you sure you want to delete Worksheet $name');\" >Delete   </a>
							</td>
								</tr>";
				}
				echo "</table>";
			
				$numrows=$displaydistrictfacilitiescount; //get total no of batches
				
					// how many pages we have when using paging?
					$maxPage = ceil($numrows/$rowsPerPage);
				
				// print the link to access each page
				$self = $_SERVER['PHP_SELF'];
				$nav  = '';
				for($page = 1; $page <= $maxPage; $page++)
				{
				   if ($page == $pageNum)
				   {
					  $nav .= " $page "; // no need to create a link to current page
				   }
				   else
				   {
					  $nav .= " <a href=\"$self?page=$page\">$page</a> ";
				   }
				}
				
				// creating previous and next link
				// plus the link to go straight to
				// the first and last page
				
				if ($pageNum > 1)
				{
				   $page  = $pageNum - 1;
				   $prev  = " <a href=\"$self?page=$page\"> | Prev </a> ";
				
				   $first = " <a href=\"$self?page=1\"> First Page </a> ";
				}
				else
				{
				   $prev  = '&nbsp;'; // we're on page one, don't print previous link
				   $first = '&nbsp;'; // nor the first page link
				}
				
				if ($pageNum < $maxPage)
				{
				   $page = $pageNum + 1;
				   $next = " <a href=\"$self?page=$page\"> | Next |</a> ";
				
				   $last = " <a href=\"$self?page=$maxPage\">Last Page</a> ";
				}
				else
				{
				   $next = '&nbsp;'; // we're on the last page, don't print next link
				   $last = '&nbsp;'; // nor the last page link
				}
				
				// print the navigation link
				echo '<center>'. $first . $prev . $next . $last .'</center>';
				exit();
			
			}
			
			//display normal view
			echo "<table border=0  class='data-table'>
			<tr ><th>Facility Code</th><th>Facility Name</th><th>District</th><th>Province</th><th>Land Line</th><th>Mobile No</th><th>Address</th><th>Email Address</th><th>Contact Person</th><th>Task</th></tr>";
					
			$showfacility = "SELECT ID,facilitycode,name,district,ftype,telephone,telephone2,email,contactperson,PostalAddress FROM facilitys WHERE flag = 1 LIMIT $offset, $rowsPerPage";
			
			$displayfacilities = @mysql_query($showfacility) or die(mysql_error());
			
			//list the variables that you would like to get
			while(list($ID,$facilitycode,$name,$district,$ftype,$telephone,$telephone2,$email,$contactperson,$PostalAddress ) = mysql_fetch_array($displayfacilities))
			{  //get select district name and province id	
		$distname=GetDistrictName($district);
		//get province ID
		$provid=GetProvid($district);
			//get province name	
		$provname=GetProvname($provid);
				//display the facility name
				//$facilityname = GetFacility($ID);
				//display the facility information as well as the facility name and type
				echo "<tr class='even'>
						<td >$facilitycode</td>
						<td >$name</td> 
						<td >$distname</td> 
					<td >$provname</td>
						<td >$telephone</td>
						<td >$telephone2</td>
						<td>$PostalAddress </td>
						<td ><a href='mailto:$email'>$email</a></td>
						<td >$contactperson</td>
						<td ><a href=\"facilitydetails.php" ."?ID=$ID" . "\" title='Click to view Facility Details'>View </a> | <a href=\"editfacility.php" ."?ID=$ID" . "\" title='Click to view Facility Details'>Edit</a>  |  <a href=\"deletefacility.php" ."?ID=$ID&fname=$name" . "\" title='Click to Delete Facility' OnClick=\"return confirm('Are you sure you want to delete Worksheet $name');\" >Delete   </a>
				</td>
					</tr>";
			}echo "</table>";
		
			$numrows=GetTotalFacilities(); //get total no of batches
			
				// how many pages we have when using paging?
				$maxPage = ceil($numrows/$rowsPerPage);
			
			// print the link to access each page
			$self = $_SERVER['PHP_SELF'];
			$nav  = '';
			for($page = 1; $page <= $maxPage; $page++)
			{
			   if ($page == $pageNum)
			   {
				  $nav .= " $page "; // no need to create a link to current page
			   }
			   else
			   {
				  $nav .= " <a href=\"$self?page=$page\">$page</a> ";
			   }
			}
			
			// creating previous and next link
			// plus the link to go straight to
			// the first and last page
			
			if ($pageNum > 1)
			{
			   $page  = $pageNum - 1;
			   $prev  = " <a href=\"$self?page=$page\"> | Prev </a> ";
			
			   $first = " <a href=\"$self?page=1\"> First Page </a> ";
			}
			else
			{
			   $prev  = '&nbsp;'; // we're on page one, don't print previous link
			   $first = '&nbsp;'; // nor the first page link
			}
			
			if ($pageNum < $maxPage)
			{
			   $page = $pageNum + 1;
			   $next = " <a href=\"$self?page=$page\"> | Next |</a> ";
			
			   $last = " <a href=\"$self?page=$maxPage\">Last Page</a> ";
			}
			else
			{
			   $next = '&nbsp;'; // we're on the last page, don't print next link
			   $last = '&nbsp;'; // nor the last page link
			}
			
			// print the navigation link
			echo '<center>'. $first . $prev . $next . $last .'</center>';
	}
		
	else if (!empty($searchparameter))
	{
		$showfacility = "SELECT ID, facilitycode,LTRIM(RTRIM(name)),district,telephone,telephone2,email,contactperson,PostalAddress  FROM facilitys WHERE name LIKE '%$searchparameter%' AND flag = 1";
		
		$displayfacilities = @mysql_query($showfacility) or die(mysql_error());
		
		$showfacilitycount = mysql_num_rows($displayfacilities);
		
		echo "The search for <strong>$searchparameter</strong> returned <strong>$showfacilitycount</strong> results.<a href='facilitieslist.php'><strong>Click here to refresh page.</strong></a>";
		
		//display search
		echo "<table border=0 class='data-table'>
	<tr ><th>Facility Code</th><th>Facility Name</th><th>District</th><th>Province</th><th>Land Line</th><th>Mobile No</th><th>Address</th><th>Email Address</th><th>Contact Person</th><th>Task</th></tr>";
					
		//list the variables that you would like to get
		while(list($ID,$facilitycode,$name,$district,$telephone,$telephone2,$email,$contactperson,$PostalAddress ) = mysql_fetch_array($displayfacilities))
		{   //get select district name and province id	
			$distname=GetDistrictName($district);
			//get province ID
			$provid=GetProvid($district);
				//get province name	
			$provname=GetProvname($provid);
				//display the facility name
				//$facilityname = GetFacility($ID);
				//display the facility information as well as the facility name and type
				echo "<tr class='even'>
						<td >$facilitycode</td>
						<td >$name</td> 
						<td >$distname</td> 
						<td >$provname</td>
						<td >$telephone</td>
						<td >$telephone2</td>
						<td>$PostalAddress </td>
						<td ><a href='mailto:$email'>$email</a></td>
						<td >$contactperson</td>
						<td ><a href=\"facilitydetails.php" ."?ID=$ID" . "\" title='Click to view Facility Details'>View </a> | <a href=\"editfacility.php" ."?facilitycode=$facilitycode" . "\" title='Click to view Facility Details'>Edit</a> |  <a href=\"deletefacility.php" ."?ID=$ID&fname=$name" . "\" title='Click to Delete Facility' OnClick=\"return confirm('Are you sure you want to delete Worksheet $name');\" >Delete   </a>
				</td>
					</tr>";
		}echo "</table>";
		
		$numrows=$showfacilitycount; //get total no of batches
				
					// how many pages we have when using paging?
					$maxPage = ceil($numrows/$rowsPerPage);
				
				// print the link to access each page
				$self = $_SERVER['PHP_SELF'];
				$nav  = '';
				for($page = 1; $page <= $maxPage; $page++)
				{
				   if ($page == $pageNum)
				   {
					  $nav .= " $page "; // no need to create a link to current page
				   }
				   else
				   {
					  $nav .= " <a href=\"$self?page=$page\">$page</a> ";
				   }
				}
				
				// creating previous and next link
				// plus the link to go straight to
				// the first and last page
				
				if ($pageNum > 1)
				{
				   $page  = $pageNum - 1;
				   $prev  = " <a href=\"$self?page=$page\"> | Prev </a> ";
				
				   $first = " <a href=\"$self?page=1\"> First Page </a> ";
				}
				else
				{
				   $prev  = '&nbsp;'; // we're on page one, don't print previous link
				   $first = '&nbsp;'; // nor the first page link
				}
				
				if ($pageNum < $maxPage)
				{
				   $page = $pageNum + 1;
				   $next = " <a href=\"$self?page=$page\"> | Next |</a> ";
				
				   $last = " <a href=\"$self?page=$maxPage\">Last Page</a> ";
				}
				else
				{
				   $next = '&nbsp;'; // we're on the last page, don't print next link
				   $last = '&nbsp;'; // nor the last page link
				}
				
				// print the navigation link
				echo '<center>'. $first . $prev . $next . $last .'</center>';
		exit();
	
	}
}
else if ($facilitycount == 0)
{
	echo "</strong><center>There are no facility records.</center></strong>";
}
	?>

</div>

		
 <?php include('../includes/footer.php');?>