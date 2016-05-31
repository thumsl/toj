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
	<title>Delete</title>
</head>

<body>

<form id="delete" method="post">
	<label for="email">E-mail</label>
	<input id="email" name="email" type="text" placeholder="nome@example.com" class="form-control input-md" required><br>
	<button type="submit" form="delete" name="submit" value="submit">Delete user</button>
</form>

<legend>
	<?php
		if(isset($_POST['submit'])) { //check if form was submitted
			if ($_POST['email'] != "") {
				$sql = "SELECT * FROM usuarios WHERE email = '" . $_POST['email'] . "'";
				$result = pg_query($con, $sql);
				if (pg_num_rows($result) == 0) {
					echo "<i>" . $_POST['email'] . "</i> is not registered.<br>";
					exit;
				}
				else {
					$delete = "DELETE FROM usuarios WHERE email = '".$_POST['email']."';";
					echo "Delete query: <br> ".$delete."<br><br>";

					$result = pg_query($con, $delete);
					
					if (!$result)
						echo "Failed to remove user <i>".$_POST['email']."</i>. Please try again later.<br><br>";
					else
						echo "User <i>".$_POST['email']."</i> has been deleted.";
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
