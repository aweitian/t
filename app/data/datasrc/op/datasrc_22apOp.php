<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once dirname(__FILE__)."/datasrc_22apOpRegexp.php";
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/DataSrcPath.php";
class datasrc_22apOp{
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
		if(is_array($data) && datasrc_22apOpRegexp::isValid($data)){
			$row = $this->dbhelper->getNsInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$this->dataSrcPath = new DataSrcPath($path);
		$dstype = $this->dbhelper->getDatakeyInfoByPath($this->dataSrcPath->getDatakeyPath());
		if($dstype['dstype'] != '22ap'){
			throw new Exception("path datasrc type is not matched.",0x116);
		}
		if($row['nt'] != 'file'){
			throw new Exception("data only can attach to file data node.",0x112);
		}
		$ret = true;
		foreach ($data as $item){
			$id = $this->pdo->insert("insert into `tny_fs_datasrc_22ap`
			(`nssid`,`a`,`p`) values (:nssid,:a,:p)", array(
				"nssid" => $row['sid'],
				"a" => $item[0],
				"p" => $item[1],
			));
			$ret = $ret && $id > 0;
			if(!$ret){
				$info = $this->pdo->getErrorInfo();
				var_dump($info);
				$this->removeByNssid($row['sid']);
				throw new Exception($info[2], $info[1]); 
			}
		}
		return $ret;
	}
	private function removeByNssid($nssid){
		return $this->pdo->exec("delete from tny_fs_datasrc_22ap where nssid=:nssid", array(
			"nssid"=>$nssid
		));
	}
	public function remove($path){
		$nssid = $this->dbhelper->getNssidByPath($path);
		return $this->removeByNssid($nssid);
	}
	public function update($path,$data){
		if(is_array($data) && datasrc_22apOpRegexp::isValid($data)){
			$row = $this->dbhelper->getNsInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$this->dataSrcPath = new DataSrcPath($path);
		$dstype = $this->dbhelper->getDatakeyInfoByPath($this->dataSrcPath->getDatakeyPath());
		if($dstype['dstype'] != '22ap'){
			throw new Exception("path datasrc type is not matched.",0x116);
		}
		$nssid = $row["sid"];
		//$ret[$item["a"]] = $item["sid"];
		$sidArr = $this->_getSidArrByNssid($nssid);
		if(empty($sidArr)){
			$this->add($path, $data);
			return count($data);
		}
		$data = $this->_convertAmountBase($data);
		$c = 0;
		$sidArrBak = $sidArr;
		//更新a存在的
		foreach ($sidArr as $a => $sid){
			if(array_key_exists($a, $data)){
				$c += $this->pdo->exec("update tny_fs_datasrc_22ap set p=:p where sid=:sid and a=:a", array(
					"a"=>$a,
					"p"=>$data[$a][0],
					"sid"=>$sid,
				));
				unset($data[$a]);
				unset($sidArrBak[$a]);
			}
		}
		$databak = $data;
		
		//更新新数据中余下部分，要更新长度和老数据余下部分相同
		foreach ($data as $a => $item){
			if(!is_null(key($sidArrBak))){
				$sid = $sidArrBak[key($sidArrBak)];
				$c += $this->pdo->exec("update tny_fs_datasrc_22ap set p=:p,a=:a where sid=:sid", array(
					"a"=>$a,
					"p"=>$item[0],
					"sid"=>$sid,
				));
				unset($sidArrBak[key($sidArrBak)]);
				unset($databak[$a]);
			}
		}
		//新数据中比老数据长度长，把多的部分插入进去
		foreach ($databak as  $a => $item){
			$c += $this->pdo->exec("insert into tny_fs_datasrc_22ap (`nssid`,`a`,`p`) values (:nssid,:a,:p)", array(
				"nssid"=>$nssid,
				"a"=>$a,
				"p"=>$item[0],
			));
		}
		//老数据比新数据长，把长的部分删除
		foreach ($sidArrBak as $sid){
			$c += $this->pdo->exec("delete from tny_fs_datasrc_22ap where sid=:sid", array(
				"sid"=>$sid,
			));
		}
		return $c;
	}
	/**
	 * 
	 * @return array(amount=>array(price))
	 * @param array $data
	 */
	private function _convertAmountBase($data){
		$ret = array();
		foreach ($data as $item){
			$ret[$item[0]] = array($item[1]);
		}
		return $ret;
	}
	private function _getSidArrByNssid($nssid){
		$row = $this->pdo->fetchAll("select `a`,`sid` from tny_fs_datasrc_22ap where nssid=:nssid order by a asc", array(
			"nssid"=>$nssid,
		));
		if(empty($row))return array();
		$ret = array();
		foreach ($row as $item){
			$ret[$item["a"]] = $item["sid"];
		}
		return $ret;
	}
}