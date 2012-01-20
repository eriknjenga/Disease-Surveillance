<?php
error_reporting(0);
include('national_header.php');
$currentyear = date('Y');
$lastepiweek = GetLastEpiweek($currentyear);

if ($_SESSION['role'] !== '4') {
    echo '<script type="text/javascript">';
    echo "window.location.href='access_denied.php'";
    echo '</script>';
} else {

    $typequery = mysql_query("SELECT name as tname FROM diseasetypes where id ='1'") or die(mysql_error());
    $tdd = mysql_fetch_array($typequery);
    $tname = $tdd['tname'];

    $ttypequery = mysql_query("SELECT name as ttname FROM diseasetypes where id ='2' ") or die(mysql_error());
    $ttdd = mysql_fetch_array($ttypequery);
    $ttname = $ttdd['ttname'];

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
    }
?>
    <style type="text/css">
        select {
            width: 250;}
        </style>
        <div  class="section">


        <form action="edit_district_details.php?week=<?php echo $_GET['epiweek']; ?>&District=<?php echo $_GET['district']; ?>" method="post">

            <table class="data-table">
                <tr>
                    <th></th>
                    <th colspan="4">&le; 5 Years</th>
                    <th colspan="4">&ge; 5 Years</th>
                    <th colspan="4">Total</th>
                    <th colspan="4">Cummulative Total<br />
    			  (As from 1st January)


                </tr>
                <tr>
                    <th>Diseases</th>
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
                    <th>F</th>
                    <th>M</th>
                    <th>F</th>
                    <th>M</th>

                </tr>
                <tr class="even">
                    <td colspan="16"><?php echo '<strong>' . $tname . '</strong>'; ?></td>
            </tr>

            <?php
            $below = 0; //totals of people below or equal 5 years
            $above = 0; //totals of people above 5 years
            $sql = "select ID,name from districts";

                        $result = mysql_query($sql) or die(mysql_error());
                        while(list($ID,$name) = mysql_fetch_array($result)){

                        $query = "SELECT SUM( lmcase ) AS lmcase, SUM( lfcase ) AS lfcase, SUM( lmdeath ) AS lmdeath, SUM( lfdeath ) AS lfdeath, SUM( gmcase ) AS gmcase, SUM( gfcase ) AS gfcase, SUM( gmdeath ) AS gmdeath, SUM( gfdeath ) AS gfdeath
                        FROM surveillance,districts where epiweek = '".$_GET['epiweek']."' and disease='".$_GET['DIS']."' AND surveillance.district = districts.ID AND districts.ID = '$ID' ";
                        $tim=mysql_query($query) or die(mysql_error());
                        $values=mysql_fetch_array($tim);

                        $cumulativequery = "SELECT SUM( lmcase ) AS lmcase, SUM( lfcase ) AS lfcase, SUM( lmdeath ) AS lmdeath, SUM( lfdeath ) AS lfdeath, SUM( gmcase ) AS gmcase, SUM( gfcase ) AS gfcase, SUM( gmdeath ) AS gmdeath, SUM( gfdeath ) AS gfdeath FROM surveillance,districts WHERE epiweek BETWEEN 1 AND '$lastepiweek' AND date='$currentyear' AND districts.ID = '$ID' AND surveillance.district = districts.ID";
                        $shila=mysql_query($cumulativequery) or die(mysql_error());
                        $shilavalues=mysql_fetch_array($shila);

                        $lmc=$values['lmcase'];
                        echo "<tr class=\"even\">";
                        echo "<td name=PRO>" . $name . "</td>";
                        echo "<td>" .$lmc  . "</td>";
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
                //$S = "select ID,name from districts";
                //$res = mysql_query($S);
                //while(list($ID,$name) = mysql_fetch_assoc($res)){
                $labquery = "SELECT DISTINCT malaria_below_5,malaria_above_5,positive_below_5,positive_above_5,remarks FROM lab_weekly,surveillance WHERE lab_weekly.district='" . $_GET['DIS'] . "' and lab_weekly.epiweek = surveillance.epiweek";
                $Query = mysql_query($labquery);

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
                    echo "<tr><td><strong>Remarks</strong></td>";
                    echo "<td colspan=20>" . $row['remarks'] . "</td>";
                }
                // }
                ?>
            <tr>
                <td><input name="edit" type="submit" value="Edit" class="button" />&nbsp;</td>
                <td><a href="submissionlist.php"><input name="back" type="button" value="Back" class="button" /></a></td>
            </tr>
        </table>
<?php
                "</td>";


                echo "</table>";
?>

                <div class="xtop"></div>

<?php } ?>
            <div id="close">
<?php include('footer.php'); ?>
        </div>






