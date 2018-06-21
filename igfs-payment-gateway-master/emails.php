<?php
session_start();
include "../Classi/Ordine.php";
include "../Classi/Tessera.php";
include "../Classi/Articolo.php";



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
        $query = "SELECT Ordine.ID_ordine, `Foto`, `data_nascita`, `titolo`, `nome`, `cognome`, `indirizzo`, `cap`, `city`, `cellulare`, `email`, `data_ordine`, `tipologia`, `commenti` FROM `Ordine`INNER JOIN `Foto` ON Ordine.ID_cliente = Foto.ID_cliente INNER JOIN `Cliente` ON Ordine.ID_cliente = Cliente.ID_cliente INNER JOIN `Tessera` ON Ordine.ID_tessera = Tessera.ID_tessera WHERE Ordine.ID_ordine= '$ID_ordine'";
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
        $ordine = new Ordine();
        $articolo = new Articolo();
        $tessera = new Tessera();

        $numero_tessere = $ordine->countProduct($ID_ordine); //recupero numero tessere dell'ordine


    $tipologia_tessere = $ordine->getTessere_StessoOrdine($ID_ordine); //recupero la tipologia delle tessere di un ordine.
    $date_nascita = $ordine->getDate_StessoOrdine($ID_ordine);
    $nomi = $ordine->getName_StessoOrdine($ID_ordine);
    $cognomi = $ordine->getSurname_StessoOrdine($ID_ordine);
    $importi_tessere = $ordine->getImporto_Tessera($ID_ordine);
    $importi_articoli = $ordine->getImporto_Articolo($ID_ordine);
    $ID_articoli = $ordine->getIDArticolo_StessoOrdine($ID_ordine);
    $ID_shop = $_SESSION["shop_ID"];
        
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
        <style>
        body {
            font-size: 16px;
            align-content: center;
        }
        </style>
    </head>
    <body>
   
        <p style='margin: 0px; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 19px;'><span style='font-kerning: none'><b></b></span><br></p>
        <h1>Riepilogo ordine n° $ID_ordine</h1>
<table style='border-collapse: collapse'>
<p style='margin: 0px; font-stretch: normal; font-size: 11px; line-height: normal; font-family: Trebuchet MS; color: rgb(255, 255, 255); -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(255, 255, 255);'><span style='font-kerning: none'>77&nbsp;</span></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 11px;'><span style='font-kerning: none'></span><br></p>
<p style='width:70%; margin: 0px 0px 12px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>La ringraziamo per l’ordine d’acquisto effettuato. Con la presente confermiamo che tutto è andato a buon fine. Di seguito i dettagli dell’ordine.</span></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 11px;'><span style='font-kerning: none'>&nbsp;</span></p>
      
<table style='border-collapse: collapse; width: 70%;'>
<tbody>
<tr>
<td valign='top' style='width: 30%; height: 11.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Descrizione</b></span></p>
</td>
<td valign='top' style='width: 50%; height: 11.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Dati</b></span></p>
</td>
<td valign='top' style='width: 20%; height: 11.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Prezzo</b></span></p>
</td>
</tr>";
for($i = 0; $i < $numero_tessere; $i++) { 
                $tipologia=$tessera->getTipologia(implode("", $tipologia_tessere[$i]));//
                $tipo_articolo=$articolo->getArticolo(implode("", $ID_articoli[$i]));
                $nome = implode("", $nomi[$i]);
                $cognome = implode("", $cognomi[$i]);
                $data = implode("", $date_nascita[$i]);  
                $importo_tessera = implode("", $importi_tessere[$i]);
                $importo_articolo = implode("", $importi_articoli[$i]);
                $importo_totale = $importo_totale + $importo_tessera + $importo_articolo;
        $msg .= "
<tr>
<td valign='top' style='width: 30%; height: 10.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal;  line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'> $tipologia"; if($importo_articolo == 0) {
                        $msg .="</span></p>";
                    }
                    else {
                        $msg .= " <hr>$tipo_articolo</span></p>";
                    } 
                    $msg .="
