<?php
/**
 * Date: 2015-1-26
 * Author: Awei.tian
 * function: 
 */

class memberModel extends appModel{
	public $errorMsg;
	public $module;
	public $auth;
	public function __construct(){
		$this->module = new memberModule();
		$this->auth = new memberAuthModule();
	}
	public function login($eml,$pwd,$code){
		return $this->auth->checkByEml($eml, $pwd, $code);
	}
	public function getLoginedEml(){
		return $this->auth->auth->getEmail();
	}
	/**
	 * @return boolean
	 * @param STRING $email
	 * @param STRING $nknme
	 * @param STRING $pswod
	 * @param STRING $fname
	 * @param STRING $lname
	 * @param STRING $squst
	 * @param STRING $sqkey
	 * @param STRING $phone
	 * @param STRING $mssnn
	 * @param STRING $aimmm
	 * @param STRING $yahoo
	 */
	public function register($email,$nknme,$pswod,$fname,$lname,$squst,$sqkey,$phone,$mssnn,$aimmm,$yahoo){
		$f = $this->module->register($email, $nknme, $pswod, $fname, $lname, $squst, $sqkey, $phone, $mssnn, $aimmm, $yahoo);
		$this->errorMsg = $this->module->errorMsg;
		return $f;
	}
	public function getProfile(){
		if(!$this->auth->isLogined()){
			return array();
		}
		$memberInfo = new memberInfo();
		return $memberInfo->infoByEml($this->getLoginedEml());
	}
	public function isLogined(){
		return $this->auth->isLogined();
	}
	public function isBlocked(){
		return $this->auth->isBlocked();
	}
	public function getHotData(){
		
	}
}