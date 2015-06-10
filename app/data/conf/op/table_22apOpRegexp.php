<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/base/table_22ap.php";
class table_22apOpRegexp{
	public static function isValid($conf){
		return conf_table_22ap::isValid($conf);
	}	
}