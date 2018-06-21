<?php
session_start();
// ====================================================================
// =          importazione classi di riferimento                      =
// ====================================================================
require('IGFS_CG_API/init/IgfsCgInit.php');
// ====================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $importo_totale = htmlspecialchars($_POST["importo_totale"]);
            $email = htmlspecialchars($_POST["email"]);
            $ID_ordine = htmlspecialchars($_POST["ID_ordine"]);
            $azione = htmlspecialchars($_POST["azione"]);
            
}
$shopID = uniqid("shopID-$ID_ordine-");

if(isset($_SESSION["email"])) {
    unset ($_SESSION["email"]);
    $_SESSION["email2"] = $email;
}
else {
    $_SESSION["email2"] = $email;
}

//url dove si trovano i file di gestione del pagamento.
$siteUrl = 'https://www.funiviemadonnacampiglio.it/onlinesale/igfs-payment-gateway-master/';

if($_POST) {

		include_once(dirname(__FILE__) ."/igfs.php");
		$PayObj = new Igfs();
		$PayObj->IgfsNotifyURL = $siteUrl . 'notify.php';
		$PayObj->IgfsErrorURL  = $siteUrl . 'error.php';
                
                

		$paymentData = array();
		$paymentData['cart_id'] = $shopID;
		$paymentData['amount'] = $importo_totale;
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


?>