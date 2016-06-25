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
	<title>Delete Problem</title>
</head>

<body>

<section>
<form id="delete" method="post">
	<label for="id">Problem ID</label>
	<input id="id" name="id" type="text" placeholder="12345" class="form-control input-md" required><br>
	<button type="submit" form="delete" name="submit" value="submit">Delete</button>
</form>

<legend>
	<?php
		if(isset($_POST['submit'])) { //check if form was submitted
			if ($_POST['id'] != "") {
				$select = "SELECT * FROM problems WHERE id = " . $_POST['id'] . ";";
				$result = pg_query($con, $select);
				if (!$result) {
					echo "Sorry, you can't do that right now. Please try again later.<br>";
					exit(1);
				}
				else {
					if (pg_num_rows($result) == 0) {
						echo "There is no problem with ID = <i>" . $_POST['id'] . "</i>.<br>";
					}
					else {
						$delete = "DELETE FROM problems WHERE id = ".$_POST['id'].";";

						$result = pg_query($con, $delete);
						
						if (!$result)
							echo "Sorry, you can't do that right now. Please try again later.<br>";
						else
							echo "Problem <i>".$_POST['id']."</i> has been deleted.";
					}
				}
			}
			else {
				echo "Please fill all required fields correctly.<br>";
				exit(1);
			}
			echo "</legend></section><footer>$select<br>$delete</footer>";
		}
	?>

</body>
</html>
