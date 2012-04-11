<div class="quick_menu">
<a class="quick_menu_link" href="<?php echo site_url("user_management/add");?>">New User</a>
</div>
<?php if (isset($pagination)): ?>
<div style="width:450px; margin:0 auto 60px auto">
<?php echo $pagination; ?>
</div>
<?php endif; ?>
<table border="0" class="data-table" style="margin:0 auto ">
	<th class="subsection-title" colspan="11">Users</th>
	<tr>
		<th>Full Name</th> 
		<th>Username</th>		
		<th>User Group</th> 
		<th>Province</th> 
		<th>District</th> 
		<th>Can Delete?</th> 
		<th>Can Download Raw Data</th> 
		<th>Disabled?</th> 
		<th>Action</th>
	</tr>
 <?php 
 foreach($users as $user){?>
 <tr>
 <td>
 <?php echo $user->Name;?>
 </td> 
   <td>
 <?php echo $user->Username;?>
 </td>
  <td>
 <?php echo $user->Access->Level_Name;?>
 </td>
   <td>
 <?php echo $user->Province_Object->Name;?>
 </td>
   <td>
 <?php echo $user->District_Object->Name;?>
 </td>
   <td>
 <?php echo $user->Can_Delete;?>
 </td>
   <td>
 <?php echo $user->Can_Download_Raw_Data;?>
 </td>
 
  <td>
 <?php if($user->Disabled == 0){echo "No";}else{echo "Yes";};?>
 </td>
 <td>
  <a href="<?php echo base_url()."user_management/edit_user/".$user->id?>" class="link">Edit </a>|
  <?php
  if($user->Disabled == 0){?>
  	   <a class="link" style="color:red" href="<?php echo base_url()."user_management/change_availability/".$user->id."/1"?>">Disable</a> 
  <?php }
  else{?>
  	   <a class="link" style="color:green" href="<?php echo base_url()."user_management/change_availability/".$user->id."/0"?>">Enable</a> 
 <?php }
  ?>

 </td>
 </tr>
 
 <?php }
 ?>
	 
 

</table> 
<?php if (isset($pagination)): ?>
<div style="width:450px; margin:0 auto 60px auto">
<?php echo $pagination; ?>
</div>
<?php endif; ?>