<?php
// ====================================================================
// =          importazione classi di riferimento                      =
// ====================================================================
require('IGFS_CG_API/init/IgfsCgInit.php');
// ====================================================================
// = impostazione parametri per l’inizializzazione richiesta di       =
// = pagamento.                                                       =
// = NB: I parametri riportati sono solo a titolo di esempio          =
// ====================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $importo_totale = htmlspecialchars($_POST["importo_totale"]);
            $email = htmlspecialchars($_POST["email"]);
            $ID_ordine = htmlspecialchars($_POST["ID_ordine"]);
            
}
$shopID = uniqid("shopID");

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
		$PayObj->processPayment($paymentData);
		

}


?>