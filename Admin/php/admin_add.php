<!doctype html>

<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../");
	exit;
}
ob_start();
require_once "../../php/connection.php";
$date = date("Y-m-d");

$id = $name = $email = $phone = $age = $password = $conpw = $gender = "";
$id_check = $email_check = $phone_check = $age_check = $name_check = $password_check = $conpw_check = "";
if(isset($_POST["savebtn"]))
{
	$contact = trim(preg_replace("/[^0-9]/", '', $_POST["staff_contact"]));
	$date = date("Y-m-d");
	$gender = $_POST["staff_gender"];
	$mail = trim($_POST["staff_email"]);
	/*validation for admin id*/
	if(empty(trim($_POST["staff_id"])))
	{
		$id_check = "Please enter an admin ID.";
	}
	else
	{
		if(strlen(trim($_POST["staff_id"])) != 6)
		{
			$id_check = "Admin ID must in 6 characters.";
		}
		else
		{
			$sql = "select Staff_ID from staff where Admin_ID = ?";

			if($stmt = mysqli_prepare($connect, $sql))
			{
				mysqli_stmt_bind_param($stmt, "s", $param_id);
				$param_id = trim($_POST["staff_id"]);

				if(mysqli_stmt_execute($stmt))
				{
					mysqli_stmt_store_result($stmt);

					if(mysqli_stmt_num_rows($stmt) == 1)
					{
						$id_check = "This ID is already taken.";
					}
					else
					{
						$id = trim($_POST["staff_id"]);
					}
				}
				else
				{
					echo "Oops! Something went wrong. Please try again later.";
				}
				mysqli_stmt_close($stmt);
			}
		}
	}
	
	/*validate username*/
	if(empty(trim($_POST["staff_name"])))
	{
		$name_check = "Please enter a username.";
	}
	else
	{
		$sql = "select Staff_ID from staff where Staff_Name = ?";
		
		if($stmt = mysqli_prepare($connect, $sql))
		{
			mysqli_stmt_bind_param($stmt, "s", $param_name);
			$param_name = trim($_POST["staff_name"]);
			
			if(mysqli_stmt_execute($stmt))
			{
				mysqli_stmt_store_result($stmt);
				
				if(mysqli_stmt_num_rows($stmt) == 1)
				{
					$name_check = "This username is already taken.";
				}
				else
				{
					$name = trim($_POST["staff_name"]);
				}
			}
			else
			{
				echo "Oops! Something went wrong. Please try again later.";
			}
			mysqli_stmt_close($stmt);
		}
	}
	
	/*check for password*/
	if(empty(trim($_POST["staff_pass"])))
	{
		$password_check = "Please enter a password.";
	}
	else
	{
		if(strlen(trim($_POST["staff_pass"])) < 8)
		{
			$password_check = "Password must have at least 8 characters.";
		}
		elseif(!preg_match("#[0-9]+#",trim($_POST["staff_pass"]))) 
		{
        	$password_check = "Your password must contain at least 1 number!";
		}
		elseif(!preg_match("#[A-Z]+#",trim($_POST["staff_pass"]))) 
		{
			$password_check = "Your password must contain at least 1 capital letter!";
		}
		elseif(!preg_match("#[a-z]+#",trim($_POST["staff_pass"]))) 
		{
			$password_check = "Your password must contain at least 1 lowercase letter!";
		}
		else
		{
			$password_check = "";
			$password= trim($_POST["staff_pass"]);
		}
	}
	
	if(empty(trim($_POST["conpass"])))
	{
        $conpw_check = "Please confirm password.";     
    } 
	else
	{
        if(empty($password_check) && ($password != trim($_POST["conpass"])))
		{
            $conpw_check = "Password did not match.";
        }
		else
		{
			$conpw_check = "";
		}
    }
	
	/*validation for email*/
	if(empty($mail))
	{
		$email_check = "Please enter an email.";
	}
	else
	{
		$sqlemail = "select * from staff where Staff_Email = '$mail' LIMIT 1";
		$stat = mysqli_query($connect, $sqlemail);
		if(mysqli_num_rows($stat) > 0)
		{
			$email_check = "This email is already taken.";
		}
		else
		{
			$email = $mail;
		}
	}
	
	/*check for phone validity*/
	if(empty($contact))
	{
		$phone_check = "Please enter a phone number.";
	}
	else
	{
		if(strlen($contact) == 10 || strlen($contact) == 11)
		{
			if($contact[0] == 6)
			{
				$phone_check = "Don't enter the area code (6).";
			}
			else
			{
				$phone = $contact;
			}
		}
		else
		{
			$phone_check = "A phone number can only have 10-11 character.";
		}
	}
	
	/*check for age*/
	if(empty(trim($_POST["staff_age"])))
	{
		$age_check = "Please enter the age.";
	}
	else
	{
		if(trim($_POST["staff_age"]) < 18)
		{
			$age_check = "Admin must be 18 years or above.";
		}
		else
		{
			$age = trim($_POST["staff_age"]);
		}
	}
	
	if(empty($id_check) && empty($email_check) && empty($phone_check) && empty($age_check) && empty($name_check) && empty($password_check) && empty($conpw_check))
	{
		$param_id = $id;
		$param_name = $name;
		$param_date = $date;
		$param_email = $email;
		$param_phone = $phone;
		$param_age = $age;
		$param_gender = $gender;
		$param_pass = password_hash($password, PASSWORD_DEFAULT);
		
		$find = mysqli_query($connect, "select * from staff");	
		$count = mysqli_num_rows($find) + 1;
		
		mysqli_query($connect,"insert into staff (Staff_ID, Admin_ID, Staff_Name, Staff_Join_Date, Staff_Email, Staff_Contact_Num, Staff_Age, Staff_Gender, Staff_Pass) values ('$count', '$param_id', '$param_name','$param_date', '$param_email', '$param_phone', '$param_age', '$param_gender', '$param_pass')");
		?>
			<script type="text/javascript">
				confirm = alert("<?php echo "$name is saved.";?>");
				window.location.href = "admin_add.php?confirm=" + confirm;
			</script>
		<?php
	}
	else
	{
		?>
			<script>console.log("Something went wrong. Admin cannot be saved.");</script>
		<?php
	}
}

