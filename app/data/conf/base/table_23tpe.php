<?php
/**
 * Date: 2014-11-18
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/conf/AConf.php";
class conf_table_23tpe extends AConf{
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
	public function getTitleType(){
		return $this->conf["titleType"];
	}
	public function getExtraShowMode(){
		return $this->conf["extraShowMode"];
	}
	public function getIconPlaceHolder(){
		return $this->conf["iconPlaceHolder"];
	}
	public function getExtraShowMask(){
		return $this->conf["extraShowMask"];
	}
	public function getExtraCaption(){
		return $this->conf["extraCaption"];
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
		&& array_key_exists("tableCaption", $conf) 
		&& array_key_exists("titleType", $conf) 
		&& array_key_exists("extraShowMode", $conf) 
		&& array_key_exists("iconPlaceHolder", $conf) 
		&& array_key_exists("extraShowMask", $conf) 
		&& array_key_exists("extraCaption", $conf) 
		&& array_key_exists("showType", $conf)
		&& array_key_exists("gridCol", $conf)
		&& is_string($conf["tableCaption"])
		&& is_string($conf["titleType"])
		&& is_string($conf["extraShowMode"])
		&& is_string($conf["iconPlaceHolder"])
		&& is_string($conf["extraShowMask"])
		&& is_string($conf["extraCaption"])
		&& is_string($conf["mutistyle"])
		&& in_array($conf["titleType"],array("text","img"))
		&& in_array($conf["extraShowMode"],array("text","icon"))
		&& in_array($conf["extraShowMask"],array("etp","tep","tpe"))
		&& in_array($conf["showType"],array("grid","table"))
		&& util::isInt($conf["gridCol"])
		&& in_array($conf["mutistyle"],array("auto","expand","collapse"))
		;
	}
	static public function getDefaultConf(){
		return array(
			"mutistyle" => "auto",
			"tableCaption" => "",
			"titleType" => "text",
			"extraShowMode" => "text",
			"iconPlaceHolder" => "<span class=\"widget-table-icon\" {placeholder}><img src=\"/public/img/detail.gif\"></span>",
			"extraShowMask" => "tpe",
			"extraCaption" => "",
			"showType" => "table",
			"gridCol" => 3,
		);
	}
}