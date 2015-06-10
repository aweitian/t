<?php
/**
 * Date: 2014-9-12
 * Author: Awei.tian
 * function: * 表示结果不唯一
	NODEINFO		/path							* array(nodekey=>nodevalue)
	DATAKEYINFO		/np1/np2?						* array(nsnodekey=>nsnodevalue)
	NSINFO			/np1/np2?nskey/ns1				* array(nspathkey=>nspathvalue)
	DATA			/np1/np2?nskey					DataSrcNsdata
	
	完整的命令格式:
		上面五种格式@参数
 */
 class DataSrcPath{
 	//regexps tested at 2014-9-19 11:26:21
 	const NODEINFO_PATTERN = "/^(\/(?:(?:[^\/:*?\"<>|\r\n]+\/)*(?:[^\/:*?\"<>|\r\n]+))?)$/";
 	const DATAKEYINFO_PATTERN = "/^(\/(?:(?:[^\/:*?\"<>|\r\n]+\/)*(?:[^\/:*?\"<>|\r\n]+))?)\?$/";
 	const NSINFO_PATTERN = "/^(\/(?:(?:[^\/:*?\"<>|\r\n]+\/)*(?:[^\/:*?\"<>|\r\n]+))?)\?([^\/:*?\"<>|\r\n]+)(\/(?:(?:[^\/:*?\"<>|\r\n]+\/)*(?:[^\/:*?\"<>|\r\n]+))?)$/";
 	const DATA_PATTERN = "/^(\/(?:(?:[^\/:*?\"<>|\r\n]+\/)*(?:[^\/:*?\"<>|\r\n]+))?)\?([^\/:*?\"<>|\r\n]+)$/";
 	
 	const NODEINFO_MODE = 0x0;
 	const DATAKEYINFO_MODE = 0x1;
 	const NSINFO_MODE = 0x2;
 	const BASEDATA_MODE = 0x3;
 	const DATA_MODE = 0x4;
 	
 	protected $nodeinfo_path;
 	protected $datakey;
 	protected $nsinfo_path;
 	
 	protected $mode;
 	public $raw_path;
 	protected $path;
 	protected $args;
 	public function __construct($path){
 		$this->raw_path = $path;
 		$this->path = $path;
 		$this->_checkpath($this->path);
 	}
 	public function setNodepath($path){
 		$this->nodeinfo_path = $path;
 		$this->_checkpath($this->toString());
 	}
 	public function setDatakey($key){
 		$this->datakey = $key;
 		$this->_checkpath($this->toString());
 	}
 	public function setNsPath($path){
 		$this->nsinfo_path = $path;
 		$this->_checkpath($this->toString());
 	}
 	public function getPathMode(){
 		return $this->mode;
 	}
 	public function getNodePath(){
 		return $this->nodeinfo_path;
 	}
 	public function getNsPath(){
 		return $this->nsinfo_path;
 	}
 	public function getDatakey(){
 		return $this->datakey;
 	}
 	public function getChildNodePath($key){
 		if($this->isRoot()){
 			return "/".$key;
 		}
 		return $this->nodeinfo_path."/".$key;
 	}
 	public function getChildNsPath($key){
 		if($this->isNsRoot()){
 			return "/".$key;
 		}
 		return $this->nsinfo_path."/".$key;
 	}
 	public function getDatakeyPath(){
 		switch ($this->mode){
 			case self::NSINFO_MODE:
 			case self::DATA_MODE:
 				return $this->nodeinfo_path ."?".
 						$this->datakey;
 		}
 		throw new Exception("path mode illegal",0x7788);
 	}
 	public function toString(){
 		switch ($this->mode){
 			case self::NODEINFO_MODE:
 				return $this->nodeinfo_path;
 			case self::DATAKEYINFO_MODE:
 				return $this->nodeinfo_path."?";
 			case self::NSINFO_MODE:
 				return $this->nodeinfo_path ."?".
 				$this->datakey .
 				$this->nsinfo_path;
 			case self::BASEDATA_MODE:
 				return $this->nodeinfo_path ."?".
 				$this->datakey .
 				$this->nsinfo_path.".";
 			case self::DATA_MODE:
 				return $this->nodeinfo_path ."?".
 				$this->datakey;
 		}
 	}
 	public static function isValidNodeInfoPath($path){
 		return preg_match(self::NODEINFO_PATTERN, $path);
 	}
 	public static function isValidDataPath($path){
 		return preg_match(self::DATA_PATTERN, $path);
 	}
 	public static function isValidDataSrcTypeId($id){
 		return is_string($id)
 		&& preg_match("/^[\da-z]+$/", $id)
 		&& file_exists(dirname(__FILE__)."/DataSrc_".$id.".php");
 	}
 	public static function isValiddataSrcId($id){
 		return is_string($id)
 		&& preg_match("/^\d[\da-z]+$/", $id)
 		&& file_exists(dirname(__FILE__)."/DataSrc_".$id.".php");
 	}
 	public static function getParentPath($path){
 		if(!self::isValidPath($path))return $path;
 		$p=dirname($path);
 		if($p===DIRECTORY_SEPARATOR){
 			return "/";
 		}
 		return $p;
 	}
 	public static function isValidPath($path){
 		return preg_match(self::NODEINFO_PATTERN, $path);
 	}
 	public static function isRootPath($path){
 		return $path === "/";
 	}
 	public function isRoot(){
 		return $this->nodeinfo_path === "/";
 	}
 	public function isNsRoot(){
 		return $this->nsinfo_path === "/";
 	}
 	/**
 	 * @return bool
 	 * @param unknown $path
 	 * @param string $throw
 	 * @throws Exception
 	 */
 	protected function _checkpath($path,$throw=TRUE){
 		if(preg_match(self::NODEINFO_PATTERN, $path,$matches)){
 			$this->nodeinfo_path = $matches[1];
 			$this->mode = self::NODEINFO_MODE;
 			return true;
 		}elseif (preg_match(self::DATAKEYINFO_PATTERN, $path,$matches)){
 			$this->nodeinfo_path = $matches[1];
 			$this->mode = self::DATAKEYINFO_MODE;
 			return true;
 		}elseif (preg_match(self::NSINFO_PATTERN, $path,$matches)){
 			$this->nodeinfo_path = $matches[1];
 			$this->datakey = $matches[2];
 			$this->nsinfo_path = $matches[3];
 			$this->mode = self::NSINFO_MODE;
 			return true;
 		}else if (preg_match(self::DATA_PATTERN, $path,$matches)){
 			$this->nodeinfo_path = $matches[1];
 			$this->datakey = $matches[2];
 			$this->mode = self::DATA_MODE;
 			return true;
 		}else{
 			if($throw)throw new Exception("invalid datasrc path",0x3);
 		}
 		return false;
 	}
 }