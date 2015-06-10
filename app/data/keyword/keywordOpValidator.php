<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
class keywordOpValidator{
	public static function isValidOri($v){
		return is_string($v)&&strlen($v)<=32;
	}
	public static function isValidAlias($v){
		return is_string($v)&&strlen($v)<=16;
	}
}