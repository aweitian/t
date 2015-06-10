<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/DataSrcPath.php";
require_once ENTRY_PATH."/app/data/conf/base/table_hot.php";
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
class table_hotInfo{
	public function __construct($path){

	}

	public function getConf(){
		return array("dumb"=>1);
	}	
}