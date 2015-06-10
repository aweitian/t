<?php
/**
 * Date: 2014-9-29
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/orderField/orderFieldOpRegexp.php";
class namespaceOpRegexp{
	public static $key = "/^[^\/:*?\"<>|\r\n]+$/";
	public static $name = "/^.{0,25}$/";
	public static function isValidNT($v){
		return $v == "folder" || $v == "file";
	}
	public static function isValidOrder($v){
		return is_numeric($v);
	}
	public static function isValidDa($v){
		return $v == ""||orderFieldOpRegexp::isValidorderFieldKey($v);
	}
}