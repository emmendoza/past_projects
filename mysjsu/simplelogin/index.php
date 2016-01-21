<?php
/*
*	Simple Login, temporary hard coded password
*	Student Id: 1234
*	Password: password
*/
ob_start();
if (!session_id()) session_start();

if (isset($_SESSION["mysjsu"])) {
    header("Location: main.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<body>
MySJSU Login
<br>
<form action="main.php" method="post">
  Student Id:<br>
  <input type="text" name="sid" value="" autofocus>
  <br>
  Password:<br>
  <input type="password" name="pass" value="">
  <br><br>
  <input type="submit" value="login">
</form> 


</body>
</html>
