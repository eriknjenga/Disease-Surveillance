<?php
session_start();
error_reporting(0);
include('district_header.php');
mysql_select_db("idsr");
$currentyear = date('Y');
$lastepiweek = GetLastEpiweek($currentyear);




if ($_SESSION['role'] !== '3') {
    echo '<script type="text/javascript">';
    echo "window.location.href='access_denied.php'";
    echo '</script>';
} else {
?>
    <div  class="section">
        <div class="section-title"> <strong>AGGREGATED IDSR FACILITY WEEKLY EPIDEMIC MONITORING FORMS FOR EPI WEEK <?php echo $lastepiweek; ?>  </strong></div>

        <form action="facilityviewdetails.php?week=<?php echo $_GET['epiweek'] ?>&Facility=<?php echo $_GET['facility'] ?>&yr=<?php echo $_GET['filteryear']?>" method="get">
            <table>
                <tr>
                    <td>Epiweek

                        <select name="epiweek"><option selected>Select Epiweek<?php
    for ($w = 1; $w <= 52; $w++) {
        echo "<option >" . $w;
    }
?></select>
                </td><td>
                    Facility
                    <?php
                    mysql_select_db("idsr");
                    $sqltwo = "SELECT id,name FROM facilitys";
                    $secondresult = mysql_query($sqltwo);
                    echo "<select name=\"facility\">";
                    echo "<option size=30 selected>Select Facility</option>";
                    if (mysql_num_rows($secondresult)) {
                        while ($row = mysql_fetch_assoc($secondresult)) {
                            echo "<option value='$row[id]'>$row[name]</option>";
                        }
                    }
                    ?></td>
                
                
                <!--Year Select
                    ----
                    ----
                    ----
                    ----
                    ---->
                        <td>
                            Year
                        <?php                      
                        $sqlthree = "SELECT DISTINCT YEAR(datemodified) as filteryear FROM surveillance";                        
                        $thirdresult = mysql_query($sqlthree);
                        echo "<select name=\"filteryear\"><option selected>Select Year";
                        if (mysql_num_rows($thirdresult)) {
                            while ($row = mysql_fetch_assoc($thirdresult)) {
                                echo "<option value='$row[filteryear]'>$row[filteryear]</option>";
                            }
                        }
                        ?>
                        </td>                                                
                <td><input name="filter" type="submit" class="button" value="Filter"></td></tr></table>
    </form>

<?php
                    $epiweek = $_GET['epiweek'];
                    $nm = $_GET['name'];

                    echo "\n";
                    $typequery = mysql_query("SELECT name as tname FROM diseasetypes where id ='1'") or die(mysql_error());
                    $tdd = mysql_fetch_array($typequery);
                    $tname = $tdd['tname'];

                    $result = mysql_query("SELECT * FROM diseases") or die(mysql_error());
                    $values = mysql_num_rows($result);
                    $i = 0;
                    $disease_names = array();
                    $disease_ids = array();
                    while ($i < $values) {
                        $value1 = mysql_result($result, $i, "name");
                        $value2 = mysql_result($result, $i, "id");
                        $disease_names[$i] = $value1;
                        $disease_ids[$i] = $value2;
                        $i++;
                    } ?>
                    <style type="text/css">
                        select {
                            width: 250;}
                        </style>
                        <div  class="section">



                        <table class="data-table">
                            <tr>
                                <th>&nbsp;</th>
                                <th colspan="4">&le; 5 Years</th>
                                <th colspan="4">&ge; 5 Years</th>
                                <th colspan="4">Total</th>
                                <th colspan="4">Cummulative Total<br />
                                                                			  (As from 1st January) </th>


                            </tr>
                            <tr>
                                <th>Districts</th>
                                <th colspan="2">Cases</th>
                                <th colspan="2">Deaths</th>
                                <th colspan="2">Cases</th>
                                <th colspan="2">Deaths</th>
                                <th colspan="2">Cases</th>
                                <th colspan="2">Deaths</th>
                                <th colspan="2">Cases</th>
                                <th colspan="2">Deaths</th>


                                                <!--<th>Tasks</th>-->
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <th>M</th>
                                <th>F</th>
                                <th>M</th>
                                <th>F</th>
                                <th>M</th>
                                <th>F</th>
                                <th>M</th>
                                <th>F</th>
                                <th>M</th>
                                <th>F</th>
                                <th>M</th>
                                <th>F</th>
                                <th>M</th>
                                <th>F</th>
                                <th>M</th>
                                <th>F</th>



                            </tr>

<?php
                    $below = 0; //totals of people below or equal 5 years
                    $above = 0; //totals of people above 5 years

                    $sql = "select ID,name from districts";

                    $result = mysql_query($sql) or die(mysql_error());
                    while (list($ID, $name) = mysql_fetch_array($result)) {

                        $query = "SELECT SUM( lmcase ) AS lmcase, SUM( lfcase ) AS lfcase, SUM( lmdeath ) AS lmdeath, SUM( lfdeath ) AS lfdeath, SUM( gmcase ) AS gmcase, SUM( gfcase ) AS gfcase, SUM( gmdeath ) AS gmdeath, SUM( gfdeath ) AS gfdeath
                        FROM surveillance,facilitys where epiweek = '" . $_GET['epiweek'] . "' and disease='" . $_GET['DIS'] . "' AND surveillance.facility = facilitys.id AND facilitys.district = '$ID' ";
                        $tim = mysql_query($query) or die(mysql_error());
                        $values = mysql_fetch_array($tim);

                        $cumulativequery = "SELECT SUM( lmcase ) AS lmcase, SUM( lfcase ) AS lfcase, SUM( lmdeath ) AS lmdeath, SUM( lfdeath ) AS lfdeath, SUM( gmcase ) AS gmcase, SUM( gfcase ) AS gfcase, SUM( gmdeath ) AS gmdeath, SUM( gfdeath ) AS gfdeath FROM surveillance,facilitys WHERE epiweek BETWEEN 1 AND '$lastepiweek' AND date='$currentyear' AND facilitys.district = '$ID' AND surveillance.facility = facilitys.id";
                        $shila = mysql_query($cumulativequery) or die(mysql_error());
                        $shilavalues = mysql_fetch_array($shila);

                        $lmc = $values['lmcase'];
                        echo "<tr class=\"even\">";
                        echo "<td name=PRO>" . $name . "</td>";
                        echo "<td>" . $lmc . "</td>";
                        echo "<td>" . $values['lfcase'] . "</td>";
                        echo "<td>" . $values['lmdeath'] . "</td>";
                        echo "<td>" . $values['lfdeath'] . "</td>";
                        echo "<td>" . $values['gmcase'] . "</td>";
                        echo "<td>" . $values['gfcase'] . "</td>";
                        echo "<td>" . $values['gmdeath'] . "</td>";
                        echo "<td>" . $values['gfdeath'] . "</td>";

                        echo "<td>" . ($values['lmcase'] + $values['gmcase']) . "</td>";
                        echo "<td>" . ($values['lfcase'] + $values['gfcase']) . "</td>";
                        echo "<td>" . ($values['lmdeath'] + $values['gmdeath']) . "</td>";
                        echo "<td>" . ($values['lfdeath'] + $values['gfdeath']) . "</td>";

                        echo "<td>" . ($shilavalues['lmcase'] + $shilavalues['gmcase']) . "</td>";
                        echo "<td>" . ($shilavalues['lmdeath'] + $shilavalues['gmdeath']) . "</td>";
                        echo "<td>" . ($shilavalues['lfcase'] + $shilavalues['gfcase']) . "</td>";
                        echo "<td>" . ($shilavalues['lfdeath'] + $shilavalues['gfdeath']) . "</td>";
                    }
                    echo "</tr>";
?>

                    <tr class="even">
                        <td colspan="20">&nbsp;</td>
                    </tr>
                    <tr class="even">
<?php
                    echo "<th colspan=20>Laboratory Weekly Malaria Confirmation</th>";
                    echo "<tr class=even>";
                    echo "<tr><td></td>";
                    echo "<td colspan=6><5 Years</td>";
                    echo "<td colspan=6>>=5 Years</td>";
                    echo "<td colspan=6>Total</td>";
                    echo "</tr>";

                    $labquery = "SELECT sum(malaria_below_5) as malaria_below_5,sum(malaria_above_5) as malaria_above_5,sum(positive_below_5) as positive_below_5,sum(positive_above_5) as positive_above_5 FROM lab_weekly WHERE lab_weekly.epiweek = '$lastepiweek'";
                    $Query = mysql_query($labquery) or die(mysql_error());

                    while ($row = mysql_fetch_assoc($Query)) {
                        echo "<tr><td>" . "Total Number Tested" . "</td>";
                        echo "<td colspan=6>" . $row['malaria_below_5'] . "</td>";
                        echo "<td colspan=6>" . $row['malaria_above_5'] . "</td>";
                        echo "<td colspan=6>" . ($row['malaria_above_5'] + $row['malaria_below_5']) . "</td></tr>";
                        echo "</tr>";
                        echo "<tr><td>" . "Total Number Positive" . "</td>";
                        echo "<td colspan=6>" . $row['positive_below_5'] . "</td>";
                        echo "<td colspan=6>" . $row['positive_above_5'] . "</td>";
                        echo "<td colspan=6>" . ($row['positive_above_5'] + $row['positive_below_5']) . "</td></tr>";
                    }
                    echo "</table>";
?>

                <div class="xtop"></div>

<?php } ?>