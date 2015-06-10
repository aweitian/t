<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

require_once ENTRY_PATH."/app/api/privilege/data/confkeyApi.php";

class confkeyModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getData($path){
		$api = new confkeyApi();
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
		$api = new confkeyApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"path" => $path,
		));
		return $api->invoke();
	}
	public function append($path,$type,$key,$comment){
		$api = new confkeyApi();
		$api->setMethod("post");
		$api->setArgs(array(
			"path" => $path,
			"type" => $type,
			"key" => $key,
			"comment" => $comment,
		));
		return $api->invoke();
	}
	public function update($path,$key,$comment){
		$api = new confkeyApi();
		$tmp = explode("?",$path);
		$api->setMethod("put");
		$api->setArgs(array(
			"path" => $tmp[0],
			"newkey" => $key,
			"oldkey" => $tmp[1],
			"comment" => $comment,
		));
		return $api->invoke();
	}
	public function updatedstype($path,$dstype){
		$api = new confkeyApi();
		$tmp = explode("?",$path);
		$api->setMethod("put");
		$api->setArgs(array(
			"nodepath" => $tmp[0],
			"key" => $tmp[1],
			"_dstype" => 1,
			"dstype" => $dstype,
		));
		return $api->invoke();
	}
	public function info($path){
		$api = new confkeyApi();
		$api->setMethod("get");
		$api->setScenario("foredit");
		$api->setArgs(array(
			"path" => $path,
		));
		return $api->invoke();
	}
	public function defaultValue(){
		return array(
			"key" => "",
			"typeid" => "table_22tp",
			"comment" => ""
		);
	}
}