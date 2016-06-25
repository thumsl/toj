<?php
	if (!isset($con)) {
		header('HTTP/1.0 404 Not Found', true, 404);
		include("../404.php");
		die();
	}
	if (!isset($_SESSION)) 
		session_start(); 

	if ($_SESSION['logged'] == 1) {
		header("Location: ?option=home");
		exit;
	}

?>

<html>
<head>
	<title>Register</title>
</head>

<body>

<h2>Login</h2>
<section>
<form id="login" method="post">
	<label for="email">E-mail</label>
	<input id="email" name="email" type="text" placeholder="nome@example.com" class="form-control input-md" required><br>
	<label for="password">Senha</label>
	<input id="password" name="password" type="password" class="form-control input-md" required><br>
	<button type="submit" form="login" name="login" value="submit">Log-in</button>
</form>

<legend>
	<?php
		if(isset($_POST['login'])) { //check if form was submitted
			if ($_POST['email'] != "" && $_POST['password'] != "") {
				$sql = "SELECT id, password, fk_type FROM users WHERE email = '".$_POST['email']."';";
				$result = pg_query($con, $sql);

				if (pg_num_rows($result) == 0) {
					echo "The information entered is not correct.<br>";
					exit;
				}
				else {
					$row = pg_fetch_row($result);
					if (password_verify($_POST['password'], $row[1])) {
						$_SESSION['id'] = $row[0];
						$_SESSION['logged'] = 1;
						$_SESSION['permission'] = $row[2];
						header("Location: ?option=account");
					}
					else
						echo "The information entered is not correct.<br>";

				}
			}
			else {
				echo "Please fill all required fields correctly.<br>";
				exit;
			}
		}
	?>
</legend>
</section>

</body>
</html>
