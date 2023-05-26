<?php
    session_start();
    require_once("dbBrixball.php");
    require_once("db.php");
    $db = db::getInstance();

    // Check if the user clicked the login button
    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

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
            $_SESSION["eror"] = "Ta uporabnik ne obstaja.";
            header("Location: game.php");
            exit();
        }
    }
    if(isset($_POST['guest'])){
        $_SESSION['username'] = "gost";
        header("Location: game.php");
        exit();
    }
    if(isset($_POST['register'])){
        header("Location: registracija.php");
        exit();
    }
    if(isset($_POST['nzaj'])){
        header("Location: index.php");
        exit();
    }
    if(isset($_POST['insert'])){
        // Define variables and set to empty values
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirm_password = $_POST["passwordConf"];
        $username_err = $password_err = $confirm_password_err = $email_err = "";

        // Validate username
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter a username.";
        } else {
            // Prepare a select statement
            $query = "SELECT id FROM user WHERE usrname = ?";
            $stmt = $db->prepare($query);
            $stmt->bindParam(1, $username,PDO::PARAM_STR);
            
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                // Set parameters
                $param_username = trim($_POST["username"]);
                
                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt);
                    
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $username_err = "This username is already taken.";
                    } else {
                        $username = trim($_POST["username"]);
                    }
                } else {
                    $_SESSION["eror"] = "Nekaj je narobe, poskusi pozneje.";
                    header("Location: game.php");
                    exit();
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
    
        // Validate password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter a password.";     
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Password must have at least 6 characters.";
        } else {
            $password = trim($_POST["password"]);
        }
        
        // Validate confirm password
        if (empty(trim($_POST["passwordConf"]))) {
            $confirm_password_err = "Please confirm password.";     
        } else {
            $confirm_password = trim($_POST["passwordConf"]);
            if ($password != $confirm_password) {
                $confirm_password_err = "Password did not match.";
            }
        }

        // Prepare the SQL statement to check if the user exists in the database
        $sql = "INSERT INTO user (usrname, passwrd) VALUES ('$username', '$password')";
        if(mysqli_stmt_execute(mysqli_prepare($conn, $sql))){
            header("Location: index.php");
            exit();
        }

        // Close the database connection
        mysqli_close($conn);
    }
?>
