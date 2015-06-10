<?php
/**
 * @author awei.tian
 * date: 2013-9-30
 * 说明:
 */
require_once LIB_PATH.'/interfaces/iCache.php';
require_once LIB_PATH.'/db/mysql/dbConnection.php';
require_once LIB_PATH.'/db/mysql/mysqlDbInfo.php';
require_once LIB_PATH.'/db/mysql/mysqlcrud.php';
C::load(ENTRY_PATH.'/app/conf/dbcache.php');

class mysqlDbCache implements ICache{
	private $dbname;
	private $tbname;
	private $dbEngine;
	const LIFETIME_MIN=1;
	const LIFETIME_MAX=65535;//18 hours
	const LIFETIME_ONEMINUTE=60;
	const LIFETIME_FIVEMINUTES=300;
	const LIFETIME_TENMINUTES=600;
	const LIFETIME_ONEHOUR=3600;
	public function __construct(){
		$this->dbname=pdoConnection::getDbname();
		$this->tbname=C::get("cachedb_table_name");
		$this->dbEngine=pdoConnection::getConnection();
		if(!mysqlDbInfo::tableExists($this->dbname, $this->tbname)){
			$this->init();
		}
	}
	private function init(){
		$sql='
		CREATE TABLE IF NOT EXISTS `'.$this->tbname.'` (
		  `key` varchar(200) NOT NULL,
		  `val` text NOT NULL,
		  `lastTrigger` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  `lifetime` smallint(5) unsigned NOT NULL,
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
		$curtime=time();
		$sql='select `val` from `'.$this->tbname.'` where `key`=? and `lastTrigger`+`lifetime`>?';
		$sth=$this->dbEngine->prepare($sql);//
		$sth->execute(array($key,$curtime));
		$ret = $sth->fetch(PDO::FETCH_ASSOC);
		if($ret!=null){
			$ret=$ret["val"];
			$sth = $this->dbEngine->prepare('update `'.$this->tbname.'` set `lastTrigger`=:lastTrigger where `key`=:key');
			$sth->bindParam(':lastTrigger',time(),PDO::PARAM_INT);
			$sth->bindParam(':key',$key,PDO::PARAM_STR);
			$sth->execute();
			return $ret;
		}
		return null;
	}
	public function set($key,$val,$lifetime=self::LIFETIME_TENMINUTES){
		$key=substr($key,0,200);
		$sth = $this->dbEngine->prepare('update `'.$this->tbname.'` set `val`=:val,`lastTrigger`=:lastTrigger,`lifetime`=:lifetime where `key`=:key');
		$sth->bindParam(':val',$val,PDO::PARAM_STR);
		$sth->bindParam(':key',$key,PDO::PARAM_STR);
		$sth->execute();
		if($sth->rowCount()===0){
			$sth = $this->dbEngine->prepare('insert into `'.$this->tbname.'` (`key`,`val`) values (:key,:val)');
			$sth->bindParam(':val',$val,PDO::PARAM_STR);
			$sth->bindParam(':key',$key,PDO::PARAM_STR);
			$sth->execute();
		}
		return $this;
	}
	public function delete($key){
		$sth = $this->dbEngine->prepare('delete from `'.$this->tbname.'` where `key`=:key');
		$sth->bindParam(':key',$key,PDO::PARAM_STR);
		return $sth->execute();
	}
	public function flush(){
		$this->dbEngine->exec("TRUNCATE TABLE `".$this->tbname."`");
	}
}