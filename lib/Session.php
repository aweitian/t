<?php
/**
 * Date: 2015年12月5日
 * Author: Awei.tian
 * Description: 
 */
class Session {
	public function __construct() {
		if(!session_id()){
			session_start();
		}
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