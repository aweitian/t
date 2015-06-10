<?php
/**
 * Date: 2014-11-30
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once ENTRY_PATH."/app/data/confkey/confkeyInfo.php";
require_once ENTRY_PATH."/app/data/confkey/confkeyOp.php";
class confkeyApi extends aApi{
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
	 */
	private function _list(){
		switch($this->scenario){
			case "foredit":
				$this->helper = new confkeyInfo($this->args["path"]);
				return $this->helper->getInfo();
			case "forlist":
			default:
				$this->helper = new confkeyInfo($this->args["path"]);
				return $this->helper->getChildInfo();
		}
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _add(){
		//var_dump($this->args);exit;
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x1);
		}
		if(!isset($this->args["key"])){
			throw new Exception("invalid args: key", 0x2);
		}
		if(!isset($this->args["comment"])){
			throw new Exception("invalid args: comment", 0x4);
		}
		if(!isset($this->args["type"])){
			throw new Exception("invalid args: type", 0x5);
		}

		$this->helper = new confkeyOp();
		$sid = $this->helper->add(
			$this->args["path"],$this->args["key"],
			$this->args["type"],
			$this->args["comment"]
		);
		if($sid == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $sid;
	}
	private function _update(){
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x1);
		}
		if(!isset($this->args["comment"])){
			throw new Exception("invalid args: comment", 0x5);
		}
		if(!isset($this->args["oldkey"])){
			throw new Exception("invalid args: oldkey", 0x6);
		}
		if(!isset($this->args["newkey"])){
			throw new Exception("invalid args: newkey", 0x7);
		}
		$this->helper = new confkeyOp();
		$rows = $this->helper->update($this->args["path"], $this->args["oldkey"],$this->args["newkey"],
				$this->args["comment"]
		);
//			var_dump($rows);exit;
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;
	}
	private function _remove(){
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x2);
		}
		$this->helper = new confkeyOp();
		//exit($this->args["nodepath"]);
		$rows = $this->helper->remove($this->args["path"]);
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;
	}
}