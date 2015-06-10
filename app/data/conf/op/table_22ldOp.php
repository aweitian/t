<?php
/**
 * Date: 2014-11-27
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/table_22ldOpRegexp.php";
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/DataSrcPath.php";
class table_22ldOp{
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
		if(is_array($data) && table_22ldOpRegexp::isValid($data)){
			$row = $this->dbhelper->getConfInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$this->dataSrcPath = new DataSrcPath($path);
		if($row['typeid'] != 'table_22ld'){
			throw new Exception("path datasrc type is not matched.",0x116);
		}
		$ret = $this->pdo->insert("insert into `tny_fs_conf_table_22ld`
		(`csid`,`mutistyle`,`unitprice`,`tableCaption`,`showType`,`gridCol`,`span`,`spanNum`,`titleType`,`showCalcData`,`showZero2End`,`showA2B`,`comment`) 
				values (:csid,:mutistyle,:unitprice,:tableCaption,:showType,:gridCol,:span,:spanNum,:titleType,:showCalcData,:showZero2End,:showA2B,:comment)", array(
			"csid" => $row['sid'],
			"mutistyle" => $row['mutistyle'],
			"comment" => isset($data['comment']) ? $data['comment'] : "",
			"unitprice" => $data["unitprice"],
			"tableCaption" => $data["tableCaption"],
			"showType" => $data["showType"],
			"gridCol" => $data["gridCol"],
			"span" => $data["span"],
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
		$ret = $this->pdo->insert("delete from `tny_fs_conf_table_22ld` where `csid` = :csid", array(
			"csid" => $sid,
		));
		if(!$ret){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2], $info[1]);
		}
		return $ret;
	}
	public function update($path,$data){
		if(is_array($data) && table_22ldOpRegexp::isValid($data)){
			$row = $this->dbhelper->getConfInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$sid = $this->dbhelper->getConfsidByPath($path);
// 		var_dump($sid);exit;
		$ret = $this->pdo->exec("update `tny_fs_conf_table_22ld` set 
				`mutistyle`=:mutistyle,
				`unitprice`=:unitprice,
				`tableCaption`=:tableCaption,
				`span`=:span,
				`showType`=:showType,
				`gridCol`=:gridCol,
				`spanNum`=:spanNum,
				`titleType`=:titleType,
				`showCalcData`=:showCalcData,
				`showZero2End`=:showZero2End,
				`showA2B`=:showA2B,
				`comment`=:comment
				where `csid` = :csid", array(
			"csid" => $sid,
			"mutistyle" => $data["mutistyle"],
			"unitprice" => $data["unitprice"],
			"comment" => isset($data['comment']) ? $data['comment'] : "",
			"tableCaption" => $data["tableCaption"],
			"span" => $data["span"],
			"showType" => $data["showType"],
			"gridCol" => $data["gridCol"],
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