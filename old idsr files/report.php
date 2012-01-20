<?php
error_reporting(0);
require_once('/connection/config.php');
include('/functions.php');

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];


// To protect MySQL injection
$username = stripslashes($username); //Un-quotes a quoted string.
$password = stripslashes($password); 
$username = mysql_real_escape_string($username); //Escapes special characters in a string for use in an SQL statement
$password = mysql_real_escape_string($password);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="robots" content="index, follow">
  <meta name="keywords" content="IDSR, DDSR, IDSR kenya, DDSR kenya">
  <meta name="title" content="IDSR KENYA">
  <meta name="description" content="Idsr Kenya">
  <meta name="generator" content="Joomla! 1.5 - Open Source Content Management">
  <title>IDSR REPORTS</title>


 <link rel="stylesheet" href="home/style.css" type="text/css">
  <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
  
  
  <link rel="stylesheet" href="validation/css/validationEngine.jquery.css" type="text/css">
        <link rel="stylesheet" href="jquery-ui-1.8.12.custom/development-bundle/themes/base/jquery.ui.all.css">
        <link rel="stylesheet" href="jquery-ui-1.8.12.custom/development-bundle/demos/demos.css">

        <script src="jquery-ui-1.8.12.custom/development-bundle/jquery-1.5.1.js"></script>
        <script src="validation/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
        <script src="validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
        <script src="jquery-ui-1.8.12.custom/development-bundle/ui/jquery.ui.core.js"></script>
        <script src="jquery-ui-1.8.12.custom/development-bundle/ui/jquery.ui.widget.js"></script>
        <script src="jquery-ui-1.8.12.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>

  
  
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
	$('#gallery a').css({opacity: 0.0});
	
	//Get the first image and display it (set it to full opacity)
	$('#gallery a:first').css({opacity: 1.0});
	
	//Set the caption background to semi-transparent
	$('#gallery .caption').css({opacity: 0.7});

	//Resize the width of the caption according to the image width
	$('#gallery .caption').css({width: $('#gallery a').find('img').css('width')});
	
	//Get the caption of the first image from REL attribute and display it
	$('#gallery .content').html($('#gallery a:first').find('img').attr('rel'))
	.animate({opacity: 0.7}, 400);
	
	//Call the gallery function to run the slideshow, 6000 = change to next image after 6 seconds
	setInterval('gallery()',6000);
	
}

function gallery() {
	
	//if no IMGs have the show class, grab the first image
	var current = ($('#gallery a.show')?  $('#gallery a.show') : $('#gallery a:first'));

	//Get next image, if it reached the end of the slideshow, rotate it back to the first image
	var next = ((current.next().length) ? ((current.next().hasClass('caption'))? $('#gallery a:first') :current.next()) : $('#gallery a:first'));	
	
	//Get next image caption
	var caption = next.find('img').attr('rel');	
	
	//Set the fade in effect for the next image, show class has higher z-index
	next.css({opacity: 0.0})
	.addClass('show')
	.animate({opacity: 1.0}, 1000);

	//Hide the current image
	current.animate({opacity: 0.0}, 1000)
	.removeClass('show');
	
	//Set the opacity to 0 and height to 1px
	$('#gallery .caption').animate({opacity: 0.0}, { queue:false, duration:0 }).animate({height: '1px'}, { queue:true, duration:300 });	
	
	//Animate the caption, opacity to 0.7 and heigth to 100px, a slide up effect
	$('#gallery .caption').animate({opacity: 0.7},100 ).animate({height: '100px'},500 );
	
	//Display the content
	$('#gallery .content').html(caption);
	
	
}

</script>
<style type="text/css">
.clear {
	clear:both
}
.success {
	border: 1px solid #DDD;
	margin-bottom: 1em;
	padding: 0.6em 0.8em;
}

.success {background: #CCC; color: #396; border-color: #FBC2C4;}
.success a {color: #8A1F11;}

#gallery {
	width:930px;
	position:relative;
	height:400px
}
	#gallery a {
		float:left;
		position:absolute;
	}
	
	#gallery a img {
		border:none;
	}
	
	#gallery a.show {
		z-index:500
	}

	#gallery .caption {
		z-index:500; 
		background-color:#000; 
		color:#ffffff; 
		height:50px; 
		width:100%; 
		position:absolute;
		bottom:0;
	}

	#gallery .caption .content {
		margin:5px;
			}
	
	#gallery .caption .content h3 {
		margin:0;
		padding:0;
		color:#1DCCEF;
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

