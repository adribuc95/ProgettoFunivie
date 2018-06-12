<?php
session_start();
include "../Classi/Cliente.php";
include "../Classi/Ordine.php";
include "../Classi/Tessera.php";
include "../Classi/Foto.php";
include "../Classi/Articolo.php";

$ordine = new Ordine();
$tessera = new Tessera();
$foto = new Foto();
$articolo = new Articolo();

if ((!isset($_SESSION['ID_ordine']))) {
            $ID_ordine = $ordine->getIDOrdine();
            $_SESSION['ID_ordine'] = $ID_ordine;
}    
$ID_ordine = $ordine->getIDOrdine();

$numero_tessere = $ordine->countProduct($ID_ordine); //recupero numero tessere dell'ordine
$tipologia_tessere = $ordine->getTessere_StessoOrdine($ID_ordine); //recupero la tipologia delle tessere di un ordine.
$ID_clienti = $ordine->getIDClienti_StessoOrdine($ID_ordine); //ritorna gli ID_cliente di tutti i clienti dello stesso ordine.
$date_nascita = $ordine->getDate_StessoOrdine($ID_ordine);
$nomi = $ordine->getName_StessoOrdine($ID_ordine);
$cognomi = $ordine->getSurname_StessoOrdine($ID_ordine);
$importi_tessere = $ordine->getImporto_Tessera($ID_ordine);
$importi_articoli = $ordine->getImporto_Articolo($ID_ordine);
$ID_articoli = $ordine->getIDArticolo_StessoOrdine($ID_ordine);

if ($numero_tessere == 0) {
    unset($_SESSION['prima_volta']);
    unset($_SESSION['numero_riferimento']);
}


?>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="../Pagina_iniziale/CSS/CSS.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
    </head>
    <body>
        
        <div class='container'>
        <div class='square'>
            <center>
            <div class='titolo'>
                <ul class="price">
                <li class="header"><i style="font-size:35px;" class="fa">&#xf07a;</i> Riepilogo Ordine</li>
                </ul>
            </div>
               <div class='column5' style="height: 30px;">
                <table style="width:100%;">
                    
                <tr>
                         <th id="foto">Foto</th>
                         <th id="tipo">Tipo</th>

                         <th id="dati">Dati</th>
                       <th id="importo">Importo</th>
                       <th id="elimina">Rimuovi</th>
                       </tr>
                    
                </table>
               </div>
                
                <?php
                
        
        for($i = 0; $i < $numero_tessere; $i++) { 
                $tipologia=$tessera->getTipologia(implode("", $tipologia_tessere[$i]));//
                $tipo_articolo=$articolo->getArticolo(implode("", $ID_articoli[$i]));
                $ID_cliente = implode("", $ID_clienti[$i]);
                $ID_foto =  $foto->getIDFoto($ID_ordine, $ID_cliente); //ritorna l'ID_foto dandogli l'ID_ordine attuale e l'ID_cliente
                
                $nome = implode("", $nomi[$i]);
                $cognome = implode("", $cognomi[$i]);
                $data = implode("", $date_nascita[$i]);  
                $importo_tessera = implode("", $importi_tessere[$i]);
                $importo_articolo = implode("", $importi_articoli[$i]);
                $importo_totale = $importo_totale + $importo_tessera + $importo_articolo;
                
                
                
                

            echo "<div class='column5'>
                
                    <table style='width:100%; text-align: center;'>
                        <form action='elimina_tessera.php' method='post'>
                        <tr>
                         <td id='foto'><img src='../Pagina_iniziale/images/$ID_foto.jpg' alt='foto' class='foto'></td>
                     
                        <td id='tipo'>$tipologia + $tipo_articolo</td>

                         <td id='dati'> 
                            <input name='dati$i' value='$ID_cliente' hidden/>
                            $nome<br>$cognome <br>$data</td>
                       <td id='importo'>$importo_tessera + $importo_articolo €</td>
                           
                       <td id='elimina'>
                       <input name='elimina' value='$i' hidden/>
                        <button type='submit' style='background-color: red; border: 1px solid black; color: black'><b><i class='fa fa-trash' style='font-size:20px'></i></b></button></td>
                        <input name='ordine' value='$ID_ordine' hidden/>
                        <input name='foto$i' value='$ID_foto' hidden/>
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
                            </div>";
                    
                    ?>
                    
                </div>
                <hr>
                <div style='margin-top: 10px;' >
                    <?php
                    if ($numero_tessere > 0) {
                    echo "<form action='conferma_ordine.php' method='post'>
                        <button class='bottone'>Conferma Ordine <i class='fa fa-check' style='font-size:16px'></i></button>
                    </form>
                    <form action='modifica_ordine.php' method='post'>
                        <button class='bottone'>Aggiungi Tessera <i class='fa fa-plus' style='font-size:16px'></i></button>
                    </form>";
                    }
                    else { echo "<form action='nuovo_ordine.php' method='post'>
                        <button class='bottone'>Nuovo Ordine <i class='fa fa-plus' style='font-size:16px'></i></button>
                    </form>";}
                            ?>
            
                    
                </div>
            </center>
        </div>
        </div>
    </body>
</html>
