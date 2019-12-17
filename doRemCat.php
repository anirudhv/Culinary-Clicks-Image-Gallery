<?php
session_start(); //start new or resume existing session
if(empty($_POST["imgs"])) { //if user didn't select category to remove
	$_SESSION["badInput"] = "Please select a cuisine to delete."; //set badInput to tell them to do so
	header("Location:supAdminCuisine.php"); //go to supAdminCuisine.php
	exit; //exit page
}
include("includes/OpenDBConn.php"); //include OpenDBConn.php to check if database connection was successful.
$sql = "UPDATE Categories SET available = 'No' WHERE cuisine = '" . $_POST["imgs"] . "'"; //disable cuisine by setting available to no in Categories table - sql statement
$result = $conn->query($sql); //process sql statement for my database
$_SESSION["badInput"] = $_POST["imgs"] . " Cuisine successfully deleted."; //set badInput to success message
include("includes/CloseDBConn.php"); //include closeDBConn.php which closes database connection
header("Location:supAdminCuisine.php"); //send user to supAdminCuisine.php
exit; //exit page
?>