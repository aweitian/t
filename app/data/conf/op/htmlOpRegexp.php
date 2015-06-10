<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/base/html.php";
class htmlOpRegexp{
	public static function isValid($conf){
		return conf_html::isValid($conf);
	}	
}