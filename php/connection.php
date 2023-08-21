<?php
$connect = mysqli_connect("localhost", "root", "", "beta");

if($connect)
{
	$output = "<script>console.log('Connect successfully!');</script>";
}
echo($output);
?>
