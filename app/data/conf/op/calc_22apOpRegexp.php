<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/base/calc_22ap.php";
class calc_22apOpRegexp{
	public static function isValid($conf){
		return conf_calc_22ap::isValid($conf);
	}	
}