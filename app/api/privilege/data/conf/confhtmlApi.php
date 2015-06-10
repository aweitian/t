<?php
/**
 * Date: 2014-12-1
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once ENTRY_PATH."/app/data/conf/op/table_hotOp.php";
require_once ENTRY_PATH."/app/data/conf/op/table_hotInfo.php";
class confhtmlApi extends aApi{
	private $helper;
	public function __construct(){

	}
	/**
	 * @return bool
	 * @see IApi::invoke()
	 */
	public function invoke(){
		if($this->isGet()){
			return $this->_list();
		}else if($this->isPost()){
			return $this->_add();
		}else if($this->isPut()){
			return $this->_update();
		}else if($this->isDelete()){
			return $this->_remove();
		}
	}
	private function _list(){
		return array("dumb"=>1);
	}
	private function _add(){
		return 1;
	}
	private function _update(){
		return 1;
	}
	private function _remove(){
		return 1;
	}
}