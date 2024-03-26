<!doctype html>
<?php 
    session_start();
    if (isset($_GET["logout"]) && $_GET["logout"]) {
        // remove all session variables
        session_unset();
        // destroy the session
        session_destroy();
        header("Location: ./Homepage.php");
        exit("logged out user");
    }
?>
<html lang="de">
    <head>
        <title>Aurelia Resort</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!--Schriftart-->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
        
        <!-- link to Homepage.css stylesheet -->
        <link rel="stylesheet" href="../css/Homepage.css">
    </head>  
    <body>
      <!-- --------------------------------------Homepage begins------------------------------------------ -->
      <h1>Herzlich willkommen auf der Webseite von Aurelia Resort Erholungsparadies!</h1>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
      
      <div class="container">

        <?php include 'NavigationHomepage.php'; ?>

        <?php include 'MainContent.php'; ?>
        
        <?php include 'Sidebar.php'; ?>
        
        <?php include 'Contentbox1.php'; ?>

        <?php include 'Contentbox2.php'; ?>

        <?php include 'Contentbox3.php'; ?>

        <?php include 'Footer.php'; ?>

      </div>

      <!-- --------------------------------------Homepage ends------------------------------------------ -->
    </body>
</html>






