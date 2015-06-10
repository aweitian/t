<?php
/**
 * @author:awei.tian
 * @date: 2014-10-17
 * @functions:
 */
require_once ENTRY_PATH."/app/api/aApi.php";
require_once ENTRY_PATH."/app/data/order/orderOp.php";
require_once ENTRY_PATH."/app/data/order/orderInfo.php";
class orderApi extends aApi{
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
		if(!isset($this->args["delivery_type"],$this->args["title"],$this->args["price"],$this->args["nodepath"],$this->args["widget_order"],$this->args["loc_price"],$this->args["deliveryData"],$this->args["ip"])){
			throw new Exception("invalid order args",0x9);
		}
		$this->helper = new orderOp();
		return $this->helper->add($this->args["delivery_type"],$this->args["title"],$this->args["price"],$this->args["nodepath"],$this->args["widget_order"],$this->args["loc_price"],$this->args["deliveryData"],$this->args["ip"]);
	}
	public function _list(){
		$this->helper = new orderInfo();
		switch ($this->scenario){
			case "pre":
				if(!isset($this->args["locInfo"])){
					throw new Exception("require amt",1);
				}
				if(!isset($this->args["ns"])){
					throw new Exception("require ns",1);
				}
				if(!isset($this->args["dksid"])){
					throw new Exception("require dksid",1);
				}
				if(!isset($this->args["delivery"])){
					throw new Exception("require delivery",1);
				}
				if(!isset($this->args["wigord"])){
					throw new Exception("require wigord",1);
				}
				if(!isset($this->args["np"])){
					throw new Exception("require np",1);
				}
				$locInfo = json_decode($this->args["locInfo"],true);
				if(!$locInfo){
					throw new Exception("invalid locInfo",0x2);
				}
// 				var_dump($locInfo);exit;
				return $this->helper->prebi(
						$this->args["dksid"], 
						$this->args["ns"], 
						$locInfo, 
						$this->args["np"], 
						$this->args["delivery"], 
						$this->args["wigord"]
				);
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