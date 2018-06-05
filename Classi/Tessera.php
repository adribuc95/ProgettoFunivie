<?php

class Tessera {
    public $ID_tessera;
    public $tipologia;
    public $categoria;
    public $importo;
    public $inizio_validità;
    public $fine_validità;
    

    public function salvaDati() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->inizio_validità = date ("Y/m/d");
            $this->fine_validità = strtotime ( '+2 year' , strtotime ( $this->inizio_validità ) ) ; 
            $this->fine_validità = date ( 'Y/m/d' , $this->fine_validità );
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
        ."VALUES ('0', '$this->ID_tessera', '0', '$this->ID_cliente', '$data_attuale_assoluta' );";


        if (($conn->query($sql) === TRUE)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    
    
}

