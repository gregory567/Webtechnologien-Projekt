
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
        header('Refresh: 2; URL = ../Login/Login.php'); 
    }

    // check if user is logged in as admin
    if($_SESSION["username"] != "admin"){
        // not admin: redirect to login.php
        echo "<h2 class='text-center'> You are not admin. You do not have access to this page. </h2>";
        header('Refresh: 2; URL = ../Login/Login.php'); 
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

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--Bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!--Schriftart-->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">

        <link rel="stylesheet" href="../css/FileUpload.css">
        <title>File Upload</title>
        <!--Farbe der Fehlernachrichten-->
        <style>
            .error {color: #FF0000;} /*rot*/
        </style>
        <!--Farbe der Erfolgsnachrichten-->
        <style>
            .success {color: #00FF00;} /*lime*/
        </style>
    </head>
    <body>
        <!--Bootstrap-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        
        <div class="container">
            <?php include '../Navigation.php'; ?>

            <?php include './FileUploadValidation.php'; ?>

            <!-- display log in status -->
            <div class="logged_in_status">
                <?php 
                if(isset($_SESSION["username"])){
                    echo "Eingeloggt als $admin_username";
                }
                ?>
            </div>
            <div class="fileupload-form">
                <div class ="box">
                    <div class="row">
                        <div class="col">
                            <h1>File Upload</h1>
                        </div>
                    </div>

                    <!-- File upload form has to have attribute enctype="multipart/form-data" otherwise the file upload will not work. -->
                    <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="form-group">
                            <label for="fileToUpload" class="form-label">Bilddatei:</label>
                            <!-- MAX_FILE_SIZE (measured in bytes) must precede the file input field -->
                            <input type="hidden" name="MAX_FILE_SIZE" value="1500000" />
                            <!-- name of input element determines name in $_FILES array -->
                            <input accept="image/jpeg" class="form-control" type="file" id="fileToUpload" name="fileToUpload" multiple>
                            <!-- 
                            accept="image/png" or accept=".png" — Accepts PNG files.
                            accept="image/png, image/jpeg" or accept=".png, .jpg, .jpeg" — Accept PNG or JPEG files.
                            accept="image/*" — Accept any file with an image/* MIME type. (Many mobile devices also let the user take a picture with the camera when this is used.)
                            -->
                            <span class="error">* <?php echo $uploadErr;?></span>
                            <span class="error"><?php echo $uploadErrMsg;?></span><br>
                            <span class="success"><?php echo $uploadSucc;?></span> 
                            <span class="success"><?php echo $uploadSuccMsg;?></span>
                        </div>

                        <div class="form-group">
                            <p><label for="news_text">Newsbeitrag:</label></p>
                            <textarea class="form-control" id="news_text" name="news_text" placeholder="News Text" rows="10" cols="50"></textarea>
                            <span class="error">* <?php echo $textErr;?></span><br>
                            <span class="success"><?php echo $textSucc;?></span> 
                        </div>

                        <button class="btn btn-secondary" type="submit">Hochladen</button>
                        <p></p>
                        <p>Click the "Upload" button and the form-data will be sent to the database on the server.</p>
                    </form>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <h2>Files</h2>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <ul class="list-group">
                        <?php
                        if (file_exists($uploadDir)) {
                            $files = scandir($uploadDir);

                            /*prints the paths to the pictures*/
                            for ($i = 2; isset($files[$i]); $i++) {
                                echo '<li class="list-group-item">' . $files[$i] .'</li>';
                            }
                            //echo '<br>';

                            /*fetches and puts out the pictures from the upload directory*/
                            for ($i = 2; isset($files[$i]); $i++) {
                                //$img = "../news/".$files[$i];
                                //echo '<img src="'.$img.'" alt="newsUpload" />';
                                echo '<img src="' ."../news/".$files[$i].'" alt="newsUpload" />';
                                echo '<br>';
                            }

                            if (count($files) == 2) {
                                var_dump($files);
                                echo '<li class="list-group-item">No files...</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>

        </div>
    </body>
</html>