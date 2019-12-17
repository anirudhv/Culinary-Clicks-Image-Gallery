<?php
session_start(); //start new or resume existing session
if(empty($_POST["imgs"])) { //if user did not select a cuisine whose images they want to manage
	$_SESSION["err"] = "Please select a cuisine to manage its images."; //set error message telling them to do so.
	header("Location:supAdminCat.php"); //redirect user to supAdminCat.php
	exit; //exit page
}
$_SESSION["man"] = $_POST["imgs"]; //set session variable man to the cusine the user selected in the previous page's form
$_SESSION["err"] = ""; //make the error message blank
header("Location:manImg.php"); //redirect user to manImg.php
exit; //exit page
  ?>
