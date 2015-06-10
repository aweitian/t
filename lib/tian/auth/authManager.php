<?php
/**
 * @author:awei.tian
 * @date:2013-12-24
 * @functions:
 */
require LIB_PATH.'/auth/auth.php';

class authManager{
	private $auth;
	private $session;
	private $id;
	public function __construct(){
		$this->auth=new auth();
		$this->session=tian::$context->getSession();
		$this->id=tian::$context->getIdentityToken();
	}
	public function saveToSession(){
		$this->session->add("auth.ip", $this->id->getIp());
		$this->session->add("auth.rolecode", $this->id->getRoleCode());
		$this->session->add("auth.info", $this->id->getInfo());
	}
	public function loadFromSession(){
		$this->id["$"]=$this->session->get("auth.rolecode","");
		$info=$this->session->get("auth.info",array());
		foreach ($info as $k=>$v){
			$this->id[$k]=$v;
		}
	}
}