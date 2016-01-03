<?php
/**
 * Date: 2015年12月31日
 * Author: Awei.tian
 * Description: 
 */
class model{
	/**
	 * 
	 * @var DBUtil
	 */
	protected $db;
	public function __construct(){
		$this->db = DBUtil::getInstance();
	}
	public function debug(){
		return $this->db;
	}
}