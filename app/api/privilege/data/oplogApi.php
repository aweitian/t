<?php
/**
 * Date: 2015-1-21
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once ENTRY_PATH."/app/data/oplog/oplogInfo.php";
require_once ENTRY_PATH."/app/data/oplog/oplogOp.php";
class oplogApi extends aApi{
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
		$this->helper = new oplogInfo();
		if(isset($this->args["optype"],$this->args["ipaddr"])){
			return $this->helper->getCnt($this->args["optype"],$this->args["ipaddr"]);
		}else if(isset($this->args["ipaddr"],$this->args["offset"],$this->args["length"])){
			return $this->helper->searchByIp($this->args["ipaddr"],$this->args["offset"],$this->args["length"]);
		}else if(isset($this->args["data"],$this->args["offset"],$this->args["length"])){
			return $this->helper->searchByDate($this->args["date"],$this->args["offset"],$this->args["length"]);
		}else if(isset($this->args["ipaddr"],$this->args["data"],$this->args["offset"],$this->args["length"])){
			return $this->helper->searchByIpDate($this->args["ipaddr"],$this->args["data"],$this->args["offset"],$this->args["length"]);
		}else if(isset($this->args["offset"],$this->args["length"])){
			return $this->helper->all($this->args["offset"],$this->args["length"]);
		}
		throw new Exception("invalid args",1);
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _add(){
		//var_dump($this->args);exit;
		if(!isset($this->args["optype"])){
			throw new Exception("invalid args: optype", 0x1);
		}
		if(!isset($this->args["ipaddr"])){
			throw new Exception("invalid args: ipaddr", 0x2);
		}
		$this->helper = new oplogOp();
		$sid = $this->helper->add($this->args["optype"],$this->args["ipaddr"]);
		if($sid == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $sid;
	}
	private function _update(){
		if(!isset($this->args["sid"])){
			throw new Exception("invalid args: sid", 0x1);
		}
		$this->helper = new oplogOp();
		$sid = $this->helper->update($this->args["sid"]);
		if($sid == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $sid;
	}
	private function _remove(){
		$this->helper = new oplogOp();
		if(isset($this->args["date"])){
			$rows = $this->helper->removeByDate($this->args["date"]);
			if($rows == 0){
				$info = $this->helper->pdo->getErrorInfo();
				throw new Exception($info[2], $info[0]);
			}
			return $rows;
		}else if(isset($this->args["ip"])){
			$rows = $this->helper->removeByIp($this->args["ip"]);
			if($rows == 0){
				$info = $this->helper->pdo->getErrorInfo();
				throw new Exception($info[2], $info[0]);
			}
			return $rows;
		}
		throw new Exception("invalid args", 1);
	}
}