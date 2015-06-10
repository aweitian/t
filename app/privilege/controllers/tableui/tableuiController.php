<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
require ENTRY_PATH."/app/api/privilege/ui/tableUiApi.php";
class tableuiController extends privilege{
	public function __construct(){
		$this->_init();
	}
	public function welcomeAction(message $msg){
		$api = new tableUiApi();
		$api->setMethod("get");
		$api->setArgs(array(
			"datasrc_path"=>"/?zxs/c",
			"conf_path"=>"/?new22tp",
		));
		print($api->invoke());
	}

}