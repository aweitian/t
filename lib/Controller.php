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
		. ($module == "" ? "" : "/".$module) . "/".$ctr . "/".$ctr
		;
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
}

class AuthController extends Controller {
	public static function _checkPrivilege() {
		return false;
	}
}
