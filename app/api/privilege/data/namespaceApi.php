<?php
/**
 * Date: 2014-10-15
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once DATA_PATH."/namespace/namespaceInfo.php";
require_once DATA_PATH."/namespace/namespaceOp.php";
require_once DATASRC_PATH."/dataSrc.php";
class namespaceApi extends aApi{
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
		if(!isset($this->args["path"])){
			throw new Exception("invalid path:".$this->args["path"],0x2);
		}
		if(isset($this->args["resultmode"]) && $this->args["resultmode"] == "foredit"){
			$this->helper = new namespaceInfo($this->args["path"]);
			return $this->helper->getInfo();			
		}else{
			$this->helper = new namespaceInfo($this->args["path"]);
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
		if(!isset($this->args["nt"])){
			throw new Exception("invalid args: path", 0x3);
		}
		if(!isset($this->args["order"])){
			throw new Exception("invalid args: order", 0x4);
		}
		if(!isset($this->args["da"])){
			throw new Exception("invalid args: da", 0x4);
		}

		$this->helper = new namespaceOp();
		//add($path,$key,$name)
		$sid = $this->helper->add(
			$this->args["path"],$this->args["key"],
			$this->args["nt"],
			$this->args["da"],
			$this->args["order"]
		);
		if($sid == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $sid;
	}
	private function _update(){
//		var_dump($this->args);exit;
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x1);
		}
		if(!isset($this->args["order"])){
			throw new Exception("invalid args: order", 0x4);
		}
		if(!isset($this->args["key"])){
			throw new Exception("invalid args: key", 0x5);
		}
		if(!isset($this->args["da"])){
			throw new Exception("invalid args: key", 0x5);
		}
		$this->helper = new namespaceOp();
		//($nodepath,$oldkey,$newkey,$dstype,$deco="",$comment="")
		$rows = $this->helper->update(
			$this->args["path"],$this->args["key"],$this->args["order"],$this->args["da"]
		);
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;
	}
	private function _remove(){
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x1);
		}
		$this->helper = new namespaceOp();
		//exit($this->args["nodepath"]);
		$rows = $this->helper->remove($this->args["path"]);
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;
	}
}