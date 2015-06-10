<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once ENTRY_PATH."/app/data/datasrc/ADataSrc.php";
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
require_once ENTRY_PATH."/app/data/datasrc/dataSrc.php";
class datasrc_nsdataInfo{
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
	public function getData($order="asc"){
//		var_dump($order);exit;
		if($order !== "asc"){
			$order = "desc";
		}
//		var_dum/p($this->path->getNodePath(),$this->path->getDatakey());exit;
		if($this->path->isNsRoot()){
			$row = $this->pdo->fetchAll("SELECT 
			`tny_fs_datakey_struct`.`dstype`,
			`tny_fs_datakey_struct`.`deco`,
			`tny_fs_ns_struct`.`sid` as `nssid`,
			`tny_fs_ns_struct`.`nt`,
			`tny_fs_ns_struct`.`path` 
			FROM `tny_fs_ns_struct`
				LEFT JOIN `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`sid` = `tny_fs_ns_struct`.`dksid`
				LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
				WHERE `tny_fs_node_struct`.`path` = :nodepath
				AND `tny_fs_datakey_struct`.`key` = :datakey
				AND `tny_fs_ns_struct`.`path` = '/'
				AND `tny_fs_ns_struct`.`nt` = 'file'
				", array(
					"nodepath" => $this->path->getNodePath(),
					"datakey" => $this->path->getDatakey(),
				));
				if(!empty($row)){
					foreach ($row as &$item){
						$item["namespace"] = false;
						$item["data"] = $this->_datasrc($item["dstype"], $item["nssid"]);
					}
					return $row;					
				}
			$path = "/";
		}else{
			$path = $this->path->getNsPath()."/";
		} 
// 		var_dump($this->path->getNodePath(),$this->path->getDatakey(),$path);
		$row = $this->pdo->fetchAll("SELECT 
		`tny_fs_datakey_struct`.`dstype`,
		`tny_fs_datakey_struct`.`deco`,
		`tny_fs_ns_struct`.`sid` as `nssid`,
		`tny_fs_ns_struct`.`nt`,
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
			foreach ($row as &$item){
				$item["namespace"] = true;
				$item["data"] = $this->_datasrc($item["dstype"], $item["nssid"]);
			}
// 		var_dump($this->pdo->getErrorInfo());
//		if(empty($row))return $row;
//		$ret = array();
//		$ret["nsDeco"] = $row[0]["deco"];
//var_dump($row);exit;
		return $row;
	}
	private function _datasrc($dstype,$nssid){
		if(!array_key_exists($dstype, dataSrc::$typeArr)){
			throw new Exception("invalid dstype",0x78);
		}
		switch ($dstype){
			case "22ap":
				return $this->_ds_22ap($nssid);
			case "22ld":
				return $this->_ds_22ld($nssid);
			case "22tp":
				return $this->_ds_22tp($nssid);
			case "23ldp":
				return $this->_ds_23ldp($nssid);
			case "23tpe":
				return $this->_ds_23tpe($nssid);
			case "hot":
				return $this->_ds_hot($nssid);
			case "html":
				return $this->_ds_html($nssid);
		}
	}
	private function _ds_22ap($nssid){
		$row = $this->pdo->fetchAll("SELECT `a`,`p` FROM `tny_fs_datasrc_22ap`
			WHERE `tny_fs_datasrc_22ap`.`nssid` = :nssid
			ORDER BY `a` ASC",
		array(
			"nssid" => $nssid,
		),PDO::FETCH_NUM);
		return $row;
	}
	private function _ds_22ld($nssid){
		$row = $this->pdo->fetchAll("SELECT `l`,`d` FROM `tny_fs_datasrc_22ld`
			WHERE `tny_fs_datasrc_22ld`.`nssid` = :nssid
			ORDER BY `l` ASC",
		array(
			"nssid" => $nssid,
		),PDO::FETCH_NUM);
		return $row;
	}
	private function _ds_22tp($nssid){
		$row = $this->pdo->fetchAll("SELECT `t`,`p` FROM `tny_fs_datasrc_22tp`
			WHERE `tny_fs_datasrc_22tp`.`nssid` = :nssid
			ORDER BY `order` ASC",
		array(
			"nssid" => $nssid,
		),PDO::FETCH_NUM);
		return $row;
	}
	private function _ds_23ldp($nssid){
		$row = $this->pdo->fetchAll("SELECT `l`,`d`,`p` FROM `tny_fs_datasrc_23ldp`
			WHERE `tny_fs_datasrc_23ldp`.`nssid` = :nssid
			ORDER BY `l` ASC",
		array(
			"nssid" => $nssid,
		),PDO::FETCH_NUM);
		return $row;
	}
	private function _ds_23tpe($nssid){
		$row = $this->pdo->fetchAll("SELECT `t`,`p`,`e` FROM `tny_fs_datasrc_23tpe`
			WHERE `tny_fs_datasrc_23tpe`.`nssid` = :nssid
			ORDER BY `tny_fs_datasrc_23tpe`.`order` ASC",
		array(
			"nssid" => $nssid,
		),PDO::FETCH_NUM);
		return $row;
	}
	private function _ds_hot($nssid){
		$row = $this->pdo->fetchAll("SELECT `t`,`op`,`np`,`ico` FROM `tny_fs_datasrc_23tpe`
			WHERE `tny_fs_datasrc_23tpe`.`nssid` = :nssid
			ORDER BY `tny_fs_datasrc_23tpe`.`order` ASC",
		array(
			"nssid" => $nssid,
		),PDO::FETCH_NUM);
		return $row;
	}
	private function _ds_html($nssid){
		$row = $this->pdo->fetchAll("SELECT `c` FROM `tny_fs_datasrc_23tpe`
			WHERE `tny_fs_datasrc_23tpe`.`nssid` = :nssid
			ORDER BY `tny_fs_datasrc_23tpe`.`order` ASC",
		array(
			"nssid" => $nssid,
		),PDO::FETCH_NUM);
		return $row;
	}
}