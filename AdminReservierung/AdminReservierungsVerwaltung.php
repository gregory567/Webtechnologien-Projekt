

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

        <link rel="stylesheet" href="../css/AdminReservierungsVerwaltung.css">
        <title>Adminreservierungsverwaltung</title>
    </head>
<!-------------------------------------------------------------HTML BODY BEGIN------------------------------------------------------------------------------------------>
<body>
    <!--Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <div class="container">
        <?php include '../Navigation.php'; ?>

        <!-- display log in status -->
        <div class="logged_in_status">
            <?php 
            if(isset($_SESSION["username"])){
                echo "Eingeloggt als $admin_username";
            }
            ?>
        </div>
        <!-------------------------------------------------------------REGISTRATION FORM BEGIN------------------------------------------------------------------------------------------>
        <div class="signup-form">
            <div class ="box">
                <h2> Liste der bestehenden Reservierungen </h2>
                <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th><strong>ID</strong></th>
                            <th><strong>User ID</strong></th>
                            <th><strong>Zimmer</strong></th>
                            <th><strong>Startdatum</strong></th>
                            <th><strong>Enddatum</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Erstellungsdatum und Uhrzeit</strong></th>
                            <th><strong>Auswählen</strong></th>
                            <th><strong>Status ändern</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // SELECT from table "reservierungen" to display all reservations stored in the DB
                        $sql = "SELECT * FROM `reservierungen` ORDER BY `user_id` ASC, `zimmer` ASC";
                        $stmt = $conn -> prepare($sql);
                        $stmt -> execute();
                        $result = $stmt -> get_result(); // get the mysqli result
                        while ($row = $result -> fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["user_id"]; ?></td>
                            <td><?php echo $row["zimmer"]; ?></td>
                            <td><?php echo $row["start_date"]; ?></td>
                            <td><?php echo $row["end_date"]; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                            <td><?php echo $row["timestamp"]; ?></td>
                            <td><a href="./admin_reservation_view.php?id=<?php echo $row["id"]; ?>">Details anzeigen</a></td>
                            <td><a href="./admin_reservation_status.php?id=<?php echo $row["id"]; ?>">Status ändern</a></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                </div>

                <br>
                <div class="text-center">Zurück zur <a href="../homepage/Homepage.php">Homepage</a></div>
            </div>
        </div>
    </div>
</body>
<!--------------------------------------------------------------HTML END------------------------------------------------------------------------------------------>
</html>




