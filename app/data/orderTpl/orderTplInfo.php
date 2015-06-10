<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 * 		获取结点下子结点名
 */
require_once dirname(__FILE__)."/orderTplOpRegexp.php";
class orderTplInfo{
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
	public function getDeliveryInfos($name){
		return $this->pdo->fetchAll("SELECT `tny_order_field`.`key`,
			`tny_order_field`.`val`,
			`tny_order_field`.`typ`,
			`tny_order_field`.`len`,
			`tny_order_field`.`ept`	
						
			FROM `tny_order_field`
			LEFT JOIN `tny_order_tpl` ON `tny_order_tpl`.`ofsid` = `tny_order_field`.`sid`
			WHERE `tny_order_tpl`.`name` = :name
			AND `tny_order_tpl`.`enable` = 'on'
			ORDER BY `tny_order_tpl`.`order` ASC", array(
			"name"=>$name
		));
	}
	public function getNameList(){
		return $this->pdo->fetchAll("SELECT `tny_order_tpl`.`name` FROM `tny_order_tpl`
			WHERE `enable` = 'on'
			GROUP BY `tny_order_tpl`.`name` ", array(
		));
	}
	public function getTplInfo(){
		return $this->pdo->fetchAll("SELECT `tny_order_field`.`val` AS `ofname`,
			`tny_order_tpl`.`name` AS `name`,
			`tny_order_tpl`.`enable` AS `enable`,
			`tny_order_tpl`.`order` AS `order`
			FROM `tny_order_tpl`
			LEFT JOIN `tny_order_field` ON `tny_order_field`.`sid` = `tny_order_tpl`.`ofsid`
			ORDER BY `tny_order_tpl`.`name`,`tny_order_tpl`.`order`", array(
		));
	}
}