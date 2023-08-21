<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../");
	exit;
}
ob_start();
require_once "../../php/connection.php";

$id = $name = $desc = $price = $image = $price = "";
$id_check = $name_check = $desc_check = $price_check = $image_check = $stock_check = "";

if(isset($_POST["savebtn"]))
{
	$imgFile = $_FILES["part_img"]["name"];
	$tmp_dir = $_FILES["part_img"]['tmp_name'];
	$imgSize = $_FILES["part_img"]['size'];
	
	if(empty(trim($_POST["package_id"])))
	{
		$id_check = "Please enter the package ID.";
	}
	else
	{
		$sql = "select PC_ID from pc where PC_ID = ?";
		
		if($stmt = mysqli_prepare($connect, $sql))
		{
			mysqli_stmt_bind_param($stmt, "s", $param_id);
			$param_id = trim($_POST["package_id"]);
			
			if(mysqli_stmt_execute($stmt))
			{
				mysqli_stmt_store_result($stmt);
				
				if(mysqli_stmt_num_rows($stmt) == 1)
				{
					$id_check = "This ID had already taken.";
				}
				else
				{
					$id = trim($_POST["package_id"]);
				}
			}
			else
			{
				echo "Oops! Something went wrong. Please try again later.";
			}
			mysqli_stmt_close($stmt);
		}
	}
	
	if(empty(trim($_POST["package_name"])))
	{
		$name_check = "This field cannot be empty.";
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
	
	if(empty($imgFile))
	{
		$image_check = "Please upload an image.";
	}
	else
	{
		$upload_dir = '../../upload/';
		$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
		
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); //valid extensions format
		$image = rand(1000,1000000).".".$imgExt;
    
		if(in_array($imgExt, $valid_extensions))
		{   
			if($imgSize < 5000000)
			{
 				move_uploaded_file($tmp_dir, $upload_dir.$image);
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
	
	if(empty($desc_check) && empty($name_check) && empty($id_check) && empty($price_check) && empty($image_check) && empty($stock_check))
	{
		$param_image = "upload/" . $image;
		mysqli_query($connect,"insert into pc (PC_ID, PC_Detail, PC_Name, PC_Price, image, stock) values ('$id', '$desc', '$name', '$price', '$param_image', '$stock')");
		?>
			<script type="text/javascript">
				confirm = alert("<?php echo "$name is saved.";?>");
				window.location.href = "pcpackage_add.php?confirm=" + confirm;
			</script>
		<?php
	}
	else
	{
		?>
			<script>console.log("Something went wrong. Package cannot be saved.");</script>
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
<title>JIT - PC Package</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../../image/JIT logo.png">
	<link rel="stylesheet" href="../style/admin_template.php">
	<link rel="stylesheet" href="../style/admin_package.php">
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
			$_SESSION["php"] = true;
			include("../admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>PC Package</h6>
						
			<div id="add-category" class="">

				<form class="addfrm" name="addfrm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
					<p class="<?php echo (!empty($id_check)) ? 'has-error' : ''; ?>">
						<label>ID:</label>
						<input type="text" name="package_id" value="<?php echo $id;?>">
						<br><span class="cate-name">&nbsp;<?php echo $id_check;?></span>
					</p>
					<p class="<?php echo (!empty($name_check)) ? 'has-error' : ''; ?>">
						<label>Name:</label>
						<input type="text" name="package_name" value="<?php echo $name;?>">
						<br><span class="cate-name">&nbsp;<?php echo $name_check;?></span>
					</p>
					<p>
						<label>Details:</label>
						<textarea cols="55" rows="4" name="package_desc"><?php echo $desc;?></textarea>
						<br><span class="cate-desc">&nbsp;<?php echo $desc_check;?></span>
					</p>
					<p class="<?php echo (!empty($price_check)) ? 'has-error' : ''; ?>">
						<label>Price:</label>
						<input type="number" name="package_price" value="<?php echo $price;?>">
						<br><span class="cate-name">&nbsp;<?php echo $price_check;?></span>
					</p>
					<p class="<?php echo (!empty($stock_check)) ? 'has-error' : ''; ?>">
						<label>Stock:</label>
						<input type="number" name="package_stock" value="<?php echo $stock;?>">
						<br><span class="cate-name">&nbsp;<?php echo $stock_check;?></span>
					</p>
					<p class="<?php echo (!empty($image_check)) ? 'has-error' : ''; ?>">
						<label>Image:&nbsp;</label>
						<input type="file" name="part_img" accept="image/*" />
						<br><span id="part-pic" class="image">&nbsp;<?php echo $image_check;?></span>
					</p>
					<p>
						<input type="submit" name="savebtn" value="Add Package">
						<input type="submit" name="addback" value="Back" class="add-back-btn">
					</p>
				</form>

				<?php
					
				?>
			</div>
			
		</div>
<!--add category form end here-->
		
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>