<link rel="stylesheet" href="tabs/css/general.css" type="text/css" media="screen" />

</head>
<body id="bd" class="  fs3">

<div id="ja-wrapper">
<a name="Top" id="Top"></a>

<!-- HEADER -->
<div id="ja-header" class="wrap">
  <div class="main clearfix">
  
  	  <h1 class="logo">
	  <a href="#" title="Idsr Kenya"><span>IDSR</span><img src="home/coatofarms_kenya.png" width="188" height="151" alt="GKLogo" /></a></h1>
      <div class="ministry"><img src="images/division1.png" width="721" height="40" alt="Division of Disease Surveillance and Response" /></div>
      <div class="ministry1"><img src="images/ministry1.png" width="500" height="25" alt="Division of Disease Surveillance and Response" /></div>
  	  
  </div>
</div>

<!-- //HEADER -->

<!-- MAIN NAVIGATION -->
<div id="ja-mainnav" class="wrap">  	
  <div class="main">
    <div class="inner clearfix">
  
  	<ul class="no-display">
  		<li><a href="http://www.publichealth.go.ke/#ja-content" title="Skip to content">Skip to content</a></li>
  	</ul>
  
			<ul id="ja-cssmenu" class="clearfix">
<li class="active"><a href="index.php" class="menu-item0 active first-item" id="menu1" title="HOME"><span class="menu-title">Home</span></a></li> 
<li class=""><a href="about_us.php" class="menu-item5" id="menu54" title="ABOUT US"><span class="menu-title">About Us</span></a></li> 
<li class=""><a href="strategy.php" class="menu-item5" id="menu54" title="STRATEGY"><span class="menu-title">IDSR Strategy</span></a></li> 
<li class=""><a href="report.php" class="menu-item5" id="menu54" title="PRIORITY"><span class="menu-title">Reports</span></a></li>
<li class=""><a href="outbreak.php" class="menu-item5" id="menu54" title="REPORT"><span class="menu-title">Report an Outbreak</span></a></li>  
<!--<li class=""><a href="#" class="menu-item5" id="menu54" title="DOCUMENTS"><span class="menu-title">Documents</span></a></li>-->
<li class=""><a href="resources.php" class="menu-item5" id="menu54" title="RESOURCES"><span class="menu-title">RESOURCES</span></a></li>
<li class=""><a href="#" class="menu-item5" id="menu54" title="EVENTS"><span class="menu-title">News & Events</span></a></li>
<li class=""><a id="login_link" href="#" class="menu-item5" id="menu54" title="Login"><span class="menu-title">LOGIN</span></a></li>
		</ul>
		
				
    </div>
  </div>
</div>

<!-- //MAIN NAVIGATION -->

<!-- TOP SPOTLIGHT --><!-- //TOP SPOTLIGHT -->

<!-- PATHWAY -->
<div id="ja-pathway" class="wrap">
  <div class="main">
    <div class="inner clearfix">
  
  	<div class="ja-pathway-text">
    <strong>You are here:</strong><span class="breadcrumbs pathway"> Reports
</span>

    </div>
    </div>
  </div>
</div>
<!-- //PATHWAY -->
<div id="login_form" style='display:none'>

<div id="status" align="left">

<center><h1><img src="images/key.png" align="absmiddle">&nbsp;LOGIN</h1> 

<div id="login_response"><!-- spanner --></div> </center>

<form id="login" action="javascript:alert('success!');">

<input type="hidden" name="action" value="user_login">
<input type="hidden" name="module" value="login">
<label>Username</label><input type="text" name="username"><br />  
<label>Password</label><input type="password" name="password"><br />  
<label>&nbsp;</label><input value="Login" name="Login" id="submit" class="register" type="submit" />

<div id="ajax_loading">
<img align="absmiddle" src="images/loader.gif">&nbsp;Processing...
</div>

