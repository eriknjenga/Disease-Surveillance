<?php
/* if(isSet($_POST['username']))
{
$usernames = array('john','michael','terry', 'steve', 'donald');

$username = $_POST['username'];

if(in_array($username, $usernames))
	{
	echo '<font color="red">The nickname <STRONG>'.$username.'</STRONG> is already in use.</font>';
	}
	else
	{
	echo 'OK';
	}
}*/

// This is a sample code in case you wish to check the username from a mysql db table

if(isset($_POST['epiweek'])&&isset($_POST['district']))
{
$district = $_POST['epiweek'];
$epiweek = $_POST['district'];

$dbHost = "localhost"; // usually localhost
$dbUsername = "root";
$dbPassword = "";
$dbDatabase = "idsr";

$db = mysql_connect($dbHost, $dbUsername, $dbPassword) or die ("Unable to connect to Database Server.");
mysql_select_db ($dbDatabase, $db) or die ("Could not select database.");

$sql_check = mysql_query("SELECT DISTINCT  epiweek,district FROM surveillance WHERE district ='".$district."' AND epiweek ='".$epiweek."'") or die(mysql_error());

if(mysql_num_rows($sql_check))
{
echo '<font color="red"><STRONG>'.$district.'</STRONG> district already has data.</font>';
}
else
{
echo 'OK';
}

}

?>