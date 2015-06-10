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
		$db_pwd = array();
		if(ENVIR==ENVIR_COMMON){
			$db_pwd = require ENTRY_PATH."/pd/db_pwd/local.php";
		}
		elseif (ENVIR==ENVIR_SAE){
			$db_pwd = require ENTRY_PATH."/pd/db_pwd/sae.php";
		}
		elseif (ENVIR==ENVIR_BAE){
			$db_pwd = require ENTRY_PATH."/pd/db_pwd/bae.php";
		}
		elseif (ENVIR==ENVIR_OPENSHIFT){
			$db_pwd = require ENTRY_PATH."/pd/db_pwd/openshift.php";
		}
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