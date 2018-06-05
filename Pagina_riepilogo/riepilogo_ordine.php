<?php 
        
        session_start();
include "../Classi/Cliente.php";
include "../Classi/Ordine.php";
include "../Classi/Tessera.php";

$ordine = new Ordine();
$ordine->countProduct(0);
$ordine->getTessereDiUnOrdine(0);
$importo_totale = $ordine->getImportoTotale();
echo $importo_totale;
?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="riepilogo.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="row">
            <div class="square">
            <div class="titolo">
                <h2> Riepilogo ordine: </h2>
            </div>      
                </div>
                
                
            
        </div>
            <button onclick="">Paga con carta</button>
            <button onclick="">Paga con bonifico</button>
        </div>
    </body>
</html>
