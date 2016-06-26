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

<h2>Problem listing</h2>
<section>
<?php
	switch($_GET['sort']) {
		case "problem":
			if ($_GET['order'] == 'asc')
				$sort = "S.name ASC";
			else
				$sort = "S.name DESC";
			break;
		case "category":
			if ($_GET['order'] == 'asc')
				$sort = "S.category ASC";
			else
				$sort = "S.category DESC";
			break;
		case "author":
			if ($_GET['order'] == 'asc')
				$sort = "S.userName ASC";
			else
				$sort = "S.userName DESC";
			break;
		case "level":
			if ($_GET['order'] == 'asc')
				$sort = "S.level ASC";
			else
				$sort = "S.level DESC";
			break;
		case "solved":
			if ($_GET['order'] == 'asc')
				$sort = "solved ASC";
			else
				$sort = "solved DESC";
			break;
		default:
			$sort = "S.name DESC";
			break;
	}
	$query = "
		SELECT S.id, S.name, S.category, S.userName, S.level, COUNT(s.id) as solved 
		FROM (
			SELECT DISTINCT ON (solutions.fk_user, solutions.fk_problem)
				problems.id, problems.name, problemType.name as category, users.name as userName, problems.level
				FROM
					problems INNER JOIN solutions ON (problems.id = solutions.fk_problem), users, problemType
				WHERE
					problemType.id = problems.fk_type AND users.id = problems.fk_user
				GROUP BY
					problems.id, problems.name, problemType.name, users.name, problems.level, solutions.fk_user, solutions.fk_problem, solutions.fK_status
				HAVING solutions.fK_status = 1)
		as S
		GROUP BY
			S.id, S.name, S.category, S.userName, S.level
		ORDER BY
			".$sort.";";

	$result = pg_query($con, $query);
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
			<th><a href="?option=problems&sort=problem">Problem</a>&nbsp;
				<a href="?option=problems&sort=problem&order=asc">&#8593;</a>&nbsp;
				<a href="?option=problems&sort=problem&order=desc">&#8595;</a></th>

			<th><a href="?option=problems&sort=category">Category</a>&nbsp;
				<a href="?option=problems&sort=category&order=asc">&#8593;</a>&nbsp;
				<a href="?option=problems&sort=category&order=desc">&#8595;</a></th>

			<th><a href="?option=problems&sort=author">Author</a>&nbsp;
				<a href="?option=problems&sort=author&order=asc">&#8593;</a>&nbsp;
				<a href="?option=problems&sort=author&order=desc">&#8595;</a></th>

			<th><a href="?option=problems&sort=level">Level</a>&nbsp;
				<a href="?option=problems&sort=level&order=asc">&#8593;</a>&nbsp;
				<a href="?option=problems&sort=level&order=desc">&#8595;</a></th>

			<th><a href="?option=problems&sort=solved">Solved</a>&nbsp;
				<a href="?option=problems&sort=solved&order=asc">&#8593;</a>&nbsp;
				<a href="?option=problems&sort=solved&order=desc">&#8595;</a></th>
		</tr>

		<?php
		while ($row = pg_fetch_row($result)) {
			$url = "?problem=".$row[0];
			echo "
			<tr><td><a href='".$url."'>".$row[1]."</a></td>
				<td><a href='".$url."'>".$row[2]."</a></td>
				<td><a href='".$url."''>".$row[3]."</a></td>
				<td><a href='".$url."'>".$row[4]."</a></td> 
				<td><a href='".$url."'>".$row[5]."</a></td></tr>";
		}
	}
?>
</table>
</section>

<footer>
	<?php echo $query ?>
</footer>

</body>
</html>
