<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/table_23ldpOpRegexp.php";
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/DataSrcPath.php";
class table_23ldpOp{
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
		if(isset($data["span"]) && is_string($data["span"])){
			$data["span"] = explode(",", $data["span"]);
		}
		if(is_array($data) && table_23ldpOpRegexp::isValid($data)){
			$row = $this->dbhelper->getConfInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$this->dataSrcPath = new DataSrcPath($path);
		if($row['typeid'] != 'table_23ldp'){
			throw new Exception("path datasrc type is not matched.",0x116);
		}
		$ret = $this->pdo->insert("insert into `tny_fs_conf_table_23ldp`
		(`csid`,`mutistyle`,`tableCaption`,`showType`,`gridCol`,`span`,`spanNum`,`titleType`,`showCalcData`,`showZero2End`,`showA2B`,`comment`) 
				values (:csid,:mutistyle,:tableCaption,:showType,:gridCol,:span,:spanNum,:titleType,:showCalcData,:showZero2End,:showA2B,:comment)", array(
			"csid" => $row['sid'],
			"comment" => isset($data['comment']) ? $data['comment'] : "",
			"mutistyle" => $data["mutistyle"],
			"tableCaption" => $data["tableCaption"],
			"showType" => $data["showType"],
			"gridCol" => $data["gridCol"],
			"span" => is_array($data["span"]) ? join(",",$data["span"]) : $data["span"],
			"spanNum" => $data["spanNum"],
			"titleType" => $data["titleType"],
			"showCalcData" => $data["showCalcData"],
			"showZero2End" => $data["showZero2End"],
			"showA2B" => $data["showA2B"],
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]); 
		}
		return $ret;
	}
	public function remove($path){
		$sid = $this->dbhelper->getConfsidByPath($path);
		$ret = $this->pdo->insert("delete from `tny_fs_conf_table_23ldp` where `csid` = :csid", array(
			"csid" => $sid,
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $ret;
	}
	public function update($path,$data){
		if(is_array($data) && table_23ldpOpRegexp::isValid($data)){
			$row = $this->dbhelper->getConfInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$sid = $this->dbhelper->getConfsidByPath($path);
// 		var_dump($sid);exit;
		$ret = $this->pdo->exec("update `tny_fs_conf_table_23ldp` set 
			`mutistyle`=:mutistyle,
			`tableCaption`=:tableCaption,
			`showType`=:showType,
			`gridCol`=:gridCol,
			`span`=:span,
			`spanNum`=:spanNum,
			`titleType`=:titleType,
			`showCalcData`=:showCalcData,
			`showZero2End`=:showZero2End,
			`showA2B`=:showA2B,
			`comment`=:comment
				where `csid` = :csid", array(
			"csid" => $sid,
			"comment" => isset($data['comment']) ? $data['comment'] : "",
			"mutistyle" => $data["mutistyle"],
			"tableCaption" => $data["tableCaption"],
			"showType" => $data["showType"],
			"gridCol" => $data["gridCol"],
			"span" =>  is_array($data["span"]) ? join(",",$data["span"]) : $data["span"],
			"spanNum" => $data["spanNum"],
			"titleType" => $data["titleType"],
			"showCalcData" => $data["showCalcData"],
			"showZero2End" => $data["showZero2End"],
			"showA2B" => $data["showA2B"],
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $ret;
	}
}