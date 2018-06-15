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
$_SESSION['firefox'] = false;
if(!isset($_SESSION['ID_ordine']) && (!isset($_SESSION['firefox']))) {   
$ID_ordine = $ordine->getIDOrdine();
}
else {
    $ID_ordine = $_SESSION['ID_ordine'];
}

$numero_tessere = $ordine->countProduct($ID_ordine); //recupero numero tessere dell'ordine
$tipologia_tessere = $ordine->getTessere_StessoOrdine($ID_ordine); //recupero la tipologia delle tessere di un ordine.
$ID_clienti = $ordine->getIDClienti_StessoOrdine($ID_ordine); //ritorna gli ID_cliente di tutti i clienti dello stesso ordine.
$date_nascita = $ordine->getDate_StessoOrdine($ID_ordine);
$nomi = $ordine->getName_StessoOrdine($ID_ordine);
$cognomi = $ordine->getSurname_StessoOrdine($ID_ordine);
$importi_tessere = $ordine->getImporto_Tessera($ID_ordine);
$importi_articoli = $ordine->getImporto_Articolo($ID_ordine);
$ID_articoli = $ordine->getIDArticolo_StessoOrdine($ID_ordine);
$emails = $ordine->getEmail_StessoOrdine($ID_ordine);

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
         <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
         <script>
             function mostra() {
    
        document.getElementById("email").style.display = '';
    
    }
             </script>
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
               
                
                <?php
         
        if ($numero_tessere == 0) {
            echo "<center><div>Nessuna articolo selezionato</div></center>";
        }
        else {
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
                         <td id='foto'><img src='../immagini_skipass/$ID_foto.jpg' alt='foto' class='foto'></td>
                     
                        <td id='tipo'>$tipologia ";
                    if($importo_articolo == 0) {
                        echo"</td>";
                    }
                    else {
                        echo " <hr>$tipo_articolo</td>";
                    }
                
                    echo "

                         <td id='dati'> 
                            <input name='dati$i' value='$ID_cliente' hidden/>
                            $nome<br>$cognome <br>$data</td>
                       <td id='importo'>$importo_tessera,00 €"; 
            
            if($importo_articolo == 0) {
                echo"</td>";
            }
            else {
            echo " <hr> $importo_articolo,00 €</td>";
                }
                
            echo "     <td id='elimina'>
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
        }
        ?>
                <hr>
                <div class="importo_totale column5" style="border-bottom: none">
                    <table style="width:100%;">
                    
                <tr>
                         <th id="tot_articoli">Totale Articoli</th>
                         <th id="tot_cauzione">Totale Cauzione <a href="#openModal"><i class="fa fa-info-circle" style="font-size:20px;"></i></a>
         <!-- MODAL1 speigazione cauzione --> 
        </th>
        <div id="openModal" class="modalDialog">
            <div>
		<a href="#close" title="Close" class="chiudi">X</a>
		<ul class="price">
                <li class="header">Cauzione</li>
                </ul>
                <p>Gli skipass sono venduti su supporto del tipo Key-Card al costo di € 5,00 ciascuno a titolo di cauzione. In caso di restituzione del supporto integro e ben conservato, la medesima somma verrà rimborsata.</p>
            </div>
        </div>

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
                <div style='margin-top: 10px;'>
                    <?php
                    if ($numero_tessere > 0) {
                    echo "
                    <form action='modifica_ordine.php' method='post'>
                        <button class='bottone'>Aggiungi Tessera <i class='fa fa-plus' style='font-size:16px'></i></button>
                    </form>
                    
                        <button class='bottone' onclick='mostra();'>Conferma Ordine <i class='fa fa-check' style='font-size:16px'></i></button>
                        
                    
                    ";
                    }
                    else { echo "<form action='nuovo_ordine.php' method='post'>
                        <button class='bottone'>Nuovo Ordine <i class='fa fa-plus' style='font-size:16px'></i></button>
                    </form>";}
                            ?>
            
                    
                </div>
                <div id='email' style='display: none; margin-top: 10px;'>
                    
                    <hr>
                    <form action='../igfs-payment-gateway-master/pagamento_init.php' method="post">
                    <center>
                        <br>
                        seleziona la mail su cui vuoi ricevere la notifica di pagamento:<br>
                    <input name="email" id="email" type="email" placeholder="nome@dominio.it" required pattern=".+@.+..+" value="<?php if (isset($_SESSION['email'])&& $_SESSION['email'] <> '') {    echo $_SESSION['email'];}?>" style='height: 30px; width: 40%; margin-top: 10px; align-content: center'/> <br>
                    <input name='importo_totale' value='<?php echo $importo_totale; ?>' hidden/>
                    <input name='ID_ordine' value='<?php echo $ID_ordine; ?>' hidden/>
                     <button class='bottone' style='margin-top: 10px'>Paga <i class='fa fa-paypal' style='font-size:16px;'></i></button>
                     
                    </center>
                    </form>
                </div>
            </center>
        </div>
        </div>
    </body>
</html>
