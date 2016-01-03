<?php
class roleSession extends Session{
	//用于存放实例化的对象
	static private $_instance = null;
	
	
	
	public function setRole($role){
		if (array_key_exists($role, App::$roles)){
			$this->set("role", $role);
		}
	}
	public function getRole(){
		return $this->get("role");
	}
	public function getRoleName(){
		return App::$roles[$this->get("role")];
	}
	public function setName($name){
		$this->set("name", $name);
	}
	public function getName(){
		return $this->get("name");
	}
	public function isLogined(){
		$n = $this->getName();
		if(is_null($n))return false;
		if($n == "guest")return false;
		if(!$n)return false;
		return true;
	}
	public function loginOut(){
		$this->rm('name');
		$this->rm('role');
	}
	
	
	//公共静态方法获取实例化的对象
	static public function getInstance() {
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	//私有克隆
	private function __clone() {}
	
	//私有构造
	private function __construct() {
		parent::getInstance();
	}
}