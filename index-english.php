<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
include "Classi/Ordine.php";
include "Classi/Tessera.php";
$ordine = new Ordine();
$tessera = new Tessera();


if (isset($_SESSION['ID_ordine'])) {
    $ID_ordine = $_SESSION['ID_ordine'];
}

    $numero_prodotti=$ordine->countProduct($ID_ordine);

if($numero_prodotti == 0) {
    unset($_SESSION['prima_volta']);
    unset($_SESSION['numero_riferimento']);
    unset($_SESSION['ID_ordine']);
}
else {
    $tipologia_tessere = $ordine->getTessere_StessoOrdine($ID_ordine);
}

$importi = $tessera->getImporti();
        

?>
<html>
    <head>
        <title>Richiesta Dati</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Pagina_iniziale/CSS/CSS.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
        
    <script>
    //funzione che gestisce il cambio azione tra "concludi ordine" e "aggiungi skipass"
    function chgAction( action_name ) {
        if(document.getElementById("uploaded").style.display == 'none' && document.getElementById("uploaded2").style.display == 'none') {
            alert("missing picture!!");
        }
        else
        document.dati_utente.action = action_name;
    }
       
    //funzione che calcola l'età data una data di nascita.
    function getAge(dateString) {
        var today = new Date();
        var birthDate = new Date(dateString);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
}

function getLimitDate(age) {
        var date = new Date();
        var year = date.getFullYear() - age;
        var month = date.getMonth()+1;
        var day = date.getDate();

        if (day < 10) {
            day = '0' + day;
        }
        if (month < 10) {
            month = '0' + month;
        }
        
    var formattedDate = day + '/' + month + '/' + year;
    return formattedDate;
    }

    //funzione che va a controllare che la data di nascita inserita sia valida per l'offerta scelta.
    function checkOfferta() {
        var id_radio_ss = ['sseniores_ss', 'seniores_ss', 'juniores_ss', 'bambini_ss', 'baccompagnati_ss' ];
        var id_radio_ca = ['sseniores_ca', 'seniores_ca', 'juniores_ca', 'bambini_ca', 'baccompagnati_ca' ];


        if ((document.getElementById(id_radio_ss[0]).checked == true)|| (document.getElementById(id_radio_ca[0]).checked == true)) {
            var x = document.getElementById('data_nascita').value;
            var anni = getAge(x);
               if(anni < 75) {

                    console.log(anni);
                    console.log(x);
                    alert("La data di nascita non coincide con l'offerta 'SUPER SENIOR'!"); 
                    document.getElementById(id_radio_ss[0]).checked = false;
                    document.getElementById(id_radio_ca[0]).checked = false;
                    document.getElementById('data_nascita').value="";

               }
           }

        else if ((document.getElementById(id_radio_ss[1]).checked == true)|| (document.getElementById(id_radio_ca[1]).checked == true)) {
            var x = document.getElementById('data_nascita').value;
            var anni = getAge(x);
           if(anni <= 65) {

                    console.log(anni);
                    console.log(x);
                    alert("Date doesn't match with the offer 'SENIOR'!"); 
                    document.getElementById(id_radio_ss[1]).checked = false;
                    document.getElementById(id_radio_ca[1]).checked = false;
                    document.getElementById('data_nascita').value="";

               }
           }

        else if ((document.getElementById(id_radio_ss[2]).checked == true)|| (document.getElementById(id_radio_ca[2]).checked == true)) {
            var x = document.getElementById('data_nascita').value;
            var anni = getAge(x);
           if(anni >= 16) {

                    console.log(anni);
                    console.log(x);
                    alert("Date doesn't match with the offer 'JUNIORES'!"); 
                    document.getElementById(id_radio_ss[2]).checked = false;
                    document.getElementById(id_radio_ca[2]).checked = false;
                    document.getElementById('data_nascita').value="";

               }
           }
        else if ((document.getElementById(id_radio_ss[3]).checked == true)|| (document.getElementById(id_radio_ca[3]).checked == true)) {
            var x = document.getElementById('data_nascita').value;
            var anni = getAge(x);

           if(anni >=8) {

                    console.log(anni);
                    console.log(x);
                    alert("Date doesn't match with the offer 'CHILD'!"); 
                    document.getElementById(id_radio_ss[3]).checked = false;
                    document.getElementById(id_radio_ca[3]).checked = false;
                    document.getElementById('data_nascita').value="";

               }
           }
           else if ((document.getElementById(id_radio_ss[4]).checked == true)|| (document.getElementById(id_radio_ca[4]).checked == true)) {
            var x = document.getElementById('data_nascita').value;
            var anni = getAge(x);

           if(anni >=8) {

                    console.log(anni);
                    console.log(x);
                    alert("Date doesn't match with the offer 'CHILD'!"); 
                    document.getElementById(id_radio_ss[4]).checked = false;
                    document.getElementById(id_radio_ca[4]).checked = false;
                    document.getElementById('data_nascita').value="";

               }
           }
        } 
        
    //funzione che va a mostrare un elemento dato il suo id.
    function mostra(ID) {
    
        document.getElementById(ID).style.display = '';
    
    }
    
    //funzione che va a nascondere un elemento dato il suo id.
    function nascondi(ID) {
    
        document.getElementById(ID).style.display = 'none';
    }
    
    function checkFoto() {
        if(document.getElementById("no-uploading").style.display == 'none') {
            return true;
    }
    else {
        alert("manca la foto!!");
            return false;
    }
    }
    </script>

    

    
