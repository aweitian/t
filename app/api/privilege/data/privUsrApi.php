<?php
/**
 * Date: 2015-1-21
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once ENTRY_PATH."/app/data/priv/privInfo.php";
require_once ENTRY_PATH."/app/data/priv/privOp.php";
class privUsrApi extends aApi{
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
		$this->helper = new privInfo();
		if(isset($this->args["name"],$this->args["pwd"])){
			return $this->helper->infoByNamePwd($this->args["name"],$this->args["pwd"]);
		}else if(isset($this->args["sid"])){
			return $this->helper->infoById($this->args["sid"]);
		}else{
			return $this->helper->all();
		}
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _add(){
		$this->helper = new privOp();
		if(isset($this->args["name"],$this->args["pass"],$this->args["priv"])){
			return $this->helper->add($this->args["name"],$this->args["pass"],$this->args["priv"]);
		}
		throw new Exception("invalid args",2);
	}
	private function _update(){
		$this->helper = new privOp();
		if(isset($this->args["sid"],$this->args["oldpwd"],$this->args["newpwd"])){
			return $this->helper->updatePwdBySid($this->args["sid"],$this->args["oldpwd"],$this->args["newpwd"]);
		}
		throw new Exception("invalid args",2);
	}
	private function _remove(){
		$this->helper = new privOp();
		if(isset($this->args["sid"])){
			return $this->helper->removeBySid($this->args["sid"]);
		}
		throw new Exception("invalid args", 1);
	}
}