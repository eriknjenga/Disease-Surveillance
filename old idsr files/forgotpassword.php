<?php
require_once ('/connection/config.php');
?>
<html>
	<head>
		<link rel="stylesheet" href="css.css" />
		<script src="js/jquery.js"></script>
		<script src="js/login.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#show-alert').click(function() {
					$('#alertdiv').insertAfter($(this)).fadeIn('slow').animate({
						opacity : 1.0
					}, 1000).fadeOut('slow', function() {
						$(this).remove();
					});
					return false;
				});
			});
			function pullAjax() {
				var a;
				try {
					a = new XMLHttpRequest()
				} catch(b) {
					try {
						a = new ActiveXObject("Msxml2.XMLHTTP")
					} catch(b) {
						try {
							a = new ActiveXObject("Microsoft.XMLHTTP")
						} catch(b) {
							alert("Your browser broke!");
							return false
						}
					}
				}
				return a;
			}

			function validateEmail() {
				site_root = '';
				var x = document.getElementById('emailorusername');
				var msg = document.getElementById('msg');				
				emailorusername = x.value;
				code = '';
				message = '';
				obj = pullAjax();
				obj.onreadystatechange = function() {
					if(obj.readyState == 4) {
						eval("result = " + obj.responseText);
						code = result['code'];
						message = result['result'];
						if(code <= 0) {
							x.style.border = "1px solid red";
							msg.style.color = "red";
						} else {
							x.style.border = "1px solid #000";
							msg.style.color = "green";
						}
						msg.innerHTML = message;
					}
				}
				var url = site_root + "validatemail.php?emailorusername=" + emailorusername;
				obj.open("GET", url, true);
				obj.send(null);
			}
		</script>
		<title>Forgotten Password Resolution</title>
	</head>
	<body>
		<div id="idsr">
			Integrated Disease Surveillance and Response
		</div>
		<div id="bar">
			<div id="container">
				<!-- Login Starts Here -->
				<div id="loginContainer">
					<a href="#" id="loginButton"><span>Login</span><em></em></a>
					<div style="clear:both"></div>
					<div id="loginBox">
						<form id="loginForm">
							<fieldset id="body">
								<fieldset>
									<label for="email">Email Address</label>
									<input type="text" name="email" id="email" />
								</fieldset>
								<fieldset>
									<label for="password">Password</label>
									<input type="password" name="password" id="password" />
								</fieldset>
								<input type="submit" id="login" value="Sign in" />
								<label for="checkbox">
									<input type="checkbox" id="checkbox" />
									Remember me</label>
							</fieldset>
							<span><a href="#">Forgot your password?</a></span>
						</form>
					</div>
				</div>
				<!-- Login Ends Here -->
			</div>
		</div>
		<div class="larger" style="position: absolute">
			<h2 style="font-family:'Trebuchet MS', Helvetica, sans-serif;">&nbsp;&nbsp;&nbsp;Apparently you have forgotten your password?</h2>
			<p style="font-family:'Trebuchet MS', Helvetica, sans-serif; font-size: 14px">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IDSR will send password reset instructions to the email address associated with your account.
			</p>
			<div class="contain" style="position: absolute">
				<form action="#" method="post">
					<p style="font-family:'Trebuchet MS', Helvetica, sans-serif;">
						&nbsp;&nbsp;&nbsp;&nbsp;Please type your <b>email address</b> or <b>IDSR username</b> below.
					</p>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" id="emailorusername" class="input" align="center" name="emailorusername"/>
					<input type="button" name="submitemail" class="button" align="center" onclick="validateEmail();" value="Submit"/>					
				</form>
				<div id="msg"></div>
			</div>
			<!--<div class="quick-alert" id="alertdiv">
			Alert! Watch me before it's too late!
			</div>-->
		</div>
	</body>
</html>
