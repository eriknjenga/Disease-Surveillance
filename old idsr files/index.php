<?php
error_reporting(0);
require_once ('/connection/config.php');
include ('/functions.php');

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

// To protect MySQL injection
$username = stripslashes($username);
//Un-quotes a quoted string.
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
//Escapes special characters in a string for use in an SQL statement
$password = mysql_real_escape_string($password);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="index, follow">
		<meta name="keywords" content="IDSR, DDSR, IDSR kenya, DDSR kenya">
		<meta name="title" content="IDSR KENYA">
		<meta name="description" content="Idsr Kenya">
		<meta name="generator" content="Joomla! 1.5 - Open Source Content Management">

		<title>INTEGRATED DISEASE SURVEILLANCE AND RESPONSE</title>

		<link rel="stylesheet" href="home/style.css" type="text/css">
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
		<link rel="stylesheet" href="validation/css/validationEngine.jquery.css" type="text/css">

		<script src="validation/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
		<script src="validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="home/saved_resource(1)"></script>
		<script type="text/javascript" src="home/saved_resource(2)"></script>
		<script type="text/javascript" src="home/saved_resource(3)" charset="utf-8"></script>
		<script type="text/javascript" src="home/js/jquery-1.3.1.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {

				//Execute the slideShow
				slideShow();
				jQuery("#forgot").validationEngine();

			});
			function slideShow() {

				//Set the opacity of all images to 0
				$('#gallery a').css({
					opacity : 0.0
				});

				//Get the first image and display it (set it to full opacity)
				$('#gallery a:first').css({
					opacity : 1.0
				});

				//Set the caption background to semi-transparent
				$('#gallery .caption').css({
					opacity : 0.7
				});

				//Resize the width of the caption according to the image width
				$('#gallery .caption').css({
					width : $('#gallery a').find('img').css('width')
				});

				//Get the caption of the first image from REL attribute and display it
				$('#gallery .content').html($('#gallery a:first').find('img').attr('rel')).animate({
					opacity : 0.7
				}, 400);

				//Call the gallery function to run the slideshow, 6000 = change to next image after 6 seconds
				setInterval('gallery()', 6000);

			}

			function gallery() {

				//if no IMGs have the show class, grab the first image
				var current = ($('#gallery a.show') ? $('#gallery a.show') : $('#gallery a:first'));

				//Get next image, if it reached the end of the slideshow, rotate it back to the first image
				var next = ((current.next().length) ? ((current.next().hasClass('caption')) ? $('#gallery a:first') : current.next()) : $('#gallery a:first'));

				//Get next image caption
				var caption = next.find('img').attr('rel');

				//Set the fade in effect for the next image, show class has higher z-index
				next.css({
					opacity : 0.0
				}).addClass('show').animate({
					opacity : 1.0
				}, 1000);

				//Hide the current image
				current.animate({
					opacity : 0.0
				}, 1000).removeClass('show');

				//Set the opacity to 0 and height to 1px
				$('#gallery .caption').animate({
					opacity : 0.0
				}, {
					queue : false,
					duration : 0
				}).animate({
					height : '1px'
				}, {
					queue : true,
					duration : 300
				});

				//Animate the caption, opacity to 0.7 and heigth to 100px, a slide up effect
				$('#gallery .caption').animate({
					opacity : 0.7
				}, 100).animate({
					height : '100px'
				}, 500);

				//Display the content
				$('#gallery .content').html(caption);

			}
		</script>
		<style type="text/css">
			.clear {
				clear: both
			}
			.success {
				border: 1px solid #DDD;
				margin-bottom: 1em;
				padding: 0.6em 0.8em;
			}
			.success {
				background: #CCC;
				color: #396;
				border-color: #FBC2C4;
			}
			.success a {
				color: #8A1F11;
			}
			#gallery {
				width: 930px;
				position: relative;
				height: 400px
			}
			#gallery a {
				float: left;
				position: absolute;
			}
			#gallery a img {
				border: none;
			}
			#gallery a.show {
				z-index: 500
			}
			#gallery .caption {
				z-index: 500;
				background-color: #000;
				color: #ffffff;
				height: 50px;
				width: 100%;
				position: absolute;
				bottom: 0;
			}
			#gallery .caption .content {
				margin: 5px;
			}
			#gallery .caption .content h3 {
				margin: 0;
				padding: 0;
				color: #1DCCEF;
			}

		</style>
		<script language="javascript" type="text/javascript" src="home/saved_resource(4)"></script>
		<!-- js for dragdrop -->
		<!-- Menu head -->
		<script src="home/saved_resource(5)" language="javascript" type="text/javascript"></script>
		<!--[if lte IE 6]>
		<style type="text/css">
		img {border: none;}
		</style>
		<![endif]-->
		<script type="text/javascript" src="javascript/jquery.min.js"></script>
		<script type="text/javascript" src="javascript/jquery.simplemodal.js"></script>
		<script type="text/javascript" src="javascript/init.js"></script>
		<link type='text/css' href='style/stylesheet.css' rel='stylesheet' media='screen' />
		<link type='text/css' href='style/basic.css' rel='stylesheet' media='screen' />
	</head>
	
	<body id="bd" class="fs3">
		<div id="ja-wrapper">
			<a name="Top" id="Top"></a>
			<!-- HEADER -->
			<div id="ja-header" class="wrap">
				<div class="main clearfix">
					<h1 class="logo"><a href="#" title="Idsr Kenya"><span>IDSR</span><img src="home/coatofarms_kenya.png" width="188" height="151" alt="GKLogo" /></a></h1>
					<div class="ministry"><img src="images/division1.png" width="721" height="40" alt="Division of Disease Surveillance and Response" />
					</div>
					<div class="ministry1"><img src="images/ministry1.png" width="500" height="25" alt="Division of Disease Surveillance and Response" />
					</div>
				</div>
			</div>
			<!-- //HEADER -->
			<!-- MAIN NAVIGATION -->
			<div id="ja-mainnav" class="wrap">
				<div class="main">
					<div class="inner clearfix">
						<ul class="no-display">
							<li>
								<a href="http://www.publichealth.go.ke/#ja-content" title="Skip to content">Skip to content</a>
							</li>
						</ul>
						<ul id="ja-cssmenu" class="clearfix">
							<li class="active">
								<a href="index.php" class="menu-item0 active first-item" id="menu1" title="HOME"><span class="menu-title">Home</span></a>
							</li>
							<li class="">
								<a href="about_us.php" class="menu-item5" id="menu54" title="ABOUT US"><span class="menu-title">About Us</span></a>
							</li>
							<li class="">
								<a href="strategy.php" class="menu-item5" id="menu54" title="STRATEGY"><span class="menu-title">IDSR Strategy</span></a>
							</li>
							<li class="">
								<a href="report.php" class="menu-item5" id="menu54" title="PRIORITY"><span class="menu-title">Reports</span></a>
							</li>
							<li class="">
								<a href="outbreak.php" class="menu-item5" id="menu54" title="REPORT"><span class="menu-title">Report an Outbreak</span></a>
							</li>
							<!--<li class=""><a href="#" class="menu-item5" id="menu54" title="DOCUMENTS"><span class="menu-title">Documents</span></a></li>-->
							<li class="">
								<a href="resources.php" class="menu-item5" id="menu54" title="RESOURCES"><span class="menu-title">RESOURCES</span></a>
							</li>
							<li class="">
								<a href="#" class="menu-item5" id="menu54" title="EVENTS"><span class="menu-title">News & Events</span></a>
							</li>
							<li class="">
								<a id="login_link" href="#" class="menu-item5" id="menu54" title="Login"><span class="menu-title">LOGIN</span></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- //MAIN NAVIGATION -->
			<!-- TOP SPOTLIGHT -->
			<div id="ja-topsl" class="wrap">
				<div class="main">
					<div class="inner clearfix">
						<div id="ja-slideshow">
							<script src="ja.slideshow2.js" type="text/javascript"></script>
							<script src="ja.slideshow.js" type="text/javascript"></script>
							<div class="ja-slidewrap" id="ja-slide-21" style="visibility: visible; ">
								<div class="ja-slide-main-wrap" style="width: 930px; height: 400px; ">
									<div id="gallery">
										<a href="#" class="show"> <img src="home/images/flags.jpg" alt="Flowing Rock" width="930" height="400" title="" alt="" rel="<h3>Minister Flags Off Fair</h3>The Minister for Public Health and Sanitation opens the Water Treatment and Safe Storage Fair at K.I.C.C. in Nairobi - March 2011."/> </a>
										<a href="#"> <img src="home/images/one.jpg" alt="Image" width="930" height="400" title="" alt="" rel="<h3>MPHS and WHO</h3>The Minister of Public Health and Sanitation, Hon. Beth Mugo flagging off new vehicles donated by World Health Organization (WHO) to support disease prevention, detection, investigation and control in the country."/> </a>
										<a href="#"> <img src="home/images/two.jpg" alt="Image" width="930" height="400" title="" alt="" rel="<h3>Pandemic Influenza A H1N1</h3>Hon. Dr.James Gesami, Assistant Minister for Public Health and Sanitation receives Pandemic influenza A H1N1 2009 vaccine injection at the Launch of the vaccination exercise at Kenyatta National Hospital."/> </a>
										<a href="#"> <img src="home/images/three.jpg" alt="Image" width="930" height="400" title="" alt="" rel="<h3>Press briefing on Yellow Fever</h3>The Director of Public Health and Sanitation, Dr. S. K Shariff giving a press briefing to the media on Yellow Fever alert in January 2011."/> </a>
										<a href="#"> <img src="home/images/four.jpg" alt="Image" width="930" height="400" title="" alt="" rel="<h3>DDSR Officer facilitating training</h3>The health sector works in partnership with other government ministries and Non Governmental Organizations for effective response to disease outbreaks. Sensitization trainings of multi-sectoral nature build capacity and skills in surveillance at all levels to create competencies in disease prevention, detection, reporting, investigation and control."/> </a>
										<a href="#"> <img src="home/images/five.jpg" alt="Image" width="930" height="400" title="" alt="" rel="<h3>Polio Vaccine</h3>A vaccinator giving Polio vaccine to a child during the 2010 House to House emergency campaign for districts along Kenya - Uganda border."/> </a>
										<a href="#"> <img src="home/images/last.jpg" alt="Image" width="930" height="400" title="" alt="" rel="<h3>DDSR Officers</h3>DDSR officers, provincial disease surveillance officer/epidemiologists and partners during divisional strategic planning retreat in Mombasa in December 2010."/> </a>
										<div class="caption">
											<div class="content"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- //TOP SPOTLIGHT -->
			<!-- PATHWAY -->
			<div id="ja-pathway" class="wrap">
				<div class="main">
					<div class="inner clearfix">
						<div class="ja-pathway-text">
							<strong>You are here:</strong><span class="breadcrumbs pathway"> Home</span>
						</div>
					</div>
				</div>
			</div>
			<!-- //PATHWAY -->
			<div id="login_form" style='display:none'>
				<div id="status" align="left">
					<center>
						<h1><img src="images/key.png" align="absmiddle">&nbsp;LOGIN</h1>
						<div id="login_response">
							<!-- spanner -->
						</div>
					</center>
					<form id="login" action="javascript:alert('success!');">
						<input type="hidden" name="action" value="user_login">
						<input type="hidden" name="module" value="login">
						<label>Username</label>
						<input type="text" name="username">
						<br />
						<label>Password</label>
						<input type="password" name="password">
						<br />
						<label>&nbsp;</label>
						<input value="Login" name="Login" id="submit" class="register" type="submit" />
						<div id="ajax_loading">
							<img align="absmiddle" src="images/loader.gif">&nbsp;Processing...
						</div>
						
						<p><a href="forgotpassword.php">Forgot Password?</a></p>
						
					</form>
					
				</div>
			</div>
			<div id="ja-container-fr" class="wrap clearfix">
				<div class="main">
					<div class="inner clearfix">
						<!-- CONTENT -->
						<div id="ja-mainbody">
							<!-- JA NEWS --><!-- //JA NEWS -->
							<!-- JA CONTENT SLIDER -->
							<div id="ja-cs">
								<div class="clearfix">
									<div class="moduletable" id="Mod32">
										<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">WELCOME TO OUR SITE</span></span></h3>
										<div class="ja-box-ct clearfix">
											<p>
												<strong><strong>The Division of Disease Surveillance and Response under the Ministry of Public Health and Sanitation (DDSR) was formed on the recommendation of the World Health   Organization (African Region) for governments to implement integrated   surveillance activities to avoid duplication of efforts by the different   departments within ministries of health.</strong>
											</p>
											<p>
												<strong> The DDRS is tasked to design   and manage disease surveillance and early warning systems and to provide   support in the management of disease outbreaks through provincial and   district Health teams in collaboration with other ministerial technical   and systems support departments.</strong>
											</p>
											<p>
												<strong>The division is currently staffed with twenty professional officers   and thirteen support staff. Information technology equipment was   required to boost the functional capacity of the division.</strong>
											</p>
											<p>
												<strong>The Division of Disease Surveillance and Response mainly coordinates public health surveillance in Kenya which is majorly based on the Integrated Disease Surveillance and Response (IDSR) Strategy which began in 2005.</strong>
											</p>
										</div>
									</div>
								</div>
							</div>
							<!-- //JA CONTENT SLIDER -->
						</div>
						<!-- //CONTENT -->
						<!-- RIGHT COLUMN -->
						<div id="ja-colwrap">
							<div class="ja-innerpad">
								<div class="moduletable" id="Mod29">
									<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">OUR VISION</span></span></h3>
									<div class="ja-box-ct clearfix">
										<p>
											<strong>An effective and efficient  surveillance and response system that results in a reduction in morbidity, mortality and disability from disease outbreaks and other Public Health events in Kenya</strong>
										</p>
									</div>
								</div>
								<div class="moduletable" id="Mod31">
									<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">OUR MISSION</span></span></h3>
									<div class="ja-box-ct clearfix">
										<p>
											<strong>Provide leadership and participate in surveillance, preparedness and response to disease outbreaks and other Public Health events in Kenya.</strong>
										</p>
									</div>
								</div>
							</div>
						</div>
						<br>
						<!-- //RIGHT COLUMN -->
					</div>
				</div>
			</div>
			<!-- FOOTER -->
			<div id="ja-footer" class="wrap">
				<div class="main clearfix" align="center">
					<strong>Division of Disease Surveillance and Response</strong>
					<br>
					<small>
						<div align="center">
							Copyright © 2011 Ministry of Public Health and Sanitation.All Rights Reserved.
						</div></small>
					<!--<small><a href="http://www.joomla.org">Joomla!</a> is Free Software released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html">GNU/GPL License.</a></small> -->
				</div>
			</div>
			<!-- //FOOTER -->
			<script type="text/javascript">
				//addSpanToTitle();
				//jaAddFirstItemToTopmenu();
				//jaRemoveLastContentSeparator();
				//jaRemoveLastTrBg();
				//moveReadmore();
				//addIEHover();
				//slideshowOnWalk ();
				//apply png ie6 main background
			</script>
		</div>
	</body>
</html>