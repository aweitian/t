<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/spancalc_22ldOpRegexp.php";
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/DataSrcPath.php";
class spancalc_22ldOp{
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
	private $helper;
	private $dbhelper;
	public function __construct(){
		$this->_initdb();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
		$this->dbhelper = new pathDbHelper(); 
	}
	/**
	 * 
	 * @return bool
	 * @param string path
	 * @param data
	 */
	public function add($path,$data){
// 		var_dump($data);exit();
		if(is_array($data) && spancalc_22ldOpRegexp::isValid($data)){
			$row = $this->dbhelper->getConfInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$this->dataSrcPath = new DataSrcPath($path);
		if($row['typeid'] != 'spancalc_22ld'){
			throw new Exception("path datasrc type is not matched.",0x116);
		}
		$ret = $this->pdo->insert("insert into `tny_fs_conf_spancalc_22ld`
		(`csid`,`unit`,`cachejs`,`comment`) values (:csid,:unit,:cachejs,:comment)", array(
			"csid" => $row['sid'],
			"comment" => isset($data['comment']) ? $data['comment'] : "",
			"unit" => $data["unit"],
			"cachejs" => $data["cachejs"],
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]); 
		}
		return $ret;
	}
	public function remove($path){
		$sid = $this->dbhelper->getConfsidByPath($path);
		$ret = $this->pdo->insert("delete from `tny_fs_conf_spancalc_22ld` where `csid` = :csid", array(
			"csid" => $sid,
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $ret;
	}
	public function update($path,$data){
		if(is_array($data) && spancalc_22ldOpRegexp::isValid($data)){
			$row = $this->dbhelper->getConfInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$sid = $this->dbhelper->getConfsidByPath($path);
// 		var_dump($sid);exit;
		$ret = $this->pdo->exec("update `tny_fs_conf_spancalc_22ld` set 
				`cachejs` = :cachejs,	
				`comment` = :comment,	
				`unit` = :unit	
				where `csid` = :csid", array(
			"csid" => $sid,
			"unit" => $data["unit"],
			"comment" => isset($data['comment']) ? $data['comment'] : "",
			"cachejs" => $data["cachejs"],
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $ret;
	}
}