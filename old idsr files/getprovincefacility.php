<?php
session_start();
$province=$_GET['province']; // Use this line or below line if register_global is off
	//require_once("../config.php");
	/*$res=mysql_connect($mysql_server,$mysql_user,$mysql_pass);
	mysql_select_db($mysql_db);*/
	
	if ($province ==1)
	{
	$start=1;
	$end=11;
	}
	else if ($province ==2)
	{
	$start=12;
	$end=24;
	}
	else if ($province ==3)
	{
	$start=25;
	$end=52;
	}
	else if ($province ==5)
	{
	$start=53;
	$end=55;
	}
	else if ($province ==6)
	{
	$start=56;
	$end=66;
	}
	else if ($province ==7)
	{
	$start=67;
	$end=87;
	
	$start2=150;
	$end2=151;
	
	$start3=157;
	$end3=158;
	}
	else if ($province ==8)
	{
	$start=88;
	$end=108;
	}
	else if ($province ==9)
	{
	$start=131;
	$end=155;
	}
	$mysql_link = mysql_connect("localhost", "root", ""); 
	mysql_select_db("idsr") or die("Could not select database");
	require("combo_connector.php");
	$combo = new ComboConnector($mysql_link);
	$combo->enable_log("temp.log");
	//$combo->render_sql("SELECT * FROM country_data  WHERE country_id >40 ","country_id","name");
	//$combo->render_sql("SELECT ID,name  FROM facilitys where  districts BETWEEN  53 AND 55 ","ID","name" );
	
	if ($province ==7)
	{
	$combo->render_sql("SELECT ID,name  FROM facilitys WHERE ((district BETWEEN $start AND $end) OR (district BETWEEN  $start2 AND $end2) OR (district BETWEEN  $start3 AND $end3)) ","ID","name" );
	}
	else
	{	
	$combo->render_sql("SELECT ID,name  FROM facilitys WHERE district BETWEEN $start AND $end ","ID","name" );
	
	}
	
	
?>