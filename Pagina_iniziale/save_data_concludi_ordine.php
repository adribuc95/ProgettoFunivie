<?php

session_start();
include "../Classi/Cliente.php";
include "../Classi/Foto.php";
include "../Classi/Ordine.php";
$cliente1 = new Cliente();
$ordine1 = new Ordine();
$immagine = new Foto();
header("location: https://www.funiviemadonnacampiglio.it/onlinesale/");

$ID_session = session_id();
$new_ID_cliente = $cliente1->getNewIDCliente();
$new_ID_cliente_riferimento = $cliente1->getNewIDCliente_Riferimento();
$new_ID_ordine = $ordine1->getNewIDOrdine();

$cliente1->setIDCliente_Riferimento($new_ID_cliente_riferimento);
$cliente1->setIDCliente($new_ID_cliente);
$cliente1->salvaDati();
$cliente1->mantieniDatiForm();
$ID_cliente = $cliente1->getIDCliente();
//$età = $cliente1->getBirthday($cliente1->data_nascita);

$immagine->setIDCliente($ID_cliente);
$immagine->setIDFoto($ID_session);
$immagine->salvaDati();

$ordine1->setIDCliente($ID_cliente);
$ordine1->setIDOrdine($new_ID_ordine);
$ordine1->salvaDati();
//checkSkipass($ordine1, $età, $cliente1);
distruggiSessione();


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
