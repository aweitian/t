<?php
/**
 * Date: 2014-9-24
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
class pathDbHelper{
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
	 * 进行SID和PATH互换
	 */
	public function __construct(){
		$this->_initdb();
	}
	
	public function getPathByNssid($nssid){
		$row = $this->pdo->fetch("SELECT 
		CONCAT(`tny_fs_node_struct`.`path`,'?',`tny_fs_datakey_struct`.`key`,`tny_fs_ns_struct`.`path`) as `path`
			FROM `tny_fs_ns_struct`
			LEFT JOIN  `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`sid` = `tny_fs_ns_struct`.`dksid`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
			WHERE `tny_fs_ns_struct`.`sid`=:nssid", array(
				"nssid"=>$nssid,
		));
		if(empty($row)){
			throw new Exception("invalid nssid",0x440);
		}
		return $row["path"];
	}
	public function getPathByDksid($dksid){
		$row = $this->pdo->fetch("SELECT CONCAT(`tny_fs_node_struct`.`path`,'?',`tny_fs_datakey_struct`.`key`) as `path`
			FROM `tny_fs_datakey_struct`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
			WHERE `tny_fs_datakey_struct`.`sid`=:dksid", array(
				"dksid"=>$dksid,
		));
		if(empty($row)){
			throw new Exception("invalid dksid",0x440);
		}
		return $row["path"];
	}
	public function getPathByCfsid($cfsid){
		$row = $this->pdo->fetch("SELECT CONCAT(`tny_fs_node_struct`.`path`,'?',`tny_fs_confkey_struct`.`key`) as `path`
			FROM `tny_fs_confkey_struct`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_confkey_struct`.`nsid`
			WHERE `tny_fs_confkey_struct`.`sid`=:cfsid", array(
				"cfsid"=>$cfsid,
		));
		if(empty($row)){
			throw new Exception("invalid cfsid",0x440);
		}
		return $row["path"];
	}
	
	
	
	
	public function getNsidByPath($nodeinfopath){
		$row = $this->_get_nodeinfo_row_bypath($nodeinfopath);
		return $row["sid"];
	}
	public function getNodeInfoByPath($nodeinfopath){
		$row = $this->_get_nodeinfo_row_bypath($nodeinfopath);
		return $row;
	}
	public function getDatakeysidByPath($path){
		$p = new DataSrcPath($path);
		$row = $this->_get_datakeyinfo_row_bypath($p->getNodePath(), $p->getDatakey());
		return $row["sid"];
	}
	public function getDatakeyInfoByPath($path){
		$p = new DataSrcPath($path);
		$row = $this->_get_datakeyinfo_row_bypath($p->getNodePath(), $p->getDatakey());
		return $row;
	}
	public function getConfsidByPath($path){
		$p = new DataSrcPath($path);
		$row = $this->_get_confinfo_row_bypath($p->getNodePath(), $p->getDatakey());
		return $row["sid"];
	}
	public function getConfInfoByPath($path){
		$p = new DataSrcPath($path);
		$row = $this->_get_confinfo_row_bypath($p->getNodePath(), $p->getDatakey());
		return $row;
	}
	public function getConfsidBySid($sid){
		$row = $this->_get_confinfo_row_bysid($sid);
		return $row["sid"];
	}
	public function getConfInfoBySid($sid){
		$row = $this->_get_confinfo_row_bysid($sid);
		return $row;
	}
	/**
	 * 结果为空会抛出异常
	 * @param string $path
	 * @return nssid
	 */
	public function getNssidByPath($path){
//		var_dump($path);exit;
		$p = new DataSrcPath($path);
		$row = $this->_get_nsinfo_row_bypath($p->getNodePath(),$p->getDatakey(),$p->getNsPath());
		return $row["sid"];
	}
	/**
	 * 结果为空会抛出异常
	 * @param string $path
	 * @return row
	 */
	public function getNsInfoByPath($path){
		$p = new DataSrcPath($path);
		$row = $this->_get_nsinfo_row_bypath($p->getNodePath(),$p->getDatakey(),$p->getNsPath());
		return $row;
	}
	
	public function getPathByNsid($sid){
		$row = $this->_get_nodeinfo_row_bysid($sid);
		return $row["path"];
	}
	public function getNodeInfoBySid($sid){
		$row = $this->_get_nodeinfo_row_bysid($sid);
		return $row;
	}
	
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	private function _get_nodeinfo_row_bypath($nodepath){
		$row = $this->pdo->fetch("SELECT * FROM tny_fs_node_struct WHERE  `path` = :nodepath", array(
				"nodepath"=>$nodepath,
		));
		if(empty($row)){
			throw new Exception($nodepath." is invalid nodepath",0x440);
		}
		return $row;
	}
	private function _get_datakeyinfo_row_bypath($nodepath,$key){
		$row = $this->pdo->fetch("SELECT 
				`tny_fs_datakey_struct`.`sid` AS `sid`, 
				`tny_fs_datakey_struct`.`nsid` AS `nsid`, 
				`tny_fs_datakey_struct`.`key` AS `key`, 
				`tny_fs_datakey_struct`.`dstype` AS `dstype`, 
				`tny_fs_datakey_struct`.`deco` AS `deco`, 
				`tny_fs_datakey_struct`.`comment` AS `comment`, 
				`tny_fs_datakey_struct`.`date` AS `date`				
				FROM tny_fs_datakey_struct 
				LEFT JOIN tny_fs_node_struct ON tny_fs_node_struct.sid = tny_fs_datakey_struct.nsid
				WHERE
				 `tny_fs_node_struct`.`path` = :path
				AND `tny_fs_datakey_struct`.`key` = :key
				", array(
							"path"=>$nodepath,
							"key" => $key
					));
		if(empty($row)){
			throw new Exception($nodepath."?".$key." is invalid path",0x441);
		}
		return $row;
	}
	private function _get_confinfo_row_bypath($nodepath,$key){
// 		var_dump($nodepath,$key);exit;
		$row = $this->pdo->fetch("SELECT 
				`tny_fs_confkey_struct`.`sid` AS `sid`, 
				`tny_fs_confkey_struct`.`nsid` AS `nsid`, 
				`tny_fs_confkey_struct`.`key` AS `key`, 
				`tny_fs_confkey_struct`.`typeid` AS `typeid`,
				`tny_fs_confkey_struct`.`comment` AS `comment`
				FROM tny_fs_confkey_struct 
				LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_confkey_struct`.`nsid`
				WHERE
				 `tny_fs_node_struct`.`path` = :path
				AND `tny_fs_confkey_struct`.`key` = :key
				", array(
							"path"=>$nodepath,
							"key" => $key
					));
		if(empty($row)){
			throw new Exception($nodepath."?".$key." is invalid path",0x441);
		}
		return $row;
	}
	private function _get_nsinfo_row_bypath($nodepath,$key,$nameSpacePath){
// 		var_dump($nodepath,$key,$nameSpacePath);exit;
		$row = $this->pdo->fetch("SELECT 
				`tny_fs_ns_struct`.`sid`,
				`tny_fs_ns_struct`.`dksid`,
				`tny_fs_ns_struct`.`path`,
				`tny_fs_ns_struct`.`nt`,
				`tny_fs_ns_struct`.`datetime`
			FROM `tny_fs_ns_struct`
			LEFT JOIN `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`sid` = `tny_fs_ns_struct`.`dksid`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
			WHERE
			`tny_fs_node_struct`.`path` = :nodepath
			AND 
			`tny_fs_datakey_struct`.`key` = :key
			AND 
			`tny_fs_ns_struct`.`path` = :nspath
			", array(
						"nodepath"=>$nodepath,
						"key" => $key,
						"nspath" => $nameSpacePath
				));
		if(empty($row)){
			throw new Exception($nodepath."?".$key.$nameSpacePath." is invalid path",0x442);
		}
		return $row;
	}
	private function _get_nodeinfo_row_bysid($sid){
		$row = $this->pdo->fetch("SELECT * FROM tny_fs_node_struct WHERE  `sid` = :sid", array(
				"sid"=>$sid,
		));
		if(empty($row)){
			throw new Exception($sid." is invalid nsid",0x443);
		}
		return $row;
	}
	private function _get_confinfo_row_bysid($sid){
		$row = $this->pdo->fetch("SELECT 
				*				
				FROM tny_fs_confkey_struct 
				WHERE
				 `tny_fs_confkey_struct`.`sid` = :sid
				", array(
					"sid"=>$sid
				));
		if(empty($row)){
			throw new Exception($sid." is invalid datakey sid",0x444);
		}
		return $row;
	}
//	private function _get_nsinfo_row_bysid($sid){
//		$row = $this->pdo->fetch("SELECT * FROM tny_fs_ns_struct WHERE `sid` = :sid", array(
//				"sid"=>$sid,
//		));
//		if(empty($row)){
//			throw new Exception($sid." is invalid ns sid",0x445);
//		}
//		return $row;
//	}
}