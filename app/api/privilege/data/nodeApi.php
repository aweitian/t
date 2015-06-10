<?php
/**
 * Date: 2014-10-15
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once DATA_PATH."/node/nodeInfo.php";
require_once DATA_PATH."/node/nodeOp.php";
class nodeApi extends aApi{
	private $helper;
	public function __construct(){
		
	}
	/**
	 * @return bool
	 * @see IApi::invoke()
	 */
	public function invoke(){
		if($this->isGet()){
			return $this->_listNode();
		}else if($this->isPost()){
			return $this->_addNode();
		}else if($this->isPut()){
			return $this->_updateNode();
		}else if($this->isDelete()){
			return $this->_removeNode();
		}
	}
	/**
	 * path
	 */
	private function _listNode(){
		if(isset($this->args["nodepath"]))
		$nodepath = $this->args["nodepath"];
		else $nodepath = "/";
		$resultMode = "raw";
		if(isset($this->args["resultmode"])){
			switch($this->args["resultmode"]){
				case "decotl":
				case "foredit":
					$resultMode = $this->args["resultmode"];
					break;
				
					
				default:
					break;
			}
		}
		$this->helper = new nodeInfo($nodepath);
		if($this->scenario == "listAllLeaf"){
			return $this->helper->getDescendantLeaf();
		}else{
			switch ($resultMode){
				case "decotl":
				case "raw":
					return $this->helper->getChildDetail($resultMode);
				case "foredit":
					return $this->helper->getNodeInfo();
				default:
					throw new Exception("result mode illegal", 0x12);
			}			
		}

		
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _addNode(){
// 		var_dump($this->args);exit;
		if(!isset($this->args["nodepath"])){
			throw new Exception("invalid args: nodepath", 0x1);
		}
		if(!isset($this->args["key"])){
			throw new Exception("invalid args: key", 0x2);
		}
		if(!isset($this->args["nt"])){
			throw new Exception("invalid args: nt", 0x3);
		}
		if(!isset($this->args["order"])){
			throw new Exception("invalid args: order", 0x4);
		}
		if(!isset($this->args["type"])){
			throw new Exception("invalid args: type", 0x5);
		}
		if(!isset($this->args["label"])){
			$this->args["label"] = array();
		}
		$this->helper = new nodeOp();
		$sid = $this->helper->addChild(
			$this->args["nodepath"], 
			$this->args["key"], 
			$this->args["nt"],$this->args["order"],
			$this->args["type"], $this->args["label"]
		);
		if($sid == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $sid;
	}
	private function _updateNode(){
		if(!isset($this->args["nodepath"])){
			throw new Exception("invalid args: nodepath", 0x1);
		}
		if(!isset($this->args["key"])){
			throw new Exception("invalid args: key", 0x2);
		}
		if(!isset($this->args["order"])){
			throw new Exception("invalid args: order", 0x4);
		}
		if(!isset($this->args["type"])){
			throw new Exception("invalid args: type", 0x5);
		}
		if(!isset($this->args["label"])){
			$this->args["label"] = array();
		}
		$this->helper = new nodeOp();
		$rows = $this->helper->updateChild($this->args["nodepath"], $this->args["key"],
				$this->args["order"],$this->args["type"], $this->args["label"]);
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;		
	}
	private function _removeNode(){
		if(!isset($this->args["nodepath"])){
			throw new Exception("invalid args: nodepath", 0x1);
		}
		$this->helper = new nodeOp();
		//exit($this->args["nodepath"]);
		$rows = $this->helper->remove($this->args["nodepath"]);
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;
	}
}