<?php
/**
 * @author:awei.tian
 * @date: 2014-10-17
 * @functions:
 */
require_once ENTRY_PATH."/app/api/aApi.php";
require_once ENTRY_PATH."/app/data/orderField/orderFieldInfo.php";
require_once ENTRY_PATH."/app/data/orderField/orderFieldOp.php";
class orderFieldApi extends aApi{
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
		if(!isset($this->args["key"])){
			throw new Exception("require key",0x9);
		}
		if(!isset($this->args["val"])){
			throw new Exception("require value",0x9);
		}
		if(!isset($this->args["typ"])){
			throw new Exception("require typ",0x9);
		}
		if(!isset($this->args["len"])){
			throw new Exception("require len",0x9);
		}
		if(!isset($this->args["ept"])){
			throw new Exception("require ept",0x9);
		}
		if(!isset($this->args["comment"])){
			throw new Exception("require comment",0x9);
		}
		$this->helper = new orderFieldOp();
		return $this->helper->add($this->args["key"],$this->args["val"],$this->args["typ"],
				$this->args["len"],$this->args["ept"],$this->args["comment"]);
	}
	public function _list(){
		$this->helper = new orderFieldInfo();
		switch ($this->scenario){
			case "forlist":
				return $this->helper->getList();
			case "forkvs":
				return $this->helper->getKvs();
			case "all":
				return $this->helper->all();
			default:
				if(!isset($this->args["keylist"])){
					throw new Exception("require keylist",0x9);
				}
				return $this->helper->get($this->args["keylist"]);	
		}
		
	}
	public function _remove(){
		if(!isset($this->args["key"])){
			throw new Exception("require key",0x9);
		}
		$this->helper = new orderFieldOp();
		return $this->helper->remove($this->args["key"]);
	}
	public function _update(){
		if(!isset($this->args["key"])){
			throw new Exception("require key",0x9);
		}
		if(!isset($this->args["val"])){
			throw new Exception("require value",0x9);
		}
		if(!isset($this->args["typ"])){
			throw new Exception("require typ",0x9);
		}
		if(!isset($this->args["len"])){
			throw new Exception("require len",0x9);
		}
		if(!isset($this->args["ept"])){
			throw new Exception("require ept",0x9);
		}
		if(!isset($this->args["comment"])){
			throw new Exception("require comment",0x9);
		}
		$this->helper = new orderFieldOp();
		return $this->helper->update($this->args["key"],$this->args["val"],$this->args["typ"],
				$this->args["len"],$this->args["ept"],$this->args["comment"]);
	}
}