</td>
<td valign='top' style='width: 50%; height: 10.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal;  line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>$nome<br>$cognome <br>$data</span></p>
</td>
<td valign='top' style='width: 20%; height: 10.0px; border-style: solid; border-width: 1.0px 1.0px 1.0px 1.0px; border-color: #000000 #000000 #000000 #000000; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'> $importo_tessera,00€"; if($importo_articolo == 0) {
                $msg .="</span></p>";
            }
            else {
            $msg .= " <hr> $importo_articolo,00 €</span></p>";
                }
                
            $msg .="
</td>
</tr>";
}
        $msg .= "
</tbody>
</table>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 11px;'><span style='font-kerning: none'></span><br></p>
<p style='margin: 0px; font-stretch: normal; font-size: 10px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 11px;'><span style='font-kerning: none'></span><br></p>
<p style='margin: 0px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 14px;'><span style='font-kerning: none'><span class='Apple-tab-span' style='white-space:pre'>	</span></span></p>
";
        $totale_cauzione = 5.00*$numero_tessere;
        $importo_totale = $totale_cauzione + $importo_totale;
        $msg.="

<table cellspacing='0' cellpadding='0' style='border-collapse: collapse'>
<tbody>
<tr>
<td valign='top' style='width: 250.0px; height: 19.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Shop ID:</b></span></p>
</td>
<td valign='top' style='width: 251.0px; height: 19.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; text-align: right; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>$ID_shop</b></span></p>
</td>
</tr>
<tr>
<td valign='top' style='width: 250.0px; height: 19.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Totale Articoli:</b></span></p>
</td>
<td valign='top' style='width: 251.0px; height: 19.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; text-align: right; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>$numero_tessere</b></span></p>
</td>
</tr>
<tr>
<td valign='top' style='width: 250.0px; height: 19.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Totale Cauzione:</b></span></p>
</td>
<td valign='top' style='width: 251.0px; height: 19.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; text-align: right; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>$totale_cauzione,00€</b></span></p>
</td>
</tr>
<tr>
<td valign='top' style='width: 250.0px; height: 19.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>Importo Totale:</b></span></p>
</td>
<td valign='top' style='width: 251.0px; height: 19.0px; padding: 4.0px 4.0px 4.0px 4.0px'>
<p style='margin: 0px; text-align: right; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'><b>$importo_totale,00€</b></span></p>
</td>
</tr>
</tbody>
</table>
<p style='margin: 0px; font-stretch: normal; font-size: 14px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 14px;'><span style='font-kerning: none'><span class='Apple-tab-span' style='white-space:pre'>								</span></span></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 14px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>Per eventuali domande rimaniamo a Sua completa disposizione.</span></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0); min-height: 11px;'><span style='font-kerning: none'></span><br></p>
<p style='margin: 0px 0px 12px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Trebuchet MS; -webkit-text-stroke-width: initial; -webkit-text-stroke-color: rgb(0, 0, 0);'><span style='font-kerning: none'>Cordiali Saluti,</span></p>
  <div dir='ltr'><div style='color:rgb(0,0,0);font-family:Trebuchet MS;font-size:medium'><div style='color:rgb(0,0,0);font-family:Trebuchet MS;font-size:medium'><font face='Trebuchet MS' size='2'><img align='bottom' alt='' border='0' height='70' width='142' hspace='0' src='https://ci4.googleusercontent.com/proxy/K1nv2SAYiulGXF2T4oqTQxHMyqvUNPQ_0NIp3AhGTl-ArMvhRnzYT-sMHZal88dKblSEoBDudUIVAmkrYkybYVqRA2CZv2YojxkM=s0-d-e1-ft#http://www.funiviecampiglio.it/email/logo-funivie.png' class='CToWUd'>&nbsp;<img align='bottom' alt='' border='0' height='70' width='93' hspace='0' src='https://ci5.googleusercontent.com/proxy/A041Z0w6qRDD8LJbpyqWhOxW_qe1TBP8XvERZ_2y3td3ZtXOZW7NXmByh3fMJFfF2MCZgTGGvTmMXtj8noeW-kZVZ-bP5J3NfTzT=s0-d-e1-ft#http://www.funiviecampiglio.it/email/logo-skiarea.png' class='CToWUd'></font></div><div style='color:rgb(0,0,0);font-family:Trebuchet MS;font-size:medium'><font face='Trebuchet MS' size='2'>Funivie Madonna di Campiglio S.p.A.</font></div><div style='color:rgb(0,0,0);font-family:Trebuchet MS;font-size:medium'><font face='Trebuchet MS' size='2'><a href='https://maps.google.com/?q=Via+Presanella,+12+%E2%80%A2+38086%C2%A0+Madonna+di+Campiglio%C2%A0+TN&amp;entry=gmail&amp;source=g'>Via Presanella, 12 • 38086&nbsp; Madonna di Campiglio&nbsp; TN</a></font></div><font face='Trebuchet MS' size='2' style='color:rgb(0,0,0)'><img align='bottom' alt='' border='0' height='15' hspace='0' src='https://ci6.googleusercontent.com/proxy/07uDyXeHsfrr2hR81aBv5NhTz6lKIZIoRBId4hn3hogMLN4YjzZEYDuqrmb4iv8ltgYBr_PGGfTRUOWznB1kQSXQSpE=s0-d-e1-ft#http://www.funiviecampiglio.it/email/Phone.png' width='15' class='CToWUd'>&nbsp;+39 0465 447744&nbsp;&nbsp;&nbsp;&nbsp;<img align='bottom' alt='' border='0' height='15' hspace='0' src='https://ci6.googleusercontent.com/proxy/iUgF4p9zj80Fask-JzKUVXyJmKIRIUpgMJqGRLD-n9JCpquetQcpwQwomMtWI1FT9ItquM7RyxdEHY74tDtC9sPt=s0-d-e1-ft#http://www.funiviecampiglio.it/email/Fax.png' width='15' class='CToWUd'>&nbsp;+39 0465 447799<br><hr><div><b>Informativa - D.lgs. 196/03</b><br><font face='Trebuchet MS' size='1'>I Suoi dati sono trattati per la finalità di comunicazioni commerciali circa i nostri prodotti anche tramite l'utilizzo delle sue coordinate di posta elettronica; i Suoi dati saranno trattati con modalità manuali, informatiche e/o telematiche, potranno essere comunicati a terzi ma non saranno diffusi. Lei potrà rivolgersi al 'Servizio Privacy' presso il titolare del trattamento per verificare i Suoi dati e farli integrare, aggiornare o rettificare e/o per esercitare gli altri diritti previsti dall'art. 7 del D.lgs 196/03, ). La informiamo che il titolare del trattamento dei dati è la Società Funivie Madonna di Campiglio S.p.A.. L'informativa completa è presente sul sito internet&nbsp;</font><a href='http://www.funiviecampiglio.it/pagcomuni/privacy.htm' target='_blank' data-saferedirecturl='https://www.google.com/url?hl=it&amp;q=http://www.funiviecampiglio.it/pagcomuni/privacy.htm&amp;source=gmail&amp;ust=1529655368556000&amp;usg=AFQjCNH-lbQ_Z0TRofmWMq8u_41UG2Uz8Q'><font size='1'>www.funiviecampiglio.<wbr>it</font></a><font size='1'>&nbsp;o presso i nostri uffici e casse.</font></div></font></div></div>
    
    </body>
    
</html>" . "\n\n";
      // Invio la mail
      mail($email, "Conferma ordine n°$ID_ordine", $msg, $headers); //mettere email che si vuole.
        
    }
    
}
    