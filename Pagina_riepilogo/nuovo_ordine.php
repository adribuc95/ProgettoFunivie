<?php

session_start();
distruggiSessione();

header("location: https://www.funiviemadonnacampiglio.it/onlinesale/");

 function distruggiSessione() {
     session_unset();
    unset($_SESSION['ID_ordine']);
    unset($_SESSION['prima_volta']);
    
    echo "session destroyed";
     
 }
