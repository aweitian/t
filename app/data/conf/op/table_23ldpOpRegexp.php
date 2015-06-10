<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/base/table_23ldp.php";
class table_23ldpOpRegexp{
	public static function isValid($conf){
		return conf_table_23ldp::isValid($conf);
	}	
}