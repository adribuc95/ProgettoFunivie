<?php

session_start();

include "../Classi/Cliente.php";
include "../Classi/Foto.php";
include "../Classi/Ordine.php";
$cliente = new Cliente();
$foto = new Foto();
$ordine = new Ordine();

if ((!isset($_SESSION['prima_volta']))) {
            $_SESSION['prima_volta'] = false;
            $new_ID_cliente_riferimento = $cliente->getNewIDCliente_Riferimento();
            $new_ID_ordine = $ordine->getNewIDOrdine();
            $cliente->setIDCliente_Riferimento($new_ID_cliente_riferimento);
            $ordine->setIDOrdine($new_ID_ordine);
        }
        else {
            $ID_cliente_riferimento = $cliente->getIDCliente_Riferimento();
            $ID_ordine = $ordine->getIDOrdine();
            $cliente->setIDCliente_Riferimento($ID_cliente_riferimento);
            $ordine->setIDOrdine($ID_ordine);
        }

header("location: https://www.funiviemadonnacampiglio.it/onlinesale/Pagina_riepilogo/riepilogo_ordine.php");
//header("location: https://www.funiviemadonnacampiglio.it/onlinesale/");
$ID_session = session_id();
$_SESSION['prima_volta'] = true;

//creo i nuovi ID

$new_ID_cliente = $cliente->getNewIDCliente();


//assegno i nuovi ID a Cliente

$cliente->setIDCliente($new_ID_cliente);

//salvo i dati Cliente
$cliente->salvaDati();
$cliente->mantieniDatiForm();


//recupero l'ID_Cliente attuale e l'età
$età = $cliente->getBirthday($cliente->data_nascita);


$foto->setIDCliente($new_ID_cliente);
$foto->setIDFoto($ID_session);
$foto->salvaDati();



//assegno i gli ID a Ordine
$ordine->setIDCliente($new_ID_cliente);
$ordine->salvaDati();


//distruggiSessione();



 function distruggiSessione() {
     session_unset();
    unset($_SESSION['prima_volta']);
    echo "session destroyed";
     
 }
