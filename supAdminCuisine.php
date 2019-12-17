<?php
session_start(); //start new or resume existing session
$_SESSION["view"] = ""; //set session variable "view" to an empty string -- this is for the index.php page
//if user is not of role Super Admin, redirect them to index.php and exit page
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
  <title>Cuisine Manager</title> <!-- title of page -->
</head> <!--close head tag -->

<body> <!-- open body tag-->
  <?php

  include("includes/header.php"); //include the header.php page contents
  include("includes/OpenDBConn.php"); //include OpenDBConn.php which checks to see if database connection was successful
  ?>

  <center><b><h3>Cuisine Category Manager</h3></b></center><br> <!--title text -->
  <?php if(!empty($_SESSION["badInput"])) { //if badInput session variable is not empty?>
  <div class="alert alert-info" role="alert"> <!--display what it contains -->
  <center><?php echo $_SESSION["badInput"]; ?></center>
</div>
<?php } ?>
 
 <nav>
  <!--boostrap tab layout -->
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Add Cuisine</a> <!--add cuisine -->
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Delete Cuisine</a> <!--delete cuisine -->
  </div>
</nav>
<div class="tab-content" id="nav-tabContent"> <!--add cuisine tab content -->
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"> 
  <form id="form0" method="post" action="doAddCat.php" enctype="multipart/form-data"> <!--form for user to enter new cuisine name -->
    <div class="form-group">
    <label for="category">Cuisine Name</label>
    <input type="text" class="form-control" id="category" name = "category" placeholder="Please enter a cuisine name."> <!--enter cuisine name here -->
  </div>
  <br><br>
        <br><br>
        <button type="submit" class="btn btn-primary" value = "submit">Add Cuisine</button> <!--submit button -->
</form>
</div>
  <!--tab content for delete cuisine-->
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  <form id = "form0" action = "doRemCat.php" method = "POST" enctype="multipart/form-data"><!--form with action being doRemCat.php and method being POST-->
  <select size = "7" class="form-control form-control-lg" name = "imgs" id = "imgs"><!--dropdown menu in form to select cuisine to delete-->
    <?php 
      $sql = "SELECT cuisine FROM Categories WHERE available = 'Yes'"; //sql statement to select all the available cuisine elements from table Categories
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
 <center><button type="submit" class="btn btn-primary">Delete Cuisine</button></center><!--button to submit form to doRemCat.php-->
</form> <!--close form tag -- end of form -->
</div>
</div>

</body><!--close body -->
</html>  <!--close html-->

<?php include("includes/CloseDBConn.php"); //include closeDBConn.php which closes database connection ?>