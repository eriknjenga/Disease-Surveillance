<?php
include('functions.php');

$sqlProvinces = "select name from provinces";
$provinceQuery = mysql_query($sqlProvinces) or die(mysql_error());

$sqldates = "select min(datecreated) as mindate, max(datecreated) as maxdate, min(epiweek) as minepi, max(epiweek) as maxepi from surveillance";
$dateQuery = mysql_query($sqldates) or die(mysql_error());
$dates = mysql_fetch_assoc($dateQuery);
?>


<chart caption='Provincial comparisons for epiweeks <?php echo $dates['minepi']; ?> to <?php echo $dates['maxepi']; ?>' subcaption='(from <?php echo $dates['mindate']; ?> to <?php echo $dates['maxdate']; ?>)' lineThickness='1' showValues='0' formatNumberScale='0' anchorRadius='2'   bgColor="FFFFFF" divLineAlpha='20' divLineColor='CC3300' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridAlpha='5' alternateHGridColor='CC3300' shadowAlpha='40' labelStep="2" numvdivlines='5' chartRightMargin="35" showBorder='0' animation='1' xAxisName='Epiweeks' yAxisName='Proportion of Timely Reports'>
    <categories >
        <?php
        $sql_epiweeks = "SELECT distinct epiweek FROM surveillance order by epiweek asc";
        $sql_result_epiweeks = mysql_query($sql_epiweeks) or die(mysql_error());
        $epiweeks = array();
        $counter = 0;
        while ($epiweek = mysql_fetch_assoc($sql_result_epiweeks)) {
            $epiweeks[$counter] = $epiweek['epiweek'];
            $counter++;
        }

        foreach ($epiweeks as $epiweek) {
            ?>
            <category label='<?php echo $epiweek; ?>' />

        <?php } ?>
    </categories>

    <?php
    $provinces = array();
    $sqlProvinces = "select * from provinces";
    $sqlResultProvinces = mysql_query($sqlProvinces) or die(mysql_error());
    $provinceCounter = 0;
    while ($province = mysql_fetch_assoc($sqlResultProvinces)) {
        $provinces[$province['ID']] = $province['name'];
    }

    $province_ids = array_keys($provinces);
    foreach ($provinces as $province) {
        ?>
        <dataset seriesName='<?php echo $province; ?>' >
            <?php
            foreach ($epiweeks as $epiweek) {

                $reportedSql = "SELECT count( DISTINCT (surveillance.district) ) AS Reporters from districts,surveillance where surveillance.district = districts.id  and epiweek = '$epiweek' and districts.province = '" . $province_ids[$provinceCounter] . "' group by districts.province";
                $reportedBuffer = mysql_query($reportedSql) or die(mysql_error());

                $reportedResult = mysql_fetch_assoc($reportedBuffer);
                $reporters = $reportedResult['Reporters'];
                if (mysql_num_rows($reportedResult) == "") {
                    $reportedResult['Reporters'] == 0;
                }


                $constantSql = "select count(districts.id) as districts from districts, provinces where districts.province = '" . $province_ids[$provinceCounter] . "' group by provinces.id";
                $constantBuffer = mysql_query($constantSql) or die(mysql_error());
                $constantDistricts = mysql_fetch_assoc($constantBuffer);
                $constants = $constantDistricts['districts'];
                $rr = floor(($reporters/$constants)*100);
                ?>
                <set value='<?php echo $rr; ?>' />

            <?php } ?>
        </dataset>
        <?php
        $provinceCounter++;
    }

echo "</chart>";

?>