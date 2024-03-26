
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-brand">Navigation</div>
        <?php
            if(isset($_SESSION["username"])){
                $logged_in = "Sie sind eingeloggt";
                echo "<span class='badge rounded-pill text-bg-primary'>$logged_in</span>";
            }
            else{
                $not_logged_in = "Sie sind nicht eingeloggt";
                echo "<span class='badge rounded-pill text-bg-primary'>$not_logged_in</span>";
            }
        ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#"><a id = "login" href="../Login/Login.php"> Login </a></a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="#"> --> <a id = "news" href="../NewsSite/News.php"> News </a> <!-- </a> --> 
                </li> 
                <li class="nav-item">
                    <!-- <a class="nav-link" href="#"> --> <a id = "reg_form" href="../Registrierung/Registrierung.php"> Registrierungsformular </a><!-- </a> --> 
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="#"> --> <a id = "impressum" href="../Impressum/Impressum.php"> Impressum & FAQ </a><!-- </a> --> 
                </li>

                <?php 
                    if (isset($_SESSION["username"]) && $_SESSION["username"] != "admin") { ?>
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="#"> --><a id = "res_form" href="../Reservierung/Reservierung.php"> Reservierungsformular </a><!-- </a> --> 
                        </li> 
                    <?php }?>

                <?php 
                    if (isset($_SESSION["username"]) && $_SESSION["username"] != "admin") { ?>
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="#"> --><a id = "user_profilverwaltung" href="../UserProfil/UserProfilVerwaltung.php"> Profilverwaltung </a><!-- </a> --> 
                        </li>
                    <?php }?>

                <?php 
                    if (isset($_SESSION["username"]) && $_SESSION["username"] != "admin") { ?>
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="#"> --><a id = "user_reservierungsansicht" href="../UserReservierung/user_reservation_view.php"> Reservierungen </a><!-- </a> --> 
                        </li>
                    <?php }?>

                <?php 
                    if (isset($_SESSION["username"]) && $_SESSION["username"] == "admin") { ?>
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="#"> --><a id = "fileupload" href="../FileUpload/FileUpload.php"> File Upload </a><!-- </a> --> 
                        </li>
                    <?php }?>

                <?php 
                    if (isset($_SESSION["username"]) && $_SESSION["username"] == "admin") { ?>
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="#"> --><a id = "admin_profilverwaltung" href="../AdminUser/AdminProfilVerwaltung.php"> Admin Profilverwaltung </a><!-- </a> --> 
                        </li>
                    <?php }?>

                <?php 
                    if (isset($_SESSION["username"]) && $_SESSION["username"] == "admin") { ?>
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="#"> --><a id = "admin_reservierungsverwaltung" href="../AdminReservierung/AdminReservierungsVerwaltung.php"> Admin Reservierungsverwaltung </a><!-- </a> --> 
                        </li>
                    <?php }?>

                <?php 
                    if (isset($_SESSION["username"])) { ?>
                        <li class="nav-item">
                            <div class="logout">
                                <a class="btn btn-primary" href="?logout=true">Logout</a>
                            </div>
                        </li>
                    <?php }?>
            </ul>
        </div>
    </div>
</nav>
      