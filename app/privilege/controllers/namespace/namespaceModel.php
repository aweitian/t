<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
require_once ENTRY_PATH."/app/api/privilege/data/namespaceApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/typeApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/labelApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/orderFieldApi.php";
class namespaceModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getDaArr(){
		$api = new orderFieldApi();
		$api->setMethod("get");
		$api->setArgs(array());
		$api->setScenario("forkvs");
		return $api->invoke();
	}
	public function getData($path){
		$api = new namespaceApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"path" => $path,
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
		$api = new namespaceApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"path" => $path,
		));
		return $api->invoke();
	}
	public function append($path,$nt,$key,$order,$da){
		$api = new namespaceApi();
		$api->setMethod("post");
		$api->setArgs(array(
			"path" => $path,
			"nt" => $nt,
			"key" => $key,
			"order" => $order,
			"da" => $da,
		));
		return $api->invoke();
	}
	public function update($path,$key,$order,$da){
		$api = new namespaceApi();
		$api->setMethod("put");
		$api->setArgs(array(
			"path" => $path,
			"order" => $order,
			"key" => $key,
			"da" => $da,
		));
		return $api->invoke();
	}
	public function info($path){
		$api = new namespaceApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"path" => $path,
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
	public function defaultValue(){
		return array(
			"key" => "",
//			"nt" => "file",#因为这个类型不允许修改
			"order" => "88",
			"da"=>""
		);
	}
}