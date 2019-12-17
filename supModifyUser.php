<?php
session_start(); //start new or resume existing session
$_SESSION["view"] = ""; //set session variable "view" to an empty string -- this is for the index.php page
//set session variable modify to an empty string
$_SESSION["modify"] = "";
//if the user isn't super admin, take them to index.php and exit this page
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
  <title>Modify User</title> <!-- title of page -->
</head> <!--close head tag -->

<body> <!-- open body tag-->
  <?php

  include("includes/header.php"); //include the header.php page contents
  include("includes/OpenDBConn.php"); //include OpenDBConn.php which checks to see if database connection was successful.
  ?>

  <center><b><h3>Modify Existing User</h3></b></center><br> <!--title text -->
  <?php if(!empty($_SESSION["errormessage"])) { //if the session variable errormessage is not empty, display its contents ?>
  <div class="alert alert-warning" role="alert">
  <?php echo $_SESSION["errormessage"]; ?>
</div>
<?php } ?>
  <form action="doModify.php" method="POST" role="form" class="form-horizontal"> <!--form to select users of type Cuisine Admin -->
    <div>
      <label for="role">Select a User with an Account Type of Cuisine Admin</label> <!--instructions -->
      <select size = "5" name = "username" id="username" class="form-control">
        <?php
          $sql = "SELECT username, firstname, lastname, role FROM Users WHERE role != 'Super Admin' AND role != 'User'"; //sql statement to select users of type Cuisine Admin
          $result = $conn->query($sql); //process for my database
          if($result->num_rows > 0) { //if more than 0 rows of results are returned
            $num_results = $result->num_rows; //set $num_results to num_rows
        }
      else {
        $num_results = 0; //otherwise set $num_results to 0
      }
      while ($row = $result->fetch_assoc()) { //while there is data left in the associative array $row
        ?>
        <option value = <?php echo $row["username"];?>><?php echo $row["firstname"] . " " . $row["lastname"] . " | Username - " . $row["username"] . " | Admin of - " . $row["role"] . " Cuisine";?></option> <!--display user info in dropdown menu of form -->
      <?php } ?>
      </select>  
      <br><br>
        <center><button type="submit" name = "submit" class="btn btn-primary" value = "submit">Submit</button></center> <!--submit button for form -->
    </div>
</form> <!--form close -->
</body> <!--body close -->
</html> <!-- html close -->
<?php include("incliudes/CloseDBConn.php"); //close database connection?>