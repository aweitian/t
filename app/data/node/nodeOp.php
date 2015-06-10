<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 */
require_once DATA_PATH."/node/nodeInfo.php";
require_once DATA_PATH."/node/nodeOpRegexp.php";
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
require_once DATASRC_PATH."/pathDbHelper.php";
require_once DATASRC_PATH."/dataSrc.php";
class nodeOp{
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
	public function addChild($nodepath,$key,$nt='folder',$order=0,$type=0,$labels=array()){
		//check $nodepath exists
		$p = new pathDbHelper();//($nodepath);
		$row = $p->getNodeInfoByPath($nodepath);
		if(!nodeOpRegexp::isValidKey($key)){
			throw new Exception("key is invalid");
		}
		if(!nodeOpRegexp::isValidNT($nt)){
			throw new Exception("node type is invalid");
		}
		if(!nodeOpRegexp::isValidOrder($order)){
			throw new Exception("order is invalid");
		}
		if(!nodeOpRegexp::isValidType($type)){
			throw new Exception("type is invalid");
		}
		if(!nodeOpRegexp::isValidLabel($labels)){
			throw new Exception("label is invalid");
		}
		$p = new DataSrcPath($nodepath);
		if($p->isRoot()){
			$path = "/".$key;
		}else{
			$path = $p->getNodePath()."/".$key;
		}
		if($row["nt"] != "folder"){
			throw new Exception("add file to file is not allowed.");
			return 0;
		}
//		var_dump($type<0 ? 0 : 1<<$type);exit;
		$nsid = $this->pdo->insert("insert into tny_fs_node_struct 
			(`path`,`nt`,`order`,`type`,`label`) values 
				(:path,:nt,:order,:type,:label)", array(
			"path" => $path,
			"nt" => $nt,
			"order" => $order,
			"type" => $type<0 ? 0 : 1<<$type,
			"label" => nodeOpRegexp::calc($labels),
		));
		return $nsid;
	}
	/**
	 * @return 返回影响的行数
	 * @param unknown $nodepath
	 * @param unknown $name
	 * @throws Exception
	 */
	public function updateChild($nodepath,$key,$order=0,$type=0,$labels=array()){
		if($nodepath == "/"){
			throw new Exception("update root path is not allowed", 0x7145);
		}
		if(!nodeOpRegexp::isValidOrder($order)){
			throw new Exception("order is invalid");
		}
		if(!nodeOpRegexp::isValidKey($key)){
			throw new Exception("key is invalid");
		}
		if(!nodeOpRegexp::isValidType($type)){
			throw new Exception("type is invalid");
		}
		if(!nodeOpRegexp::isValidLabel($labels)){
			throw new Exception("label is invalid");
		}
		$p = new DataSrcPath($nodepath);
		if($p->getPathMode() != DataSrcPath::NODEINFO_MODE){
			throw new Exception("invalid node path:".$nodepath);
		}
		$newpath = util::getNewPath($nodepath, $key);
		if(rtrim($nodepath,"/") == $newpath){
			return $this->pdo->exec("update tny_fs_node_struct 
				set `order`=:order,
				`type` = :type,`label`=:label
				where `path` = :path", array(
					"path" => $nodepath,
					"order" => $order,
					"type" => $type<0 ? 0 : 1<<$type,
					"label" => nodeOpRegexp::calc($labels),
			));
		}else{
			$nodepath = rtrim($nodepath,"/");
			$subpath = $nodepath."/";
			
			$row = $this->pdo->exec("UPDATE `tny_fs_node_struct` 
			SET `path` = CONCAT(:newpath,substr(`path`,char_length(:path)+2)) 
			 	where 
				LEFT(`path`,CHAR_LENGTH(:subpath)) = :subpath
				", array(
					"path" => $nodepath,
					"subpath" => $subpath,
					"newpath" => $newpath."/",
			));
