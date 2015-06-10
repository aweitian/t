<?php
/**
 * @author awei.tian
 * date: 2013-9-17
 * 说明:上下文环境，在有的框架中这叫application
 * 我觉得到context更好点
 * 它实现框架逻辑，也是插件的注册点
 */
require_once LIB_PATH.'/context/core.php';
require_once LIB_PATH.'/interfaces/IContext.php';
C::addAutoloadPath("httpResponse", LIB_PATH."/response/httpResponse.php");
abstract class AContext implements IContext{
	
	protected $log=null;
	protected $kv=null;
	public $reqeust;
	public $response;
	public $message;
	public $router;
	public $dispatcher;
	protected $_dispatcher_arr=array();
	/**
	 * @var IDb
	 */
	public $db;
	public function getRequest(){
		return $this->reqeust;
	}
	public function setRequest(httpRequest $r){
		$this->reqeust=$r;
	}
	public function getResponse(){
		return $this->response;
	}
	public function setResponse(httpResponse $r){
		$this->response=$r;
	}
	public function getMessage(){
		return $this->message;
	}
	public function setMessage(message $m){
		$this->message=$m;
	}
	public function getRouter(){
		return $this->router;
	}
	public function setRouter(router $r){
		$this->router=$r;
	}
	public function getDispatcher($name){
		if(array_key_exists($name, $this->_dispatcher_arr)){
			return $this->_dispatcher_arr[$name];
		}else if(array_key_exists("default", $this->_dispatcher_arr)){
			return $this->_dispatcher_arr["default"];
		}
		return $this->dispatcher;
	}
	public function addDispatcher($name,IDispatcher $d){
		$this->dispatcher=$d;
		$this->_dispatcher_arr[$name]=$d;
	}
	public function getSession(){
		require_once LIB_PATH."/session/session.php";
		return new session();
	}
	public function getIdentityToken(){
		require_once LIB_PATH."/auth/identityToken.php";
		static $id=null;
		if(is_null($id)){
			$id=new identityToken(util::getClientIp());
		}
		return $id;
	}
	/**
	 * @return visterEnvironment
	 */
	public function getVisterEnvironment(){
		require_once LIB_PATH."/request/visterEnvironment.php";
		static $envir=null;
		if(is_null($envir)){
			$envir=new visterEnvironment();
		}
		return $envir;
	}
}