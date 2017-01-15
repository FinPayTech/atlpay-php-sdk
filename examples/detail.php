<?php
require_once('../vendor/autoload.php');
use ATLPay\ATLPay;
use ATLPay\TransactionObject;
try{
	ATLPay::setApiKey("YOUR API KEY");
	ATLPay::setSSLVerify(false);
	$transaction	=	new TransactionObject("ATL PAY TRANSACTION ID");
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