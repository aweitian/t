<?php
/**
 * Date: 2016-01-04
 * Author: Awei.tian
 * Description: 
 */
class userModel extends model{
	public function __construct(){
		parent::__construct();
	}
	
	public function getList(){
		return $this->db->fetchAll("SELECT 	`sid`, 
			`name`, 
			`pass`, 
			`role`
			 
			FROM 
			 `user` 
				WHERE `sid` > 1
				
			LIMIT 0, 1000;", array());
	}
	public function getRow($sid){
		$sql = "SELECT * FROM `user` WHERE `sid` = :sid";
		return $this->db->fetch($sql, array(
				"sid" => $sid
		));
	}
	public function add($name,$pass,$role){
		
		if(!$this->isValidName($name)){
			return false;
		}
		if(!$this->isValidPass($pass)){
			return false;
		}
		if(!$this->isValidRole($role)){
			return false;
		}
		$u = $this->db->fetch("select * from `user` where `name`=:name", array("name"=>$name));
		if(!empty($u)){
			return false;
		}
		$uid = $this->db->insert("
				INSERT INTO `user` 
					(
					`name`, 
					`pass`, 
					`role`
					)
					VALUES
					(
					:name, 
					:pass, 
					:role
					);
				
				", array(
					"name"=>$name,
					"pass"=>App::calcPwd($pass),
					"role"=>$role	
				));
		if(!$uid){
			return false;
		}else{
			return $this->db->insert("
			INSERT INTO `blkwords` 
				(
				`uid`
				)
				VALUES
				(
				:uid
				);", array("uid"=>$uid));
		}
	}
	public function updatePwd($sid,$oldpwd,$pwd){
		return $this->db->exec("UPDATE `user` 
				SET
				`pass` = :newpass
				WHERE
				`sid` = :sid
				AND 
				`pass` = :pass
				;
				", array("sid"=>$sid,"newpass"=>App::calcPwd($pwd),
					"pass"=>App::calcPwd($oldpwd),));
	}
	public function updatePwdSuper($sid,$pwd){
		return $this->db->exec("UPDATE `user`
				SET
				`pass` = :newpass
				WHERE
				`sid` = :sid
		 AND 
				`sid` > 1
				;
				", array("sid"=>$sid,"newpass"=>App::calcPwd($pwd)));
	}
	public function rm($sid){
		$this->db->exec("DELETE FROM `user` 
			WHERE
			`sid` = :sid AND 
				`sid` > 1
			;
				", array("sid"=>$sid));
		$this->db->exec("DELETE FROM `blkwords` 
			WHERE `uid` = :uid
			;
				", array("uid"=>$sid));
		return true;
	}
	private function isValidRole($role){
		return array_key_exists($role, App::$roles);
	}
	private function isValidPass($pwd){
		return $pwd !== "";
	}
	private function isValidName($name){
		return $name !== "";
	}
}