<?php

session_start();
	
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
	$id = 0;
}
else
{
	$id = $_SESSION["id"];
}
echo"<div class='col-md-9'>";
echo"<div class='row'>";
//fetch_data.php


include('php/connection.php');


if(isset($_POST["action"]))
{
	$query = "SELECT * FROM part INNER JOIN category ON part.Category_ID = category.Category_ID WHERE part.Part_isDelete = '0' ";
	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= "
		 AND Part_Price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		";
	}
	if(isset($_POST["category"]))
	{
		$category_filter = implode("','", $_POST["category"]);
		$query .= "
		 AND Category_Name IN('".$category_filter."')
		";
	}
	


	$result = mysqli_query($connect, $query);

	while($row = mysqli_fetch_assoc($result))
	{
	
	
	?>
		
		<div class="col-md-4 col-sm-6 col-xs-12 margin_bottom_30_all">
		<div class="product_list">
		<div class="product_img"><a href="product_details.php?view&pid=<?php echo $row['Part_ID']; ?>"><img src="<?php echo $row['image']; ?>" alt="" class="img-responsive" style="height:200px; width:100%;"></a></div>
		<div class="product_detail_btm">
		<form method="post" action="">
		<div class="center">
		<h4 style="height : 60px;"><?php echo $row['Part_Name']; ?></h4>
		</div>
		<p><h4 class="center"><?php echo "RM".number_format( $row['Part_Price'],2); ?></h4></p>
		<input type="hidden" name="Part_ID" value="<?php echo $row['Part_ID']; ?>"/>
		<input type="hidden" name="Part_Price" value="<?php echo $row['Part_Price']; ?>"/>
		<input type="hidden" name="qty" value="1"/>
	<?php
		if($row["Stock"] != 0)
		{
		if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
		{
	?>
		<a href="Log_in.php" class="btn sqaure_bt light_theme_bt" style="width:100%;">Add to cart</a>
	<?php
		}
		else
		{
	?>
		<button type="submit" class="btn sqaure_bt light_theme_bt" style="width:100%;">Add to Cart</button>
		
	<?php
		}
		}
		else
		{
	?>
		<button type="submit" class="btn sqaure_bt light_theme_bt" disabled style="width:100%;">Out of Stock</button>
	<?php
		}
	?>
	
		</form>
		
		</div>
		</div>
        </div>
	
	<?php

	
	
	}
	

	  mysqli_close($connect);
		
	  if(isset($_REQUEST["pid"]))
	  {
	   $pid = $_REQUEST["pid"];
	   mysqli_query($connect, "delete from part where Part_ID = $pid");
	   
	   header("Location: fetch_data.php");
	  }

}
echo"</div>";
echo"</div>";

?>