<?php
session_start(); //start new or resume existing session
$_SESSION["view"] = ""; //set session variable "view" to an empty string -- this is for the index.php page

//make sure the user is logged in and of type Cuisine Admin - otherwise, redirect them back to the index page
if(empty($_SESSION["loggedin"]) || $_SESSION["loggedin"] != "true") {
  header("Location:index.php");
  exit;
}
if($_SESSION["role"] == "Super Admin") {
    header("Location:index.php");
    exit;
}
if($_SESSION["role"] == "User") {
    header("Location:index.php");
    exit;
}
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"); //echo opening xml statement
?>

<!DOCTYPE html> <!-- set DOCTYPE to html -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> <!--set xml version-->
<head> <!--open head tag-->
  <meta charset="utf-8" /> <!-- set charset -->
  <title>Cuisine Image Manager</title> <!-- title of page -->
</head> <!--close head tag -->

<body> <!-- open body tag-->
  <?php

  include("includes/header.php"); //include the header.php page contents
  include("includes/OpenDBConn.php"); //include OpenDBConn.php to connect to database
  ?>

  <center><b><h3><?php echo $_SESSION["role"] . " Cuisine Image Manager"; ?></h3></b></center><br>
  <?php if(!empty($_SESSION["badFileType"])) { //if the user has any issues in uploading images ?>
  <div class="alert alert-info" role="alert"> <!--display error message -->
  <center><?php echo $_SESSION["badFileType"]; ?></center>
</div>
<?php } ?>
<!--boostrap element that acts like pagination - shows certain content based on current tab that is clicked. -->
  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Upload an Image</a> <!-- tab to upload an image -->
  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Update Image Caption </a> <!--tab to update an existing image's caption -->
  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Delete Image</a> <!-- tab to delete an image -->
</div>
<div class="tab-content" id="v-pills-tabContent"> <!--content for the tabs -->


  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"> <!-- content for upload image tab -->

    <form id="form0" method="post" action="doUploadCat.php" enctype="multipart/form-data"><!--form opening tag - post method and doUploadCat.php page action -->
    <fieldset id="info"> <!--form fieldset with id info - accepts user input -->
        <input type="hidden" name="src" value="doUploadResize.php" /> <!--hidden input for form regarding file name -->
        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" /> <!--hidden input for form regarding max file size -->
        <legend>Upload File</legend> <!--form title-->
      
            
             <label title="foodFile" for="foodFile">File: <span>*</span></label> <input type="file" name="foodFile" id="foodFile" size="25" /><br> <!--image upload field-->
            <label title="Description" for="description">Description <span>*</span></label> <textarea rows="5" cols="40" name="description" id="description"></textarea><br> <!--image description field-->
        
    </fieldset> <!--close id info fieldset tag --> 
    <fieldset id="submit"> <!-- form fieldset with id submit tag -->
        <input type="submit" id="uploadFile" name="uploadFile" value="Upload File" /><br> <!--submit button to upload file and store form contents in database-->
    </fieldset><!--close id submit fieldset-->
</form><!-- close form tag -->

</div> <!-- end of upload image tab contents -->
  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"> <!-- update image caption tab contents -->
                    <?php 
                $sql = "SELECT imageID FROM Images WHERE imageID LIKE '%". $_SESSION["role"] . "%'"; //sql statement to select imageIDs from Images table where the ImageID contains the Cuisine that the user is managing.
                $result = $conn->query($sql); //process sql statement for my database.
                if($result->num_rows == 0) { //if there are no images in the database for the user to the change the caption of
                ?>
                <center><div class="alert alert-danger" role="alert"> <!--let the user know -->
  There are currently no <?php echo $_SESSION["role"]; ?> cuisine images that can have their caption changed. 
</div></center>
<?php } else {  //otherwise?>
    <form id="form0" method="post" action="doUpdateCat.php" enctype="multipart/form-data"> <!--form for user to update image caption -->
      <legend>Update Image Description</legend>
                   <label title="category" for="category">Please select an image whose caption you want to change. <span>*</span></label> <!--dropdown menu to select image name-->

              <select name="category" id="category">
                <?php while ($row = $result->fetch_assoc()) { //while there are still elements for us to go through in the associative array result ?>
                  <option value = <?php echo $row["imageID"]; ?>><?php echo $row["imageID"]; ?></option> 
                <?php } //add the current imageID element as a dropdown menu element?>
        </select><br>
        <label title="Description" for="description">Update Image Caption<span></span></label> <textarea rows="5" cols="40" name="description" id="description"></textarea><br> <!--image description update field-->
           <fieldset id="submit"> <!-- form fieldset with id submit tag -->
        <input type="submit" id="submit" name="submit" value="Submit" /><br> <!--submit button to submit and store changes in database-->
    </fieldset><!--close id submit fieldset-->
</form><!-- close form tag -->
<?php } ?>
  </div> <!--end of image caption update tab contents -->
  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab"><!--contents of tab to delete images from cuisine category -->
    <?php 
                $sql = "SELECT imageID FROM Images WHERE imageID LIKE '%". $_SESSION["role"] . "%'";//select all images from table images for the cusisine that the user manages
                $result = $conn->query($sql); //process this query for my database.
                if($result->num_rows == 0) { //if there are no images for the category which the user manages
                ?>
                <center><div class="alert alert-danger" role="alert"> <!-- let the user know -->
  There are currently no <?php echo $_SESSION["role"]; ?> cuisine images that can be deleted.</div></center>
<?php } else { //otherwise ?>
    <form id="form0" method="post" action="doDelCat.php" enctype="multipart/form-data"> <!--form to delete images -->
      <legend>Delete Image</legend>
                   <label title="category" for="category">Please select an image to delete. <span>*</span></label> <!--dropdown menu to select image to delete-->

              <select name="category" id="category">
                <?php while ($row = $result->fetch_assoc()) { //while there are still rows for us to parse through in the associative array of image names that the user manages ?> 
                  <option value = <?php echo $row["imageID"]; ?>><?php echo $row["imageID"]; //make the current imageID a dropdown menu element.?></option> 
                <?php } ?>
        </select><br>
                   <fieldset id="submit"> <!-- form fieldset with id submit tag -->
        <input type="submit" id="submit" name="submit" value="Submit" /><br> <!--submit button to delete image and update database/image folders-->
    </fieldset><!--close id submit fieldset-->
</form><!-- close form tag -->
<?php } ?>
  </div>
</div>

</body> <!--close body tag -->
</html> <!--close html tag -->
<?php 
include("includes/CloseDBConn.php"); //include closeDBConn.php which closes database connection
?>