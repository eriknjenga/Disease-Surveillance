<?php
error_reporting(0);
include('district_header.php');

if ($_SESSION['role'] !== '3') {
    echo '<script type="text/javascript">';
    echo "window.location.href='access_denied.php'";
    echo '</script>';
} else {
    $autocode = $_GET['q']; //facility code
    $currentyear = date('Y');
    $yearsago = $currentyear - 5;
?>
<html>
    <head>
        <link rel="stylesheet" href="validation/css/validationEngine.jquery.css" type="text/css">
        <link rel="stylesheet" href="jquery-ui-1.8.12.custom/development-bundle/themes/base/jquery.ui.all.css">
        <link rel="stylesheet" href="jquery-ui-1.8.12.custom/development-bundle/demos/demos.css">
        <script src="jquery-ui-1.8.12.custom/development-bundle/jquery-1.5.1.js"></script>
        <script src="validation/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
        <script src="validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
        <script src="jquery-ui-1.8.12.custom/development-bundle/ui/jquery.ui.core.js"></script>
        <script src="jquery-ui-1.8.12.custom/development-bundle/ui/jquery.ui.widget.js"></script>
        <script src="jquery-ui-1.8.12.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>

        <script>
            jQuery(document).ready(function(){
                jQuery("#formular").validationEngine();
            });
        </script>
        <script>
            $(function() {
                $( "#weekending" ).datepicker({
                    altField: "#epiweek",
                    altFormat: "DD,d MM, yy",
                    onClose:	function(date,inst){
                        var new_date = new Date(date);
                        var dave =  getWeek(new_date)-1;
                        $("#epiweek").attr("value",dave);
                        //alert(dave);

                    }
                });
                $(".zero_reporting").change(function (){

                    zeroReporting(this.id);
                });
            });
            function getWeek(date) {
                var checkDate = new Date(date.getTime());
                // Find Sunday of this week starting on Monday
                checkDate.setDate(checkDate.getDate() + 7 - (checkDate.getDay() || 7));
                var time = checkDate.getTime();
                checkDate.setMonth(0); // Compare with Jan 1
                checkDate.setDate(1);
                return Math.floor(Math.round((time - checkDate) / 86400000) / 7) + 1;
            }

            function zeroReporting(id){
                var temp = id.split("_");
                var disease = temp[1];
                var lmcase = "lmcase_"+disease;
                $("#"+lmcase).attr("value","0");
                var lfcase = "lfcase_"+disease;
                $("#"+lfcase).attr("value","0");
                var lmdeath = "lmdeath_"+disease;
                $("#"+lmdeath).attr("value","0");
                var lfdeath = "lfdeath_"+disease;
                $("#"+lfdeath).attr("value","0");
                var gmcase = "gmcase_"+disease;
                $("#"+gmcase).attr("value","0");
                var gfcase = "gfcase_"+disease;
                $("#"+gfcase).attr("value","0");
                var gmdeath = "gmdeath_"+disease;
                $("#"+gmdeath).attr("value","0");
                var gfdeath = "gfdeath_"+disease;
                $("#"+gfdeath).attr("value","0");
            }
        </script>

        <style type="text/css">
            select {
                width: 250;}
            </style>

            <script>
                window.dhx_globalImgPath="img/";
            </script>

            <script src="dhtmlxcombo_extra.js"></script>
            <link rel="STYLESHEET" type="text/css" href="dhtmlxcombo.css">
            <link type="text/css" href="calendar.css" rel="stylesheet" />
            <link href="base/jquery-ui.css" rel="stylesheet" type="text/css"/>

            <script src="dhtmlxcommon.js"></script>
            <script src="dhtmlxcombo.js"></script>
        </head>

        <body>
            <div  class="section">
            <div class="section-title"> <strong>ADD &le; Weekly Disease Survey </strong></div>
            <div class="xtop">
            <?php
            if ($autocode != "") {
            ?>
                <table>
                    <tr>
                        <td style="width:auto" ><div class="success"><?php
                echo '<strong>' . ' <font color="#666600">' . $savedcommunity . ' Community Unit Plan Successfully Saved' . '<br/>' . ' Please Enter Details for the other Community Unit' . '</strong>' . ' </font>';
            ?></div></th>
                </tr>
            </table>
            <?php } ?>

            <form id="formular" name="formular" method="post" action="#" >

                <table><tr>
                        <?php
                        if ($_POST['save']) {


                            $lmcase = ($_POST['lmcase']);
                            $lfcase = $_POST['lfcase'];
                            $lmdeath = $_POST['lmdeath'];
                            $lfdeath = $_POST['lfdeath'];

                            $gmcase = ($_POST['gmcase']);
                            $gfcase = $_POST['gfcase'];
                            $gmdeath = $_POST['gmdeath'];
                            $gfdeath = $_POST['gfdeath'];

                            $diseases = $_POST['testid'];
                            $facility = $_POST['cat'];
                            $epiweek = $_POST['epiweek'];
                            $expected = $_POST['expected'];
                            $submitted = $_POST['submitted'];
                            $weekending = $_POST['weekending'];
                            $reportedby = $_POST['reportedby'];
                            $designation = strtoupper($_POST['designation']);
                            $datereportedby = $_POST[$date];

                            $totaltestedmalarials = $_POST['totaltestedmalarials'];
                            $totaltestedmalariagr = $_POST['totaltestedmalariagr'];
                            $totalpositivemalarials = $_POST['totalpositivemalarials'];
                            $totalpositivemalariagr = $_POST['totalpositivemalariagr'];
                            $remarks = $_POST['remarks'];
                            $date = date("Y-m-d");
                            $i = 0;
                            $validateEntries = "SELECT facility,datecreated FROM surveillance WHERE facility = '$facility' AND datecreated = '$date'";
                            $validateEntriesResult = mysql_query($validateEntries);
                            if (mysql_num_rows($validateEntriesResult) == 0) {
                                foreach ($diseases as $diseaseid) {
                                    $sql = "INSERT INTO SURVEILLANCE(facility,disease,lmcase,lfcase,lmdeath,lfdeath,datecreated,createdby,datemodified,modifiedby,flag,epiweek,submitted,expected,district,weekending,gmcase,gfcase,gmdeath,gfdeath,reportedby,designation,datereportedby) values ('$facility','$diseaseid','$lmcase[$i]','$lfcase[$i]','$lmdeath[$i]','$lfdeath[$i]','$date',1,'$date',1,1,'$epiweek','$submitted','$expected','NULL','$weekending','$gmcase[$i]','$gfcase[$i]','$gmdeath[$i]','$gfdeath[$i]','$reportedby','$designation','$date')";
                                    mysql_query($sql) or die(mysql_error());
                                    $i++;
                                }
                                echo "<td>";
                                echo "<div class=\"success\">";
                                echo "Values successfully submitted for epiweek '$epiweek'";
                                echo "</td>";

                            }   else {
                                echo "<td>";
                                echo "<div class=\"error\">";
                                echo "You are entering a value(s) that already exist(s)";
                                echo "</td>";
                            }
                                
                            $sqltwo = "insert into lab_weekly (epiweek,weekending,district,facility,remarks,malaria_below_5,malaria_above_5,positive_below_5,positive_above_5,datecreated)values('$epiweek','$weekending','NULL','$facility','$remarks','$totaltestedmalarials','$totaltestedmalariagr','$totalpositivemalarials','$totalpositivemalariagr','$date')";
                            $dave = mysql_query($sqltwo);
                        }
                    } ?></tr>
                    <tr>
                        <td>Week Ending:</td>
                        <td>
                            <input type="text" class="validate[required] text" id="weekending" name="weekending">&nbsp;&nbsp;&nbsp;
                        </td>
                        <td>
                            <input type="hidden" id="epiweek" size="30" name="epiweek" />
                        </td>
                    </tr>
                    <?php
                    if ($autocode != "") {
                    ?>
                        <tr>
                            <td>Select District</td>
                            <td >
                                <div class="notice">
                                <?php
                                $facilityname = GetFacility($autocode);
                                echo '<strong>' . $facilityname . '</strong>';
                                echo"<input id=\"facility\" name='facility' type='hidden' value='$autocode' />";
                                ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                            } else {
                    ?>
                                <tr>

                                    <td><span class="mandatory">* </span>Facility</td>
                                    <td ><strong>
                                            <select  style="width:320px"  id="cat" name="cat" class="validate[required]">

                                            </select>
                                            <script>
                                                var combo = dhtmlXComboFromSelect("cat");
                                                combo.enableFilteringMode(true,"get_facilities.php",true);
                                            </script>
                                        </strong></td>
                                </tr>
                                <tr>
                                    <td>Expected&nbsp;&nbsp;</td>
                                    <td><input class="validate[required] text" id="expected" type="text" name="expected"></td>
                                    <td>Submitted&nbsp;&nbsp;</td><td><input class="validate[required] text" id="submitted" type="text" name="submitted"></td>
                                </tr>
                    <?php } ?>
                            </div>
                        </table>
                
                <div align="center">
                        <table class="data-table">

                            <tr><td colspan="2"></td>

                                <th colspan="4">&le;5 Years</th>
                                <th colspan="4">&ge;5 Years</th>
                                <th colspan="4"></th>

                            </tr>
                            <th>No.</th>
                            <th>Disease</th>
                            <th colspan="2" >Cases</th>
                            <th colspan="2" >Deaths</th>
                            <th colspan="2" >Cases</th>
                            <th colspan="2" >Deaths</th>
                            <th colspan="2" ></th>
                            <tr class="even">
                                <td colspan="2">&nbsp;</td>
                                <th >Males</th>
                                <th >Females</th>
                                <th >Males</th>
                                <th >Females</th>
                                <th >Males</th>
                                <th >Females</th>
                                <th >Males</th>
                                <th >Females</th>
                                <th colspan="2">Zero Reporting (Check as appropriate)</th>
                            </tr>

                    <?php
                            $qury = "SELECT id,name,type FROM diseases where id!=12";
                            $qury2 = "SELECT id,name,type FROM diseases where id=12";
                            $result = mysql_query($qury) or die('Error, query failed');
                            $result2 = mysql_query($qury2) or die('Error, query failed');
                            $no = mysql_num_rows($result);
                            $no2 = mysql_num_rows($result2);
                            if ($no != 0 && $no2 != 0) {
                                // print the districts info in table

                                $k = 0;
                                $i = 0;
                                $j = 0;
                                $samplesPerColumn = 1;

                                $count = 0;

                                while (list($id, $name, $type) = mysql_fetch_array($result)) {
                                    $count++;

                                    if ($k % $samplesPerColumn == 0) {
                                        echo '<tr class="even">';
                                    }
                    ?>
                                    <td><?php echo $count . ")"; ?></td>
                                    <td><?php echo $name; ?> <input type="hidden" name="testid[]" value="<?php echo $id; ?>" /></td>
                                    <td style="background-color: #F4F8FF"><input type="text" id="<?php echo "lmcase_" . $id; ?>" class="validate[required] text" name="lmcase[]" size="10" value=""/></td>
                                    <td style="background-color: #F4F8FF"><input type="text" id="<?php echo "lfcase_" . $id; ?>" class="validate[required] text" name="lfcase[]" size="10" value=""/></td>
                                    <td style="background-color: #F4F8FF"><input type="text" id="<?php echo "lmdeath_" . $id; ?>" class="validate[required] text" name="lmdeath[]" size="10" value=""/></td>
                                    <td style="background-color: #F4F8FF"><input type="text" id="<?php echo "lfdeath_" . $id; ?>" class="validate[required] text" name="lfdeath[]" size="10" value=""/></td>
                                    <td style="background-color: #FFF9F2"><input type="text" id="<?php echo "gmcase_" . $id; ?>" class="validate[required] text" name="gmcase[]" size="10" value=""/></td>
                                    <td style="background-color: #FFF9F2"><input type="text" id="<?php echo "gfcase_" . $id; ?>" class="validate[required] text" name="gfcase[]" size="10" value=""/></td>
                                    <td style="background-color: #FFF9F2"><input type="text" id="<?php echo "gmdeath_" . $id; ?>" class="validate[required] text" name="gmdeath[]" size="10" value=""/></td>
                                    <td style="background-color: #FFF9F2"><input type="text" id="<?php echo "gfdeath_" . $id; ?>" class="validate[required] text" name="gfdeath[]" size="10" value=""/></td>
                                    <td><input type="checkbox" id ="<?php echo "check_" . $id; ?>" class="zero_reporting"></td>


                    <?php
                                    if ($k % $samplesPerColumn == $samplesPerColumn - 1) {
                                        echo '</tr>';
                                    }

                                    $k += 1;
                                }
                                while (list($id, $name, $type) = mysql_fetch_array($result2)) {
                                    $count++;

                                    if ($k % $samplesPerColumn == 0) {
                                        echo '<tr class="even">';
                                    }
                    ?>
                                    <td><?php echo $count . ")"; ?></td>
                                    <td><?php echo $name; ?> <input type="hidden" name="testid[]" value="<?php echo $id; ?>" /></td>
                                    <td style="background-color: #F4F8FF"><input type="text" id="<?php echo "lmcase_" . $id; ?>" class="validate[required] text" name="lmcase[]" size="10" value=""/></td>
                                    <td style="background-color: #F4F8FF"><input type="text" id="<?php echo "lfcase_" . $id; ?>" class="validate[required] text" name="lfcase[]" size="10" value=""/></td>
                                    <td style="background-color: #F4F8FF"><input type="text" id="<?php echo "lmdeath_" . $id; ?>" class="validate[required] text" name="lmdeath[]" size="10" value=""/></td>
                                    <td style="background-color: #F4F8FF"><input type="text" id="<?php echo "lfdeath_" . $id; ?>" class="validate[required] text" name="lfdeath[]" size="10" value=""/></td>
                                    <td style="background-color: #FFF9F2"></td>
                                    <td style="background-color: #FFF9F2"></td>
                                    <td style="background-color: #FFF9F2"></td>
                                    <td style="background-color: #FFF9F2"></td>
                                    <td><input type="checkbox" id ="<?php echo "check_" . $id; ?>" class="zero_reporting"></td>


                    <?php
                                    if ($k % $samplesPerColumn == $samplesPerColumn - 1) {
                                        echo '</tr>';
                                    }

                                    $k += 1;
                                }
                            }
                    ?>
                            <tr >

                                <td></td>
                                <th colspan="1">
                                    Laboratory Weekly Malaria Confirmation
                                </th>
                                <th colspan="2">
                                    &le;5 years
                                </th>
                                <th colspan="7">
                                    &ge;5years
                                </th>
                            </tr>
                            <tr >

                                <td></td>
                                <td colspan="1">
                                    Total Number Tested
                                </td>
                                <td colspan="2" style="background-color: #f4f8ff">
                                    <input class="text" type="text"  id="totaltestedmalarials" name="totaltestedmalarials" >
                                </td>
                                <td colspan="7" style="background-color: #fff9f2">
                                    <input class="text" type="text" name="totaltestedmalariagr" id="totaltestedmalariagr">
                                </td>
                            </tr>
                            <tr >

                                <td></td>
                                <td colspan="1">
                                    Total Number Positive
                                </td>
                                <td colspan="2" style="background-color: #f4f8ff">
                                    <input type="text"  class="text" id="totalpositivemalarials" name="totalpositivemalarials">
                                </td>
                                <td colspan="7" style="background-color: #fff9f2">
                                    <input type="text" class="text" id="totalpositivemalariagr" name="totalpositivemalariagr">
                                </td>
                            </tr>
                            <tr >

                                <td></td>
                                <td colspan="1">
                                    Remarks
                                </td>
                                <td colspan="9">
                                    <textarea name="remarks" rows="2" cols="50">

                                    </textarea>
                                </td></tr><tr><td></td><td>Reported by</td>
                                <td style="background-color: #f4f8ff"  colspan="4"><input type="text" name="reportedby" class="text" class="text" id="reportedby"></td>
                                <td colspan="2">Designation</td>
                                <td style="background-color: #fff9f2"  colspan="4"><input type="text" name="designation" class="text" class="text" id="designation"></td>
                            </tr>
                            <tr >

                                <td></td>
                                <td colspan="10">
                                    <input name="save" type="submit" class="button" value="Save " />
                                </td>
                            </tr>

                        </table>
                </div>

                    </form>
                </div>
        </body>
        </html>
<?php include('footer.php'); ?>