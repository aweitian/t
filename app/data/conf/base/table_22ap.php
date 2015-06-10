<?php
/**
 * Date: 2014-11-18
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/AConf.php";
class conf_table_22ap extends AConf{
	public function __construct($conf){
		$this->rawData = $conf;
		$conf = $this->_db2conf($conf);
		if(!self::isValid($conf)){
			throw new Exception("invalid data",0x9);
		}
		$this->conf = $conf;
	}
	private function _db2conf($conf){
		return $conf;
	}
	public function getMutiStyle(){
		return $this->conf["mutistyle"];
	}
	public function getTableCaption(){
		return $this->conf["tableCaption"];
	}
	public function getUnit(){
		return $this->conf["unit"];
	}
	public function getShowType(){
		return $this->conf["showType"];
	}
	public function getTitleType(){
		return $this->conf["titleType"];
	}
	public function getGridCol(){
		return $this->conf["gridCol"];
	}
	static public function isValid($conf){
		return is_array($conf) 
		&& array_key_exists("mutistyle", $conf) 
		&& array_key_exists("unit", $conf) 
		&& array_key_exists("tableCaption", $conf) 
		&& array_key_exists("showType", $conf) 
		&& array_key_exists("gridCol", $conf) 
		&& array_key_exists("titleType", $conf) 
		&& app::isValidUnit($conf["unit"])
		&& is_string($conf["tableCaption"])
		&& util::isInt($conf["gridCol"])
		&& is_string($conf["showType"])
		&& is_string($conf["titleType"])
		&& is_string($conf["mutistyle"])
		&& in_array($conf["showType"],array("table","grid"))
		&& in_array($conf["titleType"],array("text"))
		&& in_array($conf["mutistyle"],array("auto","expand","collapse"))
		;
	}
	static public function getDefaultConf(){
		return array(
			"mutistyle" => "auto",
			"unit" => "1 g",
			"tableCaption" => "",
			"showType" => "grid",
			"titleType" => "text",
			"gridCol" => 3,
		);
	}
}