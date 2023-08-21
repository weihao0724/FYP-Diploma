<!doctype html>

<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../Admin");
	exit;
}

$results_per_page = 10;
if(isset($_GET["page"]))
{
	$page = $_GET["page"];
}
else
{
	$page = 1;
}
$start_from = ($page-1) * $results_per_page;

ob_start();
include("../php/connection.php");
$date = date("Y-m-d");
?>
<html>
<head>
<meta charset="utf-8">
<title>JIT - Admin Management</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../image/JIT logo.png">
	<link rel="stylesheet" href="style/admin_template.php">
	<link rel="stylesheet" href="style/admin_manage.php">
	<link href="https://fonts.googleapis.com/css?family=Coiny" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
	
	<script type="text/javascript">
	function delconfirmation()
	{
		choice = confirm("Do you want to delete?");
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
			$_SESSION["directory"] = "admin";
			include("admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>Admin</h6>
<!--showing the admin list-->
			<div id="show-table" class="">
				<table class="admin-table" border="0px">
					<tr>
						<th class="table-id">ID</th>
						<th class="table-name">Name</th>
						<th class="table-date">Register Date</th>
						<th class="table-email">Email</th>
						<th class="table-cont">Contact Number</th>
						<th colspan="2" class="table-action">Action</th>
					</tr>

					<?php
					$condition = mysqli_query($connect, "select * from staff where Staff_isDelete = 0 order by Staff_ID asc limit $start_from,".$results_per_page);	
					while($row = mysqli_fetch_assoc($condition))
						{
						$check = $row["Staff_ID"];
						if($check == 1)
						{
							$super = "hidden";
						}
						else
						{
							$super = "show";	
						}
						?>
						<tr>
							<td class="data-id"><?php echo $row["Admin_ID"];?></td>
							<td class="data-name"><?php echo $row["Staff_Name"];?></td>
							<td class="data-date"><?php echo $row["Staff_Join_Date"];?></td>
							<td class="data-email"><?php echo $row["Staff_Email"];?></td>
							<td class="data-cont"><?php echo $row["Staff_Contact_Num"];?></td>
							<form method="post">
								<td class="table-edit <?php if ($super == "hidden") echo 'hidden';?>">
									<a name="editadmin" href="php/admin_edit.php?edit&code=<?php echo $row["Staff_ID"];?>">
										<i class="material-icons-round table-icon">edit</i>
									</a>
								</td>
								
								<td class="table-del <?php if ($super == "hidden") echo 'hidden';?>">
									<a href="php/admin_del.php?del&code=<?php echo $row["Staff_ID"];?>" onclick="return delconfirmation();">
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
				$data_row = mysqli_query($connect, "select * from staff where staff_isDelete = 0");
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
					href='management_admin.php?page=".$i."'";
					echo ">".$i,"</a>";
				}
				?>
				<a href="php/admin_add.php"><input type="submit" name="addadmin" class="add-btn" value="New Admin"></a>
			</div>
<!--end of showing list-->
		</div>
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>