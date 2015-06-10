<?php
/**
 * @author:awei.tian
 * @date:2013-12-11
 * @functions:
 */
require_once LIB_PATH."/interfaces/IDb.php";
abstract class ADb implements IDb{
	public function getPdoBase(){
		require_once dirname(__FILE__)."/mysql/mysqlPdoBase.php";
		return new mysqlPdoBase($this->getDbConnection()->getConnection());
	}
	public function getDbInfo(){
		require_once dirname(__FILE__)."/mysql/mysqlDbInfo.php";
		$this->getDbConnection()->getConnection();
		return new mysqlDbInfo(
				$this->getDbConnection()->getConnection(),
				$this->getDbConnection()->getDbname()
		);
		
	}
	public function getDbConnection(){
		$db_pwd =  array(
			"hostname" => DB_HOST,
			"port" => DB_PORT,
			"username" => DB_USER,
			"password" => DB_PASS,
			"database" => DB_NAME,
			"charset" => "utf8"
		);
		return new pdoConnection($db_pwd);
	}
	public function getTableInfo($tabname,$kv=null){
		require_once LIB_PATH."/db/mysql/mysqlTableInfo.php";
		return new mysqlTableInfo($this->getDbConnection(), $tabname);
	}

	public function getColumnInfo($tabname, $columnname,$kv=null){
		require_once LIB_PATH."/db/mysql/mysqlColumnInfo.php";
		return new mysqlColumnInfo($this->getDbConnection()->getConnection(), $tabname, $columnname);
	}
}