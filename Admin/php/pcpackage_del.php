<?php
include("../../php/connection.php");

if(isset($_GET["del"]))
{
	$code = $_GET["code"];
	mysqli_query($connect, "update pc set pc_isDelete=1 where pc_ID ='$code'");
	header("Location: ../pcpackage.php");
	exit;
}
?>