<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
class confView extends pview{
	public function __construct(){
	}
	public function conf($path,$data){
		$this->content = $this->nodeUI($path,empty($data["conf"])?ENTRY_HOME."/priv/conf/add":ENTRY_HOME."/priv/conf/edit",$data,"show");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function add($path,$submit_path,$data){
		$this->content = $this->nodeUI($path,$submit_path,$data,"add");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function edit($path,$submit_path,$data){
		$this->content = $this->nodeUI($path,$submit_path,$data,"edit");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	private function nodeUI($path,$submit_path,$data,$mode){
		ob_start();
		include_once dirname(__FILE__)."/tpl/item.".$data["type"].".tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
}