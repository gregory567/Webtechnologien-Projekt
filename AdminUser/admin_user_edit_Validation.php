

<!-- Validation of the data put in by the admin in the Profile Update form -->
<?php
    // define variables and set to empty values
    $vornameErr = $nachnameErr = $emailErr = $new_usernameErr = $neues_passwortErr = $passwort_confirmErr = "";
    $anredeSucc = $vornameSucc = $nachnameSucc = $emailSucc = $new_usernameSucc = $passwort_confirmSucc ="";
    $anrede = $vorname = $nachname = $email = $new_username = $neues_passwort = $passwort_confirm = "";

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET['anrede']) && !empty($_GET['anrede'])) { 
            $anrede = test_input($_GET["anrede"]);
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
        

        if (!empty($_GET["vorname"])) {
            $vorname = test_input($_GET["vorname"]);
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

        if (!empty($_GET["nachname"])) {
            $nachname = test_input($_GET["nachname"]);
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

        if (!empty($_GET["email"])) {
            $email = test_input($_GET["email"]);
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

        if (!empty($_GET["new_username"])) {
            $new_username = test_input($_GET["new_username"]);

            // SELECT from table "users" to check if the chosen new username already exists in the DB
            $sql = "SELECT * FROM `users` WHERE `username` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("s", $new_username);
            $stmt -> execute();
            $stmt -> store_result();

            if ($stmt -> num_rows == 1) {  
                $new_usernameErr = "Username existiert bereits in der Datenbank."; 
            } else {  
                $new_usernameSucc = "Änderung des Usernamens erfolgreich!";
            }  

            $stmt -> close();
        }

        if (!empty($new_usernameSucc)) {
            // INSERT into DB with Prepared Statements
            $sql = "UPDATE `users` SET `username` = ? WHERE `id` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("si", $new_username, $user_id);

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

        if (!empty($_GET["neues_passwort"]) && ($_GET["neues_passwort"] == $_GET["passwort_confirm"])) {
            // Given password
            $neues_passwort = test_input($_GET["neues_passwort"]);
            // Given password confirmation
            $passwort_confirm = test_input($_GET["passwort_confirm"]);
            
            // Validate password strength
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
            
            // hash the password before sending into DB
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

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>