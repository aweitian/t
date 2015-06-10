<?php
/**
 * Date: 2015-1-20
 * Author: Awei.tian
 * function: 
 */
class feedbackOpValidator{
	public static function isValidEml($v){
		return true;
	}
	public static function isValidPrice($v){
		return is_numeric($v);
	}
	public static function isValidWidgetfeedback($v){
		return util::isInt($v);
	}
	public static function isValidLocPrice($v){
		return true;
	}
	public static function isValidIp($v){
		return true;
	}
}