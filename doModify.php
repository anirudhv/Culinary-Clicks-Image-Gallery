<?php
session_start(); //start new or resume existing session
if(empty($_POST["username"])) { //if super admin did not select a cuisine admin whose account they want to modify
	$_SESSION["errormessage"] = "Please select a Cuisine Administrator whose account you want to modify."; //set session errormessage telling them to do so
	header("Location:supModifyUser.php"); //send super admin to supModifyUser.php
	exit; //exit page
}
$_SESSION["modify"] = $_POST["username"]; //set modify session variable to the username of the cuisine admin who the super admin wants to modify
$_SESSION["errormessage"] = ""; //make session errormessage empty
header("Location:supModifyCat.php"); //send super admin to supModifyCat.php
exit; //exit page
?>