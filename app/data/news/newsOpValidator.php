<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
require_once LIB_PATH."/validate/validator.php";
class newsOpValidator{
	public static function isValidTitle($title){
		return is_string($title) && strlen($title) > 0 && strlen($title) < 128;
	}
	public static function isValidContent($content){
		return is_string($content);
	}
	public static function isValidLnk($lnk){
		return is_string($lnk);
	}
	public static function isValidSlideImg($sldflg,$img){
		if(!$sldflg)return true;
		return is_string($img) && strlen($img) > 0;
	}
	public static function isValidSlideOrder($order){
		return util::isInt($order);
	}
}