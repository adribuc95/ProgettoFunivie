<?php 
        session_start();
        ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        
        
        <title>Richiesta Dati</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/CSS.css" rel="stylesheet" type="text/css">
        <link href="css/main.css" rel="stylesheet" type="text/css" />
        
        <script>
    navigator.getUserMedia = (navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia );
    if (navigator.getUserMedia)
    {
        navigator.getUserMedia(
            {
                video:true,
                audio:false
            },
            function(stream) { /* do-say something */ },
            function(error) { alert('Something went wrong. (error code ' + error.code + ')');
                return; }
        );
    }
    else {
        alert("Sorry, the browser you are using doesn't support the HTML5 webcam API");
    }
</script>
    <style>
        .camcontent{
            display: block;
            position: relative;
            overflow: hidden;
            height: 480px;
            margin: auto;
        }
        .cambuttons button {
            border-radius: 15px;
            font-size: 18px;
        }
        .cambuttons button:hover {
            cursor: pointer;
            border-radius: 15px;
            background: #00dd00 ;    /* green */
        }
    </style>

        
    <script>
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
        
    } //funzione che gestisce il fatto del biglietto omaggio
        
        function disable(element1, element2){
        document.getElementById(element1).disabled = true;
        document.getElementById(element2).disabled = true;
        document.getElementById(element1).checked = false;
        document.getElementById(element2).checked = false;
        document.getElementById('colore1').style.color = 'gray';
        document.getElementById('colore2').style.color = 'gray';
        
    } //funzione che gestisce il fatto del biglietto omaggio
        
        function chgAction( action_name ) {
            if( action_name=='my_upload.php' ) {
                document.dati_utente.action = 'my_upload.php';
            }
            else {
                document.dati_utente.action = 'save_data.php';
            }
            
        } //funzione che gestisce il cambio azione tra "concludi ordine" e "aggiungi skipass"
        
        function sblocca() {
            
            var id_radio_ss = ['sseniores_ss', 'seniores_ss', 'juniores_ss', 'bambini_ss' ];
            var id_radio_ca = ['sseniores_ca', 'seniores_ca', 'juniores_ca', 'bambini_ca' ];
            var id_cat_ss = ['sseniores_ss_c', 'seniores_ss_c', 'juniores_ss_c', 'bambini_ss_c' ];
            var id_cat_ca = ['sseniores_ca_c', 'seniores_ca_c', 'juniores_ca_c', 'bambini_ca_c' ];
            
            
            var x = document.getElementById('data_nascita').value;
            var anni = calcAge(x);
            
            if (anni <= 5) {
                        alert("La data di nascita non coincide con l'offerta!");
            }
            else if (anni > 5 && anni <= 10) {
               for(i=0; i<4; i++) {
                   document.getElementById(id_radio_ss[i]).checked = false;
                    document.getElementById(id_radio_ca[i]).checked = false;
                    document.getElementById(id_radio_ss[i]).disabled = true;
                    document.getElementById(id_radio_ca[i]).disabled = true;
                    document.getElementById(id_cat_ss[i]).style.color = 'gray';
                    document.getElementById(id_cat_ca[i]).style.color = 'gray';
                
               }
                
                document.getElementById(id_radio_ss[2]).disabled = false;
                document.getElementById(id_cat_ss[2]).style.color = 'black';
                document.getElementById(id_radio_ca[2]).disabled = false;
                document.getElementById(id_cat_ca[2]).style.color = 'black';
                
            }
            else if (anni >= 60 && anni < 70) {
               for(i=0; i<4; i++) {
                   document.getElementById(id_radio_ss[i]).checked = false;
                    document.getElementById(id_radio_ca[i]).checked = false;
                    document.getElementById(id_radio_ss[i]).disabled = true;
                    document.getElementById(id_radio_ca[i]).disabled = true;
                    document.getElementById(id_cat_ss[i]).style.color = 'gray';
                    document.getElementById(id_cat_ca[i]).style.color = 'gray';
                
               }
                
                document.getElementById(id_radio_ss[1]).disabled = false;
                document.getElementById(id_cat_ss[1]).style.color = 'black';
                document.getElementById(id_radio_ca[1]).disabled = false;
                document.getElementById(id_cat_ca[1]).style.color = 'black';
                
            }
            else if (anni >= 70) {
               for(i=0; i<4; i++) {
                    document.getElementById(id_radio_ss[i]).disabled = true;
                    document.getElementById(id_radio_ca[i]).disabled = true;
                    document.getElementById(id_radio_ss[i]).checked = false;
                    document.getElementById(id_radio_ca[i]).checked = false;
                    document.getElementById(id_cat_ss[i]).style.color = 'gray';
                    document.getElementById(id_cat_ca[i]).style.color = 'gray';
                
               }
                
                document.getElementById(id_radio_ss[0]).disabled = false;
                document.getElementById(id_cat_ss[0]).style.color = 'black';
                document.getElementById(id_radio_ca[0]).disabled = false;
                document.getElementById(id_cat_ca[0]).style.color = 'black';
                
            }
            else {
             for(i=0; i<4; i++) {
              document.getElementById(id_radio_ss[i]).disabled = true;
                    document.getElementById(id_radio_ca[i]).disabled = true;
                    document.getElementById(id_radio_ss[i]).checked = false;
                    document.getElementById(id_radio_ca[i]).checked = false;
                    document.getElementById(id_cat_ss[i]).style.color = 'gray';
                    document.getElementById(id_cat_ca[i]).style.color = 'gray';
                
               }
            }
        }
            
        function checkDate () {
            var id_radio_ss = ['adulti_ss', 'sseniores_ss', 'seniores_ss', 'juniores_ss', 'bambini_ss' ];
            var id_radio_ca = ['adulti_ca','sseniores_ca', 'seniores_ca', 'juniores_ca', 'bambini_ca' ];
            
            
            var x = document.getElementById('data_nascita').value;
            var anni = calcAge(x);
            if ((anni <= 5) && ((document.getElementById(id_radio_ss[4]).checked === true) ||(document.getElementById(id_radio_ca[4]).checked === true))) {
                    //do nothing  
                }
            else if((anni > 5 && anni <= 10) && ((document.getElementById(id_radio_ss[3]).checked == true) || (document.getElementById(id_radio_ca[3]).checked == true))) {
                    //do nothing
            }
            else if ((anni > 10 && anni <= 60) && ((document.getElementById(id_radio_ss[0]).checked == true)||(document.getElementById(id_radio_ca[0]).checked == true))) {
                     //do nothing
                }
            
            else if ((anni > 60 && anni <= 70) && ((document.getElementById(id_radio_ss[2]).checked == true)||(document.getElementById(id_radio_ca[2]).checked == true))) {
                    //do nothing
                }
            else if ((anni > 70) && ((document.getElementById(id_radio_ss[1]).checked == true)||(document.getElementById(id_radio_ca[1]).checked == true))) {
                    //do nothing
            }
            else {
                alert("La data di nascita non coincide con l'offerta!");
            }
            
        }    
     
    
    function calcAge (birthday) {
    birthday = new Date(birthday);
    today = new Date();
 
    var years = (today.getFullYear() - birthday.getFullYear());
 
    if (today.getMonth() < birthday.getMonth() || 
        today.getMonth() == birthday.getMonth() && today.getDate() < birthday.getDate()) {
        years--;
    }
 
    return years;
}
function mostra(ID) {
    if(document.getElementById(ID).style.display === 'none')
        document.getElementById(ID).style.display = '';
    else
        document.getElementById(ID).style.display = 'none';
    }
    </script>
   
    
