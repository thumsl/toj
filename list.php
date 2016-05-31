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

<table style="width:100%">
<tr>
	<th>Nome</th>
	<th>E-mail</th>
	<th>Universidade</th>
	<th>Pais</th>
</tr>

<?php
	$result = pg_query($con, "SELECT nome, email, universidade, pais FROM usuarios");
	if (!$result) {
		echo "An error occurred.\n";
		exit;
	}

	while ($row = pg_fetch_row($result)) {
		echo "<tr> <td>$row[0]</td> <td>$row[1]</td> <td>$row[2]</td> <td>";
		switch($row[3]) {
			case "br":
				echo "<img src='images/flags/Brazil.png' alt='Brasil' style='width:24px;height:24px;'>";
				break;
			case 'ar':
				echo "<img src='images/flags/Argentina.png' alt='Argentina' style='width:24px;height:24px;'>";
				break;
			case 'us':
				echo "<img src='images/flags/United-States.png' alt='USA' style='width:24px;height:24px;'>";
				break;
		}
		echo "</td></tr>";
	}
?>
</table>

</body>
</html>
