
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

    // require access data to DB and build up connection to DB
    require_once('../dbaccess.php'); //to retrieve connection details
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed. Error in DB connection: ". $conn->connect_errno ." : ". $conn->connect_error); 
    }

    if(isset($_SESSION["username"]) && isset($_SESSION["id"])){
        $user_username = $_SESSION["username"];
        $user_id = $_SESSION["id"];
    }
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
        <title>Registrierung</title>
        <!--Farbe der Fehlernachrichten-->
        <style>
            .error {color: #FF0000;}
        </style>
        <!--Farbe der Erfolgsnachrichten-->
        <style>
            .success {color: #00FF00;} /*lime*/
        </style>
    </head>
<!-------------------------------------------------------------HTML BODY BEGIN------------------------------------------------------------------------------------------>
<body>
    <!--Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    
    <div class="container">
        <?php include '../Navigation.php'; ?>

        <?php include './RegistrationValidation.php'; ?>

        <!-- display log in status -->
        <div class="logged_in_status">
            <?php 
            if(isset($_SESSION["username"])){
                $user_username = $_SESSION["username"];
                echo "Eingeloggt als $user_username";
            }
            ?>
        </div>
        <!-------------------------------------------------------------REGISTRATION FORM BEGIN------------------------------------------------------------------------------------------>
        <div class="signup-form">
            <div class ="box">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <h2>Registrierung</h2>
                    <p><span class="error">* required field</span></p>
                    
                    <div class="form-group">

                        <select id="form_anrede" class="form-control" name="anrede">
                            <option value="" selected>Bitte Anrede auswählen...</option>
                            <?php
                                $values = array("Frau", "Herr", "Divers");
                                foreach ($values as $v) {                                    
                                    echo "<option value=\"" . $v . "\" " . ($anrede == $v ? "selected" : "") . " >" . $v . "</option>";
                                }
                            ?>
                        </select>

                        <span class="error">* <?php echo $anredeErr;?></span><br>
                        <span class="success"><?php echo $anredeSucc;?></span>
                    </div>

                    <!--
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="vorname" value="<?php //echo $vorname;?>" placeholder="Vorname">
                            </div>  
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="nachname" value="<?php //echo $nachname;?>" placeholder="Nachname">
                            </div>   	
                            <span class="error">* <?php //echo $vornameErr;?></span><br>
                            <span class="error">* <?php //echo $nachnameErr;?></span> 
                        </div>
                    </div>
                    -->
            
                    <div class="form-group">
                        <input type="text" class="form-control" name="vorname" value="<?php echo $vorname;?>" placeholder="Vorname">
                        <span class="error">* <?php echo $vornameErr;?></span><br>
                        <span class="success"><?php echo $vornameSucc;?></span>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="nachname" value="<?php echo $nachname;?>" placeholder="Nachname">
                        <span class="error">* <?php echo $nachnameErr;?></span><br>
                        <span class="success"><?php echo $nachnameSucc;?></span>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="email" value="<?php echo $email;?>" placeholder="Email">
                        <span class="error">* <?php echo $emailErr;?></span><br>
                        <span class="success"><?php echo $emailSucc;?></span>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="username" value="<?php echo $username;?>" placeholder="Username">
                        <span class="error">* <?php echo $usernameErr;?></span><br>
                        <span class="success"><?php echo $usernameSucc;?></span>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" name="passwort" placeholder="Passwort"> 
                        <span class="error">* <?php echo $passwortErr;?></span>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" name="passwort_confirm" placeholder="Passwort bestätigen">
                        <span class="error">* <?php echo $passwort_confirmErr;?></span><br>
                        <span class="success"><?php echo $passwort_confirmSucc;?></span>
                    </div> 

                    <div class="form-group">
                        <button type="submit" class="btn btn-outline btn-lg btn-block secondary" name="submit" value="Submit">Registrieren</button>
                    </div>

                </form>
                <div class="text-center">Haben Sie schon einen Account? <a href="../Login/Login.php">Log in</a></div>
                <div class="text-center">Zurück zur <a href="../homepage/Homepage.php">Homepage</a></div>
            </div>
        </div>
        <!-------------------------------------------------------------REGISTRATION FORM END------------------------------------------------------------------------------------------>

        <?php
            echo "<h2>Eingegebene Daten:</h2>";
            echo $anrede;
            echo "<br>";
            echo $vorname;
            echo "<br>";
            echo $nachname;
            echo "<br>";
            echo $email;
            echo "<br>";
            echo $username;
        ?>
    </div>
</body>
<!--------------------------------------------------------------HTML END------------------------------------------------------------------------------------------>
</html>
