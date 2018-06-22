<!--
////////////////////////////////
AUTHOR: @ADRIANO BUCELLA
adribuc95@gmail.com
///////////////////////////////
-->
<!--FILE CHE VA A DISTRUGGERE LA SESSIONE PER INIZIARE UN NUOVO ORDINE E REINDERIZZA ALL'INDEX-->
<?php

session_start();
distruggiSessione();

header("location: ../index.php");
exit();

 function distruggiSessione() {
    unset($_SESSION["ID_ordine"]);
    unset($_SESSION["prima_volta"]);
    unset($_SESSION["numero_riferimento"]);
    session_unset();
    
    echo "session destroyed";
     
 }
