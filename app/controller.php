<?php
/**
 * Date: 2014-10-15
 * Author: Awei.tian
 * function: 
 */
class apiInit{
	/**
	 * @var IApi
	 */
	private $ins;
	private $path;
	public function __construct($path){
		if(!preg_match("#^[\w/]+$#",$path)){
			throw new Exception("invalid path",0x3);
		}
		$path = ENTRY_PATH."/app/api".$path.".php";
		$info = basename($path,".php");
		if(!file_exists($path)){
			throw new Exception("invalid path:".$path,0x89);
		}
		require_once $path;
		$this->ins = new $info;
		$this->path = $path;
	}
	public function invoke(){
		$this->ins->setUrl($this->path);
		$msg = tian::$context->getMessage();
		$method = $msg->getHttpRequest()->getMethod();
		$scenario = $msg->getHttpRequest()->scenario();
		switch ($method){
			case "get":
			case "delete":
				parse_str($msg->getHttpRequest()->getQueryString(),$args);
				$this->ins->setArgs($args);
				break;
			case "post":
			case "put":
				parse_str($msg->getHttpRequest()->rawBody(),$args);
				$this->ins->setArgs($args);
				break;
			default:
				throw new Exception("Not supported http method",0x898);
		}
		$this->ins->setScenario($scenario);
		$this->ins->setMethod($method);
		return $this->ins->invoke();
	}
}
abstract class authenticateControllerRest extends authenticateController{
	public function restInvoke($path){
		$ins = new apiInit($path);
		return $ins -> invoke();
	}
	public function ok($msg){
		tian::$context->getResponse()->output(array(
			"status"=>"ok",
			"response" => $msg
		));
	}
	public function fail($msg){
		tian::$context->getResponse()->output(array(
		"status"=>"fail",
		"response" => $msg
		));
	}
}
abstract class controllerRest extends controller{
	public function restInvoke($path){
		new apiInit($path);
		return $ins -> invoke();
	}
	public function ok($msg){
		tian::$context->getResponse()->output(array(
		"status"=>"ok",
		"response" => $msg
		));
	}
	public function fail($msg){
		tian::$context->getResponse()->output(array(
		"status"=>"fail",
		"response" => $msg
		));
	}
}