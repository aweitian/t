<?php
/**
 * Date: 2015-1-20
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/session/auth/privUsrAuth.php";
require_once ENTRY_PATH."/app/data/priv/privInfo.php";
require_once ENTRY_PATH."/app/data/oplog/oplogInfo.php";
require_once ENTRY_PATH."/app/data/oplog/oplogOp.php";
require_once ENTRY_PATH."/app/interfaces/IOp.php";
require_once ENTRY_PATH."/app/session/captcha/captcha.php";
require_once ENTRY_PATH."/app/session/auth/memberAuth.php";

class privUsrAuthModule implements IOp{
	private $conf;
	/**
	 * @var identityToken 
	 */
	private $idtoken;
	private $opsid;
	private $oplog;
	public $errorMsg;
	public $remain_times = 0;
	public function __construct(){
		$this->conf = require ENTRY_PATH."/app/conf/auth.php";
		$this->idtoken = tian::$context->getIdentityToken();
		$auth = new session_privUsrAuth();
		$this->idtoken->setInfo($auth->getInfo());
		$this->idtoken->setRoleCode($auth->getRoleCode());
		$roleCode = require ENTRY_PATH."/app/conf/rolecode.php";
		if(!array_key_exists($this->idtoken->getRoleCode(), $roleCode)){
			$this->idtoken->setRoleCode("guest");
		}
	}
	public function checkByNamePwd($name,$pwd,$code=""){
		$this->remain_times = $this->getRemainTryTimes();
		if($this->remain_times<=0){
			$this->errorMsg="Exceed Max try times.";
			return false;
		}
		$this->opStart();
		if(!$this->_checkVc($code)){
			$this->errorMsg = "Invalid verification code";
			$this->opUpdate();
			return false;
		}
		$info = new privInfo();
		$ret = $info->infoByNamePwd($name, $pwd);
		if(empty($ret)){
			$this->errorMsg = "Invalid name or password";
			$this->opUpdate();
			return false;
		}
		return $this->_saveInfo($ret);
	}
	public function getRemainTryTimes(){
		return $this->conf["u_try_times_max"] - $this->getOPFailCnt();
	}
	public function getUiData(){
		$ret = array(
			"Name"=>"<input type=\"text\" name=\"name\">",
			"Password"=>"<input type=\"password\" name=\"pwd\">",
		);
		$failCnt = $this->getOPFailCnt();
		if($failCnt>$this->conf["u_try_times"]){
			$ret["Verification code"] = "<input type=\"text\" name=\"code\">";
			$ret["code_img"] = "<img src=\"".ENTRY_HOME."/captcha\">";
		}
		return $ret;
	}
	public function isLogined(){
		return $this->idtoken->getRoleCode() == "privUsr";
	}
	public function getRoleCode(){
		return $this->idtoken->getRoleCode();
	}
	public function getUserInfo(){
		return $this->idtoken->getInfo();
	}
	public function logout(){
		$auth = new session_privUsrAuth();
		$auth->logout();
		$this->idtoken->setRoleCode("guest");
	}
	
	private function _checkVc($code){
		if($this->conf["open"]){
			//检查是否需要验证码
			$failCnt = $this->getOPFailCnt();
			if($failCnt>$this->conf["u_try_times"]){
				$helper = new session_captcha();
				return $helper->check($code);
			}
			return true;
		}
		return true;
	}
	
	private function _saveInfo($ret){
		$auth = new session_privUsrAuth();
		$info = array(
			"sid"=>$ret["id"],
			"name"=>$ret["name"],
			"privilege"=>$ret["privilege"],
		);
		$auth->saveInfo($info);
		$auth->saveRoleCode("privUsr");
		$this->idtoken->setInfo($info);
		$this->idtoken->setRoleCode("privUsr");
		return true;
	}
	public function getOpType(){
		return "privUsr_auth";
	}	
	public function opStart(){
		$this->oplog = new oplogOp();
		$this->opsid = $this->oplog->add($this->getOpType(), $this->idtoken->getIp());
	} 
	public function opUpdate(){
		if($this->opsid){
			$this->oplog->update($this->opsid);
		}
	}
	public function getOPFailCnt(){
		$priv = new oplogInfo();
		return $priv->getCnt($this->getOpType(), $this->idtoken->getIp());
	}
}