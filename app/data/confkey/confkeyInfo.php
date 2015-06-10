<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 * 
 */
class confkeyInfo{
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
	public $path;
	private $raw_path;
	public function __construct($path){
		$this->_initdb();
		$this->raw_path = $path;
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	/**
	 * @return array(key => comment)
	 */
	public function getChildInfo(){
		$p = new DataSrcPath($this->raw_path);
		if($p->getPathMode() != DataSrcPath::DATAKEYINFO_MODE){
			throw new Exception("invalid path:".$path,0x12);
		}
		$this->path = $p;
		$row = $this->pdo->fetchAll("SELECT 
		`tny_fs_confkey_struct`.`key` as `key`,
		`tny_fs_confkey_struct`.`typeid` as `typeid`,
		`tny_fs_confkey_struct`.`comment` as `comment` 
		FROM `tny_fs_confkey_struct`
		left join `tny_fs_node_struct` on `tny_fs_node_struct`.`sid` = `tny_fs_confkey_struct`.`nsid`
				WHERE
		`tny_fs_node_struct`.path = :nodepath", array("nodepath" => $this->path->getNodePath()));
//		if(empty($row)){
//			$info = $this->pdo->getErrorInfo();
//			throw new Exception($info[2], $info[0]);
//		}
		return $row;
	}
	/**
	 * @return array(key => comment)
	 */
	public function getInfo(){
		$p = new DataSrcPath($this->raw_path);
		if($p->getPathMode() != DataSrcPath::DATA_MODE){
			throw new Exception("invalid path:".$path,0x12);
		}
		$this->path = $p;
		$row = $this->pdo->fetch("SELECT 
		`tny_fs_confkey_struct`.`key` as `key`,
		`tny_fs_confkey_struct`.`typeid` as `typeid`,
		`tny_fs_confkey_struct`.`comment` as `comment` 
		FROM `tny_fs_confkey_struct`
		left join `tny_fs_node_struct` on `tny_fs_node_struct`.`sid` = `tny_fs_confkey_struct`.`nsid`
				WHERE
		`tny_fs_node_struct`.path = :nodepath
		AND `tny_fs_confkey_struct`.`key`=:key", array(
			"nodepath" => $this->path->getNodePath(),
			"key" => $this->path->getDatakey()
		));
		if(empty($row)){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $row;
	}
}