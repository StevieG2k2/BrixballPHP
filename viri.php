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
        <title>Brixball - viri</title>
    </head>
    <body>
        <header>
            <h1>Viri</h1>
        </header>
        <nav>
			<a href="game.php">Brixball</a>
			<a href="navodila.php">Navodila</a>
			<a href="rekordi.php">Rekordi</a>
			<?php if($_SESSION['username'] != "gost") : ?>
					<a href="personalRekordi.php">Osebni rekordi</a>
			<?php endif; ?>
			<a href="">Viri</a>
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
                <p class="tekst"><a href="https://stevieg2k2.github.io/Bricks/" style="text-decoration: none; color:black;">Moja prvotna bricks igra</a></p>
                <p class="tekst"><a href="https://github.com/StevieG2k2/Bricks" style="text-decoration: none; color:black;">Moja prvotna bricks igra (github)</a></p>
                <p class="tekst"><a href="https://michael-karen.medium.com/how-to-save-high-scores-in-local-storage-7860baca9d68" style="text-decoration: none; color:black;">Pomoč pri izdelavi shranjevanja in prikaza rezultatov</a></p>
                <p class="tekst"><a href="https://fonts.google.com/specimen/Press+Start+2P" style="text-decoration: none; color:black;">Font spletne strani</a></p>
                <p class="tekst"><a href="https://forum.solarus-games.org/en/index.php?action=profile;area=showposts;u=738#:~:text=(Preview%20of%20the%20Spring%20Overworld%20tileset%2Bentities%20file)" style="text-decoration: none; color:black;">Slika iz katere sem vzel vzorec za opeke</a></p>
            </div>
        </div>
    </body>
</html>