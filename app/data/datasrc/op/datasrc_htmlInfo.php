<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once DATASRC_PATH."/dataSrc.php";
class datasrc_htmlInfo{
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
	 * @return DataSrc_html
	 * @param unknown_type $dsnsid
	 * @throws Exception
	 */
	public function getData(){
// 		var_dump($this->path->getDatakey());exit;
		$row = $this->pdo->fetch("SELECT `c` FROM `tny_fs_datasrc_html`
			LEFT JOIN `tny_fs_ns_struct` ON `tny_fs_ns_struct`.`sid` = `tny_fs_datasrc_html`.`nssid` AND `tny_fs_ns_struct`.`nt` = 'file'
			LEFT JOIN `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`sid` = `tny_fs_ns_struct`.`dksid`
			LEFT JOIN `tny_fs_node_struct` ON `tny_fs_node_struct`.`sid` = `tny_fs_datakey_struct`.`nsid`
			WHERE `tny_fs_node_struct`.`path` = :nodepath
			AND `tny_fs_datakey_struct`.`key` = :datakey
			AND `tny_fs_ns_struct`.`path` = :nspath
			",
		array(
			"nodepath" => $this->path->getNodePath(),
			"datakey" => $this->path->getDatakey(),
			"nspath" => $this->path->getNsPath(),
		),PDO::FETCH_NUM);
// 		var_dump($row);exit;
		if(empty($row))return "";
		return $row[0];
	}
}