</head>
<body>
 
    <button type="button" onClick="window.location.href='https://www.funiviemadonnacampiglio.it/onlinesale/Pagina_riepilogo/riepilogo_ordine.php'" style="position: fixed;  float:left; width: 50px; align-content: center; color:#1F3284; font-weight: 800; border-radius: 10px 10px 10px 10px; height: 50px;" <?php if($numero_prodotti==0){echo "disabled";}  ?>>
        <?php echo "$numero_prodotti";?><i style="font-size:25px; color: #1F3284; " class="fa">&#xf07a;</i></button>
  
    <form method="post" action="Pagina_iniziale/mantieni_dati.php" name="dati_utente">
               <div id="tessere">
        <br>
        <center><b>Seleziona il prodotto: * <a href="#openModal2"><i class="fa fa-info-circle" style="font-size:20px"></i></a>
         <!-- MODAL1 speigazione differenze --> 
        </b>
        <div id="openModal2" class="modalDialog">
            <div>
		<a href="#close" title="Close" class="chiudi">X</a>
		<ul class="price2">
                <li class="header2">Differenze</li>
                </ul>
                <p>SKIPASS SUPERSKIRAMA 380 KM OF SLOPES<br>
                    Allow unlimited runs on Funivie Madonna di Campiglio Spa and on those of the following ski resort: Folgarida-Marilleva, Pinzolo (ski connected) Pejo, Ponte di Legno-Tonale-Presena, Andalo-Fai della Paganella, Monte Bondone e Folgaria-Lavarone. <br>
                For more info click  <a href="https://www.skirama.it/homepage?@winter" target="_blank">here</a>. </p>
                <p>SKIPASS MADONNA DI CAMPIGLIO 60 KM OF SLOPES<br>
