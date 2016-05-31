<?php
	if (!isset($con)) {
		header('HTTP/1.0 404 Not Found', true, 404);
		include("../404.php");
		die();
	}

	if (!isset($_SESSION))
		session_start();
	if (!($_SESSION['logged'] == 1 && ($_SESSION['permission'] == 1 || $_SESSION['permission'] == 2)))
		header("Location: ?option=error");
?>

<html>
<head>
	<title>Register</title>
</head>

<body>

<form id="addproblem" method="post">
	<label for="title">Titulo</label>
	<input id="title" name="title" type="text" placeholder="Hello World" class="form-control input-md" required><br>
	<label for="categoria">Categoria</label>
	<select id="categoria" name="categoria">
		<option selected value="iniciante">Iniciante</option>
		<option value="ed">Estruturas</option>
		<option value="str">Strings</option>
		<option value="graph">Grafos</option>
		<option value="math">Matematica</option>
	</select><br>
	<label for="descricao">Descricao:</label>
	<textarea name="descricao"></textarea>

	<label for="dificuldade">Dificuldade</label>
	<select id="dificuldade" name="dificuldade">
		<option selected value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
	</select>
	<label for="file">Output File</label>
	<input type="file" name="file" id="file">
	<button type="submit" form="addproblem" name="submit" value="submit">Create</button>
</form>

<legend>
	<?php
		if(isset($_POST['submit'])) { //check if form was submitted
			if ($_POST['title'] != "" && $_POST['categoria'] != "" && $_POST['descricao'] != "" && $_POST['dificuldade'] != "") {
				// TODO: verify input 'dificuldade', has to be between 1-10
				$id = mt_rand(0, 2147483647);
				$insert = 
					"INSERT INTO problemas (\"codProb\", titulo, \"nivelDificuldade\", \"refCat\", \"refAutor\", \"descricao\")
					VALUES ('".$id."', '".$_POST['title']."', '".$_POST['dificuldade']."', '".$_POST['categoria']."', '".$_SESSION['id']."', '".$_POST['descricao']."');";
				echo "Insert query: <br> ".$insert."<br><br>";
				// TODO: SQL Injection protection

				$result = pg_query($con, $insert);

				if ($result) {
					$dir = 'problems';

					 // create new directory with 744 permissions if it does not exist yet
					 // owner will be the user/group the PHP script is run under
					 if (!file_exists($dir)) {
					     $oldmask = umask(0);  // helpful when used in linux server  
					     mkdir ($dir, 0777);
					 }

					$file_name = $dir."/".$id.".html";
					$file = fopen($file_name, "w");
					$autor_query = "SELECT nome FROM usuarios WHERE \"codUser\" = ".$_SESSION['id'];
					$autor  = pg_fetch_row(pg_query($con, $autor_query))[0];
					$content = "<article><h1>".$_POST['title']."</h1><br><p><small>".$autor."</p></small><br>".$_POST['descricao']."</article>";
					//fwrite($file, $content);
					fwrite($file, $content);
					echo $id."<br>";
					echo "Problema criado com sucesso.<br>";
				}
				else
					echo "There was a problem adding the problem to the database, please try again later.<br>";
				exit;
			}
			else {
				echo "Please fill all required fields correctly.<br>";
				exit;
			}
		}
	?>
</legend>

</body>
</html>
