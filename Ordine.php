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
        ."VALUES ('$this->ID_ordine', '$this->ID_tessera', '0', '$this->ID_cliente', '$this->data_ordine' );";


        if (($conn->query($sql) === TRUE)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    
    public function setIDOrdine($ID_ordine) {
        $this->ID_ordine = $ID_ordine;
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
        $query = "DELETE FROM `Ordine` WHERE `ID_ordine` = '$ID'";
        if (!$result = $conn->query($query)) {
            echo "Errore della query: ".$conn->error.".";
            exit();
        }
        
// chiusura della connessione
        $conn->close();
        return $this->ID_cliente;
        }
        
        public function getNewIDOrdine() {
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
        $query = "SELECT MAX(`ID_ordine`) FROM `Ordine`";
        if (!$result = $conn->query($query)) {
            echo "Errore della query: ".$conn->error.".";
            exit();
        }
        else{
            // conteggio dei record
            if($result->num_rows > 0) {
              // conteggio dei record restituiti dalla query
              while($row = $result->fetch_array(MYSQLI_ASSOC))
              {
                  
                $this->ID_ordine = $row['MAX(`ID_Ordine`)'];
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $this->ID_ordine+1;
}
    }
    
