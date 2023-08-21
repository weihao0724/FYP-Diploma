<?php
include("../../php/connection.php");

if(isset($_GET["del"]))
{
	$code = $_GET["code"];
	mysqli_query($connect, "delete from staff where Staff_ID ='$code'");
	header("Location: ../management_admin.php");
	exit;
}
?>