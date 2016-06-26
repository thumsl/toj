<?php
	if (!isset($con)) {
		header('HTTP/1.0 404 Not Found', true, 404);
		include("../404.php");
		die();
	}
?>

<html>
<head>
	<title>User List</title>
</head>

<body>

<h2>User List</h2>
<section>
<table style="width:100%">
<tr>
	<th>Name</th>
	<th>E-mail</th>
	<th>University</th>
	<th>Country</th>
</tr>

<?php
	$query = "SELECT users.id, users.name, users.email, university.name, country.code, country.name, university.abbrev FROM users, country, university WHERE fk_uni = university.id AND fk_country = country.id ORDER BY users.name;";
	$result = pg_query($con, $query);
	if (!$result) {
		echo "An error occurred.\n";
		exit;
	}
	while ($row = pg_fetch_row($result)) {
		$url = "?option=profile&id=".$row[0];
		echo 	"<tr><td><a href='$url'>$row[1]</a></td>
				 <td><a href='$url'>$row[2]</a></td>
				 <td><a href='$url'>$row[3] ($row[6])</a></td>
				 <td><a href='$url'><img src='images/flags/".$row[4].".png' alt='".$row[5]."' style='width:24px;height:24px;'></a></td>";
	}
	echo "</tr>";
?>
</table>
</section>

<footer>
	<?php echo "$query"; ?>
</footer>

</body>
</html>
