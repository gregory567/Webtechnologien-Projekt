

<!-- Validation of the data put in by the user in the registration form -->
<?php
    // define variables and set to empty values
    $anredeErr = $vornameErr = $nachnameErr = $emailErr = $usernameErr = $passwortErr = $passwort_confirmErr = "";
    $anredeSucc = $vornameSucc = $nachnameSucc = $emailSucc = $usernameSucc = $passwort_confirmSucc = "";
    $anrede = $vorname = $nachname = $email = $username = $passwort = $passwort_confirm = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['anrede']) && empty($_POST['anrede'])) { 
            $anredeErr = "Anrede muss angegeben werden";
        } else {
            $anrede = test_input($_POST["anrede"]);
            $anredeSucc = "Bestätigt";
        }
        
        if (empty($_POST["vorname"])) {
            $vornameErr = "Vorname muss angegeben werden";
        } else {
            $vorname = test_input($_POST["vorname"]);
            // check if vorname only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $vorname)) {
                $vornameErr = "Nur Buchstaben und Leerzeichen erlaubt im Vornamen";
            } else {
                $vornameSucc = "Bestätigt";
            }
        }

        if (empty($_POST["nachname"])) {
            $nachnameErr = "Nachname muss angegeben werden";
        } else {
            $nachname = test_input($_POST["nachname"]);
            // check if nachname only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $nachname)) {
                $nachnameErr = "Nur Buchstaben und Leerzeichen erlaubt im Nachnamen";
            } else {
                $nachnameSucc = "Bestätigt";
            }
        }
        
        if (empty($_POST["email"])) {
            $emailErr = "Email Adresse muss angegeben werden";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Ungültige Email Adresse.";
            } else {
                $emailSucc = "Gültige Email Adresse.";
            }
        }

        if (empty($_POST["username"])) {
            $usernameErr = "Username muss angegeben werden";
        } else {
            $username = test_input($_POST["username"]);

            /* SELECT with prepared statement to check if username already exists in the DB */
            $sql = "SELECT * FROM `users` WHERE `username` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("s", $username);
            $stmt -> execute();
            $stmt -> store_result();

            if ($stmt -> num_rows > 0) {  
                $usernameErr = "Username bereits vergeben. Bitte wählen Sie einen anderen Usernamen."; 
            } else {  
                $usernameSucc = "Username gültig und angenommen.";
            }  

            $stmt -> close();
        }

        if (!empty($_POST["passwort"]) && ($_POST["passwort"] == $_POST["passwort_confirm"])) {
            // Given password
            $passwort = test_input($_POST["passwort"]);
            // Given password confirmation
            $passwort_confirm = test_input($_POST["passwort_confirm"]);
            
            // Validate password strength
            $uppercase = preg_match('@[A-Z]@', $passwort);
            $lowercase = preg_match('@[a-z]@', $passwort);
            $number = preg_match('@[0-9]@', $passwort);
            //$specialChars = preg_match('@[^\w]@', $passwort);

            if (strlen($passwort) < 8) {
                $passwortErr = "Ihr Passwort muss mindestens 8 Charakter enthalten!";
            } elseif(!$number) {
                $passwortErr = "Ihr Passwort muss mindestens eine Zahl enthalten!";
            } elseif(!$uppercase) {
                $passwortErr = "Ihr Passwort muss mindestens einen Großbuchstaben enthalten!";
            } elseif(!$lowercase) {
                $passwortErr = "Ihr Passwort muss mindestens einen Kleinbuchstaben enthalten!";
            } else {
                $passwort_confirmSucc = 'Starkes Passwort. Passwort angenommen.';
            }
        } else {
            $passwort_confirmErr = "Passwort muss angegeben und bestätigt werden";
        }

        if (!empty($anredeSucc) && !empty($vornameSucc) && !empty($nachnameSucc) &&
        !empty($emailSucc) && !empty($usernameSucc) && !empty($passwort_confirmSucc)) {
            
            // after all data is declared to be correct:
            // INSERT into DB with Prepared Statements
            $sql = "INSERT INTO `users` (`anrede`, `vorname`, `nachname`, `email`, `username`, `passwort`, `rolle`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn -> prepare($sql);

            // role is always automatically set to "user"
            $rolle = "user";
            // status is always automatically set to "aktiv"
            $status = "aktiv";
            $hashvalue = password_hash($passwort, PASSWORD_DEFAULT);
            $stmt -> bind_param("ssssssss", $anrede, $vorname, $nachname, $email, $username, $hashvalue, $rolle, $status);

            $stmt -> execute();
            $stmt -> close();
            $conn -> close();
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>



