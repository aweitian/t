<?php
/**
 * @author:awei.tian
 * @date: 2014-11-14
 * @functions:
 */
class deliveryTypeView extends pview{
	public function __construct(){
	}
	public function deliveryType($data){
		$this->content = $this->_list($data);
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function add($submit_path,$data,$fields){
		$this->content = $this->_item($submit_path,$data,$fields,"add");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	public function edit($submit_path,$data,$fields){
		$this->content = $this->_item($submit_path,$data,$fields,"edit");
		include_once APP_PATH."/privilege/tpl/layout.tpl.php";
	}
	private function _list($data){
		ob_start();
		include_once dirname(__FILE__)."/tpl/list.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
	private function _item($submit_path,$data,$fields,$mode){
		ob_start();
		include_once dirname(__FILE__)."/tpl/item.tpl.php";
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
}