<?php
$vendorDir	=	 dirname(dirname(dirname(dirname(__FILE__))));
require_once($vendorDir.DIRECTORY_SEPARATOR."autoload.php");
use ATLPay\ATLPay;
use ATLPay\Webhook;
try{
	ATLPay::setApiKey("YOUR API KEY HERE");
	ATLPay::setSSLVerify(false);
	$transaction	=	new Webhook($_POST);	//Pass $_POST here
	$outputFunctions	=	[
		'getOrderCode',
		'getTransactionId',
		'getFundingType',
		'getLast4Digits',
		'getMaskedCard',
		'getCardType',
		'getCardBrand',
		'getIssuerBank',
		'getFailureReason',
		'getStatus',
		'getCurrencyCode',
		'getFees',
		'getCartAmount',
		'getIssuerCountry',
		'getStatementDescriptor',
		'getLogs',
		'getLastLog',
		'getRefunds',
	];
	foreach($outputFunctions as $func){
		$value	=	$transaction->$func();
		if(is_array($value)){
			echo $func.'<br />';
			echo '<pre>';
			print_r($value);
			echo '</pre>';
		}else{
			echo $func.': '.$value.'<br />';
		}
	}
}catch(Exception $e){
	echo $e->getMessage();
}