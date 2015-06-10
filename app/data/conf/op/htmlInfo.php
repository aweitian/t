<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/DataSrcPath.php";
require_once ENTRY_PATH."/app/data/conf/base/html.php";
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
class htmlInfo{
	public function __construct($path){

	}

	public function getConf(){
		return array("dumb"=>1);
	}	
}