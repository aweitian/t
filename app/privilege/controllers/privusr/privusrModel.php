<?php
/**
 * @author:awei.tian
 * @date: 2015-4-9
 * @functions:
 */
require_once ENTRY_PATH.'/app/api/privilege/data/privUsrApi.php';
class privusrModel extends model{
	public function getData(){
		$api = new privUsrApi();
		$api->setMethod("get");
		$api->setArgs(array(

		));
		return $api->invoke();
	}
	public function getDataByCond($page,$cond){
		$api = new privUsrApi();
		$api->setMethod("get");
		$api->setArgs(array(
				"cond" => $cond,
				"offset" => $page * 10,
				"len" => 10
		));
		return $api->invoke();
	}
	public function remove($sid){
		$api = new privUsrApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"sid" => $sid
		));
		return $api->invoke();
	}
	public function getDataBySid($sid){
		$api = new privUsrApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"sid" => $sid
		));
		return $api->invoke();
	}
	public function reply($sid,$reply){
		$api = new privUsrApi();
		$api->setMethod("put");
		$api->setArgs(array(
				"sid" => $sid,
				"reply" => $reply
		));
		return $api->invoke();
	}
}