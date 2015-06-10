<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
require_once LIB_PATH."/validate/validator.php";
class oplogOpValidator{
	public static function isValidOptype($v){
		return preg_match("/^\w{1,16}$/", $v);
	}
	public static function isValidIp($ip){
		return validator::isIp($ip);
	}

}