<?php
	// Initialize the session
	session_start();
    require_once("dbBrixball.php");
    require_once("db.php");
    $db = db::getInstance();
	
	// Check if the user is logged in
	if (!isset($_SESSION['username'])) {
		header("Location: index.php");
		exit();
	}

	$query = "SELECT id FROM user WHERE usrname = ?";
	$stmt = $db->prepare($query);
	$stmt->bindParam(1, $_SESSION['username'],PDO::PARAM_STR);
	$stmt->execute();
	$_SESSION["id"] = $stmt->fetchColumn(0);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Brixball</title>
		<link rel="icon" href="opeka.png">
		<meta charset="UTF-8">
		<link rel="stylesheet" href="stil.css">
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<!-- PHP spremenliuka v JS -->
		<script type="text/javascript">var usrId = <?php echo json_encode($_SESSION["id"]); ?>;</script>
		<script type="text/javascript">var usrname = <?php echo json_encode($_SESSION['username']); ?>;</script>
		<script type="text/javascript" src="skripta.js"></script>
	</head>
	<body>
		<header>
			<h1>Brixball</h1>
		</header>
		<nav>
			<a href="">Brixball</a>
			<a href="navodila.php">Navodila</a>
			<a href="rekordi.php">Rekordi</a>
			<?php if($_SESSION['username'] != "gost") : ?>
					<a href="personalRekordi.php">Osebni rekordi</a>
			<?php endif; ?>
			<a href="viri.php">Viri</a>
			<a href="avtor.php">Avtor</a>
			<?php if($_SESSION['username'] != "gost") : ?>
					<a href="logout.php">Odjava</a>
			<?php endif; ?>
			<?php if($_SESSION['username'] == "gost") : ?>
					<a href="logout.php">Prijava</a>
			<?php endif; ?>
		</nav>
		<div id="stats">
			<p id="t">točke:<b id="tocke" style="color:black">0</b></p>
			<p>Čas:<b id="cas">00:00</b></p>
		</div>
		<div id="main">
			<canvas id="canvas" width="900" height="600" ></canvas>
			
			<p id="finalscore"></p> 
			<div id="mozak">
				<p>Dosegli ste nov rekord!</p>
				<input id="ime" type="text">
				<p style="visibility: hidden;">s</p>
			</div>
			<p id="replay" onclick="bla()">Igraj ponovno</p>
			<p id="startPrompt">Za začetek pritisnite SPACE.</p>
		</div>
		<footer>
			
		</footer>
	</body>
</html>
