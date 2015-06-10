<?php
/**
 * Date: 2015-1-21
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/privOpValidator.php";
class privOp{
	/**
	 *
	 * @var IDb
	 */
	public $db;
	/**
	 * @var IPdoBase
	 */
	public $pdo;

	public $pathDbHelper;
	public function __construct(){
		$this->_initdb();
		$this->pathDbHelper = new pathDbHelper();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}


	/**
	 * @return nsid
	 */
	public function add($name,$pass,$priv){
		if(!privOpValidator::isValidName($name)){
			throw new Exception("invalid name",0x1);
		}
		if(!privOpValidator::isValidPass($pass)){
			throw new Exception("invalid pwd",0x1);
		}
		if(!privOpValidator::isValidPriv($priv)){
			throw new Exception("invalid priv",0x1);
		}
		$sid = $this->pdo->insert("insert into `tny_priv` (
			`name`,`pass`,`privilege`
		) values (
			:name,:pass,:privilege
		)",array(
			"name"=>$name,
			"pass"=>app::calcPwd($pass),
			"privilege"=>$priv,
		));
		if($sid>0){
			return $sid;
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2],$info[0]);
	}
	/**
	 * @return 返回影响的行数
	 * @param string $sid
	 * @throws Exception
	 */
	public function removeBySid($id){
		return $this->pdo->exec("delete from `tny_priv` where `id`=:id", array(
			"id"=>$sid
		));
	}
	public function updatePwdBySid($sid,$oldpwd,$newpwd){
		$row = $this->pdo->exec("update `tny_priv` set `pass` = :nwpwd
				where `pass`=:oldpwd and `id`=:sid", array(
			"nwpwd" => app::calcPwd($newpwd),
			"oldpwd" => app::calcPwd($oldpwd),
			"sid" => $sid
		));
		return $row;
	}
}