allow free circulation on Funivie Madonna di Campiglio lift facilities and cable car Colarin Patascoss Express.</p>
            </div>
        </div>
        </center>
        <div class="container">
            <div class="column1" style="text-align: center">
                <div>
                    <img src="Pagina_iniziale/Skirama.jpg" alt="Skirama" class="immagine" style="max-width: 250px">
                </div>
                <div class="descrizione">
                    <center>
                    <div class="columns">
                    <ul class="price">
                      <li class="header">Superskirama</li>
                      <li>
                          <div class="tipologia"><b>ADULT</b><br>Ski pass that allow a <br>ACCOMPANIED CHILD SKIPASS.</div>
                          <div class="prezzo"><?php $importo[0] = implode("", $importi[0]); echo "€ $importo[0],00";?></div>
                          <input type="radio" name="tessera" value="1" id="adulti_ss" required class="selezione" />
                      </li>
                      <li id="sseniores_ss_c">
                          <div class="tipologia"><b>SUPER SENIORES</b> <br>born before<script>document.write(getLimitDate(75));</script></div>
                          <div class="prezzo"><?php $importo[1] = implode("", $importi[1]); echo "€ $importo[1],00";?></div>
                          <input type="radio" name="tessera" value="2" id="sseniores_ss" required class="selezione" />
                      </li>
                      <li id="seniores_ss_c">
                            <div class="tipologia"><b>SENIORES</b> <br> born before <script>document.write(getLimitDate(65));</script></div>
                          <div class="prezzo"><?php $importo[2] = implode("", $importi[2]); echo "€ $importo[2],00";?></div>
                          <input type="radio" name="tessera" value="3" id="seniores_ss" required class="selezione" />
                      </li>
                      <li id="juniores_ss_c">
                           <div class="tipologia"><b>JUNIORES</b> <br>born after <script>document.write(getLimitDate(16));</script></div>
                          <div class="prezzo"><?php $importo[3] = implode("", $importi[3]); echo "€ $importo[3],00";?></div>
                          <input type="radio" name="tessera" value="4" id="juniores_ss" required class="selezione" />
                      </li>
                      <li id="bambini_ss_c">
                          <div class="tipologia"><b>CHILD</b> <br>born after <script>document.write(getLimitDate(8));</script></div>
                          <div class="prezzo"><?php $importo[4] = implode("", $importi[4]); echo "€ $importo[4],00";?></div>
                          <input type="radio" name="tessera" value="5" id="bambini_ss" required class="selezione" />
                      </li>
                      <?php
                        if(isset($_SESSION['numero_riferimento'])) {
                          if ((implode("", $tipologia_tessere[$_SESSION['numero_riferimento']]) == 1) || (implode("", $tipologia_tessere[$_SESSION['numero_riferimento']]) == 2) || (implode("", $tipologia_tessere[$_SESSION['numero_riferimento']]) == 3)) {
                              echo "<li class='height1' id='colore2'>
                          <div class='tipologia'><b>ACCOMPANIED CHILD</b><br>born after <script>document.write(getLimitDate(8));</script> <br><a href='#openModal4'><i class='fa fa-info-circle' style='font-size:20px'></i></a></div>
                          <div class='prezzo'>"; $importo[5] = implode("", $importi[5]); echo "€ $importo[5],00 </div>
                          <input type='radio' name='tessera' value='6' id='baccompagnati_ss' required class='selezione'/>
                      </li>";
                          }
                          else {
                              echo "<li class='height1' id='colore1'>
                          <div class='tipologia'><b>ACCOMPANIED CHILD</b><br>born after <script>document.write(getLimitDate(8));</script> <br><a href='#openModal4'><i class='fa fa-info-circle' style='font-size:20px'></i></a></div>
                          <div class='prezzo'>"; $importo[5] = implode("", $importi[5]); echo "€ $importo[5],00 </div>
                          <input type='radio' name='tessera' value='6' id='baccompagnati_ss' disabled class='selezione'/>
                      </li>";
                          }
                        }
                          else {
                              echo "<li class='height1' id='colore1'>
                          <div class='tipologia'><b>ACCOMPANIED CHILD</b><br>born after <script>document.write(getLimitDate(8));</script> <br><a href='#openModal4'><i class='fa fa-info-circle' style='font-size:20px'></i></a></div>
                          <div class='prezzo'>"; $importo[5] = implode("", $importi[5]); echo "€ $importo[5],00 </div>
                          <input type='radio' name='tessera' value='6' id='baccompagnati_ss' disabled class='selezione'/>
                      </li>";
                          }
                      
                      ?>
                    </ul>
                  </div>
                    </center>
                </div>
            </div>
            
           <!-- modal spiegazione BAMBINO ACCOMPAGNATO SKIRAMA -->
           <div id="openModal4" class="modalDialog">
                    <div>
                         <center>
                        <a href="#close" title="Close" class="chiudi">X</a>
                        <ul class="price2">
                        <li class="header2">ACCOMPANIED CHILD Skirama</li>
                        </ul>
                        <p> This price is valid only when simultaneously purchasing an Adult, Senior or Super Senior Superskirama season ski pass. Reduced prices only upon presentation of a valid identity document. <br>
                        Superskirama season ski pass includes 5 days on <a href="https://www.dolomitisuperski.com/" target="_blank">Dolomiti Superski</a> slopes (from 01.12.2018). </p>
                   </center>
                    </div>
                </div>
           
           <!-- fine -->
            
            <div class="column2" style="text-align: center">
                <div>
                    <img src="Pagina_iniziale/Campiglio.png" alt="Campiglio" class="immagine" style="max-width: 100px;">
                </div>
                <div class="descrizione">
                    <center>
                    <div class="columns">
                    <ul class="price">
                      <li class="header">Campiglio</li>
                      <li>
                          <div class="tipologia"><b>ADULT</b><br>Ski pass that allow a <br>ACCOMPANIED CHILD SKIPASS.</div>
                          <div class="prezzo"><?php $importo[6] = implode("", $importi[6]); echo "€ $importo[6],00";?></div>
                          <input type="radio" name="tessera" value="7" id="adulti_ca" required class="selezione" />
                      </li>
                      <li id="sseniores_ca_c">
                          <div class="tipologia"><b>SUPER SENIORES</b> <br>born before <script>document.write(getLimitDate(75));</script></div>
                          <div class="prezzo"><?php $importo[7] = implode("", $importi[7]); echo "€ $importo[7],00";?></div>
                          <input type="radio" name="tessera" value="8" id="sseniores_ca" required class="selezione" />
                      </li>
                      <li id="seniores_ca_c">
                          <div class="tipologia"><b>SENIORES</b> <br> born before <script>document.write(getLimitDate(65));</script></div>
                          <div class="prezzo"><?php $importo[8] = implode("", $importi[8]); echo "€ $importo[8],00";?></div>
                          <input type="radio" name="tessera" value="9" id="seniores_ca" required class="selezione" />
                      </li>
                      <li id="juniores_ca_c">
                          <div class="tipologia"><b>JUNIORES</b> <br>born after <script>document.write(getLimitDate(16));</script></div>
                          <div class="prezzo"><?php $importo[9] = implode("", $importi[9]); echo "€ $importo[9],00";?></div>
                         <input type="radio" name="tessera" value="10" id="juniores_ca" required class="selezione" />
                      </li>
                      <li id="bambini_ca_c">
                          <div class="tipologia"><b>CHILD</b> <br>born after <script>document.write(getLimitDate(8));</script></div>
                          <div class="prezzo"><?php $importo[10] = implode("", $importi[10]); echo "€ $importo[10],00";?></div>
                          <input type="radio" name="tessera" value="11" id="bambini_ca" required class="selezione" />
                      </li>
                      <?php
                        if(isset($_SESSION['numero_riferimento'])) {
                          if (implode("", $tipologia_tessere[$_SESSION['numero_riferimento']]) == 7) {
                              echo "<li class='height1' id='colore2'>
                          <div class='tipologia'><b>ACCOMPANIED CHILD</b><br>born after <script>document.write(getLimitDate(8));</script> <br><a href='#openModal3'><i class='fa fa-info-circle' style='font-size:20px'></i></a></div>
                          <div class='prezzo'>Omaggio</div>
                          <input type='radio' name='tessera' value='12' id='baccompagnati_ca' required class='selezione'/>
                      </li>";
                          }
                          else {
                              echo "<li class='height1' id='colore1'>
                          <div class='tipologia'><b>ACCOMPANIED CHILD</b><br>born after <script>document.write(getLimitDate(8));</script> <br><a href='#openModal3'><i class='fa fa-info-circle' style='font-size:20px'></i></a></div>
                          <div class='prezzo'>Omaggio</div>
                          <input type='radio' name='tessera' value='12' id='baccompagnati_ca' disabled class='selezione'/>
                      </li>";
                          }
                        }
                          else {
                              echo "<li class='height1' id='colore1'>
                          <div class='tipologia'><b>ACCOMPANIED CHILD</b><br>born after<script>document.write(getLimitDate(8));</script> <br><a href='#openModal3'><i class='fa fa-info-circle' style='font-size:20px'></i></a></div>
                          <div class='prezzo'>Omaggio</div>
                          <input type='radio' name='tessera' value='12' id='baccompagnati_ca' disabled class='selezione'/>
                      </li>";
                          }
                      
                      ?>
                    </ul>
                  </div>
                    </center>
                    
                </div>
            </div>
        </div>
    </div>
        
        <!-- modal spiegazione BAMBINO ACCOMPAGNATO CAMPIGLIO -->
           <div id="openModal3" class="modalDialog">
                    <div>
                        <center>
                        <a href="#close" title="Close" class="chiudi">X</a>
                        <ul class="price2">
                        <li class="header2">ACCOMPANIED CHILD Campiglio</li>
                        </ul>
                        <p> When a family member purchases at the same time a season 'Campiglio Adult' pass.</p>
                        </center>
                    </div>
                </div>
           <!-- fine -->
       
        <div class="dati_utente">
            <div class="container">
                <div class="column1" style="text-align: center; align-content:center;">
                    <center>
                    <div class="columns">
    <ul class="price2">
        <li class="header2">Personal data</li>
    </ul>
    <p class="note">Star (*) sign the mandatory data</p>
    
    <fieldset>
        <label>Title *</label>
        <select id="titolo" name="titolo" required style="height: 25px;">
          <option value="" selected disabled hidden> </option>
          <option value="signor">Mr.</option>
          <option value="signora">Mrs</option>
          <option value="signorina">Miss</option>
        </select>
    </fieldset>
    <fieldset>
        <label>Name *</label>
        <input class="input" name="nome" id="nome" type="text" required   value="<?php if (isset($_SESSION['nome']) && $_SESSION['nome'] <> '') {    echo $_SESSION['nome'];}   ?>">
    </fieldset>  
    <fieldset>
        <label>Surname *</label>
        <input class="input" name="cognome" id="cognome" type="text" required   value="<?php if (isset($_SESSION['cognome']) && $_SESSION['cognome'] <> '') {    echo $_SESSION['cognome'];}   ?>">
    </fieldset>	
    <fieldset>
        <label>Birth date *</label>
        <input class="input" type="date" id="data_nascita" name="data_nascita" placeholder="GG-MM-YYYY" required min="1920-01-01"  pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])([-/])(0[1-9]|1[012])([-/])[0-9]{4}"  onchange="setTimeout(checkOfferta, 5000)" >
    </fieldset>	
    <fieldset>
        <label>Address *</label>
        <input class="input" name='indirizzo' required value="<?php if (isset($_SESSION['indirizzo']) && $_SESSION['indirizzo'] <> '') {    echo $_SESSION['indirizzo'];}   ?>" /> 
    </fieldset>
    <fieldset>
        <label>City *</label>
        <input class="input" name='city' required value="<?php if (isset($_SESSION['city'])&& $_SESSION['city'] <> '') {    echo $_SESSION['city'];}?>"/>
    </fieldset>
    <fieldset>
        <label>ZIP code *</label>
        <input class="input" name='CAP' value="<?php if (isset($_SESSION['CAP']) && $_SESSION['CAP'] <> '') {    echo $_SESSION['CAP'];}   ?>"> 
    </fieldset>
                </div>
                    </center>
                </div>
    
                 
                <div class="column2" style="text-align: center">
                    <center>
                    <div class="columns">
    <ul class="price2">
        <li class="header2">Contacts</li>
    </ul>
        <p class="note">Contacts can be repeated for orders of more than one skipass.</p>
        <fieldset>
            <label>Telephone</label>
            <input class="input" name="telefono" id="telefono" type="tel" value="<?php if (isset($_SESSION['telefono'])&& $_SESSION['telefono'] <> '') {    echo $_SESSION['telefono'];}?>"/>
	</fieldset>
	<fieldset>
            <label>Fax</label>
            <input class="input" name="fax" id="fax" type="text" value="<?php if (isset($_SESSION['fax'])&& $_SESSION['fax'] <> '') {    echo $_SESSION['fax'];}?>"/>
	</fieldset>
	<fieldset>
            <label>Cellphone *</label>
            <input class="input" name="cellulare" id="cellulare" type="tel" required pattern="[0-9]{10}" value="<?php if (isset($_SESSION['cellulare'])&& $_SESSION['cellulare'] <> '') {    echo $_SESSION['cellulare'];}?>"/>
	</fieldset>
        <fieldset>
            <label>Email *</label>
            <input class="input" name="email" id="email" type="email" placeholder="nome@dominio.it" required pattern=".+@.+..+" value="<?php if (isset($_SESSION['email'])&& $_SESSION['email'] <> '') {    echo $_SESSION['email'];}?>"/>
	</fieldset>
	<fieldset>
            <label>Website</label>
            <input class="input" name="sito" id="sito" type="url" placeholder="www.sito.com" value="<?php if (isset($_SESSION['sito'])&& $_SESSION['sito'] <> '') {    echo $_SESSION['sito'];}?>"/>
	</fieldset>
	<fieldset>
    <label>Comments</label>
    <textarea name="commenti" id="commenti" placeholder="" maxlength="100" wrap="soft" style="margin-left: 38px;" value="<?php if (isset($_SESSION['commenti'])&& $_SESSION['commenti'] <> '') {    echo $_SESSION['commenti'];}?>"/></textarea>
	</fieldset>
        <fieldset>
            <label>Would you like the insurance? 
                <!-- riferimento a MODAL2 --> 
                <a href="#openModal"><i class="fa fa-info-circle" style="font-size:20px"></i></a>   
            </label>
            <!-- MODAL2 spiegazione assicurazione -->
            <div id="openModal" class="modalDialog">
                    <div>
                        <a href="#close" title="Close" class="chiudi">X</a>
                        <ul class="price2">
                        <li class="header2">Insurance</li>
                        </ul>
                        <p>The price is 46,00€, for more info click <a href="https://www.funiviecampiglio.it/images/AIGassicurazione/MdiC_FAscicolo_ENG_2018_19.pdf" target="_blank">here</a>. </p></div>
                </div>
            Yes <input type="radio" name="assicurazione" value="1" id="agree" required/>
            No <input type="radio" name="assicurazione" value="0" required/>
           </fieldset>
        
                      
                    </div>
                    </center>
                </div>
    
        

                </div>
            </div>
    <section class="column3">
        <ul class="price2">
        <li class="header2">Picture</li>
    </ul>
        <center>
        <p class="note">The picture has to represent the person who will use the skipass; it must be clear and centered on the face.</p>
        <div style="align-content:center;">
        <button type="button" class="bottone" onclick='mostra("mostra_camera"); nascondi("mostra_camera2"); startWebcam();' id="webcam"> Webcam <i class="fa fa-video-camera" style="font-size:16px"></i></button>
        <button type="button" class="bottone" id ="carica" onclick='mostra("mostra_camera2"); nascondi("mostra_camera");'> Upload <i class="fa fa-camera" style="font-size:16px"></i></button>
        </div>
        <div id='no_foto1'>
        I've already had the picture from last years.<input type="checkbox" name="checkbox" value="check" id="no_foto" onclick='if(document.getElementById("no_foto").checked == true) {mostra("conferma"); nascondi("mostra_camera2"); nascondi("mostra_camera"); nascondi("webcam"); nascondi("carica");} else {mostra("webcam"); mostra("carica"); nascondi("conferma");}'/>
        <br><button type="button" id="conferma" class="bottone" style="display:none; margin-top: 10px;"> Confirm <i class="fa fa-check" style="font-size:16px"></i></button>
        </div>
        <div id='mostra_camera2' style='display: none; margin-top: 10px; border: #eee 1px solid;'>
            <div>
                <button type="button" class="btn" hidden></button>
                <input type='file' id="fileUpload" style=" margin: 20px;" />
            </div>
        <img id="immagine" src="#" alt="your image" style="display: none; max-width:400px; "/>
        <div>
        <button type="button" class="bottone" id="upload2" style="display:none; margin-top: 10px;"> Upload <i class="fa fa-upload" style="font-size:16px"></i></button>
        <br> 
        <span id="uploading2" style="display:none; background-color: gold"> <b> Wait . . . </b> </span>
        
        </div>
        </div>
        <span id="no-uploading" style="background-color: red"> <b> Picture not uploaded </b> </span>
        <span id="uploading3" style="display:none; background-color: gold"> <b> Wait . . . </b> </span>
        <span id="uploaded"  style="display:none; background-color: #00dd00"> <b> Picture uploaded! <i class="fa fa-check" style="font-size:16px"></i></b></span>
        <span id="uploaded2"  style="display:none; background-color: #00dd00"> <b> Confirmed <i class="fa fa-check" style="font-size:16px"></i></b></span>
       
        </center>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
        function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    var immagine = document.createElement("img");
    immagine.src = "https://funiviemadonnacampiglio.it/onlinesale/immagini_skipass/default/default.jpg";

    reader.onload = function(e) {
      $('#immagine').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#fileUpload").change(function() {
  readURL(this);
  $('#immagine').show();
  $('#upload2').show();
});

