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

        $testSql = "SELECT count( DISTINCT (surveillance.district) ) AS Reporters, (districts.province) as provinces from districts,surveillance where surveillance.district = districts.id group by provinces";
        $testBuffer = mysql_query($testSql) or die(mysql_error());
        $counter = 0;
        while ($testResult = mysql_fetch_array($testBuffer)) {
            $namesnids[$counter][1] = $testResult['Reporters'];
            //$namesnids[$counter][3] = $testResult['Names'];
            $counter++;
        }

        $provinces = "select distinct(province) as province,count(districts.id) as districts,provinces.name as name from districts, provinces where provinces.id = districts.province group by provinces.id";
        $prsql = mysql_query($provinces) or die(mysql_error());
        $counter2 = 0;
        while ($provinceResult = mysql_fetch_array($prsql)) {
            $namesnids[$counter2][2] = $provinceResult['districts'];
            $counter2++;
        }

        $mwathi = array();
        for ($a = 0; $a < count($namesnids); $a++) {
            $value = ($namesnids[$a][1] / $namesnids[$a][2]) * 100;
            $mwathi[$a][1] = $namesnids[$a][3];
            $mwathi[$a][2] = floor($value);
        }


        echo "<p align=center><b> Number of Reporting Districts with respect to Province </b></p>";
        $strXML = "<chart formatNumberScale='0'>";
        foreach ($mwathi as $names) {
            $strXML .= "<set label='" . $names[1] . "' value='" . $names[2] . "' />";
        }

        $strXML .= "</chart>";

        echo renderChart("FusionCharts/Line.swf", "", $strXML, "", 800, 500, false, false);
        ?>
    </body>
</html>