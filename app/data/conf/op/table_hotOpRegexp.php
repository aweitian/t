<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/base/table_hot.php";
class table_hotOpRegexp{
	public static function isValid($conf){
		return conf_table_hot::isValid($conf);
	}	
}