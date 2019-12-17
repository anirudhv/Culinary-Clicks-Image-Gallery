<?php
session_start(); //start new or resume existing session
if(empty($_POST["role"])) { //if super admin did not select new cuisine for cuisine admin to modify in prrevious page's form
	$_SESSION["errormessage"] = "Please select a cuisine for Cuisine Admin user " . $_SESSION["modify"] . ".";
	header("Location:supModifyCat.php"); //set error message telling them to do so
	exit;
}
include("includes/OpenDBConn.php"); //include OpenDBConn.php to check if database connection was successful.
$sql = "UPDATE Users SET role = '" . $_POST["role"] . "' WHERE username = '" . $_SESSION["modify"] . "'"; //sql statement to update Users table with new role for selected cusine admin
$result = $conn->query($sql); //process sql statement for my database
$_SESSION["success"] = "Cuisine Admin user " . $_SESSION["modify"] . " is now the admin of the " . $_POST["role"] . " Cuisine."; //set success message.
$_SESSION["errormessage"] = ""; //make errormessage empty
include("includes/CloseDBConn.php"); //close database connection
header("Location:supUsers.php"); //redirect superAdmin to supUsers.php
exit; //exit page
?>