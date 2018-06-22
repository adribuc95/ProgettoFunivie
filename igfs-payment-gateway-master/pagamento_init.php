<!--
////////////////////////////////
AUTHOR: @ADRIANO BUCELLA
adribuc95@gmail.com
///////////////////////////////
-->
<!--FILE CHE VA AD INIZIALIZZARE I VARI DATI PER IL PAGAMENTO-->

<?php
session_start();

// =          importazione classi di riferimento                      =
// ====================================================================
require('IGFS_CG_API/init/IgfsCgInit.php');
// ====================================================================

//RECUPERO I DATI NASCOSTI IN RIEPILOGO ORDINE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $email = htmlspecialchars($_POST["email"]);
            $stringa = htmlspecialchars($_POST["eojneiofneor"]);
            $azione = htmlspecialchars($_POST["azione"]);
            $importo = htmlspecialchars($_POST["wee"]);
            $ID_ordine = $_SESSION["ID_ordine"];
            
}

//

$result = $stringa/$ID_ordine;

if ($result == $importo) {
    
    echo "controllo superato";

//CALCOLO LO SHOP ID --> VA A RAPPRESENTARE UN ORDINE IN MODO UNIVOCO.
$shopID = uniqid("shopID-$ID_ordine-");

//GESTISCO SU QUALE EMAIL SPEDIRE LE MAIL DI CONFERMA
if(isset($_SESSION["email"])) {
    unset ($_SESSION["email"]);
    $_SESSION["email2"] = $email;
}
else {
    $_SESSION["email2"] = $email;
}

//url dove si trovano i file di gestione del pagamento.
$siteUrl = 'https://www.funiviemadonnacampiglio.it/onlinesale/igfs-payment-gateway-master/';

//INIZIALIZZO PAGAMENTO --> VADO IN IGFS.PHP
if($_POST) {

		include_once(dirname(__FILE__) ."/igfs.php");
		$PayObj = new Igfs();
		$PayObj->IgfsNotifyURL = $siteUrl . 'notify.php';
		$PayObj->IgfsErrorURL  = $siteUrl . 'error.php';
                
		$paymentData = array();
		$paymentData['cart_id'] = $shopID;
		$paymentData['amount'] = $result;
                $paymentData['email'] = $email;
                $paymentData['ID_ordine'] = $ID_ordine;
                
                if($azione == 'bonifico') {
                    $paymentData['metodo'] = 'UNI_MYBK';
                }
                else {
                    $paymentData['metodo'] = 'UNI_ECOM';
                }
                
		$PayObj->processPayment($paymentData);
}
}
else {
    echo "controllo NON superato";
    header("location: error.php");
}
?>