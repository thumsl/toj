<?php
	if (!isset($con)) {
		header('HTTP/1.0 404 Not Found', true, 404);
		include("../404.php");
		die();
	}
	
	if (!isset($_SESSION))
		session_start();
	if (!($_SESSION['logged'] == 1 && $_SESSION['permission'] == 2))
		header("Location: ?option=error");
?>

<html>
<head>
	<title>Edit</title>
</head>

<body>

<form id="edit" method="post">
	<label for="email">E-mail</label>
	<input id="email" name="email" type="text" placeholder="nome@example.com" class="form-control input-md" required>
	<label for="permission">Categoria</label>
	<select id="permission" name="permission">
		<option value="0">Regular</option>
		<option selected value="1">Author</option>
		<option value="2">Administrator</option>
	</select>
	<button type="submit" form="edit" name="submit" value="submit">Edit</button>
</form>

<legend>
	<?php
		if(isset($_POST['submit'])) {
			if ($_POST['email'] != "") {
				$sql = "SELECT * FROM usuarios WHERE email = '" . $_POST['email'] . "'";
				$result = pg_query($con, $sql);
				if (pg_num_rows($result) == 0) {
					echo "<i>" . $_POST['email'] . "</i> is not registered.<br>";
					exit;
				}
				else {
					$update = "UPDATE usuarios  SET \"refCatUser\" = '".$_POST['permission']."' WHERE email = '".$_POST['email']."'";
					echo "Update query: <br> ".$update."<br><br>";

					$result = pg_query($con, $update);
					// TODO: check if permission == 0, 1 or 2
					
					if (!$result)
						echo "Failed to alter <i>".$_POST['email']."</i>'s permission level. Please try again later.<br><br>";
					else
						echo "User <i>".$_POST['email']."</i> permission level has changed.";
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
