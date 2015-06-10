<?php
/**
 * @author:awei.tian
 * @date: 2014-10-17
 * @functions:
 */
require_once ENTRY_PATH."/app/api/aApi.php";
require_once ENTRY_PATH."/app/data/orderTpl/orderTplInfo.php";
require_once ENTRY_PATH."/app/data/orderTpl/orderTplOp.php";
class orderTplApi extends aApi{
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
		if(!isset($this->args["name"])){
			throw new Exception("require name",0x9);
		}
		if(!isset($this->args["keylist"])){
			throw new Exception("require keylist",0x9);
		}
		$this->helper = new orderTplOp();
		return $this->helper->add($this->args["name"],$this->args["keylist"]);
	}
	public function _list(){
		if($this->scenario == "all"){
			$this->helper = new orderTplInfo();
			return $this->helper->getTplInfo();
		}else{
			if(!isset($this->args["name"])){
				$this->helper = new orderTplInfo();
				return $this->helper->getNameList();
			}else{
				$this->helper = new orderTplInfo();
				return $this->helper->getDeliveryInfos($this->args["name"]);
			}			
		}
	}
	public function _remove(){
		if(!isset($this->args["name"])){
			throw new Exception("require name",0x9);
		}
		$this->helper = new orderTplOp();
		return $this->helper->remove($this->args["name"]);
	}
	public function _update(){
		if(!isset($this->args["name"])){
			throw new Exception("require name",0x9);
		}
		if(!isset($this->args["enable"])){
			throw new Exception("require enable",0x9);
		}
		$this->helper = new orderTplOp();
		if($this->args["enable"] == "on"){
			return $this->helper->enable($this->args["name"]);
		}else{
			return $this->helper->disable($this->args["name"]);
		}
	}
}