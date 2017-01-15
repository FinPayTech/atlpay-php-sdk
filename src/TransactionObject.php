<?php 
namespace ATLPay;
use \GuzzleHttp\Client;
class TransactionObject{
	
	private	$fundingType	=	null;
	private $last4Digits	=	null;
	private	$maskedCard		=	null;
	private	$cardType		=	null;
	private $cardBrand		=	null;
	private $issuerBank		=	null;
	private	$reason			=	null;
	private $status			=	null;
	private $fees			=	null;
	private $amount			=	null;
	private $issuerCountry	=	null;
	private $stmtDescriptor	=	null;
	private $logs			=	[];
	private $refunds		=	[];
	private $currencyCode	=	null;
	private $orderCode		=	null;
	private $txnId			=	null;
	
	
	
	public function __construct($txnId){
		if(!$txnId){
			throw new \Exception("Empty Transaction ID");
		}else{
			try{
				$client = new Client([
					'connect_timeout'=>5,
				]);
				$response	=	$client->request('GET', ATLPay::$apiEndPoint.'/transactions/'.$txnId, [
					'headers'=>[
						'ApiKey'=>ATLPay::getApiKey()
					],
					'verify'=>ATLPay::$verifySSL
				]);
				
				$body = json_decode($response->getBody(), true);
				$this->fundingType		=	$body["funding_type"];
				$this->last4Digits		=	$body["last4_digits"];
				$this->maskedCard		=	$body["masked_card"];
				$this->cardType			=	$body["card_type"];
				$this->cardBrand		=	$body["card_brand"];
				$this->issuerBank		=	$body["issuer_bank"];
				$this->reason			=	$body["reason"];
				$this->status			=	$body["status"];
				$this->fees				=	$body["commission"];
				$this->amount			=	$body["gross_amount"];
				$this->issuerCountry	=	$body["card_country_code"];
				$this->stmtDescriptor	=	$body["statement_descriptor"];
				$this->logs				=	$body["logs"];
				$this->refunds			=	$body["refunds"];
				$this->currencyCode		=	$body["currency_code"];
				$this->orderCode		=	$body["txn_reference"];
				$this->transactionId	=	$body["atlpay_txn_id"];
			}catch(\Exception $e){
				if($e->getResponse()->getStatusCode() == 403){
					throw new \Exception('Authorization Failed. Please check your API Key');
				}else{
					throw new \Exception($e->getMessage());
				}
				
			}
		}
	}
	//Returns Order Code
	//returns string
	public function getOrderCode(){
		return $this->orderCode;
	}
	//Returns ATLPay Transaction ID
	//returns string
	public function getTransactionId(){
		return $this->transactionId;
	}
	//Returns Funding Type
	//returns string
	public function getFundingType(){
		return $this->fundingType;
	}
	//Returns Last 4 Digits or Card or Bank Account
	//returns integer
	public function getLast4Digits(){
		return $this->last4Digits;
	}
	//Returns Masked Card with ***
	//returns string
	public function getMaskedCard(){
		return $this->maskedCard;
	}
	//Returns Card Type
	//returns string
	public function getCardType(){
		return $this->cardType;
	}
	//Returns Card Brand
	//returns string
	public function getCardBrand(){
		return $this->cardBrand;
	}
	//Returns Card Issuer Bank or Bank used for Sofort
	//returns string
	public function getIssuerBank(){
		return $this->issuerBank;
	}
	//Returns Failure Reason if available
	public function getFailureReason(){
		return $this->reason;
	}
	//Returns Currency Code of Order
	//returns string
	public function getCurrencyCode(){
		return $this->currencyCode;
	}
	//Returns Status of Transaction
	//returns string
	public function getStatus(){
		return $this->status;
	}
	//Returns Fees of Transaction
	//returns Integer
	public function getFees(){
		return $this->fees;
	}
	//Returns Actual Cart Amount
	//returns Integer
	public function getCartAmount(){
		return $this->amount;
	}
	//Returns Card Issuer Country or Bank Account Country
	//returns string
	public function getIssuerCountry(){
		return $this->issuerCountry;
	}
	//Returns Statement Descriptor for Card Payments
	//returns string
	public function getStatementDescriptor(){
		return $this->stmtDescriptor;
	}
	//Returns Array of all Logs
	//returns array
	public function getLogs(){
		return $this->logs;
	}
	//Returns Array of Latest Log
	//returns array
	public function getLastLog(){
		$logs	=	(array)$this->logs;
		return end($logs);
	}
	//Returns Array of Refund List
	//returns array
	public function getRefunds(){
		return $this->refunds;
	}
	
}
?>