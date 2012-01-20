<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('/connection/config.php');
include('functions.php');

$username = $_POST['username'];
$password = $_POST['password'];

// To protect MySQL injection
$username = stripslashes($username); //Un-quotes a quoted string.
$password = stripslashes($password); 
$username = mysql_real_escape_string($username); //Escapes special characters in a string for use in an SQL statement
$password = mysql_real_escape_string($password);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head><title>Integrated Diseases Surveillance Response</title>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">

<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/table.css" rel="stylesheet" type="text/css">

<!-- stylesheets -->
  	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
  	<link rel="stylesheet" href="css/slide.css" type="text/css" media="screen" />
	
  	<!-- PNG FIX for IE6 -->
  	<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script type="text/javascript" src="js/pngfix/supersleight-min.js"></script>
	<![endif]-->
	 
    <!-- jQuery - the core -->
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<!-- Sliding effect -->
	<script src="js/slide.js" type="text/javascript"></script>
	
	<link rel="stylesheet" href="css/dropdown.css" type="text/css" />
<script type="text/javascript" src="js/dropdown.js"></script>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/fadeslideshow.js"></script>
<script type="text/javascript">

var mygallery=new fadeSlideShow({
	wrapperid: "fadeshow1", //ID of blank DIV on page to house Slideshow
	dimensions: [665, 385], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [
		["images/p1010242.jpg", "", "", "Nothing beats relaxing next to the pool when the weather is hot."],
		["images/dsc04286.jpg", "", "_new", "Some day I'd like to explore these caves!"],
		["images/28.jpg"],
		["images/45.jpg"], 
		["images/45.jpg"]//<--no trailing comma after very last image element!
	],
	displaymode: {type:'auto', pause:3500, cycles:0, wraparound:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 5000, //transition duration (milliseconds)
	descreveal: "ondemand",
	togglerid: ""
})

</script>
<link href="css/simpleTicker.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="pro_dropdown_2/pro_dropdown_2.css" />

<script src="pro_dropdown_2/stuHover.js" type="text/javascript"></script>


<style type="text/css">


/* Add some margin to the page and set a default font and colour */

body {
  margin: 30px;
  font-family: "Georgia", serif;
  line-height: 1.8em;
  color: #333;
}


/* Set the content dimensions */

#content {
  width: 800px;
  padding: 50px;
  margin: 0 auto;
  display: block;
  font-size: 1.2em;
}

#content h2 {
  line-height: 1.5em;
}


/* Add curved borders to various elements */

#contactForm, .statusMessage, input[type="submit"], input[type="button"] {
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;  
  border-radius: 10px;
}


/* Style for the contact form and status messages */

#contactForm, .statusMessage {
  color: #666;
  background-color: #ebedf2;
  background: -webkit-gradient( linear, left bottom, left top, color-stop(0,#dfe1e5), color-stop(1, #ebedf2) );
  background: -moz-linear-gradient( center bottom, #dfe1e5 0%, #ebedf2 100% );  
  border: 1px solid #aaa;
  -moz-box-shadow: 0 0 1em rgba(0, 0, 0, .5);
  -webkit-box-shadow: 0 0 1em rgba(0, 0, 0, .5);
  box-shadow: 0 0 1em rgba(0, 0, 0, .5);
  opacity: .95;
}


/* The form dimensions */

#contactForm {
  width: 40em;
  height: 33em;
  padding: 0 1.5em 1.5em 1.5em;
  margin: 0 auto;
}


/* Position the form in the middle of the window (if JavaScript is enabled) */

#contactForm.positioned {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin-top: auto;
  margin-bottom: auto;
}


/* Dimensions and position of the status messages */

.statusMessage {
  display: none;
  margin: auto;
  width: 30em;
  height: 2em;
  padding: 1.5em;
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}

.statusMessage p {
  text-align: center;
  margin: 0;
  padding: 0;
}


/* The header at the top of the form */

#contactForm h2 {
  font-size: 2em;
  font-style: italic;
  letter-spacing: .05em;
  margin: 0 0 1em -.75em;
  padding: 1em;
  width: 19.5em;  
  color: #aeb6aa;
  background: #dfe0e5 url('images/stamp.jpg') no-repeat 15em -3em; /* http://morguefile.com/archive/display/606433 */
  border-bottom: 1px solid #aaa;
  -moz-border-radius: 10px 10px 0 0;
  -webkit-border-radius: 10px 10px 0 0;  
  border-radius: 10px 10px 0 0;
}


