<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
require_once ENTRY_PATH."/app/data/conf/base/calc_22ap.php";
require_once ENTRY_PATH."/app/data/conf/base/spancalc_22ld.php";
require_once ENTRY_PATH."/app/data/conf/base/spancalc_23ldp.php";
require_once ENTRY_PATH."/app/data/conf/base/table_22ap.php";
require_once ENTRY_PATH."/app/data/conf/base/table_22ld.php";
require_once ENTRY_PATH."/app/data/conf/base/table_22tp.php";
require_once ENTRY_PATH."/app/data/conf/base/table_23ldp.php";
require_once ENTRY_PATH."/app/data/conf/base/table_23tpe.php";
class confkeyOpRegexp{
	public static function isValidOrder($v){
		return preg_match("/^[^\/:*?\"<>|\r\n]+$/", $v);
	}
	public static function isValidType($v){
		return array_key_exists($v, conf::$typeArr);
	}
	public static function isValidKey($v){
		return preg_match("/^[\da-z]{1,20}$/", $v);
	}
	public static function isValidComment($v){
		return true;
	}
}