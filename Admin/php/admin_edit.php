<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../");
	exit;
}
ob_start();
require_once("../../php/connection.php");

if(isset($_GET["edit"]))
{
	ob_start();
	$code = $_GET["code"];
	$result = mysqli_query($connect, "select * from staff where Staff_ID = $code");
	$row = mysqli_fetch_assoc($result);
	ob_end_flush();
}

$id = $name = $email = $phone = $age = $password = "";
$id_check = $email_check = $phone_check = $age_check = $name_check = $password_check = "";

if(isset($_POST["savebtn"])) 	
{
	$contact = trim(preg_replace("/[^0-9]/", '', $_POST["staff_contact"]));
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
			if(trim($_POST["staff_id"]) == $row["Admin_ID"])
			{
				$id = trim($_POST["staff_id"]);
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
	}
	
	/*validate username*/
	if(empty(trim($_POST["staff_name"])))
	{
		$name_check = "Please enter a username.";
	}
	else
	{
		if(trim($_POST["staff_name"]) == $row["Staff_Name"])
		{
			$name = trim($_POST["staff_name"]);
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
	}
	
	/*validation for email*/
	if(empty($mail))
	{
		$email_check = "Please enter an email.";
	}
	else
	{
		if($mail == $row["Staff_Email"])
		{
			$email = $mail;
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
	echo("<script>console.log('$gender')</script>");
	if(empty($id_check) && empty($email_check) && empty($phone_check) && empty($age_check) && empty($name_check) && empty($password_check))
	{
		$param_id = $id;
		$param_name = $name;
		$param_email = $email;
		$param_phone = $phone;
		$param_age = $age;
		
		$find = mysqli_query($connect, "select * from staff");	
		$count = mysqli_num_rows($find) + 1;
		
		mysqli_query($connect,"update staff set Admin_ID = '$param_id', Staff_Name = '$param_name', Staff_Email = '$param_email', Staff_Contact_Num = '$param_phone', Staff_Age = '$param_age', Staff_Gender = '$gender' where Staff_ID = '$code'");
		?>
			<script type="text/javascript">
				confirm = alert("<?php echo "$name is updated.";?>");
				window.location.href = "admin_edit.php?confirm=" + confirm;
			</script>
		<?php
	}
	else
	{
		?>
			<script>console.log("Something went wrong. Admin cannot be updated.");</script>
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
<!--div for editing admin-->
	<div class="main-body">
		<h6>Admin</h6>
		<div id="add-admin" class="">

			<form name="addfrm" method="post" class="addform" action="">
				<p class="<?php echo (!empty($id_check)) ? 'has-error' : ''; ?>">
					<label>ID (need 6 characters):&nbsp;</label>
					<input type="text" name="staff_id" value="<?php echo $row["Admin_ID"];?>"><br>
					<span id="valid-id">&nbsp;<?php echo $id_check; ?></span>
				</p>
				<p class="<?php echo (!empty($name_check)) ? 'has-error' : ''; ?>">
					<label>Username:&nbsp;</label>
					<input type="text" name="staff_name" value="<?php echo $row["Staff_Name"];?>"><br>
					<span id="valid-name">&nbsp;<?php echo $name_check; ?></span>
				</p>
				<p>
					<label>Register Date:&nbsp;&nbsp;</label>
					<input type="date" name="staff_date" id="join_date" value="<?php echo $row["Staff_Join_Date"];?>" disabled><br>
					<span id="id">*This part cannot be edited.</span>
				</p>
				<p class="<?php echo (!empty($email_check)) ? 'has-error' : ''; ?>">
					<label>Email:&nbsp;&nbsp;</label>
					<input type="email" name="staff_email" value="<?php echo $row["Staff_Email"];?>"><br>
					<span id="valid-email">&nbsp;<?php echo $email_check; ?></span>
				</p>
				<p class="<?php echo (!empty($phone_check)) ? 'has-error' : ''; ?>">
					<label>Contact Number:&nbsp;</label>
					<input type="number" name="staff_contact" value="<?php echo $row["Staff_Contact_Num"];?>"><br>
					<span id="valid-contact">&nbsp;<?php echo $phone_check; ?></span>
				</p>
				<p class="<?php echo (!empty($age_check)) ? 'has-error' : ''; ?>">
					<label>Age (>= 18 years old):&nbsp;</label>
					<input type="number" name="staff_age" value="<?php echo $row["Staff_Age"];?>"><br>
					<span id="valid-age">&nbsp;<?php echo $age_check; ?></span>
				</p>
				<p>
					<label>Gender:&nbsp;</label>
					<select name="staff_gender">
						<option value="male" <?php if($row["Staff_Gender"] == "male") echo 'selected';?>>MALE</option>
						<option value="female" <?php if($row["Staff_Gender"] == "female") echo 'selected';?>>FEMALE</option>
					</select>
				</p>

				<p>
					<input type="submit" name="savebtn" value="Edit Admin">
					<input type="submit" name="addback" value="Back" class="add-back-btn">
				</p>
			</form>
		</div>
		<script type="text/javascript" src="../js/admin_login.js"></script>
<!--edit admin form end here-->
	</div>	
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>