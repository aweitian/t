<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/table_23tpeOpRegexp.php";
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/DataSrcPath.php";
class table_23tpeOp{
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
		if(is_array($data) && table_23tpeOpRegexp::isValid($data)){
			$row = $this->dbhelper->getConfInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$this->dataSrcPath = new DataSrcPath($path);
		if($row['typeid'] != 'table_23tpe'){
			throw new Exception("path datasrc type is not matched.",0x116);
		}
		$ret = $this->pdo->insert("insert into `tny_fs_conf_table_23tpe`
		(`csid`,`mutistyle`,`tableCaption`,`showType`,`gridCol`,`titleType`,`extraShowMode`,`iconPlaceHolder`,`extraShowMask`,`extraCaption`,`comment`) 
				values (:csid,:mutistyle,:tableCaption,:showType,:gridCol,:titleType,:extraShowMode,:iconPlaceHolder,:extraShowMask,:extraCaption,:comment)", array(
			"csid" => $row['sid'],
			"comment" => isset($data['comment']) ? $data['comment'] : "",
			"mutistyle" => $data["mutistyle"],
			"tableCaption" => $data["tableCaption"],
			"showType" => $data["showType"],
			"gridCol" => $data["gridCol"],
			"titleType" => $data["titleType"],
			"extraShowMode" => $data["extraShowMode"],
			"iconPlaceHolder" => $data["iconPlaceHolder"],
			"extraShowMask" => $data["extraShowMask"],
			"extraCaption" => $data["extraCaption"],
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]); 
		}
		return $ret;
	}
	public function remove($path){
		$sid = $this->dbhelper->getConfsidByPath($path);
		$ret = $this->pdo->insert("delete from `tny_fs_conf_table_23tpe` where `csid` = :csid", array(
			"csid" => $sid,
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $ret;
	}
	public function update($path,$data){
		if(is_array($data) && table_23tpeOpRegexp::isValid($data)){
			$row = $this->dbhelper->getConfInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$sid = $this->dbhelper->getConfsidByPath($path);
// 		var_dump($sid);exit;
		$ret = $this->pdo->exec("update `tny_fs_conf_table_23tpe` set 
				`mutistyle`=:mutistyle,
				`tableCaption`=:tableCaption,
				`showType`=:showType,
				`gridCol`=:gridCol,
			`titleType`=:titleType,
			`extraShowMode`=:extraShowMode,
			`iconPlaceHolder`=:iconPlaceHolder,
			`extraShowMask`=:extraShowMask,
			`extraCaption`=:extraCaption,
			`comment`=:comment
				where `csid` = :csid", array(
			"csid" => $row['sid'],
			"comment" => isset($data['comment']) ? $data['comment'] : "",
			"mutistyle" => $data["mutistyle"],
			"tableCaption" => $data["tableCaption"],
			"showType" => $data["showType"],
			"gridCol" => $data["gridCol"],
			"titleType" => $data["titleType"],
			"extraShowMode" => $data["extraShowMode"],
			"iconPlaceHolder" => $data["iconPlaceHolder"],
			"extraShowMask" => $data["extraShowMask"],
			"extraCaption" => $data["extraCaption"],
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $ret;
	}
}