<?php
/*
*	Log Out.
*/

ob_start(); 
if (!session_id()) session_start();

session_unset();
session_destroy();

if (!isset($_SESSION["mysjsu"])) {
    header("Location: index.php");
    exit;
}

header( "refresh:5;url=index.php" );
?>
<!DOCTYPE html>
<html>
<body>

You have been successfully signed out of MySJSU.


</body>
</html>