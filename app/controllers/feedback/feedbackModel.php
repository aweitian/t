<?php
/**
 * Date: 2015-5-8
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH.'/app/api/privilege/data/feedbackApi.php';
class feedbackModel extends appModel{
	public function getData($page){
		$api = new feedbackApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"offset" => $page * 10,
			"len" => 10	
		));
		return $api->invoke();
	}
}