<?php

session_start();
distruggiSessione();

header("../index.php");
exit();

 function distruggiSessione() {
    unset($_SESSION["ID_ordine"]);
    unset($_SESSION["prima_volta"]);
    unset($_SESSION["numero_riferimento"]);
    session_unset();
    
    echo "session destroyed";
     
 }
