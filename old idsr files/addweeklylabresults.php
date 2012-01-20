<?php 
include('/connection/authenticate.php');
require_once('/connection/config.php');
include('header3.php');

$sessionuserid = $_SESSION['id']; 
$sessionaccounttype = $_SESSION['accounttype']; 
$autocode=$_GET['q']; //facility code
$savedcommunity=$_GET['p'];

$districtdetails = GetDistrictInfo($sessionaccounttype);
$districtname = $districtdetails['name'];

$typequery=mysql_query("SELECT name as tname FROM diseasetypes where id ='1' ")or die(mysql_error()); 
$tdd=mysql_fetch_array($typequery);
$tname=$tdd['tname'];

$ttypequery=mysql_query("SELECT name as ttname FROM diseasetypes where id ='2' ")or die(mysql_error()); 
$ttdd=mysql_fetch_array($ttypequery);
$ttname=$ttdd['ttname'];
?>
	<div class="section-title">Add Lab Test Results for Gachege Dispensary </div>

    <table class="data-table">
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
        <td colspan="19"><?php echo '<strong>'.$tname.'</strong>';?></td>
      </tr>
      <tr class="even">
        <td>Malaria</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
       
      </tr>
      <tr class="even">
        <td>Cholera</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
    
      </tr>
      <tr class="even">
        <td>Typhoid</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
       
      </tr>
      <tr class="even">
        <td>Dysentry</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
       
      </tr>
      <tr class="even">
        <td>Measles</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
      
      </tr>
      <tr class="even">
        <td>Meningitis (Meningococcal)</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
      
      </tr>
      <tr class="even">
        <td>Plague</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
      
      </tr>
      <tr class="even">
        <td>Yellow Fever </td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
       
      </tr>
      <tr class="even">
        <td>Other Viral Haemorrhagic Fevers </td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
       
      </tr>
      <tr class="even">
        <td>Other * Chicken Pox </td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
      
      </tr>
      <tr class="even">
        <td colspan="20"><?php echo '<strong>'.$ttname.'</strong>';?></td>
      </tr>
      <tr class="even">
        <td>Acute Flaccid Paralysis (AFP) </td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
     
      </tr>
      <tr class="even">
        <td>Neonatal Tetanus </td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="4" bgcolor="#999999">&nbsp;</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
     
      </tr>
      <tr class="even">
        <td colspan="20">&nbsp;</td>
      </tr>
      <tr class="even">
        <th colspan="20">Laboratory Weekly Malaria Confirmation</th>
      </tr>
      <tr class="even">
        <td>&nbsp;</td>
        <td colspan="4"><strong>&le; 5 Years</strong></td>
        <td colspan="4"><strong>&ge; 5 Years</strong></td>
        <td colspan="4"><strong>Total</strong></td>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr class="even">
        <td>Total Number Tested</td>
        <td colspan="4"><input type="text" name="pid" size="31" class="text" id="pid" value=""/></td>
        <td colspan="4"><input type="text" name="pid" size="31" class="text" id="pid" value=""/></td>
        <td colspan="4">0</td>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr class="even">
        <td>Total Number Positive </td>
        <td colspan="4"><input type="text" name="pid" size="31" class="text" id="pid" value=""/></td>
        <td colspan="4"><input type="text" name="pid" size="31" class="text" id="pid" value=""/></td>
        <td colspan="4">0</td>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr class="even">
        <td colspan="20">&nbsp;</td>
      </tr>
      <tr class="even">
        <th colspan="20">Remarks</th>
      </tr>
      <tr class="even">
        <td colspan="20"><textarea name="labcomment" rows="3" cols="71"></textarea></td>
      </tr>
	  <tr align="center">
		  	
            <td align="center" colspan="20">
			<input name="addonly" type="submit" class="button" value="Save Results" />
			<input name="reset" type="reset" class="button" value="Reset" /></td>
          </tr>
    </table>
    <?php include('footer.php');?>