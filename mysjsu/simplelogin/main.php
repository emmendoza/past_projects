<?php
/*
*	Basic session holding.
*/

ob_start(); 
if (!session_id()) session_start();

if (isset($_POST["sid"]) && isset($_POST["pass"])){
	if($_POST["sid"] == "1234" && $_POST["pass"] == "password"){
		$_SESSION["mysjsu"] = $_POST["sid"];
	}
}

if (!isset($_SESSION["mysjsu"])) {
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html>

<body>

Welcome To MySJSU Registration.
<br>
<a href="logout.php">logout</a>


</body>
</html>