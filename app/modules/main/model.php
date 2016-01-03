<?php
/**
 * Date: 2015-12-31
 * Author: Awei.tian
 * Description: 
 */
class mainModel extends model{
	public function __construct(){
		parent::__construct();
	}
	
	public function getRow($sid){
		$sql = "SELECT * FROM `data` WHERE `sid` = :sid";
		return $this->db->fetch($sql, array(
			"sid" => $sid
		));
	}
	public function detail($sid){
		return $this->getRow($sid);
	}
	public function getList($offset,$limit){
		$offset = intval($offset);
		$limit = intval($limit);
		$sql = "SELECT * FROM `data` LIMIT $offset, $limit;";
		return $this->db->fetchAll($sql, array());
	}
	public function add($price,$time,$con_type,$con_val,$gm_name,$char_name,$pay_type,$ad_from,$op_name){
		$sql = "INSERT INTO `data`
            (
             `price`,
             `time`,
             `con_type`,
             `con_val`,
             `gm_name`,
             `char_name`,
             `pay_type`,
             `ad_from`,
             `op_name`,
             `date`) VALUES (
        :price,
        :time,
        :con_type,
        :con_val,
        :gm_name,
        :char_name,
        :pay_type,
        :ad_from,
        :op_name,
        :date)";
		$data = array(
			'price' => $price,
			'time' => $time,
			'con_type' => $con_type,
			'con_val' => $con_val,
			'gm_name' => $gm_name,
			'char_name' => $char_name,
			'pay_type' => $pay_type,
			'ad_from' => $ad_from,
			'op_name' => $op_name,
			'date' => date("Y-m-d h:i:s",time())
		);
		$ret = $this->db->insert($sql, $data);
		return $ret;
	}
	public function update($sid,$price,$time,$con_type,$con_val,$gm_name,$char_name,$pay_type,$ad_from,$op_name){
		$sql = "UPDATE `data`
			SET 
			  `price` = :price,
			  `time` = :time,
			  `con_type` = :con_type,
			  `con_val` = :con_val,
			  `gm_name` = :gm_name,
			  `char_name` = :char_name,
			  `pay_type` = :pay_type,
			  `ad_from` = :ad_from,
			  `op_name` = :op_name
			WHERE `sid` = :sid;";
		$data = array(
				'sid' => $sid,
				'price' => $price,
				'time' => $time,
				'con_type' => $con_type,
				'con_val' => $con_val,
				'gm_name' => $gm_name,
				'char_name' => $char_name,
				'pay_type' => $pay_type,
				'ad_from' => $ad_from,
				'op_name' => $op_name,
		);
		return $this->db->exec($sql, $data);
	}
	public function rm($sid){
		$sql = "DELETE `data`,`his`
			FROM `data`,`his`
			WHERE `his`.`did` = `data`.`sid`
			AND 
			`data`.`sid` = :sid";
		$data = array(
			'sid' => $sid,
		);
		return $this->db->exec($sql, $data);
	}
	
}