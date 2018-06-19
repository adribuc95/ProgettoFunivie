<?php
session_start();
$ID_ordine = $_SESSION["ID_ordine"];


class Email {

 //funzione che manda una mail con i dati relativi all'ordine. @$email è l'email a cui verrà spedita. @$ID_ordine è l'ordine di riferimento.
 public function emailDati($email, $ID_ordine) {
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
        $query = "SELECT `Foto`, `data_nascita`, `titolo`, `nome`, `cognome`, `indirizzo`, `cap`, `city`, `cellulare`, `email`, `data_ordine`, `tipologia` FROM `Ordine` INNER JOIN `Pagamento` ON Pagamento.ID_ordine = Ordine.ID_ordine INNER JOIN `Cliente` ON Ordine.ID_cliente = Cliente.ID_cliente INNER JOIN `Foto` ON Cliente.ID_cliente = Foto.ID_cliente INNER JOIN `Tessera` ON Tessera.ID_tessera = Ordine.ID_tessera WHERE Ordine.ID_ordine= '$ID_ordine'";
        $output='';
        if (!$result = $conn->query($query)) {
             echo "Errore della query: ".$conn->error.".";
             exit();
         }
         else{
             //intestazione file
             $output.=''.'link_immagine'.';';
             $output.=''.'data_nascita'.';';
            $output.=''.'titolo'.';';
            $output.=''.'nome'.';';
            $output.=''.'cognome'.';';
            $output.=''.'indirizzo'.';';
            $output.=''.'cap'.';';
            $output.=''.'città'.';';
            $output.=''.'cellulare'.';';
            $output.=''.'email'.';';
            $output.=''.'data_ordine'.';';
            $output.=''.'tessera'.';';
            $output.="\n";
            // conteggio dei record
        if($result->num_rows > 0) {
              // conteggio dei record restituiti dalla query
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                //dati file
                if($row['Foto'] == 'Foto anni scorsi') {
                    $output.= '"Foto anni scorsi";';
                }
                else {
                $output.= '"'.'https://www.funiviemadonnacampiglio.it/onlinesale/immagini_skipass/'.$row['Foto'].'.jpg";';
                }
                $output.='"'.$row['data_nascita'].'";';
                $output.='"'.$row['titolo'].'";';
                $output.='"'.$row['nome'].'";';
                $output.='"'.$row['cognome'].'";';
                $output.='"'.$row['indirizzo'].'";';
                $output.='"'.$row['cap'].'";';
                $output.='"'.$row['city'].'";';
                $output.='"'.$row['cellulare'].'";';
                $output.='"'.$row['email'].'";';
                $output.='"'.$row['data_ordine'].'";';
                $output.='"'.$row['tipologia'].'";';
                $output.="\n";
                }
            $result->close();
        }

        $file = 'miofile.txt';
        $f = fopen($file,'w');

        $c = fopen($file,'rb');
        fwrite($f,$output);
        fwrite($c,$output);
        $data = fread($c, filesize($file));
        fclose($f);
        fclose($c);

        // Adatto il file al formato MIME base64 usando base64_encode
        $data = chunk_split(base64_encode($data));

        // Genero il "separatore"
        // Serve per dividere, appunto, le varie parti del messaggio.
        // Nel nostro caso separerà la parte testuale dall'allegato
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

        // Aggiungo le intestazioni necessarie per l'allegato
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: multipart/mixed;\n";
        $headers .= " boundary=\"{$mime_boundary}\"";

        // Definisco il tipo di messaggio (MIME/multi-part)
        $msg .= "This is a multi-part message in MIME format.\n\n";

        // Metto il separatore
        $msg .= "--{$mime_boundary}\n";

        // Questa è la parte "testuale" del messaggio
        $msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
        $msg .= "Content-Transfer-Encoding: 7bit\n\n";
        $msg .= "In allegato i dati relativi all'ordine $ID_ordine" . "\n\n";

        // Metto il separatore
        $msg .= "--{$mime_boundary}\n";

        // Aggiungo l'allegato al messaggio
        $msg .= "Content-Disposition: attachment; filename=\"dati_ordine_$ID_ordine\"\n";
        $msg .= "Content-Transfer-Encoding: base64\n\n";
        $msg .= $data . "\n\n";

        // chiudo con il separatore
        $msg .= "--{$mime_boundary}--\n";
      // Invio la mail
      mail($email, "dati_ordine n°$ID_ordine", $msg, $headers); //mettere email che si vuole.
     }
    }
    
    public function emailRiepilogo($email, $ID_ordine) {
        
        
        // Genero il "separatore"
        // Serve per dividere, appunto, le varie parti del messaggio.
        // Nel nostro caso separerà la parte testuale dall'allegato
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

        // Aggiungo le intestazioni necessarie per l'allegato
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: multipart/mixed;\n";
        $headers .= " boundary=\"{$mime_boundary}\"";

        // Definisco il tipo di messaggio (MIME/multi-part)
        $msg .= "This is a multi-part message in MIME format.\n\n";

        // Metto il separatore
        $msg .= "--{$mime_boundary}\n";

        // Questa è la parte "testuale" del messaggio
        $msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
        $msg .= "Content-Transfer-Encoding: 7bit\n\n";
        $msg .= "In allegato i dati relativi all'ordine $ID_ordine" . "\n\n";

        // Metto il separatore
        $msg .= "--{$mime_boundary}\n";

        // Aggiungo l'allegato al messaggio
        $msg .= "Content-Disposition: attachment; filename=\"dati_ordine_$ID_ordine\"\n";
        $msg .= "Content-Transfer-Encoding: base64\n\n";
        $msg .= $data . "\n\n";

        // chiudo con il separatore
        $msg .= "--{$mime_boundary}--\n";
      // Invio la mail
      mail($email, "dati_ordine n°$ID_ordine", $msg, $headers); //mettere email che si vuole.
        
    }
    
}