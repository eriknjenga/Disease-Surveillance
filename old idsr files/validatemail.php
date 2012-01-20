<?php
include ('functions.php');

$DatabaseHost = "localhost";
$DatabaseUser = "root";
$DatabasePassword = "";
$Database = "idsr";

mysql_connect($DatabaseHost, $DatabaseUser, $DatabasePassword) or die(mysql_error());
mysql_select_db($Database);
$mail = strip_tags(trim($_REQUEST['emailorusername']));

if (strlen($mail) <= 0) {
	echo json_encode(array('code' => -1, 'result' => 'That\'s a joke, right?'));
	die ;
}//end if

$query = "SELECT username,email FROM users WHERE username = '$mail' or email = '$mail'";
$result = mysql_query($query);
$available = mysql_num_rows($result);
$details = mysql_fetch_assoc($result);
if ($available) {
	$q = "SELECT password,email FROM users WHERE username = '$mail' OR email = '$mail'";
	$res = mysql_query($q);
	$yourmail = mysql_fetch_assoc($res);

	$avail = mysql_num_rows($res);
	if ($avail) {
		$to = $yourmail['email'];
		$subject = "Password";
		//$headers = "From: localhost";
		$message = "Your password is" . $yourmail['password'];
		mail($to, $subject, stripslashes($message), null, 'localhost');
		echo json_encode(array('code' => 1, 'result' => "Check your mail " . $yourmail['email'] . " for the password, it has been sent there. Thank you."));
		die ;
	} else {
		echo json_encode(array('code' => 0, 'result' => "This is a funny error, coz you can't not have a password..."));
	}
}//end if
else {

	echo json_encode(array('code' => 0, 'result' => "No such username or password exists"));
	die ;
}//end else
die ;
?>