<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 */
abstract class AConfigHelper{
	protected $data;
	protected $code;
	protected $field;
	protected $conf;
	public function __construct($datasrc_typeid,$data){
		$this->data = $data;
		if(!$this->isValid($datasrc_typeid,$data))throw new Exception(self::getLastValidMsg());
		$this->_fill_default_value($datasrc_typeid);
	}
	/**
	 * extra show mode		extraShowMode icon/text     text
	 */
	public function getConfig(){
		return $this->data;
	}
	
	/**
	 * extra show caption   extraCaption  string		*
	 * extra show mode		extraShowMode icon/text     text
	 * extra show mask		extraShowMask tep/tpe		tpe
	 * table cation			tableCaption	string		""
	 * @param unknown $data
	 */
	protected function isValidNumber($datasrc_typeid,$data){
		if(!is_array($data))return 1;
		$conf = $this->getConfigDesc($datasrc_typeid);
		if(!$conf)return 6;
		foreach ($conf as $key => $val){
			$this->field = $key;
			if($val["require"]){
				if(!array_key_exists($key, $data))return 2;
			}else{
				if(!array_key_exists($key, $data))continue;
			}
			switch ($val["type"]){
				case "string":
					if(!is_string($data[$key]))return 3;
					if(is_array($val["range"])){
						if(!in_array($data[$key], $val["range"]))return 4;
					}
					break;
				case "number":
					if(!is_numeric($data[$key]))return 3;
					break;
				case "bool":
					if(!is_bool($data[$key]))return 3;
					break;
				case "array":
					if(!is_array($data[$key]))return 3;
					break;
			}
		}
		return 0;
	}
	public function isValid($datasrc_typeid,$data){
		$this->code = $this->isValidNumber($datasrc_typeid, $data);
		return $this->code === 0;
	}
	
	protected function _fill_default_value($datasrc_typeid){
		$conf = $this->getConfigDesc($datasrc_typeid);
		foreach ($conf as $key => $val){
			if(!array_key_exists($key, $this->data))$this->data[$key] = $val["default"];
		}
	}
	public function getLastValidMsg(){
 		$code = $this->code;
 		switch ($code){
 			case 0:return "ok";
 			case 1:return "data is not an array";
 			case 2:return "[".$this->field."] required key is absent";
 			case 3:return "[".$this->field."] type is invalid";
 			case 4:return "[".$this->field."] data is not in range";
 			case 6:return "invalid datasrc id";
 		}
 		return "invalid return code";
 	}
	abstract public function getConfigDesc($datasrc_typeid);
}