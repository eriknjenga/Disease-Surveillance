<?php
include('/connection/authenticate.php');
require_once('/connection/config.php');
include('functions.php');

$sessionuserid = $_SESSION['id']; //get the user id for this session
$sessionaccounttype = $_SESSION['accounttype']; //get the user id for this session

//get the session id from log history
$sessionrec = GetSessionInfo($sessionuserid);

$_SESSION['maxsession'] = $sessionrec['maxsession'];
$sessionid = $_SESSION['maxsession'];					
//get the session id


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
	<title>IDSR GOK</title>
	<script language="JavaScript" src="scripts/FusionMaps.js"></script>
	<script language="JavaScript" src="scripts/FusionCharts.js"></script>
<script type="text/javascript" src="jquery.min.js"></script>

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
				<li><a href="dashboard.php">Home</a></li>
				
				<li><a href="surveillance.php">Weekly </a></li>
				<li><a href="casebasedlist.php">Case Based </a></li>
				<li><a href="linelists.php">Line Lists </a></li>
				<li><a href="dashboard.php">Disease Surveillance Dashboard</a></li>	
				<li><a href="fatality.php">Fatality Rate  Dashboard</a></li>				
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

	</div>
	
	<div class="left sidebar" id="sidebar">
		<div class="section">
				<div class="section-title">Quick Menu</div>
				<!--side bar menu-->
				<div class="section-content">

					<ul class="nice-list">
					<li><a href="addbelow.php">Add Weekly<span class="style1">&le;</span> 5 Year Data </a></li>
					<li><a href="addabove.php">Add Weekly<span class="style1">&ge;</span> 5 Year Data</a></li>
					<li><a href="addcasebased.php">Add Cased Based Data </a></li>
					<li><a href="addlinelist.php">Add Line List Data </a></li>
					<li>&nbsp;</li>
					<li>&nbsp;</li>
					<li>&nbsp;</li>
					<li>&nbsp;</li>
					<li>&nbsp;</li>
					</ul>
				
		  </div>
				<!--end side bar menu-->
				
				
		</div>
			

	</div>
	
  	<div  class="center" id="main-content">	