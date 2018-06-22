<?php
session_start();
include_once(dirname(__FILE__) ."/igfs.php");
include_once(dirname(__FILE__) ."/emails.php");

$email = new Email();
$PayObj = new Igfs();
$payment_id = $PayObj->verifyPayment();
$ID_ordine = $_SESSION["ID_ordine"];

//se esito pagamento positivo
if($payment_id){

    //esporto dati per salvarli nel database SKIDATA
    $email->emailDati("adribuc95@gmail.com", $ID_ordine); //mettere mail che si vuole. (ADMIN)
    
    //email riepilogo UTENTE
    $email->emailRiepilogo($_SESSION["email2"], $ID_ordine);
    

    //pagina pagamento andato a buon fine.
    echo "<html>
        <head>
            <title>TODO supply a title</title>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
            <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'> 
            <link href='../Pagina_iniziale/CSS/CSS.css' rel='stylesheet' type='text/css'>
            <script>
    window.setTimeout(function() {
        document.getElementById('sleep').style.display = '';
    }, 3000);
    </script>
        </head>
        <body>
        <center>
            <i class='fa fa-check' style='font-size:90px; color: green; margin-top: 20px;'></i> <br>
            <h1 style='color: green; font-size: 70px;'>Grazie!</h1>
            <p style='font-size: 25px;'>Il tuo ordine è andato a buon fine! Verrai reindirizzato alla Homepage... <br> A breve riceverai una mail di conferma. <br> 
            </p>
            <p style='font-size: 15px;'>(Se non la visualizzi, controlla tra la posta indesiderata)</p>
            <a id='sleep' href='../index.php'><p style='font-size: 15px;'>Ritorna alla Homepage</p></a>
        </center>
        </body>
    </html>";
    //elimina sessione
    distruggiSessione();
    
    //reindirizza alla homepage
    header("refresh:10; url= ../index.php");
    exit();

}
//se esito negativo, rimanda a pagina error.php
else{
header("location: error.php");
exit();
}

//funzione che elimina le variabili di sessione e permette un nuovo ordine.
function distruggiSessione() {
    unset($_SESSION["ID_ordine"]);
    unset($_SESSION["prima_volta"]);
    unset($_SESSION["numero_riferimento"]);
    session_unset();
 }