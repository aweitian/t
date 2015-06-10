<?php
/**
 * Date: 2015-1-20
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/session/auth/memberAuth.php";
require_once ENTRY_PATH."/app/data/member/memberInfo.php";
require_once ENTRY_PATH."/app/data/oplog/oplogInfo.php";
require_once ENTRY_PATH."/app/data/oplog/oplogOp.php";
require_once ENTRY_PATH."/app/session/captcha/captcha.php";
require_once ENTRY_PATH."/app/interfaces/IOp.php";
class memberAuthModule implements IOp{
	private $conf;
	/**
	 * @var identityToken 
	 */
	private $idtoken;
	private $opsid;
	private $oplog;
	public $errorMsg;
	public $remain_times = 0;
	public $auth;
	public function __construct(){
		$this->conf = require ENTRY_PATH."/app/conf/auth.php";
		$this->idtoken = tian::$context->getIdentityToken();
		$this->auth = new session_memAuth();
		$this->idtoken->setInfo($this->auth->getInfo());
		$this->idtoken->setRoleCode($this->auth->getRoleCode());
		$roleCode = require ENTRY_PATH."/app/conf/rolecode.php";
		if(!array_key_exists($this->idtoken->getRoleCode(), $roleCode)){
			$this->idtoken->setRoleCode("guest");
		}
	}
	/**
	 * 
	 * @param string $eml
	 * @param string $pwd
	 * @param string $code
	 * @return bool
	 */
	public function checkByEml($eml,$pwd,$code=""){
		$this->remain_times = $this->getRemainTryTimes();
		if($this->isBlocked()){
			$this->errorMsg="Exceed Max try times.";
			return false;
		}
		$this->opStart();
		if(!$this->_checkVc($code)){
			$this->errorMsg = "Invalid verification code";
			$this->opUpdate();
			return false;
		}
		$info = new memberInfo();
		$ret = $info->infoByEmlPwd($eml, $pwd);
		if(empty($ret)){
			$this->errorMsg = "Invalid email or password";
			$this->opUpdate();
			return false;
		}
		return $this->_saveInfo($ret);
	}
	public function isBlocked(){
		$this->remain_times = $this->getRemainTryTimes();
		return $this->remain_times<=0;
	}
	/**
	 * 
	 * @param string $vid
	 * @param string $pwd
	 * @param string $code
	 * @return 0 ok,-1 尝试次数过多,>0 fail
	 */
	public function checkByVid($vid,$pwd,$code=""){
		$this->remain_times = $this->getRemainTryTimes();
		if($this->isBlocked()){
			$this->errorMsg="Exceed Max try times.";
			return false;
		}
		$this->opStart();
		if(!$this->_checkVc($code)){
			$this->errorMsg = "Invalid verification code";
			$this->opUpdate();
			return false;
		}
		$info = new memberInfo();
		$ret = $info->infoByVipidPwd($vid, $pwd);
		if(empty($ret)){
			$this->errorMsg = "Invalid vip id or password";
			$this->opUpdate();
			return false;
		}
		return $this->_saveInfo($ret);
	}
	public function getRemainTryTimes(){
		return $this->conf["m_try_times_max"] - $this->getOPFailCnt();
	}
	/**
	 * @return array
	 */
	public function getUiData(){
		if($this->getRemainTryTimes()<0){
			$this->errorMsg="Exceed Max try times.";
			return false;
		}
		$ret = array(
			"Your Email"=>"<input type=\"text\" name=\"id\">",
			"Password"=>"<input type=\"password\" name=\"pwd\">",
		);
		if($this->conf["open"]){
			$failCnt = $this->getOPFailCnt();
			if($failCnt>=$this->conf["m_try_times"]){
				$ret["Verification code"] = "<input type=\"text\" name=\"code\">";
				$ret["code_img"] = "<img src=\"".ENTRY_HOME."/captcha\">";
			}			
		}
		return $ret;
	}
	//此时的ROLE CODE在构造函数中已设置
	public function isLogined(){
		return $this->idtoken->getRoleCode() == "member";
	}
	public function getRoleCode(){
		return $this->idtoken->getRoleCode();
	}
	public function getUserInfo(){
		return $this->idtoken->getInfo();
	}
	public function logout(){
		$this->auth->logout();
		$this->idtoken->setRoleCode("guest");
	}
	public function updateEml($eml){
		return $this->auth->updateEml($eml);
	}
	private function _checkVc($code){
		if($this->conf["open"]){
			//检查是否需要验证码
			$failCnt = $this->getOPFailCnt();
			if($failCnt>=$this->conf["m_try_times"]){
				$helper = new session_captcha();
				return $helper->check($code);
			}
			return true;
		}
		return true;
	}
	
	private function _saveInfo($ret){
		$info = array(
			"sid"=>$ret["id"],
			"email"=>$ret["member_email"],
		);
		$this->auth->saveInfo($info);
		$this->auth->saveRoleCode("member");
		$this->idtoken->setInfo($info);
		$this->idtoken->setRoleCode("member");
		return true;
	}
	public function getOpType(){
		return "member_auth";
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