/* Give form elements consistent margin, padding and line height */

#contactForm ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

#contactForm ul li {
  margin: .9em 0 0 0;
  padding: 0;
}

#contactForm input, #contactForm label {
  line-height: 1em;
}


/* The field labels */

label {
  display: block;
  float: left;
  clear: left;
  text-align: right;
  width: 28%;
  padding: .4em 0 0 0;
  margin: .15em .5em 0 0;
  font-weight: bold;
}


/* The fields */

input, textarea {
  display: block;
  margin: 0;
  padding: .4em;
  width: 67%;
  font-family: "Georgia", serif;
  font-size: 1em;
  border: 1px solid #aaa;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;    
  border-radius: 5px;
  -moz-box-shadow: rgba(0,0,0,.2) 0 1px 4px inset;
  -webkit-box-shadow: rgba(0,0,0,.2) 0 1px 4px inset;
  box-shadow: rgba(0,0,0,.2) 0 1px 4px inset;
  background: #fff;
}

textarea {
  height: 13em;
  line-height: 1.5em;
  resize: none;
}


/* Place a border around focused fields, and hide the inner shadow */

#contactForm *:focus {
  border: 1px solid #66f;
  outline: none;
  box-shadow: none;
  -moz-box-shadow: none;
  -webkit-box-shadow: none;
}


/* Display correctly filled-in fields with a green background */

input:valid, textarea:valid {
  background: #dfd;
}


/* The Send and Cancel buttons */

input[type="submit"], input[type="button"] {
  float: right;
  margin: 2em 1em 0 1em;
  width: 10em;
  padding: .5em;
  border: 1px solid #666;
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;  
  border-radius: 10px;
  -moz-box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
  -webkit-box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
  box-shadow: 0 0 .5em rgba(0, 0, 0, .8);
  color: #fff;

  background: #0a0;
  font-size: 1em;
  line-height: 1em;
  font-weight: bold;
  opacity: .7;
  -webkit-appearance: none;
  -moz-transition: opacity .5s;
  -webkit-transition: opacity .5s;
  -o-transition: opacity .5s;
  transition: opacity .5s;
}

input[type="submit"]:hover,
input[type="submit"]:active,
input[type="button"]:hover,
input[type="button"]:active {
  cursor: pointer;
  opacity: 1;
}

input[type="submit"]:active, input[type="button"]:active {
  color: #333;
  background: #eee;
  -moz-box-shadow: 0 0 .5em rgba(0, 0, 0, .8) inset;
  -webkit-box-shadow: 0 0 .5em rgba(0, 0, 0, .8) inset;
  box-shadow: 0 0 .5em rgba(0, 0, 0, .8) inset;
}

input[type="button"] {
  background: #f33;
}


/* Header/footer boxes */

.wideBox {
  clear: both;
  text-align: center;
  margin: 70px;
  padding: 10px;
  background: #ebedf2;
  border: 1px solid #333;
}

.wideBox h1 {
  font-weight: bold;
  margin: 20px;
  color: #666;
  font-size: 1.5em;
}

</style>

<!-- Some IE7 hacks and workarounds -->

<!--[if lt IE 8]>
<style>

/* IE7 needs the fields to be floated as well as the labels */

input, textarea {
  float: right;
}

#formButtons {
  clear: both;
}

/*
  IE7 needs an ickier approach to vertical/horizontal centring with fixed positioning.
  The negative margins are half the element's width/height.
*/

#contactForm.positioned, .statusMessage {
  left: 50%;
  top: 50%;
}

#contactForm.positioned {
  margin-left: -20em;
  margin-top: -16.5em;
}

.statusMessage {
  margin-left: -15em;
  margin-top: -1em;
}

</style>
<![endif]-->


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript">

var messageDelay = 2000;  // How long to display status messages (in milliseconds)

// Init the form once the document is ready
$( init );


// Initialize the form