</form>

 <?php
		if ($_REQUEST['Login'])
		{
			if ((strlen($username) <1) || (strlen($username) > 32))
			{
				?>
				<div class="error">
				<?php
				echo "<strong>Login failed, Please enter Username</strong>";
				?>
				</div>
				<?php
		
			}
			else if ((strlen($password) < 1) || (strlen($password) > 32))
			{
				?>
				<div class="error">
				<?php
				echo "<strong>Login failed, Please enter Password</strong>";
				?>
				</div>
				<?php
		
			}
			else
			{
				//$password = md5($password); //encrypt the password
				$checkuser = "SELECT id,role FROM users WHERE username='$username' AND password=md5($password) AND flag = 1";
				$result = mysql_query($checkuser) or die(mysql_error());
				$count = mysql_num_rows($result);
			
				if ($result)
				{
					if($count > 0)
					{
							$userrec = mysql_fetch_assoc($result);
							
							$_SESSION['id'] = $userrec['id']; //the userid
							$_SESSION['role'] = $userrec['role'];
							$_SESSION['accounttype'] = $userrec['accounttype'];
							session_write_close();
														
							//save the log in time
							$sessionuserid = $_SESSION['id'];
							$sessionuserrole = $_SESSION['role'];
							$sessionaccounttype = $_SESSION['accounttype'];
							$logindate = date('Y-m-d');
							$logintime = date("h:i:s A");
							
							$savelog = "INSERT INTO loghistory(user,logindate,logintime)VALUES('$sessionuserid','$logindate','$logintime')";
							$loghist = @mysql_query($savelog) or die(mysql_error());
							
							if ($loghist)
							{
								//////////////////////////////////////////////////////////////////////////////////////
								if ($_SESSION['role'] == '3')
								{
									echo '<script type="text/javascript">' ;
									echo "window.location.href='dashboard.php'";
									echo '</script>';
								}
								else if ($_SESSION['role'] == '5')
								{
									echo '<script type="text/javascript">' ;
									echo "window.location.href='admin/admin.php'";
									echo '</script>';
								}
								
								else if ($_SESSION['role'] == '4')
								{
									echo '<script type="text/javascript">' ;
									echo "window.location.href='submissionlist.php'";
									echo '</script>';
								}
								else
								{
									//echo "Wait";
									echo '<script type="text/javascript">' ;
									echo "window.location.href='overall.php'";
									echo '</script>';
								}
							}
							
							else
							{
								?>
								<div class="error">
								<?php
								echo "<strong>Unable to save Details. Please try again.</strong><br/>";
								?>
								</div>
								<?php
							}
					}
					else 
					{
							?>
							<?php
							echo '<script type="text/javascript">' ;
									echo "window.location.href='wrong.php'";
									echo '</script>';
							?>
							<?php
					}
				}
				else
				{
					die("Query failed");
				}
				session_write_close();
			}
			
		}?>
              
  </div>

</div>



<div id="ja-container-fr" class="wrap clearfix">
  <div class="main"><div class="inner clearfix">
  
  	<!-- CONTENT -->  
    	
  	<div id="ja-mainbody">
			

		  <div id="ja-current-content" class="clearfix">
    		
<div id="ja-contentheading">

<div class="blog">
<div id="container">
		<ul class="menu">
			<li id="news" class="active">2010 Bulletins</li>
          <li id="tutorials" class="active">2011 Bulletins</li>
			<li id="tutorials">M&E</li>
			<li id="links">EPR</li>
            <li id="links">VPD</li>
            <li id="links">Influenza</li>
            <li id="links">IDS</li>
            <li id="links">Administration</li>
		</ul>
		<span class="clear"></span>
		<div class="content news">
			<p>Kenya Weekly Epidemiological Bulletins for 2010</p>
			<ul>
				<?php
echo "<table width='100%' align='center'>";
for($i=7;$i<=26;$i++)
{
if($i % 2 == 0)
		{
			echo "<tr>";
			echo "<td style='background-color:#fff'>";
			
			echo "Bulletin for Epiweek ".$i;
			echo "<a style='text-decoration : none;' href='Bulletins/2010/" .$i. ".pdf'>&nbsp;<img src='images/down.png' alt='Download' /></a>"; 
			echo "</td>";
			echo "<td style='background-color:#fff'>";
			echo "Bulletin for Epiweek ".($i+27);
			echo "<a style='text-decoration : none;' href='Bulletins/2010/".($i+27). ".pdf'>&nbsp;<img src='images/down.png' alt='Download' /></a>"; 
			echo "</td>";
			echo "</tr>";
		}
		else
		{
			echo "<tr>";
			echo "<td style='background-color:#eee'>";
			echo "Bulletin for Epiweek ".$i;
			echo "<a style='text-decoration : none;' href='Bulletins/2010/" .$i. ".pdf'>&nbsp;<img src='images/down.png' alt='Download' /></a>"; 
			echo "</td>";
			echo "<td style='background-color:#eee'>";
			echo "Bulletin for Epiweek ".($i+27);
			echo "<a style='text-decoration : none;' href='Bulletins/2010/".($i+27). ".pdf'>&nbsp;<img src='images/down.png' alt='Download' /></a>"; 
			echo "</td>";
			echo "</tr>";
		}
	}
	echo "</table>";
