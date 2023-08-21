<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../Admin");
	exit;
}
ob_start();
include("../php/connection.php");
$results_per_page = 10;
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JIT - Category Management</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../image/JIT logo.png">
	<link rel="stylesheet" href="style/admin_template.php">
	<link rel="stylesheet" href="style/admin_customers.php">
	<link href="https://fonts.googleapis.com/css?family=Coiny" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
</head>

<body>
	<div id="navbar">
		<?php
		$_SESSION["php"] = false;
		include("hamburger_menu.php");
		?>
	</div>	
	<!--side navbar-->
	<div id="content-panel">
		<div class="side-navbar navheight">
			<?php
			$_SESSION["directory"] = "customer";
			include("admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>Customers</h6>

<!--showing the category list-->
			<div id="show-table" class="">
				<table class="cate-table" border="0px">
					<tr>
						<th class="table-name">Name</th>
						<th class="table-contact data-contact">Contact No</th>
						<th class="table-email">Email</th>
					</tr>


					<?php
					if(isset($_GET["page"]))
					{
						$page = $_GET["page"];
					}
					else
					{
						$page = 1;
					}
					$start_from = ($page-1) * $results_per_page;
					$sql = "select * from customer order by Customer_ID asc limit $start_from, ".$results_per_page;
					$result = mysqli_query($connect, $sql);	
					while($row = mysqli_fetch_assoc($result))
						{
						?>
						<tr>
							<td class="data-name"><?php echo $row["Customer_name"];?></td>
							<td class="data-contact"><?php echo $row["Customer_Contact_num"];?></td>
							<td><?php echo $row["Customer_Email"];?></td>
						</tr>
						<?php
						}
					?>

				</table>
				<?php
				$data_row = mysqli_query($connect, "select * from customer");
				$row_count = mysqli_num_rows($data_row);
				$total_pages = ceil($row_count / $results_per_page);
				
				for($i = 1; $i <= $total_pages; $i++)
				{
					$cur = "";
					if($page == $i)
					{
						$cur = "curPage";
					}
					else
					{
						$cur = "";
					}
					echo "<a class='pages ".$cur."'
					href='customers.php?page=".$i."'";
					echo ">".$i,"</a>";
				}
				?>
			</div>
<!--end of showing list-->
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>