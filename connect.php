<?php
	function connectDB($host, $port, $user, $passwd, $dbname) {
		$constring = "host=".$host." port=".$port." user=".$user." password=".$passwd." dbname=".$dbname;
		return pg_connect($constring);
	}

	$con = 	connectDB("localhost", "5432", "postgres", "QpT{2RsS", "TOJ");
	if (!$con) {
		echo pg_result_error($con);
		echo "<br>Connection to the database failed";
		exit;
	}
?>