?>
			<ul>
		</div>
		<div class="content tutorials">
<p>Kenya Weekly Epidemiological Bulletins for 2011</p>
			<ul>
				<?php
echo "<table width='100%' align='center'>";
$sql = "select epiweek from surveillance order by epiweek desc limit 1";
$sql_result = mysql_query($sql);
$sql_resultset = mysql_fetch_assoc($sql_result);
$current_epiweek = $sql_resultset['epiweek']-1;//Set it to pick from last week
 
for($i = 1; $i<=$current_epiweek;$i++){

if($i % 2 == 0)
		{
			echo "<tr>";
			echo "<td style='background-color:#fff'>";
			
			echo "Bulletin for Epiweek ".$i;
			echo "<a style='text-decoration : none;' href='Bulletins/2011/" .$i. ".pdf'>&nbsp;<img src='images/down.png' alt='Download' /></a>"; 
			echo "</td>";
$next_week = $i +1;
if($next_week <= $current_epiweek){
$i++;
			echo "<td style='background-color:#fff'>";
			echo "Bulletin for Epiweek ".$i;
			echo "<a style='text-decoration : none;' href='Bulletins/2011/".$i. ".pdf'>&nbsp;<img src='images/down.png' alt='Download' /></a>"; 
			echo "</td>";
}
			echo "</tr>";
		}
		else
		{
			echo "<tr>";
			echo "<td style='background-color:#eee'>";
			echo "Bulletin for Epiweek ".$i;
			echo "<a style='text-decoration : none;' href='Bulletins/2011/" .$i. ".pdf'>&nbsp;<img src='images/down.png' alt='Download' /></a>"; 
			echo "</td>";
$next_week = $i +1;
if($next_week <= $current_epiweek){
$i++;
			echo "<td style='background-color:#eee'>";
			echo "Bulletin for Epiweek ".$i;
			echo "<a style='text-decoration : none;' href='Bulletins/2011/".$i. ".pdf'>&nbsp;<img src='images/down.png' alt='Download' /></a>"; 
			echo "</td>";
}
			echo "</tr>";
		}


}


	echo "</table>";
?>
			<ul>
		</div>
		<div class="content links">
			<h1>&nbsp;</h1>
			<ul>
		</div>
	</div>
	
<script type="text/javascript" src="tabs/tabs.js"></script></div>

</div>

			</div>
			
						<!-- JA NEWS --><!-- //JA NEWS -->
						
			      <!-- JA CONTENT SLIDER --><!-- //JA CONTENT SLIDER -->
        			
  	</div>
  	<!-- //CONTENT -->
  		
  	  	<!-- RIGHT COLUMN -->
  	<div id="ja-colwrap">
  	<div class="ja-innerpad">
  	
  	 	  	
  				<div class="moduletable" id="Mod29">
						<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">VISION</span></span></h3>
						<div class="ja-box-ct clearfix">
			<p><strong>An effective and efficient  surveillance and response system that results in a reduction in morbidity, mortality and disability from disease outbreaks and other Public Health events in Kenya</strong></p>			
			</div>
    </div>
			<div class="moduletable" id="Mod31">
						<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">MISSION</span></span></h3>
						<div class="ja-box-ct clearfix">
			<p><strong>Provide leadership and participate in surveillance, preparedness and response to disease outbreaks and other Public Health events in Kenya.</strong></p>			
			</div>
    </div>
			<div class="moduletable" id="Mod30">
						<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">CORE FUNCTIONS</span></span></h3>
						<div class="ja-box-ct clearfix">
			<ul>
