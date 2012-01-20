<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta name="description" content=""/>
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
	<title>AOP</title>
<!--for the system icon on the browser -->
<link rel="shortcut icon" href="favicon.ico" >
<link rel="icon" type="image/gif" href="images/animated_favicon1.gif" title="Langata HMS" >

</head>

<body>

<div id="site-wrapper">

	<div id="header">

		<div id="top">

			<div class="left" id="logo">
				<a href="index.html"><img src="img/naslogo.jpg" alt="" /></a> 
			</div>
			
			<div class="clearer">&nbsp;</div>

		</div>

	</div>

	<div class="main" id="main-content">
	
			
				<div class="error" align="center">
					<h2><?php echo  '<strong>'.' <font color="#CC3333">'.'Access Denied'.'</strong>'.' </font>';?>
					</h2>
					<br/> 
					You either entered the wrong username or password.  
				</div>
			<p align="center">Click here to<strong><a href="index.php">  Log in</a> .</strong><a href="#">Forgotten Password?</a></p>
			
	


	
<?php include('footer.php');?>