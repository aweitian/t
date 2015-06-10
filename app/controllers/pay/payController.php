<?php
/**
 * @author awei.tian
 * date: 2013-9-18
 * 说明:
 */
require_once ENTRY_PATH."/app/payment/payssion/payssion.php";
require_once ENTRY_PATH."/app/payment/ppipn/ppipn.php";
class payController extends appController{
	/**
	 * @var mainView
	 */
	protected $view;
	/**
	 * @var mainModel
	 */
	protected $model;
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$this->paypalAction($msg);
	}
	public function paypalAction(message $msg){
// 		echo "paypal<br>";
// 		echo "id:".$msg["id"]."<br>";X
// 		echo "title:".$msg["title"]."<br>";X
// 		echo "price:".$msg["price"]."<br>";
		$pp = new ppipn('$business', '$return_url', '$cancal_rul', '$notify_url',ppipn::PRODUCT);
		if(APP_DEBUG){
			print $pp->pay($msg["title"], $msg["price"], array(
				"item_number" => $msg["id"]
			));
		}else{
			header("locaction:".$pp->pay($msg["title"], $msg["price"], array(
				"item_number" => $msg["id"]
			)));			
		}

	}
	public function payssionAction(message $msg){
// 		echo "payssion<br>";
// 		echo "title:".$msg["title"]."<br>";
// 		echo "price:".$msg["price"]."<br>";
		$pp = new payssion("a0082dde5be759d4", "7fafce48b3a12cc51578db6e3903a59c");
		
		if(APP_DEBUG){
			print $pp->pay($msg["title"], $msg["price"], array(
				"pm_id" => $msg["pmtype"],
				"track_id" => $msg["id"],
			));
		}else{
			header("locaction:".$pp->pay($msg["title"], $msg["price"], array(
			"pm_id" => $msg["pmtype"],
			"track_id" => $msg["id"],
		)));
		}
	}
}