function init() {

  // Hide the form initially.
  // Make submitForm() the form's submit handler.
  // Position the form so it sits in the centre of the browser window.


  // When the "Send us an email" link is clicked:
  // 1. Fade the content out
  // 2. Display the form
  // 3. Move focus to the first field
  // 4. Prevent the link being followed

  $('a[href="#contactForm"]').click( function() {
    $('#content').fadeTo( 'slow', .2 );
    $('#contactForm').fadeIn( 'slow', function() {
      $('#senderName').focus();
    } )

    return false;
  } );
  
  // When the "Cancel" button is clicked, close the form
  $('#cancel').click( function() { 
   
    $('#content').fadeTo( 'slow', 1 );
  } );  

  // When the "Escape" key is pressed, close the form
  $('#contactForm').keydown( function( event ) {
    if ( event.which == 27 ) {
      $('#contactForm').fadeOut();
      $('#content').fadeTo( 'slow', 1 );
    }
  } );

}


// Submit the form via Ajax

function submitForm() {
  var contactForm = $(this);

  // Are all the fields filled in?

  if ( !$('#senderName').val() || !$('#senderEmail').val() || !$('#message').val() ) {

    // No; display a warning message and return to the form
    $('#incompleteMessage').fadeIn().delay(messageDelay).fadeOut();
    contactForm.fadeOut().delay(messageDelay).fadeIn();

  } else {

    // Yes; submit the form to the PHP script via Ajax

    $('#sendingMessage').fadeIn();
    contactForm.fadeOut();

    $.ajax( {
      url: contactForm.attr( 'action' ) + "?ajax=true",
      type: contactForm.attr( 'method' ),
      data: contactForm.serialize(),
      success: submitFinished
    } );
  }

  // Prevent the default form submission occurring
  return false;
}


// Handle the Ajax response

function submitFinished( response ) {
  response = $.trim( response );
  $('#sendingMessage').fadeOut();

  if ( response == "success" ) {

    // Form submitted successfully:
    // 1. Display the success message
    // 2. Clear the form fields
    // 3. Fade the content back in

    $('#successMessage').fadeIn().delay(messageDelay).fadeOut();
    $('#senderName').val( "" );
    $('#senderEmail').val( "" );
    $('#message').val( "" );

    $('#content').delay(messageDelay+500).fadeTo( 'slow', 1 );

  } else {

    // Form submission failed: Display the failure message,
    // then redisplay the form
    $('#failureMessage').fadeIn().delay(messageDelay).fadeOut();
    $('#contactForm').delay(messageDelay+500).fadeIn();
  }
}

</script>


</head>

<body>
<div class="main" id="main-two-columns-left">
	<div>
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
				$checkuser = "SELECT id,role,accounttype FROM users WHERE username='$username' AND password='$password' AND flag = 1";
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
<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			
			<div class="left">
            
				<!-- Login Form -->
				<form class="clearfix" name="form1" method="post">
                <table width="950" border="0">
  <tr>
    
    <th scope="col"><label class="grey" for="username">Username:</label></th>
    <th scope="col"><input class="field" type="text" name="username" id="username" value="" size="23" /></th>
    <th scope="col"><label class="grey" for="password">Password:</label></th>
    <th scope="col"><input class="field" type="password" name="password" id="password" size="23" /></th>
    <th scope="col"><input type="submit" name="Login" value="Login" class="bt_login" /></th>
    <th scope="col"><a class="lost-pwd" href="#">Forgot your password?</a></th>
  </tr>
</table>

		  	
        			<div class="clear"></div>
					
					
				</form>
			</div>
			
		</div>
</div> <!-- /login -->	

	<!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
			<li class="left">&nbsp;</li>
			<li>Hello Guest!</li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#">Log In Here</a>
				<a id="close" style="display: none;" class="close" href="#">Close Panel</a>			
			</li>
			<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div> <!--panel -->
<div align="center">
<table width="950" border="0">
  <tr>
    <td height="856"><table width="15" border="0" height="700px" align="center">
  <tr>
    <td><img src="images/template_r10_c2.gif" alt="Border" height="1700"></td>
  </tr>
