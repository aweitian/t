<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/lib/tian/validate/validator.php";
class memberOpValidator{
	public static function isValidEml($v){
		return validator::isEmail($v);
	}
	public static function isValidSqust($v){
		return strlen($v) > 0;
	}
	public static function isValidSqkey($v){
		return strlen($v) > 0;
	}
	public static function isValidPwd($v){
		return strlen($v) > 3;
	}
	
}