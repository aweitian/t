<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 * 		获取结点下子结点名
 */
require_once DATASRC_PATH."/dataSrc.php";
class listDk{
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
	public function getDsList($dstype){
		$row = $this->pdo->fetchAll("SELECT CONCAT(`tny_fs_node_struct`.`path`,'?',`tny_fs_datakey_struct`.`key`) AS p
			FROM `tny_fs_datakey_struct`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
			WHERE `tny_fs_datakey_struct`.`dstype` = :dstype", array(
			"dstype"=>$dstype
		));
		$ret = array();
		foreach ($row as $item){
			$ret[] = $item["p"];
		}
		return $ret;
	}
}	