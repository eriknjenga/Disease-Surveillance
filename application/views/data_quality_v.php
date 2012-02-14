<?php
if (!isset($quick_link)) {
	$quick_link = null;
}
?>
<div id="sub_menu">
	<a href="<?php echo site_url('data_duplication');?>" class="top_menu_link sub_menu_link first_link  <?php
	if ($quick_link == "data_duplication") {echo "top_menu_active";
	}
	?>">Data Duplication</a>
	<a href="<?php echo site_url('district_reports');?>" class="top_menu_link sub_menu_link first_link  <?php
	if ($quick_link == "district_reports") {echo "top_menu_active";
	}
	?>">District Reports</a>
</div>
<div id="main_content">
	<?php
	$this -> load -> view($quality_view);
	?>
</div>
