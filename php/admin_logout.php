<?php
session_start();
 
$_SESSION = array();
 
/*void session*/
session_destroy();
 
/*back to admin login*/
header("Location: ../../Admin");
exit;
?>