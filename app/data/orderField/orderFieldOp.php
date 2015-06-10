<?php
/**
 * Date: 2014-10-17
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/orderFieldInfo.php";
require_once dirname(__FILE__)."/orderFieldOpRegexp.php";
require_once ENTRY_PATH."/app/data/orderTpl/orderTplOpRegexp.php";
class orderFieldOp{
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
	 * @return npsid
	 */
	public function add($key,$val,$typ,$len,$ept,$comment=""){
		if(!orderFieldOpRegexp::isValidorderFieldKey($key)){
			throw new Exception("invalid key",0x9);
		}
		if(!orderFieldOpRegexp::isValidorderFieldVal($val)){
			throw new Exception("orderField name is too long",0x89);
		}
		if(!orderFieldOpRegexp::isValidorderFieldTyp($typ)){
			throw new Exception("invalid type",0x89);
		}
		if(!orderFieldOpRegexp::isValidorderFieldLen($typ, $len)){
			throw new Exception("invalid len ",0x89);
		}
		if(!orderFieldOpRegexp::isValidorderFieldEpt($ept)){
			throw new Exception("invalid is null",0x89);
		}
		$sid = $this->pdo->insert("insert into `tny_order_field` 
				(`key`,`val`,`typ`,`len`,`ept`,`comment`) 
				values 
				(:key,:val,:typ,:len,:ept,:comment)", array(
					"key"=>$key,
					"val"=>$val,
					"typ"=>$typ,
					"len"=>$len,
					"ept"=>$ept,
					"comment"=>$comment
		));
		if($sid == 0){
			$info = $this->pdo->getErrorInfo();
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
	public function update($key,$val,$typ,$len,$ept,$comment=""){
		throw new Exception("not support yet",0x9090);
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @throws Exception
	 */
	public function remove($key){
		if(!orderFieldOpRegexp::isValidorderFieldKey($key)){
			throw new Exception("orderField key is invalid",0x236);
		}
		$row = $this->pdo->exec("DELETE `tny_order_field`,`tny_order_tpl`
			FROM `tny_order_field`
			LEFT JOIN `tny_order_tpl` ON `tny_order_tpl`.`ofsid` = `tny_order_field`.`sid`
			WHERE `tny_order_field`.`key` = :key
				", array(
			"key" => $key
		));
		if($row == 0){
			$info = $this->pdo->getErrorInfo();
			throw new Exception($info[2],$info[0]);
		}
		$this->syncTblStruct($key);
		return $row;
	}
	private function syncTblStruct($key){
		//ALTER TABLE table_name DROP field_name;   
		if(!orderFieldOpRegexp::isValidorderFieldKey($key)){
			throw new Exception("orderField key is invalid",0x236);
		}
		$names = $this->pdo->fetchAll("SELECT `tny_order_tpl`.`name` FROM `tny_order_tpl`
			GROUP BY `tny_order_tpl`.`name`", array(
		));
		foreach ($names as $item){
			$name = $item["name"];
			if(orderTplOpRegexp::isValidorderTplKey($name)&&$this->db->getDbInfo()->tableExists("tny_delivery_".$name)){
				$this->pdo->exec("ALTER TABLE tny_delivery_".$name." DROP ".$key,array());
			}
		}
	}
}