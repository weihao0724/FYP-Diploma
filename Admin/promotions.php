<?php
session_start();
if(!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] != true)
{
	header("location: ../Admin");
	exit;
}

ob_start();

include("../php/connection.php");
$results_per_page = 10;
/*get the page for display the content*/
if(isset($_GET["page"]))
{
	$page = $_GET["page"];
}
else
{
	$page = 1;
}
$start_from = ($page-1) * $results_per_page;

date_default_timezone_set('Asia/Kuala_Lumpur');
$date = date('Y-m-d H:i:s');

$sql = "select * from promotions where Promo_isDelete = 0";
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JIT - Promotions</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="../image/JIT logo.png">
	<link rel="stylesheet" href="style/admin_template.php">
	<link rel="stylesheet" href="style/admin_promo.php">
	<link href="https://fonts.googleapis.com/css?family=Coiny" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
	<script type="text/javascript">
    function delconfirmation()
    {
        choice = confirm("Do you want to delete this promotion?");
        return choice;
    }
	</script>
</head>

<body>
	<!--top navbar-->
	<div id="navbar">
		<?php
		$_SESSION["php"] = false;
		include("hamburger_menu.php");
		?>
	</div>		
	<!--navbar end here-->
	<!--side navbar-->
	<div id="content-panel">
		<div class="side-navbar navheight">
			<?php
			$_SESSION["directory"] = "promotions";
			include("admin_sidenav.php");
			?>
		</div>
		<!--end of side navbar-->
		<div class="main-body">
			<h6>Promotions</h6>
<!--showing promotions list-->
			
			<div id="show-table" class="">
				<table class="cate-table" border="0px">
					<tr>
						<th class="table-id">ID</th>
						<th class="table-code">Promotion Code</th>
						<th class="table-desc">Describe</th>
						<th class="table-value">Amount(RM/%)</th>
						<th class="table-date">Start</th>
						<th class="table-date">End</th>
						<th colspan="3" class="table-action">Action</th>
					</tr>


					<?php
					$check = false;
					$result = mysqli_query($connect, $sql);
					while($row = mysqli_fetch_assoc($result))
					{
						if($date <= $row["Promo_End"])
						{
							$validid = $row["Promo_ID"];
							$newsql = "select * from promotions where Promo_ID = $validid order by Promo_ID asc limit $start_from, ".$results_per_page;
							$newresult = mysqli_query($connect, $newsql);
							$newrow = mysqli_fetch_assoc($newresult);
							?>
							<tr>
								<td class="promo-id"><?php echo $newrow["Promo_ID"];?></td>
								<td class="promo-code"><?php echo $newrow["Promo_Code"];?></td>
								<td class="promo-desc"><?php echo $newrow["Promo_Desc"];?></td>
								<td class="promo-value"><?php echo $newrow["Promo_Value"];?></td>
								<td class="promo-date"><?php echo $newrow["Promo_Start"];?></td>
								<td class="promo-date"><?php echo $newrow["Promo_End"];?></td>
								<form method="post">
									<div class="action-btn">
										<td class="table-edit">
											<a name="editcategory" href="php/promo_edit.php?edit&code=<?php echo $row["Promo_ID"];?>">
												<i class="material-icons-round table-icon">edit</i>
											</a>
										</td>
										<td class="table-del">
											<a href="php/promo_del.php?del&code=<?php echo $row["Promo_ID"];?>" onclick="return delconfirmation();">
												<i class="material-icons-round table-icon">delete</i>
											</a>
										</td>
									</div>
								</form>
							</tr>
							<?php
						}
					}
					?>

				</table>
				<?php
				$data_row = mysqli_query($connect, $sql);
				$row_count = mysqli_num_rows($data_row);
				$total_pages = ceil($row_count / $results_per_page);
				
				for($i = 1; $i <= $total_pages; $i++)
				{
					echo "<a class='pages' href='promotions.php?page=$i'";
					if($i == $page) echo " class='curPage'";
					echo ">".$i,"</a>";
				}
				?>
				<a href="php/promo_add.php">
					<input type="submit" name="addproduct" class="add-btn" value="New Promotion">
				</a>
				
			</div>
<!--end of showing list-->
	</div>
	<div class="credit">2020-2021 Just In Tech<span style="font-size: 15px;">&trade;</span> (JIT)</div>
</body>
</html>