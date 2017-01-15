<?php
require_once('../vendor/autoload.php');
use ATLPay\ATLPay;
use ATLPay\Charge;
try{
	ATLPay::setApiKey("YOUR API KEY");
	ATLPay::setSSLVerify(false);
	$chargeObject	=	new Charge();
	//Partial Refund
	$refunded	=	$chargeObject->refund("ATLPAY TRANSACTION ID", "AMOUNT OF PARTIAL REFUND IN INTEGER");
	if($refunded){
		echo "Success : Refund is processed";
	}else{
		echo "Error : ".$refunded;
	}
	
	//Full Refund
	/*$refunded	=	$chargeObject->refund("Z2017011458178");
	if($refunded){
		echo "Success : Refund is processed";
	}else{
		echo "Error : ".$refunded;
	}*/
}catch(Exception $e){
	echo $e->getMessage();
}