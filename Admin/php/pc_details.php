<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../");
	exit;
}
ob_start();
require_once("../../php/connection.php");
$code = $_GET["code"];
$id = $_GET["id"];

if(isset($_POST["addback"]))
{
	header("Location: ../order.php");
}

$sql = "select * from pc where pc_id = '$code'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
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
			<h6>PC Package Details</h6>
			
			<div id="edit-category" class="">
				<p class="">
					<label>ID:</label>
					<input type="text" name="" value="<?php echo $row["PC_ID"];?>">
				</p>
				<p class="">
					<label>Name:</label>
					<input type="text" name="" value="<?php echo $row["PC_Name"];?>">
				</p>
				<p class="">
					<label>Details:</label>
					<textarea cols="60" rows="4"><?php echo $row["PC_Detail"];?></textarea>
				</p>
				<p class="show-payment"><b><?php echo "Total to pay : RM".number_format($row["PC_Price"],2); ?></b></p>
				<a href="order_edit.php?edit&code=<?php echo $id;?>">
					<button type="button">Back</button>
				</a>
			</div>
		</div>
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>