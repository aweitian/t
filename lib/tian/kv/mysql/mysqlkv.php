<?php
/**
 * @author awei.tian
 * date: 2013-9-30
 * 说明:利用MYSQL进行K/V存储
 */
require_once LIB_PATH.'/interfaces/IKv.php';
C::load(ENTRY_PATH.'/app/conf/mysqlkv.php');
class mysqlKv implements Ikv{
	private $dbname;
	private $tbname;
	private $dbEngine;
	private $kvEngine;
	/**
	 * @var IDb
	 */
	private $db;
	public function __construct(){
		$this->db=tian::$context->getDb();
		$this->dbname=$this->db->getDbConnection()->getDbname();
		$this->dbEngine=$this->db->getDbConnection()->getConnection();
		$this->tbname=C::get("kvdb_table_name");
		$dbinfo=$this->db->getDbInfo();
		if(!$dbinfo->tableExists($this->tbname)){
			$this->init();
		}
	}
	private function init(){
		$sql='
		CREATE TABLE IF NOT EXISTS `'.$this->tbname.'` (
		  `key` varchar(200) NOT NULL,
		  `val` text NOT NULL,
		  UNIQUE KEY `key` (`key`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		';
		$r=$this->dbEngine->exec($sql);
		if($r===false){
			$errMsg=$this->dbEngine->errorInfo();
			throw new Exception($errMsg[2]);
		}
	}
	public function get($key){
		$sql='select `val` from `'.$this->tbname.'` where `key`=?';
		$sth=$this->dbEngine->prepare($sql);//
		$sth->execute(array($key));
		$ret = $sth->fetch(PDO::FETCH_ASSOC);
		if($ret!=null)return substr($ret["val"], 0,4)=="arr:"?json_decode(substr($ret["val"],4)):substr($ret["val"],4);
		return false;
	}
	public function set($key,$val){
		$key=substr($key,0,200);
		$sth = $this->dbEngine->prepare('update `'.$this->tbname.'` set `val`=:val where `key`=:key');
		$sth->bindValue(':val',is_array($val)?"arr:".json_encode($val):"str:".$val,PDO::PARAM_STR);
		$sth->bindValue(':key',$key,PDO::PARAM_STR);
		$sth->execute();
		if($sth->rowCount()===0){
			$sth = $this->dbEngine->prepare('insert into `'.$this->tbname.'` (`key`,`val`) values (:key,:val)');
			$sth->bindValue(':val',is_array($val)?"arr:".json_encode($val):"str:".$val,PDO::PARAM_STR);
			$sth->bindValue(':key',$key,PDO::PARAM_STR);
			$sth->execute();
		}
		return true;
	}
	public function delete($key){
		$sth = $this->dbEngine->prepare('delete from `'.$this->tbname.'` where `key`=:key');//PDOStatement
		$sth->bindValue(':key',$key,PDO::PARAM_STR);
		return $sth->execute();//bool
	}
}