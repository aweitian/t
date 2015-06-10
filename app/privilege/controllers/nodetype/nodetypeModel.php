<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

require_once ENTRY_PATH."/app/api/privilege/data/typeApi.php";

class nodetypeModel extends pmodel{
	public function __construct(){
		$this->_initdb();
	}
	public function getData(){
		$api = new typeApi();
		$api->setMethod("get");
		$api->setArgs(array());
		return $api->invoke();
	}
	/**
	 * @return affected roaws
	 * Enter description here ...
	 * @param unknown_nodetype $path
	 */
	public function remove($tk){
		$api = new typeApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"tk" => $tk,
		));
		return $api->invoke();
	}
	public function append($tv){
		$api = new typeApi();
		$api->setMethod("post");
		$api->setArgs(array("tv"=>$tv));
		return $api->invoke();
	}
	public function update($tk,$tv){
		$api = new typeApi();
		$api->setMethod("put");
		$api->setArgs(array(
			"tk"=>$tk,
			"tv"=>$tv
		));
		return $api->invoke();
	}
	public function info($tk){
		$api = new typeApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"tk" => $tk,
		));
		return $api->invoke();
	}
	public function defaultValue(){
		return array(
			"tv" => ""
		);
	}
//build post data
	private function _build_post_data($msg){
		
		
	}	
}