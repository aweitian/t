<?php
/**
 * Date: 2014-10-17
 * Author: Awei.tian
 * function: 
 */
require_once LIB_PATH."/formUI/fieldsManifest.php";
require_once LIB_PATH."/formUI/mysqlFieldHelper.php";
require_once LIB_PATH."/validate/validator.php";

class orderFieldOpRegexp{
	public static function isValidorderFieldKey($key){
		return preg_match("/^\w+$/", $key);
	}
	public static function isValidorderFieldKeyList($keylist){
		return preg_match("/^(\w+,?)*\w+$/", $keylist);
	}
	public static function isValidorderFieldVal($val){
		return is_string($val) && strlen($val)<= 25;
	}
	public static function isValidorderFieldTyp($val){
		return array_key_exists($val, mysqlFieldHelper::$typeArr);
	}
	public static function isValidorderFieldLen($typ,$len){
		switch ($typ){
			case "textarea":
			case "input_datetime":
			case "input_date":
			case "input_num":
				return strlen($len)<=128;
			case "enum":
			case "set":
				return preg_match("/^(\w+,?)*\w+$/", $len) && strlen($len)<=128;
			case "input_str":
			case "input_file":
				return validator::isInt($len);
			default:
				throw new Exception("invalid type",0x890);
		}
	}
	public static function isValidorderFieldEpt($val){
		return $val==="yes" || $val === "no";
	}
}