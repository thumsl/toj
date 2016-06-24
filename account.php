<?php
	if (!isset($con)) {
		header('HTTP/1.0 404 Not Found', true, 404);
		include("../404.php");
		die();
	}
	
	if (!isset($_SESSION))
		session_start();

	if ($_SESSION['logged'] == 0)
		header("Location: ?option=login");
	else {
		echo "Your account's permission level is ".$_SESSION['permission']."<br>";
		echo "Your account details will appear here.<br>";
	}
?>