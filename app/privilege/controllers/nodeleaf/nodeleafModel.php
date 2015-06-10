<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
require_once ENTRY_PATH."/app/api/privilege/data/widgetApi.php";
class nodeleafModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getData($path){
			$api = new widgetApi();
			$api->setMethod("get");
			$api->setScenario("forlist");
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
		$api = new nodeleafApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"nodeleafpath" => $path,
		));
		return $api->invoke();
	}
	public function append($nodeleafpath,$nt,$key,$order,$type,$label){
		$api = new nodeleafApi();
		$api->setMethod("post");
		$api->setArgs(array(
			"nodeleafpath" => $nodeleafpath,
			"nt" => $nt,
			"key" => $key,
			"order" => $order,
			"type" => $type,
			"label" => $label,
		));
		return $api->invoke();
	}
	public function update($nodeleafpath,$key,$order,$type,$label){
		$api = new nodeleafApi();
		$api->setMethod("put");
		$api->setArgs(array(
			"nodeleafpath" => $nodeleafpath,
			"key" => $key,
			"order" => $order,
			"type" => $type,
			"label" => $label,
		));
		return $api->invoke();
	}
	public function nodeleafInfo($path,$order){
		$api = new widgetApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"nodeleafpath" => $path,
			"resultmode" => "foredit"
		));
		return $api->invoke();
	}
	
	
	public function defaultnodeleafValue(){
		return array(
			"key" => "",
			"order" => "100",
			"type" => 0,
			"label" => 0
		);
	}
}