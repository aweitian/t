<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */

class namespaceView extends pview{
	public function __construct(){
	}
	public function showList($path,$data){
		$this->content = $this->_list($path,$data);
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function add($path,$append_path,$default,$daArr){
		$this->content = $this->_ui($path,$append_path,$default,$daArr,"add");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function edit($path,$append_path,$default,$daArr){
		$this->content = $this->_ui($path,$append_path,$default,$daArr,"edit");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	private function _ui($path,$append_path,$defaultValue,$daArr,$mode){
		ob_start();
		include_once dirname(__FILE__)."/tpl/item.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	private function _list($path,$data){
		ob_start();
		include_once dirname(__FILE__)."/tpl/list.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	
}