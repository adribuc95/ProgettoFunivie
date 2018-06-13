<?php

class Tessera {
    public $ID_tessera;
    public $tipologia;
    public $categoria;
    public $importo;
    public $inizio_validità;
    public $fine_validità;
    
    public function getTipologia($ID_tessera) {
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
        $query = "SELECT `tipologia` FROM `Tessera` WHERE `ID_tessera` = '$ID_tessera'";
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
                  
                $this->tipologia = $row['tipologia'];
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $this->tipologia;
}

public function getImporti() {
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
        $query = "SELECT `importo` FROM `Tessera`";
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
                  
                $importi[] = $row;
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $importi;
}
}
        
    
    
    


