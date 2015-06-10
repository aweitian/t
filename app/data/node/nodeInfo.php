<?php
/**
 * Date: 2014-9-26
 * Author: Awei.tian
 * function: 
 * 		获取结点下子结点名
 */
require_once dirname(__FILE__)."/nodeOpRegexp.php";
require_once DATASRC_PATH."/dataSrc.php";
class nodeInfo{
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
	public function __construct($nodepath){
		$this->_initdb();
		$p = new DataSrcPath($nodepath);
		if($p->getPathMode() != DataSrcPath::NODEINFO_MODE){
			throw new Exception("invalid node path:".$nodepath);
		}
		$this->nodepath = $p;
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	public function getNodeInfo(){
		$path = $this->nodepath->getNodePath();
		$row = $this->pdo->fetch("SELECT SUBSTRING_INDEX(path,'/',-1) as `key`,
			`nt`,`order`,`type`,`label` FROM tny_fs_node_struct WHERE
			`path` = :path			
		", array(
				"path" => $path
		));
		if(empty($row))return $row;
		$row["type_deco"] = $this->_decoType($row["type"]);
		$row["label_deco"] = $this->_decoLabels($row["label"]);//need raw label	
		return $row;
	}
	/**
	 * @return array(childkey => childtext)
	 */
	public function getChildInfo(){
		if($this->nodepath->isRoot()){
			$path = $this->nodepath->getNodePath();
			$row = $this->pdo->fetchAll("SELECT SUBSTRING_INDEX(path,'/',-1) as `key` FROM tny_fs_node_struct WHERE
			LEFT(path,1) = '/'
			AND CHAR_LENGTH(path)-CHAR_LENGTH(REPLACE(path,'/','')) = 1
			AND CHAR_LENGTH(path)>1	
			order by `order` asc	
					", array(
								"path" => $path
						));
		}else{
			$path = $this->nodepath->getNodePath()."/";
			$row = $this->pdo->fetchAll("SELECT SUBSTRING_INDEX(path,'/',-1) as `key` FROM tny_fs_node_struct WHERE
			LEFT(path,CHAR_LENGTH(:path)) = :path
			AND CHAR_LENGTH(path)-CHAR_LENGTH(REPLACE(path,'/','')) = CHAR_LENGTH(:path) - CHAR_LENGTH(REPLACE(:path,'/',''))
			order by `order` asc			
					", array(
								"path" => $path
						));
			
		}
		$key = array();
		foreach ($row as $item){
			$key[] = $item["key"];
		}
		return $key;
	}
	/**
	 * @return array(childkey => array("name"=>childtext,order=>order))
	 */
	public function getChildDetail($tldeco="raw"){
		if($this->nodepath->isRoot()){
			$path = $this->nodepath->getNodePath();
			$row = $this->pdo->fetchAll("SELECT SUBSTRING_INDEX(path,'/',-1) as `key`,
			`nt`,`order`,`type`,`label` FROM tny_fs_node_struct WHERE
			LEFT(path,1) = '/'
			AND CHAR_LENGTH(path)-CHAR_LENGTH(REPLACE(path,'/','')) = 1
			AND CHAR_LENGTH(path)>1	
			order by `order` asc	
					", array(
								"path" => $path
						));
		}else{
			$path = $this->nodepath->getNodePath()."/";
			$row = $this->pdo->fetchAll("SELECT SUBSTRING_INDEX(path,'/',-1) as `key`,
			`nt`,`order`,`type`,`label` FROM tny_fs_node_struct WHERE
			LEFT(path,CHAR_LENGTH(:path)) = :path
			AND CHAR_LENGTH(path)-CHAR_LENGTH(REPLACE(path,'/','')) = CHAR_LENGTH(:path) - CHAR_LENGTH(REPLACE(:path,'/',''))
			order by `order` asc			
					", array(
								"path" => $path
						));
			
		}
		$key = array();
		$val = array();
		foreach ($row as $item){
			$key[] = $item["key"];
			$tmp = array(
				"nt"=>$item["nt"],
				"order"=>$item["order"],
				"type" => nodeOpRegexp::typetoindex($item["type"]),
				"label" => nodeOpRegexp::labeltoindexArr($item["label"]),
			);
			if($tldeco == "decotl"){
				$tmp["type_deco"] = $this->_decoType($tmp["type"]);
				$tmp["label_deco"] = $this->_decoLabels($item["label"]);//need raw label
			}
			$val[] = $tmp;
		}
		if(count($key))
		return array_combine($key, $val);
		return array();
	}
	private function _decoType($type){
		if($type<0)return "";
		$row = $this->pdo->fetch("select `tv` from `tny_fs_node_type` where `tk`=:tk", array(
			"tk" => $type
		));
		if(empty($row)){
			return "";
		}
		return $row["tv"];
	}
	private function _decoLabels($label){
		$row = $this->pdo->fetch("SELECT GROUP_CONCAT(tny_fs_node_label.lv) as label FROM  tny_fs_node_label 
				WHERE :label & (1<<tny_fs_node_label.lk)
		", array(
			"label" => $label
		));
		if(empty($row)){
			throw new Exception("no matched label found", 0x500100);
		}
		return $row["label"];
	}
	public function getNavLink($path,$url){
		$path = new DataSrcPath($path);
		$cur = "";
		$html = "<a href='".$url."&nodepath=".urlencode("/")."'>/</a>";
		if($path->isRoot()){
			return $html;
		}
		$data = explode("/", trim($path->getNodePath(),"/"));
		foreach ($data as $v){
			$cur = $cur."/".$v;
			$html .= "<a href='".$url."&nodepath=".urlencode($cur)."'>". $this->getNameByPath($cur) . "</a> / ";
		}
		return $html;
	}
	/**
	 * @return all descendants order by deep asc
	 * not include self
	 */
	public function getDescendantSids($order="desc"){
		if($order !== "asc"){
			$order = "desc";
		}
		if($this->nodepath->isRoot()){
			$row = $this->pdo->fetchAll("SELECT sid FROM tny_fs_node_struct where path != '/' ORDER BY 
					CHAR_LENGTH(path) - CHAR_LENGTH(REPLACE(path,'/','')) ".$order.",
					`order` ".$order." ", array());
		}else{
			$path = $this->nodepath->getNodePath()."/";
			$row = $this->pdo->fetchAll("SELECT sid FROM `tny_fs_node_struct` WHERE
				(LEFT(`tny_fs_node_struct`.`path`,CHAR_LENGTH(:path)+1) = CONCAT(:path ,'/'))
				OR 
				`tny_fs_node_struct`.`path`=:path
				ORDER BY CHAR_LENGTH(`tny_fs_node_struct`.`path`) - CHAR_LENGTH(REPLACE(`tny_fs_node_struct`.`path`,'/','')) ".$order.",
				`tny_fs_node_struct`.`order` ".$order."", array(
								"path" => $path
						));
		}
		
		$key = array();
		foreach ($row as $item){
			$key[] = $item["sid"];
		}
		return $key;
	}
	/**
	 * @return all descendants order by deep asc
	 * not include self
	 */
	public function getDescendantLeaf($order="desc"){
		if($order !== "asc"){
			$order = "desc";
		}
		if($this->nodepath->isRoot()){
			$row = $this->pdo->fetchAll("SELECT SUBSTRING_INDEX(path,'/',-1) as `key`, `path` FROM tny_fs_node_struct where 
					path != '/' 
					and `nt` = 'file'
					", array());
		}else{
			$path = $this->nodepath->getNodePath()."/";
			$row = $this->pdo->fetchAll("SELECT SUBSTRING_INDEX(path,'/',-1) as `key`,`path` FROM `tny_fs_node_struct` WHERE
				((LEFT(`tny_fs_node_struct`.`path`,CHAR_LENGTH(:path)+1) = CONCAT(:path ,'/'))
				OR 
				`tny_fs_node_struct`.`path`=:path
				) and `nt` = 'file' 
				", array(
								"path" => $path
						));
		}
		return $row;
	}
	/**
	 * 
	 * @return unknown
	 */
	public function getAllLeaves(){
		$row = $this->pdo->fetchAll("SELECT `path`,`order` FROM tny_fs_node_struct where `nt` = 'folder'", array());
		$hash = array();
		foreach ($row as $item){
			$hash[$item["path"]] = $item["order"];
		}
		$row = $this->pdo->fetchAll("SELECT `path`,`order` FROM tny_fs_node_struct where `nt` = 'file'", array());
		//把它们的ORDER变成
// 		20,50,100
// 		100,20
// 		50,1,1,1
// 		20,100
// 		100   这样的格式
		//var_dump($hash);
		$orderArr = array();
		foreach ($row as $item){
			$orderArr[$item["path"]] = $this->calcOrder($hash, $item["path"], $item["order"]);
		}
		//var_dump($orderArr);
// 		array(2) {
// 			"/a/b/c" => array(163,2,100),
// 			"/a/d/e" => array(5,3,100).
// 			"/a/d" => array(3,2).
// 		}
		
		//var_dump($this->compare(array(1,2,3), array(1,2)));
// 		$orderArr = array(
// 			"/a/b/c" => array(163,2,100),
// 			"/a/d/e" => array(5,3,100),
// 			"/a/d" => array(3,2)			
// 		);
		$min = "";
		$ret = array();
		while(!empty($orderArr)){
			$min = key($orderArr);
			while(next($orderArr) !== false){
				$cmp = key($orderArr);
				$num = $this->compare($orderArr[$min], $orderArr[$cmp]);
				if($num == 2){
					$min = $cmp;
				}
			}
			$ret[] = $min;
			//echo $min;echo "\r\n";
			unset($orderArr[$min]);
			reset($orderArr);
		}
// 		var_dump($ret);
// 		exit();
		return $ret;
	}
	/**
	 * 
	 * @param array $parentsOrder
	 * @param string $path
	 * @return array likes array(20,50,100)
	 * 如果path一层一层向上找父结点,没有在$parentsOrder找到相应路径,说明这是一条无效的路径
	 */
	private function calcOrder($parentsOrder,$path,$pathorder){
		$ret = array();
		$bak = $path;
		while(!DataSrcPath::isRootPath(DataSrcPath::getParentPath($path))){
			$path =  DataSrcPath::getParentPath($path);
// 			var_dump($path);
			if(!array_key_exists($path, $parentsOrder)){
				if(APP_DEBUG){
					throw new Exception("found invalid path:".$bak,0x23);
				}
			}else{
				$ret[] = $parentsOrder[$path];
			}
		}
		array_unshift($ret, $pathorder);
		return array_reverse($ret);
	}
	/**
	 * 大小比较约定 1,2,3和1,2 1,2小
	 * @param array $arr1
	 * @param array $arr2
	 * 返回1表示前面小,2后面小,相等返回1
	 */
	private function compare($arr1,$arr2){
		$len1 = count($arr1);
		$len2 = count($arr2);
		$loop = $len1 < $len2 ? $len1 : $len2;
		for($i=0;$i<$loop;$i++){
			if($arr1[$i] < $arr2[$i]){
				return 1;
			}else if($arr2[$i] < $arr1[$i]){
				return 2;
			}
		}
		return $len1 <= $loop ? 1 : 2;
	}
}