<?php
session_start(); //start new or resume existing session
include("includes/OpenDBConn.php"); //include OpenDBConn.php to see if database connection was successful
$sql = "DELETE FROM Images WHERE imageID = '" . $_POST["category"] ."'"; //create sql statement to remove the Image which the user chose to delete in form on previous page
$result = $conn->query($sql); //process sql statement for my database
unlink("upload/". $_POST["category"]); //delete image from upload folder
unlink("thumb/". "th_" . $_POST["category"]); //delete image from thumbnail resized image folder
$sql2 = "ALTER TABLE Images DROP primarykey"; //drop the primary key column in table - sql statement
$result2 = $conn->query($sql2); //process sql statement for my database 
$sql3 = "ALTER TABLE Images ADD primarykey int not null auto_increment primary key first"; //re-add primarykey column (do this to maintain ordering)
$result3 = $conn->query($sql3); //process sql statement for my database
$_SESSION["badFileType"] = $_POST["category"] . " successfully deleted."; //set badFileType to success message
include("includes/CloseDBConn.php"); //include closeDBConn.php which closes database connection
header("Location:catAdmin.php"); //send user to catAdmin.php
exit; //exit page
?>