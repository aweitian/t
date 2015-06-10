<?php
/**
 * Date: 2015-1-21
 * Author: Awei.tian
 * function: 
 */
class privInfo{
	/**
	 *
	 * @var IDb
	 */
	public $db;
	/**
	 * @var IPdoBase
	 */
	public $pdo;
	public function __construct(){
		$this->_initdb();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	public function all(){
		return $this->pdo->fetchAll("select * from `tny_priv` where 1", array());
	}
	public function infoById($sid){
		$row = $this->pdo->fetch("select * from `tny_priv` where `id`=:sid", array(
				"sid"=>$sid
		));
		return $row;
	}
	public function infoByNamePwd($name,$pwd){
		$row = $this->pdo->fetch("select * from `tny_priv` where `name`=:name and `pass`=:pass", array(
				"name"=>$name,
				"pass"=>app::calcPwd($pwd)
		));
		return $row;
	}
}