<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 * 
 */
class listCk{
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
	public function getCkList($typeid){
		$row = $this->pdo->fetchAll("SELECT CONCAT(`tny_fs_node_struct`.`path`,'?',`tny_fs_confkey_struct`.`key`) AS p
			FROM `tny_fs_confkey_struct`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_confkey_struct`.`nsid`
			WHERE `tny_fs_confkey_struct`.`typeid` = :typeid", array(
			"typeid" => $typeid
		));
		if(empty($row)){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		$ret = array();
		foreach ($row as $item){
			$ret[] = $item["p"];
		}
		return $ret;
	}
}