<?php
include('php/connection.php');
session_start();
error_reporting(0);

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
	$id = 0;
}
else
{
	$id = $_SESSION["id"];
}

$result= mysqli_query($connect, "SELECT * FROM customer WHERE Customer_ID='$id'");
if(mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
	{
		$email = $row["Customer_Email"];
		$shipping_address = $row["Customer_Address"];
	}
}



$total_price = 0;

$item_details = '';

$order_details = '
<div class="table-responsive" id="order_table">
 <table class="table table-bordered table-striped">
  <tr>  
	<th>Product Name</th>  
	<th>Quantity</th>  
	<th>Price</th>  
	<th>Total</th>  
  </tr>
';

$result = mysqli_query($connect,"SELECT * FROM cart WHERE Customer_ID = $id AND Payment_ID IS NULL");
$result1 = mysqli_query($connect,"SELECT * FROM customise WHERE Customer_ID = $id AND Payment_ID IS NULL");


 while($result_cart = mysqli_fetch_assoc($result))
 {
	 
	$prod_cod = $result_cart["Part_ID"];
	$pc_cod = $result_cart["PC_ID"];
	$find_part = mysqli_query($connect,"SELECT * FROM part WHERE Part_ID = '$prod_cod'");
	$find_pc = mysqli_query($connect,"SELECT * FROM pc WHERE PC_ID = '$pc_cod'");
	
	while($row = mysqli_fetch_assoc($find_part))
	{
  $order_details .= '
  <tr>
   <td>'.$row["Part_Name"].'</td>
   <td>'.$result_cart["Qty"].'</td>
   <td align="right">RM '.$row["Part_Price"].'</td>
   <td align="right">RM '.number_format($result_cart["Qty"] * $row["Part_Price"], 2).'</td>
  </tr>
  ';
  $total_price = $total_price + ($result_cart["Qty"] * $row["Part_Price"]);

  $item_details .= $row["Part_Name"] . ', ';
 }
 
 while($row_pc = mysqli_fetch_assoc($find_pc))
	{
  $order_details .= '
  <tr>
   <td>'.$row_pc["PC_Name"].'</td>
   <td>'.$result_cart["Qty"].'</td>
   <td align="right">RM '.$row_pc["PC_Price"].'</td>
   <td align="right">RM '.number_format($result_cart["Qty"] * $row_pc["PC_Price"], 2).'</td>
  </tr>
  ';
  $total_price = $total_price + ($result_cart["Qty"] * $row_pc["PC_Price"]);

  $item_details .= $row_pc["PC_Name"] . ', ';
 }
 }
	 $totalcus=0;
