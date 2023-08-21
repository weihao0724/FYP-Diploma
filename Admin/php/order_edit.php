<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../");
	exit;
}
ob_start();
require_once("../../php/connection.php");
$results_per_page = 6;
$code = $_GET["code"];

if(isset($_GET["page"]))
{
	$page = $_GET["page"];
}
else
{
	$page = 1;
}

$start_from = ($page-1) * $results_per_page;
$packagestart = $packageend = $packageremain = $cartstart = $cartend = 0;

$customise = mysqli_query($connect, "select * from customise where payment_id =".$code);
$customisecount = mysqli_num_rows($customise);
$customiseremain = $customisecount%$results_per_page;
$customisepage = ceil($customisecount/$results_per_page);

$package = mysqli_query($connect, "select * from cart where pc_id!='null' and payment_id =".$code);
$packagecount = mysqli_num_rows($package);
$packagepage = ceil(($customisecount+$packagecount)/$results_per_page);
$remainder = ($customisecount + $packagecount) - ($page * $results_per_page);

if($remainder > 0)
{
	$packageremain = $remainder;
}
else if($remainder < 0)
{
	$packageremain = $results_per_page - ($remainder * -1);
}

if($customisepage == 0)
{
	$packagestart = ($page-1) * $results_per_page;
	$packageend = $results_per_page;
}
else if($customiseremain == 0)
{
	$packageend = $results_per_page;
	$packagestart = ($page-$customisepage) * $results_per_page;
}
else
{
	if($page == $customisepage)
	{
		$packageend = $results_per_page - $customiseremain;
		$packagestart = ($page-$customisepage) * $results_per_page;
	}
	else if($page > $customisepage)
	{
		$packagestart = ($page-$customisepage-1) * $results_per_page + $customiseremain + 1;
		$packageend = $results_per_page;
	}
}

if($packagepage == 0)
{
	$cartstart = ($page-1) * $results_per_page;
	$cartend = $results_per_page;
}
else if($packageremain == 0)
{
	$cartend = $results_per_page;
	$cartstart = ($page-$packagepage-1) * $results_per_page;
}
else
{
	if($page == $packagepage)
	{
		$cartend = $results_per_page - $customiseremain;
		$cartstart = ($page-$packagepage) * $results_per_page;
	}
	else if($page > $packagepage)
	{
		$cartstart = ($page-$packagepage) * $results_per_page + $packageremain + 1;
		$cartend = $results_per_page;
	}
}

if(isset($_GET["edit"]))
{
	ob_start();
	
	$orderresult = mysqli_query($connect, "select * from payment where payment_id = '$code'");
	$orderrow = mysqli_fetch_assoc($orderresult);
	
	$customiseresult = mysqli_query($connect, "select * from customise where payment_id = '$code' order by payment_id asc limit $start_from,".$results_per_page);
	
	$cusid = $orderrow['Customer_ID'];
	$customerresult = mysqli_query($connect, "select * from customer where Customer_ID = $cusid");
	$cusrow = mysqli_fetch_assoc($customerresult);
	
	ob_end_flush();
}

if(isset($_POST["savebtn"])) 	
{
	if(empty(trim($_POST["track_no"])))
	{
		$track_no = "NULL";
	}
	else
	{
		$track_no = trim($_POST["track_no"]);
	}
	
	$name = $orderrow["order_number"];
	mysqli_query($connect,"update payment set shipping_no = '$track_no' where payment_id = '$code'");
	?>
		<script type="text/javascript">
			confirm = alert("<?php echo "$name is updated";?>");
			window.location.href = "order_edit.php?confirm=" + confirm;
		</script>
	<?php	
}

if(isset($_POST["addback"]) || isset($_GET["confirm"]))
{
	header("Location: ../order.php");
}
?>

<html>
<head>
<meta charset="utf-8">
<title>JIT - Orders</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../image/JIT logo.png">
	<link rel="stylesheet" href="../style/admin_template.php">
	<link rel="stylesheet" href="../style/admin_order.php">
	<link href="https://fonts.googleapis.com/css?family=Coiny" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
</head>

