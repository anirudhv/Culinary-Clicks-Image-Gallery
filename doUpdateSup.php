<?php
session_start(); //start new or resume existing session
include("includes/OpenDBConn.php"); //include OpenDBConn.php to check if database connection was successful.


if(empty($_POST["description"])) { //if user didn't enter a caption
	$_POST["description"] = "No caption provided."; //update their input to say so.
}

$sql = "UPDATE Images SET imgDesc = '" . $_POST["description"] . "'WHERE imageID = '". $_POST["category"] . "'"; //sql statement to update Images form with the user's new Image description for selected image.
$result = $conn->query($sql); //process sql statement for my database.
$_SESSION["badFileType"] = $_POST["category"] . "  image caption successfully changed."; //set badFileType to success message
include("includes/CloseDBConn.php"); //include closeDBConn.php which closes database connection
header("Location:manImg.php"); //send user to manImg.php
exit; //exit page
?>
