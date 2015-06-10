<?php
/**
 * Date: 2014-9-29
 * Author: Awei.tian
 * function: 
 * 		获取结点下子结点名
 */
require_once DATASRC_PATH."/DataSrcPath.php";
class namespaceInfo{
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
	public function __construct($nspath){
		$this->_initdb();
		$this->path = new DataSrcPath($nspath);
		if($this->path->getPathMode() != DataSrcPath::NSINFO_MODE){
			throw new Exception("invalid ds path:".$nspath,0x25);
		}
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	/**
	 * @return array(key => comment)
	 */
	public function getChildInfo(){
//		var_dump($this->path->isNsRoot());exit;
		if($this->path->isNsRoot()){
			$path = "";
		}else{
			$path = $this->path->getNsPath();
		}
		$row = $this->pdo->fetchAll("SELECT 
			SUBSTRING_INDEX(`tny_fs_ns_struct`.`path`,'/',-1) AS `key`,
			`tny_fs_ns_struct`.`order` AS `order`,
			`tny_fs_ns_struct`.`da` AS `da`,
			`tny_fs_ns_struct`.`nt` AS `nt`
			
			FROM `tny_fs_ns_struct` 
			LEFT JOIN `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`sid` = `tny_fs_ns_struct`.`dksid`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
			WHERE
			`tny_fs_ns_struct`.`path` != '/' 
			AND	`tny_fs_node_struct`.`path` = :nodepath
			AND `tny_fs_datakey_struct`.`key` = :datakey
			AND LEFT(`tny_fs_ns_struct`.`path`,CHAR_LENGTH(:nspath)) = :nspath
			AND CHAR_LENGTH(`tny_fs_ns_struct`.`path`)-CHAR_LENGTH(REPLACE(`tny_fs_ns_struct`.`path`,'/','')) = 1+CHAR_LENGTH(:nspath) - CHAR_LENGTH(REPLACE(:nspath,'/',''))
			ORDER BY `tny_fs_ns_struct`.`order` ASC					
		", array(
				"nspath" => $path,
				"nodepath" => $this->path->getNodePath(),
				"datakey" => $this->path->getDatakey(),
		));
		return $row;
	}
	public function getInfo(){
//		var_dump($this->path->getNodePath(),$this->path->getDatakey(),$this->path->getNsPath());
//		exit;
		$row = $this->pdo->fetch("SELECT 
			SUBSTRING_INDEX(`tny_fs_ns_struct`.`path`,'/',-1) AS `key`,
			`tny_fs_ns_struct`.`order` AS `order`,
			`tny_fs_ns_struct`.`da` AS `da`,
			`tny_fs_ns_struct`.`nt` AS `nt`
			FROM `tny_fs_ns_struct` 
			LEFT JOIN `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`sid` = `tny_fs_ns_struct`.`dksid`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
			WHERE
			`tny_fs_node_struct`.`path` = :nodepath
			AND `tny_fs_datakey_struct`.`key` = :datakey
			AND `tny_fs_ns_struct`.`path` = :nspath
			ORDER BY `tny_fs_ns_struct`.`order` ASC					
		", array(
				"nspath" => $this->path->getNsPath(),
				"nodepath" => $this->path->getNodePath(),
				"datakey" => $this->path->getDatakey(),
		));
		return $row;
	}
	
	/**
	 * @return all descendants order by deep asc
	 * not include self
	 */
	public function getDescendantSids($order="desc"){
		if($order !== "asc"){
			$order = "desc";
		}
		if($this->path->isNsRoot()){
			$path = "";
		}else{
			$path = $this->path->getNsPath();
		}
		$row = $this->pdo->fetchAll("SELECT `tny_fs_ns_struct`.`sid` AS `sid`
			FROM `tny_fs_ns_struct` 
			LEFT JOIN `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`sid` = `tny_fs_ns_struct`.`dksid`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
			WHERE
				`tny_fs_ns_struct`.`path` != '/' 
			AND `tny_fs_ns_struct`.`path` != :nspath
			AND	`tny_fs_node_struct`.`path` = :nodepath
			AND `tny_fs_datakey_struct`.`key` = :datakey
			AND LEFT(`tny_fs_ns_struct`.`path`,CHAR_LENGTH(:nspath)) = :nspath
			ORDER BY 
				CHAR_LENGTH(`tny_fs_ns_struct`.`path`) - LENGTH(REPLACE(`tny_fs_ns_struct`.`path`,'/','')) ".$order.",
				`tny_fs_ns_struct`.`order` ASC					
		", array(
				"nspath" => $path,
				"nodepath" => $this->path->getNodePath(),
				"datakey" => $this->path->getDatakey(),
		));
		return $row;
		$key = array();
		foreach ($row as $item){
			$key[] = $item["sid"];
		}
		return $key;
	}
}