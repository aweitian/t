<?php
/**
 * @author:awei.tian
 * @date: 2014-12-5
 * @functions:
 */
require_once API_PATH."/aApi.php";
require_once ENTRY_PATH."/app/data/conf/confInfo.php";
require_once ENTRY_PATH."/app/data/conf/confOp.php";
class confApi extends aApi{
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
		$this->helper = new confInfo();
		return $this->helper->getConf($this->args["path"]);
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
		if(!isset($this->args["data"])){
			throw new Exception("invalid args: data", 0x2);
		}
		$this->helper = new confOp();
		$sid = $this->helper->add($this->args["path"],$this->args["data"]);
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
		if(!isset($this->args["data"])){
			throw new Exception("invalid args: data", 0x2);
		}
		$this->helper = new confOp();
		$sid = $this->helper->update($this->args["path"],$this->args["data"]);
		if($sid == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $sid;
	}
	private function _remove(){
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x2);
		}
		$this->helper = new confOp();
		//exit($this->args["nodepath"]);
		$rows = $this->helper->remove($this->args["path"]);
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;
	}
}