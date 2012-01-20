<?php
function cleanData(&$str){
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace ('"', '""', $str) . '"';
}
mysql_connect("localhost","root","");
mysql_select_db("idsr");

$filename = "Weekly_Bulletin" . date('Ymd') . ".xls";

$districtNames = array();
$sqlDistricts = "SELECT name FROM diseases";
$sqlDistrictsResults = mysql_query($sqlDistricts) or die(mysql_error());
while($districtResultset = mysql_fetch_assoc($sqlDistrictsResults)){
$districtNames[] = $districtResultset;
}

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");
//$flag = false;
foreach($districtNames as $row){
//    if(!$flag){
//    echo implode("\t", array_keys($row));
//    $flag = true;
//    }
    array_walk($row, 'cleanData');
    echo implode("\t", array_values($row)) . "\t";
}
?>

