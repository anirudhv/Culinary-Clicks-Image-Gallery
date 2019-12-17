<?php
session_start(); //start new or resume existing session
 //set session variable "view" to an empty string -- this is for the viewImage.php page
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"); //echo opening xml statement
?>

<!DOCTYPE html> <!-- set DOCTYPE to html -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> <!--set xml version-->
<head> <!--open head tag-->
  <meta charset="utf-8" /> <!-- set charset -->
  <title>ReadMe</title> <!-- title of page -->
</head> <!--close head tag -->

<body> <!-- open body tag-->
  <?php

  include("includes/header.php"); //include the header.php page contents
?>
<h2><center>ReadMe Page</center></h2> <!--title text -->
<h4><center>Anirudh Venkataramanan - CGT 356000</center></h4> <!-- name and course -->
<h6><center>Quirks</center></h6> <!--section title -->
<ul> <!-- list of quirks -->
  <li> The pagination feature only appears when there are more than eight images in a cuisine category. </li>
  <li> In addition to using the <a href = "https://lokeshdhakar.com/projects/lightbox2/">Lightbox</a> Library, I also used the <a href = "http://st3ph.github.io/jquery.easyPaginate/">Easy Paginate</a> Library. </li>
  <li> One small minor bug that I was unable to fix is that when the user selects the American Cuisine Category on the home page, the selected value upon reloading of the page will be "All" and not "American". This is not the case with any of the other Cuisine Categories.</li>
  <li> If the user has 3 images uploaded for a certain cuisine - Greek1.jpg, Greek2.jpg, and Greek3.jpg, and then deletes Greek2.jpg, the next Greek Cuisine Image they upload will be Greek4.jpg (or .gif) unless Greek3.jpg is also deleted, in which case Greek2 will be the next image name.</li>
  <li> As I discussed with you in class, "deleting" a cuisine/category simply means users can't sign up for that role. Any previous images and data associated with that category are stored. Users can still view images from "deleted" categories, just not make an account with that category.</li>
</ul>
<h6><center>Above and Beyond</center></h6> <!-- section title -->
<ul> <!-- list of above and beyond things -->
  <li> I implemented a modal for the sign up and login process. </li>
</ul>
</body> <!-- close body tag -->
</html> <!--close html tag -->
