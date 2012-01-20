<?php
include 'national_header.php';


$sqlProvinces = "select name from provinces";
$provinceQuery = mysql_query($sqlProvinces) or die(mysql_error());

$sqldates = "select min(datecreated) as mindate, max(datecreated) as maxdate, min(epiweek) as minepi, max(epiweek) as maxepi from surveillance";
$dateQuery = mysql_query($sqldates) or die(mysql_error());
$dates = mysql_fetch_assoc($dateQuery);
?>


<chart caption='National Comparisons for epiweeks<?php echo $dates['minepi']; ?> to <?php echo $dates['maxepi']; ?>' subcaption='(from <?php echo $dates['mindate']; ?> to <?php echo $dates['maxdate']; ?>)' lineThickness='1' showValues='0' formatNumberScale='0' anchorRadius='2'   divLineAlpha='20' divLineColor='CC3300' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridAlpha='5' alternateHGridColor='CC3300' shadowAlpha='40' labelStep="2" numvdivlines='5' chartRightMargin="35" bgColor='FFFFFF' bgAlpha='10,10' xAxisName='Epiweeks' yAxisName='Proportion of Timely Reports' showBorder='0'>
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

        ?>
        <dataset seriesName='National Report' >
            <?php
            foreach ($epiweeks as $epiweek) {

                $reportedSql = "SELECT count( DISTINCT (surveillance.district) ) AS Reporters from surveillance where epiweek = '$epiweek'";
                $reportedBuffer = mysql_query($reportedSql) or die(mysql_error());

                $reportedResult = mysql_fetch_assoc($reportedBuffer);
                $reporters = $reportedResult['Reporters'];
                if (mysql_num_rows($reportedResult) == "") {
                    $reportedResult['Reporters'] == 0;
                }


                $constantSql = "select count(districts.id) as districts from districts";
                $constantBuffer = mysql_query($constantSql) or die(mysql_error());
                $constantDistricts = mysql_fetch_assoc($constantBuffer);
                $constants = $constantDistricts['districts'];
                $rr = floor(($reporters/$constants)*100);
                ?>
                <set value='<?php echo $rr; ?>' />

            <?php } ?>
        </dataset>

    <styles>                
        <definition>

            <style name='CaptionFont' type='font' size='12'/>
        </definition>
        <application>
            <apply toObject='CAPTION' styles='CaptionFont' />
            <apply toObject='SUBCAPTION' styles='CaptionFont' />
        </application>
    </styles>

</chart>
