<?php
/**
 * Date: 2014-10-15
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once DATA_PATH."/widget/widgetInfo.php";
require_once DATA_PATH."/widget/widgetOp.php";
class widgetApi extends aApi{
	private $helper;
	public function __construct(){
		
	}
	/**
	 * @return bool
	 * @see IApi::invoke()
	 */
	public function invoke(){
		if($this->isGet()){
			return $this->_listwidget();
		}else if($this->isPost()){
			return $this->_addwidget();
		}else if($this->isPut()){
			return $this->_updatewidget();
		}else if($this->isDelete()){
			return $this->_removewidget();
		}
	}
	/**
	 * path
	 */
	private function _listwidget(){
		$this->helper = new widgetInfo();
//		var_dump($this->scenario,$this->args["path"]);exit;
		switch ($this->scenario){
			case "forlist":
				if(!isset($this->args["path"])){
					throw new Exception("invalid path", 0x258);
				}
				return $this->helper->getWidgets($this->args["path"]);
			case "maxorder":
				if(!isset($this->args["path"])){
					throw new Exception("invalid path", 0x258);
				}
				return $this->helper->getMaxOrder($this->args["path"]);
			default:
				if(!isset($this->args["path"])){
					throw new Exception("invalid path", 0x258);
				}
				if(!isset($this->args["order"])){
					throw new Exception("invalid order", 0x258);
				}
				return $this->helper->getInfo($this->args["path"], $this->args["order"]);
		}
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _addwidget(){
		//,,,,,
// 		var_dump($this->args);exit;
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x1);
		}
		if(!isset($this->args["order"])){
			throw new Exception("invalid args: order", 0x2);
		}
		if(!isset($this->args["typeid"])){
			throw new Exception("invalid args: typeid", 0x3);
		}
		if(!isset($this->args["datasrcpath"])){
			throw new Exception("invalid args: datasrcpath", 0x4);
		}
		if(!isset($this->args["confpath"])){
			throw new Exception("invalid args: confpath", 0x5);
		}
		if(!isset($this->args["ordertpl"])){
			throw new Exception("invalid args: ordertpl", 0x5);
		}
		if(!isset($this->args["comment"])){
			$this->args["comment"] = '';
		}
		$this->helper = new widgetOp();
		$sid = $this->helper->add(
			$this->args["path"], 
			$this->args["order"], 
			$this->args["typeid"],
			$this->args["datasrcpath"],
			$this->args["confpath"],
			$this->args["ordertpl"],
			$this->args["comment"]
		);
		if($sid == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $sid;
	}
	private function _updatewidget(){
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x1);
		}
		if(!isset($this->args["old_order"])){
			throw new Exception("invalid args: old_order", 0x2);
		}
		if(!isset($this->args["new_order"])){
			throw new Exception("invalid args: new order", 0x2);
		}
		if(!isset($this->args["typeid"])){
			throw new Exception("invalid args: typeid", 0x3);
		}
		if(!isset($this->args["datasrcpath"])){
			throw new Exception("invalid args: datasrcpath", 0x4);
		}
		if(!isset($this->args["confpath"])){
			throw new Exception("invalid args: confpath", 0x5);
		}
		if(!isset($this->args["ordertpl"])){
			throw new Exception("invalid args: ordertpl", 0x5);
		}
		if(!isset($this->args["comment"])){
			$this->args["comment"] = '';
		}
		$this->helper = new widgetOp();
		$rows = $this->helper->update(
			$this->args["path"], 
			$this->args["old_order"], 
			$this->args["new_order"], 
			$this->args["typeid"],
			$this->args["datasrcpath"],
			$this->args["confpath"],
			$this->args["ordertpl"],
			$this->args["comment"]
		);
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;		
	}
	private function _removewidget(){
//		var_dump($this->args);exit;
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x1);
		}
		if(!isset($this->args["order"])){
			throw new Exception("invalid args: order", 0x2);
		}
		$this->helper = new widgetOp();
		//exit($this->args["widgetpath"]);
		$rows = $this->helper->remove($this->args["path"],$this->args["order"]);
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;
	}
}