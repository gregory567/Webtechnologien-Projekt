<!doctype html>
<?php 
    session_start();
    if (isset($_GET["logout"]) && $_GET["logout"]) {
        // remove all session variables
        session_unset();
        // destroy the session
        session_destroy();
        header("Location: ../homepage/Homepage.php");
        exit("logged out user");
    }
?>
<html lang="de">
    <head>
        <title>Impressum & FAQ Aurelia Resort</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--Bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- link to Impressum.css stylesheet -->
        <link rel="stylesheet" href="../css/Impressum.css">
    </head>
    <body>
        <!--Bootstrap-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        
        <?php include '../Navigation.php'; ?>

        <!-- display log in status -->
        <div class="logged_in_status">
            <?php 
            if(isset($_SESSION["username"])){
                $username = $_SESSION["username"];
                echo "Eingeloggt als $username";
            }
            ?>
        </div>
        <!----------------------------------------Impressum begins-------------------------------------------->
        <h1>Impressum</h1>
    
        <div class="container">

            <div id="impressum"> 


                <p>
                    <strong>
                        Firmawortlaut: 
                    </strong>
                    <br>
                        Hotel Aurelia GmbH (Gesellschaft mit beschränkter Haftung)
                    <br>
                </p>

                <p>
                    <strong>
                        Unternehmensgegenstand:
                    </strong>
                    <br>
                        Hotel
                    <br>
                </p>

                <p>
                    <strong>
                        UID-Nummer:
                    </strong>
                    <br>
                        ATU12345678
                    <br>
                </p>

                <p>
                    <strong>
                        Firmenbuchnummer:
                    </strong>
                    <br>
                        123456a
                    <br>
                </p>
                
                <p>
                    <strong>
                        Firmenbuchgericht:
                    </strong>
                    <br>
                        Wien
                    <br>
                </p>
                
                <p>
                    <strong>
                        Firmensitz:
                    </strong>
                    <br>
                        1010 Wien
                    <br>
                </p>

                <p>
                    <strong>
                        Volle geografische Anschrift:
                    </strong>
                    <br>
                        Stephansplatz 1
                    <br> 
                </p>
                
                <p>
                    <strong>
                        Telefon:
                    </strong>
                    <br>
                        +43-1-26252701
                    <br>
                </p>
                
                <p>
                    <strong>
                        E-Mail:
                    </strong>
                    <br>
                        <a href="mailto:hotel.aurelia@gmail.com">hotel.aurelia@gmail.com</a>
                    <br>
                </p>
                

                <p>
                    <strong>
                        Mitgliedschaften bei der Wirtschaftskammerorganisation:
                    </strong>
                    <br>
                        Mitglied der WKÖ, der ÖHV
                    <br>
                </p>

                <p>
                    <strong>
                        Gewerbeordnung:
                    </strong>
                    <br> 
                        <a href ="https://www.ris.bka.gv.at/%22%3Ewww.ris.bka.gv.at"> https://www.ris.bka.gv.at/%22%3Ewww.ris.bka.gv.at </a>
                    <br>
                </p>

                <p>
                    <strong>
                        Aufsichtsbehörde/Gewerbebehörde:
                    </strong>
                    <br> 
                        Bezirkshauptmannschaft Wien
                    <br>
                </p>

                <p>
                    <strong>
                        Berufsbezeichnung:
                    </strong>
                    <br>
                        Hotelbetrieb
                    <br>
                </p>

                <p>
                    <strong>
                        Angaben zur Online-Streitbeilegung:
                    </strong>
                    <br>
                        Verbraucher haben die Möglichkeit, Beschwerden an die Online-Streitbeilegungsplattform der EU zurichten:
                        <a href ="https://www.ec.europa.eu/"> https://www.ec.europa.eu/</a>
                    <br>
                        oder Sie können allfällige Beschwerden auch an die oben angegebene E-Mail-Adresse richten.
                </p>
                
                <p>
                    <strong>
                        Geschäftsführer:
                    </strong>
                    <br>
                        Carpentieri Luca & Tavaszi Peter
                    <br>
                </p>
            </div>

            <div id="personal">

                <div class="row justify-content-center">
                    
                    <div class="col-md-3">
                        <div class="card h-100 text-bg-light" style="width: 15rem;">
                            <img src="./Luca_Profilbild.jpg" class="card-img-top" alt="Luca Carpentieri" height="300">
                            <div class="card-body">
                            <h5 class="card-title">Luca Carpentieri</h5>
                            <p class="card-text">Gesellschaftsanteile: 50%</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card h-100 text-bg-light" style="width: 15rem;">
                            <img src="./Peter_Profilbild.jpg" class="card-img-top" alt="Peter Tavaszi" height="300">
                            <div class="card-body">
                            <h5 class="card-title">Peter Tavaszi</h5>
                            <p class="card-text">Gesellschaftsanteile: 50%</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        <!-- --------------------------------------Impressum ends------------------------------------------ -->
        <!-- --------------------------------------FAQ begins------------------------------------------ -->
            <div id="faq">
                <h1>FAQ</h1>
                <br><br>
                Dies ist eine Liste der von unseren Kunden am häufigsten gestellten Fragen.
                <br>
                <br>
                <div class="row justify-content-center">
                    
                    <div class="col-md-12">
                        <div class="accordion" id="accordionExample">
                            
                            <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Wo kann ich mich registrieren?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <br>Wenn Sie in der Navigationsleiste auf "Registrierungsformular" klicken, kommen Sie zur Registrierung.
                                    Bei der Registrierung sind folgende Daten anzugeben:<br>
                                    <ul>
                                        <li>Anrede</li>
                                        <li>Vorname</li>
                                        <li>Nachname</li>
                                        <li>E-Mail-Adresse</li>
                                        <li>Username</li>
                                        <li>Passwort (muss 2x eingegeben werden)</li>
                                    </ul> 
                                </div>
                            </div>
                            </div>

                            <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Wo kann ich neue Reservierungen anlegen?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Eingeloggte User/innen können neue Reservierungen unter dem Menüpunkt "Reservierungsformular" anlegen.
                                    Bei der Reservierung sind folgende Daten anzugeben:<br>
                                    <ul>
                                        <li>Zimmernummer</li>
                                        <li>Anreisedatum</li>
                                        <li>Abreisedatum</li>
                                        <li>Anspruch auf Frühstück</li>
                                        <li>Anspruch auf Parkplatz</li>
                                        <li>Mitnahme von Haustieren</li>
                                    </ul> 
                                </div>
                            </div>
                            </div>

                            <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Wo kann ich meine Profildaten einsehen und bearbeiten?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Eingeloggte User/innen können die eigenen Profildaten unter dem Menüpunkt "Profilverwaltung" einsehen und bearbeiten (Stammdaten bearbeiten, Passwort setzen, etc.).
                                </div>
                            </div>
                            </div>

                            <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Wo kann ich meine Reservierungen einsehen?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Eingeloggte User/innen können die Liste der eigenen Reservierungen unter dem Menüpunkt "Reservierungen" einsehen.
                                </div>
                            </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Wo kann ich den Status meiner Reservierungen einsehen?
                                </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Eingeloggte User/innen können den Status der eigenen Reservierungen unter dem Menüpunkt "Reservierungen" einsehen.
                                </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    Wo finde ich die neuesten Nachrichten und Ereignisse rund um Aurelia Resort Erholungsparadies?
                                </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Sie finden Nachrichten und Ereignisse über Aurelia Resort Erholungsparadies und dessen Standort unter dem Menüpunkt "News".
                                </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSeven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    Wie viel kostet ein Frühstück pro Person?
                                </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Das Frühstück wird im Restaurant unseres Hotels täglich von 8 bis 10 Uhr in der Früh serviert und kostet 10 Euro pro Person.
                                </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingEight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    Wie viel kostet ein Parkplatz pro Tag?
                                </button>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Ein Parkplatz wird Ihnen in der Parkgarage des Hotels für 5 Euro pro Tag zur Verfügung gestellt.
                                </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingNine">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                    Wo kann ich meine Wünsche und Anregungen zu den Services der Webseite mitteilen?
                                </button>
                                </h2>
                                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Sie können Ihre eventuellen Wünsche und Anregungen zu den Services unserer Webseite unter dem Menüpunkt "Kommentare und Vorschläge" mitteilen.
                                </div>
                                </div>
                            </div>

                        </div>
                    </div>
                 </div>
                <!-- --------------------------------------FAQ ends------------------------------------------ -->
            </div>
        </div>
    </body>
</html>
