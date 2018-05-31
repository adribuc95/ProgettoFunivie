<?php

class Ordine {
    public $ID_ordine;
    public $ID_tessera;
    public $ID_articolo;
    public $ID_cliente;
    public $data_ordine;
    

    public function salvaDati() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //$this->ID_ordine = htmlspecialchars($_POST["titolo"]);
            $this->ID_tessera = htmlspecialchars($_POST["tessera"]);
            //$this->ID_articolo = htmlspecialchars($_POST["cognome"]);
            $this->data_ordine = date ("Y/m/d");
        }
        
        $data_attuale_assoluta = strtotime($this->data_ordine);
        
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

        $sql = " INSERT INTO `Ordine` (`ID_ordine`, `ID_tessera`, `ID_articolo`, `ID_cliente`, `data_ordine`)"
        ."VALUES ('0', '$this->ID_tessera', '0', '$this->ID_cliente', '$data_attuale_assoluta' );";


        if (($conn->query($sql) === TRUE)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    
    public function setIDCliente($ID_cliente) {
        $this->ID_cliente = $ID_cliente;
    }
    
    public function eliminaDaDB($ID) {
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
        $query = "DELETE FROM `Ordine` WHERE `ID_Ordine` = '$ID'";
        if (!$result = $conn->query($query)) {
            echo "Errore della query: ".$conn->error.".";
            exit();
        }
        
// chiusura della connessione
        $conn->close();
        return $this->ID_cliente;
        }
    }
    
    


