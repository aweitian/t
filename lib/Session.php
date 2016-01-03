<?php
/**
 * Date: 2015年12月5日
 * Author: Awei.tian
 * Description: 
 */
class Session {
	static private $_instance = null;
	
	//公共静态方法获取实例化的对象
	static public function getInstance() {
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	private function __construct() {
		if(!session_id()){
			session_start();
		}
	}
	public function rm($key) {
		$_SESSION[$key] = null;
		unset($_SESSION[$key]);
	}
	public function set($key,$val) {
		$_SESSION[$key] = $val;
	}
	public function get($key) {
		if(array_key_exists($key,$_SESSION)){
			return $_SESSION[$key];
		}
		return null;
	}
}