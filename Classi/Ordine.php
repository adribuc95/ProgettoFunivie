<?php

class Ordine {
    public $ID_ordine;
    public $ID_tessera;
    public $ID_articolo;
    public $ID_cliente;
    public $data_ordine;
    public $numero_prodotti;
    public $new_array;
    

    public function salvaDati() { //funzione che va a salvare i dati inseriti nel form iniziale
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $this->ID_tessera = htmlspecialchars($_POST["tessera"]);
            //$this->ID_articolo = htmlspecialchars($_POST["cognome"]);
            $this->data_ordine = date ("Y/m/d");
            $this->ID_articolo = htmlspecialchars($_POST["assicurazione"]);
            echo $this->ID_articolo;
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
        ."VALUES ('$this->ID_ordine', '$this->ID_tessera', '$this->ID_articolo', '$this->ID_cliente', '$this->data_ordine' );";


        if (($conn->query($sql) === TRUE)) {
            echo "New record Ordine created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    
    public function setIDOrdine($ID_ordine) { //imposta l'ID_ordine
        $this->ID_ordine = $ID_ordine;
    }
    
    public function setIDCliente($ID_cliente) { //imposta l'ID_cliente
        $this->ID_cliente = $ID_cliente;
    }
    
  
    
    public function eliminaDaDB($ID) { //elimina la riga corrispondente a $ID
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
        
        public function getNewIDOrdine() { //va a vedere l'ultimo ID_ordine inserito e lo aumenta di 1
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
                  
                $this->ID_ordine = $row['MAX(`ID_ordine`)'];
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $this->ID_ordine+1;
}

public function getIDOrdine() { //va a vedere l'ultimo ID_ordine inserito e lo aumenta di 1
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
                  
                $this->ID_ordine = $row['MAX(`ID_ordine`)'];
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $this->ID_ordine;
}

public function countProduct($ID_ordine) { //conta le tessere all'interno di un ordine e ritorna il numero.
        
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

        $sql = " SELECT count(`ID_Ordine`) FROM `Ordine` WHERE 'ID_ordine' = '$ID_ordine'";
        if (!$result = $conn->query($sql)) {
            echo "Errore della query: ".$conn->error.".";
            exit();
        }
        else{
            // conteggio dei record
            if($result->num_rows > 0) {
              // conteggio dei record restituiti dalla query
              while($row = $result->fetch_array(MYSQLI_ASSOC))
              {
                  
                $this->numero_prodotti = $row['count(`ID_Ordine`)'];
                
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
       
        }
        
        
        public function getTessereDiUnOrdine($ID_ordine) { //ritorna un array contenente gli ID_tessera presenti in un ordine.
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
                $sql = " SELECT `ID_tessera` FROM `Ordine` WHERE `ID_ordine` = '$ID_ordine'";
                if (!$result = $conn->query($sql)) {
                echo "Errore della query: ".$conn->error.".";
                exit();
            }
            else{
                // conteggio dei record
                if($result->num_rows > 0) {
                  // conteggio dei record restituiti dalla query
                  while($row = $result->fetch_array(MYSQLI_ASSOC))
                  {
                      $this->new_array[] = $row;



                  }
                  // liberazione delle risorse occupate dal risultato
                  $result->close();
                }
        }
    
            
        }
        
        public function getImporto($ID_ordine) { //vado a prendere i singoli importi facendo una join di ORDINE e TESSERA
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
            $sql = "SELECT `importo` FROM (`Tessera` JOIN `Ordine`) WHERE `ID_ordine` = '$ID_ordine'";
            if (!$result = $conn->query($sql)) {
                echo "Errore della query: ".$conn->error.".";
                exit();
                }
            else{
                // conteggio dei record
                if($result->num_rows > 0) {
                  // conteggio dei record restituiti dalla query
                  while($row = $result->fetch_array(MYSQLI_ASSOC))
                  {
                      $this->importi[] = $row;
                  }
                  // liberazione delle risorse occupate dal risultato
                  $result->close();
                }
            }
        }

        public function getImportoTotale() { //da sistemare --> calcola l'importo totale di un ordine
            $importo_totale = '';
            for ($i = 0; $i < $this->numero_prodotti; $i++) {
                if(implode("", $this->new_array[$i]) == 1) {
                    $importo_totale = $importo_totale + getImporto($this->ID_ordine);
                } 
                else if(implode("", $this->new_array[$i]) == 2) {
                    $importo_totale = $importo_totale + 540;
                }
            }
            return $importo_totale;
        }
}
    