<?php
/**
 * @author:awei.tian
 * @date: 2014-11-15
 * @functions:
 */
class memberView extends pview{

	public function showList($data,$cur,$cond){
		$this->content = $this->fetch(array("data"=>$data,"cur"=>$cur,"cond"=>$cond), "tpl");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function update($data){
		$this->content = $this->fetch(array("data"=>$data), "rank");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function resetpwd($data){
		$this->content = $this->fetch(array("data"=>$data), "resetpwd");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function view($data){
		$this->content = $this->fetch(array("data"=>$data), "view");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
}