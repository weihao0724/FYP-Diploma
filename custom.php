<?php

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
$cpuerror=$gpuerror=$moboerror=$ramerror=$ssderror=$hhderror=$psuerror=$pccaseerror="";
$cpuid=$gpuid=$moboid=$ramid=$ssdid=$hhdida=$psuid=$pccaseid="";

if(isset($_POST["Add_to_Cart"]))
{
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
		header("location: log_in.php");
	}
	else
	{
		$id = $_SESSION["id"];
	}
	
	if(isset($_REQUEST['psuida']))
	{
		$psuid=$_POST["psuida"];
	}
	else
	{
		$psuerror="Please select your PSU!";
		
	}
	if(isset($_REQUEST['pccaseida']))
	{
		$pccaseid=$_POST["pccaseida"];
	}      
	else
	{
	$pccaseerror="Please select your PC CASE!";
	}
	if(isset($_REQUEST['hhdid']))
	{
		$hhdida=$_POST["hhdid"];
	}      
	else
	{
	$hhderror="Please select your HHD!";
	}
	if(isset($_REQUEST['ssdid']))
	{
		$ssdid=$_POST["ssdid"];
	}      
	else
	{
	$ssderror="Please select your SSD!";
	}
	if(isset($_REQUEST['ramid']))
	{
		$ramid=$_POST["ramid"];
	}      
	else
	{
	$ramerror="Please select your RAM!";
	}
	if(isset($_REQUEST['gpuid']))
	{
		$gpuid=$_POST["gpuid"];
	}      
	else
	{
	$gpuerror="Please select your GPU!";
	}
	if(isset($_REQUEST['moboid']))
	{
		$moboid=$_POST["moboid"];
	}      
	else
	{
	$moboerror="Please select your Motherboard!";
	}
	if(isset($_REQUEST['cpuid']))
	{
		$cpuid=$_POST["cpuid"];
	}      
	else
	{
	$cpuerror="Please select your CPU!";
	}
	$query_psu=mysqli_query($connect,"SELECT * from part where Part_ID='$psuid'");
	$query_pccase=mysqli_query($connect,"SELECT * from part where Part_ID='$pccaseid'");
	$query_hhd=mysqli_query($connect,"SELECT * from part where Part_ID='$hhdida'");
	$query_ssd=mysqli_query($connect,"SELECT * from part where Part_ID='$ssdid'");
	$query_ram=mysqli_query($connect,"SELECT * from part where Part_ID='$ramid'");
	$query_gpu=mysqli_query($connect,"SELECT * from part where Part_ID='$gpuid'");
	$query_cpu=mysqli_query($connect,"SELECT * from part where Part_ID='$cpuid'");
	$query_mobo=mysqli_query($connect,"SELECT * from part where Part_ID='$moboid'");
	if(empty($cpuerror) && empty($gpuerror) && empty($moboerror) && empty($ramerror) && empty($ssderror) && empty($hhderror) && empty($psuerror) && empty($pccaseerror))
	{
		$checkbox1=$_POST['other'];  
		$chk="";  
		$final="";
		$totalother=0;
		$countcomma=0;
		$count=0;
		foreach($checkbox1 as $chk1)
		{
			$countcomma++;
		}
		foreach($checkbox1 as $chk1)  
		{  
			$count++;
			$chk = $chk1;  
			$query_add=mysqli_query($connect,"SELECT * FROM part where Part_ID ='$chk'");
			$row_add=mysqli_fetch_assoc($query_add);
			$row_add['Part_Price'];
			$totalother= $totalother+$row_add['Part_Price'];
			$comma="";
			if($countcomma>$count)
			{
				$comma=",";
			}
			$final .= $chk.$comma;
		} 

		$rowpsu=mysqli_fetch_assoc($query_psu);
		$rowpc=mysqli_fetch_assoc($query_pccase);
		$rowhhd=mysqli_fetch_assoc($query_hhd);
		$rowssd=mysqli_fetch_assoc($query_ssd);
		$rowram=mysqli_fetch_assoc($query_ram);
		$rowgpu=mysqli_fetch_assoc($query_gpu);
		$rowmobo=mysqli_fetch_assoc($query_mobo);
		$rowcpu=mysqli_fetch_assoc($query_cpu);
		$status =1;
		$psuprice=0;
		$pcprice=0;
		$hhdprice=0;
		$ramprice=0;
		$ssdprice=0;
		$gpuprice=0;
		$moboprice=0;
		$cpuprice=0;
		$psuprice=$rowpsu['Part_Price'];
		$pcprice=$rowpc['Part_Price'];
		$hhdprice=$rowhhd['Part_Price'];
		$ramprice=$rowram['Part_Price'];
		$ssdprice=$rowssd['Part_Price'];
		$gpuprice=$rowgpu['Part_Price'];
		$moboprice=$rowmobo['Part_Price'];
		$cpuprice=$rowcpu['Part_Price'];
		$total = $psuprice+$pcprice+$hhdprice+$ssdprice+$ramprice+$gpuprice+$moboprice+$cpuprice+$totalother;

		if(empty($cpuerror) && empty($gpuerror) && empty($moboerror) && empty($ramerror) && empty($ssderror) && empty($hhderror) && empty($psuerror) && empty($pccaseerror))
		{
			$insert_query=mysqli_query($connect,"INSERT INTO customise(Customer_ID,cpuid,moboid,gpuid,ssdid,hhdid,ramid,psuid,pccaseid,addonid,total) VALUES('$id','$cpuid','$moboid','$gpuid','$ssdid','$hhdida','$ramid','$psuid','$pccaseid','$final','$total') ");
			?>
				<script>
					confirm = alert("Your Customise PC Package is added to cart!");
					window.location.href = "custom.php?confirm=" + confirm;
				</script>
			<?php

		}
	
	}
}

