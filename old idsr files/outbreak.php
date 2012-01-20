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
  <title>IDSR OUTBREAK REPORT</title>


 <link rel="stylesheet" href="home/style.css" type="text/css">
  <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
  
<script type="text/javascript" src="javascript/jquery.min.js"></script>
<script type="text/javascript" src="javascript/jquery.simplemodal.js"></script>
<script type="text/javascript" src="javascript/init.js"></script>

<link type='text/css' href='style/stylesheet.css' rel='stylesheet' media='screen' />
<link type='text/css' href='style/basic.css' rel='stylesheet' media='screen' />

<link rel="stylesheet" href="css_form/style.css" type="text/css" media="all" />
	<link rel="stylesheet" href="css_form/css/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
    
		<link rel="stylesheet" href="css_form/css/template.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<script src="css_form/js/jquery.min.js" type="text/javascript"></script>

		<script src="css_form/js/jquery.validationEngine-en.js" type="text/javascript"></script>
		<script src="css_form/js/jquery.validationEngine.js" type="text/javascript"></script>

		<script>
		$(document).ready(function() {
			
			
			
			// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
			$("#form1").validationEngine({
				ajaxSubmit: true,
					ajaxSubmitFile: "ajaxSubmit.php",
					ajaxSubmitMessage: "Thank you, We will contact you soon !",
				success : function() { callSuccessFunction() },
				failure : function() {}
			})
			

		
		});
		</script>
        
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
    <strong>You are here:</strong><span class="breadcrumbs pathway"> Report an Outbreak
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

	
				<div class="article_row clearfix">
									<div class="article_column column1 cols1">
						

<div class="contentpaneopen clearfix">



<div class="article-content"><div class="ja-innerpad">


<div class="img-desc clearfix"></div>

    <h2 class="contentheading">
  	  	<a href="#" class="contentpagetitle">
  		Report an Outbreak 	</a>
</h2>
<div id="wrapper">
  <div id="form-div">
    <form id="form1" class="form" method="post" target="ajaxSubmit.php">
      <p class="name">
        <input name="name" type="text" class="validate[required,custom[onlyLetter],length[0,100]] text-input" id="name" value="" />
        <label for="name">Full Name</label>
      </p><br />
      <p class="email">
        <input name="province" type="text" class="validate[required,custom[onlyLetter],length[0,100]] text-input" id="province" value="" />
        <label for="email">Province</label><br />
      </p>
      <p class="web">
        <input type="text" name="district" id="district" class="validate[required,custom[onlyLetter],length[0,100]] text-input" />
        <label for="district">District</label>
      </p>
      <p class="text">
        <textarea name="text" class="validate[required,length[6,300]] text-input" id="comment"></textarea>
      </p>
      <p class="submit">
        <input type="submit" value="Send" />
      </p>
    </form>

  </div>
</div>
  
</div></div>

</div>

					</div>
					<span class="article_separator">&nbsp;</span>
								<span class="row_separator">&nbsp;</span>
			</div>
		
	
					
			  </div>

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

</div>


</body></html>