<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 * 		获取结点下子结点名
 */
require_once dirname(__FILE__)."/orderFieldOpRegexp.php";
class orderFieldInfo{
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
	/**
	 * @return array(childkey => childtext)
	 */
	public function get($keylist){
		if(!orderFieldOpRegexp::isValidorderFieldKeyList($keylist)){
			throw new Exception("invalid key list",0x989);
		}
		$arr = explode(",", $keylist);
		$sql_arr = array();
		foreach ($arr as $key){
			$sql_arr[] = "SELECT `tny_order_field`.`sid`,
					`tny_order_field`.`key`,
					`tny_order_field`.`val`,
					`tny_order_field`.`typ`,
					`tny_order_field`.`len`,
					`tny_order_field`.`ept`,
					`tny_order_field`.`comment`
				FROM `tny_order_field`
				WHERE `tny_order_field`.`key` = '".$key."'";
		}
		$row = $this->pdo->fetchAll(join(" UNION ", $sql_arr), array());
		return $row;
	}
	/**
	 * @return array(childkey => childtext)
	 */
	public function all(){
		$sql = "SELECT `tny_order_field`.`sid`,
				`tny_order_field`.`key`,
				`tny_order_field`.`val`,
				`tny_order_field`.`typ`,
				`tny_order_field`.`len`,
				`tny_order_field`.`ept`,
				`tny_order_field`.`comment`
			FROM `tny_order_field`
			WHERE 1";
		$row = $this->pdo->fetchAll($sql, array());
		return $row;
	}
	public function getList(){
		$sql = "SELECT `tny_order_field`.`key` FROM `tny_order_field`";

		$row = $this->pdo->fetchAll($sql,array());
		$ret = array();
		foreach ($row as $item){
			$ret[]=$item["key"];
		}
		return $ret;
	}
	public function getKvs(){
		$sql = "SELECT `tny_order_field`.`key`,`tny_order_field`.`val` FROM `tny_order_field`";
		$row = $this->pdo->fetchAll($sql,array());
		return $row;
	}
	
}