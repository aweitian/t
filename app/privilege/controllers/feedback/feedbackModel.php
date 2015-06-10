<?php
/**
 * @author:awei.tian
 * @date: 2015-4-9
 * @functions:
 */
require_once ENTRY_PATH.'/app/api/privilege/data/feedbackApi.php';
class feedbackModel extends model{
	public function getData($page){
		$api = new feedbackApi();
		$api->setMethod("get");
		$api->setArgs(array(
				"offset" => $page * 10,
				"len" => 10
		));
		return $api->invoke();
	}
	public function getDataByCond($page,$cond){
		$api = new feedbackApi();
		$api->setMethod("get");
		$api->setArgs(array(
				"cond" => $cond,
				"offset" => $page * 10,
				"len" => 10
		));
		return $api->invoke();
	}
	public function remove($sid){
		$api = new feedbackApi();
		$api->setMethod("delete");
		$api->setArgs(array(
			"sid" => $sid
		));
		return $api->invoke();
	}
	public function getDataBySid($sid){
		$api = new feedbackApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"sid" => $sid
		));
		return $api->invoke();
	}
	public function reply($sid,$reply){
		$api = new feedbackApi();
		$api->setMethod("put");
		$api->setArgs(array(
				"sid" => $sid,
				"reply" => $reply
		));
		return $api->invoke();
	}
}