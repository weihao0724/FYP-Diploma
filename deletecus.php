<?php

include "php/connection.php"; // Using database connection file here

session_start();
	
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
	$user_id = 0;
}
else
{
	$user_id = $_SESSION["id"];
}

$id = $_GET['id']; // get id through query string

$del = mysqli_query($connect,"delete from customise where customiseid = '$id' AND Customer_ID = '$user_id'"); // delete query

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