while($result_cuscart = mysqli_fetch_assoc($result1))
 {
	
	$cus_cod = $result_cuscart["customiseid"];
	$find_cus = mysqli_query($connect,"SELECT * FROM customise WHERE customiseid = '$cus_cod'");
	while($row1 = mysqli_fetch_assoc($find_cus))
	{
	 $psuid=$row1['psuid'];
	 $pccaseid=$row1['pccaseid'];
	 $hhdida=$row1['hhdid'];
	 $ssdid=$row1['ssdid'];
	 $ramid=$row1['ramid'];
	 $gpuid=$row1['gpuid'];
	 $cpuid=$row1['cpuid'];
	 $moboid=$row1['moboid'];
	 $query_psu=mysqli_query($connect,"SELECT * from part where Part_ID='$psuid'");
     $query_pccase=mysqli_query($connect,"SELECT * from part where Part_ID='$pccaseid'");
     $query_hhd=mysqli_query($connect,"SELECT * from part where Part_ID='$hhdida'");
     $query_ssd=mysqli_query($connect,"SELECT * from part where Part_ID='$ssdid'");
     $query_ram=mysqli_query($connect,"SELECT * from part where Part_ID='$ramid'");
     $query_gpu=mysqli_query($connect,"SELECT * from part where Part_ID='$gpuid'");
     $query_cpu=mysqli_query($connect,"SELECT * from part where Part_ID='$cpuid'");
     $query_mobo=mysqli_query($connect,"SELECT * from part where Part_ID='$moboid'");
	 $rowpsu=mysqli_fetch_assoc($query_psu);
     $rowpc=mysqli_fetch_assoc($query_pccase);
     $rowhhd=mysqli_fetch_assoc($query_hhd);
     $rowssd=mysqli_fetch_assoc($query_ssd);
     $rowram=mysqli_fetch_assoc($query_ram);
     $rowgpu=mysqli_fetch_assoc($query_gpu);
     $rowmobo=mysqli_fetch_assoc($query_mobo);
     $rowcpu=mysqli_fetch_assoc($query_cpu);
	 $minus1=1;
	 $psuqty=$rowpsu['Stock']-$minus1;
	 $pcqty=$rowpc['Stock']-$minus1;
	 $hhdqty=$rowhhd['Stock']-$minus1;
	 $ssdqty=$rowssd['Stock']-$minus1;
	 $ramqty=$rowram['Stock']-$minus1;
	 $gpuqty=$rowgpu['Stock']-$minus1;
	 $moboqty=$rowmobo['Stock']-$minus1;
	 $cpuqty=$rowcpu['Stock']-$minus1;
	 $totalcus+=$row1["total"];  
  	 $order_details .= '
  <tr>
   <td>'."<b>Custom PC Package</b>".'</td>
   <td>'."<b>1</b>".'</td>
   <td align="right">RM '.number_format($row1["total"], 2).'</td>
   <td align="right">RM '.number_format($row1["total"], 2).'</td>
  </tr>
  ';
 }
 }
 $item_details = substr($item_details, 0, -2);
$total_price = $total_price +$totalcus;
 $order_details .= '
 <tr>  
        <td colspan="3" align="right">Total</td>  
        <td align="right">RM '.number_format($total_price, 2).'</td>
    </tr>
 ';

