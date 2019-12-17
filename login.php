<?php
session_start(); //start new or resume existing session
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"); //echo opening xml statement
?>

<!DOCTYPE html> <!-- set DOCTYPE to html -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> <!--set xml version-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> <!-- boostrap framework link -->
<head> <!--open head tag-->
  <meta charset="utf-8" /> <!-- set charset -->
  <title>Login</title> <!-- title of page -->
</head> <!--close head tag -->
<body>
<form action="Logindo.php" method="POST">
  <center><h6 style="color:red;"><?php echo $_SESSION["errormessage"]; ?></h6></center>
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name = "username" placeholder="Please enter your username.">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" name = "password" id="password">
  </div>
      <br><br>
        <button type="submit" class="btn btn-primary" value = "Register">Login</button>
</form>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> <!-- more boostrap scripts -->
</html>