<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

require_once ENTRY_PATH."/app/api/privilege/data/deliveryApi.php";
require_once ENTRY_PATH."/app/api/privilege/data/orderFieldApi.php";
class deliveryModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getData(){
		$api = new orderFieldApi();
		$api->setMethod("get");
		$api->setScenario("all");
		$api->setArgs(array(

		));
		return $api->invoke();
	}
	/**
	 * @return affected roaws
	 * Enter description here ...
	 * @param unknown_type $path
	 */
	public function remove($key){
		$api = new orderFieldApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"key" => $key,
		));
		return $api->invoke();
	}
	public function append($key,$val,$typ,$len,$ept,$comment){
		$api = new orderFieldApi();
		$api->setMethod("post");
		$api->setArgs(array(
			"key"=>$key,
			"val"=>$val,
			"typ"=>$typ,
			"len"=>$len,
			"ept"=>$ept,
			"comment"=>$comment,
		));
		return $api->invoke();
	}
	public function update($msg){
		$api = new deliveryApi();
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
			"key" => "",
			"val" => "",
			"typ" => "input_str",
			"len" => "25",
			"ept" => "no",
			"comment" => ""
		);
	}
}