<?php
/**
 * Date: 2014-12-1
 * Author: Awei.tian
 * function: 
 */
require_once ENTRY_PATH."/app/data/datasrc/pathDbHelper.php";
require_once ENTRY_PATH."/app/data/datasrc/DataSrcPath.php";
require_once ENTRY_PATH."/app/data/conf/base/conf.php";
class confOp{
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
	public $dataSrcPath;
	/**
	 * @var pathDbHelper
	 */
	public $pathDbHelper;
	private $helper;
	public function __construct(){
		$this->_initdb();
	}
	private function _initdb(){
		$this->db = tian::$context->getDb();
		$this->pdo = $this->db->getPdoBase();
	}
	/**
	 *
	 * @return bool
	 * @param string path
	 * @param data
	 */
	public function add($path,$data){
		$this->dataSrcPath = new DataSrcPath($path);
		$this->pathDbHelper = new pathDbHelper();
		if($this->dataSrcPath->getPathMode()!=DataSrcPath::DATA_MODE){
			throw new Exception("invalid path mode",0x52);
		}
		$confkey_metadata = $this->pathDbHelper->getConfInfoByPath($path);
		if(!array_key_exists($confkey_metadata["typeid"],conf::$typeArr)){
			throw new Exception("invalid path", "0x9");
		}
		require_once ENTRY_PATH."/app/data/conf/op/".$confkey_metadata["typeid"]."Op.php";
		$cls = $confkey_metadata["typeid"]."Op";
//		$cls = str_replace("_", "", $cls);
		$this->helper = new $cls();
		return $this->helper->add($path, json_decode($data,true));
	}
	public function remove($path){
		$this->dataSrcPath = new DataSrcPath($path);
		$this->pathDbHelper = new pathDbHelper();
		if($this->dataSrcPath->getPathMode()!=DataSrcPath::DATA_MODE){
			throw new Exception("invalid path mode",0x52);
		}
		$confkey_metadata = $this->pathDbHelper->getConfInfoByPath($path);
		if(!array_key_exists($confkey_metadata["typeid"],conf::$typeArr)){
			throw new Exception("invalid path", "0x9");
		}
		require_once ENTRY_PATH."/app/data/conf/op/".$confkey_metadata["typeid"]."Op.php";
		$cls = $confkey_metadata["typeid"]."Op";
//		$cls = str_replace("_", "", $cls);
		$this->helper = new $cls();
		return $this->helper->remove($path);
	}
	public function update($path,$data){
		$this->dataSrcPath = new DataSrcPath($path);
		$this->pathDbHelper = new pathDbHelper();
		if($this->dataSrcPath->getPathMode()!=DataSrcPath::DATA_MODE){
			throw new Exception("invalid path mode",0x52);
		}
		$confkey_metadata = $this->pathDbHelper->getConfInfoByPath($path);
		if(!array_key_exists($confkey_metadata["typeid"],conf::$typeArr)){
			throw new Exception("invalid path", "0x9");
		}
		require_once ENTRY_PATH."/app/data/conf/op/".$confkey_metadata["typeid"]."Op.php";
		$cls = $confkey_metadata["typeid"]."Op";
//		$cls = str_replace("_", "", $cls);
		$this->helper = new $cls();
		return $this->helper->update($path,json_decode($data,true));
	}
}