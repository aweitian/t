<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 */
class nodeOpRegexp{
	public static function isValidKey($v){
		return preg_match("/^[^\/:*?\"<>|\r\n]+$/", $v);
	}
	public static function isValidType($v){
		return is_numeric($v) && $v>=-1 && $v<32;
	}
	public static function isValidNT($v){
		return $v == "folder" || $v == "file";
	}
	public static function isValidLabel($v){
		
		$f = is_array($v);//($v) && $v>=0 && $v<32;
		foreach ($v as $i){
			$f = $f && is_numeric($i) && $i>=0 && $i<32;
		}
		return $f;
	}
	public static function isValidOrder($v){
		return is_numeric($v);
	}
	public static function calc($v){
		$c = 0;
		foreach ($v as $i){
			$c += 1<<$i;
		}
		return $c;
	}
	public static function typetoindex($type){
		for($i=0;$i<32;$i++){
			if((1<<$i)&$type)return $i;
		}
		return -1;
	}
	public static function labeltoindexArr($label){
		$ret = array();
		for($i=0;$i<32;$i++){
			if((1<<$i)&$label)$ret[] = $i;
		}
		return $ret;
	}
	
}