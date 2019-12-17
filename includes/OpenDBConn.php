<?php 
$db_host = "165.22.191.102"; //set database host variable to server address
$db_name = "project02venkataramanan"; //set database name variable to the name database username
$db_username = "anirudhv"; //set database username variable to username used to login to phpMyAdmin
$db_password = "password"; //ust database password variable to password used to login to phpMyAdmin

$conn = new mysqli($db_host, $db_username, $db_password, $db_name); //set conn variable to a new mysqli variable which takes the previously declared local variables as paramaters. 

if($conn->connect_error) //If there is a connection error
{
	die("Connection Failed:" . $conn->connect_error); //end the connection
	header("location:index.php"); //redirect user to index page
}
?>
