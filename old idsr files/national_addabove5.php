<?php
error_reporting(0);
include('national_header.php');
require_once('classes/tc_calendar.php');
if ($_SESSION['role'] !== '4') {
    echo '<script type="text/javascript">';
    echo "window.location.href='access_denied.php'";
    echo '</script>';
} else {

    $autocode = $_GET['q']; //facility code

    $currentyear = date('Y');

    $yearsago = $currentyear - 5;
?>

    <style type="text/css">
        select {
            width: 250;}
        </style>

        <script>
            window.dhx_globalImgPath="img/";
        </script>
        <script type="text/javascript" src="validation.js"></script>
        <script src="dhtmlxcombo_extra.js"></script>
        <link rel="STYLESHEET" type="text/css" href="dhtmlxcombo.css">
        <script src="dhtmlxcommon.js"></script>
        <script src="dhtmlxcombo.js"></script>

        <link rel="stylesheet" href="validation.css" type="text/css" media="screen" />

        <link type="text/css" href="calendar.css" rel="stylesheet" />

        <link href="base/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="jquery-ui.min.js"></script>

        <script>
            $(document).ready(function() {
                // $("#dob").datepicker();
                $( "#datereceived" ).datepicker({ minDate: "-18M", maxDate: "+2D" });
            });


            //  });
        </script>

        <div  class="section">
        <div class="section-title"> <strong>ADD &ge; 5 Years Disease Survey </strong></div>
        <div class="xtop">
        <?php
        if ($autocode != "") {
        ?>
            <table   >
                <tr>
                    <td style="width:auto" ><div class="success"><?php
            echo '<strong>' . ' <font color="#666600">' . $savedcommunity . ' Community Unit Plan Successfully Saved' . '<br/>' . ' Please Enter Details for the other Community Unit' . '</strong>' . ' </font>';
        ?></div></th>
            </tr>
        </table>
        <?php } ?>

        <form id="customForm" method="post" action="" >

            <table>
                <tr>
                    <td>Select Epi-Week</td>
                    <td>
                        <select name="epiweek"><option><?php
        for ($w = 1; $w <= 52; $w++) {
            echo "<option>" . $w;
            //echo $w + "\n";
        }
        ?></select>
                    </td>

                    <td>Week Ending</td>
                    <td>
                        <?php
                        $myCalendar = new tc_calendar("endmonth", true);
                        $myCalendar->setDate(date('d'), date('m'), date('Y'));
                        $myCalendar->setPath("calendar/");
                        $myCalendar->setYearInterval($yearsago, $currentyear);
                        //$myCalendar->dateAllow('1960-01-01', '2015-03-01');
                        $myCalendar->writeScript();
                        ?>
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
                            echo"<input name='facility' type='hidden' value='$autocode' />";
                            ?>
                        </div>
                    </td>
                </tr>
                <?php
                        } else {
                ?>
                            <tr>

                                <td><span class="mandatory">* </span>District</td>
                                <td ><strong>
                                        <select  style="width:262px"  id='cat' name="cat">

                                        </select>
                                        <script>
                                            var combo = dhtmlXComboFromSelect("cat");
                                            combo.enableFilteringMode(true,"get_districts.php",true);





                                        </script>
                                    </strong></td>
                            </tr>
                            <tr>
                                <td>Expected&nbsp;&nbsp;<input class="text" type="text" name="expected"></td>
                                <td>Submitted&nbsp;&nbsp;<input class="text" type="text" name="submitted"></td>
                            </tr>
                <?php } ?>
                    </table>

                    <table class="data-table">
                        <th>No.</th>
                        <th>Disease</th>
                        <th colspan="2" >Cases</th>
                        <th colspan="2" >Deaths</th>

                        <tr class="even">
                            <td colspan="2">&nbsp;</td>
                            <th >Males</th>
                            <th >Females</th>
                            <th >Males</th>
                            <th >Females</th>
                        </tr>
                <?php
                        //ORDER BY name ASC

                        $qury = "SELECT id,name,type FROM diseases WHERE id!= 12";
                        $result = mysql_query($qury) or die('Error, query failed');
                        $no = mysql_num_rows($result);

                        if ($no != 0) {
                            // print the districts info in table

                            $k = 0;
                            $i = 0;
                            $samplesPerColumn = 1;

                            $count = 0;

                            while (list($id, $name, $type) = mysql_fetch_array($result)) {
                                $count++;

                                if ($k % $samplesPerColumn == 0) {
                                    echo '<tr class="even">';
                                }
                ?>
                                <td><?php echo $count . ")"; ?></td>
                                <td ><?php echo $name; ?> <input type="hidden" name="testid[]" value="<?php echo $id; ?>" /></td>
                                <td><input type="text" class="text" name="mcase[]" size="7" value="0"/></td>
                                <td><input type="text" class="text" name="fcase[]" size="7" value="0"/></td>
                                <td><input type="text" class="text" name="mdeath[]" size="7" value="0"/></td>
                                <td><input type="text" class="text" name="fdeath[]" size="7" value="0"/></td>

                <?php
                                if ($k % $samplesPerColumn == $samplesPerColumn - 1) {
                                    echo '</tr>';
                                }

                                $k += 1;
                            }
                        }


                        echo "</tr>";
                ?>
                        <tr >

                            <td></td>
                            <th colspan="1">
                                Laboratory Weekly Malaria Confirmation
                            </th>
                            <th colspan="2">
                                <5 years
                            </th>
                            <th colspan="2">
                                >=5years
                            </th>
                        </tr>
                        <tr >

                            <td></td>
                            <td colspan="1">
                                Total Number Tested
                            </td>
                            <td colspan="2">
                                <input class="text" type="text" name="totaltestedmalarials5">
                            </td>
                            <td colspan="2">
                                <input class="text" type="text" name="totaltestedmalariagr5">
                            </td>
                        </tr>
                        <tr >

                            <td></td>
                            <td colspan="1">
                                Total Number Positive
                            </td>
                            <td colspan="2">
                                <input class="text" type="text" name="totalpositivemalarials5">
                            </td>
                            <td colspan="2">
                                <input class="text" type="text" name="totalpositivemalariagr5">
                            </td>
                        </tr>
                        <tr >

                            <td></td>
                            <td colspan="1">
                                Remarks
                            </td>
                            <td colspan="6">
                                <textarea name="remarks" rows="2" cols="20">

                                </textarea>
                            </td>

                        </tr>
                        <tr >

                            <td></td>
                            <td colspan="6">
                                <input name="save" type="submit" class="button" value="Save " />
                                <!--<input name="add" type="submit" class="button" value="Save & Continue " />-->
                                <!--<input name="reset" type="submit" class="button" value="Reset" /></td>-->
                        </tr>

                    </table>

                </form>
        <?php
                        if ($_POST['save']) {

                            $mcase = ($_POST['mcase']);
                            $fcase = $_POST['fcase'];
                            $mdeath = $_POST['mdeath'];
                            $fdeath = $_POST['fdeath'];
                            $diseases = $_POST['testid'];
                          $district = $_POST['cat'];
                            $epiweek = $_POST['epiweek'];
                            $expected = $_POST['expected'];
                            $submitted = $_POST['submitted'];
                            $weekending = $_POST['endmonth'];
                            $totaltestedmalarials5 = $_POST['$totaltestedmalarials5'];
                            $totaltestedmalariagr5 = $_POST['$totaltestedmalariagr5'];
                            $totalpositivemalarials5 = $_POST['totalpositivemalarials5'];
                            $totalpositivemalariagr5 = $_POST['totalpositivemalariagr5'];
                            $remarks = $_POST['remarks'];
                            $date = date('Y-m-d');
                            $i = 0;
                            foreach ($diseases as $diseaseid) {
                                $sql = "insert into surveillance(district,disease,age,mcase,fcase,mdeath,fdeath,datecreated,createdby,datemodified,modifiedby,flag,epiweek,submitted,expected,weekending) values ('$district','$diseaseid','2','$mcase[$i]','$fcase[$i]','$mdeath[$i]','$fdeath[$i]','$date',1,'$date',1,1,'$epiweek','$submitted','$expected','$weekending')";
                                mysql_query($sql);
                                $i++;
                            }
                           /*foreach ($diseases as $diseaseid) {
                            $sql = "insert into lab_weekly(epiweek,weekending,district,facility,remarks,malaria_below_5,malaria_above_5,positive_below_5,positive_above_5,datecreated) VALUES ('$epiweek','$weekending','$district','$facility','$remarks','$totaltestedmalarials5','$totaltestedmalariagr5','$totalpositivemalarials5','$totalpositivemalariagr5')";
                            mysql_query($sql);
                             $i++;
                            }*/
                            echo '<script type="text/javascript">';
                            echo "alert(\"values successfully added in the database\")"; //direct to patient list view
                            echo '</script>';
                        }
        ?>

                    </div>
                </div>

<?php include('footer.php');
                    } ?>