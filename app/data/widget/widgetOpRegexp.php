<?php
/**
 * Date: 2014-10-17
 * Author: Awei.tian
 * function: 
 */
class widgetOpRegexp{
	public static function isValidTypeKey($key){
		return $key>=0 && $key < 32;
	}
	public static function isValidTypeVal($val){
		return is_string($val) && strlen($val)<= 20;
	}
	public static function isMatchedTDC($typeid,$datasrctype,$conftype){
		return true;
	}
}