if(isset($_POST["addback"]))
{
	header("Location: ../management_admin.php");
}

if(isset($_GET["confirm"]))
{
	header("Location: ../management_admin.php");
	exit();
}
?>

<html>
<head>
<meta charset="utf-8">
<title>JIT - Admin Management</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../image/JIT logo.png">
	<link rel="stylesheet" href="../style/admin_template.php">
	<link rel="stylesheet" href="../style/admin_manage.php">
	<link href="https://fonts.googleapis.com/css?family=Coiny" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
</head>

<body>
	<!--top navbar-->
	<div id="navbar">
		<?php
		$_SESSION["php"] = true;
		include("../hamburger_menu.php");
		?>
	</div>
	<!--navbar end here-->
	<!--side navbar-->
	<div id="content-panel">
		<div class="side-navbar navheight">
			<?php
			$_SESSION["directory"] = "admin";
			include("../admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
<!--div for adding a new admin-->
		<div class="main-body">
			<h6>Admin</h6>
			<div id="add-admin" class="">
				
				<form name="addfrm" method="post" class="addform1" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<p class="<?php echo (!empty($id_check)) ? 'has-error' : ''; ?>">
						<label>ID (need 6 characters):&nbsp;</label>
						<input type="text" name="staff_id" value="<?php echo $id; ?>"><br>
						<span id="valid"><?php echo $id_check; ?></span>
					</p>
					<p class="<?php echo (!empty($name_check)) ? 'has-error' : ''; ?>">
						<label>Username:&nbsp;</label>
						<input type="text" name="staff_name" value="<?php echo $name; ?>"><br>
						<span id="valid"><?php echo $name_check; ?></span>
					</p>
					<p>
						<label>Register Date:&nbsp;&nbsp;</label>
						<input type="date" name="staff_date" id="join_date" value="<?php echo $date; ?>" disabled><br>
						<span id="id">*This part cannot be edited.</span>
					</p>
					<p class="<?php echo (!empty($email_check)) ? 'has-error' : ''; ?>">
						<label>Email:&nbsp;&nbsp;</label>
						<input type="email" name="staff_email" value="<?php echo $email; ?>"><br>
						<span id="valid"><?php echo $email_check; ?></span>
					</p>
					<p class="<?php echo (!empty($phone_check)) ? 'has-error' : ''; ?>">
						<label>Contact Number:&nbsp;</label>
						<input type="number" name="staff_contact" value="<?php echo $phone; ?>"><br>
						<span id="valid"><?php echo $phone_check; ?></span>
					</p>
					<p class="<?php echo (!empty($age_check)) ? 'has-error' : ''; ?>">
						<label>Age (>= 18 years old):&nbsp;</label>
						<input type="number" name="staff_age" value="<?php echo $age; ?>"><br>
						<span id="valid"><?php echo $age_check; ?></span>
					</p>
					<p>
						<label>Gender:&nbsp;</label>
						<select name="staff_gender">
							<option value="male" <?php if($gender == "male") echo 'selected'; ?>>MALE</option>
							<option value="female" <?php if($gender == "female") echo 'selected'; ?>>FEMALE</option>
						</select>
					</p>
					<p class="<?php echo (!empty($password_check)) ? 'has-error' : ''; ?>">
						<label>Password:&nbsp;</label>
						<input type="password" name="staff_pass" id="input-pass" value="<?php echo $password; ?>">
						<input type="checkbox" onClick="showpass()" class="show-pass" title="Show Password">
						<span class="show-text" style="color: black;">Show Password</span><br>
						<span id="valid"><?php echo $password_check; ?></span><br>
					</p>
					<p class="<?php echo (!empty($conpw_check)) ? 'has-error' : ''; ?>">
						<label>Confirm Password:&nbsp;</label>
						<input type="password" name="conpass" id="confirm-pass" value="<?php echo $conpw; ?>">
						<input type="checkbox" onClick="showpassword()" class="show-pass" style="padding-left: 1px;" title="Show Password"><span class="show-text" style="color: black;">Show Password</span><br>
						<span id="valid"><?php echo $conpw_check; ?></span><br>
					</p>
					<p>
						<input type="submit" name="savebtn" value="Add Admin">
						<input type="submit" name="addback" value="Back" class="add-back-btn">
					</p>
				</form>
			</div>
			
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
<!--add admin form end here-->
		</div>
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>