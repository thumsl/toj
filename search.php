<?php
	if (!isset($con)) {
		header('HTTP/1.0 404 Not Found', true, 404);
		include("../404.php");
		die();
	}
?>

<html>
<head>
	<title>Edit</title>
</head>

<body>

<h2>Search user</h2>
<section>
<form id="edit" method="post">
	<label for="string">Name</label>
	<input id="string" name="string" type="text" class="form-control input-md" required>
	<button type="submit" form="edit" name="submit" value="submit">Search</button>
</form>

<?php
	if(isset($_POST['submit'])) {
		if ($_POST['string'] != "") {
			$select =
				"SELECT users.id, users.name, university.name, university.abbrev FROM users JOIN university ON (users.fk_uni = university.id) WHERE UPPER(users.name) LIKE UPPER('%".$_POST['string']."%') ORDER BY users.name ASC";
			$result = pg_query($con, $select);
			if (!$result) {
				echo "You can't do that right now, please try again later.<br>";
				exit(1);
			}
			else {
				if (pg_num_rows($result) == 0) {
					echo "Your search criteria did not meet any result.<br>";
				}
				else {
					echo "<br><table style='width:100%;'>
						<tr style='padding-top:20;'><th>Name</th><th>University</th></tr>";

					while ($row = pg_fetch_row($result)) {
						$url = "?option=profile&id=".$row[0];

						echo 	"<tr><td><a href='$url'>$row[1]</a></td>
								 <td><a href='$url'>$row[2] ($row[3])</a></td>";
						}
						echo "</tr></table>";
				}
			}
		}
		else {
			echo "The search can't be null.<br>";
			exit;
		}
		echo "</legend></section><footer>$select</footer>";
	}
?>

</body>
</html>
