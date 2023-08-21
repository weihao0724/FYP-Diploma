<?php
$head = "";
if($_SESSION["php"])
{
	$head = "../";
}

//include_once("style/admin_template.php");
?>

<div class="side-navi">
	<span class="navi-title">&nbsp;&nbsp;&nbsp;Monitoring</span>
	<a class="side-navi-menu <?php if($_SESSION["directory"] == "dashboard") echo 'dir';?>" href="<?php echo $head;?>admin_dashboardpage.php" style="margin-top: 5%; margin-left: 0%">
		<i class="material-icons-round icon-google navred <?php if($_SESSION["directory"] == "dashboard") echo 'current';?>">dashboard</i>
		<span class="text <?php if($_SESSION["directory"] == "dashboard") echo 'current';?>">
			Dashboard
		</span>
	</a>
	<a class="side-navi-menu <?php if($_SESSION["directory"] == "profile") echo 'dir';?>" href="<?php echo $head;?>admin_profile.php" style="margin-left: 0%;">
		<i class="material-icons-round icon-google navyellow <?php if($_SESSION["directory"] == "profile") echo 'current';?>">account_box</i>
		<span class="text <?php if($_SESSION["directory"] == "profile") echo 'current';?>">
			My Account
		</span>
	</a>
	<a class="side-navi-menu <?php if($_SESSION["directory"] == "part") echo 'dir';?>" href="<?php echo $head;?>management_parts.php" style="margin-left: 0%;">
		<i class="material-icons icon-google navgreen <?php if($_SESSION["directory"] == "part") echo 'current';?>">list</i>
		<span class="text <?php if($_SESSION["directory"] == "part") echo 'current';?>">
			Parts
		</span>
	</a>
	<a class="side-navi-menu <?php if($_SESSION["directory"] == "category") echo 'dir';?>" href="<?php echo $head;?>management_category.php" style="margin-left: 0%;">
		<i class="material-icons-round icon-google navblue <?php if($_SESSION["directory"] == "category") echo 'current';?>">category</i>
		<span class="text <?php if($_SESSION["directory"] == "category") echo 'current';?>">
			Category
		</span>
	</a>
	<a class="side-navi-menu <?php if($_SESSION["directory"] == "order") echo 'dir';?>" href="<?php echo $head;?>order.php" style="margin-left: 0%;">
		<i class="material-icons-round icon-google navred <?php if($_SESSION["directory"] == "order") echo 'current';?>">assignment</i>
		<span class="text <?php if($_SESSION["directory"] == "order") echo 'current';?>">
			Order
		</span>
	</a>
<!--
	<a class="side-navi-menu <?php if($_SESSION["directory"] == "promotions") echo 'dir';?>" href="<?php echo $head;?>promotions.php" style="margin-left: 0%;">
		<i class="material-icons-round icon-google navyellow <?php if($_SESSION["directory"] == "promotions") echo 'current';?>">local_offer</i>
		<span class="text <?php if($_SESSION["directory"] == "promotions") echo 'current';?>">
			Promotions
		</span>
	</a>
-->
	<a class="side-navi-menu <?php if($_SESSION["directory"] == "customer") echo 'dir';?>" href="<?php echo $head;?>customers.php" style="margin-left: 0%;">
		<i class="material-icons-round icon-google navyellow <?php if($_SESSION["directory"] == "customer") echo 'current';?>">folder_shared</i>
		<span class="text <?php if($_SESSION["directory"] == "customer") echo 'current';?>">
			Customer
		</span>
	</a>
	<a class="side-navi-menu <?php if($_SESSION["directory"] == "pcpackage") echo 'dir';?>" href="<?php echo $head;?>pcpackage.php" style="margin-left: 0%;">
		<i class="material-icons-round icon-google navgreen <?php if($_SESSION["directory"] == "pcpackage") echo 'current';?>">cases</i>
		<span class="text <?php if($_SESSION["directory"] == "pcpackage") echo 'current';?>">
			PC Package
		</span>
	</a>
<!--
	<a class="side-navi-menu <?php if($_SESSION["directory"] == "report") echo 'dir';?>" href="#" style="margin-left: 0%; margin-bottom: 10%;">
		<i class="material-icons-round icon-google navblue <?php if($_SESSION["directory"] == "report") echo 'current';?>">analytics</i>
		<span class="text <?php if($_SESSION["directory"] == "report") echo 'current';?>">
			Report
		</span>
	</a>
-->
	<div class="authority <?php echo ($_SESSION["admin_id"] != 1)? 'hidden' : ''; ; ?>">
		<span class="navi-title">&nbsp;&nbsp;&nbsp;Authority</span>
		
		<a class="side-navi-menu <?php if($_SESSION["directory"] == "admin") echo 'dir';?>" href="<?php echo $head;?>management_admin.php" style="margin-left: 0%; margin-top: 5%;">
			<i class="material-icons-round icon-google navblue <?php if($_SESSION["directory"] == "admin") echo 'current';?>">admin_panel_settings</i>
			<span class="text <?php if($_SESSION["directory"] == "admin") echo 'current';?>">
				Admin Management
			</span>
		</a>
	</div>
</div>