<?php
/**
 * Date: 2014-12-29
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/orderInfo.php";
require_once dirname(__FILE__)."/orderOpValidator.php";
require_once ENTRY_PATH."/app/data/delivery/deliveryOp.php";
require_once ENTRY_PATH."/app/data/delivery/deliveryInfo.php";

class orderOp{
	/**
	 *
	 * @var IDb
	 */
	public $db;
	/**
	 * @var IPdoBase
	 */
	public $pdo;

	public $pathDbHelper;
	public function __construct(){
		$this->_initdb();
		$this->pathDbHelper = new pathDbHelper();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}


	/**
	 * @return tny_order_his.sid
	 * or throw Exception
	 */
	public function add($pmtype,$eml,$delivery_type,$title,$price,$nodepath,$widget_order,$loc_price,$deliveryData,$ip){
		if(!orderOpValidator::isValidPmtype($pmtype)){
			throw new Exception("invalid Payment type",0x1);
		}
		if(!orderOpValidator::isValidTitle($title)){
			throw new Exception("invalid title",0x1);
		}
		if(!orderOpValidator::isValidPrice($price)){
			throw new Exception("invalid price",0x1);
		}
		if(!orderOpValidator::isValidWidgetOrder($widget_order)){
			throw new Exception("invalid WidgetOrder",0x1);
		}
		if(!orderOpValidator::isValidLocPrice($loc_price)){
			throw new Exception("invalid WidgetOrder",0x1);
		}
		if(!orderOpValidator::isValidIp($ip)){
			throw new Exception("invalid ip",0x1);
		}
		$helper = new deliveryOp();
		$delivery_sid = $helper->add($delivery_type, $deliveryData);
		$helper = new pathDbHelper();
		$nsid = $helper->getNsidByPath($nodepath);
		$data = array(
			"pmtype"=>$pmtype,
			"eml"=>$eml,
			"dt"=>$delivery_type,
			"title"=>$title,
			"price"=>$price,
			"nsid"=>$nsid,
			"widord"=>$widget_order,
			"locprice"=>$loc_price,
			"dlvid"=>$delivery_sid,
			"ip"=>$ip,
		);
		$sid = $this->pdo->insert("insert into `tny_order_his` (
			`pmtype`,
			`eml`,
			`dt`,
			`title`,
			`price`,
			`nsid`,
			`widord`,
			`locprice`,
			`dlvid`,
			`ip`
		) values (
			:pmtype,
			:eml,
			:dt,
			:title,
			:price,
			:nsid,
			:widord,
			:locprice,
			:dlvid,
			:ip)", $data);
		if($sid>0){
			return $sid;
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2],$info[0]);
	}
	
	
	public function updateSt($sid,$st){
		return $this->pdo->exec("update `tny_order_his` set `st`=:st where `sid`=:sid", array(
			"sid"=>$sid,
			"st"=>(int)$st
		));
	}
	
	
	/**
	 * @return 返回影响的行数
	 * @param string $sid
	 * @throws Exception
	 */
	public function remove($sid){
		$helper = new orderInfo();
		$orderinfo = $helper->info($sid);
		if(empty($orderinfo)){
			return $this->rmhis($sid);
		}		
		$type = $orderinfo["dt"];
		$dsid = $orderinfo["dlvid"];
		$helper = new deliveryOp();
		$helper->remove($type, $dsid);
		return $this->rmhis($sid);
	}
	private function rmhis($sid){
		$row = $this->pdo->exec("delete from `tny_order_his` where `sid`=:sid", array(
				"sid"=>$sid
		));
		if($row>0){
			return $row;
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2],$info[0]);
	}
}