//			string 'nodepath:/world of warcraft/Achievement List' (length=44)
//			string 'subpath:/world of warcraft/Achievement List/' (length=44)
//			string 'newpath:/world of warcraft/WOW Achievement List' (length=47)
//			var_dump("nodepath:".$nodepath,"subpath:".$subpath,"newpath:".$newpath);
//			var_dump("UPDATE `tny_fs_node_struct` 
//			SET `path` = CONCAT(:newpath,substr(`path`,char_length(:path)+2)) 
//			 	where 
//				LEFT(`path`,CHAR_LENGTH(:subpath)) = :subpath
//				");exit;
			if($row <= 0){
				$row = $this->pdo->fetch("select nt from `tny_fs_node_struct` where `path`=:path",array(
					"path"=>$nodepath
				));
				if(!$row || $row["nt"] == "folder"){
					$info = $this->pdo->getErrorInfo();
					throw new Exception($info[2], $info[0]);					
				}

			}
//			var_dump("nodepath:".$nodepath,"subpath:".$subpath,"newpath:".$newpath);exit;			
			return $this->pdo->exec("update tny_fs_node_struct 
				set `order`=:order,`path`=:newpath,
				`type` = :type,`label`=:label
				where `path` = :path", array(
					"path" => $nodepath,
					"newpath" => $newpath,
					"order" => $order,
					"type" => $type<0 ? 0 : 1<<$type,
					"label" => nodeOpRegexp::calc($labels),
			));
		}
				
	}
	/**
	 * @return 返回影响的行数
	 * @param string $nodepath
	 * @throws Exception
	 * 删除所有和结点有关信息
	 */
	public function remove($nodepath){
		$p = new DataSrcPath($nodepath);
		if($p->getPathMode() != DataSrcPath::NODEINFO_MODE){
			throw new Exception("invalid node path:".$nodepath);
		}
		$this->removeMsg = array();
		$this->removeCount = 0;
		$nodeInfo = new nodeInfo($nodepath);
		$sql = "";
		//array("22ap","22ld","22tp","23ldp","23tpe")
		$dsrArr = dataSrc::$typeArr;
		//array ("table_22tp","table_23tpe","table_22ap","table_23ldp","table_22ld","spancalc_23ldp","spancalc_22ld","calc_22ap");
		$cnfArr = conf::$typeArr;
		$sql .= "DELETE `tny_fs_node_struct`,`tny_fs_datakey_struct`,`tny_fs_ns_struct`,
				`tny_fs_confkey_struct`,`tny_fs_widget_struct`";
		foreach (array_keys($dsrArr) as $dsr){
			$sql .= ",`tny_fs_datasrc_".$dsr."`";
		}
		foreach ($cnfArr as $cnf=>$cnfname){
			$sql .= ",`tny_fs_conf_".$cnf."`";
		}
		$sql .= " FROM `tny_fs_node_struct` 
			LEFT JOIN `tny_fs_datakey_struct` ON `tny_fs_datakey_struct`.`nsid` = `tny_fs_node_struct`.`sid` 
			LEFT JOIN `tny_fs_ns_struct` ON `tny_fs_ns_struct`.`dksid` = `tny_fs_node_struct`.`sid`";
		foreach (array_keys($dsrArr) as $dsr){
			$sql .= " LEFT JOIN `tny_fs_datasrc_".$dsr."` ON `tny_fs_datasrc_".$dsr."`.`nssid` = `tny_fs_ns_struct`.`sid`";
		}
		$sql .= " LEFT JOIN `tny_fs_widget_struct` ON `tny_fs_widget_struct`.`nsid` = `tny_fs_node_struct`.`sid`";
		$sql .= " LEFT JOIN `tny_fs_confkey_struct` ON`tny_fs_confkey_struct`.`nsid` = `tny_fs_node_struct`.`sid`";
		foreach ($cnfArr as $cnf=>$cnfname){
			$sql .= " LEFT JOIN `tny_fs_conf_".$cnf."` ON `tny_fs_conf_".$cnf."`.`csid` = `tny_fs_confkey_struct`.`sid`";
		}
		$sql .= " WHERE (LEFT(`tny_fs_node_struct`.`path`,CHAR_LENGTH(:path)+1) = CONCAT(:path ,'/')) 
		OR `tny_fs_node_struct`.`path`=:path";
// 		exit($sql);
		$this->removeCount = $this->pdo->exec($sql, array(
			"path" => $nodepath
		));
		return $this->removeCount;
	}
	public function getRemoveInfos(){
		return $this->removeMsg;
	}
	public function getRemoveCount(){
		return $this->removeCount
		;
	}
}