<?php 
require_once('connection/config.php');
include('national_header.php');
//get the search variable
$searchparameter = $_GET['search'];
$success = $_GET['p'];

?>

<div>
	<div class="section-title">DISTRICTS LIST</div>
	<?php if ($success !="")
		{
		?> 
			<table   >
  			<tr>
    		<td style="width:auto" ><div class="success"><?php echo  '<strong>'.' <font color="#666600">'.$success.'</strong>'.' </font>';?></div></td>
  			</tr>
			</table>
	<?php 
		} ?>
	<?php
		//query database for all districts
		$districtsquery = "SELECT * FROM districts WHERE flag = 1 ";
		$result = mysql_query($districtsquery) or die(mysql_error()); //for main display		
		$no = mysql_num_rows($result);

if ($no != 0)
{
	$rowsPerPage =15; //number of rows to be displayed per page
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
		echo "Total Districts: <strong>" .GetTotalDistricts();		
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
				
				///////GET district COUNT////////////////////////////////////////////////////////////////////////////////////////////////////				
				$showdistricts = "SELECT name, comment FROM districts WHERE province = $provid";
				
				$displaydistricts = @mysql_query($showdistricts) or die(mysql_error());
				
				$displaydistrictscount = mysql_num_rows($displaydistricts);				
				///////END COUNT////////////////////////////////////////////////////////////////////////////////////////////////////
				
				echo "The filter for districts in <strong>$provname</strong> province returned <strong>$displaydistrictscount</strong> results. <a href='districtslist.php'><strong>Click here to refresh page.</strong></a>";
								
				/*	<!--	***************************************************************** -->*/
				echo '<table border=0  class="data-table">
				<tr ><th>Count</th><th>Name</th><th>Province</th><th>Comment(s)</th></tr>';
				/*<!--*********************************************************** -->*/
						
					$showdistrict = "SELECT name, comment FROM districts WHERE province = $provid LIMIT $offset, $rowsPerPage";
					$displaydistricts = mysql_query($showdistrict) or die(mysql_error());
					
					$districtcount = 0;
					while(list($name,$province,$comment) = mysql_fetch_array($displaydistricts))
					{  
						$districtcount = $districtcount + 1;
						
						//display the province name
						
						//display the table
						echo "<tr >
								<td >$districtcount</td>
								<td >$name</td>
								<td >$provname</td>
								<td >$comment</td>
								</tr>";
					}
					echo "</table>";
			
				$numrows=$displaydistrictscount; //get total no of batches
				
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
			
		$districtcount = 0;
		/*	<!--	***************************************************************** -->*/
		echo '<table border=0  class="data-table">
		<tr ><th>Count</th><th>Name</th><th>Province</th><th>Comment(s)</th></tr>';
		/*<!--*********************************************************** -->*/
				
			$showdistrict = "SELECT name,province,comment FROM districts WHERE flag = 1 LIMIT $offset, $rowsPerPage";
			$displaydistricts = mysql_query($showdistrict) or die(mysql_error());
			
			
			while(list($name,$province,$comment) = mysql_fetch_array($displaydistricts))
			{  
				$districtcount = $districtcount + 1;
				
				//display the province name
				$provincename = GetProvname($province);
				//display the table
				echo "<tr >
						<td >$districtcount</td>
						<td >$name</td>
						<td >$provincename</td>
						<td >$comment</td>
						</tr>";
			}
			echo "</table>";
			
		$numrows=GetTotalDistricts(); //get total no of batches

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
		   $prev  = " <a href=\"$self?page=$page\">[Prev]</a> ";
		
		   $first = " <a href=\"$self?page=1\">[First Page]</a> ";
		}
		else
		{
		   $prev  = '&nbsp;'; // we're on page one, don't print previous link
		   $first = '&nbsp;'; // nor the first page link
		}
		
		if ($pageNum < $maxPage)
		{
		   $page = $pageNum + 1;
		   $next = " <a href=\"$self?page=$page\">[Next]</a> ";
		
		   $last = " <a href=\"$self?page=$maxPage\">[Last Page]</a> ";
		}
		else
		{
		   $next = '&nbsp;'; // we're on the last page, don't print next link
		   $last = '&nbsp;'; // nor the last page link
		}
		
		// print the navigation link
		echo '<center>'. $first . $prev . $nav . $next . $last .'</center>';
			
								/*<!--***********************************************************	 -->*/
			
	}
	else if (!empty($searchparameter))
	{
			//query database for all districts
			$districtsquery = "SELECT LTRIM(RTRIM(name)),province,comment FROM districts WHERE name LIKE '%$searchparameter%' AND flag = 1";
			$result = mysql_query($districtsquery) or die(mysql_error()); //for main display		
			$no = mysql_num_rows($result);
			
			echo "The search for <strong>$searchparameter</strong> returned <strong>$no</strong> results.<a href='districtslist.php'><strong>Click here to refresh page.</strong></a>";
					/*	<!--	***************************************************************** -->*/
					echo '<table border="0"   class="data-table">
					<tr ><th>Count</th><th>Name</th><th>Province</th><th>Comment(s)</th></tr>';
					/*<!--*********************************************************** -->*/
						$displaycount = 0;
						while(list($name,$province,$comment) = mysql_fetch_array($result))
						{  
							//display the province name
							$provincename = GetProvname($province);
							$displaycount = $displaycount + 1;
							//display the table
							echo "<tr >
									<td >$displaycount</td>
									<td >$name</td>
									<td >$provincename</td>
									<td >$comment</td>
									</tr>";
						}
					echo "</table>";
					/*<!--***********************************************************	 -->*/
		$numrows = $no; //get total no of batches

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
		   $prev  = " <a href=\"$self?page=$page\">[Prev]</a> ";
		
		   $first = " <a href=\"$self?page=1\">[First Page]</a> ";
		}
		else
		{
		   $prev  = '&nbsp;'; // we're on page one, don't print previous link
		   $first = '&nbsp;'; // nor the first page link
		}
		
		if ($pageNum < $maxPage)
		{
		   $page = $pageNum + 1;
		   $next = " <a href=\"$self?page=$page\">[Next]</a> ";
		
		   $last = " <a href=\"$self?page=$maxPage\">[Last Page]</a> ";
		}
		else
		{
		   $next = '&nbsp;'; // we're on the last page, don't print next link
		   $last = '&nbsp;'; // nor the last page link
		}
		
		// print the navigation link
		echo '<center>'. $first . $prev . $nav . $next . $last .'</center>';
		exit();
	}
}
else if ($no == 0)
{
	echo '<center>No Districts have been Added</center>';		
	exit();
}
	?>	
</div>
		
 <?php include('../includes/footer.php');?>