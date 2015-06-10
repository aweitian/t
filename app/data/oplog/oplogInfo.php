<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
class oplogInfo{
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
	public function getCnt($optype,$ipaddr){
		$row = $this->pdo->fetch("select count(sid) as cnt from `tny_oplog`
				where
				`ipaddr` = :ipaddr and `optype`= :optype and `date`=:date and `opflag` = 0
		", array(
			'optype'=>$optype,
			'ipaddr'=>$ipaddr,
			'date'=>date("Y-m-d")
		));
		return $row["cnt"];
	}
	public function searchByIp($cond,$offset,$len){
		$row = $this->pdo->fetch("select count(id) as cnt from `tny_oplog` 
				where 
				`ipaddr` = :cond
				", array(
			'cond'=>$cond
		));
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * from `tny_oplog` 
				where 
				`ipaddr` = :cond
				limit :offset,:length	
				", array(
				'cond'=>$cond,
				'offset'=>$offset,
				'length'=>$len
			));
		}else{
			$data = array();
		}
		return array(
			"cnt"=>$cnt,
			"data"=>$data
		);
	}
	public function searchByDate($cond,$offset,$len){
		$row = $this->pdo->fetch("select count(id) as cnt from `tny_oplog` 
				where 
				`date` = :cond
				", array(
			'cond'=>$cond
		));
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * from `tny_oplog` 
				where 
				`date` = :cond
				limit :offset,:length	
				", array(
				'cond'=>$cond,
				'offset'=>$offset,
				'length'=>$len
			));
		}else{
			$data = array();
		}
		return array(
			"cnt"=>$cnt,
			"data"=>$data
		);
	}
	public function searchByIpDate($ip,$date,$offset,$len){
		$row = $this->pdo->fetch("select count(id) as cnt from `tny_oplog` 
				where 
				`date` = :date and `ipaddr` = :ip
				", array(
			'ip'=>$ip,
			'date'=>$date
		));
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * from `tny_oplog` 
				where 
				`date` = :date and `ipaddr` = :ip
				limit :offset,:length	
				", array(
				'ip'=>$ip,
				'date'=>$date,
				'offset'=>$offset,
				'length'=>$len
			));
		}else{
			$data = array();
		}
		return array(
			"cnt"=>$cnt,
			"data"=>$data
		);
	}
	public function all($offset,$len){
		$row = $this->pdo->fetch("select count(id) as cnt from `tny_oplog` where 1", array());
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * from `tny_oplog` where 1 limit :offset,:length", array(
					'offset'=>$offset,
					'length'=>$len
			));
		}else{
			$data = array();
		}
		return array(
			"cnt"=>$cnt,
			"data"=>$data
		);
	}
}