<?php
/**
 * @author:awei.tian
 * @date: 2014-10-17
 * @functions:
 */
require_once ENTRY_PATH."/app/api/aApi.php";
require_once ENTRY_PATH."/app/data/type/typeInfo.php";
require_once ENTRY_PATH."/app/data/type/typeOp.php";
class typeApi extends aApi{
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
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _add(){
		if(!isset($this->args["tv"])){
			throw new Exception("invalid tv", 0x90);
		}
		$this->helper = new typeOp();
		return $this->helper->add($this->args["tv"]);
	}
	public function _list(){
		$this->helper = new typeInfo();
		if(!isset($this->args["tk"])){
			return $this->helper->get();
		}else{
			return $this->helper->info($this->args["tk"]);
		}
		
	}
	public function _remove(){
		if(!isset($this->args["tk"]))return -1;
		$this->helper = new typeOp();
		return $this->helper->remove($this->args["tk"]);
	}
	public function _update(){
		if(!isset($this->args["tv"])){
			throw new Exception("invalid tv", 0x90);
		}
		if(!isset($this->args["tk"])){
			throw new Exception("invalid tk", 0x11);
		}
		$this->helper = new typeOp();
		return $this->helper->update($this->args["tk"],$this->args["tv"]);
	}
}