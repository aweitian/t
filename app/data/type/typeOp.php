<?php
/**
 * Date: 2014-10-17
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/typeInfo.php";
require_once dirname(__FILE__)."/typeOpRegexp.php";
class typeOp{
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
		if(!typeOpRegexp::isValidTypeVal($val)){
			throw new Exception("type name is too long");
		}
		$row = $this->pdo->fetch("SELECT SUM(1<<tk) as bitchk FROM `tny_fs_node_type`", array());
		if($row["bitchk"]>=0xFFFFFFFF){
			throw new Exception("Max type length is 32", 0x568);
		}
		for($i=0;$i<32;$i++){
			if(!((1<<$i)&$row["bitchk"])){
				break;
			}
		}
		$npsid = $this->pdo->insert("insert into `tny_fs_node_type` (`tk`,`tv`) values 
				(:tk,:tv)", array(
			"tk" => $i,
			"tv" => $val,
		));
		return 1;
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @param unknown $name
	 * @throws Exception
	 */
	public function update($tk,$tv){
		if(!typeOpRegexp::isValidTypeVal($tv)){
			throw new Exception("type name is too long");
		}
		return $this->pdo->exec("update tny_fs_node_type 
			set `tv` = :tv where `tk` = :tk", array(
			"tv" => $tv,
			"tk" => $tk,
		));		
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @throws Exception
	 */
	public function remove($tk){
		if(!typeOpRegexp::isValidTypeKey($tk)){
			throw new Exception("type key is invalid");
		}
		//二进制移去中间一位
		$this->pdo->exec("update `tny_fs_nodepath_struct` set 
		type = (`type`>>:tk<<(:tk-1))|(`type` & (1<<:tk-1)-1)", array(
			"tk" => $tk+1
		));
		$row = $this->pdo->exec("delete from `tny_fs_node_type` where `tk` = :tk and `sys`='usr'", array(
			"tk" => $tk
		));
		$this->pdo->exec("update `tny_fs_node_type` set `tk` = `tk` - 1 where `tk` > :tk order by tk asc", array(
			"tk" => $tk
		));
		return $row;
	}
}