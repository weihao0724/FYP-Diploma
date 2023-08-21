<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<style>
img
	{
		height: 100px;
		width: 100px;
	}
</style>
<?php 
include('../../php/connection.php');

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
	$user_id = 0;
}
else
{
	$user_id = $_SESSION["id"];
}

$id = 3; // get id through query string

$date = date('Y/m/d', time());
?>
<body>
	<a href="cart.php"><button>Back To Cart</button></a>
	<?php include('../../php/connection.php');?>
	
	
	<?php
		  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
			{
				
			?>
		  <?php
			}
			
			else
			{
				
				$user_id = $_SESSION["id"];
			?>
			
			<?php				
			}
			?>
	<?php 
$query1 ="SELECT * FROM `customise` where Customer_ID =$user_id and customiseid='$id'";
$result1 = mysqli_query($connect, $query1);
$totalfinal=0;
?>
		
	<?php $query_addres=mysqli_query($connect,"SELECT * from customer where Customer_ID=$user_id"); 
	$rowcusadd =mysqli_fetch_assoc($query_addres);
	$address=$rowcusadd['Customer_Address']; ?>
	<?php
	while($row1 = mysqli_fetch_assoc($result1))
	{
			$total = $row1['total'];
?>
	
	<table>
			<br>
			<tr><b>Custom Pc Package Details :</b></tr>

	</table>
		
<?php
	 	$psuid=$row1['psuid'];
	 	$pccaseid=$row1['pccaseid'];
	 	$hhdida=$row1['hhdid'];
	 	$ssdid=$row1['ssdid'];
	 	$ramid=$row1['ramid'];
	 	$gpuid=$row1['gpuid'];
	 	$cpuid=$row1['cpuid'];
	 	$moboid=$row1['moboid'];
	 	$query_psu=mysqli_query($connect,"SELECT * from part where Part_ID='$psuid'");
        $query_pccase=mysqli_query($connect,"SELECT * from part where Part_ID='$pccaseid'");
        $query_hhd=mysqli_query($connect,"SELECT * from part where Part_ID='$hhdida'");
        $query_ssd=mysqli_query($connect,"SELECT * from part where Part_ID='$ssdid'");
        $query_ram=mysqli_query($connect,"SELECT * from part where Part_ID='$ramid'");
        $query_gpu=mysqli_query($connect,"SELECT * from part where Part_ID='$gpuid'");
        $query_cpu=mysqli_query($connect,"SELECT * from part where Part_ID='$cpuid'");
        $query_mobo=mysqli_query($connect,"SELECT * from part where Part_ID='$moboid'");
	}?>
	<?php  
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
		<td>CPU</td>
		<td><img src="<?php echo $rowcpu['image']?>"</td>
		<td><?php echo $rowcpu['Part_Name']; ?></td>
	</tr>
	<tr>
		<td>MOBO</td>
		<td><img src="<?php echo $rowmobo['image']?>"</td>
		<td><?php echo $rowmobo['Part_Name']; ?></td>
	</tr>
	<tr>
		<td>GPU</td>
		<td><img src="<?php echo $rowgpu['image']?>"</td>
		<td><?php echo $rowgpu['Part_Name']; ?></td>
	</tr>
	<tr>
		<td>RAM</td>
		<td><img src="<?php echo $rowram['image']?>"</td>
		<td><?php echo $rowram['Part_Name']; ?></td>
	</tr>
	<tr>
		<td>SSD</td>
		<td><img src="<?php echo $rowssd['image']?>"</td>
		<td><?php echo $rowssd['Part_Name']; ?></td>
	</tr>
	<tr>
		<td>HHD</td>
		<td><img src="<?php echo $rowhhd['image']?>"</td>
		<td><?php echo $rowhhd['Part_Name']; ?></td>
	</tr>
	<tr>
		<td>PSU</td>
		<td><img src="<?php echo $rowpsu['image']?>"</td>
		<td><?php echo $rowpsu['Part_Name']; ?></td>
	</tr>
	<tr>
		<td>PC CASE</td>
		<td><img src="<?php echo $rowpc['image']?>"</td>
		<td><?php echo $rowpc['Part_Name']; ?></td>
	</tr>
		<tr>
			<td>Other</td>
		<td>
		<?php
		$addquery = mysqli_query($connect,"SELECT * FROM  customise where Customer_ID ='$user_id' and customiseid='$id'");
		?>
			<?php
			
		while($rowsadd = mysqli_fetch_array($addquery)) {
		$mark=explode(',',$rowsadd['addonid']);//what will do here
		foreach($mark as $out) {
			$queryadd=mysqli_query($connect,"select * from part where Part_ID='$out'");
			$rowsaddon=mysqli_fetch_assoc($queryadd);
			?>
			<img src="<?php echo $rowsaddon['image']?> " ><br>
			
	<?php
		}
}
	?>
		</td>
			<td>
			<?php
		
		foreach($mark as $out) {
			$queryadd=mysqli_query($connect,"select * from part where Part_ID='$out'");
			$rowsaddon=mysqli_fetch_assoc($queryadd);
			?>
				<br></br><?php echo $rowsaddon['Part_Name']?><br></br>
			
	<?php
		}			
	?>
		</td>
		</tr>
	</table>
<a><h1><b><?php echo "Total to pay : RM".number_format($total,2); ?></b></h1></a>
</body>
</html>