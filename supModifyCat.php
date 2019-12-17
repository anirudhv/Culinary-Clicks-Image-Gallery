<?php
session_start(); //start new or resume existing session
$_SESSION["view"] = ""; //set session variable "view" to an empty string -- this is for the index.php page
//if user's role is not super admin or has not selected cuisine admin user to modify, redirect to index.php and exit this page
if($_SESSION["role"] != "Super Admin") {
    header("Location:index.php");
    exit;
}
if(empty($_SESSION["modify"])) {
  header("Location:supModifyUser.php");
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
  include("includes/OpenDBConn.php"); //include OpenDBConn.php which checks to see if database connection was successful
  ?>

  <center><b><h3>Modify Existing User</h3></b></center><br> <!-- title text -->
  <?php if(!empty($_SESSION["errormessage"])) { //if session variable errormessage is not empty, display its contents ?>
  <div class="alert alert-warning" role="alert">
  <?php echo $_SESSION["errormessage"]; ?>
</div>
<?php } ?>
  <form action="doModifyChange.php" method="POST" role="form" class="form-horizontal"> <!--form to choose new cuisine for cuisine admin user to manage -->
    <div>
      <label for="role">Select a new Cuisine for Cuisine Admin user <?php echo $_SESSION["modify"]; ?> to be an Admin of</label> <!--instructions -->
      <select size = "10" name = "role" id="role" class="form-control"> <!--dropdown menu -->
        <?php
          $sql = "SELECT cuisine FROM Categories WHERE available = 'Yes'"; //sql statement to select all available cuisines 
          $result = $conn->query($sql); //process sql statement for my database
          if($result->num_rows > 0) { //if there are more than 0 rows of results
            $num_results = $result->num_rows; //set $num_results to num_rows
        }
      else {
        $num_results = 0; //otherwise set $num_results to 0
      }
      while ($row = $result->fetch_assoc()) { //while there is still data in the associative array $row
        ?>
        <option value = <?php echo $row["cuisine"];?>><?php echo $row["cuisine"];?></option> <!--create dropdown menu options with the cuisine for each row -->
      <?php } ?>
      </select>  
      <br><br>
        <center><button type="submit" name = "submit" class="btn btn-primary" value = "submit">Submit</button></center> <!--submit button -->
    </div>
</form> <!--end form -->
</body> <!-- end body -->
</html> <!-- end html -->
<?php include("incliudes/CloseDBConn.php");  //close database connection ?>