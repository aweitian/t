<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
class widgetView extends pview{
	public function __construct(){
	}
	public function showList($path,$data){
		$this->content = $this->listNode($path,$data);
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function add($path,$append_path,$default,$tplArr){
		$this->content = $this->nodeUI($path,$append_path,$default,$tplArr,"add");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function edit($path,$append_path,$default,$tplArr){
		$this->content = $this->nodeUI($path,$append_path,$default,$tplArr,"edit");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function editdstype($path,$append_path,$default){
		$this->content = $this->nodeUI($path,$append_path,$default,"editdstype");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function autoCompleteDk($cur){
		$cur = explode("_", $cur);
		if(count($cur) == 2){
			$cur = $cur[1];
		}else{
			$cur = $cur[0];
		}
		$demo = new listDk();
		return $demo->getDsList($cur);
	}
	public function autoCompleteCk($cur){
		$demo = new listCk();
		$ret = $demo->getCkList($cur);
		return $ret;
	}	
	private function nodeUI($path,$append_path,$defaultValue,$tplArr,$mode){
		ob_start();
		include_once dirname(__FILE__)."/tpl/item.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	private function listNode($path,$data){
		ob_start();
		include_once dirname(__FILE__)."/tpl/list.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	
}