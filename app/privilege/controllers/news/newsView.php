<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
class newsView extends pview{

	public function showList($data,$cur){
		$this->content = $this->fetch(array("data"=>$data,"cur"=>$cur), "tpl");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function edit($data){
		$this->content = $this->fetch(array("data"=>$data,"mode"=>"edit"), "edit");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function add($data){
		$this->content = $this->fetch(array("data"=>$data,"mode"=>"add"), "edit");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
}