<?php 
namespace ATLPay;
use Respect\Validation\Validator as v;
use \GuzzleHttp\Client;
class Charge{
	
	public $email					=	null;
	public $billingAddressLine1		=	null;
	public $billingAddressLine2		=	null;
	public $billingCity				=	null;
	public $billingState			=	null;
	public $billingPostalCode		=	null;
	public $billingCountryCode		=	null;
	public $currencyCode			=	null;
	public $amount					=	null;
	public $orderDescription		=	null;
	public $orderCode				=	null;
	public $successReturnUrl		=	null;
	public $failureReturnUrl		=	null;
	public $cancelReturnUrl			=	null;
	public $callBackUrl				=	null;
	public $notificationUrl			=	null;
	public $delivereeFirstName		=	null;
	public $delivereeLastName		=	null;
	public $delivereeAddressLine1	=	null;
	public $delivereeAddressLine2	=	null;
	public $delivereeCity			=	null;
	public $delivereeState			=	null;
	public $delivereePostalCode		=	null;
	public $delivereeCountryCode	=	null;
	public $delivereeMobile			=	null;
	public $delivereePhone			=	null;
	private $isChargeCreated		=	false;
	private $transactionId			=	null;
	private $paymentUrl				=	null;
	private	$lastError				=	null;
	
	public function __construct($options = []){
		
	}
	