document.getElementById("upload2").addEventListener("click", function(){
            $("#uploading2").show();
            $("#no-uploading").hide();
            var images = $('#immagine').attr('src');
            $.ajax({
                type: "POST",
                url: "Pagina_iniziale/caricamento_immagine.php",
                data: {
                    imgBase64: images
        }
        }).done(function(msg) {
                console.log("saved");
                $("#uploading2").hide();
                $("#uploaded").show();
                $("#upload2").hide();
                $("#webcam").hide();
                $("#carica").hide();
                $("#no_foto").hide();
                $("#no_foto1").hide();
                $("#mostra_camera2").fadeOut("slow");
            });
        });
  
  document.getElementById("conferma").addEventListener("click", function(){
            $("#uploading3").show();
            $("#no-uploading").hide();
            var images = "";
            $.ajax({
                type: "POST",
                url: "Pagina_iniziale/caricamento_immagine.php",
                data: {
                    imgBase64: images
        }
        }).done(function(msg) {
                console.log("saved");
                $("#uploading3").hide();
                $("#no_foto").hide();
                $("#no_foto1").hide();
                $("#uploaded2").show();
               
            });
        });
  
  




        </script>
        <center>
        <div id='mostra_camera' style='display:none; margin-top: 10px;'>      
<div class="camcontent" id="camcontent">
    <video id="video" autoplay></video>
    <canvas id="canvas"></canvas>
