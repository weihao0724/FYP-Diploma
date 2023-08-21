<?php 
include("../php/connection.php");
session_start();

if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../Admin");
	exit;
}

$code=$_SESSION["admin_id"];
$password_check = $conpw_check = $oldpw_check = "";
$pw = "";

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
		elseif(!preg_match("#[A-Z]+#",$password)) 
		{
			$password_check = "Your password must contain at least 1 capital letter!";
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
		}
    }
	
	if(empty(trim($_POST["oldpw"])))
	{
        $oldpw_check = "Please enter old password.";     
    } 
	else
	{
		$sql = "select * from staff where Staff_ID = '$code'";
		$result = mysqli_query($connect, $sql);
		$row = mysqli_fetch_assoc($result);
		
		if(password_verify(trim($_POST["oldpw"]), $row["Staff_Pass"]))
		{
			$oldpw_check = "";
		}
		else
		{
			$oldpw_check = "Your current password is wrong.";
		}
        
    }
	
	if(empty($conpw_check) && empty($password_check) && empty($oldpw_check))
	{
		mysqli_query($connect, "update staff set Staff_Pass = '$pw' where Staff_ID = '$code'");
		?>
			<script>
				confirm = alert('Password Updated');
				window.location.href = "admin_changepw.php?confirm=" + confirm;
			</script>
		<?php
	}
	else
	{
		?>
			<script>
				console.log('Somthing went wrong. Try again later.');
			</script>
		<?php
	}
}

if(isset($_POST["addback"]))
{
	header("Location: admin_profile.php");
}

if(isset($_GET["confirm"]))
{
	header("location: admin_profile.php");
	exit();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JIT - Admin Account</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../image/JIT logo.png">
	<link rel="stylesheet" href="style/admin_template.php">
	<link rel="stylesheet" href="style/admin_profile.php">
	<link href="https://fonts.googleapis.com/css?family=Coiny" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
</head>

<body>
	<!--top navbar-->
	<div id="navbar">
		<?php
		$_SESSION["php"] = false;
		include("hamburger_menu.php");
		?>
	</div>	
	<!--navbar end here-->
	<!--side navbar-->
	<div id="content-panel">
		<div class="side-navbar navheight">
			<?php
			$_SESSION["directory"] = "profile";
			include("admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>Admin Profile</h6>
			<form name="addfrm" method="post" action="">
				<p class="<?php echo (!empty($oldpw_check)) ? 'has-error' : ''; ?>">
					<label>Old password:</label><br>
					<input type="password" name="oldpw" placeholder="old password"><br>
					<span class="valid-pass">&nbsp;<?php echo $oldpw_check; ?></span><br>
				</p>
				<p class="<?php echo (!empty($password_check)) ? 'has-error' : ''; ?>">
					<label>New password:</label><br>
					<input type="password" id="input-pass" name="password" placeholder="new password">
					<input type="checkbox" onClick="showpass()" class="show-pass" title="Show Password"><span class="show-text" style="color: black;">Show Password</span><br>
					<span class="valid-pass">&nbsp;<?php echo $password_check; ?></span><br>
				</p>
				<p class="<?php echo (!empty($conpw_check)) ? 'has-error' : ''; ?>">
					<label>Confirm password:</label><br>
					<input type="password" id="confirm-pass" name="conpw" placeholder="confirm password">
					<input type="checkbox" onClick="showpassword()" class="show-pass" title="Show Password"><span class="show-text" style="color: black;">Show Password</span><br>
					<span class="valid-pass">&nbsp;<?php echo $conpw_check; ?></span><br>
				</p>
				<br><br>
				<input type="submit" class="change-pw" name="submit" value="Change Password">
				<input type="submit" name="addback" value="Back" class="add-back-btn">
			</form>
			<script>
				function showpass() 
				{
					var x = document.getElementById("input-pass");
					if (x.type === "password") 
						{
							x.type = "text";
						} 
					else 
						{
							x.type = "password";
						}
				}

				function showpassword() 
				{
					var x = document.getElementById("confirm-pass");
					if (x.type === "password") 
						{
							x.type = "text";
						} 
					else 
						{
							x.type = "password";
						}
				}
			</script>
		</div>
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>
