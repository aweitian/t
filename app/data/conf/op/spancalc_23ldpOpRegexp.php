<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/base/spancalc_23ldp.php";
class spancalc_23ldpOpRegexp{
	public static function isValid($conf){
		return conf_spancalc_23ldp::isValid($conf);
	}	
}