</table></td>
    <td><table class="frame" border="0" cellpadding="0" cellspacing="0" width="900" align="center">
      <tbody>
        <tr>
          <td colspan="19"><img src="images/banner.jpg" alt="" height="125" width="896"></td>
          <td width="1"><img src="images/spacer.gif" alt="" height="25" width="1"></td>
        </tr>
        <tr>
         <td colspan="19"><ul id="nav">
	<li class="top"><a href="#nogo1" class="top_link"><span>Home</span></a></li>
	<li class="top"><a href="#nogo2" id="products" class="top_link"><span class="down">About Us</span></a>
		<ul class="sub">
			<li><a href="#nogo3" class="fly">Cameras</a>
					<ul>
						<li><a href="#nogo4">Nikon</a></li>
						<li><a href="#nogo5">Minolta</a></li>
						<li><a href="#nogo6">Pentax</a></li>
					</ul>
			</li>
			<li class="mid"><a href="#nogo7" class="fly">Lenses</a>
					<ul>
						<li><a href="#nogo8">Wide Angle</a></li>
						<li><a href="#nogo9">Standard</a></li>
						<li><a href="#nogo10">Telephoto</a></li>
						<li><a href="#nogo11" class="fly">Zoom</a>
							<ul>
								<li><a href="#nogo12">35mm to 125mm</a></li>
								<li><a href="#nogo13">50mm to 250mm</a></li>
								<li><a href="#nogo14">125mm to 500mm</a></li>
							</ul>
						</li>
						<li><a href="#nogo15">Mirror</a></li>
						<li><a href="#nogo16" class="fly">Non standard</a>
							<ul>
								<li><a href="#nogo17">Bayonet mount</a></li>
								<li><a href="#nogo18">Screw mount</a></li>
							</ul>
						</li>
					</ul>
			</li>
			<li><a href="#nogo19">Flash Guns</a></li>
			<li><a href="#nogo20">Tripods</a></li>
			<li><a href="#nogo21">Filters</a></li>
		</ul>
	</li>
	<li class="top"><a href="#nogo22" id="services" class="top_link"><span class="down">Resources</span></a>
		<ul class="sub">
			<li><a href="#nogo23">Printing</a></li>
			<li><a href="#nogo24">Photo Framing</a></li>
			<li><a href="#nogo25">Retouching</a></li>
			<li><a href="#nogo26">Archiving</a></li>
		</ul>
	</li>
	<li class="top"><a href="#nogo27" id="contacts" class="top_link"><span class="down">Events</span></a>
		<ul class="sub">
			<li><a href="#nogo28">Support</a></li>
			<li><a href="#nogo29" class="fly">Sales</a>
				<ul>
					<li><a href="#nogo30">USA</a></li>
					<li><a href="#nogo31">Canadian</a></li>
					<li><a href="#nogo32">South American</a></li>
					<li><a href="#nogo33" class="fly">European</a>
						<ul>
							<li><a href="#nogo34" class="fly">British</a>
								<ul>
									<li><a href="#nogo35">London</a></li>
									<li><a href="#nogo36">Liverpool</a></li>
									<li><a href="#nogo37">Glasgow</a></li>
									<li><a href="#nogo38" class="fly">Bristol</a>
										<ul>
											<li><a href="#nogo39">Redland</a></li>
											<li><a href="#nogo40">Hanham</a></li>
											<li><a href="#nogo41">Eastville</a></li>
										</ul>
									</li>
									<li><a href="#nogo42">Cardiff</a></li>
									<li><a href="#nogo43">Belfast</a></li>
								</ul>
							</li>
							<li><a href="#nogo44">French</a></li>
							<li><a href="#nogo45">German</a></li>
							<li><a href="#nogo46">Spanish</a></li>
						</ul>
					</li>
					<li><a href="#nogo47">Australian</a></li>
					<li><a href="#nogo48">Asian</a></li>
				</ul>
			</li>
			<li><a href="#nogo49">Buying</a></li>
			<li><a href="#nogo50">Photographers</a></li>
			<li><a href="#nogo51">Stockist</a></li>
			<li><a href="#nogo52">General</a></li>
		</ul>
	</li>
	<li class="top"><a href="#nogo53" id="shop" class="top_link"><span class="down">Clinicians Booklet</span></a>
		<ul class="sub">
			<li><a href="#nogo54">Online</a></li>
			<li><a href="#nogo55">Catalogue</a></li>
			<li><a href="#nogo56">Mail Order</a></li>
		</ul>
	</li>
	<li class="top"><a href="#nogo57" id="privacy" class="top_link"><span>Contact Us</span></a></li>
    <li class="top"><a href="#nogo57" id="privacy" class="top_link"><span>FAQs</span></a></li>
