<!--
////////////////////////////////
AUTHOR: @ADRIANO BUCELLA
adribuc95@gmail.com
///////////////////////////////
-->
<?php
//INIZIALIZZAZIONE E GESTIONE DELLE VARIABILI E DEI DATI NECESSARI
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

if(!isset($_SESSION["ID_ordine"])) {   
header("location: ../index.php");
}

else {
    $we2=$ID_ordine = $_SESSION["ID_ordine"];
}

$numero_tessere = $ordine->countProduct($ID_ordine); //recupero numero tessere dell'ordine

if ($numero_tessere != 0) {
    $tipologia_tessere = $ordine->getTessere_StessoOrdine($ID_ordine); //recupero la tipologia delle tessere di un ordine.
    $ID_clienti = $ordine->getIDClienti_StessoOrdine($ID_ordine); //ritorna gli ID_cliente di tutti i clienti dello stesso ordine.
    $date_nascita = $ordine->getDate_StessoOrdine($ID_ordine);//ritorna LE DATE DI NASCITA di tutti i clienti dello stesso ordine.
    $nomi = $ordine->getName_StessoOrdine($ID_ordine);//ritorna I NOMI di tutti i clienti dello stesso ordine.
    $cognomi = $ordine->getSurname_StessoOrdine($ID_ordine);//ritorna I COGNOMI di tutti i clienti dello stesso ordine.
    $importi_tessere = $ordine->getImporto_Tessera($ID_ordine);//ritorna GLI IMPORTI di tutte le tessere dello stesso ordine.
    $importi_articoli = $ordine->getImporto_Articolo($ID_ordine);//ritorna GLI IMPORTI di tutti gli articoli dello stesso ordine.
    $ID_articoli = $ordine->getIDArticolo_StessoOrdine($ID_ordine);//ritorna GLI ID di tutti gli articoli dello stesso ordine.
}

?>
<html>
    <head>
        <title>Riepilogo Ordine</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../Pagina_iniziale/CSS/CSS.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"> <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
         <script>
             
             //funzione che mostra un elemento
    function mostra() {
        document.getElementById("email").style.display = '';
    }
    //funzione che sostituisce l'immagine se non è stata caricata --> per ora non utilizzata.
    function defaultImage() {
        img=document.getElementById('image');
        img.src='default/default.jpg';
    }
             </script>
    </head>
    <body>
        
        <div class='container'>
        <div class='square'>
            <center>
            <div class='titolo'>
                <ul class="price">
                <li class="header">Riepilogo Ordine<i style="font-size:35px;" class="fa">&#xf07a;</i></li>
                </ul>
            </div>
               
                <!--VADO A POPOLARE IL CARRELLO DEI PRODOTTI AGGIUNTI.-->
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
                        <form action='elimina_tessera.php' method='post' name='elimina_tessera'>
                        <tr>
                        
                         <td id='foto'>
                         
                         <img src='../immagini_skipass/$ID_foto.jpg' class='foto' onerror=document.getElementById('image$i').src='default/default.jpg'; id='image$i'></td>
                     
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
                       <td id='importo'>$importo_tessera,00€"; 
            
            if($importo_articolo == 0) {
                echo"</td>";
            }
            else {
            echo " <hr> $importo_articolo,00 €</td>";
                }
                
            echo "     <td id='elimina'>
                       <input name='elimina' value='$i' hidden/>
                        <button id='button_elimina' onsubmit='return confirmAzione();' type='submit'><b><i class='fa fa-times-circle' style='font-size:30px'></i></b></button></td>
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
                 <!--IMPORTI DELL'ORDINE-->
                <div class="importo_totale column5" style="border-bottom: none">
                    <table style="width:100%;">
                <tr>
                    <th id="tot_articoli">Totale Articoli</th>
                    <th id="tot_cauzione">Totale Cauzione <a href="#openModal"><i class="fa fa-info-circle" style="font-size:20px;"></i></a> </th>
                    <th id="tot_importo">Totale importo</th>
                </tr>
                </table>
                    
                    <!-- MODAL speigazione cauzione --> 
        <div id="openModal" class="modalDialog">
            <div>
		<a href="#close" title="Close" class="chiudi">X</a>
		<ul class="price">
                <li class="header">Cauzione</li>
                </ul>
                <p>Gli skipass sono venduti su supporto del tipo Key-Card al costo di € 5,00 ciascuno a titolo di cauzione. In caso di restituzione del supporto integro e ben conservato, la medesima somma verrà rimborsata.</p>
            </div>
        </div>
                <!--FINE MODAL-->
                    
                    <?php
                    $totale_cauzione = 5.00*$numero_tessere;
                    $we1=$importo_totale = $totale_cauzione + $importo_totale;
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
                    
                     <!--GESTIONE DEI PULSANTI, SE TESSERE = 0, MOSTRO 'NUOVO ORDINE', ALTRIMENTI CONCLUDO ORDINE O AGGIUNGI TESSERA-->
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
                
                 <!--SE CONFERMO L'ORDINE VADO A RICHIEDERE LA MAIL DOVE MANDARE LA CONFERMA E INIZIO IL PAGAMENTO.-->
                <div id='email' style='display: none; margin-top: 10px;'>
                    <hr>
                    <form action='../igfs-payment-gateway-master/pagamento_init.php' method="post">
                    <center>
                        <br>
                        Seleziona la mail su cui vuoi ricevere la ricevuta:<br>
                    <input name="email" id="email" type="email" placeholder="nome@dominio.it" required pattern=".+@.+..+" value="<?php if (isset($_SESSION['email'])&& $_SESSION['email'] <> '') {    echo $_SESSION['email'];}?>" style='height: 30px; width: 40%; margin-top: 10px; align-content: center'/> <br>
                     <!--DATI NASCOSTI CHE MI SERVONO PER IL PAGAMENTO-->
                    <input name='eojneiofneor' value='<?php echo $we1*$we2; ?>' hidden/>
                    <input name='wee' value='<?php echo $we1; ?>' hidden/>
                    <input id='azione' name="azione"hidden />
                     <!---->
                      <!--BOTTONI PER IL PAGAMENTO CON BONIFICO O CARTA-->
                    <button class='bottone' style='margin-top: 10px'onclick="document.getElementById('azione').value ='carta';">Paga Con Carta di Credito <i class='fa fa-credit-card' style='font-size:16px;'></i></button>
                     <button class='bottone' style='margin-top: 10px' onclick="document.getElementById('azione').value ='bonifico';">Paga Con Bonifico <i class='fa fa-piggy-bank' style='font-size:16px;'></i></button>
                     
                     
                    </center>
                    </form>
                </div>
            </center>
        </div>
        </div>
    </body>
</html>
