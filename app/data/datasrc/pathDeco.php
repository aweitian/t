<?php
/**
 * @author:awei.tian
 * @date: 2014-10-3
 * @functions:
 */

require_once dirname(__FILE__)."/DataSrcPath.php";
class pathDeco{
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
	public $path;
	
	private $_nodepath_arr;
	private $_nspath_arr;
	public function __construct($path){
		$this->path = new DataSrcPath($path);
		$this->_initdb();
		$this->_nodepath_arr = $this->_decoNodePath();
		if($this->path->getPathMode() == DataSrcPath::NSINFO_MODE){
			$this->_nspath_arr = $this->_decoNsPath();
		}
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	
	public function getDecoPath(){
		switch($this->path->getPathMode()){
			case DataSrcPath::NODEINFO_MODE:
				if(empty($this->_nodepath_arr))return "/";
				return "/".join("/",$this->_nodepath_arr);
			case DataSrcPath::DATA_MODE:
			case DataSrcPath::DATAKEYINFO_MODE:
				if(empty($this->_nodepath_arr))return "/".$this->path->getDatakey();
				return "/".join("/",$this->_nodepath_arr)."#".$this->path->getDatakey();
			case DataSrcPath::NSINFO_MODE:
			case DataSrcPath::BASEDATA_MODE:
				if(empty($this->_nodepath_arr))$np = "/";
				else $np = "/".join("/",$this->_nodepath_arr);
				$np = $np."#".$this->path->getDatakey();
				if(empty($this->_nspath_arr))$dsp = "/";
				else $dsp = "/".join("/",$this->_nspath_arr);
				return $np.$dsp;
		}
	}
	private function _decoNodePath(){
		$nodepath = $this->path->getNodePath();
		if($this->path->isRoot())return array();
		$p = explode("/",trim($nodepath,"/"));
		$q = array();
		$pp = "";
		
		foreach ($p as $ppp){
			$row = $this->pdo->fetch("select `name` from tny_fs_node_struct where `path` = :path", array(
				"path" => $pp."/".$ppp
			));
			
			if(empty($row)){
				throw new Exception("invalid path:".$pp."/".$ppp);
			}
			$pp = $pp."/".$ppp;
			$q[] = $row["name"];
		}
		return array_combine($p, $q);
	}
	private function _decoNsPath(){
		$nspath = $this->path->getNsPath();
		if($this->path->isNsRoot())return array();
		$p = explode("/",trim($nspath,"/"));
		$q = array();
		$pp = "";
		foreach ($p as $ppp){
			$row = $this->pdo->fetch("select `name` from tny_fs_ns_struct where `path` = :path", array(
				"path" => $pp."/".$ppp
			));
			
			if(empty($row)){
				throw new Exception("invalid path:".$pp."/".$ppp);
			}
			$pp = $pp."/".$ppp;
			$q[] = $row["name"];
		}
		return array_combine($p, $q);
	}
}