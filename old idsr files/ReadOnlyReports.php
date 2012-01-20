<?php
$start_time = date('U');
$link = 'weekly_reports';
include('ReadOnlyHeader.php');
include('/connection/authenticate.php');
$year = date('Y');

$epiweeks = array();
$sql_epiweek = "SELECT distinct epiweek, weekending from surveillance WHERE weekending like '%" . $year . "%' order by epiweek asc";

$sql_result_epiweek = mysql_query($sql_epiweek) or die(mysql_error());
$counter = 0;
while ($epiweek_resultset = mysql_fetch_assoc($sql_result_epiweek)) {
    $epiweeks[$counter] = $epiweek_resultset;
    $counter++;
}
$epiweek = $epiweeks[0]['epiweek'];
if (isset($_GET['epiweek'])) {
    $epiweek = $_GET['epiweek'];
}

$sql_weekending = "SELECT distinct weekending from surveillance WHERE epiweek ='" . $epiweek . "' limit 1";
$sql_result_weekending = mysql_query($sql_weekending) or die(mysql_error());
$weekending_resultset = mysql_fetch_assoc($sql_result_weekending);
$weekending = $weekending_resultset['weekending'];

$static_provinces = array();
$sql = "select * from provinces";
$sql_result_provinces = mysql_query($sql) or die(mysql_error());
while ($province = mysql_fetch_assoc($sql_result_provinces)) {
    $static_provinces[$province['ID']] = $province['name'];
    mysql_data_seek($sql_result_provinces);
}
$static_districts = array();

/*
  if($_SESSION['role'] == '3'){
  $sql = "select ID,name,province  from districts where id = '".$_SESSION['district_or_province']."'";
  $sql_result_districts = mysql_query($sql) or die(mysql_error());
  $district = mysql_fetch_assoc($sql_result_districts);
  unset($static_districts);
  $static_districts[$district['ID']] = $district;
  $districts = $static_districts;

  $sql = "select ID,name   from provinces where ID = '".$district['province']."'";
  $sql_result_provinces = mysql_query($sql) or die(mysql_error());
  $province = mysql_fetch_assoc($sql_result_provinces);
  unset($static_provinces);
  $static_provinces[$province['ID']] = $province['name'];
  $provinces = $static_provinces;
  }


  else if($_SESSION['role'] == '2'){
  $sql = "select ID,name   from provinces where ID = '".$_SESSION['district_or_province']."'";
  $sql_result_provinces = mysql_query($sql) or die(mysql_error());
  $province = mysql_fetch_assoc($sql_result_provinces);
  unset($static_provinces);
  $static_provinces[$province['ID']] = $province['name'];
  $provinces = $static_provinces;

  $sql = "select ID,name,province  from districts where province = '".$_SESSION['district_or_province']."'";
  $sql_result_districts = mysql_query($sql) or die(mysql_error());
  unset($static_districts);
  $counter = 1;
  while($district = mysql_fetch_assoc($sql_result_districts)){
  $static_districts[$district['ID']] = $district;
  mysql_data_seek($sql_result_districts);
  $counter ++;
  }
  $districts = $static_districts;
  if(isset($_GET['district']) && $_GET['district_selected']== "yes" && $_GET['district']>0){
  $districts = array(0=>$static_districts[$_GET['district']]);
  }


  }
 */

//else if ($_SESSION['role'] == '1'){
if (isset($_GET['province']) && $_GET['province'] > 0) {
    $sql = "select ID,name,province from districts where province='" . $_GET['province'] . "'";
} else {
    $sql = "select ID,name,province  from districts";
}
$sql_result_districts = mysql_query($sql) or die(mysql_error());
$counter = 1;
while ($district = mysql_fetch_assoc($sql_result_districts)) {
    $static_districts[$district['ID']] = $district;
    mysql_data_seek($sql_result_districts);
    $counter++;
}

if (isset($_GET['province']) && $_GET['province'] > 0) {
    $provinces = array($_GET['province'] => $static_provinces[$_GET['province']]);
} else if ($_GET['province'] == 0 && $_GET['district'] > 0) {
    $sql = "select province from districts where ID = '" . $_GET['district'] . "'";
    $sql_result_province = mysql_query($sql) or die(mysql_error());
    $resultset = mysql_fetch_array($sql_result_province);
    $provinces = array($resultset['province'] => $static_provinces[$resultset['province']]);
} else {
    $provinces = $static_provinces;
}
if (isset($_GET['district']) && $_GET['district_selected'] == "yes" && $_GET['district'] > 0) {
    $districts = array(0 => $static_districts[$_GET['district']]);
} else {
    $districts = $static_districts;
}

