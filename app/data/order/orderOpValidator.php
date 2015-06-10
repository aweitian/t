<?php
/**
 * Date: 2014-12-29
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/lib/tian/validate/validator.php";
class orderOpValidator{
	public static function isValidPmtype($v){
		return preg_match("/^\w+$/",$v);
	}
	public static function isValidEml($v){
		return validator::isEmail($v);
	}
	public static function isValidTitle($v){
		return is_string($v) && strlen($v) > 1;
	}
	public static function isValidPrice($v){
		return is_numeric($v);
	}
	public static function isValidWidgetOrder($v){
		return util::isInt($v);
	}
	public static function isValidLocPrice($v){
		return true;
	}
	public static function isValidIp($v){
		return validator::isIp($v);
	}
}