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

$sql = "select * from customise where customiseid = '$code'";
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
			<h6>Customised PC Details</h6>
			
			<div id="edit-category" class="">
				<?php
				$total = $row['total'];
				
				$psuid=$row['psuid'];
				$pccaseid=$row['pccaseid'];
				$hhdida=$row['hhdid'];
				$ssdid=$row['ssdid'];
				$ramid=$row['ramid'];
				$gpuid=$row['gpuid'];
				$cpuid=$row['cpuid'];
				$moboid=$row['moboid'];
				$query_psu=mysqli_query($connect,"SELECT * from part where Part_ID='$psuid'");
				$query_pccase=mysqli_query($connect,"SELECT * from part where Part_ID='$pccaseid'");
				$query_hhd=mysqli_query($connect,"SELECT * from part where Part_ID='$hhdida'");
				$query_ssd=mysqli_query($connect,"SELECT * from part where Part_ID='$ssdid'");
				$query_ram=mysqli_query($connect,"SELECT * from part where Part_ID='$ramid'");
				$query_gpu=mysqli_query($connect,"SELECT * from part where Part_ID='$gpuid'");
				$query_cpu=mysqli_query($connect,"SELECT * from part where Part_ID='$cpuid'");
				$query_mobo=mysqli_query($connect,"SELECT * from part where Part_ID='$moboid'");
				
				$rowpsu=mysqli_fetch_assoc($query_psu);
				$rowpc=mysqli_fetch_assoc($query_pccase);
				$rowhhd=mysqli_fetch_assoc($query_hhd);
				$rowssd=mysqli_fetch_assoc($query_ssd);
				$rowram=mysqli_fetch_assoc($query_ram);
				$rowgpu=mysqli_fetch_assoc($query_gpu);
				$rowmobo=mysqli_fetch_assoc($query_mobo);
				$rowcpu=mysqli_fetch_assoc($query_cpu);
				?>
				<table border="1px" id="details">
				<tr>
					<td class="col-width">CPU</td>
					<td><?php echo $rowcpu['Part_Name']; ?></td>
				</tr>
				<tr>
					<td>Motherboard</td>
					<td><?php echo $rowmobo['Part_Name']; ?></td>
				</tr>
				<tr>
					<td>GPU</td>
					<td><?php echo $rowgpu['Part_Name']; ?></td>
				</tr>
				<tr>
					<td>RAM</td>
					<td><?php echo $rowram['Part_Name']; ?></td>
				</tr>
				<tr>
					<td>SSD</td>
					<td><?php echo $rowssd['Part_Name']; ?></td>
				</tr>
				<tr>
					<td>HHD</td>
					<td><?php echo $rowhhd['Part_Name']; ?></td>
				</tr>
				<tr>
					<td>PSU</td>
					<td><?php echo $rowpsu['Part_Name']; ?></td>
				</tr>
				<tr>
					<td>PC CASE</td>
					<td><?php echo $rowpc['Part_Name']; ?></td>
				</tr>
				<tr>
					<td>Other</td>
					<td>
					<?php
					$addquery = mysqli_query($connect,"SELECT * FROM customise where customiseid='$code'");
					while($rowsadd = mysqli_fetch_array($addquery)) 
					{
						$mark=explode(',',$rowsadd['addonid']);
						foreach($mark as $out) 
						{
							$queryadd=mysqli_query($connect,"select * from part where Part_ID='$out'");
							$rowsaddon=mysqli_fetch_assoc($queryadd);
							?>
								<?php echo $rowsaddon['Part_Name']?><br>
							<?php
						}
					}
					?>
					</td>
				</tr>
			</table>
			<p class="show-payment"><b><?php echo "Total to pay : RM".number_format($total,2); ?></b></p>
			<a href="order_edit.php?edit&code=<?php echo $id;?>">
				<button type="button">Back</button>
			</a>
			</div>
		</div>
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>