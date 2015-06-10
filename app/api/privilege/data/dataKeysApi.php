<?php
/**
 * Date: 2014-10-15
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once DATA_PATH."/datakey/datakeyInfo.php";
require_once DATA_PATH."/datakey/datakeyOp.php";
class dataKeysApi extends aApi{
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
		if(isset($this->args["path"])){
			$this->helper = new datakeyInfo($this->args["path"]);
			return $this->helper->getInfo();
		}else if(isset($this->args["dstype"])){
			$this->helper = new datakeyInfo($this->args["path"]);
			return $this->helper->getInfo();
		}else{
			if(isset($this->args["nodepath"]))
			$nodepath = $this->args["nodepath"];
			else $nodepath = "/";
			$this->helper = new datakeyInfo($nodepath);
			return $this->helper->getChildDetails();			
		}
//		exit(var_dump($priv));

	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _add(){
		//var_dump($this->args);exit;
		if(!isset($this->args["nodepath"])){
			throw new Exception("invalid args: nodepath", 0x1);
		}
		if(!isset($this->args["key"])){
			throw new Exception("invalid args: key", 0x2);
		}
		if(!isset($this->args["deco"])){
			throw new Exception("invalid args: deco", 0x3);
		}
		if(!isset($this->args["comment"])){
			throw new Exception("invalid args: comment", 0x4);
		}
		if(!isset($this->args["dstype"])){
			throw new Exception("invalid args: dstype", 0x5);
		}
		if(!isset($this->args["nsroottype"])){
			throw new Exception("invalid args: nsroottype", 0x5);
		}

		$this->helper = new datakeyOp();
		$sid = $this->helper->add(
			$this->args["nodepath"],
			$this->args["key"],
			$this->args["dstype"],
			$this->args["deco"],
			$this->args["comment"],
			$this->args["nsroottype"]
		);
		if($sid == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $sid;
	}
	private function _update(){
		if(!isset($this->args["nodepath"])){
			throw new Exception("invalid args: nodepath", 0x1);
		}
		if(isset($this->args["_dstype"])){
			if(!isset($this->args["dstype"])){
				throw new Exception("invalid args: dstype", 0x2);
			}
			if(!isset($this->args["key"])){
				throw new Exception("invalid args: key", 0x3);
			}
			$this->helper = new datakeyOp();
//			var_dump($this->args["nodepath"], $this->args["key"],$this->args["dstype"]);exit;
			$rows = $this->helper->updateDstype($this->args["nodepath"], $this->args["key"],$this->args["dstype"]);
			if($rows == 0){
				$info = $this->helper->pdo->getErrorInfo();
				throw new Exception($info[2], $info[0]);
			}
			return $rows;
		}else{
			if(!isset($this->args["deco"])){
				throw new Exception("invalid args: deco", 0x4);
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
			$this->helper = new datakeyOp();
			$rows = $this->helper->update($this->args["nodepath"], $this->args["oldkey"],$this->args["newkey"],
					$this->args["deco"],$this->args["comment"]
			);
//			var_dump($rows);exit;
			if($rows == 0){
				$info = $this->helper->pdo->getErrorInfo();
				throw new Exception($info[2], $info[0]);
			}
			return $rows;
		}
		
			
	}
	private function _remove(){
		if(!isset($this->args["path"])){
			throw new Exception("invalid args: path", 0x2);
		}
		$this->helper = new datakeyOp();
		//exit($this->args["nodepath"]);
		$rows = $this->helper->remove($this->args["path"]);
		if($rows == 0){
			$info = $this->helper->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $rows;
		//($this->args["nodepath"], $this->args["name"],$this->args["order"]);
	}
}