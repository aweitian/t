<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
class nodelabelView extends pview{
	public function __construct(){
	}
	public function showList($data){
		$this->content = $this->listNode($data);
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function add($submit_path,$default){
		$this->content = $this->nodeUI($submit_path,$default,"add");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function edit($submit_path,$default){
		$this->content = $this->nodeUI($submit_path,$default,"edit");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	
	private function nodeUI($submit_path,$default,$mode){
		ob_start();
		include_once dirname(__FILE__)."/tpl/item.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	private function listNode($data){
		ob_start();
		include_once dirname(__FILE__)."/tpl/list.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	
}