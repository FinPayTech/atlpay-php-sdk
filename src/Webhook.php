<?php
namespace ATLPay;
class Webhook extends TransactionObject{
	//Will Return a Transaction Object
	public function __construct($postedData = []){
		try{
			parent::__construct(@$postedData["atlpay_txn_id"]);
		}catch(\Excpetion $e){
			throw new \Exception($e->getMessage());
		}
	}
}
?>