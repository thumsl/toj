<?php
	function connectDB($host, $port, $user, $passwd, $dbname) {
		$constring = "host=".$host." port=".$port." user=".$user." password=".$passwd." dbname=".$dbname;
		echo $constring."<br>";
		return pg_connect($constring);
	}

	$con = 	connectDB("localhost", "5432", "postgres", "QpT{2RsS", "judge");
	if (!$con)
		echo "Connection to the database failed";
	else
		echo "Successfully connected to the database (" . pg_dbname($con) . ")";

?>