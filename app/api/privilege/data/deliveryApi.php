<?php
/**
 * @author:awei.tian
 * @date: 2014-10-17
 * @functions:
 */
require_once ENTRY_PATH."/app/api/aApi.php";
require_once ENTRY_PATH."/app/data/delivery/deliveryOp.php";
require_once ENTRY_PATH."/app/data/delivery/deliveryInfo.php";

class deliveryApi extends aApi{
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
		if(!isset($this->args["type"])){
			throw new Exception("invalid type", 0x22);
		}
		if(!isset($this->args["data"])){
			throw new Exception("invalid data", 0x22);
		}
		$this->helper = new deliveryOp();
		return $this->helper->add($this->args["type"],json_decode($this->args["data"],true));
	}
	public function _list(){
		if(!isset($this->args["type"])){
			throw new Exception("invalid type", 0x22);
		}
		if(!isset($this->args["sid"])){
			throw new Exception("invalid sid", 0x22);
		}
		$this->helper = new deliveryInfo();
		return $this->helper->info($this->args["type"],$this->args["sid"]);
	}
	public function _remove(){
		if(!isset($this->args["type"])){
			throw new Exception("invalid type", 0x22);
		}
		if(!isset($this->args["sid"])){
			throw new Exception("invalid sid", 0x22);
		}
		$this->helper = new deliveryOp();
		return $this->helper->remove($this->args["type"],$this->args["sid"]);
	}
	public function _update(){
		throw new Exception("NOT SUPPORT",0x9);
	}
}