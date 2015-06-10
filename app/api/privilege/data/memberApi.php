<?php
/**
 * Date: 2015-1-21
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once ENTRY_PATH."/app/data/member/memberInfo.php";
require_once ENTRY_PATH."/app/data/member/memberOp.php";
require_once ENTRY_PATH."/app/modules/member/memberModule.php";

class memberApi extends aApi{
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
		$this->helper = new memberInfo();
		if(isset($this->args["cond"],$this->args["offset"],$this->args["length"])){
			return $this->helper->search($this->args["cond"],$this->args["offset"],$this->args["length"]);
		}else if(isset($this->args["offset"],$this->args["length"])){
			return $this->helper->all($this->args["offset"],$this->args["length"]);
		}else if(isset($this->args["sid"])){
			return $this->helper->infoById($this->args["sid"]);
		}else if(isset($this->args["vid"],$this->args["pwd"])){
			return $this->helper->infoByVipidPwd($this->args["vid"],$this->args["pwd"]);
		}else if(isset($this->args["eml"],$this->args["pwd"])){
			return $this->helper->infoByEmlPwd($this->args["eml"],$this->args["pwd"]);
		}else if(isset($this->args["eml"])){
			return $this->helper->infoByEml($this->args["eml"]);
		}else if(isset($this->args["vid"])){
			return $this->helper->infoByVipid($this->args["vid"]);
		}
		throw new Exception("invalid args",1);
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _add(){
		$args = array("email","nknme","pswod","fname","lname","squst","sqkey","phone","mssnn","aimmm","yahoo");
		foreach ($args as $arg){
			if(!isset($this->args[$arg])){
				throw new Exception("invalid args: ".$arg, 0x1);
			}
		}
		$this->helper = new memberModule();
		$sid = $this->helper->register($this->args["email"],$this->args["nknme"],$this->args["pswod"],$this->args["fname"],$this->args["lname"],$this->args["squst"],$this->args["sqkey"],$this->args["phone"],$this->args["mssnn"],$this->args["aimmm"],$this->args["yahoo"]);
		if(!$sid){
			throw new Exception($this->helper->errorMsg, 1);
		}
		return $sid;
	}
	private function _update(){
		$this->helper = new memberOp();
		if(isset($this->args["email"],$this->args["nknme"],$this->args["fname"],$this->args["lname"],$this->args["squst"],$this->args["sqkey"],$this->args["phone"],$this->args["mssnn"],$this->args["aimmm"],$this->args["yahoo"])){
			return $this->helper->update($this->args["email"],$this->args["nknme"],$this->args["fname"],$this->args["lname"],$this->args["squst"],$this->args["sqkey"],$this->args["phone"],$this->args["mssnn"],$this->args["aimmm"],$this->args["yahoo"]);
		}else if(isset($this->args["eml"],$this->args["oldpwd"],$this->args["newpwd"])){
			return $this->helper->updatePwdByEml($this->args["eml"],$this->args["oldpwd"],$this->args["newpwd"]);
		}else if(isset($this->args["eml"],$this->args["cnsm"],$this->args["rank"],$this->args["vid"])){
			return $this->helper->updateCnsmRankVid($this->args["eml"],$this->args["cnsm"],$this->args["rank"],$this->args["vid"]);
		}else if(isset($this->args["eml"],$this->args["q"],$this->args["a"],$this->args["nwpwd"])){
			return $this->helper->updatePwdBySk($this->args["eml"],$this->args["q"],$this->args["a"],$this->args["nwpwd"]);
		}else if(isset($this->args["sid"],$this->args["pwd"],$this->args["eml"])){
			$ret = $this->helper->updateEml($this->args["sid"],$this->args["pwd"],$this->args["eml"]);
			if($ret){
				require_once ENTRY_PATH."/app/session/auth/memberAuth.php";
				$auth = new session_memAuth();
				$auth->updateEml($this->args["eml"]);
				return 1;
			}
			return 0;
		}else if(isset($this->args["eml"],$this->args["cnsm"])){
			return $this->helper->updateCnsm($this->args["eml"],$this->args["cnsm"]);
		}else if(isset($this->args["sid"],$this->args["pwd"])){
			return $this->helper->resetPwd($this->args["sid"],$this->args["pwd"]);
		}
		throw new Exception("invalid args",2);
	}
	private function _remove(){
		$this->helper = new memberOp();
		if(isset($this->args["eml"])){
			$rows = $this->helper->removeByEml($this->args["eml"]);
			if($rows == 0){
				$info = $this->helper->pdo->getErrorInfo();
				throw new Exception($info[2], $info[0]);
			}
			return $rows;
		}else if(isset($this->args["sid"])){
			$rows = $this->helper->removeBySid($this->args["sid"]);
			if($rows == 0){
				$info = $this->helper->pdo->getErrorInfo();
				throw new Exception($info[2], $info[0]);
			}
			return $rows;
		}
		throw new Exception("invalid args", 1);
	}
}