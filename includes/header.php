<?php
session_start(); //start new or resume existing session
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"); //echo opening xml statement
?>

<!DOCTYPE html> <!-- set DOCTYPE to html -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> <!--set xml version-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> <!-- boostrap framework link -->
  <link href="lightbox.css" rel="stylesheet" /> <!--lightbox css link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--icon stylesheet link -->
<head> <!--open head tag-->
  <meta charset="utf-8" /> <!-- set charset -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Culinary Clicks</title> <!-- title of page -->
</head> <!--close head tag -->
<style> /*css*/
  .navbar-custom {
    background-color: blue; /*set navbar background color to black*/
}
/* change the brand and text color */
.navbar-custom .navbar-brand,
.navbar-custom .navbar-text {
    color: rgba(255,255,255,.8); /*set navbar title text to a light blue shade color */
}
/* change the link color */
.navbar-custom .navbar-nav .nav-link {
    color: white; /*set navbar link elements to white*/
}
/* change the color of active or hovered links */
.navbar-custom .nav-item.active .nav-link,
.navbar-custom .nav-item:hover .nav-link {
    color: #ffffff; /*set color of link elements when hovered over*/
}
body {
  background-image: url("bckgnd.jpg"); /*set body background color to yellow*/
  background-repeat:no-repeat;
  background-attachment: fixed;
  background-position: center; 
}
#easyPaginate {width:300px;} /*set pagination size */
#easyPaginate img {display:block;margin-bottom:10px;}
.easyPaginateNav a {padding:5px;}
.easyPaginateNav a.current {font-weight:bold;text-decoration:underline;}
</style> <!--end css-->
<body> <!-- open body tag  -->
<!--BELOW CODE IS FROM BOOSTRAP -->
<nav class="navbar navbar-expand-sm navbar-light bg-light">
  <a class="navbar-brand" href="#">Culinary Clicks <?php if ($_SESSION["loggedin"] == true) { echo " | Welcome, " . $_SESSION["firstname"];}?><?php if($_SESSION["role"] == "User") { echo " | Role - User"; } ?> <?php if($_SESSION["role"] == "Super Admin") { echo " | Role - Super Admin"; } ?><?php if($_SESSION["role"] != "User" && $_SESSION["role"] != "Super Admin" && $_SESSION["loggedin"] == "true") { echo " | Role - " . $_SESSION["role"] . " Cuisine Manager"; } //intro message on left of navbar. Include website name. If user is logged in, welcome them and state their role as well.?></a>
  <!--boostrap navbar -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a> <!--home page link -->
      </li>
      <?php if($_SESSION["loggedin"] == true && $_SESSION["role"] != "Super Admin" && $_SESSION["role"] != "User") { //if the user is a Cuisine Admin ?>
      <li class="nav-item">
        <a class="nav-link" href="catAdmin.php"><?php echo $_SESSION["role"] ?> Cuisine Image Manager</a>
      </li> <!-- link to manage one specific cuisine -->
    <?php } ?>
    <?php if($_SESSION["role"] == "Super Admin") { //if the user is a Super Admin ?>
        <li class="nav-item">
        <a class="nav-link" href="supAdminCat.php">Image Manager</a> <!--link to manage all images -->
      </li>
        <li class="nav-item">
        <a class="nav-link" href="supAdminCuisine.php">Cuisine Manager</a> <!--link to add/delete cuisines -->
      </li>
        <li class="nav-item">
        <a class="nav-link" href="supUsers.php">User Manager</a> <!-- link to manage users -->
      </li>
    <?php } ?>
      <li class="nav-item">
        <a class="nav-link" href="readme.php">Readme</a> <!--readme link - available for everyone -->
      </li>
    </ul>
  
    <?php  if($_SESSION["loggedin"] != "true") { //if the user isn't logged in ?>
     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
  Sign Up <?php if($_SESSION["errormessage2"] != "") { ?> <span class="badge badge-danger">Error!</span><?php } ?>
</button> <!--button to register. Include an "error" badge if user could not successfully register an account -->
     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop2">
Login <?php if($_SESSION["errormessage"] != "") { ?> <span class="badge badge-danger">Error!</span><?php } ?>
</button>  <!-- button to log in. Include an "error badge" if user could not successfully log in. -->
<?php } else { //otherwise ?> 
<a href="logoutdo.php" class="btn btn-info" role="button">Logout</a> <!--include a button to logout of account -->
<?php } ?>
  </div>
</nav>
<!--boostrap modal to register -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Register to Culinary Clicks</h5><br> <!--modal title -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <!--button to close modal -->
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
        include("signup.php"); //include php page that contains sign up form
        ?>
      </div>
    </div>
  </div>
</div>
<!--boostrap modal for logging in -->
<div class="modal fade" id="staticBackdrop2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Login to your Culinary Clicks Account</h5><br> <!--modal title -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <!--button to close modal -->
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
        include("login.php"); //include php page that contains login form
        ?>
      </div>
    </div>
  </div>
</div>

</body> <!--close body tag -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> <!-- more boostrap scripts -->
</html> <!-- close html tag -->