<body>
	<!--top navbar-->
	<div id="navbar">
		<?php
		$_SESSION["php"] = true;
		include("../hamburger_menu.php");
		?>
	</div>
	<!--navbar end here-->
	<!--side navbar-->
	<div id="content-panel">
		<div class="side-navbar navheight">
			<?php
			$_SESSION["directory"] = "order";
			include("../admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>Orders</h6>
			
<!--div for edit category and show the previous data-->
			<div id="edit-category" class="">

				<form class="addfrm" name="addfrm" method="post" action="">
					<span class="show-left">
						<p>
							<label>Receiver Name:&nbsp;</label><br/>
							<input type="text" name="cate_name" value="<?php echo $orderrow["customer_name"]; ?>" disabled>
						</p>
						<p>
							<label>Shipping Address:</label><br/>
							<textarea cols="40" rows="4" name="cate_desc" disabled>
								<?php echo $orderrow["Address"]; ?>
							</textarea>
						</p>
						<p>
							<label>Order No:</label><br/>
							<input type="text" name="cate_id" value="<?php echo $orderrow["order_number"]; ?>" disabled>
						</p>
					</span>
					<span class="show-right">
						<p>
							<label>Telephone No:</label><br/>
							<input type="text" name="cate_id" value="<?php echo $cusrow["Customer_Contact_num"]; ?>" disabled>
						</p>
						<p>
							<label>Email Address:</label><br/>
							<input type="text" name="cate_id" value="<?php echo $cusrow["Customer_Email"]; ?>" disabled>
						</p>
						<p>
							<label>Total Amount(RM):</label><br/>
							<input type="text" name="cate_id" value="<?php echo $orderrow["amount"]; ?>" disabled>
						</p>
						<p>
							<label>Shipping Number:</label><br/>
							<input type="text" name="track_no" value="<?php echo ($orderrow["shipping_no"]=='NULL') ? '' : $orderrow["shipping_no"];?>">
						</p>
					</span>
					
					<div id="show-table" class="">
						<table class="order-table" border="0px">
							<tr>
								<th class="table-id">Part ID</th>
								<th class="table-name">Name</th>
								<th class="table-qty">Quantity</th>
								<th class="table-price">Amount(RM)</th>
							</tr>
							<?php
							if($customisecount !=0)
							{
								while($customiserow = mysqli_fetch_assoc($customiseresult))
								{
									?>
									<tr>
										<td class="table-con">
											<a href="customise_details.php?code=<?php echo $customiserow["customiseid"];?>&id=<?php echo $code;?>">
												<button type="button">details</button>
											</a>
										</td>
										<td class="table-con">Customised PC</td>
										<td class="table-con">1</td>
										<td class="table-con"><?php echo $customiserow["total"];?></td>
									</tr>
									<?php
								}
							}
							
							if($packageend != 0)
							{
								$packagesql = "select * from cart where payment_id = $code and pc_id is not null order by pc_id asc limit ".$packagestart.",".$packageend;
								$packageresult = mysqli_query($connect, $packagesql);
								
								while($packagerow = mysqli_fetch_assoc($packageresult))
								{
									$part_id = $packagerow["PC_ID"];
									$partsql = "select * from pc where PC_ID = '$part_id'";
									$partresult = mysqli_query($connect, $partsql);
									$partrow = mysqli_fetch_assoc($partresult)

									?>
									<tr>
										<td class="table-con">
											<a href="pc_details.php?code=<?php echo $packagerow["PC_ID"];?>&id=<?php echo $code;?>">
												<button type="button">details</button>
											</a>
										</td>
										<td class="table-con"><?php echo $partrow["PC_Name"];?></td>
										<td class="table-con"><?php echo $packagerow["Qty"];?></td>
										<td class="table-con"><?php echo $packagerow["total_price"];?></td>
									</tr>
									<?php

								}
							}
							
							if($cartend != 0)
							{
								$cartsql = "select * from cart where payment_id = $code and part_id is not null order by part_id asc limit ".$cartstart.",".$cartend;
								$cartresult = mysqli_query($connect, $cartsql);
								
								while($cartrow = mysqli_fetch_assoc($cartresult))
								{
									$part_id = $cartrow["Part_ID"];
									$partsql = "select * from part where Part_ID = '$part_id'";
									$partresult = mysqli_query($connect, $partsql);
									$partrow = mysqli_fetch_assoc($partresult)

									?>
									<tr>
										<td class="table-con"><?php echo $partrow["Part_ID"];?></td>
										<td class="table-con"><?php echo $partrow["Part_Name"];?></td>
										<td class="table-con"><?php echo $cartrow["Qty"];?></td>
										<td class="table-con"><?php echo $cartrow["total_price"];?></td>
									</tr>
									<?php
								}
							}
							?>
						</table>
						<?php
						$cart = mysqli_query($connect, "select * from cart where payment_id = '$code'");
						$row_count = mysqli_num_rows($cart);
						$total_row = $customisecount + $row_count;
						$total_pages = ceil($total_row / $results_per_page);
						for($i = 1; $i <= $total_pages; $i++)
						{
							echo "<a class='pages' href='order_edit.php?edit&code=$code&page=$i'";
							if($i == $page) echo " class='curPage'";
							echo ">".$i,"</a>";
						}
						?>
					</div>
					
					<p>
						<input class="update-btn" type="submit" name="savebtn" value="Update Order">
						<input type="submit" name="addback" value="Back" class="add-back-btn">
					</p>
				</form>
			</div>
		</div>
<!--edit category form end here-->
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>