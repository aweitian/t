<?php
/**
 * @author:awei.tian
 * @date:2013-12-11
 * @functions:
 */
interface IDb{
	/**
	 * @return IPdoBase
	 */
	public function getPdoBase();
	/**
	 * @return IDbConnection
	 */
	public function getDbConnection();
	/**
	 * @return IDbInfo
	 */
	public function getDbInfo();
	/**
	 * @return ITableInfo
	 */
	public function getTableInfo($tabname,$kv=null);
	/**
	 * @return IColumnInfo
	 */
	public function getColumnInfo($tabname, $columnname,$kv=null);
}