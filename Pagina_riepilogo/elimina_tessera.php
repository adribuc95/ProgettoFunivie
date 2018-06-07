<?php

session_start();
header("location: https://www.funiviemadonnacampiglio.it/onlinesale/Pagina_riepilogo/riepilogo_ordine.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $riferimento = htmlspecialchars($_POST["elimina"]);
            $ID_cliente = htmlspecialchars($_POST["dati$riferimento"]);
            $ID_ordine = htmlspecialchars($_POST["ordine"]);
            $numero_tessere = htmlspecialchars($_POST["numero_tessere"]);
            eliminaDaDB($ID_cliente, $ID_ordine);
}
if ($numero_tessere != 0) {
    unset($_SESSION["prima_volta2"]);
}

            function eliminaDaDB($ID_cliente, $ID_ordine) {
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

        eseguiQuery($conn, $query1);
        eseguiQuery($conn, $query2);
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
        