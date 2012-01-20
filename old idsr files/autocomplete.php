<?php

$link = mysql_connect('localhost', 'root', '');
if (!$link) {
   die('Could not connect: ' . mysql_error());
}
if (!mysql_select_db("idsr")) {
   echo "Unable to select database: " . mysql_error();
   exit;
}

$result = mysql_query("SELECT name FROM  districts");
while ($row = mysql_fetch_assoc($result)) {
   		$districts[]=$row['name'];
}
mysql_free_result($result);
mysql_close($link);

// check the parameter
if(isset($_GET['part']) and $_GET['part'] != '')
{
	// initialize the results array
	$results = array();

	// search colors
	foreach($districts as $district)
	{
		// if it starts with 'part' add to results
		if( strpos($district, $_GET['part']) === 0 ){
			$results[] = $district;
		}
	}

	// return the array as json with PHP 5.2
	echo json_encode($results);
}