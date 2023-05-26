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
		<style>
			label, p{
				color:white;
				background-color: red;
			}
			button{
				padding:5px;
			}
		</style>
	</head>
	<body>
		<header>
			<h1>Registracija</h1>
		</header>
		<div id="main">
			<div style="height:30px"></div>
			<form method="POST" action="">
				<div style="display: flex; justify-content: center">
					<div style="width:50%">
						<label style="float:right">Uporabniško ime:</label>
					</div>
					<div style="width:50%"	>
						<input type="text" name="username" style="float:left"><label><?php echo (isset($_SESSION["usrnameERR"])) ? $_SESSION["usrnameERR"] : "" ?></label><br><br>
					</div>
				</div>
				<div style="display: flex; justify-content: center">
					<div style="width:50%">
						<label style="float:right">Geslo:</label>
					</div>
					<div style="width:50%">
						<input type="password" name="password" style="float:left"><label><?php echo (isset($_SESSION["passwrdERR"])) ? $_SESSION["passwrdERR"] : "" ?></label><br><br>
					</div>
				</div>
				<div style="display: flex; justify-content: center">
					<div style="width:50%">
						<label style="float:right">Potrdi geslo:</label>
					</div>
					<div style="width:50%">
						<input type="password" name="passwordConf" style="float:left"><label><?php echo (isset($_SESSION["passwrdConfERR"])) ? $_SESSION["passwrdConfERR"] : "" ?></label><br><br>
					</div>
				</div>
				<button type="submit" name="insert">Registracija</button> 
				<button type="submit" name="guest">Gost</button> 
				<button type="submit" name="nzaj">Prijava</button>
			</form>
		</div>
		<?php
			$db = db::getInstance();

			if(isset($_POST['guest'])){
				$_SESSION["usrnameERR"] = "";
				$_SESSION["passwrdERR"] = "";
				$_SESSION["passwrdConfERR"] = "";
				$bol = false;
				$_SESSION['username'] = "gost";
				header("Location: game.php");
				exit();
			}
			if(isset($_POST['nzaj'])){
				$_SESSION["usrnameERR"] = "";
				$_SESSION["passwrdERR"] = "";
				$_SESSION["passwrdConfERR"] = "";
				$bol = false;
				header("Location: index.php");
				exit();
			}
			if(isset($_POST['insert'])){
				$bol = false;
				// Define variables and set to empty values
				$username = trim($_POST["username"]);
				$password = $_POST["password"];
				$confirm_password = $_POST["passwordConf"];
		
				// Validate username
				if (empty(trim($_POST["username"]))) {
					$_SESSION["usrnameERR"] = "Vnesite uporabniško ime.";
					$bol = true;
				} else {
					// Prepare a select statement
					$query = "SELECT COUNT(id) FROM user WHERE usrname = ?";
					$stmt = $db->prepare($query);
					$stmt->bindParam(1, $username,PDO::PARAM_STR);
					$stmt->execute();
					
					if ($stmt->fetchColumn(0) >= 1) {
						$_SESSION["usrnameERR"] = "Uporabniško ime je že zasedeno.";
						$bol = true;
					}
				}
			
				// Validate password
				if (empty(trim($_POST["password"]))) {
					$_SESSION["passwrdERR"] = "Vnesite geslo."; 
					$bol = true;    
				} elseif (strlen(trim($_POST["password"])) < 6) {
					$_SESSION["passwrdERR"] = "Geslo mora biti daljše od 6 znakov.";
					$bol = true;
				} else {
					$password = trim($_POST["password"]);
				}
				
				// Validate confirm password
				if (empty(trim($_POST["passwordConf"]))) {
					$_SESSION["passwrdConfERR"] = "Potrdite geslo.";   
					$bol = true;  
				} else {
					$confirm_password = trim($_POST["passwordConf"]);
					if ($password != $confirm_password) {
						$_SESSION["passwrdConfERR"] = "Gesli se ne ujemata."; 
						$bol = true;
					}
				}

				if($bol){
					header("Location: registracija.php");
					exit();
				}
				// Prepare the SQL statement to check if the user exists in the database
				$query = "INSERT INTO user (usrname, passwrd) VALUES (?,?)";
				$stmt = $db->prepare($query);
				$stmt->bindParam(1, $username,PDO::PARAM_STR);
				$stmt->bindParam(2, $password,PDO::PARAM_STR);
				$stmt->execute();
				
				$_SESSION["usrnameERR"] = "";
				$_SESSION["passwrdERR"] = "";
				$_SESSION["passwrdConfERR"] = "";
				header("Location: index.php");
				exit();
			}
		?>

		<footer></footer>
	</body>
</html>
