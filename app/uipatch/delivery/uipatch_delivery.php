<?php
/**
 * Date: 2014-9-17
 * Author: Awei.tian
 * function: 
 */
require_once dirname(dirname(__FILE__))."/AUipatch.php";
require_once LIB_PATH."/formUI/fieldsManifest.php";
require_once LIB_PATH."/formUI/mysqlFieldHelper.php";
class uipatch_delivery extends AUipatch{
	public $type;
	public $data;
	/**
	 * 
	 * @var array(
	 * 		"type"=>"type",
	 * 		"data"=>array(
	 * 			"key1"=>array(
	 * 				"name"=>"text",
	 * 				"html"=>"html"
	 * 			)
	 * 		),
	 * 		...
	 * )
	 */
	private $result;
	private $ui;
	private $def;
	/**
	 * @param string $type
	 * @param array $data
	 * @param array $defaultvalue array(key=>val)
	 */
 	public function __construct($type,$data,$defaultvalue=array()){
 		$this->type = $type;
 		$this->data = $data;
 		$this->def = $defaultvalue;
 		$this->ui = new fieldsManifest();
 		$this->_parse();
 	}
	
	public function getData(){
 		return $this->result;
	}
	
	private function _parse(){
		$this->result = array(
			"type" => $this->type,
			"data" => array()
		);
		$names = array();
// 		var_dump($this->data);exit;
		foreach ($this->data as $item){
			$names[$item["key"]] = $item["val"];
			$this->ui->addField(
				$item["key"], 
				$this->_for_opl_select_type($item["typ"],$item["len"]),
				array_key_exists($item["key"],$this->def)? array("value"=>$this->def[$item["key"]],"ept"=>$item["ept"]) : array("ept"=>$item["ept"]),
				explode(",", $item["len"])
			);
		}
		$ret = $this->ui->getData();
		foreach ($ret as $key=>$item){
			$this->result["data"][$key] = array(
				"name" => $names[$key],
				"html" => $item
			);
		}
	}
	/**
	 * 
	 * @param string $type
	 * @param array $val
	 * 提供INPUT类型可能转换为select
	 */
	private function _for_opl_select_type($type,$val){
		if($type == "input_str"){
			if(count(explode(",", $val)) > 1){
				return "enum";
			}
		}
		return $type;
	}
}