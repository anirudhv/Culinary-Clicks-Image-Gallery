<?php
session_start(); //start or resume session
//set local variables to posted variables from register form - use addslashes() function to avoid SQL injection
$username = addslashes($_POST["username"]); 
$password = addslashes($_POST["password"]);
$firstname = addslashes($_POST["firstname"]);
$lastname = addslashes($_POST["lastname"]);
$role = addslashes($_POST["role"]);

//test to see if all fields are filled in
if(($username == "") || ($password == "") || ($firstname == "") || ($lastname == "") || ($role == "")) { //if any of the fields were not filled in the register form
	$_SESSION["errormessage2"] = "You must enter a value for all boxes!!"; //set appropriate error message
	$_SESSION["status"] = ""; //set session variable status to empty string
	header("location:index.php"); //return user to index.php page
	exit; //exit program
}
else {
	$_SESSION["errormessage2"] = ""; //otherwise, make the error message an empty string
} 

include("includes/OpenDBConn.php"); //include openDBConn.php page which checks to see if database connection is successful
$sql = "SELECT username FROM Users WHERE username = '" . $username. "'"; //create sql statement that selects  usernames with the user inputted username from register form
$result = $conn->query($sql); //process sql statement in our database
if($result->num_rows > 0) { //if there are more than 0 rows in the result variable
	$num_results = $result->num_rows; //set $num_results to num_rows
}
else {
	$num_results = 0; //otherwise set $num_results to 0
}
if($num_results != 0) { //if $num_results is not 0 
	$_SESSION["errormessage2"]="The username you are trying to create already exists."; //update session error message
	$_SESSION["status"] = ""; //make status session variable blank
	header("location:index.php"); //send user to index.php
	exit; //stop running code on this page
}
else {
	$_SESSION["errormessage"] = "";
	$_SESSION["errormessage2"] = ""; //otherwise, make the errormessage a blank string
}
$sql = "INSERT INTO `Users`(`username`, `password`, `firstname`, `lastname`, `role`) VALUES ('".$username."', '".$password."', '".$firstname."', '".$lastname."', '".$role."')"; //sql statement to insert user inputted values into database
$result = $conn->query($sql); //process sql statement for our database
$_SESSION["status"] = "You have successfully registered! You may now login."; //set status message
include("includes/CloseDBConn.php"); //include closeDBConn.php which closes database connection
header("location:index.php"); //send user to index.php page
?>