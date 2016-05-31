<?php
	if (!isset($con)) {
		header('HTTP/1.0 404 Not Found', true, 404);
		include("../404.php");
		die();
	}
	if (!isset($_SESSION)) 
		session_start();
	$_SESSION['logged'] = 0;
	header("Location: ?option=home");
?>