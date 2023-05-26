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
        <title>Brixball - osebni rekordi</title>
    </head>
    <body>
        <header>
            <h1>Top 10 osebnih rekordov</h1>
        </header>
        <nav>
			<a href="game.php">Brixball</a>
			<a href="navodila.php">Navodila</a>
			<a href="rekordi.php">Rekordi</a>
			<?php if($_SESSION['username'] != "gost") : ?>
					<a href="">Osebni rekordi</a>
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
        <script type="text/javascript">  
            // notice the quotes around the ?php tag         
            var htmlString="<?php echo $htmlString; ?>";
            alert(htmlString);
        </script>
        </div>
        <div id="main">
            <div>
                <table id="rekordi">
                    <tr id="stolpc">
                        <th>točke</th><th>Čas</th><th>igralec</th><th>datum</th>
                    </tr>
                    <tr id="template">
                        <th>1000</th><th>00:00</th><th>janezselski111</th><th>8888888888</th>
                    </tr>
                    <?php foreach (dbBrixball::get($_SESSION["id"]) as $rekord): ?>
                        <tr>
                            <td><?= $rekord["points"] ?></td>
                            <td><?= $rekord["time"] ?></td>
                            <td><?= $rekord["usrname"] ?></td>
                            <td><?= $rekord["date"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <script>
                //izpis()
                function izpis(){
                    const highScores = JSON.parse(localStorage.getItem('rekordi')) || [];
                    document.getElementById("rekordi").innerHTML
                    document.getElementById("rekordi").innerHTML += highScores
                        .map((rekord) => `<tr><td id="tockeout">${rekord.sc}</td><td>${rekord.minuteI}:${rekord.sekundeI}</td><td>${rekord.mwz}</td><td>${rekord.datum}</td></tr>`)
                        .join('');
                }
                if(highScores.length == 0){
                    document.getElementById("del").style.visibility = "hidden"
                }else{
                    //document.getElementById("del").style.visibility = "visible"
                }
            </script>
            <br>
            <div id="delit">
                <p id="del">pobriši lestvico</p>
                <br>
                <div id="conf">
                    <p id="prompt">Ali zares želite zbrisati lestvico?</p>
                    <br>
                    <p id="da" title="Dvojni klik za potrditev"><b ondblclick="zbris()">DA</b></p>
                    <p id="ne"><b onclick="skri()">NE</b></p>
                </div>
                <script>
                    var del = document.getElementById("del")

                    del.addEventListener("click", event => {
                        document.getElementById("conf").style.visibility = "visible";
                        document.getElementById("del").style.visibility = "hidden";
                    });
                    
                    function zbris(){
                        localStorage.clear("rekordi");
                        location.reload();
                    };

                    function skri(){
                        document.getElementById("conf").style.visibility = "hidden";
                        document.getElementById("del").style.visibility = "visible";
                    };

                    if(localStorage.length == 0){
                        document.getElementById("delit").style.visibility = "hidden"
                    }else{
                        document.getElementById("delit").style.visibility = "visible"
                    }
                </script>
            </div>
        </div>
    </body>
</html>