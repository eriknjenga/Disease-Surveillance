<?php
error_reporting(0);
include('national_header.php');
mysql_select_db("idsr");
$currentyear = date('Y');
$lastepiweek = GetLastEpiweek($currentyear);

mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("test") or die(mysql_error());

$array = array();
$sql = "select district,epiweek from surveillance where epiweek = '$lastepiweek' " or die(mysql_error());
$result = mysql_query($sql);
$counter = 0;

while ($rows = mysql_fetch_assoc($result)) {
    $array[$counter] = $rows['epiweek'];
    $counter++;
}

var_dump($array);
$user_name = $_POST['user_name'];
 if (in_array($user_name, $array))
  {
  //user name is not availble
  echo "no";
  }
  else
  {
  //user name is available
  echo "yes";
  }
?>