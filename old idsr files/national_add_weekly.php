<?php
//error_reporting(0);
$link = 'add_weekly';
include('national_header.php');
$currentyear = date('Y');
$lastepiweek = GetLastEpiweek($currentyear);

if ($_SESSION['role'] !== '4') {
    echo '<script type="text/javascript">';
    echo "window.location.href='access_denied.php'";
    echo '</script>';
} else {
    $sql_weekending = "SELECT max(epiweek) as epiweek, max(weekending) as weekending from surveillance order by epiweek asc limit 1";
    $sql_result_weekending = mysql_query($sql_weekending) or die(mysql_error());
    $weekending_resultset = mysql_fetch_assoc($sql_result_weekending);
    $autocode = $_GET['q']; //facility code
    $currentyear = date('Y');
    $yearsago = $currentyear - 5;
    ?>
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
                    beforeShowDay: function(date) {
                        var day = date.getDay();
                        return [(day != 1 && day != 2 && day != 3 && day != 4 && day != 5 && day != 6)];
                    },
                    onClose:	function(date,inst){
                        var new_date = new Date(date);
                        var dave =  getWeek(new_date);
                        $("#epiweek").attr("value",dave);
                        //alert(dave);

                    }
                });
                $("#weekending").attr("value","<?php echo $weekending_resultset['weekending']; ?>");
                $("#epiweek").attr("value","<?php echo $weekending_resultset['epiweek']; ?>");
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
                return Math.floor(Math.round((time - checkDate) / 86400000) / 7);
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

            //function to create ajax object
            function pullAjax(){
                var a;
                try{
                    a=new XMLHttpRequest()
                }
                catch(b)
                {
                    try
                    {
                        a=new ActiveXObject("Msxml2.XMLHTTP")
                    }catch(b)
                    {
                        try
                        {
                            a=new ActiveXObject("Microsoft.XMLHTTP")
                        }
                        catch(b)
                        {
                            alert("Your browser broke!");return false
                        }
                    }
                }
                return a;
            }
                                    
            function validateDistrict()
            {
                site_root = '';
                var x = document.getElementById('cat');
                var msg = document.getElementById('msg');
                var epiweek = document.getElementById('epiweek').value;
                dis = x.value;
                code = '';
                message = '';
                obj=pullAjax();
                obj.onreadystatechange=function()
                {
                    if(obj.readyState==4)
                    {
                        eval("result = "+obj.responseText);
                        code = result['code'];
                        message = result['result'];
                        if(code <=0)
                        {
                            x.style.border = "1px solid red";
                            msg.style.color = "red";
                        }
                        else
                        {
                            x.style.border = "1px solid #000";
                            msg.style.color = "green";
                        }
                        msg.innerHTML = message;
                    }
                }
                var url = site_root+"validate.php?cat="+dis+"&epiweek="+epiweek;
                obj.open("GET",url,true);
                obj.send(null);
            }
                    
            function dave(form){
                var val = form.province.options[form.province.options.selectedIndex].value;
                self.location = 'national_add_weekly.php?province=' + val;
            }
            
            /*function deathsGreaterThanCases(){
            	if(document.getElementById())
            }*/
           
           function validateReports(){
           	//alert (document.getElementById('submitted').value);
           	if((document.getElementById('submitted').value) > (document.getElementById('expected').value)){
           		alert("Received cannot be more than expected!");
           		document.getElementById('submitted').value = "";
           	}//end if
           }
        </script>



            <link type="text/css" href="calendar.css" rel="stylesheet" />


        </head>

        <body>
            <div  class="section">
            <div class="section-title" align="center"> <strong>Weekly Disease Survey </strong></div>
            <div class="xtop" style="position: absolute; left: 200px">
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
                                $district = $_POST['cat'];
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
                                foreach ($diseases as $diseaseid) {
                                    $sql = "INSERT INTO surveillance(facility,disease,lmcase,lfcase,lmdeath,lfdeath,datecreated,createdby,datemodified,modifiedby,flag,epiweek,submitted,expected,district,weekending,gmcase,gfcase,gmdeath,gfdeath,reportedby,designation,datereportedby) values ('NULL','$diseaseid','$lmcase[$i]','$lfcase[$i]','$lmdeath[$i]','$lfdeath[$i]','$date',1,'$date',1,1,'$epiweek','$submitted','$expected','$district','$weekending','$gmcase[$i]','$gfcase[$i]','$gmdeath[$i]','$gfdeath[$i]','$reportedby','$designation','$date')";
                                    $echo = mysql_query($sql) or die(mysql_error());
                                    $i++;
                                }
                                echo "92 values inserted";
                                echo "<td>";
                                echo "<div class=\"success\">";
                                echo "Values successfully submitted for epiweek '$epiweek'";
                                echo "</td>";

                                $sqltwo = "insert into lab_weekly (epiweek,weekending,district,facility,remarks,malaria_below_5,malaria_above_5,positive_below_5,positive_above_5,datecreated)values('$epiweek','$weekending','$district','NULL','$remarks','$totaltestedmalarials','$totaltestedmalariagr','$totalpositivemalarials','$totalpositivemalariagr','$date')";
                                $dave = mysql_query($sqltwo);
                            }
                        }
                        ?></tr>
                    <tr>
                        <td><strong>Week Ending:</strong></td>
                        <td>
                            <input type="text" class="validate[required] text" id="weekending" name="weekending">&nbsp;&nbsp;&nbsp;
                        </td>
                        <td><strong>Epiweek:</strong></td>
                        <td>
                            <input class="text" type="text" id="epiweek" name="epiweek" readonly=""/>
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
                            <td>

                                <!--Province Select
                                ----
                                ----
                                ----
                                ----
                                ---->

                                <strong>Province</strong>
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
                                ?>
                            </td>

                            <!--District Select
                             ----
                             ----
                             ----
                             ----
                             ---->
                            <td><span class="mandatory">* </span><strong>District</strong>&nbsp;&nbsp;&nbsp;
                                <?php
                                if (isset($province)) {
                                    $sqltwo = "SELECT ID,name,province FROM districts WHERE province = $province order by name ASC";
                                }
                                $secondresult = mysql_query($sqltwo);
                                echo "<select name=\"cat\" id=\"cat\" onblur=\"validateDistrict();\">";
                                while ($row = mysql_fetch_assoc($secondresult)) {
                                    echo "<option value='$row[ID]'>$row[name]</option>";
                                }
                                ?>
                            </td>

                            <td></td>

                            <td><div id="msg"></div></td>
                        </tr>
                        <tr>
                            <td><strong> No. of Health Facility/Site Reporting&nbsp;</strong>&nbsp;</td><td><input class="validate[required,custom[onlyNumberSp]] text" id="submitted" type="text" name="submitted"></td>
                            <td><strong> No. of Health Facility/Site reports expected</strong>&nbsp;&nbsp;</td>
                            <td><input class="validate[required,custom[onlyNumberSp]] text" id="expected" type="text" name="expected" onfocusout="validateReports()"></td>

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
                                <td><?php echo "<strong>" . $count . "</strong>" . ")"; ?></td>
                                <td><?php echo "<strong>" . $name . "</strong>"; ?> <input type="hidden" name="testid[]" value="<?php echo $id; ?>" /></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "lmcase_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="lmcase[]" size="10" value=""/></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "lfcase_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="lfcase[]" size="10" value=""/></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "lmdeath_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="lmdeath[]" size="10" value=""/></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "lfdeath_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="lfdeath[]" size="10" value=""/></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "gmcase_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="gmcase[]" size="10" value=""/></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "gfcase_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="gfcase[]" size="10" value=""/></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "gmdeath_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="gmdeath[]" size="10" value=""/></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "gfdeath_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="gfdeath[]" size="10" value=""/></td>
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
                                <td><?php echo "<strong>" . $count . "</strong>" . ")"; ?></td>
                                <td><?php echo "<strong>" . $name . "</strong>"; ?> <input type="hidden" name="testid[]" value="<?php echo $id; ?>" /></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "lmcase_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="lmcase[]" size="10" value=""/></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "lfcase_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="lfcase[]" size="10" value=""/></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "lmdeath_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="lmdeath[]" size="10" value=""/></td>
                                <td style="background-color: #C4E8B7"><input type="text" id="<?php echo "lfdeath_" . $id; ?>" class="validate[required,custom[onlyNumberSp]] text" name="lfdeath[]" size="10" value=""/></td>
                                <td style="background-color: #C4E8B7"></td>
                                <td style="background-color: #C4E8B7"></td>
                                <td style="background-color: #C4E8B7"></td>
                                <td style="background-color: #C4E8B7"></td>
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
                                <strong> Total Number Tested </strong>
                            </td>
                            <td colspan="2" style="background-color: #C4E8B7">
                                <input class="text" type="text"  id="totaltestedmalarials" name="totaltestedmalarials" >
                            </td>
                            <td colspan="7" style="background-color: #C4E8B7">
                                <input class="text" type="text" name="totaltestedmalariagr" id="totaltestedmalariagr">
                            </td>
                        </tr>
                        <tr >

                            <td></td>
                            <td colspan="1">
                                <strong> Total Number Positive </strong>
                            </td>
                            <td colspan="2" style="background-color: #C4E8B7">
                                <input type="text"  class="text" id="totalpositivemalarials" name="totalpositivemalarials">
                            </td>
                            <td colspan="7" style="background-color: #C4E8B7">
                                <input type="text" class="text" id="totalpositivemalariagr" name="totalpositivemalariagr">
                            </td>
                        </tr>
                        <tr >

                            <td></td>
                            <td colspan="1">
                                <strong> Remarks </strong>
                            </td>
                            <td colspan="9">
                                <textarea name="remarks" rows="2" cols="50">

                                </textarea>
                            </td></tr><tr><td></td><td><strong> Reported by </strong></td>
                            <td style="background-color: #C4E8B7"  colspan="4"><input type="text" name="reportedby" class="text" class="text" id="reportedby"></td>
                            <td colspan="2"><strong> Designation </strong></td>
                            <td style="background-color: #C4E8B7"  colspan="4"><input type="text" name="designation" class="text" class="text" id="designation"></td>
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
