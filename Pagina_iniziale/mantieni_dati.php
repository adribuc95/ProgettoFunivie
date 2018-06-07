<?php

        
    header("location: https://www.funiviemadonnacampiglio.it/onlinesale/");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = htmlspecialchars($_POST["nome"]);
            
            $cognome = htmlspecialchars($_POST["cognome"]);
            
            $indirizzo = htmlspecialchars($_POST["indirizzo"]);
            $city = htmlspecialchars($_POST["city"]);
            $cap = htmlspecialchars($_POST["CAP"]);
            
            $telefono = htmlspecialchars($_POST["telefono"]);
            $fax = htmlspecialchars($_POST["fax"]);
            $cellulare = htmlspecialchars($_POST["cellulare"]);
            $email = htmlspecialchars($_POST["email"]);
            $sito = htmlspecialchars($_POST["sito"]);
            $commenti = htmlspecialchars($_POST["commenti"]);
            
            
            $_SESSION['nome'] = $nome;
            $_SESSION['cognome'] = $cognome;
            $_SESSION['indirizzo'] = $indirizzo;
            $_SESSION['CAP'] = $cap;
            $_SESSION['city'] = $city;
            $_SESSION['cellulare'] = $cellulare;
            $_SESSION['telefono'] = $telefono;
            $_SESSION['fax'] = $fax;
            $_SESSION['email'] = $email;
            $_SESSION['sito'] = $sito;
            $_SESSION['commenti'] = $commenti;
    }
        