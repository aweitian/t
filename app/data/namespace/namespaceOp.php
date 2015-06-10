<?php
/**
 * Date: 2014-9-29
 * Author: Awei.tian
 * function: 
 */
require_once LIB_PATH."/functions.php";
require_once dirname(__FILE__)."/namespaceInfo.php";
require_once dirname(__FILE__)."/namespaceOpRegexp.php";
require_once DATASRC_PATH."/pathDbHelper.php";
class namespaceOp{
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

	private $removeCount = 0;
	public function __construct(){
		$this->_initdb();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	/**
	 * @return dsnsid
	 */
	public function add($path,$key,$nt,$da="",$order=0){
		$p = new pathDbHelper();
		$row = $p->getNsInfoByPath($path);
		if(!preg_match(namespaceOpRegexp::$key,$key)){
			throw new Exception("key is invalid",x090);
		}
		if(!namespaceOpRegexp::isValidNT($nt)){
			throw new Exception("data node type is invalid",0x909);
		}
		if(!namespaceOpRegexp::isValidOrder($order)){
			throw new Exception("order is invalid",0x102);
		}
		if(!namespaceOpRegexp::isValidDa($da)){
			throw new Exception("delivery alias is invalid",0x123);
		}
		$p = new DataSrcPath($path);
		$path = $p->getChildNsPath($key);
		if($row["nt"] != "folder"){
			throw new Exception("add data to dataNode is not allowed.",45);
			return 0;
		}
		$dsnsid = $this->pdo->insert("insert into tny_fs_ns_struct (`dksid`,`path`,`nt`,`order`,`da`) values 
				(:dksid,:path,:nt,:order,:da)", array(
			"dksid" => $row["dksid"],
			"path" => $path,
			"nt" => $nt,
			"da" => $da,
			"order" => $order
		));
		return $dsnsid;
	}
	/**
	 * @return 返回影响的行数
	 * @param sid/path $ns
	 * @param string $name
	 * @throws Exception
	 */
	public function update($path,$newkey,$order=0,$da=""){
		if(!preg_match(namespaceOpRegexp::$key,$newkey)){
			throw new Exception("key is invalid");
		}
		if(!namespaceOpRegexp::isValidOrder($order)){
			throw new Exception("order is invalid");
		}
		if(!namespaceOpRegexp::isValidDa($da)){
			throw new Exception("da is invalid");
		}
		$dsp = new DataSrcPath($path);
		if($dsp->getPathMode() != DataSrcPath::NSINFO_MODE){
			throw new Exception("invalid path mode",0x34);
		}
		$nspath = $dsp->getNsPath();
		$newnspath = util::getNewPath($nspath, $newkey);
		$p = new pathDbHelper();
		$nssid = $p->getNssidByPath($path);
		
		if(rtrim($nspath,"/") == $newnspath){
			return $this->_update_sid($nssid, $order);
		}else{
			$dksid = $p->getDatakeysidByPath($dsp->getNodePath()."?".$dsp->getDatakey());
			$subpath = $nspath."/";
			$row = $this->pdo->exec("UPDATE `tny_fs_ns_struct`
				SET `path` = CONCAT(:newpath,substr(`path`,char_length(:path)+2)),
				`order` = :order,
				`da` = :da
			 	where
				LEFT(`path`,CHAR_LENGTH(:subpath)) = :subpath
				AND `dksid` = :dksid
				", array(
					"dksid" => $dksid,
					"path" => $nspath,
					"da" => $da,
					"order" => $order,
					"subpath" => $subpath,
					"newpath" => $newnspath."/",
			));
			if($row <= 0){
				$info = $this->pdo->getErrorInfo();
				throw new Exception($info[2], $info[0]);
			}
			return $this->pdo->exec("update `tny_fs_ns_struct`
				set `order`=:order,`path`=:newpath
				where `path` = :path AND `dksid` = :dksid", array(
						"path" => $nspath,
						"newpath" => $newnspath,
						"order" => $order,
						"dksid" => $dksid
				));
		}
	}
	private function _update_sid($id,$order){
		return $this->pdo->exec("update `tny_fs_ns_struct` set 
		`order` = :order 
		where `sid` = :sid", array(
				"sid" => $id,
				"order" => $order,
		));	
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @throws Exception
	 */
	public function remove($path){
		$p = new DataSrcPath($path);
		if($p->getPathMode() != DataSrcPath::NSINFO_MODE){
			throw new Exception("invalid path:".$path);
		}
		$this->removeCount = 0;
		$sql = "";
		$dsrArr = dataSrc::$typeArr;
		$sql .= "DELETE `tny_fs_ns_struct`";
		foreach (array_keys($dsrArr) as $dsr){
			$sql .= ",`tny_fs_datasrc_".$dsr."`";
		}
		$sql .= " FROM `tny_fs_ns_struct`";
		foreach (array_keys($dsrArr) as $dsr){
			$sql .= " LEFT JOIN `tny_fs_datasrc_".$dsr."` ON `tny_fs_datasrc_".$dsr."`.`nssid` = `tny_fs_ns_struct`.`sid`";
		}
		$sql .= " 	LEFT JOIN `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`sid` = `tny_fs_ns_struct`.`dksid`
 	LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
		";
		$sql .= " where
			 	`tny_fs_node_struct`.`path`=:path
			 	AND `tny_fs_datakey_struct`.`key` = :key
			 AND
			 	LEFT(`tny_fs_ns_struct`.`path`,CHAR_LENGTH(:nspath)) = :nspath
		";
//		exit($sql);
		$this->removeCount = $this->pdo->exec($sql, array(
			"path" => $p->getNodePath(),
			"key" => $p->getDatakey(),
			"nspath" => $p->getNsPath(),
		));
		return $this->removeCount;
	}
}