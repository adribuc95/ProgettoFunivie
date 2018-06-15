<?php
session_start();
include_once(dirname(__FILE__) ."/igfs.php");
$PayObj = new Igfs();
$payment_id = $PayObj->verifyPayment();
if($payment_id){
echo "<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'> 
        <link href='../Pagina_iniziale/CSS/CSS.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
    <center>
        <i class='fa fa-check' style='font-size:90px; color: green; margin-top: 20px;'></i> <br>
        <h1 style='color: green; font-size: 70px;'>Grazie!</h1>
        <p style='font-size: 25px;'>Il tuo ordine è andato a buon fine! Verrai reindirizzato alla Homepage... <br> A breve riceverai una mail di conferma.
        </p>
    </center>
    </body>
</html>";
distruggiSessione();
header("refresh:3; url= https://www.funiviemadonnacampiglio.it/");

}else{
header("location: https://www.funiviemadonnacampiglio.it/onlinesale/igfs-payment-gateway-master/error.php");
}


function distruggiSessione() {
     session_unset();
    unset($_SESSION['ID_ordine']);
    unset($_SESSION['prima_volta']);
     
 }