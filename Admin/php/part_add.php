<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../");
	exit;
}

ob_start();
include("../../php/connection.php");

$id = $name = $price = $category = $stock = $image = "";
$id_check = $name_check = $price_check = $category_check = $stock_check = $image_check = "";

if(isset($_POST["savebtn"]))
{
	$imgFile = $_FILES["part_img"]["name"];
	$tmp_dir = $_FILES["part_img"]['tmp_name'];
	$imgSize = $_FILES["part_img"]['size'];
	
	/*validation for part id*/
	if(empty(trim($_POST["part_id"])))
	{
		$id_check = "Please enter the part ID.";
	}
	else
	{
		$sql = "select Part_ID from part where Part_ID = ?";
		
		if($stmt = mysqli_prepare($connect, $sql))
		{
			mysqli_stmt_bind_param($stmt, "s", $param_id);
			$param_id = trim($_POST["part_id"]);
			
			if(mysqli_stmt_execute($stmt))
			{
				mysqli_stmt_store_result($stmt);
				
				if(mysqli_stmt_num_rows($stmt) == 1)
				{
					$id_check = "This ID had already taken.";
				}
				else
				{
					$id = trim($_POST["part_id"]);
				}
			}
			else
			{
				echo "Oops! Something went wrong. Please try again later.";
			}
			mysqli_stmt_close($stmt);
		}
	}
	
	/*validation for name*/
	if(empty(trim($_POST["part_name"])))
	{
		$name_check = "Please enter part name.";
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
	
	/*validation for price*/
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
	
	/*validation for category*/
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
	
	/*validation for image and assign a new name for uploaded image*/
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
	
	/*store into database*/
	if(empty($id_check) && empty($name_check) && empty($price_check) && empty($category_check) && empty($stock_check) && empty($image_check))
	{
		$details = $_POST["part_details"];
		$param_image = "upload/" . $image;
		mysqli_query($connect,"insert into part (Part_ID, Part_Name, Part_Details, Part_Price, Category_ID, Stock, image) values ('$id','$name', '$details', '$price', '$category', '$stock', '$param_image')");
		?>
			<script type="text/javascript">
				confirm = alert("<?php echo "$name is saved.";?>");
				window.location.href = "part_add.php?confirm=" + confirm;
			</script>
		<?php
	}
	else
	{
		?>
			<script>console.log("Something went wrong. Part cannot be saved.");</script>
		<?php
	}
}

/*back attribute*/
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

				<form class="addfrm" name="addfrm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
					<p class="<?php echo (!empty($id_check)) ? 'has-error' : ''; ?>">
						<label>ID:&nbsp;</label>
						<input type="text" name="part_id" value="<?php echo $id;?>"><br>
						<span id="part-id">&nbsp;<?php echo $id_check;?></span>
					</p>
					<p class="<?php echo (!empty($name_check)) ? 'has-error' : ''; ?>">
						<label>Name:&nbsp;</label>
						<input type="text" name="part_name" value="<?php echo $name;?>"><br>
						<span id="part-name">&nbsp;<?php echo $name_check;?></span>
					</p>
					<p>
						<label>Details:&nbsp;</label>
						<textarea cols="55" rows="4" name="part_details"></textarea>
						<br>
					</p>
					<p class="<?php echo (!empty($price_check)) ? 'has-error' : ''; ?>">
						<label>Price:&nbsp;</label>
						<input type="number" name="part_price" value="<?php echo $price;?>"><br>
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
								<option value="<?php echo $cate_row["Category_ID"];?>" <?php if($category == $cate_row["Category_ID"]) echo 'selected';?>>
									<?php echo $cate_row["Category_Name"];?>
								</option>
							<?php
							}
							?>
						</select><br>
						<span id="part-cate"><?php echo $category_check;?></span>
					</p>
					<p class="<?php echo (!empty($stock_check)) ? 'has-error' : ''; ?>">
						<label>Stock:&nbsp;</label>
						<input type="number" name="part_stock" value="<?php echo $stock;?>"><br>
						<span id="part-stock">&nbsp;<?php echo $stock_check;?></span>
					</p>
					<p class="<?php echo (!empty($image_check)) ? 'has-error' : ''; ?>">
						<label>Image:&nbsp;</label>
						<input type="file" name="part_img" accept="image/*" />
						<br><span id="part-pic" class="image">&nbsp;<?php echo $image_check;?></span>
					</p>
					
					<p>
						<input class="update-btn" type="submit" name="savebtn" value="Add Part">
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
