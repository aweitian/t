<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 */
require_once dirname(__FILE__)."/datakeyOpRegexp.php";
require_once DATASRC_PATH."/pathDbHelper.php";
class datakeyOp{
	/**
	 *
	 * @var IDb
	 */
	public $db;
	/**
	 * @var IPdoBase
	 */
	public $pdo;
	/**
	 * @var DataSrcPath
	 */
	public $nodepath;
	/**
	 * @var pathDbHelper
	 */
	public $pathDbHelper;
	
	
	private $removeMsg = array();
	private $removeCount = 0;
	public function __construct(){
		$this->_initdb();
		$this->pathDbHelper = new pathDbHelper();
		$this->_check_init_envir();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	private function _check_init_envir(){
		$row = $this->pdo->fetch("select sid from tny_fs_node_struct where path = '/'", array());
		if(empty($row)){
			$this->pdo->insert("insert into tny_fs_node_struct (`path`,`name`) values ('/','root')", array());
		}
	}
	/**
	 * @return nsid
	 */
	public function add($nodepath,$key,$dstype,$deco="",$comment="",$nsroottype="folder"){
		if(!datakeyOpRegexp::isValidNodePath($nodepath)){
			throw new Exception("nodepath is invalid",0x1);
		}
		if(!datakeyOpRegexp::isValidKey($key)){
			throw new Exception("key is invalid",0x1);
		}
		if(!datakeyOpRegexp::isValidDsType($dstype)){
			throw new Exception("dstype is invalid",0x1);
		}
		if(!datakeyOpRegexp::isValidDeco($deco)){
			throw new Exception("type is invalid",0x1);
		}
		if(!datakeyOpRegexp::isValidComment($comment)){
			throw new Exception("label is invalid",0x1);
		}
		if(!datakeyOpRegexp::isValidNsRootType($nsroottype)){
			throw new Exception("ns root type is invalid",0x1);
		}
//		$sql = "INSERT INTO `tny_fs_datakey_struct`
//			(`nsid`,`key`,`dstype`,`deco`,`comment`)
//			SELECT `tny_fs_node_struct`.`sid` AS nsid,'".$key."' AS `key`,'22ap' AS `dstype`,'' AS `deco`,'test' AS `comment` FROM `tny_fs_node_struct` 
//			WHERE `tny_fs_node_struct`.path = :nodepath
//			";
		$nsid = $this->pathDbHelper->getNsidByPath($nodepath);
		$sql = "INSERT INTO `tny_fs_datakey_struct`
			(`nsid`,`key`,`dstype`,`deco`,`comment`)
			values (:nsid,:key,:dstype,:deco,:comment)
			";
//		exit($sql);
//		var_dump($nsid);exit;
		$dksid = $this->pdo->insert($sql, array(
			"nsid" => $nsid,
			"key" => $key,
			"dstype" => $dstype,
			"deco" => $deco,
			"comment" => $comment,
		));
		if($nsid>0){
			$sql = "insert into `tny_fs_ns_struct` 
			(`dksid`,`path`,`nt`)
			values(:dksid,:path,:nt)";
			return $this->pdo->insert($sql, array(
				"dksid" =>$dksid,
				"path" => "/",
				"nt" => $nsroottype,
			));			
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2], $info[0]);
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @param unknown $name
	 * @throws Exception
	 */
	public function update($nodepath,$oldkey,$newkey,$deco="",$comment=""){
		if(!datakeyOpRegexp::isValidNodePath($nodepath)){
			throw new Exception("nodepath is invalid",0x1);
		}
		if(!datakeyOpRegexp::isValidKey($oldkey)){
			throw new Exception("oldkey is invalid",0x1);
		}
		if(!datakeyOpRegexp::isValidKey($newkey)){
			throw new Exception("newkey is invalid",0x1);
		}
// 		if(!datakeyOpRegexp::isValidDsType($dstype)){
// 			throw new Exception("dstype is invalid");
// 		}
		if(!datakeyOpRegexp::isValidDeco($deco)){
			throw new Exception("type is invalid",0x1);
		}
		if(!datakeyOpRegexp::isValidComment($comment)){
			throw new Exception("label is invalid",0x1);
		}//`dstype`=:dstype,
		$nsid = $this->pathDbHelper->getNsidByPath($nodepath);
		return $this->pdo->exec("update tny_fs_datakey_struct 
			set `key` = :newkey,
			`deco` = :deco,`comment`=:comment
			where `nsid` = :nsid and `key`=:oldkey", array(
				"nsid" => $nsid,
				"oldkey" => $oldkey,
				"newkey" => $newkey,
// 				"dstype" => $dstype,
				"deco" => $deco,
				"comment" => $comment,
		));		
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @param unknown $name
	 * @throws Exception
	 */
	public function updateDstype($nodepath,$key,$dstype){
		if(!datakeyOpRegexp::isValidNodePath($nodepath)){
			throw new Exception("nodepath is invalid",0x12);
		}
		if(!datakeyOpRegexp::isValidKey($key)){
			throw new Exception("key is invalid",0x14);
		}
		if(!datakeyOpRegexp::isValidDsType($dstype)){
			throw new Exception("dstype is invalid",0x15);
		}
		
		$nsid = $this->pathDbHelper->getNsidByPath($nodepath);
		
		//删除所有DATASRC数据
		$sql = "";$tmp = array();
		$dsrArr = dataSrc::$typeArr;
		$sql .= "DELETE ";
		foreach (array_keys($dsrArr) as $dsr){
			$tmp[] = "`tny_fs_datasrc_".$dsr."`";
		}
		$sql .= join(",",$tmp);
		$sql .= " FROM `tny_fs_datakey_struct` LEFT JOIN `tny_fs_ns_struct` ON `tny_fs_ns_struct`.`dksid` = `tny_fs_datakey_struct`.`sid` ";
		foreach (array_keys($dsrArr) as $dsr){
			$sql .= " LEFT JOIN `tny_fs_datasrc_".$dsr."` ON `tny_fs_datasrc_".$dsr."`.`nssid` = `tny_fs_ns_struct`.`sid`";
		}
		$sql .= " WHERE `tny_fs_datakey_struct``nsid` = :nsid  and `tny_fs_datakey_struct`.`key` = :key";
// 				exit($sql);
		$this->pdo->exec($sql, array(
			"nsid" => $nsid,
			"key" => $key,
		));
		// 		exit($sql);
// 		var_dump($nsid,$key,$dstype);exit();
		return $this->pdo->exec("update `tny_fs_datakey_struct` 
			set `dstype`=:dstype
			where `nsid` = :nsid and `key`=:key", array(
				"nsid" => $nsid,
				"key" => $key,
				"dstype" => $dstype,
		));		
	}
	/**
	 * @return 返回影响的行数
	 * @param string $nodepath
	 * @throws Exception
	 * 删除所有和结点有关信息
	 */
	public function remove($path){
		$p = new DataSrcPath($path);
		if($p->getPathMode() != DataSrcPath::DATA_MODE){
			throw new Exception("invalid path:".$path);
		}
		$this->removeMsg = array();
		$this->removeCount = 0;
		$sql = "";
		//array("22ap","22ld","22tp","23ldp","23tpe")
		$dsrArr = dataSrc::$typeArr;
		$sql .= "DELETE `tny_fs_datakey_struct`,`tny_fs_ns_struct`";
		foreach (array_keys($dsrArr) as $dsr){
			$sql .= ",`tny_fs_datasrc_".$dsr."`";
		}
		$sql .= " FROM `tny_fs_node_struct` LEFT JOIN `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`nsid` = `tny_fs_node_struct`.`sid` LEFT JOIN `tny_fs_ns_struct` ON `tny_fs_ns_struct`.`dksid` = `tny_fs_node_struct`.`sid`";
		foreach (array_keys($dsrArr) as $dsr){
			$sql .= " LEFT JOIN `tny_fs_datasrc_".$dsr."` ON `tny_fs_datasrc_".$dsr."`.`nssid` = `tny_fs_ns_struct`.`sid`";
		}
		$sql .= " WHERE `tny_fs_node_struct`.`path`=:path and `tny_fs_datakey_struct`.`key` = :key";
// 		exit($sql);
		$this->removeCount = $this->pdo->exec($sql, array(
			"path" => $p->getNodePath(),
			"key" => $p->getDatakey()
		));
		return $this->removeCount;
	}
}