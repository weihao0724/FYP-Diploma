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
/*get the page for display the content*/
if(isset($_GET["cat"]))
{
	$cat = $_GET["cat"];
}
else
{
	$cat = 0;
}

if(isset($_GET["page"]))
{
	$page = $_GET["page"];
}
else
{
	$page = 1;
}
$start_from = ($page-1) * $results_per_page;

$sql_cat = $sql = "";
$category = "";
/*query for shipping status*/
if($cat == 0)
{
	$sql_cat = "select * from payment where shipping_no = 'NULL' order by Payment_ID asc limit $start_from, ".$results_per_page;
	$category = 0;
	$sql = "select * from payment where shipping_no = 'NULL'";
}
else if($cat == 1)
{
	$sql_cat = "select * from payment where shipping_no !='NULL' order by Payment_ID desc limit $start_from, ".$results_per_page;
	$category = 1;
	$sql = "select * from payment where shipping_no != 'NULL'";
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JIT - Orders</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../image/JIT logo.png">
	<link rel="stylesheet" href="style/admin_template.php">
	<link rel="stylesheet" href="style/admin_order.php">
	<link href="https://fonts.googleapis.com/css?family=Coiny" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
	<script type="text/javascript">
    function delconfirmation()
    {
        choice = confirm("Are you sure the order had been shipped?");
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
			$_SESSION["directory"] = "order";
			include("admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>Orders</h6>
			<select name="pcategory" class="cate_option" id="pcategory" onChange="RedirectCat();">
				<option value="order.php?cat=0&page=1" <?php if($cat == 0) echo 'selected';?>>Pending</option>
				<option value="order.php?cat=1&page=1" <?php if($cat == 1) echo 'selected';?>>Shipped</option>
			</select>
			
			<script>
				function RedirectCat()
				{
					window.location.href = document.getElementById("pcategory").value;
				}
			</script>
			<br/><br/>
			<div id="show-table" class="">
				<table class="cate-table" border="0px">
					<tr>
						<th class="table-id">Order No</th>
						<th class="table-name">Customer Name</th>
						<th class="table-price">Amount</th>
						<th class="table-pay">Payment ID</th>
						<th class="table-ship">Shipping No</th>
						<th colspan="2" class="table-action">Actions</th>
					</tr>


					<?php
					$result = mysqli_query($connect, $sql_cat);
					while($row = mysqli_fetch_assoc($result))
						{
						?>
						<tr>
							<td class="part-id"><?php echo $row["order_number"];?></td>
							<td class="part-price"><?php echo $row["customer_name"];?></td>
							<td class="part-name"><?php echo $row["amount"];?></td>
							<td class="part-price"><?php echo $row["Payment_ID"];?></td>
							<td class="part-price"><?php echo ($row["shipping_no"]=='NULL') ? '' : $row["shipping_no"];?></td>
							<form method="post">
								<td class="table-edit">
									<a name="editcategory" href="php/order_edit.php?edit&code=<?php echo $row["Payment_ID"];?>&page=1">
										<i class="material-icons-round table-icon">visibility</i>
									</a>
									
								</td>
								<td class="table-del">
									<a name="" href="php/order_receipt.php?code=<?php echo $row["Payment_ID"];?>">
										<i class="material-icons-round table-icon">receipt</i>
									</a>
								</td>
							</form>
						</tr>
						<?php
						}
					?>

				</table>
				<?php
				$data_row = mysqli_query($connect, $sql);
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
					href='order.php?cat=".$cat."&page=$i'";
					echo ">".$i,"</a>";
				}
				?>
				
			</div>
<!--end of showing list-->
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>