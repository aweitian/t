<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/base/table_23tpe.php";
class table_23tpeOpRegexp{
	public static function isValid($conf){
		return conf_table_23tpe::isValid($conf);
	}	
}