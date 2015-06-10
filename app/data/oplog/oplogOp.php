<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/oplogOpValidator.php";
class oplogOp{
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
	public function add($optype,$ipaddr){
		if(!oplogOpValidator::isValidOptype($optype)){
			throw new Exception("invalid op type",0x1);
		}
		$sid = $this->pdo->insert("insert into `tny_oplog` (
			`optype`,`ipaddr`,`date`
		) values (
			:optype,:ipaddr,:date
		)",array(
			"optype"=>$optype,
			"ipaddr"=>$ipaddr,
			"date"=>date("Y-m-d"),
		));
		if($sid>0){
			return $sid;
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2],$info[0]);
	}
	/**
	 * @return 返回影响的行数,删除小于指定日期的记录
	 * @param string $sid
	 * @throws Exception
	 */
	public function removeByDate($date){
		return $this->pdo->exec("DELETE FROM `tny_oplog` WHERE `datetime`<:date", array(
			"date"=>$date
		));
	}
	public function update($sid){
		return $this->pdo->exec("update `tny_oplog` set `opflag` = 0 WHERE `sid`=:sid", array(
				"sid"=>$sid
		));
	}
	/**
	 * 删除一个IP当天的记录
	 * @param string $ip
	 */
	public function removeByIp($ip){
		return $this->pdo->exec("DELETE FROM `tny_oplog` 
			WHERE `datetime`=:date and `ipaddr`=:ipaddr", array(
				"date"=>date("Y-m-d"),
				"ipaddr"=>$ip
		));
	}
}