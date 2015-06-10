<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/keywordOpValidator.php";
class keywordOp{
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
	public function add($ori,$alias){
		if(!keywordOpValidator::isValidOri($ori)){
			throw new Exception("invalid kw",0x1);
		}
		if(!keywordOpValidator::isValidAlias($alias)){
			throw new Exception("invalid alias",0x1);
		}
		$sid = $this->pdo->insert("insert into `tny_keyword` (
			`ori`,`als`
		) values (
			:ori,:als
		)",array(
			"ori"=>$ori,
			"als"=>$alias,
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
	public function remove($sid){
		$row = $this->pdo->exec("delete from `tny_keyword` where `sid`=:sid",array(
			"sid"=>$sid
		));
		if($row>0){
			return $row;
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2],$info[0]);
	}
	/**
	 * @return 返回影响的行数
	 * @param string $sid
	 * @throws Exception
	 */
	public function update($sid,$ori,$als){
		$row = $this->pdo->exec("update `tny_keyword` set 
				`ori`=:ori,`als`=:als
				where `sid`=:sid",array(
			"sid"=>$sid,
			"ori"=>$ori,
			"als"=>$als
		));
		if($row>0){
			return $row;
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2],$info[0]);
	}
}