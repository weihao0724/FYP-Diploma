<?php 
include("php/connection.php");

$prod_cod = "";
$qty = "";
session_start();

/*store session user id into a variable*/
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
	$id = 0;
}
else
{
	$id = $_SESSION["id"];
}

/*update quantity product in cart after change quntity*/
if (isset($_POST['action']) && $_POST['action']=="change")
{
	$pid = $_POST["Prod_ID"];
	$sql_qty = mysqli_query($connect,"SELECT * FROM cart WHERE Part_ID = '$pid' OR PC_ID = '$pid' AND Customer_ID = '$pid' AND Payment_ID IS NULL");	

    $result_qty = mysqli_fetch_assoc($sql_qty);
  
	$qty = $_POST["quantity"];

	mysqli_query($connect,"UPDATE cart SET Qty = $qty WHERE Customer_ID = '$id' AND Part_ID = '$pid' OR PC_ID = '$pid' AND Payment_ID IS NULL");

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
<title>Cart</title>
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
<body id="default_theme" class="it_serv_shopping_cart shopping-cart">

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
/* if user login show user profile and log out*/
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
				/*count item in cart that belongs to this customer*/
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
              <h1 class="page-title">Shopping Cart</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end inner page banner -->
<div class="section padding_layout_1 Shopping_cart_section">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="product-table">
	<table class="table">
            <thead>
              <tr>
                <th>PC Customize</th>
                <th class="text-center">Total</th>
                <th class="text-center">Details</th>
				<th> </th>
              </tr>
            </thead>

            <tbody>
			<?php		
				/*show customise product select by customer*/
				$total_price = 0;
				$totalcus=0;
				$result = mysqli_query($connect,"SELECT * FROM customise WHERE Customer_ID = $id AND Payment_ID IS NULL ");
				
				while($rowcus = mysqli_fetch_assoc($result))
				{
					$totalcus += $rowcus['total'];
				?>
              <tr>
                <td class="col-sm-8 col-md-6">
				<div class="media-body">
				<h4 class="media-heading">Custom PC Package</h4>
                </div>
				</td>
                <td class="col-sm-1 col-md-1 text-center"><p class="price_table"><?php echo "RM". number_format($rowcus['total'],2); ?></p></td>
				
				<td><a href="details.php?id=<?php echo $rowcus['customiseid'];?>"><button class="button" style = "margin-top: 37%; margin-left: 20%;">Details</button></a></td>

                <td class="col-sm-1 col-md-1">
				
				<a href="deletecus.php?id=<?php echo $rowcus["customiseid"]; ?>"><button class="bt_main"><i class="fa fa-trash"></i> Remove</button><a/>
				<?php 
				} 
				?>
				</td>
              </tr>
            </tbody>
          </table>
          <table class="table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th class="text-center">Price</th>
                <th class="text-center">Total</th>
                <th> </th>
              </tr>
            </thead>

            <tbody>
			<?php		
			
				$total_price = 0;
				$total_pricepc = 0;
				$result = mysqli_query($connect,"SELECT * FROM cart WHERE Customer_ID = $id AND Payment_ID IS NULL");
				/*show part select by customer*/
				while($result_cart = mysqli_fetch_assoc($result))
				{
					$prod_cod = $result_cart["Part_ID"];
					$pc_cod = $result_cart["PC_ID"];
					$find_part = mysqli_query($connect,"SELECT * FROM part WHERE Part_ID = '$prod_cod' ");
					$find_pc = mysqli_query($connect,"SELECT * FROM pc WHERE PC_ID = '$pc_cod' ");
					
				while($row = mysqli_fetch_assoc($find_part))
				{
					if($row['Stock']==0)
					{
						$outstock = $row['Part_ID'];
						$oustk = " is out of stock!";
						$remove_query =mysqli_query($connect,"delete from cart where Part_ID = '$outstock'");
				?>
					<script>
						alert("The thing in your cart is out of stock!");
					</script>
				<?php
					}
				?>
              <tr>
                <td class="col-sm-8 col-md-6">
				<div class="media"> 
				<img class="media-object" src="<?php echo $row["image"]; ?>" style="width:150px; high:100px;/">
                    <div class="media-body">
                      <h4 class="media-heading"><a href="#"><?php echo $row["Part_Name"]; ?></a></h4>
                    </div>
                  </div>
				</td>
                <td class="col-sm-1 col-md-1" style="text-align: center">
				<form method='post' action=''>
				<input type='hidden' name='Prod_ID' value="<?php echo $row["Part_ID"]; ?>" />
				<input type='hidden' name='action' value="change" />
				
				<select name='quantity' class='quantity' style="margin-top:40%;" onChange="this.form.submit()">	
				<?php
					/*adjusts the result pointer to an arbitrary row in the result-set.*/
					mysqli_data_seek($find_part,0);
					
					
					$select = mysqli_query($connect,"SELECT * FROM cart WHERE Part_ID = '$prod_cod' AND Customer_ID = '$id' AND Payment_ID IS NULL");
					$slect_qty = mysqli_fetch_assoc($select);
					
					while($stock = mysqli_fetch_assoc($find_part))
					{
						
					for($i=1; $i <= $stock["Stock"]; $i++)
					{
						?>
						
						<option class='form-control' <?php if($slect_qty['Qty'] == $i) echo"selected";?> value="<?php echo $i;?>"><?php echo $i;?></option>
						<?php
					}
					
					}
				?>
				</select>
			
				
				</form>
                </td>
                <td class="col-sm-1 col-md-1 text-center"><p class="price_table"><?php echo "RM".$row['Part_Price']; ?></p></td>
                <td class="col-sm-1 col-md-1 text-center"><p class="price_table"><mark style="background-color: #CACFD2;"><?php echo "RM". number_format($row['Part_Price'] * $result_cart["Qty"],2); ?></mark></p></td>

                <td class="col-sm-1 col-md-1">
				
				<a href="delete.php?id=<?php echo $row["Part_ID"]; ?>"><button class="bt_main"><i class="fa fa-trash"></i> Remove</button><a/>
				
				</td>
              </tr>
				<?php
				$total_price += ($row["Part_Price"]*$result_cart["Qty"]);
				}
				
				/*show pc select by customer*/
				while($row_pc = mysqli_fetch_assoc($find_pc))
				{
				?>
              <tr>
                <td class="col-sm-8 col-md-6">
				<div class="media"> 
				<img class="media-object" src="<?php echo $row_pc["image"]; ?>" style="width:150px; high:100px;/">
                    <div class="media-body">
                      <h4 class="media-heading"><a href="#"><?php echo $row_pc["PC_Name"]; ?></a></h4>
                    </div>
                  </div>
				</td>
                <td class="col-sm-1 col-md-1" style="text-align: center">
				<form method='post' action=''>
				<input type='hidden' name='Prod_ID' value="<?php echo $row_pc["PC_ID"]; ?>" />
				<input type='hidden' name='action' value="change" />
				
				<select name='quantity' class='quantity' style="margin-top:40%;" onChange="this.form.submit()">	
				<?php
					/*adjusts the result pointer to an arbitrary row in the result-set.*/
					mysqli_data_seek($find_pc,0);
					
					$select_pc = mysqli_query($connect,"SELECT * FROM cart WHERE PC_ID = '$pc_cod' AND Customer_ID = '$id' AND Payment_ID IS NULL");
					$pc_qty = mysqli_fetch_assoc($select_pc);
					
					while($stock_pc = mysqli_fetch_assoc($find_pc))
					{
						
					for($j=1; $j <= $stock_pc["Stock"]; $j++)
					{
						?>
						
						<option class='form-control' <?php if($pc_qty['Qty'] == $j) echo"selected";?> value="<?php echo $j;?>"><?php echo $j;?></option>
						<?php
					}
					
					}
				?>
				</select>
			
				
				</form>
                </td>
                <td class="col-sm-1 col-md-1 text-center"><p class="price_table"><?php echo "RM".$row_pc['PC_Price']; ?></p></td>
                <td class="col-sm-1 col-md-1 text-center"><p class="price_table"><mark style="background-color: #CACFD2;"><?php echo "RM". number_format($row_pc['PC_Price'] * $result_cart["Qty"],2); ?></mark></p></td>

                <td class="col-sm-1 col-md-1">
				
				<a href="delete.php?id=<?php echo $row_pc["PC_ID"]; ?>"><button class="bt_main"><i class="fa fa-trash"></i> Remove</button><a/>
				
				</td>
              </tr>
				<?php
				$total_pricepc += ($row_pc["PC_Price"]*$result_cart["Qty"]);
				}
				}
				
				$total_price=$totalcus+$total_price+$total_pricepc;
				$_SESSION["total"] = $total_price;
				?>
            </tbody>
          </table>
          <table class="table">
            <tbody>
              <tr class="cart-form">
                <td class="actions"><div class="coupon">
                    
                  </div>
                 
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="shopping-cart-cart">
          <table>
            <tbody>
              <tr>
                <td><h3>Total</h3></td>
                <td class="text-right"><h4><?php echo "RM".number_format($total_price,2); ?></h4></td>
              </tr>
			  <?php
			  if($total_price == 0)
			  {
			  ?>
			  <tr>
                <td><a href="Part.php"><button type="button" class="button" >Continue Shopping</button><a></td>
			  </tr>
			  <?php
			  }
			  else
			  {
			  ?>
              <tr>
                <td><a href="Part.php"><button type="button" class="button" >Continue Shopping</button><a></td>
				<td><a href="order_process.php"><button class="button">Checkout</button></a></td>				  
              </tr>
			  <?php
			  }
			  ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- section -->

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
