<?php
mysql_connect("localhost","root","");
mysql_select_db("idsr");

function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

$sqldates = mysql_query("select count(distinct(surveillance.datereportedby)) as datereported, surveillance.epiweek as epiweek from surveillance,deadlines where surveillance.epiweek = deadlines.epiweek and surveillance.datereportedby > deadlines.deadline group by deadlines.epiweek asc") or die(mysql_error());
while($result = mysql_fetch_assoc($sqldates)){
    echo $result["epiweek"]. " with " .$result["datereported"] . "<br/>";
}




