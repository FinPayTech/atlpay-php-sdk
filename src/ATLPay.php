<?php 
namespace ATLPay;
class ATLPay
{
	
	public static $apiEndPoint	=	'https://api.atlpay.com/v1';
	public static $apiKey	=	null;
	public static $verifySSL	=	true;
	
	public function __construct($apiKey = null){
		if($apiKey){
			try{
				$this->setApiKey($apiKey);
			}catch(\Exception $e){
				throw new \Exception($e->getMessage());
			}			
		}
	}
	
	public static function setSSLVerify($verifySSL){
		self::$verifySSL	=	$verifySSL;
	}
	
	public static function setApiKey($apiKey){
		if($apiKey){
			self::$apiKey	=	$apiKey;
		}else{
			throw new \Exception("Empty API Key.");
		}
	}
	
	public function getApiKey(){
		return self::$apiKey;
	}
	
}
?>