<?php
//! Controller

class Controller {
	public static function _checkPrivilege() {
		return true;
	}
	public function __construct() {

	}
	public function url($ctr=DEFAULT_CONTROLLER,$act=DEFAULT_ACTION,$module=""){
		return HTTP_ENTRY
		. ($module == "" ? "" : "/".$module) . "/".$ctr . "/".$act
		;
	}
	public function go($ctr=DEFAULT_CONTROLLER,$act=DEFAULT_ACTION,$module=""){
		header("location:".$this->url($ctr,$act,$module));
		exit;
	}
	public function redirect($url){
		header("location:".HTTP_ENTRY.$url);
		exit;
	}
	public function back(){
		header("location:".$_SERVER["HTTP_REFERER"]);
		exit;
	}
	public function goHome(){
		if (HTTP_ENTRY == "")
			header("location:/");
		else
			header("location:".HTTP_ENTRY);
		exit;
	}
	/**
	 * 只设置HTTP STATUS
	 */
	public function _404(){
		App::$router->_404();
		exit;
	}
	public function isPost(){
		return App::isPost();
	}
	public function exitMsg($msg){
		App::$router->response($msg);
	}
}

class AuthController extends Controller {
	/**
	 * 
	 * @var roleSession
	 */
	protected $role;
	public static function _checkPrivilege() {
		return false;
	}
	protected function checkPriv($priv){
		if(!$this->role->hasPriv($priv)){
			$this->exitMsg("Permission denied > <!");
		}
	}
}
