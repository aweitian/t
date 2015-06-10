<?php
/**
 * Date: 2014-10-17
 * Author: Awei.tian
 * function: 
 */
class typeOpRegexp{
	public static function isValidTypeKey($key){
		return $key>=0 && $key < 32;
	}
	public static function isValidTypeVal($val){
		return is_string($val) && strlen($val)<= 20;
	}
}