</ul></td>
          <td><img src="images/spacer.gif" alt="" height="25" width="1"></td>
        </tr>
        <tr>
          <td colspan="19"><table width="900" border="0" height="250">
              <tr>
                
                <td width="700"><div id="mytable"><table width="100%" border="0">
  <tr>
    <td class="mytable_th">The Ministry Offices</td>
  </tr>
  <tr>
    <td class="mytable_td"><img src="images/afya.jpg" width="676" height="413" alt="Afya house"></td>
  </tr>
  <tr>
    <td class="mytable_th">Contact Details</td>
  </tr>
  <tr>
    <td class="mytable_td"><div class="list"><div id="img"></div>A nation free from preventable disease and ill health. </div>
    <div class="list"><div id="img"></div>To provide effective leadership and participate in provision of quality Public Health and Sanitation services that are: equitable, responsive, accessible and accountable to Kenyans.</div>
    </td>
  </tr>
  <tr>
    <td class="mytable_th">our core functions</td>
  </tr>
  <tr>
    <td class="mytable_td"><form id="contactForm" action="form/processForm.php" method="post">

  <h2>Send us an email...</h2>

  <ul>

    <li>
      <label for="senderName">Your Name</label>
      <input type="text" name="senderName" id="senderName" placeholder="Please type your name" required="required" maxlength="40" />
    </li>

    <li>
      <label for="senderEmail">Your Email Address</label>
      <input type="email" name="senderEmail" id="senderEmail" placeholder="Please type your email address" required="required" maxlength="50" />
    </li>

    <li>
      <label for="message" style="padding-top: .5em;">Your Message</label>
      <textarea name="message" id="message" placeholder="Please type your message" required="required" cols="80" rows="10" maxlength="10000"></textarea>
    </li>

  </ul>

  <div id="formButtons">
    <input type="submit" id="sendMessage" name="sendMessage" value="Send Email" />
    <input type="button" id="cancel" name="cancel" value="Cancel" />
  </div>

</form>

<div id="sendingMessage" class="statusMessage"><p>Sending your message. Please wait...</p></div>
<div id="successMessage" class="statusMessage"><p>Thanks for sending your message! We'll get back to you shortly.</p></div>
<div id="failureMessage" class="statusMessage"><p>There was a problem sending your message. Please try again.</p></div>
<div id="incompleteMessage" class="statusMessage"><p>Please complete all the fields in the form before sending.</p></div></td>
  </tr>
</table></div>
</td>
                <td width="185"><table border="0" 
cellpadding="0" cellspacing="3"><form method="get" action="search.php"></form><tbody><tr
 align="left"><td><font class="style5">Search:</font></td><td><input 
