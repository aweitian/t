<?php
/**
 * @author awei.tian
 * date: 2013-9-30
 * 说明:
 */
require_once LIB_PATH."/algorithms/Security.php";
require_once dirname(__FILE__)."/userAuthModel.php";
require_once dirname(__FILE__)."/authRelationsModel.php";
C::load(LIB_PATH."/_setting/auth.php");
class auth{
	const AUTH_CODE_SYSTEM="SYSTEM";
	/**
	 * @var IDb
	 */
	public $db;
	/**
	 * @var userAuthModel
	 */
	private $userAuth;
	private $rlsnAuth;
	/**
	 * @var identityToken
	 */
	private $id;
	public function __construct(){
		$this->db=tian::$context->getDb();
		require_once dirname(__FILE__)."/authInit.php";
		new authInit();
		$this->userAuth=new userAuthModel();
		$this->rlsnAuth=new authRelationsModel();
		$this->id=tian::$context->getIdentityToken();
	}
	public function hasPriv($priv_code) {
		if($priv_code==self::AUTH_CODE_SYSTEM)return true;
		$rolecode=$this->id->getRoleCode();
		$allowed_priv_codes=$this->rlsnAuth->findAll("rolecode=:rolecode", array(
			"rolecode"=>$rolecode
		));
		foreach ($allowed_priv_codes as $row){
			if($row["privilegecode"]==$priv_code){
				return true;
			}
		}
		return false;
	}
	/**
	 * @return boolean
	 * @param string $username
	 * @param string $password
	 * 不授权超级用户
	 */
	public function validate($username,$password){
		$userInfo=$this->userAuth->findRaw("`userid`=:userid and `passwd`=:passwd", array(
			"userid"=>$username,
			"passwd"=>Security::encrypt($password)
		));
		if(empty($userInfo))return false;
		//不授权超级用户
		if($userInfo["rolecode"]==self::AUTH_CODE_SYSTEM)return false;
		$this->id['usersid']=$userInfo["usersid"];
		$this->id['userid']=$userInfo["userid"];
		$this->id['passwd']=$userInfo["passwd"];
		$this->id["$"]=$userInfo["rolecode"];
		return true;
	}
	public function sv($username,$password){
		if($username=="" || $password=="")return false;
		if($username!=$this->getSuperName() || Security::encrypt($password)!=$this->getSuperPswd()){
			return false;
		}
		$this->id['usersid']=0;
		$this->id['userid']=$username;
		$this->id['passwd']=$password;
		$this->id["$"]=self::AUTH_CODE_SYSTEM;
		return true;
	}
	private function getSuperName(){
		return C::get("inner_system_username");
	}
	private function getSuperPswd(){
		return C::get("inner_system_password");
	}
}