<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

require_once ENTRY_PATH."/app/api/privilege/data/orderFieldApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/orderTplApi.php";
class deliveryTypeModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getData(){
		$api = new orderTplApi();
		$api->setScenario("all");
		$api->setMethod("get");
		$api->setArgs(array());
		return $api->invoke();
	}
	public function getAllFields(){
		$api = new orderFieldApi();
		$api->setScenario("forkvs");
		$api->setMethod("get");
		$api->setArgs(array());
		$res = $api->invoke();
		$ret = array();
		foreach ($res as $item){
			$ret[$item["key"]] = $item["val"];
		}
		return $ret;
	}
	/**
	 * @return affected roaws
	 * Enter description here ...
	 * @param unknown_type $path
	 */
	public function remove($name){
		$api = new orderTplApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"name"=>$name,
		));
		return $api->invoke();
	}
	public function append($name,$keylist){
		$api = new orderTplApi();
		$api->setMethod("post");
		$api->setArgs(array(
			"name"=>$name,
			"keylist"=>$keylist,
		));
		return $api->invoke();
	}
	public function update($msg){
		$api = new deliveryTypeApi();
		$api->setMethod("put");
		$api->setArgs($this->_build_post_data($msg));
		return $api->invoke();
	}
	public function info($key){
		$api = new orderFieldApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"keylist" => $key,
		));
		return $api->invoke();
	}
	public function defaultValue(){
		return array(
			"name" => "",
			"keylist" => array()
		);
	}
}