if(isset($_GET["confirm"]))
{
	header("location: custom.php");
	exit();
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
<title>Customize PC</title>
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
				
				$id = $_SESSION["id"];
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
              <h1 class="page-title">Customize</h1>
              <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Pages</li>
                <li class="active">Customize</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end inner page banner -->
<!-- section -->
<?php 
$query1 ="SELECT * FROM `part` where Category_ID =1 and Part_ID like 'am%' and Stock >0 and Part_isDelete=0";
$result1 = mysqli_query($connect, $query1);
$query10 ="SELECT * FROM `part` where Category_ID =1 and Part_ID like 'in%' and Stock >0 and Part_isDelete=0";
$result10 = mysqli_query($connect, $query10);
$query11 ="SELECT * FROM `part` where Category_ID =3 and Part_ID like 'amb%'and Stock >0 and Part_isDelete=0";
$result11 = mysqli_query($connect, $query11);
$query12 ="SELECT * FROM `part` where Category_ID =3 and Part_ID like 'imb%'and Stock >0 and Part_isDelete=0";
$result12 = mysqli_query($connect, $query12);
$query2 ="SELECT * FROM `part` where Category_ID =2 and Stock >0 and Part_isDelete=0 ";
$result2 = mysqli_query($connect, $query2);
$query4 ="SELECT * FROM `part` where Category_ID =4 and Stock >0 and Part_isDelete=0";
$result4 = mysqli_query($connect, $query4);
$query5 ="SELECT * FROM `part` where Category_ID =5 and Stock >0 and Part_isDelete=0";
$result5 = mysqli_query($connect, $query5);
$query6 ="SELECT * FROM `part` where Category_ID =8 and Stock >0 and Part_isDelete=0";
$result6 = mysqli_query($connect, $query6);
$query7 ="SELECT * FROM `part` where Category_ID =7 and Stock >0 and Part_isDelete=0";
$result7 = mysqli_query($connect, $query7);
$query8 ="SELECT * FROM `part` where Category_ID =6 and Stock >0 and Part_isDelete=0";
$result8 = mysqli_query($connect, $query8);
$query9 ="SELECT * FROM `part` where Category_ID =9 and Stock >0 and Part_isDelete=0";
$result9 = mysqli_query($connect, $query9);
?>	
<div class="section padding_layout_1">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="row" style="margin-bottom: 30px;">
          <div class="col-md-12">
            <div class="full margin_bottom_30">
              <div class="accordion border_circle">
                <div class="bs-example">
                  <div class="panel-group" id="accordion" style="margin-top: 0;">
                    <div class="panel panel-default">
                      <div class="panel-heading">
						  
                        <p class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">CPU Manufacture<i class="fa fa-angle-down"></i></a> </p>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                         <button  onclick="myFunction1();myFunction3();switchVisible3();switchVisible4();">
    AMD
  </button>
  <button onclick="myFunction2();myFunction4();switchVisible1();switchVisible2();" >
    Intel
  </button>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <p class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">CPU<i class="fa fa-angle-down"></i></a> </p>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse">
						  <b>Central Processor Unit </b>performs basic arithmetic, logic, controlling, and input and output operations
                        <div class="panel-body">						<form method="post">		<div id="amd" style="display:none">
		<table>
			<tr>
				<th>Image</th>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th colspan="2">Radio Button</th>
			</tr>
			
<?php
	while($row1 = mysqli_fetch_assoc($result1))
	{
?>
			<tr >
				<td><img src=<?php echo $row1['image']; ?> style="width:100px;height:100px;"></td>
				<td><?php echo $row1['Part_ID']; ?></td>
				<td><?php echo $row1['Part_Name']; ?></td>
				<td class="nr"><?php echo $row1['Part_Price']; ?></td>
				<td><label><input type="radio" name="cpuid" class="cpu"value=<?php echo $row1['Part_ID'];?>  /> </label>Add</td>
			</tr>
<?php
	}
?>
			
		</table>
	</div>
		<div id="intel" style="display:none">
		<table>
			<tr>
				<th>Image</th>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th colspan="2">Radio Button</th>
			</tr>
			
<?php
	while($row10 = mysqli_fetch_assoc($result10))
	{
?>
			<tr >
				<td><img src=<?php echo $row10['image']; ?> style="width:100px;height:100px;"></td>
				<td><?php echo $row10['Part_ID']; ?></td>
				<td><?php echo $row10['Part_Name']; ?></td>
				<td class="nr"><?php echo $row10['Part_Price']; ?></td>
				<td><label><input type="radio" name="cpuid" class="cpu"value=<?php echo $row10['Part_ID'];?>  /> </label>Add</td>
			</tr>
<?php
	}
?>
			
		</table>
	</div>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <p class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Motherboard<i class="fa fa-angle-down"></i></a> </p>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse">
						 <b>Motherboard</b> is the main printed circuit board in general-purpose computer and other expandable systems.
                        <div class="panel-body">						<div id="amdmobo" style="display:none">
		<table>
			<tr>
				<th>Image</th>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th colspan="2">Radio Button</th>
			</tr>
			
<?php
	while($row11 = mysqli_fetch_assoc($result11))
	{
?>
			<tr >
				<td><img src=<?php echo $row11['image']; ?> style="width:100px;height:100px;"></td>
				<td><?php echo $row11['Part_ID']; ?></td>
				<td><?php echo $row11['Part_Name']; ?></td>
				<td class="nr"><?php echo $row11['Part_Price']; ?></td>
				<td><label><input type="radio" name="moboid" class="mobo"value=<?php echo $row11['Part_ID'];?>  /> </label>Add</td></br>
			</tr>
<?php
	}
?>
			
		</table>
	</div>
	<div id="intelmobo" style="display:none">
		<table>
			<tr>
				<th>Image</th>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th colspan="2">Radio Button</th>
			</tr>
			
<?php
	while($row12 = mysqli_fetch_assoc($result12))
	{
?>
			<tr >
				<td><img src=<?php echo $row12['image']; ?> style="width:100px;height:100px;"></td>
				<td><?php echo $row12['Part_ID']; ?></td>
				<td><?php echo $row12['Part_Name']; ?></td>
				<td class="nr"><?php echo $row12['Part_Price']; ?></td>
				<td><label><input type="radio" name="moboid" class="mobo"value=<?php echo $row12['Part_ID'];?>  /> </label>Add</td></br>
			</tr>
<?php
	}
?>
			
		</table>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <p class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">GPU<i class="fa fa-angle-down"></i></a> </p>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse in">
						  <b>Graphics processing unit </b>manipulating computer graphics and image processing
                        <div class="panel-body">						<table border="1px;">
			<tr>
				<th>Image</th>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th colspan="2">Radio Button</th>
			</tr>
<?php
	while($row2 = mysqli_fetch_assoc($result2))
	{
?>
			<tr>
				<td><img src=<?php echo $row2['image']; ?> style="width:100px;height:100px;"></td>
				<td><?php echo $row2['Part_ID']; ?></td>
				<td><?php echo $row2['Part_Name']; ?></td>
				<td class="nr"><?php echo $row2['Part_Price']; ?></td>
				<td><label><input type="radio" name="gpuid" class="gpu"value=<?php echo $row2['Part_ID'];?>  /> </label>Add</td></br>
			</tr>
<?php
	}
?></table>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <p class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">RAM<i class="fa fa-angle-down"></i></a> </p>
                      </div>
                      <div id="collapseFive" class="panel-collapse collapse in">
						  <b>Random-access memory </b>store working data and machine code.
			<table border="1px;">
			<tr>
				<th>Image</th>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th colspan="2">Radio Button</th>
			</tr>
                        <?php
	while($row4 = mysqli_fetch_assoc($result4))
	{
?>
			<tr>
				<td><img src=<?php echo $row4['image']; ?> style="width:100px;height:100px;"></td>
				<td><?php echo $row4['Part_ID']; ?></td>
				<td><?php echo $row4['Part_Name']; ?></td>
				<td class="nr"><?php echo $row4['Part_Price']; ?></td>
				<td><label><input type="radio" name="ramid" class="ram"value=<?php echo $row4['Part_ID'];?>  /> </label>Add</td></br>
			</tr>
<?php
	}
?></table>
                        </div>
                      </div>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <p class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">SSD<i class="fa fa-angle-down"></i></a> </p>
                      </div>
                      <div id="collapseSix" class="panel-collapse collapse in">
						  <b>Solid-state drive </b>use to store data.
                        <div class="panel-body">						<table border="1px;">
			<tr>
				<th>Image</th>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th colspan="2">Radio Button</th>
			</tr>
                         <?php
	while($row5 = mysqli_fetch_assoc($result5))
	{
?>
			<tr>
				<td><img src=<?php echo $row5['image']; ?> style="width:100px;height:100px;"></td>
				<td><?php echo $row5['Part_ID']; ?></td>
				<td><?php echo $row5['Part_Name']; ?></td>
				<td class="nr"><?php echo $row5['Part_Price']; ?></td>
				<td><label><input type="radio" name="ssdid" class="ssd"value=<?php echo $row5['Part_ID'];?>  /> </label>Add</td></br>
			</tr>
<?php
	}
			?></table>
							
                        </div>
                      </div>
                    </div><div class="panel panel-default">
                      <div class="panel-heading">
                        <p class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">HHD<i class="fa fa-angle-down"></i></a> </p>
                      </div>
                      <div id="collapseSeven" class="panel-collapse collapse in">
						  <b>Hard disk drive </b>use to store data.
                        <div class="panel-body">						<table border="1px;">
			<tr>
				<th>Image</th>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th colspan="2">Radio Button</th>
			</tr>
<?php
	while($row6 = mysqli_fetch_assoc($result6))
	{
?>
			<tr>
				<td><img src=<?php echo $row6['image']; ?> style="width:100px;height:100px;"></td>
				<td><?php echo $row6['Part_ID']; ?></td>
				<td><?php echo $row6['Part_Name']; ?></td>
				<td class="nr"><?php echo $row6['Part_Price']; ?></td>
				<td><label><input type="radio" name="hhdid" class="hhd"value=<?php echo $row6['Part_ID'];?>  /> </label>Add</td></br>
			</tr>
<?php
	}
?></table>
							
                        </div>
                      </div>
                    </div><div class="panel panel-default">
                      <div class="panel-heading">
                        <p class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">PC CASE<i class="fa fa-angle-down"></i></a> </p>
                      </div>
                      <div id="collapseEight" class="panel-collapse collapse in">
						  <b>PC CASE </b>contains most of the components of computers.
                        <div class="panel-body">						<table border="1px;">
			<tr>
				<th>Image</th>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th colspan="2">Radio Button</th>
			</tr>
                        <?php
	while($row7 = mysqli_fetch_assoc($result7))
	{
?>
			<tr>
				<td><img src=<?php echo $row7['image']; ?> style="width:100px;height:100px;"></td>
				<td><?php echo $row7['Part_ID']; ?></td>
				<td><?php echo $row7['Part_Name']; ?></td>
				<td class="nr"><?php echo $row7['Part_Price']; ?></td>
				<td><label><input type="radio" name="pccaseida" class="pccaseida"value=<?php echo $row7['Part_ID'];?>  /> </label>Add</td>
			</tr>
			 
<?php
	}
?></table>
                        </div>
                      </div>
                    </div><div class="panel panel-default">
                      <div class="panel-heading">
                        <p class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseNine">PSU<i class="fa fa-angle-down"></i></a> </p>
                      </div>
                      <div id="collapseNine" class="panel-collapse collapse in">
						  <b>Power Supply Unit </b>provide powers for computer.
                        <div class="panel-body">
									<table border="1px;">
			<tr>
				<th>Image</th>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th colspan="2">Radio Button</th>
			</tr>
                       <?php
	while($row8 = mysqli_fetch_assoc($result8))
	{
?>
			<tr>
				<td><img src=<?php echo $row8['image']; ?> style="width:100px;height:100px;"></td>
				<td name="ira" class="ir"><?php echo $row8['Part_ID']; ?></td>
				<td><?php echo $row8['Part_Name']; ?></td>
				<td class="nr"><?php echo $row8['Part_Price']; ?></td>
				<td><label><input type="radio" name="psuida" class="psu"value=<?php echo $row8['Part_ID'];?>  /> </label>Add</td></br>
			</tr>
			     
			
<?php
	}
?>
				</table>			
						  </table></div>
                      </div>
                    </div><div class="panel panel-default">
                      <div class="panel-heading">
                        <p class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseTen">Other<i class="fa fa-angle-down"></i></a> </p>
                      </div>
                      <div id="collapseTen" class="panel-collapse collapse in">
						  <b>Other PC Components</b> additional parts for PC.
                        <div class="panel-body">
													<table border="1px;">
			<tr>
				<th>Image</th>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th colspan="2">Radio Button</th>
			</tr>
<?php
	while($row9 = mysqli_fetch_assoc($result9))
	{
?>
			<tr>
				<td><img src=<?php echo $row9['image']; ?> style="width:100px;height:100px;"></td>
				<td><?php echo $row9['Part_ID']; ?></td>
				<td><?php echo $row9['Part_Name']; ?></td>
				<td class="nr"><?php echo $row9['Part_Price']; ?></td>
				<td><input type="checkbox" name="other[]" class="selectProduct" value="<?php echo $row9['Part_ID'];?>">Add</td></br>
			</tr>
<?php
	}
?></table>
							
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><p><input type="text" class="totalSum" value="0" style="postion:sticky"></p>
				<button type="submit" name="Add_to_Cart" >CONTINUE</button>
<p><?php echo $cpuerror;?></p>
<p><?php echo $moboerror;?></p>
<p><?php echo $gpuerror;?></p>
<p><?php echo $ramerror;?></p>
<p><?php echo $ssderror;?></p>
<p><?php echo $hhderror;?></p>
<p><?php echo $pccaseerror;?></p>
<p><?php echo $psuerror;?></p>
			</form>
<!-- end footer -->
<!-- js section -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- menu js -->
<script src="js/menumaker.js"></script>
<!-- wow animation -->
<script src="js/wow.js"></script>
<!-- custom js -->
<script>
	var $total = 0;
	var $past_pccase = 0;
	var $past_psu = 0;
	var $past_gpu=0;
	var $past_hhd=0;
	var $past_ssd=0;
	var $past_ram=0;
	var $past_cpu=0;
	var $past_mobo=0;
	var $past_selectProduct=0;
	var $selectpsuid="";
	$( document ).ready(function() {
		var $psu = 0;
		$(".psu").on("change",function() {
			var $row = $(this).closest("tr");    // Find the row
			var $price=$row.find(".nr").text();
			var checked = $(this).attr('checked', true);
                 if(checked)
                 {
                     $psu  = parseFloat($price);
					 if($past_psu != 0)
						 {
							 $total -= $past_psu;
							 $total += $psu;
							 $past_psu = $psu;
						 }
					 else
						 {
							 $total += $psu;
							 $past_psu = $psu;
						 }
                 }
			$('.totalSum').val($total);
			$('.sleid').val($selectpsuid);
		});
	});$( document ).ready(function() {
		var $gpu = 0;
		$(".gpu").on("change",function() {
			
			var $row = $(this).closest("tr");    // Find the row
			var $price = $row.find(".nr").text(); // Find the text
		    var checked = $(this).attr('checked', true);
                 if(checked)
                 {
                     $gpu  = parseFloat($price);
					 if($past_gpu != 0)
						 {
							 $total -= $past_gpu;
							 $total += $gpu;
							 $past_gpu = $gpu;
						 }
					 else
						 {
							 $total += $gpu;
							 $past_gpu = $gpu;
						 }
                 }
			$('.totalSum').val($total);
		});
	});$( document ).ready(function() {
		var $hhd = 0;
		$(".hhd").on("change",function() {
			
			var $row = $(this).closest("tr");    // Find the row
			var $price = $row.find(".nr").text(); // Find the text
		    var checked = $(this).attr('checked', true);
                 if(checked)
                 {
                     $hhd  = parseFloat($price);
					 if($past_hhd != 0)
						 {
							 $total -= $past_hhd;
							 $total += $hhd;
							 $past_hhd = $hhd;
						 }
					 else
						 {
							 $total += $hhd;
							 $past_hhd = $hhd;
						 }
                 }
			$('.totalSum').val($total);
		});
	});
		$( document ).ready(function() {
		var $pccase = 0;
		$(".pccaseida").on("change",function() {
			
			var $row = $(this).closest("tr");    // Find the row
			var $price = $row.find(".nr").text(); // Find the text
		    var checked = $(this).attr('checked', true);
                 if(checked)
                 {
					 $pccase  = parseFloat($price);
					 if($past_pccase != 0)
						 {
							 $total -= $past_pccase;
							 $total += $pccase;
							 $past_pccase = $pccase;
						 }
					 else
						 {
							 $total += $pccase;
							 $past_pccase = $pccase;
						 }
                 }
			
			$('.totalSum').val($total);
		});
	});$( document ).ready(function() {
		var $cpu = 0;
		$(".cpu").on("change",function() {
			
			var $row = $(this).closest("tr");    // Find the row
			var $price = $row.find(".nr").text(); // Find the text
		    var checked = $(this).attr('checked', true);
                 if(checked)
                 {
					 $cpu  = parseFloat($price);
					 if($past_cpu != 0)
						 {
							 $total -= $past_cpu;
							 $total += $cpu;
							 $past_cpu = $cpu;
						 }
					 else
						 {
							 $total += $cpu;
							 $past_cpu = $cpu;
						 }
                 }
			
			$('.totalSum').val($total);
		});
	});$( document ).ready(function() {
		var $mobo = 0;
		$(".mobo").on("change",function() {
			
			var $row = $(this).closest("tr");    // Find the row
			var $price = $row.find(".nr").text(); // Find the text
		    var checked = $(this).attr('checked', true);
                 if(checked)
                 {
					 $mobo  = parseFloat($price);
					 if($past_mobo != 0)
						 {
							 $total -= $past_mobo;
							 $total += $mobo;
							 $past_mobo = $mobo;
						 }
					 else
						 {
							 $total += $mobo;
							 $past_mobo = $mobo;
						 }
                 }
			
			$('.totalSum').val($total);
		});
	});$( document ).ready(function() {
		var $ram = 0;
		$(".ram").on("change",function() {
			
			var $row = $(this).closest("tr");    // Find the row
			var $price = $row.find(".nr").text(); // Find the text
		    var checked = $(this).attr('checked', true);
                 if(checked)
                 {
					 $ram  = parseFloat($price);
					 if($past_ram != 0)
						 {
							 $total -= $past_ram;
							 $total += $ram;
							 $past_ram = $ram;
						 }
					 else
						 {
							 $total += $ram;
							 $past_ram = $ram;
						 }
                 }
			
			$('.totalSum').val($total);
		});
	});$( document ).ready(function() {
		var $ssd = 0;
		$(".ssd").on("change",function() {
			
			var $row = $(this).closest("tr");    // Find the row
			var $price = $row.find(".nr").text(); // Find the text
		    var checked = $(this).attr('checked', true);
                 if(checked)
                 {
					 $ssd  = parseFloat($price);
					 if($past_ssd != 0)
						 {
							 $total -= $past_ssd;
							 $total += $ssd;
							 $past_ssd = $ssd;
						 }
					 else
						 {
							 $total += $ssd;
							 $past_ssd = $ssd;
						 }
                 }
			
			$('.totalSum').val($total);
		});
	});
$( document ).ready(function() {
		var $selectProduct = 0;
		$(".selectProduct").on("change",function() {
			
			var $row = $(this).closest("tr");    // Find the row
			var $price = $row.find(".nr").text(); // Find the text
                 if(this.checked)
                 {
					 $total = $total + parseFloat($price);
				 }
			else{
				 $total = $total - parseFloat($price);
			}
			
			$('.totalSum').val($total);
		});
	});
	function myFunction1() {
  var x = document.getElementById("amd");
  var y = document.getElementById("intel");
  if (x.style.display === "none") {
    x.style.display = "block";
	y.style.display = "none";
  } else {
    x.style.display = "none";
 }
}
		function myFunction2() {
  var y = document.getElementById("intel");
  var x = document.getElementById("amd");
  if (y.style.display === "none") {
    y.style.display = "block";
	 x.style.display="none";
  } else {
    y.style.display = "none";
 }
}
		function myFunction3() {
  var x = document.getElementById("amdmobo");
  var y = document.getElementById("intelmobo");
  if (x.style.display === "none") {
    x.style.display = "block";
	y.style.display ="none";
  } else {
    x.style.display = "none";
 }
}
		function myFunction4() {
  var y = document.getElementById("intelmobo");
  var x = document.getElementById("amdmobo");
  if (y.style.display === "none") {
    y.style.display = "block";
	x.style.display = "none";
  } else {
    y.style.display = "none";
 }
}

</script>
</body>
</html>