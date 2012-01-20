<?php
include('/connection/authenticate.php');
include('functions.php');
if(isset($_POST['surveillance'])){
$sql = "SELECT d.name as Disease, districts.name as District_Name, provinces.name as Province_Name, s.epiweek as Week_Number, s.weekending as Week_Ending, 
s.lmcase as Less_Than_5_Male_Cases, s.lfcase as Less_Than_5_Female_Cases, s.gmcase as Greater_Than_5_Male_Cases,s.gfcase as Greater_Than_5_Female_Cases, 
(s.lmcase+s.lfcase+s.gmcase+s.gfcase) as Total_Cases,s.lmdeath as Less_Than_5_Male_Deaths, s.lfdeath as Less_Than_5_Female_Deaths, s.gmdeath as Greater_Than_5_Male_Deaths,
s.gfdeath as Greater_Than_5_Female_Deaths, (s.lmdeath+s.lfdeath+s.gmdeath+s.gfdeath) as Total_Deaths, s.date as Year, s.reportedby as Reported_By, s.designation as Designation,
s.datereportedby as Date_Reported from Surveillance s, diseases d, districts, provinces where s.disease = d.id and s.district = districts.ID and districts.province = provinces.ID 
and date ='".$_POST['year_from']."' and epiweek between '".$_POST['epiweek_from']."' and '".$_POST['epiweek_to']."' order by epiweek asc";
$result = mysql_query($sql) or die(mysql_error());
$result_set = mysql_fetch_assoc($result);
$excell_headers = "Disease\t District Name\t Province Name\t Week Number\t Week Ending\t Male Cases (Less Than 5)\t Female Cases (Less Than 5)\t Male Cases (Greater Than 5)\t Female Cases (Greater Than 5)\t Total Cases\t Male Deaths (Less Than 5)\t Female Deaths (Less Than 5)\t Male Deaths (Greater Than 5)\t Female Deaths (Greater Than 5)\t Total Deaths\tYear\t Reported By\t Designation\t Date Reported\t\n";
$excell_data = ""; 
while($result_set = mysql_fetch_assoc($result)){
$excell_data.= $result_set['Disease']."\t".$result_set['District_Name']."\t".$result_set['Province_Name']."\t".$result_set['Week_Number']."\t".$result_set['Week_Ending']."\t".
$result_set['Less_Than_5_Male_Cases']."\t".$result_set['Less_Than_5_Female_Cases']."\t".$result_set['Greater_Than_5_Male_Cases']."\t".$result_set['Greater_Than_5_Female_Cases']."\t".
$result_set['Total_Cases']."\t".$result_set['Less_Than_5_Male_Deaths']."\t".$result_set['Less_Than_5_Female_Deaths']."\t".$result_set['Greater_Than_5_Male_Deaths']."\t".
$result_set['Greater_Than_5_Female_Deaths']."\t".$result_set['Total_Deaths']."\t".$result_set['Year']."\t".$result_set['Reported_By']."\t".$result_set['Designation']."\t".$result_set['Date_Reported']."\t";
$excell_data.="\n";
mysql_data_seek($result);
} 
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=Surveillance_Data (".$_POST['year_from']." epiweek ".$_POST['epiweek_from']." to epiweek ".$_POST['epiweek_to'].").xls");
// Fix for crappy IE bug in download.
header("Pragma: ");
header("Cache-Control: ");
echo $excell_headers.$excell_data;
}

else if(isset($_POST['malaria'])){
$sql = "select d.name as District, p.name as Province, l.epiweek as Week_Number, l.weekending as Week_Ending, l.malaria_below_5 as Tested_Below, 
l.malaria_above_5 as Tested_Above,(l.malaria_below_5+l.malaria_above_5) as Total_Tested, l.positive_below_5 as Positive_Below, l.positive_above_5 as Positive_Above,
(l.positive_below_5+l.positive_above_5) as Total_Positive from lab_weekly l, districts d, provinces p where l.district = d.ID and d.province = p.ID 
and weekending like '%".$_POST['year_from']."%' and epiweek between '".$_POST['epiweek_from']."' and '".$_POST['epiweek_to']."' order by epiweek asc;";
$result = mysql_query($sql) or die(mysql_error());
$result_set = mysql_fetch_assoc($result);
$excell_headers = "District\t Province\t Week Number\t Week Ending\t Tested (Less Than 5)\t Tested (Greater Than 5)\t Total Tested\t Positive (Less Than 5)\t Positive (Greater Than 5)\t Total Positive\t\n";
$excell_data = ""; 
while($result_set = mysql_fetch_assoc($result)){
$excell_data.= $result_set['District']."\t".$result_set['Province']."\t".$result_set['Week_Number']."\t".$result_set['Week_Ending']."\t".$result_set['Tested_Below']."\t".
$result_set['Tested_Above']."\t".$result_set['Total_Tested']."\t".$result_set['Positive_Below']."\t".$result_set['Positive_Above']."\t".
$result_set['Total_Positive']."\t";
$excell_data.="\n";
mysql_data_seek($result);
} 
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=Malaria_Test_Data (".$_POST['year_from']." epiweek ".$_POST['epiweek_from']." to epiweek ".$_POST['epiweek_to'].").xls");
// Fix for crappy IE bug in download.
header("Pragma: ");
header("Cache-Control: ");
echo $excell_headers.$excell_data;
}
?>