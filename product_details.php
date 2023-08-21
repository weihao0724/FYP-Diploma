<?php 
session_start();

include('php/connection.php');
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
	$id = 0;
}
else
{
	$id = $_SESSION["id"];
}

$Part_ID = "";
$qty = "";
$total_price = "";

if (isset($_POST['Part_ID']) && $_POST['Part_ID']!="")
{
$Part_ID = $_POST['Part_ID'];
$qty = $_POST['qty'];
$total_price = $_POST['Part_Price'];

$check_sql = mysqli_query($connect,"SELECT * FROM cart WHERE Part_ID = '$Part_ID' AND Customer_ID = '$id' AND Payment_ID IS NULL");

if(mysqli_num_rows($check_sql) == 0)
{
	$insert = mysqli_query($connect,"INSERT INTO cart (Qty,total_price,Part_ID,Customer_ID) VALUES ('$qty', '$total_price', '$Part_ID','$id')");
	if($insert = true)
	{
		echo"<script>alert('Product is added to your cart!')</script>";
	}
	else
	{
		echo"<script>alert('error!')</script>";
	}
}
else
{
	echo"<script>alert('Product is already in your cart! You can change the quantity at your cart.')</script>";	
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- mobile metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<!-- site metas -->
<title>Part details</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<!-- site icons -->
<link rel="icon" href="images/JIT logo-light.png" type="image/gif" />
<!-- bootstrap css -->
<link rel="stylesheet" href="css/bootstrap.min.css" />
<!-- Site css -->
<link rel="stylesheet" href="css/style.css" />
<!-- responsive css -->
<link rel="stylesheet" href="css/responsive.css" />
<!-- colors css -->
<link rel="stylesheet" href="css/colors1.css" />
<!-- custom css -->
<link rel="stylesheet" href="css/custom.css" />
<!-- wow Animation css -->
<link rel="stylesheet" href="css/animate.css" />
<!-- zoom effect -->
<link rel='stylesheet' href='css/hizoom.css'>
<!-- end zoom effect -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>
<body id="default_theme" class="it_shop_detail">

<!-- header -->
<header id="default_header" class="header_style_1">
  <!-- header top -->
  <div class="header_top">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="full">
            <div class="topbar-left">
              <ul class="list-inline">
                <li> <span class="topbar-label"><i class="fa  fa-home"></i></span> <span class="topbar-hightlight">Jalan Ayer Keroh Lama, 75450 Bukit Beruang, Melaka</span> </li>
                <li> <span class="topbar-label"><i class="fa fa-envelope-o"></i></span> <span class="topbar-hightlight"><a href="mailto:justintechstore@gmail.com">justintechstore@gmail.com</a></span> </li>
              </ul>
            </div>
          </div>
        </div>

			<?php
		
			if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
			{

			?>
				<div class="col-md-4 right_section_header_top">
				<div class="float-right">
				<div class="make_appo">
				<a  href="Log_in.php" ><button class="btn white_btn"><b>Log in here</b></button></a> 
				</div>
				</div>
				</div>
		  <?php
			}
			
			else
			{
				

			?>
				<div class="col-md-4 right_section_header_top">
				<div class="float-right">
				<div class="make_appo">

				<a class="btn white_btn" href="Log_out.php" style="display: inline;"><b>Log out</b></a>
				
				<a href="user_profile.php" class="btn white_btn" style="display: inline;"><b>PROFILE</b>&nbsp;&nbsp;<b class="tolltiptext"><?php echo $_SESSION["username"];?></b></a> 
				</div>
				</div>
				</div>";
			<?php				
			}
			?>
			
      </div>
    </div>
  </div>
  <!-- end header top -->
  <!-- header bottom -->
  <div class="header_bottom">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
          <!-- logo start -->
          <div class="logo"> <a href="index.php"><img src="images/logos/JIT logo-light.png" alt="logo" /></a> </div>
          <!-- logo end -->
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
          <!-- menu start -->
          <div class="menu_side">
            <div id="navbar_menu">
			<ul class="first-ul">
			
				<?php
				
				$num = mysqli_query($connect,"SELECT * FROM cart WHERE Customer_ID = '$id' AND Payment_ID IS NULL");
				$cart_customize = mysqli_query($connect,"SELECT * FROM customise WHERE Customer_ID = '$id' AND Payment_ID IS NULL");
				$num_cart =  mysqli_num_rows($num);
				$num_customise = mysqli_num_rows($cart_customize);
				$cart_count = 0;
				
				$cart_count=$num_cart + $num_customise;
				if($cart_count!=0)
				{
					
				?>
			    <a href="cart.php"><img src="images/cart.png" style="width:50px;">Cart<span><?php echo $cart_count; ?></span></a>
			   <?php
				}
				?>
				
                <li> <a class="" href="index.php">Home</a></li>
				<li> <a class="" href="part.php">Shop</a></li>
				<li><a href="custom.php">Customize PC</a></li>
				
            </ul>
            </div>
          </div>
          <!-- menu end -->
        </div>
      </div>
    </div>
  </div>
  <!-- header bottom end -->
</header>
<!-- end header -->
<!-- inner page banner -->
<div id="inner_banner" class="section inner_banner_section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="title-holder">
            <div class="title-holder-cell text-left">
              <h1 class="page-title">Shop Detail</h1>
              <ol class="breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li class="active">Shop Detail</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end inner page banner -->
<?php
    if(isset($_GET['view']))
    {
        $pid=$_GET["pid"];
		$result = mysqli_query($connect,"SELECT * FROM part  WHERE Part_ID = '$pid'");
	    $row = mysqli_fetch_assoc($result);
		
?>
<!-- section -->
<div class="section padding_layout_1 product_detail">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="row">
          <div class="col-xl-6 col-lg-12 col-md-12">
            <div class="product_detail_feature_img hizoom hi2">
              <div class='hizoom hi2'> <img src="<?php echo $row["image"]; ?>" alt="#" /> </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-12 col-md-12 product_detail_side detail_style1">
            <div class="product-heading">
              <h2><?php echo $row["Part_Name"]; ?></h2>
            </div>
           <div class="product-detail-side"><span class="new-price"><?php echo "RM".number_format( $row ["Part_Price"],2); ?></span> </div>
            <div class="detail-contant">
          <?php
			$mark=explode(',',$row['Part_Details']);
			foreach ($mark as $out)
			{
				echo "<h5>$out</h5><br></br>";
			}
			?>
              <form method="post" action="">
				<input type="hidden" name="Part_ID" value="<?php echo $row['Part_ID']; ?>"/>
				<input type="hidden" name="Part_Price" value="<?php echo $row['Part_Price']; ?>"/>
				<input type="hidden" name="qty" value="1"/>
            <?php
				if($row["Stock"] != 0)
				{
				if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
				{
			?>
				<a href="Log_in.php" class="btn sqaure_bt">Add to cart</a>
			<?php
				}
				else
				{
			?>
				<button type="submit" class="btn sqaure_bt">Add to cart</button>
			<?php
				}
				}
				else
				{
			?>
			<button type="submit" disabled class="btn sqaure_bt">Out of Stock</button>
			<?php
				}
			?>
              </form>
			  <a href="Part.php"><button class="btn sqaure_bt">Back to Shop</button><a>
            </div>
          </div>
        </div>
<?php		
	}
?>
       
      </div>

      </div>
    </div>
  </div>

<!-- end section -->
<!-- section -->

<!-- end footer -->
<!-- js section -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- menu js -->
<script src="js/menumaker.js"></script>
<!-- wow animation -->
<script src="js/wow.js"></script>
<!-- custom js -->
<script src="js/custom.js"></script>

<!-- google map js -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8eaHt9Dh5H57Zh0xVTqxVdBFCvFMqFjQ&callback=initMap"></script>
<!-- end google map js -->
<!-- zoom effect -->
<script src='js/hizoom.js'></script>
<script>
        $('.hi1').hiZoom({
            width: 300,
            position: 'right'
        });
        $('.hi2').hiZoom({
            width: 400,
            position: 'right'
        });
    </script>
</body>
</html>
