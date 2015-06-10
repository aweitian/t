<?php
/**
 * Date: 2014-12-30
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/deliveryOpRegexp.php";
class deliveryOp{
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
	public function add($type,$data){
// 		var_dump($data);exit;
		if(!deliveryOpRegexp::isValidData($type, $data)){
			throw new Exception("invalid data",0x9);
		}
		$sql = array();
		$sql[] = "insert into `tny_delivery_".$type."` ";
		$sql[] = "(`";
		$helper = new orderTplInfo();
		$fields = $helper->getDeliveryInfos($type);
		$sql_fields = array();
		$sql_values = array();
		$sql_rdatas = array();
		foreach ($fields as $field){
			$sql_fields[] = $field["key"];
			$sql_values[] = ":".$field["key"];
			$sql_rdatas[$field["key"]] = $data[$field["key"]];
		}
		$sql[] = join("`,`",$sql_fields);
		$sql[] = "`)";
		$sql[] = " values ";
		$sql[] = "(";
		$sql[] = join(",",$sql_values);
		$sql[] = ")";
// 		var_dump(join("",$sql),$sql_rdatas);exit;
		$sid = $this->pdo->insert(join("",$sql), $sql_rdatas);
		if($sid>0){
			return $sid;
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2],$info[0]);
	}
	public function remove($type,$sid){
		if(!orderTplOpRegexp::isValidorderTplKey($type)){
			return false;
		}
		$row = $this->pdo->exec("delete from `tny_delivery_".$type."` where `_sid`=:sid", array(
			"sid"=>$sid
		));
		if($row>0){
			return $row;
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2],$info[0]);
	}
}