<?php

class Cliente {
    public $ID_cliente_riferimento;
    public $ID_cliente;
    public $titolo;
    public $nome;
    public $cognome;
    public $data_nascita;
    public $indirizzo;
    public $city;
    public $cap;
    public $provincia;
    public $telefono;
    public $fax;
    public $cellulare;
    public $email;
    public $sito;
    public $commenti;
    public $is_syncronised = 0;
    public $is_exported = 0;
    

    public function salvaDati() {
        echo $this->ID_cliente;
        echo $this->ID_cliente_riferimento;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->titolo = htmlspecialchars($_POST["titolo"]);
            $this->nome = htmlspecialchars($_POST["nome"]);
            $this->cognome = htmlspecialchars($_POST["cognome"]);
            $this->data_nascita = htmlspecialchars($_POST["data_nascita"]);
            $this->indirizzo = htmlspecialchars($_POST["indirizzo"]);
            $this->city = htmlspecialchars($_POST["city"]);
            $this->cap = htmlspecialchars($_POST["CAP"]);
            $this->provincia = $_POST["provincia"];
            $this->telefono = htmlspecialchars($_POST["telefono"]);
            $this->fax = htmlspecialchars($_POST["fax"]);
            $this->cellulare = htmlspecialchars($_POST["cellulare"]);
            $this->email = htmlspecialchars($_POST["email"]);
            $this->sito = htmlspecialchars($_POST["sito"]);
            $this->commenti = htmlspecialchars($_POST["commenti"]);
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

        $sql = "INSERT INTO `Cliente` (`ID_cliente_riferimento`, `ID_cliente`, `titolo`, `nome`, `cognome`, `data_nascita`, `indirizzo`, `city`, `cap`, `provincia`, `telefono`, `fax`, `cellulare`, `email`, `sito`, `commenti`,`is_syncronised`, `is_exported`) "
                 ."VALUES ('$this->ID_cliente_riferimento', '$this->ID_cliente', '$this->titolo', '$this->nome', '$this->cognome', '$this->data_nascita', '$this->indirizzo', '$this->city', '$this->cap', '$this->provincia', '$this->telefono', '$this->fax', '$this->cellulare', '$this->email', '$this->sito', '$this->commenti', '1', '1');";
        


        if (($conn->query($sql) === TRUE)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    
    public function mantieniDatiForm() {
        $_SESSION['indirizzo'] = $this->indirizzo;
        $_SESSION['CAP'] = $this->cap;
        $_SESSION['city'] = $this->city;
        $_SESSION['cellulare'] = $this->cellulare;
        $_SESSION['telefono'] = $this->telefono;
        $_SESSION['fax'] = $this->fax;
        $_SESSION['email'] = $this->email;
        $_SESSION['sito'] = $this->sito;
        $_SESSION['commenti'] = $this->commenti;
    }
    
    public function getIDCliente() {
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
        $query = "SELECT `ID_cliente` FROM `Cliente` WHERE `nome` = '$this->nome' AND `cognome` = '$this->cognome'";
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
                $this->ID_cliente = $row['ID_cliente'];
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $this->ID_cliente;
        }


    public function getBirthday($birthday){
        $datetime1 = new DateTime($birthday);
        $datetime2 = new DateTime(date('Y-m-d'));
        $diff = $datetime1->diff($datetime2);

        return $diff->format('%y');
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
        $query = "DELETE FROM `Cliente` WHERE `ID_cliente` = '$ID'";
        if (!$result = $conn->query($query)) {
            echo "Errore della query: ".$conn->error.".";
            exit();
        }
// chiusura della connessione
        $conn->close();
        }

    public function setIDCliente($ID_cliente) {
        $this->ID_cliente = $ID_cliente;
    }
    
    public function setIDCliente_Riferimento($ID_cliente_riferimento) {
        $this->ID_cliente_riferimento = $ID_cliente_riferimento;
    }

    public function getNewIDCliente() {
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
        $query = "SELECT MAX(`ID_cliente`) FROM `Cliente`";
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
                  
                $this->ID_cliente = $row['MAX(`ID_cliente`)'];
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $this->ID_cliente+1;
}

    public function getNewIDCliente_Riferimento() {
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
        $query = "SELECT MAX(`ID_cliente_riferimento`) FROM `Cliente`";
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
                  
                $this->ID_cliente_riferimento = $row['MAX(`ID_cliente_riferimento`)'];
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $this->ID_cliente_riferimento+1;
}

    public function getIDCliente_Riferimento() {
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
        $query = "SELECT MAX(`ID_cliente_riferimento`) FROM `Cliente`";
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
                  
                $this->ID_cliente_riferimento = $row['MAX(`ID_cliente_riferimento`)'];
                
              }
              // liberazione delle risorse occupate dal risultato
              $result->close();
            }
    }
// chiusura della connessione
        $conn->close();
        return $this->ID_cliente_riferimento;
}





}

