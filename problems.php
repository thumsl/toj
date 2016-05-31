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
	$result = pg_query($con, "SELECT titulo, \"refCat\", \"refAutor\", \"nivelDificuldade\", \"codProb\", descricao FROM problemas");
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
			switch($row[1]) {
				case 'inic':
					$categoria = "Iniciante";
					break;
				case 'str':
					$categoria = "Strings";
					break;
				case 'ed':
					$categoria = "Estruturas";
					break;
				case 'graph':
					$categoria = "Grafos";
					break;
				case 'math':
					$categoria = "Matematica";
					break;
				}
			// TODO: check if user still exists
			$url = "?problem=".$row[4];
			$nome_autor = pg_fetch_row(pg_query($con, "SELECT nome FROM usuarios WHERE \"codUser\" = ". $row[2]));
			$resolvido = pg_num_rows(pg_query($con, "SELECT * FROM \"problemUser\" WHERE \"codProb\" = ".$row[4]));
			echo "<tr> <td><a href='".$url."'>".$row[0]."</a></td> <td><a href='".$url."'>".$categoria."</a></td>
				<td><a href='".$url."''>".$nome_autor[0]."</a></td> <td><a href='".$url."'>".$row[3]."</a></td> 
				<td><a href='".$url."'>".$resolvido."</a></td></tr>";
		}
	}
?>
</table>

</body>
</html>
