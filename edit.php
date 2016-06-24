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
	<label for="permission">Permission Level</label>
	<select id="permission" name="permission">
		<?php
			$result = pg_query($con, "SELECT id, title FROM userType ORDER BY id");
			while ($row = pg_fetch_row($result)) {
				echo "<option value='".$row[0]."'>".$row[1]."</option>";
			}
		?>
	</select>
	<button type="submit" form="edit" name="submit" value="submit">Edit</button>
</form>

<legend>
	<?php
		if(isset($_POST['submit'])) {
			if ($_POST['email'] != "") {
				$sql = "SELECT * FROM usuarios WHERE email = '" . $_POST['email'] . "'";
				$result = pg_query($con, $sql);
				if (!$result) {
					echo "You can't do that right now, please try again later.<br>";
					exit(1);
				}
				else {
					if (pg_num_rows($result) == 0) {
						echo "<i>" . $_POST['email'] . "</i> is not registered.<br>";
						exit(1);
					}
					else {
						$update = "UPDATE usuarios  SET \"refCatUser\" = '".$_POST['permission']."' WHERE email = '".$_POST['email']."'";
						echo "Update query: <br> ".$update."<br><br>";

						$result = pg_query($con, $update);
						
						if (!$result)
							echo "Failed to alter <i>".$_POST['email']."</i>'s permission level. Please try again later.<br><br>";
						else
							echo "User <i>".$_POST['email']."</i> permission level has changed.";
						exit(0);
					}
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