</div>
<div>
    <button type="button" id="snap" class="bottone" style="margin-top: 10px;">  Snap <i class="fa fa-camera" style="font-size:16px"></i></button>
    <button type="button" id="reset_camera"  class="bottone" style="display:none; margin-top: 10px;" onclick='resetCam();'>Reset <i class="fa fa-trash" style="font-size:16px"></i></button>
    <button type="button" id="upload" class="bottone" style="display:none; margin-top: 10px;"> Upload <i class="fa fa-upload" style="font-size:16px"></i></button>
    <br> 
    <span id="uploading" style="display:none; margin-top: 10px; background-color: gold"> <b> Wait . . . </b> </span>
</div>
        </div>
        </center>
    </section>
 
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    
<script>
 navigator.getUserMedia = ( navigator.getUserMedia ||
                   navigator.webkitGetUserMedia ||
                   navigator.mozGetUserMedia ||
                   navigator.msGetUserMedia);

 var webcamStream;

 function startWebcam() {
 // Older browsers might not implement mediaDevices at all, so we set an empty object first
if (navigator.mediaDevices === undefined) {
  navigator.mediaDevices = {};
}

// Some browsers partially implement mediaDevices. We can't just assign an object
// with getUserMedia as it would overwrite existing properties.
// Here, we will just add the getUserMedia property if it's missing.
if (navigator.mediaDevices.getUserMedia === undefined) {
  navigator.mediaDevices.getUserMedia = function(constraints) {

    // First get ahold of the legacy getUserMedia, if present
    var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

    // Some browsers just don't implement it - return a rejected promise with an error
    // to keep a consistent interface
    if (!getUserMedia) {
      return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
    }

    // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise
    return new Promise(function(resolve, reject) {
      getUserMedia.call(navigator, constraints, resolve, reject);
    });
  }
}

navigator.mediaDevices.getUserMedia({ audio: false, video: true })
.then(function(stream) {
  var video = document.querySelector('video');
  // Older browsers may not have srcObject
  if ("srcObject" in video) {
    video.srcObject = stream;
  } else {
    // Avoid using this in new browsers, as it is going away.
    video.src = window.URL.createObjectURL(stream);
  }
  video.onloadedmetadata = function(e) {
    video.play();
  };
})
.catch(function(err) {
  console.log(err.name + ": " + err.message);
});
 }

  document.getElementById("carica").addEventListener('click', function (ev) {
                video.pause();
                ev.preventDefault();
            }, false);
  
  document.getElementById("snap").addEventListener("click", function() {
         var img = document.createElement('img');;
      var context;
      var width = video.offsetWidth
        , height = video.offsetHeight;
        canvas= document.getElementById("canvas");
      
      
      canvas.width = width;
      canvas.height = height;
      
      
      
      

      context = canvas.getContext('2d');
      context.drawImage(video, 0, 0, width, height);
      img.src = canvas.toDataURL('image/png');
      $("#canvas").fadeIn("slow");
      $("#video").fadeOut("slow");
      $("#reset_camera").show();
      $("#upload").show();
      $("#snap").hide();
      
      
  });
  
  function resetCam() {
      var context;
      context = canvas.getContext('2d');
      canvas = document.getElementById('canvas');
      $("#canvas").fadeOut("slow");
      $("#video").fadeIn("slow");
      $("#snap").show();
      $("#reset_camera").hide();
      $("#upload").hide();
      
  }
  
  document.getElementById("upload").addEventListener("click", function(){
            $("#no-uploading").hide();
            $("#uploading").show();
            var dataUrl = canvas.toDataURL("image/jpeg", 0.85);
            $.ajax({
                type: "POST",
                url: "Pagina_iniziale/caricamento_immagine.php",
                data: {
                    imgBase64: dataUrl
        }
        }).done(function(msg) {
                console.log("saved");
                $("#uploading").hide();
                $("#uploaded").show();
                $("#upload").hide();
                $("#reset_camera").hide();
                $("#canvas").hide();
                $("#webcam").hide();
                $("#carica").hide();
                $("#no_foto").hide();
                $("#no_foto1").hide();
               $("#mostra_camera").fadeOut("slow");
            });
        });
        
        
  
  
  
  
