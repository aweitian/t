<?php
/**
 * @author:twei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once dirname(__FILE__)."/datasrc_htmlOpRegexp.php";
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/DataSrcPath.php";
class datasrc_htmlOp{
	/**
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
	public $dataSrcPath;
	/**
	 * @var pathDbHelper
	 */
	public $dbhelper;
	public function __construct(){
		$this->_initdb();
		$this->dbhelper = new pathDbHelper();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	/**
	 * 
	 * @return bool
	 * @param string path
	 * @param data
	 */
	public function add($path,$data){
		if(datasrc_htmlOpRegexp::isValidData($data)){
			$row = $this->dbhelper->getNsInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$this->dataSrcPath = new DataSrcPath($path);
		$dstype = $this->dbhelper->getDatakeyInfoByPath($this->dataSrcPath->getDatakeyPath());
		if($dstype['dstype'] != 'html'){
			throw new Exception("path datasrc type is not matched.",0x116);
		}
		if($row['nt'] != 'file'){
			throw new Exception("data only can attach to file data node.",0x112);
		}
		$ret = $this->pdo->insert("insert into `tny_fs_datasrc_html`
		(`nssid`,`c`) values (:nssid,:c)", array(
			"nssid" => $row['sid'],
			"c" => $data,
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]); 
		}
		return $ret;
	}
	private function remove($path){
		if(datasrc_htmlOpRegexp::isValidData($data)){
			$row = $this->dbhelper->getNsInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$ret =  $this->pdo->exec("delete from tny_fs_datasrc_html 
				where `nssid`=:nssid", array(
			"nssid"=>$row['sid'],
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $ret;
	}
	public function update($path,$data){
		if(datasrc_htmlOpRegexp::isValidData($data)){
			$row = $this->dbhelper->getNsInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$ret = $this->pdo->exec("update tny_fs_datasrc_html
				set `c`=:c
				where `nssid`=:nssid", array(
								"nssid"=>$row['sid'],
								"c"=>$data,
						));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $ret;
	}
}