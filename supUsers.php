<?php
session_start(); //start new or resume existing session
$_SESSION["view"] = ""; //set session variable "view" to an empty string -- this is for the index.php page
//if user is not super admin, send them to index.php and exit this page
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
  <title>Manage Users</title> <!-- title of page -->
</head> <!--close head tag -->

<body> <!-- open body tag-->
  <?php

  include("includes/header.php"); //include the header.php page contents
  ?>

  <center><b><h3>Manage Users</h3></b></center><br> <!--title text -->
  <?php if(!empty($_SESSION["success"])) { //if session variable success is not empty, display its contents ?>
    <div class="alert alert-success" role="alert">
  <?php echo $_SESSION["success"]; ?>
</div>
<?php } ?>
<!--boostrap list with options to manage groups -->
  <div class="list-group"> 
  <a href="supAddUser.php" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Add New User</h5> <!--add new user -->
      <small>Option 1</small>
    </div>
    <p class="mb-1">Create a Culinary Clicks Account for a new user!</p>
    <small>Accounts can only be of type User and Cuisine Admin.</small>
  </a>
  <a href="supModifyUser.php" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Modify Existing User</h5> <!--modify existing user -->
      <small class="text-muted">Option 2</small>
    </div>
    <p class="mb-1">Make an existing Cuisine Manager the Manager of another Cuisine!</p>
    <small class="text-muted">Users and other Super Admins cannot have their account modified.</small>
  </a>
  <a href="supDelUser.php" class="list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Delete User</h5> <!-- delete user -->
      <small class="text-muted">Option 3</small>
    </div>
    <p class="mb-1">Revoke an existing user's access from the website. Doing so will permanently wipe the user's login information from the website database.</p>
    <small class="text-muted">This can only be done for Users and Cuisine Admins.</small>
  </a>
</div>
</body> <!--close body -->
</html> <!--close html-->