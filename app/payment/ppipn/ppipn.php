<?php
/**
 * @author awei.tian
 * date: 2013-10-12
 * 说明:paypal ipn支付接口
 */
require_once ENTRY_PATH.'/app/interfaces/IPayment.php';
class ppipn implements IPayment{
	const TEST    = 0;
	const PRODUCT = 1;
	private $_env;
	private $_env_test_url         = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	private $_env_prod_url         = "https://www.paypal.com/cgi-bin/webscr";
	private $_business;
	private $pp_post_url;
	private $_pp_entrypoint_return;	//paypal回调入口目录
	private $_pp_entrypoint_cancel; //paypal回调入口目录
	private $_pp_entrypoint_ipn;    //paypal回调入口目录
	private $_title                = "test";
	private $_price                = 0;
	private $_extra                = array();
	private $_ordercode            = 1;
	private $_submit_btn_text      = "Check out";
	private static $_callback_ok   = null;
	private static $_callback_fail = null;
	public function __construct($business,$return_url,$cancal_rul,$notify_url,$envir=self::TEST){
		$this->_business = $business;
		$this->_pp_entrypoint_return = $return_url;
		$this->_pp_entrypoint_cancel = $cancal_rul;
		$this->_pp_entrypoint_ipn    = $notify_url;
		if($envir == self::PRODUCT){
			$this->_env = self::PRODUCT;
		}
		$this->pp_post_url = $this->_env == self::TEST ? $this->_env_test_url : $this->_env_prod_url;
	}
	/**
	 * (non-PHPdoc)
	 * @param $extra array("currency_code" =>"USD","item_number"=>1)
	 * @return payment link
	 */
	public function pay($title, $price, $extra){
		$this->_title = $title;
		$this->_price = $price;
		if(is_array($extra)){
			$this->_extra = $extra;
		}
		$data = array(
			"business" 		=> $this->_business,
			"cmd" 			=> "_xclick",
			"return" 		=> $this->_pp_entrypoint_return,
			"cancel_return" => $this->_pp_entrypoint_cancel,
			"notify_url" 	=> $this->_pp_entrypoint_ipn,
			"currency_code" => isset($this->_extra["currency_code"]) ? $this->_extra["currency_code"] : "USD",
			"item_name" 	=> $this->_title,
			"amount" 		=> $this->_price,
			"item_number" 	=> isset($this->_extra["item_number"]) ? $this->_extra["item_number"] : 1,
		);
		return $this->pp_post_url.'?'.http_build_query($data); 
	}
	public function notify($ok_callback,$fail_callback){
		$data = tian::$context->getMessage()->getPostData();
		$postdata = "";
		$bak = array();
		foreach($data as $i => $v){
			$postdata .= $i . "=" . urlencode($v) . "&";
			$bak[$i] = $v;
		}
		$postdata .= "cmd=_notify-validate";
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_URL,$this->pp_post_url);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
		ob_start();
		curl_exec($ch);
		$info = ob_get_contents();
		curl_close($ch);
		ob_end_clean();
		if(preg_match("/VERIFIED/",$info))	{
			return call_user_func_array($ok_callback,array($data,$info));
		}else{
			return call_user_func_array($fail_callback,array($data,$info));
		}
	}
}