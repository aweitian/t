<?php
/**
 * Date: 2014-11-18
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/AConf.php";
class conf_spancalc_23ldp extends AConf{
	public function __construct($conf){
		$this->rawData = $conf;
		$conf = $this->_db2conf($conf);
		if(!self::isValid($conf)){
			throw new Exception("invalid data",0x9);
		}
		$this->conf = $conf;
	}
	private function _db2conf($conf){
		if(empty($conf))return $conf;
		if(isset($conf["cachejs"]))$conf["cachejs"] = $conf["cachejs"] == "0" ? false : true;
		return $conf;
	}
	public function getCachejs(){
		return $this->conf["cachejs"];
	}
	static public function isValid($conf){
//		var_dump(is_array($conf) && array_key_exists("cachejs", $conf) && is_bool($conf["cachejs"]));exit;
		return is_array($conf) && array_key_exists("cachejs", $conf) && is_bool($conf["cachejs"]);
	}
	static public function getDefaultConf(){
		return array(
				"cachejs" => true
		);
	}
}