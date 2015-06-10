<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/table_22apOpRegexp.php";
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/DataSrcPath.php";
class table_22apOp{
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
		if(is_array($data) && table_22apOpRegexp::isValid($data)){
			$row = $this->dbhelper->getConfInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$this->dataSrcPath = new DataSrcPath($path);
		if($row['typeid'] != 'table_22ap'){
			throw new Exception("path datasrc type is not matched.",0x116);
		}
		$ret = $this->pdo->insert("insert into `tny_fs_conf_table_22ap`
		(`csid`,`mutistyle`,`unit`,`tableCaption`,`showType`,`gridCol`,`titleType`,`comment`) 
				values (:csid,:mutistyle,:unit,:tableCaption,:showType,:gridCol,:titleType,:comment)", array(
			"csid" => $row['sid'],
			"mutistyle" => $data['mutistyle'],
			"comment" => isset($data['comment']) ? $data['comment'] : "",
			"unit" => $data["unit"],
			"tableCaption" => $data["tableCaption"],
			"showType" => $data["showType"],
			"gridCol" => $data["gridCol"],
			"titleType" => $data["titleType"],
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]); 
		}
		return $ret;
	}
	public function remove($path){
		$sid = $this->dbhelper->getConfsidByPath($path);
		$ret = $this->pdo->insert("delete from `tny_fs_conf_table_22ap` where `csid` = :csid", array(
			"csid" => $sid,
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $ret;
	}
	public function update($path,$data){
		if(is_array($data) && table_22apOpRegexp::isValid($data)){
			$row = $this->dbhelper->getConfInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$sid = $this->dbhelper->getConfsidByPath($path);
// 		var_dump($sid);exit;
		$ret = $this->pdo->exec("update `tny_fs_conf_table_22ap` set 
				`mutistyle` = :mutistyle,	
				`unit` = :unit,	
				`tableCaption` = :tableCaption,	
				`showType` = :showType,	
				`gridCol` = :gridCol,	
				`titleType` = :titleType,	
				`comment` = :comment	
				where `csid` = :csid", array(
			"csid" => $sid,
			"mutistyle" => $data["mutistyle"],
			"unit" => $data["unit"],
			"tableCaption" => $data["tableCaption"],
			"showType" => $data["showType"],
			"gridCol" => $data["gridCol"],
			"titleType" => $data["titleType"],
			"comment" => isset($data['comment']) ? $data['comment'] : "",
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $ret;
	}
}