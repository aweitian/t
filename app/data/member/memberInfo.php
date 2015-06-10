<?php
/**
 * Date: 2015-1-6
 * Author: Awei.tian
 * function: 
 */
class memberInfo{
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
	
	public function search($cond,$offset,$len){
		$row = $this->pdo->fetch("select count(id) as cnt from `tny_member` 
				where 
				`member_email` like CONCAT('%',:cond,'%') OR
				`member_nknme` like CONCAT('%',:cond,'%') OR
				`member_fname` like CONCAT('%',:cond,'%') OR
				`member_lname` like CONCAT('%',:cond,'%') OR
				`member_vipid` like CONCAT('%',:cond,'%') OR
				`member_phone` like CONCAT('%',:cond,'%') OR
				`member_mssnn` like CONCAT('%',:cond,'%') OR
				`member_aimmm` like CONCAT('%',:cond,'%') OR
				`member_yahoo` like CONCAT('%',:cond,'%')
				
				", array(
			'cond'=>$cond
		));
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * from `tny_member` 
				where 
				`member_email` like CONCAT('%',:cond,'%') OR
				`member_nknme` like CONCAT('%',:cond,'%') OR
				`member_fname` like CONCAT('%',:cond,'%') OR
				`member_lname` like CONCAT('%',:cond,'%') OR
				`member_vipid` like CONCAT('%',:cond,'%') OR
				`member_phone` like CONCAT('%',:cond,'%') OR
				`member_mssnn` like CONCAT('%',:cond,'%') OR
				`member_aimmm` like CONCAT('%',:cond,'%') OR
				`member_yahoo` like CONCAT('%',:cond,'%')
				limit :offset,:length	
				", array(
				'cond'=>$cond,
				'offset'=>(int)$offset,
				'length'=>(int)$len
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
		$row = $this->pdo->fetch("select count(id) as cnt from `tny_member` where 1", array());
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * from `tny_member` where 1 limit :offset,:length", array(
					'offset'=>(int)$offset,
					'length'=>(int)$len
			));
		}else{
			$data = array();
		}
		return array(
			"cnt"=>$cnt,
			"data"=>$data
		);
	}
	public function infoById($sid){
		$row = $this->pdo->fetch("select * from `tny_member` where `id`=:sid", array(
				"sid"=>$sid
		));
		return $row;
	}
	public function infoByEml($eml){
		$row = $this->pdo->fetch("select * from `tny_member` where `member_email`=:eml", array(
				"eml"=>$eml
		));
		return $row;
	}
	public function infoByVipid($vid){
		$row = $this->pdo->fetch("select * from `tny_member` where `member_vipid`=:vid", array(
				"vid"=>$vid
		));
		return $row;
	}
	public function infoByVipidPwd($vid,$pwd){
		$row = $this->pdo->fetch("select * from `tny_member` 
				where `member_vipid`=:vid and `member_pswod` = :pwd", array(
				"vid"=>$vid,
				"pwd"=>app::calcPwd($pwd),
		));
		return $row;
	}
	public function infoByEmlPwd($eml,$pwd){
		$row = $this->pdo->fetch("select * from `tny_member` 
				where `member_email`=:eml and `member_pswod` = :pwd", array(
				"eml"=>$eml,
				"pwd"=>app::calcPwd($pwd),
		));
		return $row;
	}
}