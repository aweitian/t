<?php
/**
 * Date: 2015年12月8日
 * Author: Awei.tian
 * Description: 
 */
class Validator {
	public static function isValidPhone($ph){
		return preg_match("/\d{3}-?\d{8}/",$ph);
	}
	public static function isInt($v){
		return is_numeric($v) && preg_match("/^-?\d+$/",$v);
	}
	public static function isUint($v){
		return is_numeric($v) && preg_match("/^\d+$/",$v);
	}
	public static function isDate($v){
		return preg_match("/^(\d{4})[\/\-\.](0?[1-9]|1[012])[\/\-\.](0?[1-9]|[12][0-9]|3[01])$/",$v);
	}
	public static function isEmail($v){
		return preg_match("/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/",$v);
	}
	public static function isIp($ip){
		return preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/", $ip);
	}
	public static function isUrl($v){
		return preg_match("#((http|ftp|https)://)(([a-zA-Z0-9\._-]+\.[a-zA-Z]{2,6})|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,4})*(/[a-zA-Z0-9\&%_\./-~-]*)?#", $v);
	}
}