//}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".epiweek").change(function() { 
            $("#filter").submit();
        });
        $(".province").change(function() { 
            $("#filter").submit();
        });
        $(".district").change(function() { 
            $("#district_selected").attr('value','yes');
            $("#filter").submit();
        });
    });
</script>
<div class="section">
    <div class="section-title"><strong> WEEKLY REPORT </strong></div>
    <div class="xtop"></div>
    <div>
        <form action="weeklyreports.php" method="get" id="filter"><input
                type="hidden" name="district_selected" id="district_selected" /> <label
                for="epiweek">Select Epi Week</label> <select name="epiweek"
                id="epiweek" class="epiweek">

<?php
foreach ($epiweeks as $week) {
    if ($_GET['epiweek'] == $week['epiweek']) {
        ?>
                        <option value="<?php echo $week['epiweek']; ?>" selected><?php echo $week['epiweek']; ?></option>
                    <?php
                    } else {
                        ?>
                        <option value="<?php echo $week['epiweek']; ?>"><?php echo $week['epiweek']; ?></option>
                    <?php
                    }
                }
                ?>
            </select> <label for="province">Province</label> <select name="province"
                                                                     id="province" class="province">
                <option value="0">All Provinces</option>
<?php
$prov_keys = array_keys($static_provinces);
$counter = 0;
foreach ($static_provinces as $province) {
    if ($_GET['province'] == $prov_keys[$counter]) {
        ?>
                        <option value="<?php echo $prov_keys[$counter]; ?>" selected><?php echo $province; ?></option>
                    <?php
                    } else {
                        ?>
                        <option value="<?php echo $prov_keys[$counter]; ?>"><?php echo $province; ?></option>
                    <?php
                    }
                    $counter++;
                }
                ?>


            </select> <label for="district">District</label> <select name="district"
                                                                     id="district" class="district">
                <option value="0">All Districts</option>
                <?php
                $dist_keys = array_keys($static_districts);
                $counter = 0;
                foreach ($static_districts as $district) {
                    if ($_GET['district'] == $dist_keys[$counter]) {
                        ?>
                        <option value="<?php echo $district['ID']; ?>" selected><?php echo $district['name']; ?></option>
                    <?php
                    } else {
                        ?>
                        <option value="<?php echo $district['ID']; ?>"><?php echo $district['name']; ?></option>
                    <?php
                    }
                    $counter++;
                }
                ?>


            </select></form>
        <a
            href="weeklyreport_pdf.php?epiweek=<?php echo $epiweek ?>&weekending=<?php echo $weekending ?>"
            target="_">Download PDF Version</a></div>

    <div><?php
                $ob_file = fopen('summary.html', 'w');

                ob_start('ob_file_callback');

                function ob_file_callback($buffer) {
                    global $ob_file;
                    fwrite($ob_file, $buffer);
                    return $buffer;
                }
                ?>

        <table class="data-table">
            <tr style='background: #F5D2AE;'>
                <th rowspan=2>Province</th>
                <th rowspan=2>District</th>
                <th rowspan=2>Reports Expected</th>
                <th rowspan=2>%RR</th>
