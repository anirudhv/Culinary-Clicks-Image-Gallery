<?php
session_start(); //start new or resume existing session
$_SESSION["view"] = ""; //set session variable "view" to an empty string -- this is for the index.php page
//if user is not a Super Admin, send them to the index.php page
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
  <title>Add User</title> <!-- title of page -->
</head> <!--close head tag -->

<body> <!-- open body tag-->
  <?php

  include("includes/header.php"); //include the header.php page contents
  include("includes/OpenDBConn.php"); //include OpenDBConn.php which checks to see if database connection was successful
  ?>

  <center><b><h3>Add New User</h3></b></center><br> <!-- title text -->
  <?php if(!empty($_SESSION["errormessage"])) { //if the errormessage session variable isn't empty?> 
  <div class="alert alert-warning" role="alert"> <!--display error message -->
  <?php echo $_SESSION["errormessage"]; ?>
</div>
<?php } ?>
  <form action="doAddNew.php" method="POST" role="form" class="form-horizontal"> <!--form to add new user -->
  <div class="form-group">
    <label for="firstname">First Name</label> <!--first name -->
    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Please enter the user's first name.">
  </div>
  <div class="form-group">
    <label for="lastname">Last Name</label> <!-- last name -->
    <input type="text" class="form-control" name = "lastname" id="lastname" placeholder="Please enter the user's last name.">
  </div>
  <div class="form-group">
    <label for="username">Username</label> <!-- username -->
    <input type="text" class="form-control" name = "username" id="username" placeholder="Please enter the user's username.">
  </div>
  <div class="form-group">
    <label for="password">Password</label> <!-- password -->
    <input type="password" class="form-control" name = "password" id="password">
  </div>
    <div>
      <label for="role">Account Type</label> <!--account type -->
      <select size = "10" name = "role" id="role" class="form-control"> <!--dropdown menu -->
        <?php
        $yes = "Yes";
          $sql = "SELECT cuisine FROM Categories WHERE available = '" . $yes. "'"; //select all cuisines available - sql statement
          $result = $conn->query($sql); //process for my database
          if($result->num_rows > 0) { //if there are 0 rows of results
            $num_results = $result->num_rows; //set $num_results to num_rows
        }
      else {
        $num_results = 0; //otherwise set $num_results to 0
      }
      while ($row = $result->fetch_assoc()) { //while there are still elements in the associative array $row
        ?>
        <option value = <?php echo $row["cuisine"];?>> <!--create dropdown value with all the different non-super admin roles available -->
      <?php echo $row["cuisine"];
          ?>
            
          </option>
      <?php } ?>
      <option value = "User">User</option>
      </select> <!--end of dropdown menu -->
      <br><br>
        <center><button type="submit" name = "submit" class="btn btn-primary" value = "submit">Submit</button></center> <!--submit button for form -->
    </div>
</form>
</body> <!--close body -->
</html> <!--close html -->
<?php include("includes/CloseDBConn.php"); ?> <!--close database connection -->