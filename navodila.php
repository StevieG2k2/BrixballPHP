<?php
	session_start();
	require_once ("dbBrixball.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<link rel="icon" href="opeka.png">
		<meta charset="UTF-8">
		<link rel="stylesheet" href="drugistil.css">
        <title>Brixball - navodila</title>
    </head>
    <body>
        <header>
            <h1>Navodila</h1>
        </header>
        <nav>
			<a href="game.php">Brixball</a>
			<a href="">Navodila</a>
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

        </div>
        <div id="main">
            <div id="back">
                <p class="tekst">Žogico odbivaj s ploščkom v opeke in razbij čim več opek v čim krajšem času.</p>
                <p class="tekst">Plošček lahko premikaš z miško ali s puščicami LEVO in DESNO</p>
            </div>
        </div>
    </body>
</html>