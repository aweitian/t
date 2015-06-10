<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

require_once ENTRY_PATH."/app/api/privilege/data/labelApi.php";

class nodelabelModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getData(){
		$api = new labelApi();
		$api->setMethod("get");
		$api->setArgs(array());
		return $api->invoke();
	}
	/**
	 * @return affected roaws
	 * Enter description here ...
	 * @param unknown_nodelabel $path
	 */
	public function remove($lk){
		$api = new labelApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"lk" => $lk,
		));
		return $api->invoke();
	}
	public function append($lv){
		$api = new labelApi();
		$api->setMethod("post");
		$api->setArgs(array("lv"=>$lv));
		return $api->invoke();
	}
	public function update($lk,$lv){
		$api = new labelApi();
		$api->setMethod("put");
		$api->setArgs(array(
			"lk"=>$lk,
			"lv"=>$lv
		));
		return $api->invoke();
	}
	public function info($lk){
		$api = new labelApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"lk" => $lk,
		));
		return $api->invoke();
	}
	public function defaultValue(){
		return array(
			"lv" => ""
		);
	}
//build post data
	private function _build_post_data($msg){
		
		
	}	
}