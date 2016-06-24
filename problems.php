<?php
	if (!isset($con)) {
		header('HTTP/1.0 404 Not Found', true, 404);
		include("../404.php");
		die();
	}
?>

<html>
<head>
	<title>List Problems</title>
</head>

<body>

<script>
	function toggle() {
		if( document.getElementById("hidden").style.display=='none' ){
			document.getElementById("hidden").style.display = 'table-row'; // set to table-row instead of an empty string
		}
		else{
			document.getElementById("hidden").style.display = 'none';
		}
	}
</script>

<?php
	$query = "SELECT problems.id, problems.name, problems.level, problems.fk_user, problemType.id, problemType.name, users.name
		FROM problems, problemType, users WHERE problems.fk_type = problemType.id AND problems.fk_user = users.id;";
	$result = pg_query($con, $query);
	if (!$result) {
		echo "An error occurred.\n";
		exit;
	}
	else if (pg_num_rows($result) == 0)
		echo "<legend>No problems found.<br></legend>";
	else {
		?>
		<table>
		<tr>
			<th>Problema</th>
			<th>Categoria</th>
			<th>Autor</th>
			<th>Niv. Dificuldade</th>
			<th>Resolvido</th>
		</tr>

		<?php
		while ($row = pg_fetch_row($result)) {
			// TODO: check if user still exists
			$url = "?problem=".$row[0];
			$resolvido = pg_num_rows(pg_query($con, "SELECT * FROM solutions WHERE id = ".$row[0]." AND fk_status = 1;"));
			echo "
			<tr><td><a href='".$url."'>".$row[1]."</a></td>
				<td><a href='".$url."'>".$row[5]."</a></td>
				<td><a href='".$url."''>".$row[6]."</a></td>
				<td><a href='".$url."'>".$row[2]."</a></td> 
				<td><a href='".$url."'>".$resolvido."</a></td></tr>";
		}
	}
?>
</table>

</body>
</html>
