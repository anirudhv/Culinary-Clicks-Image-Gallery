<?php
session_start(); //start new or resume existing session
$_SESSION["view"] = ""; //set session variable "view" to an empty string -- this is for the index.php page

//if user is not a super admin and has not selected a cuisine to manage its images, send them to index.php and exit page
if($_SESSION["role"] != "Super Admin") {
    header("Location:index.php");
    exit;
}
if($_SESSION["man"] == "") {
    header("Location:supAdminCat.php");
    exit;
}

echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"); //echo opening xml statement
?>

<!DOCTYPE html> <!-- set DOCTYPE to html -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> <!--set xml version-->
<head> <!--open head tag-->
  <meta charset="utf-8" /> <!-- set charset -->
  <title>Manage Images - Cuisine Admin</title> <!-- title of page -->
</head> <!--close head tag -->

<body> <!-- open body tag-->
  <?php

  include("includes/header.php"); //include the header.php page contents
  include("includes/OpenDBConn.php"); //include OpenDBConn.php to see if database connection was successful.
  ?>

  <center><b><h3><?php echo $_SESSION["man"] . " Cuisine Image Manager"; ?></h3></b></center><br> <!-- page title text -->
  <?php if(!empty($_SESSION["badFileType"])) { ?> <!--if badFileType session variable is not empty -->
  <div class="alert alert-info" role="alert"> <!-- display its message -->
  <center><?php echo $_SESSION["badFileType"]; ?></center>
</div>
<?php } ?>
<!-- boostrap button tabs - sort of like pagination. click on a tab and you get content for that specific tab -->
  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Upload an Image</a> <!--upload image -->
  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Update Image Caption </a> <!--update image caption -->
  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Delete Image</a> <!--delete image -->
</div>
<div class="tab-content" id="v-pills-tabContent"> <!--content for the tabs -->


  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"> <!--content for upload image tab -->

    <form id="form0" method="post" action="doUploadSup.php" enctype="multipart/form-data"><!--form opening tag - post method and doUploadResize.php page action -->
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

</div>
  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"> <!-- content for update image tab -->
                    <?php 
                $sql = "SELECT imageID FROM Images WHERE typeID = '" . $_SESSION["man"] ."'"; //select imageIDs for the cuisine the super admin is now managing - sql statement 
                $result = $conn->query($sql); //process for my database
                if($result->num_rows == 0) { //if there are no images for the cuisine the user is managing
                ?>
                <center><div class="alert alert-danger" role="alert"> <!-- let the user know -->
  There are currently no <?php echo $_SESSION["man"]; ?> cuisine images that can have their caption changed. 
</div></center>
<?php } else { ?> <!--otherwise -->
    <form id="form0" method="post" action="doUpdateSup.php" enctype="multipart/form-data"> <!--form to update image description -->
      <legend>Update Image Description</legend> <!-- form title -->
                   <label title="category" for="category">Please select an image whose caption you want to change. <span>*</span></label> <!--dropdown menu to select image category--> <!--instructions -->

              <select name="category" id="category"> <!--dropdown menu in form -->
                <?php while ($row = $result->fetch_assoc()) { //while there are still elements in associative array row?>
                  <option value = <?php echo $row["imageID"]; ?>><?php echo $row["imageID"]; ?></option> 
                <?php } //set current row ImageID value as dropdown menu option ?>
        </select><br>
        <label title="Description" for="description">Update Image Caption<span></span></label> <textarea rows="5" cols="40" name="description" id="description"></textarea><br> <!--image description update field-->
           <fieldset id="submit"> <!-- form fieldset with id submit tag -->
        <input type="submit" id="submit" name="submit" value="Submit" /><br> <!--submit button to update contents in database-->
    </fieldset><!--close id submit fieldset-->
</form><!-- close form tag -->
<?php } ?>
  </div>
  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab"> <!--tab to delete images -->
    <?php 
                $sql = "SELECT imageID FROM Images WHERE typeID = '" . $_SESSION["man"] ."'"; //sql statement to select all images from database which are of the cuisine the super admin is currently managing.
                $result = $conn->query($sql); //process query for my database
                if($result->num_rows == 0) { //if there are no images to be deleted
                ?>
                <center><div class="alert alert-danger" role="alert">
  There are currently no <?php echo $_SESSION["man"]; ?> cuisine images that can be deleted.</div></center>
<?php //let user know
} else { //otherwise ?>
    <form id="form0" method="post" action="doDelSup.php" enctype="multipart/form-data"> <!--form to delete image -->
      <legend>Delete Image</legend> <!-- form title -->
                   <label title="category" for="category">Please select an image to delete. <span>*</span></label> <!--dropdown menu to select image image to delete //instructions-->

              <select name="category" id="category">
                <?php while ($row = $result->fetch_assoc()) { //while there are still elements in the associative array produced by processing the previous sql statement?>
                  <option value = <?php echo $row["imageID"]; ?>><?php echo $row["imageID"]; ?></option> <!--set current imageID in row to dropdown menu value -->
                <?php } ?>
        </select><br>
                   <fieldset id="submit"> <!-- form fieldset with id submit tag -->
        <input type="submit" id="submit" name="submit" value="Submit" /><br> <!--submit button to delete file and store form contents in database-->
    </fieldset><!--close id submit fieldset-->
</form><!-- close form tag -->
<?php } ?>
  </div>
</div>
</body>
</html>
<?php include("includes/OpenDBConn.php"); ?> <!--close database connection -->