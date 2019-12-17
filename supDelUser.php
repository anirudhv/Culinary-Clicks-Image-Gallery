<?php
session_start(); //start new or resume existing session
$_SESSION["view"] = ""; //set session variable "view" to an empty string -- this is for the index.php page
//if user is not of role Super Admin, redirect them to index.php
if($_SESSION["role"] != "Super Admin") {
    header("Location:index.php");
    exit;
}
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"); //echo opening xml statement
?>

<!DOCTYPE html> <!-- set DOCTYPE to html -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> <!--set xml version-->
<head> <!--open head tag-->
  <meta charset="utf-8" /> <!-- set charset -->
  <title>Delete User</title> <!-- title of page -->
</head> <!--close head tag -->

<body> <!-- open body tag-->
  <?php

  include("includes/header.php"); //include the header.php page contents
  include("includes/OpenDBConn.php"); //include OpenDBConn.php which checks if database connection was successful
  ?>

  <center><b><h3>Permanently Delete Existing User</h3></b></center><br> <!--title text -->
  <?php if(!empty($_SESSION["errormessage"])) { //if session variable errormessage is not empty, display the contents of the session variable ?>
  <div class="alert alert-warning" role="alert">
  <center><?php echo $_SESSION["errormessage"]; ?></center>
</div>
<?php } ?>
  <form action="doDelUser.php" method="POST" role="form" class="form-horizontal"> <!--form to delete users -->
    <div>
      <label for="role">Select a Cuisine Admin or Regular User to permanently revoke their login access from the website.</label>
      <select size = "10" name = "username" id="username" class="form-control"> <!--dropdown menu to select user -->
        <?php
          $sql = "SELECT username, firstname, lastname, role FROM Users WHERE role != 'Super Admin'"; //sql statement to select non-Super Admin users to delete.
          $result = $conn->query($sql); //process query for my database
          if($result->num_rows > 0) { //if there are more than 0 rows of results
            $num_results = $result->num_rows; //set $num_results to num_rows
        }
      else {
        $num_results = 0; //otherwise set $num_results to 0
      }
      while ($row = $result->fetch_assoc()) { //while there are still rows of data in associative array $row
        ?>
        <option value = <?php echo $row["username"];?>> <!--create dropdown options with user info -->
          <?php
          if($row["role"] == "User") {
           echo $row["firstname"] . " " . $row["lastname"] . " | Username - " . $row["username"] . " | Role - " . $row["role"];
          }
          else {
          echo $row["firstname"] . " " . $row["lastname"] . " | Username - " . $row["username"] . " | Role - " . $row["role"] . " Cuisine Admin";
        } ?>
          </option>
      <?php } ?>
      </select>  
      <br><br>
        <center><button type="submit" name = "submit" class="btn btn-primary" value = "submit">Delete User</button></center> <!--submit form contents -->
    </div>
</form> <!--close form-->
</body> <!--close body -->
</html><!--close html-->
<?php include("incliudes/CloseDBConn.php"); //close database connection ?>