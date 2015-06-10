<?php
/**
 * @user:awei.tian
 * @date:2014-3-14
 * @usage:接口中不涉及权限问题
 */
interface IApi{
	/**
	 * 返回接口帮助信息
	 */
	public function help();
	public function setUrl($url);
	/**
	 * @param array $args
	 */
	public function setArgs($args);
	public function setMethod($method);
	public function setScenario($scenario);
	public function invoke();
}