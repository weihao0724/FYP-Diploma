<?php

include "php/connection.php"; // Using database connection file here

session_start();
	
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
	$id = 0;
}
else
{
	$id = $_SESSION["id"];
}

$pid = $_GET['id']; // get id through query string

$del = mysqli_query($connect,"delete from cart where Part_ID = '$pid' OR PC_ID = '$pid' AND Customer_ID = '$id'"); // delete query

if($del)
{
    mysqli_close($connect); // Close connection
    header("location:cart.php"); // redirects to all records page
    exit;	
}
else
{
    echo "Error deleting record"; // display error message if not delete
}
?>