</head>
<body>
    <form method="post" action="save_data.php" name="dati_utente">

    
    <div id="tessere" style="border-top: #eee solid thin; ">
        <br>
        <center><b>Seleziona il prodotto: *</b></center>
        <div class="container">
            <div class="column1" style="text-align: center">
                <div>
                   <img src="Skirama.jpg" alt="Skirama" class="immagine" style="min-height: 100px;">
                </div>
                <div class="descrizione">
                    <center>
                    <div class="columns">
                    <ul class="price">
                      <li class="header">Superskirama</li>
                      <li>
                          <div class="tipologia" style="color:black;"><b>ADULTI</b><br>Ski pass a cui può essere associato <br>un BAMBINO ACCOMPAGNATO.</div>
                          <div class="prezzo">€ 640,00</div>
                          <input type="radio" name="tessera" value="1" id="adulti_ss" required class="selezione" onclick="enable('baccompagnati_ss')"/>
                      </li>
                      <li id="sseniores_ss_c">
                          <div class="tipologia"><b>SUPER SENIORES</b> <br>nati prima del 30.11.1942</div>
                          <div class="prezzo">€ 500,00</div>
                          <input type="radio" name="tessera" value="2" id="sseniores_ss" required class="selezione" onclick="disable('baccompagnati_ss', 'baccompagnati_ca')"/>
                      </li>
                      <li id="seniores_ss_c">
                            <div class="tipologia"><b>SENIORES</b> <br> nati prima del 30.11.1952</div>
                          <div class="prezzo">€ 550,00</div>
                          <input type="radio" name="tessera" value="3" id="seniores_ss" required class="selezione" onclick="disable('baccompagnati_ss', 'baccompagnati_ca')"/>
                      </li>
                      <li id="juniores_ss_c">
                           <div class="tipologia"><b>JUNIORES</b> <br>nati dopo il 30.11.2001</div>
                          <div class="prezzo">€ 500,00</div>
                          <input type="radio" name="tessera" value="4" id="juniores_ss" required class="selezione" onclick="disable('baccompagnati_ss', 'baccompagnati_ca')"/>
                      </li>
                      <li id="bambini_ss_c">
                          <div class="tipologia"><b>BAMBINI</b> <br>nati dopo il 30.11.2009</div>
                          <div class="prezzo">€ 210,00</div>
                          <input type="radio" name="tessera" value="5" id="bambini_ss" required class="selezione" onclick="disable('baccompagnati_ss', 'baccompagnati_ca')"/>
                      </li>
                      <li class="height1" id="colore1">
                          <div class="tipologia"><b>BAMBINI ACCOMPAGNATI </b><br>nati dopo il 30.11.2009 <br>qualora il genitore acquisti contestualmente uno <br> skipass “bistagionale Madonna di Campiglio Adulto”</div>
                          <div class="prezzo">Omaggio</div>
                          <input type="radio" name="omaggio" value="6" id="baccompagnati_ss" disabled class="selezione"/>
                      </li>
                    </ul>
                  </div>
                    </center>
                </div>
            </div>
            <div class="column2" style="text-align: center">
                <div>
                    <img src="Campiglio.png" alt="Campiglio" class="immagine" style="max-width: 100px;">
                </div>
                <div class="descrizione">
                    <center>
                    <div class="columns">
                    <ul class="price">
                      <li class="header">Campiglio</li>
                      <li>
                          <div class="tipologia" style="color:black;"><b>ADULTI</b><br>Ski pass a cui può essere associato <br>un BAMBINO ACCOMPAGNATO.</div>
                          <div class="prezzo">€ 640,00</div>
                          <input type="radio" name="tessera" value="7" id="adulti_ca" required class="selezione" onclick="enable('baccompagnati_ca')"/>
                      </li>
                      <li id="sseniores_ca_c">
                          <div class="tipologia"><b>SUPER SENIORES</b> <br>nati prima del 30.11.1942</div>
                          <div class="prezzo">€ 500,00</div>
                          <input type="radio" name="tessera" value="8" id="sseniores_ca" required class="selezione" onclick="disable('baccompagnati_ss', 'baccompagnati_ca')"/>
                      </li>
                      <li id="seniores_ca_c">
                          <div class="tipologia"><b>SENIORES</b> <br> nati prima del 30.11.1952</div>
                          <div class="prezzo">€ 550,00</div>
                          <input type="radio" name="tessera" value="9" id="seniores_ca" required class="selezione" onclick="disable('baccompagnati_ss', 'baccompagnati_ca')"/>
                      </li>
                      <li id="juniores_ca_c">
                          <div class="tipologia"><b>JUNIORES</b> <br>nati dopo il 30.11.2001</div>
                          <div class="prezzo">€ 500,00</div>
                         <input type="radio" name="tessera" value="10" id="juniores_ca" required class="selezione" onclick="disable('baccompagnati_ss', 'baccompagnati_ca')"/>
                      </li>
                      <li id="bambini_ca_c">
                          <div class="tipologia"><b>BAMBINI</b> <br>nati dopo il 30.11.2009</div>
                          <div class="prezzo">€ 210,00</div>
                          <input type="radio" name="tessera" value="11" id="bambini_ca" required class="selezione" onclick="disable('baccompagnati_ss', 'baccompagnati_ca')"/>
                      </li>
                      <li class="height1" id="colore2">
                          <div class="tipologia"><b>BAMBINI ACCOMPAGNATI</b><br>nati dopo il 30.11.2009 <br>qualora il genitore acquisti contestualmente uno <br> skipass “bistagionale Madonna di Campiglio Adulto”</div>
                          <div class="prezzo">Omaggio</div>
                          <input type="radio" name="omaggio" value="12" id="baccompagnati_ca" disabled class="selezione"/>
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
    <section class="firstSection" style="margin-bottom: 5px; float: left; margin-left: 60px;">
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
        <input class="input" name="nome" id="nome" type="text" required  pattern="[a-zA-z]+">
    </fieldset>  
    <fieldset>
        <label>Cognome *</label>
        <input class="input" name="cognome" id="cognome" type="text" required  pattern="[a-zA-z]+">
    </fieldset>	
    <fieldset>
        <label>Data di nascita *</label>
        <input class="input" type="date" id="data_nascita" name="data_nascita" placeholder="DD-MM-YYYY" required min="1920-01-01" max="2017-01-01" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])([-/])(0[1-9]|1[012]|[0-9])([-/])[0-9]{4}" style="font-family: Verdana, sans-serif;" >
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
    
    </section>
    
    <section class="firstSection" style="float: right; margin-right: 60px;">
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
            <input class="input" name="fax" id="fax" type="text"value="<?php if (isset($_SESSION['fax'])&& $_SESSION['fax'] <> '') {    echo $_SESSION['fax'];}?>"/>
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
        <center>
        <input type="checkbox">sono i dati di chi paga?
        </center>
