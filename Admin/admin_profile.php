<?php
session_start();

if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../Admin");
	exit;
}
include("../php/connection.php");

$edit = false;
$admin_id = $_SESSION["admin_id"];
$result = mysqli_query($connect, "select * from staff where Staff_ID = '$admin_id'");
$row = mysqli_fetch_assoc($result);

if(empty($row["Admin_Pic"]))
{
	if($row["Staff_Gender"] == "male")
	{
		$show_pic = "admin_pic/male-profile-pic.png";
	}
	else if($row["Staff_Gender"] == "female")
	{
		$show_pic = "admin_pic/female-profile-pic.png";
	}
}
else
{
	$show_pic = $row["Admin_Pic"];
}

$id = $name = $email = $phone = $age = $password = "";
$id_check = $email_check = $phone_check = $age_check = $name_check = $password_check = "";

if(isset($_POST["save"])) 	
{
	$contact = trim(preg_replace("/[^0-9]/", '', $_POST["staff_contact"]));
	$gender = $_POST["staff_gender"];
	$mail = trim($_POST["staff_email"]);
	$id = $row["Admin_ID"];
	
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
	if($row["Staff_Email"] == "1191200094@student.mmu.edu.my")
	{
		$email = $row["Staff_Email"];
	}
	else
	{
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
		
		mysqli_query($connect,"update staff set Admin_ID = '$param_id', Staff_Name = '$param_name', Staff_Email = '$param_email', Staff_Contact_Num = '$param_phone', Staff_Age = '$param_age', Staff_Gender = '$gender' where Staff_ID = '$admin_id'");
		?>
			<script>alert("<?php echo "$param_name is updated.";?>");</script>
		<?php
		header("location: admin_profile.php");
		$edit = false;
	}
	else
	{
		$edit = true;
		?>
			<script>console.log("Something went wrong. Admin cannot be updated.")</script>
		<?php
	}
}

if(isset($_POST["edit"]))
{
	$edit = true;
}


if(isset($_POST["back"]))
{
	$edit = false;
}

if(isset($_POST["changepw"]))
{
	header("location: admin_changepw.php");
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
			<div class="dash-content">
				<br/>
				<div class="profile-title heightmargin">
					<div class="profile-pic" align="center">
						<a href="php/admin_change_pic.php?edit&code=<?php echo $row["Staff_ID"];?>">
							<img src="<?php echo $show_pic;?>" alt="admin-profile" class="admin-pic">
							<span class="middle">
								<span class="profile-text">
									<i class="material-icons-round table-icon">edit</i><br>Edit
								</span>
							</span>
						</a>
					</div>
					<div>
						<p class="profile-name" style="font-size: 22px">
							<?php echo $_SESSION["admin_name"]; ?>
						</p>
					</div>
				</div>
				
				
				<div id="show-profile">
					<form name="addfrm" method="post" class="addform" action="">
						<div class="profile-left">
							<p class="<?php echo (!empty($id_check)) ? 'has-error' : ''; ?>">
								<label>ID:&nbsp;</label><br/>
								<div class="show-col">
									<input class="show-data" type="text" name="staff_id" value="<?php echo $row["Admin_ID"];?>" disabled>
								</div>
								<span id=""><?php if($edit) echo "*This part cannot be edited."; ?></span>
							</p>
							<p class="<?php echo (!empty($name_check)) ? 'has-error' : ''; ?>">
								<label>Username:&nbsp;</label><br/>
								<div class="show-col">
									<input class="show-data" type="text" name="staff_name" value="<?php echo $row["Staff_Name"];?>" <?php if(!$edit) echo "disabled";?>>
								</div>
								<span id="valid-name"><?php echo $name_check; ?></span>
							</p>
							<p>
								<label>Register Date:&nbsp;&nbsp;</label><br/>
								<div class="show-col">
									<input class="show-data" type="text" name="staff_date" id="join_date" value="<?php echo $row["Staff_Join_Date"];?>" disabled>
								</div>
								<span id=""><?php if($edit) echo "*This part cannot be edited."; ?></span>
							</p>
							<p>
								<label>Gender:&nbsp;</label><br/>
								<select name="staff_gender" <?php if(!$edit) echo "disabled";?>>
									<option value="male" <?php if($row["Staff_Gender"] == "male") echo 'selected';?>>MALE</option>
									<option value="female" <?php if($row["Staff_Gender"] == "female") echo 'selected';?>>FEMALE</option>
								</select>
							</p>
						</div>
						<div class="profile-right">
							<p class="<?php echo (!empty($email_check)) ? 'has-error' : ''; ?>">
								<label>Email:&nbsp;&nbsp;</label><br/>
								<div class="show-col">
									<input class="show-data" type="email" name="staff_email" value="<?php echo $row["Staff_Email"];?>" disabled>
								</div>
								<span id=""><?php if($edit) echo "*This part cannot be edited."; ?></span>
							</p>
							<p class="<?php echo (!empty($phone_check)) ? 'has-error' : ''; ?>">
								<label>Contact Number:&nbsp;</label><br/>
								<div class="show-col">
									<input class="show-data" type="number" name="staff_contact" value="<?php echo $row["Staff_Contact_Num"];?>" <?php if(!$edit) echo "disabled";?>>
								</div>
								<span id="valid-contact"><?php echo $phone_check; ?></span>
							</p>
							<p class="<?php echo (!empty($age_check)) ? 'has-error' : ''; ?>">
								<label>Age:&nbsp;</label><br/>
								<div class="show-col">
									<input class="show-data" type="number" name="staff_age" value="<?php echo $row["Staff_Age"];?>" <?php if(!$edit) echo "disabled";?>>
								</div>
								<span id="valid-age"><?php echo $age_check; ?></span>
							</p>
							<br>
							<p class="button <?php if($edit) echo hidden;?>">
								<input type="submit" name="edit" value="Edit Profile">
							</p>
							<p class="<?php if(!$edit) echo hidden;?>">
								<input type="submit" name="changepw" value="Change Password">
							</p>
							<p class="edit-button <?php if(!$edit) echo hidden;?>">
								<input type="submit" name="back" value="Back">
								<input type="submit" name="save" value="Save">
							</p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>
