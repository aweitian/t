<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 */
class datakeyOpRegexp{
	public static function isValidNodePath($v){
		return preg_match(DataSrcPath::NODEINFO_PATTERN, $v);
	}
	public static function isValidKey($v){
		return preg_match("/^[\da-z]{1,20}$/", $v);
	}
	public static function isValidDsType($v){
		return array_key_exists($v, dataSrc::$typeArr);
	}
	public static function isValidDeco($v){
		return true;
	}
	public static function isValidComment($v){
		return true;
	}
	public static function isValidNsRootType($v){
		return $v === "file" || $v === "folder";
	}
}