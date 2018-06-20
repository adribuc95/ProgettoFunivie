<?php

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $riferimento = htmlspecialchars($_POST["elimina"]);
            $ID_cliente = htmlspecialchars($_POST["dati$riferimento"]);
            $ID_ordine = htmlspecialchars($_POST["ordine"]);
            $numero_tessere = htmlspecialchars($_POST["numero_tessere"]);
            $ID_foto = htmlspecialchars($_POST["foto$riferimento"]);
            $nome_foto = $ID_foto.".jpg";
            eliminaDaDB($ID_cliente, $ID_ordine, $nome_foto);
}

$_SESSION["numero_riferimento"]--;

header("location: riepilogo_ordine.php");
exit();




            function eliminaDaDB($ID_cliente, $ID_ordine, $ID_foto) {
        $servername = "localhost";
        $username = "onlinesales";
        $password = "Sale0nl1nE";
        $dbname = "fmc-db-onlinesales";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $query1 = "DELETE FROM `Ordine` WHERE `ID_cliente` = '$ID_cliente' AND `ID_ordine` = '$ID_ordine'";
        $query2 = "DELETE FROM `Cliente` WHERE `ID_cliente` = '$ID_cliente'";
        $query3 = "DELETE FROM `Foto` WHERE `ID_cliente` = '$ID_cliente'";
        
        unlink("../Pagina_iniziale/images/".$ID_foto);
        eseguiQuery($conn, $query1);
        eseguiQuery($conn, $query2);
        eseguiQuery($conn, $query3);
// chiusura della connessione
        
        $conn->close();
            }
            
            
        function eseguiQuery($conn, $query) {
            if ($conn->query($query) === TRUE) {
                echo "Record deleted successfully";
            } 
            else {
                echo "Error deleting record: " . $conn->error;
            }
            }
        