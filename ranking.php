

<html>
<head>
	<title>Ranking</title>
</head>

<body>

<h2>Rankings</h2>
<section>
<table style="width:100%">
<tr>
	<th>Name</th>
	<th>University</th>
	<th>Solved</th>
</tr>

<?php
	$query = "
		SELECT S.id, S.name, S.uniName, S.abbrev, COUNT(s.id) as solved FROM (
			SELECT DISTINCT ON (solutions.fk_user, solutions.fk_problem)
				users.id, users.name, university.name as uniName, university.abbrev
			FROM 
				users INNER JOIN solutions ON (users.id = solutions.fk_user), university
			WHERE
				users.fk_uni = university.id
			GROUP BY 
				users.id, users.name, university.name, university.abbrev, solutions.fk_user,  solutions.fk_problem, solutions.fK_status
			HAVING 
				solutions.fK_status = 1) as S
		GROUP BY
			S.id, S.name, S.uniName, S.abbrev
		ORDER BY
			solved
		DESC;";

	$result = pg_query($con, $query);
	if (!$result) {
		echo "An error occurred.\n";
		exit;
	}

	while ($row = pg_fetch_row($result)) {
		$url = "?option=profile&id=".$row[0];
		echo 	"<tr><td><a href = '$url'>$row[1]</a></td>
				 <td><a href = '$url'>$row[2] ($row[3])</a></td>
				 <td><a href = '$url'>$row[4]</a></td>";
	}
	echo "</tr>";
?>
</table>
</section>

<footer>
	<?php echo "$query"; ?>
</footer>

</body>
</html>