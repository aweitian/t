<?php
/**
 * @author:twei.tian
 * @date: 2014-10-3
 * @functions:
 */
require_once dirname(__FILE__)."/datasrc_22tpOpRegexp.php";
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/DataSrcPath.php";
class datasrc_22tpOp{
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
//		var_dump($data);exit;
		if(is_array($data) && datasrc_22tpOpRegexp::isValid($data)){
			$row = $this->dbhelper->getNsInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$this->dataSrcPath = new DataSrcPath($path);
		$dstype = $this->dbhelper->getDatakeyInfoByPath($this->dataSrcPath->getDatakeyPath());
		if($dstype['dstype'] != '22tp'){
			throw new Exception("path datasrc type is not matched.",0x116);
		}
		if($row['nt'] != 'file'){
			throw new Exception("data only can attach to file data node.",0x112);
		}
		$ret = true;
		foreach ($data as $item){
			$id = $this->pdo->insert("insert into `tny_fs_datasrc_22tp`
			(`nssid`,`t`,`p`,`order`) values (:nssid,:t,:p,:order)", array(
				"nssid" => $row['sid'],
				"t" => $item[0],
				"p" => $item[1],
				"order" => $item[2],
			));
			$ret = $ret && $id > 0;
			if(!$ret){
				$info = $this->pdo->getErrorInfo();
				$this->removeByNssid($row['sid']);
				throw new Exception($info[2], $info[1]); 
			}
		}
		return $ret;
	}
	private function removeByNssid($nssid){
		return $this->pdo->exec("delete from tny_fs_datasrc_22tp where nssid=:nssid", array(
			"nssid"=>$nssid
		));
	}
	public function remove($path){
		$nssid = $this->dbhelper->getNssidByPath($path);
		return $this->removeByNssid($nssid);
	}
	public function update($path,$data){
		if(is_array($data) && datasrc_22tpOpRegexp::isValid($data)){
			$row = $this->dbhelper->getNsInfoByPath($path);
		}else{
			throw new Exception("invalid data",0x111);
		}
		$this->dataSrcPath = new DataSrcPath($path);
		$dstype = $this->dbhelper->getDatakeyInfoByPath($this->dataSrcPath->getDatakeyPath());
		if($dstype['dstype'] != '22tp'){
			throw new Exception("path datasrc type is not matched.",0x116);
		}
		$nssid = $row["sid"];
		//$ret[$item["l"]] = $item["sid"];
		$sidArr = $this->_getSidArrByNssid($nssid);
		if(empty($sidArr)){
			$this->add($path, $data);
			return count($data);
		}
		$data = $this->_convertAmountBase($data);
		$c = 0;
		/**
		 * @var $ret[$item["l"]] = $item["sid"];
		 */
		$sidArrBak = $sidArr;
		//更新a存在的
		foreach ($sidArr as $a => $sid){
			if(array_key_exists($a, $data)){
				$c += $this->pdo->exec("update tny_fs_datasrc_22tp set `p`=:p,`order`=:order where sid=:sid and `t`=:t", array(
					"t"=>$a,
					"p"=>$data[$a][0],
					"order"=>$data[$a][1],
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
				$key = key($sidArrBak);
				$sid = $sidArrBak[$key];
//				var_dump($sid);
				$c += $this->pdo->exec("update tny_fs_datasrc_22tp set `p`=:p,`t`=:t,`order`=:order where sid=:sid", array(
					"t"=>$a,
					"p"=>$item[0],
					"order"=>$item[1],
					"sid"=>$sid,
				));
				unset($sidArrBak[$key]);
				unset($databak[$a]);
			}
		}
		//新数据中比老数据长度长，把多的部分插入进去
		foreach ($databak as  $a => $item){
			$c += $this->pdo->exec("insert into tny_fs_datasrc_22tp (`nssid`,`t`,`p`,`order`) values (:nssid,:t,:p,:order)", array(
				"nssid"=>$nssid,
				"t"=>$a,
				"p"=>$item[0],
				"order"=>$item[1],
			));
		}
		//老数据比新数据长，把长的部分删除
		foreach ($sidArrBak as $sid){
			$c += $this->pdo->exec("delete from tny_fs_datasrc_22tp where sid=:sid", array(
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
			$ret[$item[0]] = array($item[1],$item[2]);
		}
		return $ret;
	}
	private function _getSidArrByNssid($nssid){
		$row = $this->pdo->fetchAll("select `t`,`sid` from tny_fs_datasrc_22tp where nssid=:nssid order by `t` asc", array(
			"nssid"=>$nssid,
		));
		if(empty($row))return array();
		$ret = array();
		foreach ($row as $item){
			$ret[$item["t"]] = $item["sid"];
		}
		return $ret;
	}
}