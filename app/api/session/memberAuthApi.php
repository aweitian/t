<?php
/**
 * @author: awei.tian
 * @date: 2014-3-17
 * @usage:
 */
require_once ENTRY_PATH."/app/api/aApi.php";
require_once ENTRY_PATH."/app/modules/auth/memberAuth.php";
require_once LIB_PATH."/validate/validator.php";
class memberAuthApi extends aApi{
	/**
	 * @return bool
	 * @see IApi::invoke()
	 */
	public function invoke(){
		if($this->isGet()){
			return $this->_get();
		}else if($this->isPost()){
			return $this->_auth();
		}else if($this->isPut()){
			return $this->_update();
		}else if($this->isDelete()){
			return $this->_remove();
		}
	}	
	
	private function _get(){
		$helper = new memberAuthModule();
		switch($this->scenario){
			case "getRoleCode":
				return $helper->getRoleCode();
			case "getUserInfo":
				return $helper->getUserInfo();
			case "getUiData":
				return $helper->getUiData();
			default:
				if($helper->isLogined()){
					return $helper->getUserInfo();
				}else{
					$ret = $helper->getUiData();
					if(!$ret){
						throw new Exception($helper->errorMsg,9);
					}
					return $ret;					
				}

		}
	}
	/**
	 * path
	 * @return number >0 ok
	 */
	private function _auth(){
		if(!isset($this->args["id"])){
			throw new Exception("invalid eml or vip id",1);
		}
		if(!isset($this->args["pwd"])){
			throw new Exception("invalid password",1);
		}
		
		if(!isset($this->args["code"])){
			$this->args["code"] = "";
		}
		$helper = new memberAuthModule();
		if(validator::isEmail($this->args["id"])){
			$ret = $helper->checkByEml($this->args["id"], $this->args["pwd"], $this->args["code"]);
			if(!$ret){
				throw new Exception($helper->errorMsg.",times remainning:".$helper->remain_times,9);
			}
			return true;
		}
		$ret =  $helper->checkByVid($this->args["id"], $this->args["pwd"], $this->args["code"]);
		if(!$ret){
			throw new Exception($helper->errorMsg.",times remainning:".$helper->remain_times,9);
		}
		return true;
	}
	private function _update(){
		if(!isset($this->args["eml"])){
			throw new Exception("invalid eml",1);
		}
		$helper = new memberAuthModule();
		return $helper->updateEml($eml);
	}
	private function _remove(){
		$helper = new memberAuthModule();
		$helper->logout();
		return true;
	}
	
}