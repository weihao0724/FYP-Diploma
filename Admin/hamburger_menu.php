<?php
$head = "";
if($_SESSION["php"])
{
	$head = "../";
}
?>
<!--logo location-->
<div class="weblogo">
	<a href="<?php echo $head;?>../">
		<img src="<?php echo $head;?>../image/JIT logo-light.png" alt="JIT logo">
	</a>
</div>
<!--menu hamburger-->
<div class="navi-container collapsed">
	<div class="dropdown">
		<div class="container" onclick="changestatus(this)">
			<div class="bar1"></div>
			<div class="bar2"></div>
			<div class="bar3"></div>
		</div>
		<div class="dropdown-content" id="showcontent">
			<a href="#">
				<i class="material-icons-round navbar-icon">home</i>
				<span class="dropdown-text">Home</span>
			</a>
			<a href="<?php if(!$_SESSION["php"]) echo "php/"?>admin_logout.php">
				<i class="material-icons-round navbar-icon">exit_to_app</i>
				<span class="dropdown-text">Logout</span>
			</a>
		</div>
	</div>
	<!--for the navi menu hamburger change to X and click for show dropdown content-->
	<script>
		function changestatus(x)
		{
			x.classList.toggle("change");
			document.getElementById("showcontent").classList.toggle("show");
		}
	</script>		
</div>