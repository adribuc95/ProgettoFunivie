<?php

class Articolo {
    public $ID_articolo;
    public $articolo;
    public $importo;
    public $inizio_validità;
    public $fine_validità;
    
    public function getArticolo($ID_articolo) {
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
        $query = "SELECT `articolo` FROM `Articolo` WHERE `ID_articolo` = '$ID_articolo'";
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
                  
                $this->articolo = $row['articolo'];
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $this->articolo;
}
        
    }
    
    


