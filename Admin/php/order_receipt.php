<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../");
	exit;
}
ob_start();
require_once("../../php/connection.php");
$id = $_GET["code"];
$result = mysqli_query($connect, "select * from payment where payment_id = $id");
$row = mysqli_fetch_assoc($result);

if($row == NULL || $row == "")
{
	?>
		<script type="text/javascript">
			confirm = alert("<?php echo "Order not found!";?>");
			window.location.href = "order_receipt.php?confirm=" + confirm;
		</script>
	<?php
}

if(isset($_POST["addback"]) || isset($_GET["confirm"]))
{
	header("Location: ../order.php");
}

if(isset($_GET["confirm"]))
{
	header("Location: ../order.php");
	exit();
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
	<link rel="stylesheet" href="../style/receipt.php">
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
	</div>
	<div class="main-receipt">
		<!--end of side navbar-->
		<div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="3">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="../../image/JIT logo-light.png" style="max-width:100px;">
                            </td>
                            <td class="address">
								JIT PC SHOP<br>
								<span style="font-size: 14px;">
									Jalan Ayer Keroh Lama,<br>
									75450 Bukit Beruang, Melaka.
								</span>
							</td>
                            <td class="invoice-details">
                                Invoice #: <?php echo $row["order_number"];?><br>
								Payment No: <?php echo $row["Payment_ID"];?><br>
                                Date: <?php echo $row["Payment_Date"];?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			
			<tr class="heading-title">
                <td colspan="3" class="receipt-title">
                   RECEIPT
                </td>
            </tr>
			
            <tr class="information">
                <td>
                    <table>
                        <tr>
                            <td colspan="2" class="cus-address">
								<span>Delivery to:</span><br>
                                <?php
								$mark=explode(',',$row["Address"]);
								foreach($mark as $out) 
								{
									?>
										<?php
											if($out == "" || $out == NULL)
											{
												echo "";
											}
											else
											{
												echo $out;
											}
										?><br>
									<?php
								}
								?>
								<br>
								Payment Method:&nbsp;<?php echo $row["Payment_method"];?>
                            </td>
							<td></td>
                            <td >
								<?php
								$customerresult = mysqli_query($connect, "select * from customer where Customer_ID ='".$row["Customer_ID"]."'");
								$customerrow = mysqli_fetch_assoc($customerresult);
								?>
								Receiver:<br>
                                <?php echo $row["customer_name"];?><br>
                                <?php echo $customerrow["Customer_Email"];?><br>
                                <?php echo $customerrow["Customer_Contact_num"];?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
		</table>
			
		<table cellpadding="0" cellspacing="0">
            <tr class="content">
				<th class="num">
					No.
				</th>
				
                <th class="items">
                    Item
                </th>
                
				<th class="qty">
					Qty
				</th>
				
                <th class="price">
                    Price (RM)
                </th>
            </tr>
            
            <tr class="item">
				<td class="table-num">
					1
				</td>
				
                <td class="table-items">
                    Website design
                </td>
                
				<td class="table-qtys">
					5
				</td>
				
                <td class="table-amount">
                    300.00
                </td>
            </tr>
            
            <tr class="total">
                <td></td><td></td><td></td>
                
                <td>
                   Total: $385.00
                </td>
            </tr>
        </table>
    </div>
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>