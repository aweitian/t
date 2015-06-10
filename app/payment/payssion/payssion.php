<?php
/**
 * Date:2015年4月7日
 * Author:Awei.tian
 * Function:
 */
require_once ENTRY_PATH.'/app/interfaces/IPayment.php';
require_once dirname(__FILE__)."/PayssionClient.php";
class payssion implements IPayment{
	private $apikey;//a0082dde5be759d4
	private $merchant_id;//7fafce48b3a12cc51578db6e3903a59c
	private static $_callback_ok   = null;
	private static $_callback_fail = null;
	public $error;
	public function __construct($api_key,$merchant_id){
		$this->apikey = $api_key;
		$this->merchant_id = $merchant_id;
	}
	public function pay($title, $price, $extra){
		$payssion = new PayssionClient($this->apikey, $this->merchant_id);
		$response = null;
		try {
			$response = $payssion->create(array(
				'amount' => $price,
				'currency' => 'USD',
				'description' => $title,
				'pm_id' => $extra["pm_id"],
				'track_id' =>  $extra["track_id"],          //optional, your order id or transaction id
				'sub_track_id' => '2',  //optional
			));
		} catch (Exception $e) {
			//handle exception
			$this->error = $e->getMessage();
			return false;
		}
		if ($payssion->isSuccess()) {
			//handle success
			$todo = $response['todo'];
			if ($todo) {
				$todo_list = explode('|', $todo);
				if (in_array("redirect", $todo_list)) {
					//send payment url by email
					$paylink = $response['redirect_url'];
					return $paylink;
				}else{
					$this->error = "no redirect";
				}
			}else{
				$this->error = "todo is false";
			}
		}else{
			$this->error = "payment is failed";
		}
		return false;
	}
	public function notify($ok_callback,$fail_callback){
		header('HTTP/1.1 200 OK');
		$api_key  = $this->apikey; //your api key
		$msg = tian::$context->getMessage()->getPostData();
		$merchant_id = $msg['merchant_id'];
		$app_name = $msg['app_name'];
		$pm_id = $msg['pm_id'];
		$amount = $msg['amount'];
		$currency = $msg['currency'];
		$track_id = $msg['track_id'];
		$sub_track_id = $msg['sub_track_id'];
		$state = $msg['state'];
		$check_array = array(
			$merchant_id,
			$app_name,
			$pm_id,
			$amount,
			$currency,
			$track_id,
			$sub_track_id,
			$state,
			$api_key
		);
		$check_msg = implode('|', $check_array);
		$check_sig = md5($check_msg);
		$notify_sig = $msg['notify_sig'];
		if($check_sig == $notify_sig && $result==="completed"){
			return call_user_func_array($ok_callback,array($msg));
		}else{
			return call_user_func_array($fail_callback,array($msg));
		}
	}
}