<?php 

//part.php
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
if(isset($_POST["Add_to_wish"]))
{
$Part_ID = $_POST['Part_ID'];
$check_sql = mysqli_query($connect,"SELECT * FROM part WHERE Part_ID = '$Part_ID'");

if(mysqli_num_rows($check_sql) == 0)
{
	$insert = mysqli_query($connect,"INSERT INTO wishlist (Part_ID,Customer_ID) VALUES ('$Part_ID','$id')");
	if($insert = true)
	{
		echo"<script>alert('Product is added to your wishlist!')</script>";
	}
	else
	{
		echo"<script>alert('error!')</script>";
	}
}
else
{
	echo"<script>alert('Product is already in your wishlist!')</script>";	
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--cart Css-->
<!-- menu js -->
<script src="js/menumaker.js"></script>
<!-- wow animation -->
<script src="js/wow.js"></script>
<!-- custom js -->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link href = "css/jquery-ui.css" rel = "stylesheet">
<!-- Custom CSS -->
<!-- basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- mobile metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<!-- site metas -->
<title>Show part</title>
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
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>
<body id="default_theme" class="it_shop_list">

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
				
				<a href="user_profile.php" class="btn white_btn" style="display: inline;"><b>Profile</b>&nbsp;&nbsp;<b class="tolltiptext"><?php echo $_SESSION["username"];?></b></a> 
				</div>
				</div>
				</div>";
			<?php				
			}
			?>
			
      </div>
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
              <h1 class="page-title">Shop Page</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

			   
    <!-- Page Content -->
<div class="section padding_layout_1 product_list_main">
    <div class="container">
      <div class="row">
	  <div class="col-md-9">
      <div class="row">
	  <div class="filter_data"></div>
      </div>
	  </div>

	  
	<div class="col-md-3">
    <div class="list-group">     				
	<h3>Price range</h3>
	<input type="hidden" id="hidden_minimum_price" value="0" />
	<input type="hidden" id="hidden_maximum_price" value="11000" />
	<p id="price_show">0 - 11000</p>
	<div id="price_range"></div>
	</div>	
	<br></br>
	<div class="list-group">
	    <h3>Category</h3>
		<div style="height: 180px; overflow-y: auto; overflow-x: hidden;">	
		<?php
	
		$query = "SELECT * FROM part INNER JOIN category ON part.Category_ID = category.Category_ID WHERE part.Part_isDelete = '0' AND category.Category_isDelete = '0' GROUP BY Category_Name ORDER BY category.Category_ID";
		$result = mysqli_query($connect, $query);
		foreach($result as $row)
		{

		?> 
		<div class="list-group-item checkbox">
		   <input type="checkbox" class="common_selector category" value="<?php echo $row['Category_Name'];?>" >&nbsp;&nbsp;<?php echo $row['Category_Name']; ?>
		</div>

		<?php
		}
		
		?>
				
	</div>
	</div>
	</div>
	</div>
	</div>




<script>
$(document).ready(function(){

    filter_data();

	
    function filter_data()
    {
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'fetch_data';
        var minimum_price = $('#hidden_minimum_price').val();
        var maximum_price = $('#hidden_maximum_price').val();
        var category = get_filter('category');

        $.ajax({
            url:"fetch_data.php",
            method:"POST",
            data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, category:category},
            success:function(data){
                $('.filter_data').html(data);
            }
        });
    }

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });

    $('#price_range').slider
	({
        range:true,
        min:0,
        max:11000,
        values:[0, 11000],
        step:25,
        stop:function(event, ui)
        {
            $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_price').val(ui.values[0]);
            $('#hidden_maximum_price').val(ui.values[1]);
            filter_data();
        }
    });
	
	});
	
</script>

</body>
</html>
