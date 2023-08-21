<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../Admin");
	exit;
}

ob_start();
$results_per_page = 10;
include("../php/connection.php");

/*get the page for display the content*/
if(isset($_GET["page"]))
{
	$page = $_GET["page"];
}
else
{
	$page = 1;
}
$start_from = ($page-1) * $results_per_page;
$sql = "select * from pc where pc_isdelete = 0 order by PC_id asc limit $start_from,".$results_per_page;
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JIT - PC Package</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../image/JIT logo.png">
	<link rel="stylesheet" href="style/admin_template.php">
	<link rel="stylesheet" href="style/admin_package.php">
	<link href="https://fonts.googleapis.com/css?family=Coiny" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
	<script type="text/javascript">
    function delconfirmation()
    {
        choice = confirm("Do you want to delete this package?");
        return choice;
    }
	</script>
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
			$_SESSION["directory"] = "pcpackage";
			include("admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>PC Package</h6>
<!--showing the package list-->
			
			<div id="show-table" class="">
				<table class="cate-table" border="0px">
					<tr>
						<th class="table-id">ID</th>
						<th class="table-name">Name</th>
						<th class="table-price">Price (RM)</th>
						<th colspan="2" class="table-action">Action</th>
					</tr>
					
					<?php
					$result = mysqli_query($connect, $sql);
					while($row = mysqli_fetch_assoc($result))
						{
						?>
						<tr>
							<td class="part-id"><?php echo $row["PC_ID"];?></td>
							<td class="part-name"><?php echo $row["PC_Name"];?></td>
							<td class="part-price">&nbsp;&nbsp;<?php echo $row["PC_Price"];?></td>
							<form method="post">
								<td class="table-edit">
									<a name="editcategory" href="php/pcpackage_edit.php?edit&code=<?php echo $row["PC_ID"];?>">
										<i class="material-icons-round table-icon">edit</i>
									</a>
								</td>
								<td class="table-del">
									<a href="php/pcpackage_del.php?del&code=<?php echo $row["PC_ID"];?>" onclick="return delconfirmation();">
										<i class="material-icons-round table-icon">delete</i>
									</a>
								</td>
							</form>
						</tr>
						<?php
						}
					?>

				</table>
				<?php
				$data_row = mysqli_query($connect, "select * from pc");
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
					href='pcpackage.php?page=$i'";
					echo ">".$i,"</a>";
				}
				?>
				<a href="php/pcpackage_add.php">
					<input type="submit" name="addproduct" class="add-btn" value="New Part">
				</a>
				
			</div>
<!--end of showing list-->
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>