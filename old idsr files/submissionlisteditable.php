<?php
error_reporting(0);
include('national_header.php');
if($_SESSION['role']!=='4'){
    echo '<script type="text/javascript">' ;
    echo "window.location.href='access_denied.php'";
    echo '</script>';
}else{

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

    </br>
    </br>
    </br>
    
<form method="post" action="<?$_SERVER['PHP_SELF']?>">
<table class="data-table">
    <tr><input type="submit" name="save" class="button"></tr>
    </br></br>
    <tr>
        <th>&nbsp;</th>
        <th colspan="4">&le; 5 Years</th>
        <th colspan="4">&ge; 5 Years</th>
        <th colspan="4">Total</th>
        <th colspan="4">Cummulative Total<br />
			  (As from 1st January) </th> 


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
    foreach ($disease_names as $disease) {
        echo "<tr class=\"even\">";
        echo "<td name=\"DIS\">" . $disease . "</td>";

        /*
          select the sum of the number of male and female cases as well male and female deaths
          then display then in a cell of a table
         */
        $sql = "select SUM(lmcase) AS lmcase,SUM(lfcase) AS lfcase,SUM(lmdeath) AS lmdeath,SUM(lfdeath) AS lfdeath from surveillance where district = '".$_GET['district']."' and disease IN (SELECT id FROM diseases WHERE name='$disease')";
        $result = mysql_query($sql) or die(mysql_error());
        $values = mysql_fetch_array($result);
        $mcasebelow = $values['lmcase'];
        $below+=$mcasebelow;
        $fcasebelow = $values['lfcase'];
        $below+=$fcasebelow;
        $mdeathbelow = $values['lmdeath'];
        $below+=$mdeathbelow;
        $fdeathbelow = $values['lfdeath'];
        $below+=$fdeathbelow;

        echo "<td><input type=text class=text size=1 name=lmcase value=" . $mcasebelow . "></td>";
        echo "<td><input type=text class=text size=1 name=lfcase value=" . $fcasebelow . "></td>";
        echo "<td><input type=text class=text size=1 name=lmdeath value=" . $mdeathbelow . "></td>";
        echo "<td><input type=text class=text size=1 name=lfdeath value=" . $fdeathbelow . "></td>";

        $sql = "select SUM(gmcase) AS gmcase,SUM(gfcase) AS gfcase,SUM(gmdeath) AS gmdeath,SUM(gfdeath) AS gfdeath from surveillance where district = '".$_GET['district']."' AND disease IN (SELECT id FROM diseases WHERE name='$disease')";
        $result = mysql_query($sql) or die(mysql_error());
        $values = mysql_fetch_array($result);
        $mcaseabove = $values['gmcase'];
        $above+=$mcaseabove;
        $fcaseabove = $values['gfcase'];
        $above+=$fcaseabove;
        $mdeathabove = $values['gmdeath'];
        $above+=$mdeathabove;
        $fdeathabove = $values['gfdeath'];
        $above+=$fdeathabove;

        echo "<td><input type=text class=text size=1 name=gmcase value=" . $mcaseabove . "></td>";
        echo "<td><input type=text class=text size=1 name=gfcase value=" . $fcaseabove . "></td>";
        echo "<td><input type=text class=text size=1 name=gmdeath value=" . $mdeathabove . "></td>";
        echo "<td><input type=text class=text size=1 name=gfdeath value=" . $fdeathabove . "></td>";


        echo "<td><input type=text class=text size=1 name=ablm value=" . ($mcaseabove + $mcasebelow) . "></td>";
        echo "<td><input type=text class=text size=1 name=ablf value=" . ($fcaseabove + $fcasebelow) . "></td>";
        echo "<td><input type=text class=text size=1 name=abgm value=" . ($mdeathabove + $mdeathbelow) . "></td>";
        echo "<td><input type=text class=text size=1 name=abgf value=" . ($fdeathabove + $fdeathbelow) . "></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";

        echo "<td></td>";
       // echo "<td><a href=\"submissionlisteditable.php?DIS='$disease'\">Edit Details</a></td>";

        //echo "<td><a href=\"viewdetails.php\"> View Details</a></td>";
        echo "</tr>";
    }
    ?>
    <tr class="even">
        <td colspan="20">&nbsp;</td>
    </tr>
    <tr class="even">
        <?$labquery = "SELECT DISTINCT malaria_below_5,malaria_above_5,positive_below_5,positive_above_5,remarks FROM lab_weekly,surveillance WHERE lab_weekly.district ='" .$_GET['dave']."' and lab_weekly.epiweek = surveillance.epiweek";
        $Query = mysql_query($labquery);
        echo "<th colspan=20>Laboratory Weekly Malaria Confirmation</th>";
        while ($row = mysql_fetch_assoc($Query)){
            echo "<tr class=even>";
            echo "<tr><td></td>";
            echo "<td colspan=6><5 Years</td>";
            echo "<td colspan=6>>=5 Years</td>";
            echo "<td colspan=6>Total</td>";
            echo "</tr>";
            echo "<tr><td>"."Total Number Tested". "</td>";
            echo "<td colspan=6>".$row['malaria_below_5']. "</td>";
            echo "<td colspan=6>".$row['malaria_above_5']. "</td>";
            echo "<td colspan=6>".($row['malaria_above_5']+$row['malaria_below_5']). "</td></tr>";
            echo "</tr>";
            echo "<tr><td>"."Total Number Positive". "</td>";
            echo "<td colspan=6>".$row['positive_below_5']. "</td>";
            echo "<td colspan=6>".$row['positive_above_5']. "</td>";
            echo "<td colspan=6>".($row['positive_above_5']+$row['positive_below_5']). "</td></tr>";
            echo "<tr><td><strong>Remarks</strong></td>";
            echo "<td colspan=20>".$row['remarks']."</td>";
        }

echo "</table>";echo "</form>";


if($_REQUEST['save']){
                            $mcasebelow = ($_POST['lmcase']);
                            $fcasebelow = ($_POST['lfcase']);
                            $mcaseabove = ($_POST['gmcase']);
                            $fcaseabove = ($_POST['gfcase']);
                            
                            $mdeathbelow = $_POST['lmdeath'];
                            $fdeathbelow = $_POST['lfdeath'];
                            $mdeathabove = $_POST['gmdeath'];
                            $fdeathabove = $_POST['gfdeath'];

                       
                            $i = 0;
    foreach($mcaseabove as $mcaseab){
    $SQL = "UPDATE surveillance (lmcase,lfcase,lmdeath,lfdeath,gmcase,gfcase,gmdeath,gfdeath) SET lmcase = '$mcasebelow',lfcase = '$fcasebelow',lmdeath='$mdeathbelow',lfdeath='$fdeathbelow',gmcase='$mcaseab',gfcase='$fcaseabove',gmdeath='$mdeathabove',gfdeath='$fdeathabove'";
    mysql_query($sql);
    $i++;
    echo '<script type="text/javascript">';
    echo "alert(\"values successfully added in the database\")"; //direct to patient list view
    echo '</script>';
}


}

?>
<?}?>


