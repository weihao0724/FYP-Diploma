<?php
session_start();

if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../Admin");
	exit;
}
ob_start();
require_once("../php/connection.php");

if(isset($_GET["page"]))
{
	$page = $_GET["page"];
}
else
{
	$page = 1;
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JIT - Admin Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../image/JIT logo.png">
	<link rel="stylesheet" href="style/admin_template.php">
	<link rel="stylesheet" href="style/admin_dashboard.php">
	<link href="https://fonts.googleapis.com/css?family=Coiny" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
</head>

<body>
	<!--top navbar-->
	<div id="navbar">
		<?php
		$_SESSION["php"] = false;
		include("hamburger_menu.php");
		?>
	</div>		
	<!--navbar end here-->
	<!--side navbar-->
	<div id="content-panel">
		<div class="side-navbar navheight">
			<?php
			$_SESSION["directory"] = "dashboard";
			include("admin_sidenav.php");
			
			$color= '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<div class="dash-content">
				<script>console.log(<?php echo $_SESSION["admin_id"]?>);</script>
				<br/>
				<p align="center" style="font-size: 22px">Welcome, <?php echo $_SESSION["admin_name"]; ?></p>
				<div class="<?php echo ($page == 1) ? '' : 'hidden';?>">
					<div class="chart-left">
						<p id="columnchart_values"></p>
						<p id="piechart"></p>
						<div class="page-loc">
							<span>Page:</span>
							<a class="pages <?php if($page == 1) echo 'curPage';?>" href="admin_dashboardpage.php?page=1">1</a>
							<a class="pages <?php if($page == 2) echo 'curPage';?>" href="admin_dashboardpage.php?page=2">2</a>
						</div>
					</div>
					<div class="chart-right">
						<p id="columnchart_values1"></p>
						<p id="piechart1"></p>
					</div>
					
					
					<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
					<script type="text/javascript">
					google.charts.load("current", {packages:['corechart']});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() 
						{
							<?php
							$result1 = mysqli_query($connect, "select * from customise");
							$cuscount = mysqli_num_rows($result1);
							$result2 = mysqli_query($connect, "select * from cart where part_id is not null");
							$partcount = mysqli_num_rows($result2);
							$result3 = mysqli_query($connect, "select * from cart where pc_id is not null");
							$pccount = mysqli_num_rows($result3);
							?>
							var data = google.visualization.arrayToDataTable([
							["Type", "Quantity", { role: "style" } ],
							["Customise", <?php echo $cuscount;?>, "#DC3912"],
							["Part", <?php echo $partcount;?>, "#3366CC"],
							["PC Package", <?php echo $pccount;?>, "#FF9900"],
							]);

							var view = new google.visualization.DataView(data);
							view.setColumns([0, 1,
										   { calc: "stringify",
											 sourceColumn: 1,
											 type: "string",
											 role: "annotation" },
										   2]);

							var options = {
							title: "Sales Quantity by Product Type",
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
							};
							var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
							chart.draw(view, options);
						}

					google.charts.setOnLoadCallback(drawChart1);
					function drawChart1() 
						{
							<?php
							$custotal = $parttotal = $pctotal = 0;
							$result1 = mysqli_query($connect, "select * from customise");
							while($cusrow = mysqli_fetch_assoc($result1))
							{
								$custotal += $cusrow["total"];
							}
							$result2 = mysqli_query($connect, "select * from cart where part_id is not null");
							while($partrow = mysqli_fetch_assoc($result2))
							{
								$parttotal += $partrow["total_price"];
							}
							$result3 = mysqli_query($connect, "select * from cart where pc_id is not null");
							while($pcrow = mysqli_fetch_assoc($result3))
							{
								$pctotal += $pcrow["total_price"];
							}
							?>
							var data = google.visualization.arrayToDataTable([
							["Type", "Amount (RM)", { role: "style" } ],
							["Customise", <?php echo $custotal;?>, "#DC3912"],
							["Part", <?php echo $parttotal;?>, "#3366CC"],
							["PC Package", <?php echo $pctotal;?>, "#FF9900"],
							]);

							var view = new google.visualization.DataView(data);
							view.setColumns([0, 1,
										   { calc: "stringify",
											 sourceColumn: 1,
											 type: "string",
											 role: "annotation" },
										   2]);

							var options = {
							title: "Sales Amount (RM) by Product Type",
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
							};
							var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values1"));
							chart.draw(view, options);
						}

					google.charts.setOnLoadCallback(drawChart2);
					function drawChart2() 
						{
							var data = google.visualization.arrayToDataTable([
								['Category', 'Quantity']
								<?php

								$result = mysqli_query($connect, "select * from category");
								while($row = mysqli_fetch_assoc($result))
								{
									$count = 0;
									$partresult = mysqli_query($connect, "select * from part where category_id ='".$row["Category_ID"]."'");
									while($part = mysqli_fetch_assoc($partresult))
									{
										$cartresult = mysqli_query($connect, "select * from cart where part_id ='".$part["Part_ID"]."'");
										while($cart = mysqli_fetch_assoc($cartresult))
										{
											$count += $cart["Qty"];
										}

									}
									$name = $row["Category_Name"];

										echo(", ['$name', $count]");
								}

								?>
							]);

							var options = {
								title: 'Sales Quantity by Category'
							};

							var chart = new google.visualization.PieChart(document.getElementById('piechart'));

							chart.draw(data, options);
						}
						
					google.charts.setOnLoadCallback(drawChart3);
					function drawChart3() 
						{
							var data = google.visualization.arrayToDataTable([
								['Category', 'Amount (RM)']
								<?php

								$result = mysqli_query($connect, "select * from category");
								while($row = mysqli_fetch_assoc($result))
								{
									$count = 0;
									$partresult = mysqli_query($connect, "select * from part where category_id ='".$row["Category_ID"]."'");
									while($part = mysqli_fetch_assoc($partresult))
									{
										$cartresult = mysqli_query($connect, "select * from cart where part_id ='".$part["Part_ID"]."'");
										while($cart = mysqli_fetch_assoc($cartresult))
										{
											$count += $cart["total_price"];
										}

									}
									$name = $row["Category_Name"];

										echo(", ['$name', $count]");
								}

								?>
							]);

							var options = {
								title: 'Sales Amount (RM) by Category'
							};

							var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

							chart.draw(data, options);
						}
					</script>
				</div>
				
				<div class="<?php echo ($page == 2) ? '' : 'hidden';?>">
					<div class="chart-left">
						<p id="piechart2" style="width: 100%; height: 37%; padding-top: 5%;"></p>
						<div class="page-loc1">
							<span>Page:</span>
							<a class="pages <?php if($page == 1) echo 'curPage';?>" href="admin_dashboardpage.php?page=1">1</a>
							<a class="pages <?php if($page == 2) echo 'curPage';?>" href="admin_dashboardpage.php?page=2">2</a>
						</div>
					</div>
					<div class="chart-right">
						<p id="piechart3" style="width: 100%; height: 37%; padding-top: 5%;"></p>
					</div>
					
					<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
					<script type="text/javascript">
					google.charts.load("current", {packages:['corechart']});
					google.charts.setOnLoadCallback(drawChart4);
					function drawChart4() 
						{
							var data = google.visualization.arrayToDataTable([
								['Package', 'Quantity']
								<?php

								$result = mysqli_query($connect, "select * from pc");
								while($row = mysqli_fetch_assoc($result))
								{
									$count = 0;
									$cartresult = mysqli_query($connect, "select * from cart where pc_id ='".$row["PC_ID"]."'");
									while($cart = mysqli_fetch_assoc($cartresult))
									{
										$count += $cart["Qty"];
									}
									$name = $row["PC_Name"];

										echo(", ['$name', $count]");
								}

								?>
							]);

							var options = {
								title: 'Sales Quantity by PC Package'
							};

							var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

							chart.draw(data, options);
						}
						
					google.charts.setOnLoadCallback(drawChart5);
					function drawChart5() 
						{
							var data = google.visualization.arrayToDataTable([
								['Package', 'Amount (RM)']
								<?php

								$result = mysqli_query($connect, "select * from pc");
								while($row = mysqli_fetch_assoc($result))
								{
									$count = 0;
									$cartresult = mysqli_query($connect, "select * from cart where pc_id ='".$row["PC_ID"]."'");
									while($cart = mysqli_fetch_assoc($cartresult))
									{
										$count += $cart["total_price"];
									}
									$name = $row["PC_Name"];

										echo(", ['$name', $count]");
								}

								?>
							]);

							var options = {
								title: 'Sales Amount (RM) by PC Package'
							};

							var chart = new google.visualization.PieChart(document.getElementById('piechart3'));

							chart.draw(data, options);
						}
					</script>
				</div>
				
			</div>
			
		</div>
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>