<?php
$diseases = array();
$diseases["reports"] = "reports";
$diseases["percentage"] = "percentage";
$sql = "select * from diseases ORDER BY  id ASC ";
$sql_result = mysql_query($sql) or die(mysql_error());
$counter = 0;
while ($disease = mysql_fetch_assoc($sql_result)) {

    if ($disease['name'] == 'Malaria') {
        $diseases[$disease['id']] = $disease['name'];
        $diseases["tested"] = "tested";
        $diseases["positive"] = "positive";
        echo "<th rowspan=2>" . $disease['name'] . "</th>";
        echo "<th  colspan=2 style='color:green;'>" . $disease['name'] . " Indicators</th>";
    } else {
        $diseases[$disease['id']] = $disease['name'];
        echo "<th rowspan=2>" . $disease['name'] . "</th>";
    }

    mysql_data_seek($sql_result);
    $counter++;
}
?>
            </tr>
            <tr style='background: #F5D2AE'>
                <?php echo "<th >Tested</th>" . "<th >Positive</th>"; ?>
            </tr>

                <?php
                $disease_keys = array_keys($diseases);
                $province_ids = array_keys($provinces);
                $counter = 0;
                foreach ($provinces as $province) {
                    echo "<tr class='even'><td style='font-weight:bold; font-size:14px'>" . $province . "</td></tr>";

                    foreach ($districts as $district) {
                        if ($district['province'] == $province_ids[$counter]) {
                            echo "<tr class='even' style='background:#C4E8B7'><td></td><td>" . $district['name'] . "</td>";

                            $available_data = array();
                            $surveillance_counter = 2;
                            $sql_surveillance = "SELECT submitted,expected, lfcase+lmcase+gfcase+gmcase as cases,disease, lfdeath+lmdeath+gfdeath+gmdeath as deaths FROM surveillance WHERE weekending like '%" . $year . "%' and epiweek='" . $epiweek . "' and district = '" . $district['ID'] . "' order by disease asc;";
//echo $sql_surveillance;
                            $sql_result_surveillance = mysql_query($sql_surveillance) or die(mysql_error());




                            $sql_reports_expected = "select expected from surveillance where district = '" . $district['ID'] . "'";
                            $sql_result_expected = mysql_query($sql_reports_expected);
                            $array_expected_reports = mysql_fetch_assoc($sql_result_expected);
                            $available_data['reports'] = $array_expected_reports['expected'];


                            if (mysql_num_rows($sql_result_surveillance) == 0) {
                                $available_data['percentage'] = 0;
                            }





                            while ($surv_result = mysql_fetch_assoc($sql_result_surveillance)) {


                                $available_data[$surv_result['disease']] = array('cases' => $surv_result['cases'], 'deaths' => $surv_result['deaths']);



                                $available_data['percentage'] = floor(($surv_result['submitted'] / $available_data['reports']) * 100);



                                $surveillance_counter++;
                            }


                            $sql_malaria_data = "SELECT malaria_below_5+malaria_above_5 as tested, positive_below_5+positive_above_5 as positive FROM lab_weekly WHERE weekending like '%" . $year . "%' and epiweek='" . $epiweek . "' and district = '" . $district['ID'] . "' order by tested desc limit 1;";
                            $sql_result_malaria_data = mysql_query($sql_malaria_data) or die(mysql_error());

                            $array_malaria_data = mysql_fetch_assoc($sql_result_malaria_data);



                            $available_data['tested'] = $array_malaria_data['tested'];
                            $available_data['positive'] = $array_malaria_data['positive'];
                            $disease_keys = array_keys($diseases);
                            foreach ($disease_keys as $disease) {

                                if (isset($available_data[$disease])) {
                                    if ($disease == "reports") {
                                        echo "<td>" . $available_data[$disease] . "</td>";
                                    } else if ($disease == "percentage") {

                                        echo "<td>" . $available_data[$disease] . "</td>";
                                    } else if ($disease == "tested") {

                                        echo "<td>" . $available_data[$disease] . "</td>";
                                    } else if ($disease == "positive") {

                                        echo "<td>" . $available_data[$disease] . "</td>";
                                    } else {

                                        echo "<td>" . $available_data[$disease]['cases'] . "(" . $available_data[$disease]['deaths'] . ")</td>";
                                    }
                                } else {
                                    echo "<td>DNR</td>";
                                }
                            }



                            mysql_data_seek($sql_result_districts);
                            echo "</tr>";
                        }
                    }
                    $counter++;
                }
                ?>



        </table>

        <table class="data-table">
            <tr style='background: #F5D2AE;'>
                <th rowspan=2></th>
            <?php
            $diseases = array();
            $diseases["reports"] = "reports";
            $diseases["percentage"] = "percentage";
            $sql = "select * from diseases ORDER BY  id ASC ";
            $sql_result = mysql_query($sql) or die(mysql_error());
            $counter = 0;
            while ($disease = mysql_fetch_assoc($sql_result)) {

                if ($disease['name'] == 'Malaria') {
                    $diseases[$disease['id']] = $disease['name'];
                    $diseases["tested"] = "tested";
                    $diseases["positive"] = "positive";
                    echo "<th rowspan=2>" . $disease['name'] . "</th>";
                    echo "<th  colspan=2 style='color:green;'>" . $disease['name'] . " Indicators</th>";
                } else {
                    $diseases[$disease['id']] = $disease['name'];
                    echo "<th rowspan=2>" . $disease['name'] . "</th>";
                }

                mysql_data_seek($sql_result);
                $counter++;
            }
            ?>
            </tr>
            <tr style='background: #F5D2AE'>
                <th >Tested</th><th >Positive</th>
            </tr>

                <?php
                //Summary for the week
                $counter = 0;
                $disease_keys = array_keys($diseases);
                $available_data = array();
                foreach ($diseases as $disease) {
                    if ($disease_keys[$counter] > 0) {
                        $sql_week_totals = "select sum(lfcase+lmcase+gfcase+gmcase) as Cases, sum(lfdeath+lmdeath+gfdeath+gmdeath) as Deaths from surveillance where weekending like '%" . $year . "%' and epiweek='" . $epiweek . "' and disease='" . $disease_keys[$counter] . "'";
                        $sql_result_totals = mysql_query($sql_week_totals) or die(mysql_error());
                        $totals = mysql_fetch_assoc($sql_result_totals);
                        $available_data[$disease_keys[$counter]] = array('cases' => $totals['Cases'], 'deaths' => $totals['Deaths']);
                    }
                    $counter++;
                }

                $sql_malaria_data = "SELECT sum(malaria_below_5+malaria_above_5) as tested, sum(positive_below_5+positive_above_5) as positive FROM lab_weekly WHERE weekending like '%" . $year . "%' and epiweek='" . $epiweek . "'";
                $sql_result_malaria_data = mysql_query($sql_malaria_data) or die(mysql_error());
                $array_malaria_data = mysql_fetch_assoc($sql_result_malaria_data);
                $available_data['tested'] = $array_malaria_data['tested'];
                $available_data['positive'] = $array_malaria_data['positive'];
                echo "<tr class='even'><td rowspan=2>Week " . $epiweek . " Summary</td>";
                foreach ($disease_keys as $disease) {
                    if (isset($available_data[$disease])) {

                        if ($disease == "tested") {

                            echo "<td rowspan=2>" . $available_data[$disease] . "</td>";
                        } else if ($disease == "positive") {

                            echo "<td rowspan=2>" . $available_data[$disease] . "</td>";
                        } else {
                            echo "<td>" . $available_data[$disease]['cases'] . "</td>";
                        }
                    }
                }
                echo "</tr>";
                echo "<tr class='even' >";
                foreach ($disease_keys as $disease) {
                    if (isset($available_data[$disease])) {

                        if ($disease > 0) {
                            echo "<td >" . "(" . $available_data[$disease]['deaths'] . ")</td>";
                        }
                    }
                }
                echo "</tr>";


                //Cumulative summary for the year
                $counter = 0;
                $disease_keys = array_keys($diseases);
                $available_data = array();
                foreach ($diseases as $disease) {
                    if ($disease_keys[$counter] > 0) {
                        $sql_week_totals = "select sum(lfcase+lmcase+gfcase+gmcase) as Cases, sum(lfdeath+lmdeath+gfdeath+gmdeath) as Deaths from surveillance where weekending like '%" . $year . "%' and disease='" . $disease_keys[$counter] . "'";
                        $sql_result_totals = mysql_query($sql_week_totals) or die(mysql_error());
                        $totals = mysql_fetch_assoc($sql_result_totals);
                        $available_data[$disease_keys[$counter]] = array('cases' => $totals['Cases'], 'deaths' => $totals['Deaths']);
                    }
                    $counter++;
                }

                $sql_malaria_data = "SELECT sum(malaria_below_5+malaria_above_5) as tested, sum(positive_below_5+positive_above_5) as positive FROM lab_weekly WHERE weekending like '%" . $year . "%'";
                $sql_result_malaria_data = mysql_query($sql_malaria_data) or die(mysql_error());
                $array_malaria_data = mysql_fetch_assoc($sql_result_malaria_data);
                $available_data['tested'] = $array_malaria_data['tested'];
                $available_data['positive'] = $array_malaria_data['positive'];
                echo "<tr class='even' style='background:#BB00FF'><td rowspan=2>Years Cummulative Summary</td>";
                foreach ($disease_keys as $disease) {
                    if (isset($available_data[$disease])) {

                        if ($disease == "tested") {

                            echo "<td rowspan=2>" . $available_data[$disease] . "</td>";
                        } else if ($disease == "positive") {

                            echo "<td rowspan=2>" . $available_data[$disease] . "</td>";
                        } else {
                            echo "<td>" . $available_data[$disease]['cases'] . "</td>";
                        }
                    }
                }
                echo "</tr>";
                echo "<tr class='even' style='background:#BB00FF'>";
                foreach ($disease_keys as $disease) {
                    if (isset($available_data[$disease])) {

                        if ($disease > 0) {
                            echo "<td >" . "(" . $available_data[$disease]['deaths'] . ")</td>";
                        }
                    }
                }
                echo "</tr>";
                ?>
        </table>
            <?php
            ob_end_flush();
            ?></div>