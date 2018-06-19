<?php

class Foto {
    public $ID_cliente;
    public $Foto;
    public $data_inserimento;
    public $data_cancellazione;
    

   public function salvaDati() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->ID_tessera = htmlspecialchars($_POST["tessera"]);
            $this->data_inserimento = date("Y/m/d");
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

        $sql = " INSERT INTO `Foto` (`ID_cliente`, `Foto`, `data_inserimento`, `data_cancellazione`)"
        ."VALUES ('$this->ID_cliente', '$this->Foto', '$this->data_inserimento', '');";


        if (($conn->query($sql) === TRUE)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    
  public function setIDCliente($ID_cliente) {
        $this->ID_cliente = $ID_cliente;
        echo $this->ID_cliente;
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

        
       public function setIDFoto($ID_foto) {
           $this->Foto = $ID_foto;
       }
       
       public function getIDFoto($ID_ordine, $ID_cliente) {
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
        $query = "SELECT `Foto` FROM `Foto` INNER JOIN `Ordine` ON Foto.ID_cliente = Ordine.ID_cliente AND Ordine.ID_ordine = '$ID_ordine' WHERE Ordine.ID_cliente = '$ID_cliente'";
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
                  
                $ID_foto = $row['Foto'];
                
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $ID_foto;
}

public function getLastIDFoto() {
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
        $query = "SELECT `Foto` FROM `Foto`";
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
                  
                $ID_foto = $row[];
                
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        $i=0;
        while($ID_foto[$i] == 'Foto anni scorsi') {
            $i++;
        }
        echo $ID_foto[$i];
        return $ID_foto[$i];
}

function salvaNoFoto() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->ID_tessera = htmlspecialchars($_POST["tessera"]);
            $this->data_inserimento = date ("Y/m/d");
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

        $sql = " INSERT INTO `Foto` (`ID_cliente`, `Foto`, `data_inserimento`, `data_cancellazione`)"
        ."VALUES ('$this->ID_cliente', 'Foto anni scorsi', '$this->data_inserimento', '');";


        if (($conn->query($sql) === TRUE)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}


