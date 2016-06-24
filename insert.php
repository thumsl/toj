<?php
        if (!isset($con)) {
                header('HTTP/1.0 404 Not Found', true, 404);
                include("../404.php");
                die();
        }

        if (!isset($_SESSION))
                start_session();
        if ($_SESSION['logged'] == 1)
                header("Location: ?option=home");
?>

<html>
<head>
	<title>Register</title>
</head>

<body>

<section>
<form id="register" method="post">
	<label for="name">Nome</label>
	<input id="name" name="name" type="text" placeholder="Joao da Silva" class="form-control input-md" required><br>
	<label for="email">E-mail</label>
	<input id="email" name="email" type="text" placeholder="nome@example.com" class="form-control input-md" required><br>
	<label for="password">Senha</label>
	<input id="password" name="password" type="password" class="form-control input-md" required><br>
	<label for="universidade">Universidade</label>
	<select id="universidade" name="universidade">
		<?php
			$select = "SELECT id, abbrev FROM university ORDER BY abbrev";
			$result = pg_query($con, $select);
			while ($row = pg_fetch_row($result)) {
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		?>
	</select>	
	<label for="country">Pa&iacute;s</label>
	<select id="country" name="country">
		<?php
			$select2 = "SELECT id, name FROM country ORDER BY name";
			$result = pg_query($con, $select2);
			while ($row = pg_fetch_row($result)) {
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		?>
	</select>
	<button type="submit" form="register" name="submit" value="submit">Register</button>
</form>

<legend>
	<?php
		if(isset($_POST['submit'])) {
			if ($_POST['name'] != "" && $_POST['email'] != "" && $_POST['password'] != "") { 
				$select3 = "SELECT * FROM usuarios WHERE email = UPPER('" . $_POST['email'] . "')";
				$result = pg_query($con, $select3);
				if (pg_num_rows($result) > 0) {
					echo "<i>" . $_POST['email'] . "</i> is already registered.<br>";
				}
				else {
					$id = mt_rand(0, 2147483647);
					$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
					$insert = "INSERT INTO users VALUES (".$id.", '".$_POST['name']."', '".$_POST['email']."', '".$hash."', ".$_POST['country'].", ".$_POST['universidade'].", 0);"; //".$_POST['universidade']."

					$result = pg_query($con, $insert);

					if ($result)
						echo "Usuario cadastrado com sucesso.<br>";
					else
						echo "There was a problem adding the user to the database, please try again.<br>";
				}
			}
			else {
				echo "Please fill all required fields correctly.<br>";
				exit(1);
			}
			echo "</legend></section><footer>$select<br>$select2<br>$select3<br>$insert</footer>";
		}
	?>
</legend>
</section>
</body>
</html>
