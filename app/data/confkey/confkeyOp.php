<?php
/**
 * Date: 2014-10-17
 * Author: Awei.tian
 * function: 
 */
require_once DATASRC_PATH."/pathDbHelper.php";
require_once ENTRY_PATH."/app/data/confkey/confkeyOpRegexp.php";
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
class confkeyOp{
	/**
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
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	/**
	 * @return nsid
	 */
	public function add($nodepath,$key,$type,$comment=""){
		if(!confkeyOpRegexp::isValidKey($key)){
			throw new Exception("key is invalid");
		}
		if(!confkeyOpRegexp::isValidType($type)){
			throw new Exception("type is invalid");
		}
		if(!confkeyOpRegexp::isValidComment($comment)){
			throw new Exception("comment is invalid");
		}
		$nsid = $this->pathDbHelper->getNsidByPath($nodepath);
		$sql = "INSERT INTO `tny_fs_confkey_struct`
			(`nsid`,`key`,`typeid`,`comment`)
			values (:nsid,:key,:typeid,:comment)
			";
//		exit($sql);
//		var_dump($nsid);exit;
		$dksid = $this->pdo->insert($sql, array(
			"nsid" => $nsid,
			"key" => $key,
			"typeid" => $type,
			"comment" => $comment,
		));
		if($dksid>0){
			return $dksid;		
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
	public function update($nodepath,$oldkey,$newkey,$comment=""){
		if(!confkeyOpRegexp::isValidKey($oldkey)){
			throw new Exception("oldkey is invalid");
		}
		if(!confkeyOpRegexp::isValidKey($newkey)){
			throw new Exception("newkey is invalid");
		}
		if(!confkeyOpRegexp::isValidComment($comment)){
			throw new Exception("comment is invalid");
		}//`dstype`=:dstype,
		$nsid = $this->pathDbHelper->getNsidByPath($nodepath);
		return $this->pdo->exec("update `tny_fs_confkey_struct` 
			set `key` = :newkey,
			`comment`=:comment
			where `nsid` = :nsid and `key`=:oldkey", array(
				"nsid" => $nsid,
				"oldkey" => $oldkey,
				"newkey" => $newkey,
				"comment" => $comment,
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
			throw new Exception("invalid path:".$path,0x1);
		}
// 		var_dump($p->getPathMode());exit;
		$this->removeMsg = array();
		$this->removeCount = 0;
		$sql = "";
		$confArr = conf::$typeArr;
		$sql .= "DELETE `tny_fs_confkey_struct`";
		foreach ($confArr as $conf=>$name){
			$sql .= ",`tny_fs_conf_".$conf."`";
		}
		$sql .= " FROM `tny_fs_node_struct` 
		LEFT JOIN `tny_fs_confkey_struct` ON `tny_fs_confkey_struct`.`nsid` = `tny_fs_node_struct`.`sid` ";
		foreach ($confArr as $conf=>$name){
			$sql .= " LEFT JOIN `tny_fs_conf_".$conf."` ON `tny_fs_conf_".$conf."`.`csid` = `tny_fs_confkey_struct`.`sid`";
		}
		$sql .= " WHERE `tny_fs_node_struct`.`path`=:path and `tny_fs_confkey_struct`.`key` = :key";
// 		exit($sql);
		$row = $this->pdo->exec($sql, array(
			"path" => $p->getNodePath(),
			"key" => $p->getDatakey()
		));
		if($row>0){
			return $row;		
		}
		$info = $this->pdo->getErrorInfo();
		throw new Exception($info[2], $info[0]);
	}
}