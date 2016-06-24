<?php
	if (!isset($con)) {
		header('HTTP/1.0 404 Not Found', true, 404);
		include("../404.php");
		die();
	}
?>

<html>
<head>
	<title>List</title>
</head>

<body>

<section>
<table style="width:100%">
<tr>
	<th>Name</th>
	<th>E-mail</th>
	<th>University</th>
	<th>Country</th>
</tr>

<?php
	$query = "SELECT users.name, users.email, university.name, country.code, country.name, university.abbrev FROM users, country, university WHERE fk_uni = university.id AND fk_country = country.id ORDER BY users.name;";
	$result = pg_query($con, $query);
	if (!$result) {
		echo "An error occurred.\n";
		exit;
	}

	while ($row = pg_fetch_row($result)) {
		echo 	"<tr><td>$row[0]</td>
				 <td>$row[1]</td>
				 <td>$row[2] ($row[5])</td>
				 <td><img src='images/flags/".$row[3].".png' alt='".$row[4]."' style='width:24px;height:24px;'></td>";
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
