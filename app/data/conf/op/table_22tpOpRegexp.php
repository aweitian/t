<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/base/table_22tp.php";
class table_22tpOpRegexp{
	public static function isValid($conf){
		return conf_table_22tp::isValid($conf);
	}	
}