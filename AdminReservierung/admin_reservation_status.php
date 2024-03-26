<!DOCTYPE html>
<?php 
    session_start();
    if (isset($_GET["logout"]) && $_GET["logout"]){
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
        echo "<h2 class='text-center'> You are not logged. You will be redirected to the Login page shortly. </h2>";
        header('Refresh: 2; URL = ../Login.php'); 
    }

    // check if user is logged in as admin
    if($_SESSION["username"] != "admin"){
        // not admin: redirect to login.php
        echo "<h2 class='text-center'> You are not admin. You do not have access to this page. </h2>";
        header('Refresh: 2; URL = ../Login.php'); 
    }

    // require access data to DB and build up connection to DB
    require_once('../dbaccess.php'); //to retrieve connection details
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed. Error in DB connection: ". $conn->connect_errno ." : ". $conn->connect_error); 
    }

    $admin_username = $_SESSION["username"];
    $admin_id = $_SESSION["id"];
    $res_id = $_GET["id"];
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
        <title>Update Reservation Status by Admin</title>
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
            text-align: left; /* align text to the left */
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

        <?php include './admin_reservation_status_Validation.php'; ?>

        <!-- display log in status -->
        <div class="logged_in_status">
            <?php 
            if(isset($_SESSION["username"])){
                echo "Eingeloggt als $admin_username";
            }
            ?>
        </div>

        <!-------------------------------------------------------------RESERVATION STATUS FORM BEGIN------------------------------------------------------------------------------------------>
        <div class="signup-form">
            <div class ="box">

                <?php
                    // SELECT from table "reservierungen" to display the chosen reservation
                    $sql = "SELECT * FROM `reservierungen` WHERE `id` = ?";
                    $stmt = $conn -> prepare($sql);
                    $stmt -> bind_param("i", $res_id);
                    $stmt -> execute();
                    $result = $stmt -> get_result(); // get the mysqli result
                    while ($row = $result->fetch_assoc()) { 
                ?>
                <table>
                    <tr>
                        <th><strong>ID</strong></th>
                        <td><?php echo $row["id"]; ?></td>
                    </tr>
                    <tr>
                        <th><strong>User ID</strong></th>
                        <td><?php echo $row["user_id"]; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Zimmer</strong></th>
                        <td><?php echo $row["zimmer"]; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Startdatum</strong></th>
                        <td><?php echo $row["start_date"]; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Enddatum</strong></th>
                        <td><?php echo $row["end_date"]; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Frühstück</strong></th>
                        <td><?php echo $row["frühstück"]; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Parkplatz</strong></th>
                        <td><?php echo $row["parkplatz"]; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Haustier</strong></th>
                        <td><?php echo $row["haustier"]; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Informationen zu Haustieren</strong></th>
                        <td><?php echo $row["haustier_info"]; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Status</strong></th>
                        <td><?php echo $row["status"]; ?></td>
                    </tr>
                    <tr>
                        <th><strong>Erstellungsdatum und Uhrzeit</strong></th>
                        <td><?php echo $row["timestamp"]; ?></td>
                    </tr>
                </table>
                <?php } ?>

                <!-- GET form to update the status of the chosen reservation and stay on the same page -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
                    <h3> Status ändern von Reservierung Nummer <?php echo $res_id ?> </h3>
                    
                    <div class="form-group">

                        <select id="form_status" class="form-control" name="status">
                            <option value="" selected>Reservierungsstatus auswählen...</option>
                            <?php
                                $values = array("neu", "bestätigt", "storniert");
                                foreach ($values as $v) {                                    
                                    echo "<option value=\"" . $v . "\" " . ($status == $v ? "selected" : "") . " >" . $v . "</option>";
                                }
                            ?>
                        </select>

                        <input type="hidden" name="id" value="<?php echo $res_id?>">
                        <span class="success"><?php echo $statusSucc;?></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-outline btn-lg btn-block secondary" name="submit" value="Submit">Abschicken</button>
                    </div>

                </form>

                <div class="text-center">Zurück zur <a href="./AdminReservierungsVerwaltung.php">Reservierungsverwaltung</a></div><br>
            </div>
        </div>
    </div>
</body>
<!--------------------------------------------------------------HTML END------------------------------------------------------------------------------------------>
</html>