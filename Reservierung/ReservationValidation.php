
<!-- Validation of the data put in by the user in the reservation form -->
<?php
    // define variables and set to empty values
    $zimmer = $start_date = $end_date = $frühstück = $parkplatz = $haustier = $haustier_info = "";
    $zimmerErr = $start_dateErr = $end_dateErr = $frühstückErr = $parkplatzErr = $haustierErr = "";
    $zimmerSucc = $start_dateSucc = $end_dateSucc = $frühstückSucc = $parkplatzSucc = $haustierSucc = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!empty($_POST["zimmer"])){
            $zimmer = test_input($_POST["zimmer"]);

            /* Zimmernummer muss zwischen 1 und 5 liegen */
            if ($zimmer >= 1 && $zimmer <= 5) {
                $zimmerSucc = "Gültige Zimmernummer";
            } else {
                $zimmerErr = "Ungültige Zimmernummer";
            }
        } else {
            $zimmerErr = "Zimmernummer muss angegeben werden";
        }


        if(!empty($_POST["start_date"])){
            $start_date = date("Y-m-d", strtotime($_POST["start_date"]));
            
            /* check if start date is today or later, but not later than a year from today */
            if ($start_date >= date("Y-m-d") && $start_date <= date("Y-m-d", strtotime("+1 Year"))) {

                /* check if start date falls between start and end date of another reservation */
                $sql = "SELECT * FROM `reservierungen` WHERE `zimmer` = ? AND `start_date` <= ? AND `end_date` >= ?";
                $stmt = $conn -> prepare($sql);
                $stmt -> bind_param("sss", $zimmer, $start_date, $start_date);
                $stmt -> execute();
                $stmt -> store_result();

                /* if start date falls between start and end date of another reservation, fetch start and end date of that reservation */
                if ($stmt -> num_rows > 0) {  
                    $stmt = $conn -> prepare($sql);
                    $stmt -> bind_param("sss", $zimmer, $start_date, $start_date);
                    $stmt -> execute();
                    $result = $stmt -> get_result(); // get the mysqli result
                    while($row = $result -> fetch_object()){
                        $von = $row -> start_date;
                        $bis = $row -> end_date;
                    }
                    $start_dateErr = "Zimmer ist in diesem Zeitraum schon besetzt. Reserviert von: $von bis: $bis"; 
                } else {  
                    $start_dateSucc = "Gültiges Anreisedatum: $start_date";  
                }     
                
            } else {
                $start_dateErr = "Kein gültiges Anreisedatum: $start_date";
            }

        } else {
            $start_dateErr = "Anreisedatum muss angegeben werden";
        }


        if(!empty($_POST["end_date"])){
            $end_date = date("Y-m-d", strtotime($_POST["end_date"]));

            /* check if end date is today or later, but not later than a year from today and end date is later than start date */
            if ($end_date >= date("Y-m-d") && $end_date <= date("Y-m-d", strtotime("+1 Year")) && $end_date > $start_date) {

                /* check if end date falls between start and end date of another reservation */
                $sql = "SELECT * FROM `reservierungen` WHERE `zimmer` = ? AND `start_date` <= ? AND `end_date` >= ?";
                $stmt = $conn -> prepare($sql);
                $stmt -> bind_param("sss", $zimmer, $end_date, $end_date);
                $stmt -> execute();
                $stmt -> store_result();

                /* if end date falls between start and end date of another reservation, fetch start and end date of that reservation */
                if ($stmt -> num_rows > 0) { 
                    $stmt = $conn -> prepare($sql);
                    $stmt -> bind_param("sss", $zimmer, $end_date, $end_date);
                    $stmt -> execute();
                    $result = $stmt -> get_result(); // get the mysqli result
                    while($row = $result -> fetch_object()){
                        $von = $row -> start_date;
                        $bis = $row -> end_date;
                    }
                    $end_dateErr = "Zimmer ist in diesem Zeitraum schon besetzt. Reserviert von: $von bis: $bis";  
                } else {  
                    $end_dateSucc = "Gültiges Abreisedatum: $end_date";  
                }     
                
            } else {
                $end_dateErr = "Kein gültiges Abreisedatum: $end_date";
            }

        } else {
            $end_dateErr = "Abreisedatum muss angegeben werden";
        }


        if(!isset($_POST["frühstück"])){ 
            $frühstückErr = "Anspruch auf Frühstück muss angegeben werden."; 
        } else {
            $frühstück = $_POST["frühstück"];
            if($frühstück == "mit"){
                $frühstückSucc = "Anspruch auf Frühstück angenommen.";
            } else {
                $frühstückSucc = "Verzicht auf Frühstück angenommen.";
            }
        }

        if(!isset($_POST["parkplatz"])){ 
            $parkplatzErr = "Anspruch auf Parkplatz muss angegeben werden."; 
        } else {
            $parkplatz = $_POST["parkplatz"];
            if($parkplatz == "mit"){
                $parkplatzSucc = "Anspruch auf Parkplatz angenommen.";
            } else {
                $parkplatzSucc = "Verzicht auf Parkplatz angenommen.";
            }
        }

        if(!isset($_POST["haustier"])){ 
            $haustierErr = "Mitnahme von Haustier(en) muss angegeben werden."; 
        } else {
            $haustier = $_POST["haustier"];
            if($haustier == "ja"){
                $haustier_info = test_input($_POST["haustier_info"]);
                $haustierSucc = "Danke, dass Sie uns über Ihre Haustiere informieren.";
            } else {
                $haustier_info = NULL;
                $haustierSucc = "Danke für die Mitteilung.";
            }
        }

        if (!empty($zimmerSucc) && !empty($start_dateSucc) && !empty($end_dateSucc) && !empty($frühstückSucc) &&
        !empty($parkplatzSucc) && !empty($haustierSucc)) {
            
            // after all data is declared to be correct:
            // INSERT into DB with Prepared Statements
            $sql = "INSERT INTO `reservierungen` (`user_id`, `zimmer`, `start_date`, `end_date`, `frühstück`, `parkplatz`, `haustier`, `haustier_info`, `status`, `timestamp`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn -> prepare($sql);

            // status of reservation is always set to "new"
            $status = "neu";
            // Change the line below to your timezone
            date_default_timezone_set('Europe/Berlin');
            $timestamp = date('Y-m-d h:i:s a', time());
            $stmt -> bind_param("iissssssss", $_SESSION["id"], $zimmer, $start_date, $end_date, $frühstück, $parkplatz, $haustier, $haustier_info, $status, $timestamp);

            $stmt -> execute();
            $stmt -> close();
            $conn -> close();
        }

    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>