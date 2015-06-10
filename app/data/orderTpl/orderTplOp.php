<?php
/**
 * Date: 2014-10-17
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/orderTplInfo.php";
require_once dirname(__FILE__)."/orderTplOpRegexp.php";
require_once ENTRY_PATH."/app/data/orderTpl/orderTplOpRegexp.php";
// var_dump(class_exists("orderFieldOpRegexp"));exit;
class orderTplOp{
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
	 * @return affected rows
	 */
	public function add($name,$keylist){
		if(!orderTplOpRegexp::isValidorderTplKey($name)){
			throw new Exception("invalid name",0x9);
		}
		if(!orderTplOpRegexp::isValidorderTplKeyList($keylist)){
			throw new Exception("invalid keylist",0x9);
		}
		
		if($this->db->getDbInfo()->tableExists("tny_delivery_".$name)){
			throw new Exception("table tny_delivery_".$name." has exsited",0x8989);
		}
		
//		var_dump($keylist);exit;
		
		$keyArr = explode(",", $keylist);
		$this->pdo->exec("delete from `tny_order_tpl` where `tny_order_tpl`.`name`=:name", array(
			"name"=>$name
		));
		$ofsidArr = array();
		foreach ($keyArr as $key){
			$row = $this->pdo->fetch("select `sid`,`key`,`val`,`typ`,`ept`,`len` from `tny_order_field` where `tny_order_field`.`key` = :key", array(
				"key" => $key,
			));
			if(!empty($row)){
				$ofsidArr[$row["sid"]] = $row;
			}
		}
		$sid = 0;$order = 0;
		$createTabelSql = "CREATE TABLE `tny_delivery_{n}` (
  			`_sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  		";
  		//`_dt` varchar(20) NOT NULL,
		foreach ($ofsidArr as $ofsid => $val){
			$_sid = $this->pdo->insert("insert into `tny_order_tpl` (`ofsid`,`name`,`order`) values 
					(:ofsid,:name,:order)", array(
				"ofsid" => $ofsid,
				"name" => $name,
				"order" => $order,
			));
			$order++;
			if($_sid>0){
				$sid++;
				switch ($val["typ"]){
					case "textarea":
						if(orderFieldOpRegexp::isValidorderFieldKey($val["key"])){
							$createTabelSql .= " `".$val["key"]."` TEXT ".($val["ept"] == "yes" ? "NOT NULL" : "NULL").",";
						}
						break;
					case "input_datetime":
						if(orderFieldOpRegexp::isValidorderFieldKey($val["key"])){
							$createTabelSql .= " `".$val["key"]."` DATETIME ".($val["ept"] == "yes" ? "NOT NULL" : "NULL").",";
						}
						break;
					case "input_date":
						if(orderFieldOpRegexp::isValidorderFieldKey($val["key"])){
							$createTabelSql .= " `".$val["key"]."` DATE ".($val["ept"] == "yes" ? "NOT NULL" : "NULL").",";
						}
						break;
					case "enum":
						if(orderFieldOpRegexp::isValidorderFieldKey($val["key"]) && orderFieldOpRegexp::isValidorderFieldLen($val["typ"], $val["len"])){
							$createTabelSql .= " `".$val["key"]."` ENUM('".join("','",explode(",",$val["len"]))."') ".($val["ept"] == "yes" ? "NOT NULL" : "NULL").",";
						}
						break;
					case "set":
						if(orderFieldOpRegexp::isValidorderFieldKey($val["key"]) && orderFieldOpRegexp::isValidorderFieldLen($val["typ"], $val["len"])){
							$createTabelSql .= " `".$val["key"]."` SET('".join("','",explode(",",$val["len"]))."') ".($val["ept"] == "yes" ? "NOT NULL" : "NULL").",";
						}
						break;
					case "input_file":
						if(orderFieldOpRegexp::isValidorderFieldKey($val["key"]) && orderFieldOpRegexp::isValidorderFieldLen($val["typ"], $val["len"])){
							$createTabelSql .= " `".$val["key"]."` VARBINARY(".$val["len"].")".($val["ept"] == "yes" ? "NOT NULL" : "NULL").",";
						}
						break;
					case "input_str":
						if(orderFieldOpRegexp::isValidorderFieldKey($val["key"]) && orderFieldOpRegexp::isValidorderFieldLen($val["typ"], $val["len"])){
							$createTabelSql .= " `".$val["key"]."` VARCHAR(".$val["len"].")".($val["ept"] == "yes" ? "NOT NULL" : "NULL").",";
						}
						break;						
					case "input_num":
						if(orderFieldOpRegexp::isValidorderFieldKey($val["key"]) && orderFieldOpRegexp::isValidorderFieldLen($val["typ"], $val["len"])){
							$createTabelSql .= " `".$val["key"]."` INT(".$val["len"].")".($val["ept"] == "yes" ? "NOT NULL" : "NULL").",";
						}
						break;						
				}
			}
		}
		if($sid == 0){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2],$info[0]);
		}
		$createTabelSql .= " PRIMARY KEY (`_sid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8";
		$createTabelSql = str_replace("{n}", $name, $createTabelSql);
// 		exit($createTabelSql);exit;
		$this->pdo->exec($createTabelSql, array());
		$info = $this->pdo->getErrorInfo();
		if($info[0] != mysqlPdoBase::NONERRCODE){
			throw new Exception($info[2],$info[0]);
		}
		return $sid;
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @param unknown $name
	 * @throws Exception
	 */
	public function update($name,$keylist){
		throw new Exception("not support",0x9);
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @throws Exception
	 */
	public function remove($name){
		if(!orderTplOpRegexp::isValidorderTplKey($name)){
			throw new Exception("invalid key",0x9);
		}
		$ofsidArr = array();
		if($this->db->getDbInfo()->tableExists("tny_delivery_".$name)){
			$this->pdo->exec("DROP TABLE IF EXISTS `"."tny_delivery_".$name."`", array());
		}
		$row = $this->pdo->exec("delete from `tny_order_tpl` where `tny_order_tpl`.`name`=:name", array(
			"name"=>$name
		));
		if($row == 0){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2],$info[0]);
		}
		$this->syncTblStruct($name);
		return $row;
	}
	private function syncTblStruct($name){
		if(orderTplOpRegexp::isValidorderTplKey($name)&&$this->db->getDbInfo()->tableExists("tny_delivery_".$name)){
			$this->pdo->exec("DROP TABLE `tny_delivery_".$name."`",array());
		}
	}
	public function disable($name){
		if(!orderTplOpRegexp::isValidorderTplKey($name)){
			throw new Exception("invalid key",0x9);
		}
		$row = $this->pdo->exec("UPDATE `tny_order_tpl` SET `tny_order_tpl`.`enable` = 'off' where `tny_order_tpl`.`name`=:name", array(
				"name"=>$name
		));
		if($row == 0){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2],$info[0]);
		}
		return $row;
	}
	public function enable($name){
		if(!orderTplOpRegexp::isValidorderTplKey($name)){
			throw new Exception("invalid key",0x9);
		}
		$row = $this->pdo->exec("UPDATE `tny_order_tpl` SET `tny_order_tpl`.`enable` = 'on' where `tny_order_tpl`.`name`=:name", array(
				"name"=>$name
		));
		if($row == 0){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2],$info[0]);
		}
		return $row;
	}
	
}