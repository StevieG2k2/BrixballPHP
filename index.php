<?php
	session_start();
	require_once ("dbBrixball.php");
	require_once ("db.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Brixball</title>
		<link rel="icon" href="opeka.png">
		<meta charset="UTF-8">
		<link rel="stylesheet" href="stil.css">
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="skripta.js"></script>
		<style>
			label, p{
				color:white;
			}
			button{
				padding:5px;
			}
		</style>
	</head>
	<body>
		<header>
			<h1>Prijava</h1>
		</header>
		<div id="main">
			<div style="height:30px"></div>
			<form method="POST" action="">
				<div style="display: flex; justify-content: center">
					<div style="width:50%">
						<label style="float:right">Uporabniško ime:</label>
					</div>
					<div style="width:50%"	>
						<input type="text" name="username" style="float:left"><br><br>
					</div>
				</div>
				<div style="display: flex; justify-content: center">
					<div style="width:50%">
						<label style="float:right">Geslo:</label>
					</div>
					<div style="width:50%">
						<input type="password" name="password" style="float:left"><br><br>
					</div>
				</div>
				<button type="submit" name="login">Prijava</button> 
				<button type="submit" name="guest">Gost</button> 
				<button type="submit" name="register">Registracija</button>
			</form>
			<br>
			<p id="narobe"><?php echo (isset($_SESSION["eror"])) ? $_SESSION["eror"] : "" ?></p>
				
		</div>
		
		<?php
			$db = db::getInstance();

			// Check if the user clicked the login button
			if (isset($_POST["login"])) {
				$_SESSION["eror"] = "";
				$username = $_POST["username"];
				$password = $_POST["password"];

				if($username == "" || $password == ""){
					$_SESSION["eror"] = "Napačno uporabniško ime ali geslo.";
					header("Location: index.php");
					exit();
				}
				// Prepare the SQL statement to check if the user exists in the database

				$query = "SELECT COUNT(id) FROM user WHERE usrname = ? AND passwrd = ?";
				$stmt = $db->prepare($query);
				$stmt->bindParam(1, $username,PDO::PARAM_STR);
				$stmt->bindParam(2, $password,PDO::PARAM_STR);
				$stmt->execute();
				

				// Check if the user exists
				if ($stmt->fetchColumn(0) == 1) {
					// The user exists, set session variables and redirect to the home page
					$_SESSION['username'] = $username;
					header("Location: game.php");
					exit();
				} else {
					// The user does not exist, display an error message
					$_SESSION["eror"] = "Napačno uporabniško ime ali geslo.";
					header("Location: index.php");
					exit();
				}
			}
			if(isset($_POST['guest'])){
				$_SESSION["eror"] = "";
				$_SESSION['username'] = "gost";
				header("Location: game.php");
				exit();
			}
			if(isset($_POST['register'])){
				$_SESSION["eror"] = "";
				header("Location: registracija.php");
				exit();
			}
		?>
		

		<footer></footer>
	</body>
</html>








 
