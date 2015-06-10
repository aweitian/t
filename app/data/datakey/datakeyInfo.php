<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 * 		获取结点下子结点名
 */
require_once dirname(__FILE__)."/datakeyOpRegexp.php";
require_once DATASRC_PATH."/dataSrc.php";
class datakeyInfo{
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
	public function __construct($path){
		$this->_initdb();
		$p = new DataSrcPath($path);
		if($p->getPathMode() != DataSrcPath::DATAKEYINFO_MODE && $p->getPathMode() != DataSrcPath::DATA_MODE){
			throw new Exception("invalid path:".$path);
		}
		$this->path = $p;
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	/**
	 * @return array(key => comment)
	 */
	public function getChildInfo(){
		$row = $this->pdo->fetchAll("SELECT 
		tny_fs_datakey_struct.`key` as `key`,
		tny_fs_datakey_struct.`comment` as `comment` 
		FROM tny_fs_datakey_struct
		left join `tny_fs_node_struct` on `tny_fs_node_struct`.sid = tny_fs_datakey_struct.nsid
				WHERE
		`tny_fs_node_struct`.path = :nodepath", array("nodepath" => $this->path->getNodePath()));
		$key = array();
		$val = array();
		foreach ($row as $item){
			$key[] = $item["key"];
			$val[] = $item["comment"];
		}
		if(count($key))
			return array_combine($key, $val);
		return array();
	}
	/**
	 * @return array(key => comment)
	 */
	public function getInfo(){
//		var_dump( $this->path->getNodePath(),$this->path->getDatakey());
		$row = $this->pdo->fetch("SELECT 
		`tny_fs_datakey_struct`.`key` as `key`,
		`tny_fs_datakey_struct`.`dstype` as `dstype`,
		`tny_fs_datakey_struct`.`deco` as `deco`,
		`tny_fs_datakey_struct`.`comment` as `comment` 
		FROM tny_fs_datakey_struct
		left join `tny_fs_node_struct` on `tny_fs_node_struct`.sid = tny_fs_datakey_struct.nsid
				WHERE
		`tny_fs_node_struct`.path = :nodepath
		AND `tny_fs_datakey_struct`.`key`=:key", array(
			"nodepath" => $this->path->getNodePath(),
			"key" => $this->path->getDatakey()
		));
		if(empty($row)){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[0]);
		}
		return $row;
	}
	/**
	 * @return array(key => comment)
	 */
	public function getChildDetails(){
		$row = $this->pdo->fetchAll("SELECT 
				`tny_fs_datakey_struct`.`key`,
				`tny_fs_datakey_struct`.`dstype`,
				`tny_fs_datakey_struct`.`deco`,
				`tny_fs_datakey_struct`.`comment` FROM tny_fs_datakey_struct
				left join `tny_fs_node_struct` on `tny_fs_node_struct`.sid = tny_fs_datakey_struct.nsid
				WHERE
		`tny_fs_node_struct`.path = :nodepath", array("nodepath" => $this->path->getNodePath()));
		$key = array();
		$val = array();
		foreach ($row as $item){
			$key[] = $item["key"];
			$val[] = array("dstype"=>$item["dstype"],"deco"=>$item["deco"],"comment"=>$item["comment"]);
		}
		if(count($key))
			return array_combine($key, $val);
		return array();
	}
}	