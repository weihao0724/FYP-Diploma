<?php 
include("php/connection.php"); 
if(!isset($_GET["code"]))
{
	echo("<script>alert('Can't find the page');</script>");
	header("location:index.php");
}

$code=$_GET["code"];
$password_check = $conpw_check = $pw = " ";
$query = false;

$getEmailquery = mysqli_query($connect,"SELECT Email FROM resetpassword WHERE Resetcode = '$code'");
if(mysqli_num_rows($getEmailquery) == 0 )
{
	echo("<script>alert('Can't find the page');</script>");
	header("location:index.php");
}
if(isset($_POST["submit"]))
{
	if(empty(trim($_POST["password"])))
	{
		$password_check = "Please enter a password.";
	}
	else
	{
		$password = trim($_POST["password"]);
		if(strlen($password) < 8)
		{
			$password_check = "Password must have at least 8 characters.";
		}
		elseif(!preg_match("#[0-9]+#",$password)) 
		{
        	$password_check = "Your password must contain at least 1 number!";
		}
		elseif(!preg_match("#[a-z]+#",$password)) 
		{
			$password_check = "Your password must contain at least 1 lowercase letter!";
		}
		else
		{
			$password_check = "";
			$pw= trim($_POST["password"]);
		}
	}
	
	if(empty(trim($_POST["conpw"])))
	{
        $conpw_check = "Please confirm password.";     
    } 
	else
	{
		$conpw = trim($_POST["conpw"]);
        if(empty($password_check) && ($pw != $conpw))
		{
            $conpw_check = "Password did not match.";
        }
		else
		{
			$conpw_check = "";
			$pw= password_hash($pw,PASSWORD_DEFAULT);
			$row = mysqli_fetch_array($getEmailquery);
			$email = $row["Email"];
			$query = mysqli_query($connect,"UPDATE customer SET Customer_password ='$pw' WHERE Customer_Email = '$email'");
		}
    }
	
	
	if(empty($conpw_check) && empty($password_check))
	{
		$query=mysqli_query($connect,"DELETE FROM resetpassword WHERE Resetcode='$code'");
		?>
			<script>
				confirm = alert('Password Updated');
				window.location.href = "resetpassword.php?confirm=" + confirm;
			</script>
		<?php
	}
}

if(isset($_GET["confirm"]))
{
	header("location:Log_in.php");
	exit();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Forgot Password</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="../style/admin_login.php">
	<link rel="shortcut icon" type="image/x-icon" href="../../image/JIT logo.png">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
</head>
	
<body>
	
	<div class="login-panel" align="center">
		<img src="image/JIT logo.png" alt="JIT logo" style="height: 7em;">
		<h1>Change Password</h1>
		<div class="login-form">
			<form method="POST">
				<input type="password" class="forgot-email" name="password" placeholder="new password" id="Pass"><br>
				<span id="valid-pass">&nbsp;<br><?php echo  $password_check; ?></span><br><br>
				<input type="password" class="forgot-email" name="conpw" placeholder="confirm password" id="ConPass"><br>
				<span id="valid-pass">&nbsp;<?php echo $conpw_check; ?></span><br>
				<br>
				<input type="submit" class="change-pw" name="submit" value="Change Password">
				<input type="checkbox" onclick="myFunction1();myFunction()">Show Password
			</form>
			<script>
function myFunction() {
var x = document.getElementById("Pass");
if (x.type === "password") {
x.type = "text";
} else {
x.type = "password";
}
}
function myFunction1() {
var y = document.getElementById("ConPass");
if (y.type === "password") {
y.type = "text";
} else {
y.type = "password";
}
}</script>
		</div>
	</div>
</body>
</html>
