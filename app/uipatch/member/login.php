<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/uipatch/AUipatch.php";
class uipatch_login extends AUipatch{
	/**
	 * @param array $default
	 * array(
	 * 		"usr"=>array(
	 * 			"value"=>"val",
	 * 			"classname"=>"22"
	 * 		)
	 * )
	 */
	public function __construct($default=array()){
		$this->initFieldsManifest();
		$this->fieldsManifest->addField("usr", "input_str",isset($default["usr"])?$default["usr"]:array());
		$this->fieldsManifest->addField("pas", "input_str",isset($default["pas"])?$default["pas"]:array("type"=>"password"));
// 		$this->fieldsManifest->rules = array(
// 			"usr"=>array(
// 				"type"=>"input_str",
// 				"options"=>array(
				
// 				),
// 				"key"=>array(),
// 				"value"=>array(),
// 				"selectedValue"=>""
// 			),
// 			"pas"=>array(
// 				"type"=>"input_str",
// 				"options"=>array(
// 					"type"=>"password"
// 				),
// 				"key"=>array(),
// 				"value"=>array(),
// 				"selectedValue"=>""
// 			)
// 		);
	}
	public function getData(){
		return $this->fieldsManifest->getData();
	}
}