<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
class privusrView extends pview{

	public function showList($data){
		$this->content = $this->fetch(array("data"=>$data), "tpl");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function reply($data){
		$this->content = $this->fetch(array("data"=>$data), "reply");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
}