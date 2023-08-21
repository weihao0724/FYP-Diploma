<?php include("php/connection.php"); ?> 
<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
// Instantiation and passing `true` enables exceptions
if(isset($_POST["email"]))
{
	$emailTo = $_POST["email"];
	$code = uniqid(true);
	$query = mysqli_query($connect,"INSERT INTO resetpassword(Resetcode,email) VALUES('$code','$emailTo')");
	if(!$query)
	{
		exit("Error");
	}
	$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'justintechstore@gmail.com';                     // SMTP username
    $mail->Password   = 'JITstore@password';                               // SMTP password
    $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('justintechstore@gmail.com', 'JIT PC STORE');
    $mail->addAddress("$emailTo");     // Add a recipient
    $mail->addReplyTo('no-reply@example.com', 'No Reply');
    // Attachments

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
	$url ="http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/resetpassword.php?code=$code";
    $mail->Subject = 'Forgot Password';
    $mail->Body    = "Please reset your Password by the <a href='$url'>Link</a> provided.";
    $mail->AltBody = 'Please reset your password';

    $mail->send();
    echo 'Reset Password link has been sent to your email';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
	exit();
}

?>
	<form method="POST">
	<div class="login-panel" align="center">
		
	<input type="text" name="email" placeholder="Email" autocomplete="off">
	<br>
	<input type="submit" name="submit" value="Reset Password">
			</form>
