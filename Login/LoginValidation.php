
<!-- Validation of the data put in by the user in the login form -->
<?php
    // define variables and set to empty values
    $usernameErr = $passwortErr = "";
    $usernameSucc = $passwortSucc = "";
    $username = $passwort = "";
 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["username"])) {
            $usernameErr = "Username muss angegeben werden";
        } else {
            $username = test_input($_POST["username"]);

            // SELECT from DB with Prepared Statements to check if username is stored in the DB
            $sql = "SELECT * FROM `users` WHERE `username` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("s", $username);
            $stmt -> execute();
            $stmt -> store_result();

            if ($stmt -> num_rows == 1) {  
                $usernameSucc = "Gültiger Username";   
            } else {  
                $usernameErr = "Falscher Username"; 
            }     
        }


        if (!empty($_POST["passwort"])) {
            // Given password
            $passwort = test_input($_POST["passwort"]);

            // SELECT from DB with Prepared Statements to check if hashed password is identical to input password 
            $sql = "SELECT * FROM `users` WHERE `username` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("s", $username);
            $stmt -> execute();
            $result = $stmt -> get_result();
            
            while($row = $result -> fetch_object()){
                $id = $row -> id;
                $hash = $row -> passwort;
            }
            /*
            while($row = $result -> fetch_assoc()){
                $id = $row["id"];
                $hash = $row["passwort"];
            }
            */
            if(password_verify($passwort, $hash)) {
                $passwortSucc = "Gültiges Passwort"; 
            } else {
                $passwortErr = "Falsches Passwort"; 
            }
        } else {
            $passwortErr = "Passwort muss angegeben werden";
        }
        
        if(!empty($passwortSucc)){
            // SELECT from DB with Prepared Statements to check if user's status is active
            $sql = "SELECT * FROM `users` WHERE `username` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("s", $username);
            $stmt -> execute();
            $result = $stmt -> get_result();
            
            while($row = $result -> fetch_object()){
                $status = $row -> status;
            }
            /*
            while($row = $result -> fetch_assoc()){
                $status = $row["status"];
            }
            */
            if($status == "aktiv") {
                $_SESSION["username"] = $username;
                $_SESSION["id"] = $id;
                echo "<h2 class='text-center'> Login erfolgreich! Wilkommen $username! </h2>";
                if ($username == "admin") {
                    header('Refresh: 4; URL = ../FileUpload/FileUpload.php'); 
                } else {
                    header('Refresh: 4; URL = ../Reservierung/Reservierung.php');
                }
            } else {
                header('Refresh: 3; URL = ../Login/Login.php'); 
                //$passwortSucc = "";
                $passwortErr = "Status inaktiv, Zugang verweigert"; 
            }
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>


