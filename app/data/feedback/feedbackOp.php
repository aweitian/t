<?php
/**
 * Date: 2015-1-20
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/feedbackOpValidator.php";
class feedbackOp{
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


	/**
	 * @return nsid
	 */
	public function add($title,$contt,$email,$ipars,$pictt,$times,$nname){
		if(!feedbackOpValidator::isValidEml($email)){
			throw new Exception("invalid email",0x1);
		}

		$sid = $this->pdo->insert("insert into `tny_feedback` (
			`title`,`contt`,`email`,`ipars`,`pictt`,`times`,`nname`
		) values (
			:title,:contt,:email,:ipars,:pictt,:times,:nname
		)",array(
			"title"=>$title,
			"contt"=>$contt,
			"email"=>$email,
			"ipars"=>$ipars,
			"pictt"=>$pictt,
			"times"=>$times,
			"nname"=>$nname
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
	public function removeBySid($sid){
		return $this->pdo->exec("delete from `tny_feedback` where `id`=:id", array(
			"id"=>$sid
		));
	}
	public function reply($sid,$reply){
		return $this->pdo->exec("update `tny_feedback`
				set `reply`=:reply
				where `id`=:sid", array(
				"sid"=>$sid,
				"reply"=>$reply
		));
	}
}