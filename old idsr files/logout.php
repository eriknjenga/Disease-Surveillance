<?php
include('/connection/config.php');

$sessionuserid = $_SESSION['id'];
$sessionid = $_SESSION['maxsession'];

$logouttime = date("h:i:s A");
$logoutdate = date("Y-m-d");

$sql = "UPDATE loghistory SET logoutdate = '$logoutdate', logouttime = '$logouttime' WHERE  sessionid = '$sessionid' AND user = '$sessionuserid'";
$lastaccessrec= mysql_query($sql)or die(mysql_error());
	   


if ($lastaccessrec )
{ 
	header('Location: index.php');
}
session_destroy();
?>
