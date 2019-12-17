<?php
session_start(); //start or resume existing session
session_unset(); //destroy all session variables
session_destroy(); //destroy session
header("location:index.php"); //send user to index.php page.
exit;
?>