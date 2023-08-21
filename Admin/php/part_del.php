<?php
include("../../php/connection.php");

$img_path = "";
if(isset($_GET["del"]))
{
	$code = $_GET["code"];
	mysqli_query($connect, "update part set part_isDelete=1 where Part_ID ='$code'");
	header("Location: ../management_parts.php");
	exit;
}
?>