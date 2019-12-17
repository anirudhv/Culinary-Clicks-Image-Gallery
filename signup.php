<?php
session_start(); //start new or resume existing session
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"); //echo opening xml statement
?>

<!DOCTYPE html> <!-- set DOCTYPE to html -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> <!--set xml version-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> <!-- boostrap framework link -->
<head> <!--open head tag-->
  <meta charset="utf-8" /> <!-- set charset -->
  <title>Sign Up</title> <!-- title of page -->
</head> <!--close head tag -->
<body>
  <?php 
  include("includes/OpenDBConn.php"); //include OpenDBConn.php to see if database connection was successful
  ?>
<form action="registerdo.php" method="POST" role="form" class="form-horizontal"> <!-- register form -->
  <center><h6 style="color:red;"><?php echo $_SESSION["errormessage2"]; ?></h6></center> <!--display error messages -->
  <div class="form-group">
    <label for="firstname">First Name</label> <!--first name field -->
    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Please enter your first name.">
  </div>
  <div class="form-group">
    <label for="lastname">Last Name</label> <!--last name field -->
    <input type="text" class="form-control" name = "lastname" id="lastname" placeholder="Please enter your last name.">
  </div>
  <div class="form-group">
    <label for="username">Username</label> <!--username field -->
    <input type="text" class="form-control" name = "username" id="username" placeholder="Please enter a username.">
  </div>
  <div class="form-group">
    <label for="password">Password</label> <!--password field -->
    <input type="password" class="form-control" name = "password" id="password">
  </div>
    <div>
      <label for="role">Account Type</label> <!--account type field -->
      <select name = "role" id="role" class="form-control">
        <option value = "Super Admin">Super Admin</option>
        <?php
        $yes = "Yes";
          $sql = "SELECT cuisine FROM Categories WHERE available = '" . $yes. "'"; //sql statement to select all active cuisines from Categories
          $result = $conn->query($sql); //process sql statement for my database
          if($result->num_rows > 0) { //if thehre more than 0 rows of results
            $num_results = $result->num_rows; //set $num_results to num_rows
        }
      else {
        $num_results = 0; //otherwise set $num_results to 0
      }
      while ($row = $result->fetch_assoc()) { //while there are still elements left in the associative array $row
        ?>
        <option value = <?php echo $row["cuisine"] . " Cuisine Admin";?>><?php echo $row["cuisine"] . " Cuisine Admin";?></option> <!--add the cuisines as an option for the dropdown menu -->
      <?php } ?>
      <option value ="User">User</option> <!--option value for account type user -->
      </select>
      <br><br>
        <button type="submit" name = "submit" class="btn btn-primary" value = "submit">Submit</button> <!--button to submit form -->
    </div>
</form>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> <!-- more boostrap scripts -->
</html>
<?php include("includes/CloseDBConn.php"); //include closeDBConn.php which closes database connection  ?>