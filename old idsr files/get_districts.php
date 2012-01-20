<?php
session_start();

	$mysql_link = mysql_connect("localhost", "root", ""); 
	mysql_select_db("idsr") or die("Could not select database");
	require("combo_connector.php");
	$combo = new ComboConnector($mysql_link);
	$combo->enable_log("temp.log");
	
	
	

	$combo->render_sql("SELECT ID,name  FROM districts ","ID","name" );
	
	
	
	
?>