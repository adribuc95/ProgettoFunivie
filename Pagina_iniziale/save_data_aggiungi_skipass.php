<?php

session_start();
include "../Classi/Cliente.php";
include "../Classi/Foto.php";
include "../Classi/Ordine.php";
$cliente1 = new Cliente();
$ordine1 = new Ordine();

//header("location: https://www.funiviemadonnacampiglio.it/onlinesale/");



//creo i nuovi ID

$new_ID_cliente = $cliente1->getNewIDCliente();
$new_ID_cliente_riferimento = $cliente1->getNewIDCliente_Riferimento();
$new_ID_ordine = $ordine1->getNewIDOrdine();

//assegno i nuovi ID a Cliente
$cliente1->setIDCliente_Riferimento($new_ID_cliente_riferimento);
$cliente1->setIDCliente($new_ID_cliente);

//salvo i dati Cliente
$cliente1->salvaDati();
$cliente1->mantieniDatiForm();


//recupero l'ID_Cliente attuale e l'età
$ID_cliente = $cliente1->getIDCliente();
$età = $cliente1->getBirthday($cliente1->data_nascita);


//assegno i gli ID a Foto
if(isset($_POST['function2call']) && !empty($_POST['function2call'])) {
    echo "funzione";
    $function2call = $_POST['function2call'];
    if($function2call == 'caricaImmagine') {
       caricaImmagine();
    }
}


//assegno i gli ID a Ordine
$ordine1->setIDCliente($ID_cliente);
$ordine1->setIDOrdine($new_ID_ordine);
$ordine1->salvaDati();
//checkSkipass($ordine1, $età, $cliente1);
distruggiSessione();


//gestisco caricamento immagini
function caricaImmagine() {
    $immagine = new Foto();
    $new_ID_foto = $immagine->getNewIdFoto();
    $immagine->setIdFoto($new_ID_foto);
    echo "funzione carica_immagine";
    //$immagine->setIDCliente($ID_cliente);
    $rawData = $_POST['imgBase64'];
    print $rawData;
    $filteredData = explode(',', $rawData);
    $unencoded = base64_decode($filteredData[1]);
    // name & save the image file
    $fp = fopen('images/'.'we'.'.jpg', 'w');
    fwrite($fp, $unencoded);
    fclose($fp);
}



function checkSkipass($ordine, $età, $cliente) {
        if (($ordine->ID_tessera >= 2 && $ordine->ID_tessera <= 5 && $età >= 5) || ($ordine->ID_tessera >= 8 && $ordine->ID_tessera <= 10 && $età >= 5)) {
            $message = "l'età inserita non corrisponde con l'offerta!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $cliente->eliminaDaDB($cliente->ID_cliente);
            $ordine->eliminaDaDB($ordine->ID_ordine);
            echo "eliminato";
        }
        
        else if (($ordine->ID_tessera >= 2 && $ordine->ID_tessera <= 4 && $età >= 5) || ($ordine->ID_tessera >= 8 && $ordine->ID_tessera <= 10 && $età >= 5)) {
            $message = "l'età inserita non corrisponde con l'offerta!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
            
        
    }

 function distruggiSessione() {
   
     $_SESSION=array();
    unset($_SESSION);
    session_destroy();
    echo "session destroyed...";
 }