</script>
      
    
    
    
    <section class="column4" style="margin-top: 20px;">
        <ul class="price2">
        <li class="header2">Acknowledge</li>
    </ul>
        <fieldset style="text-align: center;">
            <div style="border-bottom: 1px solid #eee;">
                <label class="privacy"> By clicking on 'Accept' you state that you read and accept the (link ) article 13 of
 UE regolamentation 679/2016 and you athorized  autorizzo il trattamento dei miei dati personali</label>
                Do il consenso <input type="checkbox" name="checkbox" value="check" id="agree1" required/>
            </div>
            <div style="margin-top:10px; border-bottom: 1px solid #eee;">
            <label class="privacy"> Dichiaro inoltre di avere attentamente letto l&#39;informativa e di prestare il mio consenso al
trattamento ed alla comunicazione dei miei dati personali anche per le finalità di
marketing</label>
            Do il consenso <input type="radio" name="checkbox2" value="1" id="agree2" required/>
            Nego il consenso <input type="radio" name="checkbox2" value="0"/>
            </div>
            <div style="margin-top:10px;">
            <label class="privacy"> accetto l'iscrizione alla newsletter</label>
            Sì <input type="radio" name="checkbox3" value="1" id="agree3" required/>
            No <input type="radio" name="checkbox3" value="0"/>
            </div>
	 </fieldset>
    
         <center>
        
            <button class="bottone" onclick="chgAction('Pagina_iniziale/concludi_ordine.php')" onsubmit="return checkFoto();">Check order <i class="fa fa-check" style="font-size:16px"></i></button>
            <button  class="bottone" id="final_button" onclick="chgAction('Pagina_iniziale/aggiungi_skipass.php')" onsubmit="return checkFoto();">Add skipass <i class="fa fa-plus" style="font-size:16px"></i></button>
            </center>
        </section>
</form>
    </body>
</html>
