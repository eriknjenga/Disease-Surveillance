<?php 
$rejid=$_GET['rejid'];
if ($rejid =='Y')   //monthly
{
?>
<table>
		<tr>
            <td width="400px">Date of Vaccination </td>
            <td><!--calendar--><div>
			 <input id="datecollected" type="text" name="sdoc" class="text"  size="31" ><span id="sdocInfo"></span></div>


<div type="text" id="datecollected"></div>
			  <!--end calendar-->	  		</td>
  </tr>
</table>
<?php
}
else if ($rejid =='N')   //monthly

{

}
?>

