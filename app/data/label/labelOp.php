<?php
/**
 * Date: 2014-10-17
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/labelInfo.php";
require_once dirname(__FILE__)."/labelOpRegexp.php";
class labelOp{
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
	public function add($val){
		if(!labelOpRegexp::isValidlabelVal($val)){
			throw new Exception("label name is too long");
		}
		$row = $this->pdo->fetch("SELECT SUM(1<<lk) as bitchk FROM `tny_fs_node_label`", array());
		if($row["bitchk"]>=0xFFFFFFFF){
			throw new Exception("Max label length is 32", 0x568);
		}
		for($i=0;$i<32;$i++){
			if(!((1<<$i)&$row["bitchk"])){
				break;
			}
		}
		$npsid = $this->pdo->insert("insert into `tny_fs_node_label` (`lk`,`lv`) values 
				(:lk,:lv)", array(
			"lk" => $i,
			"lv" => $val,
		));
		return 1;
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @param unknown $name
	 * @throws Exception
	 */
	public function update($lk,$lv){
		if(!labelOpRegexp::isValidlabelVal($lv)){
			throw new Exception("label name is too long");
		}
		return $this->pdo->exec("update tny_fs_node_label 
			set `lv` = :lv where `lk` = :lk", array(
			"lv" => $lv,
			"lk" => $lk,
		));		
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @throws Exception
	 */
	public function remove($lk){
		if(!labelOpRegexp::isValidlabelKey($lk)){
			throw new Exception("label key is invalid");
		}
		//二进制移去中间一位
		$this->pdo->exec("update `tny_fs_nodepath_struct` set 
		label = (`label`>>:lk<<(:lk-1))|(`label` & (1<<:lk-1)-1)", array(
			"lk" => $lk+1
		));
		$row = $this->pdo->exec("delete from `tny_fs_node_label` where `lk` = :lk and `sys`='usr'", array(
			"lk" => $lk
		));
		$this->pdo->exec("update `tny_fs_node_label` set `lk` = `lk` - 1 where `lk` > :lk order by lk asc", array(
			"lk" => $lk
		));
		return $row;
	}
}