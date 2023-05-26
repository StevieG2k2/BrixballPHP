<?php

require_once "db.php";

class dbBrixball {
    public static function getUsr() {
        $db = db::getInstance();

        $statement = $db->prepare("SELECT id, usrname, passwrd FROM user WHERE usrname = ?");
        $statement->execute();

        return $statement->fetchAll();
    }

    //dobi top 10 rekordov DONE
    public static function getAll() {
        $db = db::getInstance();

        $statement = $db->prepare("SELECT usrname, points, DATE_FORMAT(date,'%d.%m.%Y') as date,DATE_FORMAT(time,'%i:%s') as time 
            FROM wr, personalrekord, user
            WHERE wr.idUser = user.id and wr.idRekord = personalrekord.id
            order by points desc, time desc");
        $statement->execute();

        return $statement->fetchAll();
    }

    //dobi vse svoje rekorde DONE?
    public static function get($id) {
        $db = db::getInstance();

        $statement = $db->prepare("SELECT usrname, points, DATE_FORMAT(date,'%d.%m.%Y') as date,DATE_FORMAT(time,'%i:%s') as time FROM personalrekord, user 
            WHERE personalrekord.idUser = user.id and user.id = :id
            order by points desc, time asc");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    //dobi vn najmanjsi rekord uporabnika
    public static function getPersRecId($id) {
        $db = db::getInstance();

        $statement = $db->prepare("SELECT id FROM personalrekord
            WHERE personalrekord.idUser = :id
            order by points asc, time asc");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getMinPersRec($id) {
        $db = db::getInstance();

        $statement = $db->prepare("SELECT personalrekord.id as id, usrname, points, DATE_FORMAT(date,'%d.%m.%Y') as date,DATE_FORMAT(time,'%i:%s') as time 
            FROM personalrekord, user
            WHERE user.id = personalrekord.idUser and user.id = :id
            order by points asc, time asc");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    //dobi stevilo rekordu ene osebe
    public static function getNumIds($id) {
        $db = db::getInstance();

        $statement = $db->prepare("SELECT COUNT(idUser) FROM personalrekord
            WHERE personalrekord.idUser = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    //insert pri registraciji DONE
    public static function insert($name, $password) {
        $db = db::getInstance();

        $statement = $db->prepare("INSERT INTO user (usrname, passwrd)
            VALUES (:name, :pass)");
        $statement->bindParam(":name", $name);
        $statement->bindParam(":pass", $password);
        $statement->execute();
    }

    public static function insertWR($user, $rekord) {
        $db = db::getInstance();

        $statement = $db->prepare("INSERT INTO wr (idUser, idRekord)
            VALUES (:usr, :rekord)");
        $statement->bindParam(":usr", $user);
        $statement->bindParam(":rekord", $rekord);
        $statement->execute();
    }

    //dodaj personal rekord DONE?
    public static function insertPersonal($id, $points, $time, $date) {
        $db = db::getInstance();

        $statement = $db->prepare("INSERT INTO personalrekord (idUser, points, time, date)
            VALUES (:idUser, :points, :cas, :datum)");
        $statement->bindParam(":idUser", $id);
        $statement->bindParam(":points", $points);
        $statement->bindParam(":cas", $time);
        $statement->bindParam(":datum", $date);
        $statement->execute();
    }

    //za dodajanje rekorda ce jih je ze 10 notr
    public static function update($id, $author, $title, $price, $year) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE book SET author = :author,
            title = :title, price = :price, year = :year WHERE id = :id");
        $statement->bindParam(":author", $author);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":price", $price);
        $statement->bindParam(":year", $year);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    //pobrisi svoje rekorde mogoce
    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM book WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }   
}
