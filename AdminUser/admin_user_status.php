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

    $user_username = $_GET["username"];
    $user_id = $_GET["id"];
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
        <title>Update User Status by Admin</title>
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

        <?php include './admin_user_status_Validation.php'; ?>

        <!-- display log in status -->
        <div class="logged_in_status">
            <?php 
            if(isset($_SESSION["username"])){
                echo "Eingeloggt als $admin_username";
            }
            ?>
        </div>
        <!-------------------------------------------------------------USER STATUS BEGIN------------------------------------------------------------------------------------------>
        <div class="signup-form">
            <div class ="box">

                <?php
                // SELECT statement FROM the table "users" to display the chosen user 
                $sql = "SELECT * FROM `users` WHERE `id` = ?";
                $stmt = $conn -> prepare($sql);
                $stmt -> bind_param("i", $user_id);
                $stmt -> execute();
                $result = $stmt -> get_result(); // get the mysqli result
                while ($row = $result -> fetch_assoc()) {
                    $current_anrede = $row["anrede"];
                    $current_vorname = $row["vorname"];
                    $current_nachname = $row["nachname"];
                    $current_email = $row["email"];
                    $current_username = $row["username"];
                    $current_status = $row["status"];
                } ?>
                <table>
                    <tr>
                        <th>Anrede von User: <?php echo $user_username ?></th>
                        <td> <?php echo $current_anrede; ?> </td>
                    </tr>
                    <tr>
                        <th>Vorname von User: <?php echo $user_username ?></th>
                        <td> <?php echo $current_vorname; ?> </td>
                    </tr>
                    <tr>
                        <th>Nachname von User: <?php echo $user_username ?></th>
                        <td> <?php echo $current_nachname; ?> </td>
                    </tr>
                    <tr>
                        <th>Email von User: <?php echo $user_username ?></th>
                        <td> <?php echo $current_email; ?> </td>
                    </tr>
                    <tr>
                        <th>Username von User: <?php echo $user_username ?></th>
                        <td> <?php echo $current_username; ?> </td>
                    </tr>
                    <tr>
                        <th>Status von User: <?php echo $user_username ?></th>
                        <td> <?php echo $current_status; ?> </td>
                    </tr>
                </table>

                <!-- GET form to change the chosen user's status and stay on the same page -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
                    <h3> Status ändern von User: <?php echo $user_username ?> </h3>
                    
                    <div class="form-group">

                        <select id="form_status" class="form-control" name="status">
                            <option value="" selected>User Status auswählen...</option>
                            <?php
                                $values = array("aktiv", "inaktiv");
                                foreach ($values as $v) {                                    
                                    echo "<option value=\"" . $v . "\" " . ($status == $v ? "selected" : "") . " >" . $v . "</option>";
                                }
                            ?>
                        </select>

                        <input type="hidden" name="id" value="<?php echo $user_id?>">
                        <input type="hidden" name="username" value="<?php echo $user_username?>">

                        <span class="success"><?php echo $statusSucc;?></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-outline btn-lg btn-block secondary" name="submit" value="Submit">Abschicken</button>
                    </div>

                </form>

                <div class="text-center">Zurück zur <a href="./AdminProfilVerwaltung.php">Profilübersicht</a></div><br>
            </div>
        </div>
    </div>
</body>
<!--------------------------------------------------------------HTML END------------------------------------------------------------------------------------------>
</html>