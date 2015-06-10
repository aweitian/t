<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
require_once ENTRY_PATH."/app/api/privilege/data/datasrcApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/typeApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/labelApi.php";
class datasrcModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getData($path){
		$api = new datasrcApi();
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
		$api = new datasrcApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"path" => $path,
		));
		return $api->invoke();
	}
	public function append($path,$dstype,$data){
		$api = new datasrcApi();
		$api->setMethod("post");
		$api->setArgs(array(
			"path" => $path,
			"dstype" => $dstype,
			"data" => $data,
		));
		return $api->invoke();
	}
	public function update($path,$dstype,$data){
		$api = new datasrcApi();
		$api->setMethod("put");
		$api->setArgs(array(
			"path" => $path,
			"dstype" => $dstype,
			"data" => $data,
		));
		return $api->invoke();
	}
	public function defaultValue(){
		return array(
			"key" => "",
//			"nt" => "file",#因为这个类型不允许修改
			"order" => "88",
		);
	}
}