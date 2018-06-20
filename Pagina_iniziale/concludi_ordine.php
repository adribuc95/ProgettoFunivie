<?php

session_start();

include "../Classi/Cliente.php";
include "../Classi/Foto.php";
include "../Classi/Ordine.php";
$cliente = new Cliente();
$foto = new Foto();
$ordine = new Ordine();

if ((!isset($_SESSION["prima_volta"]))) {
            $_SESSION["prima_volta"] = false;
            $new_ID_cliente_riferimento = $cliente->getNewIDCliente_Riferimento();
            $new_ID_ordine = $ordine->getNewIDOrdine();
            $cliente->setIDCliente_Riferimento($new_ID_cliente_riferimento);
            $ordine->setIDOrdine($new_ID_ordine);
            $_SESSION["ID_ordine"] = $new_ID_ordine;
            $_SESSION["numero_riferimento"] = 0;
        }
        else {
            $cliente->setIDCliente_Riferimento($_SESSION["ID_ordine"]);
            $ordine->setIDOrdine($_SESSION["ID_ordine"]);
            $_SESSION["numero_riferimento"]++;
        }



$ID_session = session_id();

//creo i nuovi ID
$new_ID_cliente = $cliente->getNewIDCliente();

//assegno i nuovi ID a Cliente
$cliente->setIDCliente($new_ID_cliente);

//salvo i dati Cliente
$cliente->salvaDati();
$cliente->mantieniDatiForm();

//assegno i gli ID a Ordine
$ordine->setIDCliente($new_ID_cliente);
$ordine->salvaDati();

if (implode($foto->getLastIDFoto()) == $ID_session) {
    $foto->setIDCliente($new_ID_cliente);
    $foto->salvaNoFoto();   
}

else {
    $foto->setIDCliente($new_ID_cliente);
    $foto->setIDFoto($ID_session);
    $foto->salvaDati(); 
}

header("location: ../Pagina_riepilogo/riepilogo_ordine.php");
exit();