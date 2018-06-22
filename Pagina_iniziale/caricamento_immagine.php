<!--
////////////////////////////////
AUTHOR: @ADRIANO BUCELLA
adribuc95@gmail.com
///////////////////////////////
-->
<!--funzione che va a caricare l'immagine nella cartella /immagini_skipass, gestisce anche il fatto se non c'è una foto (non usato)-->
<?php
session_start();


$rawData = $_POST['imgBase64'];
if($rawData != "") {
    
    //rigenero l'id sessione e lo assegno al nome del file.
    session_regenerate_id();
    print $rawData;
    $filteredData = explode(',', $rawData);
    $unencoded = base64_decode($filteredData[1]);
    $userid  = session_id();
    
    // name & save the image file
    $fp = fopen('../immagini_skipass/'.$userid.'.jpg', 'w');
    fwrite($fp, $unencoded);
    fclose($fp);
}