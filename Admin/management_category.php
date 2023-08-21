<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../Admin");
	exit;
}
ob_start();
include("../php/connection.php");
$results_per_page = 9;
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JIT - Category Management</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../image/JIT logo.png">
	<link rel="stylesheet" href="style/admin_template.php">
	<link rel="stylesheet" href="style/admin_category.php">
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
			$_SESSION["directory"] = "category";
			include("admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>Category</h6>

<!--showing the category list-->
			<div id="show-table" class="">
				<table class="cate-table" border="0px">
					<tr>
						<th class="table-name">Category Name</th>
						<th class="table-desc">Category Description</th>				
						<th class="table-action" colspan="2">Action</th>
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
					$sql = "select * from category where Category_isDelete = 0 order by Category_ID asc limit $start_from, ".$results_per_page;
					$result = mysqli_query($connect, $sql);	
					while($row = mysqli_fetch_assoc($result))
						{
						?>
						<tr>
							<td><?php echo $row["Category_Name"];?></td>
							<td><?php echo $row["Category_Desc"];?></td>
							<form method="post">
								<td><a name="editcategory" href="php/category_edit.php?edit&code=<?php echo $row["Category_ID"];?>"><i class="material-icons-round table-icon">edit</i></a></td>
								<td class="table-del"><a href="php/category_del.php?del&code=<?php echo $row["Category_ID"];?>" onclick="return delconfirmation();"><i class="material-icons-round table-icon">delete</i></a></td>
							</form>
						</tr>
						<?php
						}
					?>

				</table>
				<?php
				$data_row = mysqli_query($connect, "select * from category where Category_isDelete = 0");
				$row_count = mysqli_num_rows($data_row);
				$total_pages = ceil($row_count / $results_per_page);
				echo("<script>console.log($total_pages)</script>");
				
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
					href='management_category.php?page=$i'";
					echo ">".$i,"</a>";
				}
				?>
					<a href="php/category_add.php"><input type="submit" name="addcategory" class="add-btn" value="New Category"></a>
			</div>
<!--end of showing list-->
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>