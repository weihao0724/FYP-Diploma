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

$Customer_name = $Customer_Email = $Customer_Address='';
$sql = "SELECT * FROM customer WHERE Customer_ID='$id'";
$result = mysqli_query($connect, $sql);
if(mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
	{
		$old_username = $row["Customer_name"];
		$old_address = $row["Customer_Address"];
		$old_age = $row["customer_age"];
		$old_ph = $row["Customer_Contact_num"];
	}
}
			
$username = $age = $ph = $address = "";
$username_err = $age_err  = $ph_err = $address_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{

	if(empty($_POST["username"]))
	{
		$username_err = "Name can not be empty.";
	}
	else if (!preg_match("/^[a-zA-Z-' ]*$/",(trim($_POST["username"])))) 
	{
		$username_err = "Only letters and white space allowed";
	}
	else if((trim($_POST["username"])) == $old_username)
	{
		$username = $old_username;
	}
	else
	{
		$check = $_POST["username"];
		$check_name=mysqli_query($connect,"SELECT * FROM customer WHERE Customer_name = '$check'");
		if(mysqli_num_rows($check_name) == 0)
		{
		$username = $_POST["username"];
		}
		else
		{
			$username_err = "This name has already taken.";
		}
	}
	
	
	
	if(empty($_POST["age"]))
	{
		$age_err = "age is required.";
	}
	else if($_POST["age"] < 18 )
	{
        $age_err = "age requirment is at least 18.";
    }
	else if($_POST["age"] > 120 )
	{
        $age_err = "age requirment is under 120.";
    }
	else
	{
		$age = $_POST["age"];
	}
	
	if(empty($_POST["ph"]))
	{
		$ph_err = "Phone number is required.";
	}
	if(strlen($_POST["ph"]) < 10 || strlen($_POST["ph"]) > 12)
	{
        $ph_err = "Please enter a valid phone number.";
    } 
	else if((trim($_POST["ph"])) == $old_ph)
	{
		$ph = $old_ph;
	}
	else
	{
		$check_ph = $_POST["ph"];
		$check_ph=mysqli_query($connect,"SELECT * FROM customer WHERE Customer_Contact_num = '$check_ph'");
		if(mysqli_num_rows($check_name) == 0)
		{
		$ph = $_POST["ph"];
		}
		else
		{
			$ph_err = "This phone number has already taken.";
		}
	}
	
	if(empty($_POST["address"]))
	{
		$address_err = "Address can not be empty.";
	}
	else
	{
		$address = $_POST["address"];
	}
	
	if(empty($username_err) && empty($email_err) && empty($age_err) && empty($ph_err) && empty($address_err)) 
	{
		mysqli_query($connect,"UPDATE `customer` SET `Customer_name`='$username',`Customer_Contact_num`='$ph',`customer_age`='$age',`Customer_Address`= '$address' WHERE `Customer_ID` = '$id'");
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
<title>Edit profile</title>
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
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
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
              <h1 class="page-title">Edit profile</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end inner page banner -->
<?php
			$id = $_SESSION['id'];
			$Customer_name = $Customer_Email = $Customer_Address='';
			$sql = "SELECT * FROM customer WHERE Customer_ID='$id'";
			$result = mysqli_query($connect, $sql);
			if(mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$username = $row["Customer_name"];
					$email = $row["Customer_Email"];
					$address = $row["Customer_Address"];
					$age = $row["customer_age"];
					$ph = $row["Customer_Contact_num"];
				}
			}
?>
<div class="section padding_layout_1">
  <div class="container">
    <div class="row">
      <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12"></div>
      <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
          <div class="full">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contant_form">
          <div class="main_heading text_align_center">
			<h2><?php echo $username;?></h2>
			<p class="large">Edit your profile here (^_^)</p>
			</div>
			</div>
			</div>
              <div class="form_section">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                  <fieldset>
                  <div class="row">
                    <div class="field col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<label><h5>Name</h5></label>
                      <input class="field_custom" id="username" name="username" value="<?php echo $username; ?>"/>
					  <span id="username_err" class="text-danger"><?php echo $username_err; ?></span>
                    </div>
                    <div class="field col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
					<label><h5>Age</h5></label>
                      <input class="field_custom" id="age" name="age" value="<?php echo $age; ?>" />
					  <span id="age_err" class="text-danger"><?php echo $age_err; ?></span>
                    </div>
                    <div class="field col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<label><h5>Email</h5></label>
                      <input class="field_custom" id="email" name="email" disabled value="<?php echo $email; ?>"/>
                    </div>
                    <div class="field col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<label><h5>Phone number</h5></label>
                      <input class="field_custom" name="ph" value="<?php echo $ph; ?>" />
					  <span id="ph_err" class="text-danger"><?php echo $ph_err; ?></span>
                    </div>
                    <div class="field col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label><h5>Address</h5></label>
                      <input class="field_custom" id="address" name="address" value="<?php echo $address; ?>"/>
					  <span id="address_err" class="text-danger"><?php echo $address_err; ?></span>
                    </div>
                    <div class="center"><input class="bt_main" type="submit" name="Update" value="Update"/></div>
                  </div>
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- section -->

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