class="textfield" name="keywords" size="15" type="text"></td><td><input 
src="images/Serach.jpg" value="Search Site" alt="Search" 
type="image" border="0" width="25" height="23"></td></tr></tbody></table>

	
	              <table width="180" border="0" height="330">
                    <tr>
                      <td><img src="images/wn.jpg" width="180" height="35" alt="News"></td>
                    </tr>
                    <tr>
                      <td><div id="tickerContainer">
      <dl id="ticker">
        <dt class="heading">The specific goals of IDSR are to:</dt>
        <dd class="text">
          <ul>
            <li>Strengthen district level surveillance and response for priority diseases,</li>
          </ul>
          <ul>
            <li></li>
          </ul>
        </dd>
        <dt class="heading">Disease control </dt>
        <dd class="text">Health surveillance, monitoring and analysis </dd>
        <dt class="heading">Malaria Control</dt>
        <dd class="text">Malaria Control Programme</dd>
        <dt class="heading">Non-Communicable Disease Control</dt><dd class="text">Investigation of disease outbreaks, epidemics and risk to health </dd>
        <dt class="heading">Government Chemist</dt><dd class="text">Undertake operational research in order to develop&nbsp; development and evaluate innovations on disease control interventions .</dd>
      </dl>
    </div></td>
                    </tr>
                  </table>
	              <script type="text/javascript" src="js/jquery.min.js"></script>
                  <table width="100%" border="0">
                    <tr>
                      <td><img src="images/implementattion.jpg" width="183" height="368" alt="IDSR in Kenya"></td>
                    </tr>
                  </table>
                  <script type="text/javascript">
	  $(function() {
	  
		//cache the ticker
		var ticker = $("#ticker");
		  
		//wrap dt:dd pairs in divs
		ticker.children().filter("dt").each(function() {
		  
		  var dt = $(this),
		    container = $("<div>");
		  
		  dt.next().appendTo(container);
		  dt.prependTo(container);
		  
		  container.appendTo(ticker);
		});
				
		//hide the scrollbar
		ticker.css("overflow", "hidden");
		
		//animator function
		function animator(currentItem) {
		    
		  //work out new anim duration
		  var distance = currentItem.height();
			duration = (distance + parseInt(currentItem.css("marginTop"))) / 0.025;

		  //animate the first child of the ticker
		  currentItem.animate({ marginTop: -distance }, duration, "linear", function() {
		    
			//move current item to the bottom
			currentItem.appendTo(currentItem.parent()).css("marginTop", 0);

			//recurse
			animator(currentItem.parent().children(":first"));
		  }); 
		};
		
		//start the ticker
		animator(ticker.children(":first"));
				
		//set mouseenter
		ticker.mouseenter(function() {
		  
		  //stop current animation
		  ticker.children().stop();
		  
		});
		
		//set mouseleave
		ticker.mouseleave(function() {
		          
          //resume animation
		  animator(ticker.children(":first"));
		  
		});
	  });
    </script>	</td>
              </tr>
          </table></td>
          <td><img src="images/spacer.gif" alt="" height="25" width="1"></td>
        </tr>
		<tr>
        <td colspan="19">
        
		<table width="100%" border="0">
  <tr>
    <td width="20%" bgcolor="#999999" style="font-size:16px; font-weight:bold; color:#FFF;" height="30" align="center">Public</td>
    <td width="26%" bgcolor="#666666" style="font-size:16px; font-weight:bold; color:#FFF;" height="30" align="center">Popular</td>
    <td width="33%" bgcolor="#333333" style="font-size:16px; font-weight:bold; color:#FFF;" height="30" align="center">Our Services</td>
    <td width="21%" bgcolor="#111111" style="font-size:16px; font-weight:bold; color:#FFF;" height="30" align="center">Polls</td>
  </tr>
  <tr>
    <td><img src="images/corruption.jpg" width="182" height="94" alt="Corruption"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="images/forum.jpg" width="182" height="94" alt="Forum"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

        </td>
         
        </tr>
        <tr>
          <td colspan="19"><img src="images/down.gif" alt="" height="25" width="900"></td>
          <td><img src="images/spacer.gif" alt="" height="25" width="1"></td>
        </tr>
        <tr>
          <td colspan="5" class="text3" align="center" bgcolor="#ffffff" valign="middle"> Copyright 2011 © MOH <br></td>
          <td colspan="14" class="text4" align="center" bgcolor="#ffffff" valign="middle"><a href="#">Home</a> | <a href="#">About Us</a> | <a href="#">Events</a> | <a href="#">Resources</a> | <a href="#">News</a> | <a href="#">Contact Us</a></td>
          <td><img src="images/spacer.gif" alt="" height="34" width="1"></td>
        </tr>
        <tr>
          <td><img src="images/spacer.gif" alt="" height="1" width="16"></td>
          <td width="48"><img src="images/spacer.gif" alt="" height="1" width="48"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="121"></td>
          <td width="14"><img src="images/spacer.gif" alt="" height="1" width="12"></td>
          <td width="71"><img src="images/spacer.gif" alt="" height="1" width="61"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="25"></td>
          <td width="161"><img src="images/spacer.gif" alt="" height="1" width="139"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="37"></td>
          <td width="59"><img src="images/spacer.gif" alt="" height="1" width="51"></td>
          <td width="5"><img src="images/spacer.gif" alt="" height="1" width="4"></td>
          <td width="16"><img src="images/spacer.gif" alt="" height="1" width="14"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="16"></td>
          <td width="6"><img src="images/spacer.gif" alt="" height="1" width="5"></td>
          <td width="14"><img src="images/spacer.gif" alt="" height="1" width="12"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="37"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="143"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="21"></td>
          <td width="9"><img src="images/spacer.gif" alt="" height="1" width="8"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="5"></td>
          <td></td>
        </tr>
      </tbody>
    </table></td>
    <td><table width="15" border="0" height="700px" align="center">
  <tr>
    <td><img src="images/template_r10_c2.gif" alt="Border" height="1700"></td>
  </tr>
</table></td>
  </tr>
</table>


 
    
</div>

</body></html>