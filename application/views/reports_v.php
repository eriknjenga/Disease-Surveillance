<?php
if (!isset($quick_link)) {
	$quick_link = null;
}
?>
<div id="sub_menu">
	<?php
	if($this -> session -> userdata('can_download_raw_data') == '1'){ 
	?>
	<a href="<?php echo site_url('raw_data');?>" class="top_menu_link sub_menu_link first_link  <?php
	if ($quick_link == "raw_data") {echo "top_menu_active";
	}
	?>">Raw Data</a>
	<?php
	}
	?>
	<a href="<?php echo site_url("dnr_districts");?>" class=" top_menu_link sub_menu_link  <?php
	if ($quick_link == "dnr_districts") {echo "top_menu_active";
	}
	?>">'DNR' Districts</a>
	<a href="<?php echo site_url("weekly_report");?>" class=" top_menu_link sub_menu_link last_link  <?php
	if ($quick_link == "weekly_report") {echo "top_menu_active";
	}
	?>">Weekly Report</a>
</div>
<div id="main_content">
	<?php
	$this -> load -> view($report_view);
	?>
</div>
