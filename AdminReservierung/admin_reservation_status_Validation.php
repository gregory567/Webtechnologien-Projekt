

<!-- Validation of the data put in by the admin in the Reservation Status Update form -->
<?php
    // define variables and set to empty values
    $statusSucc = "";
    $status = "";

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(!empty($_GET['status'])) { 
            $status = test_input($_GET["status"]);
            $statusSucc = "Änderung des Reservierungsstatus erfolgreich!";
        }

        if (!empty($statusSucc)) {
            // INSERT into DB with Prepared Statements
            $sql = "UPDATE `reservierungen` SET `status` = ? WHERE `id` = ?";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("si", $status, $res_id);

            /* Execute the prepared statement */
            $stmt_status = $stmt -> execute();
            /* check whether the execute() succeeded */
            if ($stmt_status === FALSE) {
                trigger_error($stmt -> error, E_USER_ERROR);
            } else {
                /*"1 Row inserted." will be printed out while successful*/
                printf("%d Row inserted.\n", $stmt -> affected_rows);
                //echo "<h2 class='text-center'> Update Successful! </h2>";
            }

            $stmt -> close();
        }

    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>