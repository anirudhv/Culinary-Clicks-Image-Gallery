<?php
session_start(); //start new or resume existing session
if(empty($_POST["username"])) { //if super admin did not select user account to remove in previous page form
	$_SESSION["errormessage"] = "Please select a user account to delete."; //set error message to let super admin know
	header("Location:supDelUser.php"); //send super admin to supDelUser.php
	exit; //exit page
}
include("includes/OpenDBConn.php"); //include OpenDBConn.php to see if database connection was successful
$sql = "DELETE from Users WHERE username = '" . $_POST["username"] ."'"; //sql statement to delete the username which the user chose in previous page's form
$result = $conn->query($sql); //process sql statement for my database
$sql2 = "ALTER TABLE Users DROP primarykey"; //drop primarykey in Users Table
$result2 = $conn->query($sql2); //process sql statement for my database
$sql3 = "ALTER TABLE Users ADD primarykey int not null auto_increment primary key first"; //re-add primary key to Users table (do this to keep ordering)
$result3 = $conn->query($sql3); //process sql statement for my database
$_SESSION["success"] = "The account for " . $_POST["username"] . " has successfully been removed."; //set success message session variable
$_SESSION["errormessage"] = ""; //make errormessage session variable empty
header("Location:supUsers.php"); //redirect super admin to supUsers.php
?>