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
    <html>
        <head>
            <style type="text/css">
                select {
                    width: 250;}
                </style>

                <script type="text/javascript">
                    function dave(form){
                        var val = form.province.options[form.province.options.selectedIndex].value;
                        self.location = 'districtviewdetails.php?province=' + val;
                    }
                </script>
            </head>
            
            <?php
                $sqlDistrictName = "select name from districts where id = $_GET[district]";
                $query = mysql_query($sqlDistrictName);
                $districtName = mysql_fetch_assoc($query);
                
            ?>

            <div style="position: absolute; left: 600px"><p style="font-size: small"><strong>DETAILS FOR <?php echo strtoupper($districtName['name']); ?> FOR EPIWEEK <?php echo $_GET['epiweek']; ?></strong></p></div>
            <div style="position: absolute; left: 400px; top: 230px">
                <form action="districtviewdetails.php?epiweek=<?php echo $_GET['epiweek']; ?>&District=<?php echo $_GET['district']; ?>&yr=<?php echo $_GET['filteryear']; ?>&provinces=<?php echo $_GET['province']; ?>" method="get" name="submissionlist">
                    <table>
                        <tr>

                            <td>

                                <!--Province Select
                                ----
                                ----
                                ----
                                ----
                                ---->

                                Province
                                <?php
                                $province = $_GET['province'];
                                mysql_select_db("idsr");
                                $sqlfour = "SELECT ID,name FROM provinces";
                                $fourthresult = mysql_query($sqlfour);
                                echo "<select name=\"province\" onchange=\"dave(this.form)\"><option value=''>Select Province</option>";
                                while ($row = mysql_fetch_assoc($fourthresult)) {
                                    if ($row[ID] == $province) {
                                        echo "<option selected value='$row[ID]'>$row[name]</option>" . "<br>";
                                    } else {
                                        echo "<option value=\"$row[ID]\">$row[name]</option>";
                                    }
                                }
                                echo "</select>";
                                ?></td>


                            <td>

                                <!--District Select
                                ----
                                ----
                                ----
                                ----
                                ---->
                                District
                                <?php
                                if (isset($province)) {
                                    $sqltwo = "SELECT ID,name,province FROM districts WHERE province = $province";
                                }
                                $secondresult = mysql_query($sqltwo);
                                echo "<select name=\"district\"><option selected>Select District";
                                while ($row = mysql_fetch_assoc($secondresult)) {
                                    echo "<option value='$row[ID]'>$row[name]</option>";
                                }
                                ?></td>

                            <td>Epiweek

                                <select name="epiweek"><option selected>Select Epiweek<?php
                            for ($w = 1; $w <= 52; $w++) {
                                echo "<option>" . $w;
                                //echo $w + "\n";
                            }
                                ?>
                                </select>
                            </td>

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
                            <td>
                                <input name="filter" type="submit" class="button" value="Filter">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

            <div style="position: absolute; top: 280px; left: 350px">
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

                            $sql = "select SUM(lmcase) AS lmcase,SUM(lfcase) AS lfcase,SUM(lmdeath) AS lmdeath,SUM(lfdeath) AS lfdeath from surveillance where district = '" . $_GET['district'] . "' and disease IN (SELECT id FROM diseases WHERE name='$disease') AND epiweek='" . $_GET['epiweek'] . "' AND YEAR(datemodified) = '" . $_GET['filteryear'] . "'";
                            $result = mysql_query($sql) or die(mysql_error());
                            $values = mysql_fetch_array($result);
                            $mcasebelow = $values['lmcase'];
                            //$below+=$mcasebelow;
                            $fcasebelow = $values['lfcase'];
                            //$below+=$fcasebelow;
                            $mdeathbelow = $values['lmdeath'];
                            //$below+=$mdeathbelow;
                            $fdeathbelow = $values['lfdeath'];
                            //$below+=$fdeathbelow;

                            echo "<td>" . $mcasebelow . "</td>";
                            echo "<td>" . $fcasebelow . "</td>";
                            echo "<td>" . $mdeathbelow . "</td>";
                            echo "<td>" . $fdeathbelow . "</td>";

                            $sql = "select SUM(gmcase) AS gmcase,SUM(gfcase) AS gfcase,SUM(gmdeath) AS gmdeath,SUM(gfdeath) AS gfdeath from surveillance where district = '" . $_GET['district'] . "' AND disease IN (SELECT id FROM diseases WHERE name='$disease') AND epiweek='" . $_GET['epiweek'] . "' AND YEAR(datemodified) = '" . $_GET['filteryear'] . "'";
                            $result = mysql_query($sql) or die(mysql_error());
                            $values = mysql_fetch_array($result);

                            $cumulativequery = "SELECT SUM( lmcase ) AS lmcase, SUM( lfcase ) AS lfcase, SUM( lmdeath ) AS lmdeath, SUM( lfdeath ) AS lfdeath, SUM( gmcase ) AS gmcase, SUM( gfcase ) AS gfcase, SUM( gmdeath ) AS gmdeath, SUM( gfdeath ) AS gfdeath
                       FROM surveillance,districts where district = '" . $_GET['district'] . "' AND districts.province = '" . $_GET['province'] . "' AND disease IN (SELECT id FROM diseases WHERE name='$disease') AND epiweek between 1 and '" . $_GET['epiweek'] . "' AND YEAR(datemodified) = $currentyear";                         
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
                            
                            $labquery = "SELECT sum(malaria_below_5) as malaria_below_5,sum(malaria_above_5) as malaria_above_5,sum(positive_below_5) as positive_below_5,sum(positive_above_5) as positive_above_5 FROM lab_weekly WHERE lab_weekly.epiweek = '".$_GET['epiweek']."' ";
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
                            // }
                            ?>
                        <tr>  
                            <form action="edit_district_details.php?epiweek=<?php echo $_GET['epiweek']; ?>&District=<?php echo $_GET['district']; ?>&yr=<?php echo $_GET['filteryear']; ?>&provinces=<?php echo $_GET['province'];?>" method="post">
                            <td><input name="edit" type="submit" value="Edit" class="button" />&nbsp;</td>
                            <td><a href="submissionlist.php" style="color: red">Click here to go back</a></td>
                            </form>
                        </tr>
                        <?php
                        echo "</table>";
                        echo "</div>";
                        ?>

                    <?php } ?>