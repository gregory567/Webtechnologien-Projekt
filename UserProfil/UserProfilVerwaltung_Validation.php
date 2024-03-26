
<!-- Validation of the data put in by the user in the Profile Update form -->
<?php
    // define variables and set to empty values
    $vornameErr = $nachnameErr = $emailErr = $usernameErr = $altes_passwortErr = $neues_passwortErr = $passwort_confirmErr = "";
    $anredeSucc = $vornameSucc = $nachnameSucc = $emailSucc = $usernameSucc = $altes_passwortSucc = $passwort_confirmSucc = "";
    $anrede = $vorname = $nachname = $email = $username = $altes_passwort = $neues_passwort = $passwort_confirm = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_POST['anrede']) && !empty($_POST['anrede'])) { 
            $anrede = test_input($_POST["anrede"]);
            $anredeSucc = "Änderung der Anrede erfolgreich!";
        }

        if (!empty($anredeSucc)) {
            // INSERT into DB with Prepared Statements
            $sql = "UPDATE `users` SET `anrede` = ? WHERE `id` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("si", $anrede, $user_id);

            /* Execute the prepared statement */
            $status = $stmt -> execute();
            /* check whether the execute() succeeded */
            if ($status === FALSE) {
                trigger_error($stmt -> error, E_USER_ERROR);
            } else {
                /*"1 Row inserted." will be printed out while successful*/
                printf("%d Row inserted.\n", $stmt -> affected_rows);
                //echo "<h2 class='text-center'> Update Successful! </h2>";
            }

            $stmt -> close();
        }
        

        if (!empty($_POST["vorname"])) {
            $vorname = test_input($_POST["vorname"]);
            // check if vorname only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $vorname)) {
                $vornameErr = "Nur Buchstaben und Leerzeichen erlaubt im Vornamen";
            } else {
                $vornameSucc = "Änderung der Vorname erfolgreich!";
            }
        }

        if (!empty($vornameSucc)) {
            // INSERT into DB with Prepared Statements
            $sql = "UPDATE `users` SET `vorname` = ? WHERE `id` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("si", $vorname, $user_id);

            /* Execute the prepared statement */
            $status = $stmt -> execute();
            /* check whether the execute() succeeded */
            if ($status === FALSE) {
                trigger_error($stmt -> error, E_USER_ERROR);
            } else {
                /*"1 Row inserted." will be printed out while successful*/
                printf("%d Row inserted.\n", $stmt -> affected_rows);
                //echo "<h2 class='text-center'> Update Successful! </h2>";
            }

            $stmt -> close();
        }

        if (!empty($_POST["nachname"])) {
            $nachname = test_input($_POST["nachname"]);
            // check if vorname only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $nachname)) {
                $nachnameErr = "Nur Buchstaben und Leerzeichen erlaubt im Nachnamen";
            } else {
                $nachnameSucc = "Änderung der Nachname erfolgreich!";
            }
        }

        if (!empty($nachnameSucc)) {
            // INSERT into DB with Prepared Statements
            $sql = "UPDATE `users` SET `nachname` = ? WHERE `id` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("si", $nachname, $user_id);

            /* Execute the prepared statement */
            $status = $stmt -> execute();
            /* check whether the execute() succeeded */
            if ($status === FALSE) {
                trigger_error($stmt -> error, E_USER_ERROR);
            } else {
                /*"1 Row inserted." will be printed out while successful*/
                printf("%d Row inserted.\n", $stmt -> affected_rows);
                //echo "<h2 class='text-center'> Update Successful! </h2>";
            }

            $stmt -> close();
        }

        if (!empty($_POST["email"])) {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Ungültige Email Adresse.";
            } else {
                $emailSucc = "Änderung der Email Adresse erfolgreich!";
            }
        }

        if (!empty($emailSucc)) {
            // INSERT into DB with Prepared Statements
            $sql = "UPDATE `users` SET `email` = ? WHERE `id` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("si", $email, $user_id);

            /* Execute the prepared statement */
            $status = $stmt -> execute();
            /* check whether the execute() succeeded */
            if ($status === FALSE) {
                trigger_error($stmt -> error, E_USER_ERROR);
            } else {
                /*"1 Row inserted." will be printed out while successful*/
                printf("%d Row inserted.\n", $stmt -> affected_rows);
                //echo "<h2 class='text-center'> Update Successful! </h2>"; 
            }

            $stmt -> close();
        }

        if (!empty($_POST["username"])) {
            $username = test_input($_POST["username"]);

            // SELECT from DB with Prepared Statements to check if username already exists in the DB
            $sql = "SELECT * FROM `users` WHERE `username` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("s", $username);
            $stmt -> execute();
            $stmt -> store_result();

            if ($stmt -> num_rows > 0) {  
                $usernameErr = "Username bereits vergeben. Bitte wählen Sie einen anderen Usernamen."; 
            } else {  
                $usernameSucc = "Änderung des Usernamens erfolgreich!";
            }  

            $stmt -> close();
        }

        if (!empty($usernameSucc)) {
            // INSERT into DB with Prepared Statements
            $sql = "UPDATE `users` SET `username` = ? WHERE `id` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("si", $username, $user_id);

            /* Execute the prepared statement */
            $status = $stmt -> execute();
            /* check whether the execute() succeeded */
            if ($status === FALSE) {
                trigger_error($stmt -> error, E_USER_ERROR);
            } else {
                /*"1 Row inserted." will be printed out while successful*/
                printf("%d Row inserted.\n", $stmt -> affected_rows);
                //echo "<h2 class='text-center'> Update Successful! </h2>";
            }

            $stmt -> close();
        }


        if (!empty($_POST["altes_passwort"])) {
            $altes_passwort = test_input($_POST["altes_passwort"]);

            // SELECT from DB with Prepared Statements to check if the old password is stored in the DB 
            $sql = "SELECT * FROM `users` WHERE `id` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("i", $user_id);
            $stmt -> execute();
            $result = $stmt -> get_result();
            
            while($row = $result -> fetch_object()){
                $hash = $row -> passwort;
            }
            /*
            while($row = $result -> fetch_assoc()){
                $hash = $row["passwort"];
            }
            */
            if(password_verify($altes_passwort, $hash)) {
                $altes_passwortSucc = "Gültiges Passwort";
            } else {
                $altes_passwortErr = "Falsches Passwort"; 
            }
        } else {
            $altes_passwortErr = "Altes Passwort muss angegeben werden!";
        }

        if (!empty($altes_passwortSucc)) {
            if (!empty($_POST["neues_passwort"]) && ($_POST["neues_passwort"] == $_POST["passwort_confirm"])) {
                // Given new password
                $neues_passwort = test_input($_POST["neues_passwort"]);
                // Given new password confirmation
                $passwort_confirm = test_input($_POST["passwort_confirm"]);
                
                // Validate new password's strength
                $uppercase = preg_match('@[A-Z]@', $neues_passwort);
                $lowercase = preg_match('@[a-z]@', $neues_passwort);
                $number = preg_match('@[0-9]@', $neues_passwort);
                //$specialChars = preg_match('@[^\w]@', $passwort);
    
                if (strlen($neues_passwort) < 8) {
                    $neues_passwortErr = "Ihr Passwort muss mindestens 8 Charakter enthalten!";
                } elseif(!$number) {
                    $neues_passwortErr = "Ihr Passwort muss mindestens eine Zahl enthalten!";
                } elseif(!$uppercase) {
                    $neues_passwortErr = "Ihr Passwort muss mindestens einen Großbuchstaben enthalten!";
                } elseif(!$lowercase) {
                    $neues_passwortErr = "Ihr Passwort muss mindestens einen Kleinbuchstaben enthalten!";
                } else {
                    $passwort_confirmSucc = 'Starkes Passwort. Neues Passwort angenommen.';
                }
            } else {
                $passwort_confirmErr = "Neues Passwort muss angegeben und bestätigt werden";
            }
    
            if (!empty($passwort_confirmSucc)) {
                // INSERT into DB with Prepared Statements
                $sql = "UPDATE `users` SET `passwort` = ? WHERE `id` = ?";
                $stmt = $conn -> prepare($sql);
                $stmt -> bind_param("si", $hashvalue, $user_id);
                
                $hashvalue = password_hash($neues_passwort, PASSWORD_DEFAULT);
    
                /* Execute the prepared statement */
                $status = $stmt -> execute();
                /* check whether the execute() succeeded */
                if ($status === FALSE) {
                    trigger_error($stmt -> error, E_USER_ERROR);
                } else {
                    /*"1 Row inserted." will be printed out while successful*/
                    printf("%d Row inserted.\n", $stmt -> affected_rows);
                    //echo "<h2 class='text-center'> Update Successful! </h2>";
                }
    
                $stmt -> close();
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
