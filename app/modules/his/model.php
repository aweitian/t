<?php
/**
 * Date: 2016-01-01
 * Author: Awei.tian
 * Description: 
 */
class hisModel extends model{
	public function __construct(){
		parent::__construct();
	}
	public function hasOrder($did){
		$data = $this->db->fetch("select * from `data` where `sid`=:sid", array(
			"sid" => $did
		));
		return !empty($data);
	}
	public function getRow($sid){
		$sql = "SELECT * FROM `his` WHERE `sid` = :sid";
		return $this->db->fetch($sql, array(
				"sid" => $sid
		));
	}
	public function getList($did){
		$data = $this->db->fetch("SELECT * FROM `data` WHERE `sid`=:sid;", array(
			"sid"=>$did	
		));
		$sql = "SELECT * FROM `his` WHERE `did` = :did";
		$his = $this->db->fetchAll($sql, array("did"=>$did));
		return array(
			"data" => $data,
			"his" => $his,
			"rmTime" => $this->getRemains($did)
		);
	}
	public function getRemains($did){
		if(!$this->hasOrder($did)){
			return false;
		}
		$data = $this->db->fetch("select * from `data` where `sid`=:sid", array(
				"sid" => $did
		));
		$time = $data["time"];
		$sum = $this->db->fetch("select sum(`exhaust`) as e from `his` where `did`=:did", array(
			"did"=>$did
		));
		if (!is_null($sum["e"])){
			$sum = $sum["e"];
		}else{
			$sum = 0;
		}
		return $time - $sum;
	}
	public function add($did,$exhaust,$mark,$op_date){
		if (!$this->hasOrder($did)){
			return false;
		}
		$sql = "INSERT INTO `his`
            (
             `did`,
             `exhaust`,
             `mark`,
			`op_date`,
             `date`)
			VALUES (
	        :did,
	        :exhaust,
	        :mark,
			:op_date,
	        :date);
				";
		$data = array(
			"did"=>$did,
			"exhaust"=>$exhaust,
			"mark"=>$mark,
			"op_date"=>$op_date,
			"date"=>date("Y-m-d h:i:s",time())
		);
		return $this->db->insert($sql, $data);
	}
	public function update($sid,$exhaust,$mark,$op_date){
		$sql = "UPDATE `his`
				SET 
				  `exhaust` = :exhaust,
				`op_date` = :op_date,
				  `mark` = :mark
				WHERE `sid` = :sid;
				";
		$data = array(
			"exhaust"=>$exhaust,
			"mark"=>$mark,
				"op_date"=>$op_date,
			"sid"=>$sid
		);
		return $this->db->exec($sql, $data);
	}
	public function rm($sid){
		$sql = "DELETE
				FROM `his`
				WHERE `sid` = :sid;";
		$data = array(
				'sid' => $sid,
		);
		return $this->db->exec($sql, $data);
	}
}