<li>Case Detection</li>
<li>Case Registration and reporting</li>
<li>Lab Confirmation</li>
<li>Data Analysis and Interpretation</li>
<li>Response</li>
<li>Provide Feedback</li>
<li>Evaluation and Improvement of the system</li>
</ul>			</div>
    </div>
			<div class="moduletable" id="Mod38">
						<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">Contact Us</span></span></h3>
						<div class="ja-box-ct clearfix">
			<div class="ja-tabswrap quartz" style="width:100%;">	<div id="myTab-1852520348" class="container">	<div class="ja-tabs-title-top" style="height:30px;">			
								<ul class="ja-tabs-title"><li title="mod_jdownloads_latest" class="first active"><h3><span>Mail & Telephone</span></h3></li></ul>
							</div>						
							<div class="ja-tab-panels-top" style="height: 200px; "><div class="ja-tab-content" style="left: 0px; top: 0px; ">
							<div class="ja-tab-subcontent"><table width="100%" class="moduletable"><tbody><tr valign="top"><td align="left"><a href="#">HEAD&cedil; </a></td></tr><tr valign="top">
							  <td align="left">DIVISION OF DISEASE SURVEILLANCE &amp; RESPONSE&cedil;</td></tr><tr valign="top"><td align="left"><a href="#">P.O. BOX 20781 - 00202, KNH, </a></td></tr><tr valign="top"><td align="left">NAIROBI, KENYA.</td></tr><tr valign="top"><td align="left"><a href="#">CELL:+254-722-343341</a></td></tr><tr valign="top"><td align="left">OR</td></tr>
                              <tr valign="top"><td align="left"><a href="#">To the Nearest Health Facility.</a></td></tr></tbody></table>  </div>
						 </div><div class="ja-tab-content" style="left: 265px; top: 0px; ">
							<div class="ja-tab-subcontent"><table width="100%" class="moduletable"><tbody><tr valign="top"><td align="left"><a href="#">+254-722-343341 </a></td><td align="right"></td></tr><tr valign="top"><td align="left"></td><td align="right"></td></tr></tbody></table>  </div>
						 </div><div class="ja-tab-content" style="left: 530px; top: 0px; ">
							<div class="ja-tab-subcontent"><p><a href="#">To the Nearest Health Facility</a></p>  </div>
						 </div></div>	</div>
					</div>
					<script type="text/javascript" charset="utf-8">
						window.addEvent("load", init);
						function init() {
							myTabs1 = new JATabs("myTab-1852520348", {animType:'animMoveHor',style:'quartz',position:'top',width:'100%',height:'auto',mouseType:'mouseover',duration:1000,colors:10,useAjax:false,skipAnim:false});							
						}
						//new JATabs("myTab-1852520348", {animType:'animMoveHor',style:'quartz',position:'top',width:'100%',height:'auto',mouseType:'mouseover',duration:1000,colors:10,useAjax:false,skipAnim:false});													
				     </script>			</div>
    </div>
			<div class="moduletable" id="Mod36">
						<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">Links</span></span></h3>
						<div class="ja-box-ct clearfix">
			<li><a href="http://www.publichealth.go.ke">Ministry of Public Health and Sanitation</a></li>
<li><a href="http://www.medical.go.ke">Ministry of Medical Services</a></li>
<li><a href="http://www.planning.go.ke">Ministry of Planning and Vision 2030</a></li>
<li><a href="http://www.kemri.org">Kenya Medical Research Institute</a></li>
<li><a href="http://www.aidskenya.org">National AIDS Control Council</a></li>
<li><a href="http://www.drh.go.ke">Division of Reproductive Health</a></li>
<li><a href="http://www.nmcp.or.ke">Division of Malaria</a></li>	
<li><a href="http://www.ehealth.or.ke">Master Facility List (MFL)</a></li>		</div>
    </div>
			<div class="moduletable" id="Mod55">
						<div class="ja-box-ct clearfix">
			<p><strong>We encourage members of the public to contact us</strong> <strong class="red">For Further information or reporting of disease outbreaks and other  public health events </strong><strong>or to formally send us any concerns on matters touching on the Division of Disease Surveillance and Response using the Blog on the Report an Outbreak section.</strong><br>
			</p>			</div>
    </div>
	
  		
  	</div></div><br>
  	<!-- //RIGHT COLUMN -->
  	    
  </div></div>
</div>

	
<!-- FOOTER -->
<div id="ja-footer" class="wrap">
<div class="main clearfix" align="center"><strong>Division of Disease Surveillance and Control - Integrated Disease Surveillance and Response (IDSR)</strong><br>

	<small>
	<div align="center">Copyright © 2011 Ministry of Public Health and Sanitation.All Rights Reserved. </div></small>
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


</body></html>