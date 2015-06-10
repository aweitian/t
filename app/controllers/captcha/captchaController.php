<?php
/**
 * Date: 2015-1-5
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH.'/app/api/session/captchaApi.php';
class captchaController extends appController{
	public function welcomeAction(message $msg){
		$api = new captchaApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"width"=>(isset($msg["width"])&&util::isInt($msg["width"]) ? $msg["width"]:70),
			"height"=>(isset($msg["width"])&&util::isInt($msg["width"]) ? $msg["width"]:30),
			"length"=>5,
			"type"=>"char"//math,char,num
		));
		$api->invoke();
	}
	public function testAction(message $msg){
		echo "<form method='post' action='".ENTRY_HOME."/captcha/check'>
				<img src='".ENTRY_HOME."/captcha'>
				<input name='code' value=''>
				<input type='submit' value='submit'>
				</form>";
	}
	public function checkAction(message $msg){
		$api = new captchaApi();
		$api->setMethod("post");
		$api->setArgs(array(
				"code"=>$msg["code"]//math,char,num
		));
		var_dump($api->invoke());
		echo "<a href='".ENTRY_HOME."/captcha/test'>continue</a>";
	}
	public function showAction(message $msg){
		if($msg->getUrlManager()->getHost() == "localhost"){
			$api = new captchaApi();
			$api->setMethod("put");
			$api->setArgs(array());
			echo ($api->invoke());			
		}
		exit;
	}
}