<?php
session_start();
include "../Classi/Cliente.php";
include "../Classi/Ordine.php";
include "../Classi/Tessera.php";
include "../Classi/Foto.php";

$ordine = new Ordine();
$tessera = new Tessera();
$foto = new Foto();

if ((!isset($_SESSION['prima_volta2']))) {
            $_SESSION['prima_volta2'] = false;
            $ID_ordine = $ordine->getIDOrdine(); //recupero ID_ordine
}
$numero_tessere = $ordine->countProduct($ID_ordine); //recupero numero tessere dell'ordine
$tipologia_tessere = $ordine->getTessereDiUnOrdine($ID_ordine); //recupero la tipologia delle tessere di un ordine.
$ID_clienti = $ordine->getIDClienti_StessoOrdine($ID_ordine); //ritorna gli ID_cliente di tutti i clienti dello stesso ordine.
$date_nascita = $ordine->getDate_StessoOrdine($ID_ordine);
$nomi = $ordine->getName_StessoOrdine($ID_ordine);
$cognomi = $ordine->getSurname_StessoOrdine($ID_ordine);
$importi = $ordine->getImporto($ID_ordine);


?>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="../CSS/CSS.css" rel="stylesheet" type="text/css">
        
        <style>
        
.square {
    border: solid darkgray thin;
    margin: 100px;
    border-radius: 10px 10px 10px 10px;
    margin-top: 10px;
    
}

.foto {
    width: 100%;
    max-width: 95px;
    max-height: 95px;
    border-radius: 10px 10px 10px 10px;
}


.column5 {
    
    align-content: center;
    border-bottom: solid gainsboro thin; 
    padding-top: 5px;
    padding-bottom: 5px;
}

#foto {
    width: 20%;
}
#tipo {
    width: 10%;
}

#dati {
    width: 30%;
}

#importo {
   width: 10%; 
    
}

#elimina {
   width: 20%; 
}

#tot_articoli {
    width: 30%;
}

#tot_cauzione {
    width: 30%;
}

#tot_importo {
    width: 30%;
}
        

@media screen and (max-width: 900px) {
    .column5 {
        width: 100%;
        
    }
    
    .square {
        margin: 0px;
        margin-top: 10px;
}

.foto {
    margin-left: 0;
}

#foto {
    width: 30%;
}
#tipo {
    width: 0;
}

#dati {
    width: 30%;
}

#importo {
   width: 10%; 
    
}

#elimina {
   width: 20%; 
}
}


        </style>
    </head>
    <body>
        
        <div class='container'>
        <div class='square'>
            <center>
            <div class='titolo'>
                <ul class="price">
                <li class="header">Riepilogo Ordine</li>
                </ul>
            </div>
               <div class='column5' style="height: 30px;">
                <table style="width:100%;">
                    
                <tr>
                         <th id="foto">Foto</th>
                         <th id="tipo">Tipo</th>

                         <th id="dati">Dati</th>
                       <th id="importo">Importo</th>
                       <th id="elimina">Elimina</th>
                       </tr>
                    
                </table>
               </div>
                
                <?php
        
        for($i = 0; $i < $numero_tessere; $i++) { //$numero_tessere al posto di 4
                $tipologia=$tessera->getTipologia(implode("", $tipologia_tessere[$i]));//
                $ID_cliente = implode("", $ID_clienti[$i]);
                $ID_foto =  $foto->getIDFoto($ID_ordine, $ID_cliente); //ritorna l'ID_foto dandogli l'ID_ordine attuale e l'ID_cliente
                
                $nome = implode("", $nomi[$i]);
                $cognome = implode("", $cognomi[$i]);
                $data = implode("", $date_nascita[$i]);  
                $importo = implode("", $importi[$i]);
                $importo_totale = $importo_totale + $importo;
                
                
                

            echo "<div class='column5'>
                    <table style='width:100%; text-align: center;'>
                        <form action='elimina_tessera.php' method='post'>
                        <tr>
                         <td id='foto'><img src='../Pagina_iniziale/images/$ID_foto.jpg' alt='foto' class='foto'></td>
                         <td id='tipo'>$tipologia</td>

                         <td id='dati'> 
                            <input name='dati$i' value='$ID_cliente' hidden/>
                            $nome<br>$cognome <br>$data</td>
                       <td id='importo'>$importo €</td>
                           
                       <td id='elimina'>
                       <input name='elimina' value='$i' hidden/>
                        <button type='submit'>X</button></td>
                        <input name='ordine' value='$ID_ordine' hidden/>
                        <input name='numero_tessere' value='$numero_tessere' hidden/>
                       </tr>
                       </form>
                     </table>        
        </div>";
        }
        ?>
                <hr>
                <div class="importo_totale column5" style="border-bottom: none">
                    <table style="width:100%;">
                    
                <tr>
                         <th id="tot_articoli">Totale Articoli</th>
                         <th id="tot_cauzione">Totale Cauzione</th>

                         <th id="tot_importo">Totale importo</th>
                       </tr>
                    
                </table>
                    <?php
                    $totale_cauzione = 5.00*$numero_tessere;
                    $importo_totale = $totale_cauzione + $importo_totale;
                    echo "
                        <div class='importo_totale column5' style='border-bottom: none'>
                        <table style='width:100%;'>
                    
                <tr>
                         <th id='tot_articoli'>$numero_tessere</th>
                         <th id='tot_cauzione'>$totale_cauzione,00 €</th>
                         <th id='tot_importo'>$importo_totale,00 €</th>
                       </tr>
                    
                </table>
                            </div>
                            "
                    ?>
                    
                </div>
                <hr>
                <div style='margin-top: 10px;' >
                    <form action="conferma_ordine.php" method="post">
                        <button class="bottone" onclick="">Conferma Ordine</button>
                    </form>
            <form action="modifica_ordine.php" method="post">
                        <button class="bottone" onclick="">Aggiungi Tessera</button>
                    </form>
                </div>
            </center>
        </div>
        </div>
    </body>
</html>
