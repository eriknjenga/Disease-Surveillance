<?php
error_reporting(0);
include('district_header.php');
$currentyear = date('Y');
$lastepiweek = GetLastEpiweek($currentyear);

if ($_SESSION['role'] !== '3') {
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


        <form method="post">
            <table>
                    <tr>
                        <td>                                                                                    
                            <!--Facility Select
                            ----
                            ----
                            ----
                            ----
                            ---->
                            Facility
                            <?php
                            $sqltwo = "SELECT id,name FROM facilitys WHERE district = '" . $_SESSION['districtid'] . "' ";
                            $secondresult = mysql_query($sqltwo);
                            echo "<select name=\"facility\"><option selected>Select Facility</option>";
                            while ($row = mysql_fetch_assoc($secondresult)) {
                                echo "<option value='$row[id]'>$row[name]</option>";
                            }
                            ?>
                        </td>

                        <!--Year Select
                        ----
                        ----
                        ----
                        ----
                        ---->
                        <td>Epiweek
                            <?
                            $epiweeksql = "SELECT DISTINCT epiweek FROM surveillance WHERE district = '" . $_SESSION['districtid'] . "' ";
                            $epiweekresult = mysql_query($epiweeksql);
                            echo "<select name=epiweek><option selected>Select Epiweek</option>";
                            while ($epirow = mysql_fetch_assoc($epiweekresult)) {
                                echo "<option value ='$epirow[epiweek]'>$epirow[epiweek]</option>";
                            }
                            ?>
                        </td>

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
                        <td>
                            <input name="filter" type="submit" class="button" value="Filter">
                        </td>
                    </tr>
                </table>


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
                    <th>M</th>
                    <th>F</th>
                    <th>M</th>
                    <th>F</th>


                </tr>
                <tr class="even">
                    <td colspan="16"><?php echo '<strong>' . $tname . '</strong>'; ?></td>
            </tr>

            <?php
            $below = 0; //totals of people below or equal 5 years
            $above = 0; //totals of people above 5 years
            foreach ($disease_names as $disease) {
                echo "<tr class=\"even\">";
                echo "<td name=\"DIS\">" . $disease . "</td>";

                $sql = "select SUM(lmcase) AS lmcase,SUM(lfcase) AS lfcase,SUM(lmdeath) AS lmdeath,SUM(lfdeath) AS lfdeath from surveillance where facility = '" . $_GET['facility'] . "' and disease IN (SELECT id FROM diseases WHERE name='$disease') AND epiweek='" . $_GET['epiweek'] . "' AND YEAR(datemodified) = '" . $_GET['filteryear'] . "'";
                $result = mysql_query($sql) or die(mysql_error());
                $values = mysql_fetch_array($result);
                $mcasebelow = $values['lmcase'];
                $fcasebelow = $values['lfcase'];
                $mdeathbelow = $values['lmdeath'];
                $fdeathbelow = $values['lfdeath'];
                
                echo "<td>" . $mcasebelow . "</td>";
                echo "<td>" . $fcasebelow . "</td>";
                echo "<td>" . $mdeathbelow . "</td>";
                echo "<td>" . $fdeathbelow . "</td>";

                $cumulativequery = "SELECT SUM( lmcase ) AS lmcase, SUM( lfcase ) AS lfcase, SUM( lmdeath ) AS lmdeath, SUM( lfdeath ) AS lfdeath, SUM( gmcase ) AS gmcase, SUM( gfcase ) AS gfcase, SUM( gmdeath ) AS gmdeath, SUM( gfdeath ) AS gfdeath
                       FROM surveillance,facilitys where facility = '" . $_GET['facility'] . "' AND facilitys.district = '" . $_GET['district'] . "' AND disease IN (SELECT id FROM diseases WHERE name='$disease') AND epiweek between 1 and '" . $_GET['epiweek'] . "' AND YEAR(datemodified) = $currentyear";                
                $shila = mysql_query($cumulativequery) or die(mysql_error());
                $shilavalues = mysql_fetch_array($shila);
                $mcaseabove = $values['gmcase'];
                
                $fcaseabove = $values['gfcase'];
                
                $mdeathabove = $values['gmdeath'];
                
                $fdeathabove = $values['gfdeath'];
                

                $mcasebelow2 = $shilavalues['lmcase'];
                $fcasebelow2 = $shilavalues['lfcase'];
                $mdeathbelow2 = $shilavalues['lmdeath'];
                $fdeathbelow2 = $shilavalues['lfdeath'];
                $mcaseabove2 = $shilavalues['gmcase2'];
                $fcaseabove2 = $shilavalues['gfcase'];
                $mdeathabove2 = $shilavalues['gmdeath'];
                $fdeathabove2 = $shilavalues['gfdeath'];


                echo "<td>" . $mcaseabove . "</td>";
                echo "<td>" . $fcaseabove . "</td>";
                echo "<td>" . $mdeathabove . "</td>";
                echo "<td>" . $fdeathabove . "</td>";


                echo "<td>" . ($mcaseabove + $mcasebelow) . "</td>";
                echo "<td>" . ($fcaseabove + $fcasebelow) . "</td>";
                echo "<td>" . ($mdeathabove + $mdeathbelow) . "</td>";
                echo "<td>" . ($fdeathabove + $fdeathbelow) . "</td>";

                echo "<td>" . ($mcasebelow2 + $mcaseabove2) . "</td>";
                echo "<td>" . ($mdeathbelow2 + $mdeathabove2) . "</td>";
                echo "<td>" . ($fcasebelow2 + $fcaseabove2) . "</td>";
                echo "<td>" . ($fdeathbelow2 + $fdeathabove2) . "</td>";
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

                        $labquery = "SELECT sum(malaria_below_5) as malaria_below_5,sum(malaria_above_5) as malaria_above_5,sum(positive_below_5) as positive_below_5,sum(positive_above_5) as positive_above_5 FROM lab_weekly WHERE lab_weekly.epiweek = '$lastepiweek' AND district = '" . $_SESSION['districtid'] . "' ";
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
            <tr>
                <td><a href="<?php echo $_GET['epiweek']; ?>&Facility=<?php echo $_GET['facility']; ?>">Edit</a>&nbsp;</td>
                <td><a href="districts_submission_list.php"><input name="back" type="button" value="Back" class="button" /></a></td>
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






