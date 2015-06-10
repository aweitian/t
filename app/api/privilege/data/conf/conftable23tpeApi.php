<?php
/**
 * Date: 2014-12-1
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once ENTRY_PATH."/app/data/conf/op/table_23tpeOp.php";
require_once ENTRY_PATH."/app/data/conf/op/table_23tpeInfo.php";
class conftable23tpeApi extends aApi{
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
	private function _list(){
		$this->helper = new table_23tpeInfo($this->args["path"]);
		return $this->helper->getConf();
	}
	private function _add(){
		//var_dump($this->args);exit;
		if(!isset($this->args["path"])){
			throw new Exception("invalid path",0x11);
		}
		if(!isset($this->args["data"])){
			throw new Exception("invalid data",0x22);
		}
		$this->helper = new table_23tpeOp();
		$sid = $this->helper->add(
			$this->args["path"],json_decode($this->args["data"],true)
		);
		if($sid == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $sid;
	}
	private function _update(){
		//var_dump($this->args);exit;
		if(!isset($this->args["path"])){
			throw new Exception("invalid path",0x11);
		}
		if(!isset($this->args["data"])){
			throw new Exception("invalid data",0x22);
		}
		$this->helper = new table_23tpeOp();
		$rows = $this->helper->update(
				$this->args["path"],json_decode($this->args["data"],true)
		);
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;
	}
	private function _remove(){
		if(!isset($this->args["path"])){
			throw new Exception("invalid path",0x11);
		}
		$this->helper = new table_23tpeOp();
		$rows = $this->helper->remove($this->args["path"]);
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;
	}
}