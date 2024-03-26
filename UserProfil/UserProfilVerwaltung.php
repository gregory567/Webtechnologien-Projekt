

<!DOCTYPE html>
<?php 
    session_start();
    if (isset($_GET["logout"]) && $_GET["logout"]) {
        // remove all session variables
        session_unset();
        // destroy the session
        session_destroy();
        // redirect to homepage 
        header("Location: ../homepage/Homepage.php");
        exit("logged out user");
    }

    // check if user is logged in
    if(!isset($_SESSION["username"]) && !isset($_SESSION["id"])){
        // not logged in: redirect to login.php
        echo "<h2 class='text-center'> You are not logged in. </h2>";
        header('Refresh: 2; URL = ../Login/Login.php'); 
    }

    // require access data to DB and build up connection to DB
    require_once('../dbaccess.php'); //to retrieve connection details
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed. Error in DB connection: ". $conn->connect_errno ." : ". $conn->connect_error); 
    }

    $user_username = $_SESSION["username"];
    $user_id = $_SESSION["id"];
?>

<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--Bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!--Schriftart-->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">

        <link rel="stylesheet" href="../css/Registrierung.css">
        <title>Profil Verwaltung</title>
        <!--Farbe der Fehlernachrichten-->
        <style>
            .error {color: #FF0000;} /*rot*/ 
        </style>
        <!--Farbe der Erfolgsnachrichten-->
        <style>
            .success {color: #00FF00;} /*lime*/
        </style>
        <!--Tabelle-->
        <style>
        table {
            font-family: 'Roboto', sans-serif;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
            display: flex;
            border-radius: 6px;
        }

        td, th {
            border: 1px solid #466281;
            padding: 8px;
        }

        th {
            background-color: #97AFC8; /* light gray */
            font-weight: bold;
            flex: 0 0 25%; /* main columns will take up 25% of the table's width */
            text-align: center; /* align text to the left */
        }

        td {
            flex: 1; /* the other columns will take up the remaining space */
            text-align: center; /* align text to the center */
        }

        
        </style>
    </head>
<!-------------------------------------------------------------HTML BODY BEGIN------------------------------------------------------------------------------------------>
<body>
    <!--Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <div class="container">
        <?php include '../Navigation.php'; ?>

        <?php include './UserProfilVerwaltung_Validation.php'; ?>

        <!-- display log in status -->
        <div class="logged_in_status">
            <?php 
            if(isset($_SESSION["username"])){
                $user_username = $_SESSION["username"];
                echo "Eingeloggt als $user_username";
            }
            ?>
        </div>

        <!-------------------------------------------------------------PROFILE UPDATE FORM BEGIN------------------------------------------------------------------------------------------>
        <div class="signup-form">
            <div class ="box">
                <br>
                <?php
                /* Select the row corresponding to the user who is currently logged in with prepared statement */
                $sql = "SELECT * FROM `users` WHERE `id` = ?";
                $stmt = $conn -> prepare($sql);
                $stmt -> bind_param("i", $user_id);
                $stmt -> execute();
                $result = $stmt -> get_result(); // get the mysqli result
                /* save the elements of the result row in variables for later output */
                while ($row = $result -> fetch_assoc()) {
                    $current_anrede = $row["anrede"];
                    $current_vorname = $row["vorname"];
                    $current_nachname = $row["nachname"];
                    $current_email = $row["email"];
                    $current_username = $row["username"];
                } ?> 
                <!-- display current user data in a table at the top of the page -->
                <table>
                    <tr>
                        <th>Anrede</th>
                        <td> <?php echo $current_anrede; ?> </td>
                    </tr>
                    <tr>
                        <th>Vorname</th>
                        <td> <?php echo $current_vorname; ?> </td>
                    </tr>
                    <tr>
                        <th>Nachname</th>
                        <td> <?php echo $current_nachname; ?> </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td> <?php echo $current_email; ?> </td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td> <?php echo $current_username; ?> </td>
                    </tr>
                </table>
                
                <!-- a series of POST forms to change the user's data and password if required -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <h3> User Profilverwaltung </h3>
                    <h3> Hier können Sie die Stammdaten Ihres Profils ändern. </h3>
                    <h2> Anrede </h2>
                    
                    <div class="form-group">

                        <select id="form_anrede" class="form-control" name="anrede">
                            <option value="" selected>Bitte neue Anrede auswählen...</option>
                            <?php
                                $values = array("Frau", "Herr", "Divers");
                                foreach ($values as $v) {                                    
                                    echo "<option value=\"" . $v . "\" " . ($anrede == $v ? "selected" : "") . " >" . $v . "</option>";
                                }
                            ?>
                        </select>

                        <span class="success"><?php echo $anredeSucc;?></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-outline btn-lg btn-block secondary" name="submit" value="Submit">Abschicken</button>
                    </div>

                </form>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <h2>Vorname</h2>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" name="vorname" value="<?php echo $vorname;?>" placeholder="Neuer Vorname">
                        <span class="error">* <?php echo $vornameErr;?></span><br/>
                        <span class="success"><?php echo $vornameSucc;?></span>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline btn-lg btn-block secondary" name="submit" value="Submit">Abschicken</button>
                    </div>

                </form>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <h2>Nachname</h2>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" name="nachname" value="<?php echo $nachname;?>" placeholder="Neuer Nachname">
                        <span class="error">* <?php echo $nachnameErr;?></span><br/>
                        <span class="success"><?php echo $nachnameSucc;?></span>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline btn-lg btn-block secondary" name="submit" value="Submit">Abschicken</button>
                    </div>

                </form>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <h2>Email</h2>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" name="email" value="<?php echo $email;?>" placeholder="Neue Email">
                        <span class="error">* <?php echo $emailErr;?></span><br/>
                        <span class="success"><?php echo $emailSucc;?></span>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline btn-lg btn-block secondary" name="submit" value="Submit">Abschicken</button>
                    </div>

                </form>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <h2>Username</h2>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" value="<?php echo $username;?>" placeholder="Neuer Username">
                        <span class="error">* <?php echo $usernameErr;?></span><br/>
                        <span class="success"><?php echo $usernameSucc;?></span>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline btn-lg btn-block secondary" name="submit" value="Submit">Abschicken</button>
                    </div>

                </form>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <h2>Passwort</h2>

                    <div class="form-group">
                        <input type="password" class="form-control" name="altes_passwort" placeholder="Altes Passwort">
                        <span class="error">* <?php echo $altes_passwortErr;?></span><br/>
                        <span class="success"><?php echo $altes_passwortSucc;?></span>
                    </div> 
                    
                    <div class="form-group">
                        <input type="password" class="form-control" name="neues_passwort" placeholder="Neues Passwort"> 
                        <span class="error">* <?php echo $neues_passwortErr;?></span>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" name="passwort_confirm" placeholder="Neues Passwort bestätigen">
                        <span class="error">* <?php echo $passwort_confirmErr;?></span><br/>
                        <span class="success"><?php echo $passwort_confirmSucc;?></span>
                    </div> 
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline btn-lg btn-block secondary" name="submit" value="Submit">Abschicken</button>
                    </div>

                </form>
        
                <div class="text-center">Zurück zur <a href="../homepage/Homepage.php">Homepage</a></div>
                <br>
            </div>
        </div>
    </div>
</body>
<!--------------------------------------------------------------HTML END------------------------------------------------------------------------------------------>
</html>



