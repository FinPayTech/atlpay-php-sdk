<?php
require_once('../vendor/autoload.php');
use ATLPay\ATLPay;
use ATLPay\Charge;
try{
	ATLPay::setApiKey("YOUR API KEY");
	ATLPay::setSSLVerify(false);
	$chargeObject	=	new Charge();
	try{
		$txnCode		=	strtoupper(uniqid());
		$chargeObject->setOrderCode("YOUR CARD IT OR ORDER CODE");
		$chargeObject->setOrderDescription("DESCRIPTION FOR ORDER {REQUIRED}");
		$chargeObject->setSuccessReturnUrl("LEAVE EMPTY OR VALID URL");
		$chargeObject->setFailureReturnUrl("LEAVE EMPTY OR VALID URL");
		$chargeObject->setCancelReturnUrl("LEAVE EMPTY OR VALID URL");
		$chargeObject->setCallbackUrl("LEAVE EMPTY OR VALID URL");
		$chargeObject->setNotificationUrl("LEAVE EMPTY OR VALID URL");
		$chargeObject->setEmail("CUSTOMER's EMAIL ADDRESS");
		$chargeObject->setCurrency("CURRENCY CODE ISO 3");
		$chargeObject->setAmount("AMOUNT IN INTEGER");
		$chargeObject->setBillingAddress("Address Line 1", "Address Line 2", "City", "State", "Postal Code", "COUNTRY ISO 2 CODE");
		$chargeObject->setDeliveryDetails("FName", "LName", "Address 1", "Address 2", "City", "State", "Postal Code", "COUNTRY ISO 2 CODE", "Mobile", "Phone");
		$chargeObject->initPayment();
		if($chargeObject->isChargeCreated()){
			echo "Order ID : ".$chargeObject->getTransactionId(); echo "<br />";
			echo "Payment URL : ".$chargeObject->getPaymentUrl(); // Redirect the user to this url for completing payment
		}else{
			echo "Last Error : ".$chargeObject->getLastError();
		}
	}catch(\Exception $e){
		echo $e->getMessage();
	}
}catch(\Exception $e){
	echo $e->getMessage();
}
?>