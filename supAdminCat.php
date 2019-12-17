<?php
session_start(); //start new or resume existing session
$_SESSION["view"] = ""; //set session variable "view" to an empty string -- this is for the viewImage.php page
$_SESSION["man"] = "";
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"); //echo opening xml statement
//if user is not a super admin, send them to index.php
if($_SESSION["role"] != "Super Admin") {
  header("Location:index.php");
  exit;
}
?>

<!DOCTYPE html> <!-- set DOCTYPE to html -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> <!--set xml version-->
<head> <!--open head tag-->
  <meta charset="utf-8" /> <!-- set charset -->
  <title>Cuisine Selection - Image Manager</title> <!-- title of page -->
</head> <!--close head tag -->

<body> <!-- open body tag-->
  <?php

  include("includes/header.php"); //include the header.php page contents
  include("includes/OpenDBConn.php"); //include OpenDBConn.php to see if database connection was successful
?>

<center><b> Please select a cuisine to manage its images. <?php echo $_SESSION["man"] ?></b></center> <!--instrictions -->
<?php if($_SESSION["err"] != "") { //if session variable err is not empty ?>
  <div class="alert alert-danger" role="alert"> <!-- display error -->
  <center> <?php echo $_SESSION["err"]; ?> </center>
</div>
<?php } ?>
<form id = "form0" name = "form0" action = "doManImg.php" method = "POST"><!--form with action being doManImg.php and method being POST-->
  <select size = "7" class="form-control form-control-lg" name = "imgs" id = "imgs"><!--dropdown menu in form to select category to manage. -->
    <?php 
      $sql = "SELECT cuisine FROM Categories WHERE available = 'Yes'"; //sql statement to select all the cuisine elements from table Categories that are available for use
      $result = $conn->query($sql); //process sql statement for my database
      if($result->num_rows > 0) { //if there are more than 0 rows of elements in the result variable
          $num_results = $result->num_rows; //set $num_results to num_rows
        }
      else {
        $num_results = 0; //otherwise set $num_results to 0
      }

    while ($row = $result->fetch_assoc()) { //while there are still rows of cuisine elements left in the associative array $result

    ?>
  <option value = <?php echo $row["cuisine"]; ?>><?php echo $row["cuisine"]; ?></option> <!-- create a form dropdown menu element with the text being the cuisine in the current row in $result-->
<?php } ?> <!-- close while loop -->
</select> <!--close select tag -- end of dropdown menu -->
<br> <!--new line-->
 <center><button type="submit" name = "submit" id = "submit" value = "Manage Cuisine Image Gallery" class="btn btn-primary">Manage Cuisine Image Gallery</button></center><!--button to submit form to doManImg.php-->
</form> <!--close form tag -- end of form -->
</body> <!--close body -->
</html> <!-- close html -->

<?php include("includes/CloseDBConn.php"); //include closeDBConn.php which closes database connection ?>