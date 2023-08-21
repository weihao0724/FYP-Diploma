<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../");
	exit;
}
ob_start();
require_once "../../php/connection.php";

$name = $desc = "";
$name_check = $desc_check = "";

if(isset($_POST["savebtn"])) 	
{
	if(empty(trim($_POST["cate_name"])))
	{
		$name_check = "This field cannot be empty.";
	}
	else
	{
		$sql = "select Category_ID from category where Category_Name = ?";

		if($stmt = mysqli_prepare($connect, $sql))
		{
			mysqli_stmt_bind_param($stmt, "s", $param_name);
			$param_name = trim($_POST["cate_name"]);

			if(mysqli_stmt_execute($stmt))
			{
				mysqli_stmt_store_result($stmt);

				if(mysqli_stmt_num_rows($stmt) == 1)
				{
					$name_check = "This category name had already register.";
				}
				else
				{
					$name = trim($_POST["cate_name"]);
				}
			}
			else
			{
				echo "Oops! Something went wrong. Please try again later.";
			}
			mysqli_stmt_close($stmt);
		}
	}

	if(empty($_POST["cate_desc"]))
	{
		$desc_check = "This field cannot be empty.";
	}
	else
	{
		$desc = $_POST["cate_desc"];
	}

	if(empty($desc_check) && empty($name_check))
	{
		
		mysqli_query($connect,"insert into category (Category_Name, Category_Desc) values ('$name','$desc')");
		?>
			<script type="text/javascript">
				confirm = alert("<?php echo "$name is saved";?>");
				window.location.href = "category_add.php?confirm=" + confirm;
			</script>
		<?php
	}
	else
	{
		?>
			<script>console.log("Something went wrong. Category cannot be saved.");</script>
		<?php
	}
}

if(isset($_POST["addback"]))
{
	header("Location: ../management_category.php");
}

if(isset($_GET["confirm"]))
{
	header("Location: ../management_category.php");
	exit();
}
?>

<html>
<head>
<meta charset="utf-8">
<title>JIT - Category Management</title>
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
			$_SESSION["directory"] = "category";
			$_SESSION["php"] = true;
			include("../admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>Category</h6>
			
<!--div for adding a new category-->			
			<div id="add-category" class="">
				<?php
					$find = mysqli_query($connect, "select * from category");	
					$count = mysqli_num_rows($find) + 1;
				?>

				<form class="addfrm" name="addfrm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<p>
						<label>ID:</label>
						<input type="text" name="cate_id" value="<?php echo $count;?>" disabled><br>
						<span id="id">*This part cannot be edited.</span>
					</p>
					<p class="<?php echo (!empty($name_check)) ? 'has-error' : ''; ?>">
						<label>Name:</label>
						<input type="text" name="cate_name" value="<?php echo $name;?>">
						<br><span class="cate-name">&nbsp;<?php echo $name_check;?></span>
					</p>
					<p>
						<label>Description:</label>
						<textarea cols="55" rows="4" name="cate_desc"><?php echo $desc;?></textarea>
						<br><span class="cate-desc">&nbsp;<?php echo $desc_check;?></span>
					</p>
					
					<p>
						<input type="submit" name="savebtn" value="Add Category">
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