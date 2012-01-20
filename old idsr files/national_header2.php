<?php
error_reporting(0);
include('functions.php');
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
			<strong>Welcome</strong> <?php echo $_SESSION['fullnames'];?>
			<br />
			<strong>Date Today:</strong> <?php echo date('l, d F Y');?>			
			</div>
			<div class="clearer">&nbsp;</div>

		</div>

		<div class="navigation" id="sub-nav">

			<ul class="tabbed">
				<li><a href="submissionlist.php">Home</a></li>
				
				<li><a href="submissionlist.php">Submission List </a></li>
				<li><a href="weeklyreports.php">Weekly Epidermical Bulletin </a></li>
                <li><a href="national_dashboard.php" target="_blank">Dashboard </a></li>
			
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
	
	
	
  	<div  class="center" id="main-content">	