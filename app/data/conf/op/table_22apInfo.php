<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/DataSrcPath.php";
require_once ENTRY_PATH."/app/data/conf/base/table_22ap.php";
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
class table_22apInfo{
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
		if($p->getPathMode()!=DatasrcPath::DATA_MODE){
			throw new Exception("invalid path",0x9);
		}
		$this->path = $p;
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	public function getConf(){
		$pathDbHelper = new pathDbHelper();
		$row = $pathDbHelper->getConfInfoByPath($this->path->toString());
		if($row["typeid"] != "table_22ap"){
			throw new Exception("invalid path",0x89);
		}
		$row = $this->pdo->fetch("select `mutistyle`,`unit`,`tableCaption`,`showType`,`gridCol`,`titleType`,`comment` from `tny_fs_conf_table_22ap` where `csid`=:csid", array(
			"csid"=>$row["sid"]
		));
		return $row;
	}	
}