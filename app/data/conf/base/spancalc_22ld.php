<?php
/**
 * Date: 2014-11-18
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/AConf.php";
class conf_spancalc_22ld extends AConf{
	public $rawData;
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
	public function getUnit(){
		return $this->conf["unit"];
	}
	static public function isValid($conf){
		return is_array($conf) 
		&& array_key_exists("cachejs", $conf) 
		&& array_key_exists("unit", $conf) 
		&& is_bool($conf["cachejs"])
		&& is_numeric($conf["unit"])
		;
	}
	static public function getDefaultConf(){
		return array(
			"cachejs" => true,
			"unit" => 30
		);
	}
}