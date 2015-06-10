<?php
/**
 * Date: 2015-1-20
 * Author: Awei.tian
 * function: 
 */
class session_memAuth{
	/**
	 * @var session
	 */
	private $session;
	private $session_key = "usr_auth_info";
	private $session_key_rc = "usr_auth_rolecode";
	public function __construct(){
		$this->session=tian::$context->getSession();
	}
	public function saveInfo($info){
		$this->session->add($this->session_key, $info);
	}
	public function saveRoleCode($rc){
		$this->session->add($this->session_key_rc, $rc);
	}
	public function updateEml($eml){
		$info = $this->session->get($this->session_key);
		$info["email"] = $eml;
		$this->session->add($this->session_key, $info);
	}
	public function isLogined(){
		return $this->session->get($this->session_key_rc) == "member";
	}
	public function getInfo(){
		return $this->session->get($this->session_key);
	}
	public function getEmail(){
		$info = $this->getInfo();
		if(isset($info["email"]))
		return $info["email"];
		return false;
	}
	public function getRoleCode(){
		return $this->session->get($this->session_key_rc);
	}
	public function logout(){
		$this->session->remove($this->session_key);
		$this->session->remove($this->session_key_rc);
		return true;
	}
}