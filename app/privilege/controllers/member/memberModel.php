<?php
/**
 * @author:awei.tian
 * @date: 2015-4-9
 * @functions:
 */
require_once ENTRY_PATH.'/app/api/privilege/data/memberApi.php';
class memberModel extends model{
	public function getData($page){
		$api = new memberApi();
		$api->setMethod("get");
		$api->setArgs(array(
				"offset" => $page * 10,
				"length" => 10
		));
		return $api->invoke();
	}
	public function getDataByCond($page,$cond){
		$api = new memberApi();
		$api->setMethod("get");
		$api->setArgs(array(
				"cond" => $cond,
				"offset" => $page * 10,
				"length" => 10
		));
		return $api->invoke();
	}
	public function remove($sid){
		$api = new memberApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"sid" => $sid
		));
		return $api->invoke();
	}
	public function getDataBySid($sid){
		$api = new memberApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"sid" => $sid
		));
		return $api->invoke();
	}
	public function update($eml,$rank,$vid,$cnsm){
		$api = new memberApi();
		$api->setMethod("put");
		$api->setArgs(array(
			"eml" => $eml,
			"rank" => $rank,
			"vid" => $vid,
			"cnsm" => $cnsm,
		));
		return $api->invoke();
	}
	public function resetpwd($eml,$pwd,$sid){
		$api = new memberApi();
		$api->setMethod("put");
		$api->setArgs(array(
			"pwd" => $pwd,
			"sid" => $sid,
		));
		return $api->invoke();
	}
	
	
}