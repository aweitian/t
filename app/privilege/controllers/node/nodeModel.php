<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
require_once ENTRY_PATH."/app/api/privilege/data/nodeApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/typeApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/labelApi.php";
class nodeModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getData($path){
		$api = new nodeApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"nodepath" => $path,
			"resultmode" => "decotl"
		));
		return $api->invoke();
	}
	/**
	 * @return affected roaws
	 * Enter description here ...
	 * @param unknown_type $path
	 */
	public function remove($path){
		if($path == "/"){
			throw new Exception("Remove root is not allowed.", 0x123);
		}
		$api = new nodeApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"nodepath" => $path,
		));
		return $api->invoke();
	}
	public function append($nodepath,$nt,$key,$order,$type,$label){
		$api = new nodeApi();
		$api->setMethod("post");
		$api->setArgs(array(
			"nodepath" => $nodepath,
			"nt" => $nt,
			"key" => $key,
			"order" => $order,
			"type" => $type,
			"label" => $label,
		));
		return $api->invoke();
	}
	public function update($nodepath,$key,$order,$type,$label){
		$api = new nodeApi();
		$api->setMethod("put");
		$api->setArgs(array(
			"nodepath" => $nodepath,
			"key" => $key,
			"order" => $order,
			"type" => $type,
			"label" => $label,
		));
		return $api->invoke();
	}
	public function nodeInfo($path){
		$api = new nodeApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"nodepath" => $path,
			"resultmode" => "foredit"
		));
		return $api->invoke();
	}
	
	public function getTypes(){
		$api = new typeApi();
		$api->setMethod("get");
		$api->setArgs(array());
		return $api->invoke();
	}
	public function getLabels(){
		$api = new labelApi();
		$api->setMethod("get");
		$api->setArgs(array());
		return $api->invoke();
	}
	public function defaultNodeValue(){
		return array(
			"key" => "",
			"order" => "100",
			"type" => 0,
			"label" => 0
		);
	}
}