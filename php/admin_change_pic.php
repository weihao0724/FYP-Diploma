<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../");
	exit;
}
ob_start();
include("../../php/connection.php");

if(isset($_GET["edit"]))
{
	ob_start();
	$code = $_GET["code"];
	$result = mysqli_query($connect, "select * from staff where Staff_ID = '$code'");
	$row = mysqli_fetch_assoc($result);
	ob_end_flush();
	$name = $row["Staff_Name"];
	
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
}

$image = $image_check = "";

if(isset($_POST["savebtn"]))
{
	$imgFile = $_FILES["admin_img"]["name"];
	$tmp_dir = $_FILES["admin_img"]['tmp_name'];
	$imgSize = $_FILES["admin_img"]['size'];
	
	if(!empty($imgFile) && $imgFile != NULL)
	{
		$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
		
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); //valid extensions format
		$image = "admin_pic/" . rand(1000,1000000).".".$imgExt;
    
		if(in_array($imgExt, $valid_extensions))
		{   
			if($imgSize < 5000000)
			{
 				move_uploaded_file($tmp_dir, "../" . $image);
			}
			else
			{
				$image_check = "Sorry, your file is too large.";
			}
		}
		else
		{
			$image_check = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";  
		}
	}
	else
	{
		$image = $row["Admin_Pic"];
	}
	
	if(empty($image_check))
	{
		$param_image = $image;
		mysqli_query($connect,"update staff set Admin_Pic = '$param_image' where Staff_ID = '$code'");
		?>
			<script type="text/javascript">
				alert("<?php echo "$name is updated";?>");
			</script>
		<?php
		header("Location: ../admin_profile.php");
	}
	else
	{
		?>
			<script>console.log("Something went wrong. Profile picture cannot be updated.")</script>
		<?php
	}
}

if(isset($_POST["addback"]))
{
	header("Location: ../admin_profile.php");
}
?>

<html>
<head>
<meta charset="utf-8">
<title>JIT - Admin Account</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../image/JIT logo.png">
	<link rel="stylesheet" href="../style/admin_template.php">
	<link rel="stylesheet" href="../style/admin_profile.php">
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
			$_SESSION["directory"] = "profile";
			include("../admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6><?php echo $row["Staff_Name"];?></h6>
			
			<div id="edit-part" class="">
				<form class="addfrm" name="addfrm" method="post" action="" enctype="multipart/form-data">
					<div class="img-section">
						<p class="img">
							<label>Select a picture for profile picture:</label><br>
							<img class="show-img" src="../<?php echo $show_pic;?>" alt="admin_image">
						</p>
					</div>
					<p class="<?php echo (!empty($image_check)) ? 'has-error' : ''; ?>">
						<input type="file" name="admin_img" accept="image/*" />
						<br><span id="admin-pic" class="image">&nbsp;<?php echo $image_check;?></span>
					</p>
					<p>
						<input class="update-btn" type="submit" name="savebtn" value="Update Profile">
						<input type="submit" name="addback" value="Back" class="add-back-btn">
					</p>
				</form>
			</div>
		</div>
		
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>
