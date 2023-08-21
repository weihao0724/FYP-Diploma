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
	$result = mysqli_query($connect, "select * from pc where PC_ID = '$code'");
	$row = mysqli_fetch_assoc($result);
	ob_end_flush();
}

$name = $desc = $price = $image = $price = "";
$name_check = $desc_check = $price_check = $image_check = $stock_check = "";

if(isset($_POST["savebtn"]))
{
	$imgFile = $_FILES["part_img"]["name"];
	$tmp_dir = $_FILES["part_img"]['tmp_name'];
	$imgSize = $_FILES["part_img"]['size'];
	
	if(empty(trim($_POST["package_name"])))
	{
		$name_check = "This field cannot be empty.";
	}
	else
	{
		if(trim($_POST["package_name"]) == $row["PC_Name"])
		{
			$name = $row["PC_Name"];
		}
		else
		{
			$sql = "select PC_id from pc where PC_Name = ?";

			if($stmt = mysqli_prepare($connect, $sql))
			{
				mysqli_stmt_bind_param($stmt, "s", $param_name);
				$param_name = trim($_POST["package_name"]);

				if(mysqli_stmt_execute($stmt))
				{
					mysqli_stmt_store_result($stmt);
					
					if(mysqli_stmt_num_rows($stmt) == 1)
					{
						$name_check = "This package name had already register.";
					}
					else
					{
						$name = trim($_POST["package_name"]);
					}
				}
				else
				{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}
			mysqli_stmt_close($stmt);
		}
	}
	
	if(empty(trim($_POST["package_price"])))
	{
		$price_check = "This field cannot be empty.";
	}
	else
	{
		if(trim($_POST["package_price"]) <= 0)
		{
			$price_check = "Please enter a valid price";
		}
		else
		{
			$price = trim($_POST["package_price"]);
		}
	}
	
	if(empty(trim($_POST["package_stock"])))
	{
		$stock_check = "This field cannot be empty.";
	}
	else
	{
		if(trim($_POST["package_stock"]) <= 0)
		{
			$stock_check = "Please enter a valid price";
		}
		else
		{
			$stock = trim($_POST["package_stock"]);
		}
	}

	if(empty($_POST["package_desc"]))
	{
		$desc_check = "This field cannot be empty.";
	}
	else
	{
		$desc = $_POST["package_desc"];
	}
	
	if(!empty($imgFile) && $imgFile != NULL)
	{
		$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
		
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); //valid extensions format
		$image = "upload/" . rand(1000,1000000).".".$imgExt;
    
		if(in_array($imgExt, $valid_extensions))
		{   
			if($imgSize < 5000000)
			{
 				move_uploaded_file($tmp_dir, "../../".$image);
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
		$image = $row["image"];
	}
	
	if(empty($name_check) && empty($price_check) && empty($desc_check) && empty($stock_check) && empty($image_check))
	{
		$param_image = $image;
		mysqli_query($connect,"update pc set PC_Name = '$name', PC_Price = '$price', PC_Detail = '$desc', Stock = '$stock', image = '$param_image' where PC_ID = '$code'");
		?>
			<script type="text/javascript">
				confirm = alert("<?php echo "$name is updated.";?>");
				window.location.href = "pcpackage_edit.php?confirm=" + confirm;
			</script>
		<?php
	}
	else
	{
		?>
			<script>console.log("Something went wrong. Package cannot be updated.");</script>
		<?php
	}
}

if(isset($_POST["addback"]))
{
	header("Location: ../pcpackage.php");
}

if(isset($_GET["confirm"]))
{
	header("Location: ../pcpackage.php");
	exit();
}
?>

<html>
<head>
<meta charset="utf-8">
<title>JIT - Management Parts</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../image/JIT logo.png">
	<link rel="stylesheet" href="../style/admin_template.php">
	<link rel="stylesheet" href="../style/admin_category.php">
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
			$_SESSION["directory"] = "pcpackage";
			include("../admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>PC Package</h6>
			
<!--div for adding a new part-->
			<div id="edit-part" class="">
				<form class="addfrm" name="addfrm" method="post" enctype="multipart/form-data">
					<div class="img-section">
						<p class="img">
							<img class="show-img" src="../../<?php echo $row["image"];?>" alt="part_image">
						</p>
						<p class="img-caption">
							<?php
							if(!empty($name))
							{
								echo("$name");
							}
							else
							{
								echo $row['PC_Name'];
							}
							?>
						<p>
					</div>
					<p class="<?php echo (!empty($id_check)) ? 'has-error' : ''; ?>">
						<label>ID:</label>
						<input type="text" name="package_id" value="<?php echo $row["PC_ID"];?>" disabled><br>
						<span id="id">*This part cannot be edited.</span>
					</p>
					<p class="<?php echo (!empty($name_check)) ? 'has-error' : ''; ?>">
						<label>Name:</label>
						<input type="text" name="package_name" value="<?php echo $row["PC_Name"];?>">
						<br><span class="cate-name">&nbsp;<?php echo $name_check;?></span>
					</p>
					<p>
						<label>Details:</label>
						<textarea cols="55" rows="4" name="package_desc"><?php echo $row["PC_Detail"];?></textarea>
						<br><span class="cate-desc">&nbsp;<?php echo $desc_check;?></span>
					</p>
					<p class="<?php echo (!empty($price_check)) ? 'has-error' : ''; ?>">
						<label>Price:</label>
						<input type="number" name="package_price" value="<?php echo $row["PC_Price"];?>">
						<br><span class="cate-name">&nbsp;<?php echo $price_check;?></span>
					</p>
					<p class="<?php echo (!empty($stock_check)) ? 'has-error' : ''; ?>">
						<label>Stock:</label>
						<input type="number" name="package_stock" value="<?php echo $row["Stock"];?>">
						<br><span class="cate-name">&nbsp;<?php echo $stock_check;?></span>
					</p>
					<p class="<?php echo (!empty($image_check)) ? 'has-error' : ''; ?>">
						<label>Image:&nbsp;</label>
						<input type="file" name="part_img" accept="image/*" value="<?php echo $row["image"];?>"/>
						<br><span id="part-pic" class="image">&nbsp;<?php echo $image_check;?></span>
					</p>
					<p>
						<input type="submit" name="savebtn" value="Update Package">
						<input type="submit" name="addback" value="Back" class="add-back-btn">
					</p>
				</form>
			</div>
			
		</div>
<!--add part form end here-->
		
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>
