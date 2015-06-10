<?php
/**
 * @author: awei.tian
 * @date: 2013-12-14
 * @function:
 */
interface IDataProviderSQL{
	/**
	 * @param string $condition
	 */
	public function addCondition($condition);
	public function applyLimit($start,$offset);
	/**
	 * @return array
	 * 返回结果集KEYS
	 */
	public function getKeys();
	/**
	 * field1 asc,field2 desc,...
	 * Enter description here ...
	 * @param string $orderString
	 */
	public function applyOrder($orderString);
	/**
	 * 带WHERE的计数
	 */
	public function getCountSql();
	public function getSql();
	/**
	 * 不带WHERE的计数
	 */
	public function getTotalCountSql();
}