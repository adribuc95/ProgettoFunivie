<?php

session_start();

include "../Classi/Cliente.php";
include "../Classi/Foto.php";
include "../Classi/Ordine.php";
$cliente = new Cliente();
$ordine = new Ordine();


            $ID_cliente_riferimento = $cliente->getIDCliente_Riferimento();
            $ID_ordine = $ordine->getIDOrdine();
            $cliente->setIDCliente_Riferimento($ID_cliente_riferimento);
            $ordine->setIDOrdine($ID_ordine);
        
        
header("location: https://www.funiviemadonnacampiglio.it/onlinesale/");