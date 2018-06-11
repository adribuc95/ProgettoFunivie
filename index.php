<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
include "Classi/Ordine.php";
$ordine = new Ordine();
if ((!isset($_SESSION['ID_ordine']))) {
            $_SESSION['ID_ordine'] = $ordine->getNewIDOrdine();
            
}
$tipologia_tessere = $ordine->getTessereDiUnOrdine($ID_ordine);

?>
<html>
    <head>
        <title>Richiesta Dati</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Pagina_iniziale/CSS/CSS.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
    <script>
    //funzione che gestisce il fatto del biglietto omaggio
    function enable(element){
        if (element === 'baccompagnati_ss') {
            document.getElementById('colore1').style.color = 'black';
            document.getElementById('colore2').style.color = 'gray';
            document.getElementById(element).disabled = false;
            document.getElementById('baccompagnati_ca').disabled = true;
            document.getElementById('baccompagnati_ca').checked = false;
            
        }
        else {
            document.getElementById('colore2').style.color = 'black';
            document.getElementById('colore1').style.color = 'gray';
            document.getElementById(element).disabled = false;
            document.getElementById('baccompagnati_ss').disabled = true;
            document.getElementById('baccompagnati_ss').checked = false;
        }
        
    } 
    
    //funzione che gestisce il fatto del biglietto omaggio    
    function disable(element1, element2){
        document.getElementById(element1).disabled = true;
        document.getElementById(element2).disabled = true;
        document.getElementById(element1).checked = false;
        document.getElementById(element2).checked = false;
        document.getElementById('colore1').style.color = 'gray';
        document.getElementById('colore2').style.color = 'gray';
        
    } 
    
    //funzione che gestisce il cambio azione tra "concludi ordine" e "aggiungi skipass"
    function chgAction( action_name ) {
        if(document.getElementById("uploaded").style.display == 'none' && document.getElementById("uploaded2").style.display == 'none') {
            alert("manca la foto!!");
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

    //funzione che va a controllare che la data di nascita inserita sia valida per l'offerta scelta.
    function checkOfferta() {
        var id_radio_ss = ['sseniores_ss', 'seniores_ss', 'juniores_ss', 'bambini_ss' ];
        var id_radio_ca = ['sseniores_ca', 'seniores_ca', 'juniores_ca', 'bambini_ca' ];


        if ((document.getElementById(id_radio_ss[0]).checked == true)|| (document.getElementById(id_radio_ca[0]).checked == true)) {
            var x = document.getElementById('data_nascita').value;
            var anni = getAge(x);
               if(anni < 76) {

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
           if(anni <= 66) {

                    console.log(anni);
                    console.log(x);
                    alert("La data di nascita non coincide con l'offerta 'SENIOR'!"); 
                    document.getElementById(id_radio_ss[1]).checked = false;
                    document.getElementById(id_radio_ca[1]).checked = false;
                    document.getElementById('data_nascita').value="";

               }
           }

        else if ((document.getElementById(id_radio_ss[2]).checked == true)|| (document.getElementById(id_radio_ca[2]).checked == true)) {
            var x = document.getElementById('data_nascita').value;
            var anni = getAge(x);
           if(anni >= 10) {

                    console.log(anni);
                    console.log(x);
                    alert("La data di nascita non coincide con l'offerta 'JUNIORES'!"); 
                    document.getElementById(id_radio_ss[2]).checked = false;
                    document.getElementById(id_radio_ca[2]).checked = false;
                    document.getElementById('data_nascita').value="";

               }
           }
        else if ((document.getElementById(id_radio_ss[3]).checked == true)|| (document.getElementById(id_radio_ca[3]).checked == true)) {
            var x = document.getElementById('data_nascita').value;
            var anni = getAge(x);

           if(anni >=5) {

                    console.log(anni);
                    console.log(x);
                    alert("La data di nascita non coincide con l'offerta! 'BAMBINI'!"); 
                    document.getElementById(id_radio_ss[3]).checked = false;
                    document.getElementById(id_radio_ca[3]).checked = false;
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
        if(document.getElementById("uploaded").style.display == 'none' && document.getElementById("uploaded2").style.display == 'none') {
            alert("manca la foto!!");
            return false;
    }
    }
    </script>

    
</head>
<body>
 
    <button type="button" onClick="window.location.href='https://www.funiviemadonnacampiglio.it/onlinesale/Pagina_riepilogo/riepilogo_ordine.php'" style="position: fixed; margin-top: 500px;  width: 50px; align-content: center;
            height: 50px;"><i style="font-size:35px; color: #1F3284" class="fa">&#xf07a;</i></button>
  
    <form method="post" action="Pagina_iniziale/mantieni_dati.php" name="dati_utente">
               <div id="tessere" style="border-top: #eee solid thin; ">
        <br>
        <center><b>Seleziona il prodotto: *</b></center>
        <div class="container">
            <div class="column1" style="text-align: center">
                <div>
                    <img src="Pagina_iniziale/Skirama.jpg" alt="Skirama" class="immagine" style="min-height: 100px;">
                </div>
                <div class="descrizione">
                    <center>
                    <div class="columns">
                    <ul class="price">
                      <li class="header">Superskirama</li>
                      <li>
                          <div class="tipologia"><b>ADULTI</b><br>Ski pass a cui può essere associato <br>un BAMBINO ACCOMPAGNATO.</div>
                          <div class="prezzo">€ 640,00</div>
                          <input type="radio" name="tessera" value="1" id="adulti_ss" required class="selezione" />
                      </li>
                      <li id="sseniores_ss_c">
                          <div class="tipologia"><b>SUPER SENIORES</b> <br>nati prima del 30.11.1942</div>
                          <div class="prezzo">€ 500,00</div>
                          <input type="radio" name="tessera" value="2" id="sseniores_ss" required class="selezione" />
                      </li>
                      <li id="seniores_ss_c">
                            <div class="tipologia"><b>SENIORES</b> <br> nati prima del 30.11.1952</div>
                          <div class="prezzo">€ 550,00</div>
                          <input type="radio" name="tessera" value="3" id="seniores_ss" required class="selezione" />
                      </li>
                      <li id="juniores_ss_c">
                           <div class="tipologia"><b>JUNIORES</b> <br>nati dopo il 30.11.2001</div>
                          <div class="prezzo">€ 500,00</div>
                          <input type="radio" name="tessera" value="4" id="juniores_ss" required class="selezione" />
                      </li>
                      <li id="bambini_ss_c">
                          <div class="tipologia"><b>BAMBINI</b> <br>nati dopo il 30.11.2009</div>
                          <div class="prezzo">€ 210,00</div>
                          <input type="radio" name="tessera" value="5" id="bambini_ss" required class="selezione" />
                      </li>
                      <li class="height1">
                          <div class="tipologia"><b>BAMBINI ACCOMPAGNATI </b><br>nati dopo il 30.11.2009 <br>qualora il genitore acquisti contestualmente uno <br> skipass “bistagionale Madonna di Campiglio Adulto”</div>
                          <div class="prezzo">Omaggio</div>
                          <input type="radio" name="tessera" value="6" id="baccompagnati_ss" disabled class="selezione"/>
                      </li>
                    </ul>
                  </div>
                    </center>
                </div>
            </div>
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
                          <div class="tipologia"><b>ADULTI</b><br>Ski pass a cui può essere associato <br>un BAMBINO ACCOMPAGNATO.</div>
                          <div class="prezzo">€ 640,00</div>
                          <input type="radio" name="tessera" value="7" id="adulti_ca" required class="selezione" />
                      </li>
                      <li id="sseniores_ca_c">
                          <div class="tipologia"><b>SUPER SENIORES</b> <br>nati prima del 30.11.1942</div>
                          <div class="prezzo">€ 500,00</div>
                          <input type="radio" name="tessera" value="8" id="sseniores_ca" required class="selezione" />
                      </li>
                      <li id="seniores_ca_c">
                          <div class="tipologia"><b>SENIORES</b> <br> nati prima del 30.11.1952</div>
                          <div class="prezzo">€ 550,00</div>
                          <input type="radio" name="tessera" value="9" id="seniores_ca" required class="selezione" />
                      </li>
                      <li id="juniores_ca_c">
                          <div class="tipologia"><b>JUNIORES</b> <br>nati dopo il 30.11.2001</div>
                          <div class="prezzo">€ 500,00</div>
                         <input type="radio" name="tessera" value="10" id="juniores_ca" required class="selezione" />
                      </li>
                      <li id="bambini_ca_c">
                          <div class="tipologia"><b>BAMBINI</b> <br>nati dopo il 30.11.2009</div>
                          <div class="prezzo">€ 210,00</div>
                          <input type="radio" name="tessera" value="11" id="bambini_ca" required class="selezione" />
                      </li>
                      <li class="height1">
                          <div class="tipologia"><b>BAMBINI ACCOMPAGNATI</b><br>nati dopo il 30.11.2009 <br>qualora il genitore acquisti contestualmente uno <br> skipass “bistagionale Madonna di Campiglio Adulto”</div>
                          <div class="prezzo">Omaggio</div>
                          <input type="radio" name="tessera" value="12" id="baccompagnati_ca" disabled class="selezione"/>
                      </li>
                    </ul>
                  </div>
                    </center>
                    
                </div>
            </div>
        </div>
    </div>
    
    <div>
        <hr>
        <center>
        Non sai la differenza? Clicca qui: 
        </center>
            <hr>
    </div>
        <div class="dati_utente">
            <div class="container">
                <div class="column1" style="text-align: center; align-content:center;">
                    <center>
                    <div class="columns">
    <ul class="price">
        <li class="header">Dati Anagrafici</li>
    </ul>
    <p class="note">L'asterisco (*) indica i campi obbligatori</p>
    
    <fieldset>
        <label>Titolo *</label>
        <select id="titolo" name="titolo" required style="height: 25px; margin-left: 38px;">
          <option value="" selected disabled hidden> </option>
          <option value="signor">Sig.</option>
          <option value="signora">Sig.ra</option>
          <option value="signorina">Sig.na</option>
        </select>
    </fieldset>
    <fieldset>
        <label>Nome *</label>
        <input class="input" name="nome" id="nome" type="text" required  pattern="[a-zA-z]+" value="<?php if (isset($_SESSION['nome']) && $_SESSION['nome'] <> '') {    echo $_SESSION['nome'];}   ?>">
    </fieldset>  
    <fieldset>
        <label>Cognome *</label>
        <input class="input" name="cognome" id="cognome" type="text" required  pattern="[a-zA-z]+" value="<?php if (isset($_SESSION['cognome']) && $_SESSION['cognome'] <> '') {    echo $_SESSION['cognome'];}   ?>">
    </fieldset>	
    <fieldset>
        <label>Data di nascita *</label>
        <input class="input" type="date" id="data_nascita" name="data_nascita" placeholder="DD-MM-YYYY" required min="1920-01-01" max="2017-01-01" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])([-/])(0[1-9]|1[012]|[0-9])([-/])[0-9]{4}" style="font-family: Verdana, sans-serif;" onchange="setTimeout(checkOfferta, 8000)" >
    </fieldset>	
    <fieldset>
        <label>Indirizzo *</label>
        <input class="input" name='indirizzo' required value="<?php if (isset($_SESSION['indirizzo']) && $_SESSION['indirizzo'] <> '') {    echo $_SESSION['indirizzo'];}   ?>" /> 
    </fieldset>
    <fieldset>
        <label>Città *</label>
        <input class="input" name='city' required value="<?php if (isset($_SESSION['city'])&& $_SESSION['city'] <> '') {    echo $_SESSION['city'];}?>"/>
    </fieldset>
    <fieldset>
        <label>CAP *</label>
        <input class="input" name='CAP' required pattern="[0-9]{5}" placeholder='es: 38086' value="<?php if (isset($_SESSION['CAP']) && $_SESSION['CAP'] <> '') {    echo $_SESSION['CAP'];}   ?>"> 
    </fieldset>
    <fieldset style="border-bottom: none; ">
    <label>Provincia *</label>
        <select id="provincia" name="provincia" required style=" margin-left: 38px; height: 25px;">
            <option value="" selected disabled hidden> </option>
            <option value="ag">Agrigento</option>
            <option value="al">Alessandria</option>
            <option value="an">Ancona</option>
            <option value="ao">Aosta</option>
            <option value="ar">Arezzo</option>
            <option value="ap">Ascoli Piceno</option>
            <option value="at">Asti</option>
            <option value="av">Avellino</option>
            <option value="ba">Bari</option>
            <option value="bt">Barletta-Andria-Trani</option>
            <option value="bl">Belluno</option>
            <option value="bn">Benevento</option>
            <option value="bg">Bergamo</option>
            <option value="bi">Biella</option>
            <option value="bo">Bologna</option>
            <option value="bz">Bolzano</option>
            <option value="bs">Brescia</option>
            <option value="br">Brindisi</option>
            <option value="ca">Cagliari</option>
            <option value="cl">Caltanissetta</option>
            <option value="cb">Campobasso</option>
            <option value="ci">Carbonia-iglesias</option>
            <option value="ce">Caserta</option>
            <option value="ct">Catania</option>
            <option value="cz">Catanzaro</option>
            <option value="ch">Chieti</option>
            <option value="co">Como</option>
            <option value="cs">Cosenza</option>
            <option value="cr">Cremona</option>
            <option value="kr">Crotone</option>
            <option value="cn">Cuneo</option>
            <option value="en">Enna</option>
            <option value="fm">Fermo</option>
            <option value="fe">Ferrara</option>
            <option value="fi">Firenze</option>
            <option value="fg">Foggia</option>
            <option value="fc">Forl&igrave;-Cesena</option>
            <option value="fr">Frosinone</option>
            <option value="ge">Genova</option>
            <option value="go">Gorizia</option>
            <option value="gr">Grosseto</option>
            <option value="im">Imperia</option>
            <option value="is">Isernia</option>
            <option value="sp">La spezia</option>
            <option value="aq">L'aquila</option>
            <option value="lt">Latina</option>
            <option value="le">Lecce</option>
            <option value="lc">Lecco</option>
            <option value="li">Livorno</option>
            <option value="lo">Lodi</option>
            <option value="lu">Lucca</option>
            <option value="mc">Macerata</option>
            <option value="mn">Mantova</option>
            <option value="ms">Massa-Carrara</option>
            <option value="mt">Matera</option>
            <option value="vs">Medio Campidano</option>
            <option value="me">Messina</option>
            <option value="mi">Milano</option>
            <option value="mo">Modena</option>
            <option value="mb">Monza e della Brianza</option>
            <option value="na">Napoli</option>
            <option value="no">Novara</option>
            <option value="nu">Nuoro</option>
            <option value="og">Ogliastra</option>
            <option value="ot">Olbia-Tempio</option>
            <option value="or">Oristano</option>
            <option value="pd">Padova</option>
            <option value="pa">Palermo</option>
            <option value="pr">Parma</option>
            <option value="pv">Pavia</option>
            <option value="pg">Perugia</option>
            <option value="pu">Pesaro e Urbino</option>
            <option value="pe">Pescara</option>
            <option value="pc">Piacenza</option>
            <option value="pi">Pisa</option>
            <option value="pt">Pistoia</option>
            <option value="pn">Pordenone</option>
            <option value="pz">Potenza</option>
            <option value="po">Prato</option>
            <option value="rg">Ragusa</option>
            <option value="ra">Ravenna</option>
            <option value="rc">Reggio di Calabria</option>
            <option value="re">Reggio nell'Emilia</option>
            <option value="ri">Rieti</option>
            <option value="rn">Rimini</option>
            <option value="rm">Roma</option>
            <option value="ro">Rovigo</option>
            <option value="sa">Salerno</option>
            <option value="ss">Sassari</option>
            <option value="sv">Savona</option>
            <option value="si">Siena</option>
            <option value="sr">Siracusa</option>
            <option value="so">Sondrio</option>
            <option value="ta">Taranto</option>
            <option value="te">Teramo</option>
            <option value="tr">Terni</option>
            <option value="to">Torino</option>
            <option value="tp">Trapani</option>
            <option value="tn">Trento</option>
            <option value="tv">Treviso</option>
            <option value="ts">Trieste</option>
            <option value="ud">Udine</option>
            <option value="va">Varese</option>
            <option value="ve">Venezia</option>
            <option value="vb">Verbano-Cusio-Ossola</option>
            <option value="vc">Vercelli</option>
            <option value="vr">Verona</option>
            <option value="vv">Vibo valentia</option>
            <option value="vi">Vicenza</option>
            <option value="vt">Viterbo</option>
        </select>
    </fieldset>
    
                  
                </div>
                    </center>
                </div>
    
                 
                <div class="column2" style="text-align: center">
                    <center>
                    <div class="columns">
    <ul class="price">
        <li class="header">Contatti</li>
    </ul>
        <p class="note">Questi dati possono essere ripetuti per ordini di più tessere.</p>
        <fieldset>
            <label>Telefono</label>
            <input class="input" name="telefono" id="telefono" type="tel" value="<?php if (isset($_SESSION['telefono'])&& $_SESSION['telefono'] <> '') {    echo $_SESSION['telefono'];}?>"/>
	</fieldset>
	<fieldset>
            <label>Fax</label>
            <input class="input" name="fax" id="fax" type="text" value="<?php if (isset($_SESSION['fax'])&& $_SESSION['fax'] <> '') {    echo $_SESSION['fax'];}?>"/>
	</fieldset>
	<fieldset>
            <label>Cellulare *</label>
            <input class="input" name="cellulare" id="cellulare" type="tel" required pattern="[0-9]{10}" value="<?php if (isset($_SESSION['cellulare'])&& $_SESSION['cellulare'] <> '') {    echo $_SESSION['cellulare'];}?>"/>
	</fieldset>
        <fieldset>
            <label>Email *</label>
            <input class="input" name="email" id="email" type="email" placeholder="nome@dominio.it" required pattern=".+@.+..+" value="<?php if (isset($_SESSION['email'])&& $_SESSION['email'] <> '') {    echo $_SESSION['email'];}?>"/>
	</fieldset>
	<fieldset>
            <label>Sito Web</label>
            <input class="input" name="sito" id="sito" type="url" placeholder="www.sito.com" value="<?php if (isset($_SESSION['sito'])&& $_SESSION['sito'] <> '') {    echo $_SESSION['sito'];}?>"/>
	</fieldset>
	<fieldset>
    <label>Commenti</label>
    <textarea name="commenti" id="commenti" placeholder="" maxlength="100" wrap="soft" style="margin-left: 38px;" value="<?php if (isset($_SESSION['commenti'])&& $_SESSION['commenti'] <> '') {    echo $_SESSION['commenti'];}?>"/></textarea>
	</fieldset>
        <fieldset>
            <label>Desideri l'assicurazione?</label>
            Sì <input type="radio" name="assicurazione" value="1" id="agree" required/>
            No <input type="radio" name="assicurazione" value="0" required/>
           </fieldset>
        
                      
                    </div>
                    </center>
                </div>
    
        

                </div>
            </div>

        
       
    <section class="column3">
        <ul class="price">
        <li class="header">Foto</li>
    </ul>
        <center>
        <p class="note">La foto deve rappresentare il soggetto che andrà ad utilizzare lo skipass in modo chiaro, centrata sul viso.</p>
        <div style="align-content:center;">
        <button type="button" class="bottone" onclick='mostra("mostra_camera"); nascondi("mostra_camera2"); startWebcam();' id="webcam"> Webcam <i class="fa fa-video-camera" style="font-size:16px"></i></button>
        <button type="button" class="bottone" id ="carica" onclick='mostra("mostra_camera2"); nascondi("mostra_camera");'> Carica <i class="fa fa-camera" style="font-size:16px"></i></button>
        </div>
        
        <div id='mostra_camera2' style='display: none; margin-top: 10px; border: #eee 1px solid;'>
            <div>
                <button type="button" class="btn" hidden></button>
                <input type='file' id="fileUpload" style=" margin: 20px;" />
            </div>
        <img id="immagine" src="#" alt="your image" style="display: none; max-width:400px; "/>
        <div>
        <button type="button" class="bottone" id="upload2" style="display:none; margin-top: 10px;"> Carica <i class="fa fa-upload" style="font-size:16px"></i></button>
        <br> <span id="uploading2" style="display:none; background-color: gold"> <b> Attendi . . . </b> </span>
        
        </div>
        </div>
        <span id="uploaded2"  style="display:none; background-color: #00dd00"> <b> Foto caricata! <i class="fa fa-check" style="font-size:16px"></i></b></span>
       
        </center>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
        function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    var immagine;

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
                $("#uploaded2").show();
                $("#upload2").hide();
                $("#webcam").hide();
                $("#carica").hide();
                $("#mostra_camera2").fadeOut("slow");
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
    <button type="button" id="snap" class="bottone" style="margin-top: 10px;">  Scatta <i class="fa fa-camera" style="font-size:16px"></i></button>
    <button type="button" id="reset_camera"  class="bottone" style="display:none; margin-top: 10px;" onclick='resetCam();'>Reset <i class="fa fa-trash" style="font-size:16px"></i></button>
    <button type="button" id="upload" class="bottone" style="display:none; margin-top: 10px;"> Carica <i class="fa fa-upload" style="font-size:16px"></i></button>
    <br> <span id="uploading" style="display:none; margin-top: 10px; background-color: gold"> <b> Attendi . . . </b> </span>
</div>
        </div>
            <span id="uploaded"  style="display:none; margin-top: 10px; background-color: #00dd00"> <b> Foto caricata! <i class="fa fa-check" style="font-size:16px"></i></b></span>
    
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
 if (navigator.getUserMedia) {
 console.log("toto");
 navigator.getUserMedia (

    // constraints
    {
      video: true,
      audio: false
    },

    // successCallback
     function(localMediaStream) {
      var video = document.querySelector('video');
      video.src = window.URL.createObjectURL(localMediaStream);
      webcamStream = localMediaStream;
    },

    // errorCallback
       function(err) {
       console.log("The following error occured: " + err);
       }
     );
    } else {
    console.log("getUserMedia not supported");
      }  
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
               $("#mostra_camera").fadeOut("slow");
            });
        });
  
  
  
  
