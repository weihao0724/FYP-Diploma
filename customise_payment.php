<?php
include('php/PDO.php');
session_start();

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

if(!empty($_SESSION["shopping_cart"]))
{
 foreach($_SESSION["shopping_cart"] as $keys => $value)
 {
  $order_details .= '
  <tr>
   <td>'.$value["Part_Name"].'</td>
   <td>'.$value["quantity"].'</td>
   <td align="right">RM '.$value["Part_Price"].'</td>
   <td align="right">RM '.number_format($value["quantity"] * $value["Part_Price"], 2).'</td>
  </tr>
  ';
  $total_price = $total_price + ($value["quantity"] * $value["Part_Price"]);

  $item_details .= $value["Part_Name"] . ', ';
 }
 $item_details = substr($item_details, 0, -2);
 $order_details .= '
 <tr>  
        <td colspan="3" align="right">Total</td>  
        <td align="right">RM '.number_format($total_price, 2).'</td>
    </tr>
 ';
}
$order_details .= '</table>';

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
<link rel="icon" href="images/fevicon/fevicon.png" type="image/gif" />
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
				echo  "  
				<div class='col-md-4 right_section_header_top'>
				<div class='float-right'>
				<div class='make_appo'>
				<a class='btn white_btn' href='Log_in.php' style='display: inline;'><b>Log in here</b></a> 
				</div>
				</div>
				</div>
				";
			}
			else
			{
				echo "
				<div class='col-md-4 right_section_header_top'>
				<div class='float-right'>
				<div class='make_appo'>

				<a class='btn white_btn' href='Log_out.php' style='display: inline;'><b>Log out</b></a>
				
				<a href='profile.php?action=view' class='btn white_btn' style='display: inline;'><b>PROFILE</b>&nbsp;&nbsp;<b class='tolltiptext'>".$_SESSION["username"]."</b></a> 
				</div>
				</div>
				</div>";				

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
				if(!empty($_SESSION["shopping_cart"])) 
				{
				$cart_count = count(array_keys($_SESSION["shopping_cart"]));
				?>
			    <li><a href="cart.php"><img src="images/cart.png" style="width:50px;">Cart<span><?php echo $cart_count; ?></span></a></li>
			   <?php
				}
				?>
				
                <li> <a class="" href="index.php">Home</a>
                  <ul>
                    <li><a href="it_home.html">It Home Page</a></li>
                    <li><a href="it_home_dark.html">It Dark Home Page</a></li>
                  </ul>
                </li>
				
                <li><a href="it_about.html">About Us</a></li>
                <li> <a href="it_service.html">Service</a>
                  <ul>
                    <li><a href="it_service_list.html">Services list</a></li>
                    <li><a href="it_service_detail.html">Services Detail</a></li>
                  </ul>
                </li>
			
				
                <li> <a class="" href="part.php">Shop</a>
                  <ul>
                    <li><a href="it_shop.html">Shop List</a></li>
                    <li><a href="it_shop_detail.html">Shop Detail</a></li>
                    <li><a href="it_cart.html">Shopping Cart</a></li>
                    <li><a href="it_checkout.html">Checkout</a></li>
                  </ul>
                </li>
				
                <li> <a href="it_contact.html">Contact</a>
                  <ul>
                    <li><a href="it_contact.html">Contact Page 1</a></li>
                    <li><a href="it_contact_2.html">Contact Page 2</a></li>
                  </ul>
                </li>
				
            </ul>
            </div>
            <div class="search_icon">
              <ul>
                <li><a href="#" data-toggle="modal" data-target="#search_bar"><i class="fa fa-search" aria-hidden="true"></i></a></li>
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
              <ol class="breadcrumb">
                <li><a href="cart.php">Cart</a></li>
                <li class="active">Checkout</li>
              </ol>
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
          <div id="login" class="collapse">
          </div>
          <div class="tab-info coupon-section">
            <p>Have a coupon? <a href="#cupon" class="" data-toggle="collapse">Click here to enter your code</a></p>
          </div>
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
	<form method="post" id="order_process_form" action="payment.php">
    <div class="row">
      <div class="col-md-8">
        <div class="checkout-form">
          
 
            <div class="row">
              <div class="col-md-6">
                <div class="form-field">
				<div class="form-group">
                  <label>Card Holder Name<span class="text-danger">*</span></label>
                  <input type="text" name="customer_name" id="customer_name" class="form-control" value="" />
					<span id="error_customer_name" class="text-danger"></span>
                </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-field">
				<div class="form-group">
                  <label>Email Address<span class="text-danger">*</span></label>
                  <input type="text" name="email_address" id="email_address" class="form-control" value="" />
            <span id="error_email_address" class="text-danger"></span>
                </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-field">
				<div class="form-group">
                  <label>Country</label>
                  <input type="text" name="customer_country" id="customer_country" class="form-control" />
              <span id="error_customer_country" class="text-danger"></span>
                </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-field">
				<div class="form-group">
                  <label>Address <span class="text-danger">*</span></label>
                  <textarea name="customer_address" id="customer_address" class="form-control"></textarea>
            <span id="error_customer_address" class="text-danger"></span>
                </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-field">
				<div class="form-group">
                  <label>Town / City <span class="text-danger">*</span></label>
                  <input type="text" name="customer_city" id="customer_city" class="form-control" value="" />
              <span id="error_customer_city" class="text-danger"></span>
                </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-field">
				<div class="form-group">
                  <label>State<span class="text-danger">*</span></label>
                  <input type="text" name="customer_state" id="customer_state" class="form-control" value="" />
                </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-field">
				<div class="form-group">
                  <label>Postcode / ZIP <span class="text-danger">*</span></label>
                  <input type="text" name="customer_pin" id="customer_pin" class="form-control" value="" />
              <span id="error_customer_pin" class="text-danger"></span>
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
                  <div class="display-td"> <img class="img-responsive pull-right" src="images/it_service/accepted.png" alt="#"> </div>
                </div>
              </div>
              <div class="panel-body">
                
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-field">
					  <div class="form-field cardNumber">
					  <div class="form-group">
                        <label>Card Number<span class="text-danger">*</span></label>
                        <input type="text" name="card_holder_number" id="card_holder_number" class="form-control" placeholder="1234 5678 9012 3456" maxlength="20" onkeypress="" />
						<span id="error_card_number" class="text-danger"></span>	  
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
                        <input type="text" name="card_expiry_month" id="card_expiry_month" class="form-control" placeholder="MM" maxlength="2" onkeypress="return only_number(event);" />
                   <span id="error_card_expiry_month" class="text-danger"></span>
                      </div>
                    </div>
                    </div>
					<br/>
					
					<div class="row">
                    <div class="col-xs-12 col-md-7">
                      <div class="form-field">
                        <label>Expiry Year<span class="text-danger">*</span></label>
                        <input type="text" name="card_expiry_year" id="card_expiry_year" class="form-control" placeholder="YYYY" maxlength="4" onkeypress="return only_number(event);" />
                   <span id="error_card_expiry_year" class="text-danger"></span>
                      </div>
                    </div>
                  </div>
				  <br/>
                  <div class="row">
                    <div class="col-md-12 col-md-7">
                      <div class="form-field">
                        <label>CVC<span class="text-danger">*</span></label>
                        <input type="text" name="card_cvc" id="card_cvc" class="form-control" placeholder="123" maxlength="4" onkeypress="return only_number(event);" />
                   <span id="error_card_cvc" class="text-danger"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 payment-bt">
                      <div class="center">
					  <input type="hidden" name="total_amount" value="<?php echo $total_price; ?>" />
					<input type="hidden" name="currency_code" value="MYR" />
					<input type="hidden" name="item_details" value="<?php echo $item_details; ?>" />
					<input type="button" name="button_action" id="button_action" class="btn_main btn-success btn-sm" onClick="stripePay(event)" value="Pay Now" />
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
<script>

function validate_form()
{
 var valid_card = 0;
 var valid = true;
 var card_cvc = $('#card_cvc').val();
 var card_expiry_month = $('#card_expiry_month').val();
 var card_expiry_year = $('#card_expiry_year').val();
 var card_holder_number = $('#card_holder_number').val();
 var email_address = $('#email_address').val();
 var customer_name = $('#customer_name').val();
 var customer_address = $('#customer_address').val();
 var customer_city = $('#customer_city').val();
 var customer_pin = $('#customer_pin').val();
 var customer_country = $('#customer_country').val();
 var name_expression = /^[a-z ,.'-]+$/i;
 var email_expression = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/;
 var month_expression = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
 var year_expression = /^2017|2018|2019|2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
 var cvv_expression = /^[0-9]{3,3}$/;

 $('#card_holder_number').validateCreditCard(function(result){
  if(result.valid)
  {
   $('#card_holder_number').removeClass('require');
   $('#error_card_number').text('');
   valid = true;
  }
  else
  {
   $('#card_holder_number').addClass('require');
   $('#error_card_number').text('Invalid Card Number');
   valid = false;
  }
 });

 if(!name_expression.test(customer_name))
 {
  $('#customer_name').addClass('require');
  $('#error_customer_name').text('Invalid Name');
  valid = false;
 }
 else
 {
  $('#customer_name').removeClass('require');
  $('#error_customer_name').text('');
  valid = true;
 }

 if(!email_expression.test(email_address))
 {
  $('#email_address').addClass('require');
  $('#error_email_address').text('Invalid Email Address');
  valid = false;
 }
 else
 {
  $('#email_address').removeClass('require');
  $('#error_email_address').text('');
  valid = true;
 }

 if(customer_address == '')
 {
  $('#customer_address').addClass('require');
  $('#error_customer_address').text('Enter Address Detail');
  valid = false;
 }
 else
 {
  $('#customer_address').removeClass('require');
  $('#error_customer_address').text('');
  valid = true;
 }

 if(customer_city == '')
 {
  $('#customer_city').addClass('require');
  $('#error_customer_city').text('Enter City');
  valid = false;
 }
 else
 {
  $('#customer_city').removeClass('require');
  $('#error_customer_city').text('');
  valid = true;
 }

 if(customer_pin == '')
 {
  $('#customer_pin').addClass('require');
  $('#error_customer_pin').text('Enter Zip code');
  valid = false;
 }
 else
 {
  $('#customer_pin').removeClass('require');
  $('#error_customer_pin').text('');
  valid = true;
 }

 if(customer_country == '')
 {
  $('#customer_country').addClass('require');
  $('#error_customer_country').text('Enter Country Detail');
  valid = false;
 }
 else
 {
  $('#customer_country').removeClass('require');
  $('#error_customer_country').text('');
  valid = true;
 }

 if(!month_expression.test(card_expiry_month))
 {
  $('#card_expiry_month').addClass('require');
  $('#error_card_expiry_month').text('Invalid Data');
  valid = false;
 }
 else
 { 
  $('#card_expiry_month').removeClass('require');
  $('#error_card_expiry_month').text('');
  valid = true;
 }

 if(!year_expression.test(card_expiry_year))
 {
  $('#card_expiry_year').addClass('require');
  $('#error_card_expiry_year').error('Invalid Data');
  valid = false;
 }
 else
 {
  $('#card_expiry_year').removeClass('require');
  $('#error_card_expiry_year').error('');
  valid = true;
 }

 if(!cvv_expression.test(card_cvc))
 {
  $('#card_cvc').addClass('require');
  $('#error_card_cvc').text('Invalid Data');
  valid = false;
 }
 else
 {
  $('#card_cvc').removeClass('require');
  $('#error_card_cvc').text('');
  valid = true;
 }

 return valid;
}

Stripe.setPublishableKey('pk_test_51HsXgbGwiIP0vCYJfXLUCp20IeLo2K6Z84jWrMlCO1pZRXxcANlOtpY2XNHoZ4JshOIRNdJgBVLkpOc6lPEBHzfT008kc8OtOV');
	
function stripeResponseHandler(status, response)
{
 if(response.error)
 {
  $('#button_action').attr('disabled', false);
  $('#message').html(response.error.message).show();
 }
 else
 {
  var token = response['id'];
  $('#order_process_form').append("<input type='hidden' name='token' value='" + token + "' />");

  $('#order_process_form').submit();
 }
}
	
function stripePay(event)
{
 event.preventDefault();
 if(validate_form() == true)
 {
  $('#button_action').attr('disabled', 'disabled');
  $('#button_action').val('Payment Processing....');
  Stripe.createToken({
   number:$('#card_holder_number').val(),
   cvc:$('#card_cvc').val(),
   exp_month : $('#card_expiry_month').val(),
   exp_year : $('#card_expiry_year').val()
  }, stripeResponseHandler);
  return false;
 }
}


function only_number(event)
{
 var charCode = (event.which) ? event.which : event.keyCode;
 if (charCode != 32 && charCode > 31 && (charCode < 48 || charCode > 57))
 {
  return false;
 }
 return true;
}


</script>





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


