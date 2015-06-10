<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/base/table_22ld.php";
class table_22ldOpRegexp{
	public static function isValid($conf){
		return conf_table_22ld::isValid($conf);
	}	
}