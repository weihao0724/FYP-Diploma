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
	$result = mysqli_query($connect, "select * from part where Part_ID = '$code'");
	$row = mysqli_fetch_assoc($result);
	ob_end_flush();
}

$name = $price = $category = $stock = $image = "";
$name_check = $price_check = $category_check = $stock_check = $image_check = "";

if(isset($_POST["savebtn"]))
{
	$imgFile = $_FILES["part_img"]["name"];
	$tmp_dir = $_FILES["part_img"]['tmp_name'];
	$imgSize = $_FILES["part_img"]['size'];
	
	if(empty(trim($_POST["part_name"])))
	{
		$name_check = "Please enter part name.";
	}
	else
	{
		if(trim($_POST["part_name"]) == $row["Part_Name"])
		{
			$name = trim($_POST["part_name"]);
		}
		else
		{
			$sql = "select Part_ID from part where Part_Name = ?";

			if($stmt = mysqli_prepare($connect, $sql))
			{
				mysqli_stmt_bind_param($stmt, "s", $param_name);
				$param_name = trim($_POST["part_name"]);

				if(mysqli_stmt_execute($stmt))
				{
					mysqli_stmt_store_result($stmt);

					if(mysqli_stmt_num_rows($stmt) == 1)
					{
						$name_check = "This name had already registered.";
					}
					else
					{
						$name = trim($_POST["part_name"]);
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

	if(empty($_POST["part_price"]))
	{
		$price_check = "Please enter price for part.";
	}
	else
	{
		if($_POST["part_price"] <= 0)
		{
			$price_check = "Price should be at least RM1.00.";
		}
		else
		{
			$price = $_POST["part_price"];
		}
	}
	
	if(empty($_POST["pcategory"]))
	{
		$category_check = "Please select a category.";
	}
	else
	{
		$category = $_POST["pcategory"];
	}
	
	if(empty($_POST["part_stock"]))
	{
		$stock_check = "Please enter stock for part.";
	}
	else
	{
		if($_POST["part_stock"] <= 0)
		{
			$stock_check = "The stock must at least 1.";
		}
		else
		{
			$stock = $_POST["part_stock"];
		}
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
	
	if(empty($id_check) && empty($name_check) && empty($price_check) && empty($category_check) && empty($stock_check) && empty($image_check))
	{
		$param_image = $image;
		$details = $_POST["part_details"];
		mysqli_query($connect,"update part set Part_Name = '$name', Part_Details = '$details', Part_Price = '$price', Category_ID = '$category', Stock = '$stock', image = '$param_image' where Part_ID = '$code'");
		?>
			<script type="text/javascript">
				confirm = alert("<?php echo "$name is updated.";?>");
				window.location.href = "part_edit.php?confirm=" + confirm;
			</script>
		<?php
	}
	else
	{
		?>
			<script>console.log("Something went wrong. Part cannot be updated.");</script>
		<?php
	}
}

if(isset($_POST["addback"]))
{
	header("Location: ../management_parts.php");
}

if(isset($_GET["confirm"]))
{
	header("Location: ../management_parts.php");
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
			$_SESSION["directory"] = "part";
			include("../admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>Parts</h6>
			
<!--div for adding a new part-->
			<div id="edit-part" class="">
				<form class="addfrm" name="addfrm" method="post" action="" enctype="multipart/form-data">
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
								echo $row['Part_Name'];
							}
							?>
						<p>
					</div>
					<p>
						<label>ID:&nbsp;</label>
						<input type="text" name="part_id" value="<?php echo $row["Part_ID"];?>" disabled><br>
						<span id="id">*This part cannot be edited.</span>
					</p>
					<p class="<?php echo (!empty($name_check)) ? 'has-error' : ''; ?>">
						<label>Name:&nbsp;</label>
						<input type="text" name="part_name" value="<?php echo $row["Part_Name"];?>"><br>
						<span id="part-name">&nbsp;<?php echo $name_check;?></span>
					</p>
					<p>
						<label>Details:&nbsp;</label>
						<textarea cols="55" rows="4" name="part_details"><?php echo $row["Part_Details"]; ?></textarea>
						<br><span>&nbsp;</span>
					</p>
					<p class="<?php echo (!empty($price_check)) ? 'has-error' : ''; ?>">
						<label>Price:&nbsp;</label>
						<input type="number" name="part_price" value="<?php echo $row["Part_Price"];?>"><br>
						<span id="part-price">&nbsp;<?php echo $price_check;?></span>
					</p>
					<p class="<?php echo (!empty($category_check)) ? 'has-error' : ''; ?>">
						<label>Category:&nbsp;</label>
						<select name="pcategory" class="cate_option">
							<option value="">--select category--</option>
							<?php
							$cate_sql = "select * from category where Category_isDelete = 0";
							$cate_result = mysqli_query($connect, $cate_sql);
							while($cate_row = mysqli_fetch_assoc($cate_result))
							{
							?>
								<option value="<?php echo $cate_row["Category_ID"];?>" <?php if($row["Category_ID"] == $cate_row["Category_ID"]) echo 'selected';?>>
									<?php echo $cate_row["Category_Name"];?>
								</option>
							<?php
							}
							?>
						</select><br>
						<span id="part-cate">&nbsp;<?php echo $category_check;?></span>
					</p>
					<p class="<?php echo (!empty($stock_check)) ? 'has-error' : ''; ?>">
						<label>Stock:&nbsp;</label>
						<input type="number" name="part_stock" value="<?php echo $row["Stock"];?>"><br>
						<span id="part-stock">&nbsp;<?php echo $stock_check;?></span>
					</p>
					<p class="<?php echo (!empty($image_check)) ? 'has-error' : ''; ?>">
						<label>Image:&nbsp;</label>
						<input type="file" name="part_img" accept="image/*"/>
						<br><span id="part-pic" class="image">&nbsp;<?php echo $image_check;?></span>
					</p>

					<p>
						<input class="update-btn" type="submit" name="savebtn" value="Update Part">
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
