<?php
include('functions.php');
$currentyear = date('Y');
$lastepiweek = GetLastEpiweek($currentyear);

$DatabaseHost = "localhost";
$DatabaseUser = "root";
$DatabasePassword = "";
$Database = "idsr";

mysql_connect($DatabaseHost, $DatabaseUser, $DatabasePassword) or die(mysql_error());
mysql_select_db($Database);
$user = strip_tags(trim($_REQUEST['cat']));
$epiweek = strip_tags(trim($_REQUEST['epiweek']));
if(strlen($user) <=0 )
{
    echo json_encode(array('code' => -1,'result' => 'Invalid username, please try again'));
    die;
}//end if

$query = "SELECT name FROM districts WHERE ID = '$user'";
$result = mysql_query($query);
$available = mysql_num_rows($result);
$details = mysql_fetch_assoc($result);
if($available){
    $q = "SELECT name FROM districts WHERE ID = '$user' AND id IN(SELECT DISTINCT district FROM surveillance WHERE epiweek = '$epiweek')";
    $res = mysql_query($q);
    $avail = mysql_num_rows($res);
    if($avail){
        echo json_encode(array('code' => 0, 'result' => "Sorry, but ".$details['name']." already has epiweek $epiweek data"));
        die;
    }
 else {
        echo json_encode(array('code' => 1, 'result' => "You can enter ".$details['name']." data"));
    }
}//end if
else{
    
      echo json_encode(array('code' => 0, 'result' => "No such district exists"));
    die;
}//end else
die;
?>