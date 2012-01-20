<?php
//Author David Mwathi
?>
<?php
error_reporting(0);
include('functions.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

    <head>
        <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="scripts/css/custom-theme/jquery-ui.css" media="screen" />
        <title>IDSR GOK</title>
        
        <script type=""  language="JavaScript" src="scripts/FusionCharts.js"></script>
        <script type="text/javascript" src="jquery.min.js"></script>
        <script type=""  language="JavaScript" src="scripts/js/jquery_ui.js"></script>

        <style type="text/css">
            <!--
            .style1 {font-size: large}
            -->
        </style>
    </head>

    <body>

        <div id="site-wrapper">

            <div id="header">

                <div id="top">
                   <img src="img/idsrlogo.jpg" alt="" />
                    <div id="logged_in">
<span class="login_details">Logged in as:</span><?php echo $_SESSION['name'];?> (<?php
$user_levels = array("Unknown Level","Unknown Level","Unknown Level","District Store","Data Administrator","High Level User","General User","Limited");

 echo $user_levels[$_SESSION['role']];

?>)<br>
<span class="login_details">Date:</span><?php echo date("d-m-Y");?><br>
<a class="link" href="national_change_password.php"  >Change Password</a> -
<a class="link" href="logout.php"  >Logout</a>
</div>
                </div>


<div id="top_menu">

<div style="width:850px; margin-left:auto; margin-right:auto;">
<a href="ReadOnly.php" class="top_menu_link <?php if($link == "home"){echo "top_menu_active";}?>">Home</a>
<a href="ReadOnlySubmissions.php" class="top_menu_link <?php if($link == "submission_list"){echo "top_menu_active";}?>">Submissions</a>
<a href="ReadOnlyDashboard.php" class="top_menu_link <?php if($link == "disease_trends"){echo "top_menu_active";}?>">Disease Trends</a>
<a href="ReadOnlyTimeliness.php" class="top_menu_link <?php if($link == "timeliness"){echo "top_menu_active";}?>">Timeliness</a>
<a href="ReadOnlyReports.php" class="top_menu_link <?php if($link == "weekly_reports"){echo "top_menu_active";}?>">Weekly Report</a>



</div>
</div>