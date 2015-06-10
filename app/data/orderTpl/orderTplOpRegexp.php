<?php
/**
 * Date: 2014-10-17
 * Author: Awei.tian
 * function: 
 */
class orderTplOpRegexp{
	public static function isValidorderTplKey($key){
		return preg_match("/^[a-z]+$/", $key) && strlen($key)<=10;
	}
	public static function isValidorderTplKeyList($keylist){
		return preg_match("/^(\w+,?)*\w+$/", $keylist);
	}
	public static function isValidorderTplVal($val){
		return is_string($val) && strlen($val)<= 25;
	}
}