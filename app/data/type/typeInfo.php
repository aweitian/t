<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 * 		获取结点下子结点名
 */
class typeInfo{
	/**
	 *
	 * @var IDb
	 */
	public $db;
	/**
	 * @var IPdoBase
	 */
	public $pdo;
	/**
	 * @var DataSrcPath
	 */
	public $nodepath;
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
		$row = $this->pdo->fetchAll("select `tv` from `tny_fs_node_type` order by `tk` asc", array());
		$ret = array();
		foreach ($row as $item){
			$ret[] = $item["tv"];
		}
		return $ret;
	}
	/**
	 * @return array(childkey => childtext)
	 */
	public function info($tk){
		$row = $this->pdo->fetch("select `tv` from `tny_fs_node_type` where `tk`=:tk", array(
			"tk"=>$tk
		));
		if(empty($row)){
			return $row;
		}
		return $row["tv"];
	}
	
}