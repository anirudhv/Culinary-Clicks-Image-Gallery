<?php 
session_start(); //start new or resume existing session

$_SESSION["view"] = $_POST["imgs"]; //set session variable view to the image selected from the form dropdown menu in the uploadResizeform.php page

header("Location:index.php"); //redirect user to the viewImage.php page
exit; //exit page; stop running code 
?>