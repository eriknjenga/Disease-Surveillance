<?php
include('/connection/authenticate.php');
require_once('/connection/config.php');
include('functions.php');

$sessionuserid = $_SESSION['id']; //get the user id for this session
$sessionaccounttype = $_SESSION['accounttype']; //get the user id for this session

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
	$currentmonth="";
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

//get the name of the user for the current session
$sessionuser = GetUserInfo($sessionuserid);

$sessionusername = $sessionuser['username'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta name="description" content=""/>
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
	<title>IDSR: Integrated Disease Surveillance and Response</title>
	<script language="JavaScript" src="scripts/FusionMaps.js"></script>
	<script language="JavaScript" src="scripts/FusionCharts.js"></script>

    <style type="text/css">
<!--
.style1 {font-size: large}
-->
    </style>
</head>

<body>

<div id="site-wrapper">

	<div id="header">

		<div id="top">

			<div class="left" id="logo"><img src="img/idsrlogo.jpg" alt="" /></div>
			<div class="right">
			<strong>Welcome</strong> <?php echo $sessionusername;?>
			<br />
			<strong>Date Today:</strong> <?php echo date('l, d F Y');?>			
			</div>
			<div class="clearer">&nbsp;</div>

		</div>

		<div class="navigation" id="sub-nav">

			<ul class="tabbed">
				<li><a href="overall.php">Overall</a></li>
				<li><a href="regional.php">Disease Surveillance </a></li>
				<li><a href="fatalityr.php">Fatality Rate </a></li>
				<li><a href="reports.php">Reports</a></li>				
				<li><a href="logout.php">Log Out</a></li>
				<li>&nbsp;</li>
				<li>&nbsp;</li>
				<li>&nbsp;</li>
				<li>&nbsp;</li>
				<li>&nbsp;</li>
				<li>&nbsp;</li>
				<li>&nbsp;</li>
			</ul>

			<div class="clearer">&nbsp;</div>

		</div>

<div class="navigation" >
			<ul class="tabbed">
			
	
		
	
				<table width="1111">
				<tr>	
				<td>	
				<li><?php
				$D=$_SERVER['PHP_SELF'];
					$year = date('Y');
						$twoless = $year-3;
						for ($year; $year>=$twoless; $year--)
  						{  

  							echo  "<a href=$D?year=$year>   $year  |</a>";    	     
  						}
						?>&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						 <?php //echo "<a href =$D?year=2010&mwezi=13>Jan-Sep 2010 </a>"; ?>
				
				</li>
				</td>
				<td width='360'><li> &nbsp; </li></td>
				
				<td >
				<li><?php /*$year=$_GET['year'];
						if ($year=="")
{
$year=date('Y');
} 
						 echo "<a href =$D?year=$year&mwezi=1>Jan</a>";?> | <?php echo "<a href =$D?year=$year&mwezi=2>Feb </a>";?>| <?php echo "<a href =$D?year=$year&mwezi=3>Mar</a>";?>  | <?php echo "<a href =$D?year=$year&mwezi=4>Apr</a>";?>  | <?php echo "<a href =$D?year=$year&mwezi=5>May</a>";?>  | <?php echo "<a href =$D?year=$year&mwezi=6>Jun</a>";?>  | <?php echo "<a href =$D?year=$year&mwezi=7>Jul</a>";?>  | <?php echo "<a href =$D?year=$year&mwezi=8>Aug</a>";?>  | <?php echo "<a href =$D?year=$year&mwezi=9>Sept</a>";?>  | <?php echo "<a href =$D?year=$year&mwezi=10>Oct</a>";?>  | <?php echo "<a href =$D?year=$year&mwezi=11>Nov</a>";?>  | <?php echo "<a href =$D?year=$year&mwezi=12>Dec</a>";*/?>  
				Please Select Epiweek &nbsp;
				<?php
				$epiweek = 1;?>
				
				<select name='epiweek'>
					<?php
					while ($epiweek <= 52)
					{?>
						<option value="0"> <?php echo $epiweek;?></option>
					<?php
						$epiweek = $epiweek + 1;
					}
					?>
				</select>
				</li>&nbsp;&nbsp;
				
				<input type="submit" name="Submit" value="Filter" class="button" /></td>
				
				</tr>
			  </table>	
			</ul>
		</div>
		<div class="clearer">&nbsp;</div>
		
	</div>
	
  	<div  class="center" id="main-content">	