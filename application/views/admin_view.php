<style type="text/css">
.chart_section{
border-top:2px solid #969696;
padding:10px;
width:650px;
margin:0 auto 0 auto;
}
.dashboard_menu{ 
font-size:14px;
width:90%;
margin:0 auto;
border-bottom: 1px solid #DDD;
overflow:hidden;
}
.quick_menu{ 
font-size:14px;
width:90%;
margin:5px auto; 
overflow:hidden;
}
.quick_menu a{ 
border-bottom: 1px solid #DDD;
}

</style> 

<div id="sub_menu">
<a href="<?php echo site_url("district_management");?>" class="top_menu_link sub_menu_link first_link <?php if($quick_link == "district_management"){echo "top_menu_active";}?>">Districts</a>
<a href="<?php echo site_url("user_management/listing");?>" class="top_menu_link sub_menu_link <?php if($quick_link == "user_management"){echo "top_menu_active";}?>">Users</a>

 
</div>
<?php 
$this->load->view($module_view);
?>
