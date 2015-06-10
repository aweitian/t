<?php
/**
 * Date: 2014-10-17
 * Author: Awei.tian
 * function: 
 */
class labelOpRegexp{
	public static function isValidlabelKey($key){
		return $key>=0 && $key < 32;
	}
	public static function isValidlabelVal($val){
		return is_string($val) && strlen($val)<= 20;
	}
}