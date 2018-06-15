<?php
session_start();
class Ordine {
    public $ID_ordine;
    public $ID_tessera;
    public $ID_articolo;
    public $ID_cliente;
    public $data_ordine;
    public $numero_prodotti;
   
    

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

        $sql = " SELECT count(`ID_Ordine`) FROM `Ordine` WHERE `ID_ordine` = '$ID_ordine'";
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
            return $this->numero_prodotti;
        }
        
        //ritorna un array contenente gli ID_tessera presenti in un ordine.
        
        public function getTessere_StessoOrdine($ID_ordine) { 
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
                      $tipologia_tessere[] = $row;



                  }
                
                
                  // liberazione delle risorse occupate dal risultato
                  $result->close();
                  }
                  }
                  return $tipologia_tessere;
                  }
                  
        //vado a prendere i singoli importi facendo una join di ORDINE e TESSERA
                  //da sistemare!!
        public function getImporto_Tessera($ID_ordine) { 
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
            $sql = "SELECT `importo` FROM `Tessera` INNER JOIN `Ordine` ON Tessera.ID_tessera = Ordine.ID_tessera AND Ordine.ID_ordine = '$ID_ordine'";
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
                      $importi[] = $row;
                  }
                  // liberazione delle risorse occupate dal risultato
                  $result->close();
                }
            }
            return $importi;
        }
        
        public function getImporto_Articolo($ID_ordine) { 
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
            $sql = "SELECT `importo` FROM `Articolo` INNER JOIN `Ordine` ON Articolo.ID_articolo = Ordine.ID_articolo AND Ordine.ID_ordine = '$ID_ordine'";
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
                      $importi[] = $row;
                  }
                  // liberazione delle risorse occupate dal risultato
                  $result->close();
                }
            }
            return $importi;
        }
        
        //ritorna gli ID_cliente dei clienti dello stesso ordine
       
        public function getIDClienti_StessoOrdine($ID_ordine) {
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
        $query = "SELECT Cliente.ID_cliente FROM `Cliente` INNER JOIN `Ordine` ON Cliente.ID_cliente = Ordine.ID_cliente WHERE Ordine.ID_ordine = '$ID_ordine'";
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
                  
                $ID_clienti[] = $row;
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $ID_clienti;
        }
        
        
        public function getName_StessoOrdine($ID_ordine) {
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
        $query = "SELECT Cliente.nome FROM `Cliente` INNER JOIN `Ordine` ON Cliente.ID_cliente = Ordine.ID_cliente WHERE Ordine.ID_ordine = '$ID_ordine'";
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
                  
                $nomi[] = $row;
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
            
        }
        return $nomi;
        }
        
        public function getSurname_StessoOrdine($ID_ordine) {
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
        $query = "SELECT Cliente.cognome FROM `Cliente` INNER JOIN `Ordine` ON Cliente.ID_cliente = Ordine.ID_cliente WHERE Ordine.ID_ordine = '$ID_ordine'";
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
                  
                $cognomi[] = $row;
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
        }
            return $cognomi;
        }
        
        public function getDate_StessoOrdine($ID_ordine) {
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
        $query = "SELECT Cliente.data_nascita FROM `Cliente` INNER JOIN `Ordine` ON Cliente.ID_cliente = Ordine.ID_cliente WHERE Ordine.ID_ordine = '$ID_ordine'";
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
                  
                $data_nascita[] = $row;
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
        }
            return $data_nascita;
        }
        
        public function getIDArticolo_StessoOrdine($ID_ordine) {
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
        $query = "SELECT `ID_articolo` FROM `Ordine` WHERE `ID_ordine` = '$ID_ordine'";
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
                  
                $ID_articolo[] = $row;
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
        }
            return $ID_articolo;
        }
        
        public function getEmail_StessoOrdine($ID_ordine) {
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
        $query = "SELECT Cliente.email FROM `Cliente` INNER JOIN `Ordine` ON Cliente.ID_cliente = Ordine.ID_cliente WHERE Ordine.ID_ordine = $ID_ordine";
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
                  
                $email[] = $row;
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $email;
}
}

        

    
