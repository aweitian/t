<?php
/**
 * Date: 2015-1-20
 * Author: Awei.tian
 * function: 
 */
class feedbackInfo{
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
	public function all($offset,$len){
		$row = $this->pdo->fetch("select count(id) as cnt from `tny_feedback` where 1", array());
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * from `tny_feedback` where 1 limit :offset,:length", array(
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
	public function search($cond,$offset,$len){
		$row = $this->pdo->fetch("select count(id) as cnt from `tny_feedback` 
				where 
				`title` like CONCAT('%',:cond,'%') OR
				`email` like CONCAT('%',:cond,'%') OR
				`contt` like CONCAT('%',:cond,'%') OR
				`ipars` like CONCAT('%',:cond,'%') OR
				`nname` like CONCAT('%',:cond,'%')
				", array(
			'cond'=>$cond
		));
		$cnt = $row["cnt"];
		if($cnt != 0){
			$data = $this->pdo->fetchAll("select * from `tny_feedback` 
				where 
				`title` like CONCAT('%',:cond,'%') OR
				`email` like CONCAT('%',:cond,'%') OR
				`contt` like CONCAT('%',:cond,'%') OR
				`ipars` like CONCAT('%',:cond,'%') OR
				`nname` like CONCAT('%',:cond,'%')
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
	public function infoById($sid){
		$row = $this->pdo->fetch("select * from `tny_feedback` where `id`=:sid", array(
				"sid"=>$sid
		));
		return $row;
	}
}