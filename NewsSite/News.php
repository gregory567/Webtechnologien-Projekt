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

        <link rel="stylesheet" href="../css/News.css">
        <title>News</title>
    </head>
    <body>
        <!--Bootstrap-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        
        <?php include '../Navigation.php'; ?>

        <!-- display log in status -->
        <div class="logged_in_status">
            <?php 
                if(isset($_SESSION["username"])){
                    $user_username = $_SESSION["username"];
                    echo "Eingeloggt als $user_username";
                }
            ?>
        </div>

        <h2>Newsbeiträge</h2>

        <?php
            /* SELECT all news entries ORDERED BY timestamp from DB with prepared statement */
            $sql = "SELECT * FROM `newsbeitraege` ORDER BY `timestamp`";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            $result = $stmt -> get_result(); // get the mysqli result
            $count = 0;
            while ($row = $result -> fetch_assoc()) { 
                $count++;
        ?>
            <div class="responsive">
                <div class="gallery">
                    <a target="_blank" href="<?php echo $row["bildpfad"]?>">
                        <img src="<?php echo $row["bildpfad"] ?>" alt="<?php echo "news" . $count ?>" width="720" height="480"> 
                    </a>
                    <p> 
                        <?php echo $row["timestamp"] ?> 
                    </p>
                    <div class="desc">
                        <?php echo $row["text"] ?>
                    </div>
                </div>
            </div>

        <?php } ?>

        <div class="clearfix"></div>

    </body>
</html>
