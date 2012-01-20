<html>
    <head>
                <?php
        error_reporting(0);
	$link = 'submission_list';
        include('national_header.php');
        mysql_select_db("idsr");
        $currentyear = date('Y');
        $lastepiweek = GetLastEpiweek($currentyear);

        if ($_SESSION['role'] !== '4') {
            echo '<script type="text/javascript">';
            echo "window.location.href='access_denied.php'";
            echo '</script>';
        } else {
            ?>
        <script src="jquery-ui-1.8.12.custom/development-bundle/jquery-1.5.1.js"></script>
        <script src="jquery-ui-1.8.12.custom/development-bundle/ui/jquery.ui.core.js"></script>
        <script src="jquery-ui-1.8.12.custom/development-bundle/ui/jquery.ui.widget.js"></script>
        <script src="jquery-ui-1.8.12.custom/development-bundle/ui/jquery.ui.mouse.js"></script>
        <script src="jquery-ui-1.8.12.custom/development-bundle/ui/jquery.ui.draggable.js"></script>
        
        <style>
	#draggable {}
	</style>
	<script>
	$(function() {
		$( "#draggable" ).draggable();
	});
	</script>

            <script type="text/javascript">
                function dave(form){
                    var val = form.province.options[form.province.options.selectedIndex].value;
                    self.location = 'submissionlist.php?province=' + val;
                }
            </script>
        </head>

        <div  class="section">
            <div class="section-title" align="center"> <strong>SUBMISSIONS LIST  FOR EPI WEEK <?php echo $lastepiweek; ?>  </strong></div>
            <div align="center">
                <form action="districtviewdetails.php?week=<?php echo $_GET['epiweek']; ?>&District=<?php echo $_GET['district']; ?>&yr=<?php echo $_GET['filteryear']; ?>&provinces=<?php echo $_GET['province']; ?>" method="get" name="submissionlist">
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
                                    $sqltwo = "SELECT ID,name,province FROM districts WHERE province = $province ORDER BY name ASC";
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
                                <input name="filter" type="submit" class="button" value="Filter"/>
                            </td>
                        </tr>
                    </table>
                </form></div>

            <?php
            //if($_REQUEST['filter'])

            $epiweek = $_GET['epiweek'];
            $nm = $_GET['name'];

            echo "\n";
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

                <div id="draggable" class="section" align="center">
                <table class="data-table">
                    <tr>
                        <th>&nbsp;</th>
                        <th colspan="4">&le; 5 Years</th>
                        <th colspan="4">&ge; 5 Years</th>
                        <th colspan="4">Total</th>
                        <th colspan="4">Cummulative Total<br />
                                                                    			  (As from 1st January) </th>
                        <th colspan="4"><br />
                        </th>

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
                        <th colspan="4"></th>

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
                        <th></th>


                    </tr>
                    <tr class="even">
                        <td colspan="28">
    <?php echo '<strong>' . $tname . '</strong>'; ?>
                        </td>
                    </tr>

                    <?php
                    $below = 0; //totals of people below or equal 5 years
                    $above = 0; //totals of people above 5 years                     
                    $sql = "select ID,name from diseases";
                    $result = mysql_query($sql) or die(mysql_error());
                    while (list($ID, $name) = mysql_fetch_array($result)) {

                        $query = "SELECT SUM( lmcase ) AS lmcase, SUM( lfcase ) AS lfcase, SUM( lmdeath ) AS lmdeath, SUM( lfdeath ) AS lfdeath, SUM( gmcase ) AS gmcase, SUM( gfcase ) AS gfcase, SUM( gmdeath ) AS gmdeath, SUM( gfdeath ) AS gfdeath
                            FROM surveillance where epiweek = '$lastepiweek' and disease='$ID'";
                        $tim = mysql_query($query) or die(mysql_error());
                        $values = mysql_fetch_array($tim);

                        $cumulativequery = "SELECT SUM( lmcase ) AS lmcase, SUM( lfcase ) AS lfcase, SUM( lmdeath ) AS lmdeath, SUM( lfdeath ) AS lfdeath, SUM( gmcase ) AS gmcase, SUM( gfcase ) AS gfcase, SUM( gmdeath ) AS gmdeath, SUM( gfdeath ) AS gfdeath
                            FROM surveillance WHERE epiweek BETWEEN 1 AND '$lastepiweek' AND disease='$ID' and date='$currentyear'";
                        $shila = mysql_query($cumulativequery) or die(mysql_error());
                        $shilavalues = mysql_fetch_array($shila);

                        $lmc = $values['lmcase'];
                        echo "<tr class=\"even\">";
                        echo "<td name=\"DIS\">" . $name . "</td>";
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
                        echo "<td>" . ($shilavalues['lfcase'] + $shilavalues['gfcase']) . "</td>";
                        echo "<td>" . ($shilavalues['lmdeath'] + $shilavalues['gmdeath']) . "</td>";
                        echo "<td>" . ($shilavalues['lfdeath'] + $shilavalues['gfdeath']) . "</td>";

                        echo "<td colspan=6><a href=\"viewprovincedetails.php?epiweek=$lastepiweek&DIS=$ID\" style=color:red>View Details</a></td>";
                    }
                    echo "</tr>";
                    ?>

                    <tr class="even">
                        <td colspan="20">&nbsp;</td>
                    </tr>
                </table>
            </div>

            <div class="xtop"></div>

<?php } ?>
        </html>