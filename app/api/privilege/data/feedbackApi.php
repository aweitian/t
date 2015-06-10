<?php
/**
 * Date: 2015-1-21
 * Author: Awei.tian
 * function: 
 */
require_once API_PATH."/aApi.php";
require_once ENTRY_PATH."/app/data/feedback/feedbackInfo.php";
require_once ENTRY_PATH."/app/data/feedback/feedbackOp.php";
require_once ENTRY_PATH."/app/session/captcha/captcha.php";

class feedbackApi extends aApi{
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
		$this->helper = new feedbackInfo();
		if(isset($this->args["cond"],$this->args["offset"],$this->args["len"])){
			return $this->helper->search($this->args["cond"],$this->args["offset"],$this->args["len"]);
		}else if(isset($this->args["sid"])){
			return $this->helper->infoById($this->args["sid"]);
		}else if(isset($this->args["offset"],$this->args["len"])){
			return $this->helper->all($this->args["offset"],$this->args["len"]);
		}
		throw new Exception("invalid args",2);
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _add(){
		if(!isset($this->args["code"])){
			throw new Exception("verification code invalid",2);
		}
		$vc = new session_captcha();
		if(!$vc->check($this->args["code"])){
			throw new Exception("verification code invalid",5);
		}
		$this->helper = new feedbackOp();
		if(isset($this->args["title"],$this->args["contt"],$this->args["email"],$this->args["ipars"],$this->args["pictt"],$this->args["times"],$this->args["nname"])){
			return $this->helper->add($this->args["title"],$this->args["contt"],$this->args["email"],$this->args["ipars"],$this->args["pictt"],$this->args["times"],$this->args["nname"]);
		}
		throw new Exception("invalid args",2);
	}
	private function _update(){
		$this->helper = new feedbackOp();
		if(isset($this->args["sid"],$this->args["reply"])){
			return $this->helper->reply($this->args["sid"],$this->args["reply"]);
		}
		throw new Exception("invalid args",2);
	}
	private function _remove(){
		$this->helper = new feedbackOp();
		if(isset($this->args["sid"])){
			return $this->helper->removeBySid($this->args["sid"]);
		}
		throw new Exception("invalid args", 1);
	}
}