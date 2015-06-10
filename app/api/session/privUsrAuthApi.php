<?php
/**
 * @author: awei.tian
 * @date: 2014-3-17
 * @usage:
 */
require_once ENTRY_PATH."/app/api/aApi.php";
require_once ENTRY_PATH."/app/modules/auth/privUsrAuth.php";
require_once LIB_PATH."/validate/validator.php";
class privUsrAuthApi extends aApi{
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
		$helper = new privUsrAuthModule();
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
		if(!isset($this->args["name"])){
			throw new Exception("invalid name",1);
		}
		if(!isset($this->args["pwd"])){
			throw new Exception("invalid password",1);
		}
		
		if(!isset($this->args["code"])){
			$this->args["code"] = "";
		}
		$helper = new privUsrAuthModule();
		$ret =  $helper->checkByVid($this->args["name"], $this->args["pwd"], $this->args["code"]);
		if(!$ret){
			throw new Exception($helper->errorMsg.",times remainning:".$helper->remain_times,9);
		}
		return true;
	}
	private function _update(){
		return 0;
	}
	private function _remove(){
		$helper = new privUsrAuthModule();
		$helper->logout();
		return true;
	}
	
}