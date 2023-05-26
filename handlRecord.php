<?php
	session_start();
    require_once("dbBrixball.php");
    require_once("db.php");
    $db = db::getInstance();

    if($_SESSION["username"] == "gost"){
        echo"gost";
        return;
    }

    //$name = $_POST['name'];
    $points = $_POST['points'];
    $time = $_POST['timeO'];
    $minTry = explode(":",$time)[0];
    $secTry = explode(":",$time)[1];
    $date = $_POST['date'];
    $dan = explode(".",$date)[0];
    $mesc = explode(".",$date)[1];
    $leto = explode(".",$date)[2];


    $query = "SELECT id FROM user WHERE usrname = ?";
	$stmt = $db->prepare($query);
	$stmt->bindParam(1, $_SESSION['username'],PDO::PARAM_STR);
	$stmt->execute();
	$_SESSION["id"] = $stmt->fetchColumn(0);

    // stevilo osebnih rekordu
	$numOfPersRecs = dbBrixball::getNumIds($_SESSION["id"]);
	// 3 (jernej)
	//echo(implode(" ", $numOfPersRecs[0]));
    $t = "00:".$time;
    $d = $leto."-".$mesc."-".$dan;
    echo implode(" ", $numOfPersRecs[0]);
    if(intval(implode(" ", $numOfPersRecs[0])) < 10){
        $query = "INSERT INTO `personalrekord`(`idUser`, `points`, `time`, `date`) VALUES (?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $_SESSION['id'],PDO::PARAM_INT);
        $stmt->bindParam(2, $points,PDO::PARAM_INT);
        $stmt->bindParam(3, $t,PDO::PARAM_STR);
        $stmt->bindParam(4, $d,PDO::PARAM_STR);
        $stmt->execute();
        echo "dodano";
        return;
    }

    // ID najmanjsega presonal rekorda
	$idOfMinPersRec = dbBrixball::getPersRecId($_SESSION["id"]);
    
    echo intval(implode(" ", $idOfMinPersRec[0]));
    echo gettype(intval(implode(" ", $idOfMinPersRec[0])));
    $ajdi = intval(implode(" ", $idOfMinPersRec[0]));
	// 5 (jernej)
	//if($numOfMinPersRec != [])
		//echo(implode(" ", $numOfMinPersRec[0]));
	
	//get dobi use personal rekorde max -> min
	$PersRecs = dbBrixball::get($_SESSION["id"]);
	//jernej 120 datum cas
	//if($numOfMinPersRec != [])
		//echo(implode(" ", $PersRecs[0]));

	//IME, TOCKE, DATUM, CAS
	$minRecs = dbBrixball::getMinPersRec($_SESSION["id"]);
    $timeRecord = ($minRecs[0])["time"];
    $minRec = explode(":",$timeRecord)[0];
    $secRec = explode(":",$timeRecord)[1];
    $tockeRecord = ($minRecs[0])["points"];

    $tt = intval($minTry.$secTry);
    $tr = intval($minRec.$secRec);
    if($points > $tockeRecord){
        $query = "UPDATE personalrekord SET points=?,time=?,date=? WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $points,PDO::PARAM_INT);
        $stmt->bindParam(2, $t,PDO::PARAM_STR);
        $stmt->bindParam(3, $d,PDO::PARAM_STR);
        $stmt->bindParam(4, $ajdi,PDO::PARAM_INT);
        $stmt->execute();
        echo "updated P>R";
        return;
    }else if($points == $tockeRecord && $tt < $tr){
        $query = "UPDATE personalrekord SET time=?,date=? WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $t,PDO::PARAM_STR);
        $stmt->bindParam(2, $d,PDO::PARAM_STR);
        $stmt->bindParam(3, $ajdi,PDO::PARAM_INT);
        $stmt->execute();
        echo "updated P=R";
        return;
    }





    // Process the received data and generate a response
    //$response = "Hello, ".$_SESSION['username']."! Your points are " . $points . ", time: " . $time . ", date: ". $date;
    $response = "try: ".$idOfMinPersRec. ", sdadsad ".$tockeRecord;
    // Send the response back to the JavaScript file
    echo $response;
    return;
?>