</section>

    <input type="submit" class="bottone" onclick="chgAction('save_data.php')" value="Aggiungi un altro skipass">
    
</form>
    
    
    <section class="firstSection">
        <ul class="price">
        <li class="header">Foto</li>
    </ul>
        <p class="note">La foto deve rappresentare il soggetto che andrà ad utilizzare lo skipass in modo chiaro, centrata sul viso.</p>
        <button onclick='mostra("mostra_camera")'> webcam</button>
        <input id="image" type="image" alt="Login">
        <div id='mostra_camera' style='display:none;'>      
<div class="camcontent">
    <video id="video" autoplay></video>
    <canvas id="canvas" width="640" height="480"> </canvas>
</div>
<div class="cambuttons">
    <button id="snap" style="display:none;">  Capture </button>
    <button id="reset" style="display:none;">  Reset  </button>
    <button id="upload" style="display:none;"> Upload </button>
    <br> <span id=uploading style="display:none;"> Uploading has begun . . .  </span>
    <span id=uploaded  style="display:none;"> Success, your photo has been uploaded!</span>
</div>
        </div>
    </section>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
    // Put event listeners into place
    window.addEventListener("DOMContentLoaded", function() {
        // Grab elements, create settings, etc.
        var canvas = document.getElementById("canvas"),
            context = canvas.getContext("2d"),
            video = document.getElementById("video"),
            videoObj = { "video": true },
            image_format= "jpeg",
            jpeg_quality= 85,
            errBack = function(error) {
                console.log("Video capture error: ", error.code);
            };


        // Put video listeners into place
        if(navigator.getUserMedia) { // Standard
            navigator.getUserMedia(videoObj, function(stream) {
                //video.src = stream;
                video.srcObject = stream;
                video.play();
                $("#snap").show();
            }, errBack);
        } else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
            navigator.webkitGetUserMedia(videoObj, function(stream){
                video.src = window.webkitURL.createObjectURL(stream);
                video.play();
                $("#snap").show();
            }, errBack);
        } else if(navigator.mozGetUserMedia) { // moz-prefixed
            navigator.mozGetUserMedia(videoObj, function(stream){
                video.src = window.URL.createObjectURL(stream);
                video.play();
                $("#snap").show();
            }, errBack);
        }
        // video.play();       these 2 lines must be repeated above 3 times
        // $("#snap").show();  rather than here once, to keep "capture" hidden
        //                     until after the webcam has been activated.

        // Get-Save Snapshot - image
        document.getElementById("snap").addEventListener("click", function() {
            context.drawImage(video, 0, 0, 640, 480);
            // the fade only works on firefox?
            $("#video").fadeOut("slow");
            $("#canvas").fadeIn("slow");
            $("#snap").hide();
            $("#reset").show();
            $("#upload").show();
        });
        // reset - clear - to Capture New Photo
        document.getElementById("reset").addEventListener("click", function() {
            $("#video").fadeIn("slow");
            $("#canvas").fadeOut("slow");
            $("#snap").show();
            $("#reset").hide();
            $("#upload").hide();
        });
        // Upload image to sever
        document.getElementById("upload").addEventListener("click", function(){
            var dataUrl = canvas.toDataURL("image/jpeg", 0.85);
            $("#uploading").show();
            $.ajax({
                type: "POST",
                url: "caricamento_immagine.php",
                data: {
                    imgBase64: dataUrl,
                    user: "Joe",
                userid: 25
        }
        }).done(function(msg) {
                console.log("saved");
                $("#uploading").hide();
                $("#uploaded").show();
            });
        });
    }, false);

</script>
    
    
    
    
    <section class="firstSection" style="width: 60%;">
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
        
            <button class="bottone" onclick="chgAction('my_upload.php')" value="submit2">Concludi Ordine</button>
            </center>
</form>
    </body>
</html>
