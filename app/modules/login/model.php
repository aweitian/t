<?php
/**
 * Date: 2015-12-31
 * Author: Awei.tian
 * Description: 
 */
class loginModel extends model{
	public function __construct(){
		parent::__construct();
		
	}
	/**
	 * 
	 * @param string $name
	 * @param string $pass
	 * @return roleid
	 */
	public function checkNamePass($name,$pass){
		$role = array("role"=>"guest");
		$data = $this->db->fetch("select * from user where `name`=:name AND `pass`=:pass", array(
			"name"=>$name,
			"pass"=>App::calcPwd($pass)
		));
		if(count($data)){
			return $data;
		}
		return $role;
	}
}