<?php 
	if (!isset($_SESSION)) session_start();
	if ($_SESSION['logged'] == 1) {
		if ($_SESSION['permission'] == 1) {
			$option = array("list", "addproblem", "problems", "account");
			$title = array($option[0] => "List all existing users", $option[1] => "Create a new problem", $option[2] => "List all existing problems", $option[3] => "My account page");
			$text = array($option[0] => "Users", $option[1] => "Create Problem", $option[2] => "Problems", $option[3] => "Account");
		}
		else if ($_SESSION['permission'] == 2) {
			$option = array("list", "remove", "addproblem", "problems", "edit", "account");
			$title = array($option[0] => "List all existing users", $option[1] => "Delete an existing user", 
				$option[2] => "Create a new problem", $option[3] => "List all existing problems", 
				$option[4] => "Edit user's permission level.", $option[5] => "My account page");
			$text = array($option[0] => "Users", $option[1] => "Delete user", $option[2] => "Create Problem", $option[3] => "Problems", 
					$option[4] => "Edit", $option[5] => "Account");
		}
		else {
			$option = array("list", "problems", "account");
			$title = array($option[0] => "List all existing users", $option[1] => "List all existing problems", $option[2] => "My account page");
			$text = array($option[0] => "Users", $option[1] => "Problems", $option[2] => "Account");
		}
	}
	else {
		$option = array("list", "problems");
		$title = array($option[0] => "List all existing users", $option[1] => "List all existing problems");
		$text = array($option[0] => "Users", $option[1] => "Problems");
	}

?>

<html>
<head>
	<title>Online Judge</title>
	<meta name=viewport content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>
</head>

<body>

<?php
	if ($_SESSION['logged'] == 0) {
		$session_status = "LOGIN";
		$action = "login";
	}
	else {
		$session_status = "LOGOUT";
		$action = "logout";
	}
?>
<header>
	<?php include("connect.php"); ?>
	<a href="?option=<?php echo $action; ?>"><?php echo $session_status; ?></a>
	<?php 
		if ($_SESSION['logged'] == 0)
			echo "<a href='?option=insert'>REGISTER</a>";
	?>
</header>

<h1>Online Judge</h1>

<nav>
	<?php
		if ($_SESSION['logged'] == 1) {
			if ($_SESSION['permission'] == 0) {
				// REGULAR
				?>
				<div class="dropdown">
					<button class="dropbtn">USERS</button>
					<div class="dropdown-content">
						<a href="?option=list">LIST</a>
						<a href="?option=ranking">RANKING</a>
						<a href="?option=search">SEARCH</a>
					</div>
				</div>
				<div class="dropdown">
					<button class="dropbtn">PROBLEMS</button>
					<div class="dropdown-content">
						<a href="?option=problems">LIST</a>
						<a href="?option=submit">SUBMIT</a>
						<a href="?option=submissions">SUBMISSIONS</a>
					</div>
				</div>
				<div class="dropdown">
					<button class="dropbtn">ACCOUNT</button>
					<div class="dropdown-content">
						<a href="?option=profile&id=<?php echo$_SESSION['id'] ?>">PROFILE</a>
						<a href="?option=logout">LOGOUT</a>
					</div>
				</div>
				<?php
			}
			if ($_SESSION['permission'] == 1) {
				// AUTHOR
				?>
				<div class="dropdown">
					<button class="dropbtn">USERS</button>
					<div class="dropdown-content">
						<a href="?option=list">LIST</a>
						<a href="?option=ranking">RANKING</a>
						<a href="?option=search">SEARCH</a>
					</div>
				</div>
				<div class="dropdown">
					<button class="dropbtn">PROBLEMS</button>
					<div class="dropdown-content">
						<a href="?option=problems">LIST</a>
						<a href="?option=submit">SUBMIT</a>
						<a href="?option=submissions">SUBMISSIONS</a>
						<a href="?option=addproblem">CREATE</a>
					</div>
				</div>
				<div class="dropdown">
					<button class="dropbtn">ACCOUNT</button>
					<div class="dropdown-content">
						<a href="?option=profile&id=<?php echo$_SESSION['id'] ?>">PROFILE</a>
						<a href="?option=logout">LOGOUT</a>
					</div>
				</div>
				<?php
			}
			else if ($_SESSION['permission'] == 2) {
				// ADMIN
				?>
				<div class="dropdown">
					<button class="dropbtn">USERS</button>
					<div class="dropdown-content">
						<a href="?option=list">LIST</a>
						<a href="?option=ranking">RANKING</a>
						<a href="?option=search">SEARCH</a>
						<a href="?option=edit">UPDATE</a>
						<a href="?option=remove">REMOVE</a>
					</div>
				</div>
				<div class="dropdown">
					<button class="dropbtn">PROBLEMS</button>
					<div class="dropdown-content">
						<a href="?option=problems">LIST</a>
						<a href="?option=submit">SUBMIT</a>
						<a href="?option=submissions">SUBMISSIONS</a>
						<a href="?option=addproblem">CREATE</a>
						<a href="?option=delproblem">REMOVE</a>
					</div>
				</div>
				<div class="dropdown">
					<button class="dropbtn">ACCOUNT</button>
					<div class="dropdown-content">
						<a href="?option=profile&id=<?php echo$_SESSION['id'] ?>">PROFILE</a>
						<a href="?option=logout">LOGOUT</a>
					</div>
				</div>
				<?php
			}
		}
		else {
			// NOT LOGGED IN
			?>
			<div class="dropdown">
				<button class="dropbtn">USERS</button>
				<div class="dropdown-content">
					<a href="?option=list">LIST</a>
					<a href="?option=ranking">RANKINGS</a>
					<a href="?option=search">SEARCH</a>
				</div>
			</div>
			<div class="dropdown">
				<button class="dropbtn">PROBLEMS</button>
				<div class="dropdown-content">
					<a href="?option=problems">LIST</a>
					<a href="?option=submissions">SUBMISSIONS</a>
				</div>
			</div>
			<?php
		}
	?>

</nav>

<?php
	if (isset($_GET['problem'])) {
		include("problems/".$_GET['problem'].".html");
	}
	else {
		switch($_GET["option"]) {
			case "list":
				include("list.php");
				break;
			case "insert":
				include("insert.php");
				break;
			case "remove":
				include("delete.php");
				break;
			case "problems":
				include("problems.php");
				break;
			case "addproblem":
				include("addproblem.php");
				break;
			case "delproblem":
				include("delproblem.php");
				break;
			case "login":
				include("login.php");
				break;
			case "logout":
				include("logout.php");
				break;
			case "home":
				include("home.php");
				break;
			case "edit":
				include("edit.php");
				break;
			case "ranking":
				include("ranking.php");
				break;
			case "profile":
				include ("profile.php");
				break;
			case "search":
				include ("search.php");
				break;
			default:
				include("home.php");
				break;
		}
	}
?>

</body>
</html>

