<?php
/**
 * Date: 2015-1-5
 * Author: Awei.tian
 * function: WID,ORDER
 */
require_once ENTRY_PATH."/app/modules/order/subsribe.php";
class orderController extends appController{
	/**
	 * @var orderView
	 */
	protected $view;
	/**
	 * @var orderModel
	 */
	protected $model;
	public function __construct(){
		$this->_loadView();
		$this->_loadModel();
		$this->_init();
	}
	public function welcomeAction(message $msg){
		
	}
	public function estimateAction(message $msg){
		$order = new orderSubscribe();
		try{
			$data = $order->est($msg->getGetData());
		}catch (Exception $e){
			$this->view->showErr($e->getMessage());
			return ;
		}
		$this->view->pribiUi($msg->getRawQueryString(),$data);
	}
	public function subscribeAction(message $msg){
		$order = new orderSubscribe();
		try{
			$data = $order->subscribe($msg->getPostData());
		}catch (Exception $e){
			$this->view->showErr($e->getMessage());
			return ;
		}
// 		var_dump($data);exit;
		foreach ($data as $k => $item){
			$msg[$k] = $item;
		}
		
		$msg->setControl("pay");
		switch ($data["pmtype"]){
			case "paysafecard":
			case "sofort":
			case "cashu":
			case "boleto_br":
			case "qiwi":
			case "onecard":
				$msg->setAction("payssion");
				break;
			default:
				$msg->setAction("paypal");
				break;				
		}
		$msg->setDispatchedState(dispatcher::DISPATCH_STATE_RESTART);
		tian::$context->getDispatcher("default")->dispatch();
	}
}