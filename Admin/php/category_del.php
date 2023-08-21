<?php
include("connection.php");

if(isset($_GET["del"]))
{
	$code = $_GET["code"];
	mysqli_query($connect, "update category set category_isDelete=1 where Category_ID ='$code'");
	header("Location: ../management_category.php");
	exit;
}
?>