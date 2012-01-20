<?php
include 'FusionCharts/FusionCharts.php';
?>

<html>
    <head>
        <script language="javascript" src="FusionCharts/FusionCharts.js">
        </script>
    </head>
    <body>
        <?
        mysql_connect("localhost", "root", "");
        mysql_select_db("idsr");

        function dateDiff($start, $end) {
            $start_ts = strtotime($start);
            $end_ts = strtotime($end);
            $diff = $end_ts - $start_ts;
            return round($diff / 86400);
        }

        $dateArray = array();
        //$districts = array();
        $counter = 0;
        $dateSql = "select reportingtime, deadline, district from dashboarddemo";
        $dateQuery = mysql_query($dateSql) or die(mysql_error());
        while ($dateResults = mysql_fetch_assoc($dateQuery)) {
            $dateArray[$counter][1] = dateDiff($dateResults['reportingtime'], $dateResults['deadline']);           
            $dateArray[$counter][2] = $dateResults['district'];
            $counter++;            
        }

        echo "<p align=center><b> Timeliness </b></p>";
        $strXML = "<chart formatNumberScale='0'>";
        foreach ($dateArray as $dates) {
            $strXML .= "<set label='" . $dates[2] . "' value='" . $dates[1] . "' />";
        }
        
        $strXML .= "<trendlines><line startValue='0' isTrendZone='0' displayValue='Deadline  30-06-2011' color='ff0000'/></trendlines>";

        $strXML .= "</chart>";

        
        echo renderChart("FusionCharts/Bar2D.swf", "", $strXML, "", 800, 500, false, false);
        ?>
    </body>
</html>
