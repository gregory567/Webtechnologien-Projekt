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

        <link rel="stylesheet" href="../css/Reservierung.css">
        <title>Zimmer Reservierung</title>
        <!--Farbe der Fehlernachrichten-->
        <style>
            .error {color: #FF0000;} /*rot*/ 
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

        <?php include './ReservationValidation.php'; ?>

        <!-- display log in status -->
        <div class="logged_in_status">
            <?php 
            if(isset($_SESSION["username"])){
                $user_username = $_SESSION["username"];
                echo "Eingeloggt als $user_username";
            }
            ?>
        </div>
        <!-------------------------------------------------------------RESERVATION FORM BEGIN------------------------------------------------------------------------------------------>
        <div class="reservation-form">
            <div class ="box">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <h2>Zimmer Reservierung</h2>

                    <div class="form-group">
                        <p>Zimmer: </p>
                        <select id="form_zimmer" class="form-control" name="zimmer">
                            <option value="" selected>Bitte Zimmer auswählen...</option>
                            <?php
                                $values = range(1, 5);
                                foreach ($values as $v) {                                    
                                    echo "<option value=\"" . $v . "\" " . ($zimmer == $v ? "selected" : "") . " >" . $v . "</option>";
                                }
                            ?>
                        </select>

                        <span class="error">* <?php echo $zimmerErr;?></span><br>
                        <span class="success"><?php echo $zimmerSucc;?></span>
                    </div>

                    <div class="form-group">
                        <p>Anreisedatum: </p>

                        <div class="input-group">                                                                                                           
                            <input type="date" class="form-control" name="start_date" value="<?php echo $start_date;?>" placeholder="YYYY-MM-DD" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])">
                        </div>

                        <span class="error">* <?php echo $start_dateErr;?></span><br>
                        <span class="success"><?php echo $start_dateSucc;?></span>
                    </div>

                    <div class="form-group">
                        <p>Abreisedatum: </p>

                        <div class="input-group">
                            <input type="date" class="form-control" name="end_date" value="<?php echo $end_date;?>" placeholder="YYYY-MM-DD" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])">
                        </div>

                        <span class="error">* <?php echo $end_dateErr;?></span><br>
                        <span class="success"><?php echo $end_dateSucc;?></span>
                    </div>

                    <div class="form-group">
                        mit / ohne Frühstück: <br>
                        (Kosten: 10 Euro pro Person) <br>

                        <input type="radio" id="mit" name="frühstück" value="mit">
                        <label for="mit">mit</label><br>

                        <input type="radio" id="ohne" name="frühstück" value="ohne">
                        <label for="ohne">ohne</label><br>

                        <span class="error">* <?php echo $frühstückErr;?></span><br>
                        <span class="success"><?php echo $frühstückSucc;?></span>
                    </div>

                    <div class="form-group">
                        mit / ohne Parkplatz: <br>
                        (Kosten: 5 Euro täglich) <br>

                        <input type="radio" id="mit" name="parkplatz" value="mit">
                        <label for="mit">mit</label><br>

                        <input type="radio" id="ohne" name="parkplatz" value="ohne">
                        <label for="ohne">ohne</label><br>

                        <span class="error">* <?php echo $parkplatzErr;?></span><br>
                        <span class="success"><?php echo $parkplatzSucc;?></span>
                    </div>

                    <div class="form-group">
                        <script>
                            function ShowHideDiv() {
                                var ja = document.getElementById("ja");
                                var haustiertext = document.getElementById("haustiertext");
                                haustiertext.style.display = ja.checked ? "block" : "none";
                            }
                        </script>

                        <p>Mitnahme von Haustieren: </p>
                        
                        <input type="radio" id="ja" name="haustier" value="ja" onclick="ShowHideDiv()" />
                        <label for="ja">Ja</label><br>
                        
                        <input type="radio" id="nein" name="haustier" value="nein" onclick="ShowHideDiv()" />
                        <label for="nein">Nein</label><br>
                
                        <div id="haustiertext" style="display: none">
                            Weitere Informationen zu Haustieren bitte hier angeben:<br>
                            <input type="text" class="form-control" name="haustier_info" placeholder="Informationen über Haustier(e)">
                        </div>
            
                        <span class="error">* <?php echo $haustierErr;?></span><br>
                        <span class="success"><?php echo $haustierSucc;?></span>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline btn-lg btn-block secondary" name="submit" value="Submit">Reservieren</button>
                    </div>

                </form>
                <div class="text-center">
                    Zurück zur <a href="../homepage/Homepage.php">Homepage</a>
                </div>
            </div>
        </div>
        <!-------------------------------------------------------------RESERVATION FORM END------------------------------------------------------------------------------------------>
    </div>
</body>
<!--------------------------------------------------------------------HTML BODY END--------------------------------------------------------------------------------------->
</html>