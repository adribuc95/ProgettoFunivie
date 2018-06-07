<?php

session_start();

distruggiSessione();

header("location: https://www.funiviemadonnacampiglio.it/onlinesale/");

 function distruggiSessione() {
     session_unset();
    
    echo "session destroyed";
     
 }
