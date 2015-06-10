<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once ENTRY_PATH."/app/data/datasrc/ADataSrc.php";
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
class datasrc_nsInfo{
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
	 * 
	 * @var DataSrcPath
	 */
	public $path;
	public function __construct($path){
		$this->_initdb();
		$p = new DataSrcPath($path);
		if($p->getPathMode() != DataSrcPath::NSINFO_MODE){
			throw new Exception("invalid path:".$path,0x441);
		}
		$this->path = $p;
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	/**
	 * 
	 * @return DataSrc_23tpe
	 * @param unknown_type $dsnsid
	 * @throws Exception
	 */
	public function getData($order="desc"){
		if($order !== "asc"){
			$order = "desc";
		}
		if($this->path->isNsRoot()){
			$path = "/";
		}else{
			$path = $this->path->getNsPath()."/";
		} 
//		var_dump($this->path->getNodePath(),$this->path->getDatakey(),$path);
		$row = $this->pdo->fetchAll("SELECT 
		`tny_fs_datakey_struct`.`dstype`,
		`tny_fs_datakey_struct`.`deco`,
		`tny_fs_ns_struct`.`sid` AS `nssid`,
		`tny_fs_ns_struct`.`path` 
		FROM `tny_fs_ns_struct`
			LEFT JOIN `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`sid` = `tny_fs_ns_struct`.`dksid`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
			WHERE `tny_fs_node_struct`.`path` = :nodepath
			AND `tny_fs_datakey_struct`.`key` = :datakey
			AND LEFT(`tny_fs_ns_struct`.`path`,LENGTH(:nspath_with_slash)) = :nspath_with_slash
			AND `tny_fs_ns_struct`.`path` != '/'
			ORDER BY LENGTH(`tny_fs_ns_struct`.`path`) - LENGTH(REPLACE(`tny_fs_ns_struct`.`path`,'/','')) ".$order.",
			`tny_fs_ns_struct`.`order` ASC", array(
				"nodepath" => $this->path->getNodePath(),
				"datakey" => $this->path->getDatakey(),
				"nspath_with_slash" => $path
			));
//		var_dump($this->pdo->getErrorInfo());
//		if(empty($row))return $row;
//		$ret = array();
//		$ret["nsDeco"] = $row[0]["deco"];
		return $row;
	}
}