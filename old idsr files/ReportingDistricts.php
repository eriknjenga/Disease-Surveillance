<?php
include 'national_header.php';
include 'FusionCharts/FusionCharts.php';
?>

<html>
    <head>
        <script language="javascript" src="FusionCharts/FusionCharts.js"></script>
    </head>
    <body>
        <?
        mysql_connect("localhost", "root", "");
        mysql_select_db("idsr");
        
        $namesnids = array();
        $testSql = "SELECT count( DISTINCT (district) ) AS Submitters, provinces.name AS Names FROM surveillance, districts, provinces WHERE surveillance.district = districts.id  and provinces.id = districts.province GROUP BY province";
        $testBuffer = mysql_query($testSql) or die(mysql_error());
        $counter = 0;
        while ($testResult = mysql_fetch_array($testBuffer)) {
            $namesnids[$counter][1] = $testResult['Names'];
            $namesnids[$counter][2] = $testResult['Submitters'];            
            $counter++;
        }                
        
        $provinces = "select distinct(province) as province,count(districts.id) as districts,provinces.name as name from districts, provinces where provinces.id = districts.province group by provinces.id";
        $prsql = mysql_query($provinces);
        echo "<div style=\"position: absolute; top:400px; left:200px\">";
        echo "<table class=data-table>";
        echo "<tr><th>Province</th><th>Expected Reports</th>";
        while($prres = mysql_fetch_assoc($prsql)){
            echo "<tr><td>" . $prres['name'] . "</td>";
            
            echo "<td>" . $prres['districts'] . "</td></tr>";
            
        }
        
        echo "</table>";
        echo "</div>";
        
        echo "<p align=center><b> Number of Reporting Districts with respect to Province </b></p>";
        $strXML = "<chart formatNumberScale='0'>";
        foreach ($namesnids as $names) {
            $strXML .= "<set label='" . $names[1] . "' value='" . $names[2] . "' />";
        }

        $strXML .= "</chart>";

        echo renderChart("FusionCharts/Line.swf", "", $strXML, "", 800, 500, false, false);
        ?>
    </body>
</html>