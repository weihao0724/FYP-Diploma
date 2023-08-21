<?php 
session_start();

if(isset($_SESSION["adminloggedin"]) && $_SESSION["adminloggedin"] === true)
{
	$_SESSION["php"] = false;
	header("location: admin_dashboardpage.php");
	exit;
}

require_once "../php/connection.php";

$username = $password = "";
$username_err = $password_err = "";

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	/*check validation of username and password*/
	if(empty(trim($_POST["username"])))
	{
		$username_err = "Please enter username/email.";
	}
	else
	{
		$username = trim($_POST["username"]);
	}
	
	if(empty(trim($_POST["password"])))
	{
		$password_err = "Please enter password.";
	}
	else
	{
		$password = trim($_POST["password"]);
	}
	/*end of checking*/
	
    if(empty($username_err) && empty($password_err))
	{
        $sql = "SELECT Staff_ID, Staff_Name, Staff_Pass FROM staff WHERE Staff_Name = ?";
		$emailsql = "SELECT Staff_ID, Staff_Name, Staff_Pass FROM staff WHERE Staff_Email = ?";
        
		if(strpos($_POST["username"], "@") === false)
		{
			if($result = mysqli_prepare($connect, $sql))
			{
				mysqli_stmt_bind_param($result, "s", $param_username);
				$param_username = $username;

				if(mysqli_stmt_execute($result))
				{
					mysqli_stmt_store_result($result);

					if(mysqli_stmt_num_rows($result) == 1)
					{
						mysqli_stmt_bind_result($result, $id, $username, $hashed_password);
						if(mysqli_stmt_fetch($result))
						{
							if(password_verify($password, $hashed_password))
							{
								session_start();

								$_SESSION["adminloggedin"] = true;
								$_SESSION["admin_id"] = $id;
								$_SESSION["admin_name"] = $username;                            

								/*go to admin home page*/
								$_SESSION["php"] = false;
								header("location: admin_dashboardpage.php");
							} 
							else
							{
								$password_err = "The password you entered was not valid.";
							}
						}
					} 
					else
					{
						$username_err = "No account found with that username.";
					}
				} 
				else
				{
					echo "Oops! Something went wrong. Please try again later.";
				}
				mysqli_stmt_close($result);
			}
		}
		else
		{
			if($result = mysqli_prepare($connect, $emailsql))
			{
				mysqli_stmt_bind_param($result, "s", $param_email);
				$param_email = $username;

				if(mysqli_stmt_execute($result))
				{
					mysqli_stmt_store_result($result);

					if(mysqli_stmt_num_rows($result) == 1)
					{
						mysqli_stmt_bind_result($result, $id, $username, $hashed_password);
						if(mysqli_stmt_fetch($result))
						{
							if(password_verify($password, $hashed_password))
							{
								session_start();

								$_SESSION["adminloggedin"] = true;
								$_SESSION["admin_id"] = $id;
								$query = "select Staff_Name from staff where Staff_ID = " . $id;
								$status = mysqli_query($connect, $query);
								$row = mysqli_fetch_array($status);
								$_SESSION["admin_name"] = $row["Staff_Name"];                       

								/*go to admin home page*/
								$_SESSION["php"] = false;
								header("location: admin_dashboardpage.php");
							} 
							else
							{
								$password_err = "The password you entered was not valid.";
							}
						}
					} 
					else
					{
						$username_err = "No account found with that username.";
					}
				} 
				else
				{
					echo "Oops! Something went wrong. Please try again later.";
				}
				mysqli_stmt_close($result);
			}
		}
    }
    mysqli_close($connect);
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JIT - Admin Login Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="style/admin_login.php">
	<link rel="shortcut icon" type="image/x-icon" href="../image/JIT logo.png">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
</head>

<body>
	<div class="show-top">
		<div class="weblogo">
			<a href="../">
				<img src="../image/JIT logo-light.png" alt="JIT logo" />
			</a>
		</div>
	</div>
	
	<div class="login-panel" align="center">
		<h1>Admin Login</h1>
		<div class="login-form">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="input-div mail  <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
					<div class="icon">
           		   		<i class="material-icons-round">person</i>
           		    </div>
					<div class="input-wrap">
						<h5>Username/Email</h5>
						<input type="text" class="input" name="username" value="">
					</div>
				</div><span class="help-block"><?php echo $username_err; ?></span>
				
				<div class="input-div pass <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
					<div class="icon"> 
           		    	<i class="material-icons-round">lock</i>
           		    </div>
					<div class="input-wrap">
						<h5>Password</h5>
						<input type="password" class="input" name="password" id="input-pass">
					</div>
				</div>
				<span class="help-block"><?php echo $password_err; ?></span>
				
				<div class="showpass">
					<input type="checkbox" onClick="showpass()" class="show-pass" title="Show Password"><span class="show-text">Show Password</span><br>
				</div>
				
				<a href="php/resetpass.php"><p class="forgot-pw">Forgot password?</p></a><br><br>
				<div class="button-warp">
					<div class="login-button-warp"></div>
					<button type="submit" class="login-button" value="login" name="login">Login</button>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="js/admin_login.js"></script>
</body>
</html>
