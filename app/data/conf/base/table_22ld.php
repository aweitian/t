<?php
/**
 * Date: 2014-11-18
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/AConf.php";
class conf_table_22ld extends AConf{
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
		if(isset($conf["showCalcData"]))$conf["showCalcData"] = $conf["showCalcData"] == "0" ? false : true;
		if(isset($conf["showZero2End"]))$conf["showZero2End"] = $conf["showZero2End"] == "0" ? false : true;
		if(isset($conf["showA2B"]))$conf["showA2B"] = $conf["showA2B"] == "0" ? false : true;
		if(isset($conf["span"])){
			if(is_string($conf["span"])){
				$conf["span"] = explode(",", $conf["span"]);
			}
		}
		return $conf;
	}
	public function getMutiStyle(){
		return $this->conf["mutistyle"];
	}
	public function getUnit(){
		return $this->conf["unit"];
	}
	public function getTableCaption(){
		return $this->conf["tableCaption"];
	}	
	public function getSpan(){
		return $this->conf["span"];
	}
	public function getSpanNum(){
		return $this->conf["spanNum"];
	}
	public function getTitleType(){
		return $this->conf["titleType"];
	}
	public function getShowCalcData(){
		return $this->conf["showCalcData"];
	}
	public function getShowZero2End(){
		return $this->conf["showZero2End"];
	}
	public function getShowA2B(){
		return $this->conf["showA2B"];
	}
	public function getShowType(){
		return $this->conf["showType"];
	}
	public function getGridCol(){
		return $this->conf["gridCol"];
	}
	static public function isValid($conf){
		return is_array($conf) 
		&& array_key_exists("mutistyle", $conf)
		&& array_key_exists("unitprice", $conf) 
		&& array_key_exists("tableCaption", $conf) 
		&& array_key_exists("span", $conf) 
		&& array_key_exists("spanNum", $conf) 
		&& array_key_exists("titleType", $conf) 
		&& array_key_exists("showType", $conf) 
		&& array_key_exists("gridCol", $conf)
		&& array_key_exists("showCalcData", $conf) 
		&& array_key_exists("showZero2End", $conf) 
		&& array_key_exists("showA2B", $conf) 
		&& is_numeric($conf["unitprice"])
		&& is_string($conf["tableCaption"])
		&& is_array($conf["span"])
		&& is_numeric($conf["spanNum"])
		&& is_string($conf["titleType"])
		&& is_bool($conf["showCalcData"])
		&& is_bool($conf["showZero2End"])
		&& is_bool($conf["showA2B"])
		&& is_string($conf["mutistyle"])
		&& in_array($conf["titleType"],array("text"))
		&& in_array($conf["showType"],array("grid","table"))
		&& util::isInt($conf["gridCol"])
		&& in_array($conf["mutistyle"],array("auto","expand","collapse"))
		;
	}
	static public function getDefaultConf(){
		return array(
			"mutistyle" => "auto",
			"unitprice" => "",
			"tableCaption" => "",
			"showType" => "table",
			"gridCol" => 3,
			"span" => array(),
			"spanNum" => 3,
			"titleType" => "text",
			"showCalcData" => true,
			"showZero2End" => true,
			"showA2B" => true
		);
	}
}