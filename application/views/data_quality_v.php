<?php
if (!isset($quick_link)) {
	$quick_link = null;
}
?>
<div id="sub_menu">
	<a href="<?php echo site_url('facility_reports');?>" class="top_menu_link sub_menu_link first_link  <?php
	if ($quick_link == "facility_reports") {echo "top_menu_active";
	}
	?>">Facility Reports</a>
	<a href="<?php echo site_url('data_delete_management');?>" class="top_menu_link sub_menu_link last_link  <?php
	if ($quick_link == "data_delete") {echo "top_menu_active";
	}
	?>">Deletion Logs</a>
</div>
<div id="main_content">
	<?php
	$this -> load -> view($quality_view);
	?>
</div>
