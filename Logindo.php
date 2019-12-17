<?php
session_start(); //start or resume session
include("includes/OpenDBConn.php"); //include openDBConn.php page which checks to see if database connection is successful
//set local variables to posted variables from login form
$username = addslashes($_POST["username"]);
$password = addslashes($_POST["password"]);

$ip = $_SERVER['REMOTE_ADDR']; //get user ip address
$httphost = $_SERVER['HTTP_HOST']; //get user httphost
$date = date(FdY); //get date of login
$time = date(hiae); //get time of login (UTC)
$success = "No"; //set success (for successful login) to No for now
$useragent = $_SERVER['HTTP_USER_AGENT']; //get HTTP_USER_AGENT
$sql2 = "INSERT INTO `Logging`(`REMOTE_ADDR`, `HTTP_HOST`, `Date`, `Time`, `UserID`, `HTTP_USER_AGENT`, `Success`) VALUES ('" . $ip . "', '" . $httphost . "', '" . $date . "', '" . $time . "', '" . $username . "', '" . $useragent . "', '" . $success . "')"; //create sql statement - $sql2 - to insert the above variables into database table Logging

//test to see if all fields are filled in
if($username == ""){ //if username is empty
	$_SESSION["errormessage"] = "You must enter a username!!"; //set appropriate error message
	$_SESSION["status"] = ""; //set status session variable status to blank
	$result = $conn->query($sql2); //process $sql2 for my database
	header("location:index.php"); //return user to login.php page
	exit; //exit program
}
else if($password == "") { //if password is empty
	$_SESSION["errormessage"] = "You must enter a password!!"; //set appropriate error message
	$_SESSION["status"] = "";  //set session variable status to blank
	$result = $conn->query($sql2); //process $sql2 for my database
	header("location:index.php"); //return user to login.php page
	exit; //exit program
}
else {
	$_SESSION["errormessage"] = ""; //otherwise, make the error message an empty string
} 

$sql = "SELECT username FROM Users WHERE username ='". $username. "'"; //create sql statement that selects  usernames with the user inputted username from login form

$result = $conn->query($sql); //process sql statement in our database
if($result->num_rows > 0) { //if there are more than 0 rows in the result variable
	$num_results = $result->num_rows; //set $num_results to num_rows
}
else {
	$num_results = 0; //otherwise set $num_results to 0
}

if($num_results == 0) { //if $num_results is  0 
	$_SESSION["errormessage"]="Invalid username!"; //update session error message
	$_SESSION["status"] = ""; //set session variable status to blank string
	$result = $conn->query($sql2); //process $sql2 for my database
	header("location:index.php"); //send user to login.php
	exit; //stop running code on this page
}
else {
	$_SESSION["errormessage"] = ""; //otherwise, make the errormessage a blank string
}
$sql = "SELECT password FROM Users WHERE username = '" .$username. "'"; //create sql statement that selects  passwords with the user inputted username from login form
$result = $conn->query($sql); //process sql statement for our database
$row = $result->fetch_assoc(); //get the sql output in an array. since there is only one username-password combo, the array only has a length of 1. 
if($row["password"] != $password) { //if the user inputted password is not equal to the password stored in the database
	$_SESSION["errormessage"] = "Incorrect password!"; //set appropriate error message
	$_SESSION["status"] = ""; //set session variable status to blank string
	$result = $conn->query($sql2); //process $sql2 for my database
	header("location:index.php"); //send user to login.php
	exit;
}
else {
	$_SESSION["errormessage"] = ""; //otherwise, make the error message a blank string
	$_SESSION["errormessage2"] = "";
}
$sql = "SELECT firstname, lastname, role FROM Users WHERE username = '" .$username . "'"; //select the first name, last name, and role from the table where the username is the user-inputted username
$result = $conn->query($sql); //process sql statement for our database
$row = $result->fetch_assoc(); //put sql output in array. array should be of length 1.
$_SESSION["firstname"] = $row["firstname"]; //save output from sql statement into session variables.
$_SESSION["lastname"] = $row["lastname"];
$_SESSION["role"] = $row["role"];
//update status session variable with the status of the user.
$_SESSION["loggedin"] = "true"; //set loggedin session variable to true
	$success = "Yes"; //set local variable success to YES
	$sql2 = "INSERT INTO `Logging`(`REMOTE_ADDR`, `HTTP_HOST`, `Date`, `Time`, `UserID`, `HTTP_USER_AGENT`, `Success`) VALUES ('" . $ip . "', '" . $httphost . "', '" . $date . "', '" . $time . "', '" . $username . "', '" . $useragent . "', '" . $success . "')"; //update $sql2 sql statement with the changed Success Field from No to Yes
	$result = $conn->query($sql2); //process sql statement for my database
include("includes/CloseDBConn.php"); //include closeDBConn.php which closes database connection
header("location:index.php"); //send user to index.php page
?>