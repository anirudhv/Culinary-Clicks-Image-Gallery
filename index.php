<?php
session_start(); //start new or resume existing session
 //set session variable "view" to an empty string -- this is for the viewImage.php page
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"); //echo opening xml statement
?>

<!DOCTYPE html> <!-- set DOCTYPE to html -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> <!--set xml version-->
<head> <!--open head tag-->
  <meta charset="utf-8" /> <!-- set charset -->
  <title>Home</title> <!-- title of page -->
</head> <!--close head tag -->

<body> <!-- open body tag-->
  <?php

  include("includes/header.php"); //include the header.php page contents
  include("includes/OpenDBConn.php"); //include database connection
  if(empty($_SESSION["view"])) { //if the session variable, view, which is used to help display images for a chosen category, is empty,
    $_SESSION["view"] = "All"; //then set the session variable view to All
  }

  if($_SESSION["loggedin"] == "true" && $_SESSION["role"] != "User" && $_SESSION["role"] != "Super Admin") {
    //if the user is logged in (as shown by the loggedin session variable) and their role (as shown by the role session variable) is neither 'User' or 'Super Admin' (so a Cuisine Admin Role)
?>
<center><b><h1 style ="color:red;"> Welcome, <?php echo $_SESSION["role"] . " Cuisine Admin " . $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?>! </h1></b></center> <!-- welcome text for cusine admin users who are logged in -->

<?php } ?>

<?php 
  if($_SESSION["loggedin"] == "true" && ($_SESSION["role"] == "User" || $_SESSION["role"] == "Super Admin")) {
    //otherwise, if the user's role upon logging in is either 'User' or 'Super Admin'
?>
<center><b><h1 style ="color:red;"> Welcome, <?php echo $_SESSION["role"] . " " . $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?>! </h1></b></center> <!-- User and Super Admin welcome text -->

<?php } ?>
<center><b><h4 style="color:green;"> Welcome to <i>Culinary Clicks</i>, your one-stop shop for anything food image related!</h4></b> <!--wensite intro text -->
<?php if($_SESSION["loggedin"] != "true" && $_SESSION["errormessage2"] != "") { //if the user is not signed in and there were errors in registering for an account ?>
<div class="alert alert-warning" role="alert"> <!-- display error message -->
  We are sorry, but we are unable to register your account at this time due to the following error - <br>
  <?php echo $_SESSION["errormessage2"]; ?> <br>
  Please try again.
</div>
<?php }
if($_SESSION["loggedin"] != "true" && $_SESSION["errormessage"] != "") { //if user is not signed in and there were errors in logging in
 ?>
 <div class="alert alert-warning" role="alert"> <!-- display error message -->
  We are sorry, but we are unable to log you in to your account at this time due to the following error - <br>
  <?php echo $_SESSION["errormessage"]; ?> <br>
  Please try again, or create a new account if you don't already have one.
</div>
<?php } 
if($_SESSION["loggedin"] != "true" && $_SESSION["status"] != "") { //if user has successfully created new account
?>
<div class="alert alert-success" role="alert"> <!--congratulations/update message -->
  <?php echo $_SESSION["status"]; ?>
</div>
<?php } ?>
</center>

<center><b> Please select a cuisine to view all sorts of foods that it has to offer.</b></center> <!-- instructions for viewing food images -->
<center>
<form id = "form0" action = "doViewImage.php" method = "POST"><!--form with action being doViewImage.php and method being POST-->
  <select class="form-control form-control-lg" name = "imgs" id = "imgs"><!--dropdown menu in form to select cuisine-->
    <option value = "All">All</option>
    <?php 
      $sql = "SELECT cuisine FROM Categories"; //sql statement to select all the cuisine elements from Categories table
      $result = $conn->query($sql); //process sql statement for my database; 
      if($result->num_rows > 0) { //if there are more than 0 rows of elements in the result variable
          $num_results = $result->num_rows; //set $num_results to num_rows
        }
      else {
        $num_results = 0; //otherwise set $num_results to 0
      }

    while ($row = $result->fetch_assoc()) { //while there are still rows of cuisine elements left in the associative array $result

    ?>
  <option value = <?php echo $row["cuisine"]; ?> <?php if($_SESSION["view"] == $row["cuisine"]) { echo "Selected";} ?>><?php echo $row["cuisine"]; ?></option> <!-- create a form dropdown menu element with the text being the cuisine in the current row in $result. if this cuisine is equal to the cuisine that was previously selected when using the form (aka $_SESSION["view"]), then autoselect this dropdown value.-->
<?php } ?> <!-- close while loop -->
</select> <!--close select tag -- end of dropdown menu -->
<br> <!--new line-->
 <center><button type="submit" class="btn btn-primary">View Image</button></center><br><br><!--button to submit form to doViewImage.php-->
</form></center> <!--close form tag -- end of form -->
<center><?php 
if($_SESSION["view"] != "All") { //if the user has not chosen to view all images
$sql2 = "SELECT primarykey, imageID, imgDesc, imageNum FROM Images WHERE typeID = '". $_SESSION["view"] . "'"; //select the primarykey, imageID, imgDesc, and imageNum table values for the cuisine the user chose.
} else {
  $sql2 = "SELECT primarykey, imageID, imgDesc, imageNum FROM Images"; //otherwise, select all images
}
$result2 = $conn->query($sql2); //process this query for my database.
      if($result2->num_rows > 0) { //if there are more than 0 rows of elements in the result variable
          $num_results2 = $result2->num_rows; //set $num_results to num_rows
        }
      else {
        $num_results2 = 0; //otherwise set $num_results to 0
      } 
      ?>
      <?php if($num_results2 == 0) { //if there are no images for the category that the user chose ?>
        <h4 style ="color:#f14d00"> No images avialable for this category.</h4> <!-- say so -->
      <?php } ?>
      <div id = "easyPaginate" class = "image-row"><!-- create a new div. id is easyPaginate so that Pagination can occur. class is image-row so that the Lightbox image elements are ordered nicely. -->
    <?php while ($row2 = $result2->fetch_assoc()) { //while there are still rows of elements left in the associative array $result

    ?>
    <div> <!--create a div and add a Lightbox image element inside of it -->
    <a href= "<?php echo "upload/" . $row2["imageID"]; ?>" data-lightbox="img" data-title="<?php echo $row2["imgDesc"]; ?>">
    <img src = <?php echo "thumb/" . $row2["imageID"]; ?>>
  </a>
  <a href= "<?php echo "upload/" . $row2["imageID"]; ?>" class="btn btn-dark" role="button" download>Download Image</a>
  <br><br>
</div>
  <?php } ?>
</div>


</center>
</body>
    <script src="http://code.jquery.com/jquery-latest.js"></script> <!--jquery script -->
    <script src="lightbox.js"></script> <!--lightbox script -->
    <script src="jquery.easyPaginate.js"></script> <!--pagination library script -->
     <script> //script to add pagination feature to images for every 8 images
          $('#easyPaginate').easyPaginate({
        paginateElement: 'div',
        elementsPerPage: 8,
        effect: 'climb'
    });
  </script>
</html>
<?php include("includes/CloseDBConn.php"); //close database connection ?>