$customer_name  = $address  = $card_holder_number = $card_expiry_month = $card_expiry_year = $card_cvc = "";
$customer_name_err = $shipping_address_err  = $card_holder_number_err = $card_expiry_month_err = $card_expiry_year_err = $card_cvc_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty($_POST["customer_name"]))
	{
		$customer_name_err = "Please enter a name.";
	}
	if (!preg_match("/^[a-zA-Z-' ]*$/",(trim($_POST["customer_name"])))) 
	{
		$customer_name_err = "Only letters and white space allowed";
	}
	else
	{
		$customer_name = $_POST["customer_name"];
	}
	
	if(empty(trim($_POST["shipping_address"])))
	{
		$shipping_address_err = "Please enter your shipping address.";
	}
	else
	{
		$shipping_address = $_POST["shipping_address"];
	}
	
	
	global $type;

    $cardtype = array
	(
        "Visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "Mastercard" => "/^5[1-5][0-9]{14}$/",
    );
	
	if(empty(trim($_POST["card_holder_number"])))
	{
		$card_holder_number_err = "Please enter your card number.";
	}
	else
	{
		
		if(preg_match($cardtype['Visa'],(trim($_POST["card_holder_number"]))) ) 
		{
			$type= "Visa";
			$card_holder_number = $_POST["card_holder_number"];
		}
		else if(preg_match($cardtype['Mastercard'],(trim($_POST["card_holder_number"]))) ) 
		{
			$type= "Mastercard";
			$card_holder_number = $_POST["card_holder_number"];
		}
		else
		{
			$card_holder_number_err = "Please enter a valid card number.";
		}
	
	}
	
	if(empty(trim($_POST["card_expiry_month"])))
	{
		$card_expiry_month_err = "Please enter your card expiry month.";

	}
	if (!preg_match("/^01|02|03|04|05|06|07|08|09|10|11|12$/",(trim($_POST["card_expiry_month"])))) 
	{
		$card_expiry_month_err = "Please enter a valid card expiry month.";
	}
	else
	{
		$card_expiry_month = $_POST["card_expiry_month"];
	}
	
	if(empty(trim($_POST["card_expiry_year"])))
	{
		$card_expiry_year_err = "Please enter your card expiry year.";
	}
	if (!preg_match("/^2021|2022|2023|2024|2025$/",(trim($_POST["card_expiry_year"])))) 
	{
		$card_expiry_year_err = "Please enter a valid card expiry year.";
	}
	else
	{

		$card_expiry_year = $_POST["card_expiry_year"];
	}
	
	if(empty(trim($_POST["card_cvc"])))
	{
		$card_cvc_err = "Please enter your cvc.";
	}
	if (!preg_match("/^[0-9]{3,3}$/",(trim($_POST["card_cvc"])))) 
	{
		$card_cvc_err = "Please enter a valid cvc";
	}
	else
	{
		$card_cvc = $_POST["card_cvc"];
	}
	
	$order_number = rand(100000,999999);
	
	$total = $_POST["total_amount"];
	
	$card = $_POST["card_holder_number"];
	
	$card_sql = mysqli_query($connect,"SELECT * FROM credit_card WHERE card_number = $card");
	$row_card = mysqli_fetch_assoc($card_sql);
	if(mysqli_num_rows($card_sql) == 1)
	{
	
		$card_number = $row_card["card_number"];
		$cvv = $row_card["card_cvv"];
		$month = $row_card["card_expiry_month"];
		$year = $row_card["card_expiry_year"];
			
		if($card_cvc != $cvv)
		{
			$card_cvc_err = "Card cvv is invalid.";
		}
		if($card_expiry_month != $month)
		{
			$card_expiry_month_err = "card expiry month is invalid.";
		}
		if($card_expiry_year != $year)
		{
			$card_expiry_year_err = "card expiry year is invalid.";
		}
		
	}
	else
	{
		$card_holder_number_err = "This card number is invalid.";
	}
			
	
	
	if(empty($customer_name_err) && empty($shipping_address_err) && empty($card_holder_number_err) && empty($card_expiry_month_err) && empty($card_expiry_year_err) && empty($card_cvc_err))
	{
		$date = date("Y:m:d");
		
		$find = mysqli_query($connect,"SELECT * FROM cart WHERE Customer_ID = $id AND Payment_ID IS NULL");
		while($find_qty = mysqli_fetch_assoc($find))
		{	
		$p_id = $find_qty["Part_ID"];
		$pc_id = $find_qty["PC_ID"];
		$check_part = mysqli_query($connect,"SELECT * FROM part WHERE Part_ID = '$p_id'");
		$check_pc = mysqli_query($connect,"SELECT * FROM pc WHERE PC_ID = '$pc_id'");
		while($find_stock = mysqli_fetch_assoc($check_part))
		{
				$minus_stock = 0;
				$pre_qty = $find_qty["Qty"];			
				$pre_stock = $find_stock["Stock"];	
				$minus_stock = $pre_stock - $pre_qty;
				mysqli_query($connect,"Update part SET Stock = '$minus_stock' WHERE Part_ID = '$p_id'");
		}
		while($find_stock_pc = mysqli_fetch_assoc($check_pc))
		{
				$minus_stock_pc = 0;
				$pre_qty_pc = $find_qty["Qty"];			
				$pre_stock_pc = $find_stock_pc["Stock"];	
				$minus_stock_pc = $pre_stock_pc - $pre_qty_pc;
				mysqli_query($connect,"Update pc SET Stock = '$minus_stock_pc' WHERE PC_ID = '$pc_id'");
		}
		}
	 $query_psu=mysqli_query($connect,"update part set Stock =$psuqty where Part_ID='$psuid'");
     $query_pccase=mysqli_query($connect,"update part set Stock =$pcqty where Part_ID='$pccaseid'");
     $query_hhd=mysqli_query($connect,"update part set Stock =$hhdqty where Part_ID='$hhdida'");
     $query_ssd=mysqli_query($connect,"update part set Stock =$ssdqty where Part_ID='$ssdid'");
     $query_ram=mysqli_query($connect,"update part set Stock =$ramqty where Part_ID='$ramid'");
     $query_gpu=mysqli_query($connect,"update part set Stock =$gpuqty where Part_ID='$gpuid'");
     $query_cpu=mysqli_query($connect,"update part set Stock =$cpuqty where Part_ID='$cpuid'");
     $query_mobo=mysqli_query($connect,"update part set Stock =$moboqty where Part_ID='$moboid'");
		
		$addquery = mysqli_query($connect,"SELECT * FROM  customise where Customer_ID ='$id' and customiseid='$cus_cod'");
		while($rowsadd = mysqli_fetch_array($addquery)) 
		{
		$mark=explode(',',$rowsadd['addonid']);//what will do here
		foreach($mark as $out) 
		{
			$addqty=0;
			$queryadd=mysqli_query($connect,"select * from part where Part_ID='$out'");
			$rowsaddon=mysqli_fetch_assoc($queryadd);
			$addqty=$rowsaddon['Stock'] -$minus1;
			$query_addon=mysqli_query($connect,"update part set Stock =$addqty where Part_ID ='$out'");
		}
		
		}
		
		mysqli_query($connect,"INSERT INTO payment (Customer_ID, amount, Address, 
		Payment_method, Payment_Date, order_number, card_cvc, card_expiry_month, card_expiry_year, card_holder_number, customer_name) 
		VALUES ('$id', '$total', '$shipping_address', '$type', '$date', '$order_number', '$card_holder_number', '$customer_name')");
		
		
		$find_payment_id = mysqli_query($connect,"SELECT * FROM `payment` order by Payment_ID desc limit 1");
		$pay_id = mysqli_fetch_assoc($find_payment_id); 
		$paid_id = $pay_id["Payment_ID"];
		
		mysqli_query($connect,"Update cart SET Payment_ID = '$paid_id' WHERE Customer_ID = '$id' AND Payment_ID IS NULL");
		mysqli_query($connect,"Update customise SET Payment_ID = '$paid_id' WHERE Customer_ID = '$id' AND Payment_ID IS NULL");
		
		$_SESSION['success_message'] = $order_number;
		
		header('Location: index.php');
		exit;

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
<title>It.Next - IT Service Responsive Html Theme</title>
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
<body id="default_theme" class="it_serv_shopping_cart it_checkout checkout_page">
<!-- loader -->

<!-- end loader -->
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
				$id = $_SESSION["id"];
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
  <!-- end header top -->
  <!-- header bottom -->
  <div class="header_bottom">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
          <!-- logo start -->
          <div class="logo"> <a href="main.html"><img src="images/logos/JIT logo-light.png" alt="logo" /></a> </div>
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
              <h1 class="page-title">Checkout</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end inner page banner -->
<div class="section padding_layout_1 checkout_section">
  <div class="container">
  <span class="payment-errors"></span>
    <div class="row">
      <div class="col-sm-12">
        <div class="full">
          <div id="cupon" class="collapse">
            <div class="coupen-form">
              <form action="#">
                <fieldset>
                <div class="row">
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <input class="input-text" name="coupon" placeholder="Coupon code" id="coupon" required="" type="text">
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <button class="bt_main">Redeem</button>
                  </div>
                </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
	<!--form payment-->
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="row">
      <div class="col-md-8">
        <div class="checkout-form">
          
 
            <div class="row">
              <div class="col-md-6">
                <div class="form-field">
				<div class="form-group ">
                  <label>Card Holder Name<span class="text-danger">*</span></label>
                  <input type="text" name="customer_name" id="customer_name" class="form-control" value="<?php echo $customer_name; ?>" />
				  <span class="help-block"><?php echo $customer_name_err; ?></span>
                </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-field">
				<div class="form-group">
                  <label>Email Address<span class="text-danger">*</span></label>
                  <input type="email" disabled name="email_address" id="email_address" class="form-control" value="<?php echo $email; ?>" />
                </div>
                </div>
              </div>
			  
              <div class="col-md-12">
                <div class="form-field">
				<div class="form-group">
                  <label>Shipping address<span class="text-danger">*</span></label>
                  <input name="shipping_address" id="shipping_address" class="form-control" value="<?php echo $shipping_address; ?>"/>
				  <span class="help-block"><?php echo $shipping_address_err; ?></span>
                </div>
                </div>
              </div>
			  
            </div>

        </div>
      </div>
      <div class="col-md-4">
        <div class="">
		<table>
		<tbody>
			<?php
			echo $order_details;
			?>
		</tbody>
		</table>
        </div>
      </div>

      <div class="col-sm-12">
        <div class="payment-form">
          <div class="col-xs-12 col-md-12">
            <!-- CREDIT CARD FORM STARTS HERE -->
            <div class="panel panel-default credit-card-box">
              <div class="panel-heading display-table">
                <div class="display-tr">
                  <h3 class="panel-title display-td">Payment Details</h3>
                  <div class="display-td"> <img class="img-responsive pull-right" src="images/accepted.png" style="width:120px;"> </div>
                </div>
              </div>
              <div class="panel-body">
                
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-field">
					  <div class="form-field cardNumber">
					  <div class="form-group">
                        <label>Card Number<span class="text-danger">*</span></label>
                        <input type="text" name="card_holder_number" id="card_holder_number" class="form-control" placeholder="" maxlength="20" value="<?php echo $card_holder_number; ?>"/>
						<span class="help-block"><?php echo $card_holder_number_err; ?></span>	  
						</div>
						</div>
                      </div>
                    </div>
                  </div>
				  
				  <br/>
				  <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12 col-md-7">
                      <div class="form-field">
                        <label>Expiry Month<span class="text-danger">*</span></label>
                        <input type="text" name="card_expiry_month" id="card_expiry_month" class="form-control" placeholder="MM" maxlength="2" value="<?php echo $card_expiry_month; ?>"/>
						<span class="help-block"><?php echo $card_expiry_month_err; ?></span>
                      </div>
                    </div>
                    </div>
					<br/>
					
					<div class="row">
                    <div class="col-xs-12 col-md-7">
                      <div class="form-field">
                        <label>Expiry Year<span class="text-danger">*</span></label>
                        <input type="text" name="card_expiry_year" id="card_expiry_year" class="form-control" placeholder="YYYY" maxlength="4" value="<?php echo $card_expiry_year; ?>"/>
						<span class="help-block"><?php echo $card_expiry_year_err; ?></span>
                      </div>
                    </div>
                  </div>
				  
				  <br/>
                  <div class="row">
                    <div class="col-md-12 col-md-7">
                      <div class="form-field">
                        <label>CVV<span class="text-danger">*</span></label>
                        <input type="text" name="card_cvc" id="card_cvc" class="form-control" placeholder="123" maxlength="4"/>
						<span class="help-block"><?php echo $card_cvc_err; ?></span>
                      </div>
                    </div>
                  </div>
				  
                  <div class="row">
                    <div class="col-md-12 payment-bt">
                      <div class="center">
					<input type="hidden" name="total_amount" value="<?php echo $total_price; ?>" />
					<input type="hidden" name="currency_code" value="MYR" />
					<input type="hidden" name="item_details" value="<?php echo $item_details; ?>" />
					<button type="submit" name="submit" class="btn_main btn-success btn-sm">Pay Now</button>
                      </div>
                    </div>
                  </div>
				  </div>
               
              </div>
            </div>
            <!-- CREDIT CARD FORM ENDS HERE -->
          </div>
        </div>
      </div>
	   <!--form payment end-->
    </div>
	</form>
  </div>
</div>
<!-- section -->

<!-- end section -->

<!-- section lib-->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/slick/slick.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://js.stripe.com/v2/"></script>
<script src="js/jquery.creditCardValidator.js"></script>

<!-- end section -->
<!-- section -->

<!-- end section -->
<!-- Modal -->

<!-- End Model search bar -->
<!-- footer -->
<!-- end footer -->
<!-- js section --> 
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


