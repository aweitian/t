<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

require_once ENTRY_PATH."/app/api/privilege/data/dataKeysApi.php";

class datakeyModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getData($path){
		$api = new dataKeysApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"nodepath" => $path,
		));
		return $api->invoke();
	}
	/**
	 * @return affected roaws
	 * Enter description here ...
	 * @param unknown_type $path
	 */
	public function remove($path){
		$api = new dataKeysApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"path" => $path,
		));
		return $api->invoke();
	}
	public function append($nodepath,$dstype,$key,$deco,$comment,$nsroottype){
		$api = new dataKeysApi();
		$api->setMethod("post");
		$api->setArgs(array(
			"nodepath" => $nodepath,
			"dstype" => $dstype,
			"key" => $key,
			"deco" => $deco,
			"comment" => $comment,
			"nsroottype" => $nsroottype,
		));
		return $api->invoke();
	}
	public function update($path,$key,$deco,$comment){
		$api = new dataKeysApi();
		$tmp = explode("?",$path);
		$api->setMethod("put");
		$api->setArgs(array(
			"nodepath" => $tmp[0],
			"newkey" => $key,
			"oldkey" => $tmp[1],
			"deco" => $deco,
			"comment" => $comment,
		));
		return $api->invoke();
	}
	public function updatedstype($path,$dstype){
		$api = new dataKeysApi();
		$tmp = explode("?",$path);
		$api->setMethod("put");
//		var_dump($dstype);exit;
		$api->setArgs(array(
			"nodepath" => $tmp[0],
			"key" => $tmp[1],
			"_dstype" => 1,
			"dstype" => $dstype,
		));
		return $api->invoke();
	}
	public function info($path){
		$api = new dataKeysApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"path" => $path,
		));
		return $api->invoke();
	}
	public function defaultValue(){
		return array(
			"key" => "",
			"dstype" => "",
			"deco" => "",
			"comment" => "",
			"nsroottype" => "file"
		);
	}
}