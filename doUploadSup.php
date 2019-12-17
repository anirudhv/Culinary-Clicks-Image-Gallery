<?php
session_start();
include("includes/OpenDBConn.php"); //include OpenDBConn.php to check if database connection was successful.
//make sure page doesnt time out - in case of large file
set_time_limit(300);

$sql = "SELECT MAX(imageNum) AS MaxNum FROM Images WHERE typeID = '".$_SESSION["man"]."'"; //get the largest ImageNum for chosen cuisine in Images - sql statement

$result = $conn->query($sql); //process sql statement for my database
//if no images in folder, set image number to one
if(empty($result)) {
	$nextNumber = 1;
	echo($nextNumber);
}
//Otherwise find the current highest number and add 1 to it.
else {
	$row = $result->fetch_array();
	$nextNumber = trim($row["MaxNum"]) + 1;
}
//make sure the submit button was pressed.
if($_POST["uploadFile"] != "")
{
	//Get the file extension
	$fileExt = strrchr($_FILES['foodFile']['name'], ".");

	//if file extension is not in this list, do not allow upload
	if( ($fileExt != ".jpg") && ($fileExt != ".jpeg") && ($fileExt != ".gif") && ($fileExt != ".JPG") && ($fileExt != ".JPEG") && ($fileExt != ".GIF"))
	{
		//set the session message in case of bad file type
		$_SESSION["badFileType"] = "You cannot upload a file of type ".$fileExt;
    header("Location:manImg.php"); //redirect user to manImg.php
    exit; //exit page
	}
    else //otherwise
	{
		//Get the filename
		$fileName = $_FILES['foodFile']['name'];
		$_SESSION["badFileType"] = ""; //make session variable badFileType blank
		// Make sure the file is uploaded (initially uploaded to the computers temp directory)
		// and ready for upload
		if(!is_uploaded_file($_FILES['foodFile']['tmp_name']))
		{
			echo "Problem: possible file upload attack";
			header("Location:manImg.php");
			exit;
		}



		// Name the file. This one includes the directory as well.
		$upfile = "upload/".$_SESSION["man"].$nextNumber.$fileExt;

		// Need this for resizing - no directory
		$newFileName = $_SESSION["man"].$nextNumber.$fileExt;

		// copy the file into its location on the server
		if(!move_uploaded_file($_FILES['foodFile']['tmp_name'], $upfile))
		{
			echo "Problem: Could not move file into directory";
			header("Location:manImg.php");
			exit;
		}

		// set the session message
		$_SESSION["badFileType"] = "File Successfully Uploaded as " . $newFileName . ".";

	} // end filetype check
}
else //otherwise
{
	$_SESSION["badFileType"] = ""; //make badFileType blank
} // end form check
//inserts image into the database
	if(empty($_POST["description"])) { //if user did not enter a caption
		$_POST["description"] = "No caption provided."; //make user input say so
	}
	$sql2 = "INSERT INTO Images(imageID, typeID, imageNum, imgDesc) VALUES ('".$newFileName."', '".$_SESSION["man"]."', ".$nextNumber.", '".$_POST["description"]."')"; 

	$result2 = $conn->query($sql2); //process sql statement for my database

$dir = "./upload/"; //upload directory
$thdir = "./thumb/"; //thumbnail directory
$img = $newFileName; //filename of uploadedimage

if($fileExt == ".gif" || $fileEXT == ".GIF") { //if the file extension is a gif
	resizegif($dir, $thdir, $img, 160, 120, ""); //run resizegif function
}
else {
	resizejpeg($dir, $thdir, $img, 160, 120, ""); //run resize jpeg function
}
$_SESSION["badFileType"] .=" File successfully resized."; //set badFileType session variable to success message.
include("includes/CloseDBConn.php"); //include closeDBConn.php which closes database connection
	header("Location:manImg.php"); //send user to manImg.php


function resizejpeg($dir, $newdir, $img, $max_w, $max_h, $prefix) //function declaration for resizejpeg function
{ 
   // set destination directory
   if (!$newdir) $newdir = $dir;

   // get original images width and height
   list($or_w, $or_h, $or_t) = getimagesize($dir.$img);

   // make sure image is a jpeg
   if ($or_t == 2)
   {

       // obtain the image's ratio
       $ratio = ($or_h / $or_w);

       // original image
       $or_image = imagecreatefromjpeg($dir.$img);

       // resize image?
       if ($or_w > $max_w || $or_h > $max_h) {

           // resize by height, then width (height dominant)
           if ($max_h < $max_w) {
               $rs_h = $max_h;
               $rs_w = $rs_h / $ratio;
           }
           // resize by width, then height (width dominant)
           else {
               $rs_w = $max_w;
               $rs_h = $ratio * $rs_w;
           }

           // copy old image to new image
           $rs_image = imagecreatetruecolor($rs_w, $rs_h);
           imagecopyresampled($rs_image, $or_image, 0, 0, 0, 0, $rs_w, $rs_h, $or_w, $or_h);
       }
       // image requires no resizing
       else {
           $rs_w = $or_w;
           $rs_h = $or_h;

           $rs_image = $or_image;
       }

       // generate resized image
       imagejpeg($rs_image, $newdir.$prefix.$img, 100);

       return true;
   }

   // Image type was not jpeg!
   else
   {
       return false;
   }
}

function resizegif($dir, $newdir, $img, $max_w, $max_h, $prefix) //function declaration for resizegif function
{
   // set destination directory
   if (!$newdir) $newdir = $dir;

   // get original images width and height
   list($or_w, $or_h, $or_t) = getimagesize($dir.$img);

   // make sure image is a gif
   if ($or_t == 1)
   {

       // obtain the image's ratio
       $ratio = ($or_h / $or_w);

       // original image
       $or_image = imagecreatefromgif($dir.$img);

       // resize image?
       if ($or_w > $max_w || $or_h > $max_h) {

           // resize by height, then width (height dominant)
           if ($max_h < $max_w) {
               $rs_h = $max_h;
               $rs_w = $rs_h / $ratio;
           }
           // resize by width, then height (width dominant)
           else {
               $rs_w = $max_w;
               $rs_h = $ratio * $rs_w;
           }

           // copy old image to new image
           $rs_image = imagecreatetruecolor($rs_w, $rs_h);
           imagecopyresampled($rs_image, $or_image, 0, 0, 0, 0, $rs_w, $rs_h, $or_w, $or_h);
       }
       // image requires no resizing
       else {
           $rs_w = $or_w;
           $rs_h = $or_h;

           $rs_image = $or_image;
       }

       // generate resized image
       imagegif($rs_image, $newdir.$prefix.$img, 100);

       return true;
   }

   // Image type was not gif!
   else
   {
       return false;
   }
}
?>

