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

<form id="register" method="post">
	<label for="name">Nome</label>
	<input id="name" name="name" type="text" placeholder="Joao da Silva" class="form-control input-md" required><br>
	<label for="email">E-mail</label>
	<input id="email" name="email" type="text" placeholder="nome@example.com" class="form-control input-md" required><br>
	<label for="password">Senha</label>
	<input id="password" name="password" type="password" class="form-control input-md" required><br>
	<label for="universidade">Universidade</label>
	<input id="universidade" name="universidade" type="text" placeholder="UTFPR" class="form-control input-md"><br>
	<label for="country">Pa&iacute;s</label>
	<select id="country" name="country">
		<option value="ar">Argentina</option>
		<option selected value="br">Brasil</option>
		<option value="us">United States of America</option>
	</select>
	<button type="submit" form="register" name="submit" value="submit">Register</button>
</form>

<legend>
	<?php
		if(isset($_POST['submit'])) { //check if form was submitted
			if ($_POST['name'] != "" && $_POST['email'] != "" && $_POST['password'] != "") {
				$sql = "SELECT * FROM usuarios WHERE email = '" . $_POST['email'] . "'";
				$result = pg_query($con, $sql);
				if (pg_num_rows($result) > 0) {
					echo "<i>" . $_POST['email'] . "</i> is already registered.<br>";
					exit;
				}
				else {
					$id = mt_rand(0, 2147483647);
					$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
					$escaped = pg_escape_string('codUser');
					$insert = 
						"INSERT INTO usuarios (\"codUser\", nome, email, senha, universidade, pais)
						VALUES ('".$id."', '".$_POST['name']."', '".$_POST['email']."', '".$hash."', '".
						$_POST['universidade']."', '".$_POST['country']."');";
					echo "Insert query: <br> ".$insert."<br><br>";

					$result = pg_query($con, $insert);
					$tries = 0;

					while (!$result && $tries < 5) {
						$id = mt_rand(0, 2147483647);
						$insert = 
							"INSERT INTO usuarios (\"codUser\", nome, email, senha, universidade, pais)
							VALUES ('".$id."', '".$_POST['name']."', '".$_POST['email']."', '".$hash."', '".
							$_POST['universidade']."', '".$_POST['country']."');";

						$result = pg_query($con, $insert);
						$tries++;
						echo $tries;
					}
					if ($result)
						echo "Usuario cadastrado com sucesso.<br>";
					else
						echo "There was a problem adding the user to the database, please try again later.<br>";
					exit;
				}
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