	//Setter function for setting order code
	//params string $orderCode
	//returns 
	public function setOrderCode($orderCode){
		if(v::stringType()->validate($orderCode)){
			$this->orderCode	=	$orderCode;
		}
	}
	//Setter function for setting order description
	//params string $orderDescription
	//returns none or throws exception on failure
	public function setOrderDescription($orderDescription){
		if(v::stringType()->notEmpty()->validate($orderDescription)){
			$this->orderDescription	=	$orderDescription;
		}else{
			throw new \Exception("EMPTY/INVALID ORDER DESCRIPTION");
		}
	}
	//Setter function for setting payment success return url eg. http://your-domain.com/thank-you/your-order-code
	//The customer will be redirected to this url once payment is sucessful. 
	//However you should not rely on this url for payment status but listen to notifications.
	//params url(string) $successReturnUrl
	//returns none or throws exception on failure
	public function setSuccessReturnUrl($successReturnUrl){
		if($successReturnUrl){
			if(v::url()->validate($successReturnUrl)){
				$this->successReturnUrl	=	$successReturnUrl;
			}else{
				throw new \Exception("INVALID SUCCESS RETURN URL");
			}
		}
	}
	//Setter function for setting payment failure return url eg. http://your-domain.com/failed/your-order-code
	//The customer will be redirected to this url once payment is failed. 
	//However you should not rely on this url for payment status but listen to notifications.
	//params url(string) $failureReturnUrl
	//returns none or throws exception on failure
	public function setFailureReturnUrl($failureReturnUrl){
		if($failureReturnUrl){
			if(v::url()->validate($failureReturnUrl)){
				$this->failureReturnUrl	=	$failureReturnUrl;
			}else{
				throw new \Exception("INVALID FAILURE RETURN URL");
			}
		}
	}
	//Setter function for setting payment cancel return url eg. http://your-domain.com/cancelled/your-order-code
	//The customer will be redirected to this url once payment is cancelled by the customer. 
	//However you should not rely on this url for payment status but listen to notifications.
	//params url(string) $cancelReturnUrl
	//returns none or throws exception on failure
	public function setCancelReturnUrl($cancelReturnUrl){
		if($cancelReturnUrl){
			if(v::url()->validate($cancelReturnUrl)){
				$this->cancelReturnUrl	=	$cancelReturnUrl;
			}else{
				throw new \Exception("INVALID CANCEL RETURN URL");
			}
		}
	}
	//Setter function for setting callback url eg. http://your-domain.com/callback-handler/your-order-code
	//ATL Pay will send PUSH Notification to this URL for Final Confirmation for Processing Transaction
	//This URL should Return one of followings
	//1. HTTP STATUS 200 with URL in BODY 
	//			IF URL is returned then payment will be cancelled and customer will be redirected to this url, 
	// 			where you can explain to this customer about reason for calling back
	//2. HTTP STATUS 200 without URL or BODY
	//			Payment will continue, this is approval to ATLPay to process the payment
	//3. NON 200 HTTP STATUS
	//			Payment will be rejected and customer will be redirected to failure return url if provided
	//params url(string) $callBackUrl
	//returns none or throws exception on failure
	public function setCallbackUrl($callBackUrl){
		if($callBackUrl){
			if(v::url()->validate($callBackUrl)){
				$this->callBackUrl	=	$callBackUrl;
			}else{
				throw new \Exception("INVALID CALLBACK URL");
			}
		}
	}
	//Setter function for setting payment notification url eg. http://your-domain.com/payment-notification/your-order-code
	//You should listen to this URL for payment related updates.
	//params url(string) $callBackUrl
	//returns none or throws exception on failure
	public function setNotificationUrl($notificationUrl){
		if($notificationUrl){
			if(v::url()->validate($notificationUrl)){
				$this->notificationUrl	=	$notificationUrl;
			}else{
				throw new \Exception("INVALID NOTIFICATION URL");
			}
		}
	}
	//Setter function to set customer email address
	//params email(string) $email
	//returns none or throws exception on failure
	public function setEmail($email){
		if($email){
			if(v::email()->validate($email)){
				$this->email	=	$email;
			}else{
				throw new \Exception("INVALID EMAIL ADDRESS");
			}
		}
	}
	//Setter function to set charge currency
	//params char[3] $currencyCode
	//returns none or throws exception on failure
	public function setCurrency($currencyCode){
		if(v::currencyCode()->validate($currencyCode)){
			$this->currencyCode	=	$currencyCode;
		}else{
			throw new \Exception("INVALID CURRENCY CODE");
		}
	}
	//Setter function to set charge amount
	//params int $amount
	//returns none or throws exception on failure
	public function setAmount($amount){
		if(v::intVal()->notEmpty()->min(0)->validate($amount)){
			$this->amount	=	$amount;
		}else{
			throw new \Exception("INVALID AMOUNT");
		}
	}
	//Setter function to set billing address of customer
	//params 
	//		string $line1
	//		string $line2
	//		string $city
	//		string $state
	//		string $postalCode
	//		char[2] $countryCode
	//returns none
	public function setBillingAddress($line1, $line2, $city, $state, $postalCode, $countryCode){
		$this->billingAddressLine1	=	$line1;
		$this->billingAddressLine2	=	$line2;
		$this->billingCity			=	$city;
		$this->billingState			=	$state;
		$this->billingPostalCode	=	$postalCode;
		$this->billingCountryCode	=	$countryCode;
	}
	//Setter function to set delivery details
	//params 
	//		string $first_name
	//		string $last_name
	//		string $line1
	//		string $line2
	//		string $city
	//		string $state
	//		string $postalCode
	//		char[2] $countryCode
	//		string $mobile
	//		string $phone
	//returns none
	public function setDeliveryDetails($first_name, $last_name, $line1, $line2, $city, $state, $postalCode, $countryCode, $mobile, $phone){
		$this->delivereeFirstName		=	$first_name;
		$this->delivereeLastName		=	$last_name;
		$this->delivereeAddressLine1	=	$line1;
		$this->delivereeAddressLine2	=	$line2;
		$this->delivereeCity			=	$city;
		$this->delivereeState			=	$state;
		$this->delivereePostalCode		=	$postalCode;
		$this->delivereeCountryCode		=	$countryCode;
		$this->delivereeMobile			=	$mobile;
		$this->delivereePhone			=	$phone;
		
	}
	//Checks if Charge is created on ATLPay
	//Returns Boolean
	public function isChargeCreated(){
		return $this->isChargeCreated;
	}
	//Returns Payment URL, Customer needs to be redirected to returned url to complete payment.
	//Returns String URL
	public function getPaymentUrl(){
		return $this->paymentUrl;
	}
	//Returns Transaction ID
	//Returns String Transaction ID
	public function getTransactionId(){
		return $this->transactionId;
	}
	//Returns Last Error in Error List
	//Returns String Last Error Message
	public function getLastError(){
		return $this->lastError;
	}
	//Initilitalizes the Payment
	//Params string $paymentType (CARD OR SOFORT)
	public function initPayment($paymentType = "CARD"){
		$body							=	[];
		$body["type"]					=	$paymentType;
		$body["amount"]					=	$this->amount;
		$body["currency_code"]			=	$this->currencyCode;
		$body["description"]			=	$this->orderDescription;
		$body["success_return"]			=	$this->successReturnUrl;
		$body["cancel_return"]			=	$this->cancelReturnUrl;
		$body["failure_return"]			=	$this->failureReturnUrl;
		$body["callback_url"]			=	$this->callBackUrl;
		$body["txn_reference"]			=	$this->orderCode;
		$body["notification_url"]		=	$this->notificationUrl;
		$body["billing_address_1"]		=	$this->billingAddressLine1;
		$body["billing_address_2"]		=	$this->billingAddressLine2;
		$body["billing_city"]			=	$this->billingCity;
		$body["billing_state"]			=	$this->billingState;
		$body["billing_postal_code"]	=	$this->billingPostalCode;
		$body["billing_country_code"]	=	$this->billingCountryCode;
		$body["delivery_first_name"]	=	$this->delivereeFirstName;
		$body["delivery_last_name"]		=	$this->delivereeLastName;
		$body["delivery_address_1"]		=	$this->delivereeAddressLine1;
		$body["delivery_address_2"]		=	$this->delivereeAddressLine2;
		$body["delivery_city"]			=	$this->delivereeCity;
		$body["delivery_state"]			=	$this->delivereeState;
		$body["delivery_postal_code"]	=	$this->delivereePostalCode;
		$body["delivery_country_code"]	=	$this->delivereeCountryCode;
		$body["delivery_mobile"]		=	$this->delivereeMobile;
		$body["delivery_phone"]			=	$this->delivereePhone;
		$body["email"]					=	$this->email;
		try{
			$client = new Client([
				'connect_timeout'=>5,
			]);
			$response	=	$client->request('POST', ATLPay::$apiEndPoint.'/transactions', [
				'form_params' => $body,
				'headers'=>[
					'ApiKey'=>ATLPay::getApiKey()
				],
				'verify'=>ATLPay::$verifySSL
			]);
			$body = json_decode($response->getBody(), true);
			if($body["httpStatusCode"] == 200){
				$this->isChargeCreated	=	true;
				$this->paymentUrl		=	$body["redirectUrl"];
				$this->transactionId	=	$body["atlpay_txn_id"];
			}else{
				
				$this->isChargeCreated		=	false;
				$this->paymentUrl			=	null;
				$this->transactionId		=	null;
				$this->lastError			=	end(array_values((array)@$body["errors"]));
			}
			
		}catch(\Exception $e){
			$this->isChargeCreated	=	false;
			$this->paymentUrl			=	null;
			$this->transactionId		=	null;
			if($e->getResponse()->getStatusCode() == 403){
				$this->lastError			=	'Authorization Failed. Please check your API Key';
			}else{
				$this->lastError			=	$e->getMessage();
			}
			
		}
		
	}
	//Does partial or full refund
	//Params string $orderId, int $amount
	//Return True or Error Message
	public function refund($orderId, $amount = null){
		
		$body							=	[];
		if($amount){
			$body["amount"]					=	$amount;
		}
		
		try{
			$client = new Client([
				'connect_timeout'=>5,
			]);
			$response	=	$client->request('POST', ATLPay::$apiEndPoint.'/transactions/refund/'.$orderId, [
				'form_params' => $body,
				'headers'=>[
					'ApiKey'=>ATLPay::getApiKey()
				],
				'verify'=>ATLPay::$verifySSL
			]);
			$body = json_decode($response->getBody(), true);
			if($body["httpStatusCode"] == 200){
				return true;
			}else{
				return end(array_values((array)@$body["errors"]));
			}
			
		}catch(\Exception $e){
			if($e->getResponse()->getStatusCode() == 403){
				return	'Authorization Failed. Please check your API Key';
			}else{
				return	$e->getMessage();
			}
			
		}
	}
	
}
?>