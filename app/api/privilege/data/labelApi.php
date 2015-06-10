<?php
/**
 * @author:awei.tian
 * @date: 2014-10-17
 * @functions:
 */
require_once ENTRY_PATH."/app/api/aApi.php";
require_once ENTRY_PATH."/app/data/label/labelInfo.php";
require_once ENTRY_PATH."/app/data/label/labelOp.php";
class labelApi extends aApi{
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
		if(!isset($this->args["lv"])){
			throw new Exception("invalid lv", 0x22);
		}
		$this->helper = new labelOp();
		return $this->helper->add($this->args["lv"]);
	}
	public function _list(){
		$this->helper = new labelInfo();
		if(!isset($this->args["lk"])){
			return $this->helper->get();
		}else{
			return $this->helper->info($this->args["lk"]);
		}
		
	}
	public function _remove(){
		if(!isset($this->args["lk"])){
			throw new Exception("invalid lk", 0x14);
		}
		$this->helper = new labelOp();
		return $this->helper->remove($this->args["lk"]);
	}
	public function _update(){
		if(!isset($this->args["lv"])){
			throw new Exception("invalid lv", 0x22);
		}
		if(!isset($this->args["lk"])){
			throw new Exception("invalid lk", 0x456);
		}
		$this->helper = new labelOp();
		return $this->helper->update($this->args["lk"],$this->args["lv"]);
	}
}