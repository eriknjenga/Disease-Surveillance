<?php 
require_once("mpdf51/mpdf.php");
$html = file_get_contents("http://localhost/idsr/summary.html");

$mpdf=new mPDF('','A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
$epiweek = $_GET['epiweek'];
$week_ending = $_GET['weekending'];
$html_title = "<img src='coat_of_arms.png' style='position:absolute; width:160px; width:160px; top:0px; left:0px; margin-bottom:-100px;margin-right:-100px;'></img>";
$html_title .= "<h2 style='text-align:center; text-decoration:underline;'>Republic of Kenya</h2>";
$html_title .= "<h3 style='text-align:center; text-decoration:underline;'>Ministry of Public Health and Sanitation</h3>";
$html_title .= "<h1 style='text-align:center; text-decoration:underline;'>WEEKLY EPIDEMIOLOGICAL BULLETIN</h1>";
$html_title .= " <h3 style='padding:10px; text-decoration:underline; text-align:center; color:#3B68A8'>Week $epiweek  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Week Ending $week_ending</h3> ";
$mpdf->SetTitle('WEEKLY EPIDEMIOLOGICAL BULLETIN');
$mpdf->WriteHTML($html_title);
$mpdf->simpleTables = true;
$mpdf->WriteHTML($html);
$mpdf->WriteHTML('<br/>');
$mpdf->WriteHTML('<br/>');
$mpdf->WriteHTML('<br/>');
$mpdf->WriteHTML('<table><tr><td><strong><u>Key</u></strong></td></tr><tr><td><strong>DNR</strong></td><td>District did not report for this disease</td><td><strong>MM</strong></td><td>Meningococcal Meningitis</td></tr>
    <tr><td><strong> AFP </strong></td> <td> Acute Flaccid Paralysis </td> <td><strong> VHF </strong></td> <td> Viral Hemorrhagic Fever </td></tr>
    <tr><td><strong> NNT </strong></td> <td> Neonatal Tetanus </td> <td><strong> NEP </strong></td> <td> North Eastern Province </td></tr>
    <tr><td><strong> HF </strong></td> <td>Health Facilities </td> <td><strong> % RR </strong></td> <td> Health Facility reporting rate for this week </td></tr>
    <br/>
    <tr><td><strong>Timely reports</strong></td> <td>Reports received before Wednesday</td></tr>
    <tr><td><strong>Completeness (Intra-district)</strong></td>  <td>Proportion of health facilities reporting in a district/province</td></tr>
    <tr><td><strong>Timeliness</strong></td> <td>Proportion of district in a province/country reporting on time</td></tr>
    <tr><td><strong>Weighted Aggregate Score</strong></td> <td>Composite Surveillance Score (3 for Timeliness, 2 for Completeness,1 for Complete reports)</td></tr></table>');
$mpdf->Output();

?>
