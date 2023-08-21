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

/*get category id to query parts by selected category*/
if(isset($_GET["cat"]))
{
	$category = $_GET["cat"];
}
else
{
	$category = 0;
}

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

if($category == 0)
{
	$sql = "select * from part where part_isdelete = 0 order by Part_ID asc limit $start_from, ".$results_per_page;
	$sql_cat = "select * from part where part_isdelete = 0";
}
else
{
	$sql = "select * from part where Category_ID = $category and part_isdelete = 0 order by Part_ID asc limit $start_from, ".$results_per_page;
	$sql_cat = "select * from part where Category_ID = $category and part_isdelete = 0";
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JIT - Management Parts</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../image/JIT logo.png">
	<link rel="stylesheet" href="style/admin_template.php">
	<link rel="stylesheet" href="style/admin_product.php">
	<link href="https://fonts.googleapis.com/css?family=Coiny" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
	<script type="text/javascript">
    function delconfirmation()
    {
        choice = confirm("Do you want to delete this part?");
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
			$_SESSION["directory"] = "part";
			include("admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>Parts</h6>
<!--showing the category list-->
			<!--category query-->
			<select name="pcategory" class="cate_option" id="pcategory" onChange="RedirectCat();">
				<option value="management_parts.php?cat=0&page=1" <?php if($category == 0) echo 'selected';?>>All</option>
				<?php
				$cate_sql = "select * from category where Category_isDelete = 0";
				$cate_result = mysqli_query($connect, $cate_sql);
				while($cate_row = mysqli_fetch_assoc($cate_result))
				{
				?>
					<option value="management_parts.php?cat=<?php echo $cate_row["Category_ID"];?>&page=1" <?php if($category == $cate_row["Category_ID"]) echo 'selected';?>><?php echo $cate_row["Category_Name"];?></option>
				<?php
					$count++;
				}
				?>
			</select>
			
			<script>
				function RedirectCat()
				{
					window.location = document.getElementById("pcategory").value;
				}
			</script>
			<!--end of category query-->
			
			<div id="show-table" class="">
				<table class="cate-table" border="0px">
					<tr>
						<th class="table-id">ID</th>
						<th class="table-name">Name</th>
						<th class="table-price">Price (RM)</th>
						<th class="table-cate">Category</th>
						<th class="table-stock">Stock</th>
						<th colspan="2" class="table-action">Action</th>
					</tr>


					<?php
					$result = mysqli_query($connect, $sql);
					while($row = mysqli_fetch_assoc($result))
						{
						$cate_id = $row["Category_ID"];
						$cate_show = mysqli_query($connect, "select * from category where Category_ID = ".$cate_id);
						$cate_data = mysqli_fetch_assoc($cate_show);
						?>
						<tr>
							<td class="part-id"><?php echo $row["Part_ID"];?></td>
							<td class="part-name"><?php echo $row["Part_Name"];?></td>
							<td class="part-price">&nbsp;<?php echo $row["Part_Price"];?></td>
							<td class="part-cate"><?php echo $cate_data["Category_Name"];?></td>
							<td class="part-stock"><?php echo $row["Stock"];?></td>
							<form method="post">
								<td class="table-edit">
									<a name="editcategory" href="php/part_edit.php?edit&code=<?php echo $row["Part_ID"];?>">
										<i class="material-icons-round table-icon">edit</i>
									</a>
								</td>
								<td class="table-del">
									<a href="php/part_del.php?del&code=<?php echo $row["Part_ID"];?>" onclick="return delconfirmation();">
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
				$data_row = mysqli_query($connect, $sql_cat);
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
					href='management_parts.php?cat=$category&page=$i'";
					echo ">".$i,"</a>";
				}
				?>
				<a href="php/part_add.php">
					<input type="submit" name="addproduct" class="add-btn" value="New Part">
				</a>
				
			</div>
<!--end of showing list-->
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>