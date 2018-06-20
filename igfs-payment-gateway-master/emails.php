<?php
session_start();


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
        $query = "SELECT `Foto`, `data_nascita`, `titolo`, `nome`, `cognome`, `indirizzo`, `cap`, `city`, `cellulare`, `email`, `data_ordine`, `tipologia`, `commenti` FROM `Ordine` INNER JOIN `Pagamento` ON Pagamento.ID_ordine = Ordine.ID_ordine INNER JOIN `Cliente` ON Ordine.ID_cliente = Cliente.ID_cliente INNER JOIN `Foto` ON Cliente.ID_cliente = Foto.ID_cliente INNER JOIN `Tessera` ON Tessera.ID_tessera = Ordine.ID_tessera WHERE Ordine.ID_ordine= '$ID_ordine'";
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
            $output.=''.'commenti'.';';
            $output.="\n\n";
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
                $output.='"'.$row['commenti'].'";';
                $output.="\n\n";
                }
            $result->close();
        }

        $file = 'datiOrdine.txt';
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
    
    
    
    //da implementare
    public function emailRiepilogo($email, $ID_ordine) {
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
        $query = "SELECT `Foto`, `data_nascita`, `titolo`, `nome`, `cognome`, `indirizzo`, `cap`, `city`, `cellulare`, `email`, `data_ordine`, `tipologia`, Tessera.importo, `commenti` FROM `Ordine` INNER JOIN `Pagamento` ON Pagamento.ID_ordine = Ordine.ID_ordine INNER JOIN `Cliente` ON Ordine.ID_cliente = Cliente.ID_cliente INNER JOIN `Foto` ON Cliente.ID_cliente = Foto.ID_cliente INNER JOIN `Tessera` ON Tessera.ID_tessera = Ordine.ID_tessera WHERE Ordine.ID_ordine= '$ID_ordine'";
        $output='';
        if (!$result = $conn->query($query)) {
             echo "Errore della query: ".$conn->error.".";
             exit();
         }
         else{
             if($result->num_rows > 0) {
                 $rif=0;
              // conteggio dei record restituiti dalla query
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                //dati file
                $data_nascita[$rif] = $row['data_nascita'];
                $titolo[$rif] = $row['titolo'];
                $nome[$rif] = $row['nome'];
                $cognome[$rif] = $row['cognome'];
                $indirizzo[$rif] = $row['indirizzo'];
                $cap[$rif] = $row['cap'];
                $city[$rif] = $row['city'];
                $cellulare[$rif] = $row['cellulare'];
                $email_cliente[$rif] = $row['email'];
                $data_ordine[$rif] = $row['data_ordine'];
                $tipologia[$rif] = $row['tipologia'];
                $commenti[$rif] = $row['commenti'];
                $importo[$rif] = $row['Tessera.importo'];
                $rif++;
         }
             }
        
        // Genero il "separatore"
        // Serve per dividere, appunto, le varie parti del messaggio.
        // Nel nostro caso separerà la parte testuale dall'allegato
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
       

        // Aggiungo le intestazioni necessarie per l'allegato
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8\n";
        $headers .= " boundary=\"{$mime_boundary}\"";


        // Questa è la parte "testuale" del messaggio
        $msg .= "<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
    <body>
       <center>
        <p style='margin: 0px; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 19px;'><span style='font-kerning: none'><b></b></span><br></p>
<table cellspacing='0' cellpadding='0' style='border-collapse: collapse'>
<tbody>
<tr>
<td valign='top' style='width: 250.0px; height: 60.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Funivie Madonna di Campiglio</b></span></p>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>Via Presanella, 12, Madonna di Campiglio TN</span></p>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>Italia</span></p>
<p style='margin: 0px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Helvetica; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 14px;'><br></p>
</td>
<td valign='top' style='width: 251.0px; height: 60.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; text-align: right; font-stretch: normal; font-size: 20px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Conferma d’ordine</b></span></p>
</td>
</tr>
</tbody>
<p style='margin: 0px; font-stretch: normal; font-size: 11px; line-height: normal; font-family: Trebuchet MS; color: rgb(255, 255, 255); -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(255, 255, 255);'><span style='font-kerning: none'>77&nbsp;</span></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 11px;'><span style='font-kerning: none'></span><br></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>Spett.le"; echo implode("",$titolo[0]); echo" "; echo implode("",$cognome[0]); echo "</span></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>La ringraziamo per l’ordine d’acquisto effettuato. Con la presente confermiamo che tutto è andato a buon fine. Di seguito i dettagli dell’ordine.</span></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 11px;'><span style='font-kerning: none'>&nbsp;</span></p>
      
<table cellspacing='0' cellpadding='0' style='border-collapse: collapse'>
<tbody>
<tr>
<td valign='top' style='width: 157.0px; height: 11.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Descrizione</b></span></p>
</td>
<td valign='top' style='width: 243.0px; height: 11.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Dati</b></span></p>
</td>
<td valign='top' style='width: 83.0px; height: 11.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Prezzo</b></span></p>
</td>
</tr>";
for($i = 0; $i< $rif; $i++){
        echo "
<tr>
<td valign='top' style='width: 157.0px; height: 10.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>"; echo implode("",$tipologia[$i]); echo"</span></p>
</td>
<td valign='top' style='width: 243.0px; height: 10.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>"; echo implode("",$titolo[$i]); echo implode("",$cognome[$i]); echo " <br>"; echo implode("", $data_nascita[$i]); echo "</span></p>
</td>
<td valign='top' style='width: 83.0px; height: 10.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>"; echo implode("",$importo[$i]); echo"</span></p>
</td>
</tr>";
$importo_totale = $importo_totale + implode("", $importo[$i]);
}
        echo "
</tbody>
</table>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 11px;'><span style='font-kerning: none'></span><br></p>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 11px;'><span style='font-kerning: none'></span><br></p>
<p style='margin: 0px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 14px;'><span style='font-kerning: none'><span class='Apple-tab-span' style='white-space:pre'>	</span></span></p>
<table cellspacing='0' cellpadding='0' style='border-collapse: collapse'>
<tbody>
<tr>
<td valign='top' style='width: 250.0px; height: 19.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Totale imponibile lordo</b></span></p>
</td>
<td valign='top' style='width: 251.0px; height: 19.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; text-align: right; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>&nbsp;&nbsp; $importo_totale</b></span></p>
</td>
</tr>
</tbody>
</table>
<p style='margin: 0px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 14px;'><span style='font-kerning: none'><span class='Apple-tab-span' style='white-space:pre'>								</span></span></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>Per eventuali domande rimaniamo a Sua completa disposizione.</span></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 11px;'><span style='font-kerning: none'></span><br></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>Cordiali Saluti,</span></p>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>Firma<span class='Apple-tab-span' style='white-space:pre'>	</span></span></p>
    </center>
    </body>
    
</html>" . "\n\n";
      // Invio la mail
      mail($email, "Conferma ordine n°$ID_ordine", $msg, $headers); //mettere email che si vuole.
        
    }
    
}
    }