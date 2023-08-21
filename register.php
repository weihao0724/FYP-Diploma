<?php
// Include config file
require_once "php/connection.php";
 
// Define variables and initialize with empty values
$username = $email = $age = $address = $ph =  $password = $confirm_password = "";
$username_err = $ph_err = $age_err = $address_err = $email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"])))
	{
        $username_err = "Please enter a username.";
    } 
	
	if (!preg_match("/^[a-zA-Z-' ]*$/",(trim($_POST["username"])))) 
	{
		$username_err = "Only letters and white space allowed";
	}
	
	else
	{
        // Prepare a select statement
        $sql = "SELECT Customer_ID FROM customer WHERE Customer_name = ?";
        
        if($stmt = mysqli_prepare($connect, $sql))
		{
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
			{
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1)
				{
                    $username_err = "This username is already taken.";
                } 
				else
				{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.name";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
	
	if(empty(trim($_POST["email"])))
	{
		$email_err = "email is required.";
	}
	
	if (!filter_var(($_POST["email"]), FILTER_VALIDATE_EMAIL)) 
	{
	  $email_err = "Invalid email format";
	}
	
	else
	{
        // Prepare a select statement
        $sql = "SELECT Customer_ID FROM customer WHERE Customer_Email = ?";
        
        if($stmt = mysqli_prepare($connect, $sql))
		{
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
			{
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1)
				{
                    $email_err = "This email is already taken.";
                } 
				
				else
				{
                    $email = trim($_POST["email"]);
                }
            }
			
			else
			{
                echo "Oops! Something went wrong. Please try again later.email";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
	
    //Validate phone number
	if(empty(trim($_POST["ph"])))
	{
		$ph_err = "Phone number is required.";
	}
	if(strlen(trim($_POST["ph"])) < 10 || strlen(trim($_POST["ph"])) > 12)
	{
        $ph_err = "Please enter a valid phone number.";
    } 
	else
	{
		
		$sql = "SELECT Customer_ID FROM customer WHERE Customer_Contact_num = ?";
		
		if($stmt = mysqli_prepare($connect, $sql))
		{
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_ph);
            
            // Set parameters
            $param_ph = trim($_POST["ph"]);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
			{
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1)
				{
                    $ph_err = "This Phone number is already taken.";
                } 
				
				else
				{
                    $ph = trim($_POST["ph"]);
                }
            }
			
			else
			{
                echo "Oops! Something went wrong. Please try again later.PH number";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
	
	//Validate age
	if(empty(trim($_POST["age"])))
	{
		$age_err = "age is required.";
	}
	else if($_POST["age"] < 18 )
	{
        $age_err = "age requirment is at least 18.";
    }
	else if($_POST["age"] > 120 )
	{
        $age_err = "age requirment is under 120";
    }
	else
	{
		$age = trim($_POST["age"]);
	}
	
	//Validate address
	if(empty(trim($_POST["address"])))
	{
		$address_err = "address is required.";
	}
	else
	{
		$address = trim($_POST["address"]);
	}
	 
    // Validate password
    if(empty(trim($_POST["password"])))
	{
        $password_err = "Please enter a password.";     
    } 
	else if(strlen(trim($_POST["password"])) < 8)
	{
        $password_err = "Password must have atleast 8 characters.";
    } 
	else
	{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($ph_err) && empty($address_err) && empty($age_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO customer (Customer_name, Customer_Contact_num, customer_age, Customer_Address, Customer_Email, Customer_password) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($connect, $sql))
		{
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_ph, $param_age, $param_address, $param_email, $param_password);
            
            // Set parameters
            $param_username = $username;
			$param_ph		= $ph;
			$param_age		= $age;
			$param_address 	= $address;
			$param_email	= $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
			{
                // Redirect to login page
                header("location: Log_in.php");
            }
			
			else
			{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($connect);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body,object{ font: 14px sans-serif; }
        .wrapper{ max-width: 500px;max-height: 500px; margin: auto; margin-top: 75; padding: 20px; }
		p,h2{
			color:black;
		}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
			
			<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
			
			<div class="form-group <?php echo (!empty($ph_err)) ? 'has-error' : ''; ?>">
                <label>Phone number</label>
                <input type="tel" size="15" maxlength="15" name="ph" class="form-control" value="<?php echo $ph; ?>">
                <span class="help-block"><?php echo $ph_err; ?></span>
            </div> 
			
			<div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                <label>Age</label>
                <input type="number" name="age" class="form-control" value="<?php echo $age; ?>">
                <span class="help-block"><?php echo $age_err; ?></span>
            </div> 
			
			<div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                <span class="help-block"><?php echo $address_err; ?></span>
            </div> 
			
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
			
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
			
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
			
            <p>Already have an account? <a href="Log_in.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>