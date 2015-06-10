<?php
/**
 * Date: 2014-12-30
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/deliveryOpRegexp.php";
class deliveryInfo{
	/**
	 *
	 * @var IDb
	 */
	public $db;
	/**
	 * @var IPdoBase
	 */
	public $pdo;
	
	public function __construct(){
		$this->_initdb();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	public function info($type,$sid){
		if(!orderTplOpRegexp::isValidorderTplKey($type)){
			return false;
		}
		$row = $this->pdo->fetch("select * from `tny_delivery_".$type."` where `_sid`=:sid", array(
			"sid"=>$sid
		));
		return $row;
	}
}