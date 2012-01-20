<?php
include 'national_header.php';
include 'FusionCharts/FusionCharts.php';

?>

<html>
    <head>
        <script language="javascript" src="FusionCharts/FusionCharts.js"></script>
    </head>
    <body>
        <form action="DistrictPies.php?epiweek=<?php echo $_GET['epiweek']; ?>&province=<?php echo $_GET['province']; ?>" method="get" name="DistrictPies">
            <div style="position: absolute; top: 200px; left: 400px">
                <table>
                    <tr><td>
                            <input type="submit" name="submit" value="Filter" class="button"/>
                        </td>
                    </tr>
                    <tr><td>
                            <select name="epiweek">

                                <?php
                                $epiweeksql = mysql_query("select distinct epiweek from surveillance");
                                while ($epires = mysql_fetch_assoc($epiweeksql)) {
                                    echo "<option value=$epires[epiweek]>" . $epires['epiweek'];
                                }
                                ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr><td>
                            <select name="province">

                                <?php
                                $province = mysql_query("select id,name from provinces");
                                while ($prores = mysql_fetch_assoc($province)) {
                                    echo "<option value=$prores[id]>" . $prores['name'];
                                }
                                ?></option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <?
            $namesnids = array();
            $testSql = "SELECT count( DISTINCT (district) ) AS Submitters,provinces.name as Names from surveillance,provinces,districts where provinces.id = districts.province and surveillance.district = districts.id and provinces.id = '".$_GET['province']."' and epiweek= '".$_GET[epiweek]."' ";
            $districtsquery = mysql_query("select count(id) as expected from districts where province = '".$_GET['province']."'");
            $districtres = mysql_fetch_assoc($districtsquery);
            $testBuffer = mysql_query($testSql) or die(mysql_error());
            $counter = 0;
            while ($testResult = mysql_fetch_array($testBuffer)) {
                $namesnids[$counter][1] = $testResult['Names'];
                $namesnids[$counter][2] = $testResult['Submitters'];
                $counter++;
            }


            echo "<p align=center><b> Number of Reporting Districts with respect to Province </b></p>";
            $strXML = "<chart formatNumberScale='0'>";
            foreach ($namesnids as $names) {
                $strXML .= "<set label='" . $names[1] . "' value='" . $names[2] . "' />";
                $strXML .= "<set label='" . $names[1] . "' value='" . ($districtres['expected'] - $names[2]) . "' />";
            }

            $strXML .= "</chart>";

            echo renderChart("FusionCharts/Pie3D.swf", "", $strXML, "chart3", 800, 500, false, false);
            ?>
        </form>
    </body>
</html>