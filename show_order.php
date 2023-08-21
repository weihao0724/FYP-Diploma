<?php

//home.php

include('php/connection.php');
include('php/header.php');


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
$id = 0;
}
else
{
$id = $_SESSION["id"];
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
<title>Profile</title>
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
<!-- revolution slider css -->
<link rel="stylesheet" type="text/css" href="revolution/css/settings.css" />
<link rel="stylesheet" type="text/css" href="revolution/css/layers.css" />
<link rel="stylesheet" type="text/css" href="revolution/css/navigation.css" />

</head>
<body id="default_theme" class="it_service">

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
<a class="btn white_btn" href="Log_out.php" style=""><b>Log out</b></a>

<a href="user_profile.php" class="btn white_btn" style=""><b class="tolltiptext"><?php echo $_SESSION["username"];?></b></a> 
</div>
</div>
</div>
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
<h1 class="page-title">View order</h1>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="row" style="margin-top:25%;">
<div class="col-md-12">
<div class="full">
<div class="main_heading text_align_center">
<h2>View your order here</h2>
<p>Click on details for more information</p>
</div>
</div>
</div>
</div>

<div class="full margin_bottom_30">
<div class="accordion border_circle">
<div class="bs-example">
<?php
$find_pid = mysqli_query($connect,"SELECT * FROM payment where Customer_ID = '$id' ORDER BY Payment_ID DESC ");

if(mysqli_num_rows($find_pid) > 0)
{
?>


<div class="row" style="width:75%; margin-left:19%;">
<div class="col-sm-12 col-md-12">
<div class="product-table">
<table class="table">
<thead>
<tr>
<th class="text-center" style="color:black;"><b>Payment Date</b></th>
<th class="text-center" style="color:black;"><b>Amount</b></th>
<th class="text-center" style="color:black;"><b>Shipping Number</b></th>
<th class="text-center" style="color:black;"><b>Check Details</b></th>
</tr>
</thead>
<tbody>
<?php
while($pay_id =  mysqli_fetch_assoc($find_pid))
{
$paid = $pay_id['Payment_ID'];		
?>
<tr>
<td>
<p class="text-center" style="font-size:125%; margin-top:10%"><?php echo $pay_id['Payment_Date']; ?></p>
</td>
<td>
<p class="text-center" style="font-size:125%; margin-top:10%">RM <?php echo $pay_id['amount']; ?></p>
</td>
<td>
<p class="text-center" style="font-size:125%; margin-top:10%"><?php echo $pay_id['shipping_no']; ?></p>
</td>
<td>
<a href="order_details.php?view&p_id=<?php echo $paid; ?>"><button class="btn sqaure_bt light_theme_bt" style="margin-left:25%;">Details</button></a> 
</td>
</tr>
<?php

}

?>
</tbody>
</table>
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
</div>
</div>
</div>
</div>
</div>



<!-- section -->
<!-- end section -->
<!-- section -->
<!-- end section -->
<!-- section -->
<!-- End Model search bar -->
<!-- footer -->
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
