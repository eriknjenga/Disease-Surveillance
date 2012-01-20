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
        <script type="text/javascript" src="includes/validation.js"></script>
        <script src="dhtmlxcombo_extra.js"></script>
        <link rel="STYLESHEET" type="text/css" href="dhtmlxcombo.css">
        <script src="dhtmlxcommon.js"></script>
        <script src="dhtmlxcombo.js"></script>
<script type="text/javascript" src="includes/jquery.min.js"></script>
<script type="text/javascript" src="includes/jquery.js"></script>

        <link rel="stylesheet" href="includes/validation.css" type="text/css" media="screen" />

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
  <?php
  $d=mysql_query("SELECT name FROM districts WHERE ID='".$_GET['District']."'");  
  $dist= mysql_fetch_array($d);   
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

$stmt=mysql_query("SELECT submitted,expected,weekending FROM surveillance WHERE district='".$_GET['District']."' AND epiweek='".$_GET['epiweek']."';");
 
$rs=mysql_fetch_array($stmt);



?>

        <div  class="section">
        <div class="section-title"> <strong>Update  Weekly Disease Survey for <?php echo $dist[0]; ?> District</strong></div>
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

        <form id="customForm" method="post">

            <table>
                <tr>
                    <td> Epi-Week</td>
                    <td><?php echo $_GET['epiweek']; ?></td>

                    <td>Week Ending</td>
                    <td><?php echo $rs[2]; ?>
                        
                    </td>
                </tr>
                <?php
                        if ($autocode != "") {
                ?>
                            <tr>
                                <td>Select District</td>
                                <td colspan="3">
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
							<td> <span class="mandatory">* </span> Number of Health Facilitys/Site expected&nbsp;&nbsp;</td>
                                <td><div><input class="text" type="text" name="expected" id="expected" value="<?php echo $rs[1]; ?>"><span id="expectedInfo"></span></div></td>
								<td><span class="mandatory">* </span> Number of Health Facilitys/Site Reporting&nbsp;&nbsp;</td>
                                <td><div><input class="text" type="text" name="submitted" id="submitted" value="<?php echo $rs[0]; ?>"><span id="submittedInfo"></span></div></td>
                            </tr>
                <?php } ?>
                    </table>

                    <table class="data-table">
                        <tr>
                        <th rowspan="3">No.</th>
						 <th  rowspan="3">Disease</th>
                        <th colspan="4">&le;5 Years</th>
                        <th colspan="4">&ge;5 Years</th>
                        
                        </tr>
                        
                       
                        <th colspan="2" >Cases</th>
                        <th colspan="2" >Deaths</th>
                        <th colspan="2" >Cases</th>
                        <th colspan="2" >Deaths</th>
                        <tr class="even">
                          
                            <th >Males</th>
                            <th >Females</th>
                            <th >Males</th>
                            <th >Females</th>
                            <th >Males</th>
                            <th >Females</th>
                            <th >Males</th>
                            <th >Females</th>
                        </tr>
        <?php
    $below = 0; //totals of people below or equal 5 years
    $above = 0; //totals of people above 5 years
    foreach ($disease_names as $disease) {
		$sq=mysql_query("SELECT id,name FROM diseases WHERE name='".$disease."'");
		$rw=mysql_fetch_array($sq);
        echo "<tr class=\"even\">"; ?>
        <td><?php echo $rw[0]; ?><input name="id[]" type="hidden" value="<?php echo $rw[0]; ?>" /></td>
        <?php echo "<td name=\"DIS\">" . $rw[1] . "</td>"; ?>
                <?php
								
												                   
	$sql = "select  lmcase, lfcase, lmdeath, lfdeath from surveillance where district = '".$_GET['District']."' and disease IN (SELECT id FROM diseases WHERE name='".$disease."') AND epiweek='".$_GET['epiweek']."'";
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
?>
                                <td style="background-color: #F4F8FF"><div id="error"><input type="text" class="text" name="mcase[]" size="7" value="<?php echo $mcasebelow; ?>"/><span id="mcaseInfo"></span></div></td>
								   
                                
                                <td style="background-color: #F4F8FF"><input type="text" class="text" name="fcase[]" size="7" value="<?php echo $fcasebelow; ?>"/></td>
                                <td style="background-color: #F4F8FF"><input type="text" class="text" name="mdeath[]" size="7" value="<?php echo $mdeathbelow; ?>"/></td>
                                <td style="background-color: #F4F8FF"><input type="text" class="text" name="fdeath[]" size="7" value="<?php echo $fdeathbelow; ?>"/></td>
                                <?php  $sql = "select gmcase, gfcase, gmdeath, gfdeath from surveillance where district = '".$_GET['District']."' AND disease IN (SELECT id FROM diseases WHERE name='$disease') AND epiweek='".$_GET['epiweek']."'";
        $result = mysql_query($sql) or die(mysql_error());
        $values = mysql_fetch_array($result);
        $mcaseabove = $values['gmcase'];
        //$above+=$mcaseabove;
        $fcaseabove = $values['gfcase'];
        //$above+=$fcaseabove;
        $mdeathabove = $values['gmdeath'];
        //$above+=$mdeathabove;
        $fdeathabove = $values['gfdeath'];
        //$above+=$fdeathabove; ?>
                                <td style="background-color: #FFF9F2"><input type="text" class="text" name="mcase2[]" size="7" value="<?php echo $mcaseabove; ?>"/></td>
                                <td style="background-color: #FFF9F2"><input type="text" class="text" name="fcase2[]" size="7" value="<?php echo $fcaseabove; ?>"/></td>
                                <td style="background-color: #FFF9F2"><input type="text" class="text" name="mdeath2[]" size="7" value="<?php echo $mdeathabove; ?>"/></td>
                                <td style="background-color: #FFF9F2"><input type="text" class="text" name="fdeath2[]" size="7" value="<?php echo $fdeathabove; ?>"/></td>
                
              <?php  echo "</tr>";?>
                <?php
    }
    ?>
				<tr>
				<td colspan="10">&nbsp;</td></tr>
                
                        <tr >

                            <td></td>
                            <th >
                                Laboratory Weekly Malaria Confirmation
                            </th>
                            <th colspan="4">
                                <5 years
                            </th>
                            <th colspan="4">
                                >=5years
                            </th>
                        </tr>
                         <?php 
					   $labquery = "SELECT DISTINCT malaria_below_5,malaria_above_5,positive_below_5,positive_above_5,remarks FROM lab_weekly WHERE lab_weekly.district ='" .$_GET['District']."' and lab_weekly.epiweek = '".$_GET['epiweek']."'";
        $Query = mysql_query($labquery);
		$row=mysql_fetch_array($Query);
					   ?>  

                        <tr class="even">

                            <td></td>
                            <td colspan="1">
                                Total Number Tested
                            </td>
                            <td colspan="4">
                                <input class="text" type="text" name="totaltestedmalarials" value="<?php echo $row[0]; ?>">
                            </td>
                            <td colspan="4">
                                <input class="text" type="text" name="totaltestedmalariagr" value="<?php echo $row[1]; ?>">
                            </td>
                        </tr>
                        <tr class="even">

                            <td></td>
                            <td colspan="1">
                                Total Number Positive
                            </td>
                            <td colspan="4">
                                <input class="text" type="text" name="totalpositivemalarials" value="<?php echo $row[2]; ?>">
                            </td>
                            <td colspan="4">
                                <input class="text" type="text" name="totalpositivemalariagr" value="<?php echo $row[3]; ?>">
                            </td>
                        </tr>
                        <tr class="even">

                            <td></td>
                            <td >
                                Remarks
                            </td>
                            <td colspan="8">
                                <textarea name="remarks" rows="2" cols="60"><?php echo $row[4]; ?>"
        
                                </textarea>        
                            </td>

                        </tr>
                        <tr >

                          
                            <td colspan="10" align="center">
                                <input name="save" type="submit" class="button" value="Save Changes" />
								
								<input name="reset" type="reset" class="button" value="Reset" />
                            </td>
                        </tr>

                    </table>
                    
                    <input name="MM_update" type="hidden" value="update">

                </form>
        <?php
                        if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update")) {

                            $mcase = ($_POST['mcase']);
                            $mcase2 = ($_POST['mcase2']);
                            $fcase = $_POST['fcase'];
                            $fcase2 = ($_POST['fcase2']);
                            $mdeath = $_POST['mdeath'];
                            $mdeath2 = $_POST['mdeath2'];
                            $fdeath = $_POST['fdeath'];
                            $fdeath2 = $_POST['fdeath2'];
                            $epiweek = $_GET['epiweek'];
							$district=$_GET['District'];
                            $expected = $_POST['expected'];
                            $submitted = $_POST['submitted'];
                            $weekending = $_POST['endmonth'];
                            $totaltestedmalarials = $_POST['totaltestedmalarials'];
                            $totaltestedmalariagr = $_POST['totaltestedmalariagr'];
                            $totalpositivemalarials = $_POST['totalpositivemalarials'];
                            $totalpositivemalariagr = $_POST['totalpositivemalariagr'];
                            $remarks = $_POST['remarks'];
                            $date = date('Y-m-d');
                            
							$numbers=$_POST['id'];
							
							//for($counter=0;$counter<$found;$counter++)
							                   //var_dump($numbers);  
											   $i = 0;  
                           foreach ($numbers as $diseaseid) {
								
								
								
							$update_query="UPDATE surveillance SET lmcase='$mcase[$i]',lfcase='$fcase[$i]', lmdeath='$mdeath[$i]',lfdeath='$fdeath[$i]', datemodified='$date', modifiedby=1, submitted='$submitted', expected='$expected', gmcase='$mcase2[$i]', gfcase='$fcase2[$i]', gmdeath='$mdeath2[$i]', gfdeath='$fdeath2[$i]' WHERE disease = '$diseaseid' AND epiweek='$epiweek' AND district='$district';";

                               $query=mysql_query($update_query) or die(mysql_error());
								//var_dump($query);
                               		//echo $diseaseid." is the disease<br>".$i;	
									$i++;
                            }
							
                             
							$sqltwo="UPDATE lab_weekly SET remarks='$remarks', malaria_below_5='$totaltestedmalarials', malaria_above_5='$totaltestedmalariagr', positive_below_5='$totalpositivemalarials', positive_above_5='$totalpositivemalariagr', datecreated='$date' WHERE epiweek='".$_GET['week']."' AND district='".$_GET['District']."';";
                           mysql_query($sqltwo);
                           
                            echo '<script type="text/javascript">';
                            echo "alert(\"Your records have been successfully updated in the database\")"; //direct to patient list view
							/*header("Location: districtviewdetails.php?epiweek='".$_GET['week']."'&district='".$_GET['District']."'&value=Refresh");
							 action="districtviewdetails.php?epiweek=<?php echo $_GET['week'];?>&district=<?php echo $_GET['District']; ?>&value=Refresh"*/


                            echo '</script>';
                        }
        ?>

                    </div>
                </div>

<?php include('footer.php');
                    } ?>