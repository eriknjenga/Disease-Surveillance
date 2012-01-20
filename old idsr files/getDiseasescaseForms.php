<?php 
$rejid=intval($_GET['rejid']);
if ($rejid ==11)   //monthly
{
?>
<table>
<th colspan="3">For Acute Flaccid Paralysis (AFP)</th>
<tr><td colspan="3">Clinical History</td></tr>

<tr>
            <td width="400px">Date of Onset of paralysis </td>
            <td><!--calendar--><div>
			 <input id="datecollectedd" type="text" name="sdoc" class="text"  size="31" ><span id="sdocInfo"></span></div>


<div type="text" id="datecollectedd"></div>
			  <!--end calendar-->	  		</td>
  </tr>
		  <tr>
            <td>Signs and Symptoms</td>
            <td><div>
			<input name="fever" type="checkbox" value="" />  
			Fever at onset of paralysis
			<input name="fever" type="checkbox" value="" /> 
			Sudden onset of paralysis
			<input name="fever" type="checkbox" value="" /> 
			Paralysis progressed &lt;3dy
			<input name="fever" type="checkbox" value="" />
			<span id="mentpointInfo"></span>Flaccid (floppy) </div></td>
          </tr>
		  <tr>
            <td>Site(s) of paralysis </td>
            <td><div>
			<input name="fever" type="checkbox" value="" />  
			Left Leg
			<input name="fever" type="checkbox" value="" /> 
			Right Leg
			<input name="fever" type="checkbox" value="" /> 
			Left Arm
			<input name="fever" type="checkbox" value="" />
			<span id="mentpointInfo"></span>Right Arm  <br />
			Are both sides affected? 
			<input name="pgender" type="radio" value="M" />
              Y&nbsp;
              <input name="pgender" type="radio" value="F" />
              N
			</div></td>
          </tr>
</table>
<?php
}
else if ($rejid ==12)   //monthly
{
?>

<?php
}
if ($rejid ==5)   //monthly
{
?>
<table>
<tr>
            <td width="400px">Date of Onset of rash </td>
            <td><!--calendar--><div>
			 <input id="datecollected" type="text" name="sdoc" class="text"  size="31" ><span id="sdocInfo"></span></div>


<div type="text" id="datecollected"></div>
			  <!--end calendar-->	  		</td>
  </tr>
		  <tr>
            <td>Presence of fever </td>
            <td><div>
              <input name="pgender" type="radio" value="M" />
              Y&nbsp;
              <input name="pgender" type="radio" value="F" />
              N</div></td>
          </tr>
		  <tr>
            <td>Is the case epidermically linked to a laboratory-confirmed case </td>
            <td><div>
              <input name="pgender" type="radio" value="M" />
              Y&nbsp;
              <input name="pgender" type="radio" value="F" />
              N</div></td>
          </tr>
</table>
<?php
}




else if ($rejid =='N')   //monthly

{

}
?>