</script>
      
    
    
    
    <section class="column4">
        <ul class="price">
        <li class="header">Accettazione</li>
    </ul>
        <fieldset style="text-align: center;">
            <div style="border-bottom: 1px solid #eee;">
                <label class="privacy"> Dichiaro di aver letto e compreso l’informativa (link all’informativa) di cui all’art 13
Regolamento (UE) 679/2016 e autorizzo il trattamento dei miei dati personali</label>
            
                Do il consenso <input type="radio" name="checkbox" value="check" id="agree" required/>
            Nego il consenso <input type="radio" name="checkbox" value="check" checked/>
            </div>
            <div style="margin-top:10px; border-bottom: 1px solid #eee;">
            <label class="privacy"> Dichiaro inoltre di avere attentamente letto l&#39;informativa e di prestare il mio consenso al
trattamento ed alla comunicazione dei miei dati personali anche per le finalità di
marketing</label>
            Do il consenso <input type="radio" name="checkbox2" value="check" id="agree" required/>
            Nego il consenso <input type="radio" name="checkbox2" value="check" checked/>
            </div>
            <div style="margin-top:10px;">
            <label class="privacy"> accetto l'iscrizione alla newsletter</label>
            Sì <input type="radio" name="checkbox3" value="check" id="agree" required/>
            No <input type="radio" name="checkbox3" value="check" checked/>
            </div>
	 </fieldset>
    </section>
         <center>
        
            <button class="bottone" onclick="chgAction('Pagina_iniziale/concludi_ordine.php')" onsubmit="return checkFoto();">Concludi Ordine <i class="fa fa-check" style="font-size:16px"></i></button>
            <button  class="bottone" id="final_button" onclick="chgAction('Pagina_iniziale/aggiungi_skipass.php')" onsubmit="return checkFoto();">Aggiungi un altro skipass <i class="fa fa-plus" style="font-size:16px"></i></button>
            </center>
</form>
    </body>
</html>
