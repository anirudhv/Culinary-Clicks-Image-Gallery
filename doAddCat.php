<?php 
session_start(); //start new or resume existing session
if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["category"]))
{ //if the user entered a cuisine name with special characters
    $_SESSION["badInput"] = "No special characters, numbers or spaces allowed. If a cuisine you would like to enter is multiple words, do not include spaces between the words. For example, 'Saudi Arabian' would be represented as 'SaudiArabain'."; //create an error message that tells them this is not allowed.
    header("Location:supAdminCuisine.php"); //redirect to cuisine category manager page
    exit; //exit current page
}
else if (preg_match('~[0-9]+~', $_POST["category"])) { //if user entered a cuisine name with numbers
    $_SESSION["badInput"] = "No special characters, numbers or spaces allowed. If a cuisine you would like to enter is multiple words, do not include spaces between the words. For example, 'Saudi Arabian' would be represented as 'SaudiArabain'."; //create an error message that tells them this is not allowed.
    header("Location:supAdminCuisine.php"); //redirect to cuisine category manager page
    exit; //exit current page
}
else if ( preg_match('/\s/',$_POST["category"]) ) { //if the user entered a cuisine name with spaces
	$_SESSION["badInput"] = "No special characters, numbers or spaces allowed. If a cuisine you would like to enter is multiple words, do not include spaces between the words. For example, 'Saudi Arabian' would be represented as 'SaudiArabain'."; //create an error message that tells them this is not allowed.
	header("Location:supAdminCuisine.php"); //redirect to cuisine category manager page
	exit; //exit current page
}
else if(empty($_POST["category"])) { //if the user didn't enter any name at all
	$_SESSION["badInput"] = "Please enter a cuisine name."; //create error message telling them to enter one
}
else {
	$_SESSION["badInput"] = ""; //if the user entered a name that met all the guidlines, make the badInput session variable blank.
}

include("includes/OpenDBConn.php"); //include OpenDBConn.php to connect to database.
$sql = "SELECT * FROM Categories"; //select all elements from Categories Table
$result = $conn->query($sql); //process query for my database
if($result->num_rows > 0) { //if more than 0 rows of results come up
	$num_results = $result->num_rows; //set $num_results to num_rows
}
else {
	$num_results = 0; //otherwise set $num_results to 0
}
if($num_results > 0) { //if $num_results > 0
	 while ($row = $result->fetch_assoc()) { //while there are still rows of elements left in the associative array $result
	 	if($row["cuisine"] == $_POST["category"]) { //if the cuisine that the user entered is already in the database
	 		if($row["available"] == "No") { //if the cuisine is disabled
	 			$sql2 = "UPDATE Categories SET available = 'Yes' WHERE cuisine = '" . $_POST["category"] . "'"; //sql statement to re-enable that category by changing available from No to Yes
	 			$result2 = $conn->query($sql2); //process query for my database.
	 			$_SESSION["badInput"] = $_POST["category"] . " Cuisine successfully added."; //set badInput session variable to let user know that cuisine was added.
	 			header("Location:supAdminCuisine.php"); //go back to super admin cuisine category manager.
	 			exit; //exit page
	 		}
	 		else { //otherwise, if Available is Yes
	 			$_SESSION["badInput"] = "Cuisine " . $_POST["category"] . " already exists."; //set badInput session variable to tell the user that the category they entered already exists.
	 			header("Location:supAdminCuisine.php"); //go to supAdminCuisine.php
	 			exit; //exit page
	 		}
	 	}
	 }
} //if the category is not already in the database
	 $ans = "Yes";
	 $sql3 = "INSERT INTO Categories(cuisine, available) VALUES ('". $_POST["category"] . "', '" . $ans."')"; //create sql statement to add it to database and make it available
	 $result3 = $conn->query($sql3); //process query for my database
	 $_SESSION["badInput"] = $_POST["category"] . " Cuisine successfully added."; //set badInput session variable to success message
	 header("Location:supAdminCuisine.php"); //go to supAdminCuisine.php
	 include("includes/CloseDBConn.php"); //include closeDBConn.php which closes database connection
	exit; //exit page

?>