<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 * 		获取结点下子结点名
 */
class labelInfo{
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
	 * @return array(childkey => childtext)
	 */
	public function get(){
		$row = $this->pdo->fetchAll("select `lv` from `tny_fs_node_label` order by `lk` asc", array());
		$ret = array();
		foreach ($row as $item){
			$ret[] = $item["lv"];
		}
		return $ret;
	}
	/**
	 * @return array(childkey => childtext)
	 */
	public function info($lk){
		$row = $this->pdo->fetch("select `lv` from `tny_fs_node_label` where `lk` = :lk", array(
			"lk" => $lk
		));
		if(empty($row)){
			return $row;
		}
		return $row["lv"];
	}	
}