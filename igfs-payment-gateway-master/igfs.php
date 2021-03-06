<?php
/**
 * Name : IGFS Payment Gateway (UniCredit)
 * Ver : 1.0
 * Author : RaviSaxena2006
 * Release :  April 2015
 */
include_once(dirname(__FILE__) ."/IGFS_CG_API/init/IgfsCgInit.php");


class Igfs 
{
	public $ssl = true;	
	public $testmode = false;	
	public $testurl = 'https://testuni.netsw.it/UNI_CG_SERVICES/services';
	public $liveurl = 'https://testeps.netswgroup.it/UNI_CG_SERVICES/services'; //'https://pagamenti.unicredit.it/UNI_CG_SERVICES/services'
	public $IgfsNotifyURL = '';
	public $IgfsErrorURL = '';
	public $IgfsTimeout = 30000;
	public $IgfsTreminalId = '';//
	public $IgfsApikSig = 'UNI_TESTKEY';
	public $IgfsShopUserRef = 'UNIBO'; //3055296
	public $IgfsCurrencyCode = 'EUR'; //ISO
	public $IgfsLangID = 'IT'; //ISO
	
    function __construct() {
		//parent::__construct();
	}
	
	public function processPayment($paymentData = array()){
	
	    
			$init = new IgfsCgInit();
                        
			
			if($this->testmode==true){
				$init->serverURL = $this->testurl; 
				$init->disableCheckSSLCert();				
			}else{
				$init->serverURL = $this->liveurl;
			}
			
			$this->setCookiesValue('cart_id',$paymentData['cart_id']);
                        
			
			$init->timeout 		= $this->IgfsTimeout;			
			$init->tid              = $paymentData["metodo"];
			$init->kSig 		= $this->IgfsApikSig;
			$init->shopID 		= $paymentData['cart_id'];
			$init->shopUserRef 	= $paymentData['email'];
			$init->trType = "PURCHASE";
			$init->currencyCode = $this->IgfsCurrencyCode;//iso_code;
                        
			$init->amount = $paymentData['amount']*100;
			$init->langID = $this->IgfsLangID; //per italiano: "IT"
                        
			$init->notifyURL = $this->IgfsNotifyURL;
			$init->errorURL = $this->IgfsErrorURL;
			
			if(!$init->execute()){
			//assign error 
			//header("location: error.php");
			}else{
			//redirect to success page.
			$payment_id = $init->paymentID;
			$this->setCookiesValue('payment_id',$payment_id);
                        $this->setCookiesValue('ID_ordine',$paymentData['ID_ordine']);
                        $this->setCookiesValue('data', date("Y/m/d"));
                        $this->setCookiesValue('importo_totale', $paymentData['amount']);
                        $this->setCookiesValue('email', $paymentData['email']);
                        $this->setCookiesValue('metodo',$paymentData['metodo']);
			header("location: ".$init->redirectURL);
                        
                        
                        
			}
			
			
	
	}
	
	
	
	function verifyPayment(){
	
	include_once(dirname(__FILE__) ."/IGFS_CG_API/init/IgfsCgVerify.php");
		$verify = new IgfsCgVerify();
		$payment_id =  $this->getCookiesValue('payment_id');
		$cart_id =$this->getCookiesValue('cart_id');
                $_SESSION["shop_ID"] = $cart_id;
                $ID_ordine=$this->getCookiesValue('ID_ordine');
                $data=$this->getCookiesValue('data');
                $importo_totale=$this->getCookiesValue('importo_totale');
                $email=$this->getCookiesValue('email');
                $metodo = $this->getCookiesValue('metodo');
		if($payment_id) { 
				
				if($this->testmode==true){
					$verify->serverURL = $this->testurl; 
					$verify->disableCheckSSLCert();
				}else{
					$verify->serverURL = $this->liveurl; 
				}

				$verify->timeout = $this->IgfsTimeout;		
				$verify->tid = $metodo;
				$verify->kSig = $this->IgfsApikSig;
				$verify->shopID = $cart_id;
				$verify->paymentID = $payment_id;
                                
				
				if ($verify->execute()){
                                    
                                    //salvo nel DB
                        
                        $servername = "localhost";
                        $username = "onlinesales";
                        $password = "Sale0nl1nE";
                        $dbname = "fmc-db-onlinesales";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        } 

                        $sql = " INSERT INTO `Pagamento` (`ID_pagamento`, `ID_shop`, `ID_ordine`, `email_riferimento`, `importo`, `data_pagamento`, `esito`)"
                        ."VALUES ('$payment_id', '$verify->shopID', '$ID_ordine', '$email',  '$importo_totale', '$data',  'POSITIVO');";


                        if (($conn->query($sql) === TRUE)) {
                            
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }

                        $conn->close();
                        
                        
                        
                        //fine
					$this->deleteCookiesValue('payment_id');
					return $verify->paymentID;
				}
		}
	
	return false;
	
	}
	
	
	protected function getCookiesValue($key=null){
			
			if(isset($_COOKIE[$key])){
				return $_COOKIE[$key];
			}
			else{
				return false;
			}		
	
	}	

	protected function setCookiesValue($cookie_name=null,$cookie_value=null){
	
				if($cookie_value!=null){				
						setcookie($cookie_name, $cookie_value, time() + (3600 * 30), "/"); // 3600 = 1 hour
				}
	}
	
	public function deleteCookiesValue($key=null){	     
		setcookie($key, "", time() - (8400 * 30), "/"); // 3600 = 1 hour	
	}
	
	
	
	
	
}