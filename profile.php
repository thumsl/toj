<html>
<style>
	.left {
		display: inline-block;
		float:left;
		width: 150px;
		height: 150px;
		border: 1px dashed black;
	}
	.wrapper {
		display: inline-block;
		min-width: 50%;
		height: auto;
		padding-left: 10;
		margin: 0 auto;
		
	}
</style>
</html>

<?php
	if (!isset($con)) {
		header('HTTP/1.0 404 Not Found', true, 404);
		include("../404.php");
		die();
	}

	if (!isset($_GET['id']))
		header("Location: ?option=home");
	else {
		$select = "
		SELECT users.name, users.email, university.name, university.abbrev, country.name, COUNT(CASE WHEN S.fk_status = 1 THEN 1 ELSE NULL END) as SOLVED, COUNT(DISTINCT(S.fk_problem)) as TRIED, users.registrationDate
		FROM users, university, country, 
			(SELECT DISTINCT ON (solutions.fk_user, solutions.fk_problem, solutions.fk_status, users.id) fk_status, fk_problem, users.id
			FROM users FULL JOIN solutions ON (users.id = solutions.fk_user)) as S
		WHERE users.id = S.id AND S.id = ".$_GET['id']." AND users.fk_uni = university.id AND users.fk_country = country.id 
		GROUP BY users.name, users.email, university.name, university.abbrev, country.name, users.registrationDate;";

		$result = pg_query($con, $select);

		if (!$result) {
			echo "Something went wrong. Please try again later.<br>";
			exit(1);
		}
		else {
			if (pg_num_rows($result) == 0)
				echo "<h2>Invalid ID</h2>";
			else {
				$row = pg_fetch_row($result);
				echo "<section>
					<div class='left'>profile picture</div>
					<div class='wrapper'>
					<div class='profileName'><b>$row[0]</b>, $row[4]<br>
					$row[2] ($row[3])<br>
					<small>$row[1]</small><br>
					<hr>
					<b>Member since:</b> $row[7]<br>
					<b>Problems solved:</b> $row[5]<br>
					<b>Problems tried:</b> $row[6]<br>
					</div>
					</section>";
			}
			echo "<footer>$select</footer>";
		}
	}
?>